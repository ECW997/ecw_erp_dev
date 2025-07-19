<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class JobOptionGroup extends CI_Controller {
	protected $api_token;
    protected $auth_user;

    public function __construct() {
        parent::__construct();
		$this->load->helper('api_helper');
        $this->load->model('JobOptionGroupinfo');

		$auth_info = auth_check();
		$this->api_token = $auth_info['api_token'];
		$this->auth_user = $auth_info['user'];
    }

    public function index(){
		$this->load->model('Commeninfo');
		$result['menuaccess'] = json_decode(json_encode($this->Commeninfo->getMenuPrivilege($this->api_token,'')['data'] ?? []));
		$this->load->view('job_option_group', $result);
	}

	public function jobOptionGroupInsertUpdate() {
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
			$response = $this->JobOptionGroupinfo->jobOptionGroupInsert($this->api_token,$form_data);
		}else{
			$response = $this->JobOptionGroupinfo->jobOptionGroupUpdate($this->api_token,$form_data);
		}

		if ($response) {
			echo json_encode($response);
		}else{
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('JobOptionGroup');
		}
    }

    public function jobOptionGroupEdit($id) {
        $response = $this->JobOptionGroupinfo->jobOptionGroupEdit($this->api_token,$id);
		echo json_encode($response);
    }

	public function jobOptionGroupDetailsList() {
		$sub_id = $this->input->get('sub_id');
		$modalOption = $this->input->get('modalOption', true) ?: '1';
		$editcheck = $this->input->get('editcheck');
		$statuscheck = $this->input->get('statuscheck');
		$deletecheck = $this->input->get('deletecheck');

        $response = $this->JobOptionGroupinfo->jobOptionGroupDetailsList($this->api_token,$sub_id);

		$data['data'] = $response;
		$data['modalOption'] = $modalOption;
		$data['editcheck'] = $editcheck;
		$data['statuscheck'] = $statuscheck;
		$data['deletecheck'] = $deletecheck;

		$html = $this->load->view('components/table/job_option_group_table', $data, true);

		echo ($html);
    }


	public function jobOptionGroupStatus($id, $status) {
        $form_data = [
            'recordID' => $id,
			'status' => $status,
        ];

        $response = $this->JobOptionGroupinfo->jobOptionGroupStatus($this->api_token,$form_data);

        if ($response) {
			echo json_encode($response);    
        } else {
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('JobOptionGroup');
        }
    }

	public function jobOptionGroupDelete($id) {
        $response = $this->JobOptionGroupinfo->jobOptionGroupDelete($this->api_token,$id);

        if ($response) {
			echo json_encode($response);   
        } else {
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('JobOptionGroup');
        }
    }
}