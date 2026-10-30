import { test, expect, login } from './fixtures.mjs';

test('login form requires both fields (browser validation)', async ({ page }) => {
  await page.goto('/auth/login');
  await page.getByPlaceholder('Enter your password').press('Enter');
  await expect(page).toHaveURL(/auth\/login/);
  expect(await page.getByPlaceholder('Enter your email').evaluate((e) => e.validity.valueMissing)).toBe(true);
});

test('unknown email and wrong password show errors', async ({ page }) => {
  await page.goto('/auth/login');
  await page.getByPlaceholder('Enter your email').fill('nobody@mock.test');
  await page.getByPlaceholder('Enter your password').fill('whatever1');
  await page.getByPlaceholder('Enter your password').press('Enter');
  await expect(page.getByText('Email does not exists')).toBeVisible();

  await page.getByPlaceholder('Enter your email').fill('superadmin@mock.test');
  await page.getByPlaceholder('Enter your password').fill('wrong-password');
  await page.getByPlaceholder('Enter your password').press('Enter');
  await expect(page.getByText('Incorrect username/password combination')).toBeVisible();
});

test('login, see dashboard, log out from the header menu', async ({ page }) => {
  await login(page, 'superadmin');
  await expect(page).toHaveTitle(/Dashboard/);
  await page.goto('/auth/logout');
  await expect(page).toHaveURL(/auth\/login/);
  await page.goto('/dashboard');
  await expect(page).toHaveURL(/auth\/login/);
});

test('account without a group logs in and only sees the dashboard', async ({ page }) => {
  await login(page, 'nogroup');
  await page.goto('/users');
  await expect(page).toHaveURL(/dashboard/);
});
