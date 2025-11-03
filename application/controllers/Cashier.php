<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cashier extends CI_Controller {
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