<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class SalesTarget extends CI_Controller {
	protected $api_token;
    protected $auth_user;

    public function __construct() {
        parent::__construct();
		$this->load->helper('api_helper');
        $this->load->model('SalesTargetinfo');
		$this->load->model('JobCardinfo');

		$auth_info = auth_check();
		$this->api_token = $auth_info['api_token'];
		$this->auth_user = $auth_info['user'];
    }

    public function index(){
		$branch_id = $this->session->userdata('branch_id');
		$this->load->model('Commeninfo');
		$result['menuaccess'] = json_decode(json_encode($this->Commeninfo->getMenuPrivilege($this->api_token,'')['data'] ?? []));
		$result['sales_agents'] = $this->JobCardinfo->getSalesAgent($this->api_token,$branch_id)['data'];

		$this->load->view('sales_target', $result);
	}

	public function salesTargetInsert() {
		$recordOption = $this->input->post('recordOption');

		$form_data = [
			'sales_agent_id' => $this->input->post('sales_agent_id'),
			'month' => $this->input->post('month'),
			'year' => $this->input->post('year'),
			'target_amount' => $this->input->post('target_amount'),
			'recordID' => $this->input->post('recordID'),
		];

		$response='';
		if($recordOption == '1'){
			$response = $this->SalesTargetinfo->salesTargetInsert($this->api_token,$form_data);
		}else{
			$response = $this->SalesTargetinfo->salesTargetUpdate($this->api_token,$form_data);
		}

		if ($response) {
			$this->session->set_flashdata(['res' => $response['code'], 'msg' => $response['message']]);
			redirect('SalesTarget');   
		}else{
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
			redirect('SalesTarget');
		}
	}

	public function salesTargetEdit($id) {
		$response = $this->SalesTargetinfo->salesTargetEdit($this->api_token,$id);
		echo json_encode($response);
	}

	public function salesTargetDelete($id) {
		$response = $this->SalesTargetinfo->salesTargetDelete($this->api_token, $id);

		if ($response && $response['code'] == 200) {
			$this->session->set_flashdata(['res' => $response['code'], 'msg' => $response['message']]);
		} else {
			$this->session->set_flashdata(['res' => $response['code'] ?? '204', 'msg' => $response['message'] ?? 'Delete failed!']);
		}
		redirect('SalesTarget');
	}



	
}