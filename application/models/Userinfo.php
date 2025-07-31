<?php
class Userinfo extends CI_Model{
    public function LoginUser(){
        $username=$this->input->post('username');
        $password=md5($this->input->post('password'));
        $company_id=$this->input->post('company_id');
        $branch_id=$this->input->post('branch_id');
        $companyname=$this->input->post('company_text');
        $branchname=$this->input->post('branch_text');

        // if($username=='admin@gmail.com'){
        //     $this->db->select('*');
        //     $this->db->from('tbl_user');
        //     $this->db->join('tbl_user_type', 'tbl_user_type.idtbl_user_type = tbl_user.tbl_user_type_idtbl_user_type');
        //     $this->db->where('tbl_user.username', $username);
        //     $this->db->where('tbl_user.password', $password);
        //     $this->db->where('tbl_user.status', 1);
        // }else{
            $this->db->select('*');
            $this->db->from('tbl_user');
            $this->db->join('tbl_user_type', 'tbl_user_type.idtbl_user_type = tbl_user.tbl_user_type_idtbl_user_type');
            $this->db->where('tbl_user.username', $username);
            $this->db->where('tbl_user.password', $password);
            $this->db->where('tbl_user.status', 1);
            $this->db->where('tbl_user.company_id', $company_id);
            $this->db->where('tbl_user.branch_id', $branch_id);
        // }
        
        $respond=$this->db->get();
        if($respond->num_rows()==1){    
            $user_data = $respond->row(0);
            return [
                'user_data' => $user_data,
                'company_id' => $company_id,
                'branch_id' => $branch_id,
                'company_name' => $companyname,
                'branch_name' => $branchname,
            ];        
        }
        else{
            return false; 
        }
    }

    // User Type Functions
    public function userTypeInsert($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'user_type_v1', $form_data, $headers);
    }
    public function userTypeEdit($api_token,$id) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'user_type_v1', $id, $headers);
    }
    public function userTypeUpdate($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('PUT', 'user_type_v1', $form_data, $headers);
    }
    public function userTypeStatus($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('PUT', 'user_type_status_v1', $form_data, $headers);
    }
    public function userTypeDelete($api_token,$id) {
        $headers = get_api_headers($api_token);
        return call_api('DELETE', 'user_type_v1', $id, $headers);
    }

    // User Privilege Functions
    public function getUsers($api_token,$id){
        $headers = get_api_headers($api_token);
        return call_api('GET', 'get_user_list_v1', $id, $headers);
    }
    public function getUserTypes($api_token,$id){
        $headers = get_api_headers($api_token);
        return call_api('GET', 'get_user_type_list_v1', $id, $headers);
    }
    public function getMenuList($api_token,$id){
        $headers = get_api_headers($api_token);
        return call_api('GET', 'get_menu_list_v1', $id, $headers);
    }
    public function privilegeInsert($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'user_privilege_v1', $form_data, $headers);
    }
    public function privilegeEdit($api_token,$id) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'user_privilege_v1', $id, $headers);
    }
    public function privilegeUpdate($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('PUT', 'user_privilege_v1', $form_data, $headers);
    }
    public function privilegeStatus($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('PUT', 'user_privilege_status_v1', $form_data, $headers);
    }
    public function privilegeDelete($api_token,$id) {
        $headers = get_api_headers($api_token);
        return call_api('DELETE', 'user_privilege_v1', $id, $headers);
    }

    // User User Account Functions
    public function userAccountInsert($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('POST', 'user_account_v1', $form_data, $headers);
    }
    public function userAccountUpdate($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('PUT', 'user_account_v1', $form_data, $headers);
    }
    public function userAccountEdit($api_token,$id) {
        $headers = get_api_headers($api_token);
        return call_api('GET', 'user_account_v1', $id, $headers);
    }
    public function userAccountStatus($api_token,$form_data) {
        $headers = get_api_headers($api_token);
        return call_api('PUT', 'user_account_status_v1', $form_data, $headers);
    }
    public function userAccountDelete($api_token,$id) {
        $headers = get_api_headers($api_token);
        return call_api('DELETE', 'user_account_v1', $id, $headers);
    }
    public function getEmployee($api_token,$id){
        $headers = get_api_headers($api_token);
        return call_api('GET', 'get_employee_details_v1', $id, $headers);
    }
    

    // public function Usertype(){
    //     $this->db->select('idtbl_user_type, type');
    //     $this->db->from('tbl_user_type');

    //     return $respond=$this->db->get();
    // }
    // public function Getsalesperson(){
    //     $company_id=$_SESSION['company_id'];
    //     $branch_id=$_SESSION['branch_id'];

    //     $this->db->select('idtbl_sales_person, sales_person_name');
    //     $this->db->from('tbl_sales_person');
    //     $this->db->where('status','1');
    //     $this->db->where('company_id',$company_id);
    //     $this->db->where('company_branch_id',$branch_id);

    //     return $respond=$this->db->get();
    // }
    // public function Getemployee(){
    //     $company_id=$_SESSION['company_id'];
    //     $branch_id=$_SESSION['branch_id'];

    //     $this->db->select('id, calling_name');
    //     $this->db->from('employees');
    //     $this->db->where('is_resigned','0');
    //     $this->db->where('deleted','0');
    //     $this->db->where('emp_company',$company_id);
    //     $this->db->where('emp_branch',$branch_id);

    //     return $respond=$this->db->get();
    // }
    // public function Useraccountedit(){
    //     $recordID=$this->input->post('recordID');

    //     $this->db->select('*');
    //     $this->db->from('tbl_user');
    //     $this->db->where('idtbl_user', $recordID);
    //     $this->db->where('status', 1);

    //     $respond=$this->db->get();

    //     $obj=new stdClass();
    //     $obj->id=$respond->row(0)->idtbl_user;
    //     $obj->name=$respond->row(0)->name;
    //     $obj->username=$respond->row(0)->username;
    //     $obj->sale_person_id=$respond->row(0)->sale_person_id;
    //     $obj->type=$respond->row(0)->tbl_user_type_idtbl_user_type;
    //     $obj->company_id=$respond->row(0)->company_id;
    //     $obj->branch_id=$respond->row(0)->branch_id;
    //     $obj->employee_id=$respond->row(0)->employee_id;

    //     echo json_encode($obj);
    // }
    // public function Useraccountinsertupdate(){
    //     $this->db->trans_begin();

    //     $userID=$_SESSION['userid'];

    //     $accountname=$this->input->post('accountname');
    //     $username=$this->input->post('username');
    //     if(!empty($this->input->post('password'))){$password=md5($this->input->post('password'));}
    //     $usertype=$this->input->post('usertype');
    //     $sales_person_id=$this->input->post('sales_person_id');
    //     $company_id=$this->input->post('company_id');
    //     $branch_id=$this->input->post('branch_id');
    //     $employee_id=$this->input->post('emp');

    //     $recordOption=$this->input->post('recordOption');
    //     if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}

    //     $updatedatetime=date('Y-m-d H:i:s');

    //     if($recordOption==1){
    //         $data = array(
    //             'name'=>$accountname, 
    //             'username'=>$username, 
    //             'password'=>$password, 
    //             'status'=>'1', 
    //             'insertdatetime'=>$updatedatetime, 
    //             'sale_person_id'=>$sales_person_id,
    //             'tbl_user_type_idtbl_user_type'=>$usertype,
    //             'company_id'=>$company_id,
    //             'branch_id'=>$branch_id,
    //             'employee_id'=>$employee_id
    //         );

    //         $this->db->insert('tbl_user', $data);

    //         $this->db->trans_complete();

    //         if ($this->db->trans_status() === TRUE) {
    //             $this->db->trans_commit();
                
    //             $actionObj=new stdClass();
    //             $actionObj->icon='fas fa-save';
    //             $actionObj->title='';
    //             $actionObj->message='Record Added Successfully';
    //             $actionObj->url='';
    //             $actionObj->target='_blank';
    //             $actionObj->type='success';

    //             $actionJSON=json_encode($actionObj);
                
    //             $this->session->set_flashdata('msg', $actionJSON);
    //             redirect('User/Useraccount');                
    //         } else {
    //             $this->db->trans_rollback();

    //             $actionObj=new stdClass();
    //             $actionObj->icon='fas fa-warning';
    //             $actionObj->title='';
    //             $actionObj->message='Record Error';
    //             $actionObj->url='';
    //             $actionObj->target='_blank';
    //             $actionObj->type='danger';

    //             $actionJSON=json_encode($actionObj);
                
    //             $this->session->set_flashdata('msg', $actionJSON);
    //             redirect('User/Useraccount');
    //         }
    //     }
    //     else{
    //         if(!empty($this->input->post('password'))){
    //             $data = array(
    //                 'name'=>$accountname, 
    //                 'username'=>$username, 
    //                 'password'=>$password,
    //                 'updateuser'=>$userID, 
    //                 'updatedatetime'=>$updatedatetime, 
    //                 'sale_person_id'=>$sales_person_id,
    //                 'tbl_user_type_idtbl_user_type'=>$usertype,
    //                 'company_id'=>$company_id,
    //                 'branch_id'=>$branch_id,
    //                 'employee_id'=>$employee_id
    //             );
    
    //             $this->db->where('idtbl_user', $recordID);
    //             $this->db->update('tbl_user', $data);
    //         }
    //         else{
    //             $data = array(
    //                 'name'=>$accountname, 
    //                 'username'=>$username, 
    //                 'updateuser'=>$userID, 
    //                 'updatedatetime'=>$updatedatetime, 
    //                 'sale_person_id'=>$sales_person_id,
    //                 'tbl_user_type_idtbl_user_type'=>$usertype,
    //                 'company_id'=>$company_id,
    //                 'branch_id'=>$branch_id,
    //                 'employee_id'=>$employee_id
    //             );
    
    //             $this->db->where('idtbl_user', $recordID);
    //             $this->db->update('tbl_user', $data);
    //         }

    //         $this->db->trans_complete();

    //         if ($this->db->trans_status() === TRUE) {
    //             $this->db->trans_commit();
                
    //             $actionObj=new stdClass();
    //             $actionObj->icon='fas fa-save';
    //             $actionObj->title='';
    //             $actionObj->message='Record Update Successfully';
    //             $actionObj->url='';
    //             $actionObj->target='_blank';
    //             $actionObj->type='primary';

    //             $actionJSON=json_encode($actionObj);
                
    //             $this->session->set_flashdata('msg', $actionJSON);
    //             redirect('User/Useraccount');                
    //         } else {
    //             $this->db->trans_rollback();

    //             $actionObj=new stdClass();
    //             $actionObj->icon='fas fa-warning';
    //             $actionObj->title='';
    //             $actionObj->message='Record Error';
    //             $actionObj->url='';
    //             $actionObj->target='_blank';
    //             $actionObj->type='danger';

    //             $actionJSON=json_encode($actionObj);
                
    //             $this->session->set_flashdata('msg', $actionJSON);
    //             redirect('User/Useraccount');
    //         }
    //     }
    // }
    // public function Useraccountstatus($x, $y){
    //     $this->db->trans_begin();

    //     $userID=$_SESSION['userid'];
    //     $recordID=$x;
    //     $type=$y;
    //     $updatedatetime=date('Y-m-d H:i:s');

    //     if($type==1){
    //         $data = array(
    //             'status' => '1',
    //             'updateuser'=> $userID, 
    //             'updatedatetime'=> $updatedatetime
    //         );

    //         $this->db->where('idtbl_user', $recordID);
    //         $this->db->update('tbl_user', $data);

    //         $this->db->trans_complete();

    //         if ($this->db->trans_status() === TRUE) {
    //             $this->db->trans_commit();
                
    //             $actionObj=new stdClass();
    //             $actionObj->icon='fas fa-check';
    //             $actionObj->title='';
    //             $actionObj->message='Record Activate Successfully';
    //             $actionObj->url='';
    //             $actionObj->target='_blank';
    //             $actionObj->type='success';

    //             $actionJSON=json_encode($actionObj);
                
    //             $this->session->set_flashdata('msg', $actionJSON);
    //             redirect('User/Useraccount');                
    //         } else {
    //             $this->db->trans_rollback();

    //             $actionObj=new stdClass();
    //             $actionObj->icon='fas fa-warning';
    //             $actionObj->title='';
    //             $actionObj->message='Record Error';
    //             $actionObj->url='';
    //             $actionObj->target='_blank';
    //             $actionObj->type='danger';

    //             $actionJSON=json_encode($actionObj);
                
    //             $this->session->set_flashdata('msg', $actionJSON);
    //             redirect('User/Useraccount');
    //         }
    //     }
    //     else if($type==2){
    //         $data = array(
    //             'status' => '2',
    //             'updateuser'=> $userID, 
    //             'updatedatetime'=> $updatedatetime
    //         );

    //         $this->db->where('idtbl_user', $recordID);
    //         $this->db->update('tbl_user', $data);

    //         $this->db->trans_complete();

    //         if ($this->db->trans_status() === TRUE) {
    //             $this->db->trans_commit();
                
    //             $actionObj=new stdClass();
    //             $actionObj->icon='fas fa-times';
    //             $actionObj->title='';
    //             $actionObj->message='Record Deactivate Successfully';
    //             $actionObj->url='';
    //             $actionObj->target='_blank';
    //             $actionObj->type='warning';

    //             $actionJSON=json_encode($actionObj);
                
    //             $this->session->set_flashdata('msg', $actionJSON);
    //             redirect('User/Useraccount');                
    //         } else {
    //             $this->db->trans_rollback();

    //             $actionObj=new stdClass();
    //             $actionObj->icon='fas fa-warning';
    //             $actionObj->title='';
    //             $actionObj->message='Record Error';
    //             $actionObj->url='';
    //             $actionObj->target='_blank';
    //             $actionObj->type='danger';

    //             $actionJSON=json_encode($actionObj);
                
    //             $this->session->set_flashdata('msg', $actionJSON);
    //             redirect('User/Useraccount');
    //         }
    //     }
    //     else if($type==3){
    //         $data = array(
    //             'status' => '3',
    //             'updateuser'=> $userID, 
    //             'updatedatetime'=> $updatedatetime
    //         );

    //         $this->db->where('idtbl_user', $recordID);
    //         $this->db->update('tbl_user', $data);

    //         $this->db->trans_complete();

    //         if ($this->db->trans_status() === TRUE) {
    //             $this->db->trans_commit();
                
    //             $actionObj=new stdClass();
    //             $actionObj->icon='fas fa-trash-alt';
    //             $actionObj->title='';
    //             $actionObj->message='Record Remove Successfully';
    //             $actionObj->url='';
    //             $actionObj->target='_blank';
    //             $actionObj->type='danger';

    //             $actionJSON=json_encode($actionObj);
                
    //             $this->session->set_flashdata('msg', $actionJSON);
    //             redirect('User/Useraccount');                
    //         } else {
    //             $this->db->trans_rollback();

    //             $actionObj=new stdClass();
    //             $actionObj->icon='fas fa-warning';
    //             $actionObj->title='';
    //             $actionObj->message='Record Error';
    //             $actionObj->url='';
    //             $actionObj->target='_blank';
    //             $actionObj->type='danger';

    //             $actionJSON=json_encode($actionObj);
                
    //             $this->session->set_flashdata('msg', $actionJSON);
    //             redirect('User/Useraccount');
    //         }
    //     }
    // }
    public function Getemployeedetails(){
        $recordID=$this->input->post('employee_id');

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
        $obj->emp_mobile=$respond->row(0)->emp_mobile;
        $obj->department_name=$respond->row(0)->department_name;
        $obj->jobtitle=$respond->row(0)->jobtitle;
        $obj->profile_pic_path=$respond->row(0)->profile_pic_path;

        echo json_encode($obj);
    }
    // public function Usertypeedit(){
    //     $recordID=$this->input->post('recordID');

    //     $this->db->select('*');
    //     $this->db->from('tbl_user_type');
    //     $this->db->where('idtbl_user_type', $recordID);
    //     $this->db->where('status', 1);

    //     $respond=$this->db->get();

    //     $obj=new stdClass();
    //     $obj->id=$respond->row(0)->idtbl_user_type;
    //     $obj->type=$respond->row(0)->type;

    //     echo json_encode($obj);
    // }
    // public function Usertypeinsertupdate(){
    //     $this->db->trans_begin();

    //     $userID=$_SESSION['userid'];

    //     $usertype=$this->input->post('usertype');

    //     $recordOption=$this->input->post('recordOption');
    //     if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}

    //     $updatedatetime=date('Y-m-d H:i:s');

    //     if($recordOption==1){
    //         $data = array(
    //             'type'=> $usertype,
    //             'status'=> '1',
    //             'insertdatetime'=> $updatedatetime
    //         );

    //         $this->db->insert('tbl_user_type', $data);

    //         $this->db->trans_complete();

    //         if ($this->db->trans_status() === TRUE) {
    //             $this->db->trans_commit();
                
    //             $actionObj=new stdClass();
    //             $actionObj->icon='fas fa-save';
    //             $actionObj->title='';
    //             $actionObj->message='Record Added Successfully';
    //             $actionObj->url='';
    //             $actionObj->target='_blank';
    //             $actionObj->type='success';

    //             $actionJSON=json_encode($actionObj);
                
    //             $this->session->set_flashdata('msg', $actionJSON);
    //             redirect('User/Usertype');                
    //         } else {
    //             $this->db->trans_rollback();

    //             $actionObj=new stdClass();
    //             $actionObj->icon='fas fa-warning';
    //             $actionObj->title='';
    //             $actionObj->message='Record Error';
    //             $actionObj->url='';
    //             $actionObj->target='_blank';
    //             $actionObj->type='danger';

    //             $actionJSON=json_encode($actionObj);
                
    //             $this->session->set_flashdata('msg', $actionJSON);
    //             redirect('User/Usertype');
    //         }
    //     }
    //     else{
    //         $data = array(
    //             'type'=> $usertype,
    //             'updatedatetime'=> $updatedatetime
    //         );

    //         $this->db->where('idtbl_user_type', $recordID);
    //         $this->db->update('tbl_user_type', $data);

    //         $this->db->trans_complete();

    //         if ($this->db->trans_status() === TRUE) {
    //             $this->db->trans_commit();
                
    //             $actionObj=new stdClass();
    //             $actionObj->icon='fas fa-save';
    //             $actionObj->title='';
    //             $actionObj->message='Record Update Successfully';
    //             $actionObj->url='';
    //             $actionObj->target='_blank';
    //             $actionObj->type='primary';

    //             $actionJSON=json_encode($actionObj);
                
    //             $this->session->set_flashdata('msg', $actionJSON);
    //             redirect('User/Usertype');                
    //         } else {
    //             $this->db->trans_rollback();

    //             $actionObj=new stdClass();
    //             $actionObj->icon='fas fa-warning';
    //             $actionObj->title='';
    //             $actionObj->message='Record Error';
    //             $actionObj->url='';
    //             $actionObj->target='_blank';
    //             $actionObj->type='danger';

    //             $actionJSON=json_encode($actionObj);
                
    //             $this->session->set_flashdata('msg', $actionJSON);
    //             redirect('User/Usertype');
    //         }
    //     }
    // }
    // public function Usertypestatus($x, $y){
    //     $this->db->trans_begin();

    //     $userID=$_SESSION['userid'];
    //     $recordID=$x;
    //     $type=$y;

    //     if($type==1){
    //         $data = array(
    //             'status' => '1',
    //             'updatedatetime'=> $updatedatetime
    //         );

    //         $this->db->where('idtbl_user_type', $recordID);
    //         $this->db->update('tbl_user_type', $data);

    //         $this->db->trans_complete();

    //         if ($this->db->trans_status() === TRUE) {
    //             $this->db->trans_commit();
                
    //             $actionObj=new stdClass();
    //             $actionObj->icon='fas fa-check';
    //             $actionObj->title='';
    //             $actionObj->message='Record Activate Successfully';
    //             $actionObj->url='';
    //             $actionObj->target='_blank';
    //             $actionObj->type='success';

    //             $actionJSON=json_encode($actionObj);
                
    //             $this->session->set_flashdata('msg', $actionJSON);
    //             redirect('User/Usertype');                
    //         } else {
    //             $this->db->trans_rollback();

    //             $actionObj=new stdClass();
    //             $actionObj->icon='fas fa-warning';
    //             $actionObj->title='';
    //             $actionObj->message='Record Error';
    //             $actionObj->url='';
    //             $actionObj->target='_blank';
    //             $actionObj->type='danger';

    //             $actionJSON=json_encode($actionObj);
                
    //             $this->session->set_flashdata('msg', $actionJSON);
    //             redirect('User/Usertype');
    //         }
    //     }
    //     else if($type==2){
    //         $data = array(
    //             'status' => '2',
    //             'updatedatetime'=> $updatedatetime
    //         );

    //         $this->db->where('idtbl_user_type', $recordID);
    //         $this->db->update('tbl_user_type', $data);

    //         $this->db->trans_complete();

    //         if ($this->db->trans_status() === TRUE) {
    //             $this->db->trans_commit();
                
    //             $actionObj=new stdClass();
    //             $actionObj->icon='fas fa-times';
    //             $actionObj->title='';
    //             $actionObj->message='Record Deactivate Successfully';
    //             $actionObj->url='';
    //             $actionObj->target='_blank';
    //             $actionObj->type='warning';

    //             $actionJSON=json_encode($actionObj);
                
    //             $this->session->set_flashdata('msg', $actionJSON);
    //             redirect('User/Usertype');                
    //         } else {
    //             $this->db->trans_rollback();

    //             $actionObj=new stdClass();
    //             $actionObj->icon='fas fa-warning';
    //             $actionObj->title='';
    //             $actionObj->message='Record Error';
    //             $actionObj->url='';
    //             $actionObj->target='_blank';
    //             $actionObj->type='danger';

    //             $actionJSON=json_encode($actionObj);
                
    //             $this->session->set_flashdata('msg', $actionJSON);
    //             redirect('User/Usertype');
    //         }
    //     }
    //     else if($type==3){
    //         $data = array(
    //             'status' => '3',
    //             'updatedatetime'=> $updatedatetime
    //         );

    //         $this->db->where('idtbl_user_type', $recordID);
    //         $this->db->update('tbl_user_type', $data);

    //         $this->db->trans_complete();

    //         if ($this->db->trans_status() === TRUE) {
    //             $this->db->trans_commit();
                
    //             $actionObj=new stdClass();
    //             $actionObj->icon='fas fa-trash-alt';
    //             $actionObj->title='';
    //             $actionObj->message='Record Remove Successfully';
    //             $actionObj->url='';
    //             $actionObj->target='_blank';
    //             $actionObj->type='danger';

    //             $actionJSON=json_encode($actionObj);
                
    //             $this->session->set_flashdata('msg', $actionJSON);
    //             redirect('User/Usertype');                
    //         } else {
    //             $this->db->trans_rollback();

    //             $actionObj=new stdClass();
    //             $actionObj->icon='fas fa-warning';
    //             $actionObj->title='';
    //             $actionObj->message='Record Error';
    //             $actionObj->url='';
    //             $actionObj->target='_blank';
    //             $actionObj->type='danger';

    //             $actionJSON=json_encode($actionObj);
                
    //             $this->session->set_flashdata('msg', $actionJSON);
    //             redirect('User/Usertype');
    //         }
    //     }
    // }
    // public function Menulist(){
    //     $this->db->select('idtbl_menu_list, menu');
    //     $this->db->from('tbl_menu_list');
    //     $this->db->where('status', 1);

    //     return $respond=$this->db->get();
    // }
    // public function Useraccountmenu(){
    //     if($_SESSION['userid']==1){
    //         $this->db->select('idtbl_user, name');
    //         $this->db->from('tbl_user');
    //         $this->db->where('status', 1);
    //     }
    //     else{
    //         $this->db->select('idtbl_user, name');
    //         $this->db->from('tbl_user');
    //         $this->db->where('idtbl_user >', '1');
    //         $this->db->where('status', 1);
    //     }        

    //     return $respond=$this->db->get();
    // }
    // public function Userprivilegeinsertupdate(){
    //     $this->db->trans_begin();

    //     $userID=$_SESSION['userid'];

    //     $userlist=$this->input->post('userlist');
    //     $menulist=$this->input->post('menulist');
    //     if(!empty($this->input->post('addcheck'))){$addcheck=$this->input->post('addcheck');}else{$addcheck=0;}
    //     if(!empty($this->input->post('editcheck'))){$editcheck=$this->input->post('editcheck');}else{$editcheck=0;}
    //     if(!empty($this->input->post('statuscheck'))){$statuscheck=$this->input->post('statuscheck');}else{$statuscheck=0;}
    //     if(!empty($this->input->post('removecheck'))){$removecheck=$this->input->post('removecheck');}else{$removecheck=0;}
    //     if(!empty($this->input->post('approvecheck'))){$approvecheck=$this->input->post('approvecheck');}else{$approvecheck=0;}
    //     if(!empty($this->input->post('allfollowupcheck'))){$allfollowupcheck=$this->input->post('allfollowupcheck');}else{$allfollowupcheck=0;}

    //     $recordOption=$this->input->post('recordOption');
    //     if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}

    //     $updatedatetime=date('Y-m-d h:i:s');

    //     if($recordOption==1){
    //         foreach($menulist as $rowmenulist){
    //             $data = array(
    //                 'add'=>$addcheck,
    //                 'edit'=>$editcheck,
    //                 'statuschange'=>$statuscheck,
    //                 'remove'=>$removecheck,
    //                 'approve'=>$approvecheck,
    //                 'all_followup'=>$allfollowupcheck,
    //                 'access_status'=>'1',
    //                 'status'=>'1',
    //                 'insertdatetime'=>$updatedatetime,
    //                 'tbl_user_idtbl_user'=>$userlist,
    //                 'tbl_menu_list_idtbl_menu_list'=>$rowmenulist
    //             );

    //             $this->db->insert('tbl_user_privilege', $data);
    //         }

    //         $this->db->trans_complete();

    //         if ($this->db->trans_status() === TRUE) {
    //             $this->db->trans_commit();
                
    //             $actionObj=new stdClass();
    //             $actionObj->icon='fas fa-save';
    //             $actionObj->title='';
    //             $actionObj->message='Record Added Successfully';
    //             $actionObj->url='';
    //             $actionObj->target='_blank';
    //             $actionObj->type='success';

    //             $actionJSON=json_encode($actionObj);
                
    //             $this->session->set_flashdata('msg', $actionJSON);
    //             redirect('User/Userprivilege');                
    //         } else {
    //             $this->db->trans_rollback();

    //             $actionObj=new stdClass();
    //             $actionObj->icon='fas fa-warning';
    //             $actionObj->title='';
    //             $actionObj->message='Record Error';
    //             $actionObj->url='';
    //             $actionObj->target='_blank';
    //             $actionObj->type='danger';

    //             $actionJSON=json_encode($actionObj);
                
    //             $this->session->set_flashdata('msg', $actionJSON);
    //             redirect('User/Userprivilege');
    //         }
    //     }
    //     else{
    //         foreach($menulist as $rowmenulist){
    //             $data = array(
    //                 'add'=>$addcheck,
    //                 'edit'=>$editcheck,
    //                 'statuschange'=>$statuscheck,
    //                 'remove'=>$removecheck,
    //                 'approve'=>$approvecheck,
    //                 'all_followup'=>$allfollowupcheck,
    //                 'access_status'=>'1',
    //                 'updateuser'=>$userID,
    //                 'updatedatetime'=>$updatedatetime,
    //                 'tbl_user_idtbl_user'=>$userlist,
    //                 'tbl_menu_list_idtbl_menu_list'=>$rowmenulist
    //             );

    //             $this->db->where('idtbl_user_privilege', $recordID);
    //             $this->db->update('tbl_user_privilege', $data);
    //         }

    //         $this->db->trans_complete();

    //         if ($this->db->trans_status() === TRUE) {
    //             $this->db->trans_commit();
                
    //             $actionObj=new stdClass();
    //             $actionObj->icon='fas fa-save';
    //             $actionObj->title='';
    //             $actionObj->message='Record Update Successfully';
    //             $actionObj->url='';
    //             $actionObj->target='_blank';
    //             $actionObj->type='primary';

    //             $actionJSON=json_encode($actionObj);
                
    //             $this->session->set_flashdata('msg', $actionJSON);
    //             redirect('User/Userprivilege');                
    //         } else {
    //             $this->db->trans_rollback();

    //             $actionObj=new stdClass();
    //             $actionObj->icon='fas fa-warning';
    //             $actionObj->title='';
    //             $actionObj->message='Record Error';
    //             $actionObj->url='';
    //             $actionObj->target='_blank';
    //             $actionObj->type='danger';

    //             $actionJSON=json_encode($actionObj);
                
    //             $this->session->set_flashdata('msg', $actionJSON);
    //             redirect('User/Userprivilege');
    //         }
    //     }
    // }
    // public function Userprivilegeedit(){
    //     $recordID=$this->input->post('recordID');

    //     $this->db->select('*');
    //     $this->db->from('tbl_user_privilege');
    //     $this->db->where('idtbl_user_privilege', $recordID);
    //     $this->db->where('status', 1);

    //     $respond=$this->db->get();

    //     $menulistArray=array();
    //     $objmenulist=new stdClass();
    //     $objmenulist->menulistID=$respond->row(0)->tbl_menu_list_idtbl_menu_list;
    //     array_push($menulistArray, $objmenulist);

    //     $obj=new stdClass();
    //     $obj->id=$respond->row(0)->idtbl_user_privilege;
    //     $obj->add=$respond->row(0)->add;
    //     $obj->edit=$respond->row(0)->edit;
    //     $obj->statuschange=$respond->row(0)->statuschange;
    //     $obj->remove=$respond->row(0)->remove;
    //     $obj->approve=$respond->row(0)->approve;
    //     $obj->all_followup=$respond->row(0)->all_followup;
    //     $obj->user=$respond->row(0)->tbl_user_idtbl_user;
    //     $obj->menu=$menulistArray;

    //     echo json_encode($obj);
    // }
    // public function Userprivilegestatus($x, $y){
    //     $this->db->trans_begin();

    //     $userID=$_SESSION['userid'];
    //     $recordID=$x;
    //     $type=$y;
    //     $updatedatetime=date('Y-m-d h:i:s');

    //     if($type==1){
    //         $data = array(
    //             'status' => '1',
    //             'updateuser'=>$userID,
    //             'updatedatetime'=>$updatedatetime,
    //         );

    //         $this->db->where('idtbl_user_privilege', $recordID);
    //         $this->db->update('tbl_user_privilege', $data);

    //         $this->db->trans_complete();

    //         if ($this->db->trans_status() === TRUE) {
    //             $this->db->trans_commit();
                
    //             $actionObj=new stdClass();
    //             $actionObj->icon='fas fa-check';
    //             $actionObj->title='';
    //             $actionObj->message='Record Activate Successfully';
    //             $actionObj->url='';
    //             $actionObj->target='_blank';
    //             $actionObj->type='success';

    //             $actionJSON=json_encode($actionObj);
                
    //             $this->session->set_flashdata('msg', $actionJSON);
    //             redirect('User/Userprivilege');                
    //         } else {
    //             $this->db->trans_rollback();

    //             $actionObj=new stdClass();
    //             $actionObj->icon='fas fa-warning';
    //             $actionObj->title='';
    //             $actionObj->message='Record Error';
    //             $actionObj->url='';
    //             $actionObj->target='_blank';
    //             $actionObj->type='danger';

    //             $actionJSON=json_encode($actionObj);
                
    //             $this->session->set_flashdata('msg', $actionJSON);
    //             redirect('User/Userprivilege');
    //         }
    //     }
    //     else if($type==2){
    //         $data = array(
    //             'status' => '2',
    //             'updateuser'=>$userID,
    //             'updatedatetime'=>$updatedatetime,
    //         );

    //         $this->db->where('idtbl_user_privilege', $recordID);
    //         $this->db->update('tbl_user_privilege', $data);

    //         $this->db->trans_complete();

    //         if ($this->db->trans_status() === TRUE) {
    //             $this->db->trans_commit();
                
    //             $actionObj=new stdClass();
    //             $actionObj->icon='fas fa-times';
    //             $actionObj->title='';
    //             $actionObj->message='Record Deactivate Successfully';
    //             $actionObj->url='';
    //             $actionObj->target='_blank';
    //             $actionObj->type='warning';

    //             $actionJSON=json_encode($actionObj);
                
    //             $this->session->set_flashdata('msg', $actionJSON);
    //             redirect('User/Userprivilege');                
    //         } else {
    //             $this->db->trans_rollback();

    //             $actionObj=new stdClass();
    //             $actionObj->icon='fas fa-warning';
    //             $actionObj->title='';
    //             $actionObj->message='Record Error';
    //             $actionObj->url='';
    //             $actionObj->target='_blank';
    //             $actionObj->type='danger';

    //             $actionJSON=json_encode($actionObj);
                
    //             $this->session->set_flashdata('msg', $actionJSON);
    //             redirect('User/Userprivilege');
    //         }
    //     }
    //     else if($type==3){
    //         $data = array(
    //             'status' => '3',
    //             'updateuser'=>$userID,
    //             'updatedatetime'=>$updatedatetime,
    //         );

    //         $this->db->where('idtbl_user_privilege', $recordID);
    //         $this->db->update('tbl_user_privilege', $data);

    //         $this->db->trans_complete();

    //         if ($this->db->trans_status() === TRUE) {
    //             $this->db->trans_commit();
                
    //             $actionObj=new stdClass();
    //             $actionObj->icon='fas fa-trash-alt';
    //             $actionObj->title='';
    //             $actionObj->message='Record Remove Successfully';
    //             $actionObj->url='';
    //             $actionObj->target='_blank';
    //             $actionObj->type='danger';

    //             $actionJSON=json_encode($actionObj);
                
    //             $this->session->set_flashdata('msg', $actionJSON);
    //             redirect('User/Userprivilege');                
    //         } else {
    //             $this->db->trans_rollback();

    //             $actionObj=new stdClass();
    //             $actionObj->icon='fas fa-warning';
    //             $actionObj->title='';
    //             $actionObj->message='Record Error';
    //             $actionObj->url='';
    //             $actionObj->target='_blank';
    //             $actionObj->type='danger';

    //             $actionJSON=json_encode($actionObj);
                
    //             $this->session->set_flashdata('msg', $actionJSON);
    //             redirect('User/Userprivilege');
    //         }
    //     }
    // }
}