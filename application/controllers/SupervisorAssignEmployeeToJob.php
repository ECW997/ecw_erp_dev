<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class SupervisorAssignEmployeeToJob extends CI_Controller {
    public function index(){
        $this->load->model('SupervisorAssignEmployeeToJobinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['jobcardlist']=$this->SupervisorAssignEmployeeToJobinfo->Getjobcard();
		$result['companylist']=$this->SupervisorAssignEmployeeToJobinfo->Getcompany();
		$this->load->view('supervisor_assign_employee_to_job', $result);
	}
    public function SupervisorAssignEmployeeToJobinsertupdate(){
		$this->load->model('SupervisorAssignEmployeeToJobinfo');
        $result=$this->SupervisorAssignEmployeeToJobinfo->SupervisorAssignEmployeeToJobinsertupdate();
	}
    public function SupervisorAssignEmployeeToJobstatus($x, $y){
		$this->load->model('SupervisorAssignEmployeeToJobinfo');
        $result=$this->SupervisorAssignEmployeeToJobinfo->SupervisorAssignEmployeeToJobstatus($x, $y);
	}
    public function SupervisorAssignEmployeeToJobedit(){
		$this->load->model('SupervisorAssignEmployeeToJobinfo');
        $result=$this->SupervisorAssignEmployeeToJobinfo->SupervisorAssignEmployeeToJobedit();
	}
	public function getJobList(){
		$this->load->model('SupervisorAssignEmployeeToJobinfo');
        $result=$this->SupervisorAssignEmployeeToJobinfo->getJobList();
	}
	public function SupervisorAssignEmployeeToJobView(){
		$this->load->model('SupervisorAssignEmployeeToJobinfo');
        $result=$this->SupervisorAssignEmployeeToJobinfo->SupervisorAssignEmployeeToJobView();
	}
	public function department_list_sel2() {
		if ($this->input->is_ajax_request()) {
			$page = $this->input->get('page') ?? 1;
			$company = $this->input->get('company');
			$term = $this->input->get('term') ?? '';

			$this->load->model('SupervisorAssignEmployeeToJobinfo');

			$result = $this->SupervisorAssignEmployeeToJobinfo->department_list_sel2($company, $term, $page);
	
			echo json_encode($result);
		}
	}

	public function supervisor_list_sel2() {
		if ($this->input->is_ajax_request()) {
			$page = $this->input->get('page') ?? 1;
			$department = $this->input->get('department');
			$term = $this->input->get('term') ?? '';

			$this->load->model('SupervisorAssignEmployeeToJobinfo');

			$result = $this->SupervisorAssignEmployeeToJobinfo->supervisor_list_sel2($department, $term, $page);
	
			echo json_encode($result);
		}
	}
	public function insertupdateSupervisor(){
		$this->load->model('SupervisorAssignEmployeeToJobinfo');
        $result=$this->SupervisorAssignEmployeeToJobinfo->insertupdateSupervisor();
	}
	public function AssignSupervisorToJobstatus(){
		$this->load->model('SupervisorAssignEmployeeToJobinfo');
        $result=$this->SupervisorAssignEmployeeToJobinfo->AssignSupervisorToJobstatus();
	}
}