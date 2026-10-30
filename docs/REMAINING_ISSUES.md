# Remaining issues and recommendations

Ordered by priority. None of these were changed on this branch, either because they need a product decision, would change behaviour widely, or carry risk not justified without the owner's input.

## High

1. **Work-order edit / approval cannot be submitted.** `views/work_order/edit.php` posts to `workorder/update/<id>`, which returns 404: `WorkOrder` has no `update()` method. The signing stages (checker → endorser → receiver → approver) and status transitions are therefore unimplemented server-side. Needs the intended rules (who may sign when, stock deduction on approval — `reduce_stock` exists but is commented out) before it can be built.
2. **CSRF protection is off** (`config.php: csrf_protection = FALSE`). Every state-changing action (user delete, order delete, group edit…) can be triggered cross-site by a logged-in user's browser. Enabling CI's CSRF requires adding the token to every AJAX call in the views; do it together with a pass over the jQuery `$.ajax` calls.
3. **Rotate secrets and stop committing them.** `Credentials.txt`/`Login.txt` are in the repo; `config.php` has a hard-coded `encryption_key`; `database.php`/`db_config.php`/`docker-compose.yml` default the DB password to a real-looking value; the README advertises `admin@admin.com` / `password`. Move to env vars, remove the files from git history, change the admin password.
4. **API consumers need the key.** Set `API_KEY` in each environment and add `X-API-Key` to the Postman collection and the external job-order client. Consider restricting the API to an allow-list of tables (`job_order`, `activity_log`) — even with a key it can drop columns on any table.
5. **Orders trust client totals and allow overselling.** `gross_amount`, `net_amount`, `rate`, `amount` come straight from the form; quantity is not checked against stock, so qty can go negative. Recompute on the server from product prices and reject qty > stock.
6. **Run the schema migration on the existing dev DB** (`database/migrations/2026_10_30_add_missing_columns.sql`) — the running `deltaone` stack on :8080 still has the dashboard crash.

## Medium

7. **Systemic unescaped output.** Only the customer- and product-facing paths were escaped. Brand/category/store/attribute/group names, user fields in `users/index.php`, `users/setting.php` values, dashboard and work-order cards still echo raw DB values. Low exploitability (admins enter them) but worth a sweep with `html_escape()`.
8. **Deleting a user referenced by a work order** hits a foreign-key error (shown as a DB error page while `db_debug` is on; a generic error message in production). Block the delete with a clear message, or soft-delete users.
9. **Tables use 3-byte `utf8`.** Emoji (4-byte) in product names etc. are rejected by MariaDB. Convert tables to `utf8mb4` and set `char_set`/`dbcollat` accordingly.
10. **No database transactions** around multi-table writes (order create/update/delete, user create). A failure midway leaves partial data. Wrap in `$this->db->trans_start()/trans_complete()`.
11. **Login hardening**: no rate limiting or lockout; distinct messages for "email does not exist" vs wrong password allow account enumeration; session ID is not regenerated on login (`sess_regenerate(TRUE)`).
12. **Groups UI is missing permissions** that controllers check: `createOrder/updateOrder/viewOrder/deleteOrder`, `viewReports`, `updateProduct2` (`createWorkOrder` is present). Admins cannot grant them through the UI (the mock seeder writes them directly). The seeded "Admin" group also has `viewActivity` instead of `viewActivityLog`.
13. **Docker `uploads` volume** shadows the repo's `uploads/` (and its `.htaccess`); the root `.htaccess` rule covers it, but keep that rule if the layout changes.

13a. **Work-order delete links 404.** The work-order list and dashboard cards link to `work_order/delete/{id}`, but `WorkOrder` has no `delete()` method.
13b. **Orders are hidden from the UI.** There is no Orders entry in the sidebar, and the action buttons in `Orders::fetchOrdersData` (print/edit/delete) are commented out, so orders can only be reached by URL. Confirm whether this is intentional.
13c. **Company page JS**: it initialises a Summernote editor that is not shipped, so the page throws `summernote is not a function`. Saving still works only because that error stops the AJAX submit handler from attaching (the controller returns a redirect, not the JSON that handler expects). Either add Summernote and make the controller answer JSON, or delete the dead handler.
13d. **Work-order form client validation**: missing required fields show a toast but do not stop submission (`isValid` is never set in that loop); the server rejects only a missing title/date.
13e. **Product create/update accept non-numeric or negative price/qty** (`required` only, no `numeric`/`greater_than_equal_to` rules).
13f. **Product images are not deleted** when a product is deleted, and each `GET /work_order/create` consumes a request number from `request_sequence`.

## Low

14. N+1 queries: dashboard and work-order list call `user_exists()` + `getUserData()` per user field per order; product feeds call `getStoresData()` per row; invoice calls `getProductData()` per item. Fine at current volume (310 products), worth joins later.
15. Responsive: at ~800 px the sidebar is open and overlays content.
16. *(fixed: the scanner script no longer runs on pages without a scanner.)* No page currently renders the barcode scanner (`<video id="video">`); wire it into a page or remove `scanner.js`.
16a. Work-order list/dashboard echo `request_title`/`request_no` unescaped (part of #7).
17. Dead code: `LowQuantityController.php` (declares a second `LowIndex` class, unreachable), empty `lowproduct.php`, `controllers/dpi.png`, `__MACOSX/`, `test/`, empty `ActivityLog::create/update/remove`, large commented blocks, ~20-line activity-log boilerplate duplicated in most actions (candidate for a helper in `Admin_Controller`).
18. `Reports` constructor sets page title "Stores" and skips `not_logged_in()` (access is still denied via the permission check).
19. No CI pipeline runs the test suite; `tests/` needs Docker and Node 18+.
