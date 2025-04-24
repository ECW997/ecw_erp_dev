<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Job_price_details extends CI_Controller {
    public function index(){
        $this->load->model('Job_price_detailsinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['price_categorylist']=$this->Job_price_detailsinfo->Getprice_category_type();
		// $result['repair_typelist']=$this->Job_price_detailsinfo->Getrepair_type();
		$result['seat_conditionlist']=$this->Job_price_detailsinfo->Getseat_condition();
		$result['mainjoblist']=$this->Job_price_detailsinfo->Getmainjob();
        $result['jobslist']=$this->Job_price_detailsinfo->Getjobs();
		$result['materiallist']=$this->Job_price_detailsinfo->Getmaterial();
		$this->load->view('job_price_details', $result);
	}
    public function Job_price_details_insertupdate(){
		$this->load->model('Job_price_detailsinfo');
        $result=$this->Job_price_detailsinfo->Job_price_details_insertupdate();
	}
    public function Job_price_details_status($x, $y){
		$this->load->model('Job_price_detailsinfo');
        $result=$this->Job_price_detailsinfo->Job_price_details_status($x, $y);
	}
    public function Job_price_details_edit(){
		$this->load->model('Job_price_detailsinfo');
        $result=$this->Job_price_detailsinfo->Job_price_details_edit();
	}
	public function Job_price_detailsjoblistedit(){
		$this->load->model('Job_price_detailsinfo');
        $result=$this->Job_price_detailsinfo->Job_price_detailsjoblistedit();
	}
	public function Job_detailsview(){
		$this->load->model('Job_price_detailsinfo');
        $result=$this->Job_price_detailsinfo->Job_detailsview();
	}
	public function Job_detailviewheader(){
		$this->load->model('Job_price_detailsinfo');
        $result=$this->Job_price_detailsinfo->Job_detailviewheader();
	}
	public function Job_price_details_editjobedit(){
		$this->load->model('Job_price_detailsinfo');
        $result=$this->Job_price_detailsinfo->Job_price_details_editjobedit();
	}
	public function job_price_details_pdf(){
		$this->load->model('Job_price_detailsinfo');
        $result=$this->Job_price_detailsinfo->job_price_details_pdf();
	}
	public function Getsalesjobdetails(){
		$this->load->model('Job_price_detailsinfo');
        $result=$this->Job_price_detailsinfo->Getsalesjobdetails();
	}
	public function Get_repair_type(){
		$this->load->model('Job_price_detailsinfo');
        $result=$this->Job_price_detailsinfo->Get_repair_type();
	}
	public function Getseat_type(){
		$this->load->model('Job_price_detailsinfo');
        $result=$this->Job_price_detailsinfo->Getseat_type();
	}
}