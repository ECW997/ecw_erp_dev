<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class MainJobCategory extends CI_Controller {
	public function __construct() {
        parent::__construct();
        $this->load->model('MainJobCategoryinfo');
    }
	
	public function index(){
		$api_token = $this->session->userdata('api_token');
		if (!$api_token) {
			$this->session->set_flashdata(['res' => '401', 'msg' => 'Not authenticated']);
			redirect('Welcome/Logout');
			return;
		}
		
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('main_job_category', $result);
	}

    public function mainJobCategoryInsert() {
        $api_token = $this->session->userdata('api_token');
		if (!$api_token) {
			$this->session->set_flashdata(['res' => '401', 'msg' => 'Not authenticated']);
			redirect('Welcome/Logout');
			return;
		}

		$recordOption = $this->input->post('recordOption');

        $form_data = [
            'main_job_category' => $this->input->post('main_job_category'),
			'recordID' => $this->input->post('recordID'),
        ];

		$response='';
		if($recordOption == '1'){
			$response = $this->MainJobCategoryinfo->mainJobCategoryInsert($api_token,$form_data);
		}else{
			$response = $this->MainJobCategoryinfo->mainJobCategoryUpdate($api_token,$form_data);
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
        $api_token = $this->session->userdata('api_token');
		if (!$api_token) {
			$this->session->set_flashdata(['res' => '401', 'msg' => 'Not authenticated']);
			redirect('Welcome/Logout');
			return;
		}

        $response = $this->MainJobCategoryinfo->mainJobCategoryEdit($api_token,$id);

		echo json_encode($response);
    }

	public function mainJobCategoryStatus($id, $status) {
        $api_token = $this->session->userdata('api_token');
		if (!$api_token) {
			$this->session->set_flashdata(['res' => '401', 'msg' => 'Not authenticated']);
			redirect('Welcome/Logout');
			return;
		}

        $form_data = [
            'recordID' => $id,
			'status' => $status,
        ];

        $response = $this->MainJobCategoryinfo->mainJobCategoryStatus($api_token,$form_data);

        if ($response) {
			$this->session->set_flashdata(['res' => $response['code'], 'msg' => $response['message']]);
			redirect('MainJobCategory');      
        } else {
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('MainJobCategory');
        }
    }

	public function mainJobCategoryDelete($id) {
        $api_token = $this->session->userdata('api_token');
		if (!$api_token) {
			$this->session->set_flashdata(['res' => '401', 'msg' => 'Not authenticated']);
			redirect('Welcome/Logout');
			return;
		}

        $response = $this->MainJobCategoryinfo->mainJobCategoryDelete($api_token,$id);

        if ($response) {
			$this->session->set_flashdata(['res' => $response['code'], 'msg' => $response['message']]);
			redirect('MainJobCategory');      
        } else {
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('MainJobCategory');
        }
    }


}