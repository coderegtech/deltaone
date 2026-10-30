// Brands, categories, stores and attributes: add / edit / delete through the modals.
import { test, expect, login, filterTable, sql, one } from './fixtures.mjs';

const modules = [
  { path: '/brands', table: 'brands', field: 'brand' },
  { path: '/category', table: 'categories', field: 'category' },
  { path: '/stores', table: 'stores', field: 'store' },
  { path: '/attributes', table: 'attributes', field: 'attribute' },
];

for (const m of modules) {
  test(`${m.table}: add, validate, edit, delete`, async ({ page }) => {
    const name = `[MOCK] UI ${m.field}`;
    sql(`DELETE FROM ${m.table} WHERE name LIKE '[MOCK] UI %'`);
    await login(page, 'superadmin');
    await page.goto(m.path);

    // empty name -> validation message, nothing saved
    await page.locator("button[onclick=\"showModal('addModal')\"]").click();
    await page.locator('#addModal button[type=submit]').click();
    await expect(page.locator('#addModal .text-danger').first()).toBeVisible();

    await page.locator(`#${m.field}_name`).fill(name);
    await page.locator('#addModal button[type=submit]').click();
    await expect.poll(() => one(`SELECT COUNT(*) FROM ${m.table} WHERE name='${name}'`)).toBe('1');

    const row = await filterTable(page, '#manageTable', name);
    await row.locator('button[onclick^="editFunc"]').click();
    await expect(page.locator(`#edit_${m.field}_name`)).toHaveValue(name);
    await page.locator(`#edit_${m.field}_name`).fill(`${name} v2`);
    await page.locator('#edit_active').selectOption('2');
    await page.locator('#editModal button[type=submit]').click();
    await expect.poll(() => sql(`SELECT name, active FROM ${m.table} WHERE name LIKE '${name}%'`)[0]).toEqual([`${name} v2`, '2']);

    await page.reload();
    const row2 = await filterTable(page, '#manageTable', `${name} v2`);
    await row2.locator('button[onclick^="removeFunc"]').click();
    await page.locator('#removeModal button[type=submit]').click();
    await expect.poll(() => one(`SELECT COUNT(*) FROM ${m.table} WHERE name LIKE '${name}%'`)).toBe('0');
  });
}

test('attribute values: add, edit, delete on the value page', async ({ page }) => {
  const attr = one("SELECT id FROM attributes WHERE name='[MOCK] Color'");
  sql(`DELETE FROM attribute_value WHERE value LIKE 'UI Teal%'`);
  await login(page, 'superadmin');
  await page.goto(`/attributes/addvalue/${attr}`);
  await page.locator("button[onclick=\"showModal('addValueModal')\"]").click();
  await page.locator('#attribute_value_name').fill('UI Teal');
  await page.locator('#addValueModal button[type=submit]').click();
  await expect.poll(() => one(`SELECT COUNT(*) FROM attribute_value WHERE value='UI Teal' AND attribute_parent_id=${attr}`)).toBe('1');

  const row = await filterTable(page, '#manageTable', 'UI Teal');
  await row.locator('button[onclick^="editFunc"]').click();
  await expect(page.locator('#edit_attribute_value_name')).toHaveValue('UI Teal');
  await page.locator('#edit_attribute_value_name').fill('UI Teal v2');
  await page.locator('#editValueModal button[type=submit]').click();
  await expect.poll(() => one("SELECT COUNT(*) FROM attribute_value WHERE value='UI Teal v2'")).toBe('1');

  await page.reload();
  const row2 = await filterTable(page, '#manageTable', 'UI Teal v2');
  await row2.locator('button[onclick^="removeFunc"]').click();
  await page.locator('#removeValueModal button[type=submit]').click();
  await expect.poll(() => one("SELECT COUNT(*) FROM attribute_value WHERE value LIKE 'UI Teal%'")).toBe('0');
});
