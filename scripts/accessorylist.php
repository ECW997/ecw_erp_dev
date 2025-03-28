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
$table = 'tbl_accessory_detail';

// Table's primary key
$primaryKey = 'idtbl_accessory_detail';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`u`.`idtbl_accessory_detail`', 'dt' => 'idtbl_accessory_detail', 'field' => 'idtbl_accessory_detail' ),
	array( 'db' => '`u`.`tot_extra_charge_amount`', 'dt' => 'tot_extra_charge_amount', 'field' => 'tot_extra_charge_amount' ),
    array( 'db' => '`u`.`accessory_amount`', 'dt' => 'accessory_amount', 'field' => 'accessory_amount' ),
    array( 'db' => '`u`.`fixing_charge_amount`', 'dt' => 'fixing_charge_amount', 'field' => 'fixing_charge_amount' ),
    array( 'db' => '`ua`.`accessory_name`', 'dt' => 'accessory_name', 'field' => 'accessory_name' ),
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

$main_job_id = $_POST['main_job_id'];
$sub_job_id = $_POST['sub_job_id'];
$job_details_id = $_POST['job_details_id'];

$joinQuery = "FROM `tbl_accessory_detail` AS `u`
              LEFT JOIN `tbl_accessories` AS `ua` ON `u`.`accessory_id` = `ua`.`idtbl_accessories`";
              
$extraWhere = "`u`.`status` IN (1, 2) AND `u`.`main_job_id` = $main_job_id AND `u`.`sub_job_id` = $sub_job_id AND `u`.`job_details_id` = $job_details_id";


echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);