// Users and groups: create, edit, delete through the real forms and modals.
import { test, expect, login, filterTable, sql, one } from './fixtures.mjs';

test('users: validation, create, edit, delete', async ({ page }) => {
  sql("DELETE ug FROM user_group ug JOIN users u ON u.id=ug.user_id WHERE u.email='uitest@mock.test'; DELETE FROM users WHERE email='uitest@mock.test'");
  const viewerGroup = one("SELECT id FROM `groups` WHERE group_name='[MOCK] Viewer'");
  await login(page, 'superadmin');

  await page.goto('/users/create');
  const fill = async (password) => {
    await page.locator('#groups').selectOption(viewerGroup);
    await page.locator('#username').fill('muitest');
    await page.locator('#email').fill('uitest@mock.test');
    await page.locator('#password').fill(password);
    await page.locator('#cpassword').fill(password);
    await page.locator('#fname').fill('Ui');
    await page.locator('#lname').fill('Tester');
    await page.locator('#phone').fill('09170000000');
    await page.locator('#female').check();
  };
  await fill('short');
  await page.locator('#createUserBtn').click();
  await expect(page.getByText('at least 8 characters')).toBeVisible();

  await fill('UiTestPass1');
  await page.locator('#createUserBtn').click();
  await page.waitForURL(/\/users\/?$/);
  const uid = one("SELECT id FROM users WHERE email='uitest@mock.test'");
  expect(uid).toBeTruthy();

  // edit form is prefilled with the user and their group
  await page.goto(`/users/edit/${uid}`);
  await expect(page.locator('#username')).toHaveValue('muitest');
  await expect(page.locator('#groups')).toHaveValue(viewerGroup);
  await page.locator('#fname').fill('Edited');
  await page.locator('#saveUserBtn').click();
  await page.waitForURL(/\/users\/?$/);
  expect(one(`SELECT firstname FROM users WHERE id=${uid}`)).toBe('Edited');

  // the new account can log in
  const other = await page.context().browser().newPage();
  await other.goto(page.url().replace(/\/users\/?$/, '/auth/login'));
  await other.getByPlaceholder('Enter your email').fill('uitest@mock.test');
  await other.getByPlaceholder('Enter your password').fill('UiTestPass1');
  await other.getByPlaceholder('Enter your password').press('Enter');
  await other.waitForURL('**/dashboard');
  await other.close();

  const row = await filterTable(page, '#userTable', 'uitest@mock.test');
  await row.locator('button[onclick^="openDeleteModal"]').click();
  await page.locator('#deleteUserBtn').click();
  await expect.poll(() => one(`SELECT COUNT(*) FROM users WHERE id=${uid}`)).toBe('0');
  expect(one(`SELECT COUNT(*) FROM user_group WHERE user_id=${uid}`)).toBe('0');
});

test('groups: create with permissions, edit, delete', async ({ page }) => {
  sql("DELETE FROM `groups` WHERE group_name LIKE '[MOCK] UI Group%'");
  await login(page, 'superadmin');
  await page.goto('/groups/create');
  await page.locator('#group_name').fill('[MOCK] UI Group');
  for (const perm of ['viewProduct', 'viewBrand', 'viewProfile']) await page.locator(`input[name="permission[]"][value="${perm}"]`).check();
  await page.getByRole('button', { name: 'Save Group' }).click();
  await page.waitForURL(/groups\/?$/);
  await expect.poll(() => one("SELECT permission FROM `groups` WHERE group_name='[MOCK] UI Group'")).toContain('viewBrand');
  const gid = one("SELECT id FROM `groups` WHERE group_name='[MOCK] UI Group'");

  await page.goto(`/groups/edit/${gid}`);
  await expect(page.locator('input[name="permission[]"][value="viewBrand"]')).toBeChecked();
  await page.locator('#group_name').fill('[MOCK] UI Group v2');
  await page.locator('input[name="permission[]"][value="viewBrand"]').uncheck();
  await page.locator('input[name="permission[]"][value="viewCategory"]').check();
  await page.locator('form button[type=submit]').first().click();
  await page.waitForURL(/groups\/?$/);
  await expect.poll(() => one(`SELECT group_name FROM \`groups\` WHERE id=${gid}`)).toBe('[MOCK] UI Group v2');
  const perms = one(`SELECT permission FROM \`groups\` WHERE id=${gid}`);
  expect(perms).toContain('viewCategory');
  expect(perms).not.toContain('viewBrand');

  await page.goto('/groups');
  const row = await filterTable(page, '#groupTable', '[MOCK] UI Group v2');
  await row.locator('button[onclick^="openDeleteModal"]').click();
  await page.locator('#deleteGroupBtn').click();
  await expect.poll(() => one(`SELECT COUNT(*) FROM \`groups\` WHERE id=${gid}`)).toBe('0');
});

test('profile shows the account and settings updates it', async ({ page }) => {
  const original = one("SELECT lastname FROM users WHERE email='manager@mock.test'");
  await login(page, 'manager');
  await page.goto('/users/profile');
  await expect(page.locator('body')).toContainText('manager@mock.test');

  await page.goto('/users/setting');
  await page.locator('#lname').fill('Settings Updated');
  await page.locator('form button[type=submit]').first().click();
  await expect.poll(() => one("SELECT lastname FROM users WHERE email='manager@mock.test'")).toBe('Settings Updated');
  sql(`UPDATE users SET lastname='${original}' WHERE email='manager@mock.test'`);
});
