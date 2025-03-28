<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Vehicle_year extends CI_Controller {
    public function index(){
        $this->load->model('Vehicle_yearinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('vehicle_year', $result);
	}
    public function Vehicle_yearinsertupdate(){
		$this->load->model('Vehicle_yearinfo');
        $result=$this->Vehicle_yearinfo->Vehicle_yearinsertupdate();
	}
    public function Vehicle_yearstatus($x, $y){
		$this->load->model('Vehicle_yearinfo');
        $result=$this->Vehicle_yearinfo->Vehicle_yearstatus($x, $y);
	}
    public function Vehicle_yearedit(){
		$this->load->model('Vehicle_yearinfo');
        $result=$this->Vehicle_yearinfo->Vehicle_yearedit();
	}
	// public function Getcompanybranch(){
	// 	$this->load->model('Vehicle_brandinfo');
    //     $result=$this->Vehicle_brandinfo->Getcompanybranch();
	// }
}