<?php
class Vehicleinfo extends CI_Model{
    public function Getvehicletype(){
        $this->db->select('idtbl_vehicle_type , vehicle_type');
        $this->db->from('tbl_vehicle_type');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function Getvehiclebrand(){
        $this->db->select('idtbl_vehicle_brand , vehicle_brand');
        $this->db->from('tbl_vehicle_brand');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function Getvehiclemodel(){
        $this->db->select('idtbl_vehicle_model , vehicle_model');
        $this->db->from('tbl_vehicle_model');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }
    
    public function Vehicleinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $vehicleregno=$this->input->post('vehicleregno');
        $vehicletype=$this->input->post('vehicletype');
        $vehiclebrand=$this->input->post('vehiclebrand');
        $vehiclemodel=$this->input->post('vehiclemodel');
        $engineno=$this->input->post('engineno');
        $chassisno=$this->input->post('chassisno');
        $mileage=$this->input->post('mileage');
    
      
        $recordOption=$this->input->post('recordOption');
        if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}

        $insertdatetime=date('Y-m-d H:i:s');

        if($recordOption==1){
            $data = array(
                'vehicle_reg_no'=> $vehicleregno, 
                'tbl_vehicle_type_idtbl_vehicle_type '=> $vehicletype, 
                'tbl_vehicle_brand_idtbl_vehicle_brand '=> $vehiclebrand, 
                'tbl_vehicle_model_idtbl_vehicle_model '=> $vehiclemodel, 
                'engine_no'=> $engineno, 
                'chassis_no'=> $chassisno, 
                'mileage'=> $mileage, 
                'status'=> '1', 
                'insertdatetime'=> $insertdatetime, 
                'tbl_user_idtbl_user'=> $userID,
            );

            $this->db->insert('tbl_vehicle', $data);

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
    public function Vehicleedit(){
        $recordID=$this->input->post('recordID');

        $this->db->select('*');
        $this->db->from('tbl_vehicle');
        $this->db->where('idtbl_vehicle', $recordID);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        $obj=new stdClass();
        $obj->id=$respond->row(0)->idtbl_vehicle ;
        $obj->vehicleregno=$respond->row(0)->vehicle_reg_no;
        $obj->vehicletype=$respond->row(0)->tbl_vehicle_type_idtbl_vehicle_type;
        $obj->vehiclebrand=$respond->row(0)->tbl_vehicle_brand_idtbl_vehicle_brand;
        $obj->vehiclemodel=$respond->row(0)->tbl_vehicle_model_idtbl_vehicle_model;
        $obj->engineno=$respond->row(0)->engine_no;
        $obj->chassisno=$respond->row(0)->chassis_no;
        $obj->mileage=$respond->row(0)->mileage;


    
        echo json_encode($obj);
    }
}