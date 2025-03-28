<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Leather_Type extends CI_Controller {
    public function index(){
        $this->load->model('Leather_Typeinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('leather_Type', $result);
	}
    public function Leather_Typeinsertupdate(){
		$this->load->model('Leather_Typeinfo');
        $result=$this->Leather_Typeinfo->Leather_Typeinsertupdate();
	}
    public function Leather_Typestatus($x, $y){
		$this->load->model('Leather_Typeinfo');
        $result=$this->Leather_Typeinfo->Leather_Typestatus($x, $y);
	}
    public function Leather_Typeedit(){
		$this->load->model('Leather_Typeinfo');
        $result=$this->Leather_Typeinfo->Leather_Typeedit();
	}
}