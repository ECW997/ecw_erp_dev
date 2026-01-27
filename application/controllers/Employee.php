<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');


class Employee extends CI_Controller {
	protected $api_token;
    protected $auth_user;

    public function __construct() {
        parent::__construct();
        $this->load->helper('api_helper');

        $auth_info = auth_check();
        $this->api_token = $auth_info['api_token'];
        $this->auth_user = $auth_info['user'];
    }

    public function index(){
        $this->load->model('Employeeinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess'] = json_decode(json_encode($this->Commeninfo->getMenuPrivilege($this->api_token,'')['data'] ?? []));
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
	public function EmployeeCsvUpload(){
		$this->load->model('Employeeinfo');
        $result=$this->Employeeinfo->EmployeeCsvUpload();
	}
}