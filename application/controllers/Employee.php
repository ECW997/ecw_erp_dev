<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Employee extends CI_Controller {
    public function index(){
        $this->load->model('Employeeinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['departmentlist']=$this->Employeeinfo->Getdepartment();
		$result['jobtitlelist']=$this->Employeeinfo->Getjobtitle();
		$this->load->view('employee', $result);
	}
    public function Employeeinsertupdate(){
		$this->load->model('Employeeinfo');
        $result=$this->Employeeinfo->Employeeinsertupdate();
	}
    public function Employeestatus($x, $y){
		$this->load->model('Employeeinfo');
        $result=$this->Employeeinfo->Employeestatus($x, $y);
	}
    public function Employeeedit(){
		$this->load->model('Employeeinfo');
        $result=$this->Employeeinfo->Employeeedit();
	}
	public function Getcompanybranch(){
		$this->load->model('Employeeinfo');
        $result=$this->Employeeinfo->Getcompanybranch();
	}
}