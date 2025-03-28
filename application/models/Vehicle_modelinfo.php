<?php
class Vehicle_modelinfo extends CI_Model{


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

    public function Get_vehicle_brand() {
        $branchID = $_SESSION['branch_id'];
        $search = $this->input->get('search');
        $page = $this->input->get('page');

        $this->db->select('idtbl_vehicle_brand AS id, brand_name AS text');
        $this->db->from('tbl_vehicle_brand');
        $this->db->where('status', 1);
        $this->db->like('brand_name', $search);
        
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $this->db->limit($limit, $offset);
        
        $query = $this->db->get();
        $result = $query->result_array();
        
        $this->db->select('COUNT(idtbl_vehicle_brand) as total');
        $this->db->where('status', 1);
        $this->db->like('brand_name', $search);
        
        $total = $this->db->get('tbl_vehicle_brand')->row()->total;

        return [
            'results' => $result,
            'pagination' => ['more' => $total > $offset + $limit]
        ];
    }

    public function Getvehicletype() {
        $this->db->select('idtbl_vehicle_type  , vehicle_type_name');
        $this->db->from('tbl_vehicle_type');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function Getvehicleseries() {
        $this->db->select('idtbl_vehicle_series , series_name');
        $this->db->from('tbl_vehicle_series');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function Getvehiclegeneration() {
        $this->db->select('idtbl_vehicle_generation , generation_name');
        $this->db->from('tbl_vehicle_generation');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function Getvehicleyear() {
        $this->db->select('idtbl_vehicle_year , year_name');
        $this->db->from('tbl_vehicle_year');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }


    public function Vehicle_modelinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $vehicle_brand_id=$this->input->post('vehicle_brand_id');
        $vehicle_series_id=$this->input->post('vehicle_series_id');
        $vehicle_generation_id=$this->input->post('vehicle_generation_id');
        $vehicle_year_id=$this->input->post('vehicle_year_id');
        $price_category_id=$this->input->post('price_category_id');
        $model_name=$this->input->post('model_name');
        $vehicle_type_id=$this->input->post('vehicle_type_id');

        $recordOption=$this->input->post('recordOption');
        if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}

        $insertdatetime=date('Y-m-d H:i:s');

        if($recordOption==1){
            $data = array(
                'model_name'=> $model_name, 
                'vehicle_brand_id'=> $vehicle_brand_id, 
                'vehicle_series_id'=> $vehicle_series_id, 
                'vehicle_generation_id'=> $vehicle_generation_id, 
                'vehicle_year_id'=> $vehicle_year_id, 
                'price_category_id'=> $price_category_id,
                'vehicle_type_id'=> $vehicle_type_id, 
                'status'=> '1', 
                'insertdatetime'=> $insertdatetime, 
                'tbl_user_idtbl_user'=> $userID,
            );

            $this->db->insert('tbl_vehicle_model', $data);

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
                redirect('Vehicle_model');                
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
                redirect('Vehicle_model');
            }
        }
        else{
            $data = array(
                'model_name'=> $model_name, 
                'vehicle_series_id'=> $vehicle_series_id, 
                'vehicle_generation_id'=> $vehicle_generation_id, 
                'vehicle_year_id'=> $vehicle_year_id, 
                'price_category_id'=> $price_category_id, 
                'vehicle_type_id'=> $vehicle_type_id, 
                'updateuser'=> $userID, 
                'updatedatetime' => $insertdatetime,
            );

            $this->db->where('idtbl_vehicle_model', $recordID);
            $this->db->update('tbl_vehicle_model', $data);

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
                redirect('Vehicle_model');                
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
                redirect('Vehicle_model');
            }
        }
    }
    public function Vehicle_modelstatus($x, $y){
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

            $this->db->where('idtbl_vehicle_model', $recordID);
            $this->db->update('tbl_vehicle_model', $data);

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
                redirect('Vehicle_model');                
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
                redirect('Vehicle_model');
            }
        }
        else if($type==2){
            $data = array(
                'status' => '2',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_vehicle_model', $recordID);
            $this->db->update('tbl_vehicle_model', $data);

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
                redirect('Vehicle_model');                
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
                redirect('Vehicle_model');
            }
        }
        else if($type==3){
            $data = array(
                'status' => '3',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_vehicle_model', $recordID);
            $this->db->update('tbl_vehicle_model', $data);

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
                redirect('Vehicle_model');                
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
                redirect('Vehicle_model');
            }
        }
    }
    public function Vehicle_modeledit(){
        $recordID=$this->input->post('recordID');

        $this->db->select('tbl_vehicle_model.*,tbl_vehicle_brand.brand_name');
        $this->db->from('tbl_vehicle_model');
        $this->db->join('tbl_vehicle_brand','tbl_vehicle_model.vehicle_brand_id = tbl_vehicle_brand.idtbl_vehicle_brand','left');
        $this->db->where('tbl_vehicle_model.idtbl_vehicle_model', $recordID);
        $this->db->where('tbl_vehicle_model.status', 1);

        $respond=$this->db->get();

        $obj=new stdClass();
        $obj->id=$respond->row(0)->idtbl_vehicle_model;
        $obj->model_name=$respond->row(0)->model_name;
        $obj->vehicle_brand_id=$respond->row(0)->vehicle_brand_id;
        $obj->vehicle_series_id=$respond->row(0)->vehicle_series_id;
        $obj->vehicle_generation_id=$respond->row(0)->vehicle_generation_id;
        $obj->vehicle_year_id=$respond->row(0)->vehicle_year_id;
        $obj->vehicle_type_id=$respond->row(0)->vehicle_type_id;
        $obj->price_category_id=$respond->row(0)->price_category_id;
        $obj->brand_name=$respond->row(0)->brand_name;
        

        echo json_encode($obj);
    }

    public function Brand_insert(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $brand_name=$this->input->post('brand_name');

        $insertdatetime=date('Y-m-d H:i:s');

            $data = array(
                'brand_name'=> $brand_name, 
                'status'=> '1', 
                'insertdatetime'=> $insertdatetime, 
                'tbl_user_idtbl_user'=> $userID,
            );

            $this->db->insert('tbl_vehicle_brand', $data);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                $response = array('status' => 'success', 'message' => 'Record Save successfully');
                echo json_encode($response);   
            } else {
                $this->db->trans_rollback();
                $response = array('status' => 'error', 'message' => 'Failed to Save record');
                echo json_encode($response);
            }
    }
}