// Every sidebar / header link opens a working page for the all-permissions user,
// and a restricted role is bounced from pages it may not see.
import { test, expect, login } from './fixtures.mjs';

test('every menu link opens a page without errors', async ({ page }) => {
  await login(page, 'superadmin');
  const hrefs = await page.$$eval('aside a[href], nav a[href], header a[href]', (as) =>
    [...new Set(as.map((a) => a.href).filter((h) => h.startsWith(location.origin) && !/logout|#$|\.(png|jpg)$/.test(h)))]);
  expect(hrefs.length).toBeGreaterThan(10);
  for (const href of hrefs) {
    const res = await page.goto(href);
    expect(res.status(), href).toBe(200);
    await expect(page.locator('body'), href).not.toContainText('404 Page Not Found');
  }
});

test('viewer is redirected away from admin-only pages', async ({ page }) => {
  await login(page, 'viewer');
  for (const path of ['/users', '/groups/create', '/company', '/activitylog', '/work_order/create']) {
    await page.goto(path);
    await expect(page, path).toHaveURL(/dashboard/);
  }
});
