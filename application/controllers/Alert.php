<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Alert extends CI_Controller {
    public function get_alert_data(){
		$this->load->model('Alertinfo');
        $result=$this->Alertinfo->get_alert_data();
	}

    public function get_today_active_second_alert_data(){
		$this->load->model('Alertinfo');
        $result=$this->Alertinfo->get_today_active_second_alert_data();
	}

  public function get_today_active_first_alert_data(){
		$this->load->model('Alertinfo');
        $result=$this->Alertinfo->get_today_active_first_alert_data();
	}
}