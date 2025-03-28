<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Vehicle_generation extends CI_Controller {
    public function index(){
        $this->load->model('Vehicle_generationinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('vehicle_generation', $result);
	}
    public function Vehicle_generationinsertupdate(){
		$this->load->model('Vehicle_generationinfo');
        $result=$this->Vehicle_generationinfo->Vehicle_generationinsertupdate();
	}
    public function Vehicle_generationstatus($x, $y){
		$this->load->model('Vehicle_generationinfo');
        $result=$this->Vehicle_generationinfo->Vehicle_generationstatus($x, $y);
	}
    public function Vehicle_generationedit(){
		$this->load->model('Vehicle_generationinfo');
        $result=$this->Vehicle_generationinfo->Vehicle_generationedit();
	}
	// public function Getcompanybranch(){
	// 	$this->load->model('Vehicle_brandinfo');
    //     $result=$this->Vehicle_brandinfo->Getcompanybranch();
	// }
}