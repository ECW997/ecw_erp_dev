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
$table = 'tbl_vehicle';

// Table's primary key
$primaryKey = 'idtbl_vehicle';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`u`.`idtbl_vehicle`', 'dt' => 'idtbl_vehicle', 'field' => 'idtbl_vehicle' ),
	array( 'db' => '`u`.`vehicle_reg_no`', 'dt' => 'vehicle_reg_no', 'field' => 'vehicle_reg_no' ),
	array( 'db' => '`u`.`engine_no`', 'dt' => 'engine_no', 'field' => 'engine_no' ),
	array( 'db' => '`u`.`chassis_no`', 'dt' => 'chassis_no', 'field' => 'chassis_no' ),
	array( 'db' => '`u`.`mileage`', 'dt' => 'mileage', 'field' => 'mileage' ),
	array( 'db' => '`ua`.`vehicle_type`', 'dt' => 'vehicle_type', 'field' => 'vehicle_type' ),
	array( 'db' => '`ub`.`vehicle_model`', 'dt' => 'vehicle_model', 'field' => 'vehicle_model' ),
    array( 'db' => '`uc`.`vehicle_brand`', 'dt' => 'vehicle_brand', 'field' => 'vehicle_brand' ),
	array( 'db' => '`ud`.`next_renew_date`', 'dt' => 'next_renew_date', 'field' => 'next_renew_date' ),
	array( 'db' => '`u`.`status`', 'dt' => 'status', 'field' => 'status' )

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




$joinQuery = "FROM `tbl_vehicle` AS `u` JOIN `tbl_vehicle_type` AS `ua` ON (`ua`.`idtbl_vehicle_type` = `u`.`tbl_vehicle_type_idtbl_vehicle_type`) 
                JOIN `tbl_vehicle_model` AS `ub` ON (`ub`.`idtbl_vehicle_model` = `u`.`tbl_vehicle_model_idtbl_vehicle_model`)
                JOIN `tbl_vehicle_brand` AS `uc` ON (`uc`.`idtbl_vehicle_brand` = `u`.`tbl_vehicle_brand_idtbl_vehicle_brand`)
				LEFT JOIN `tbl_renew_details` AS `ud` ON (`ud`.`tbl_vehicle_idtbl_vehicle` = `u`.`idtbl_vehicle`)";


				// $joinQuery = "FROM `tbl_vehicle` AS `u` JOIN `tbl_vehicle_type` AS `ua` ON (`ua`.`idtbl_vehicle_type` = `u`.`tbl_vehicle_type_idtbl_vehicle_type`) 
                // JOIN `tbl_vehicle_model` AS `ub` ON (`ub`.`idtbl_vehicle_model` = `u`.`tbl_vehicle_model_idtbl_vehicle_model`)
                // JOIN `tbl_vehicle_brand` AS `uc` ON (`uc`.`idtbl_vehicle_brand` = `u`.`tbl_vehicle_brand_idtbl_vehicle_brand`)
				// JOIN `tbl_renew_details` AS `ud` ON (`ud`.`tbl_vehicle_idtbl_vehicle` = `u`.`idtbl_vehicle`)";




$extraWhere = "`u`.`status` IN (1, 2)";
$groupBy ="`u`.`idtbl_vehicle`";

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere,$groupBy)
);
