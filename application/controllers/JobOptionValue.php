<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class JobOptionValue extends CI_Controller {
	public function __construct() {
        parent::__construct();
        $this->load->model('JobOptionValueinfo');
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
		$this->load->view('job_option_value', $result);
	}

	public function getJobOption(){
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

		$response = $this->JobOptionValueinfo->getJobOption($api_token,$form_data);
		echo json_encode($response);
	}

	public function getJobOptionValue(){
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

		$response = $this->JobOptionValueinfo->getJobOptionValue($api_token,$form_data);
		echo json_encode($response);
	}

	public function jobOptionValueInsertUpdate() {
        $api_token = $this->session->userdata('api_token');
		if (!$api_token) {
			$this->session->set_flashdata(['res' => '401', 'msg' => 'Not authenticated']);
			redirect('Welcome/Logout');
			return;
		}

		$recordOption = $this->input->post('recordOption');

        $form_data = [
            'job_option_id' => $this->input->post('job_option'),
			'value_name' => $this->input->post('value_name'),
			'parent_option_value_id' => $this->input->post('parent_option_value'),
			'is_active' => $this->input->post('status'),
			'recordID' => $this->input->post('recordID'),
        ];

	
		$response='';
		if($recordOption == '1'){
			$response = $this->JobOptionValueinfo->jobOptionValueInsert($api_token,$form_data);
		}else{
			$response = $this->JobOptionValueinfo->jobOptionValueUpdate($api_token,$form_data);
		}

		if ($response) {
			echo json_encode($response);
			// $this->session->set_flashdata(['res' => $response['code'], 'msg' => $response['message']]);
        	// redirect('JobOptionValue');   
		}else{
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('JobOptionValue');
		}
    }

    public function jobOptionValueEdit($id) {
        $api_token = $this->session->userdata('api_token');
		if (!$api_token) {
			$this->session->set_flashdata(['res' => '401', 'msg' => 'Not authenticated']);
			redirect('Welcome/Logout');
			return;
		}

        $response = $this->JobOptionValueinfo->jobOptionValueEdit($api_token,$id);

		echo json_encode($response);
    }

	public function jobOptionValueDetailsList() {
        $api_token = $this->session->userdata('api_token');
		if (!$api_token) {
			$this->session->set_flashdata(['res' => '401', 'msg' => 'Not authenticated']);
			redirect('Welcome/Logout');
			return;
		}
		$job_option = $this->input->get('job_option');
		$modalOption = $this->input->get('modalOption', true) ?: '1';
		$editcheck = $this->input->get('editcheck');
		$statuscheck = $this->input->get('statuscheck');
		$deletecheck = $this->input->get('deletecheck');

        $response = $this->JobOptionValueinfo->jobOptionValueDetailsList($api_token,$job_option);

		$data['data'] = $response;
		$data['modalOption'] = $modalOption;
		$data['editcheck'] = $editcheck;
		$data['statuscheck'] = $statuscheck;
		$data['deletecheck'] = $deletecheck;

		$html = $this->load->view('components/table/job_option_value_table', $data, true);

		echo ($html);
    }

	public function jobOptionValueStatus($id, $status) {
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

        $response = $this->JobOptionValueinfo->jobOptionValueStatus($api_token,$form_data);

        if ($response) {
			echo json_encode($response);
			// $this->session->set_flashdata(['res' => $response['code'], 'msg' => $response['message']]);
			// redirect('JobOptionValue');      
        } else {
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('JobOptionValue');
        }
    }

	public function jobOptionValueDelete($id) {
        $api_token = $this->session->userdata('api_token');
		if (!$api_token) {
			$this->session->set_flashdata(['res' => '401', 'msg' => 'Not authenticated']);
			redirect('Welcome/Logout');
			return;
		}

        $response = $this->JobOptionValueinfo->jobOptionValueDelete($api_token,$id);

        if ($response) {
			echo json_encode($response);
			// $this->session->set_flashdata(['res' => $response['code'], 'msg' => $response['message']]);
			// redirect('JobOptionValue');      
        } else {
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('JobOptionValue');
        }
    }

	public function getImagesByCategory(){
		$api_token = $this->session->userdata('api_token');

		if (!$api_token) {
			$this->session->set_flashdata(['res' => '401', 'msg' => 'Not authenticated']);
			redirect('Welcome/Logout');
			return;
		}

		$form_data = [
			'category_id' => $this->input->post('category_id'),
			'btn_type' => $this->input->post('btn_type'),
		];

		$response = $this->JobOptionValueinfo->getImagesByCategory($api_token,$form_data);
		echo json_encode($response);
	}
}