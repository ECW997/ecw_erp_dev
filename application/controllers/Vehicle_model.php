<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Vehicle_model extends CI_Controller {
    public function index(){
        $this->load->model('Vehicle_modelinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['brandlist']=$this->Vehicle_modelinfo->Getvehiclebrand();
		$result['typelist']=$this->Vehicle_modelinfo->Getvehicletype();
		$result['serieslist']=$this->Vehicle_modelinfo->Getvehicleseries();
		$result['generationlist']=$this->Vehicle_modelinfo->Getvehiclegeneration();
		$result['yearlist']=$this->Vehicle_modelinfo->Getvehicleyear();
		$result['price_categorylist']=$this->Vehicle_modelinfo->Getprice_category_type();
		$this->load->view('vehicle_model', $result);
	}
    public function Vehicle_modelinsertupdate(){
		$this->load->model('Vehicle_modelinfo');
        $result=$this->Vehicle_modelinfo->Vehicle_modelinsertupdate();
	}
    public function Vehicle_modelstatus($x, $y){
		$this->load->model('Vehicle_modelinfo');
        $result=$this->Vehicle_modelinfo->Vehicle_modelstatus($x, $y);
	}
    public function Vehicle_modeledit(){
		$this->load->model('Vehicle_modelinfo');
        $result=$this->Vehicle_modelinfo->Vehicle_modeledit();
	}
	public function Get_vehicle_brand(){
		$this->load->model('Vehicle_modelinfo');
		$data = $this->Vehicle_modelinfo->Get_vehicle_brand();

		echo json_encode($data);
	}
	public function Brand_insert(){
		$this->load->model('Vehicle_modelinfo');
        $result=$this->Vehicle_modelinfo->Brand_insert();
	}
}