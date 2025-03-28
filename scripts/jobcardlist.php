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
    array( 'db' => '`u`.`jobcard_date`', 'dt' => 'jobcard_date', 'field' => 'jobcard_date' ),
    array( 'db' => '`u`.`vehicle_number`', 'dt' => 'vehicle_number', 'field' => 'vehicle_number' ),
    array( 'db' => '`u`.`inquiry_number`', 'dt' => 'inquiry_number', 'field' => 'inquiry_number' ),
    array( 'db' => '`u`.`complete_date`', 'dt' => 'complete_date', 'field' => 'complete_date' ),
	array( 'db' => '`u`.`job_card_number`', 'dt' => 'job_card_number', 'field' => 'job_card_number' ),
    array( 'db' => '`u`.`customer_id`', 'dt' => 'customer_id', 'field' => 'customer_id' ),
    array( 'db' => '`u`.`vehicle_model_id`', 'dt' => 'vehicle_model_id', 'field' => 'vehicle_model_id' ),
    array( 'db' => '`ua`.`customer_name`', 'dt' => 'customer_name', 'field' => 'customer_name' ),
    array( 'db' => '`ub`.`brand_name`', 'dt' => 'brand_name', 'field' => 'brand_name' ),
	array( 'db' => '`uc`.`model_name`', 'dt' => 'model_name', 'field' => 'model_name' ),

    array( 'db' => '`uc`.`price_category_id`', 'dt' => 'price_category_id', 'field' => 'price_category_id' ),

    array( 'db' => '`ud`.`payment_type`', 'dt' => 'payment_type', 'field' => 'payment_type' ),
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

$companyID = $_POST['company_branch_id'];
$customerID = $_POST['customer_id'];

$joinQuery = "FROM `tbl_jobcard` AS `u`
			JOIN `tbl_customer` AS `ua` ON `u`.`customer_id` = `ua`.`idtbl_customer`
            JOIN `tbl_vehicle_brand` AS `ub` ON `u`.`vehicle_brand_id` = `ub`.`idtbl_vehicle_brand`
            JOIN `tbl_vehicle_model` AS `uc` ON `u`.`vehicle_model_id` = `uc`.`idtbl_vehicle_model`
            JOIN `tbl_payment_method` AS `ud` ON `u`.`peyment_method` = `ud`.`idtbl_payment_method`";  

$extraWhere = "`u`.`status` IN (1, 2) AND `u`.`company_branch_id`='$companyID' AND `u`.`customer_id`='$customerID'";

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);