<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Dashboard extends CI_Controller {
    public function index(){
        $this->load->model('Dashboardinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		// $result['salespersonlist']=$this->Dashboardinfo->getSalesPerson();
		// $result['inquirylist']=$this->Dashboardinfo->Getinquirysource();
		$this->load->view('dashboard', $result);
	}

    public function GetTotalFoodCost(){
		$this->load->model('Dashboardinfo');
        $result=$this->Dashboardinfo->GetTotalFoodCost();
	}
    public function GetTotalTransportCost(){
		$this->load->model('Dashboardinfo');
        $result=$this->Dashboardinfo->GetTotalTransportCost();
    }
}