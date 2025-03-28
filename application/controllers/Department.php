<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Department extends CI_Controller {
    public function index(){
        $this->load->model('Departmentinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['companylist']=$this->Departmentinfo->Getcompany();
		$this->load->view('department', $result);
	}
    public function Departmentinsertupdate(){
		$this->load->model('Departmentinfo');
        $result=$this->Departmentinfo->Departmentinsertupdate();
	}
    public function Departmentstatus($x, $y){
		$this->load->model('Departmentinfo');
        $result=$this->Departmentinfo->Departmentstatus($x, $y);
	}
    public function Departmentedit(){
		$this->load->model('Departmentinfo');
        $result=$this->Departmentinfo->Departmentedit();
	}
}