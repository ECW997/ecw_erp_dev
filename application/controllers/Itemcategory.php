<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Itemcategory extends CI_Controller {
    public function Itemcategorypage(){
		// $this->load->model('Itemcategoryinfo');
		$this->load->model('Commeninfo');
		// $result['usertype']=$this->Userinfo->Usertype();
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('itemcategory',$result);
	}
   
	public function Itemcategoryinsertupdate(){
		$this->load->model('Itemcategoyrinfo');
        $result=$this->Userinfo->Itemcategoryinsertupdate();
	}
	public function Itemcategoryedit(){
		$this->load->model('Itemcategoryinfo');
        $result=$this->Userinfo->Itemcategoryedit();
	}
	public function Itemcategorystatus($x, $y){
		$this->load->model('Itemcategoryinfo');
        $result=$this->Userinfo->Itemcategorystatus($x, $y);
	}
	
}