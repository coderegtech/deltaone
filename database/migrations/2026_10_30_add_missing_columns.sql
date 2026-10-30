-- Adds columns the application code already reads/writes but stock.sql never created.
-- Without them the dashboard, product create/update and work order create fail with
-- "Unknown column" errors. Safe to run more than once (MariaDB 10.0.2+).
ALTER TABLE `products`
  ADD COLUMN IF NOT EXISTS `part_number` varchar(255) NOT NULL DEFAULT '' AFTER `name`,
  ADD COLUMN IF NOT EXISTS `high_quantity` int(11) NOT NULL DEFAULT 0 AFTER `low_quantity`;

ALTER TABLE `work_order`
  ADD COLUMN IF NOT EXISTS `signatures` longtext DEFAULT NULL AFTER `attachments`;
