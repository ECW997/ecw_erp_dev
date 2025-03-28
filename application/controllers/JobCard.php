<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class JobCard extends CI_Controller {
    public function index(){
        $this->load->model('JobCardinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['brandlist']=$this->JobCardinfo->Getvehiclebrand();
        $result['mainjoblist']=$this->JobCardinfo->Getmainjob();
        $result['paymentlist']=$this->JobCardinfo->Getpayment_method();
        $result['materiallist']=$this->JobCardinfo->Getmaterial();
      
		$this->load->view('jobCard', $result);
	}
    public function JobCardinsertupdate(){
		$this->load->model('JobCardinfo');
        $result=$this->JobCardinfo->JobCardinsertupdate();
	}
    public function JobCardstatus($x, $y, $z){
		$this->load->model('JobCardinfo');
        $result=$this->JobCardinfo->JobCardstatus($x, $y, $z);
	}
    public function JobCardedit(){
		$this->load->model('JobCardinfo');
        $result=$this->JobCardinfo->JobCardedit();
	}
    public function getJobprice(){
		$this->load->model('JobCardinfo');
        $result=$this->JobCardinfo->getJobprice();
	}
    public function GetCustomerInquiry(){
		$this->load->model('JobCardinfo');
        $result=$this->JobCardinfo->GetCustomerInquiry();
	}
    public function GetInquiryDetails(){
		$this->load->model('JobCardinfo');
        $result=$this->JobCardinfo->GetInquiryDetails();
	}
    public function Getvehiclenumber(){
		$this->load->model('JobCardinfo');
        $result=$this->JobCardinfo->Getvehiclenumber();
	}
    public function GetcustomerName(){
		$this->load->model('JobCardinfo');
        $result=$this->JobCardinfo->GetcustomerName();
	}
    public function Getvehicleinformation(){
		$this->load->model('JobCardinfo');
        $result=$this->JobCardinfo->Getvehicleinformation();
	}
    
    public function getInquiryJobList(){
        $this->load->model('JobCardinfo');
        $result=$this->JobCardinfo->getInquiryJobList();
    }
    public function jobCardPDF(){
		$this->load->model('JobCardinfo');
        $result=$this->JobCardinfo->jobCardPDF();
	}


}