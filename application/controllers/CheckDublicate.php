<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class CheckDublicate extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('CheckDublicateinfo');
    }

    public function check_duplicate() {
        $api_token = $this->session->userdata('api_token');
        if (!$api_token) {
			$this->session->set_flashdata(['res' => '401', 'msg' => 'Not authenticated']);
			redirect('Welcome/Logout');
			return;
		}

        $form_data = [
            'input_value' => $this->input->post('input_value'),
			'column_name' => $this->input->post('column_name'),
			'table_name' => $this->input->post('table_name'),
        ];
 
        $response = $this->CheckDublicateinfo->is_duplicate($api_token,$form_data);
        if ($response) {
			echo json_encode($response);
		}else{
			$this->session->set_flashdata(['res' => '204', 'msg' => 'Not Response Server!']);
            redirect('JobOptionGroup');
		}

    }
}