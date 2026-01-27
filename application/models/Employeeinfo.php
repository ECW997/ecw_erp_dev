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

    public function EmployeeCsvUpload(){
        $this->db->trans_begin();
        
        // Load URL helper for base_url()
        $this->load->helper('url');

        $userID = $_SESSION['userid'];
        $company_id = $_SESSION['company_id'];
        $branch_id = $_SESSION['branch_id'];
        $insertdatetime = date('Y-m-d H:i:s');

        // Configure file upload
        $config['upload_path'] = './uploads/temp/';
        $config['allowed_types'] = 'csv';
        $config['max_size'] = 5120; // 5MB
        $config['file_name'] = 'employee_csv_' . time() . '.csv';
        
        // Create upload directory if it doesn't exist
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0755, true);
        }

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('csv_file')) {
            $uploadError = $this->upload->display_errors();
            
            $actionObj = new stdClass();
            $actionObj->icon = 'fas fa-warning';
            $actionObj->title = '';
            $actionObj->message = 'CSV Upload Error: ' . $uploadError;
            $actionObj->url = '';
            $actionObj->target = '_blank';
            $actionObj->type = 'danger';

            $actionJSON = json_encode($actionObj);
            $this->session->set_flashdata('msg', $actionJSON);
            redirect('Employee');
            return;
        }

        $upload_data = $this->upload->data();
        $file_path = $upload_data['full_path'];

        // Read CSV file with UTF-8 BOM handling
        // Remove BOM if present
        $file_content = file_get_contents($file_path);
        if (substr($file_content, 0, 3) === "\xEF\xBB\xBF") {
            $file_content = substr($file_content, 3);
            file_put_contents($file_path, $file_content);
        }
        
        $handle = fopen($file_path, 'r');
        if ($handle === FALSE) {
            $actionObj = new stdClass();
            $actionObj->icon = 'fas fa-warning';
            $actionObj->title = '';
            $actionObj->message = 'Error reading CSV file';
            $actionObj->url = '';
            $actionObj->target = '_blank';
            $actionObj->type = 'danger';

            $actionJSON = json_encode($actionObj);
            $this->session->set_flashdata('msg', $actionJSON);
            redirect('Employee');
            return;
        }

        // Skip header row if exists
        $first_line = fgetcsv($handle);
        if ($first_line === FALSE) {
            fclose($handle);
            unlink($file_path);
            
            $actionObj = new stdClass();
            $actionObj->icon = 'fas fa-warning';
            $actionObj->title = '';
            $actionObj->message = 'CSV file is empty';
            $actionObj->url = '';
            $actionObj->target = '_blank';
            $actionObj->type = 'danger';

            $actionJSON = json_encode($actionObj);
            $this->session->set_flashdata('msg', $actionJSON);
            redirect('Employee');
            return;
        }

        // Check if first row is header (contains text like 'emp_no', 'emp_name')
        $is_header = false;
        if (isset($first_line[0]) && isset($first_line[1])) {
            $col1_lower = strtolower(trim($first_line[0]));
            $col2_lower = strtolower(trim($first_line[1]));
            if (strpos($col1_lower, 'emp') !== false || strpos($col1_lower, 'no') !== false || 
                strpos($col2_lower, 'emp') !== false || strpos($col2_lower, 'name') !== false) {
                $is_header = true;
            }
        }

        // If not header, rewind to beginning
        if (!$is_header) {
            rewind($handle);
        }

        $success_count = 0;
        $duplicate_count = 0;
        $error_count = 0;
        $duplicate_records = array(); // Store duplicate records with details
        $error_records = array(); // Store error records with details
        $success_records = array(); // Store successful records for SQL generation
        $row_number = 0;

        // Get existing employee numbers to check duplicates
        $this->db->select('emp_id, service_no');
        $this->db->from('employees');
        $existing_employees = $this->db->get()->result_array();
        $existing_emp_nos = array();
        foreach ($existing_employees as $emp) {
            if (!empty($emp['emp_id'])) {
                $existing_emp_nos[] = trim($emp['emp_id']);
            }
            if (!empty($emp['service_no'])) {
                $existing_emp_nos[] = trim($emp['service_no']);
            }
        }
        $existing_emp_nos = array_unique($existing_emp_nos);

        // Track emp_nos in current CSV to detect duplicates within file
        $csv_emp_nos = array();

        // Process CSV rows
        while (($row = fgetcsv($handle)) !== FALSE) {
            $row_number++;
            
            // Skip empty rows
            if (empty($row[0]) && empty($row[1])) {
                continue;
            }

            // Get emp_no and emp_name from first two columns
            $emp_no = isset($row[0]) ? trim($row[0]) : '';
            $emp_name = isset($row[1]) ? trim($row[1]) : '';

            // Validate emp_no (required field)
            if (empty($emp_no)) {
                $error_count++;
                $error_records[] = array(
                    'row' => $row_number,
                    'emp_no' => $emp_no,
                    'emp_name' => $emp_name,
                    'error' => 'Missing emp_no (required field)'
                );
                continue;
            }

            // Clean and sanitize emp_no (remove special characters except alphanumeric)
            $emp_no_clean = preg_replace('/[^a-zA-Z0-9]/', '', $emp_no);
            if (empty($emp_no_clean)) {
                $error_count++;
                $error_records[] = array(
                    'row' => $row_number,
                    'emp_no' => $emp_no,
                    'emp_name' => $emp_name,
                    'error' => 'Invalid emp_no (contains only special characters)'
                );
                continue;
            }

            // Handle special characters in emp_name - preserve them but sanitize
            $emp_name_clean = mb_convert_encoding($emp_name, 'UTF-8', 'UTF-8');
            // Remove null bytes and other dangerous characters
            $emp_name_clean = str_replace(["\0", "\r"], '', $emp_name_clean);
            // Trim whitespace
            $emp_name_clean = trim($emp_name_clean);
            
            // If emp_name is empty or null, assign '-' instead of treating as error
            if (empty($emp_name_clean)) {
                $emp_name_clean = '-';
            }

            // Check for duplicate in CSV file itself
            if (in_array($emp_no_clean, $csv_emp_nos)) {
                $duplicate_count++;
                $duplicate_records[] = array(
                    'row' => $row_number,
                    'emp_no' => $emp_no_clean,
                    'emp_name' => $emp_name_clean,
                    'reason' => 'Duplicate in CSV file'
                );
                continue;
            }

            // Check for duplicate in database
            if (in_array($emp_no_clean, $existing_emp_nos)) {
                $duplicate_count++;
                $duplicate_records[] = array(
                    'row' => $row_number,
                    'emp_no' => $emp_no_clean,
                    'emp_name' => $emp_name_clean,
                    'reason' => 'Already exists in database'
                );
                continue;
            }

            // Add to tracking array
            $csv_emp_nos[] = $emp_no_clean;

            // Prepare data according to the SQL structure provided
            $data = array(
                'emp_id' => $emp_no_clean,
                'emp_fp_id' => '0',
                'service_no' => $emp_no_clean,
                'emp_name_with_initial' => $emp_name_clean,
                'calling_name' => $emp_name_clean,
                'emp_first_name' => $emp_name_clean,
                'emp_fullname' => $emp_name_clean,
                'emp_status' => 1,
                'no_of_casual_leaves' => 0,
                'no_of_annual_leaves' => 0,
                'emp_branch' => $branch_id,
                'emp_shift' => '2',
                'emp_company' => $company_id,
                'deleted' => '0',
                'created_by' => $userID,
                'created_at' => $insertdatetime,
                'is_resigned' => '1',
                'resign_remark' => 'Resigned Before System Implementation'
            );

            // Insert employee
            if ($this->db->insert('employees', $data)) {
                $success_count++;
                // Store successful record data for SQL file generation
                $success_records[] = $data;
                // Add to existing list to prevent duplicates in same batch
                $existing_emp_nos[] = $emp_no_clean;
            } else {
                $error_count++;
                $db_error = $this->db->error();
                $error_records[] = array(
                    'row' => $row_number,
                    'emp_no' => $emp_no_clean,
                    'emp_name' => $emp_name_clean,
                    'error' => 'Database insert failed: ' . (isset($db_error['message']) ? $db_error['message'] : 'Unknown error')
                );
            }
        }

        fclose($handle);
        // Clean up uploaded file
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        // Create log file for duplicates and errors
        $log_file_name = 'employee_upload_log_' . date('Y-m-d_H-i-s') . '_' . time() . '.txt';
        $log_file_path = './uploads/temp/' . $log_file_name;
        $log_content = '';
        
        // Create SQL file for successful inserts (without id field)
        $sql_file_name = 'employee_insert_' . date('Y-m-d_H-i-s') . '_' . time() . '.sql';
        $sql_file_path = './uploads/temp/' . $sql_file_name;
        $sql_content = '';
        
        // Write log file header
        $log_content .= "=" . str_repeat("=", 80) . "=\n";
        $log_content .= "EMPLOYEE CSV UPLOAD LOG\n";
        $log_content .= "Upload Date: " . $insertdatetime . "\n";
        $log_content .= "=" . str_repeat("=", 80) . "=\n\n";
        
        $log_content .= "SUMMARY\n";
        $log_content .= str_repeat("-", 80) . "\n";
        $log_content .= "Total Success: {$success_count}\n";
        $log_content .= "Total Duplicates: {$duplicate_count}\n";
        $log_content .= "Total Errors: {$error_count}\n";
        $log_content .= "\n" . str_repeat("=", 80) . "\n\n";

        // Write duplicate records
        if (!empty($duplicate_records)) {
            $log_content .= "DUPLICATE RECORDS ({$duplicate_count})\n";
            $log_content .= str_repeat("-", 80) . "\n";
            foreach ($duplicate_records as $index => $dup) {
                $log_content .= sprintf(
                    "%d. Row: %-5s | Emp No: %-20s | Emp Name: %-30s | Reason: %s\n",
                    ($index + 1),
                    $dup['row'],
                    $dup['emp_no'],
                    $dup['emp_name'],
                    $dup['reason']
                );
            }
            $log_content .= "\n" . str_repeat("=", 80) . "\n\n";
        }

        // Write error records
        if (!empty($error_records)) {
            $log_content .= "ERROR RECORDS ({$error_count})\n";
            $log_content .= str_repeat("-", 80) . "\n";
            foreach ($error_records as $index => $err) {
                $log_content .= sprintf(
                    "%d. Row: %-5s | Emp No: %-20s | Emp Name: %-30s | Error: %s\n",
                    ($index + 1),
                    $err['row'],
                    $err['emp_no'],
                    $err['emp_name'],
                    $err['error']
                );
            }
            $log_content .= "\n" . str_repeat("=", 80) . "\n\n";
        }

        // Write log file
        if (($duplicate_count > 0 || $error_count > 0) && !empty($log_content)) {
            file_put_contents($log_file_path, $log_content);
        }
        
        // Generate SQL file with INSERT statements (without id field)
        if ($success_count > 0 && !empty($success_records)) {
            $sql_content .= "-- Employee CSV Upload SQL Insert Statements\n";
            $sql_content .= "-- Generated on: " . $insertdatetime . "\n";
            $sql_content .= "-- Total Records: {$success_count}\n";
            $sql_content .= "-- Note: id field is excluded (auto-increment)\n\n";
            
            // Start single INSERT statement
            $sql_content .= "INSERT INTO `employees` (`emp_id`, `emp_fp_id`, `service_no`, `emp_name_with_initial`, `calling_name`, `emp_first_name`, `emp_fullname`, `emp_status`, `no_of_casual_leaves`, `no_of_annual_leaves`, `emp_branch`, `emp_shift`, `emp_company`, `deleted`, `created_by`, `created_at`, `is_resigned`, `resign_remark`) VALUES\n";
            
            $values_array = array();
            foreach ($success_records as $index => $record) {
                // Escape values for SQL
                $emp_id = $this->db->escape($record['emp_id']);
                $emp_fp_id = $this->db->escape($record['emp_fp_id']);
                $service_no = $this->db->escape($record['service_no']);
                $emp_name_with_initial = $this->db->escape($record['emp_name_with_initial']);
                $calling_name = $this->db->escape($record['calling_name']);
                $emp_first_name = $this->db->escape($record['emp_first_name']);
                $emp_fullname = $this->db->escape($record['emp_fullname']);
                $emp_status = (int)$record['emp_status'];
                $no_of_casual_leaves = (int)$record['no_of_casual_leaves'];
                $no_of_annual_leaves = (int)$record['no_of_annual_leaves'];
                $emp_branch = $this->db->escape($record['emp_branch']);
                $emp_shift = $this->db->escape($record['emp_shift']);
                $emp_company = $this->db->escape($record['emp_company']);
                $deleted = $this->db->escape($record['deleted']);
                $created_by = (int)$record['created_by'];
                $created_at = $this->db->escape($record['created_at']);
                $is_resigned = (int)$record['is_resigned'];
                $resign_remark = $this->db->escape($record['resign_remark']);
                
                // Build VALUES row
                $values_row = "({$emp_id}, {$emp_fp_id}, {$service_no}, {$emp_name_with_initial}, {$calling_name}, {$emp_first_name}, {$emp_fullname}, {$emp_status}, {$no_of_casual_leaves}, {$no_of_annual_leaves}, {$emp_branch}, {$emp_shift}, {$emp_company}, {$deleted}, {$created_by}, {$created_at}, {$is_resigned}, {$resign_remark})";
                
                // Add comma if not the last record
                if ($index < count($success_records) - 1) {
                    $values_row .= ",";
                }
                
                $values_array[] = $values_row;
            }
            
            // Join all values with newlines for readability
            $sql_content .= implode("\n", $values_array) . ";\n";
            
            file_put_contents($sql_file_path, $sql_content);
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            
            // Prepare success message
            $message = "CSV Upload Completed. ";
            $message .= "Success: {$success_count}, ";
            $message .= "Duplicates: {$duplicate_count}, ";
            $message .= "Errors: {$error_count}";
            
            $download_links = array();
            
            // Add log file info if duplicates or errors exist
            if (($duplicate_count > 0 || $error_count > 0) && file_exists($log_file_path)) {
                $log_file_url = base_url('uploads/temp/' . $log_file_name);
                $download_links[] = "<a href='" . $log_file_url . "' target='_blank' class='text-white'><u>Download Log File</u></a>";
                // Store log file name in session for potential download
                $this->session->set_userdata('last_upload_log_file', $log_file_name);
            }
            
            // Add SQL file info if successful records exist
            if ($success_count > 0 && file_exists($sql_file_path)) {
                $sql_file_url = base_url('uploads/temp/' . $sql_file_name);
                $download_links[] = "<a href='" . $sql_file_url . "' target='_blank' class='text-white'><u>Download SQL File</u></a>";
                // Store SQL file name in session
                $this->session->set_userdata('last_upload_sql_file', $sql_file_name);
            }
            
            if (!empty($download_links)) {
                $message .= ". " . implode(" | ", $download_links);
            }

            $actionObj = new stdClass();
            $actionObj->icon = 'fas fa-check-circle';
            $actionObj->title = '';
            $actionObj->message = $message;
            $actionObj->url = '';
            $actionObj->target = '_blank';
            $actionObj->type = $error_count > 0 || $duplicate_count > 0 ? 'warning' : 'success';

            $actionJSON = json_encode($actionObj);
            $this->session->set_flashdata('msg', $actionJSON);
            redirect('Employee');
        } else {
            $this->db->trans_rollback();

            // Write transaction error to log if log file exists
            if (file_exists($log_file_path)) {
                $log_content .= "\nTRANSACTION ERROR: Database transaction failed\n";
                file_put_contents($log_file_path, $log_content, FILE_APPEND);
            }

            $error_links = array();
            if (file_exists($log_file_path)) {
                $error_links[] = '<a href="' . base_url('uploads/temp/' . $log_file_name) . '" target="_blank" class="text-white"><u>View Log File</u></a>';
            }
            if (file_exists($sql_file_path)) {
                $error_links[] = '<a href="' . base_url('uploads/temp/' . $sql_file_name) . '" target="_blank" class="text-white"><u>View SQL File</u></a>';
            }
            
            $actionObj = new stdClass();
            $actionObj->icon = 'fas fa-warning';
            $actionObj->title = '';
            $actionObj->message = 'CSV Upload Error: Transaction failed' . 
                (!empty($error_links) ? '. ' . implode(' | ', $error_links) : '');
            $actionObj->url = '';
            $actionObj->target = '_blank';
            $actionObj->type = 'danger';

            $actionJSON = json_encode($actionObj);
            $this->session->set_flashdata('msg', $actionJSON);
            redirect('Employee');
        }
    }
}