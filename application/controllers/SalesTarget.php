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

	public function getMainJob(){
		$form_data = [
			'term' => $this->input->get('term'),
			'page' => $this->input->get('page'),
		];

		$response = $this->SubJobCategoryinfo->getMainJob($this->api_token,$form_data);
		echo json_encode($response);
	}

	// public function getSubJob(){
	// 	$form_data = [
	// 		'term' => $this->input->get('term'),
	// 		'page' => $this->input->get('page'),
	// 		'mainJob' => $this->input->get('mainJob'),
	// 	];

	// 	$response = $this->SubJobCategoryinfo->getSubJob($this->api_token,$form_data);

	// 	echo json_encode($response);
	// }

	// public function salesTargetInsert() {
	// 	$recordOption = $this->input->post('recordOption');

    //     $form_data = [
    //         'main_job_category' => $this->input->post('main_job_category'),
	// 		'sub_job_category' => $this->input->post('sub_job_category'),
	// 		'recordID' => $this->input->post('recordID'),
    //     ];

	// 	$response='';
	// 	if($recordOption == '1'){
	// 		$response = $this->SubJobCategoryinfo->subJobCategoryInsert($this->api_token,$form_data);
	// 	}else{
	// 		$response = $this->SubJobCategoryinfo->subJobCategoryUpdate($this->api_token,$form_data);
	// 	}

	// 	if ($response) {
	// 		$this->session->set_flashdata(['res' => $response['code'], 'msg' => $response['message']]);
    //     	redirect('SubJobCategory');   
	// 	}else{
	// 		$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
    //         redirect('SubJobCategory');
	// 	}
    // }


	// public function subJobCategoryEdit($id) {
    //     $response = $this->SubJobCategoryinfo->subJobCategoryEdit($this->api_token,$id);
	// 	echo json_encode($response);
    // }


    // public function subJobCategoryStatus($id, $status) {
    //     $form_data = [
    //         'recordID' => $id,
	// 		'status' => $status,
    //     ];

    //     $response = $this->SubJobCategoryinfo->subJobCategoryStatus($this->api_token,$form_data);

    //     if ($response) {
	// 		$this->session->set_flashdata(['res' => $response['code'], 'msg' => $response['message']]);
	// 		redirect('SubJobCategory');      
    //     } else {
	// 		$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
    //         redirect('SubJobCategory');
    //     }
    // }
	
	// public function subJobCategoryDelete($id) {
    //     $response = $this->SubJobCategoryinfo->subJobCategoryDelete($this->api_token,$id);

    //     if ($response) {
	// 		$this->session->set_flashdata(['res' => $response['code'], 'msg' => $response['message']]);
	// 		redirect('SubJobCategory');      
    //     } else {
	// 		$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
    //         redirect('SubJobCategory');
    //     }
    // }
}