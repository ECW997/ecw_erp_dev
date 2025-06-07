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
		$id=$this->input->get('jobcard_id');
        $response=$this->JobCardinfo->jobCardPDF($this->api_token,$id);

		if (!$response['status'] || $response['code'] != 200) {
			show_error('Failed to fetch job card data');
		}

		$pdf_data = [
			'main_data'    => $response['data']['main_data'][0],     
			'details_data' => $response['data']['details_data'],     
			'summary_data' => $response['data']['summary_data']     
		];

		$this->load->library('Pdf');

		$this->pdf->setPaper('A4', 'portrait');                      
		$this->pdf->set_option('defaultFont', 'Helvetica');           
		$this->pdf->set_option('isRemoteEnabled', true); 

		$html = $this->load->view('components/pdf/jobcard_pdf', $pdf_data, TRUE);

		$this->pdf->loadHtml($html);
		$this->pdf->render();
		$this->pdf->stream(
			$pdf_data['main_data']['job_card_number'] . '.pdf', 
			['Attachment' => 0]  
		);
	}

	public function jobSummaryPDF(){
		$id=$this->input->get('jobcard_id');
        $response=$this->JobCardinfo->jobSummaryPDF($this->api_token,$id);

		if (!$response['status'] || $response['code'] != 200) {
			show_error('Failed to fetch job card data');
		}

		$pdf_data = [
			'main_data'    => $response['data']['main_data'][0],     
			'details_data' => $response['data']['details_data'],     
			'summary_data' => $response['data']['summary_data']     
		];

		$this->load->library('Pdf');

	   	$customPaper = array(0, 0, 382.84, 380.84); 
        $this->pdf->setPaper($customPaper);    
		$this->pdf->set_option('defaultFont', 'Helvetica');           
		$this->pdf->set_option('isRemoteEnabled', true); 

		$html = $this->load->view('components/pdf/job_summary_pdf', $pdf_data, TRUE);

		$this->pdf->loadHtml($html);
		$this->pdf->render();
		$this->pdf->stream(
			$pdf_data['main_data']['job_card_number'] . '.pdf', 
			['Attachment' => 0]  
		);
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


	public function updatediscount() {
        $api_token = $this->session->userdata('api_token');
        if (!$api_token) {
            $this->session->set_flashdata(['res' => '401', 'msg' => 'Not authenticated']);
            redirect('Welcome/Logout');
            return;
        }

        $form_data = $this->input->post();

		$response = $this->JobCardinfo->updatediscount($api_token, $form_data);
 
		if ($response) {
            echo json_encode($response);
		}else{
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('JobCard');
		}   
    }

	public function getDiscount($id) {
        $api_token = $this->session->userdata('api_token');
		if (!$api_token) {
			$this->session->set_flashdata(['res' => '401', 'msg' => 'Not authenticated']);
			redirect('Welcome/Logout');
			return;
		}

        $response = $this->JobCardinfo->getDiscount($api_token,$id);

		echo json_encode($response);
    }


}