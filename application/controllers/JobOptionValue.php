<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class JobOptionValue extends CI_Controller {
	protected $api_token;
    protected $auth_user;

    public function __construct() {
        parent::__construct();
		$this->load->helper('api_helper');
        $this->load->model('JobOptionValueinfo');

		$auth_info = auth_check();
		$this->api_token = $auth_info['api_token'];
		$this->auth_user = $auth_info['user'];
    }
    public function index(){
		$this->load->model('Commeninfo');
		$result['menuaccess'] = json_decode(json_encode($this->Commeninfo->getMenuPrivilege($this->api_token,'')['data'] ?? []));
		$this->load->view('job_option_value', $result);
	}

	public function getJobOption(){
		$form_data = [
			'term' => $this->input->get('term'),
			'page' => $this->input->get('page'),
		];

		$response = $this->JobOptionValueinfo->getJobOption($this->api_token,$form_data);
		echo json_encode($response);
	}

	public function getJobOptionValue(){
		$form_data = [
			'term' => $this->input->get('term'),
			'page' => $this->input->get('page'),
		];

		$response = $this->JobOptionValueinfo->getJobOptionValue($this->api_token,$form_data);
		echo json_encode($response);
	}

	public function jobOptionValueInsertUpdate() {
		$recordOption = $this->input->post('recordOption');

        $form_data = [
            'job_option_id' => $this->input->post('job_option'),
			'bulk_copy_toggle' => $this->input->post('bulk_copy_toggle'),
			'copy_value_name_source' => $this->input->post('copy_value_name_source'),
			'option_valuebulk_copy_toggle' => $this->input->post('option_valuebulk_copy_toggle'),
			'option_bulk_copy_source' => $this->input->post('option_bulk_copy_source'),
			'begining_parent_id' => $this->input->post('begining_parent_id'),
			'value_name' => $this->input->post('value_name'),
			'parent_option_value_id' => $this->input->post('parent_option_value'),
			'is_active' => $this->input->post('status'),
			'branch_id' => $this->input->post('branch_id'),
			'recordID' => $this->input->post('recordID'),
        ];

	
		$response='';
		if($recordOption == '1'){
			$response = $this->JobOptionValueinfo->jobOptionValueInsert($this->api_token,$form_data);
		}else{
			$response = $this->JobOptionValueinfo->jobOptionValueUpdate($this->api_token,$form_data);
		}

		if ($response) {
			echo json_encode($response);
		}else{
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('JobOptionValue');
		}
    }

    public function jobOptionValueEdit($id) {
        $response = $this->JobOptionValueinfo->jobOptionValueEdit($this->api_token,$id);
		echo json_encode($response);
    }

	public function jobOptionValueDetailsList() {
		$job_option = $this->input->get('job_option');
		$modalOption = $this->input->get('modalOption', true) ?: '1';
		$editcheck = $this->input->get('editcheck');
		$statuscheck = $this->input->get('statuscheck');
		$deletecheck = $this->input->get('deletecheck');

        $response = $this->JobOptionValueinfo->jobOptionValueDetailsList($this->api_token,$job_option);

		$data['data'] = $response;
		$data['modalOption'] = $modalOption;
		$data['editcheck'] = $editcheck;
		$data['statuscheck'] = $statuscheck;
		$data['deletecheck'] = $deletecheck;

		$html = $this->load->view('components/table/job_option_value_table', $data, true);

		echo ($html);
    }

	public function jobOptionValueStatus($id, $status) {
        $form_data = [
            'recordID' => $id,
			'status' => $status,
        ];

        $response = $this->JobOptionValueinfo->jobOptionValueStatus($this->api_token,$form_data);

        if ($response) {
			echo json_encode($response);   
        } else {
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('JobOptionValue');
        }
    }

	public function jobOptionValueDelete($id) {
        $response = $this->JobOptionValueinfo->jobOptionValueDelete($this->api_token,$id);

        if ($response) {
			echo json_encode($response);     
        } else {
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('JobOptionValue');
        }
    }

	public function getImagesByCategory(){
		$form_data = [
			'category_id' => $this->input->post('category_id'),
			'btn_type' => $this->input->post('btn_type'),
		];

		$response = $this->JobOptionValueinfo->getImagesByCategory($this->api_token,$form_data);
		echo json_encode($response);
	}
}