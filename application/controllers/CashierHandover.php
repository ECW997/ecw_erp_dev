<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CashierHandover extends CI_Controller {
    protected $api_token;
    protected $auth_user;

    public function __construct() {
        parent::__construct();
        $this->load->helper('api_helper');
        $this->load->model('CashierHandoverinfo');
        
        $auth_info = auth_check();
		$this->api_token = $auth_info['api_token'];
		$this->auth_user = $auth_info['user'];
    }

    public function index() {
        $this->load->model('Commeninfo');
		$handover_logs_response = $this->CashierHandoverinfo->getHandoverLogs($this->api_token,[]);

		$result['menuaccess'] = json_decode(json_encode($this->Commeninfo->getMenuPrivilege($this->api_token,'')['data'] ?? []));
		$result['handover_logs'] = $handover_logs_response;

        $this->load->view('cashier_handover', $result);
    }

    public function updateHandoverAmount() {
        $data = [
            'recordID' => $this->input->post('id'),
            'actual_cash'      => $this->input->post('actual_cash')
        ];

        $response = $this->CashierHandoverinfo->updateHandoverAmount($this->api_token, $data);

        if ($response) {
            echo json_encode($response);
        } else {
           	$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect();
        }
    }
}
