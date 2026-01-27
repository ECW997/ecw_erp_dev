<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CashierIouSettlement extends CI_Controller {
    protected $api_token;
    protected $auth_user;

    public function __construct() {
        parent::__construct();
        $this->load->helper('api_helper');
        $this->load->model('Cashier/IouSettlementinfo');

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
        $result['settlements'] = $this->IouSettlementinfo->getSettlements($this->api_token, $shift_id);
        $result['outstanding_ious'] = $this->IouSettlementinfo->getOutstandingIous($this->api_token);
        $result['active_shift'] = $active_shift;

        $this->load->view('Cashier/IouSettlement', $result);
    }

    public function getSettlements() {
        $this->load->helper('api_helper');
        
        // Get current user's active shift automatically
        $active_shift = get_current_user_active_shift($this->api_token);
        $shift_id = $active_shift ? $active_shift['id'] : null;
        
        $response = $this->IouSettlementinfo->getSettlements($this->api_token, $shift_id);
        echo json_encode($response);
    }

    /**
     * DataTables server-side processing endpoint for IOU Settlements
     * Handles pagination, sorting, and filtering with Series 2 support
     */
    public function datatable() {
        // Get all DataTables parameters
        $draw = $this->input->post('draw');
        $start = $this->input->post('start');
        $length = $this->input->post('length');
        $search = $this->input->post('search');
        $order = $this->input->post('order');
        
        // Optional filters
        $cash_movement_id = $this->input->post('cash_movement_id');
        $settlement_type = $this->input->post('settlement_type');
        $include_series2 = $this->input->post('include_series2'); // Include Series 2 when 1
        
        // Prepare parameters
        $datatable_params = [
            'draw' => $draw,
            'start' => $start,
            'length' => $length,
            'search' => $search,
            'order' => $order,
            'cash_movement_id' => $cash_movement_id,
            'settlement_type' => $settlement_type,
            'include_series2' => $include_series2 // Pass to API
        ];
        
        $response = $this->IouSettlementinfo->getSettlementsDatatable($this->api_token, $datatable_params);
        echo json_encode($response);
    }

    public function getOutstandingIous() {
        $response = $this->IouSettlementinfo->getOutstandingIous($this->api_token);
        echo json_encode($response);
    }

    /**
     * DataTables server-side processing endpoint for Outstanding IOUs
     * Handles pagination, sorting, and filtering with Series 2 support
     */
    public function outstandingIousDatatable() {
        // Get all DataTables parameters
        $draw = $this->input->post('draw');
        $start = $this->input->post('start');
        $length = $this->input->post('length');
        $search = $this->input->post('search');
        $order = $this->input->post('order');
        
        // Optional filters
        $shift_id = $this->input->post('shift_id');
        $status = $this->input->post('status');
        $include_series2 = $this->input->post('include_series2'); // Include Series 2 when 1
        
        // Prepare parameters
        $datatable_params = [
            'draw' => $draw,
            'start' => $start,
            'length' => $length,
            'search' => $search,
            'order' => $order,
            'shift_id' => $shift_id,
            'status' => $status,
            'include_series2' => $include_series2 // Pass to API
        ];
        
        $response = $this->IouSettlementinfo->getOutstandingIousDatatable($this->api_token, $datatable_params);
        echo json_encode($response);
    }

    public function createSettlement() {
        // Verify active shift exists (settlements are for IOUs from current shift)
        $this->load->helper('api_helper');
        require_active_shift($this->api_token);
        
        $form_data = [
            'cash_movement_id' => $this->input->post('cash_movement_id'),
            'settlement_type' => $this->input->post('settlement_type'),
            'settlement_amount' => $this->input->post('settlement_amount'),
            'settlement_date' => $this->input->post('settlement_date'),
            'reference_id' => $this->input->post('reference_id'),
            'remarks' => $this->input->post('remarks')
        ];

        // Log settlement creation attempt
        log_cashier_transaction('iou_settlement', 'create', null, $form_data, [], true, 'Creating IOU settlement');

        $response = $this->IouSettlementinfo->createSettlement($this->api_token, $form_data);

        if ($response && isset($response['status']) && $response['status']) {
            $entity_id = isset($response['data']['id']) ? $response['data']['id'] : null;
            log_cashier_transaction('iou_settlement', 'create', $entity_id, $form_data, [], true, 'IOU settlement created successfully');
            echo json_encode($response);
        } else {
            // Return error response with details for frontend display
            $error_message = isset($response['message']) ? $response['message'] : 'Failed to create IOU settlement';
            log_cashier_transaction('iou_settlement', 'create', null, $form_data, [], false, 'Failed to create IOU settlement: ' . $error_message);
            
            $error_response = [
                'status' => false,
                'message' => $error_message
            ];
            
            // Include blockers if present
            if (isset($response['blockers'])) {
                $error_response['blockers'] = $response['blockers'];
            }
            
            // Include warnings if present
            if (isset($response['warnings'])) {
                $error_response['warnings'] = $response['warnings'];
            }
            
            // Include code if present
            if (isset($response['code'])) {
                $error_response['code'] = $response['code'];
            }
            
            echo json_encode($error_response);
        }
    }

    public function updateSettlement($id) {
        // Get current data before update
        $current_response = $this->IouSettlementinfo->getSettlementById($this->api_token, $id);
        $current_data = isset($current_response['data']) ? $current_response['data'] : $current_response;
        
        $form_data = [
            'settlement_amount' => $this->input->post('settlement_amount'),
            'settlement_date' => $this->input->post('settlement_date'),
            'remarks' => $this->input->post('remarks')
        ];

        // Log update attempt
        log_cashier_transaction('iou_settlement', 'update', $id, $form_data, $current_data, true, 'Updating IOU settlement');

        $response = $this->IouSettlementinfo->updateSettlement($this->api_token, $id, $form_data);

        if ($response && isset($response['status']) && $response['status']) {
            log_cashier_transaction('iou_settlement', 'update', $id, $form_data, $current_data, true, 'IOU settlement updated successfully');
            echo json_encode($response);
        } else {
            // Return error response with details for frontend display
            $error_message = isset($response['message']) ? $response['message'] : 'Failed to update IOU settlement';
            log_cashier_transaction('iou_settlement', 'update', $id, $form_data, $current_data, false, 'Failed to update IOU settlement: ' . $error_message);
            
            $error_response = [
                'status' => false,
                'message' => $error_message
            ];
            
            if (isset($response['blockers'])) {
                $error_response['blockers'] = $response['blockers'];
            }
            
            if (isset($response['warnings'])) {
                $error_response['warnings'] = $response['warnings'];
            }
            
            if (isset($response['code'])) {
                $error_response['code'] = $response['code'];
            }
            
            echo json_encode($error_response);
        }
    }

    public function deleteSettlement($id) {
        // Get current data before deletion
        $current_response = $this->IouSettlementinfo->getSettlementById($this->api_token, $id);
        $current_data = isset($current_response['data']) ? $current_response['data'] : $current_response;

        // Log deletion attempt
        log_cashier_transaction('iou_settlement', 'delete', $id, [], $current_data, true, 'Deleting IOU settlement');

        $response = $this->IouSettlementinfo->deleteSettlement($this->api_token, $id);

        if ($response && isset($response['status']) && $response['status']) {
            log_cashier_transaction('iou_settlement', 'delete', $id, [], $current_data, true, 'IOU settlement deleted successfully');
            echo json_encode($response);
        } else {
            // Return error response with details for frontend display
            $error_message = isset($response['message']) ? $response['message'] : 'Failed to delete IOU settlement';
            log_cashier_transaction('iou_settlement', 'delete', $id, [], $current_data, false, 'Failed to delete IOU settlement: ' . $error_message);
            
            $error_response = [
                'status' => false,
                'message' => $error_message
            ];
            
            if (isset($response['blockers'])) {
                $error_response['blockers'] = $response['blockers'];
            }
            
            if (isset($response['warnings'])) {
                $error_response['warnings'] = $response['warnings'];
            }
            
            if (isset($response['code'])) {
                $error_response['code'] = $response['code'];
            }
            
            echo json_encode($error_response);
        }
    }

    public function getSettlementById($id) {
        $response = $this->IouSettlementinfo->getSettlementById($this->api_token, $id);
        echo json_encode($response);
    }
}

