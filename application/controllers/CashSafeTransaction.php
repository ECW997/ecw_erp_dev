<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CashSafeTransaction extends CI_Controller {
    protected $api_token;
    protected $auth_user;

    public function __construct() {
        parent::__construct();
        $this->load->helper('api_helper');
        $this->load->model('Cashier/CashSafeTransactioninfo');

        $auth_info = auth_check();
        $this->api_token = $auth_info['api_token'];
        $this->auth_user = $auth_info['user'];
    }

    public function index(){
        $this->load->model('Commeninfo');
        $result['menuaccess'] = json_decode(json_encode($this->Commeninfo->getMenuPrivilege($this->api_token,'')['data'] ?? []));

        // Get options for dropdowns
        $options_response = $this->CashSafeTransactioninfo->getCashSafeTransactionOptions($this->api_token);
        $result['options'] = $options_response['success'] ? $options_response['data'] : [];

        // Get current shift info and active shift ID
        $this->load->model('Cashier/Shiftinfo');
        $check_cashier_shift_response = $this->Shiftinfo->checkCashierShift($this->api_token, []);

        // Get active shift ID for auto-selection
        $active_shift_id = null;
        if (isset($check_cashier_shift_response['status']) && $check_cashier_shift_response['status'] === true && isset($check_cashier_shift_response['shift']['id'])) {
            $active_shift_id = $check_cashier_shift_response['shift']['id'];
        }

        $result['check_cashier_shift'] = $check_cashier_shift_response;
        $result['active_shift_id'] = $active_shift_id;

        $this->load->view('Cashier/CashSafeTransaction', $result);
    }

    public function getAll() {
        $params = $this->input->get();
        $response = $this->CashSafeTransactioninfo->getAllCashSafeTransactions($this->api_token, $params);
        echo json_encode($response);
    }

    public function datatable() {
        $params = $this->input->post();
        $response = $this->CashSafeTransactioninfo->getCashSafeTransactionDatatable($this->api_token, $params);
        echo json_encode($response);
    }

    public function getById($id) {
        $response = $this->CashSafeTransactioninfo->getCashSafeTransaction($this->api_token, $id);
        echo json_encode($response);
    }

    public function create() {
        $form_data = [
            'transaction_type' => $this->input->post('transaction_type'),
            'amount' => $this->input->post('amount'),
            'input_method' => $this->input->post('input_method'),
            'remarks' => $this->input->post('remarks'),
            'transaction_date' => $this->input->post('transaction_date'),
            'shift_id' => $this->input->post('shift_id'),
            'status' => $this->input->post('status'),
            'reference_transaction_id' => $this->input->post('reference_transaction_id'),
            'is_confirm' => $this->input->post('is_confirm')
        ];

        // Add cheque fields if input method is cheque
        if ($form_data['input_method'] === 'cheque') {
            $form_data['cheque_no'] = $this->input->post('cheque_no');
            $form_data['bank'] = $this->input->post('bank');
            $form_data['cheque_date'] = $this->input->post('cheque_date');
            $form_data['job_card_no'] = $this->input->post('job_card_no');
        }

        // Add conditional fields based on transaction type
        if ($form_data['transaction_type'] === 'cash_in') {
            $form_data['added_by'] = $this->input->post('added_by');
        } elseif ($form_data['transaction_type'] === 'cash_out') {
            $form_data['out_by'] = $this->input->post('out_by');
        }

        // Log transaction creation attempt
        log_cashier_transaction('cash_safe', 'create', null, $form_data, [], true, 'Creating cash safe transaction');

        $response = $this->CashSafeTransactioninfo->createCashSafeTransaction($this->api_token, $form_data);

        if ($response && isset($response['success']) && $response['success']) {
            // Log successful creation
            $transaction_id = isset($response['data']['id']) ? $response['data']['id'] : null;
            log_cashier_transaction('cash_safe', 'create', $transaction_id, $form_data, [], true, 'Cash safe transaction created successfully');
        }

        echo json_encode($response);
    }

    public function update($id) {
        $form_data = [
            'transaction_type' => $this->input->post('transaction_type'),
            'amount' => $this->input->post('amount'),
            'input_method' => $this->input->post('input_method'),
            'remarks' => $this->input->post('remarks'),
            'transaction_date' => $this->input->post('transaction_date'),
            'shift_id' => $this->input->post('shift_id')
        ];

        // Add cheque fields if input method is cheque or if being updated
        $input_method = $this->input->post('input_method');
        if ($input_method === 'cheque' || $this->input->post('cheque_no')) {
            $form_data['cheque_no'] = $this->input->post('cheque_no');
            $form_data['bank'] = $this->input->post('bank');
            $form_data['cheque_date'] = $this->input->post('cheque_date');
            $form_data['job_card_no'] = $this->input->post('job_card_no');
        }

        // Add conditional fields based on transaction type
        if ($form_data['transaction_type'] === 'cash_in') {
            $form_data['added_by'] = $this->input->post('added_by');
        } elseif ($form_data['transaction_type'] === 'cash_out') {
            $form_data['out_by'] = $this->input->post('out_by');
        }

        // Log transaction update attempt
        log_cashier_transaction('cash_safe', 'update', $id, $form_data, [], true, 'Updating cash safe transaction');

        $response = $this->CashSafeTransactioninfo->updateCashSafeTransaction($this->api_token, $id, $form_data);

        if ($response && isset($response['success']) && $response['success']) {
            // Log successful update
            log_cashier_transaction('cash_safe', 'update', $id, $form_data, [], true, 'Cash safe transaction updated successfully');
        }

        echo json_encode($response);
    }

    public function delete($id) {
        // Get transaction details before deletion for logging
        $transaction_response = $this->CashSafeTransactioninfo->getCashSafeTransaction($this->api_token, $id);
        $old_data = isset($transaction_response['data']) ? $transaction_response['data'] : [];

        // Log deletion attempt
        log_cashier_transaction('cash_safe', 'delete', $id, [], $old_data, true, 'Deleting cash safe transaction');

        $response = $this->CashSafeTransactioninfo->deleteCashSafeTransaction($this->api_token, $id);

        if ($response && isset($response['success']) && $response['success']) {
            // Log successful deletion
            log_cashier_transaction('cash_safe', 'delete', $id, [], $old_data, true, 'Cash safe transaction deleted successfully');
        }

        echo json_encode($response);
    }

    public function confirm($id) {
        // Log confirmation attempt
        log_cashier_transaction('cash_safe', 'confirm', $id, [], [], true, 'Confirming cash safe transaction');

        $response = $this->CashSafeTransactioninfo->confirmCashSafeTransaction($this->api_token, $id);

        if ($response && isset($response['success']) && $response['success']) {
            // Log successful confirmation
            log_cashier_transaction('cash_safe', 'confirm', $id, [], [], true, 'Cash safe transaction confirmed successfully');
        }

        echo json_encode($response);
    }

    public function approve($id) {
        // Log approval attempt
        log_cashier_transaction('cash_safe', 'approve', $id, [], [], true, 'Approving cash safe transaction');

        $response = $this->CashSafeTransactioninfo->approveCashSafeTransaction($this->api_token, $id);

        if ($response && isset($response['success']) && $response['success']) {
            // Log successful approval
            log_cashier_transaction('cash_safe', 'approve', $id, [], [], true, 'Cash safe transaction approved successfully');
        }

        echo json_encode($response);
    }

    public function cancel($id) {
        // Log cancellation attempt
        log_cashier_transaction('cash_safe', 'cancel', $id, [], [], true, 'Cancelling cash safe transaction');

        $response = $this->CashSafeTransactioninfo->cancelCashSafeTransaction($this->api_token, $id);

        if ($response && isset($response['success']) && $response['success']) {
            // Log successful cancellation
            log_cashier_transaction('cash_safe', 'cancel', $id, [], [], true, 'Cash safe transaction cancelled successfully');
        }

        echo json_encode($response);
    }

    public function getSummary() {
        $params = $this->input->get();
        $response = $this->CashSafeTransactioninfo->getCashSafeTransactionSummary($this->api_token, $params);
        echo json_encode($response);
    }

    public function getOptions() {
        $response = $this->CashSafeTransactioninfo->getCashSafeTransactionOptions($this->api_token);
        echo json_encode($response);
    }
}
