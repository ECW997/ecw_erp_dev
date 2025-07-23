<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class JobOption extends CI_Controller {
	protected $api_token;
    protected $auth_user;

    public function __construct() {
        parent::__construct();
		$this->load->helper('api_helper');
        $this->load->model('JobOptioninfo');

		$auth_info = auth_check();
		$this->api_token = $auth_info['api_token'];
		$this->auth_user = $auth_info['user'];
    }

    public function index(){
		$this->load->model('Commeninfo');
		$result['menuaccess'] = json_decode(json_encode($this->Commeninfo->getMenuPrivilege($this->api_token,'')['data'] ?? []));
		$this->load->view('job_option', $result);
	}

    public function getOptionGroup(){
		$form_data = [
			'term' => $this->input->get('term'),
			'page' => $this->input->get('page'),
			'sub_job_category' => $this->input->get('sub_job_category'),
		];

		$response = $this->JobOptioninfo->getOptionGroup($this->api_token,$form_data);
		echo json_encode($response);
	}

	public function jobOptionInsertUpdate() {
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
			$response = $this->JobOptioninfo->jobOptionInsert($this->api_token,$form_data);
		}else{
			$response = $this->JobOptioninfo->jobOptionUpdate($this->api_token,$form_data);
		}

		if ($response) {
			echo json_encode($response);
		}else{
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('JobOption');
		}
    }

    public function jobOptionEdit($id) {
        $response = $this->JobOptioninfo->jobOptionEdit($this->api_token,$id);
		echo json_encode($response);
    }



    public function jobOptionDetailsList() {
		$sub_id = $this->input->get('sub_id');
		$modalOption = $this->input->get('modalOption', true) ?: '1';
		$editcheck = $this->input->get('editcheck');
		$statuscheck = $this->input->get('statuscheck');
		$deletecheck = $this->input->get('deletecheck');

        $response = $this->JobOptioninfo->jobOptionDetailsList($this->api_token,$sub_id);

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
        $form_data = [
            'recordID' => $id,
			'status' => $status,
        ];

        $response = $this->JobOptioninfo->jobOptionStatus($this->api_token,$form_data);

        if ($response) {
			echo json_encode($response);
        } else {
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('JobOption');
        }
    }


    public function jobOptionDelete($id) {
        $response = $this->JobOptioninfo->jobOptionDelete($this->api_token,$id);

        if ($response) {
			echo json_encode($response);
        } else {
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('JobOption');
        }
    }

    
}