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
$table = 'tbl_job_card_detail';

// Table's primary key
$primaryKey = 'idtbl_job_card_detail';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`u`.`idtbl_job_card_detail`', 'dt' => 'idtbl_job_card_detail', 'field' => 'idtbl_job_card_detail' ),
    array( 'db' => '`u`.`jobprice`', 'dt' => 'jobprice', 'field' => 'jobprice' ),
    array( 'db' => '`u`.`qty`', 'dt' => 'qty', 'field' => 'qty' ),
	array( 'db' => '`u`.`gross_amount`', 'dt' => 'gross_amount', 'field' => 'gross_amount' ),
    array( 'db' => '`u`.`discount_amount`', 'dt' => 'discount_amount', 'field' => 'discount_amount' ),
    array( 'db' => '`u`.`sub_total`', 'dt' => 'sub_total', 'field' => 'sub_total' ),
    array( 'db' => '`ua`.`main_job_category`', 'dt' => 'main_job_category', 'field' => 'main_job_category' ),
    array( 'db' => '`ub`.`sub_job_category`', 'dt' => 'sub_job_category', 'field' => 'sub_job_category' ),
	array( 'db' => '`uc`.`sales_job_name`', 'dt' => 'sales_job_name', 'field' => 'sales_job_name' ),
    array( 'db' => '`ud`.`material_type`', 'dt' => 'material_type', 'field' => 'material_type' ),
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

// $companyID = $_POST['company_branch_id'];
$jobcard_id = $_POST['jobcard_id'];

$joinQuery = "FROM `tbl_job_card_detail` AS `u`
            LEFT JOIN `tbl_main_job_category` AS `ua` ON `u`.`main_job_id` = `ua`.`idtbl_main_job_category`
            LEFT JOIN `tbl_sub_job_category` AS `ub` ON `u`.`sub_job_id` = `ub`.`idtbl_sub_job_category`
            LEFT JOIN `tbl_sales_jobs_details` AS `uc` ON `u`.`sales_job_details_id` = `uc`.`idtbl_sales_jobs_details`
            LEFT JOIN `tbl_material` AS `ud` ON `u`.`material_id` = `ud`.`idtbl_material`";

$extraWhere = "`u`.`status` IN (1, 2) AND `u`.`tbl_job_card_id`='$jobcard_id'";


echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);