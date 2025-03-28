<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Vehicle_brand extends CI_Controller {
    public function index(){
        $this->load->model('Vehicle_brandinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('vehicle_brand', $result);
	}
    public function Vehicle_brandinsertupdate(){
		$this->load->model('Vehicle_brandinfo');
        $result=$this->Vehicle_brandinfo->Vehicle_brandinsertupdate();
	}
    public function Vehicle_brandstatus($x, $y){
		$this->load->model('Vehicle_brandinfo');
        $result=$this->Vehicle_brandinfo->Vehicle_brandstatus($x, $y);
	}
    public function Vehicle_brandedit(){
		$this->load->model('Vehicle_brandinfo');
        $result=$this->Vehicle_brandinfo->Vehicle_brandedit();
	}
	// public function Getcompanybranch(){
	// 	$this->load->model('Vehicle_brandinfo');
    //     $result=$this->Vehicle_brandinfo->Getcompanybranch();
	// }
}