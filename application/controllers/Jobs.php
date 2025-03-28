<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Jobs extends CI_Controller {
    public function index(){
        $this->load->model('Jobsinfo');
		$this->load->model('Commeninfo');
		$result['jobtypelist']=$this->Jobsinfo->Getjobtype();
		$result['company_typelist']=$this->Jobsinfo->Getcompanytype();
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['mainjoblist']=$this->Jobsinfo->Getmainjob();
		$this->load->view('jobs', $result);
	}
    public function Jobsinsertupdate(){
		$this->load->model('Jobsinfo');
        $result=$this->Jobsinfo->Jobsinsertupdate();
	}
    public function Jobsstatus($x, $y){
		$this->load->model('Jobsinfo');
        $result=$this->Jobsinfo->Jobsstatus($x, $y);
	}
    public function Jobsedit(){
		$this->load->model('Jobsinfo');
        $result=$this->Jobsinfo->Jobsedit();
	}
	public function Getsubjobcategory(){
		$this->load->model('Jobsinfo');
        $result=$this->Jobsinfo->Getsubjobcategory();
	}
}