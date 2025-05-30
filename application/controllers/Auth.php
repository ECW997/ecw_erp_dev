<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Authinfo');
    }

    public function LoginUser() {

        $form_data = [
            'email' => $this->input->post('username'),
            'password' => $this->input->post('password'),
            'company_id' => $this->input->post('company_id'),
            'branch_id' => $this->input->post('branch_id'),
            'company_name' => $this->input->post('company_text'),
            'company_branch_name' => $this->input->post('branch_text'),
        ];

        $response = $this->Authinfo->login($form_data);

        if ($response['status'] === true) {
            $loginData = $response['data'];
            $loginAuthorisation = $response['authorisation'];
            $user_data = [
                'userid' => $loginData['id'],
                'name' => $loginData['name'],
                'typename'=>$loginData['role'],
                'email' => $loginData['email'],
                'api_token' => $loginAuthorisation['token'],
                'employee_id' => $loginData['emp_id'],
                'emp_no' => $loginData['emp_no'],
                'company_id' => $this->input->post('company_id'),
                'companyname' => $this->input->post('company_text'),
                'branch_id' => $this->input->post('branch_id'),
                'branchname' => $this->input->post('branch_text'),
                'api_status' => $response['status'],
                'loggedin' => true
            ];

            $this->session->set_userdata($user_data);

            date_default_timezone_set('Asia/Colombo');
            $currentHour = date('H');
            $greeting = ($currentHour >= 5 && $currentHour < 12) ? "Good Morning" :
                        (($currentHour >= 12 && $currentHour < 17) ? "Good Afternoon" :
                        (($currentHour >= 17 && $currentHour < 21) ? "Good Evening" : "Welcome"));

            $this->session->set_flashdata('greeting_message', "$greeting, {$user_data['name']}. Welcome to ECW Software");

            redirect('Welcome/Dashboard');            
        } else {
            $this->session->set_flashdata('loginmsg', 'Invalid Username or Password');
            redirect();
        }
    }

    public function Logout(){
        $this->load->helper('api_helper');
        $auth_info = auth_check();
		$api_token = $auth_info['api_token'];
		$auth_user = $auth_info['user'];

        $this->session->unset_userdata('userid');
        $this->session->unset_userdata('name');
        $this->session->unset_userdata('typename');
		$this->session->unset_userdata('email');
		$this->session->unset_userdata('api_token');
		$this->session->unset_userdata('employee_id');
		$this->session->unset_userdata('emp_no');
		$this->session->unset_userdata('company_id');
		$this->session->unset_userdata('companyname');
        $this->session->unset_userdata('branch_id');
        $this->session->unset_userdata('branchname');
        $this->session->unset_userdata('api_status');
        $this->session->unset_userdata('loggedin');
        $this->cart->destroy();

        $response = $this->Authinfo->Logout($api_token);

        if ($response['status'] === true) {
            $this->session->set_flashdata('loginmsg', $response['message']);
            redirect(base_url());
         }
    }

	public function Dashboard(){
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('dashboard', $result);
	}

}

?>