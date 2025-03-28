<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Stitch_Style extends CI_Controller {
    public function index(){
        $this->load->model('Stitch_Styleinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('stitch_style', $result);
	}
    public function Stitch_Styleinsertupdate(){
		$this->load->model('Stitch_Styleinfo');
        $result=$this->Stitch_Styleinfo->Stitch_Styleinsertupdate();
	}
    public function Stitch_Stylestatus($x, $y){
		$this->load->model('Stitch_Styleinfo');
        $result=$this->Stitch_Styleinfo->Stitch_Stylestatus($x, $y);
	}
    public function Stitch_Styleedit(){
		$this->load->model('Stitch_Styleinfo');
        $result=$this->Stitch_Styleinfo->Stitch_Styleedit();
	}
}