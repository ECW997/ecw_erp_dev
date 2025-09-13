<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class AssignEmployeeToJob extends CI_Controller {
	protected $api_token;
    protected $auth_user;
	
	public function __construct() {
        parent::__construct();
		$this->load->helper('api_helper');
        $this->load->model('AssignEmployeeToJobinfo');

		$auth_info = auth_check();
		$this->api_token = $auth_info['api_token'];
		$this->auth_user = $auth_info['user'];
    }

	public function index(){
		$this->load->model('Commeninfo');
		$result['menuaccess'] = json_decode(json_encode($this->Commeninfo->getMenuPrivilege($this->api_token,'')['data'] ?? []));
		$this->load->view('assign_employee_to_job', $result);
	}

	public function getJobcardNumbers(){
		$form_data = [
			'term' => $this->input->get('term'),
			'page' => $this->input->get('page'),
		];

		$response = $this->AssignEmployeeToJobinfo->getJobcardNumbers($this->api_token,$form_data);
		echo json_encode($response);
	}


	

	public function getJobcardJobs() {
    $form_data = [
        'recordID' => $this->input->post('recordID')
    ];

    if (empty($form_data['recordID'])) {
        echo json_encode(['error' => 'No form data received']);
        return;
    }

    $response = $this->AssignEmployeeToJobinfo->getJobcardJobs($this->api_token, $form_data);
    echo json_encode($response);
}

    
}