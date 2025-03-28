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

        if ($response['status'] === true && isset($response['data']['api_token'])) {
            $loginData = $response['data'];

            $user_data = [
                'userid' => $loginData['id'],
                'name' => $loginData['name'],
                'typename' => 1,
                'email' => $loginData['email'],
                'api_token' => $loginData['api_token'],
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
}

?>