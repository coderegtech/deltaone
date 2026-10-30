# Project review — DeltaOne inventory / asset management

Reviewed 2026-10-30 on branch `fix/project-review-testing`.

## Stack

| Layer | Technology |
|---|---|
| Framework | CodeIgniter 3 (server-rendered PHP MVC) |
| Runtime | PHP 7.4 + Apache (Docker image `php:7.4-apache`); CI 3 does not run on PHP 8 |
| Database | MariaDB 10.4, schema + data dump in `stock.sql` (no CI migrations in use) |
| UI | AdminLTE/Bootstrap 3 assets, Tailwind classes, jQuery, DataTables (AJAX JSON feeds) |
| Side API | `api/*` — standalone PHP endpoints over `core/rowManager.php` / `core/columnManager.php` (a "FlexiAPI" generic table CRUD for an external job-order system; see `collection/`) |
| Packaging | `Dockerfile` + `docker-compose.yml` (db, web, optional phpMyAdmin) |

## Architecture

```
browser ──> index.php (CI front controller, .htaccess rewrite)
              └─ controllers/*  extends Admin_Controller (core/MY_Controller.php)
                    ├─ session login check  (not_logged_in / logged_in)
                    ├─ permission array = unserialize(groups.permission) of the user's group
                    ├─ models/*  (CI Query Builder / bound queries)
                    └─ views/*   (render_template -> templates/main_layout)
external ──> api/<resource>/<verb>/index.php ──> core/*Manager.php ──> mysqli (any table)
```

Authorization is permission-string based: each group stores a PHP-serialized list such as `createProduct`, `viewOrder`, `requester`. Controllers check `in_array('<perm>', $this->permission)` per action.

## Modules

| Module | Controller | Main tables | Notes |
|---|---|---|---|
| Auth | `Auth` | users | bcrypt (`password_hash`), session cookie, login/logout written to activity log |
| Dashboard | `Dashboard` | products, orders, users, stores, work_order | counts + work-order cards |
| Users / Profile / Settings | `Users` | users, user_group | CRUD; settings = own profile |
| Groups (roles) | `Groups` | groups | permission checkboxes |
| Brands, Categories, Stores, Attributes (+values) | same names | same names | AJAX CRUD + DataTables feeds |
| Products / Inventory | `Products`, `LowIndex` | products | stock status (low / out / over supply), image upload |
| Orders | `Orders` | orders, orders_item, company | stock is deducted on create, re-applied on update; printable invoice |
| Reports | `Reports` | orders | yearly sales chart |
| Company | `Company` | company | VAT/service charge, currency |
| Work orders | `WorkOrder` | work_order, work_order_supplies, work_order_performed_by, request_sequence | request → check → endorse → receive → approve, attachments |
| Activity log | `ActivityLog` | activity_log | filter by user/action/date, paginated |
| External job-order API | `api/*` | job_order (and, before the fix, any table) | JSON |

Roles that exist in the data/permission model: administrator, editor, viewer, plus work-order roles requester, checker, endorser, receiver, supervisor, approver.

## Findings summary

Full detail, root causes and fixes are in [BUG_FIXES.md](BUG_FIXES.md); open items in [REMAINING_ISSUES.md](REMAINING_ISSUES.md).

**Critical (fixed)**
- Schema drift: code uses `products.part_number`, `products.high_quantity`, `work_order.signatures`, none of which `stock.sql` (or the running dev DB) had. The dashboard — the page every login lands on — crashed with a database error; product and work-order writes failed.
- Work-order attachment upload trusted the client MIME type and used the client `request_no` in the path: a `.php` file uploaded as `image/png` was stored under `uploads/` and **executed** (verified: it printed `pwned`). Also allowed directory traversal.
- `api/*` had no authentication and accepts any table/database name: anyone could read `users` (password hashes), insert/delete rows, and add/drop columns. It was also a PHP parse error on the shipped PHP 7.4 image (`array|false` return type).
- Privilege escalation: the self-service settings form passed a POSTed `groups` value into the user update, so any user could make themselves administrator.
- `Credentials.txt`, `Login.txt` and `stock.sql` (all data incl. password hashes) were downloadable over HTTP.

**High (fixed)**
- Missing permission checks: any logged-in user could delete products, create/update/delete attribute values, and create work orders.
- `users/edit.php` contained a copy of the work-order edit page, so editing a user from the UI was impossible (and it raised PHP notices).
- Accounts without a group hit PHP errors on every page.
- Deleting an order did not return its items to stock.

**Medium (fixed)**: stored XSS via order customer fields and product names (invoice, order list/edit, product list); "Out of stock" label unreachable; `high_quantity` 0 flagged every product as over-supplied; activity-log end date excluded that day and `?page=abc` raised warnings; deleting a user left an orphan `user_group` row; work-order form prefilled invalid date/time; attachment links pointed at the wrong path; wrong activity-log action type for product delete.

**Not fixed (documented)**: CSRF protection disabled, hard-coded encryption key/DB default password, 3-byte `utf8` tables, client-trusted order totals and no overselling check, systemic unescaped output in other views, N+1 queries, dead code (`LowQuantityController.php`, `lowproduct.php`, `__MACOSX/`), Docker uploads volume.

## Dead / duplicate code observed

- `application/controllers/LowQuantityController.php` declares class `LowIndex` (duplicate of `LowIndex.php`, unreachable: CI expects class `LowQuantityController`).
- `application/controllers/lowproduct.php` is empty; `application/controllers/dpi.png` is an image in the controllers folder.
- `__MACOSX/` resource-fork files, `test/` scratch files.
- Large blocks of commented-out code and debug `print_r` blocks in controllers.
- Activity-log boilerplate (≈20 lines) is duplicated in nearly every controller action.
- `ActivityLog::create/update/remove` are empty public methods.
