# Test report

Date: 2026-10-30 · Branch: `fix/project-review-testing`

## Environment

Isolated Docker stack (separate compose project, own DB volume — the existing `deltaone` containers on :8080 were not touched):

```bash
WEB_PORT=8091 BASE_URL=http://localhost:8091 API_KEY=mock-api-key docker compose -p deltaone-review up -d --build
```

- web: `php:7.4-apache` (PHP 7.4.33), db: `mariadb:10.4`, DB created from `stock.sql`
- Mock data: `docker exec -e MOCK_SEED=1 deltaone-review-web-1 php database/seeds/seed_mock_data.php` (see [MOCK_DATA.md](MOCK_DATA.md))
- Test runner: Node 24 built-in `node:test` + `fetch`; no packages to install. Tests call `docker exec` for DB assertions.

## How to run

```bash
docker exec -e MOCK_SEED=1 deltaone-review-web-1 php database/seeds/seed_mock_data.php
```

```bash
node --test --test-concurrency=1 tests/
```

Overridable env: `BASE_URL` (default `http://localhost:8091`), `API_KEY` (`mock-api-key`), `DB_CONTAINER` (`deltaone-review-db-1`), `WEB_CONTAINER` (`deltaone-review-web-1`), `DB_PASS` (`codereg`). Re-seed before each full run; tests clean up after themselves but some assertions expect the seeded state.

## Results

| Run | Code | Tests | Pass | Fail |
|---|---|---|---|---|
| Baseline | original code (schema migration + seed applied so pages could load) | 48 | 28 | 20 |
| Final | this branch | 48 | **48** | **0** |

Final run duration ≈ 204 s (Docker bind mounts on Windows make each request ~1 s).

Baseline failures (each now passes):

| Test | Baseline failure |
|---|---|
| account without a group can log in | `Trying to access array offset on value of type null` in `MY_Controller.php:29` |
| every page renders without errors | `/users/edit/{id}`: `Undefined variable: users` (view was a work-order page); after that fix, `/lowindex`: `Undefined variable: stores` |
| user without deleteProduct cannot delete a product | clerk deleted the product |
| user without attribute permissions… | viewer created/updated/deleted attribute values |
| user cannot change their own group via settings | requester moved into the Superadmin group |
| user without createWorkOrder cannot store a work order | request accepted |
| upload rejects a PHP file with an image MIME type | `shell.php` stored under `uploads/`; fetching it over HTTP **executed it** (`pwned`, HTTP 200) |
| request_no cannot traverse out of uploads | files written to `assets/mock-traversal/` |
| valid work order attachment link points at the file | stored path lacked the `request_no` directory |
| order print escapes customer HTML | raw `<script>` in invoice |
| sensitive files not downloadable | `Credentials.txt`, `stock.sql`, … returned 200 |
| raw DB API rejects requests without key | PHP parse error (PHP 8 syntax on 7.4); with that fixed it would have served `users` incl. password hashes |
| raw DB API works with key | connection error: `DB_HOST` env ignored |
| brand / category CRUD (2 tests) | harness: stale keep-alive socket (`fetch failed`) — fixed in the harness, not an app bug |
| user lifecycle | orphaned `user_group` row after delete |
| order lifecycle keeps stock consistent | deleting an order left stock 5 lower than the start |
| product list stock labels | `MOCK-OUT` (qty 0) showed “Low!” instead of “Out of stock” |
| activity log end date | entries on the end date excluded |
| activity log non-numeric page | `A non-numeric value encountered` warning |

## Coverage (what the 48 tests exercise)

- **Auth (17)**: login page, empty form validation, unknown email, wrong password, SQL-injection-style input, login + clean dashboard for all 8 roles, group-less account, anonymous redirects, logout, logged-in user hitting login.
- **Pages (10)**: 30 pages rendered as superadmin with no PHP notice/DB error/redirect (dashboard, users list/create/edit/profile/settings, groups list/create/edit, brands, categories, stores, attributes + values, products list/create/update, orders list/create/update/print, reports current + past year, company, activity log + filters, work orders list/create/edit, low stock); 7 DataTables JSON feeds return valid non-empty JSON; unknown route → 404.
- **Security (14)**: RBAC redirects for 8 admin pages, product delete / attribute values / work-order store permission checks, settings privilege escalation, PHP upload, path traversal, valid upload + stored path, invoice XSS, product-list XSS, sensitive files 403, API 401 without key (GET row/column endpoints + POST create), API 200 with key.
- **Workflows (7)**: brand/category/store create → validation error → update → viewer blocked → delete; user create (short password, duplicate) → edit → delete; order create → stock deducted → update → stock re-applied + paid status → delete → stock restored; product stock-status labels; activity log date filter and bad page param.

## Manual / browser checks (built-in browser)

- Logged in as `superadmin@mock.test` through the real form → dashboard renders with work-order cards.
- `/users/edit/{id}`: form posts to `users/edit/{id}`, username/email prefilled, current group selected.
- 375 px mobile viewport on `/products`: no horizontal page overflow; table is inside a scroll wrapper.
- Console: only external 404 is `cdn.jsdelivr.net/npm/@zxing/library@0.19.1` (scanner library URL, see remaining issues).
- At ~800 px wide the sidebar is open and overlaps the content (cosmetic, not fixed).

## Builds / startup

- `docker compose build` + `up`: succeeds; Apache/PHP 7.4 starts; DB initialised from `stock.sql`.
- `php -l` (PHP 7.4) on every changed controller, model, core file, view and the seeder: no syntax errors.
- No frontend build step exists (static assets); no Composer packages are required at runtime.

## Not tested / blocked

- No existing automated tests in the repo to re-run (none were present).
- Playwright MCP server failed to connect, so no scripted browser E2E; HTTP-level tests + manual browser checks used instead. JavaScript-driven flows (order form total calculation, work-order multi-step signing UI, barcode scanner) were not exercised by automation.
- Work-order approval/edit submission: the edit view posts to `workorder/update`, which does not exist in `WorkOrder` (see remaining issues) — not testable as a working flow.
- XAMPP / subdirectory install (`http://localhost/deltaone`) not run; `.htaccess` rules were written to be path-relative.
- Load/performance testing not performed beyond the 310-product / 60-order dataset.
