<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Colombo');

class JobCard_information extends CI_Controller {
    public function index(){
        $this->load->model('JobCard_informationinfo');
		$this->load->model('Commeninfo');
		$result['menuaccess']=$this->Commeninfo->Getmenuprivilege();
        $result['logo_colorlist']=$this->JobCard_informationinfo->Getlogo_color();
        $result['thread_colorlist']=$this->JobCard_informationinfo->Getthread_color();
        $result['stitch_stylelist']=$this->JobCard_informationinfo->Getstitch_style();
        $result['price_categorylist']=$this->JobCard_informationinfo->Getprice_category_type();
        $result['categorytypelist']=$this->JobCard_informationinfo->Getcategory_type();
        $result['repairtypelist']=$this->JobCard_informationinfo->Getrepair_type();
        $result['seat_conditionlist']=$this->JobCard_informationinfo->Getseat_condition();
        $result['mainjoblist']=$this->JobCard_informationinfo->Getmainjob();
        $result['logolist']=$this->JobCard_informationinfo->Getlogo();
        $result['comfort_layerlist']=$this->JobCard_informationinfo->Getcomfort_layer();
        $result['logo_status_list']=$this->JobCard_informationinfo->Getlogo_status();
        $result['materiallist']=$this->JobCard_informationinfo->Getmaterial();
        $result['assessorylist']=$this->JobCard_informationinfo->Getassesory();
		$this->load->view('jobCard_information', $result);
	}
    public function JobCard_informationinsertupdate(){
		$this->load->model('JobCard_informationinfo');
        $result=$this->JobCard_informationinfo->JobCard_informationinsertupdate();
	}
    public function JobCardstatus($x, $y){
		$this->load->model('JobCard_informationinfo');
        $result=$this->JobCard_informationinfo->JobCardstatus($x, $y);
	}
    public function JobCardedit(){
		$this->load->model('JobCard_informationinfo');
        $result=$this->JobCard_informationinfo->JobCardedit();
	}
    public function getJobprice(){
		$this->load->model('JobCard_informationinfo');
        $result=$this->JobCard_informationinfo->getJobprice();
	}

    public function get_japanseat_Jobprice(){
		$this->load->model('JobCard_informationinfo');
        $result=$this->JobCard_informationinfo->get_japanseat_Jobprice();
	}

    public function Getsalesjobdetails(){
		$this->load->model('JobCard_informationinfo');
        $result=$this->JobCard_informationinfo->Getsalesjobdetails();
	}

    public function Get_japanseat_jobdetails(){
		$this->load->model('JobCard_informationinfo');
        $result=$this->JobCard_informationinfo->Get_japanseat_jobdetails();
	}

    public function Getvehiclenumber(){
		$this->load->model('JobCard_informationinfo');
        $result=$this->JobCard_informationinfo->Getvehiclenumber();
	}
    public function GetjobcardNumber(){
		$this->load->model('JobCard_informationinfo');
        $result=$this->JobCard_informationinfo->GetjobcardNumber();
	}
    public function GetvehicleModel(){
		$this->load->model('JobCard_informationinfo');
        $result=$this->JobCard_informationinfo->GetvehicleModel();
	}
    public function GetPrice_cat(){
		$this->load->model('JobCard_informationinfo');
        $result=$this->JobCard_informationinfo->GetPrice_cat();
	}
    public function GetdesignPrice(){
		$this->load->model('JobCard_informationinfo');
        $result=$this->JobCard_informationinfo->GetdesignPrice();
	}
    public function GetDotdesignPrice(){
		$this->load->model('JobCard_informationinfo');
        $result=$this->JobCard_informationinfo->GetDotdesignPrice();
	}
    public function getCushion_repairPrice(){
		$this->load->model('JobCard_informationinfo');
        $result=$this->JobCard_informationinfo->getCushion_repairPrice();
	}
    public function getCushionReplacementPrice(){
		$this->load->model('JobCard_informationinfo');
        $result=$this->JobCard_informationinfo->getCushionReplacementPrice();
	}
    public function getpipening_designPrice(){
		$this->load->model('JobCard_informationinfo');
        $result=$this->JobCard_informationinfo->getpipening_designPrice();
	}
    public function material_insertPrice(){
		$this->load->model('JobCard_informationinfo');
        $result=$this->JobCard_informationinfo->material_insertPrice();
	}
    public function getcoverDesignPrice(){
		$this->load->model('JobCard_informationinfo');
        $result=$this->JobCard_informationinfo->getcoverDesignPrice();
	}
    public function getcushionModificationPrice(){
		$this->load->model('JobCard_informationinfo');
        $result=$this->JobCard_informationinfo->getcushionModificationPrice();
	}
    public function GetDesigns()
    {
        $this->load->model('JobCard_informationinfo'); 
        $data = $this->JobCard_informationinfo->GetDesigns(); 
        echo json_encode($data); 
    }
    public function showDataTable(){
		$this->load->model('JobCard_informationinfo');
        $result=$this->JobCard_informationinfo->showDataTable();
	}
    public function extraChargeUpdate(){
		$this->load->model('JobCard_informationinfo');
        $result=$this->JobCard_informationinfo->extraChargeUpdate();
	}

    public function AddextraCharge(){
		$this->load->model('JobCard_informationinfo');
        $result=$this->JobCard_informationinfo->AddextraCharge();
	}
    public function Extra_charges_status($x, $y){
		$this->load->model('JobCard_informationinfo');
        $result=$this->JobCard_informationinfo->Extra_charges_status($x, $y);
	}

    public function Extra_charges_edit(){
		$this->load->model('JobCard_informationinfo');
        $result=$this->JobCard_informationinfo->Extra_charges_edit();
	}

    public function Getseat_type(){
		$this->load->model('JobCard_informationinfo');
        $result=$this->JobCard_informationinfo->Getseat_type();
	}

    public function Get_repair_typedetails(){
		$this->load->model('JobCard_informationinfo');
        $result=$this->JobCard_informationinfo->Get_repair_typedetails();
	}

    public function DeleteJobCard() {
        $this->load->model('JobCard_informationinfo');
        $result=$this->JobCard_informationinfo->DeleteJobCard();
       
    }

}