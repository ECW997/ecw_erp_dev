<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class SalesOrder extends CI_Controller {
	protected $api_token;
    protected $auth_user;

    public function __construct() {
        parent::__construct();
		$this->load->helper('api_helper');
        $this->load->model('SalesOrderinfo');
		$this->load->model('CashierShiftinfo');

		$auth_info = auth_check();
		$this->api_token = $auth_info['api_token'];
		$this->auth_user = $auth_info['user'];
    }

    public function index(){
		$this->load->model('Commeninfo');
		$check_cashier_shift_response = $this->CashierShiftinfo->checkCashierShift($this->api_token, []);
		$result['check_cashier_shift'] = $check_cashier_shift_response;
		$status = isset($check_cashier_shift_response['status']) ? $check_cashier_shift_response['status'] : false;
		$code   = isset($check_cashier_shift_response['code']) ? $check_cashier_shift_response['code'] : 0;
		$result['menuaccess'] = json_decode(json_encode($this->Commeninfo->getMenuPrivilege($this->api_token,'')['data'] ?? []));
		$this->load->view('salesOrderList', $result);
	}

	public function salesOrderDetailIndex($id = null){
		$this->load->model('Commeninfo');
		$check_cashier_shift_response = $this->CashierShiftinfo->checkCashierShift($this->api_token, []);
		$result['check_cashier_shift'] = $check_cashier_shift_response;
		$status = isset($check_cashier_shift_response['status']) ? $check_cashier_shift_response['status'] : false;
		$code   = isset($check_cashier_shift_response['code']) ? $check_cashier_shift_response['code'] : 0;
		$result['menuaccess'] = json_decode(json_encode($this->Commeninfo->getMenuPrivilege($this->api_token,'')['data'] ?? []));
		$branch_id = $this->session->userdata('branch_id');
		$jobcard_id = $this->input->get('jobcard_id'); 
		$jobcard_no = $this->input->get('jobcard_no');

        if ($id !== null) {
			$result['jobCardId'] = null;
			$result['jobCardNo'] = null;
			$salesOrderData = $this->SalesOrderinfo->getSalesOrderById($this->api_token, $id);
			$result['relationDetails'] = $salesOrderData['relationDetails'] ?? null;
			$result['salesOrderHeader'] = $salesOrderData['salesOrderDetails']['main_data'] ?? null;
			$result['salesOrderDetails'] = $salesOrderData['salesOrderDetails']['details_data'] ?? null;
			$result['excludeSalesOrderHeader'] = $salesOrderData['excludeSalesOrderDetails']['main_data'] ?? null;
			$result['excludeSalesOrderDetails'] = $salesOrderData['excludeSalesOrderDetails']['details_data'] ?? null;
			$result['is_edit'] = true;
        }else{
			$result['jobCardId'] = $jobcard_id;
			$result['jobCardNo'] = $jobcard_no;
			$result['relationDetails'] = null;
			$result['salesOrderHeader'] = null;
			$result['salesOrderDetails'] = null;
            $result['excludeSalesOrderHeader'] = null;
			$result['excludeSalesOrderDetails'] = null;
            $result['is_edit'] = false;
		}
		$this->load->view('salesOrder', $result);
	}

	public function salesOrderDetailIndex2($id = null){
		$this->load->model('Commeninfo');
		$result['menuaccess'] = json_decode(json_encode($this->Commeninfo->getMenuPrivilege($this->api_token,'')['data'] ?? []));
		$branch_id = $this->session->userdata('branch_id');

        if ($id !== null) {
			$salesOrderData = $this->SalesOrderinfo->getSalesOrderById($this->api_token, $id);
			$result['relationDetails'] = $salesOrderData['relationDetails'] ?? null;
			$result['salesOrderHeader'] = $salesOrderData['salesOrderDetails']['main_data'] ?? null;
			$result['salesOrderDetails'] = $salesOrderData['salesOrderDetails']['details_data'] ?? null;
			$result['is_edit'] = true;
        }else{
			$result['relationDetails'] = null;
			$result['salesOrderHeader'] = null;
			$result['salesOrderDetails'] = null;
            $result['is_edit'] = false;
		}
		$this->load->view('salesOrder2', $result);
	}

	public function SalesOrderInsertUpdate() {
		$recordOption = $this->input->post('recordOption');

        $form_data = [
            'availableJobs' => $this->input->post('availableJobs'),
            'selectedJobs' => $this->input->post('selectedJobs'),
			'tempAvailableJobs' => $this->input->post('tempAvailableJobs'),
			'tempSelectedJobs' => $this->input->post('tempSelectedJobs'),
            'jobCardId' => $this->input->post('jobCardId'),
			'confirmedOrderValue' => $this->input->post('confirmedOrderValue'),
			'headerDiscount' => $this->input->post('headerDiscount'),
			'paymentType' => $this->input->post('paymenttype'),
			'recordOption' => $this->input->post('recordOption'),
			'recordID' => $this->input->post('recordID'),
        ];

		$response='';
		if($recordOption == '1'){
			$response = $this->SalesOrderinfo->SalesOrderInsert($this->api_token,$form_data);
		}else{
			$response = $this->SalesOrderinfo->SalesOrderUpdate($this->api_token,$form_data);
		}

		if ($response) {
			echo json_encode($response);
		}else{
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('SalesOrder');
		}
    }

    public function SalesOrderDelete($id) {
        $response = $this->SalesOrderinfo->SalesOrderDelete($this->api_token,$id);

        if ($response) {
			echo json_encode($response);
        } else {
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('SalesOrder');
        }
    }

	public function Approve() {
		$recordID = $this->input->post('recordID');
		$recordOption = $this->input->post('recordOption');

		$form_data = [
			'recordID' => $recordID,
		];

		$response = $this->SalesOrderinfo->Approve($this->api_token,$form_data);

		if ($response) {
			echo json_encode($response);
		} else {
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
			redirect('SalesOrder');
		}
	}

	public function getJobcardNumbers(){
		$form_data = [
			'term' => $this->input->get('term'),
			'page' => $this->input->get('page'),
		];

		$response = $this->SalesOrderinfo->getJobcardNumbers($this->api_token,$form_data);
		echo json_encode($response);
	}

	public function getJobCardDetails() {
        $id = $this->input->post('job_card_id');

        if (!$id) {
            echo json_encode(['status' => false, 'msg' => 'Missing job card ID or token']);
            return;
        }

        $response = $this->SalesOrderinfo->fetchJobCardDetails($this->api_token, $id);
        echo json_encode($response);
    }
    
	public function salesOrderPDF(){
		$id=$this->input->get('relation_id');
        $response=$this->SalesOrderinfo->getSalesOrderById($this->api_token,$id);

		if (!$response['status'] || $response['code'] != 200) {
			show_error('Failed to fetch job card data');
		}

		$pdf_data = [
			'main_data'    => $response['salesOrderDetails']['main_data'][0],     
			'details_data' => $response['salesOrderDetails']['details_data'],     
			'summary_data' => $response['salesOrderDetails']['summary_data']     
		];

		$this->load->library('Pdf');

		$this->pdf->setPaper('A4', 'portrait');                      
		$this->pdf->set_option('defaultFont', 'Helvetica');           
		$this->pdf->set_option('isRemoteEnabled', true); 

		$html = $this->load->view('components/pdf/jobcard_pdf', $pdf_data, TRUE);

		$this->pdf->loadHtml($html);
		$this->pdf->render();

		// $this->pdf->stream(
		// 	$pdf_data['main_data']['job_card_number'] . '.pdf', 
		// 	['Attachment' => 1]  
		// );

		// Check if request is from Electron
		$user_agent = $this->input->server('HTTP_USER_AGENT');
		$is_electron = strpos($user_agent, 'Electron') !== false;
		
		$filename = $pdf_data['main_data']['job_card_number'] . '.pdf';
		
		if ($is_electron) {
			// For Electron: Set proper headers for download
			header('Content-Type: application/pdf');
			header('Content-Disposition: attachment; filename="' . $filename . '"');
			header('Content-Length: ' . strlen($this->pdf->output()));
			header('Cache-Control: private, max-age=0, must-revalidate');
			header('Pragma: public');
			
			echo $this->pdf->output();
		} else {
			// For regular browsers: Use stream method
			$this->pdf->stream($filename, ['Attachment' => 0]);
		}
	}
}