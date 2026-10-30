# Bug fixes

Every fix below was reproduced first (by curl or by a failing test in the baseline run) and is covered by a test in `tests/` that now passes. See [TEST_REPORT.md](TEST_REPORT.md).

## Critical

### 1. Dashboard and product/work-order writes crash: missing columns
- **Symptom**: right after login, `/dashboard` shows *Unknown column 'high_quantity' in 'where clause'*. Product create/update and work-order create fail.
- **Root cause**: code uses `products.part_number`, `products.high_quantity`, `work_order.signatures`; neither `stock.sql` nor the running dev DB has them (schema drift).
- **Fix**: added the columns to `stock.sql`; added the idempotent migration `database/migrations/2026_10_30_add_missing_columns.sql` for existing databases. `high_quantity` defaults to 0, treated as "no upper limit" (see #11).
- **Files**: `stock.sql`, `database/migrations/2026_10_30_add_missing_columns.sql` · commit `c40e0ac`
- **Action needed on existing DBs**: run the migration (the running `deltaone` dev DB also lacks these columns).

### 2. Remote code execution and path traversal via work-order attachments
- **Symptom**: uploading `shell.php` with `Content-Type: image/png` stored it at `uploads/work_orders/<request_no>/…_shell.php`; requesting it executed the PHP (verified output `pwned`). `request_no=../../assets/x` wrote files outside `uploads/`.
- **Root cause**: `WorkOrder::store` validated only the client-supplied MIME type, kept the client filename, and built the directory from the client `request_no`. No permission check on `store()`.
- **Fix**: require `createWorkOrder`; validate `request_no` against `^[A-Za-z0-9-]{1,50}$`; accept only `.jpg/.jpeg/.png` whose content `getimagesize()` confirms as JPEG/PNG; save under generated names (`<time>_<n>.<ext>`); move files only after all validation passes (no orphans on rejected requests); `.htaccess` refuses script extensions under `uploads/` and `assets/images/` as defense in depth. Also fixed the stored path (was missing the `request_no` directory, so links were broken), the "Maximum 3" message for a 5-file limit, request-date validation, and the form's invalid date/time prefill.
- **Files**: `application/controllers/WorkOrder.php`, `application/views/work_order/create.php`, `.htaccess`, `uploads/.htaccess` · commits `84914cb`, `3555a53`

### 3. Unauthenticated generic DB API (and broken on PHP 7.4)
- **Symptom**: `GET /api/db-rows/get/?table=users` was meant to return any table to anyone (password hashes included); create/update/delete rows and add/alter/drop columns likewise. On the shipped `php:7.4` image every endpoint was a *Parse error* instead.
- **Root cause**: no auth layer; `sanitizeDynamicInput(): array|false` is PHP 8 syntax; `DBConnection::env()` was never called, so `DB_HOST` was ignored and Docker could not connect.
- **Fix**: `requireApiKey()` checks `X-API-Key` against the `API_KEY` env var with `hash_equals`; no key configured → API disabled (401). Called once in `rowManager.php` and `columnManager.php`, which every endpoint includes. Removed the union return type. `getConnection()`/`setDatabase()` now call `env()`. `docker-compose.yml` passes `API_KEY`.
- **Files**: `core/response.php`, `core/rowManager.php`, `core/columnManager.php`, `core/db_config.php`, `docker-compose.yml` · commit `92dda5e`
- **Breaking for API consumers**: clients (the Postman collection, the external job-order system) must now send `X-API-Key`.

### 4. Privilege escalation through the settings form
- **Symptom**: any user could POST `groups=<admin group id>` with a password change on `/users/setting` and become an administrator.
- **Root cause**: `Users::setting()` passed `$this->input->post('groups')` to `model_users->edit()`.
- **Fix**: the settings path no longer passes a group. · `application/controllers/Users.php` · commit `b94ab7d`

### 5. Credentials and full DB dump downloadable
- **Symptom**: `/Credentials.txt`, `/Login.txt`, `/stock.sql` (all data, bcrypt hashes) returned 200.
- **Fix**: root `.htaccess` denies `sql/txt/md/json/lock/yml/eraserdiagram` and tooling files; `test/`, `tests/`, `database/` get deny-all `.htaccess` (same form as `application/.htaccess`). · commit `3555a53`

## High

| # | Bug | Root cause | Fix | Files / commit |
|---|---|---|---|---|
| 6 | Any logged-in user could delete products | `Products::remove()` had no permission check | require `deleteProduct` (JSON error otherwise); log action type `Delete` | `Products.php` · `7d8410d` |
| 7 | Any logged-in user could create/update/delete attribute values | `createValue/updateValue/removeValue` had no checks | require create/update/deleteAttribute, same style as `Attributes::remove` | `Attributes.php` · `4f56329` |
| 8 | Low-stock page: no permission check, PHP notice, empty store filter | view uses `$stores`, controller never set it | require `viewProduct`, pass `getActiveStore()` | `LowIndex.php` · `4f56329` |
| 9 | Users could not be edited from the UI | `views/users/edit.php` was a copy of the work-order edit page posting to `workorder/update` | rebuilt from `users/create.php` with escaped prefilled values and current group selected | `views/users/edit.php` · `b94ab7d` |
| 10 | Users without a group get PHP errors on every page | `unserialize(null['permission'])` | missing/invalid permission → empty array; `unserialize` with `allowed_classes => false` | `core/MY_Controller.php` · `9f8b206` |
| 11 | Deleting an order loses stock | `Model_orders::remove()` deleted items without restoring quantities (`update()` already restores) | add each item's qty back before deleting | `Model_orders.php` · `48b890b` |

## Medium

| # | Bug | Fix | Files / commit |
|---|---|---|---|
| 12 | Stored XSS: customer name/address/phone, bill no, company and product names rendered raw in invoice, order list, order edit form, product list | `html_escape()` at output | `Orders.php`, `views/orders/edit.php`, `Products.php` · `48b890b`, `7d8410d` |
| 13 | "Out of stock" never shown (qty ≤ low_quantity matched first) | check qty ≤ 0 first | `Products.php` · `7d8410d` |
| 14 | `high_quantity` 0 flags every product as "Over supply" (list + dashboard count) | 0 = no upper limit in controller and both model queries | `Products.php`, `Model_products.php` · `7d8410d` |
| 15 | Activity log end date excluded that day; `?page=abc` warnings | bare end date → `23:59:59`; page cast to int ≥ 1 | `ActivityLog.php`, `Model_activityLog.php` · `4941d19` |
| 16 | Deleting a user left an orphan `user_group` row | delete membership with the user | `Model_users.php` · `b94ab7d` |

## Found by the Playwright UI suite

| # | Severity | Bug | Fix | Files / commit |
|---|---|---|---|---|
| 17 | Medium | `jQuery is not defined` on every page: Select2 was loaded from a CDN before jQuery (and loaded again locally later) | remove the early duplicate | `views/templates/header.php` · `d02bf8c` |
| 18 | Medium | `scanner.js` loaded by a relative path (404 on nested URLs) and started the camera on every page, though no page has the scanner | absolute path; script exits unless `<video id="video">` exists | `header.php`, `assets/dist/js/scanner.js` · `d02bf8c` |
| 19 | High | Work-order create form's script broken by any `"` or newline in a product's name/description (product data pasted into JS strings); selected supplies inserted into `innerHTML` raw (DOM XSS) | `json_encode` the product list; escape supply-row values | `views/work_order/create.php` · `28d09e7` |
| 20 | Medium | Saving a product without choosing a new image: PHP notices (`Undefined index: product_image`) | check the upload field exists | `controllers/Products.php` · `b15edeb` |
| 21 | High | Edit page broken (PHP warnings) for any product saved without attributes/brands/categories (`in_array(…, null)`) | cast decoded ids to array | `views/products/edit.php`, `edit2.php` · `6bf4bff` |
| 22 | Low | Menu/dashboard links to `workorder` only work on case-insensitive filesystems; 404 on Linux | use routed `work_order` URLs | `side_menubar.php`, `dashboard.php`, `work_order/create.php` · `fd034b2` |

## Test-harness issue (not an app bug)

`fetch failed` in a few tests: `execFileSync('docker exec …')` blocks Node's event loop past Apache's 5 s keep-alive, so undici reused a socket the server had closed. `tests/helpers.mjs` resends once on that error.
