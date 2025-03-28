<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class AssignEmployeeToJobDashboad extends CI_Controller {
    public function index(){
        // $this->load->model('Branchinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
		$this->load->view('employee_assign_dashboard', $result);
	}
}