<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class UserRole extends CI_Controller {
	protected $api_token;
    protected $auth_user;

    public function __construct() {
        parent::__construct();
		$this->load->helper('api_helper');
        $this->load->model('Roleinfo');
		$this->load->model('Commeninfo');

		$auth_info = auth_check();
		$this->api_token = $auth_info['api_token'];
		$this->auth_user = $auth_info['user'];
    }
	
	public function index(){
		$result['menuaccess'] = json_decode(json_encode($this->Commeninfo->getMenuPrivilege($this->api_token,'')['data'] ?? []));
		$result['permissions'] = json_decode(json_encode($this->Commeninfo->getPermission($this->api_token,'')['data'] ?? []));
		$rolesApiResponse = $this->Roleinfo->getUserRoles($this->api_token, []);
        $result['roles'] = $rolesApiResponse['data'] ?? [];

		$this->load->view('role/index', $result);
		
	}

	public function create() {
		$form_data = [
			'role' => $this->input->post('role')
        ];
		$response = $this->Roleinfo->create($this->api_token,$form_data);
		
		$redirect_url = 'UserRole/index';
		$this->handleResponse($redirect_url,$response);
	}

	public function update() {
		$form_data = [
			'recordID' => $this->input->post('recordID'),
			'editRoleName' => $this->input->post('editRoleName')
        ];
		$response = $this->Roleinfo->Update($this->api_token,$form_data);
		
		$redirect_url = 'UserRole/index';
		$this->handleResponse($redirect_url,$response);
	}

	public function edit($id) {
		$response = $this->Roleinfo->edit($this->api_token,$id);
		echo json_encode($response);
	}

	public function delete($id) {
		$response = $this->Roleinfo->delete($this->api_token,$id);
		$redirect_url = 'UserRole/index';
		$this->handleResponse($redirect_url,$response);
	}

	public function permissions($id) {
		$response = $this->Roleinfo->permissions($this->api_token,$id);
		echo json_encode($response);
	}

	public function updatePermission($id) {
		$form_data = [
			'recordID' 	  => $id,
			'permissions' => $this->input->post('permissions')
        ];
		
		$response = $this->Roleinfo->updatePermission($this->api_token,$form_data);

		$redirect_url = 'UserRole/index';
		$this->handleResponse($redirect_url,$response);
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