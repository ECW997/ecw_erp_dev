<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class JobCard extends CI_Controller {
	protected $api_token;
    protected $auth_user;

    public function __construct() {
        parent::__construct();
		$this->load->helper('api_helper');
        $this->load->model('JobCardinfo');

		$auth_info = auth_check();
		$this->api_token = $auth_info['api_token'];
		$this->auth_user = $auth_info['user'];
    }

	public function index(){
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('jobCardList', $result);
	}

    public function jobCardDetailIndex($id = null){
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();

        if ($id !== null) {
            $result['job_main_data'] = $this->JobCardinfo->getJobById($this->api_token,$id)['data']['main_data'];
			$result['job_detail_data'] = $this->JobCardinfo->getJobById($this->api_token,$id)['data']['details_data'];
			$result['summary_data'] = $this->JobCardinfo->getJobById($this->api_token,$id)['data']['summary_data'];
            $result['is_edit'] = true;
        } else {
            $result['job_main_data'] = null;
            $result['job_detail_data'] = null;
			$result['summary_data'] = null;
            $result['is_edit'] = false;
        }

		$this->load->view('jobCard', $result);
	}
 
    public function jobCardPDF(){
		$this->load->model('JobCardinfo');
        $result=$this->JobCardinfo->jobCardPDF();
	}

    public function getCustomerDetails($id) {
        $response = $this->JobCardinfo->getCustomerDetails($this->api_token,$id);
		echo json_encode($response);
    }

    public function getPriceCategory(){
		$form_data = [
			'term' => $this->input->get('term'),
			'page' => $this->input->get('page'),
		];

		$response = $this->JobCardinfo->getPriceCategory($this->api_token,$form_data);
		echo json_encode($response);
	}

    public function createJobCard() {
        $form_data = $this->input->post('data');

		$response = $this->JobCardinfo->createJobCard($this->api_token,$form_data);
 
		if ($response) {
            echo json_encode($response);
		}else{
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('JobCard');
		}
    }

	public function insertJobCardDetail() {
		$form_data = [
            'jobData' => $this->input->post('jobData'),
			'inputMethod' => $this->input->post('inputMethod'),
        ];
		
		$response = $this->JobCardinfo->insertJobCardDetail($this->api_token,$form_data);
 
		if ($response) {
            echo json_encode($response);
		}else{
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('JobCard');
		}
    }

    public function getSubJob($id,$idtbl_jobcard) {
		$form_data = [
            'main_id' => $id,
			'jobcard_id' => $idtbl_jobcard
        ];

        $response = $this->JobCardinfo->getSubJob($this->api_token,$form_data);
        $data['data'] = $response;
		// echo json_encode($data['data']);
		$html = $this->load->view('components/modal/job_card/job_item_container', $data, true);
        echo ($html);
    }

    public function getItemParentOptions() {
        $form_data = [
            'sub_id' => $this->input->post('subJobCategoryID'),
			'id' => $this->input->post('selectedOptionValue')
        ];

        $response = $this->JobCardinfo->getItemParentOptions($this->api_token,$form_data);
        if ($response) {
            echo json_encode($response);
		}
    }

	public function getOptionvaluePrice() {
        $form_data = [
            'optionValueId' => $this->input->post('optionValueId'),
			'priceCategoryId' => $this->input->post('priceCategoryId')
        ];

        $response = $this->JobCardinfo->getOptionvaluePrice($this->api_token,$form_data);
        if ($response) {
            echo json_encode($response);
		}
    }
}