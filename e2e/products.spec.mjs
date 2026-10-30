// Products: create (with image, brand, category), list status, edit, delete; low-stock page.
import { test, expect, login, filterTable, sql, one, web } from './fixtures.mjs';

const PNG = Buffer.from('89504e470d0a1a0a0000000d49484452000000010000000108060000001f15c4890000000d4944415478da63f8ffff3f0005fe02fea7d6a4c00000000049454e44ae426082', 'hex');

test('products: create with image, find in list, edit stock, delete', async ({ page }) => {
  sql("DELETE FROM products WHERE sku='MOCK-UI-1'");
  const store = one("SELECT id FROM stores WHERE name='[MOCK] Main Warehouse'");
  const brand = one("SELECT id FROM brands WHERE name='[MOCK] Atlas'");
  const category = one("SELECT id FROM categories WHERE name='[MOCK] Electrical'");
  await login(page, 'superadmin');

  await page.goto('/products/create');
  await page.locator('#product_image').setInputFiles({ name: 'item.png', mimeType: 'image/png', buffer: PNG });
  await page.locator('#product_name').fill('[MOCK] UI Product');
  await page.locator('input[name=part_number]').fill('PN-UI-1');
  await page.locator('input[name=sku]').fill('MOCK-UI-1');
  await page.locator('#price').fill('49.95');
  await page.locator('#qty').fill('3');
  await page.locator('#low_quantity').fill('5');
  await page.locator('#high_quantity').fill('100');
  await page.locator('#store').selectOption(store);
  await page.locator('#availability').selectOption('1');
  await page.locator('#description').fill('Created by Playwright');
  // select2 hides the native multi-selects; set them directly, as select2 would
  await page.locator('#brands').selectOption([brand], { force: true });
  await page.locator('#category').selectOption([category], { force: true });
  await page.locator('#createProductBtn').click();
  await page.waitForURL(/\/products\/?$/);

  const [id, image, brands, qty] = sql("SELECT id, image, brand_id, qty FROM products WHERE sku='MOCK-UI-1'")[0];
  try {
  expect(image).toMatch(/^assets\/images\/product_image\/.+\.png$/);
  expect(JSON.parse(brands)).toEqual([brand]);
  expect(qty).toBe('3');

  // 3 <= low threshold 5 -> flagged Low in the list
  const row = await filterTable(page, '#manageTable', 'MOCK-UI-1');
  await expect(row).toContainText('Low!');
  await expect(row.locator('img')).toHaveJSProperty('complete', true);

  await page.goto(`/products/update/${id}`);
  await expect(page.locator('#product_name')).toHaveValue('[MOCK] UI Product');
  await page.locator('#qty').fill('50');
  await page.locator('#updateProductBtn').click();
  await page.waitForURL(/\/products\/?$/);
  expect(one(`SELECT qty FROM products WHERE id=${id}`)).toBe('50');

  const row2 = await filterTable(page, '#manageTable', 'MOCK-UI-1');
  await expect(row2).not.toContainText('Low!');
  await row2.locator('button[onclick^="openDeleteModal"]').click();
  await page.locator('#deleteProductBtn').click();
  await expect.poll(() => one(`SELECT COUNT(*) FROM products WHERE id=${id}`)).toBe('0');
  } finally {
    // the app keeps image files after a product is deleted; don't leave the test's upload behind
    if (/^assets\/images\/product_image\/[\w.]+$/.test(image)) web(`rm -f /var/www/html/${image}`);
  }
});

test('products: required fields are enforced', async ({ page }) => {
  await login(page, 'superadmin');
  await page.goto('/products/create');
  // skip the browser's native required checks so the page's own JS validation runs
  await page.locator('form[action$="products/create"]').evaluate((f) => { f.noValidate = true; });
  let message = '';
  page.once('dialog', (d) => { message = d.message(); d.dismiss(); });
  await page.locator('#createProductBtn').click();
  await expect.poll(() => message).toBe('Please fill in all required fields');
  await expect(page).toHaveURL(/products\/create/);
});

test('product list shows stock states and escapes names', async ({ page }) => {
  await login(page, 'superadmin');
  await page.goto('/products');
  await expect((await filterTable(page, '#manageTable', 'MOCK-OUT'))).toContainText('Out of stock');
  await expect((await filterTable(page, '#manageTable', 'MOCK-OVER'))).toContainText('Over supply');
  const xss = await filterTable(page, '#manageTable', 'MOCK-XSS');
  await expect(xss).toContainText('<script>alert(1)</script>'); // shown as text, not executed
});

test('low stock page lists low products', async ({ page }) => {
  await login(page, 'superadmin');
  await page.goto('/lowindex');
  await expect(page.locator('body')).toContainText('Safety Gloves (low stock)');
});

test('clerk cannot reach product create', async ({ page }) => {
  await login(page, 'clerk');
  await page.goto('/products/create');
  await expect(page).toHaveURL(/dashboard/);
});
