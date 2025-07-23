<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Job_price_details extends CI_Controller {
	protected $api_token;
    protected $auth_user;

    public function __construct() {
        parent::__construct();
		$this->load->helper('api_helper');
        $this->load->model('Job_price_detailsinfo');

		$auth_info = auth_check();
		$this->api_token = $auth_info['api_token'];
		$this->auth_user = $auth_info['user'];
    }

    public function index(){
		$this->load->model('Commeninfo');
		$result['menuaccess'] = json_decode(json_encode($this->Commeninfo->getMenuPrivilege($this->api_token,'')['data'] ?? []));
		$this->load->view('job_price_details', $result);
	}

	public function jobOptionPricingDetailsList() {
		$sub_id = $this->input->get('sub_id');
		$editcheck = $this->input->get('editcheck');
		$statuscheck = $this->input->get('statuscheck');
		$deletecheck = $this->input->get('deletecheck');

        $response = $this->Job_price_detailsinfo->jobOptionPricingDetailsList($this->api_token,$sub_id);

		$data['data'] = $response;
		$data['editcheck'] = $editcheck;
		$data['statuscheck'] = $statuscheck;
		$data['deletecheck'] = $deletecheck;

		$html = $this->load->view('components/table/job_pricing_table', $data, true);
		echo ($html);
    }
   
	public function jobOptionPricingUpdateDetailsList() {
		$id = $this->input->get('id');
		$valuename = $this->input->get('valuename');
		$subCategoryText = $this->input->get('subCategoryText');

        $response = $this->Job_price_detailsinfo->jobOptionPricingUpdateDetailsList($this->api_token,$id);

		$data['data'] = $response;
		$data['valuename'] = $valuename;
		$data['subCategoryText'] = $subCategoryText;

		$html = $this->load->view('components/modal/pricing/update_pricing_item', $data, true);
		echo ($html);
    }

	public function jobOptionPricingUpdate() {
		$form_data = [
			'updatedData' => $this->input->post('updatedData'),
			'recordID' => $this->input->post('recordID'),
        ];

		$response = $this->Job_price_detailsinfo->jobOptionPricingUpdate($this->api_token,$form_data);
		
		if ($response) {
			echo json_encode($response);
		}else{
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('Job_price_details');
		}
    }
}