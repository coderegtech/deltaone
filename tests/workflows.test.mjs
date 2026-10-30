// End-to-end business workflows through the real HTTP endpoints.
import { test } from 'node:test';
import assert from 'node:assert/strict';
import { as, sql, one, redirectTarget } from './helpers.mjs';

const json = (res) => JSON.parse(res.text_);

for (const [entity, path, table, field] of [
  ['brand', 'brands', 'brands', 'brand'],
  ['category', 'category', 'categories', 'category'],
  ['store', 'stores', 'stores', 'store'],
]) {
  test(`${entity}: create, update, remove as manager; viewer is blocked`, async (t) => {
    const name = `[MOCK] E2E ${entity}`;
    t.after(() => sql(`DELETE FROM ${table} WHERE name LIKE '[MOCK] E2E%'`));
    const manager = await as('manager');

    const missing = await manager.req(`/${path}/create`, { form: { [`${field}_name`]: '', active: '1' } });
    assert.equal(json(missing).success, false, 'empty name rejected');

    assert.equal(json(await manager.req(`/${path}/create`, { form: { [`${field}_name`]: name, active: '1' } })).success, true);
    const id = one(`SELECT id FROM ${table} WHERE name='${name}'`);
    assert.ok(id);

    const upd = await manager.req(`/${path}/update/${id}`, { form: { [`edit_${field}_name`]: `${name} v2`, edit_active: '2' } });
    assert.equal(json(upd).success, true);
    assert.deepEqual(sql(`SELECT name, active FROM ${table} WHERE id=${id}`)[0], [`${name} v2`, '2']);

    const viewer = await as('viewer');
    await viewer.req(`/${path}/create`, { form: { [`${field}_name`]: `${name} viewer`, active: '1' } });
    assert.equal(one(`SELECT COUNT(*) FROM ${table} WHERE name='${name} viewer'`), '0');

    assert.equal(json(await manager.req(`/${path}/remove`, { form: { [`${field}_id`]: id } })).success, true);
    assert.equal(one(`SELECT COUNT(*) FROM ${table} WHERE id=${id}`), '0');
  });
}

test('user lifecycle: create, edit, delete cleans up group membership', async (t) => {
  t.after(() => sql("DELETE ug FROM user_group ug JOIN users u ON u.id=ug.user_id WHERE u.email='e2e@mock.test'; DELETE FROM users WHERE email='e2e@mock.test'"));
  const admin = await as('superadmin');
  const group = one("SELECT id FROM `groups` WHERE group_name='[MOCK] Viewer'");
  const base = { groups: group, username: 'me2euser', email: 'e2e@mock.test', fname: 'E2E', lname: 'User', phone: '1', gender: '1' };

  const short = await admin.req('/users/create', { form: { ...base, password: 'short', cpassword: 'short' } });
  assert.match(short.text_, /at least 8 characters/);

  const created = await admin.req('/users/create', { form: { ...base, password: 'E2ePass123', cpassword: 'E2ePass123' } });
  assert.equal(redirectTarget(created), '/users/');
  const uid = one("SELECT id FROM users WHERE email='e2e@mock.test'");

  const dup = await admin.req('/users/create', { form: { ...base, password: 'E2ePass123', cpassword: 'E2ePass123' } });
  assert.match(dup.text_, /must contain a unique value/);

  await admin.req(`/users/edit/${uid}`, { form: { ...base, fname: 'Edited' } });
  assert.equal(one(`SELECT firstname FROM users WHERE id=${uid}`), 'Edited');

  assert.equal(json(await admin.req('/users/delete', { form: { user_id: uid } })).success, true);
  assert.equal(one(`SELECT COUNT(*) FROM users WHERE id=${uid}`), '0');
  assert.equal(one(`SELECT COUNT(*) FROM user_group WHERE user_id=${uid}`), '0', 'no orphaned user_group row');
});

function orderForm(pid, qty, extra = {}) {
  return {
    customer_name: 'E2E Customer', customer_address: 'Somewhere', customer_phone: '123',
    'product[]': pid, 'qty[]': String(qty), 'rate_value[]': '10', 'amount_value[]': String(10 * qty),
    gross_amount_value: String(10 * qty), service_charge_rate: '0', service_charge_value: '0',
    vat_charge_rate: '0', vat_charge_value: '0', net_amount_value: String(10 * qty), discount: '0', ...extra,
  };
}

test('order lifecycle keeps product stock consistent', async (t) => {
  const pid = one("SELECT id FROM products WHERE sku='MOCK-NORMAL'");
  const stock = () => Number(one(`SELECT qty FROM products WHERE id=${pid}`));
  const start = stock();
  t.after(() => sql(`DELETE oi FROM orders_item oi JOIN orders o ON o.id=oi.order_id WHERE o.customer_name='E2E Customer'; DELETE FROM orders WHERE customer_name='E2E Customer'; UPDATE products SET qty='${start}' WHERE id=${pid}`));
  const clerk = await as('clerk');

  const created = await clerk.req('/orders/create', { form: orderForm(pid, 3) });
  const oid = redirectTarget(created).match(/orders\/update\/(\d+)/)?.[1];
  assert.ok(oid, 'redirects to the new order');
  assert.equal(stock(), start - 3, 'create deducts stock');

  await clerk.req(`/orders/update/${oid}`, { form: orderForm(pid, 5, { paid_status: '1' }) });
  assert.equal(stock(), start - 5, 'update re-applies stock');
  assert.equal(one(`SELECT paid_status FROM orders WHERE id=${oid}`), '1');

  const admin = await as('superadmin');
  assert.equal(json(await admin.req('/orders/remove', { form: { order_id: oid } })).success, true);
  assert.equal(stock(), start, 'remove returns stock');
  assert.equal(one(`SELECT COUNT(*) FROM orders_item WHERE order_id=${oid}`), '0');
});

test('product list shows the right stock status labels', async () => {
  const rows = json(await (await as('superadmin')).req('/products/fetchProductData')).data;
  const row = (sku) => rows.find((r) => r[2] === `MOCK-${sku}`);
  assert.match(row('OUT')[4], /Out of stock/);
  assert.match(row('LOW')[4], /Low!/);
  assert.match(row('OVER')[4], /Over supply/);
  assert.doesNotMatch(row('NOHIGH')[4], /Over supply/, 'high_quantity 0 means no upper limit');
  assert.doesNotMatch(row('NORMAL')[4], /Low!|Out of stock|Over supply/);
});

test('activity log date filter includes the whole end date', async (t) => {
  // a midday entry for a user nobody logs in as, so the suite's own logins can't push it off page 1
  sql("INSERT INTO activity_log (log_time, user_name, system_name, action_type, description) VALUES (CONCAT(CURDATE(), ' 12:00:00'), 'datefilter@mock.test', 'mock-seed', 'Update', 'Midday entry')");
  t.after(() => sql("DELETE FROM activity_log WHERE user_name='datefilter@mock.test'"));
  const today = one('SELECT CURDATE()');
  const res = await (await as('superadmin')).req(`/activitylog?start_date=${today}&end_date=${today}&user_name=datefilter@mock.test`);
  assert.match(res.text_, /Midday entry/);
});

test('activity log tolerates a non-numeric page parameter', async () => {
  const res = await (await as('superadmin')).req('/activitylog?page=abc');
  assert.doesNotMatch(res.text_, /A PHP Error was encountered|A Database Error Occurred/);
});
