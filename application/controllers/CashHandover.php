<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CashHandover extends CI_Controller {
    protected $api_token;

    public function __construct() {
        parent::__construct();
        $this->load->model('Cashierinfo');
        $auth_info = auth_check();
        $this->api_token = $auth_info['api_token'];
    }

    public function index() {
        $result['handover_logs'] = $this->Cashierinfo->getHandoverLogs($this->api_token);
        $this->load->view('cashier_handover/index', $result);
    }

    public function declare() {
        $data = [
            'cashier_shift_id' => $this->input->post('shift_id'),
            'actual_cash'      => $this->input->post('actual_cash'),
            'declared_by'      => $this->session->userdata('user_id'),
            'declared_at'      => date('Y-m-d H:i:s')
        ];
        echo json_encode($this->Cashierinfo->declareCashHandover($this->api_token, $data));
    }

    public function verify() {
        $data = [
            'id' => $this->input->post('handover_id'),
            'verified_by' => $this->session->userdata('user_id'),
            'verified_at' => date('Y-m-d H:i:s')
        ];
        echo json_encode($this->Cashierinfo->verifyCashHandover($this->api_token, $data));
    }
}
