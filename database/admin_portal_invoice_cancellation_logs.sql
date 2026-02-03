-- Admin Portal Invoice Cancellation Logs Table
-- This table stores all invoice cancellation emergency actions performed by admins
-- Used for future invoice-only cancellation actions (separate from unified sales order cancellation)

CREATE TABLE IF NOT EXISTS `admin_portal_invoice_cancellation_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `action_type` varchar(50) NOT NULL DEFAULT 'INVOICE_CANCEL' COMMENT 'Action type identifier',
  `invoice_id` int(11) DEFAULT NULL COMMENT 'Reference to inv_header.id (for regular invoices)',
  `exclude_invoice_id` int(11) DEFAULT NULL COMMENT 'Reference to exclude_inv_header.id (for exclude invoices)',
  `sales_order_header_id` int(11) DEFAULT NULL COMMENT 'Reference to sales_orders_header.id (if linked)',
  `exclude_sales_order_header_id` int(11) DEFAULT NULL COMMENT 'Reference to exclude_sales_orders_header.id (if linked)',
  `payment_id` int(11) DEFAULT NULL COMMENT 'Reference to pay_header.id (linked payments)',
  `temp_payment_id` int(11) DEFAULT NULL COMMENT 'Reference to temp_pay_header.id (linked temp payments)',
  `job_card_id` int(11) DEFAULT NULL COMMENT 'Reference to job_card.id (if linked)',
  `reason` text NOT NULL COMMENT 'Reason for emergency action',
  `action_details` text DEFAULT NULL COMMENT 'JSON details of what was cancelled',
  `status` varchar(20) NOT NULL DEFAULT 'PENDING' COMMENT 'SUCCESS, FAILED, PENDING',
  `error_message` text DEFAULT NULL COMMENT 'Error message if action failed',
  `user_id` int(11) NOT NULL COMMENT 'Reference to tbl_user.idtbl_user',
  `branch_id` int(11) NOT NULL COMMENT 'Reference to company_branch.id',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_action_type` (`action_type`),
  KEY `idx_invoice_id` (`invoice_id`),
  KEY `idx_exclude_invoice_id` (`exclude_invoice_id`),
  KEY `idx_sales_order_header_id` (`sales_order_header_id`),
  KEY `idx_exclude_sales_order_header_id` (`exclude_sales_order_header_id`),
  KEY `idx_payment_id` (`payment_id`),
  KEY `idx_temp_payment_id` (`temp_payment_id`),
  KEY `idx_job_card_id` (`job_card_id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_branch_id` (`branch_id`),
  KEY `idx_status` (`status`),
  KEY `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Admin Portal Invoice Cancellation Logs';
