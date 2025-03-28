<?php
class JobCard_informationinfo extends CI_Model{


    public function GetDesigns()
    {
        $query = $this->db->get('tbl_stitching_design'); 
        return $query->result_array(); 
    }

    public function Getlogo(){
        $this->db->select('idtbl_logo , logo_type');
        $this->db->from('tbl_logo');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function Getcomfort_layer(){
        $this->db->select('idtbl_hybrid_comfort , hybrid_comfort_name , price');
        $this->db->from('tbl_hybrid_comfort');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function Getlogo_status(){
        $this->db->select('idtbl_logo_status , logo_status , price');
        $this->db->from('tbl_logo_status');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    // public function Getseat_type() {
    //     $this->db->select('idtbl_seat_type , seat_type');
    //     $this->db->from('tbl_seat_type');
    //     $this->db->where('status', 1);

    //     return $respond=$this->db->get();
    // }

    public function Getseat_type() {
        $sub_job_category_id = $this->input->post('sub_job_category_id');

        $this->db->select('idtbl_seat_type, seat_type');
        $this->db->from('tbl_seat_type');
        $this->db->where('status', 1);
        $this->db->where('seat_category', $sub_job_category_id); 
        $query = $this->db->get();
        $result = $query->result_array();
        echo json_encode($result);
        
	}

    public function Getseat_condition() {
        $this->db->select('idtbl_seat_condition , condition_type');
        $this->db->from('tbl_seat_condition');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function Getcategory_type() {
        $this->db->select('idtbl_price_category_type , price_category_type');
        $this->db->from('tbl_price_category_type');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function Getprice_category_type() {
        $this->db->select('idtbl_price_category_type , price_category_type');
        $this->db->from('tbl_price_category_type');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function Getrepair_type() {
        $this->db->select('idtbl_seat_repair_category , sub_Repair_job_name');
        $this->db->from('tbl_seat_repair_category');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function Getstitch_style(){
        $this->db->select('idtbl_stitch_style , stitch_style');
        $this->db->from('tbl_stitch_style');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function Getlogo_color(){
        $this->db->select('idtbl_logo_colour , logo_colour_type');
        $this->db->from('tbl_logo_colour');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function Getthread_color(){
        $this->db->select('idtbl_thread_colour , thread_colour');
        $this->db->from('tbl_thread_colour');
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


    public function Getassesory() {
        $this->db->select('idtbl_accessories ,accessory_name , accessory_price');
        $this->db->from('tbl_accessories');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
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

    public function GetjobcardNumber() {
        $jobcard_id = $this->input->post('jobcard_id');
    
        $this->db->select('job_card_number');
        $this->db->from('tbl_jobcard');
        $this->db->where('status', 1);
        $this->db->where('idtbl_jobcard', $jobcard_id);
    
        $query = $this->db->get();
    
        if ($query->num_rows() > 0) {
            $customer = $query->row(); 
            echo json_encode(['success' => true, 'job_card_number' => $customer->job_card_number]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Job Card not found.']);
        }
    }


    public function GetPrice_cat() {
        $price_cat_id = $this->input->post('price_cat_id');
    
        $this->db->select('idtbl_price_category_type');
        $this->db->from('tbl_price_category_type');
        $this->db->where('status', 1);
        $this->db->where('idtbl_price_category_type', $price_cat_id);
    
        $query = $this->db->get();
    
        if ($query->num_rows() > 0) {
            $customer = $query->row(); 
            echo json_encode(['success' => true, 'idtbl_price_category_type' => $customer->idtbl_price_category_type]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Price Category not found.']);
        }
    }


    public function GetvehicleModel() {
        $vehi_model_id = $this->input->post('vehi_model_id');
    
        $this->db->select('model_name');
        $this->db->from('tbl_vehicle_model');
        $this->db->where('status', 1);
        $this->db->where('idtbl_vehicle_model', $vehi_model_id);
    
        $query = $this->db->get();
    
        if ($query->num_rows() > 0) {
            $customer = $query->row(); 
            echo json_encode(['success' => true, 'model_name' => $customer->model_name]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Vehicle Model not found.']);
        }
    }

    public function GetdesignPrice() {
        $design_id = $this->input->post('design_id');
        $vehicle_model_id=$this->input->post('vehicle_model_id');
        $job_id=$this->input->post('job_id');
        $price_cat_id=$this->input->post('price_cat_id');
    
        $this->db->select('*');
        $this->db->from('tbl_vehicle_model');
        $this->db->where('idtbl_vehicle_model', $vehicle_model_id);
        $this->db->where('status', 1);

        $respond=$this->db->get();
        $price_category_id=$respond->row(0)->price_category_id ;
        $vehicle_type_id=$respond->row(0)->vehicle_type_id ;
        $vehi_type = $vehicle_type_id !=19 ?  1 : 2 ;

        $this->db->select('tbl_stitching_design_price_details.price');
        $this->db->from('tbl_stitching_design_price_details');
        $this->db->join('tbl_stitching_design','tbl_stitching_design.idtbl_stitching_design = tbl_stitching_design_price_details.tbl_stitching_design_id','left');
        $this->db->where('tbl_stitching_design_price_details.price_category_type_id', $price_cat_id);
        $this->db->where('tbl_stitching_design_price_details.tbl_stitching_design_id', $design_id);
        $this->db->where('tbl_stitching_design_price_details.vehicle_type', $vehi_type);
        $this->db->where('tbl_stitching_design_price_details.job_id', $job_id);

        $respond2=$this->db->get();

        $obj=new stdClass();
        if ($respond2->num_rows() > 0) {
            $obj->design_price=$respond2->row(0)->price;
        }
        echo json_encode($obj);

    }


    public function getCushionReplacementPrice() {
        $vehicle_model_id=$this->input->post('vehicle_model_id');
        $price_cat_id=$this->input->post('price_cat_id');
        $job_id=$this->input->post('job_id');
    
        $this->db->select('*');
        $this->db->from('tbl_vehicle_model');
        $this->db->where('idtbl_vehicle_model', $vehicle_model_id);
        $this->db->where('status', 1);

        $respond=$this->db->get();
        $price_category_id=$respond->row(0)->price_category_id ;


        $this->db->select('tbl_cushion_replacement_price_details.price');
        $this->db->from('tbl_cushion_replacement_price_details');
        $this->db->where('tbl_cushion_replacement_price_details.price_category_type_id', $price_cat_id);
        $this->db->where('tbl_cushion_replacement_price_details.job_id', $job_id);

        $respond2=$this->db->get();

        $obj=new stdClass();
        if ($respond2->num_rows() > 0) {
            $obj->material_design_price=$respond2->row(0)->price;
        }
        echo json_encode($obj);

    }



    public function getcoverDesignPrice() {
        $vehicle_model_id=$this->input->post('vehicle_model_id');
        $price_cat_id=$this->input->post('price_cat_id');
        $job_id=$this->input->post('job_id');
    
        $this->db->select('*');
        $this->db->from('tbl_vehicle_model');
        $this->db->where('idtbl_vehicle_model', $vehicle_model_id);
        $this->db->where('status', 1);

        $respond=$this->db->get();
        $price_category_id=$respond->row(0)->price_category_id ;
        $vehicle_type_id=$respond->row(0)->vehicle_type_id ;
        $vehi_type = $vehicle_type_id !=19 ?  1 : 2 ;


        $this->db->select('tbl_cover_design_price_details.price');
        $this->db->from('tbl_cover_design_price_details');
        $this->db->where('tbl_cover_design_price_details.price_category_type_id', $price_cat_id);
        $this->db->where('tbl_cover_design_price_details.vehicle_type', $vehi_type);
        $this->db->where('tbl_cover_design_price_details.job_id', $job_id);

        $respond2=$this->db->get();

        $obj=new stdClass();
        if ($respond2->num_rows() > 0) {
            $obj->cover_design_price=$respond2->row(0)->price;
        }
        echo json_encode($obj);

    }


    public function getcushionModificationPrice() {
        $vehicle_model_id=$this->input->post('vehicle_model_id');
        $price_cat_id=$this->input->post('price_cat_id');
        $job_id=$this->input->post('job_id');
    
        $this->db->select('*');
        $this->db->from('tbl_vehicle_model');
        $this->db->where('idtbl_vehicle_model', $vehicle_model_id);
        $this->db->where('status', 1);

        $respond=$this->db->get();
        $price_category_id=$respond->row(0)->price_category_id ;
        $vehicle_type_id=$respond->row(0)->vehicle_type_id ;
        $vehi_type = $vehicle_type_id !=19 ?  1 : 2 ;


        $this->db->select('tbl_cushion_modification_price_details.price');
        $this->db->from('tbl_cushion_modification_price_details');
        $this->db->where('tbl_cushion_modification_price_details.price_category_type_id', $price_cat_id);
        $this->db->where('tbl_cushion_modification_price_details.vehicle_type', $vehi_type);
        $this->db->where('tbl_cushion_modification_price_details.job_id', $job_id);

        $respond2=$this->db->get();

        $obj=new stdClass();
        if ($respond2->num_rows() > 0) {
            $obj->cushion_modify_price=$respond2->row(0)->price;
        }
        echo json_encode($obj);

    }


    public function GetDotdesignPrice() {
        $dot_design = $this->input->post('dot_design');
        $vehicle_model_id=$this->input->post('vehicle_model_id');
        $job_id=$this->input->post('job_id');
        $price_cat_id=$this->input->post('price_cat_id');
    
        $this->db->select('*');
        $this->db->from('tbl_vehicle_model');
        $this->db->where('idtbl_vehicle_model', $vehicle_model_id);
        $this->db->where('status', 1);

        $respond=$this->db->get();
        $price_category_id=$respond->row(0)->price_category_id ;
        $vehicle_type_id=$respond->row(0)->vehicle_type_id ;
        $vehi_type = $vehicle_type_id !=19 ?  1 : 2 ;

        $this->db->select('tbl_dot_design_price_details.price');
        $this->db->from('tbl_dot_design_price_details');
        $this->db->where('tbl_dot_design_price_details.price_category_type_id', $price_cat_id);
        $this->db->where('tbl_dot_design_price_details.tbl_dot_design_id', $dot_design);
        $this->db->where('tbl_dot_design_price_details.vehicle_type', $vehi_type);
        $this->db->where('tbl_dot_design_price_details.job_id', $job_id);

        $respond2=$this->db->get();

        $obj=new stdClass();
        if ($respond2->num_rows() > 0) {
            $obj->dot_design_price=$respond2->row(0)->price;
        }
        echo json_encode($obj);

    }


    public function getpipening_designPrice() {
        $pipening_design = $this->input->post('pipening_design');
        $vehicle_model_id=$this->input->post('vehicle_model_id');
        $job_id=$this->input->post('job_id');

        $this->db->select('*');
        $this->db->from('tbl_vehicle_model');
        $this->db->where('idtbl_vehicle_model', $vehicle_model_id);
        $this->db->where('status', 1);

        $respond=$this->db->get();
        $price_category_id=$respond->row(0)->price_category_id ;
        $vehicle_type_id=$respond->row(0)->vehicle_type_id ;
        $vehi_type = $vehicle_type_id !=19 ?  1 : 2 ;

        $this->db->select('tbl_pipeing_design_price_details.price');
        $this->db->from('tbl_pipeing_design_price_details');
        $this->db->where('tbl_pipeing_design_price_details.tbl_pipeing_design_id', $pipening_design);
        $this->db->where('tbl_pipeing_design_price_details.vehicle_type', $vehi_type);
        $this->db->where('tbl_pipeing_design_price_details.job_id', $job_id);

        $respond2=$this->db->get();

        $obj=new stdClass();
        if ($respond2->num_rows() > 0) {
            $obj->pipening_design_price=$respond2->row(0)->price;
        }
        echo json_encode($obj);

    }


    public function material_insertPrice() {
        $material_incert = $this->input->post('material_incert');
        $vehicle_model_id=$this->input->post('vehicle_model_id');
        $job_id=$this->input->post('job_id');
        $material_incert_type=$this->input->post('material_incert_type');

        $this->db->select('*');
        $this->db->from('tbl_vehicle_model');
        $this->db->where('idtbl_vehicle_model', $vehicle_model_id);
        $this->db->where('status', 1);

        $respond=$this->db->get();
        $price_category_id=$respond->row(0)->price_category_id ;
        $vehicle_type_id=$respond->row(0)->vehicle_type_id ;
        $vehi_type = $vehicle_type_id !=19 ?  1 : 2 ;

        $this->db->select('tbl_special_material_incert_price.price');
        $this->db->from('tbl_special_material_incert_price');
        $this->db->where('tbl_special_material_incert_price.tbl_covering_area_id', $material_incert);
        $this->db->where('tbl_special_material_incert_price.material_incert_type', $material_incert_type);
        $this->db->where('tbl_special_material_incert_price.vehicle_type', $vehi_type);
        $this->db->where('tbl_special_material_incert_price.job_id', $job_id);

        $respond2=$this->db->get();

        $obj=new stdClass();
        if ($respond2->num_rows() > 0) {
            $obj->special_material_incert_price=$respond2->row(0)->price;
        }
        echo json_encode($obj);

    }


    public function getCushion_repairPrice() {
        $cushion_repair = $this->input->post('cushion_repair');
        $vehicle_model_id=$this->input->post('vehicle_model_id');
        $job_id=$this->input->post('job_id');
        $price_cat_id=$this->input->post('price_cat_id');
    
        $this->db->select('*');
        $this->db->from('tbl_vehicle_model');
        $this->db->where('idtbl_vehicle_model', $vehicle_model_id);
        $this->db->where('status', 1);

        $respond=$this->db->get();
        $price_category_id=$respond->row(0)->price_category_id ;
        $vehicle_type_id=$respond->row(0)->vehicle_type_id ;
        $vehi_type = $vehicle_type_id !=19 ?  1 : 2 ;


        $this->db->select('tbl_cushion_repair_price_details.price');
        $this->db->from('tbl_cushion_repair_price_details');
        $this->db->where('tbl_cushion_repair_price_details.price_category_type_id', $price_cat_id);
        $this->db->where('tbl_cushion_repair_price_details.tbl_cushion_repair_id', $cushion_repair);
        $this->db->where('tbl_cushion_repair_price_details.vehicle_type', $vehi_type);
        $this->db->where('tbl_cushion_repair_price_details.job_id', $job_id);

        $respond2=$this->db->get();

        $obj=new stdClass();
        if ($respond2->num_rows() > 0) {
            $obj->cushion_pepair_price=$respond2->row(0)->price;
        }
        echo json_encode($obj);

    }


    public function JobCard_informationinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $jobcard_id=$this->input->post('jobcard_id');
        $main_job_id=$this->input->post('main_job_id');
        $sub_job_category=$this->input->post('sub_job_category');
        $seat_condition_id=$this->input->post('seat_condition_id');
        $seat_type_id=$this->input->post('seat_type_id');
        $job_name=$this->input->post('job_name');
        $jobprice=$this->input->post('jobprice');
        $qty=$this->input->post('qty');
        $japanSeatTableData=$this->input->post('japanSeatTableData');
        $seatRepairTbableData=$this->input->post('seatRepairTbableData');
        $material_id=$this->input->post('material_id');
        $production_advice=$this->input->post('production_advice');
        $logo=$this->input->post('logo');
        $logo_charge=$this->input->post('logo_charge');
        $logo_type=$this->input->post('logo_type');
        $logo_color=$this->input->post('logo_color');
        $thread_color=$this->input->post('thread_color');
        $dot_design=$this->input->post('dot_design');
        $dot_design_charge=$this->input->post('dot_design_charge');
        $stitch_design_id=$this->input->post('stitch_design_id');
        $stitch_design_charge=$this->input->post('stitch_design_charge');
        $stitch_style=$this->input->post('stitch_style');
        $add_cushion_replacement=$this->input->post('add_cushion_replacement');
        $cushion_replacement_charge=$this->input->post('cushion_replacement_charge');
        $add_cover_design=$this->input->post('add_cover_design');
        $cover_design_charge=$this->input->post('cover_design_charge');
        $cushion_repair=$this->input->post('cushion_repair');
        $cushion_repair_charge=$this->input->post('cushion_repair_charge');

        $hybrid_comfort_layer=$this->input->post('hybrid_comfort_layer');
        $hybrid_comfort_price=$this->input->post('hybrid_comfort_price');
        $hybrid_comfort_qty=$this->input->post('hybrid_comfort_qty');

        $logo_qty=$this->input->post('logo_qty');
        $dot_design_qty=$this->input->post('dot_design_qty');
        $stitch_design_qty=$this->input->post('stitch_design_qty');
        $cushion_replacement_qty=$this->input->post('cushion_replacement_qty');
        $cover_design_qty=$this->input->post('cover_design_qty');
        $cushion_repair_qty=$this->input->post('cushion_repair_qty');

        $gross_amount=$this->input->post('gross_amount');
        $discount=$this->input->post('discount');
        $discount_amount=$this->input->post('discount_amount');
        $sub_total=$this->input->post('sub_total');
       

        $recordOption=$this->input->post('recordOption');
        if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}

        $insertdatetime=date('Y-m-d H:i:s');

        $allSubTotal = $this->getAllSubTotal($jobcard_id); 

        if($recordOption==1){
            if ($sub_job_category != '1' && $sub_job_category != '8' && $sub_job_category != '9') {
                foreach($japanSeatTableData AS $list){
                    $job_name=$list['col_2'];
                    $qty=$list['col_4'];
                    $jobprice=$list['col_3'];

                    $data = array(
                        'tbl_job_card_id'=> $jobcard_id, 
                        'main_job_id '=> $main_job_id, 
                        'sub_job_id '=> $sub_job_category, 
                        'seat_condition '=> $seat_condition_id, 
                        'seat_type '=> $seat_type_id, 
                        'sales_job_details_id '=> $job_name, 
                        'jobprice'=> $jobprice, 
                        'qty'=> $qty, 
        
                        'gross_amount'=> 0,
                        'discount'=> 0,
                        'discount_amount'=> 0,
                        'sub_total'=> 0,
        
                        'status'=> '1', 
                        'insertdatetime'=> $insertdatetime, 
                        'tbl_user_idtbl_user'=> $userID,
                    );
                    $this->db->insert('tbl_job_card_detail', $data);
                }
                $data2 = array(
                    'tbl_job_card_id'=> $jobcard_id, 
                    'main_job_id '=> $main_job_id, 
                    'sub_job_id '=> $sub_job_category, 
                    'seat_condition '=> $seat_condition_id, 
                    'seat_type '=> $seat_type_id, 
                    'sales_job_details_id '=> 0, 
                    'jobprice'=> 0, 
                    'qty'=> 0, 
    
                    'gross_amount'=> $gross_amount,
                    'discount'=> $discount,
                    'discount_amount'=> $discount_amount,
                    'sub_total'=> $sub_total,
    
                    'status'=> '1', 
                    'insertdatetime'=> $insertdatetime, 
                    'tbl_user_idtbl_user'=> $userID,
                );
                $this->db->insert('tbl_job_card_detail', $data2);
                $newAllSubTotal=$allSubTotal+$sub_total;


            } else if ($sub_job_category == '9') {

                foreach($seatRepairTbableData AS $list){
                    $job_name=$list['col_2'];
                    $repair_type=$list['col_4'];
                    $category_type=$list['col_6'];
                    $jobprice=$list['col_7'];
                    $qty=$list['col_8'];

                    $data = array(
                        'tbl_job_card_id'=> $jobcard_id, 
                        'main_job_id '=> $main_job_id, 
                        'sub_job_id '=> $sub_job_category, 
                        'repair_type '=> $repair_type, 
                        'category_type '=> $category_type, 
                        'sales_job_details_id '=> $job_name, 
                        'jobprice'=> $jobprice, 
                        'qty'=> $qty, 
        
                        'gross_amount'=> 0,
                        'discount'=> 0,
                        'discount_amount'=> 0,
                        'sub_total'=> 0,
        
                        'status'=> '1', 
                        'insertdatetime'=> $insertdatetime, 
                        'tbl_user_idtbl_user'=> $userID,
                    );
                    $this->db->insert('tbl_job_card_detail', $data);
                }
                $data2 = array(
                    'tbl_job_card_id'=> $jobcard_id, 
                    'main_job_id '=> $main_job_id, 
                    'sub_job_id '=> $sub_job_category, 
                    'repair_type '=> $repair_type, 
                    'category_type '=> $category_type, 
                    'sales_job_details_id '=> 0, 
                    'jobprice'=> 0, 
                    'qty'=> 0, 
    
                    'gross_amount'=> $gross_amount,
                    'discount'=> $discount,
                    'discount_amount'=> $discount_amount,
                    'sub_total'=> $sub_total,
    
                    'status'=> '1', 
                    'insertdatetime'=> $insertdatetime, 
                    'tbl_user_idtbl_user'=> $userID,
                );
                $this->db->insert('tbl_job_card_detail', $data2);
                $newAllSubTotal=$allSubTotal+$sub_total;



            } else if ($sub_job_category == '8') {
                $data = array(
                    'tbl_job_card_id'=> $jobcard_id, 
                    'main_job_id '=> $main_job_id, 
                    'sub_job_id '=> $sub_job_category, 
                    'sales_job_details_id '=> $job_name, 
                    'jobprice'=> $jobprice, 
                    'qty'=> $qty, 
    
                    'material_id'=> $material_id, 
                    'production_advice'=> $production_advice, 
                    'dot_design'=> $dot_design,
                    'dot_design_charge'=> $dot_design_charge,
                    'stitch_design_id'=> $stitch_design_id,
                    'stitch_design_charge'=> $stitch_design_charge,
                    'stitch_style'=> $stitch_style,
                    'add_cover_design'=> $add_cover_design,
                    'cover_design_charge'=> $cover_design_charge,
                    'cushion_repair'=> $cushion_repair,
                    'cushion_repair_charge'=> $cushion_repair_charge,
    
                    'gross_amount'=> $gross_amount,
                    'discount'=> $discount,
                    'discount_amount'=> $discount_amount,
                    'sub_total'=> $sub_total,
    
                    'status'=> '1', 
                    'insertdatetime'=> $insertdatetime, 
                    'tbl_user_idtbl_user'=> $userID,
                );

                $this->db->insert('tbl_job_card_detail', $data);
                $newAllSubTotal=$allSubTotal+$sub_total;
            
            
            }else{
                $data = array(
                    'tbl_job_card_id'=> $jobcard_id, 
                    'main_job_id '=> $main_job_id, 
                    'sub_job_id '=> $sub_job_category, 
                    'sales_job_details_id '=> $job_name, 
                    'jobprice'=> $jobprice, 
                    'qty'=> $qty, 
    
                    'material_id'=> $material_id, 
                    'production_advice'=> $production_advice, 
                    'logo'=> $logo, 
                    'logo_charge'=> $logo_charge, 
                    'logo_type'=> $logo_type, 
                    'logo_color'=> $logo_color, 
                    'thread_color'=> $thread_color,
                    'dot_design'=> $dot_design,
                    'dot_design_charge'=> $dot_design_charge,
                    'stitch_design_id'=> $stitch_design_id,
                    'stitch_design_charge'=> $stitch_design_charge,
                    'stitch_style'=> $stitch_style,
                    'add_material_design'=> $add_cushion_replacement,
                    'material_design_charge'=> $cushion_replacement_charge,
                    'add_cover_design'=> $add_cover_design,
                    'cover_design_charge'=> $cover_design_charge,
                    'cushion_repair'=> $cushion_repair,
                    'cushion_repair_charge'=> $cushion_repair_charge,

                    'hybrid_comfort_layer'=> $hybrid_comfort_layer,
                    'hybrid_comfort_price'=> $hybrid_comfort_price,
                    'hybrid_comfort_qty'=> $hybrid_comfort_qty,

                    'logo_qty'=> $logo_qty,
                    'dot_design_qty'=> $dot_design_qty,
                    'stitch_design_qty'=> $stitch_design_qty,
                    'cushion_replacement_qty'=> $cushion_replacement_qty,
                    'cover_design_qty'=> $cover_design_qty,
                    'cushion_repair_qty'=> $cushion_repair_qty,
    
                    'gross_amount'=> $gross_amount,
                    'discount'=> $discount,
                    'discount_amount'=> $discount_amount,
                    'sub_total'=> $sub_total,
    
                    'status'=> '1', 
                    'insertdatetime'=> $insertdatetime, 
                    'tbl_user_idtbl_user'=> $userID,
                );

                $this->db->insert('tbl_job_card_detail', $data);
                $newAllSubTotal=$allSubTotal+$sub_total;
            }

            $mainTblSubTotal = array(
                'sub_total'=> $newAllSubTotal,
                'net_total'=> $newAllSubTotal,
            );

            $this->db->where('idtbl_jobcard ', $jobcard_id);
            $this->db->update('tbl_jobcard', $mainTblSubTotal);

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
                
                $obj=new stdClass();
				$obj->status=1;          
				$obj->action=$actionJSON;  
				
				echo json_encode($obj);             
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
                
                $obj=new stdClass();
				$obj->status=0;          
				$obj->action=$actionJSON;  
				
				echo json_encode($obj);
            }
        }
        else{
            $data = array(
                'vehicle_reg_no'=> $vehicleregno, 
                'tbl_vehicle_type_idtbl_vehicle_type '=> $vehicletype, 
                'tbl_vehicle_brand_idtbl_vehicle_brand '=> $vehiclebrand, 
                'tbl_vehicle_model_idtbl_vehicle_model '=> $vehiclemodel, 
                'engine_no'=> $engineno, 
                'chassis_no'=> $chassisno, 
                'mileage'=> $mileage, 
                'updateuser'=> $userID, 
                'updatedatetime' => $insertdatetime,
               
            );

            $this->db->where('idtbl_vehicle ', $recordID);
            $this->db->update('tbl_vehicle', $data);

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
                redirect('Vehicle');                
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
                redirect('Vehicle');
            }
        }
    }

    public function Vehiclestatus($x, $y){
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

            $this->db->where('idtbl_vehicle ', $recordID);
            $this->db->update('tbl_vehicle', $data);

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
                redirect('Vehicle');                
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
                redirect('Vehicle');
            }
        }
        else if($type==2){
            $data = array(
                'status' => '2',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_vehicle', $recordID);
            $this->db->update('tbl_vehicle', $data);

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
                redirect('Vehicle');                
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
                redirect('Vehicle');
            }
        }
        else if($type==3){
            $data = array(
                'status' => '3',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_vehicle', $recordID);
            $this->db->update('tbl_vehicle', $data);

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
                redirect('Vehicle');                
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
                redirect('Vehicle');
            }
        }
    }


    public function Extra_charges_status($x,$y) {
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

            $this->db->where('idtbl_accessory_detail', $recordID);
            $this->db->update('tbl_accessory_detail', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                $response = array('status' => 'success', 'message' => 'Extra Charge Delete Successfully');
                echo json_encode($response);              
            } else {
                $this->db->trans_rollback();
                $response = array('status' => 'error', 'message' => 'Failed to Delete Extra Charge');
                echo json_encode($response);
            }
    }


    public function Extra_charges_edit(){
        $recordID=$this->input->post('recordID');

        $this->db->select('*');
        $this->db->from('tbl_accessory_detail');
        $this->db->where('idtbl_accessory_detail', $recordID);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        $obj=new stdClass();
        $obj->id=$respond->row(0)->idtbl_accessory_detail;
        $obj->accessory_id=$respond->row(0)->accessory_id;
        $obj->accessory_amount=$respond->row(0)->accessory_amount;
        $obj->fixing_amount=$respond->row(0)->fixing_charge_amount;
        

        echo json_encode($obj);
    }

    
    public function getJobprice(){
        $material_id=$this->input->post('material_id');
        $vehicle_model_id=$this->input->post('vehicle_model_id');
        $main_job_category=$this->input->post('main_job_category');
        $sub_job_category=$this->input->post('sub_job_category');
        $job_name=$this->input->post('job_name');
        $seat_type_id=$this->input->post('seat_type_id');
        $seat_condition_id=$this->input->post('seat_condition_id');
        $repair_type_id=$this->input->post('repair_type_id');
        $category_type_id=$this->input->post('category_type_id');

        $this->db->select('*');
        $this->db->from('tbl_vehicle_model');
        $this->db->where('idtbl_vehicle_model', $vehicle_model_id);
        $this->db->where('status', 1);

        $respond=$this->db->get();
        $price_category_id=$respond->row(0)->price_category_id ;

        $this->db->select('tbl_job_price_detail.job_price,tbl_job_price_detail.material_id');
        $this->db->from('tbl_job_price');
        $this->db->join('tbl_job_price_detail','tbl_job_price_detail.job_price_id = tbl_job_price.idtbl_job_price','left');
        $this->db->where('tbl_job_price.main_job_category_id', $main_job_category);
        $this->db->where('tbl_job_price.sub_job_category_id', $sub_job_category);
        $this->db->where('tbl_job_price.sales_job_details_id', $job_name);
        $this->db->where('tbl_job_price.status', 1);

        if($sub_job_category == 1 || $sub_job_category == 8){
            $this->db->where('tbl_job_price_detail.Cate_type', $price_category_id);
            $this->db->where('tbl_job_price_detail.material_id', $material_id);

       
        } elseif ($sub_job_category == 9) {
            // Use GROUPED OR conditions
            $this->db->group_start(); 
            $this->db->where('tbl_job_price_detail.repair_type', $repair_type_id);
            $this->db->or_where('tbl_job_price_detail.Cate_type', $category_type_id);
            $this->db->group_end();
        } else {
            $this->db->where('tbl_job_price_detail.seat_type', $seat_type_id);
            $this->db->where('tbl_job_price_detail.seat_condition', $seat_condition_id);
        }

        $respond2=$this->db->get();

        $obj=new stdClass();
        if ($respond2->num_rows() > 0) {
            $obj->price=$respond2->row(0)->job_price;
            $obj->material_id=$respond2->row(0)->material_id;
        }
        echo json_encode($obj);

    }


    public function Get_repair_typedetails() {
		$main_job_category_id = $this->input->post('main_job_category_id');
        $sub_job_category_id = $this->input->post('sub_job_category_id');
        $job_id = $this->input->post('job_id');

        $this->db->select('idtbl_seat_repair_category, sub_Repair_job_name');
        $this->db->from('tbl_seat_repair_category');
        $this->db->where('tbl_seat_repair_category.status', 1);
        $this->db->where('tbl_seat_repair_category.sub_job_id', $sub_job_category_id); 
        $this->db->where('tbl_seat_repair_category.repair_job_id', $job_id); 
        $query = $this->db->get();
        $result = $query->result_array();
        echo json_encode($result);
        
	}



    public function Getsalesjobdetails() {
		$main_job_category_id = $this->input->post('main_job_category_id');
        $sub_job_category_id = $this->input->post('sub_job_category_id');

        $this->db->select('idtbl_sales_jobs_details, sales_job_name');
        $this->db->from('tbl_sales_jobs_details');
        $this->db->where('status', 1);
        $this->db->where('main_job_category_id', $main_job_category_id); 
        $this->db->where('sub_job_category_id', $sub_job_category_id); 
        $query = $this->db->get();
        $result = $query->result_array();
        echo json_encode($result);
        
	}

    public function Get_japanseat_jobdetails() {
		$main_job_category_id = $this->input->post('main_job_category_id');
        $sub_job_category_id = $this->input->post('sub_job_category_id');
        $seat_type_id = $this->input->post('seat_type_id');
        $seat_condition_id = $this->input->post('seat_condition_id');

        $this->db->select('idtbl_sales_jobs_details, sales_job_name');
        $this->db->from('tbl_sales_jobs_details');
        $this->db->join('tbl_job_price','tbl_job_price.sales_job_details_id = tbl_sales_jobs_details.idtbl_sales_jobs_details','left');
        $this->db->join('tbl_job_price_detail','tbl_job_price_detail.job_price_id = tbl_job_price.idtbl_job_price','left');
        $this->db->where('tbl_sales_jobs_details.status', 1);
        $this->db->where('tbl_sales_jobs_details.main_job_category_id', $main_job_category_id); 
        $this->db->where('tbl_sales_jobs_details.sub_job_category_id', $sub_job_category_id); 
        $this->db->where('tbl_job_price_detail.seat_type', $seat_type_id); 
        $this->db->where('tbl_job_price_detail.seat_condition', $seat_condition_id); 
        $query = $this->db->get();
        $result = $query->result_array();
        echo json_encode($result);
        
	}

    public function showDataTable(){
        $jobcard_id=$this->input->post('jobcard_id');

        $this->db->select('tbl_main_job_category.idtbl_main_job_category,tbl_main_job_category.main_job_category,tbl_sub_job_category.idtbl_sub_job_category,tbl_sub_job_category.sub_job_category,tbl_seat_condition.condition_type,tbl_seat_type.idtbl_seat_type,tbl_seat_type.seat_type,tbl_sales_jobs_details.sales_job_name,
                            tbl_material.material_code,tbl_material.material_type,tbl_job_card_detail.idtbl_job_card_detail,tbl_job_card_detail.sales_job_details_id,tbl_job_card_detail.jobprice,tbl_job_card_detail.qty,tbl_job_card_detail.gross_amount,tbl_job_card_detail.discount_amount,tbl_job_card_detail.sub_total,
                            tbl_job_card_detail.logo_charge,tbl_job_card_detail.dot_design_charge,tbl_job_card_detail.stitch_design_charge,tbl_job_card_detail.material_design_charge,tbl_job_card_detail.cover_design_charge,tbl_job_card_detail.hybrid_comfort_price,tbl_job_card_detail.cushion_repair_charge,
                            tbl_logo.logo_type,tbl_job_card_detail.dot_design,tbl_stitching_design.stitching_code,tbl_job_card_detail.add_material_design,tbl_job_card_detail.cushion_repair,tbl_job_card_detail.add_cover_design,tbl_job_card_detail.hybrid_comfort_layer');
        $this->db->from('tbl_job_card_detail');
        $this->db->join('tbl_main_job_category','tbl_main_job_category.idtbl_main_job_category = tbl_job_card_detail.main_job_id','left');
        $this->db->join('tbl_sub_job_category','tbl_sub_job_category.idtbl_sub_job_category = tbl_job_card_detail.sub_job_id','left');
        $this->db->join('tbl_seat_condition','tbl_seat_condition.idtbl_seat_condition = tbl_job_card_detail.seat_condition','left');
        $this->db->join('tbl_seat_type','tbl_seat_type.idtbl_seat_type = tbl_job_card_detail.seat_type','left');
        $this->db->join('tbl_sales_jobs_details','tbl_sales_jobs_details.idtbl_sales_jobs_details = tbl_job_card_detail.sales_job_details_id','left');
        $this->db->join('tbl_material','tbl_material.idtbl_material = tbl_job_card_detail.material_id','left');
        $this->db->join('tbl_logo','tbl_logo.idtbl_logo = tbl_job_card_detail.logo_type','left');
        $this->db->join('tbl_stitching_design','tbl_stitching_design.idtbl_stitching_design = tbl_job_card_detail.stitch_design_id','left');
        $this->db->where('tbl_job_card_detail.tbl_job_card_id', $jobcard_id);
        $this->db->where('tbl_job_card_detail.status', 1);

        $query = $this->db->get();

        $html = '';
        $filter_array = array();
        foreach($query->result() as $row){
            if (!isset($filter_array[$row->main_job_category])) {
                $filter_array[$row->main_job_category] = array();
            }

            if (!isset($filter_array[$row->main_job_category][$row->sub_job_category])) {
                $filter_array[$row->main_job_category][$row->sub_job_category] = array();
            }
        
            $filter_array[$row->main_job_category][$row->sub_job_category][] = $row;


            $html = '<table class="table table-bordered table-striped table-sm nowrap w-100" id="dataTable">';
            $html .= '<thead><tr><th>#</th><th>Sub Job Category</th><th>Job Name</th><th>Material Type</th><th class="text-right">Job Price</th><th class="text-center">Qty</th><th class="text-right">Total</th><th class="text-right">Other Charges</th><th class="text-right">Gross Amount</th><th class="text-right">Discount Amount</th><th class="text-right">Sub Total</th><th class="text-right">Action</th></tr></thead>';
            $html .= '<tbody>';
            $sub_cnt = 1;
            foreach ($filter_array as $main_job_category => $sub_categories) {
                $html .= '<tr><td style="background-color:rgb(214, 230, 252);"><strong>' . $main_job_category . '</strong></td><td colspan="12" style="background-color:rgb(214, 230, 252);"></td></tr>';
                foreach ($sub_categories as $sub_job_category => $rows) {   

                    $cnt = count($rows);
                    $last_row = end($rows);
                    // that values use for japan seat sub category only
                    $last_gross_amount = $last_row->gross_amount;
                    $last_discount_amount = $last_row->discount_amount;
                    $last_sub_total = $last_row->sub_total;
                    $last_row_id = $last_row->idtbl_job_card_detail;
                  
                    foreach ($rows as $index => $row) {
                        $other_charges = $row->logo_charge+$row->dot_design_charge+$row->stitch_design_charge+$row->material_design_charge+$row->cushion_repair_charge+$row->cover_design_charge+$row->hybrid_comfort_price;

                        $dotdesign_type = '';
                        if($row->dot_design == 1){
                            $dotdesign_type = 'None';
                        }else if($row->dot_design == 2){
                            $dotdesign_type = 'OEM Dot Design';
                        }else if($row->dot_design == 3){
                            $dotdesign_type = 'Custom Dot Design';
                        }

                        $addmaterial_design = '';
                        if($row->add_material_design == 1){
                            $addmaterial_design = 'Yes';
                        }

                        $cover_design = '';
                        if($row->add_cover_design == 1){
                            $cover_design = 'Yes';
                        }

                        $cushion_repair_type = '';
                        if($row->cushion_repair == 1){
                            $cushion_repair_type = 'None';
                        }else if($row->cushion_repair == 2){
                            $cushion_repair_type = 'Cushion Repair';
                        }else if($row->cushion_repair == 3){
                            $cushion_repair_type = 'Custom Cushion Repair';
                        }

                        $comfort_layer = '';
                        if($row->hybrid_comfort_layer == 1){
                            $comfort_layer = 'None';
                        }else if($row->hybrid_comfort_layer == 2){
                            $comfort_layer = 'HCL Layer';
                        }

                        
                        $otherChargeList = '';
                        
                        $otherChargeList .= '<ul>';
                        $otherChargeList .= '<li class="' . ($row->logo_charge == 0 ? 'd-none' : '') . '"><b>Logo Design</b> (' . $row->logo_type . ' :- ' . number_format($row->logo_charge, 2, '.', ',') . ')</li>';
                        $otherChargeList .= '<li class="' . ($row->dot_design_charge == 0 ? 'd-none' : '') . '"><b>Dot Design</b> (' . $dotdesign_type . ' :- ' . number_format($row->dot_design_charge, 2, '.', ',') . ')</li>';
                        $otherChargeList .= '<li class="' . ($row->stitch_design_charge == 0 ? 'd-none' : '') . '"><b>Stitching Design</b> (' . $row->stitching_code . ' :- ' . number_format($row->stitch_design_charge, 2, '.', ',') . ')</li>';
                        $otherChargeList .= '<li class="' . ($row->material_design_charge == 0 ? 'd-none' : '') . '"><b>Cushion Replacement</b> (' . $addmaterial_design . ' :- ' . number_format($row->material_design_charge, 2, '.', ',') . ')</li>';
                        $otherChargeList .= '<li class="' . ($row->cushion_repair_charge == 0 ? 'd-none' : '') . '"><b>Cushion Repair</b> (' . $cushion_repair_type . ' :- ' . number_format($row->cushion_repair_charge, 2, '.', ',') . ')</li>';
                        $otherChargeList .= '<li class="' . ($row->cover_design_charge == 0 ? 'd-none' : '') . '"><b>Cover Design</b> (' . $cover_design . ' :- ' . number_format($row->cover_design_charge, 2, '.', ',') . ')</li>';
                        $otherChargeList .= '<li class="' . ($row->hybrid_comfort_price == 0 ? 'd-none' : '') . '"><b>Hybrid Comfort Layer</b> (' . $comfort_layer . ' :- ' . number_format($row->hybrid_comfort_price, 2, '.', ',') . ')</li>';
                        $otherChargeList .= '</ul>';

                        $escapedOtherChargeList = htmlspecialchars($otherChargeList, ENT_QUOTES, 'UTF-8');

                        $html .= '<tr>';
                        if($row->idtbl_sub_job_category != 1){
                                if($row->sales_job_details_id !=0){
                                    if ($index == 0) {
                                        $html .= '<td rowspan="' . ($cnt - 1) . '" style="vertical-align: middle;">'.$sub_cnt.'</td>';
                                        $html .= '<td rowspan="' . ($cnt - 1) . '" style="vertical-align: middle;">' . $row->sub_job_category . '</td>';
                                    }
                                        $html .= '<td style="vertical-align: middle;">'.$row->condition_type.' '.$row->seat_type.' ' . $row->sales_job_name . '</td>';
                                        $html .= '<td style="vertical-align: middle;">' . $row->material_type . '</td>';
                                        $html .= '<td class="text-right" style="vertical-align: middle;">' . number_format($row->jobprice, 2, '.', ',') . '</td>';
                                        $html .= '<td class="text-center" style="vertical-align: middle;">' . $row->qty . '</td>';
                                        $html .= '<td class="text-right" style="vertical-align: middle;">' . number_format(($row->qty * $row->jobprice), 2, '.', ',') . '</td>';
                                        $html .= '<td class="text-right" style="vertical-align: middle;">' . number_format(($other_charges), 2, '.', ',') . '</td>';
                                }
                        }else{
                            if ($index == 0) {
                                $html .= '<td rowspan="' . ($cnt) . '" style="vertical-align: middle;">'.$sub_cnt.'</td>';
                                $html .= '<td rowspan="' . ($cnt) . '" style="vertical-align: middle;">' . $row->sub_job_category . '</td>';
                            }
                                $html .= '<td style="vertical-align: middle;">'.$row->condition_type.' '.$row->seat_type.' ' . $row->sales_job_name . '</td>';
                                $html .= '<td style="vertical-align: middle;">' . $row->material_type . '</td>';
                                $html .= '<td class="text-right" style="vertical-align: middle;">' . number_format($row->jobprice, 2, '.', ',') . '</td>';
                                $html .= '<td class="text-center" style="vertical-align: middle;">' . $row->qty . '</td>';
                                $html .= '<td class="text-right" style="vertical-align: middle;">' . number_format(($row->qty * $row->jobprice), 2, '.', ',') . '</td>';
                                $html .= '<td class="text-right" style="vertical-align: middle;" data-container="body" data-toggle="popover" data-placement="bottom" onclick="showPropOver();" data-content="'.$escapedOtherChargeList .'">' . number_format(($other_charges), 2, '.', ',') . '</td>';
                        }

                        if($row->idtbl_sub_job_category != 1 ){
                            if ($index == 0) {
                                $html .= '<td rowspan="' . $cnt . '" class="text-right" style="vertical-align: middle;">' . number_format($last_gross_amount, 2, '.', ',') . '</td>';
                                $html .= '<td rowspan="' . $cnt . '" class="text-right" style="vertical-align: middle;">' . number_format($last_discount_amount, 2, '.', ',') . '</td>';
                                $html .= '<td rowspan="' . $cnt . '" class="text-right" style="vertical-align: middle;">' . number_format($last_sub_total, 2, '.', ',') . '</td>';
                                $html .= '<td rowspan="' . $cnt . '" class="text-right" style="vertical-align: middle;"><a title="Add Extra Charges" href="javascript:void(0);" class="btn btn-secondary btn-sm mr-2" onclick="addextrachargeJobCard(' . $row->idtbl_main_job_category . ',' . $row->idtbl_sub_job_category . ',' .$row->idtbl_seat_type. ',0,' .$jobcard_id.','.$last_row_id.')"><i class="fas fa-search-dollar"></i></a><a title="Edit" href="javascript:void(0);" class="btn btn-primary btn-sm mr-2" onclick="editJobCard('.$row->idtbl_job_card_detail.')"><i class="fas fa-pen-alt"></i></a><a title="Delete" href="javascript:void(0);" class="btn btn-danger btn-sm mr-2" onclick="deleteJobCard('.$row->idtbl_job_card_detail.')"><i class="fas fa-trash-alt"></i></a></td>';
                            }
                        }else{
                                $html .= '<td class="text-right" style="vertical-align: middle;">' . number_format($row->gross_amount, 2, '.', ',') . '</td>';
                                $html .= '<td class="text-right" style="vertical-align: middle;">' . number_format($row->discount_amount, 2, '.', ',') . '</td>';
                                $html .= '<td class="text-right" style="vertical-align: middle;">' . number_format($row->sub_total, 2, '.', ',') . '</td>';
                                $html .= '<td class="text-right" style="vertical-align: middle;"><a title="Edit" href="javascript:void(0);" class="btn btn-primary btn-sm mr-2" onclick="editJobCard('.$row->idtbl_job_card_detail.')"><i class="fas fa-pen-alt"></i></a><a title="Delete" href="javascript:void(0);" class="btn btn-danger btn-sm" onclick="deleteJobCard('.$row->idtbl_job_card_detail.')"><i class="fas fa-trash-alt"></i></a></td>';
                        }
                       
                        $html .= '</tr>';
                    }
                    $sub_cnt++; 
                }
         
            }
            
            $html .= '</tbody></table>';

        }

        echo $html;

    }

    private function getAllSubTotal($jobcard_id){

        $this->db->select('SUM(sub_total) as total');
        $this->db->from('tbl_job_card_detail');
        $this->db->where('tbl_job_card_id', $jobcard_id);
        $this->db->where('status', 1);

        $query = $this->db->get();
        $result = $query->row();
        return isset($result->total) ? (float) $result->total : 0;
    }





    public function Inquiryviewheader_2() {
        $recordID2 = $this->input->post('recordID2');
    
        $this->db->select('tbl_customer_inquiry.*');
        $this->db->from('tbl_customer_inquiry');
        $this->db->join('tbl_sales_person', 'tbl_sales_person.idtbl_sales_person = tbl_customer_inquiry.salesperson_id', 'left');
        $this->db->where('idtbl_customer_inquiry', $recordID2);
        $this->db->where('tbl_customer_inquiry.status', 1);
    
        $respond = $this->db->get();
    
        $obj = new stdClass();
        $obj->customername = $respond->row(0)->customer_name;
        $obj->brandname = $respond->row(0)->brandname;
        $obj->s_personname = $respond->row(0)->s_personname;
        $obj->customer_reply_id_3 = $respond->row(0)->customer_reply_id_3;
        $obj->remark_3 = $respond->row(0)->remark_3;

        $obj->s_personname = $respond->row(0)->s_personname;
        
        if ($respond->row(0)->first_follow_up == 1) {
            $obj->followup_1 = "Done!";
        } else {
            $obj->followup_1 = "Pending!";
        }
        
        $obj->companyname = $respond->row(0)->companyname;
        $obj->companyaddress = $respond->row(0)->companyaddress;
        $obj->companymobile = $respond->row(0)->companymobile;
        $obj->companyphone = $respond->row(0)->companyphone;
        $obj->companyemail = $respond->row(0)->companyemail;
        $obj->branchname = $respond->row(0)->branchname;
    
        echo json_encode($obj);
    }



    public function AddextraCharge(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $model_main_id=$this->input->post('model_main_id');
        $model_sub_id=$this->input->post('model_sub_id');
        $model_seattype_id=$this->input->post('model_seattype_id');
        $extra_jobcard_details_id=$this->input->post('extra_jobcard_details_id');
        $model_accessory_id=$this->input->post('model_accessory_id');
        $model_charge_amount=$this->input->post('model_charge_amount');
        $model_fixing_amount=$this->input->post('model_fixing_amount');
        $tot_extra_charge_amount=$this->input->post('tot_extra_charge_amount');

        $recordID=$this->input->post('recordIDTomodel');
        $recordOptionModel=$this->input->post('recordOptionModel');

        $insertdatetime=date('Y-m-d H:i:s');

        if($recordOptionModel==1){
        $data3 = array(
                'accessory_id'=> $model_accessory_id, 
                'accessory_amount'=> $model_charge_amount, 
                'fixing_charge_amount'=> $model_fixing_amount, 
                'tot_extra_charge_amount'=> $tot_extra_charge_amount, 

                'main_job_id'=> $model_main_id, 
                'sub_job_id'=> $model_sub_id, 
                'seat_type'=> $model_seattype_id, 
                'job_details_id'=> $extra_jobcard_details_id,

                // 'tbl_customer_idtbl_customer'=> $recordID, 
                'status'=> '1',
                'insertdatetime'=> $insertdatetime, 
            );

            $this->db->insert('tbl_accessory_detail ', $data3);
            // $this->db->update('tbl_customer_vehicle_detail', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                $response = array('status' => 'success', 'message' => 'Accessories and Other Charges Added Successfully');
                echo json_encode($response);              
            } else {
                $this->db->trans_rollback();
                $response = array('status' => 'error', 'message' => 'Failed to Added Accessories and Charges');
                echo json_encode($response);
            }
        }
        else{
            $data3 = array(
                'accessory_id'=> $model_accessory_id, 
                'accessory_amount'=> $model_charge_amount, 
                'fixing_charge_amount'=> $model_fixing_amount, 
                'tot_extra_charge_amount'=> $tot_extra_charge_amount,
                'status'=> '1',
                'updatedatetime'=> $insertdatetime, 
            );

            $this->db->where('idtbl_accessory_detail', $recordID); 
            $this->db->update('tbl_accessory_detail', $data3);
            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                $response = array('status' => 'success', 'message' => 'Accessories and Other Charges Updated Successfully');
                echo json_encode($response);              
            } else {
                $this->db->trans_rollback();
                $response = array('status' => 'error', 'message' => 'Failed to Update Accessories and Other Charges');
                echo json_encode($response);
            }
        }
    }


    public function DeleteJobCard() {
        $this->db->trans_begin();
    
        $userID = $_SESSION['userid'];
        $recordID = $this->input->post('recordID');
        $updatedatetime = date('Y-m-d H:i:s');
    
        $data = array(
            'status' => '3',
            'updateuser' => $userID,
            'updatedatetime' => $updatedatetime
        );
    
        $this->db->where('idtbl_job_card_detail', $recordID);
        $this->db->update('tbl_job_card_detail', $data);
    
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
            
            $obj = new stdClass();
            $obj->status = 1;
            $obj->action = $actionJSON;

            echo json_encode($obj);              
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
            
            $obj = new stdClass();
            $obj->status = 0;
            $obj->action = $actionJSON;

            echo json_encode($obj);
        }
    }

}