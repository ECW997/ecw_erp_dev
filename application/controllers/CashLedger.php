<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CashLedger extends CI_Controller {
    protected $api_token;
    protected $auth_user;

    public function __construct() {
        parent::__construct();
        $this->load->helper('api_helper');
        $this->load->model('Cashierinfo');

		$auth_info = auth_check();
		$this->api_token = $auth_info['api_token'];
		$this->auth_user = $auth_info['user'];
    }

    public function index(){
		$this->load->model('Commeninfo');
		$check_cashier_shift_response = $this->Cashierinfo->checkCashierShift($this->api_token, []);

		$result['menuaccess'] = json_decode(json_encode($this->Commeninfo->getMenuPrivilege($this->api_token,'')['data'] ?? []));
		$result['check_cashier_shift'] = $check_cashier_shift_response;

		$this->load->view('cashier', $result);

	}
    
    public function checkCashierShift() {
        $response = $this->Cashierinfo->checkCashierShift($this->api_token,[]);
		echo json_encode($response);
    }

    public function startCashierShift() {
		$form_data = [
            'opening_balance_cash' => $this->input->post('opening_balance_cash'),
			'opening_balance_slips' => $this->input->post('opening_balance_slips'),
            'opening_balance_cheques' => $this->input->post('opening_balance_cheques')
        ];

        $response = $this->Cashierinfo->startCashierShift($this->api_token,$form_data);

		if ($response) {
            echo json_encode($response);
		}else{
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect();
		}
    }

    public function closeCashierShift() {
        $check_cashier_shift = $this->Cashierinfo->checkCashierShift($this->api_token,[]);

        if (!$check_cashier_shift['status']) {
            echo json_encode(['status' => false, 'message' => 'No active shift found']);
            return;
        }

        $data = [
            'recordID' => $check_cashier_shift['shift']['id'],
            'closing_balance_cash' => $this->input->post('cash'),
            'closing_balance_slips' => $this->input->post('slips'),
            'closing_balance_cheques' => $this->input->post('cheques'),
            'closed_at' => date('Y-m-d H:i:s')
        ];

        $response = $this->Cashierinfo->closeCashierShift($this->api_token, $data);

        if ($response) {
            echo json_encode($response);
        } else {
           	$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect();
        }
    }

    public function getCashierShiftRecDetails($id) {
        $response = $this->Cashierinfo->getCashierShiftRecDetails($this->api_token,$id);
		echo json_encode($response);
    }

    public function updateShiftOpeningBalances() {
        $check_cashier_shift = $this->Cashierinfo->checkCashierShift($this->api_token,[]);

        if (!$check_cashier_shift['status']) {
            echo json_encode(['status' => false, 'message' => 'No active shift found']);
            return;
        }

        $data = [
            'recordID' => $check_cashier_shift['shift']['id'],
            'opening_balance_cash' => $this->input->post('input_opening_balance_cash'),
            'opening_balance_slips' => $this->input->post('input_opening_balance_slips'),
            'opening_balance_cheques' => $this->input->post('input_opening_balance_cheques')
        ];

        $response = $this->Cashierinfo->updateShiftOpeningBalances($this->api_token, $data);

        if ($response) {
            echo json_encode($response);
        } else {
           	$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect();
        }
    }

    public function approveShiftOpeningBalances() {
        $data = [
            'recordID' => $this->input->post('record_id')
        ];

        $response = $this->Cashierinfo->approveShiftOpeningBalances($this->api_token, $data);

        if ($response) {
            echo json_encode($response);
        } else {
           	$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect();
        }
    }

}

?>