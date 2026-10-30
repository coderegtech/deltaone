// Authorization, injection and exposure checks. Each test names the bug it guards against.
import { test } from 'node:test';
import assert from 'node:assert/strict';
import { execFileSync } from 'node:child_process';
import { BASE, API_KEY, Client, as, sql, one, redirectTarget, MOCK_PASSWORD } from './helpers.mjs';

const WEB_CONTAINER = process.env.WEB_CONTAINER || 'deltaone-review-web-1';
const webSh = (cmd) => execFileSync('docker', ['exec', WEB_CONTAINER, 'sh', '-c', cmd], { encoding: 'utf8' });

test('users without the permission are redirected away from admin pages', async () => {
  const viewer = await as('viewer');
  for (const p of ['/users', '/users/create', '/groups', '/company', '/orders/create', '/reports', '/activitylog', '/work_order']) {
    assert.equal(redirectTarget(await viewer.req(p)), '/dashboard', p);
  }
});

test('user without deleteProduct cannot delete a product', async () => {
  const pid = one("SELECT id FROM products WHERE sku='MOCK-BULK-300'");
  const clerk = await as('clerk');
  const res = await clerk.req('/products/remove', { form: { product_id: pid } });
  assert.equal(JSON.parse(res.text_).success, false);
  assert.equal(one(`SELECT COUNT(*) FROM products WHERE id=${pid}`), '1');
});

test('user without attribute permissions cannot change attribute values', async () => {
  const attr = one("SELECT id FROM attributes WHERE name='[MOCK] Color'");
  const value = one(`SELECT id FROM attribute_value WHERE attribute_parent_id=${attr} LIMIT 1`);
  const viewer = await as('viewer');
  await viewer.req('/attributes/createValue', { form: { attribute_value_name: 'Hacked', attribute_parent_id: attr } });
  await viewer.req(`/attributes/updateValue/${value}`, { form: { edit_attribute_value_name: 'Hacked', attribute_parent_id: attr } });
  await viewer.req('/attributes/removeValue', { form: { attribute_value_id: value } });
  assert.equal(one("SELECT COUNT(*) FROM attribute_value WHERE value='Hacked'"), '0');
  assert.equal(one(`SELECT COUNT(*) FROM attribute_value WHERE id=${value}`), '1');
});

test('user cannot change their own group through the settings form', async (t) => {
  const uid = one("SELECT id FROM users WHERE email='requester@mock.test'");
  const before = one(`SELECT group_id FROM user_group WHERE user_id=${uid}`);
  const adminGroup = one("SELECT id FROM `groups` WHERE group_name='[MOCK] Superadmin'");
  t.after(() => sql(`UPDATE user_group SET group_id=${before} WHERE user_id=${uid}`));
  const c = await as('requester');
  await c.req('/users/setting', { form: {
    username: 'mrequester', email: 'requester@mock.test', fname: 'Req', lname: 'User', phone: '1', gender: '1',
    password: MOCK_PASSWORD, cpassword: MOCK_PASSWORD, groups: adminGroup,
  } });
  assert.equal(one(`SELECT group_id FROM user_group WHERE user_id=${uid}`), before);
});

test('user without createWorkOrder cannot store a work order', async () => {
  const clerk = await as('clerk');
  const res = await clerk.req('/work_order/store', { form: { request_title: 'Unauthorized' } });
  assert.notEqual(JSON.parse(res.text_ || '{}').success, true);
  assert.equal(one("SELECT COUNT(*) FROM work_order WHERE request_title='Unauthorized'"), '0');
});

function workOrderForm(overrides = {}) {
  const fd = new FormData();
  const fields = {
    request_date: '2026-10-30', request_time: '09:30', priority_mode: 'Normal', 'type_of_project[]': 'safety',
    request_title: 'Upload test', description: 'd', requested_by: one("SELECT id FROM users WHERE email='requester@mock.test'"),
    checked_by: one("SELECT id FROM users WHERE email='checker@mock.test'"), supplies: '[]', ...overrides,
  };
  for (const [k, v] of Object.entries(fields)) fd.append(k, v);
  return fd;
}

test('work order upload rejects a PHP file sent with an image MIME type', async () => {
  const c = await as('requester');
  const fd = workOrderForm({ request_no: 'MOCK-UPLOAD-1' });
  fd.append('attachments[]', new Blob(['<?php echo "pwned"; ?>'], { type: 'image/png' }), 'shell.php');
  const res = await c.req('/work_order/store', { body: fd });
  assert.equal(JSON.parse(res.text_).success, false);
  assert.equal(webSh('find /var/www/html/uploads -name "*.php" | wc -l').trim(), '0');
});

test('work order request_no cannot traverse out of the uploads directory', async (t) => {
  const c = await as('requester');
  const fd = workOrderForm({ request_no: '../../assets/mock-traversal' });
  fd.append('attachments[]', new Blob([Buffer.from('89504e470d0a1a0a0000000d49484452000000010000000108060000001f15c4890000000d4944415478da63f8ffff3f0005fe02fea7d6a4c00000000049454e44ae426082', 'hex')], { type: 'image/png' }), 'pixel.png');
  await c.req('/work_order/store', { body: fd });
  t.after(() => sql("DELETE FROM work_order WHERE request_title='Upload test'"));
  assert.equal(webSh('test -e /var/www/html/assets/mock-traversal && echo yes || echo no').trim(), 'no');
});

test('valid work order with an image attachment is stored and the link points at the file', async () => {
  const c = await as('requester');
  const fd = workOrderForm({ request_no: '', request_title: 'Upload test' });
  fd.append('attachments[]', new Blob([Buffer.from('89504e470d0a1a0a0000000d49484452000000010000000108060000001f15c4890000000d4944415478da63f8ffff3f0005fe02fea7d6a4c00000000049454e44ae426082', 'hex')], { type: 'image/png' }), 'pixel.png');
  const res = await c.req('/work_order/store', { body: fd });
  assert.equal(JSON.parse(res.text_).success, true, res.text_);
  const [path] = JSON.parse(one("SELECT attachments FROM work_order WHERE request_title='Upload test' ORDER BY id DESC LIMIT 1"));
  assert.equal(webSh(`test -f /var/www/html/${path} && echo yes || echo no`).trim(), 'yes', path);
});

test('order print escapes customer-supplied HTML', async (t) => {
  const oid = one("SELECT id FROM orders WHERE bill_no LIKE 'MOCK-%' ORDER BY id LIMIT 1");
  const original = one(`SELECT customer_name FROM orders WHERE id=${oid}`);
  sql(`UPDATE orders SET customer_name='<script>alert(1)</script>' WHERE id=${oid}`);
  t.after(() => sql(`UPDATE orders SET customer_name='${original}' WHERE id=${oid}`));
  const res = await (await as('superadmin')).req(`/orders/printDiv/${oid}`);
  assert.doesNotMatch(res.text_, /<script>alert\(1\)<\/script>/);
});

test('product list escapes product names', async () => {
  const res = await (await as('superadmin')).req('/products/fetchProductData');
  assert.doesNotMatch(res.text_, /<script>alert\(1\)<\/script>/);
});

test('sensitive files in the web root are not downloadable', async () => {
  for (const f of ['/Credentials.txt', '/Login.txt', '/stock.sql', '/composer.json', '/database/seeds/seed_mock_data.php']) {
    const res = await fetch(BASE + f);
    assert.equal(res.status, 403, f);
  }
});

test('raw DB API rejects requests without the API key', async () => {
  for (const p of ['/api/db-rows/get/?table=users', '/api/job_order/get/?table=job_order', '/api/manage-column/get/?table=users']) {
    const res = await fetch(BASE + p);
    assert.equal(res.status, 401, p);
    assert.doesNotMatch(await res.text(), /\$2y\$/, 'no password hashes');
  }
  const res = await fetch(BASE + '/api/db-rows/create/', { method: 'POST', body: JSON.stringify({ table: 'groups', data: { group_name: 'x', permission: 'x' } }) });
  assert.equal(res.status, 401);
});

test('raw DB API works with the API key', async () => {
  const res = await fetch(BASE + '/api/job_order/get/?table=job_order', { headers: { 'X-API-Key': API_KEY } });
  assert.equal(res.status, 200);
  assert.equal((await res.json()).status, true);
});
