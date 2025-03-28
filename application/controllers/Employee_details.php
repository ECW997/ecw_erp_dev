<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Employee_details extends CI_Controller {
    public function index(){
        $this->load->model('Employee_detailsinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['brandlist']=$this->Employee_detailsinfo->Getvehiclebrand();
        $result['jobslist']=$this->Employee_detailsinfo->Getjobs();
		$this->load->view('employee_details', $result);
	}
    public function Job_price_details_insertupdate(){
		$this->load->model('Employee_detailsinfo');
        $result=$this->Employee_detailsinfo->Job_price_details_insertupdate();
	}
    public function Job_price_details_status($x, $y){
		$this->load->model('Employee_detailsinfo');
        $result=$this->Employee_detailsinfo->Job_price_details_status($x, $y);
	}
    public function Job_price_details_edit(){
		$this->load->model('Employee_detailsinfo');
        $result=$this->Employee_detailsinfo->Job_price_details_edit();
	}
	public function Getvehiclemodel(){
		$this->load->model('Employee_detailsinfo');
        $result=$this->Employee_detailsinfo->Getvehiclemodel();
	}
    public function Getvehicle_series_gen(){
		$this->load->model('Employee_detailsinfo');
        $result=$this->Employee_detailsinfo->Getvehicle_series_gen();
	}
    public function Getvehicletype(){
		$this->load->model('Employee_detailsinfo');
        $result=$this->Employee_detailsinfo->Getvehicletype();
	}
}