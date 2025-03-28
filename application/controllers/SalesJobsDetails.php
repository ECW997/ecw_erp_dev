<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class SalesJobsDetails extends CI_Controller {
    public function index(){
        $this->load->model('SalesJobsDetailsinfo');
		$this->load->model('Commeninfo');
		$result['jobtypelist']=$this->SalesJobsDetailsinfo->Getjobtype();
		$result['company_typelist']=$this->SalesJobsDetailsinfo->Getcompanytype();
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['mainjoblist']=$this->SalesJobsDetailsinfo->Getmainjob();
		$this->load->view('sales_jobs_details', $result);
	}
    public function SalesJobsDetailsinsertupdate(){
		$this->load->model('SalesJobsDetailsinfo');
        $result=$this->SalesJobsDetailsinfo->SalesJobsDetailsinsertupdate();
	}
    public function SalesJobsDetailsstatus($x, $y){
		$this->load->model('SalesJobsDetailsinfo');
        $result=$this->SalesJobsDetailsinfo->SalesJobsDetailsstatus($x, $y);
	}
    public function SalesJobsDetailsedit(){
		$this->load->model('SalesJobsDetailsinfo');
        $result=$this->SalesJobsDetailsinfo->SalesJobsDetailsedit();
	}
	public function Getsubjobcategory(){
		$this->load->model('SalesJobsDetailsinfo');
        $result=$this->SalesJobsDetailsinfo->Getsubjobcategory();
	}
}