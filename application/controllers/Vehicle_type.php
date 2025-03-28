<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Vehicle_type extends CI_Controller {
    public function index(){
        $this->load->model('Vehicle_typeinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('vehicle_type', $result);
	}
    public function Vehicle_typeinsertupdate(){
		$this->load->model('Vehicle_typeinfo');
        $result=$this->Vehicle_typeinfo->Vehicle_typeinsertupdate();
	}
    public function Vehicle_typestatus($x, $y){
		$this->load->model('Vehicle_typeinfo');
        $result=$this->Vehicle_typeinfo->Vehicle_typestatus($x, $y);
	}
    public function Vehicle_typeedit(){
		$this->load->model('Vehicle_typeinfo');
        $result=$this->Vehicle_typeinfo->Vehicle_typeedit();
	}
	// public function Getcompanybranch(){
	// 	$this->load->model('Vehicle_brandinfo');
    //     $result=$this->Vehicle_brandinfo->Getcompanybranch();
	// }
}