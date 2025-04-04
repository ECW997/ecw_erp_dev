<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class JobOptionGroup extends CI_Controller {
	public function __construct() {
        parent::__construct();
        $this->load->model('JobOptionGroupinfo');
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
		$this->load->view('job_option_group', $result);
	}

	public function jobOptionGroupInsertUpdate() {
        $api_token = $this->session->userdata('api_token');
		if (!$api_token) {
			$this->session->set_flashdata(['res' => '401', 'msg' => 'Not authenticated']);
			redirect('Welcome/Logout');
			return;
		}

		$recordOption = $this->input->post('recordOption');

        $form_data = [
            'sub_job_category_id' => $this->input->post('sub_job_category'),
			'group_name' => $this->input->post('group_name'),
			'sort_order' => $this->input->post('sort_order'),
			'description' => $this->input->post('description'),
			'recordID' => $this->input->post('recordID'),
        ];

	
		$response='';
		if($recordOption == '1'){
			$response = $this->JobOptionGroupinfo->jobOptionGroupInsert($api_token,$form_data);
		}else{
			$response = $this->JobOptionGroupinfo->jobOptionGroupUpdate($api_token,$form_data);
		}

		if ($response) {
			echo json_encode($response);
			// $this->session->set_flashdata(['res' => $response['code'], 'msg' => $response['message']]);
        	// redirect('JobOptionGroup');   
		}else{
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('JobOptionGroup');
		}
    }

    public function jobOptionGroupEdit($id) {
        $api_token = $this->session->userdata('api_token');
		if (!$api_token) {
			$this->session->set_flashdata(['res' => '401', 'msg' => 'Not authenticated']);
			redirect('Welcome/Logout');
			return;
		}

        $response = $this->JobOptionGroupinfo->jobOptionGroupEdit($api_token,$id);

		echo json_encode($response);
    }

	public function jobOptionGroupDetailsList() {
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

        $response = $this->JobOptionGroupinfo->jobOptionGroupDetailsList($api_token,$sub_id);

		$data['data'] = $response;
		$data['modalOption'] = $modalOption;
		$data['editcheck'] = $editcheck;
		$data['statuscheck'] = $statuscheck;
		$data['deletecheck'] = $deletecheck;

		$html = $this->load->view('components/table/job_option_group_table', $data, true);

		echo ($html);
    }


	public function jobOptionGroupStatus($id, $status) {
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

        $response = $this->JobOptionGroupinfo->jobOptionGroupStatus($api_token,$form_data);

        if ($response) {
			echo json_encode($response);
			// $this->session->set_flashdata(['res' => $response['code'], 'msg' => $response['message']]);
			// redirect('JobOptionGroup');      
        } else {
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('JobOptionGroup');
        }
    }

	public function jobOptionGroupDelete($id) {
        $api_token = $this->session->userdata('api_token');
		if (!$api_token) {
			$this->session->set_flashdata(['res' => '401', 'msg' => 'Not authenticated']);
			redirect('Welcome/Logout');
			return;
		}

        $response = $this->JobOptionGroupinfo->jobOptionGroupDelete($api_token,$id);

        if ($response) {
			echo json_encode($response);
			// $this->session->set_flashdata(['res' => $response['code'], 'msg' => $response['message']]);
			// redirect('JobOptionGroup');      
        } else {
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('JobOptionGroup');
        }
    }
}