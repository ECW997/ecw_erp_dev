<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CashierShift extends CI_Controller {
    protected $api_token;
    protected $auth_user;

    public function __construct() {
        parent::__construct();
        $this->load->model('Cashierinfo');
        $auth_info = auth_check();
        $this->api_token = $auth_info['api_token'];
        $this->auth_user = $auth_info['user'];
    }

    public function index() {
        $result['check_cashier_shift'] = $this->Cashierinfo->checkCashierShift($this->api_token, []);
        $this->load->view('cashier_shift/index', $result);
    }

    public function start() {
        $data = [
            'opening_balance_cash' => $this->input->post('cash'),
            'opening_balance_slips' => $this->input->post('slips'),
            'opening_balance_cheques' => $this->input->post('cheques')
        ];
        echo json_encode($this->Cashierinfo->startCashierShift($this->api_token, $data));
    }

    public function close() {
        $shift = $this->Cashierinfo->checkCashierShift($this->api_token,[]);
        if (!$shift['status']) {
            echo json_encode(['status' => false, 'message' => 'No active shift']);
            return;
        }
        $data = [
            'recordID' => $shift['shift']['id'],
            'closing_balance_cash' => $this->input->post('cash'),
            'closing_balance_slips' => $this->input->post('slips'),
            'closing_balance_cheques' => $this->input->post('cheques'),
            'closed_at' => date('Y-m-d H:i:s')
        ];
        echo json_encode($this->Cashierinfo->closeCashierShift($this->api_token, $data));
    }
}
