<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Vehicle extends CI_Controller {
    public function index(){
	    $this->load->model('Vehicleinfo');
		$this->load->model('Commeninfo');
		 $result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		 $result['Vehicletype']=$this->Vehicleinfo->Getvehicletype();
         $result['Vehiclebrand']=$this->Vehicleinfo->Getvehiclebrand();
         $result['Vehiclemodel']=$this->Vehicleinfo->Getvehiclemodel();
		$this->load->view('vehicle',$result);
	}
   
	public function Vehicleinsertupdate(){
		$this->load->model('Vehicleinfo');
        $result=$this->Vehicleinfo->Vehicleinsertupdate();
	}
	public function Vehicleedit(){
		$this->load->model('Vehicleinfo');
        $result=$this->Vehicleinfo->Vehicleedit();
	}
	public function Vehiclestatus($x, $y){
		$this->load->model('Vehicleinfo');
        $result=$this->Vehicleinfo->Vehiclestatus($x, $y);
	}
	
}