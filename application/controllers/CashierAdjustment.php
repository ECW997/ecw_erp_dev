<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CashierAdjustment extends CI_Controller {
    protected $api_token;
    protected $auth_user;

    public function __construct() {
        parent::__construct();
        $this->load->helper('api_helper');
        $this->load->model('Cashier/Adjustmentinfo');

        $auth_info = auth_check();
        $this->api_token = $auth_info['api_token'];
        $this->auth_user = $auth_info['user'];
    }

    public function index() {
        $this->load->model('Commeninfo');
        $this->load->model('Cashier/Shiftinfo');
        $this->load->helper('api_helper');
        
        // Get current user's active shift
        $check_cashier_shift_response = $this->Shiftinfo->checkCashierShift($this->api_token, []);
        
        // Get current user's active shift automatically
        $active_shift = get_current_user_active_shift($this->api_token);
        $shift_id = $active_shift ? $active_shift['id'] : null;
        
        $result['menuaccess'] = json_decode(json_encode($this->Commeninfo->getMenuPrivilege($this->api_token,'')['data'] ?? []));
        $result['check_cashier_shift'] = $check_cashier_shift_response;
        $result['adjustments'] = $this->Adjustmentinfo->getAdjustments($this->api_token, $shift_id);
        $result['active_shift'] = $active_shift;

        $this->load->view('Cashier/Adjustment', $result);
    }

    public function getAdjustments() {
        $this->load->helper('api_helper');
        
        // Get current user's active shift automatically
        $active_shift = get_current_user_active_shift($this->api_token);
        $shift_id = $active_shift ? $active_shift['id'] : null;
        
        // Accept include_series2 parameter to show Series 2 data (is_confirm = 0)
        $include_series2 = $this->input->get('include_series2') ?: 0;
        
        $response = $this->Adjustmentinfo->getAdjustments($this->api_token, $shift_id, $include_series2);
        echo json_encode($response);
    }

    public function create() {
        // Get current user's active shift automatically
        $this->load->helper('api_helper');
        $active_shift = require_active_shift($this->api_token);
        
        // Automatically use current user's active shift
        $form_data = [
            'cashier_shift_id' => $active_shift['id'], // Use current user's active shift
            'adjustment_type'  => $this->input->post('adjustment_type'),
            'amount'           => $this->input->post('amount'),
            'remarks'          => $this->input->post('remarks')
        ];

        // Log creation attempt
        log_cashier_transaction('adjustment', 'create', null, $form_data, [], true, 'Creating shift adjustment');

        $response = $this->Adjustmentinfo->createAdjustment($this->api_token, $form_data);
        
        if ($response && isset($response['status']) && $response['status']) {
            $entity_id = isset($response['data']['id']) ? $response['data']['id'] : null;
            log_cashier_transaction('adjustment', 'create', $entity_id, $form_data, [], true, 'Shift adjustment created successfully');
        } else {
            log_cashier_transaction('adjustment', 'create', null, $form_data, [], false, 'Failed to create shift adjustment');
        }
        
        echo json_encode($response);
    }

    public function update($id) {
        // Get current data before update
        $current_response = $this->Adjustmentinfo->getAdjustmentById($this->api_token, $id);
        $current_data = isset($current_response['data']) ? $current_response['data'] : $current_response;
        
        $form_data = [
            'amount'  => $this->input->post('amount'),
            'remarks' => $this->input->post('remarks')
        ];

        // Log update attempt
        log_cashier_transaction('adjustment', 'update', $id, $form_data, $current_data, true, 'Updating shift adjustment');

        $response = $this->Adjustmentinfo->updateAdjustment($this->api_token, $id, $form_data);
        
        if ($response && isset($response['status']) && $response['status']) {
            log_cashier_transaction('adjustment', 'update', $id, $form_data, $current_data, true, 'Shift adjustment updated successfully');
        } else {
            log_cashier_transaction('adjustment', 'update', $id, $form_data, $current_data, false, 'Failed to update shift adjustment');
        }
        
        echo json_encode($response);
    }

    public function delete($id) {
        // Get current data before deletion
        $current_response = $this->Adjustmentinfo->getAdjustmentById($this->api_token, $id);
        $current_data = isset($current_response['data']) ? $current_response['data'] : $current_response;
        
        // Log deletion attempt
        log_cashier_transaction('adjustment', 'delete', $id, [], $current_data, true, 'Deleting shift adjustment');

        $response = $this->Adjustmentinfo->deleteAdjustment($this->api_token, $id);
        
        if ($response && isset($response['status']) && $response['status']) {
            log_cashier_transaction('adjustment', 'delete', $id, [], $current_data, true, 'Shift adjustment deleted successfully');
        } else {
            log_cashier_transaction('adjustment', 'delete', $id, [], $current_data, false, 'Failed to delete shift adjustment');
        }
        
        echo json_encode($response);
    }

    public function datatable() {
        // Get all POST data from DataTables request
        $postData = $this->input->post();
        $response = $this->Adjustmentinfo->getAdjustmentsDatatable($this->api_token, $postData);
        echo json_encode($response);
    }
}

