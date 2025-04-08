<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class JobCard extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('JobCardinfo');
    }

    public function index($id = null){
        $api_token = $this->session->userdata('api_token');
		if (!$api_token) {
			$this->session->set_flashdata(['res' => '401', 'msg' => 'Not authenticated']);
			redirect('Welcome/Logout');
			return;
		}

		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['brandlist']=$this->JobCardinfo->Getvehiclebrand();
        $result['mainjoblist']=$this->JobCardinfo->Getmainjob();
        $result['paymentlist']=$this->JobCardinfo->Getpayment_method();
        $result['materiallist']=$this->JobCardinfo->Getmaterial();

        if ($id !== null) {
            $result['job_data'] = $this->JobCardinfo->getJobById($api_token,$id);
            $result['is_edit'] = true;
        } else {
            $result['job_data'] = null;
            $result['is_edit'] = false;
        }
    
		$this->load->view('jobCard', $result);
	}
    public function JobCardinsertupdate(){
		$this->load->model('JobCardinfo');
        $result=$this->JobCardinfo->JobCardinsertupdate();
	}
    public function JobCardstatus($x, $y, $z){
		$this->load->model('JobCardinfo');
        $result=$this->JobCardinfo->JobCardstatus($x, $y, $z);
	}
    public function JobCardedit(){
		$this->load->model('JobCardinfo');
        $result=$this->JobCardinfo->JobCardedit();
	}
    public function getJobprice(){
		$this->load->model('JobCardinfo');
        $result=$this->JobCardinfo->getJobprice();
	}
    public function GetCustomerInquiry(){
		$this->load->model('JobCardinfo');
        $result=$this->JobCardinfo->GetCustomerInquiry();
	}
    public function GetInquiryDetails(){
		$this->load->model('JobCardinfo');
        $result=$this->JobCardinfo->GetInquiryDetails();
	}
    public function Getvehiclenumber(){
		$this->load->model('JobCardinfo');
        $result=$this->JobCardinfo->Getvehiclenumber();
	}
    public function GetcustomerName(){
		$this->load->model('JobCardinfo');
        $result=$this->JobCardinfo->GetcustomerName();
	}
    public function Getvehicleinformation(){
		$this->load->model('JobCardinfo');
        $result=$this->JobCardinfo->Getvehicleinformation();
	}
    
    public function getInquiryJobList(){
        $this->load->model('JobCardinfo');
        $result=$this->JobCardinfo->getInquiryJobList();
    }
    public function jobCardPDF(){
		$this->load->model('JobCardinfo');
        $result=$this->JobCardinfo->jobCardPDF();
	}




    public function getCustomerDetails($id) {
        $api_token = $this->session->userdata('api_token');
		if (!$api_token) {
			$this->session->set_flashdata(['res' => '401', 'msg' => 'Not authenticated']);
			redirect('Welcome/Logout');
			return;
		}

        $response = $this->JobCardinfo->getCustomerDetails($api_token,$id);
		echo json_encode($response);
    }

    public function getPriceCategory(){
		$api_token = $this->session->userdata('api_token');

    public function createJobCard() {
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

		$response = $this->JobCardinfo->getPriceCategory($api_token,$form_data);
		echo json_encode($response);
	}
        $form_data = $this->input->post('data');

		$response = $this->JobCardinfo->createJobCard($api_token,$form_data);
 
		if ($response) {
            echo json_encode($response);
		}else{
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('JobCard');
		}
    }

    public function getSubJob($id) {
        $api_token = $this->session->userdata('api_token');
		if (!$api_token) {
			$this->session->set_flashdata(['res' => '401', 'msg' => 'Not authenticated']);
			redirect('Welcome/Logout');
			return;
		}

        $response = $this->JobCardinfo->getSubJob($api_token,$id);
        $data['data'] = $response;
		$html = $this->load->view('components/modal/job_card/job_item_container', $data, true);
        echo ($html);
    }

    public function getItemParentOptions() {
        $api_token = $this->session->userdata('api_token');
		if (!$api_token) {
			$this->session->set_flashdata(['res' => '401', 'msg' => 'Not authenticated']);
			redirect('Welcome/Logout');
			return;
		}

        $form_data = [
            'sub_id' => $this->input->post('subJobCategoryID'),
			'id' => $this->input->post('selectedOptionValue')
        ];

        $response = $this->JobCardinfo->getItemParentOptions($api_token,$form_data);
        if ($response) {
            echo json_encode($response);
		}
    }
}