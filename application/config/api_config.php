<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['api_base_url'] = 'https://devapi.ecw.lk/api';
// $config['api_base_url'] = 'http://erpapi.ecw.lk/api';

$config['api_endpoints'] = [
    'auth_check' => '/v1/auth_check',
    'login' => '/login',
    'get_users' => '/users',
    'get_profile' => '/profile',
    'update_profile' => '/profile/update',
    'logout' => '/logout',

    'user_type_v1' => '/v1/user_type',
    'user_type_status_v1' => '/v1/user_type_status',

    'user_privilege_v1' => '/v1/user_privilege',
    'user_privilege_status_v1' => '/v1/user_privilege_status',
    'get_menu_list_v1' => '/v1/get_menu_list',
    'get_user_list_v1' => '/v1/get_user_list',
    'get_user_type_list_v1' => '/v1/get_user_type_list',

    'user_account_v1' => '/v1/user_account',
    'user_account_status_v1' => '/v1/user_account_status',
    'get_employee_details_v1' => '/v1/get_employee_details',

    'menu_privilege_v1' => '/v1/menu_privilege',

    'get_company_bank_v1' => '/v1/get_company_bank',

    'check_dublicate_entry_v1' => '/v1/check_dublicate_entry',
    'main_job_category_v1' => '/v1/main_job_category',
    'main_job_category_status_v1' => '/v1/main_job_category_status',

    'sub_job_category_v1' => '/v1/sub_job_category',
    'sub_job_category_status_v1' => '/v1/sub_job_category_status',
    'get_sel2_mainjob_v1' => '/v1/get_sel2_mainjob',
    'get_sel2_subjob_v1' => '/v1/get_sel2_subjob',

    'job_option_group_v1' => '/v1/job_option_group',
    'job_option_group_details_list_v1' => '/v1/job_option_group_details_list',
    'job_option_group_status_v1' => '/v1/job_option_group_status',

    'job_option_v1' => '/v1/job_option',
    'job_option_details_list_v1' => '/v1/job_option_details_list',
    'get_sel2_optiongroup_v1' => '/v1/get_sel2_optiongroup',
    'job_option_status_v1' => '/v1/job_option_status',
  
    'job_option_value_v1' => '/v1/job_option_value',
    'get_sel2_job_option_v1' => '/v1/get_sel2_job_option',
    'get_sel2_job_option_value_v1' => '/v1/get_sel2_job_option_value',
    'job_option_value_details_list_v1' => '/v1/job_option_value_details_list',
    'job_option_value_status_v1' => '/v1/job_option_value_status',
    'get_images_by_category_v1' => '/v1/get_images_by_category',

    'job_card_v1' => '/v1/job_card',
    'customer_details_v1' => '/v1/customer_details',
    'get_sel2_pricecategory_v1' => '/v1/get_sel2_price_category',
    'get_sel2_payment_method_v1' => '/v1/get_sel2_payment_method',
    'get_sel2_discount_authorized_persons_v1' => '/v1/get_sel2_discount_authorized_person',
    'insertJobCardDetail_v1' => '/v1/insertJobCardDetail',
    'get_sub_job_base_main_v1' => '/v1/get_sub_job_base_main',
    'get_item_parent_options_v1' => '/v1/get_item_parent_options',
    'get_item_price_v1' => '/v1/get_item_price',
    'discount_update_v1' => '/v1/update_discount',
    'get_discount_v1' => '/v1/discount_details',
    'approve_jobcard_discount_v1' => '/v1/approve_jobcard_discount',
    'denied_jobcard_discount_v1' => '/v1/denied_jobcard_discount',
    'approve_job_card_v1' => '/v1/approve_jobcard',
    'denied_job_card_v1' => '/v1/denied_jobcard',
    'get_sales_agents_v1' => '/v1/get_sales_agents',
    'jobcard_item_delete_v1' => '/v1/jobcard_item_delete',
    'jobcard_header_update_v1' => '/v1/jobcard_header_update',
    'jobcard_confirmation_update_v1' => '/v1/jobcard_confirmation_update',
    'get_jobcard_edit_details_v1' => '/v1/get_jobcard_edit_details',
    'exportJobCardExcelData_v1' => '/v1/exportJobCardExcelData',
    'exportJobCardSummaryData_v1' => '/v1/exportJobCardSummaryData',

    'quickSearchJobDetails_v1' => '/v1/quickSearchJobDetails',

    'sales_target_v1' => '/v1/sales_target',
    'invoiceDetailsSummary_v1' => '/v1/invoiceDetailsSummary',

    'get_job_option_value_pricing_list_v1' => '/v1/get_job_option_value_list',
    'get_job_option_value_pricing_edit_v1' => '/v1/get_job_option_value_edit',
    'job_option_pricing_v1' => '/v1/job_option_pricing',

    'get_map_pdf_v1' => '/v1/get_map_pdf',

    'media_library_v1' => '/v1/media_library',
    'media_library_status_v1' => '/v1/media_library_status1',

    'sales_order_v1' => '/v1/sales_order',
    'get_sel2_jobcard_number_v1' => '/v1/get_sel2_jobcard',
    'sales_order_approve_v1' => '/v1/approve_sales_order',
    
    'invoice_v1' => '/v1/invoice',
    'store_direct_invoice_v1' => '/v1/store_direct_invoice',
    'update_direct_invoice_v1' => '/v1/update_direct_invoice',
    'get_sel2_salesorder_number_v1' => '/v1/get_sel2_salesorder',
    'get_direct_sales_item_v1' => '/v1/get_direct_sales_item',
    'getDirectSalesItemDetails_v1' => '/v1/get_direct_sales_item_details',
    'get_sel2_invoice_number_v1' => '/v1/get_sel2_invoice_number',
    'get_sel2_pay_allocation_receipt_v1' => '/v1/get_sel2_pay_allocation_receipts',
    'approve_invoice_v1' => '/v1/approveInvoice',
    'cancel_invoice_v1' => '/v1/cancelInvoice',
    'get_invoice_pdf_v1' => '/v1/get_invoice_pdf',
    'search_customer_v1' => '/v1/search_customer',
    'get_latest_tax_v1' => '/v1/get_latest_tax',


    'tax_master_v1' => '/v1/tax_master',
    'tax_control_status_v1' => '/v1/tax_control_status',

    'payment_v1' => '/v1/payment',
    'get_sel2_customer_v1' => '/v1/get_sel2_customer',
    'get_outstanding_invoices_v1' => '/v1/get_outstanding_invoices',

    'get_all_outstanding_invoices_v1' => '/v1/get_all_outstanding_invoices',
    'invoiceAmountSummary_v1' => '/v1/invoiceAmountSummary',

    'get_jobcards_by_customer_v1' => '/v1/get_jobcards_by_customer',
    'get_draft_receiptno_v1' => '/v1/get_draft_receiptno',
    'get_payment_details_v1' => '/v1/get_payment_details',
    'get_payment_allocation_details_v1' => '/v1/get_payment_allocation_details',
    'confirm_payment_v1' => '/v1/confirm_payment',
    'get_Receipt_pdf_v1' => '/v1/get_Receipt_pdf',
    'get_Receipt_v2_pdf_v1' => '/v1/get_Receipt_v2_pdf',
    'delete_payment_v1' => '/v1/delete_payment',
    'cancel_payment_v1' => '/v1/cancel_payment',

    'getJobList_v1' => '/v1/getJobList',

    'item_v1' => '/v1/item',

    // ============================================================
    // OLD CASHIER ENDPOINTS - COMMENTED OUT (Using new organized structure)
    // ============================================================
    // 'cashier_shift_v1' => '/v1/cashier_shift',
    // 'update_shift_opening_balance_v1' => '/v1/update_shift_opening_balance',
    // 'approve_shift_opening_balance_v1' => '/v1/approve_shift_opening_balance',
    // 'verify_shift_closing_balance_v1' => '/v1/verify_shift_closing_balance',
    // 'update_shift_closing_balance_v1' => '/v1/update_shift_closing_balance',
    // 'get_all_cashier_log_v1' => '/v1/get_all_cashier_log',
    // 'cashier_handover_v1' => '/v1/cashier_handover',
    // 'verify_cash_handover_v1' => '/v1/verify_cash_handover',
    // 'cashier_handover_voucher_v1' => '/v1/cashier_handover_voucher',
    // 'cashier_shift_summary_v1' => '/v1/cashier_shift_summary',
    // 'cashier_shift_transaction_ledger_v1' => '/v1/cashier_shift_transaction_ledger',
    // 'transaction_ledger_by_shift_v1' => '/v1/transaction_ledger_by_shift',
    // 'transaction_ledger_reversals_v1' => '/v1/transaction_ledger_reversals',
    // 'cashier_cash_movement_v1' => '/v1/cashier_cash_movement',
    // 'cashier_shift_adjustment_v1' => '/v1/cashier_shift_adjustment',
    // 'iou_settlement_v1' => '/v1/iou_settlement',
    // 'outstanding_ious_v1' => '/v1/outstanding_ious',
    // 'cashier_auth_authorize_v1' => '/v1/cashier_auth_authorize',
    // 'cashier_auth_session_v1' => '/v1/cashier_auth_session',
    // 'cashier_auth_logout_v1' => '/v1/cashier_auth_logout',
    // 'cashier_report_daily_summary_v1' => '/v1/cashier_report_daily_summary',
    // 'cashier_report_payment_summary_v1' => '/v1/cashier_report_payment_summary',
    // 'cashier_report_discrepancy_v1' => '/v1/cashier_report_discrepancy',
    // 'cashier_report_cash_out_summary_v1' => '/v1/cashier_report_cash_out_summary',
    // 'cashier_report_outstanding_ious_v1' => '/v1/cashier_report_outstanding_ious',

    'credit_settlement_list_v1' => '/v1/credit_settlement_list',

    'cashier_debitor_v1' => '/v1/cashier_debitor',
    'cashier_debitor_transfer_v1' => '/v1/cashier_debitor_transfer',
    'cashier_debitor_pdf_v1' => '/v1/cashier_debitor_pdf',

    // ============================================================
    // NEW CASHIER ENDPOINTS v1 (Organized Structure - /cashier/*)
    // ============================================================
    // Shift Management (Base paths - IDs are appended by call_api helper)
    'cashier_shift_v1' => '/v1/cashier/shift',
    'get_all_cashier_log_v1' => '/v1/cashier/shift/get_all_cashier_log',
    'update_shift_opening_balance_v1' => '/v1/cashier/shift',  // PUT: /v1/cashier/shift/{id}/update_opening_balance (handled in model)
    'approve_shift_opening_balance_v1' => '/v1/cashier/shift', // PUT: /v1/cashier/shift/{id}/approve_opening_balance (handled in model)
    'verify_shift_closing_balance_v1' => '/v1/cashier/shift',  // PUT: /v1/cashier/shift/{id}/verify_closing_balance (handled in model)
    'update_shift_closing_balance_v1' => '/v1/cashier/shift',  // PUT: /v1/cashier/shift/{id}/update_closing_balance (handled in model)
    'cashier_shift_current_balance_v1' => '/v1/cashier/shift/current_balance',
    'cashier_shift_closing_validation_v1' => '/v1/cashier/shift', // GET: /v1/cashier/shift/{id}/closing_validation (handled in model)
    'cashier_shift_discrepancy_analysis_v1' => '/v1/cashier/shift', // GET: /v1/cashier/shift/{id}/discrepancy_analysis (handled in model)
    'cashier_shift_generate_summary_v1' => '/v1/cashier/shift', // GET: /v1/cashier/shift/{id}/summary (handled in model)
    'cashier_shift_get_cash_book_summary_v1' => '/v1/cashier/shift', // GET: /v1/cashier/shift/{id}/cash_book_summary (handled in model)
    'cashier_shift_save_cash_book_summary_v1' => '/v1/cashier/shift', // POST: /v1/cashier/shift/{id}/cash_book_summary (handled in model)

    // Handover (Base paths - IDs are appended by call_api helper)
    'cashier_handover_v1' => '/v1/cashier/handover',
    'cashier_handover_datatable_v1' => '/v1/cashier/handover/datatable',
    'verify_cash_handover_v1' => '/v1/cashier/handover', // PUT: /v1/cashier/handover/{id}/verify (handled in model)
    'cashier_handover_voucher_v1' => '/v1/cashier/handover', // GET: /v1/cashier/handover/{id}/voucher (handled in model)

    // Shift Summary
    'cashier_shift_summary_v1' => '/v1/cashier/shift_summary',
    'cashier_shift_summary_datatable_v1' => '/v1/cashier/shift_summary/datatable',

    // Transaction Ledger
    'cashier_shift_transaction_ledger_v1' => '/v1/cashier/transaction_ledger',
    'transaction_ledger_by_shift_v1' => '/v1/cashier/transaction_ledger/by_shift', // GET: /v1/cashier/transaction_ledger/by_shift/{shiftId} (handled in model)
    'transaction_ledger_reversals_v1' => '/v1/cashier/transaction_ledger/reversals',
    'cashier_transaction_ledger_datatable_v1' => '/v1/cashier/transaction_ledger/datatable',
    'cashier_transaction_ledger_reverse_v1' => '/v1/cashier/transaction_ledger', // POST: /v1/cashier/transaction_ledger/{id}/reverse (handled in model)

    // Cash Movements
    'cashier_cash_movement_v1' => '/v1/cashier/cash_movement',
    'cashier_cash_movement_datatable_v1' => '/v1/cashier/cash_movement/datatable',
    'cashier_cash_movement_sources_v1' => '/v1/cashier/cash_movement/sources',
    'cashier_cash_movement_payment_categories_v1' => '/v1/cashier/cash_movement/payment-categories',
    'cashier_cash_movement_suppliers_v1' => '/v1/cashier/cash_movement/suppliers',
    'cashier_cash_movement_outsource_suppliers_v1' => '/v1/cashier/cash_movement/outsource-suppliers',
    'cashier_cash_movement_employee_advance_export_excel_v1' => '/v1/cashier/cash_movement/export-employee-advances-excel',

    // Supplier Jobs (for Out Source Supplier Advance Payments)
    'cashier_supplier_jobs_by_supplier_v1' => '/v1/cashier/supplier-jobs/by-supplier', // GET: /v1/cashier/supplier-jobs/by-supplier/{supplier_id} (handled in model)
    'cashier_supplier_jobs_create_v1' => '/v1/cashier/supplier-jobs',
    'cashier_supplier_jobs_update_v1' => '/v1/cashier/supplier-jobs', // PUT: /v1/cashier/supplier-jobs/{id} (handled in model)
    'cashier_supplier_jobs_advances_v1' => '/v1/cashier/supplier-jobs', // GET: /v1/cashier/supplier-jobs/{job_id}/advances (handled in model)
    'cashier_supplier_jobs_with_advances_v1' => '/v1/cashier/supplier-jobs/by-supplier', // GET: /v1/cashier/supplier-jobs/by-supplier/{supplier_id}/with-advances (handled in model)

    // Payee Masters
    'cashier_payee_masters_v1' => '/v1/cashier/payee-masters', // GET: /v1/cashier/payee-masters (list all payees)
    'cashier_payee_masters_create_v1' => '/v1/cashier/payee-masters', // POST: /v1/cashier/payee-masters (create new payee)

    // Shift Adjustments
    'cashier_shift_adjustment_v1' => '/v1/cashier/shift_adjustment',
    'cashier_shift_adjustment_datatable_v1' => '/v1/cashier/shift_adjustment/datatable',

    // IOU Settlements
    'iou_settlement_v1' => '/v1/cashier/iou_settlement',
    'iou_settlement_datatable_v1' => '/v1/cashier/iou_settlement/datatable',
    'outstanding_ious_v1' => '/v1/cashier/iou_settlement/outstanding/list',
    'outstanding_ious_datatable_v1' => '/v1/cashier/iou_settlement/outstanding/datatable',

    // Cash Safe Transactions
    'cash_safe_transaction_v1' => '/v1/cashier/cash_safe_v1',
    'cash_safe_transaction_datatable_v1' => '/v1/cashier/cash_safe/datatable_v1',
    'cash_safe_transaction_options_v1' => '/v1/cashier/cash_safe/options_v1',
    'cash_safe_transaction_summary_v1' => '/v1/cashier/cash_safe/summary_v1',

    // Cashier Authorization
    'cashier_auth_authorize_v1' => '/v1/cashier/auth/authorize',
    'cashier_auth_session_v1' => '/v1/cashier/auth/session',
    'cashier_auth_logout_v1' => '/v1/cashier/auth/logout',
    
    // Cashier Session Management
    'cashier_sessions_v1' => '/v1/cashier/sessions',
    'cashier_sessions_active_v1' => '/v1/cashier/sessions/active',
    'cashier_sessions_current_v1' => '/v1/cashier/sessions/current',
    'cashier_sessions_statistics_v1' => '/v1/cashier/sessions/statistics',
    'cashier_session_show_v1' => '/v1/cashier/sessions', // GET: /v1/cashier/sessions/{id} (handled in model)
    'cashier_session_update_v1' => '/v1/cashier/sessions', // PUT: /v1/cashier/sessions/{id} (handled in model)
    'cashier_session_force_logout_v1' => '/v1/cashier/sessions', // POST: /v1/cashier/sessions/{id}/force-logout (handled in model)
    'cashier_sessions_cleanup_v1' => '/v1/cashier/sessions/cleanup',
    'cashier_session_delete_v1' => '/v1/cashier/sessions', // DELETE: /v1/cashier/sessions/{id} (handled in model)

    // Reports
    'cashier_report_daily_summary_v1' => '/v1/cashier/reports/daily_summary',
    'cashier_report_payment_summary_v1' => '/v1/cashier/reports/payment_summary',
    'cashier_report_discrepancy_v1' => '/v1/cashier/reports/discrepancy',
    'cashier_report_cash_out_summary_v1' => '/v1/cashier/reports/cash_out_summary',
    'cashier_report_outstanding_ious_v1' => '/v1/cashier/reports/outstanding_ious',

    // Transaction Logs (Audit Trail)
    'cashier_transaction_log_v1' => '/v1/cashier/transaction_log',

    // ============================================================
    // FINANCE MODULE ENDPOINTS v1
    // ============================================================
    // Account Master
    'finance_account_master_v1' => '/v1/finance/account_master',
    'finance_account_master_tree_v1' => '/v1/finance/account_master/tree',
    
    // Finance Approvals
    'finance_approval_v1' => '/v1/finance/approval',
    'finance_approval_approve_v1' => '/v1/finance/approval', // POST: /v1/finance/approval/{id}/approve (handled in model)
    'finance_approval_reject_v1' => '/v1/finance/approval', // POST: /v1/finance/approval/{id}/reject (handled in model)
    'finance_approval_pending_v1' => '/v1/finance/approval/pending/list',








//--------------------------------------------V2------------------------------------------------------------------

    'roles_v2' => '/v2/roles',
    'roles_permissions_v2' => '/v2/roles_permissions',
    'roles_permissions_update_v2' => '/v2/roles_permissions_update',

    'users_v2' => '/v2/users',
    'users_active_v2' => '/v2/users_active',
    'users_deactive_v2' => '/v2/users_deactive',
    'user_permisson_v2' => '/v2/user_permisson',
    'users_update_overrides_v2' => '/v2/users_update_overrides',

    'permissions_v2' => '/v2/permissions',
    'all_permissions_v2' => '/v2/all_permissions',

    // ============================================================
    // DOCUMENT ACCESS ENDPOINTS v1
    // ============================================================
    'doc_access_type_v1' => '/v1/doc_access_type',
    'doc_access_v1' => '/v1/doc_access',

    // ============================================================
    // GATE PASS ENDPOINTS v1
    // ============================================================
    'gate_pass_list_v1' => '/v1/gate-pass',
    'gate_pass_show_v1' => '/v1/gate-pass', // GET: /v1/gate-pass/{id}
    'gate_pass_generate_in_v1' => '/v1/gate-pass/generate-in',
    'gate_pass_generate_in_1_v1' => '/v1/gate-pass/generate-in-1',
    'gate_pass_generate_in_2_v1' => '/v1/gate-pass/generate-in-2',
    'gate_pass_generate_out_v1' => '/v1/gate-pass/generate-out', // Auto-detects OUT type based on job status
    'gate_pass_generate_out_1_v1' => '/v1/gate-pass/generate-out-1',
    'gate_pass_generate_out_2_v1' => '/v1/gate-pass/generate-out-2',
    'gate_pass_generate_out_3_v1' => '/v1/gate-pass/generate-out-3',
    'gate_pass_generate_internal_v1' => '/v1/gate-pass/generate-internal',
    'gate_pass_generate_external_in_v1' => '/v1/gate-pass/generate-external-in',
    'gate_pass_generate_external_out_v1' => '/v1/gate-pass/generate-external-out',
    'gate_pass_print_v1' => '/v1/gate-pass', // POST: /v1/gate-pass/{id}/print
    'gate_pass_mark_return_v1' => '/v1/gate-pass', // POST: /v1/gate-pass/{id}/mark-return
    'gate_pass_job_card_status_v1' => '/v1/gate-pass/job-card', // GET: /v1/gate-pass/job-card/{jobCardId}/status
    'gate_pass_available_types_v1' => '/v1/gate-pass/job-card', // GET: /v1/gate-pass/job-card/{jobCardId}/available-types
    'gate_pass_locations_v1' => '/v1/gate-pass/locations',
    'gate_pass_locations_create_v1' => '/v1/gate-pass/locations',
    'gate_pass_locations_update_v1' => '/v1/gate-pass/locations', // PUT: /v1/gate-pass/locations/{id}
    'gate_pass_locations_delete_v1' => '/v1/gate-pass/locations', // DELETE: /v1/gate-pass/locations/{id}

    // ============================================================
    // ADMIN PORTAL ENDPOINTS v1
    // ============================================================
    'admin_portal_get_sales_order_details_v1' => '/v1/admin-portal/sales-order', // GET: /v1/admin-portal/sales-order/{id}
    'admin_portal_get_relation_details_v1' => '/v1/admin-portal/sales-order-relation', // GET: /v1/admin-portal/sales-order-relation/{id}
    'admin_portal_emergency_action_v1' => '/v1/admin-portal/emergency-action',
    'admin_portal_get_logs_v1' => '/v1/admin-portal/logs',
    'admin_portal_get_log_v1' => '/v1/admin-portal/logs', // GET: /v1/admin-portal/logs/{id}
];
