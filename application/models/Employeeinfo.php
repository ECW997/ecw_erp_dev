<?php
class Employeeinfo extends CI_Model{


    public function Getcompanybranch() {
		$company_id = $this->input->post('company_id');
        $this->db->select('idtbl_company_branch, branch');
        $this->db->from('tbl_company_branch');
        $this->db->where('status', 1);
        $this->db->where('tbl_company_idtbl_company', $company_id); 
        $query = $this->db->get();
        $result = $query->result_array();
        echo json_encode($result);
        
	}

    public function Getdepartment() {

		$company_id=$_SESSION['company_id'];

        $this->db->select('id, department_name');
        $this->db->from('departments');
        $this->db->where('status', 1);
        $this->db->where('company_id', $company_id); 
        return $respond=$this->db->get();
        
	}

    public function Getjobtitle() {

		$company_id=$_SESSION['company_id'];

        $this->db->select('id, jobtitle');
        $this->db->from('job_titles');
        $this->db->where('status', 1);
        return $respond=$this->db->get();
        
	}

    public function Employeeinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $company_id=$_SESSION['company_id'];
        $branch_id=$_SESSION['branch_id'];

        $service_no=$this->input->post('emp_no');
        $name_with_initials=$this->input->post('name_with_initials');
        $calling_name=$this->input->post('calling_name');
        $address=$this->input->post('address');
        $dob=$this->input->post('dob');
        $gender=$this->input->post('gender');
        $email=$this->input->post('email');
        $nic=$this->input->post('nic');
        $department=$this->input->post('department');
        $jobtitle=$this->input->post('jobtitle');
        $contact_no=$this->input->post('contact_no');
       

        $recordOption=$this->input->post('recordOption');
        if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}

        $insertdatetime=date('Y-m-d H:i:s');

        $config['upload_path'] = './images/Employee_Profile/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size'] = 12288;  // 12MB
        $config['file_name'] = time() . '_' . $this->security->sanitize_filename($_FILES['profileimage']['name']);
    
        $this->load->library('upload', $config);

        $imagePath = null; 

        if ($this->upload->do_upload('profileimage')) {
            $imageData = $this->upload->data();
            $imagePath = $imageData['file_name'];
        } else {
            $uploadError = $this->upload->display_errors();
            log_message('error', 'Image upload failed: ' . $uploadError);
        }

        if($recordOption==1){
            $data = array(
                'service_no'=> $service_no, 
                'emp_name_with_initial'=> $name_with_initials, 
                'calling_name'=> $calling_name,
                'emp_address'=> $address,
                'emp_birthday'=> $dob,
                'emp_gender'=> $gender,
                'emp_email'=> $email,
                'emp_national_id'=> $nic,
                'emp_department'=> $department,
                'job_title_id'=> $jobtitle,
                'emp_mobile'=> $contact_no,
                'emp_company'=> $company_id,
                'emp_branch'=> $branch_id,
                'deleted'=> '0',
                'is_resigned'=> '0',
                'created_at'=> $insertdatetime, 
                'created_by'=> $userID,
            );

            if ($imagePath != null) {
                $data['profile_pic_path'] = $imagePath;
            }

            $this->db->insert('employees', $data);

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
                redirect('Employee');                
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
                redirect('Employee');
            }
        }
        else{
            $data = array(
                'service_no'=> $service_no, 
                'emp_name_with_initial'=> $name_with_initials, 
                'calling_name'=> $calling_name,
                'emp_address'=> $address,
                'emp_birthday'=> $dob,
                'emp_gender'=> $gender,
                'emp_email'=> $email,
                'emp_national_id'=> $nic,
                'emp_department'=> $department,
                'job_title_id'=> $jobtitle,
                'emp_mobile'=> $contact_no,
                'modified_user_id'=> $userID, 
                'updated_at' => $insertdatetime,
            );

            if ($imagePath != null) {
                $data['profile_pic_path'] = $imagePath;
            }

            $this->db->where('id', $recordID);
            $this->db->update('employees', $data);

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
                redirect('Employee');                
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
                redirect('Employee');
            }
        }
    }
    public function Employeestatus($x, $y){
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

            $this->db->where('id', $recordID);
            $this->db->update('employees', $data);

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
                redirect('Employee');                
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
                redirect('Employee');
            }
        }
        else if($type==2){
            $data = array(
                'status' => '2',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('id', $recordID);
            $this->db->update('employees', $data);

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
                redirect('Employee');                
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
                redirect('Employee');
            }
        }
        else if($type==3){
            $data = array(
                'deleted' => '1',
                'modified_user_id'=> $userID, 
                'updated_at'=> $updatedatetime
            );

            $this->db->where('id', $recordID);
            $this->db->update('employees', $data);

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
                redirect('Employee');                
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
                redirect('Employee');
            }
        }
    }
    public function Employeeedit(){
        $recordID=$this->input->post('recordID');

        $this->db->select('employees.*,departments.department_name,job_titles.jobtitle');
        $this->db->from('employees');
        $this->db->join('departments','departments.id = employees.emp_department');
        $this->db->join('job_titles','job_titles.id = employees.job_title_id');
        $this->db->where('employees.id', $recordID);

        $respond=$this->db->get();

        $obj=new stdClass();
        $obj->id=$respond->row(0)->id;
        $obj->emp_etfno=$respond->row(0)->emp_etfno;
        $obj->service_no=$respond->row(0)->service_no;
        $obj->emp_name_with_initial=$respond->row(0)->emp_name_with_initial;
        $obj->calling_name=$respond->row(0)->calling_name;
        $obj->emp_address=$respond->row(0)->emp_address;
        $obj->emp_national_id=$respond->row(0)->emp_national_id;
        $obj->emp_gender=$respond->row(0)->emp_gender;
        $obj->emp_birthday=$respond->row(0)->emp_birthday;
        $obj->emp_email=$respond->row(0)->emp_email;
        $obj->emp_department=$respond->row(0)->emp_department;
        $obj->job_title_id=$respond->row(0)->job_title_id;
        $obj->emp_mobile=$respond->row(0)->emp_mobile;
        $obj->department_name=$respond->row(0)->department_name;
        $obj->jobtitle=$respond->row(0)->jobtitle;
        $obj->profile_pic_path=$respond->row(0)->profile_pic_path;

        echo json_encode($obj);
    }
}