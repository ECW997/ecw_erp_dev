<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Hood_Material extends CI_Controller {
    public function index(){
        $this->load->model('Hood_Materialinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('hood_Material', $result);
	}
    public function Hood_Materialinsertupdate(){
		$this->load->model('Hood_Materialinfo');
        $result=$this->Hood_Materialinfo->Hood_Materialinsertupdate();
	}
    public function Hood_Materialstatus($x, $y){
		$this->load->model('Hood_Materialinfo');
        $result=$this->Hood_Materialinfo->Hood_Materialstatus($x, $y);
	}
    public function Hood_Materialedit(){
		$this->load->model('Hood_Materialinfo');
        $result=$this->Hood_Materialinfo->Hood_Materialedit();
	}
}