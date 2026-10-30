// Smoke-tests every page and JSON feed as the all-permissions mock admin.
import { test, before } from 'node:test';
import assert from 'node:assert/strict';
import { as, one, assertCleanPage } from './helpers.mjs';

let admin;
const id = {};
before(async () => {
  admin = await as('superadmin');
  id.user = one("SELECT id FROM users WHERE email='clerk@mock.test'");
  id.group = one("SELECT id FROM `groups` WHERE group_name='[MOCK] Clerk'");
  id.attribute = one("SELECT id FROM attributes WHERE name='[MOCK] Color'");
  id.product = one("SELECT id FROM products WHERE sku='MOCK-NORMAL'");
  id.order = one("SELECT id FROM orders WHERE bill_no LIKE 'MOCK-%' ORDER BY id LIMIT 1");
  id.wo = one("SELECT id FROM work_order WHERE request_no='MOCK-WO-0001'");
});

const pages = () => [
  '/dashboard', '/users', '/users/create', `/users/edit/${id.user}`, '/users/profile', '/users/setting',
  '/groups', '/groups/create', `/groups/edit/${id.group}`, '/brands', '/category', '/stores',
  '/attributes', `/attributes/addvalue/${id.attribute}`, '/products', '/products/create',
  `/products/update/${id.product}`, '/orders', '/orders/create', `/orders/update/${id.order}`,
  `/orders/printDiv/${id.order}`, '/reports', '/company', '/activitylog', '/activitylog?page=2&action_type=Login',
  '/work_order', '/work_order/create', `/work_order/edit/${id.wo}`, '/lowindex',
];

test('every page renders without errors', async () => {
  for (const p of pages()) assertCleanPage(await admin.req(p), p);
});

test('reports render for a past year', async () => {
  const year = new Date().getFullYear() - 1;
  const res = await admin.req('/reports', { form: { select_year: String(year) } });
  assertCleanPage(res, 'reports past year');
});

for (const feed of ['/brands/fetchBrandData', '/category/fetchCategoryData', '/stores/fetchStoresData',
  '/attributes/fetchAttributeData', '/products/fetchProductData', '/products/fetchLowProduct', '/orders/fetchOrdersData']) {
  test(`${feed} returns valid DataTables JSON`, async () => {
    const res = await admin.req(feed);
    assert.equal(res.status, 200);
    const json = JSON.parse(res.text_);
    assert.ok(Array.isArray(json.data) && json.data.length > 0, 'non-empty data array');
  });
}

test('unknown page returns 404', async () => {
  const res = await admin.req('/no-such-controller');
  assert.equal(res.status, 404);
});
