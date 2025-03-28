<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Carpet extends CI_Controller {
    public function index(){
        $this->load->model('Carpetinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('carpet', $result);
	}
    public function Carpetinsertupdate(){
		$this->load->model('Carpetinfo');
        $result=$this->Carpetinfo->Carpetinsertupdate();
	}
    public function Carpetstatus($x, $y){
		$this->load->model('Carpetinfo');
        $result=$this->Carpetinfo->Carpetstatus($x, $y);
	}
    public function Carpetedit(){
		$this->load->model('Carpetinfo');
        $result=$this->Carpetinfo->Carpetedit();
	}
}