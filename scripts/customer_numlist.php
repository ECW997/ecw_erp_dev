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
$table = 'tbl_customer_inquiry';

// Table's primary key
$primaryKey = 'idtbl_customer_inquiry';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`u`.`idtbl_customer_inquiry`', 'dt' => 'idtbl_customer_inquiry', 'field' => 'idtbl_customer_inquiry' ),
    array( 'db' => '`u`.`inquiry_number`', 'dt' => 'inquiry_number', 'field' => 'inquiry_number' ),
    array( 'db' => '`u`.`inquerydate`', 'dt' => 'inquerydate', 'field' => 'inquerydate' ),
	array( 'db' => '`u`.`customer_name`', 'dt' => 'customer_name', 'field' => 'customer_name' ),
    array( 'db' => '`u`.`customer_number`', 'dt' => 'customer_number', 'field' => 'customer_number' ),
    array( 'db' => '`u`.`vehicle_number`', 'dt' => 'vehicle_number', 'field' => 'vehicle_number' ),
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


$joinQuery = "FROM `tbl_customer_inquiry` AS `u`
    
    LEFT JOIN `tbl_vehicle_brand` AS `ub` ON `u`.`vehicle_brand_id` = `ub`.`idtbl_vehicle_brand`
    LEFT JOIN `tbl_vehicle_model` AS `uc` ON `u`.`vehicle_model_id` = `uc`.`idtbl_vehicle_model`
    LEFT JOIN `tbl_vehicle_year` AS `ud` ON `u`.`vehicle_year_id` = `ud`.`idtbl_vehicle_year`
    LEFT JOIN `tbl_inquiry_source` AS `ue` ON `u`.`source_id` = `ue`.`idtbl_inquiry_source`
    LEFT JOIN `tbl_sales_person` AS `uf` ON `u`.`salesperson_id` = `uf`.`idtbl_sales_person`
    LEFT JOIN `tbl_coordinator` AS `ug` ON `u`.`coordinator_id` = `ug`.`idtbl_coordinator`
    ";

$extraWhere = "`u`.`status` IN (1, 2) AND `u`.`cancel_status` IN (0)  AND `u`.`company_branch_id`='$companyID' AND `u`.`transfer_status` IN (0)";


echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);