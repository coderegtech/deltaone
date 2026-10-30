// Orders (create with live totals, update, print), reports, company, activity log, dashboard.
import { test, expect, login, sql, one } from './fixtures.mjs';

test('orders: create with computed totals, update paid status and qty, print invoice', async ({ page }) => {
  const pid = one("SELECT id FROM products WHERE sku='MOCK-NORMAL'");
  const [price, startQty] = sql(`SELECT price, qty FROM products WHERE id=${pid}`)[0];
  try {
    await login(page, 'superadmin');
    await page.goto('/orders/create');
    await page.locator('#customer_name').fill('UI Order Customer');
    await page.locator('#customer_address').fill('1 Test Way');
    await page.locator('#customer_phone').fill('0917');
    // the select is wrapped by select2; choosing the option fires its onchange -> AJAX price lookup
    await page.locator('#product_1').selectOption(pid, { force: true });
    await expect(page.locator('#rate_1')).toHaveValue(price);
    await page.locator('#qty_1').fill('');
    await page.locator('#qty_1').pressSequentially('2'); // keyup recalculates the row and totals
    const amount = (Number(price) * 2).toFixed(2);
    await expect(page.locator('#amount_1')).toHaveValue(amount);
    await expect(page.locator('#gross_amount')).toHaveValue(amount);
    expect(Number(await page.locator('#net_amount').inputValue())).toBeGreaterThan(Number(amount)); // + service & VAT

    await page.getByRole('button', { name: 'Create Order' }).click();
    await page.waitForURL(/orders\/update\/\d+/);
    const oid = page.url().match(/update\/(\d+)/)[1];
    expect(Number(one(`SELECT qty FROM products WHERE id=${pid}`))).toBe(Number(startQty) - 2);
    expect(one(`SELECT gross_amount FROM orders WHERE id=${oid}`)).toBe(amount);

    await expect(page.locator('#customer_name')).toHaveValue('UI Order Customer');
    await page.locator('#paid_status').selectOption('1');
    await page.locator('#qty_1').fill('');
    await page.locator('#qty_1').pressSequentially('4');
    await page.getByRole('button', { name: 'Save Changes' }).click();
    await page.waitForURL(new RegExp(`orders/update/${oid}`));
    expect(one(`SELECT paid_status FROM orders WHERE id=${oid}`)).toBe('1');
    expect(Number(one(`SELECT qty FROM products WHERE id=${pid}`))).toBe(Number(startQty) - 4);

    const [invoice] = await Promise.all([page.waitForEvent('popup'), page.getByRole('link', { name: 'Print' }).click()]);
    await expect(invoice.locator('body')).toContainText('UI Order Customer');
    await expect(invoice.locator('body')).toContainText('Paid');
    await invoice.close();
  } finally {
    sql(`DELETE oi FROM orders_item oi JOIN orders o ON o.id=oi.order_id WHERE o.customer_name='UI Order Customer'; DELETE FROM orders WHERE customer_name='UI Order Customer'; UPDATE products SET qty='${startQty}' WHERE id=${pid}`);
  }
});

test('orders list loads mock orders', async ({ page }) => {
  await login(page, 'superadmin');
  await page.goto('/orders');
  await page.waitForFunction(() => window.jQuery && jQuery('#manageTable').DataTable().data().count() > 0);
  await page.evaluate(() => jQuery('#manageTable').DataTable().search('MOCK-').draw());
  await expect(page.locator('#manageTable tbody tr').first()).toContainText('MOCK-');
});

test('reports: switch year and render the chart', async ({ page }) => {
  await login(page, 'superadmin');
  await page.goto('/reports');
  const year = String(new Date().getFullYear() - 1);
  await page.locator('#select_year').selectOption(year);
  await page.getByRole('button', { name: 'Apply Filter' }).click();
  await expect(page.locator('#select_year')).toHaveValue(year);
  await expect(page.locator('canvas').first()).toBeVisible();
});

test('company: update details and persist them', async ({ page }) => {
  const phone = one('SELECT phone FROM company WHERE id=1');
  try {
    await login(page, 'superadmin');
    await page.goto('/company');
    await page.locator('#phone').fill('(555) 010-2030');
    await page.locator('#saveCompanyBtn').click();
    await expect.poll(() => one('SELECT phone FROM company WHERE id=1')).toBe('(555) 010-2030');
    await page.goto('/company');
    await expect(page.locator('#phone')).toHaveValue('(555) 010-2030');
  } finally {
    sql(`UPDATE company SET phone='${phone}' WHERE id=1`);
  }
});

test('activity log: filter by action type and user', async ({ page }) => {
  await login(page, 'superadmin');
  await page.goto('/activitylog');
  await page.locator('#action_type').selectOption('Delete');
  await page.locator('#user_name').fill('clerk@mock.test');
  await page.getByRole('button', { name: 'Filter' }).click();
  await expect(page).toHaveURL(/action_type=Delete/);
  const rows = page.locator('table tbody tr');
  await expect(rows.first()).toContainText('clerk@mock.test');
  for (const text of await rows.allInnerTexts()) expect(text).toContain('Delete');
});

test('dashboard shows counters and work order cards', async ({ page }) => {
  await login(page, 'superadmin');
  await expect(page.locator('body')).toContainText('MOCK-WO-0001');
  await expect(page.locator('body')).toContainText(/Pending/i);
});
