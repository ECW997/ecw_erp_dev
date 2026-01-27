<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CashierShift extends CI_Controller {
    protected $api_token;
    protected $auth_user;

    public function __construct() {
        parent::__construct();
        $this->load->helper('api_helper');
        $this->load->model('Cashier/Shiftinfo');

        $auth_info = auth_check();
        $this->api_token = $auth_info['api_token'];
        $this->auth_user = $auth_info['user'];
    }

    public function index(){
        $this->load->model('Commeninfo');
        $check_cashier_shift_response = $this->Shiftinfo->checkCashierShift($this->api_token, []);

        $result['menuaccess'] = json_decode(json_encode($this->Commeninfo->getMenuPrivilege($this->api_token,'')['data'] ?? []));
        $result['check_cashier_shift'] = $check_cashier_shift_response;

        $this->load->view('Cashier/Shift', $result);
    }

    public function checkCashierShift() {
        $response = $this->Shiftinfo->checkCashierShift($this->api_token,[]);
        echo json_encode($response);
    }

    public function startCashierShift() {
        $form_data = [
            'opening_cash_series_1' => $this->input->post('opening_cash_series_1'),
            'opening_cash_series_2' => $this->input->post('opening_cash_series_2'),
            'opening_balance_slips' => $this->input->post('opening_balance_slips'),
            'opening_balance_cheques' => $this->input->post('opening_balance_cheques'),
            'opening_balance_cash' => $this->input->post('opening_cash_series_1') + $this->input->post('opening_cash_series_2'),
            'opening_balance_manual_cash' => $this->input->post('opening_balance_manual_cash')
        ];

        // Log shift start attempt
        log_cashier_transaction('shift', 'create', null, $form_data, [], true, 'Starting new cashier shift');

        $response = $this->Shiftinfo->startCashierShift($this->api_token,$form_data);

        if ($response) {
            // Log successful shift creation
            $shift_id = isset($response['data']['id']) ? $response['data']['id'] : null;
            log_cashier_transaction('shift', 'create', $shift_id, $form_data, [], true, 'Cashier shift started successfully');
            echo json_encode($response);
        }else{
            // Log failure
            log_cashier_transaction('shift', 'create', null, $form_data, [], false, 'Failed to start cashier shift: Server error');
            $this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect();
        }
    }

    public function closeCashierShift() {
        $check_cashier_shift = $this->Shiftinfo->checkCashierShift($this->api_token,[]);

        if (!$check_cashier_shift['status']) {
            log_cashier_transaction('shift', 'close', null, [], [], false, 'Failed to close shift: No active shift found');
            echo json_encode(['status' => false, 'message' => 'No active shift found']);
            return;
        }

        $shift_id = $check_cashier_shift['shift']['id'];
        $old_data = $check_cashier_shift['shift'];

        $data = [
            'recordID' => $shift_id,
            'closing_cash_series_1' => $this->input->post('closing_cash_series_1'),
            'closing_cash_series_2' => $this->input->post('closing_cash_series_2'),
            'closing_balance_cash' => $this->input->post('closing_cash_series_1') + $this->input->post('closing_cash_series_2'),
            'closing_balance_manual_cash' => $this->input->post('closing_manual_cash'),
            'closing_balance_slips' => $this->input->post('closing_slips'),
            'closing_balance_cheques' => $this->input->post('closing_cheques'),
            'closed_at' => date('Y-m-d H:i:s')
        ];

        // Log shift close attempt
        log_cashier_transaction('shift', 'close', $shift_id, $data, $old_data, true, 'Closing cashier shift');

        $response = $this->Shiftinfo->closeCashierShift($this->api_token, $data);

        if ($response) {
            // Log successful shift close
            log_cashier_transaction('shift', 'close', $shift_id, $data, $old_data, true, 'Cashier shift closed successfully');
            echo json_encode($response);
        } else {
            // Log failure
            log_cashier_transaction('shift', 'close', $shift_id, $data, $old_data, false, 'Failed to close shift: Server error');
            $this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect();
        }
    }

    public function getCashierShiftRecDetails($id) {
        $response = $this->Shiftinfo->getCashierShiftRecDetails($this->api_token,$id);
        echo json_encode($response);
    }

    /**
     * Get real-time cash progress for active shift
     */
    /**
     * Get suggested opening balance based on previous shift's closing balance
     */
    public function getSuggestedOpeningBalance() {
        $response = $this->Shiftinfo->getSuggestedOpeningBalance($this->api_token);
        echo json_encode($response);
    }

    /**
     * Get real-time cash progress for active shift
     */
    public function getRealTimeCashProgress($shift_id) {
        $response = $this->Shiftinfo->getRealTimeCashProgress($this->api_token, $shift_id);
        echo json_encode($response);
    }

    public function updateShiftOpeningBalances() {
        $check_cashier_shift = $this->Shiftinfo->checkCashierShift($this->api_token,[]);

        if (!$check_cashier_shift['status']) {
            log_cashier_transaction('shift', 'update_opening', null, [], [], false, 'Failed: No active shift found');
            echo json_encode(['status' => false, 'message' => 'No active shift found']);
            return;
        }

        $shift_id = $check_cashier_shift['shift']['id'];
        $old_data = [
            'opening_balance_cash_main' => $check_cashier_shift['shift']['opening_balance_cash_main'] ?? 0,
            'opening_balance_cash_petty' => $check_cashier_shift['shift']['opening_balance_cash_petty'] ?? 0,
            'opening_balance_cash' => $check_cashier_shift['shift']['opening_balance_cash'] ?? 0,
            'opening_balance_manual_cash' => $check_cashier_shift['shift']['opening_balance_manual_cash'] ?? 0,
            'opening_balance_slips' => $check_cashier_shift['shift']['opening_balance_slips'] ?? 0,
            'opening_balance_cheques' => $check_cashier_shift['shift']['opening_balance_cheques'] ?? 0
        ];

        $data = [
            'recordID' => $shift_id,
            'opening_cash_series_1' => $this->input->post('input_opening_cash_series_1'),
            'opening_cash_series_2' => $this->input->post('input_opening_cash_series_2'),
            'opening_balance_cash' => $this->input->post('input_opening_cash_series_1') + $this->input->post('input_opening_cash_series_2'),
            'opening_balance_manual_cash' => $this->input->post('input_opening_balance_manual_cash'),
            'opening_balance_slips' => $this->input->post('input_opening_balance_slips'),
            'opening_balance_cheques' => $this->input->post('input_opening_balance_cheques')
        ];

        // Log update attempt
        log_cashier_transaction('shift', 'update_opening', $shift_id, $data, $old_data, true, 'Updating shift opening balances');

        $response = $this->Shiftinfo->updateShiftOpeningBalances($this->api_token, $data);

        if ($response) {
            log_cashier_transaction('shift', 'update_opening', $shift_id, $data, $old_data, true, 'Shift opening balances updated successfully');
            echo json_encode($response);
        } else {
            log_cashier_transaction('shift', 'update_opening', $shift_id, $data, $old_data, false, 'Failed to update opening balances: Server error');
            $this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect();
        }
    }

    public function approveShiftOpeningBalances() {
        $shift_id = $this->input->post('record_id');
        $data = [
            'recordID' => $shift_id
        ];

        // Log approval attempt
        log_cashier_transaction('shift', 'approve_opening', $shift_id, $data, [], true, 'Approving shift opening balances');

        $response = $this->Shiftinfo->approveShiftOpeningBalances($this->api_token, $data);

        if ($response) {
            log_cashier_transaction('shift', 'approve_opening', $shift_id, $data, [], true, 'Shift opening balances approved successfully');
            echo json_encode($response);
        } else {
            log_cashier_transaction('shift', 'approve_opening', $shift_id, $data, [], false, 'Failed to approve opening balances: Server error');
            $this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect();
        }
    }

    public function verifyClosingBalance() {
        $shift_id = $this->input->post('record_id');
        $data = [
            'recordID' => $shift_id
        ];

        // Log verification attempt
        log_cashier_transaction('shift', 'verify_closing', $shift_id, $data, [], true, 'Verifying shift closing balance');

        $response = $this->Shiftinfo->verifyClosingBalance($this->api_token, $data);

        if ($response) {
            log_cashier_transaction('shift', 'verify_closing', $shift_id, $data, [], true, 'Shift closing balance verified successfully');
            echo json_encode($response);
        } else {
            log_cashier_transaction('shift', 'verify_closing', $shift_id, $data, [], false, 'Failed to verify closing balance: Server error');
            $this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect();
        }
    }

    public function updateClosingBalance() {
        $shift_id = $this->input->post('record_id');
        $data = [
            'recordID' => $shift_id,
            'closing_balance_cash' => $this->input->post('closing_balance_cash'),
            'closing_balance_slips' => $this->input->post('closing_balance_slips'),
            'closing_balance_cheques' => $this->input->post('closing_balance_cheques'),
            'remarks' => $this->input->post('remarks')
        ];

        // Get current data before update
        $current_data = $this->Shiftinfo->getCashierShiftRecDetails($this->api_token, $shift_id);
        $old_data = [];
        if (isset($current_data['data'])) {
            $old_data = [
                'closing_balance_cash' => $current_data['data']['closing_balance_cash'] ?? 0,
                'closing_balance_slips' => $current_data['data']['closing_balance_slips'] ?? 0,
                'closing_balance_cheques' => $current_data['data']['closing_balance_cheques'] ?? 0
            ];
        }

        // Log update attempt
        log_cashier_transaction('shift', 'update_closing', $shift_id, $data, $old_data, true, 'Updating shift closing balance');

        $response = $this->Shiftinfo->updateClosingBalance($this->api_token, $data);

        if ($response) {
            log_cashier_transaction('shift', 'update_closing', $shift_id, $data, $old_data, true, 'Shift closing balance updated successfully');
            echo json_encode($response);
        } else {
            log_cashier_transaction('shift', 'update_closing', $shift_id, $data, $old_data, false, 'Failed to update closing balance: Server error');
            $this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect();
        }
    }

    public function getAllCashierLog() {
        $response = $this->Shiftinfo->getAllCashierLog($this->api_token, $this->input->get());
        echo json_encode($response);
    }
}
