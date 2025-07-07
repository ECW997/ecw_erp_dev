<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Invoice extends CI_Controller {
	protected $api_token;
    protected $auth_user;

    public function __construct() {
        parent::__construct();
		$this->load->helper('api_helper');
        $this->load->model('Invoiceinfo');

		$auth_info = auth_check();
		$this->api_token = $auth_info['api_token'];
		$this->auth_user = $auth_info['user'];
    }

	public function getDirectSalesItem(){
		$form_data = [
			'term' => $this->input->get('term'),
			'page' => $this->input->get('page'),
		];

		$response = $this->Invoiceinfo->getDirectSalesItem($this->api_token,$form_data);
		echo json_encode($response);
	}

	public function index(){
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('invoiceList', $result);
	}
	
	public function invoiceDetailIndex($id = null){
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();

        if ($id !== null) {
			
			if($id=='direct'){
				$result['invoice_type'] = 'direct';
				$result['invoice_main_data'] = null;
				$result['invoice_detail_data'] = null;
				$result['extra_charge_data'] = null;
				$result['is_edit'] = false;
			}else if($id=='indirect'){
				$result['invoice_type'] = 'indirect';
				$result['invoice_main_data'] = null;
				$result['invoice_detail_data'] = null;
				$result['extra_charge_data'] = null;
				$result['is_edit'] = false;
			}else{
				$result['invoice_main_data'] = $this->Invoiceinfo->getInvoiceById($this->api_token,$id)['data']['main_data'];
				$result['invoice_detail_data'] = $this->Invoiceinfo->getInvoiceById($this->api_token,$id)['data']['details_data'];
				$result['extra_charge_data'] = $this->Invoiceinfo->getInvoiceById($this->api_token,$id)['data']['extra_charge_data'];
				$result['invoice_type'] = $this->Invoiceinfo->getInvoiceById($this->api_token,$id)['data']['main_data'][0]['invoice_type'];
				$result['is_edit'] = true;
			}
          
        }

		$this->load->view('invoice', $result);
		// $this->load->view('invoice_type', $result);
	}


	public function getJobcardNumbers(){
		$api_token = $this->session->userdata('api_token');

		if (!$api_token) {
			$this->session->set_flashdata(['res' => '401', 'msg' => 'Not authenticated']);
			redirect('Welcome/Logout');
			return;
		}

		$form_data = [
			'term' => $this->input->get('term'),
			'page' => $this->input->get('page'),
		];

		$response = $this->Invoiceinfo->getJobcardNumbers($api_token,$form_data);
		echo json_encode($response);
	}
	


	public function approveInvoice() {
        $api_token = $this->session->userdata('api_token');
        if (!$api_token) {
            $this->session->set_flashdata(['res' => '401', 'msg' => 'Not authenticated']);
            redirect('Welcome/Logout');
            return;
        }

        $form_data = $this->input->post();

		$response = $this->Invoiceinfo->approveInvoice($api_token, $form_data);
 
		if ($response) {
            echo json_encode($response);
		}else{
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('invoice');
		}   
    }

	

	public function getJobCardDetails() {
        $api_token = $this->session->userdata('api_token');
        $id = $this->input->post('job_card_id');

        if (!$api_token || !$id) {
            echo json_encode(['status' => false, 'msg' => 'Missing job card ID or token']);
            return;
        }

        $response = $this->Invoiceinfo->fetchJobCardDetails($api_token, $id);
        echo json_encode($response);
    }

	

	public function getDirectSalesItemDetails($id) {
        $response = $this->Invoiceinfo->getDirectSalesItemDetails($this->api_token,$id);
		echo json_encode($response);
    }

	public function insertORUpdateInvoice() {
		$createOption = $this->input->post('main_insert_status');
		$form_data = [
            'invoiceData' => $this->input->post('invoiceData'),
			'recordID' => $this->input->post('recordID'),
        ];
		
		if($createOption == 'insert'){
			$response = $this->Invoiceinfo->insertInvoice($this->api_token,$form_data);
		}else{
			$response = $this->Invoiceinfo->updateInvoice($this->api_token,$form_data);
		}
 
		if ($response) {
            echo json_encode($response);
		}else{
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('Invoice');
		}
    }

}