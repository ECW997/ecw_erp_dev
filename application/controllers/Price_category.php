<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Price_category extends CI_Controller {
	protected $api_token;
    protected $auth_user;

    public function __construct() {
        parent::__construct();
		$this->load->helper('api_helper');
        $this->load->model('Price_categoryinfo');

		$auth_info = auth_check();
		$this->api_token = $auth_info['api_token'];
		$this->auth_user = $auth_info['user'];
    }

    public function index(){
        $this->load->model('Price_categoryinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess'] = json_decode(json_encode($this->Commeninfo->getMenuPrivilege($this->api_token,'')['data'] ?? []));
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