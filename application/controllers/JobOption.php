<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class JobOption extends CI_Controller {
	public function __construct() {
        parent::__construct();
        $this->load->model('JobOptioninfo');
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
		$this->load->view('job_option', $result);
	}

    public function getOptionGroup(){
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

		$response = $this->JobOptioninfo->getOptionGroup($api_token,$form_data);
		echo json_encode($response);
	}

	public function jobOptionInsertUpdate() {
        $api_token = $this->session->userdata('api_token');
		if (!$api_token) {
			$this->session->set_flashdata(['res' => '401', 'msg' => 'Not authenticated']);
			redirect('Welcome/Logout');
			return;
		}

		$recordOption = $this->input->post('recordOption');

        $form_data = [
            'sub_job_category_id' => $this->input->post('sub_job_category'),
			'option_name' => $this->input->post('option_name'),
			'option_type' => $this->input->post('option_type'),
			'option_group' => $this->input->post('option_group_id'),
            'is_required' => $this->input->post('required_status'),
            'description' => $this->input->post('description'),
            'company_id' => $this->input->post('company_id'),
            'branch_id' => $this->input->post('branch_id'),
			'recordID' => $this->input->post('recordID'),
        ];

	
		$response='';
		if($recordOption == '1'){
			$response = $this->JobOptioninfo->jobOptionInsert($api_token,$form_data);
		}else{
			$response = $this->JobOptioninfo->jobOptionUpdate($api_token,$form_data);
		}

		if ($response) {
			echo json_encode($response);
		}else{
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('JobOption');
		}
    }





    public function jobOptionDetailsList() {
        $api_token = $this->session->userdata('api_token');
		if (!$api_token) {
			$this->session->set_flashdata(['res' => '401', 'msg' => 'Not authenticated']);
			redirect('Welcome/Logout');
			return;
		}
		$sub_id = $this->input->get('sub_id');
		$modalOption = $this->input->get('modalOption', true) ?: '1';
		$editcheck = $this->input->get('editcheck');
		$statuscheck = $this->input->get('statuscheck');
		$deletecheck = $this->input->get('deletecheck');

        $response = $this->JobOptioninfo->jobOptionDetailsList($api_token,$sub_id);

		$data['data'] = $response;
		$data['modalOption'] = $modalOption;
		$data['editcheck'] = $editcheck;
		$data['statuscheck'] = $statuscheck;
		$data['deletecheck'] = $deletecheck;

		$html = $this->load->view('table_components/job_option_table', $data, true);

		echo ($html);
        echo "<script>console.log('PHP Data:', " . json_encode($data) . ");</script>";
    }


    public function jobOptionStatus($id, $status) {
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

        $response = $this->JobOptioninfo->jobOptionStatus($api_token,$form_data);

        if ($response) {
			echo json_encode($response);
        } else {
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('JobOption');
        }
    }

    
}