<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Admin Portal Action Types Registry
 * 
 * This configuration file registers all available emergency action types.
 * Each action type defines its controller, model, views, and database table.
 * 
 * To add a new action type:
 * 1. Add entry to this array
 * 2. Create corresponding files (controller, model, views, tables)
 * 3. Set 'enabled' => true when ready
 */

$config['admin_portal_actions'] = [
    'SALES_ORDER_RELATION_CANCEL' => [
        'name' => 'Sales Order Relation Cancellation',
        'description' => 'Cancel sales order relation and ALL linked records as one unified action: Sales Orders, Exclude Sales Orders, Invoices, Exclude Invoices, Payments, Temp Payments',
        'controller' => 'AdminPortal',
        'action_method' => 'emergencyActionForm',
        'model' => 'AdminPortalinfo',
        'log_model' => 'SalesOrderCancellationLog',
        'log_table' => 'admin_portal_sales_order_cancellation_logs',
        'enabled' => true,
        'menu_icon' => 'fas fa-exclamation-triangle',
        'menu_order' => 1,
        'requires_id_type' => 'sales_order_relation_id',
        'cancels_linked_items' => [
            'sales_orders' => true,
            'exclude_sales_orders' => true,
            'invoices' => true,
            'exclude_invoices' => true,
            'payments' => true,
            'temp_payments' => true
        ],
        'api_endpoints' => [
            'get_details' => 'admin_portal_get_sales_order_details_v1',
            'get_relation' => 'admin_portal_get_relation_details_v1',
            'execute' => 'admin_portal_emergency_action_v1'
        ]
    ]
];

/**
 * Get enabled action types
 */
function get_enabled_admin_portal_actions() {
    $CI =& get_instance();
    $CI->config->load('admin_portal_actions');
    $actions = $CI->config->item('admin_portal_actions');
    
    return array_filter($actions, function($action) {
        return isset($action['enabled']) && $action['enabled'] === true;
    });
}

/**
 * Get action type configuration
 */
function get_admin_portal_action_config($action_type) {
    $CI =& get_instance();
    $CI->config->load('admin_portal_actions');
    $actions = $CI->config->item('admin_portal_actions');
    
    return isset($actions[$action_type]) ? $actions[$action_type] : null;
}
