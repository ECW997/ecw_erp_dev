<?php

/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simply to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */

// DB table to use
$table = 'tbl_jobcard';

// Table's primary key
$primaryKey = 'idtbl_jobcard';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`u`.`idtbl_assign_emp_to_job`', 'dt' => 'idtbl_assign_emp_to_job', 'field' => 'idtbl_assign_emp_to_job' ),
    array( 'db' => '`jc`.`job_card_number`', 'dt' => 'job_card_number', 'field' => 'job_card_number' ),
    array( 'db' => '`u`.`tbl_job_card_id`', 'dt' => 'tbl_job_card_id', 'field' => 'tbl_job_card_id' ),
	array( 'db' => '`u`.`job_progress_status`', 'dt' => 'job_progress_status', 'field' => 'job_progress_status' ),
	array( 'db' => '`u`.`job_begin_datetime`', 'dt' => 'job_begin_datetime', 'field' => 'job_begin_datetime' ),
	array( 'db' => '`u`.`job_end_datetime`', 'dt' => 'job_end_datetime', 'field' => 'job_end_datetime' ),
	array( 'db' => '`u`.`job_done_datetime`', 'dt' => 'job_done_datetime', 'field' => 'job_done_datetime' ),
	array( 'db' => '`sp`.`calling_name`', 'dt' => 'calling_name', 'field' => 'calling_name' ),
	array( 'db' => '`u`.`status`', 'dt' => 'status', 'field' => 'status' ),
);

// SQL server connection information
require('config.php');
$sql_details = array(
	'user' => $db_username,
	'pass' => $db_password,
	'db'   => $db_name,
	'host' => $db_host
);

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */

// require( 'ssp.class.php' );
require('ssp.customized.class.php' );

$company_branch_id = $_POST['company_branch_id'];
$filter_value = $_POST['filter_value'];

$joinQuery = "FROM `tbl_jobcard` AS `jc`
    LEFT JOIN (SELECT * FROM `tbl_assign_emp_to_job` WHERE `status` IN (1, 2)) AS `u` ON `jc`.`idtbl_jobcard` = `u`.`tbl_job_card_id`
	LEFT JOIN `employees` AS `sp` ON `jc`.`supervisor_id` = `sp`.`id`";

    $extraWhere = "`jc`.`status` IN (1, 2) AND `jc`.`company_branch_id`='$company_branch_id'";
    
	if ($filter_value == '1') {
		$extraWhere .= " AND `jc`.`job_progress_status`='1'";
	}else if($filter_value == '2'){
		$extraWhere .= " AND `jc`.`job_progress_status`='2'";
	}
	else if($filter_value == '3') {
		$extraWhere .= " AND `jc`.`job_progress_status`='0'";
	}	

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);