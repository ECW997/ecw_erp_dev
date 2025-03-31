<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class SubJobCategory extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('SubJobCategoryinfo');
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
		$this->load->view('sub_job_category', $result);
	}

	public function getMainJob(){
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

		$response = $this->SubJobCategoryinfo->getMainJob($api_token,$form_data);
		echo json_encode($response);
	}

	public function getSubJob(){
		$api_token = $this->session->userdata('api_token');

		if (!$api_token) {
			$this->session->set_flashdata(['res' => '401', 'msg' => 'Not authenticated']);
			redirect('Welcome/Logout');
			return;
		}

		$form_data = [
			'term' => $this->input->get('term'),
			'page' => $this->input->get('page'),
			'mainJob' => $this->input->get('mainJob'),
		];

		$response = $this->SubJobCategoryinfo->getSubJob($api_token,$form_data);

		echo json_encode($response);
	}

	public function subJobCategoryInsert() {
        $api_token = $this->session->userdata('api_token');
		if (!$api_token) {
			$this->session->set_flashdata(['res' => '401', 'msg' => 'Not authenticated']);
			redirect('Welcome/Logout');
			return;
		}

		$recordOption = $this->input->post('recordOption');

        $form_data = [
            'main_job_category' => $this->input->post('main_job_category'),
			'sub_job_category' => $this->input->post('sub_job_category'),
			'recordID' => $this->input->post('recordID'),
        ];

		$response='';
		if($recordOption == '1'){
			$response = $this->SubJobCategoryinfo->subJobCategoryInsert($api_token,$form_data);
		}else{
			$response = $this->SubJobCategoryinfo->subJobCategoryUpdate($api_token,$form_data);
		}

		if ($response) {
			$this->session->set_flashdata(['res' => $response['code'], 'msg' => $response['message']]);
        	redirect('SubJobCategory');   
		}else{
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('SubJobCategory');
		}
    }


	public function subJobCategoryEdit($id) {
        $api_token = $this->session->userdata('api_token');
		if (!$api_token) {
			$this->session->set_flashdata(['res' => '401', 'msg' => 'Not authenticated']);
			redirect('Welcome/Logout');
			return;
		}

        $response = $this->SubJobCategoryinfo->subJobCategoryEdit($api_token,$id);

		echo json_encode($response);
    }


    public function subJobCategoryStatus($id, $status) {
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

        $response = $this->SubJobCategoryinfo->subJobCategoryStatus($api_token,$form_data);

        if ($response) {
			$this->session->set_flashdata(['res' => $response['code'], 'msg' => $response['message']]);
			redirect('SubJobCategory');      
        } else {
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('SubJobCategory');
        }
    }
	
	public function subJobCategoryDelete($id) {
        $api_token = $this->session->userdata('api_token');
		if (!$api_token) {
			$this->session->set_flashdata(['res' => '401', 'msg' => 'Not authenticated']);
			redirect('Welcome/Logout');
			return;
		}

        $response = $this->SubJobCategoryinfo->subJobCategoryDelete($api_token,$id);

        if ($response) {
			$this->session->set_flashdata(['res' => $response['code'], 'msg' => $response['message']]);
			redirect('SubJobCategory');      
        } else {
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('SubJobCategory');
        }
    }
}