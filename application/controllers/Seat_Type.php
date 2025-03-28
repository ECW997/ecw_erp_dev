<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Seat_Type extends CI_Controller {
    public function index(){
        $this->load->model('Seat_Typeinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['assessorylist']=$this->Seat_Typeinfo->Getseat_category();
		$this->load->view('seat_type', $result);
	}
    public function Seat_Typeinsertupdate(){
		$this->load->model('Seat_Typeinfo');
        $result=$this->Seat_Typeinfo->Seat_Typeinsertupdate();
	}
    public function Seat_Typestatus($x, $y){
		$this->load->model('Seat_Typeinfo');
        $result=$this->Seat_Typeinfo->Seat_Typestatus($x, $y);
	}
    public function Seat_Typeedit(){
		$this->load->model('Seat_Typeinfo');
        $result=$this->Seat_Typeinfo->Seat_Typeedit();
	}
}