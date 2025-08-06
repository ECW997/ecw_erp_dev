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
		$result['menuaccess'] = json_decode(json_encode($this->Commeninfo->getMenuPrivilege($this->api_token,'')['data'] ?? []));
		$this->load->view('paymentList', $result);
	}
	
	public function paymentDetailIndex($id = null){
		$this->load->model('Commeninfo');
		$result['menuaccess'] = json_decode(json_encode($this->Commeninfo->getMenuPrivilege($this->api_token,'')['data'] ?? []));
		$branch_id = $this->session->userdata('branch_id');

        if ($id !== null) {
			$result['draft_receipt_no'] = null;
			$result['payment_main_data'] = $this->Paymentinfo->getPaymentById($this->api_token,$id)['data']['header'];
			$result['payment_detail_data'] = $this->Paymentinfo->getPaymentById($this->api_token,$id)['data']['details'];
			$result['payment_allocation_detail_data'] = $this->Paymentinfo->getPaymentById($this->api_token,$id)['data']['allocated_details_group'];
			$result['is_edit'] = true;
        }else{
			$result['draft_receipt_no'] = $this->Paymentinfo->getDraftReceiptNO($this->api_token,$branch_id)['data'];
			$result['payment_main_data'] = null;
            $result['payment_detail_data'] = null;
            $result['is_edit'] = false;
		}
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

	public function getJobCardsByCustomer($id) {
        $response = $this->Paymentinfo->getJobCardsByCustomer($this->api_token,$id);
		echo json_encode($response);
    }

	public function createReceipt() {
		$form_data = [
            'draft_receipt_no' => $this->input->post('draft_receipt_no'),
			'date' => $this->input->post('date'),
			'customer_id' => $this->input->post('customer_id'),
			'payment_by' => $this->input->post('payment_by'),
			'payment_note' => $this->input->post('payment_note'),
			'payment_type' => $this->input->post('payment_type'),
			'payment_series' => $this->input->post('payment_series'),
			'branch_id' => $this->input->post('branch_id'),
			'company_id' => $this->input->post('company_id'),
			'payment_data' => $this->input->post('payment_data'),
			'allocation_data' => $this->input->post('allocation_data'),
        ];
		
		$response = $this->Paymentinfo->createReceipt($this->api_token,$form_data);
	
		if ($response) {
            echo json_encode($response);
		}else{
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('Payment');
		}
    }

	public function getPayDetails($id) {
        $response = $this->Paymentinfo->getPayDetails($this->api_token,$id);
		echo json_encode($response);
    }

	public function getPayAllocationDetails($id) {
        $response = $this->Paymentinfo->getPayAllocationDetails($this->api_token,$id);
		echo json_encode($response);
    }

	public function insertORUpdatePayment() {
		$form_data = [
            'payment_date' => $this->input->post('payment_date'),
			'invoice_id' => $this->input->post('invoice_id'),
			'payment_option' => $this->input->post('payment_option'),
			'payment' => $this->input->post('payment'),
			'cheque_number' => $this->input->post('cheque_number'),
			'bank_reference' => $this->input->post('bank_reference'),
			'allocateBankDate' => $this->input->post('allocateBankDate'),
			'allocateChequeDate' => $this->input->post('allocateChequeDate'),
			'branch_id' => $this->input->post('branch_id'),
			'company_id' => $this->input->post('company_id'),
        ];
		
		$response = $this->Paymentinfo->insertORUpdatePayment($this->api_token,$form_data);
	
		if ($response) {
            echo json_encode($response);
		}else{
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('Payment');
		}
    }

	public function verifyPayment() {
		$form_data = [
			'recordID' => $this->input->post('recordID'),
        ];
		$response = $this->Paymentinfo->verifyPayment($this->api_token,$form_data);
 
		if ($response) {
            echo json_encode($response);
		}else{
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('Payment');
		}
    }

	public function deletePayment($id,$table) {
		$form_data = [
					'id' => $id,
					'table' => $table,
		];

		$response = $this->Paymentinfo->deletePayment($this->api_token,$form_data);
 
		if ($response) {
            echo json_encode($response);
		}else{
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('Payment');
		}
    }

	public function paymentReceiptPDF(){
		$id=$this->input->get('receipt_id');
        $response=$this->Paymentinfo->getReceiptPdfDetails($this->api_token,$id);

		if (!$response['status'] || $response['code'] != 200) {
			show_error('Failed to fetch Payment data');
		}

		$pdf_data = [
			'header' => $response['data']['pay_header'],  
    		'invoices' => $response['data']['details'], 		
		];

		$this->load->library('Pdf');

	   	$customPaper = array(0, 0, 382.84, 380.84); 
        $this->pdf->setPaper($customPaper);    
		$this->pdf->set_option('defaultFont', 'Helvetica');           
		$this->pdf->set_option('isRemoteEnabled', true); 

		
		// $this->load->view('components/pdf/payment_receipt_pdf', $pdf_data);
		$html = $this->load->view('components/pdf/payment_receipt_pdf', $pdf_data, TRUE);

		$this->pdf->loadHtml($html);
		$this->pdf->render();
		$this->pdf->stream(
			$pdf_data['header']['receipt_number'] . '.pdf', 
			['Attachment' => 0]  
		);
	}

	public function cancelPayment($id) {
		$form_data = [
			'id' => $id,
		];

		$response = $this->Paymentinfo->cancelPayment($this->api_token,$form_data);
 
		if ($response) {
            echo json_encode($response);
		}else{
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('Payment');
		}
    }
	
}