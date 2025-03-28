<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Job_Done_Inquiry_Report extends CI_Controller {
    public function index(){
        $this->load->model('Reportinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['salespersonlist']=$this->Reportinfo->getSalesPerson();
		$result['inquirylist']=$this->Reportinfo->Getinquirysource();
		$this->load->view('job_done_inquiry_report', $result);
	}

	public function inquiry_summery_pdf(){
		$this->load->model('Reportinfo');
        $result=$this->Reportinfo->inquiry_summery_pdf();
	}

	public function jobdone_salesperson_change_pdf(){
		$this->load->model('Reportinfo');
        $result=$this->Reportinfo->jobdone_salesperson_change_pdf();
	}
}