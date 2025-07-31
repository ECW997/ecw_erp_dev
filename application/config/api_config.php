<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['api_base_url'] = 'https://devapi.ecw.lk/api';

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

    'customer_details_v1' => '/v1/customer_details',
    'get_sel2_pricecategory_v1' => '/v1/get_sel2_price_category',
    'job_card_v1' => '/v1/job_card',
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

    'get_job_option_value_pricing_list_v1' => '/v1/get_job_option_value_list',
    'get_job_option_value_pricing_edit_v1' => '/v1/get_job_option_value_edit',
    'job_option_pricing_v1' => '/v1/job_option_pricing',

    'get_map_pdf_v1' => '/v1/get_map_pdf',

    'media_library_v1' => '/v1/media_library',
    'media_library_status_v1' => '/v1/media_library_status',
    
    'get_sel2_jobcard_number_v1' => '/v1/get_sel2_jobcard',
    'get_direct_sales_item_v1' => '/v1/get_direct_sales_item',
    'getDirectSalesItemDetails_v1' => '/v1/get_direct_sales_item_details',
    'invoice_v1' => '/v1/invoice',
    'get_sel2_invoice_number_v1' => '/v1/get_sel2_invoice_number',
    'get_sel2_pay_allocation_receipt_v1' => '/v1/get_sel2_pay_allocation_receipts',
    'approve_invoice_v1' => '/v1/approveInvoice',
    'cancel_invoice_v1' => '/v1/cancelInvoice',

    'get_invoice_pdf_v1' => '/v1/get_invoice_pdf',
//     'delete_invoice_v1' => '/v1/deleteInvoice',


    'payment_v1' => '/v1/payment',
    'get_sel2_customer_v1' => '/v1/get_sel2_customer',
    'get_outstanding_invoices_v1' => '/v1/get_outstanding_invoices',
    'get_jobcards_by_customer_v1' => '/v1/get_jobcards_by_customer',
    'get_draft_receiptno_v1' => '/v1/get_draft_receiptno',
    'get_payment_details_v1' => '/v1/get_payment_details',
    'get_payment_allocation_details_v1' => '/v1/get_payment_allocation_details',
    'confirm_payment_v1' => '/v1/confirm_payment',
    'get_Receipt_pdf_v1' => '/v1/get_Receipt_pdf',
    'delete_payment_v1' => '/v1/delete_payment',

    'item_v1' => '/v1/item',
];