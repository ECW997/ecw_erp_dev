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

		$auth_info = auth_check();
		$this->api_token = $auth_info['api_token'];
		$this->auth_user = $auth_info['user'];
    }

    public function index(){
		$this->load->model('Commeninfo');
		$result['menuaccess'] = json_decode(json_encode($this->Commeninfo->getMenuPrivilege($this->api_token,'')['data'] ?? []));
		$this->load->view('salesOrderList', $result);
	}

	public function salesOrderDetailIndex($id = null){
		$this->load->model('Commeninfo');
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
    
}