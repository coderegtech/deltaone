# Mock data

Seeder: [`database/seeds/seed_mock_data.php`](../database/seeds/seed_mock_data.php) (PHP CLI, no dependencies).

## Safety

- Refuses to run unless `MOCK_SEED=1` is set, refuses when `CI_ENV=production`, and is CLI-only (the web path returns 403, and `database/` is denied by `.htaccess`).
- Every mock row is marked, and cleanup deletes **only** marked rows:

  | Table | Marker |
  |---|---|
  | `groups` | `group_name` starts with `[MOCK] ` |
  | `users` | `email` ends with `@mock.test` |
  | `stores`, `brands`, `categories`, `attributes` | `name` starts with `[MOCK] ` |
  | `products` | `sku` starts with `MOCK-` |
  | `orders` (+ `orders_item`) | `bill_no` starts with `MOCK-` |
  | `work_order` (+ supplies, performers) | `request_no` starts with `MOCK-`, or any user column points at a mock user |
  | `activity_log` | `system_name = 'mock-seed'` |

- Runs in one transaction, uses a fixed random seed, and is idempotent: re-running deletes the marked rows and inserts them again (verified: identical counts on repeated runs, real rows untouched).
- Never run it against a database holding real data you care about without a backup — it only deletes marked rows, but it does write to the shared tables.

## Commands

Use a dedicated stack so your normal `deltaone` containers and their data are untouched:

```bash
WEB_PORT=8091 BASE_URL=http://localhost:8091 API_KEY=mock-api-key docker compose -p deltaone-review up -d --build
```

```bash
docker exec -i deltaone-review-db-1 sh -c 'mysql -uroot -p"$MYSQL_ROOT_PASSWORD" stock' < database/migrations/2026_10_30_add_missing_columns.sql
```

(Only needed for a database created from an older `stock.sql`; a fresh volume already has the columns.)

```bash
docker exec -e MOCK_SEED=1 deltaone-review-web-1 php database/seeds/seed_mock_data.php
```

Remove all mock rows:

```bash
docker exec -e MOCK_SEED=1 deltaone-review-web-1 php database/seeds/seed_mock_data.php --clean
```

On XAMPP: `set MOCK_SEED=1` then `php database\seeds\seed_mock_data.php` (uses `DB_HOST`/`DB_USER`/`DB_PASS`/`DB_NAME`, same defaults as the app).

## Test accounts

All use the test-only password **`MockPass123!`**.

| Email | Username | Group / role | What it can do |
|---|---|---|---|
| `superadmin@mock.test` | msuperadmin | [MOCK] Superadmin | every permission, incl. orders, reports, work orders, activity log, all work-order roles |
| `manager@mock.test` | mmanager | [MOCK] Manager | CRUD brands/categories/stores/attributes/products, reports |
| `clerk@mock.test` | mclerk | [MOCK] Clerk | create/update/view orders, view products |
| `viewer@mock.test` | mviewer | [MOCK] Viewer | read-only master data, products, orders |
| `requester@mock.test` | mrequester | [MOCK] Requester | view + create work orders (requester role) |
| `checker@mock.test` | mchecker | [MOCK] Checker | view + update work orders (checker role) |
| `approver@mock.test` | mapprover | [MOCK] Approver | view + update work orders (endorser/receiver/supervisor/approver) |
| `noperm@mock.test` | mnoperm | [MOCK] Noperm | no permissions (edge case) |
| `nogroup@mock.test` | mnogroup | *(none)* | account with no group at all (edge case) |
| `clerk01..25@mock.test` | mclerk01..25 | [MOCK] Clerk | bulk users for list/pagination |

The pre-existing `admin@admin.com` account from `stock.sql` is not touched.

## What gets seeded

| Entity | Count | Scenarios covered |
|---|---|---|
| Groups | 8 | one per role above, including an empty-permission group |
| Users | 34 | one per role, one without a group, 25 bulk clerks |
| Stores / brands / categories | 4 / 6 / 6 | last one of each is inactive |
| Attributes / values | 3 / 8 | `Legacy` attribute is inactive |
| Products | 310 | `MOCK-NORMAL`, `-LOW` (≤ low_quantity), `-OUT` (qty 0), `-OVER` (> high_quantity), `-NOHIGH` (high_quantity 0 = no limit), `-INACTIVE`, `-FREE` (price 0), `-LONG` (230-char name), `-UNICODE`, `-XSS` (HTML in name), plus 300 `MOCK-BULK-*` |
| Orders | 60 (≈140 items) | 20 per year for the last three years (reports), paid and unpaid, some with discount |
| Work orders | 8 | Pending / In Progress / Completed / Closed × Normal / Emergency, outcomes Successful / with Issue / Unsuccessful, signatures at each stage, supplies |
| Activity log | 50 | Login/Logout/Create/Update/Delete over the last 50 hours |

Not seeded on purpose: emoji in product names. The legacy tables are 3-byte `utf8`, so MariaDB rejects 4-byte characters (see `REMAINING_ISSUES.md`).
