<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Vehicle_series extends CI_Controller {
    public function index(){
        $this->load->model('Vehicle_seriesinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('vehicle_series', $result);
	}
    public function Vehicle_seriesinsertupdate(){
		$this->load->model('Vehicle_seriesinfo');
        $result=$this->Vehicle_seriesinfo->Vehicle_seriesinsertupdate();
	}
    public function Vehicle_seriesstatus($x, $y){
		$this->load->model('Vehicle_seriesinfo');
        $result=$this->Vehicle_seriesinfo->Vehicle_seriesstatus($x, $y);
	}
    public function Vehicle_seriesedit(){
		$this->load->model('Vehicle_seriesinfo');
        $result=$this->Vehicle_seriesinfo->Vehicle_seriesedit();
	}
	// public function Getcompanybranch(){
	// 	$this->load->model('Vehicle_brandinfo');
    //     $result=$this->Vehicle_brandinfo->Getcompanybranch();
	// }
}