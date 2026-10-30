// Captures the README screenshots from the mock-data test stack:
//   docker exec -e MOCK_SEED=1 deltaone-review-web-1 php database/seeds/seed_mock_data.php
//   node scripts/screenshots.mjs            (BASE_URL defaults to http://localhost:8091)
// Lists are filtered to mock rows so no real records end up in the images.
import { chromium, devices } from '@playwright/test';
import { mkdirSync } from 'node:fs';

const BASE = process.env.BASE_URL || 'http://localhost:8091';
const OUT = 'docs/screenshots';
mkdirSync(OUT, { recursive: true });

const browser = await chromium.launch();

async function session(options) {
  const context = await browser.newContext({ baseURL: BASE, ...options });
  const page = await context.newPage();
  await page.goto('/auth/login');
  await page.getByPlaceholder('Enter your email').fill('superadmin@mock.test');
  await page.getByPlaceholder('Enter your password').fill('MockPass123!');
  await page.getByPlaceholder('Enter your password').press('Enter');
  await page.waitForURL('**/dashboard');
  return page;
}

async function shot(page, name, path, prepare) {
  if (path) await page.goto(path);
  await page.waitForLoadState('networkidle');
  if (prepare) await prepare(page);
  await page.waitForTimeout(600); // let entrance animations settle
  await page.screenshot({ path: `${OUT}/${name}.png` });
  console.log(`saved ${OUT}/${name}.png`);
}

const filter = (table, text) => async (page) => {
  await page.waitForFunction((t) => window.jQuery && jQuery.fn.dataTable.isDataTable(t), table);
  await page.evaluate(([t, q]) => jQuery(t).DataTable().search(q).draw(), [table, text]);
};

// Login page (signed out)
const anon = await (await browser.newContext({ baseURL: BASE, viewport: { width: 1440, height: 900 } })).newPage();
await shot(anon, 'login', '/auth/login');

const page = await session({ viewport: { width: 1440, height: 900 } });
await shot(page, 'dashboard', '/dashboard');
await shot(page, 'products', '/products', filter('#manageTable', '[MOCK]'));
await shot(page, 'product-create', '/products/create');
await shot(page, 'low-stock', '/lowindex');
await shot(page, 'work-order-create', '/work_order/create');
await shot(page, 'work-orders', '/work_order');
await shot(page, 'users', '/users', filter('#userTable', '@mock.test'));
await shot(page, 'groups', '/groups', filter('#groupTable', '[MOCK]'));
await shot(page, 'reports', '/reports');
await shot(page, 'activity-log', '/activitylog?user_name=superadmin%40mock.test');

const mobile = await session({ ...devices['Pixel 7'] });
await shot(mobile, 'mobile-dashboard', '/dashboard');

await browser.close();
