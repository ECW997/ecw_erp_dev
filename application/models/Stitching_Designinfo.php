<?php
class Stitching_Designinfo extends CI_Model{

    public function Getprice_category_type() {
        $this->db->select('idtbl_price_category_type , price_category_type');
        $this->db->from('tbl_price_category_type');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
    public function Stitching_Designinsertupdate() {
        $this->db->trans_begin();
    
        $userID = $_SESSION['userid'];
        $code = $this->input->post('code');
        $recordOption = $this->input->post('recordOption');
        if (!empty($this->input->post('recordID'))) {
            $recordID = $this->input->post('recordID');
        }
    
        $insertdatetime = date('Y-m-d H:i:s');
    
        // Handle Image Upload
        $config['upload_path'] = './images/Stitching_img/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size'] = 12288;  // 12MB
        $config['file_name'] = time() . '_' . $this->security->sanitize_filename($_FILES['design_image']['name']);
    
        $this->load->library('upload', $config);
    
        // Insert New Record
        if ($recordOption == 1) {
            if ($this->upload->do_upload('design_image')) {
                $imageData = $this->upload->data();
                $data = array(
                    'stitching_code' => $code,
                    'image_path' => $imageData['file_name'],
                    'status' => '1',
                    'insertdatetime' => $insertdatetime,
                    'tbl_user_idtbl_user' => $userID,
                );
    
                $this->db->insert('tbl_stitching_design', $data);
            } else {
                $error = $this->upload->display_errors();
                $this->session->set_flashdata('msg', json_encode(['message' => 'Image Upload Failed: ' . $error, 'type' => 'danger']));
                redirect('Stitching_Design');
                return;
            }
        } else {  // Update Record
            $data = array(
                'stitching_code' => $code,
                'updateuser' => $userID,
                'updatedatetime' => $insertdatetime,
            );
    
            if ($this->upload->do_upload('design_image')) {
                $imageData = $this->upload->data();
                $data['image_path'] = $imageData['file_name'];
            }
    
            $this->db->where('idtbl_stitching_design', $recordID);
            $this->db->update('tbl_stitching_design', $data);
        }
    
        // Complete Transaction and Redirect with Message
        $this->db->trans_complete();
    
        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            $msg = ($recordOption == 1) ? 'Record Added Successfully' : 'Record Updated Successfully';
            $actionObj = (object) ['icon' => 'fas fa-save', 'message' => $msg, 'type' => 'success'];
            $this->session->set_flashdata('msg', json_encode($actionObj));
            redirect('Stitching_Design');
        } else {
            $this->db->trans_rollback();
            $actionObj = (object) ['icon' => 'fas fa-warning', 'message' => 'Record Error', 'type' => 'danger'];
            $this->session->set_flashdata('msg', json_encode($actionObj));
            redirect('Stitching_Design');
        }
    }
    
    public function Stitching_Designstatus($x, $y){
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

            $this->db->where('idtbl_stitching_design', $recordID);
            $this->db->update('tbl_stitching_design', $data);

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
                redirect('Stitching_Design');                
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
                redirect('Stitching_Design');
            }
        }
        else if($type==2){
            $data = array(
                'status' => '2',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_stitching_design', $recordID);
            $this->db->update('tbl_stitching_design', $data);

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
                redirect('Stitching_Design');                
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
                redirect('Stitching_Design');
            }
        }
        else if($type==3){
            $data = array(
                'status' => '3',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_stitching_design', $recordID);
            $this->db->update('tbl_stitching_design', $data);

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
                redirect('Stitching_Design');                
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
                redirect('Stitching_Design');
            }
        }
    }
    public function Stitching_Designedit(){
        $recordID=$this->input->post('recordID');

        $this->db->select('*');
        $this->db->from('tbl_stitching_design');
        $this->db->where('idtbl_stitching_design', $recordID);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        $obj=new stdClass();
        $obj->id=$respond->row(0)->idtbl_stitching_design;
        $obj->code=$respond->row(0)->stitching_code;

        echo json_encode($obj);
    }

    private function checkDublicate($main_table_id,$price_category_id,$vehicle_type_id){
        $this->db->where('price_category_type_id', $price_category_id);
        $this->db->where('vehicle_type', $vehicle_type_id);
        $this->db->where('price_category_type_id', $price_category_id);
        $this->db->where('tbl_stitching_design_id', $main_table_id);
        $this->db->where('status', '1');
        $query = $this->db->get('tbl_stitching_design_price_details');

        if ($query->num_rows() > 0) {
            $actionObj=new stdClass();
            $actionObj->icon='fas fa-trash-alt';
            $actionObj->title='';
            $actionObj->message='Price Category Already Submited!';
            $actionObj->url='';
            $actionObj->target='_blank';
            $actionObj->type='danger';

            $actionJSON=json_encode($actionObj);
            
            $obj = new stdClass();
            $obj->status = 0;
            $obj->action = $actionJSON;

            echo json_encode($obj);  
            return false;
        }else{
            return true;
        }
    }
    public function AddPriceinsertupdate() {
        $this->db->trans_begin();
    
        $userID = $_SESSION['userid'];
        $main_table_id = $this->input->post('main_table_id');
        $price_category_id = $this->input->post('price_category_id');
        $vehicle_type_id = $this->input->post('vehicle_type_id');
        $price = $this->input->post('price');

        $recordOption = $this->input->post('recordOption');
        if (!empty($this->input->post('recordID'))) {
            $recordID = $this->input->post('recordID');
        }
    
        $insertdatetime = date('Y-m-d H:i:s');
    
        // Insert New Record
        if ($recordOption == 1) {
            $isUnique = $this->checkDublicate($main_table_id,$price_category_id, $vehicle_type_id);
            if (!$isUnique) {
                $this->db->trans_rollback(); 
                return;
            }
                $data = array(
                    'price_category_type_id' => $price_category_id,
                    'price' => $price,
                    'tbl_stitching_design_id' => $main_table_id,
                    'vehicle_type' => $vehicle_type_id,
                    'status' => '1',
                    'insertdatetime' => $insertdatetime,
                    'tbl_user_idtbl_user' => $userID,
                );
    
                $this->db->insert('tbl_stitching_design_price_details', $data);
        } else {  
            $data = array(
                'price_category_type_id' => $price_category_id,
                'price' => $price,
                'vehicle_type' => $vehicle_type_id,
                'updateuser' => $userID,
                'updatedatetime' => $insertdatetime,
            );
    
            $this->db->where('idtbl_stitching_design_price_details', $recordID);
            $this->db->update('tbl_stitching_design_price_details', $data);
        }
    
        // Complete Transaction and Redirect with Message
        $this->db->trans_complete();
    
        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            
            $actionObj=new stdClass();
            $actionObj->icon='fas fa-trash-alt';
            $actionObj->title='';
            $actionObj->message='Price Add Successfully';
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
    public function Priceremove(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $recordID=$this->input->post('recordID');
        $type=$this->input->post('type');
        $updatedatetime=date('Y-m-d H:i:s');

        if($type==3){
             $data = array(
                'status'=> '3',
                'updateuser'=> $userID,
                'updatedatetime'=> $updatedatetime
            );
            $this->db->where('idtbl_stitching_design_price_details', $recordID);
            $this->db->update('tbl_stitching_design_price_details', $data);

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
    public function PriceCategoryedit(){
        $recordID=$this->input->post('recordID');

        $this->db->select('*');
        $this->db->from('tbl_stitching_design_price_details');
        $this->db->where('idtbl_stitching_design_price_details', $recordID);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        $obj=new stdClass();
        $obj->id=$respond->row(0)->idtbl_stitching_design_price_details;
        $obj->price_category_type_id=$respond->row(0)->price_category_type_id;
        $obj->price=$respond->row(0)->price;
        $obj->vehicle_type=$respond->row(0)->vehicle_type;

        echo json_encode($obj);
    }
}