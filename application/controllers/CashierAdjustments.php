<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CashierAdjustments extends CI_Controller {
    public function index() {
        $result['adjustments'] = $this->Cashierinfo->getAdjustments($this->api_token);
        $this->load->view('cashier_adjustments/index', $result);
    }
    public function add() {
        $data = [
            'cashier_shift_id' => $this->input->post('shift_id'),
            'adjustment_type'  => $this->input->post('type'),
            'amount'           => $this->input->post('amount'),
            'remarks'          => $this->input->post('remarks'),
            'created_by'       => $this->session->userdata('user_id')
        ];
        echo json_encode($this->Cashierinfo->addAdjustment($this->api_token, $data));
    }
}


?>