<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Company extends CI_Controller {
    public function index(){
        $this->load->model('Companyinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('company', $result);
	}
    public function Companyinsertupdate(){
		$this->load->model('Companyinfo');
        $result=$this->Companyinfo->Companyinsertupdate();
	}
    public function Companystatus($x, $y){
		$this->load->model('Companyinfo');
        $result=$this->Companyinfo->Companystatus($x, $y);
	}
    public function Companyedit(){
		$this->load->model('Companyinfo');
        $result=$this->Companyinfo->Companyedit();
	}
	public function Getcompanybranch(){
		$this->load->model('Companyinfo');
        $result=$this->Companyinfo->Getcompanybranch();
	}
}