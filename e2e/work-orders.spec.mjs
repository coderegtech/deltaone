// Work orders: create through the form (supply + photo), list, open the edit page.
import { test, expect, login, sql, one, web } from './fixtures.mjs';

const PNG = Buffer.from('89504e470d0a1a0a0000000d49484452000000010000000108060000001f15c4890000000d4944415478da63f8ffff3f0005fe02fea7d6a4c00000000049454e44ae426082', 'hex');
const TITLE = '[MOCK] UI work request';

function cleanup() {
  const dirs = sql(`SELECT request_no FROM work_order WHERE request_title='${TITLE}'`).map(([r]) => r).filter((r) => /^[A-Za-z0-9-]+$/.test(r));
  for (const d of dirs) web(`rm -rf /var/www/html/uploads/work_orders/${d}`);
  sql(`DELETE FROM work_order WHERE request_title='${TITLE}'`);
}

test('requester creates a work order with a supply and a photo', async ({ page }) => {
  cleanup();
  try {
    await login(page, 'requester');
    await page.goto('/work_order/create');
    await page.locator('#emergency-btn').click();
    await page.locator('input[name="type_of_project[]"][value="safety"]').check();
    await page.locator('input[name=request_title]').fill(TITLE);
    for (const name of ['description', 'proposed_activities', 'important_usage', 'consequence_of_inaction', 'safety_concerns']) {
      await page.locator(`textarea[name=${name}]`).fill(`UI ${name}`);
    }
    await page.locator('select[name=requested_by]').selectOption(one("SELECT id FROM users WHERE email='requester@mock.test'"));
    await page.locator('select[name=checked_by]').selectOption(one("SELECT id FROM users WHERE email='checker@mock.test'"));

    const pid = one("SELECT id FROM products WHERE sku='MOCK-NORMAL'");
    await page.locator('#product-search').fill('Circuit Breaker');
    await page.locator('#product-dropdown').selectOption(pid);
    await page.locator(`[id="${pid}qty"]`).fill('2');

    await page.locator('#file-upload').setInputFiles({ name: 'photo.png', mimeType: 'image/png', buffer: PNG });
    await page.locator('#submit-form').click();
    await expect(page.getByText('Work order submitted successfully!')).toBeVisible();
    await page.waitForURL(/work_order\/?$/, { timeout: 10_000 });

    const [woId, priority, status, attachments] = sql(`SELECT id, priority_mode, status, attachments FROM work_order WHERE request_title='${TITLE}'`)[0];
    expect([priority, status]).toEqual(['Emergency', 'Pending']);
    expect(sql(`SELECT product_id, quantity FROM work_order_supplies WHERE work_order_id=${woId}`)).toEqual([[pid, '2']]);
    const [photo] = JSON.parse(attachments);
    expect(web(`test -f /var/www/html/${photo} && echo yes`).trim()).toBe('yes');

    await expect(page.locator('body')).toContainText(TITLE);
    // requesters may create but not edit (no updateWorkOrder permission)
    await page.goto(`/work_order/edit/${woId}`);
    await expect(page).toHaveURL(/dashboard/);
  } finally {
    cleanup();
  }
});

test('work order form rejects a submission without a project type', async ({ page }) => {
  await login(page, 'requester');
  await page.goto('/work_order/create');
  // satisfy the browser's native required fields so the page's own check runs
  await page.locator('input[name=request_title]').fill(TITLE);
  for (const name of ['description', 'proposed_activities', 'important_usage', 'consequence_of_inaction', 'safety_concerns']) {
    await page.locator(`textarea[name=${name}]`).fill('x');
  }
  await page.locator('select[name=requested_by]').selectOption(one("SELECT id FROM users WHERE email='requester@mock.test'"));
  await page.locator('select[name=checked_by]').selectOption(one("SELECT id FROM users WHERE email='checker@mock.test'"));
  await page.locator('#submit-form').click();
  await expect(page.getByText('Missing Type of Project.')).toBeVisible();
  expect(one(`SELECT COUNT(*) FROM work_order WHERE request_title='${TITLE}'`)).toBe('0');
});

test('checker sees the work order list and can open a work order', async ({ page }) => {
  await login(page, 'checker');
  await page.goto('/work_order');
  await expect(page.locator('body')).toContainText('MOCK-WO-0001');
  const id = one("SELECT id FROM work_order WHERE request_no='MOCK-WO-0001'");
  await page.goto(`/work_order/edit/${id}`);
  await expect(page.locator('#work-order-form')).toBeVisible();
});

test('KNOWN BUG: saving the work order edit/approval form returns 404', async ({ page }) => {
  // WorkOrder has no update() method; see docs/REMAINING_ISSUES.md. Expected to fail until it is built.
  test.fail();
  await login(page, 'checker');
  const id = one("SELECT id FROM work_order WHERE request_no='MOCK-WO-0001'");
  await page.goto(`/work_order/edit/${id}`);
  const action = await page.locator('#work-order-form').getAttribute('action');
  const res = await page.request.post(action, { form: { id } });
  expect(res.status()).toBe(200);
});
