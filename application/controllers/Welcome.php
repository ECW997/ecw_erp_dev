<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		$this->load->view('login');
	}


	public function LoginUser() {
        $email = $this->input->post('username');
        $password = $this->input->post('password');
		$company_id = $this->input->post('company_id');
        $branch_id = $this->input->post('branch_id');
		$company_text = $this->input->post('company_text');
        $branch_text = $this->input->post('branch_text');

        $api_url = 'https://api.ecw.lk/api/login';

        $post_data = [
            'email' => $email,
            'password' => $password
        ];

        $response = $this->send_post_request($api_url, $post_data);
		// echo '<pre>';
		// 	print_r($response['loginData']);
		// 	print_r($response['loginData']['api_token']);
		// echo '</pre>';


		if (isset($response['loginData']['api_token'])) {
			$api_token = $response['loginData']['api_token'];
			if($response['loginData'] !== ''){
				$user_data=array(
					'userid'=>$response['loginData']['id'],
					'name'=>$response['loginData']['name'],
					'typename'=>1,
					'email'=>$response['loginData']['email'],
					'api_token'=>$response['loginData']['api_token'],
					'employee_id'=>$response['loginData']['emp_id'],
					'emp_no'=>$response['loginData']['emp_no'],
					'company_id'=>$company_id,
					'companyname'=>$company_text,
					'branch_id'=>$branch_id,
					'branchname'=>$branch_text,
					'loggedin'=>true
				);
	
				$this->session->set_userdata($user_data);
				
				date_default_timezone_set('Asia/Colombo'); // Set timezone to Sri Lanka
	
				$currentHour = date('H'); 
				$greeting = '';
				
				if ($currentHour >= 5 && $currentHour < 12) {
					$greeting = "Good Morning";
				} elseif ($currentHour >= 12 && $currentHour < 17) {
					$greeting = "Good Afternoon";
				} elseif ($currentHour >= 17 && $currentHour < 21) {
					$greeting = "Good Evening";
				} else {
					$greeting = "Welcome";
				}
				
				
				
				// $this->session->set_flashdata('greeting_message', $greeting . ", " . $user_data['name'] . ". Welcome to ECW Software");
				
				redirect('Welcome/Dashboard');            
			}
			else{
				$this->session->set_flashdata('msg', 'Invalid Username or password');
				redirect();
			}
		} else {
			echo "API token not found in response.";
		}
		
    }

	private function send_post_request($url, $data) {
        $ch = curl_init();  

        curl_setopt($ch, CURLOPT_URL, $url);  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
        curl_setopt($ch, CURLOPT_POST, true);  
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));  

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }

        curl_close($ch);

        return json_decode($response, true);  
    }
	 

	public function Logout(){
        $this->session->unset_userdata('userid');
        $this->session->unset_userdata('name');
        // $this->session->unset_userdata('type');
        $this->session->unset_userdata('typename');
		$this->session->unset_userdata('sale_person_id');
		$this->session->unset_userdata('employee_id');
		$this->session->unset_userdata('company_id');
		$this->session->unset_userdata('companyname');
		$this->session->unset_userdata('branch_id');
		$this->session->unset_userdata('branchname');
        $this->session->unset_userdata('loggedin');
        $this->cart->destroy();
        redirect(base_url());
    }
	public function Dashboard(){
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('dashboard', $result);
	}
}