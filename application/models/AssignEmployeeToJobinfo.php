<?php
class AssignEmployeeToJobinfo extends CI_Model{

    public function Getjobcard() {
        $this->db->select('idtbl_jobcard , job_card_number');
        $this->db->from('tbl_jobcard');
        $this->db->where('status', 1);
        $this->db->where('emp_assign_status', 0);

        return $respond=$this->db->get();
    }

    public function Getcompany() {
        $this->db->select('idtbl_company , company');
        $this->db->from('tbl_company');
        $this->db->where('status', 1);

        return $respond=$this->db->get();
    }

    public function department_list_sel2($company, $term, $page = 1) {
        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;

        $this->db->select('id as id, department_name as text');
        $this->db->from('departments');
        $this->db->like('department_name', $term);
        $this->db->where('company_id', $company);
        $this->db->order_by('department_name');
        $this->db->limit($resultCount, $offset);
        
        $query = $this->db->get();
        $departments = $query->result();

        $this->db->where('company_id', $company);
        $count = $this->db->count_all_results('departments');
    
        $endCount = $offset + $resultCount;
        $morePages = $endCount < $count;
    
        return array(
            "results" => $departments,
            "pagination" => array("more" => $morePages)
        );
    }

    public function supervisor_list_sel2($department, $term, $page = 1) {
        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;

        $this->db->select('id as id, calling_name as text');
        $this->db->from('employees');
        $this->db->like('calling_name', $term);
        $this->db->where('emp_department', $department);
        $this->db->where_in('job_title_id', [17, 82, 87, 88]);
        $this->db->order_by('calling_name');
        $this->db->limit($resultCount, $offset);
        
        $query = $this->db->get();
        $supervisors = $query->result();

        $this->db->where('emp_department', $department);
        $count = $this->db->count_all_results('employees');
    
        $endCount = $offset + $resultCount;
        $morePages = $endCount < $count;
    
        return array(
            "results" => $supervisors,
            "pagination" => array("more" => $morePages)
        );
    }

    public function AssignEmployeeToJobinsertupdate(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $comapnyID=$_SESSION['company_id'];
        $branchID = $_SESSION['branch_id'];
        $job_card_id=$this->input->post('job_card_id');
        $tableData=$this->input->post('tableData');

        $recordOption=$this->input->post('recordOption');
        if(!empty($this->input->post('recordID'))){$recordID=$this->input->post('recordID');}

        $insertdatetime=date('Y-m-d H:i:s');

        if($recordOption==1){
            $maindata = array(
                'tbl_job_card_id'=> $job_card_id, 
                'status'=> '1', 
                'insertdatetime'=> $insertdatetime, 
                'tbl_user_idtbl_user'=> $userID,
                'company_id'=> $comapnyID,
                'company_branch_id'=> $branchID,
                'company_id'=> $comapnyID,
                'company_branch_id'=> $branchID
            );
            $this->db->insert('tbl_assign_emp_to_job', $maindata);
            $insertID=$this->db->insert_id();

            foreach ($tableData as $rowtabledata) {
                 $job_detail_id=$rowtabledata['job_detail_id'];
                 $head_emp=$rowtabledata['head_emp'];
                 $emp_level='1';

                 $data = array(
                    'tbl_assign_emp_to_job_id'=> $insertID, 
                    'tbl_sales_job_details_id'=> $job_detail_id, 
                    'emp_id'=> $head_emp, 
                    'emp_level'=> $emp_level, 
                    'status'=> '1', 
                    'insertdatetime'=> $insertdatetime, 
                    'tbl_user_idtbl_user'=> $userID
                );
                $this->db->insert('tbl_assign_emp_to_job_detail', $data);


                if (!empty($rowtabledata['sub_worker1'])) {
                    $subworker = $rowtabledata['sub_worker1'];
                  
                    foreach ($subworker as $rowtabledata) {
                        $data2 = array(
                            'tbl_assign_emp_to_job_id'=> $insertID, 
                            'tbl_sales_job_details_id'=> $job_detail_id, 
                            'emp_id'=> $rowtabledata['emp_id'], 
                            'emp_level'=> $rowtabledata['emp_level'], 
                            'status'=> '1', 
                            'insertdatetime'=> $insertdatetime, 
                            'tbl_user_idtbl_user'=> $userID
                        );
                        $this->db->insert('tbl_assign_emp_to_job_detail', $data2);
                    }
                } 
            }

            // update job card assign status
            $jobcarddata = array(
                'emp_assign_status'=> '1'
            );
            $this->db->where('idtbl_jobcard', $job_card_id);
            $this->db->update('tbl_jobcard', $jobcarddata);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj = new stdClass();
                $actionObj->icon = 'fas fa-save';
                $actionObj->title = '';
                $actionObj->message = 'Allocate Successfully';
                $actionObj->url = '';
                $actionObj->target = '_blank';
                $actionObj->type = 'success';

                $actionJSON = json_encode($actionObj);

                $obj = new stdClass();
                $obj->status = 1;
                $obj->action = $actionJSON;

                echo json_encode($obj);
            } else {
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
            $this->db->select('tbl_assign_emp_to_job.insertdatetime,tbl_assign_emp_to_job.tbl_user_idtbl_user');
            $this->db->from('tbl_assign_emp_to_job');
            $this->db->where('tbl_assign_emp_to_job.idtbl_assign_emp_to_job', $recordID);
            $this->db->where('tbl_assign_emp_to_job.status', 1);
            $respond=$this->db->get();
     
            $main_insertdatetime=$respond->row(0)->insertdatetime;    
            $main_tbl_user_idtbl_user=$respond->row(0)->tbl_user_idtbl_user;

            $maindata = array(
                'updatedatetime'=> $insertdatetime, 
                'updateuser'=> $userID
            );
            $this->db->where('idtbl_assign_emp_to_job', $recordID);
            $this->db->update('tbl_assign_emp_to_job', $maindata);

            $this->db->where('tbl_assign_emp_to_job_id', $recordID);
            $this->db->delete('tbl_assign_emp_to_job_detail');

            foreach ($tableData as $rowtabledata) {
                $job_detail_id=$rowtabledata['job_detail_id'];
                $head_emp=$rowtabledata['head_emp'];
                $emp_level='1';

                $data = array(
                   'tbl_assign_emp_to_job_id'=> $recordID, 
                   'tbl_sales_job_details_id'=> $job_detail_id, 
                   'emp_id'=> $head_emp, 
                   'emp_level'=> $emp_level, 
                   'status'=> '1', 
                   'insertdatetime'=> $main_insertdatetime, 
                   'tbl_user_idtbl_user'=> $main_tbl_user_idtbl_user,
                   'updatedatetime'=> $insertdatetime, 
                   'updateuser'=> $userID
               );
               $this->db->insert('tbl_assign_emp_to_job_detail', $data);


               if (!empty($rowtabledata['sub_worker1'])) {
                   $subworker = $rowtabledata['sub_worker1'];
                 
                   foreach ($subworker as $rowtabledata) {
                       $data2 = array(
                           'tbl_assign_emp_to_job_id'=> $recordID, 
                           'tbl_sales_job_details_id'=> $job_detail_id, 
                           'emp_id'=> $rowtabledata['emp_id'], 
                           'emp_level'=> $rowtabledata['emp_level'], 
                           'status'=> '1', 
                           'insertdatetime'=> $main_insertdatetime, 
                           'tbl_user_idtbl_user'=> $main_tbl_user_idtbl_user,
                           'updatedatetime'=> $insertdatetime, 
                           'updateuser'=> $userID
                       );
                       $this->db->insert('tbl_assign_emp_to_job_detail', $data2);
                   }
               } 
               
            }
           
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

    public function AssignEmployeeToJobstatus($x, $y){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $recordID=$x;
        $type=$y;
        $updatedatetime=date('Y-m-d H:i:s');

         // update job card assign status
         $this->db->select('tbl_job_card_id');
         $this->db->from('tbl_assign_emp_to_job');
         $this->db->where('idtbl_assign_emp_to_job', $recordID);
         $this->db->where('status', 1);
         $respond=$this->db->get();
  
         $tbl_job_card_id = $respond->row(0)->tbl_job_card_id;

        if($type==1){
            $data = array(
                'status' => '1',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_assign_emp_to_job', $recordID);
            $this->db->update('tbl_assign_emp_to_job', $data);

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
                redirect('AssignEmployeeToJob');                
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
                redirect('AssignEmployeeToJob');
            }
        }
        else if($type==2){
            $data = array(
                'status' => '2',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_assign_emp_to_job', $recordID);
            $this->db->update('tbl_assign_emp_to_job', $data);

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
                redirect('AssignEmployeeToJob');                
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
                redirect('AssignEmployeeToJob');
            }
        }
        else if($type==3){
            $data = array(
                'status' => '3',
                'updateuser'=> $userID, 
                'updatedatetime'=> $updatedatetime
            );

            $this->db->where('idtbl_assign_emp_to_job', $recordID);
            $this->db->update('tbl_assign_emp_to_job', $data);

           
             $jobcarddata = array(
                'emp_assign_status'=> '0'
            );
            $this->db->where('idtbl_jobcard', $tbl_job_card_id);
            $this->db->update('tbl_jobcard', $jobcarddata);

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
                redirect('AssignEmployeeToJob');                
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
                redirect('AssignEmployeeToJob');
            }
        }
    }

    public function AssignEmployeeToJobedit(){
        $recordID=$this->input->post('recordID');

        $this->db->select('tbl_assign_emp_to_job.idtbl_assign_emp_to_job,tbl_assign_emp_to_job.tbl_job_card_id,tbl_jobcard.job_card_number');
        $this->db->from('tbl_assign_emp_to_job');
        $this->db->join('tbl_jobcard', 'tbl_jobcard.idtbl_jobcard = tbl_assign_emp_to_job.tbl_job_card_id','left');
        $this->db->where('tbl_assign_emp_to_job.idtbl_assign_emp_to_job', $recordID);
        $this->db->where('tbl_assign_emp_to_job.status', 1);

        $respond=$this->db->get();

        $obj=new stdClass();
        $obj->id=$respond->row(0)->idtbl_assign_emp_to_job;
        $obj->tbl_job_card_id=$respond->row(0)->tbl_job_card_id; 
        $obj->job_card_number=$respond->row(0)->job_card_number;     

        $table=$this->editTableDetail($respond->row(0)->tbl_job_card_id,$respond->row(0)->idtbl_assign_emp_to_job);
        
        $response = [
            'main_details' => $obj,
            'table' => $table
        ];
        echo json_encode($response);
    }

    private function editTableDetail($jobcard_id,$header_id){
        $company_id=$_SESSION['company_id'];
        $branch_id=$_SESSION['branch_id'];
        
        $this->db->select('tbl_assign_emp_to_job_detail.emp_id,tbl_assign_emp_to_job_detail.tbl_sales_job_details_id,tbl_sales_jobs_details.sales_job_name,tbl_assign_emp_to_job_detail.emp_level');
        $this->db->from('tbl_assign_emp_to_job_detail');
        $this->db->join('tbl_sales_jobs_details', 'tbl_sales_jobs_details.idtbl_sales_jobs_details = tbl_assign_emp_to_job_detail.tbl_sales_job_details_id','left');
        $this->db->where('tbl_assign_emp_to_job_detail.tbl_assign_emp_to_job_id', $header_id);
        $this->db->where('tbl_assign_emp_to_job_detail.status', 1);
        $respond_emp_detail = $this->db->get()->result();
        $emp_count = count($respond_emp_detail);

        $this->db->select('tbl_job_card_detail.sales_job_details_id,tbl_sales_jobs_details.sales_job_name');
        $this->db->from('tbl_jobcard');
        $this->db->join('tbl_job_card_detail', 'tbl_job_card_detail.tbl_job_card_id = tbl_jobcard.idtbl_jobcard');
        $this->db->join('tbl_sales_jobs_details', 'tbl_sales_jobs_details.idtbl_sales_jobs_details = tbl_job_card_detail.sales_job_details_id');
        $this->db->where('tbl_jobcard.idtbl_jobcard', $jobcard_id);
        $this->db->where('tbl_jobcard.status', 1);

        $responddetail = $this->db->get()->result();
        $count = count($responddetail);

        // get senior employees
        $this->db->select('employees.id, employees.emp_name_with_initial AS calling_name');
        $this->db->from('employees');
        $this->db->join('job_titles', 'job_titles.id = employees.job_title_id');
        // $this->db->join('job_titles', 'job_titles.id = employees.job_title_id');
        $this->db->where('employees.is_resigned','0');
        $this->db->where('employees.deleted','0');
        $this->db->where('employees.emp_branch',$branch_id);
        $this->db->where('job_titles.occupation_group_id','1');
        $respondemp = $this->db->get()->result();

        // get junior employees
        $this->db->select('employees.id, employees.emp_name_with_initial AS calling_name');
        $this->db->from('employees');
        $this->db->join('job_titles', 'job_titles.id = employees.job_title_id');
        $this->db->where('employees.is_resigned','0');
        $this->db->where('employees.deleted','0');
        $this->db->where('employees.emp_branch',$branch_id);
        $this->db->where('job_titles.occupation_group_id','2');
        $respondemp2 = $this->db->get()->result();

        $html='';
        $c=1;
        if ($count > 0) {
            foreach ($responddetail as $list) {
                $emp_cnt=0;
                $html.='
                <tr>
                    <td style="width:2%">'.$c.'</td>
                    <td style="width:50%">'.$list->sales_job_name.'</td>
                    <td class="d-none job_detail_id">'.$list->sales_job_details_id.'</td>
                    <td style="width:23.5%">
                        <select class="form-control form-control-sm customselect2 head_emp" name="head_emp" required>
                        <option value="">Select</option>';
                        foreach ($respond_emp_detail as $allocatelist) {
                            $head_emp = (($allocatelist->tbl_sales_job_details_id == $list->sales_job_details_id) && ($allocatelist->emp_level =='1') ? $allocatelist->emp_id : 0);
                            if(($allocatelist->tbl_sales_job_details_id == $list->sales_job_details_id) && ($allocatelist->emp_level =='1')){
                                foreach ($respondemp as $emplist) {
                                    $selected = ($emplist->id == $head_emp) ? 'selected' : '';
                                    $html .= '<option value="' . $emplist->id . '" '.$selected.'>' . $emplist->calling_name . '</option>';
                                }
                            }
                            $allocatelist->tbl_sales_job_details_id == $list->sales_job_details_id ?  $emp_cnt++ : $emp_cnt=$emp_cnt+0;
                        }
                       
                       $html .= '</select>
                    </td>
                    <td style="width:1%">
                      <i class="fa fa-arrow-right text-center text-danger"></i>
                    </td>
                    <td style="width:23.5%">
                     <div class="worker-container">';
                        foreach ($respond_emp_detail as $allocatelist) {
                            if($allocatelist->tbl_sales_job_details_id == $list->sales_job_details_id){
                                for ($level_cnt = (2); ($level_cnt <= $emp_cnt); $level_cnt++) {
                                    if($level_cnt > 1){
                                        $sub_worker = (($allocatelist->emp_level == $level_cnt) ? $allocatelist->emp_id : 0);
                                        if($sub_worker){
                                            $html .= '<select class="form-control form-control-sm mb-2 customselect2 sub_worker1" name="sub_worker1[]">
                                                <option value="">Select</option>';
                                                foreach ($respondemp2 as $emplist) {
                                                    $selected = ($emplist->id == $sub_worker) ? 'selected' : '';
                                                    $html .= '<option value="' . $emplist->id . '" '.$selected.'>' . $emplist->calling_name . '</option>';
                                                }
                                            $html .= ' </select>';
                                        }
                                    }
                                    }
                                    if($emp_cnt<=1){
                                        $html .= '<select class="form-control form-control-sm mb-2 customselect2 sub_worker1" name="sub_worker1[]">
                                        <option value="">Select</option>';
                                        foreach ($respondemp2 as $emplist) {
                                            $html .= '<option value="' . $emplist->id . '">' . $emplist->calling_name . '</option>';
                                        }
                                        $html .= ' </select>';
                                }
                                
                            }
                        }
                       $html .= '</div>
                        <div style="text-align: right; margin-top: 5px;">
                            <button type="button" class="btn btn-info btn-sm addSubWorker" onclick="addSubWorker(this)">
                                <i class="fa fa-plus"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm removeSubWorker" onclick="removeSubWorker(this)">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                ';
                $c++;
            }
        } else {
            $html.='
            <tr><td colspan="3" class="text-center">No data found.</td></tr>
            ';
        }

        return $html;
    }

    public function getJobList(){
        $company_id=$_SESSION['company_id'];
        $branch_id=$_SESSION['branch_id'];

        $recordID=$this->input->post('recordID');

        $this->db->select('tbl_job_card_detail.sales_job_details_id,tbl_sales_jobs_details.sales_job_name');
        $this->db->from('tbl_jobcard');
        $this->db->join('tbl_job_card_detail', 'tbl_job_card_detail.tbl_job_card_id = tbl_jobcard.idtbl_jobcard');
        $this->db->join('tbl_sales_jobs_details', 'tbl_sales_jobs_details.idtbl_sales_jobs_details = tbl_job_card_detail.sales_job_details_id');
        $this->db->where('tbl_jobcard.idtbl_jobcard', $recordID);
        $this->db->where('tbl_jobcard.status', 1);
        $responddetail = $this->db->get()->result();
        $count = count($responddetail);


        // get senior employees
        $this->db->select('employees.id, employees.emp_name_with_initial AS calling_name');
        $this->db->from('employees');
        $this->db->join('job_titles', 'job_titles.id = employees.job_title_id');
        // $this->db->join('job_titles', 'job_titles.id = employees.job_title_id');
        $this->db->where('employees.is_resigned','0');
        $this->db->where('employees.deleted','0');
        $this->db->where('employees.emp_branch',$branch_id);
        $this->db->where('job_titles.occupation_group_id','1');
        $respondemp = $this->db->get()->result();

        // get junior employees
        $this->db->select('employees.id, employees.emp_name_with_initial AS calling_name');
        $this->db->from('employees');
        $this->db->join('job_titles', 'job_titles.id = employees.job_title_id');
        $this->db->where('employees.is_resigned','0');
        $this->db->where('employees.deleted','0');
        $this->db->where('employees.emp_branch',$branch_id);
        $this->db->where('job_titles.occupation_group_id','2');
        $respondemp2 = $this->db->get()->result();

        $html='';
        $c=1;
        if ($count > 0) {
            foreach ($responddetail as $list) {
                $html.='
                <tr>
                    <td style="width:2%">'.$c.'</td>
                    <td style="width:50%">'.$list->sales_job_name.'</td>
                    <td class="d-none job_detail_id">'.$list->sales_job_details_id.'</td>
                    <td style="width:23.5%">
                        <select class="form-control form-control-sm customselect2 head_emp" name="head_emp" required>
                        <option value="">Select</option>';
                        foreach ($respondemp as $emplist) {
                            $html .= '<option value="' . $emplist->id . '">' . $emplist->calling_name . '</option>';
                        }
                       $html .= ' </select>
                    </td>
                    <td style="width:1%">
                      <i class="fa fa-arrow-right text-center text-danger"></i>
                    </td>
                    <td style="width:23.5%">
                     <div class="worker-container">
                            <select class="form-control form-control-sm mb-2 customselect2 sub_worker1" name="sub_worker1[]">
                            <option value="">Select</option>';
                            foreach ($respondemp2 as $emplist) {
                                $html .= '<option value="' . $emplist->id . '">' . $emplist->calling_name . '</option>';
                            }
                            $html .= ' </select>
                       </div>
                        <div style="text-align: right; margin-top: 5px;">
                            <button type="button" class="btn btn-info btn-sm addSubWorker" onclick="addSubWorker(this)">
                                <i class="fa fa-plus"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm removeSubWorker" onclick="removeSubWorker(this)">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                ';
                $c++;
            }
        } else {
            $html.='
            <tr><td colspan="3" class="text-center">No data found.</td></tr>
            ';
        }

        echo $html;
    }

    public function AssignEmployeeToJobView(){
        $recordID=$this->input->post('recordID');
        $company_id=$_SESSION['company_id'];
        $branch_id=$_SESSION['branch_id'];

        $this->db->select('tbl_assign_emp_to_job.idtbl_assign_emp_to_job,tbl_assign_emp_to_job.tbl_job_card_id,tbl_jobcard.job_card_number');
        $this->db->from('tbl_assign_emp_to_job');
        $this->db->join('tbl_jobcard', 'tbl_jobcard.idtbl_jobcard = tbl_assign_emp_to_job.tbl_job_card_id','left');
        $this->db->where('tbl_assign_emp_to_job.idtbl_assign_emp_to_job', $recordID);
        $this->db->where('tbl_assign_emp_to_job.status', 1);
        $respond=$this->db->get();
        $tbl_job_card_id=$respond->row(0)->tbl_job_card_id; 

        $this->db->select('tbl_assign_emp_to_job_detail.emp_id,tbl_assign_emp_to_job_detail.tbl_sales_job_details_id,tbl_sales_jobs_details.sales_job_name,tbl_assign_emp_to_job_detail.emp_level');
        $this->db->from('tbl_assign_emp_to_job_detail');
        $this->db->join('tbl_sales_jobs_details', 'tbl_sales_jobs_details.idtbl_sales_jobs_details = tbl_assign_emp_to_job_detail.tbl_sales_job_details_id','left');
        $this->db->where('tbl_assign_emp_to_job_detail.tbl_assign_emp_to_job_id', $recordID);
        $this->db->where('tbl_assign_emp_to_job_detail.status', 1);
        $respond_emp_detail = $this->db->get()->result();
        $emp_count = count($respond_emp_detail);

        $this->db->select('tbl_job_card_detail.sales_job_details_id,tbl_sales_jobs_details.sales_job_name');
        $this->db->from('tbl_jobcard');
        $this->db->join('tbl_job_card_detail', 'tbl_job_card_detail.tbl_job_card_id = tbl_jobcard.idtbl_jobcard');
        $this->db->join('tbl_sales_jobs_details', 'tbl_sales_jobs_details.idtbl_sales_jobs_details = tbl_job_card_detail.sales_job_details_id');
        $this->db->where('tbl_jobcard.idtbl_jobcard', $tbl_job_card_id);
        $this->db->where('tbl_jobcard.status', 1);

        $responddetail = $this->db->get()->result();
        $count = count($responddetail);

        // get senior employees
        $this->db->select('employees.id, employees.emp_name_with_initial AS calling_name');
        $this->db->from('employees');
        $this->db->join('job_titles', 'job_titles.id = employees.job_title_id');
        // $this->db->join('job_titles', 'job_titles.id = employees.job_title_id');
        $this->db->where('employees.is_resigned','0');
        $this->db->where('employees.deleted','0');
        $this->db->where('employees.emp_branch',$branch_id);
        $this->db->where('job_titles.occupation_group_id','1');
        $respondemp = $this->db->get()->result();

        // get junior employees
        $this->db->select('employees.id, employees.emp_name_with_initial AS calling_name');
        $this->db->from('employees');
        $this->db->join('job_titles', 'job_titles.id = employees.job_title_id');
        $this->db->where('employees.is_resigned','0');
        $this->db->where('employees.deleted','0');
        $this->db->where('employees.emp_branch',$branch_id);
        $this->db->where('job_titles.occupation_group_id','2');
        $respondemp2 = $this->db->get()->result();

        $html='';
        $c=1;
        if ($count > 0) {
            foreach ($responddetail as $list) {
                $emp_cnt=0;
                $html.='
                <tr>
                    <td style="width:2%">'.$c.'</td>
                    <td style="width:50%">'.$list->sales_job_name.'</td>
                    <td class="d-none job_detail_id">'.$list->sales_job_details_id.'</td>
                    <td style="width:23.5%">
                        <select class="form-control form-control-sm customselect2 view_head_emp" name="view_head_emp" readonly style="pointer-events:none;">
                        <option value="">Select</option>';
                        foreach ($respond_emp_detail as $allocatelist) {
                            $head_emp = (($allocatelist->tbl_sales_job_details_id == $list->sales_job_details_id) && ($allocatelist->emp_level =='1') ? $allocatelist->emp_id : 0);
                            if(($allocatelist->tbl_sales_job_details_id == $list->sales_job_details_id) && ($allocatelist->emp_level =='1')){
                                foreach ($respondemp as $emplist) {
                                    $selected = ($emplist->id == $head_emp) ? 'selected' : '';
                                    $html .= '<option value="' . $emplist->id . '" '.$selected.'>' . $emplist->calling_name . '</option>';
                                }
                            }
                            $allocatelist->tbl_sales_job_details_id == $list->sales_job_details_id ?  $emp_cnt++ : $emp_cnt=$emp_cnt+0;
                        }
                       
                       $html .= '</select>
                    </td>
                    <td style="width:1%">
                      <i class="fa fa-arrow-right text-center text-danger"></i>
                    </td>
                    <td style="width:23.5%">
                     <div class="worker-container">';
                        foreach ($respond_emp_detail as $allocatelist) {
                            if($allocatelist->tbl_sales_job_details_id == $list->sales_job_details_id){
                                for ($level_cnt = (2); ($level_cnt <= $emp_cnt); $level_cnt++) {
                                    if($level_cnt > 1){
                                        $sub_worker = (($allocatelist->emp_level == $level_cnt) ? $allocatelist->emp_id : 0);
                                        if($sub_worker){
                                            $html .= '<select class="form-control form-control-sm mb-2 customselect2 view_sub_worker1" name="view_sub_worker1[]" readonly style="pointer-events:none;">
                                                <option value="">Select</option>';
                                                foreach ($respondemp2 as $emplist) {
                                                    $selected = ($emplist->id == $sub_worker) ? 'selected' : '';
                                                    $html .= '<option value="' . $emplist->id . '" '.$selected.'>' . $emplist->calling_name . '</option>';
                                                }
                                            $html .= ' </select>';
                                        }
                                    }
                                    }
                                    if($emp_cnt<=1){
                                        $html .= '<select class="form-control form-control-sm mb-2 customselect2 view_sub_worker1" name="view_sub_worker1[]" readonly style="pointer-events:none;">
                                        <option value="">Select</option>';
                                        foreach ($respondemp2 as $emplist) {
                                            $html .= '<option value="' . $emplist->id . '">' . $emplist->calling_name . '</option>';
                                        }
                                        $html .= ' </select>';
                                } 
                            }
                        }
                       $html .= '</div>
                    </td>
                </tr>
                ';
                $c++;
            }
        } else {
            $html.='
            <tr><td colspan="3" class="text-center">No data found.</td></tr>
            ';
        }

        echo $html;
    }

    public function insertupdateSupervisor(){
        $this->db->trans_begin();

        $userID=$_SESSION['userid'];
        $comapnyID=$_SESSION['company_id'];
        $branchID = $_SESSION['branch_id'];

        $jobcard_id=$this->input->post('s_jobcard_id');
        $compnay=$this->input->post('s_compnay');
        $department=$this->input->post('s_department');
        $supervisor=$this->input->post('s_supervisor');

        $recordOption=$this->input->post('s_recordOption');

        $insertdatetime=date('Y-m-d H:i:s');

        if($recordOption==1){
            $maindata = array(
                'supervisor_assign_status'=> '1', 
                'supervisor_id'=> $supervisor, 
                'supervisor_assign_user'=>  $userID, 
                'supervisor_assign_datetime'=> $insertdatetime,
            );

            $this->db->where('idtbl_jobcard', $jobcard_id);
            $this->db->update('tbl_jobcard', $maindata);

            $this->db->trans_complete();

            if ($this->db->trans_status() === TRUE) {
                $this->db->trans_commit();
                
                $actionObj = new stdClass();
                $actionObj->icon = 'fas fa-save';
                $actionObj->title = '';
                $actionObj->message = 'Assign Successfully';
                $actionObj->url = '';
                $actionObj->target = '_blank';
                $actionObj->type = 'success';

                $actionJSON = json_encode($actionObj);

                $obj = new stdClass();
                $obj->status = 1;
                $obj->action = $actionJSON;

                echo json_encode($obj);
            } else {
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
            $maindata = array(
                'supervisor_id'=> $supervisor, 
                'updatedatetime'=> $insertdatetime, 
                'updateuser'=> $userID
            );
            $this->db->where('idtbl_jobcard', $jobcard_id);
            $this->db->update('tbl_jobcard', $maindata);
           
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

    public function AssignSupervisorToJobstatus(){
        $this->db->trans_begin();

        $recordID=$this->input->post('recordID');
        $maindata = array(
            'supervisor_assign_status'=> '0', 
            'supervisor_id'=> null, 
            'supervisor_assign_user'=>  null, 
            'supervisor_assign_datetime'=> null,
        );

        $this->db->where('idtbl_jobcard', $recordID);
        $this->db->update('tbl_jobcard', $maindata);

        $this->db->trans_complete();

        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            
            $actionObj = new stdClass();
            $actionObj->icon = 'fas fa-save';
            $actionObj->title = '';
            $actionObj->message = 'Delete Successfully';
            $actionObj->url = '';
            $actionObj->target = '_blank';
            $actionObj->type = 'success';

            $actionJSON = json_encode($actionObj);

            $obj = new stdClass();
            $obj->status = 1;
            $obj->action = $actionJSON;

            echo json_encode($obj);
        } else {
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

}