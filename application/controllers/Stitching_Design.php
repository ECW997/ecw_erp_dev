<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Stitching_Design extends CI_Controller {
    public function index(){
        $this->load->model('Stitching_Designinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$result['price_categorylist']=$this->Stitching_Designinfo->Getprice_category_type();
		$this->load->view('stitching_design', $result);
	}
    public function Stitching_Designinsertupdate(){
		$this->load->model('Stitching_Designinfo');
        $result=$this->Stitching_Designinfo->Stitching_Designinsertupdate();
	}
    public function Stitching_Designstatus($x, $y){
		$this->load->model('Stitching_Designinfo');
        $result=$this->Stitching_Designinfo->Stitching_Designstatus($x, $y);
	}
    public function Stitching_Designedit(){
		$this->load->model('Stitching_Designinfo');
        $result=$this->Stitching_Designinfo->Stitching_Designedit();
	}
	public function AddPriceinsertupdate(){
		$this->load->model('Stitching_Designinfo');
        $result=$this->Stitching_Designinfo->AddPriceinsertupdate();
	}
	public function Priceremove(){
		$this->load->model('Stitching_Designinfo');
        $result=$this->Stitching_Designinfo->Priceremove();
	}
	public function PriceCategoryedit(){
		$this->load->model('Stitching_Designinfo');
        $result=$this->Stitching_Designinfo->PriceCategoryedit();
	}
}