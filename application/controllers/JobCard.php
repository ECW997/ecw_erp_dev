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
		$branch_id = $this->session->userdata('branch_id');
		$this->load->model('Commeninfo');
		$result['menuaccess'] = json_decode(json_encode($this->Commeninfo->getMenuPrivilege($this->api_token,'')['data'] ?? []));
		$result['sales_agents'] = $this->JobCardinfo->getSalesAgent($this->api_token,$branch_id)['data'];

		$this->load->view('jobCardList', $result);
	}

    public function jobCardDetailIndex($id = null){
		$this->load->model('Commeninfo');
		$result['menuaccess'] = json_decode(json_encode($this->Commeninfo->getMenuPrivilege($this->api_token,'')['data'] ?? []));

        if ($id !== null) {
            $result['job_main_data'] = $this->JobCardinfo->getJobById($this->api_token,$id)['data']['main_data'];
			$result['job_detail_data'] = $this->JobCardinfo->getJobById($this->api_token,$id)['data']['details_data'];
			$result['summary_data'] = $this->JobCardinfo->getJobById($this->api_token,$id)['data']['summary_data'];
			$result['is_line_discount_approved'] = $this->JobCardinfo->getJobById($this->api_token,$id)['data']['is_line_discount_approved'];
			$result['is_header_discount_approved'] = $this->JobCardinfo->getJobById($this->api_token,$id)['data']['is_header_discount_approved'];
            $result['is_edit'] = true;
        } else {
            $result['job_main_data'] = null;
            $result['job_detail_data'] = null;
			$result['summary_data'] = null;
			$result['is_line_discount_approved'] = null;
			$result['is_header_discount_approved'] = null;
            $result['is_edit'] = false;
        }

		$this->load->view('jobCard', $result);
	}
 
    public function jobCardPDF(){
		$id=$this->input->get('jobcard_id');
        $response=$this->JobCardinfo->getJobById($this->api_token,$id);

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

		// $this->pdf->stream(
		// 	$pdf_data['main_data']['job_card_number'] . '.pdf', 
		// 	['Attachment' => 1]  
		// );

		// Check if request is from Electron
		$user_agent = $this->input->server('HTTP_USER_AGENT');
		$is_electron = strpos($user_agent, 'Electron') !== false;
		
		$filename = $pdf_data['main_data']['job_card_number'] . '.pdf';
		
		if ($is_electron) {
			// For Electron: Set proper headers for download
			header('Content-Type: application/pdf');
			header('Content-Disposition: attachment; filename="' . $filename . '"');
			header('Content-Length: ' . strlen($this->pdf->output()));
			header('Cache-Control: private, max-age=0, must-revalidate');
			header('Pragma: public');
			
			echo $this->pdf->output();
		} else {
			// For regular browsers: Use stream method
			$this->pdf->stream($filename, ['Attachment' => 0]);
		}
	}

	public function jobCardQuotationPDF(){
		$id=$this->input->get('jobcard_id');
        $response=$this->JobCardinfo->getJobById($this->api_token,$id);

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

		$html = $this->load->view('components/pdf/jobcard_quotation_pdf', $pdf_data, TRUE);

		$this->pdf->loadHtml($html);
		$this->pdf->render();
		$this->pdf->stream(
			$pdf_data['main_data']['job_card_number'] . '.pdf', 
			['Attachment' => 0]  
		);
	}

	public function jobSummaryPDF(){
		$id=$this->input->get('jobcard_id');
        $response=$this->JobCardinfo->getJobById($this->api_token,$id);

		if (!$response['status'] || $response['code'] != 200) {
			show_error('Failed to fetch job card data');
		}

		$pdf_data = [
			'main_data'    => $response['data']['main_data'][0],     
			'details_data' => $response['data']['details_data'],     
			'summary_data' => $response['data']['summary_data'],     
			'is_header_discount_approved' => $response['data']['is_header_discount_approved'],
			'is_line_discount_approved' => $response['data']['is_line_discount_approved']    
		];

		$this->load->library('Pdf');

	   	// $customPaper = array(0, 0, 382.84, 380.84); 
		$customPaper = array(0, 0, 396, 396); 
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

	public function getPaymentMethod(){
		$form_data = [
			'term' => $this->input->get('term'),
			'page' => $this->input->get('page'),
		];

		$response = $this->JobCardinfo->getPaymentMethod($this->api_token,$form_data);
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
			'jobcard_id' => $this->input->post('jobcard_id'),
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
        $form_data = $this->input->post();

		$response = $this->JobCardinfo->updatediscount($this->api_token, $form_data);
 
		if ($response) {
            echo json_encode($response);
		}else{
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('JobCard');
		}   
    }

	public function getDiscount($id) {
        $response = $this->JobCardinfo->getDiscount($this->api_token,$id);
		echo json_encode($response);
    }

	public function approveDiscount() {
		$form_data = [
            'jobcard_id' => $this->input->post('jobcard_id'),
			'discount_type' => $this->input->post('discount_type'),
			'action' => $this->input->post('action')
        ];

		$response = $this->JobCardinfo->approveDiscount($this->api_token, $form_data);
 
		if ($response) {
            echo json_encode($response);
		}else{
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('JobCard');
		}   
    }

	public function deniedDiscount() {
        $form_data = [
            'jobcard_id' => $this->input->post('jobcard_id'),
			'discount_type' => $this->input->post('discount_type'),
			'action' => $this->input->post('action')
        ];

		$response = $this->JobCardinfo->deniedDiscount($this->api_token, $form_data);
 
		if ($response) {
            echo json_encode($response);
		}else{
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('JobCard');
		}   
    }

	public function approveJobcard() {
        $form_data = $this->input->post();

		$response = $this->JobCardinfo->approveJobcard($this->api_token, $form_data);
 
		if ($response) {
            echo json_encode($response);
		}else{
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('JobCard');
		}   
    }

	public function deniedJobcard() {
        $form_data = $this->input->post();

		$response = $this->JobCardinfo->deniedJobcard($this->api_token, $form_data);
 
		if ($response) {
            echo json_encode($response);
		}else{
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('JobCard');
		}   
    }

    public function jobCardItemDelete() {
		 $form_data = [
            'recordID' => $this->input->post('id'),
			'job_card_id' => $this->input->post('job_card_id')
        ];

        $response = $this->JobCardinfo->jobCardItemDelete($this->api_token,$form_data);

        if ($response) {
			echo json_encode($response);
        } else {
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('JobOption');
        }
    }

	public function updateJobCardHeader() {
        $form_data = [
			'cus_id' => $this->input->post('cus_id'),
            'cus_name' => $this->input->post('cus_name'),
			'contact_no' => $this->input->post('contact_no'),
			'nic_number' => $this->input->post('nic_number'),
			'address1' => $this->input->post('address1'),
			'address2' => $this->input->post('address2'),
			'email' => $this->input->post('email'),
			'schedule_date' => $this->input->post('schedule_date'),
			'delivery_date' => $this->input->post('delivery_date'),
			'vat_reg_type' => $this->input->post('vat_reg_type'),
			'vat_number' => $this->input->post('vat_number'),
			'price_category' => $this->input->post('price_category'),
			'payment_method' => $this->input->post('payment_method'),
			'jobcard_id' => $this->input->post('jobcard_id')
        ];

		$response = $this->JobCardinfo->updateJobCardHeader($this->api_token, $form_data);
 
		if ($response) {
            echo json_encode($response);
		}else{
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('JobCard');
		}   
    }

	public function getJobCardEditDetails() {
        $form_data = [
			'parent_id' => $this->input->post('parent_id'),
            'job_card_id' => $this->input->post('job_card_id')
        ];

        $response = $this->JobCardinfo->getJobCardEditDetails($this->api_token,$form_data);

		$data['data'] = $response;
		$html = $this->load->view('components/modal/job_card/edit_job_item', $data, true);
        echo ($html);
    }
}