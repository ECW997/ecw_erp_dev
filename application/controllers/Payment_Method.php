<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Payment_Method extends CI_Controller {
    public function index(){
        $this->load->model('Payment_Methodinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('payment_method', $result);
	}
    public function Payment_Methodinsertupdate(){
		$this->load->model('Payment_Methodinfo');
        $result=$this->Payment_Methodinfo->Payment_Methodinsertupdate();
	}
    public function Payment_Methodstatus($x, $y){
		$this->load->model('Payment_Methodinfo');
        $result=$this->Payment_Methodinfo->Payment_Methodstatus($x, $y);
	}
    public function Payment_Methodedit(){
		$this->load->model('Payment_Methodinfo');
        $result=$this->Payment_Methodinfo->Payment_Methodedit();
	}
}