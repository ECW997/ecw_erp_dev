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
$table = 'tbl_stitching_design_price_details';

// Table's primary key
$primaryKey = 'idtbl_stitching_design_price_details';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`u`.`idtbl_stitching_design_price_details`', 'dt' => 'idtbl_stitching_design_price_details', 'field' => 'idtbl_stitching_design_price_details' ),
	array( 'db' => '`u`.`price`', 'dt' => 'price', 'field' => 'price' ),
	array( 'db' => '`u`.`vehicle_type`', 'dt' => 'vehicle_type', 'field' => 'vehicle_type' ),
	array( 'db' => '`st`.`stitching_code`', 'dt' => 'stitching_code', 'field' => 'stitching_code' ),
	array( 'db' => '`pc`.`price_category_type`', 'dt' => 'price_category_type', 'field' => 'price_category_type' ),
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

$main_table_id = $_POST['main_table_id'];

$joinQuery = "FROM `tbl_stitching_design_price_details` AS `u`
LEFT JOIN `tbl_stitching_design` AS `st` ON `u`.`tbl_stitching_design_id`=`st`.`idtbl_stitching_design`
LEFT JOIN `tbl_price_category_type` AS `pc` ON `u`.`price_category_type_id`=`pc`.`idtbl_price_category_type`";

$extraWhere = "`u`.`status` IN (1, 2) AND `u`.`tbl_stitching_design_id`='$main_table_id'";

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);