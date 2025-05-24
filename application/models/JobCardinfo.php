<?php
class JobCardinfo extends CI_Model{

    public function __construct() {
        parent::__construct();
        $this->load->helper('api_helper'); 
    }
    
    public function getCustomerDetails($api_token,$id) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'customer_details_v1', $id, $headers);
    }


    public function getPriceCategory($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'get_sel2_pricecategory_v1', $form_data, $headers);
    }
    public function createJobCard($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'job_card_v1', $form_data, $headers);
    }
    public function insertJobCardDetail($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'insertJobCardDetail_v1', $form_data, $headers);
    }
    public function getJobById($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'job_card_v1', $form_data, $headers);
    }

    public function getSubJob($api_token,$id) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'get_sub_job_base_main_v1', $id, $headers);
    }

    public function getItemParentOptions($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'get_item_parent_options_v1', $form_data, $headers);
    }

    public function getOptionvaluePrice($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'get_item_price_v1', $form_data, $headers);
    }



    public function Getvehicletype(){
        $this->db->select('idtbl_vehicle_type , vehicle_type');
        $this->db->from('tbl_vehicle_type');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
    public function Getpayment_method(){
        $this->db->select('idtbl_payment_method , payment_type');
        $this->db->from('tbl_payment_method');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function Getvehiclebrand(){
        $this->db->select('idtbl_vehicle_brand , brand_name');
        $this->db->from('tbl_vehicle_brand');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function Getmainjob() {
        $this->db->select('idtbl_main_job_category , main_job_category');
        $this->db->from('tbl_main_job_category');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function Getmaterial() {
        $this->db->select('idtbl_material ,material_code , material_type');
        $this->db->from('tbl_material');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function GetCustomerInquiry() {
        $branchID = $_SESSION['branch_id']; 
        $companyID = $_SESSION['company_id']; 

		$customer_id = $this->input->post('customer_id');

        $this->db->select('tbl_customer_inquiry.idtbl_customer_inquiry AS inquiry_id, tbl_customer_inquiry.inquiry_number');
        $this->db->from('tbl_customer');
        $this->db->join('tbl_customer_inquiry', 'tbl_customer_inquiry.nic = tbl_customer.nic_number', 'left');
        $this->db->where('tbl_customer_inquiry.status', 1);
        $this->db->where('tbl_customer_inquiry.cancel_status', 0);
        $this->db->where('tbl_customer_inquiry.job_done_status', 0);
        $this->db->where('tbl_customer_inquiry.company_id', $companyID);
        $this->db->where('tbl_customer_inquiry.company_branch_id', $branchID);
        $this->db->where('tbl_customer.idtbl_customer', $customer_id); 
        $query = $this->db->get(); 
      
        if ($query) {
            $result = $query->result_array();
            echo json_encode($result);
        }
        
	}

    public function GetInquiryDetails() {
		$inquiry_id = $this->input->post('inquiry_id');

        $this->db->select('tbl_customer_inquiry.idtbl_customer_inquiry AS inquiry_id, tbl_customer_inquiry.inquiry_number, tbl_customer_inquiry.vehicle_number, tbl_customer_inquiry.vehicle_brand_id,
        tbl_customer_inquiry.vehicle_type_id,tbl_customer_inquiry.vehicle_model_id,tbl_customer_inquiry.vehicle_year_id,tbl_customer_inquiry.vehicle_gen_id');
        $this->db->from('tbl_customer_inquiry');
        $this->db->where('tbl_customer_inquiry.status', 1);
        $this->db->where('tbl_customer_inquiry.idtbl_customer_inquiry', $inquiry_id); 
        $query = $this->db->get();
      
        if ($query) {
            $result = $query->result_array();
            echo json_encode($result);
        }
        
	}

    public function Getvehiclenumber() {
		$customer_id = $this->input->post('customer_id');
        $this->db->select('idtbl_customer_vehicle_detail, customer_vehicle_number');
        $this->db->from('tbl_customer_vehicle_detail');
        $this->db->where('status', 1);
        $this->db->where('tbl_customer_idtbl_customer', $customer_id); 
        $query = $this->db->get();
        $result = $query->result_array();
        echo json_encode($result);
        
	}

    public function GetcustomerName() {
        $customer_id = $this->input->post('customer_id');
        $this->db->select('customer_name');
        $this->db->from('tbl_customer');
        $this->db->where('status', 1);
        $this->db->where('idtbl_customer', $customer_id);
        $query = $this->db->get();
    
        if ($query->num_rows() > 0) {
            $customer = $query->row(); // Fetch the first row
            echo json_encode(['success' => true, 'customer_name' => $customer->customer_name]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Customer not found.']);
        }
    }

    public function Getvehicleinformation() {
		$vehicle_number_id = $this->input->post('vehicle_number_id');
        $this->db->select('tbl_customer_vehicle_detail.vehicle_brand_id, tbl_vehicle_brand.brand_name,tbl_customer_vehicle_detail.vehicle_model_id');
        $this->db->from('tbl_customer_vehicle_detail');
        $this->db->join('tbl_vehicle_brand', 'tbl_customer_vehicle_detail.vehicle_brand_id = tbl_vehicle_brand.idtbl_vehicle_brand', 'left');
        $this->db->where('tbl_customer_vehicle_detail.status', 1);
        $this->db->where('tbl_customer_vehicle_detail.idtbl_customer_vehicle_detail', $vehicle_number_id);
        $query = $this->db->get();
        $result = $query->result_array();
        echo json_encode($result);
        
	}

    private function Getjobcard_number() {
        $branchID = $_SESSION['branch_id']; 
        $date1 = date('Y-m-d');
        
        $current = new DateTime($date1);
    
        $currentYear = $current->format('Y'); 
        $currentMonth = $current->format('m'); 
    
        if ($currentMonth < 4) { 
            $startDate = new DateTime(($currentYear - 1) . "-04-01");
            $endDate = new DateTime($currentYear . "-03-31");
        } else {
            $startDate = new DateTime("$currentYear-04-01");
            $endDate = new DateTime(($currentYear + 1) . "-03-31");
        }
    
        $fromYear = $startDate->format('Y-m-d');
        $toYear = $endDate->format('Y-m-d');
    
        $query = $this->db->query("
            SELECT job_card_number 
            FROM tbl_jobcard 
            WHERE company_branch_id = ? 
            AND jobcard_date BETWEEN ? AND ? 
            ORDER BY job_card_number DESC 
            LIMIT 1
        ", [$branchID, $fromYear, $toYear]);
    
        $lastJobCardNo = 0;
        if ($query->num_rows() > 0) {
            $lastJobCardNo = intval(substr($query->row()->job_card_number, -4)); 
        }
    
        $newJobCardCount = $lastJobCardNo + 1;
        $jobCardNumberPrefix = sprintf('%04d', $newJobCardCount); 
    
        $year = $current->format('Y');
        $month = $current->format('m');
        if ($month < 4) {
            $year -= 1;
        }
        $yearDigit = substr($year, -2);
    
        $jobCardNumber = 'JCN' . $yearDigit . $jobCardNumberPrefix;
    
        return $jobCardNumber;
    }


    public function JobCardinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
 
        $jobcard_date=$this->input->post('jobcard_date');
        $jobcard_num=$this->Getjobcard_number();
        $inquiry_id=$this->input->post('inquiry_id');
        $inquiry_no=$this->input->post('inquiry_no');
        $vehicle_number=$this->input->post('vehicle_number');
        $vehicle_brand_id=$this->input->post('vehicle_brand_id');
        $vehicle_model_id=$this->input->post('vehicle_model_id');
        $payment_method=$this->input->post('payment_method');
        $complete_date=$this->input->post('complete_date');
        $handover_date=$this->input->post('handover_date');
        $customer_id=$this->input->post('customer_id');

        $discount=$this->input->post('discount');
        $discount_amount=$this->input->post('discount_amount');
        $nettotal=$this->input->post('nettotal');

        $company_id=$this->input->post('f_company_id');
        $branch_id=$this->input->post('f_branch_id');
      
        $recordOption=$this->input->post('recordOption');
        if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}

        $insertdatetime=date('Y-m-d H:i:s');

        if($recordOption==1){
            $data = array(
                'jobcard_date'=> $jobcard_date, 
                'inquiry_id'=> $inquiry_id, 
                'inquiry_number'=> $inquiry_no, 
                'job_card_number '=> $jobcard_num, 
                'vehicle_number '=> $vehicle_number, 
                'vehicle_brand_id '=> $vehicle_brand_id, 
                'vehicle_model_id '=> $vehicle_model_id, 
                'peyment_method'=> $payment_method, 
                'complete_date'=> $complete_date, 
                'handover_date'=> $handover_date, 
                'customer_id'=> $customer_id, 
                'company_id'=> $company_id, 
				'company_branch_id'=> $branch_id, 
                'status'=> '1', 
                'insertdatetime'=> $insertdatetime, 
                'tbl_user_idtbl_user'=> $userID,
            );

            $this->db->insert('tbl_jobcard', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-save';
                $actionObj->title='';
                $actionObj->message='Record Added Successfully';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='success';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('JobCard/?customer_id=' . $customer_id);          
            } else {
                $this->db->trans_rollback();

                $actionObj=new stdClass();
                $actionObj->icon='fas fa-warning';
                $actionObj->title='';
                $actionObj->message='Record Error';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='danger';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('JobCard/?customer_id=' . $customer_id);      
            }
        }
        else{
            $data = array(
                'inquiry_number'=> $inquiry_no, 
                'vehicle_number '=> $vehicle_number, 
                'vehicle_brand_id '=> $vehicle_brand_id, 
                'vehicle_model_id '=> $vehicle_model_id, 
                'peyment_method'=> $payment_method, 
                'complete_date'=> $complete_date, 
                'handover_date'=> $handover_date,
                'company_id'=> $company_id, 
				'company_branch_id'=> $branch_id, 
                'discount'=> $discount,
                'discount_amount'=> $discount_amount,
                'net_total'=> $nettotal,
                'updateuser'=> $userID, 
                'updatedatetime' => $insertdatetime,
               
            );

            $this->db->where('idtbl_jobcard ', $recordID);
            $this->db->update('tbl_jobcard', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-save';
                $actionObj->title='';
                $actionObj->message='Job Card Update Successfully';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='primary';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('JobCard/?customer_id=' . $customer_id);                   
            } else {
                $this->db->trans_rollback();

                $actionObj=new stdClass();
                $actionObj->icon='fas fa-warning';
                $actionObj->title='';
                $actionObj->message='Record Error';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='danger';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('JobCard/?customer_id=' . $customer_id);      
            }
        }
    }
    public function JobCardstatus($x, $y, $z){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $recordID=$x;
        $type=$y;
        $customer_id=$z;

        $updatedatetime=date('Y-m-d H:i:s');

        if($type==1){
            $data = array(
                'status' => '1',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_jobcard ', $recordID);
            $this->db->update('tbl_jobcard', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-check';
                $actionObj->title='';
                $actionObj->message='Record Activate Successfully';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='success';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('JobCard/?customer_id=' . $customer_id);                
            } else {
                $this->db->trans_rollback();

                $actionObj=new stdClass();
                $actionObj->icon='fas fa-warning';
                $actionObj->title='';
                $actionObj->message='Record Error';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='danger';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('JobCard/?customer_id=' . $customer_id);
            }
        }
        else if($type==2){
            $data = array(
                'status' => '2',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_jobcard', $recordID);
            $this->db->update('tbl_jobcard', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-times';
                $actionObj->title='';
                $actionObj->message='Record Deactivate Successfully';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='warning';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('JobCard/?customer_id=' . $customer_id);                
            } else {
                $this->db->trans_rollback();

                $actionObj=new stdClass();
                $actionObj->icon='fas fa-warning';
                $actionObj->title='';
                $actionObj->message='Record Error';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='danger';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('JobCard/?customer_id=' . $customer_id);
            }
        }
        else if($type==3){
            $data = array(
                'status' => '3',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_jobcard', $recordID);
            $this->db->update('tbl_jobcard', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-trash-alt';
                $actionObj->title='';
                $actionObj->message='Record Remove Successfully';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='danger';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('JobCard/?customer_id=' . $customer_id);                
            } else {
                $this->db->trans_rollback();

                $actionObj=new stdClass();
                $actionObj->icon='fas fa-warning';
                $actionObj->title='';
                $actionObj->message='Record Error';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='danger';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('JobCard/?customer_id=' . $customer_id);
            }
        }
    }

    public function JobCardedit(){
        $recordID=$this->input->post('recordID');

        $this->db->select('*');
        $this->db->from('tbl_jobcard');
        $this->db->where('idtbl_jobcard', $recordID);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        $obj=new stdClass();
        $obj->id=$respond->row(0)->idtbl_jobcard;
        $obj->job_card_number=$respond->row(0)->job_card_number;
        $obj->inquiry_id=$respond->row(0)->inquiry_id;
        $obj->inquiry_number=$respond->row(0)->inquiry_number;
        $obj->jobcard_date=$respond->row(0)->jobcard_date;
        $obj->vehicle_number=$respond->row(0)->vehicle_number;
        $obj->vehicle_brand_id=$respond->row(0)->vehicle_brand_id;
        $obj->vehicle_model_id=$respond->row(0)->vehicle_model_id;
        $obj->peyment_method=$respond->row(0)->peyment_method;
        $obj->complete_date=$respond->row(0)->complete_date;
        $obj->handover_date=$respond->row(0)->handover_date;
        $obj->customer_id=$respond->row(0)->customer_id;
        $obj->sub_total=$respond->row(0)->sub_total;
        $obj->discount=$respond->row(0)->discount;
        $obj->discount_amount=$respond->row(0)->discount_amount;
        $obj->net_total=$respond->row(0)->net_total;

        echo json_encode($obj);
    }

    public function getInquiryJobList(){
        $customer_id=$this->input->post('customer_id');
        $inquiry_id=$this->input->post('inquiry_id');

        $this->db->select('tbl_jobs.job_name');
        $this->db->from('tbl_customer_inquiry_detail');
        $this->db->join('tbl_jobs', 'tbl_jobs.idtbl_jobs = tbl_customer_inquiry_detail.tbl_job_id', 'left');
        $this->db->where('tbl_customer_inquiry_detail.status', 1);
        $this->db->where('tbl_customer_inquiry_detail.tbl_customer_inquiry_idtbl_customer_inquiry', $inquiry_id);
        $responddetail = $this->db->get()->result();
        $count = count($responddetail);

        $html='';

        if ($count > 0) {
            foreach($responddetail as $list){
                $html .='<tr>
                <td>'.$list->job_name.'</td>
                </tr>';
            }
        } else {
            $html .='<tr>
            <td>No jobs found on that Vehicle previous customer inquiry</td>
            </tr>';
        }
        echo $html;
    }

    
    public function getJobprice(){
        $material_id=$this->input->post('material_id');
        $vehicle_model_id=$this->input->post('vehicle_model_id');
        $main_job_category=$this->input->post('main_job_category');
        $sub_job_category=$this->input->post('sub_job_category');
        $job_name=$this->input->post('job_name');

        $this->db->select('*');
        $this->db->from('tbl_vehicle_model');
        $this->db->where('idtbl_vehicle_model', $vehicle_model_id);
        $this->db->where('status', 1);

        $respond=$this->db->get();
        $price_category_id=$respond->row(0)->price_category_id ;


        $this->db->select('tbl_job_price_detail.job_price');
        $this->db->from('tbl_job_price');
        $this->db->join('tbl_job_price_detail','tbl_job_price_detail.job_price_id = tbl_job_price.idtbl_job_price','left');
        $this->db->where('tbl_job_price.main_job_category_id', $main_job_category);
        $this->db->where('tbl_job_price.sub_job_category_id', $sub_job_category);
        $this->db->where('tbl_job_price.sales_job_details_id', $job_name);
        $this->db->where('tbl_job_price_detail.Cate_type', $price_category_id);
        $this->db->where('tbl_job_price_detail.material_id', $material_id);

        $respond2=$this->db->get();

        $price=0;
        if ($respond2->num_rows() > 0) {
            $price = $respond2->row(0)->job_price;
        }


        echo $price;

    }


    private function formatDayWithSuffix($date) {
        $timestamp = strtotime($date);
        $day = date('j', $timestamp);
        if ($day % 10 == 1 && $day != 11) {
            $suffix = 'st';
        } elseif ($day % 10 == 2 && $day != 12) {
            $suffix = 'nd';
        } elseif ($day % 10 == 3 && $day != 13) {
            $suffix = 'rd';
        } else {
            $suffix = 'th';
        }
        return date('M. j', $timestamp) . $suffix . ', ' . date('Y', $timestamp);
    }

    public function jobCardPDF(){

        $branchID = $_SESSION['branch_id'];

        $seatpath = 'images/Custom.png'; 
        $seattype = pathinfo($seatpath, PATHINFO_EXTENSION);
        $seatdata = file_get_contents($seatpath); 
        $seatIconBase64 = 'data:image/' . $seattype . ';base64,' . base64_encode($seatdata); 

        $designpath = 'images/Stitching_img/1740452679_NP018.jpg'; 
        $designtype = pathinfo($designpath, PATHINFO_EXTENSION);
        $designdata = file_get_contents($designpath); 
        $designIconBase64 = 'data:image/' . $designtype . ';base64,' . base64_encode($designdata); 

        $currentDate=$this->formatDayWithSuffix(date('Y-m-d'));

        $jobcard_id=$this->input->get('jobcard_id');

        $this->db->select('tbl_jobcard.job_card_number,tbl_jobcard.jobcard_date,tbl_jobcard.complete_date,
        tbl_customer.customer_name,tbl_customer.customer_mobile_num,tbl_customer.customer_mobile_num_2,tbl_customer.nic_number,tbl_customer.address,tbl_customer.address_2,tbl_customer.city,tbl_district.district_name,tbl_customer.email,
        tbl_jobcard.vehicle_number,tbl_vehicle_brand.brand_name,tbl_vehicle_model.model_name,tbl_user.name,tbl_company_branch.branch,tbl_payment_method.payment_type,
        tbl_sales_person.sales_person_name,tbl_sales_person.sales_person_code');
        $this->db->from('tbl_jobcard');
        $this->db->join('tbl_customer', 'tbl_customer.idtbl_customer = tbl_jobcard.customer_id');
        $this->db->join('tbl_vehicle_brand', 'tbl_vehicle_brand.idtbl_vehicle_brand = tbl_jobcard.vehicle_brand_id');
        $this->db->join('tbl_vehicle_model', 'tbl_vehicle_model.idtbl_vehicle_model = tbl_jobcard.vehicle_model_id');
        $this->db->join('tbl_user', 'tbl_user.idtbl_user = tbl_jobcard.tbl_user_idtbl_user');
        $this->db->join('tbl_company_branch', 'tbl_company_branch.idtbl_company_branch = tbl_jobcard.company_branch_id');
        $this->db->join('tbl_payment_method', 'tbl_payment_method.idtbl_payment_method = tbl_jobcard.peyment_method');
        $this->db->join('tbl_sales_person', 'tbl_sales_person.idtbl_sales_person = tbl_user.sale_person_id','left');
        $this->db->join('tbl_district', 'tbl_district.idtbl_district = tbl_customer.district','left');
        $this->db->where('tbl_jobcard.idtbl_jobcard', $jobcard_id);
        $this->db->where('tbl_jobcard.status', 1);
        $respondmain = $this->db->get();

        $job_card_number=$respondmain->row(0)->job_card_number;
        $jobcard_date = $this->formatDayWithSuffix(date('Y-m-d', strtotime($respondmain->row(0)->jobcard_date)));
        $complete_date= $this->formatDayWithSuffix($respondmain->row(0)->complete_date);
        $customer_name=$respondmain->row(0)->customer_name;
        $customer_mobile_num=$respondmain->row(0)->customer_mobile_num;
        $customer_mobile_num_2=$respondmain->row(0)->customer_mobile_num_2;
        $nic_number=$respondmain->row(0)->nic_number;
        $address=$respondmain->row(0)->address;
        $address_2=$respondmain->row(0)->address_2;
        $city=$respondmain->row(0)->city;
        $district=$respondmain->row(0)->district_name;
        $email=$respondmain->row(0)->email;
        $customer_vehicle_number=$respondmain->row(0)->vehicle_number;
        $brand_name=$respondmain->row(0)->brand_name;
        $model_name=$respondmain->row(0)->model_name;
        $name=$respondmain->row(0)->name;
        $branch=$respondmain->row(0)->branch;
        $payment_type=$respondmain->row(0)->payment_type;
        $sales_person_name=$respondmain->row(0)->sales_person_name;
        $sales_person_code=$respondmain->row(0)->sales_person_code;


        $this->db->select('tbl_job_card_detail.sales_job_details_id,tbl_sales_jobs_details.sales_job_name,tbl_job_card_detail.qty');
        $this->db->from('tbl_jobcard');
        $this->db->join('tbl_job_card_detail', 'tbl_job_card_detail.tbl_job_card_id = tbl_jobcard.idtbl_jobcard');
        $this->db->join('tbl_sales_jobs_details', 'tbl_sales_jobs_details.idtbl_sales_jobs_details = tbl_job_card_detail.sales_job_details_id');
        $this->db->where('tbl_jobcard.idtbl_jobcard', $jobcard_id);
        $this->db->where('tbl_jobcard.status', 1);
        $responddetail = $this->db->get()->result();
        $count = count($responddetail);

        $this->db->select('tbl_assign_emp_to_job_detail.tbl_sales_job_details_id,employees.service_no,employees.emp_name_with_initial,employees.calling_name,tbl_assign_emp_to_job_detail.emp_level');
        $this->db->from('tbl_assign_emp_to_job');
        $this->db->join('tbl_assign_emp_to_job_detail', 'tbl_assign_emp_to_job_detail.tbl_assign_emp_to_job_id = tbl_assign_emp_to_job.idtbl_assign_emp_to_job');
        $this->db->join('tbl_sales_jobs_details', 'tbl_sales_jobs_details.idtbl_sales_jobs_details = tbl_assign_emp_to_job_detail.tbl_sales_job_details_id');
        $this->db->join('employees', 'employees.id = tbl_assign_emp_to_job_detail.emp_id');
        $this->db->where('tbl_assign_emp_to_job.tbl_job_card_id', $jobcard_id);
        $this->db->where('tbl_assign_emp_to_job.status', 1);
        $respond_emp_detail = $this->db->get()->result();
        $emp_count = count($respond_emp_detail);

        $mainJob_cnt=1;

        $body = '
            <tr></tr>
        ';

        $html = '
        <!DOCTYPE html>
        <html>

        <head>
            <title>ECW Software</title>
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
            <link rel="icon" type="image/x-icon" href="assets/img/ecw2.jpg" />
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
            <style>
                @page {
                     margin: 5mm 16mm 2mm 20mm; /* top right bottom left */
                }
                body {
                    margin: 0;
                    font-family: "Roboto", sans-serif;
                    font-size: 10px;
                    line-height: 1.5;
                    text-align:left;
                }
                header {
                    position: fixed;
                    top: 20px; 
                    left: 0;
                    right: 0;
                    height: 90px;
                    text-align: center;
                    line-height: 35px;
                    border-bottom: 2px solid #000;
                }

                footer {
                    position: fixed;
                    bottom: 50px; 
                    left: 0;
                    right: 0;
                    height: 30px;
                    text-align: center;
                    line-height: 30px;
                    border-top: 1px solid #ddd;
                }

                .content {
                    margin-top: 0px;

                }
                .header_th{
                    text-align:right;
                    height: 8px;
                    line-height: 0.4rem;
                    padding: 0; 
                    font-weight: 400; 
                }
                .sub_header_text_th{
                    text-align:left;
                    height: 4px;
                    line-height: 0.7rem;
                    padding: 0; 
                    font-weight: 700; 
                }
                .sub_header_text_td{
                    text-align:left;
                    height: 4px;
                    line-height: 0.7rem;
                    padding: 0; 
                    font-weight: 400; 
                }
                .datatable_td{
                    padding:3px;
                    color:#000;
                    border: 1px solid #000;
                    font-size:9px
                }
                .datatable_data_td{
                    border: none;
                    text-align:left;
                    height: 4px;
                    line-height: 0.6rem;
                    padding: 0; 
                    padding: 0 3px 0 3px; 
                    font-weight: 400; 
                }
                .datatable_total_td{
                    padding:3px;
                    border-top: 1.5px solid #000;
                    border-left: none;
                    border-right: none;
                    border-bottom: 1.5px solid #000;
                    text-align:right;
                }

            </style>
        </head>

        <body>
            <div class="content">
            <h1 style="text-align:center;">JOB CARD</h1>
             <table style="table-layout: fixed;padding:3px;padding-left:0px;padding-right:0px;width:100%;border-collapse: collapse;border-bottom: 1.5px solid #000">
                 <tr>
                    <th style="width:10%;" class="sub_header_text_th">Customer</th>
                    <th style="width:55%;" class="sub_header_text_td">'.$customer_name.'</th>
                    <th style="width:15%;" class="sub_header_text_th">Job Card No</th>
                    <th style="width:20%;" class="sub_header_text_td">'.$job_card_number.'</th>
                </tr>
                 <tr>
                    <th style="" class="sub_header_text_th">Address</th>
                    <th style="" class="sub_header_text_td">'.$address.', '.$address_2.', '.$city.', '.$district.'</th>
                    <th style="" class="sub_header_text_th">Created Date</th>
                    <th style="" class="sub_header_text_td">'.$jobcard_date.'</th>
                </tr>
                 <tr>
                    <th style="" class="sub_header_text_th">Contact No</th>
                    <th style="" class="sub_header_text_td"> '.$customer_mobile_num.($customer_mobile_num_2 == "+94" ? "" : ' / '.$customer_mobile_num_2).'</th>
                    <th style="" class="sub_header_text_th">Created at</th>
                    <th style="" class="sub_header_text_td">'.$branch.'</th>
                </tr>
                 <tr>
                    <th style="" class="sub_header_text_th">Vehicle No</th>
                    <th style="" class="sub_header_text_td">'.$customer_vehicle_number.'</th>
                    <th style="" class="sub_header_text_th">Sales Person Code</th>
                    <th style="" class="sub_header_text_td">'.$sales_person_code.'</th>
                </tr>
                 <tr>
                    <th style="" class="sub_header_text_th">Vehicle Type</th>
                    <th style="" class="sub_header_text_td">'.$brand_name.', '.$model_name.'</th>
                    <th style="" class="sub_header_text_th">Quotation No</th>
                    <th style="" class="sub_header_text_td">None</th>
                </tr>
                 <tr>
                    <th style="" class="sub_header_text_th">NIC</th>
                    <th style="" class="sub_header_text_td">'.$nic_number.'</th>
                    <th style="" class="sub_header_text_th">Customer PO</th>
                    <th style="" class="sub_header_text_td">None</th>
                </tr>
                 <tr>
                    <th style="" class="sub_header_text_th">Job Start Date</th>
                    <th style="" class="sub_header_text_td">'.$jobcard_date.'</th>
                    <th style="" class="sub_header_text_th">Payment Method</th>
                    <th style="" class="sub_header_text_td">'.$payment_type.'</th>
                </tr>
                 <tr>
                    <th style="" class="sub_header_text_th">Sales Person</th>
                    <th style="" class="sub_header_text_td">'.$sales_person_name.'</th>
                    <th style="" class="sub_header_text_th">Job Complete Date</th>
                    <th style="" class="sub_header_text_td">'.$complete_date.'</th>
                </tr>
                 <tr>
                    <th style="" class="sub_header_text_th"></th>
                    <th style="" class="sub_header_text_td"></th>
                    <th style="" class="sub_header_text_th">Print Date</th>
                    <th style="" class="sub_header_text_td">'.$currentDate.'</th>
                </tr>
             </table>
              <h2 style="text-align:center;">JOB DETAILS</h2>
             <table style="table-layout: fixed;padding:3px;width:100%;border-collapse: collapse;">
                <tr>
                    <th style="width:4%;text-align:left;font-size:12px;" class="sub_header_text_th datatable_td datatable_total_td">No</th>
                    <th style="width:46%;text-align:center;font-size:12px;" class="sub_header_text_th datatable_td datatable_total_td">Job</th>
                    <th style="width:10%;text-align:center;font-size:12px;" class="sub_header_text_th datatable_td datatable_total_td">Quantity</th>
                    <th style="width:40%;text-align:center;font-size:12px;" class="sub_header_text_th datatable_td datatable_total_td">Remark</th>
                </tr>
            </table>
             ';
             
             if ($count > 0) {
                foreach ($responddetail as $list) {
                    $html .= '
                    <table style="table-layout: fixed;padding:3px;width:100%;border-collapse: collapse;">
                         <tr>
                            <td style="width:4%;text-align:left;border:none;font-size:12px;" class="datatable_td">'.$mainJob_cnt.'.</td>
                            <td style="width:46%;text-align:left;border:none;font-size:12px;" class="datatable_td">'.$list->sales_job_name.'</td>
                            <td style="width:10%;text-align:center;border:none;font-size:12px;" class="datatable_td">X '.$list->qty.'</td>
                            <td style="width:40%;text-align:center;border:none;font-size:12px;" class="datatable_td">Remark</td>
                        </tr>
                    </table>';
                     if($mainJob_cnt == 1){
                        $html .= '
                        <table style="table-layout: fixed;padding:3px;width:100%;border-collapse: collapse;">
                            <tr>
                                <td style="width:50%;text-align:left;border:none;font-size:12px;" class="datatable_td">Production Advice : OEM - Custom Cloth</td>
                                <td style="width:25%;text-align:left;border:none;font-size:12px;" class="datatable_td">Seat Texture</td>
                                <td style="width:25%;text-align:left;border:none;font-size:12px;" class="datatable_td">Material : Leather</td>
                            </tr>
                            <tr>
                                <td rowspan="4" style="width:50%;text-align:left;border:none;font-size:12px;" class="datatable_td"><img style="height:120px" src="'.$seatIconBase64.'"></td>
                                <td rowspan="4" style="width:25%;text-align:left;border:none;font-size:12px;" class="datatable_td"><img style="height:120px" src="'.$designIconBase64.'"></td>
                                <td style="width:25%;text-align:left;border:none;font-size:12px;" class="datatable_td">Logo : None</td>
                            </tr>
                            <tr>
                                <td style="width:25%;text-align:left;border:none;font-size:12px;" class="datatable_td">Logo Colour : None</td>
                            </tr>
                            <tr>
                                <td style="width:25%;text-align:left;border:none;font-size:12px;" class="datatable_td">Thread Colour : Ash</td>
                            </tr>
                            <tr>
                                <td style="width:25%;text-align:left;border:none;font-size:12px;" class="datatable_td">Stitch Style : Double</td>
                            </tr>
                        </table>';
                        }
                    $html .= '<table style="table-layout: fixed;padding:3px;width:100%;border-collapse: collapse;">
                    <tr>
                        <th style="width:3%;text-align:left;" class="sub_header_text_th datatable_td">#</th>
                        <th style="width:7%;text-align:left;" class="sub_header_text_th datatable_td">EMP CODE</th>
                        <th style="width:13%;text-align:center;" class="sub_header_text_th datatable_td">RATE</th>
                        <th style="width:17%;text-align:left;" class="sub_header_text_th datatable_td">EMP.</th>
                        <th style="width:10%;text-align:left;" class="sub_header_text_th datatable_td">E-R OFFICER </th>
                        <th style="width:10%;text-align:left;" class="sub_header_text_th datatable_td">PRODUCTION SUPERVISOR</th>
                        <th style="width:10%;text-align:left;" class="sub_header_text_th datatable_td">QUALITY SUPERVISOR </th>
                        <th style="width:10%;text-align:left;" class="sub_header_text_th datatable_td">UPDATED HR DEPT.</th>
                        <th style="width:10%;text-align:left;" class="sub_header_text_th datatable_td">CHECKED HR DEPT.</th>
                        <th style="width:10%;text-align:left;" class="sub_header_text_th datatable_td">CHECKED ACC DEPT.</th>
                    </tr>
             ';
             if ($emp_count > 0) {
                foreach ($respond_emp_detail as $emplist) {
                      for ($level_cnt = 1; ($level_cnt <= $emp_count); $level_cnt++) {
                        if($list->sales_job_details_id == $emplist->tbl_sales_job_details_id && $level_cnt == $emplist->emp_level)
                 $html .= '<tr>
                    <td style="width:3%;text-align:left;" class="datatable_td">'.$level_cnt.'</td>
                    <td style="width:7%;text-align:left;" class="datatable_td">'.$emplist->service_no.'</td>
                    <td style="width:13%;text-align:center;" class="datatable_td">100</td>
                    <td style="width:17%;text-align:left;" class=" datatable_td">'.$emplist->calling_name.'</td>
                    <td style="width:10%;text-align:left;" class="datatable_td"></td>
                    <td style="width:10%;text-align:left;" class="datatable_td"></td>
                    <td style="width:10%;text-align:left;" class="datatable_td"></td>
                    <td style="width:10%;text-align:left;" class="datatable_td"></td>
                    <td style="width:10%;text-align:left;" class="datatable_td"></td>
                    <td style="width:10%;text-align:left;" class="datatable_td"></td>
                </tr>';
                      }
                    }
                }
             $html .= '</table>
             <div style="border-bottom: 2px dashed #000;margin-top:10px;"></div>';
             $mainJob_cnt++;
                }
            }
             $html .= '</div>
        </body>

        </html>';

        $this->load->library('Pdf');
        $this->pdf->set_option('isRemoteEnabled', true);
        $this->pdf->setPaper('A4', 'portrait');
        $this->pdf->loadHtml($html, 'UTF-8');
        $this->pdf->render();
        $this->pdf->stream( "Job Card.pdf", array("Attachment"=>0));


    }



}