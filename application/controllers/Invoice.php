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
		$result['menuaccess'] = json_decode(json_encode($this->Commeninfo->getMenuPrivilege($this->api_token,'')['data'] ?? []));
		$this->load->view('invoiceList', $result);
	}
	
	public function invoiceDetailIndex($id = null){
		$this->load->model('Commeninfo');
		$result['menuaccess'] = json_decode(json_encode($this->Commeninfo->getMenuPrivilege($this->api_token,'')['data'] ?? []));

        if ($id !== null) {
			
			if($id=='direct'){
				$result['invoice_type'] = 'direct';
				$result['invoice_main_data'] = null;
				$result['invoice_detail_data'] = null;
				$result['extra_charge_data'] = null;
				$result['reciept_data'] = null;
				$result['is_edit'] = false;
			}else if($id=='indirect'){
				$result['invoice_type'] = 'indirect';
				$result['invoice_main_data'] = null;
				$result['invoice_detail_data'] = null;
				$result['extra_charge_data'] = null;
				$result['reciept_data'] = null;
				$result['is_edit'] = false;
			}else{
				$result['invoice_main_data'] = $this->Invoiceinfo->getInvoiceById($this->api_token,$id)['data']['main_data'];
				$result['invoice_detail_data'] = $this->Invoiceinfo->getInvoiceById($this->api_token,$id)['data']['details_data'];
				$result['extra_charge_data'] = $this->Invoiceinfo->getInvoiceById($this->api_token,$id)['data']['extra_charge_data'];
				$result['reciept_data'] = $this->Invoiceinfo->getInvoiceById($this->api_token,$id)['data']['reciept_data'];
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

	public function getAdvancePayments(){
		$api_token = $this->session->userdata('api_token');

		if (!$api_token) {
			$this->session->set_flashdata(['res' => '401', 'msg' => 'Not authenticated']);
			redirect('Welcome/Logout');
			return;
		}

		$form_data = [
			'jobcard_id' => $this->input->get('jobcard_id'),
			'page' => $this->input->get('page'),
		];

		$response = $this->Invoiceinfo->getAdvancePayments($api_token,$form_data);
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

	public function deleteInvoice($id) {
        $api_token = $this->session->userdata('api_token');
        if (!$api_token) {
            $this->session->set_flashdata(['res' => '401', 'msg' => 'Not authenticated']);
            redirect('Welcome/Logout');
            return;
        }

		$response = $this->Invoiceinfo->deleteInvoice($api_token, $id);
 
		if ($response) {
            echo json_encode($response);
		}else{
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('invoice');
		}   
    }

	public function cancelInvoice() {

        $api_token = $this->session->userdata('api_token');
        if (!$api_token) {
            $this->session->set_flashdata(['res' => '401', 'msg' => 'Not authenticated']);
            redirect('Welcome/Logout');
            return;
        }

        $form_data = $this->input->post();

		$response = $this->Invoiceinfo->cancelInvoice($api_token, $form_data);
 
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
		// $api_token = $this->session->userdata('api_token');
		// $id = $this->input->post('job_card_id');

		// if (!$api_token || !$id) {
		// 	echo "<script>alert('Missing job card ID or token');</script>";
		// 	echo json_encode(['status' => false, 'msg' => 'Missing job card ID or token']);
		// 	return;
		// }

		// $response = $this->Invoiceinfo->fetchJobCardDetails($api_token, $id);
		// echo "<script>alert('Data fetched successfully');</script>";
		// echo json_encode($response);
	
	

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

	public function getInvoiceNo(){
		$form_data = [
			'term' => $this->input->get('term'),
			'page' => $this->input->get('page'),
		];

		$response = $this->Invoiceinfo->getInvoiceNo($this->api_token,$form_data);
		echo json_encode($response);
	}

	public function getInvoiceDetails($id) {
        $api_token = $this->session->userdata('api_token');

        if (!$api_token || !$id) {
            echo json_encode(['status' => false, 'msg' => 'Missing job card ID or token']);
            return;
        }

        $response = $this->Invoiceinfo->getInvoiceById($api_token, $id);
        echo json_encode($response);
    }

	public function invoicePDF(){
		$id=$this->input->get('invoice_id');
        $response=$this->Invoiceinfo->getInvoicePdfDetails($this->api_token,$id);

		if (!$response['status'] || $response['code'] != 200) {
			show_error('Failed to fetch invoice data');
		}

		$pdf_data = [
			'main_data'    => $response['data']['main_data'][0],     
			'details_data' => $response['data']['details_data'],     
			'extra_charge_data' => $response['data']['extra_charge_data'],  
			'total_paid_for_ref' => $response['data']['total_paid_for_ref'],  
		];

		$this->load->library('Pdf');

	   	// $customPaper = array(0, 0, 382.84, 380.84); 
		$customPaper = array(0, 0, 396, 396); 
        $this->pdf->setPaper($customPaper);    
		$this->pdf->set_option('defaultFont', 'Helvetica');           
		$this->pdf->set_option('isRemoteEnabled', true); 

		$html = $this->load->view('components/pdf/job_invoice_pdf', $pdf_data, TRUE);

		$this->pdf->loadHtml($html);
		$this->pdf->render();
		$this->pdf->stream(
			$pdf_data['main_data']['invoice_number'] . '.pdf', 
			['Attachment' => 0]  
		);
	}

	public function insertNewItem(){
		$form_data = [
            'item_name' => $this->input->post('item_name'),
			'usable_type' => $this->input->post('usable_type'),
			'uom' => $this->input->post('uom'),
			'unit_price' => $this->input->post('unit_price'),
			'sales_price' => $this->input->post('sales_price'),
			'minimum_qty' => $this->input->post('minimum_qty'),
			'qty' => $this->input->post('qty'),
			'company_id' => $this->input->post('company_id'),
			'branch_id' => $this->input->post('branch_id')
        ];
		
		$response = $this->Invoiceinfo->insertNewItem($this->api_token,$form_data);
 
		if ($response) {
            echo json_encode($response);
		}else{
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('Invoice');
		}
	}

	public function searchCustomer($id) {
		$response = $this->Invoiceinfo->searchCustomer($this->api_token, $id);
		echo json_encode($response);
	}
}