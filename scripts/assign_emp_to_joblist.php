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
$table = 'tbl_assign_emp_to_job';

// Table's primary key
$primaryKey = 'idtbl_assign_emp_to_job';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`u`.`idtbl_assign_emp_to_job`', 'dt' => 'idtbl_assign_emp_to_job', 'field' => 'idtbl_assign_emp_to_job' ),
    array( 'db' => '`jc`.`job_card_number`', 'dt' => 'job_card_number', 'field' => 'job_card_number' ),
    array( 'db' => '`u`.`tbl_job_card_id`', 'dt' => 'tbl_job_card_id', 'field' => 'tbl_job_card_id' ),
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

$joinQuery = "FROM `tbl_assign_emp_to_job` AS `u`
    LEFT JOIN `tbl_jobcard` AS `jc` ON `u`.`tbl_job_card_id` = `jc`.`idtbl_jobcard`
    ";

    $extraWhere = "`u`.`status` IN (1, 2) AND `u`.`company_branch_id`='$company_branch_id'";
    
  
echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);