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
$table = 'tbl_customer_vehicle_detail';

// Table's primary key
$primaryKey = 'idtbl_customer_vehicle_detail';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`u`.`idtbl_customer_vehicle_detail`', 'dt' => 'idtbl_customer_vehicle_detail', 'field' => 'idtbl_customer_vehicle_detail' ),
	array( 'db' => '`u`.`customer_vehicle_number`', 'dt' => 'customer_vehicle_number', 'field' => 'customer_vehicle_number' ),
    array( 'db' => '`u`.`vehicle_brand_id`', 'dt' => 'vehicle_brand_id', 'field' => 'vehicle_brand_id' ),
    array( 'db' => '`u`.`vehicle_model_id`', 'dt' => 'vehicle_model_id', 'field' => 'vehicle_model_id' ),
    array( 'db' => '`ua`.`brand_name`', 'dt' => 'brand_name', 'field' => 'brand_name' ),
    array( 'db' => '`ub`.`model_name`', 'dt' => 'model_name', 'field' => 'model_name' ),
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

$customerID = $_POST['tbl_customer_idtbl_customer'];

$joinQuery = "FROM `tbl_customer_vehicle_detail` AS `u`
              LEFT JOIN `tbl_vehicle_brand` AS `ua` ON `u`.`vehicle_brand_id` = `ua`.`idtbl_vehicle_brand`
              LEFT JOIN `tbl_vehicle_model` AS `ub` ON `u`.`vehicle_model_id` = `ub`.`idtbl_vehicle_model`";

$extraWhere = "`u`.`status` IN (1, 2) AND `u`.`tbl_customer_idtbl_customer`='$customerID'";

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);