import { test as base, expect } from '@playwright/test';
import { execFileSync } from 'node:child_process';
import { sql, one, MOCK_PASSWORD } from '../tests/helpers.mjs';

export { expect, sql, one, MOCK_PASSWORD };

// Shell command inside the web container (for cleaning up files a test uploaded).
export const web = (cmd) => execFileSync('docker', ['exec', process.env.WEB_CONTAINER || 'deltaone-review-web-1', 'sh', '-c', cmd], { encoding: 'utf8' });

// Known, documented page error (docs/REMAINING_ISSUES.md): the Company page calls a
// Summernote plugin that is not shipped. Anything else fails the test.
const KNOWN_PAGE_ERRORS = [/summernote is not a function/];

export const test = base.extend({
  // Every test fails on an uncaught JS error or a PHP/DB error page.
  page: async ({ page }, use) => {
    const errors = [];
    page.on('pageerror', (e) => {
      if (!KNOWN_PAGE_ERRORS.some((re) => re.test(e.message))) errors.push(e.message);
    });
    page.on('response', async (res) => {
      if (res.request().resourceType() !== 'document') return;
      const body = await res.text().catch(() => '');
      if (/A PHP Error was encountered|A Database Error Occurred|Fatal error/.test(body)) {
        const detail = [...body.matchAll(/<p>(Message|Filename|Line Number|Error Number):?\s*([^<]*)<\/p>/g)].map((m) => `${m[1]} ${m[2].trim()}`).slice(0, 3).join(' | ');
        errors.push(`server error page: ${res.url()} — ${detail}`);
      }
    });
    await use(page);
    expect(errors, 'page/JS errors during the test').toEqual([]);
  },
});

export async function login(page, role, password = MOCK_PASSWORD) {
  await page.goto('/auth/login');
  await page.getByPlaceholder('Enter your email').fill(`${role}@mock.test`);
  await page.getByPlaceholder('Enter your password').fill(password);
  await page.getByPlaceholder('Enter your password').press('Enter');
  await page.waitForURL('**/dashboard');
}

// Narrow a DataTables list to one row with its own search API, so the row's real buttons can be clicked.
export async function filterTable(page, table, text) {
  await page.waitForFunction((t) => window.jQuery && jQuery.fn.dataTable.isDataTable(t), table);
  await page.evaluate(([t, q]) => jQuery(t).DataTable().search(q).draw(), [table, text]);
  const row = page.locator(`${table} tbody tr`, { hasText: text });
  await expect(row).toHaveCount(1);
  return row;
}
