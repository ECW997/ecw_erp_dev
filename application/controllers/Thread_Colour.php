<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Thread_Colour extends CI_Controller {
    public function index(){
        $this->load->model('Thread_Colourinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('thread_colour', $result);
	}
    public function Thread_Colourinsertupdate(){
		$this->load->model('Thread_Colourinfo');
        $result=$this->Thread_Colourinfo->Thread_Colourinsertupdate();
	}
    public function Thread_Colourstatus($x, $y){
		$this->load->model('Thread_Colourinfo');
        $result=$this->Thread_Colourinfo->Thread_Colourstatus($x, $y);
	}
    public function Thread_Colouredit(){
		$this->load->model('Thread_Colourinfo');
        $result=$this->Thread_Colourinfo->Thread_Colouredit();
	}
}