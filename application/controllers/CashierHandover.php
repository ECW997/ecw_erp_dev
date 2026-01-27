<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CashierHandover extends CI_Controller {
    protected $api_token;
    protected $auth_user;

    public function __construct() {
        parent::__construct();
        $this->load->helper('api_helper');
        $this->load->model('Cashier/Handoverinfo');
        
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
        
        // Get handover logs for current user's shifts (filtered by backend API based on token)
        $handover_logs_response = $this->Handoverinfo->getHandoverLogs($this->api_token,[]);

        $result['menuaccess'] = json_decode(json_encode($this->Commeninfo->getMenuPrivilege($this->api_token,'')['data'] ?? []));
        $result['check_cashier_shift'] = $check_cashier_shift_response;
        $result['handover_logs'] = $handover_logs_response;

        $this->load->view('Cashier/Handover', $result);
    }

    public function getHandoverLogs() {
        // Returns handover logs filtered by current user (handled by backend API)
        // Accept include_series2 parameter to show Series 2 data (is_confirm = 0)
        $include_series2 = $this->input->get('include_series2') ?: 0;
        $params = ['include_series2' => $include_series2];
        $response = $this->Handoverinfo->getHandoverLogs($this->api_token, $params);
        echo json_encode($response);
    }

    public function updateHandoverAmount() {
        $handover_id = $this->input->post('id');
        $data = [
            'recordID' => $handover_id,
            'actual_cash' => $this->input->post('actual_cash')
        ];

        // Get current data before update
        $current_response = $this->Handoverinfo->getHandoverById($this->api_token, $handover_id);
        $current_data = isset($current_response['data']) ? $current_response['data'] : $current_response;

        // Log update attempt
        log_cashier_transaction('handover', 'update_amount', $handover_id, $data, $current_data, true, 'Updating handover amount');

        $response = $this->Handoverinfo->updateHandoverAmount($this->api_token, $data);

        if ($response) {
            log_cashier_transaction('handover', 'update_amount', $handover_id, $data, $current_data, true, 'Handover amount updated successfully');
            echo json_encode($response);
        } else {
            log_cashier_transaction('handover', 'update_amount', $handover_id, $data, $current_data, false, 'Failed to update handover amount: Server error');
            $this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect();
        }
    }

    public function verifyHandover() {
        $handover_id = $this->input->post('record_id');
        $data = [
            'recordID' => $handover_id,
            'actual_cash' => $this->input->post('actual_cash'),
            'remarks' => $this->input->post('remarks')
        ];

        // Get current data before verification
        $current_response = $this->Handoverinfo->getHandoverById($this->api_token, $handover_id);
        $current_data = isset($current_response['data']) ? $current_response['data'] : $current_response;

        // Log verification attempt
        log_cashier_transaction('handover', 'verify', $handover_id, $data, $current_data, true, 'Verifying cash handover');

        $response = $this->Handoverinfo->verifyHandover($this->api_token, $data);

        if ($response) {
            log_cashier_transaction('handover', 'verify', $handover_id, $data, $current_data, true, 'Cash handover verified successfully');
            echo json_encode($response);
        } else {
            log_cashier_transaction('handover', 'verify', $handover_id, $data, $current_data, false, 'Failed to verify handover: Server error');
            $this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect();
        }
    }

    public function generateVoucher($id) {
        // Log voucher generation
        log_cashier_transaction('handover', 'generate_voucher', $id, [], [], true, 'Generating handover voucher');

        $response = $this->Handoverinfo->generateVoucher($this->api_token, $id);

        if ($response && isset($response['status']) && $response['status']) {
            log_cashier_transaction('handover', 'generate_voucher', $id, [], [], true, 'Handover voucher generated successfully');
        } else {
            log_cashier_transaction('handover', 'generate_voucher', $id, [], [], false, 'Failed to generate voucher');
        }

        echo json_encode($response);
    }

    public function datatable() {
        // Get all POST data from DataTables request
        $postData = $this->input->post();
        $response = $this->Handoverinfo->getHandoverLogsDatatable($this->api_token, $postData);
        echo json_encode($response);
    }
}
