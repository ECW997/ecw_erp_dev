<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class MainJobCategory extends CI_Controller {
	protected $api_token;
    protected $auth_user;

    public function __construct() {
        parent::__construct();
		$this->load->helper('api_helper');
        $this->load->model('MainJobCategoryinfo');

		$auth_info = auth_check();
		$this->api_token = $auth_info['api_token'];
		$this->auth_user = $auth_info['user'];
    }
	
	public function index(){
		$this->load->model('Commeninfo');
		$result['menuaccess'] = json_decode(json_encode($this->Commeninfo->getMenuPrivilege($this->api_token,'')['data'] ?? []));
		$this->load->view('main_job_category', $result);
	}

    public function mainJobCategoryInsert() {
		$recordOption = $this->input->post('recordOption');

        $form_data = [
            'main_job_category' => $this->input->post('main_job_category'),
			'recordID' => $this->input->post('recordID'),
        ];

		$response='';
		if($recordOption == '1'){
			$response = $this->MainJobCategoryinfo->mainJobCategoryInsert($this->api_token,$form_data);
		}else{
			$response = $this->MainJobCategoryinfo->mainJobCategoryUpdate($this->api_token,$form_data);
		}

		if ($response) {
			$this->session->set_flashdata(['res' => $response['code'], 'msg' => $response['message']]);
        	redirect('MainJobCategory');   
		}else{
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('MainJobCategory');
		}
    }

    public function mainJobCategoryEdit($id) {
        $response = $this->MainJobCategoryinfo->mainJobCategoryEdit($this->api_token,$id);
		echo json_encode($response);
    }

	public function mainJobCategoryStatus($id, $status) {
        $form_data = [
            'recordID' => $id,
			'status' => $status,
        ];

        $response = $this->MainJobCategoryinfo->mainJobCategoryStatus($this->api_token,$form_data);

        if ($response) {
			$this->session->set_flashdata(['res' => $response['code'], 'msg' => $response['message']]);
			redirect('MainJobCategory');      
        } else {
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('MainJobCategory');
        }
    }

	public function mainJobCategoryDelete($id) {
        $response = $this->MainJobCategoryinfo->mainJobCategoryDelete($this->api_token,$id);

        if ($response) {
			$this->session->set_flashdata(['res' => $response['code'], 'msg' => $response['message']]);
			redirect('MainJobCategory');      
        } else {
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('MainJobCategory');
        }
    }


}