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
	
    public function SubJobCategoryinsertupdate(){
		$this->load->model('SubJobCategoryinfo');
        $result=$this->SubJobCategoryinfo->SubJobCategoryinsertupdate();
	}
    public function SubJobCategorystatus($x, $y){
		$this->load->model('SubJobCategoryinfo');
        $result=$this->SubJobCategoryinfo->SubJobCategorystatus($x, $y);
	}
    public function SubJobCategoryedit(){
		$this->load->model('SubJobCategoryinfo');
        $result=$this->SubJobCategoryinfo->SubJobCategoryedit();
	}
}