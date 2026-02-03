<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class AdminPortal extends CI_Controller {
    protected $api_token;
    protected $auth_user;
    protected $admin_user_types = [1]; // Define admin user type IDs here

    public function __construct() {
        parent::__construct();
        $this->load->helper('api_helper');
        $this->load->model('AdminPortalinfo');
        $this->load->model('Commeninfo');

        $auth_info = auth_check();
        $this->api_token = $auth_info['api_token'];
        $this->auth_user = $auth_info['user'];

        // Check if user is admin
        $this->checkAdminAccess();
    }

    /**
     * Check if current user is admin
     */
    private function checkAdminAccess() {
        $user_type_id = $this->session->userdata('user_type_id');
        
        if (!in_array($user_type_id, $this->admin_user_types)) {
            $this->session->set_flashdata(['res' => '403', 'msg' => 'Access Denied: Admin Only']);
            redirect('Welcome/Logout');
            exit;
        }
    }

    /**
     * Verify user branch matches the branch being accessed
     */
    private function verifyBranch($branch_id) {
        $user_branch_id = $this->session->userdata('branch_id');
        
        if ($user_branch_id != $branch_id) {
            return [
                'status' => false,
                'message' => 'Branch mismatch: You can only perform actions on your branch'
            ];
        }
        
        return ['status' => true];
    }

    /**
     * Main admin portal index page
     */
    public function index() {
        $result['menuaccess'] = json_decode(json_encode($this->Commeninfo->getMenuPrivilege($this->api_token, '')['data'] ?? []));
        
        // Get emergency action logs
        $logs_response = $this->AdminPortalinfo->getEmergencyActionLogs($this->api_token, []);
        $result['logs'] = isset($logs_response['data']) ? $logs_response['data'] : [];
        
        $this->load->view('AdminPortal/index', $result);
    }

    /**
     * Emergency action form for sales order cancellation
     */
    public function emergencyActionForm() {
        $result['menuaccess'] = json_decode(json_encode($this->Commeninfo->getMenuPrivilege($this->api_token, '')['data'] ?? []));
        $this->load->view('AdminPortal/emergency_action_form', $result);
    }

    /**
     * Get sales order details for verification
     */
    public function getSalesOrderDetails() {
        $sales_order_id = $this->input->post('sales_order_id');
        
        if (!$sales_order_id) {
            echo json_encode([
                'status' => false,
                'message' => 'Sales Order ID is required'
            ]);
            return;
        }

        $response = $this->AdminPortalinfo->getSalesOrderDetailsForEmergency($this->api_token, $sales_order_id);
        echo json_encode($response);
    }

    /**
     * Execute emergency action: Cancel sales order relation and related records
     */
    public function executeEmergencyAction() {
        $sales_order_relation_id = $this->input->post('sales_order_relation_id');
        $reason = $this->input->post('reason');
        $confirm_password = $this->input->post('confirm_password');
        
        // Double check admin login
        $user_type_id = $this->session->userdata('user_type_id');
        if (!in_array($user_type_id, $this->admin_user_types)) {
            echo json_encode([
                'status' => false,
                'message' => 'Access Denied: Admin Only'
            ]);
            return;
        }

        // Verify password confirmation (optional additional security)
        // You can implement password verification here if needed

        if (!$sales_order_relation_id || !$reason) {
            echo json_encode([
                'status' => false,
                'message' => 'Sales Order Relation ID and reason are required'
            ]);
            return;
        }

        // Get sales order relation details first to verify branch
        $relation_details = $this->AdminPortalinfo->getSalesOrderRelationDetails($this->api_token, $sales_order_relation_id);
        
        if (!$relation_details['status']) {
            echo json_encode($relation_details);
            return;
        }

        // Verify branch
        $branch_verification = $this->verifyBranch($relation_details['data']['branch_id']);
        if (!$branch_verification['status']) {
            echo json_encode($branch_verification);
            return;
        }

        // Execute emergency action
        $form_data = [
            'sales_order_relation_id' => $sales_order_relation_id,
            'reason' => $reason,
            'user_id' => $this->auth_user['id'],
            'user_name' => $this->auth_user['name'],
            'branch_id' => $this->session->userdata('branch_id')
        ];

        $response = $this->AdminPortalinfo->executeEmergencyAction($this->api_token, $form_data);
        echo json_encode($response);
    }

    /**
     * Get emergency action logs
     */
    public function getEmergencyActionLogs() {
        $filters = [
            'date_from' => $this->input->post('date_from') ?: $this->input->get('date_from'),
            'date_to' => $this->input->post('date_to') ?: $this->input->get('date_to'),
            'action_type' => $this->input->post('action_type') ?: $this->input->get('action_type'),
            'user_id' => $this->input->post('user_id') ?: $this->input->get('user_id')
        ];

        $response = $this->AdminPortalinfo->getEmergencyActionLogs($this->api_token, $filters);
        echo json_encode($response);
    }

    /**
     * View emergency action log details
     */
    public function viewLog($log_id) {
        $result['menuaccess'] = json_decode(json_encode($this->Commeninfo->getMenuPrivilege($this->api_token, '')['data'] ?? []));
        
        $log_response = $this->AdminPortalinfo->getEmergencyActionLogById($this->api_token, $log_id);
        $result['log'] = isset($log_response['data']) ? $log_response['data'] : null;
        
        $this->load->view('AdminPortal/view_log', $result);
    }
}
