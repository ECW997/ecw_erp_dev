<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Logo extends CI_Controller {
    public function index(){
        $this->load->model('Logoinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('logo', $result);
	}
    public function Logoinsertupdate(){
		$this->load->model('Logoinfo');
        $result=$this->Logoinfo->Logoinsertupdate();
	}
    public function Logostatus($x, $y){
		$this->load->model('Logoinfo');
        $result=$this->Logoinfo->Logostatus($x, $y);
	}
    public function Logoedit(){
		$this->load->model('Logoinfo');
        $result=$this->Logoinfo->Logoedit();
	}
}