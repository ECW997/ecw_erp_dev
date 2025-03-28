<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Price_category extends CI_Controller {
    public function index(){
        $this->load->model('Price_categoryinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('price_category', $result);
	}
    public function Price_categoryinsertupdate(){
		$this->load->model('Price_categoryinfo');
        $result=$this->Price_categoryinfo->Price_categoryinsertupdate();
	}
    public function Price_categorystatus($x, $y){
		$this->load->model('Price_categoryinfo');
        $result=$this->Price_categoryinfo->Price_categorystatus($x, $y);
	}
    public function Price_categoryedit(){
		$this->load->model('Price_categoryinfo');
        $result=$this->Price_categoryinfo->Price_categoryedit();
	}
}