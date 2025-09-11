<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class AssignEmployeeToJob extends CI_Controller {
	protected $api_token;
    protected $auth_user;
	
	public function __construct() {
        parent::__construct();
		$this->load->helper('api_helper');
        $this->load->model('JobOptioninfo');

		$auth_info = auth_check();
		$this->api_token = $auth_info['api_token'];
		$this->auth_user = $auth_info['user'];
    }

	public function index(){
		$this->load->model('Commeninfo');
		$result['menuaccess'] = json_decode(json_encode($this->Commeninfo->getMenuPrivilege($this->api_token,'')['data'] ?? []));
		$this->load->view('assign_employee_to_job', $result);
	}




    // public function index(){
    //     $this->load->model('AssignEmployeeToJobinfo');
	// 	$this->load->model('Commeninfo');
	// 	$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
	// 	$result['jobcardlist']=$this->AssignEmployeeToJobinfo->Getjobcard();
	// 	$result['companylist']=$this->AssignEmployeeToJobinfo->Getcompany();
	// 	$this->load->view('assign_employee_to_job', $result);
	// }
    // public function AssignEmployeeToJobinsertupdate(){
	// 	$this->load->model('AssignEmployeeToJobinfo');
    //     $result=$this->AssignEmployeeToJobinfo->AssignEmployeeToJobinsertupdate();
	// }
    // public function AssignEmployeeToJobstatus($x, $y){
	// 	$this->load->model('AssignEmployeeToJobinfo');
    //     $result=$this->AssignEmployeeToJobinfo->AssignEmployeeToJobstatus($x, $y);
	// }
    // public function AssignEmployeeToJobedit(){
	// 	$this->load->model('AssignEmployeeToJobinfo');
    //     $result=$this->AssignEmployeeToJobinfo->AssignEmployeeToJobedit();
	// }
	// public function getJobList(){
	// 	$this->load->model('AssignEmployeeToJobinfo');
    //     $result=$this->AssignEmployeeToJobinfo->getJobList();
	// }
	// public function AssignEmployeeToJobView(){
	// 	$this->load->model('AssignEmployeeToJobinfo');
    //     $result=$this->AssignEmployeeToJobinfo->AssignEmployeeToJobView();
	// }
	// public function department_list_sel2() {
	// 	if ($this->input->is_ajax_request()) {
	// 		$page = $this->input->get('page') ?? 1;
	// 		$company = $this->input->get('company');
	// 		$term = $this->input->get('term') ?? '';

	// 		$this->load->model('AssignEmployeeToJobinfo');

	// 		$result = $this->AssignEmployeeToJobinfo->department_list_sel2($company, $term, $page);
	
	// 		echo json_encode($result);
	// 	}
	// }

	// public function supervisor_list_sel2() {
	// 	if ($this->input->is_ajax_request()) {
	// 		$page = $this->input->get('page') ?? 1;
	// 		$department = $this->input->get('department');
	// 		$term = $this->input->get('term') ?? '';

	// 		$this->load->model('AssignEmployeeToJobinfo');

	// 		$result = $this->AssignEmployeeToJobinfo->supervisor_list_sel2($department, $term, $page);
	
	// 		echo json_encode($result);
	// 	}
	// }
	// public function insertupdateSupervisor(){
	// 	$this->load->model('AssignEmployeeToJobinfo');
    //     $result=$this->AssignEmployeeToJobinfo->insertupdateSupervisor();
	// }
	// public function AssignSupervisorToJobstatus(){
	// 	$this->load->model('AssignEmployeeToJobinfo');
    //     $result=$this->AssignEmployeeToJobinfo->AssignSupervisorToJobstatus();
	// }
}