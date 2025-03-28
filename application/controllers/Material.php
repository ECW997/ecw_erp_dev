<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Material extends CI_Controller {
    public function index(){
        $this->load->model('Materialinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('material', $result);
	}
    public function Materialinsertupdate(){
		$this->load->model('Materialinfo');
        $result=$this->Materialinfo->Materialinsertupdate();
	}
    public function Materialstatus($x, $y){
		$this->load->model('Materialinfo');
        $result=$this->Materialinfo->Materialstatus($x, $y);
	}
    public function Materialedit(){
		$this->load->model('Materialinfo');
        $result=$this->Materialinfo->Materialedit();
	}
}