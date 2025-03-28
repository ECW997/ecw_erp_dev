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
	array( 'db' => '`u`.`idtbl_jobcard`', 'dt' => 'idtbl_jobcard', 'field' => 'idtbl_jobcard' ),
    array( 'db' => '`u`.`job_card_number`', 'dt' => 'job_card_number', 'field' => 'job_card_number' ),
	array( 'db' => '`u`.`supervisor_assign_datetime`', 'dt' => 'supervisor_assign_datetime', 'field' => 'supervisor_assign_datetime' ),
	array( 'db' => '`u`.`job_card_number`', 'dt' => 'job_card_number', 'field' => 'job_card_number' ),
    array( 'db' => '`sp`.`emp_id`', 'dt' => 'emp_id', 'field' => 'emp_id' ),
	array( 'db' => '`sp`.`calling_name`', 'dt' => 'calling_name', 'field' => 'calling_name' ),
	array( 'db' => '`dp`.`department_name`', 'dt' => 'department_name', 'field' => 'department_name' ),
	array( 'db' => '`u`.`emp_assign_status`', 'dt' => 'emp_assign_status', 'field' => 'emp_assign_status' ),
	array( 'db' => '`u`.`status`', 'dt' => 'status', 'field' => 'status' ),
	array( 'db' => '`ae`.`idtbl_assign_emp_to_job`', 'dt' => 'idtbl_assign_emp_to_job', 'field' => 'idtbl_assign_emp_to_job' ),
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

$joinQuery = "FROM `tbl_jobcard` AS `u`
    LEFT JOIN `employees` AS `sp` ON `u`.`supervisor_id` = `sp`.`id`
	LEFT JOIN `departments` AS `dp` ON `sp`.`emp_department` = `dp`.`id`
	LEFT JOIN (SELECT `idtbl_assign_emp_to_job`,`tbl_job_card_id` FROM  `tbl_assign_emp_to_job` WHERE status='1') AS `ae` ON `ae`.`tbl_job_card_id` = `u`.`idtbl_jobcard`
    ";

    $extraWhere = "`u`.`status` IN (1, 2) AND `u`.`supervisor_assign_status`='1' AND `u`.`company_branch_id`='$company_branch_id'";
    
  
echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);