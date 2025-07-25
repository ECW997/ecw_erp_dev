<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class Customer extends CI_Controller {
	protected $api_token;
    protected $auth_user;

    public function __construct() {
        parent::__construct();
		$this->load->helper('api_helper');
        $this->load->model('Customerinfo');

		$auth_info = auth_check();
		$this->api_token = $auth_info['api_token'];
		$this->auth_user = $auth_info['user'];
    }
    public function index(){
        $this->load->model('Customerinfo');
		$this->load->model('Commeninfo');
        $result['brandlist']=$this->Customerinfo->Getvehiclebrand();
		$result['districtlist']=$this->Customerinfo->Getdistrict();
        // $result['model_list']=$this->Customerinfo->Getvehiclemodel_direct();
		$result['menuaccess'] = json_decode(json_encode($this->Commeninfo->getMenuPrivilege($this->api_token,'')['data'] ?? []));
		$this->load->view('customer', $result);
	}
    public function Customerinsertupdate(){
		$this->load->model('Customerinfo');
        $result=$this->Customerinfo->Customerinsertupdate();
	}
    public function Customerstatus($x, $y){
		$this->load->model('Customerinfo');
        $result=$this->Customerinfo->Customerstatus($x, $y);
	}
	public function Customer_vehiclestatus($x, $y){
		$this->load->model('Customerinfo');
        $result=$this->Customerinfo->Customer_vehiclestatus($x, $y);
	}
    public function Customeredit(){
		$this->load->model('Customerinfo');
        $result=$this->Customerinfo->Customeredit();
	}

	public function Customer_Vehicle_edit(){
		$this->load->model('Customerinfo');
        $result=$this->Customerinfo->Customer_Vehicle_edit();
	}
	public function Get_existing_customer(){
		$this->load->model('Customerinfo');
		$data = $this->Customerinfo->get_existing_customer();
        echo json_encode($data);
	}
    public function Getvehiclemodel(){
		$this->load->model('Customerinfo');
        $result=$this->Customerinfo->Getvehiclemodel();
	}
	public function addvehicle_detail(){
		$this->load->model('Customerinfo');
        $result=$this->Customerinfo->addvehicle_detail();
	}
	public function updatevehicle_detail(){
		$this->load->model('Customerinfo');
        $result=$this->Customerinfo->updatevehicle_detail();
	}
	public function quotationPDF(){
		$this->load->model('Customerinfo');
        $result=$this->Customerinfo->quotationPDF();
	}
	public function jobSummaryPDF(){
		$this->load->model('Customerinfo');
        $result=$this->Customerinfo->jobSummaryPDF();
	}
	public function invoicePDF(){
		$this->load->model('Customerinfo');
        $result=$this->Customerinfo->invoicePDF();
	}
}