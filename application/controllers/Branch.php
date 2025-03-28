<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Branch extends CI_Controller {
    public function index(){
        $this->load->model('Branchinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['companylist']=$this->Branchinfo->Getcompany();
		$this->load->view('branch', $result);
	}
    public function Branchinsertupdate(){
		$this->load->model('Branchinfo');
        $result=$this->Branchinfo->Branchinsertupdate();
	}
    public function Branchstatus($x, $y){
		$this->load->model('Branchinfo');
        $result=$this->Branchinfo->Branchstatus($x, $y);
	}
    public function Branchedit(){
		$this->load->model('Branchinfo');
        $result=$this->Branchinfo->Branchedit();
	}
	// public function Getcompanybranch(){
	// 	$this->load->model('Branchinfo');
    //     $result=$this->Branchinfo->Getcompanybranch();
	// }
}