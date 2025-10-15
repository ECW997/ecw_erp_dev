<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class User_v2 extends CI_Controller {
	protected $api_token;
    protected $auth_user;

    public function __construct() {
        parent::__construct();
		$this->load->helper('api_helper');
        $this->load->model('User_v2_info');
		$this->load->model('Roleinfo');
		$this->load->model('Commeninfo');

		$auth_info = auth_check();
		$this->api_token = $auth_info['api_token'];
		$this->auth_user = $auth_info['user'];
    }
	
	public function index(){
		$result['menuaccess'] = json_decode(json_encode($this->Commeninfo->getMenuPrivilege($this->api_token,'')['data'] ?? []));
		$result['permissions'] = json_decode(json_encode($this->Commeninfo->getPermission($this->api_token,'')['data'] ?? []));
		$userApiResponse = $this->User_v2_info->getUsers($this->api_token, []);
        $result['roles'] = $userApiResponse['roles'] ?? [];
		$result['users'] = $userApiResponse['data'] ?? [];

		$this->load->view('user/index', $result);
		
	}

	public function create() {
		$form_data = [
			'name' => $this->input->post('name'),
            'email' => $this->input->post('email'),
			'password' => $this->input->post('password'),
			'roles' => $this->input->post('roles'),
			'company_id' => $this->input->post('company_id'),
			'branch_id' => $this->input->post('branch_id')
        ];
		$response = $this->User_v2_info->create($this->api_token,$form_data);

		echo json_encode($response);
		$redirect_url = 'User_v2/index';
		$this->handleResponse($redirect_url,$response);
	}

	public function update() {
		$form_data = [
			'recordID' => $this->input->post('recordID'),
			'editName' => $this->input->post('editName'),
            'editEmail' => $this->input->post('editEmail'),
			'editPassword' => $this->input->post('editPassword'),
			'editRoles' => $this->input->post('editRoles'),
			'editCompany_id' => $this->input->post('editCompany_id'),
			'editBranch_id' => $this->input->post('editBranch_id')
        ];
		$response = $this->User_v2_info->Update($this->api_token,$form_data);

		$redirect_url = 'User_v2/index';
		$this->handleResponse($redirect_url,$response);
	}

	public function edit($id) {
		$response = $this->User_v2_info->edit($this->api_token,$id);
		echo json_encode($response);
	}

	public function delete($id) {
		$response = $this->User_v2_info->delete($this->api_token,$id);
		$redirect_url = 'User_v2/index';
		$this->handleResponse($redirect_url,$response);
	}

	public function activate($id) {
		$form_data = [
			'recordID' => $id,
        ];
		$response = $this->User_v2_info->activate($this->api_token,$form_data);
		$redirect_url = 'User_v2/index';
		$this->handleResponse($redirect_url,$response);
	}

	public function deactivate($id) {
		$form_data = [
			'recordID' => $id,
        ];
		$response = $this->User_v2_info->deactivate($this->api_token,$form_data);
		$redirect_url = 'User_v2/index';
		$this->handleResponse($redirect_url,$response);
	}

	public function permissions($id) {
		$response = $this->User_v2_info->permissions($this->api_token,$id);
		echo json_encode($response);
	}

	private function handleResponse($redirect_url,$response) {
		if (!$response) {
			$this->setFlashResponse('204', 'Not Response Server!', $redirect_url);
			return;
		}

		$this->setFlashResponse($response['code'], $response['message'], $redirect_url);
	}

	private function setFlashResponse($code, $message,$redirect_url) {
		$this->session->set_flashdata([
			'res' => $code, 
			'msg' => $message
		]);
		redirect($redirect_url);
	}
}