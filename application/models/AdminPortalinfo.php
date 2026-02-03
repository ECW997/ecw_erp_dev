<?php
class AdminPortalinfo extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->helper('api_helper'); 
    }

    /**
     * Get sales order details for emergency action verification
     */
    public function getSalesOrderDetailsForEmergency($api_token, $sales_order_id) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'admin_portal_get_sales_order_details_v1', $sales_order_id, $headers);
    }

    /**
     * Get sales order relation details
     */
    public function getSalesOrderRelationDetails($api_token, $relation_id) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'admin_portal_get_relation_details_v1', $relation_id, $headers);
    }

    /**
     * Execute emergency action
     */
    public function executeEmergencyAction($api_token, $form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'admin_portal_emergency_action_v1', $form_data, $headers);
    }

    /**
     * Get emergency action logs
     */
    public function getEmergencyActionLogs($api_token, $filters = []) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'admin_portal_get_logs_v1', $filters, $headers);
    }

    /**
     * Get emergency action log by ID
     */
    public function getEmergencyActionLogById($api_token, $log_id) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'admin_portal_get_log_v1', $log_id, $headers);
    }
}
