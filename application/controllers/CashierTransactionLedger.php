<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CashierTransactionLedger extends CI_Controller {
    protected $api_token;
    protected $auth_user;

    public function __construct() {
        parent::__construct();
        $this->load->helper('api_helper');
        $this->load->model('Cashier/TransactionLedgerinfo');

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
        
        // Get active shift ID
        $active_shift_id = null;
        if (isset($check_cashier_shift_response['status']) && $check_cashier_shift_response['status'] === true && isset($check_cashier_shift_response['shift']['id'])) {
            $active_shift_id = $check_cashier_shift_response['shift']['id'];
        }
        
        $result['menuaccess'] = json_decode(json_encode($this->Commeninfo->getMenuPrivilege($this->api_token,'')['data'] ?? []));
        $result['check_cashier_shift'] = $check_cashier_shift_response;
        $result['active_shift_id'] = $active_shift_id;

        $this->load->view('Cashier/TransactionLedger', $result);
    }

    public function getTransactionLedgers() {
        $this->load->helper('api_helper');
        
        // Get current user's active shift
        $active_shift = get_current_user_active_shift($this->api_token);
        
        // Get transactions for current user's active shift
        $params = [];
        if ($active_shift) {
            $params['shift_id'] = $active_shift['id'];
        }
        
        $response = $this->TransactionLedgerinfo->getTransactionLedgers($this->api_token, $params);
        echo json_encode($response);
    }

    public function getByShift($shiftId) {
        $response = $this->TransactionLedgerinfo->getByShift($this->api_token, $shiftId);
        echo json_encode($response);
    }

    public function getReversals() {
        $response = $this->TransactionLedgerinfo->getReversals($this->api_token);
        echo json_encode($response);
    }

    public function getTransactionById($id) {
        $response = $this->TransactionLedgerinfo->getTransactionById($this->api_token, $id);
        echo json_encode($response);
    }

    public function reverseTransaction($id) {
        $this->load->helper('api_helper');
        
        $reversal_reason = $this->input->post('reversal_reason');
        
        if (empty($reversal_reason)) {
            echo json_encode([
                'status' => false,
                'message' => 'Reversal reason is required',
                'code' => 400
            ]);
            return;
        }
        
        // Log reversal attempt
        $current_response = $this->TransactionLedgerinfo->getTransactionById($this->api_token, $id);
        $current_data = isset($current_response['data']) ? $current_response['data'] : $current_response;
        log_cashier_transaction('transaction_ledger', 'reverse', $id, ['reversal_reason' => $reversal_reason], $current_data, true, 'Reversing transaction');
        
        $response = $this->TransactionLedgerinfo->reverseTransaction($this->api_token, $id, $reversal_reason);
        
        if ($response && isset($response['status']) && $response['status']) {
            // Log successful reversal
            log_cashier_transaction('transaction_ledger', 'reverse', $id, ['reversal_reason' => $reversal_reason], $current_data, true, 'Transaction reversed successfully');
        } else {
            // Log failure
            log_cashier_transaction('transaction_ledger', 'reverse', $id, ['reversal_reason' => $reversal_reason], $current_data, false, 'Failed to reverse transaction');
        }
        
        echo json_encode($response);
    }

    /**
     * DataTables server-side processing endpoint
     */
    public function datatable() {
        $this->load->helper('api_helper');
        $this->load->model('Cashier/Shiftinfo');
        
        // Get all DataTables parameters
        $draw = $this->input->post('draw');
        $start = $this->input->post('start');
        $length = $this->input->post('length');
        $search = $this->input->post('search');
        $order = $this->input->post('order');
        
        // Get shift_id from POST or use current active shift
        $shift_id = $this->input->post('shift_id');
        
        // If no shift_id provided, get current active shift
        if (empty($shift_id)) {
            $check_cashier_shift_response = $this->Shiftinfo->checkCashierShift($this->api_token, []);
            if (isset($check_cashier_shift_response['status']) && $check_cashier_shift_response['status'] === true && isset($check_cashier_shift_response['shift']['id'])) {
                $shift_id = $check_cashier_shift_response['shift']['id'];
            }
        }
        
        // Optional filters
        $doc_type = $this->input->post('doc_type');
        $transaction_type = $this->input->post('transaction_type');
        $payment_method = $this->input->post('payment_method');
        $status = $this->input->post('status');
        $date_from = $this->input->post('date_from');
        $date_to = $this->input->post('date_to');
        $include_temp = $this->input->post('include_temp'); // Secret code toggle
        
        // Prepare parameters
        $datatable_params = [
            'draw' => $draw,
            'start' => $start,
            'length' => $length,
            'search' => $search,
            'order' => $order,
            'shift_id' => $shift_id,
            'doc_type' => $doc_type,
            'transaction_type' => $transaction_type,
            'payment_method' => $payment_method,
            'status' => $status,
            'date_from' => $date_from,
            'date_to' => $date_to,
            'include_temp' => $include_temp
        ];
        
        $response = $this->TransactionLedgerinfo->getTransactionLedgersDatatable($this->api_token, $datatable_params);
        echo json_encode($response);
    }

    /**
     * Get unsynced approved payments (payments not yet in transaction ledger)
     */
    public function getUnsyncedPayments() {
        $this->load->helper('api_helper');
        $this->load->model('Cashier/Shiftinfo');
        
        $shift_id = $this->input->post('shift_id');
        
        // If no shift_id provided, get current active shift
        if (empty($shift_id)) {
            $check_cashier_shift_response = $this->Shiftinfo->checkCashierShift($this->api_token, []);
            if (isset($check_cashier_shift_response['status']) && $check_cashier_shift_response['status'] === true && isset($check_cashier_shift_response['shift']['id'])) {
                $shift_id = $check_cashier_shift_response['shift']['id'];
            }
        }
        
        if (empty($shift_id)) {
            echo json_encode([
                'status' => false,
                'message' => 'No active shift found',
                'code' => 400
            ]);
            return;
        }
        
        $response = $this->TransactionLedgerinfo->getUnsyncedPayments($this->api_token, $shift_id);
        echo json_encode($response);
    }

    /**
     * Sync selected payments to transaction ledger
     */
    public function syncPayments() {
        $this->load->helper('api_helper');
        $this->load->model('Cashier/Shiftinfo');
        
        $shift_id = $this->input->post('shift_id');
        $receipt_ids = $this->input->post('receipt_ids');
        
        if (empty($shift_id)) {
            $check_cashier_shift_response = $this->Shiftinfo->checkCashierShift($this->api_token, []);
            if (isset($check_cashier_shift_response['status']) && $check_cashier_shift_response['status'] === true && isset($check_cashier_shift_response['shift']['id'])) {
                $shift_id = $check_cashier_shift_response['shift']['id'];
            }
        }
        
        if (empty($shift_id)) {
            echo json_encode([
                'status' => false,
                'message' => 'No active shift found',
                'code' => 400
            ]);
            return;
        }
        
        if (empty($receipt_ids) || !is_array($receipt_ids)) {
            echo json_encode([
                'status' => false,
                'message' => 'No payments selected',
                'code' => 400
            ]);
            return;
        }
        
        $response = $this->TransactionLedgerinfo->syncPayments($this->api_token, $shift_id, $receipt_ids);
        echo json_encode($response);
    }
}

