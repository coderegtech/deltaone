// Runs in the "mobile" project (Pixel 7 viewport): key pages must not scroll sideways.
import { test, expect, login } from './fixtures.mjs';

for (const path of ['/auth/login', '/dashboard', '/products', '/users', '/work_order/create', '/reports']) {
  test(`no horizontal page overflow on ${path}`, async ({ page }) => {
    if (path !== '/auth/login') await login(page, 'superadmin');
    await page.goto(path);
    await page.waitForLoadState('networkidle');
    const overflow = await page.evaluate(() => document.documentElement.scrollWidth - window.innerWidth);
    expect(overflow, `${path} is ${overflow}px wider than the screen`).toBeLessThanOrEqual(1);
  });
}
