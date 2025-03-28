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
$table = 'tbl_vehicle_model';

// Table's primary key
$primaryKey = 'idtbl_vehicle_model';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`u`.`idtbl_vehicle_model`', 'dt' => 'idtbl_vehicle_model', 'field' => 'idtbl_vehicle_model' ),
    array( 'db' => '`u`.`model_name`', 'dt' => 'model_name', 'field' => 'model_name' ),
    array( 'db' => '`ua`.`brand_name`', 'dt' => 'brand_name', 'field' => 'brand_name' ),
    array( 'db' => '`ub`.`generation_name`', 'dt' => 'generation_name', 'field' => 'generation_name' ),
    array( 'db' => '`uc`.`series_name`', 'dt' => 'series_name', 'field' => 'series_name' ),
	array( 'db' => '`ud`.`year_name`', 'dt' => 'year_name', 'field' => 'year_name' ),
    array( 'db' => '`ue`.`vehicle_type_name`', 'dt' => 'vehicle_type_name', 'field' => 'vehicle_type_name' ),
    array( 'db' => '`uf`.`price_category_type`', 'dt' => 'price_category_type', 'field' => 'price_category_type' ),
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

$joinQuery = "FROM `tbl_vehicle_model` AS `u`
    LEFT JOIN `tbl_vehicle_brand` AS `ua` ON `u`.`vehicle_brand_id` = `ua`.`idtbl_vehicle_brand`
    LEFT JOIN `tbl_vehicle_generation` AS `ub` ON `u`.`vehicle_generation_id` = `ub`.`idtbl_vehicle_generation`
    LEFT JOIN `tbl_vehicle_series` AS `uc` ON `u`.`vehicle_series_id` = `uc`.`idtbl_vehicle_series`
    LEFT JOIN `tbl_vehicle_type` AS `ue` ON `u`.`vehicle_type_id` = `ue`.`idtbl_vehicle_type`
     LEFT JOIN `tbl_price_category_type` AS `uf` ON `u`.`price_category_id` = `uf`.`idtbl_price_category_type`
    LEFT JOIN `tbl_vehicle_year` AS `ud` ON `u`.`vehicle_year_id` = `ud`.`idtbl_vehicle_year`";


$extraWhere = "`u`.`status` IN (1, 2)";

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);