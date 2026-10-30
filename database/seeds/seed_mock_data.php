<?php
/*
 * Mock data seeder for development/testing ONLY.
 *
 *   docker compose exec -e MOCK_SEED=1 web php database/seeds/seed_mock_data.php [--clean]
 *
 * Every row it creates is marked so it can be told apart from real data:
 *   groups/stores/brands/categories/attributes "[MOCK] " name prefix, users "@mock.test" email,
 *   products/orders/work orders "MOCK-" sku/bill_no/request_no prefix, activity_log system_name "mock-seed".
 * Re-running first deletes ONLY those marked rows, then inserts them again (idempotent).
 * --clean deletes the marked rows and stops.
 */

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit("CLI only.\n");
}
if (getenv('MOCK_SEED') !== '1') {
    exit("Refusing to run: set MOCK_SEED=1 to confirm this is a development/test database.\n");
}
if (getenv('CI_ENV') === 'production') {
    exit("Refusing to run with CI_ENV=production.\n");
}

const MOCK_PASSWORD = 'MockPass123!'; // test-only credential, documented in docs/MOCK_DATA.md
const P = '[MOCK] ';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$db = new mysqli(
    getenv('DB_HOST') ?: 'localhost',
    getenv('DB_USER') ?: 'root',
    getenv('DB_PASS') !== false ? getenv('DB_PASS') : '',
    getenv('DB_NAME') ?: 'stock'
);
$db->set_charset('utf8mb4');

function insert(mysqli $db, string $table, array $row): int
{
    $cols = implode(',', array_map(function ($c) { return "`$c`"; }, array_keys($row)));
    $marks = implode(',', array_fill(0, count($row), '?'));
    $stmt = $db->prepare("INSERT INTO `$table` ($cols) VALUES ($marks)");
    $values = array_values($row);
    $stmt->bind_param(str_repeat('s', count($values)), ...$values);
    $stmt->execute();
    return $db->insert_id;
}

function clean(mysqli $db): void
{
    $db->query("DELETE oi FROM orders_item oi JOIN orders o ON o.id = oi.order_id WHERE o.bill_no LIKE 'MOCK-%'");
    $db->query("DELETE FROM orders WHERE bill_no LIKE 'MOCK-%'");
    $db->query("DELETE s FROM work_order_supplies s JOIN work_order w ON w.id = s.work_order_id WHERE w.request_no LIKE 'MOCK-%'");
    $db->query("DELETE p FROM work_order_performed_by p JOIN work_order w ON w.id = p.work_order_id WHERE w.request_no LIKE 'MOCK-%'");
    $db->query("DELETE FROM work_order WHERE request_no LIKE 'MOCK-%'");
    $db->query("DELETE FROM products WHERE sku LIKE 'MOCK-%'");
    $db->query("DELETE v FROM attribute_value v JOIN attributes a ON a.id = v.attribute_parent_id WHERE a.name LIKE '[MOCK] %'");
    foreach (['attributes', 'brands', 'categories', 'stores'] as $t) {
        $db->query("DELETE FROM `$t` WHERE name LIKE '[MOCK] %'");
    }
    $db->query("DELETE ug FROM user_group ug JOIN `groups` g ON g.id = ug.group_id WHERE g.group_name LIKE '[MOCK] %'");
    $db->query("DELETE ug FROM user_group ug JOIN users u ON u.id = ug.user_id WHERE u.email LIKE '%@mock.test'");
    $db->query("DELETE FROM `groups` WHERE group_name LIKE '[MOCK] %'");
    $db->query("DELETE FROM users WHERE email LIKE '%@mock.test'");
    $db->query("DELETE FROM activity_log WHERE system_name = 'mock-seed'");
}

$db->begin_transaction();
clean($db);
if (in_array('--clean', $argv, true)) {
    $db->commit();
    exit("Mock data removed.\n");
}

mt_srand(20261030); // deterministic data on every run

// ---- Roles (groups) --------------------------------------------------------
$crud = function (array $entities) {
    $out = [];
    foreach ($entities as $e) {
        foreach (['create', 'update', 'view', 'delete'] as $verb) $out[] = $verb . $e;
    }
    return $out;
};
$woRoles = ['requester', 'checker', 'endorser', 'receiver', 'supervisor', 'approver'];
$roles = [
    'superadmin' => array_merge(
        $crud(['User', 'Group', 'Brand', 'Category', 'Store', 'Attribute', 'Product', 'Order', 'WorkOrder']),
        ['updateProduct2', 'viewReports', 'updateCompany', 'viewActivityLog', 'viewProfile', 'updateSetting'],
        $woRoles
    ),
    'manager'   => array_merge($crud(['Brand', 'Category', 'Store', 'Attribute', 'Product']), ['viewReports', 'viewProfile', 'updateSetting']),
    'clerk'     => ['createOrder', 'updateOrder', 'viewOrder', 'viewProduct', 'viewProfile', 'updateSetting'],
    'viewer'    => ['viewBrand', 'viewCategory', 'viewStore', 'viewAttribute', 'viewProduct', 'viewOrder', 'viewProfile'],
    'requester' => ['viewWorkOrder', 'createWorkOrder', 'requester', 'viewProduct', 'viewProfile', 'updateSetting'],
    'checker'   => ['viewWorkOrder', 'updateWorkOrder', 'checker', 'viewProfile'],
    'approver'  => ['viewWorkOrder', 'updateWorkOrder', 'endorser', 'receiver', 'supervisor', 'approver', 'viewProfile'],
    'noperm'    => [],
];
$groupIds = [];
foreach ($roles as $key => $perms) {
    $groupIds[$key] = insert($db, 'groups', ['group_name' => P . ucfirst($key), 'permission' => serialize($perms)]);
}

// ---- Users: one per role, a group-less user, plus bulk clerks ----------------
$hash = password_hash(MOCK_PASSWORD, PASSWORD_DEFAULT);
$first = ['Ana', 'Ben', 'Carla', 'Dante', 'Elena', 'Felix', 'Gina', 'Hugo', 'Iris', 'Jose', 'Kara', 'Leo'];
$last = ['Reyes', 'Santos', 'Cruz', 'Garcia', 'Lim', 'Tan', 'Mendoza', 'Bautista'];
$userIds = [];
$addUser = function ($username, $email, $group) use ($db, $hash, $first, $last, $groupIds, &$userIds) {
    $id = insert($db, 'users', [
        'username' => $username, 'password' => $hash, 'email' => $email,
        'firstname' => $first[mt_rand(0, count($first) - 1)], 'lastname' => $last[mt_rand(0, count($last) - 1)],
        'phone' => '0917' . mt_rand(1000000, 9999999), 'gender' => mt_rand(1, 2),
    ]);
    if ($group) insert($db, 'user_group', ['user_id' => $id, 'group_id' => $groupIds[$group]]);
    $userIds[$username] = $id;
    return $id;
};
foreach (array_keys($roles) as $key) {
    $addUser('mock' . $key, "$key@mock.test", $key);
}
$addUser('mocknogroup', 'nogroup@mock.test', null); // edge case: account without a group
for ($i = 1; $i <= 25; $i++) {
    $addUser(sprintf('mclerk%02d', $i), sprintf('clerk%02d@mock.test', $i), 'clerk');
}

// ---- Master data -----------------------------------------------------------
$named = function ($table, array $names) use ($db) {
    $ids = [];
    foreach ($names as $i => $n) {
        $ids[] = insert($db, $table, ['name' => P . $n, 'active' => $i === count($names) - 1 ? 2 : 1]); // last one inactive
    }
    return $ids;
};
$storeIds = $named('stores', ['Main Warehouse', 'North Branch', 'South Branch', 'Closed Outlet']);
$brandIds = $named('brands', ['Atlas', 'Borealis', 'Cobalt', 'Delta Tools', 'Everline', 'Retired Brand']);
$categoryIds = $named('categories', ['Electrical', 'Mechanical', 'Safety Gear', 'Consumables', 'IT Equipment', 'Discontinued']);
$attrValues = [];
foreach (['Color' => ['Red', 'Blue', 'Black'], 'Size' => ['S', 'M', 'L', 'XL'], 'Legacy' => ['Old']] as $attr => $values) {
    $aid = insert($db, 'attributes', ['name' => P . $attr, 'active' => $attr === 'Legacy' ? 2 : 1]);
    foreach ($values as $v) $attrValues[] = insert($db, 'attribute_value', ['value' => $v, 'attribute_parent_id' => $aid]);
}

// ---- Products: one per stock state + edge cases + high volume ----------------
$productIds = [];
$addProduct = function ($sku, $name, $qty, $low, $high, array $extra = []) use ($db, $storeIds, $brandIds, $categoryIds, $attrValues, &$productIds) {
    $row = array_merge([
        'name' => $name, 'part_number' => 'PN-' . substr(md5($sku), 0, 8), 'sku' => 'MOCK-' . $sku,
        'price' => (string) (mt_rand(50, 500000) / 100), 'qty' => (string) $qty, 'image' => 'box.png',
        'description' => 'Mock product for testing.',
        'attribute_value_id' => json_encode([(string) $attrValues[mt_rand(0, 2)]]),
        'brand_id' => json_encode([(string) $brandIds[mt_rand(0, 4)]]),
        'category_id' => json_encode([(string) $categoryIds[mt_rand(0, 4)]]),
        'store_id' => $storeIds[mt_rand(0, 2)], 'availability' => 1,
        'low_quantity' => $low, 'high_quantity' => $high,
    ], $extra);
    $productIds[$sku] = insert($db, 'products', $row);
};
$addProduct('NORMAL', P . 'Circuit Breaker 20A', 120, 10, 500);
$addProduct('LOW', P . 'Safety Gloves (low stock)', 4, 10, 200);
$addProduct('OUT', P . 'Hydraulic Oil (out of stock)', 0, 5, 100);
$addProduct('OVER', P . 'Cable Ties (over supply)', 900, 50, 300);
$addProduct('NOHIGH', P . 'Fuse 10A (no high limit)', 40, 5, 0);
$addProduct('INACTIVE', P . 'Old Pump (inactive)', 10, 1, 50, ['availability' => 2]);
$addProduct('FREE', P . 'Free Sample (price 0)', 15, 1, 100, ['price' => '0']);
$addProduct('LONG', P . str_repeat('Very long product name ', 10), 30, 5, 100);
$addProduct('UNICODE', P . 'Ñandú Schraubenschlüssel 扳手', 22, 5, 100); // no emoji: legacy tables are 3-byte utf8
$addProduct('XSS', P . '<b>Bold</b> & "quoted" <script>alert(1)</script>', 8, 1, 100);
for ($i = 1; $i <= 300; $i++) {
    $addProduct(sprintf('BULK-%03d', $i), P . "Bulk Item $i", mt_rand(0, 400), mt_rand(5, 20), mt_rand(250, 600));
}

// ---- Orders: paid/unpaid across three years for reports ----------------------
$sellable = array_values(array_diff_key($productIds, array_flip(['OUT', 'INACTIVE'])));
$years = [(int) date('Y') - 2, (int) date('Y') - 1, (int) date('Y')];
$orderCount = 0;
foreach ($years as $year) {
    for ($i = 1; $i <= 20; $i++) {
        $gross = 0;
        $items = [];
        for ($k = 0, $n = mt_rand(1, 4); $k < $n; $k++) {
            $qty = mt_rand(1, 5);
            $rate = mt_rand(100, 5000) / 100;
            $items[] = ['product_id' => $sellable[mt_rand(0, count($sellable) - 1)], 'qty' => $qty, 'rate' => $rate, 'amount' => round($qty * $rate, 2)];
            $gross += round($qty * $rate, 2);
        }
        $service = round($gross * 0.13, 2);
        $vat = round($gross * 0.10, 2);
        $discount = $i % 5 === 0 ? 5 : 0;
        $oid = insert($db, 'orders', [
            'bill_no' => sprintf('MOCK-%d-%02d', $year, $i),
            'customer_name' => $first[mt_rand(0, 11)] . ' ' . $last[mt_rand(0, 7)],
            'customer_address' => mt_rand(1, 999) . ' Mock Street, Test City',
            'customer_phone' => '0918' . mt_rand(1000000, 9999999),
            'date_time' => (string) mktime(mt_rand(8, 17), mt_rand(0, 59), 0, mt_rand(1, 12), mt_rand(1, 28), $year),
            'gross_amount' => (string) $gross, 'service_charge_rate' => '13', 'service_charge' => (string) $service,
            'vat_charge_rate' => '10', 'vat_charge' => (string) $vat, 'discount' => (string) $discount,
            'net_amount' => (string) round($gross + $service + $vat - $discount, 2),
            'paid_status' => $i % 3 === 0 ? 2 : 1, // 1 = paid, 2 = unpaid
            'user_id' => $userIds['mockclerk'],
        ]);
        foreach ($items as $item) insert($db, 'orders_item', ['order_id' => $oid] + $item);
        $orderCount++;
    }
}

// ---- Work orders: every status / priority / outcome --------------------------
$woStates = [
    ['Pending', 'Normal', null, ['checker' => false, 'endorser' => false, 'receiver' => false, 'approver' => false]],
    ['Pending', 'Emergency', null, ['checker' => false, 'endorser' => false, 'receiver' => false, 'approver' => false]],
    ['In Progress', 'Normal', null, ['checker' => true, 'endorser' => true, 'receiver' => false, 'approver' => false]],
    ['In Progress', 'Emergency', null, ['checker' => true, 'endorser' => false, 'receiver' => false, 'approver' => false]],
    ['Completed', 'Normal', 'Successful', ['checker' => true, 'endorser' => true, 'receiver' => true, 'approver' => false]],
    ['Completed', 'Normal', 'Successful with Issue', ['checker' => true, 'endorser' => true, 'receiver' => true, 'approver' => false]],
    ['Closed', 'Normal', 'Successful', ['checker' => true, 'endorser' => true, 'receiver' => true, 'approver' => true]],
    ['Closed', 'Emergency', 'Unsuccessful', ['checker' => true, 'endorser' => true, 'receiver' => true, 'approver' => true]],
];
$types = ['improvement', 'safety', 'corrective', 'preventive'];
foreach ($woStates as $i => list($status, $priority, $outcome, $sig)) {
    $done = $status === 'Completed' || $status === 'Closed';
    $woId = insert($db, 'work_order', [
        'request_no' => sprintf('MOCK-WO-%04d', $i + 1),
        'request_date' => date('Y-m-d', strtotime("-" . (30 - $i * 3) . " days")),
        'request_time' => sprintf('%02d:%02d:00', mt_rand(7, 18), mt_rand(0, 59)),
        'priority_mode' => $priority,
        'type_of_project' => serialize([$types[$i % 4]]),
        'request_title' => P . "$status $priority work request",
        'description' => 'Mock description of the requested work.',
        'proposed_activities' => 'Inspect, replace, test.',
        'important_usage' => 'Keeps the line running.',
        'consequence_of_inaction' => 'Possible downtime.',
        'safety_concerns' => $priority === 'Emergency' ? 'Live electrical work.' : '',
        'requested_by' => $userIds['mockrequester'],
        'checked_by' => $userIds['mockchecker'],
        'endorsed_by' => $sig['endorser'] ? $userIds['mockapprover'] : null,
        'approved_by' => $sig['approver'] ? $userIds['mockapprover'] : null,
        'work_order_status' => $outcome,
        'status' => $status,
        'closure_notes' => $status === 'Closed' ? 'Closed by mock seed.' : null,
        'attachments' => '[]',
        'signatures' => json_encode($sig),
    ]);
    insert($db, 'work_order_supplies', ['work_order_id' => $woId, 'product_id' => $productIds['NORMAL'], 'quantity' => mt_rand(1, 5)]);
    if ($done) insert($db, 'work_order_performed_by', ['work_order_id' => $woId, 'user_id' => $userIds['mockchecker']]);
}

// ---- Activity log ----------------------------------------------------------
$actions = ['Login', 'Logout', 'Create', 'Update', 'Delete'];
for ($i = 0; $i < 50; $i++) {
    insert($db, 'activity_log', [
        'log_time' => date('Y-m-d H:i:s', strtotime("-$i hours")),
        'user_name' => array_keys($roles)[$i % count($roles)] . '@mock.test',
        'system_name' => 'mock-seed',
        'action_type' => $actions[$i % 5],
        'description' => 'Mock activity #' . ($i + 1),
    ]);
}

$db->commit();
printf(
    "Mock data seeded: %d groups, %d users, %d stores, %d brands, %d categories, %d attribute values, %d products, %d orders, %d work orders, 50 activity logs.\n",
    count($groupIds), count($userIds), count($storeIds), count($brandIds), count($categoryIds), count($attrValues), count($productIds), $orderCount, count($woStates)
);
