<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Logo_Colour extends CI_Controller {
    public function index(){
        $this->load->model('Logo_Colourinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('logo_colour', $result);
	}
    public function Logo_Colourinsertupdate(){
		$this->load->model('Logo_Colourinfo');
        $result=$this->Logo_Colourinfo->Logo_Colourinsertupdate();
	}
    public function Logo_Colourstatus($x, $y){
		$this->load->model('Logo_Colourinfo');
        $result=$this->Logo_Colourinfo->Logo_Colourstatus($x, $y);
	}
    public function Logo_Colouredit(){
		$this->load->model('Logo_Colourinfo');
        $result=$this->Logo_Colourinfo->Logo_Colouredit();
	}
}