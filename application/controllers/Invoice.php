<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Invoice extends CI_Controller {
	protected $api_token;
    protected $auth_user;

    public function __construct() {
        parent::__construct();
		$this->load->helper('api_helper');
        $this->load->model('Invoiceinfo');

		$auth_info = auth_check();
		$this->api_token = $auth_info['api_token'];
		$this->auth_user = $auth_info['user'];
    }

	public function index(){
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('invoiceList', $result);
	}
	
	public function invoiceDetailIndex($id = null){
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

		$this->load->view('invoice', $result);
		// $this->load->view('invoice_type', $result);
	}


	public function getJobcardNumbers(){
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

		$response = $this->Invoiceinfo->getJobcardNumbers($api_token,$form_data);
		echo json_encode($response);
	}
	


	public function getJobCardDetails() {
        $api_token = $this->session->userdata('api_token');
        $id = $this->input->post('job_card_id');

        if (!$api_token || !$id) {
            echo json_encode(['status' => false, 'msg' => 'Missing job card ID or token']);
            return;
        }

        $response = $this->Invoiceinfo->fetchJobCardDetails($api_token, $id);
        echo json_encode($response);
    }

}