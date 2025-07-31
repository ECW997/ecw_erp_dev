<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class User extends CI_Controller {
	protected $api_token;
    protected $auth_user;

    public function __construct() {
        parent::__construct();
		$this->load->helper('api_helper');
        $this->load->model('Userinfo');

		$auth_info = auth_check();
		$this->api_token = $auth_info['api_token'];
		$this->auth_user = $auth_info['user'];
    }

	// User Type
	public function Usertype(){
		$this->load->model('Commeninfo');
		$result['menuaccess'] = json_decode(json_encode($this->Commeninfo->getMenuPrivilege($this->api_token,'')['data'] ?? []));
		$this->load->view('usertype', $result);
	}
	public function userTypeInsertUpdate() {
		$recordOption = $this->input->post('recordOption');
		$form_data = [
			'usertype' => $this->input->post('usertype'),
			'recordID' => $this->input->post('recordID'),
		];

		$method = $recordOption == '1' ? 'userTypeInsert' : 'userTypeUpdate';
		$response = $this->Userinfo->$method($this->api_token, $form_data);
		$redirect_url = 'User/Usertype';
		$this->handleResponse($reredirect_url,$response);
	}

	public function userTypeEdit($id) {
		$response = $this->Userinfo->userTypeEdit($this->api_token, $id);
		echo json_encode($response);
	}

	public function userTypeStatus($id, $status) {
		$form_data = [
			'recordID' => $id,
			'status' => $status,
		];

		$response = $this->Userinfo->userTypeStatus($this->api_token, $form_data);
		$redirect_url = 'User/Usertype';
		$this->handleResponse($reredirect_url,$response);
	}

    public function userTypeDelete($id) {
		$response = $this->Userinfo->userTypeDelete($this->api_token, $id);
		$redirect_url = 'User/Usertype';
		$this->handleResponse($reredirect_url,$response);
	}

	// User Privilege
	public function Userprivilege(){
		$this->load->model('Userinfo');
		$this->load->model('Commeninfo');
		$result['users']=$this->Userinfo->getUsers($this->api_token,'')['data'];
		$result['usertype']=$this->Userinfo->getUserTypes($this->api_token,'')['data'];
		$result['menulist']=$this->Userinfo->getMenuList($this->api_token,'')['data'];
		$result['menuaccess'] = json_decode(json_encode($this->Commeninfo->getMenuPrivilege($this->api_token,'')['data'] ?? []));

		$this->load->view('userprivilege', $result);
	}
	public function privilegeInsertUpdate() {
		$recordOption = $this->input->post('recordOption');
		$form_data = [
			'userlist' => $this->input->post('userlist'),
			'menulist' => $this->input->post('menulist'),
			'addcheck' => $this->input->post('addcheck') ? 1 : 0,
			'editcheck' => $this->input->post('editcheck') ? 1 : 0,
			'statuscheck' => $this->input->post('statuscheck') ? 1 : 0,
			'removecheck' => $this->input->post('removecheck') ? 1 : 0,
			'cancelcheck' => $this->input->post('cancelcheck') ? 1 : 0,
			'approve1check' => $this->input->post('approve1check') ? 1 : 0,
			'approve2check' => $this->input->post('approve2check') ? 1 : 0,
			'approve3check' => $this->input->post('approve3check') ? 1 : 0,
			'approve4check' => $this->input->post('approve4check') ? 1 : 0,
			'recordID' => $this->input->post('recordID')
		];

		$method = $recordOption == '1' ? 'privilegeInsert' : 'privilegeUpdate';
		$response = $this->Userinfo->$method($this->api_token, $form_data);
		
		$redirect_url = 'User/Userprivilege';
		$this->handleResponse($redirect_url,$response);
	}

	public function privilegeEdit($id) {
		$response = $this->Userinfo->privilegeEdit($this->api_token, $id);
		echo json_encode($response);
	}

	public function privilegeStatus($id, $status) {
		$form_data = [
			'recordID' => $id,
			'status' => $status,
		];

		$response = $this->Userinfo->privilegeStatus($this->api_token, $form_data);
		$redirect_url = 'User/Userprivilege';
		$this->handleResponse($redirect_url,$response);
	}

    public function privilegeDelete($id) {
		$response = $this->Userinfo->privilegeDelete($this->api_token, $id);
		$redirect_url = 'User/Userprivilege';
		$this->handleResponse($redirect_url,$response);
	}

	// User Account
    public function Useraccount(){
		$this->load->model('Userinfo');
		$this->load->model('Commeninfo');
		$result['usertype']=$this->Userinfo->getUserTypes($this->api_token,'')['data'];
		$result['employeelist']=$this->Userinfo->getEmployee($this->api_token,'')['data'];
		$result['menuaccess'] = json_decode(json_encode($this->Commeninfo->getMenuPrivilege($this->api_token,'')['data'] ?? []));

		$this->load->view('useraccount', $result);
		
	}
	public function userAccountInsertUpdate() {
		$recordOption = $this->input->post('recordOption');
		$form_data = [
			'company_id' => $this->input->post('company_id'),
			'branch_id' => $this->input->post('branch_id'),
			'employee' => $this->input->post('employee'),
			'accountname' => $this->input->post('accountname'),
			'username' => $this->input->post('username'),
			'password' => $this->input->post('password'),
			'usertype' => $this->input->post('usertype')
		];

		$method = $recordOption == '1' ? 'userAccountInsert' : 'userAccountUpdate';
		$response = $this->Userinfo->$method($this->api_token, $form_data);
		
		$redirect_url = 'User/Useraccount';
		$this->handleResponse($redirect_url,$response);
	}
	public function userAccountEdit($id) {
		$response = $this->Userinfo->userAccountEdit($this->api_token,$id);
		echo json_encode($response);
	}
	public function userAccountStatus($id, $status) {
		$form_data = [
			'recordID' => $id,
			'status' => $status,
		];

		$response = $this->Userinfo->userAccountStatus($this->api_token, $form_data);
		$redirect_url = 'User/Useraccount';
		$this->handleResponse($redirect_url,$response);
	}
	public function userAccountDelete($id) {
		$response = $this->Userinfo->userAccountDelete($this->api_token, $id);
		$redirect_url = 'User/Useraccount';
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




	// public function Useraccountinsertupdate(){
	// 	$this->load->model('Userinfo');
    //     $result=$this->Userinfo->Useraccountinsertupdate();
	// }
	// public function Useraccountedit(){
	// 	$this->load->model('Userinfo');
    //     $result=$this->Userinfo->Useraccountedit();
	// }
	// public function Useraccountstatus($x, $y){
	// 	$this->load->model('Userinfo');
    //     $result=$this->Userinfo->Useraccountstatus($x, $y);
	// }
	// public function Getemployeedetails(){
	// 	$this->load->model('Userinfo');
    //     $result=$this->Userinfo->Getemployeedetails();
	// }
	// public function Usertypeedit(){
	// 	$this->load->model('Userinfo');
    //     $result=$this->Userinfo->Usertypeedit();
	// }
	// public function Usertypeinsertupdate(){
	// 	$this->load->model('Userinfo');
    //     $result=$this->Userinfo->Usertypeinsertupdate();
	// }
	// public function Usertypestatus($x, $y){
	// 	$this->load->model('Userinfo');
    //     $result=$this->Userinfo->Usertypestatus($x, $y);
	// }
	// public function Userprivilegeinsertupdate(){
	// 	$this->load->model('Userinfo');
    //     $result=$this->Userinfo->Userprivilegeinsertupdate();
	// }
	// public function Userprivilegeedit(){
	// 	$this->load->model('Userinfo');
    //     $result=$this->Userinfo->Userprivilegeedit();
	// }
	// public function Userprivilegestatus($x, $y){
	// 	$this->load->model('Userinfo');
    //     $result=$this->Userinfo->Userprivilegestatus($x, $y);
	// }
}