<?php
/**
*@if(CheckPermission('crm', 'read'))
**/
	function rs_to_kv($result, $eopt='-1', $etxt='Select'){
		$kv = isset($eopt)?array($eopt=>$etxt):array();
		
		foreach($result as $r){
			$kv[$r->form_key] = $r->form_val;
		}
		
		return $kv;
	}
	
	function get_company_list(){
		$CI = get_instance();
		$CI->db->where('status', 1);
		$CI->db->select('idtbl_company, company, code');
		$CI->db->select('idtbl_company AS form_key, company AS form_val');
		$CI->db->from('tbl_company');
		return $CI->db->get()->result();
	}

	function get_all_company_branch_list(){
		$CI = get_instance();
		$CI->db->where('status', 1);
		//$CI->db->where('tbl_company_idtbl_company', $companyid);
		$CI->db->select('idtbl_company_branch, branch, code, tbl_company_idtbl_company');
		$CI->db->select('idtbl_company_branch AS form_key, branch AS form_val');
		$CI->db->from('tbl_company_branch');
		return $CI->db->get()->result();
	}
	
	function get_company_branch_list($companyid){
		$CI = get_instance();
		$CI->db->where('status', 1);
		$CI->db->where('tbl_company_idtbl_company', $companyid);
		$CI->db->select('idtbl_company_branch, branch, code, tbl_company_idtbl_company');
		$CI->db->select('idtbl_company_branch AS form_key, branch AS form_val');
		$CI->db->from('tbl_company_branch');
		echo json_encode($CI->db->get()->result());
	}
	
	function get_supplier_list(){
		$CI = get_instance();
		$CI->db->where('status', 1);
		$CI->db->select('idtbl_supplier, suppliername AS `suppliername`,  supcode AS supcode, contactone AS contactone');
		$CI->db->select('idtbl_supplier AS form_key, suppliername AS form_val');
		$CI->db->from('tbl_supplier');
		return $CI->db->get()->result();
	}

	function get_customer_list(){
		$CI = get_instance();
		$CI->db->where('status', 1);
		$CI->db->select('idtbl_customer, customer AS customer');
		$CI->db->select('idtbl_customer AS form_key, customer AS form_val');
		$CI->db->from('tbl_customer');
		return $CI->db->get()->result();
	}
	
	function get_child_account_list($companyid, $branchid, $json_enc=true){
		$CI = get_instance();
		$CI->db->where('tbl_account_allocation.companybank', $companyid);
        $CI->db->where('tbl_account_allocation.branchcompanybank', $branchid);
        $CI->db->where('tbl_account_detail.status', 1);
        $CI->db->where('tbl_account_allocation.status', 1);
        $CI->db->where('tbl_account_allocation.tbl_account_detail_idtbl_account_detail is NOT NULL', NULL, FALSE);
		$CI->db->select('`tbl_account_detail`.`idtbl_account_detail`, `tbl_account_detail`.`accountno`, `tbl_account_detail`.`accountname`');
		$CI->db->select('tbl_account_detail.idtbl_account_detail AS form_key, tbl_account_detail.accountname AS form_val');
		$CI->db->from('tbl_account_detail');
		$CI->db->join('tbl_account_allocation', 'tbl_account_allocation.tbl_account_detail_idtbl_account_detail = tbl_account_detail.idtbl_account_detail', 'left');
		
		if($json_enc){
			echo json_encode($CI->db->get()->result());  
		}else{
			return $CI->db->get()->result();
		}
	}
	
	function get_bank_list(){
		$CI = get_instance();
		//$CI->db->where('status', 0);
		$CI->db->select('idtbl_bank, bankname, code');
		
		$CI->db->from('tbl_bank');
		return $CI->db->get()->result();
	}
	
	function get_bank_branch_list(){
		$CI = get_instance();
		//$CI->db->where('status', 0);
		$CI->db->select('idtbl_bank_branch, branchname, code, tbl_bank_idtbl_bank');
		
		$CI->db->from('tbl_bank_branch');
		return $CI->db->get()->result();
	}

	function get_bank_account_list(){
		// $sql = "select drv_acc.idtbl_account, drv_acc.accountname, drv_doc.tbl_bank_idtbl_bank, drv_doc.tbl_bank_branch_idtbl_bank_branch as idtbl_bank_branch from (select distinct tbl_account_idtbl_account, tbl_bank_idtbl_bank, tbl_bank_branch_idtbl_bank_branch from tbl_cheque_info where status=1) as drv_doc inner join (select idtbl_account, accountname from tbl_account where tbl_account_type_idtbl_account_type=1) as drv_acc on drv_doc.tbl_account_idtbl_account=drv_acc.idtbl_account";
		$sql = "select drv_acc.idtbl_account, drv_acc.accountname, drv_doc.tbl_bank_idtbl_bank, drv_doc.tbl_bank_branch_idtbl_bank_branch as idtbl_bank_branch from (select distinct tbl_account_idtbl_account, tbl_bank_idtbl_bank, tbl_bank_branch_idtbl_bank_branch from tbl_cheque_info where status=1) as drv_doc inner join (select idtbl_account, accountname from tbl_account where 1=1) as drv_acc on drv_doc.tbl_account_idtbl_account=drv_acc.idtbl_account";
		$CI = get_instance();
		return $CI->db->query($sql)->result();
	}
	
	function get_cheque_list(){
		$CI = get_instance();
		//$CI->db->where('status', 0);
		$CI->db->select('idtbl_cheque_issue, chedate, chequeno, narration, tbl_cheque_info_idtbl_cheque_info');
		$CI->db->select('0 as cheque_amt'); // column-to-be-added-if-required
		$CI->db->from('tbl_cheque_issue');
		return $CI->db->get()->result();
	}
	
	function get_account_period($company, $company_branch){
		$CI = get_instance();
		//$CI->db->where('status', 0);
		$CI->db->where('tbl_master.tbl_company_idtbl_company', $company);
		$CI->db->where('tbl_master.tbl_company_branch_idtbl_company_branch', $company_branch);
		$CI->db->select('tbl_master.idtbl_master, tbl_master.tbl_finacial_year_idtbl_finacial_year, tbl_master.tbl_finacial_month_idtbl_finacial_month');
		$CI->db->select('tbl_finacial_year.year, tbl_finacial_year.desc');
		$CI->db->select('tbl_finacial_month.month, tbl_finacial_month.monthname');
		$CI->db->join('tbl_finacial_year', 'tbl_master.tbl_finacial_year_idtbl_finacial_year=tbl_finacial_year.idtbl_finacial_year', 'left');
		$CI->db->join('tbl_finacial_month', 'tbl_master.tbl_finacial_month_idtbl_finacial_month=tbl_finacial_month.idtbl_finacial_month', 'left');
		$CI->db->from('tbl_master');
		$CI->db->order_by('tbl_master.idtbl_master', 'DESC');
		$CI->db->limit(1);
		return $CI->db->get()->row(0);
	}

	function get_all_account_periods($company='', $company_branch=''){
		$CI = get_instance();
		$CI->db->where('tbl_finacial_year.actstatus', 1);
		$CI->db->where('tbl_finacial_month.activestatus', 1);
		
		if($company!=''){
			$CI->db->where('tbl_master.tbl_company_idtbl_company', $company);
		}
		if($company_branch!=''){
			$CI->db->where('tbl_master.tbl_company_branch_idtbl_company_branch', $company_branch);
		}
		
		$CI->db->select('tbl_master.idtbl_master, tbl_master.tbl_finacial_year_idtbl_finacial_year, tbl_master.tbl_finacial_month_idtbl_finacial_month');
		
		$CI->db->select('tbl_master.tbl_company_idtbl_company, tbl_master.tbl_company_branch_idtbl_company_branch');
		
		$CI->db->select('tbl_finacial_year.year, tbl_finacial_year.desc');
		$CI->db->select('tbl_finacial_month.month, tbl_finacial_month.monthname');
		$CI->db->join('tbl_finacial_year', 'tbl_master.tbl_finacial_year_idtbl_finacial_year=tbl_finacial_year.idtbl_finacial_year', 'inner');
		$CI->db->join('tbl_finacial_month', 'tbl_master.tbl_finacial_month_idtbl_finacial_month=tbl_finacial_month.idtbl_finacial_month', 'inner');
		$CI->db->from('tbl_master');
		$CI->db->order_by('tbl_master.idtbl_master', 'ASC');
		
		return $CI->db->get()->result();
	}
	
	function tr_batch_num($prefix, $branch){
		$CI = get_instance();
		//start the transaction
		$CI->db->trans_begin();
		$flag = true;
		
		
		/*
		begin-process-to-generate-new-gatepasscode
		*/
		$new_ref = ''; //NULL; // purposely-breaking-gatepass-creation-process-without-valid-refnum
		
		$res_callback = 0; // get-updated-result-of-ref-num
		
		/*
		locking-and-generating-with-update-
		assuming-the-most-frequent-operation
		*/
		$CI->db->where('idtbl_batch_num_register', $prefix);
		$CI->db->where('tbl_company_branch_idtbl_company_branch', $branch);
		$CI->db->where('acq_locked', '0');
		$CI->db->set('ref_no', 'ref_no+1', FALSE);
		
		$update = $CI->db->update('tbl_batch_num_register', array('acq_locked'=>1));
		
		$affectedRowCnt = $CI->db->affected_rows();
		
		if($affectedRowCnt!=1){
			/*
			fallback-generating-with-insert-where-update-is-refused-
			leaving-primary-key-to-prevent-duplicates-as-less-frequent-incident
			
			*/
			$insert = $CI->db->insert('tbl_batch_num_register', 
										array('idtbl_batch_num_register'=>$prefix, 
									'tbl_company_branch_idtbl_company_branch'=>$branch)
									);
			$affectedRowCnt = $CI->db->affected_rows();
			$res_callback = 1; // set-newly-inserted-value
		}	
		
		if($affectedRowCnt==1){
			if($res_callback==0){
				/*read-the-locked-and-generated-number*/
				$resQuery = $CI->db->get_where('tbl_batch_num_register', 
												 array('idtbl_batch_num_register'=>$prefix,
													   'tbl_company_branch_idtbl_company_branch'=>$branch,
													   'acq_locked'=>1)
										)->row();
				
				//var_dump($resQuery);
				
				if(!empty($resQuery)){
					$res_callback = $resQuery->ref_no;
				}
				
				
				/*release-the-locked-number*/
				$CI->db->where('idtbl_batch_num_register', $prefix);
				$CI->db->where('tbl_company_branch_idtbl_company_branch', $branch);
				$CI->db->where('acq_locked', '1');
				$ResultOut = $CI->db->update('tbl_batch_num_register', array('acq_locked'=>0));
				
				if(!$ResultOut){
					$flag = false;
				}
			}
			
			if($res_callback>0){
				$str_callback = '000000'.$res_callback;
				$new_ref = $prefix.substr($str_callback, strlen($str_callback)-6, strlen($str_callback));
			}
		}else{
			$flag = false;
		}
		
		/*end-process-new-ref-number*/
		
		$CI->db->trans_complete();
		//check if transaction status TRUE or FALSE
		if(($CI->db->trans_status()===FALSE)||($flag==FALSE)){
			//if something went wrong, rollback everything
			$CI->db->trans_rollback();
			$importmsg = 'Transaction error';//.$detailData['order_qty']
			$msgclass = 'bg-warning text-white';
		}else{
			//if everything went right, commit the data to the database
			$CI->db->trans_commit();
			$msgclass = 'bg-success text-white';
		}
		
		return $new_ref;
	}
	
	function pay_prefix($companyid, $branchid){
		$CI = get_instance();
		$CI->db->where('tbl_master.status', 1);
		$CI->db->where('tbl_master.tbl_company_idtbl_company', $companyid);
		$CI->db->where('tbl_master.tbl_company_branch_idtbl_company_branch', $branchid);
		$CI->db->select('tbl_finacial_year.year, tbl_finacial_month.month');
		$CI->db->from('tbl_master');
		$CI->db->join('tbl_finacial_year', 'tbl_finacial_year.idtbl_finacial_year = tbl_master.tbl_finacial_year_idtbl_finacial_year', 'left');
		$CI->db->join('tbl_finacial_month', 'tbl_finacial_month.idtbl_finacial_month = tbl_master.tbl_finacial_month_idtbl_finacial_month', 'left');
		$respond=$CI->db->get();

		$date = DateTime::createFromFormat('!m', $respond->row(0)->month);
		$monthName = $date->format('M');
		return 'AP'.$respond->row(0)->year.strtoupper($monthName);
	}

	function rece_prefix($companyid, $branchid){
		$CI = get_instance();
		$CI->db->where('tbl_master.status', 1);
		$CI->db->where('tbl_master.tbl_company_idtbl_company', $companyid);
		$CI->db->where('tbl_master.tbl_company_branch_idtbl_company_branch', $branchid);
		$CI->db->select('tbl_finacial_year.year, tbl_finacial_month.month');
		$CI->db->from('tbl_master');
		$CI->db->join('tbl_finacial_year', 'tbl_finacial_year.idtbl_finacial_year = tbl_master.tbl_finacial_year_idtbl_finacial_year', 'left');
		$CI->db->join('tbl_finacial_month', 'tbl_finacial_month.idtbl_finacial_month = tbl_master.tbl_finacial_month_idtbl_finacial_month', 'left');
		$respond=$CI->db->get();

		$date = DateTime::createFromFormat('!m', $respond->row(0)->month);
		$monthName = $date->format('M');
		return 'AR'.$respond->row(0)->year.strtoupper($monthName);
	}

	function trans_prefix($companyid, $branchid){
		$CI = get_instance();
		$CI->db->where('tbl_master.status', 1);
		$CI->db->where('tbl_master.tbl_company_idtbl_company', $companyid);
		$CI->db->where('tbl_master.tbl_company_branch_idtbl_company_branch', $branchid);
		$CI->db->select('tbl_finacial_year.year, tbl_finacial_month.month');
		$CI->db->from('tbl_master');
		$CI->db->join('tbl_finacial_year', 'tbl_finacial_year.idtbl_finacial_year = tbl_master.tbl_finacial_year_idtbl_finacial_year', 'left');
		$CI->db->join('tbl_finacial_month', 'tbl_finacial_month.idtbl_finacial_month = tbl_master.tbl_finacial_month_idtbl_finacial_month', 'left');
		$respond=$CI->db->get();

		$date = DateTime::createFromFormat('!m', $respond->row(0)->month);
		$monthName = $date->format('M');
		return 'AT'.$respond->row(0)->year.strtoupper($monthName);
	}

	function petty_prefix($companyid, $branchid){
		$CI = get_instance();
		$CI->db->where('tbl_master.status', 1);
		$CI->db->where('tbl_master.tbl_company_idtbl_company', $companyid);
		$CI->db->where('tbl_master.tbl_company_branch_idtbl_company_branch', $branchid);
		$CI->db->select('tbl_finacial_year.year, tbl_finacial_month.month');
		$CI->db->from('tbl_master');
		$CI->db->join('tbl_finacial_year', 'tbl_finacial_year.idtbl_finacial_year = tbl_master.tbl_finacial_year_idtbl_finacial_year', 'left');
		$CI->db->join('tbl_finacial_month', 'tbl_finacial_month.idtbl_finacial_month = tbl_master.tbl_finacial_month_idtbl_finacial_month', 'left');
		$respond=$CI->db->get();

		$date = DateTime::createFromFormat('!m', $respond->row(0)->month);
		$monthName = $date->format('M');
		return 'PV'.$respond->row(0)->year.strtoupper($monthName);
	}

	function reimburse_prefix($companyid, $branchid){
		$CI = get_instance();
		$CI->db->where('tbl_master.status', 1);
		$CI->db->where('tbl_master.tbl_company_idtbl_company', $companyid);
		$CI->db->where('tbl_master.tbl_company_branch_idtbl_company_branch', $branchid);
		$CI->db->select('tbl_finacial_year.year, tbl_finacial_month.month');
		$CI->db->from('tbl_master');
		$CI->db->join('tbl_finacial_year', 'tbl_finacial_year.idtbl_finacial_year = tbl_master.tbl_finacial_year_idtbl_finacial_year', 'left');
		$CI->db->join('tbl_finacial_month', 'tbl_finacial_month.idtbl_finacial_month = tbl_master.tbl_finacial_month_idtbl_finacial_month', 'left');
		$respond=$CI->db->get();

		$date = DateTime::createFromFormat('!m', $respond->row(0)->month);
		$monthName = $date->format('M');
		return 'RE'.$respond->row(0)->year.strtoupper($monthName);
	}
	
	function get_chart_account_acco_child_account($companyid, $branchid, $detailaccount){
		$CI = get_instance();
		$CI->db->where('tbl_account_allocation.companybank', $companyid);
        $CI->db->where('tbl_account_allocation.branchcompanybank', $branchid);
        $CI->db->where('tbl_account_detail.idtbl_account_detail', $detailaccount);
        $CI->db->where('tbl_account.status', 1);
        $CI->db->where('tbl_account_allocation.status', 1);
        $CI->db->where('tbl_account_allocation.tbl_account_idtbl_account is NOT NULL', NULL, FALSE);
		$CI->db->select('`tbl_account`.`idtbl_account`, `tbl_account`.`accountno`, `tbl_account`.`accountname`');
		$CI->db->from('tbl_account');
		$CI->db->join('tbl_account_detail', 'tbl_account_detail.tbl_account_idtbl_account = tbl_account.idtbl_account', 'left');
		$CI->db->join('tbl_account_allocation', 'tbl_account_allocation.tbl_account_idtbl_account = tbl_account.idtbl_account', 'left');
		
		return $CI->db->get();
	}

	function get_petty_account_list($companyid, $branchid){
		$CI = get_instance();
		$CI->db->where('tbl_account_allocation.companybank', $companyid);
        $CI->db->where('tbl_account_allocation.branchcompanybank', $branchid);
        // $CI->db->where('tbl_account.tbl_account_type_idtbl_account_type', 3);
        $CI->db->where('tbl_account.status', 1);
        $CI->db->where('tbl_account_allocation.status', 1);
        $CI->db->where('tbl_account_allocation.tbl_account_idtbl_account is NOT NULL', NULL, FALSE);
		$CI->db->select('`tbl_account`.`idtbl_account`, `tbl_account`.`accountno`, `tbl_account`.`accountname`');
		$CI->db->from('tbl_account');
		$CI->db->join('tbl_account_allocation', 'tbl_account_allocation.tbl_account_idtbl_account = tbl_account.idtbl_account', 'left');
		
		echo json_encode($CI->db->get()->result());  
	}

	function get_bank_acount_list($companyid, $branchid){
		$CI = get_instance();
		$CI->db->where('tbl_account_allocation.companybank', $companyid);
        $CI->db->where('tbl_account_allocation.branchcompanybank', $branchid);
        // $CI->db->where('tbl_account.tbl_account_type_idtbl_account_type', 1);
        $CI->db->where('tbl_account.status', 1);
        $CI->db->where('tbl_account_allocation.status', 1);
        $CI->db->where('tbl_account_allocation.tbl_account_idtbl_account is NOT NULL', NULL, FALSE);
		$CI->db->select('`tbl_account`.`idtbl_account`, `tbl_account`.`accountno`, `tbl_account`.`accountname`');
		$CI->db->from('tbl_account');
		$CI->db->join('tbl_account_allocation', 'tbl_account_allocation.tbl_account_idtbl_account = tbl_account.idtbl_account', 'left');
		
		echo json_encode($CI->db->get()->result());  
	}

	function get_customer_search_list($searchTerm){
        if(!isset($searchTerm)){
            $CI = get_instance();
			$CI->db->where('status', 1);
			$CI->db->select('idtbl_customer, name AS customer');
			$CI->db->from('tbl_customer');
			$CI->db->limit(5);
			$respond=$CI->db->get();
        }
        else{            
            if(!empty($searchTerm)){
                $CI = get_instance();
				$CI->db->where('status', 1);
				$CI->db->select('idtbl_customer, name AS customer');
				$CI->db->from('tbl_customer');
				$CI->db->like('name', $searchTerm, 'after'); 
				$respond=$CI->db->get();
            }
            else{
                $CI = get_instance();
				$CI->db->where('status', 1);
				$CI->db->select('idtbl_customer, name AS customer');
				$CI->db->from('tbl_customer');
				$CI->db->limit(5);
				$respond=$CI->db->get();             
            }
        }
        
        $data=array();
        
        foreach ($respond->result() as $row) {
            $data[]=array("id"=>$row->idtbl_customer, "text"=>$row->customer);
        }
        
        echo json_encode($data);
	}

	function receiv_prefix($companyid, $branchid){
		$CI = get_instance();
		$CI->db->where('tbl_master.status', 1);
		$CI->db->where('tbl_master.tbl_company_idtbl_company', $companyid);
		$CI->db->where('tbl_master.tbl_company_branch_idtbl_company_branch', $branchid);
		$CI->db->select('tbl_finacial_year.year, tbl_finacial_month.month');
		$CI->db->from('tbl_master');
		$CI->db->join('tbl_finacial_year', 'tbl_finacial_year.idtbl_finacial_year = tbl_master.tbl_finacial_year_idtbl_finacial_year', 'left');
		$CI->db->join('tbl_finacial_month', 'tbl_finacial_month.idtbl_finacial_month = tbl_master.tbl_finacial_month_idtbl_finacial_month', 'left');
		$respond=$CI->db->get();

		$date = DateTime::createFromFormat('!m', $respond->row(0)->month);
		$monthName = $date->format('M');
		return 'RE'.$respond->row(0)->year.strtoupper($monthName);
	}

	function bankrec_prefix($acc_year, $acc_month){
		$CI = get_instance();
		$CI->db->where('tbl_master.status', 1);
		$CI->db->where('tbl_master.tbl_finacial_year_idtbl_finacial_year', $acc_year);
		$CI->db->where('tbl_master.tbl_finacial_month_idtbl_finacial_month', $acc_month);
		$CI->db->from('tbl_master');
		$CI->db->join('tbl_finacial_year', 'tbl_finacial_year.idtbl_finacial_year = tbl_master.tbl_finacial_year_idtbl_finacial_year', 'left');
		$CI->db->join('tbl_finacial_month', 'tbl_finacial_month.idtbl_finacial_month = tbl_master.tbl_finacial_month_idtbl_finacial_month', 'left');
		$respond=$CI->db->get();

		$date = DateTime::createFromFormat('!m', $respond->row(0)->month);
		$monthName = $date->format('M');
		return 'BR'.$respond->row(0)->year.strtoupper($monthName);
	}

	function get_chart_acount_list($companyid, $branchid){
		$CI = get_instance();
		$CI->db->where('tbl_account_allocation.companybank', $companyid);
        $CI->db->where('tbl_account_allocation.branchcompanybank', $branchid);
        // $CI->db->where('tbl_account.tbl_account_type_idtbl_account_type', 2);
        $CI->db->where('tbl_account.status', 1);
        $CI->db->where('tbl_account_allocation.status', 1);
        $CI->db->where('tbl_account_allocation.tbl_account_idtbl_account is NOT NULL', NULL, FALSE);
		$CI->db->select('`tbl_account`.`idtbl_account`, `tbl_account`.`accountno`, `tbl_account`.`accountname`');
		$CI->db->from('tbl_account');
		$CI->db->join('tbl_account_allocation', 'tbl_account_allocation.tbl_account_idtbl_account = tbl_account.idtbl_account', 'left');
		
		echo json_encode($CI->db->get()->result());  
	}

	function journal_prefix($companyid, $branchid){
		$CI = get_instance();
		$CI->db->where('tbl_master.status', 1);
		$CI->db->where('tbl_master.tbl_company_idtbl_company', $companyid);
		$CI->db->where('tbl_master.tbl_company_branch_idtbl_company_branch', $branchid);
		$CI->db->select('tbl_finacial_year.year, tbl_finacial_month.month');
		$CI->db->from('tbl_master');
		$CI->db->join('tbl_finacial_year', 'tbl_finacial_year.idtbl_finacial_year = tbl_master.tbl_finacial_year_idtbl_finacial_year', 'left');
		$CI->db->join('tbl_finacial_month', 'tbl_finacial_month.idtbl_finacial_month = tbl_master.tbl_finacial_month_idtbl_finacial_month', 'left');
		$respond=$CI->db->get();

		$date = DateTime::createFromFormat('!m', $respond->row(0)->month);
		$monthName = $date->format('M');
		return 'JE'.$respond->row(0)->year.strtoupper($monthName);
	}
?>
