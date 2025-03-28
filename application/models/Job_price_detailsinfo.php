<?php
class Job_price_detailsinfo extends CI_Model{


    public function Getvehiclebrand() {
        $this->db->select('idtbl_vehicle_brand , brand_name');
        $this->db->from('tbl_vehicle_brand');
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

    public function Getseat_condition() {
        $this->db->select('idtbl_seat_condition , condition_type');
        $this->db->from('tbl_seat_condition');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function Getmainjob() {
        $this->db->select('idtbl_main_job_category , main_job_category');
        $this->db->from('tbl_main_job_category');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function Getjobs() {
        $this->db->select('idtbl_jobs , job_name');
        $this->db->from('tbl_jobs');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function Getmaterial() {
        $this->db->select('idtbl_material , material_type');
        $this->db->from('tbl_material');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function Job_price_details_insertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $tableData=$this->input->post('tableData');
        $tableData1=$this->input->post('tableData1');
        $tableData2 = $this->input->post('tableData2');
        $main_job_category=$this->input->post('main_job_category');
        $sub_job_category=$this->input->post('sub_job_category');
        $job_name=$this->input->post('job_name');
        $recordOption=$this->input->post('recordOption');
        if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}

        $updatedatetime=date('Y-m-d H:i:s');

        if($recordOption==1){
            $data = array(
                'main_job_category_id'=> $main_job_category, 
                'sub_job_category_id'=> $sub_job_category, 
                'sales_job_details_id'=> $job_name, 
                'status'=> '1', 
                'insertdatetime'=> $updatedatetime, 
                'tbl_user_idtbl_user'=> $userID,
            );

            $this->db->insert('tbl_job_price', $data);
            $porderID=$this->db->insert_id();

                    // Insert tableData
        if (!empty($tableData)) {
            foreach ($tableData as $key => $rowtabledata) {
                $category_type = $rowtabledata['col_2'];
                $material = $rowtabledata['col_4'];
                $price = $rowtabledata['col_5'];

                $dataone = array(
                    'status' => '1',
                    'insertdatetime' => $updatedatetime,
                    'job_price_id' => $porderID,
                    'Cate_type' => $category_type,
                    'seat_type' => '0',
                    'seat_condition' => '0',
                    'material_id' => $material,
                    'repair_type' => '0',
                    'job_price' => $price,
                );

                $this->db->insert('tbl_job_price_detail', $dataone);
            }
        }


        if (!empty($tableData1)) {
            foreach ($tableData1 as $key => $rowtableData1) {
                $category_type = $rowtableData1['col_2'];
                $repair_type = $rowtableData1['col_4'];
                $price = $rowtableData1['col_5'];

                $dataTwo = array(
                    'status' => '1',
                    'insertdatetime' => $updatedatetime,
                    'job_price_id' => $porderID,
                    'Cate_type' => $category_type,
                    'material_id' => '0',
                    'repair_type' => $repair_type,
                    'seat_type' => '0',
                    'seat_condition' =>'0',
                    'job_price' => $price,
                );

                $this->db->insert('tbl_job_price_detail', $dataTwo);
            }
        }

        // Insert tableData2
        if (!empty($tableData2)) {
            foreach ($tableData2 as $key => $rowtabledata2) {
                $seat_type = $rowtabledata2['col_2'];
                $seat_condition = $rowtabledata2['col_4'];
                $price = $rowtabledata2['col_5'];

                $dataTwo = array(
                    'status' => '1',
                    'insertdatetime' => $updatedatetime,
                    'job_price_id' => $porderID,
                    'Cate_type' => '0',
                    'material_id' => '0',
                    'repair_type' => '0',
                    'seat_type' => $seat_type,
                    'seat_condition' => $seat_condition,
                    'job_price' => $price,
                );

                $this->db->insert('tbl_job_price_detail', $dataTwo);
            }
        }



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
                
                $obj = new stdClass();
                $obj->status = 1;
                $obj->action = $actionJSON;

                echo json_encode($obj);
            }  else {
                $this->db->trans_rollback();

                $actionObj = new stdClass();
                $actionObj->icon = 'fas fa-exclamation-triangle';
                $actionObj->title = '';
                $actionObj->message = 'Record Error';
                $actionObj->url = '';
                $actionObj->target = '_blank';
                $actionObj->type = 'danger';

                $actionJSON = json_encode($actionObj);

                $obj = new stdClass();
                $obj->status = 0;
                $obj->action = $actionJSON;

                echo json_encode($obj);
            }
        }
        else{
            $data = array(
                'main_job_category_id'=> $main_job_category, 
                'sub_job_category_id'=> $sub_job_category, 
                'sales_job_details_id'=> $job_name, 
                'updateuser'=> $userID, 
                'updatedatetime' => $updatedatetime,
            );

            $this->db->where('idtbl_job_price', $recordID);
            $this->db->update('tbl_job_price', $data);

            if (!empty($tableData)) {
                foreach($tableData as $rowtabledata){
                    $category_type = $rowtabledata['col_2'];
                    $material=$rowtabledata['col_4'];
                    $price=$rowtabledata['col_5'];
                    $insertMethod = $rowtabledata['col_6'];

                    if($insertMethod=="NewRow"){
                        $data = array(
                            'job_price'=> $price, 
                            'Cate_type'=> $category_type, 
                            'material_id'=> $material,
                            'status'=> '1', 
                            'insertdatetime'=> $updatedatetime, 
                            'job_price_id'=> $recordID,
                        );
                        $this->db->insert('tbl_job_price_detail', $data);
                    }else if($insertMethod=="Updated"){
                        $detailsID = $rowtabledata['col_8'];
                        $data = array(
                            'job_price'=> $price, 
                            'Cate_type'=> $category_type, 
                            'material_id'=> $material,
                            'updateuser'=> $userID, 
                            'updatedatetime'=> $updatedatetime, 
                        );

                        $this->db->where('idtbl_job_price_detail', $detailsID);
                        $this->db->update('tbl_job_price_detail', $data);
                    }
                    
                }
            }


                // Update tableData2
            if (!empty($tableData2)) {
                foreach ($tableData2 as $rowtabledata2) {
                    $seat_type = $rowtabledata2['col_2'];
                    $seat_condition = $rowtabledata2['col_4'];
                    $price = $rowtabledata2['col_5'];
                    $insertMethod = $rowtabledata2['col_6'];

                    if ($insertMethod == "NewRow") {
                        $dataTwo = array(
                            'job_price' => $price,
                            'seat_type' => $seat_type,
                            'seat_condition' => $seat_condition,
                            'status' => '1',
                            'insertdatetime' => $updatedatetime,
                            'job_price_id' => $recordID,
                        );
                        $this->db->insert('tbl_job_price_seat_detail', $dataTwo);
                    } else if ($insertMethod == "Updated") {
                        $detailsID = $rowtabledata2['col_8'];
                        $dataTwo = array(
                            'job_price' => $price,
                            'seat_type' => $seat_type,
                            'seat_condition' => $seat_condition,
                            'updateuser' => $userID,
                            'updatedatetime' => $updatedatetime,
                        );

                        $this->db->where('idtbl_job_price_detail', $detailsID);
                        $this->db->update('tbl_job_price_detail', $dataTwo);
                    }
                }
            }

                

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
				$this->db->trans_commit();
				
				$actionObj=new stdClass();
				$actionObj->icon='fas fa-save';
				$actionObj->title='';
				$actionObj->message='Inquiry Updated Successfully';
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
				$actionObj->icon='fas fa-exclamation-triangle';
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
    }



    public function Job_price_details_status($x, $y){
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

            $this->db->where('idtbl_job_price', $recordID);
            $this->db->update('tbl_job_price', $data);

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
                redirect('Job_price_details');                
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
                redirect('Job_price_details');
            }
        }
        else if($type==2){
            $data = array(
                'status' => '2',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_job_price', $recordID);
            $this->db->update('tbl_job_price', $data);

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
                redirect('Job_price_details');                
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
                redirect('Job_price_details');
            }
        }
        else if($type==3){
            $data = array(
                'status' => '3',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_job_price', $recordID);
            $this->db->update('tbl_job_price', $data);

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
                redirect('Job_price_details');                
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
                redirect('Job_price_details');
            }
        }
    }

    public function Job_detailsview () {
        $recordID = $this->input->post('recordID');
        $sub_job_category_id=$this->input->post('sub_job_category_id');


        // echo $sub_job_category_id;
    
        // Corrected SQL query
        $sql="SELECT `u`.* FROM `tbl_job_price` AS `u` WHERE `u`.`status`=? AND `u`.`idtbl_job_price`=?";
        $respond = $this->db->query($sql, array(1, $recordID));
    
        $this->db->select('tbl_job_price_detail.*,tbl_price_category_type.price_category_type,tbl_material.material_type,tbl_seat_type.seat_type,tbl_seat_condition.condition_type,tbl_seat_repair_category.sub_Repair_job_name');
        $this->db->from('tbl_job_price_detail');
        $this->db->join('tbl_price_category_type', 'tbl_price_category_type.idtbl_price_category_type = tbl_job_price_detail.Cate_type', 'left');

        $this->db->join('tbl_seat_repair_category', 'tbl_seat_repair_category.idtbl_seat_repair_category = tbl_job_price_detail.repair_type', 'left');


        $this->db->join('tbl_material', 'tbl_material.idtbl_material = tbl_job_price_detail.material_id', 'left');
        $this->db->join('tbl_seat_type', 'tbl_seat_type.idtbl_seat_type = tbl_job_price_detail.seat_type', 'left');
        $this->db->join('tbl_seat_condition', 'tbl_seat_condition.idtbl_seat_condition = tbl_job_price_detail.seat_condition', 'left');
        $this->db->join('tbl_job_price', 'tbl_job_price.idtbl_job_price = tbl_job_price_detail.job_price_id', 'left');
        $this->db->where('tbl_job_price_detail.job_price_id', $recordID);
        $this->db->where('tbl_job_price_detail.status', 1);
    
        $responddetail = $this->db->get();
    
        $html = '';

        if ($sub_job_category_id == 1 || $sub_job_category_id == 8) {
            $html .= '
            <div class="row">
            </div>
            <div class="row">
            <div class="col-12">
            <hr>
            <table class="table table-striped table-bordered table-sm">
            <thead>
            <th style="background-color: #c3faf6">Price Category Type</th>
            <th style="background-color: #c3faf6">Material</th>
            <th style="background-color: #c3faf6;text-align: right">Price</th>
            </thead>
            <tbody>';
            foreach ($responddetail->result() as $roworderinfo) {
                $html .= '<tr>
                    <td>' . $roworderinfo->price_category_type . '</td>
                    <td>' . $roworderinfo->material_type . '</td>
                    <td style="text-align: right;">' . number_format((float)$roworderinfo->job_price, 2, '.', '') . '</td>
                </tr>';
            }
            $html .= '</tbody>
            </table></div></div>';


        } elseif ($sub_job_category_id == 9) {
            $html .= '
            <div class="row"></div>
            <div class="row">
                <div class="col-12">
                    <hr>
                    <table class="table table-striped table-bordered table-sm">
                        <thead>
                            <th style="background-color: #c3faf6">Category Type</th>
                            <th style="background-color: #c3faf6">Repair Type</th>
                            <th style="background-color: #c3faf6;text-align: right">Price</th>
                        </thead>
                        <tbody>';
            foreach ($responddetail->result() as $roworderinfo) {
                $html .= '<tr>
                    <td>' . $roworderinfo->price_category_type . '</td>
                    <td>' . $roworderinfo->sub_Repair_job_name . '</td>
                    <td style="text-align: right;">' . number_format((float)$roworderinfo->job_price, 2, '.', '') . '</td>
                </tr>';
            }
            $html .= '</tbody>
                    </table>
                </div>
            </div>';




        } else {
            $html .= '
            <div class="row">
            </div>
            <div class="row">
            <div class="col-12">
            <hr>
            <table class="table table-striped table-bordered table-sm">
            <thead>
            <th style="background-color: #c3faf6">Seat Type</th>
            <th style="background-color: #c3faf6">Seat Condition Type</th>
            <th style="background-color: #c3faf6;text-align: right">Price</th>
            </thead>
            <tbody>';
            foreach ($responddetail->result() as $roworderinfo) {
                $html .= '<tr>
                    <td>' . $roworderinfo->seat_type . '</td>
                    <td>' . $roworderinfo->condition_type . '</td>
                    <td style="text-align: right;">' . number_format((float)$roworderinfo->job_price, 2, '.', '') . '</td>
                </tr>';
            }
            $html .= '</tbody>
            </table></div></div>';
        }
    
        echo $html;
    }



    public function Job_detailviewheader() {
        $recordID = $this->input->post('recordID');
    
        $this->db->select('tbl_job_price.*, tbl_sales_jobs_details.sales_job_name AS jobname');
        $this->db->from('tbl_job_price');
        $this->db->join('tbl_sales_jobs_details', 'tbl_sales_jobs_details.idtbl_sales_jobs_details = tbl_job_price.sales_job_details_id', 'left');
        $this->db->where('idtbl_job_price', $recordID);
        $this->db->where('tbl_job_price.status', 1);
    
        $respond = $this->db->get();
    
        $obj = new stdClass();
        $obj->jobname = $respond->row(0)->jobname;
    
        echo json_encode($obj);
    }

    public function Job_price_details_edit(){
        $recordID=$this->input->post('recordID');

        $this->db->select('*');
        $this->db->from('tbl_job_price');
        $this->db->where('idtbl_job_price', $recordID);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        $obj=new stdClass();
        $obj->id=$respond->row(0)->idtbl_job_price;
        $obj->main_job_category_id=$respond->row(0)->main_job_category_id;
        $obj->sub_job_category_id=$respond->row(0)->sub_job_category_id;
        $obj->sales_job_details_id=$respond->row(0)->sales_job_details_id;        

        echo json_encode($obj);
    }


    public function Job_price_details_editjobedit(){
        $recordID=$this->input->post('recordID');
        $sub_job_category_id=$this->input->post('sub_job_category_id');

        $html='';

		$sql = "SELECT 
            tbl_job_price_detail.*, 
            tbl_seat_type.idtbl_seat_type,
            tbl_seat_type.seat_type,
            tbl_seat_condition.idtbl_seat_condition,
            tbl_seat_condition.condition_type,
            tbl_price_category_type.price_category_type,tbl_material.material_type FROM tbl_job_price_detail 
        LEFT JOIN tbl_job_price ON tbl_job_price.idtbl_job_price = tbl_job_price_detail.job_price_id 
        LEFT JOIN tbl_price_category_type ON tbl_price_category_type.idtbl_price_category_type = tbl_job_price_detail.Cate_type 
        LEFT JOIN tbl_material ON tbl_material.idtbl_material = tbl_job_price_detail.material_id 
        LEFT JOIN tbl_seat_type ON tbl_seat_type.idtbl_seat_type = tbl_job_price_detail.seat_type 
        LEFT JOIN tbl_seat_condition ON tbl_seat_condition.idtbl_seat_condition = tbl_job_price_detail.seat_condition
        WHERE job_price_id = '$recordID'";


        $respond=$this->db->query($sql, array(1, $recordID));

        $html='';
        foreach($respond->result() as $rowlist){
            if($sub_job_category_id == '1'){
                $html.='
                            <tr id ="'.$rowlist->idtbl_job_price_detail .'">
                                <td>'.$rowlist->price_category_type.'</td>
                                <td class="d-none price_cat_id">'.$rowlist->Cate_type.'</td>
                                <td class="material_name">'.$rowlist->material_type.'</td>
                                <td class="d-none material_id">'.$rowlist->material_id.'</td>
                                <td>'.$rowlist->job_price.'</td>
                                <td class="d-none">OldData</td>
                                <td class="d-none"> '.$rowlist->job_price_id.'</td>
                                <td ><button type="button" id="'.$rowlist->idtbl_job_price_detail.'" class="btnEditlist btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#exampleModal">
                                <i class="fas fa-pen"></i>
                            </button>
                            </td>
                            <td class="d-none"><input class="hiddenid" type ="hidden" id ="hiddenid" name="hiddenid" value="'.$rowlist->idtbl_job_price_detail.'"></td>
                                
                            </tr>
                    
                    ';
                
            }else{

                        $html.=' <tr id ="'.$rowlist->idtbl_job_price_detail .'">
                                        <td>'.$rowlist->seat_type.'</td>
                                        <td class="d-none seat_type_id">'.$rowlist->idtbl_seat_type.'</td>
                                        <td>'.$rowlist->condition_type.'</td>
                                        <td class="d-none seat_type_id">'.$rowlist->idtbl_seat_condition.'</td>
                                        <td>'.$rowlist->job_price.'</td>
                                        <td class="d-none">OldData</td>
                                        <td class="d-none"> '.$rowlist->job_price_id.'</td>
                                        <td ><button type="button" id="'.$rowlist->idtbl_job_price_detail.'" class="btnEditlist btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#exampleModal">
                                        <i class="fas fa-pen"></i>
                                        </button>
                                        </td>
                                        <td class="d-none"><input class="hiddenid" type ="hidden" id ="hiddenid" name="hiddenid" value="'.$rowlist->idtbl_job_price_detail.'"></td>
                                    </tr>
                            ';
            }
        }

        echo ($html);


    }

    public function Job_price_detailsjoblistedit(){
        $recordID=$this->input->post('recordID');
        $this->db->select('*');
        $this->db->from('tbl_job_price_detail');
        $this->db->where('idtbl_job_price_detail', $recordID);
        $this->db->where('tbl_job_price_detail.status', 1);

        $respond=$this->db->get();

        $obj=new stdClass();
        $obj->id=$respond->row(0)->idtbl_job_price_detail;
        $obj->Cate_type=$respond->row(0)->Cate_type;
        $obj->seat_type=$respond->row(0)->seat_type;
        $obj->seat_condition=$respond->row(0)->seat_condition;
        $obj->material_id=$respond->row(0)->material_id;
        $obj->job_price=$respond->row(0)->job_price;
        $obj->idtbl_job_price=$respond->row(0)->job_price_id;
        echo json_encode($obj);
    }

    public function job_price_details_pdf(){
      
        $this->db->select('tbl_job_price.idtbl_job_price,tbl_job_price.job_id,tbl_jobs.job_name');
        $this->db->from('tbl_job_price');
        $this->db->join('tbl_jobs', 'tbl_job_price.job_id = tbl_jobs.idtbl_jobs', 'left');
        $this->db->where('tbl_job_price.status', 1);

        $mainData = $this->db->get()->result_array();
      

        if (empty($mainData)) {
            echo "No main Data found";
            return; 
        }

        $mainDataID = array_column($mainData, 'idtbl_job_price');
       

        $this->db->select('tbl_job_price_detail.job_price_id, tbl_price_category_type.price_category_type,tbl_job_price_detail.job_price');
        $this->db->from('tbl_job_price_detail');
        $this->db->join('tbl_price_category_type', 'tbl_job_price_detail.Cate_type = tbl_price_category_type.idtbl_price_category_type', 'left');
        $this->db->where_in('tbl_job_price_detail.job_price_id', $mainDataID);
        $details = $this->db->get()->result_array();
     
        $detailsByJobPrice = [];
        foreach ($details as $detail) {
            $detailsByJobPrice[$detail['job_price_id']][] = $detail;
        }

        $finalData = [];
        foreach ($mainData as $jobpriceIdList) {
            $MainJobPriceId = $jobpriceIdList['idtbl_job_price'];

            $finalData[] = [
            'main_data' => $jobpriceIdList,
            'details_data' => isset($detailsByJobPrice[$MainJobPriceId]) ? $detailsByJobPrice[$MainJobPriceId] : []
            ];
        }

        $checkpath = 'assets/img/check.png'; 
        $checktype = pathinfo($checkpath, PATHINFO_EXTENSION);
        $checkdata = file_get_contents($checkpath); 
        $checkIconBase64 = 'data:image/' . $checktype . ';base64,' . base64_encode($checkdata); 

        $crosspath = 'assets/img/cross.png'; 
        $crosstype = pathinfo($crosspath, PATHINFO_EXTENSION);
        $crossdata = file_get_contents($crosspath); 
        $crossIconBase64 = 'data:image/' . $crosstype . ';base64,' . base64_encode($crossdata); 
        

        $count=1;

        $html = '
        <!DOCTYPE html>
        <html>

        <head>
            <title>ECW Software</title>
            <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
            <link rel="icon" type="image/x-icon" href="assets/img/ecw2.jpg" />
            <style>
                @page {
                     margin: 5mm 16mm 2mm 20mm; /* top right bottom left */
                }
                body {
                margin: 0;
                font-family: "Roboto", sans-serif;
                font-size: 11px;
                line-height: 1.5;
                text-align:left;
                }
                .tg td {
                    font-size: 11px;
                    overflow: hidden;
                    word-break: normal;
                }

                .tg th {
                    font-size: 11px;
                    font-weight: normal;
                    overflow: hidden;
                    word-break: normal;
                }

                .tg .tg-btmp {
                    color: #000;
                    text-align: left;
                    vertical-align: top
                }

                .tg .tg-0lax {
                    text-align: left;
                    vertical-align: top
                }
                .tg .tg-btmp {
                    color: #000;
                    text-align: left;
                    vertical-align: top
                }

                .tg .tg-0lax {
                    text-align: left;
                    vertical-align: top
                }

            </style>
        </head>

        <body>';
        $html .= '
        <p style="font-weight:bold; font-size: 21px;text-align: center;margin-top:-5px;margin-bottom:2px;">Job Price Details Informations</p>
        <table style="table-layout: fixed;padding:3px;width:100%;border-collapse: collapse;">
            <tr>
                <th style="width:1%;padding:3px;text-align:left; border: 1px solid #000;font-weight:bold">#</th>
                <th style="width:15%;padding:3px;text-align:left; border: 1px solid #000;font-weight:bold">Job Name</th>
                <th style="width:5%;padding:3px;text-align:left; border: 1px solid #000;font-weight:bold">Price Category Type</th>
                <th style="width:5%;padding:3px;text-align:left; border: 1px solid #000;font-weight:bold">Price</th>
            </tr>
            <tr>';
            if($finalData==null){
                  $html .= '
                     <tr>
                        <td colspan="17" style="width:2%;padding:3px;text-align:center;vertical-align: top;border: 1px solid #000;">No Data Found!</td>
                    </tr>';
            }else{
                foreach ($finalData as $data) {
                    $job_name = $data['main_data']['job_name'];

                    $price_category = '';
                    $price = '';
    
                    foreach ($data['details_data'] as $detail) {
                        $price_category .= '* '.$detail['price_category_type'] . '<br>'; 
                        $price .= '* '.$detail['job_price'] . '<br>'; 
                    }
        
                    
    
                    $html .= '
                    <tr>
                        <td style="width:1%;padding:3px;text-align:left;vertical-align: top;border: 1px solid #000;">' . $count . '</td>
                        <td style="width:15%;padding:3px;text-align:left;vertical-align: top;border: 1px solid #000;">' . $job_name . '</td>
                        <td style="width:5%;padding:3px;text-align:left;vertical-align: top;border: 1px solid #000;">' . $price_category . '</td>
                        <td style="width:5%;padding:2px;text-align:left;vertical-align: top;border: 1px solid #000;">' . $price . '</td>
                    </tr>';
                    $count++;
                }
            }
            $html .= '</tr>

        </table>
        <div style="margin-top:75px"></div>
       
        </body>

        </html>';

        $this->load->library('Pdf');
        $this->pdf->set_option('isRemoteEnabled', true);
        $this->pdf->setPaper('A4', 'landscape');
        $this->pdf->loadHtml($html, 'UTF-8');
        $this->pdf->render();
        $this->pdf->stream( "Job Price Details Informations.pdf", array("Attachment"=>0));


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




    public function Get_repair_type() {
		$sub_job_category_id = $this->input->post('sub_job_category_id');
        $job_name_id = $this->input->post('job_name_id');

        $this->db->select('idtbl_seat_repair_category, sub_Repair_job_name');
        $this->db->from('tbl_seat_repair_category');
        $this->db->where('status', 1);
        $this->db->where('repair_job_id', $job_name_id); 
        $this->db->where('sub_job_id', $sub_job_category_id); 
        $query = $this->db->get();
        $result = $query->result_array();
        echo json_encode($result);
        
	}




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


}