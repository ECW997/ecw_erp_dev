<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Payment extends CI_Controller {
	protected $api_token;
    protected $auth_user;

    public function __construct() {
        parent::__construct();
		$this->load->helper('api_helper');
        $this->load->model('Paymentinfo');

		$auth_info = auth_check();
		$this->api_token = $auth_info['api_token'];
		$this->auth_user = $auth_info['user'];
    }

	public function index(){
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('payment', $result);
	}

	public function getCustomer(){
		$form_data = [
			'term' => $this->input->get('term'),
			'page' => $this->input->get('page'),
		];

		$response = $this->Paymentinfo->getCustomer($this->api_token,$form_data);
		echo json_encode($response);
	}

	public function getOutstandingInvoicesByCustomer($id) {
        $response = $this->Paymentinfo->getOutstandingInvoicesByCustomer($this->api_token,$id);
		echo json_encode($response);
    }

	public function insertORUpdatePayment() {
		$form_data = [
            'date' => $this->input->post('date'),
			'invoice_id' => $this->input->post('invoice_id'),
			'payment_option' => $this->input->post('payment_option'),
			'payment' => $this->input->post('payment'),
        ];
		
		$response = $this->Paymentinfo->insertORUpdatePayment($this->api_token,$form_data);
	
		if ($response) {
            echo json_encode($response);
		}else{
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('Invoice');
		}
    }

	public function getAllocatedPayments($id) {
        $response = $this->Paymentinfo->getAllocatedPayments($this->api_token,$id);
		echo json_encode($response);
    }
	
}