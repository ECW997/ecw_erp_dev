<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Jobtitle extends CI_Controller {
    public function index(){
        $this->load->model('Jobtitleinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('jobtitle', $result);
	}
    public function Jobtitleinsertupdate(){
		$this->load->model('Jobtitleinfo');
        $result=$this->Jobtitleinfo->Jobtitleinsertupdate();
	}
    public function Jobtitlestatus($x, $y){
		$this->load->model('Jobtitleinfo');
        $result=$this->Jobtitleinfo->Jobtitlestatus($x, $y);
	}
    public function Jobtitleedit(){
		$this->load->model('Jobtitleinfo');
        $result=$this->Jobtitleinfo->Jobtitleedit();
	}
}