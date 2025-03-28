<?php
class Customerinfo extends CI_Model{

    public function Getdistrict() {
        $this->db->select('idtbl_district , district_name');
        $this->db->from('tbl_district');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }


    public function Getvehiclemodel() {
		$vehi_brand_id = $this->input->post('vehi_brand_id');
        $this->db->select('idtbl_vehicle_model, model_name');
        $this->db->from('tbl_vehicle_model');
        $this->db->where('status', 1);
        $this->db->group_by('model_name'); // Group by model_name
        $this->db->where('vehicle_brand_id', $vehi_brand_id); 
        $query = $this->db->get();
        $result = $query->result_array();
        echo json_encode($result);
        
	}

    public function Getvehiclebrand() {
        $this->db->select('idtbl_vehicle_brand , brand_name');
        $this->db->from('tbl_vehicle_brand');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }


    public function Customerinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $customer_vehicle_number=$this->input->post('customer_vehicle_number');
        $customer_mobile_num=$this->input->post('customer_mobile_num');
        $customer_mobile_num_2=$this->input->post('customer_mobile_num_2');
        $customer_name=$this->input->post('customer_name');
        $nic_no=$this->input->post('nic_no');
        $customer_dob=$this->input->post('customer_dob');
        $customer_address=$this->input->post('customer_address');
        $address_line2=$this->input->post('address_line2');
        $city=$this->input->post('city');
        $email=$this->input->post('email');
        $district=$this->input->post('district');
        $tax_type=$this->input->post('tax_type');
        $tax_number=$this->input->post('tax_number');

        $company_id=$this->input->post('f_company_id');
        $branch_id=$this->input->post('f_branch_id');

        $recordOption=$this->input->post('recordOption');
        if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}

        $insertdatetime=date('Y-m-d H:i:s');
        
        if($recordOption == 1){
            $data = array(
                'customer_name'=> $customer_name, 
                'customer_mobile_num'=> $customer_mobile_num, 
                'customer_mobile_num_2'=> $customer_mobile_num_2, 
                'nic_number'=> $nic_no, 
                'dob'=> $customer_dob, 
                'address'=> $customer_address, 
                'address_2'=> $address_line2,
                'email'=> $email,
                'city'=> $city, 
                'district'=> $district, 
                'tax_type'=> $tax_type,
                'tax_number'=> $tax_number,
                'status'=> '1', 
                'insertdatetime'=> $insertdatetime, 
                'tbl_user_idtbl_user'=> $userID,
                'company_id'=> $company_id, 
                'company_branch_id'=> $branch_id, 
            );
        
            $this->db->insert('tbl_customer', $data);
        
            $newCustomerID = $this->db->insert_id();
        
            // $data2 = array(
            //     'customer_vehicle_number' => $customer_vehicle_number,
            //     'vehicle_brand_id' => $vehi_brand_id,
            //     'vehicle_model_id' => $vehi_model_id,
            //     'tbl_customer_idtbl_customer' => $newCustomerID,
            //     'status'=> '1',
            //     'insertdatetime'=> $insertdatetime, 
            // );
        
            // $this->db->insert('tbl_customer_vehicle_detail', $data2);
        
            $this->db->trans_complete();
        
            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj = new stdClass();
                $actionObj->icon = 'fas fa-save';
                $actionObj->title = '';
                $actionObj->message = 'Record Added Successfully';
                $actionObj->url = '';
                $actionObj->target = '_blank';
                $actionObj->type = 'success';
        
                $actionJSON = json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Customer');                
            } else {
                $this->db->trans_rollback();
        
                $actionObj = new stdClass();
                $actionObj->icon = 'fas fa-warning';
                $actionObj->title = '';
                $actionObj->message = 'Record Error';
                $actionObj->url = '';
                $actionObj->target = '_blank';
                $actionObj->type = 'danger';
        
                $actionJSON = json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Customer');
            }
        }
    
        else{
            $data = array(
                'customer_name'=> $customer_name, 
                // 'customer_vehicle_number'=> $customer_vehicle_number, 
                'customer_mobile_num'=> $customer_mobile_num, 
                'customer_mobile_num_2'=> $customer_mobile_num_2, 
                'nic_number'=> $nic_no, 
                'dob'=> $customer_dob, 
                'address'=> $customer_address, 
                'address_2'=> $address_line2,
                'email'=> $email,
                'city'=> $city, 
                'district'=> $district, 
                'tax_type'=> $tax_type,
                'tax_number'=> $tax_number,
                'company_id'=> $company_id, 
				'company_branch_id'=> $branch_id, 
                'updateuser'=> $userID, 
                'updatedatetime' => $insertdatetime,
            );

            $this->db->where('idtbl_customer', $recordID);
            $this->db->update('tbl_customer', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj=new stdClass();
                $actionObj->icon='fas fa-save';
                $actionObj->title='';
                $actionObj->message='Record Update Successfully';
                $actionObj->url='';
                $actionObj->target='_blank';
                $actionObj->type='primary';

                $actionJSON=json_encode($actionObj);
                
                $this->session->set_flashdata('msg', $actionJSON);
                redirect('Customer');                
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
                redirect('Customer');
            }
        }
    }
    public function Customerstatus($x, $y){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $recordID=$x;
        $type=$y;
        $updatedatetime=date('Y-m-d H:i:s');

        if($type==1){
            $data = array(
                'status' => '1',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_customer', $recordID);
            $this->db->update('tbl_customer', $data);

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
                redirect('Customer');                
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
                redirect('Customer');
            }
        }
        else if($type==2){
            $data = array(
                'status' => '2',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_customer', $recordID);
            $this->db->update('tbl_customer', $data);

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
                redirect('Customer');                
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
                redirect('Customer');
            }
        }
        else if($type==3){
            $data = array(
                'status' => '3',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_customer', $recordID);
            $this->db->update('tbl_customer', $data);

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
                redirect('Customer');                
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
                redirect('Customer');
            }
        }
    }

    public function Customer_vehiclestatus($x,$y) {
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $recordID=$x;
        $y=$y;

        $updatedatetime=date('Y-m-d H:i:s');

            $data = array(
                'status' => $y,
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_customer_vehicle_detail', $recordID);
            $this->db->update('tbl_customer_vehicle_detail', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                $response = array('status' => 'success', 'message' => 'Vehicle Delete Successfully');
                echo json_encode($response);              
            } else {
                $this->db->trans_rollback();
                $response = array('status' => 'error', 'message' => 'Failed to Delete Vehicle');
                echo json_encode($response);
            }
    }

    public function Customer_Vehicle_edit(){
        $recordID=$this->input->post('recordID');

        $this->db->select('*');
        $this->db->from('tbl_customer_vehicle_detail');
        $this->db->where('idtbl_customer_vehicle_detail', $recordID);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        $obj=new stdClass();
        $obj->id=$respond->row(0)->idtbl_customer_vehicle_detail;
        $obj->customer_vehicle_number=$respond->row(0)->customer_vehicle_number;
        $obj->vehicle_brand_id=$respond->row(0)->vehicle_brand_id;
        $obj->vehicle_model_id=$respond->row(0)->vehicle_model_id;
        

        echo json_encode($obj);
    }

    public function Customeredit(){
        $recordID=$this->input->post('recordID');

        $this->db->select('*');
        $this->db->from('tbl_customer');
        $this->db->where('idtbl_customer', $recordID);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        $obj=new stdClass();
        $obj->id=$respond->row(0)->idtbl_customer;
        $obj->customer_name=$respond->row(0)->customer_name;
        // $obj->customer_vehicle_number=$respond->row(0)->customer_vehicle_number;
        $obj->customer_mobile_num=$respond->row(0)->customer_mobile_num;
        $obj->customer_mobile_num_2=$respond->row(0)->customer_mobile_num_2;
        $obj->dob=$respond->row(0)->dob;
        $obj->address=$respond->row(0)->address;
        $obj->address_2=$respond->row(0)->address_2;
        $obj->city=$respond->row(0)->city;
        $obj->email=$respond->row(0)->email;
        $obj->district=$respond->row(0)->district;
        $obj->tax_type=$respond->row(0)->tax_type;
        $obj->tax_number=$respond->row(0)->tax_number;
        $obj->nic_number=$respond->row(0)->nic_number;
        
        echo json_encode($obj);
    }

   
    public function Get_existing_customer(){
        $vehicle_number = $this->input->post('customer_vehicle_number');
    
        $this->db->select('
    tbl_customer_inquiry.vehicle_number,
    MAX(tbl_customer_inquiry.idtbl_customer_inquiry) as idtbl_customer_inquiry,
    MAX(tbl_customer_inquiry.inquiry_number) as inquiry_number,
    MAX(tbl_customer_inquiry.customer_name) as customer_name,
    MAX(tbl_customer_inquiry.customer_number) as customer_number,
    MAX(tbl_customer_inquiry.nic) as nic,
    MAX(tbl_customer_inquiry.address) as address,
    MAX(tbl_customer_inquiry.address_2) as address_2,
    MAX(tbl_customer_inquiry.email) as email,
    MAX(tbl_customer_inquiry.district) as district,
    MAX(tbl_customer_inquiry.city) as city,
    MAX(tbl_customer_inquiry.dob) as dob,
    MAX(tbl_customer_inquiry.customer_number2) as customer_number2,
    MAX(tbl_customer_inquiry.vehicle_model_id) as vehicle_model_id,
    MAX(tbl_customer_inquiry.vehicle_brand_id) as vehicle_brand_id,
    MAX(tbl_vehicle_model.model_name) as model_name,
    MAX(tbl_vehicle_brand.brand_name) as brand_name');
    $this->db->from('tbl_customer_inquiry');
    $this->db->join('tbl_sales_person', 'tbl_sales_person.idtbl_sales_person = tbl_customer_inquiry.salesperson_id', 'left');
    $this->db->join('tbl_vehicle_model', 'tbl_vehicle_model.idtbl_vehicle_model = tbl_customer_inquiry.vehicle_model_id', 'left');
    $this->db->join('tbl_vehicle_brand', 'tbl_vehicle_brand.idtbl_vehicle_brand = tbl_customer_inquiry.vehicle_brand_id', 'left');
    $this->db->like('tbl_customer_inquiry.vehicle_number', $vehicle_number);
    $this->db->group_by('tbl_customer_inquiry.vehicle_number');

    $query = $this->db->get();
    return $query->result();
    }
    


    public function addvehicle_detail(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $vehicle_number=$this->input->post('model_vehicle_number');
        $vehicle_brand_id=$this->input->post('model_vehicle_brand_id');
        $vehicle_model_id=$this->input->post('model_vehicle_model_id');
        $recordID=$this->input->post('recordIDTomodel');
        $recordOptionModel=$this->input->post('recordOptionModel');

        $insertdatetime=date('Y-m-d H:i:s');

        if($recordOptionModel==1){
        $data3 = array(
                'customer_vehicle_number'=> $vehicle_number, 
                'vehicle_brand_id'=> $vehicle_brand_id, 
                'vehicle_model_id'=> $vehicle_model_id, 
                'tbl_customer_idtbl_customer'=> $recordID, 
                'status'=> '1',
                'insertdatetime'=> $insertdatetime, 
            );

            $this->db->insert('tbl_customer_vehicle_detail ', $data3);
            // $this->db->update('tbl_customer_vehicle_detail', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                $response = array('status' => 'success', 'message' => 'Vehicle Added Successfully');
                echo json_encode($response);              
            } else {
                $this->db->trans_rollback();
                $response = array('status' => 'error', 'message' => 'Failed to Added Vehicle');
                echo json_encode($response);
            }
        }
        else{
            $data3 = array(
                'customer_vehicle_number'=> $vehicle_number, 
                'vehicle_brand_id'=> $vehicle_brand_id, 
                'vehicle_model_id'=> $vehicle_model_id, 
                'status'=> '1',
                'updatedatetime'=> $insertdatetime, 
            );

            $this->db->where('idtbl_customer_vehicle_detail', $recordID); // Corrected here
            $this->db->update('tbl_customer_vehicle_detail', $data3);
            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                $response = array('status' => 'success', 'message' => 'Vehicle Updated Successfully');
                echo json_encode($response);              
            } else {
                $this->db->trans_rollback();
                $response = array('status' => 'error', 'message' => 'Failed to Update Vehicle');
                echo json_encode($response);
            }
        }
    }



    public function quotationPDF(){

        $branchID = $_SESSION['branch_id'];

        $logopath = 'assets/img/logo.png'; 
        $logotype = pathinfo($logopath, PATHINFO_EXTENSION);
        $logodata = file_get_contents($logopath); 
        $logoIconBase64 = 'data:image/' . $logotype . ';base64,' . base64_encode($logodata); 

        $crosspath = 'assets/img/cross.png'; 
        $crosstype = pathinfo($crosspath, PATHINFO_EXTENSION);
        $crossdata = file_get_contents($crosspath); 
        $crossIconBase64 = 'data:image/' . $crosstype . ';base64,' . base64_encode($crossdata); 

        $count=1;

        $body = '
            <tr>
                <th style="width:3%;text-align:left;" class="datatable_data_td">1</th>
                <th style="width:57%;text-align:left;" class="datatable_data_td">FULL SEAT COVER</th>
                <th style="width:5%;;text-align:center;" class="datatable_data_td">4</th>
                <th style="width:15%;text-align:right;" class="datatable_data_td"> 18,500.00</th>
                <th style="width:20%;text-align:right;" class="datatable_data_td">74,000.00</th>
            </tr>
             <tr>
                <th style="width:3%;text-align:left;" class="datatable_data_td">2</th>
                <th style="width:57%;text-align:left;" class="datatable_data_td">OEM DOT</th>
                <th style="width:5%;;text-align:center;" class="datatable_data_td">4</th>
                <th style="width:15%;text-align:right;" class="datatable_data_td"> 600.00 </th>
                <th style="width:20%;text-align:right;" class="datatable_data_td">2,400.00</th>
            </tr>
             <tr>
                <th style="width:3%;text-align:left;" class="datatable_data_td">3</th>
                <th style="width:57%;text-align:left;" class="datatable_data_td">Cushion Repair</th>
                <th style="width:5%;;text-align:center;" class="datatable_data_td">1</th>
                <th style="width:15%;text-align:right;" class="datatable_data_td"> 24,800.00</th>
                <th style="width:20%;text-align:right;" class="datatable_data_td">24,800.00</th>
            </tr>
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
                    font-size: 9px;
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
                    margin-top: 120px;

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
                    background-color:#c00000;
                    color:#fff;
                    border-top: 1.5px solid #000;
                    border-bottom: 1.5px solid #000;
                    font-size:10px
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
            <header>
                <table style="table-layout: fixed;padding:3px;width:100%;border-collapse: collapse;">
                    <tr>
                        <th rowspan="4" style="text-align:left;width:30%;"><img style="height:65px;collapse;margin-left:5px" src="'.$logoIconBase64.'"/></th>
                        <th style="width:70%;color:#082458;" class="header_th">"Splendor of Sri Lankan Vehicle Interior Modification Industry"</th>
                    </tr>
                    <tr>
                        <th class="header_th" style="font-size:14px;color: #c00000;">EDIRISINGHA CUSHION WORKS (PVT) LTD</th>
                    </tr>
                    <tr>
                        <th class="header_th">
                        <span style="margin-right:10px;"><i class="fas fa-phone" style="color: #c00000;"></i> +94(0)33 22 86 729</span>
                        <span style="margin-right:10px;"><i class="fas fa-envelope" style="color: green;"></i> admin@edirisinghagroup.lk</span>
                        <span style=""><i class="fab fa-internet-explorer" style="color: blue;"></i> www.edirisinghagroup.lk</th></span>
                    </tr>
                    <tr>
                        <th class="header_th">NO.06, KANDY ROAD, NAWAGAMUWA, NITTAMBUWA, SRI LANKA- 11890</th>
                    </tr>
                </table>
            </header>
            
            <div class="content">
             <table style="table-layout: fixed;padding:3px;padding-left:20px;padding-right:20px;width:100%;border-collapse: collapse;">
               <tr>
                    <th colspan="2" style="width:65%;font-size:18px;" class="sub_header_text_th"><span style="padding-bottom:4px;font-weight:500;">QUOTATION</span></th>
                    <th style="width:15%;" class="sub_header_text_th">QUOTATION NO</th>
                    <th style="width:20%;" class="sub_header_text_td">Q-24000011</th>
                </tr>
                 <tr>
                    <th style="width:10%;" class="sub_header_text_th">CUSTOMER</th>
                    <th style="width:55%;" class="sub_header_text_td">Assisant Commissioner of Local Government ,</th>
                    <th style="width:15%;" class="sub_header_text_th">VEHICLE MODEL</th>
                    <th style="width:20%;" class="sub_header_text_td">TOYOTA HILUX"</th>
                </tr>
                 <tr>
                    <th style="" class="sub_header_text_th">ADDRESS</th>
                    <th style="" class="sub_header_text_td">St.Antonys Road Trincomalee</th>
                    <th style="" class="sub_header_text_th">VEHICLE NO</th>
                    <th style="" class="sub_header_text_td">PF - 9433</th>
                </tr>
                 <tr>
                    <th style="" class="sub_header_text_th">CONTACT</th>
                    <th style="" class="sub_header_text_td">779684850</th>
                    <th style="" class="sub_header_text_th">DATE</th>
                    <th style="" class="sub_header_text_td">12/11/2024</th>
                </tr>
             </table>
             <br>
             <table style="table-layout: fixed;padding:3px;width:100%;border-collapse: collapse;">
                <tr>
                    <th style="width:3%;text-align:left;" class="sub_header_text_th datatable_td">#</th>
                    <th style="width:57%;text-align:left;" class="sub_header_text_th datatable_td">PRODUCT DESCRIPTION</th>
                    <th style="width:5%;;text-align:center;" class="sub_header_text_th datatable_td">QTY</th>
                    <th style="width:15%;text-align:right;" class="sub_header_text_th datatable_td">UNIT PRICE</th>
                    <th style="width:20%;text-align:right;" class="sub_header_text_th datatable_td">AMOUNT </th>
                </tr>';
                $html .= $body;
                $html .= '<tr>
                    <td colspan="4" class="sub_header_text_th datatable_total_td">TOTAL</td>
                    <td class="sub_header_text_th datatable_total_td"></td>
                </tr>
                 <tr>
                    <td colspan="2" style="border: none;"></td>
                    <td colspan="2" class="sub_header_text_th datatable_total_td">GRAND TOTAL</td>
                    <td class="sub_header_text_th datatable_total_td">101,200.00</td>
                </tr>
                <tr>
                    <td colspan="5" style="font-weight: 700;padding: 0;height: 4px; line-height: 0.6rem;font-style: italic;">** Terms & Conditions</td>
                </tr>
                 <tr>
                    <td colspan="5" style="font-weight: 400;padding: 0;height: 4px; line-height: 0.6rem;">Payment methods: Cash</td>
                </tr>
                 <tr>
                    <td colspan="5" style="font-weight: 400;padding: 0;height: 4px; line-height: 0.6rem;">This quotation is only valid for 7 working days</td>
                </tr>
                 <tr>
                    <td colspan="5" style="font-weight: 400;padding: 0;height: 4px; line-height: 0.6rem;">50% Advance Payment Requred</td>
                </tr>
             </table>
            <div style="margin-top:20px"></div>
            <table style="table-layout: fixed;padding:3px;width:100%;border-collapse: collapse;">
                <tr>
                    <th style="padding:3px;text-align:center;vertical-align: bottom;font-weight:500">......................................................</th>
                    <th style="padding:3px;text-align:center;vertical-align: bottom;font-weight:500">......................................................</th>
                    <th style="padding:3px;text-align:center;vertical-align: bottom;font-weight:500">......................................................</th>
                </tr>
                <tr>
                    <th style="padding:3px;text-align:center;font-weight:500">PREPAIRED BY</th>
                    <th style="padding:3px;text-align:center;font-weight:500">CHECKED BY</th>
                    <th style="padding:3px;text-align:center;font-weight:500">SHOWROOM MANAGER</th>
                </tr>
            </table>
            </div>

        </body>

        </html>';

        $this->load->library('Pdf');
        $this->pdf->set_option('isRemoteEnabled', true);
        $this->pdf->setPaper('A4', 'portrait');
        $this->pdf->loadHtml($html, 'UTF-8');
        $this->pdf->render();
        $this->pdf->stream( "Quotation.pdf", array("Attachment"=>0));


    }
    
    public function jobSummaryPDF(){

        $branchID = $_SESSION['branch_id'];

        $logopath = 'assets/img/logo.png'; 
        $logotype = pathinfo($logopath, PATHINFO_EXTENSION);
        $logodata = file_get_contents($logopath); 
        $logoIconBase64 = 'data:image/' . $logotype . ';base64,' . base64_encode($logodata); 

        $crosspath = 'assets/img/cross.png'; 
        $crosstype = pathinfo($crosspath, PATHINFO_EXTENSION);
        $crossdata = file_get_contents($crosspath); 
        $crossIconBase64 = 'data:image/' . $crosstype . ';base64,' . base64_encode($crossdata); 

        $count=1;

        $header='<tr>
                    <th style="width:3%;text-align:left;" class="sub_header_text_th datatable_td">#</th>
                    <th style="width:46%;text-align:left;" class="sub_header_text_th datatable_td">PRODUCT DESCRIPTION</th>
                    <th style="width:5%;;text-align:center;" class="sub_header_text_th datatable_td">QTY</th>
                    <th style="width:10%;text-align:center;" class="sub_header_text_th datatable_td">UNIT</th>
                    <th style="width:13%;text-align:right;" class="sub_header_text_th datatable_td">RATE</th>
                    <th style="width:8%;text-align:center;" class="sub_header_text_th datatable_td">DISC.%</th>
                    <th style="width:15%;text-align:right;" class="sub_header_text_th datatable_td">AMOUNT </th>
                </tr>';

        $body='';

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
                    margin: 5mm 15mm 5mm 5mm; /* top right bottom left */
                }
                body {
                    margin: 0;
                    font-family: "Roboto", sans-serif;
                    font-size: 9px;
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
                    // border-bottom: 2px solid #000;
                }

                footer {
                    position: fixed;
                    bottom: 20px; 
                    left: 0;
                    right: 0;
                    height: 30px;
                    text-align: center;
                    line-height: 30px;
                    border-top: 2px solid #000;
                }

                .content {
                    margin-top: 112px;
                }
                .header_th{
                    text-align:left;
                    height: 8px;
                    line-height: 0.6rem;
                    padding: 0; 
                    font-weight: 400; 
                }
                .sub_header_text_th{
                    text-align:left;
                    height: 4px;
                    line-height: 0.6rem;
                    padding: 0; 
                    font-weight: 700; 
                }
                .sub_header_text_td{
                    text-align:left;
                    height: 4px;
                    line-height: 0.6rem;
                    padding: 0; 
                    font-weight: 400; 
                }
                .datatable_td{
                    padding:3px;
                    border-top: 1.5px solid #000;
                    border-bottom: 1.5px solid #000;
                    font-size:10px
                }
                .datatable_data_td{
                    border: none;
                    text-align:left;
                    height: 4px;
                    line-height: 0.8rem;
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
                .footer_text{
                    height: 8px;
                    line-height: 0.7rem;
                    padding: 0; 
                    font-weight: 400; 
                }

            </style>
        </head>

        <body>
            <header>
                <table style="table-layout: fixed;padding:3px;width:100%;border-collapse: collapse;">
                    <tr>
                        <th rowspan="7" style="text-align:left;width:17%;"><img style="height:65px;collapse;margin-left:5px" src="'.$logoIconBase64.'"/></th>
                        <th colspan="4" style="width:83%;font-size:14px;font-weight:500;text-align:center;" class="header_th"><span style="margin-left:-55">JOB SUMMARY</span></th>
                    </tr>
                    <diV></div>
                    <tr>
                        <th style="width:10%;" class="header_th">Cus. Code</th>
                        <th style="width:25%;" class="header_th"><span> : </span>3634</th>
                        <th style="width:10%;" class="header_th">Job No.</th>
                        <th style="width:10%;" class="header_th"><span> : </span>J241170</th>
                    </tr>
                    <tr>
                        <th style="width:10%;" class="header_th">Cus. Name</th>
                        <th style="width:25%;" class="header_th"><span> : </span>Kasun Chathuranga</th>
                        <th style="width:10%;" class="header_th">PO No.</th>
                        <th style="width:10%;" class="header_th"><span> : </span>None</th>
                    </tr>
                    <tr>
                        <th style="width:10%;" class="header_th">Address</th>
                        <th style="width:20%;" class="header_th"><span> : </span>11, Walpola, Ruggahawila</th>
                        <th style="width:10%;" class="header_th">S.P.Code</th>
                        <th style="width:10%;" class="header_th"><span> : </span>02</th>
                    </tr>
                     <tr>
                        <th style="width:10%;" class="header_th">Vehicle No.</th>
                        <th style="width:25%;" class="header_th"><span> : </span>LZ-0186</th>
                        <th style="width:10%;" class="header_th">Created Date</th>
                        <th style="width:10%;" class="header_th"><span> : </span>21/08/024</th>
                    </tr>
                     <tr>
                        <th style="width:10%;" class="header_th">Vehicle Type.</th>
                        <th style="width:25%;" class="header_th"><span> : </span>Maruti Suzuki</th>
                        <th style="width:10%;" class="header_th">NIC No</th>
                        <th style="width:10%;" class="header_th"><span> : </span>991212121V</th>
                    </tr>
                </table>
            </header>
            <footer>
              <table style="table-layout: fixed;padding:3px;width:100%;border-collapse: collapse;">
              <tr>
                <td style="width:65%;" class="footer_text">EDIRISINGHA GROUP (PVT.) LTD</td>
                <td style="width:20%;text-align:center;" class="footer_text">FIND US</td>
                <td rowspan="2" style="width:20%;text-align:right;" class="footer_text">
                    <i class="fab fa-facebook-square" style="margin-right:2px;font-size:14px;"></i> 
                    <i class="fab fa-tiktok" style="margin-right:2px;font-size:14px;"></i>
                    <i class="fab fa-instagram-square" style="margin-right:2px;font-size:14px;"></i>
                    <i class="fab fa-youtube" style="margin-right:2px;font-size:14px;"></i>
                </td>
              </tr>
              <tr>
                <td class="footer_text">BRANCH COLOMBO ROAD, KURANA, NEGOMBO 0312 224 220</td>
                <td style="text-align:center;" class="footer_text">FOLLOW US</td>
              </tr>
              <tr>
                <td colspan="3;" class="footer_text" style="letter-spacing: 3.53px;">THE PRIME OF VEHICLE INTERIOR & EXTERIOR MODIFICATION</td>
              </tr>
              </table>
            </footer>
            <div class="content" style="border: none;">
             <table style="table-layout: fixed;padding:3px;width:100%;border-collapse: collapse;border: none;">';
              $html .= $header;
                $html .= '<tbody class="dataTableBody" style="border-bottom: 1.5px solid #000;">';
                $count = 1;
                for ($c = 1; $c <= 40; $c++) {
                    $html .= '
                        <tr>
                            <th style="width:3%; text-align:left;font-size:8px" class="datatable_data_td">' . $count . '</th>
                            <th style="width:42%; text-align:left;font-size:8px" class="datatable_data_td">FULL SEAT COVER</th>
                            <th style="width:5%; text-align:center;font-size:8px" class="datatable_data_td">4</th>
                            <th style="width:10%; text-align:center;font-size:8px" class="datatable_data_td">EA</th>
                            <th style="width:15%; text-align:right;font-size:8px" class="datatable_data_td">43,625.00</th>
                            <th style="width:10%; text-align:center;font-size:8px" class="datatable_data_td">0.00</th>
                            <th style="width:15%; text-align:right;font-size:8px" class="datatable_data_td">174,500.00</th>
                        </tr>';
                        if ($count % 11 == 0) {
                            $html .= '
                            <div style="page-break-after: always; border: none;margin-top: 115px;"></div>
                            <div style="margin-top: 115px;border: none;"></div>';
                            $html .= $header;
                        }
                    $count++; 
                }

                $html .= '</tbody>
             </table>
             <table style="table-layout: fixed;padding:3px;width:100%;border-collapse: collapse;">
                <tr>
                    <td style="width:30%;text-align:left;" class="datatable_data_td">Pay.Method : Bank</td>
                    <td style="width:40%;text-align:left;" class="datatable_data_td">Due. Date : N/A</td>
                    <td colspan="3" style="width:13%;text-align:left;" class="datatable_data_td">Total Value</td>
                    <td style="width:2%;text-align:center;" class="datatable_data_td">:</td>
                    <td style="width:15%;text-align:right;" class="datatable_data_td">443,000.00</td>
                </tr>
                 <tr>
                    <td colspan="4" style="width:70%;text-align:left;" class="datatable_data_td"></td>
                    <td style="width:13%;text-align:left;" class="datatable_data_td">Disc. Total</td>
                    <td style="width:2%;text-align:center;" class="datatable_data_td">:</td>
                    <td style="width:15%;text-align:right;" class="datatable_data_td">43,625.00</td>
                </tr>
                 <tr>
                    <td colspan="4" style="width:70%;text-align:left;" class="datatable_data_td"></td>
                    <td style="width:13%;text-align:left;" class="datatable_data_td">SVAT / VAT</td>
                    <td style="width:2%;text-align:center;" class="datatable_data_td">:</td>
                    <td style="width:15%;text-align:right;" class="datatable_data_td">N/A</td>
                </tr>
                 <tr>
                    <td colspan="4" style="width:70%;text-align:left;" class="datatable_data_td"></td>
                    <td style="width:13%;text-align:left;" class="datatable_data_td">Total</td>
                    <td style="width:2%;text-align:center;" class="datatable_data_td">:</td>
                    <td style="width:15%;text-align:right;" class="datatable_data_td">443,000.00</td>
                </tr>
                 <tr>
                    <td style="width:30%;text-align:center;" class="datatable_data_td">........................</td>
                    <td style="width:40%;text-align:center;" class="datatable_data_td">........................</td>
                    <td colspan="3" style="width:13%;text-align:left;" class="datatable_data_td">T. Advance</td>
                    <td style="width:2%;text-align:center;" class="datatable_data_td">:</td>
                    <td style="width:15%;text-align:right;" class="datatable_data_td">5,000.00</td>
                </tr>
                 <tr>
                    <td style="width:30%;text-align:center;" class="datatable_data_td">Customer</td>
                    <td style="width:40%;text-align:center;" class="datatable_data_td">Sales Person</td>
                    <td colspan="3" style="width:13%;text-align:left;border-top: 1px solid #000; border-bottom: 3px double #000;" class="datatable_data_td">Balance</td>
                    <td style="width:2%;text-align:center;border-top: 1px solid #000; border-bottom: 3px double #000;" class="datatable_data_td">:</td>
                    <td style="width:15%;text-align:right;border-top: 1px solid #000; border-bottom: 3px double #000;" class="datatable_data_td">438,000.00</td>
                </tr>
             </table>
            </div>

        </body>

        </html>';

        $this->load->library('Pdf');
        $this->pdf->set_option('isRemoteEnabled', true);
        $this->pdf->setPaper('A4', 'portrait');
        $customPaper = array(0, 0, 396.9, 396.9);
        $this->pdf->setPaper($customPaper);
        $this->pdf->loadHtml($html, 'UTF-8');
        $this->pdf->render();
        $this->pdf->stream( "Job_Summary.pdf", array("Attachment"=>0));


    }

    public function invoicePDF(){

        $branchID = $_SESSION['branch_id'];

        $logopath = 'assets/img/logo.png'; 
        $logotype = pathinfo($logopath, PATHINFO_EXTENSION);
        $logodata = file_get_contents($logopath); 
        $logoIconBase64 = 'data:image/' . $logotype . ';base64,' . base64_encode($logodata); 

        $crosspath = 'assets/img/cross.png'; 
        $crosstype = pathinfo($crosspath, PATHINFO_EXTENSION);
        $crossdata = file_get_contents($crosspath); 
        $crossIconBase64 = 'data:image/' . $crosstype . ';base64,' . base64_encode($crossdata); 

        $count=1;

        $header='<tr>
                    <th style="width:3%;text-align:left;" class="sub_header_text_th datatable_td">#</th>
                    <th style="width:46%;text-align:left;" class="sub_header_text_th datatable_td">PRODUCT DESCRIPTION</th>
                    <th style="width:5%;;text-align:center;" class="sub_header_text_th datatable_td">QTY</th>
                    <th style="width:10%;text-align:center;" class="sub_header_text_th datatable_td">UNIT</th>
                    <th style="width:13%;text-align:right;" class="sub_header_text_th datatable_td">RATE</th>
                    <th style="width:8%;text-align:center;" class="sub_header_text_th datatable_td">DISC.%</th>
                    <th style="width:15%;text-align:right;" class="sub_header_text_th datatable_td">AMOUNT </th>
                </tr>';

        $body='';

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
                    margin: 5mm 15mm 5mm 5mm; /* top right bottom left */
                }
                body {
                    margin: 0;
                    font-family: "Roboto", sans-serif;
                    font-size: 9px;
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
                    // border-bottom: 2px solid #000;
                }

                footer {
                    position: fixed;
                    bottom: 20px; 
                    left: 0;
                    right: 0;
                    height: 30px;
                    text-align: center;
                    line-height: 30px;
                    border-top: 2px solid #000;
                }

                .content {
                    margin-top: 112px;
                }
                .header_th{
                    text-align:left;
                    height: 8px;
                    line-height: 0.6rem;
                    padding: 0; 
                    font-weight: 400; 
                }
                .sub_header_text_th{
                    text-align:left;
                    height: 4px;
                    line-height: 0.6rem;
                    padding: 0; 
                    font-weight: 700; 
                }
                .sub_header_text_td{
                    text-align:left;
                    height: 4px;
                    line-height: 0.6rem;
                    padding: 0; 
                    font-weight: 400; 
                }
                .datatable_td{
                    padding:3px;
                    border-top: 1.5px solid #000;
                    border-bottom: 1.5px solid #000;
                    font-size:10px
                }
                .datatable_data_td{
                    border: none;
                    text-align:left;
                    height: 4px;
                    line-height: 0.8rem;
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
                .footer_text{
                    height: 8px;
                    line-height: 0.7rem;
                    padding: 0; 
                    font-weight: 400; 
                }

            </style>
        </head>

        <body>
            <header>
                <table style="table-layout: fixed;padding:3px;width:100%;border-collapse: collapse;">
                    <tr>
                        <th rowspan="7" style="text-align:left;width:17%;"><img style="height:65px;collapse;margin-left:5px" src="'.$logoIconBase64.'"/></th>
                        <th colspan="4" style="width:83%;font-size:14px;font-weight:500;text-align:center;" class="header_th"><span style="margin-left:-55">INVOICE(R)</span></th>
                    </tr>
                    <diV></div>
                    <tr>
                        <th style="width:10%;" class="header_th">Cus. Name</th>
                        <th style="width:25%;" class="header_th"><span> : </span>Kasun Chathuranga</th>
                        <th style="width:10%;" class="header_th">Inv.No.</th>
                        <th style="width:10%;" class="header_th"><span> : </span>EC24IN1472</th>
                    </tr>
                    <tr>
                        <th style="width:10%;" class="header_th">Address</th>
                        <th style="width:20%;" class="header_th"><span> : </span>11, Walpola, Ruggahawila</th>
                        <th style="width:10%;" class="header_th">In.Date</th>
                        <th style="width:10%;" class="header_th"><span> : </span>02/11/2024</th>
                    </tr>
                     <tr>
                        <th style="width:10%;" class="header_th">Vehicle No.</th>
                        <th style="width:25%;" class="header_th"><span> : </span>LZ-0186</th>
                        <th style="width:10%;" class="header_th">Cus. Po</th>
                        <th style="width:10%;" class="header_th"><span> : </span>N/A</th>
                    </tr>
                     <tr>
                        <th style="width:10%;" class="header_th">VAT Reg No.</th>
                        <th style="width:25%;" class="header_th"><span> : </span>N/A</th>
                        <th style="width:10%;" class="header_th">Our VAt No.</th>
                        <th style="width:10%;" class="header_th"><span> : </span>N/A</th>
                    </tr>
                    <tr>
                        <th style="width:10%;" class="header_th">SVAT No.</th>
                        <th style="width:25%;" class="header_th"><span> : </span>N/A</th>
                        <th style="width:10%;" class="header_th">S.P.Code</th>
                        <th style="width:10%;" class="header_th"><span> : </span>08</th>
                    </tr>
                    
                </table>
            </header>
            <footer>
              <table style="table-layout: fixed;padding:3px;width:100%;border-collapse: collapse;">
              <tr>
                <td style="width:65%;" class="footer_text">EDIRISINGHA GROUP (PVT.) LTD</td>
                <td style="width:20%;text-align:center;" class="footer_text">FIND US</td>
                <td rowspan="2" style="width:20%;text-align:right;" class="footer_text">
                    <i class="fab fa-facebook-square" style="margin-right:2px;font-size:14px;"></i> 
                    <i class="fab fa-tiktok" style="margin-right:2px;font-size:14px;"></i>
                    <i class="fab fa-instagram-square" style="margin-right:2px;font-size:14px;"></i>
                    <i class="fab fa-youtube" style="margin-right:2px;font-size:14px;"></i>
                </td>
              </tr>
              <tr>
                <td class="footer_text">BRANCH COLOMBO ROAD, KURANA, NEGOMBO 0312 224 220</td>
                <td style="text-align:center;" class="footer_text">FOLLOW US</td>
              </tr>
              <tr>
                <td colspan="3;" class="footer_text" style="letter-spacing: 3.53px;">THE PRIME OF VEHICLE INTERIOR & EXTERIOR MODIFICATION</td>
              </tr>
              </table>
            </footer>
            <div class="content" style="border: none;">
             <table style="table-layout: fixed;padding:3px;width:100%;border-collapse: collapse;border: none;">';
              $html .= $header;
                $html .= '<tbody class="dataTableBody" style="border-bottom: 1.5px solid #000;">';
                $count = 1;
                for ($c = 1; $c <= 40; $c++) {
                    $html .= '
                        <tr>
                            <th style="width:3%; text-align:left;font-size:8px" class="datatable_data_td">' . $count . '</th>
                            <th style="width:42%; text-align:left;font-size:8px" class="datatable_data_td">FULL SEAT COVER</th>
                            <th style="width:5%; text-align:center;font-size:8px" class="datatable_data_td">4</th>
                            <th style="width:10%; text-align:center;font-size:8px" class="datatable_data_td">EA</th>
                            <th style="width:15%; text-align:right;font-size:8px" class="datatable_data_td">43,625.00</th>
                            <th style="width:10%; text-align:center;font-size:8px" class="datatable_data_td">0.00</th>
                            <th style="width:15%; text-align:right;font-size:8px" class="datatable_data_td">174,500.00</th>
                        </tr>';
                        if ($count % 11 == 0) {
                            $html .= '
                            <div style="page-break-after: always; border: none;margin-top: 115px;"></div>
                            <div style="margin-top: 115px;border: none;"></div>';
                            $html .= $header;
                        }
                    $count++; 
                }

                $html .= '</tbody>
             </table>
             <table style="table-layout: fixed;padding:3px;width:100%;border-collapse: collapse;">
                <tr>
                    <td style="width:30%;text-align:left;" class="datatable_data_td">Pay.Method : Bank</td>
                    <td style="width:40%;text-align:left;" class="datatable_data_td">Due. Date : N/A</td>
                    <td colspan="3" style="width:13%;text-align:left;" class="datatable_data_td">Total Value</td>
                    <td style="width:2%;text-align:center;" class="datatable_data_td">:</td>
                    <td style="width:15%;text-align:right;" class="datatable_data_td">443,000.00</td>
                </tr>
                 <tr>
                    <td colspan="4" style="width:70%;text-align:left;" class="datatable_data_td"></td>
                    <td style="width:13%;text-align:left;" class="datatable_data_td">Disc. Total</td>
                    <td style="width:2%;text-align:center;" class="datatable_data_td">:</td>
                    <td style="width:15%;text-align:right;" class="datatable_data_td">43,625.00</td>
                </tr>
                 <tr>
                    <td colspan="4" style="width:70%;text-align:left;" class="datatable_data_td"></td>
                    <td style="width:13%;text-align:left;" class="datatable_data_td">SVAT / VAT</td>
                    <td style="width:2%;text-align:center;" class="datatable_data_td">:</td>
                    <td style="width:15%;text-align:right;" class="datatable_data_td">N/A</td>
                </tr>
                 <tr>
                    <td colspan="4" style="width:70%;text-align:left;" class="datatable_data_td"></td>
                    <td style="width:13%;text-align:left;" class="datatable_data_td">Total</td>
                    <td style="width:2%;text-align:center;" class="datatable_data_td">:</td>
                    <td style="width:15%;text-align:right;" class="datatable_data_td">443,000.00</td>
                </tr>
                 <tr>
                    <td style="width:30%;text-align:center;" class="datatable_data_td">........................</td>
                    <td style="width:40%;text-align:center;" class="datatable_data_td">........................</td>
                    <td colspan="3" style="width:13%;text-align:left;" class="datatable_data_td">T. Advance</td>
                    <td style="width:2%;text-align:center;" class="datatable_data_td">:</td>
                    <td style="width:15%;text-align:right;" class="datatable_data_td">5,000.00</td>
                </tr>
                 <tr>
                    <td style="width:30%;text-align:center;" class="datatable_data_td">Customer</td>
                    <td style="width:40%;text-align:center;" class="datatable_data_td">Sales Person</td>
                    <td colspan="3" style="width:13%;text-align:left;border-top: 1px solid #000; border-bottom: 3px double #000;" class="datatable_data_td">Balance</td>
                    <td style="width:2%;text-align:center;border-top: 1px solid #000; border-bottom: 3px double #000;" class="datatable_data_td">:</td>
                    <td style="width:15%;text-align:right;border-top: 1px solid #000; border-bottom: 3px double #000;" class="datatable_data_td">438,000.00</td>
                </tr>
             </table>
            </div>

        </body>

        </html>';

        $this->load->library('Pdf');
        $this->pdf->set_option('isRemoteEnabled', true);
        $this->pdf->setPaper('A4', 'portrait');
        $customPaper = array(0, 0, 396.9, 396.9);
        $this->pdf->setPaper($customPaper);
        $this->pdf->loadHtml($html, 'UTF-8');
        $this->pdf->render();
        $this->pdf->stream( "Invoice.pdf", array("Attachment"=>0));


    }
           

}