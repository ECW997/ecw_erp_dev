<?php
class SalesJobsDetailsinfo extends CI_Model{

    public function Getjobtype() {
        $this->db->select('idtbl_job_type , job_type_name');
        $this->db->from('tbl_job_type');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function Getcompanytype() {
        $this->db->select('idtbl_company_type , company_type_name');
        $this->db->from('tbl_company_type');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function Getmainjob() {
        $this->db->select('idtbl_main_job_category , main_job_category');
        $this->db->from('tbl_main_job_category');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function SalesJobsDetailsinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];

        $main_job_category=$this->input->post('main_job_category');
        $sub_job_category=$this->input->post('sub_job_category');
        $job_name=$this->input->post('job_name');
        $job_type=$this->input->post('job_type');
        $company_type=$this->input->post('company_type');

        $recordOption=$this->input->post('recordOption');
        if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}

        $insertdatetime=date('Y-m-d H:i:s');

        if($recordOption==1){
            $data = array(
                'sales_job_name'=> $job_name, 
                'sales_job_type	'=> $job_type, 
                'company_type'=> $company_type, 
                'main_job_category_id'=> $main_job_category, 
                'sub_job_category_id'=> $sub_job_category, 
                'status'=> '1', 
                'insertdatetime'=> $insertdatetime, 
                'tbl_user_idtbl_user'=> $userID,
            );

            $this->db->insert('tbl_sales_jobs_details', $data);

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
                redirect('SalesJobsDetails');                
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
                redirect('SalesJobsDetails');
            }
        }
        else{
            $data = array(
                'sales_job_name'=> $job_name,
                'sales_job_type	'=> $job_type, 
                'company_type'=> $company_type,
                'main_job_category_id'=> $main_job_category, 
                'sub_job_category_id'=> $sub_job_category, 
                'updateuser'=> $userID, 
                'updatedatetime' => $insertdatetime,
            );

            $this->db->where('idtbl_sales_jobs_details', $recordID);
            $this->db->update('tbl_sales_jobs_details', $data);

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
                redirect('SalesJobsDetails');                
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
                redirect('SalesJobsDetails');
            }
        }
    }
    public function SalesJobsDetailsstatus($x, $y){
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

            $this->db->where('idtbl_sales_jobs_details', $recordID);
            $this->db->update('tbl_sales_jobs_details', $data);

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
                redirect('SalesJobsDetails');                
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
                redirect('SalesJobsDetails');
            }
        }
        else if($type==2){
            $data = array(
                'status' => '2',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_sales_jobs_details', $recordID);
            $this->db->update('tbl_sales_jobs_details', $data);

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
                redirect('SalesJobsDetails');                
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
                redirect('SalesJobsDetails');
            }
        }
        else if($type==3){
            $data = array(
                'status' => '3',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_sales_jobs_details', $recordID);
            $this->db->update('tbl_sales_jobs_details', $data);

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
                redirect('SalesJobsDetails');                
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
                redirect('SalesJobsDetails');
            }
        }
    }
    public function SalesJobsDetailsedit(){
        $recordID=$this->input->post('recordID');

        $this->db->select('*');
        $this->db->from('tbl_sales_jobs_details');
        $this->db->where('idtbl_sales_jobs_details', $recordID);
        $this->db->where('status', 1);

        $respond=$this->db->get();

        $obj=new stdClass();
        $obj->id=$respond->row(0)->idtbl_sales_jobs_details;
        $obj->job_name=$respond->row(0)->sales_job_name;
        $obj->job_type=$respond->row(0)->sales_job_type	;
        $obj->company_type=$respond->row(0)->company_type;
        $obj->main_job_category_id=$respond->row(0)->main_job_category_id;
        $obj->sub_job_category_id=$respond->row(0)->sub_job_category_id;

        echo json_encode($obj);
    }

    public function Getsubjobcategory() {
		$main_job_category_id = $this->input->post('main_job_category_id');

        $this->db->select('idtbl_sub_job_category, sub_job_category');
        $this->db->from('tbl_sub_job_category');
        $this->db->where('status', 1);
        $this->db->where('main_job_category_id', $main_job_category_id); 
        $query = $this->db->get();
        $result = $query->result_array();
        echo json_encode($result);
        
	}
}