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
$table = 'tbl_job_price';

// Table's primary key
$primaryKey = 'idtbl_job_price';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`u`.`idtbl_job_price`', 'dt' => 'idtbl_job_price', 'field' => 'idtbl_job_price' ),
	array( 'db' => '`mc`.`main_job_category`', 'dt' => 'main_job_category', 'field' => 'main_job_category' ),
	array( 'db' => '`sc`.`sub_job_category`', 'dt' => 'sub_job_category', 'field' => 'sub_job_category' ),
	array( 'db' => '`u`.`sub_job_category_id`', 'dt' => 'sub_job_category_id', 'field' => 'sub_job_category_id' ),
    array( 'db' => '`ua`.`sales_job_name`', 'dt' => 'sales_job_name', 'field' => 'sales_job_name' ),
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

$joinQuery = "FROM `tbl_job_price` AS `u`
    LEFT JOIN `tbl_main_job_category` AS `mc` ON `u`.`main_job_category_id` = `mc`.`idtbl_main_job_category`
	LEFT JOIN `tbl_sub_job_category` AS `sc` ON `u`.`sub_job_category_id` = `sc`.`idtbl_sub_job_category`
	LEFT JOIN `tbl_sales_jobs_details` AS `ua` ON `u`.`sales_job_details_id` = `ua`.`idtbl_sales_jobs_details`";


$extraWhere = "`u`.`status` IN (1, 2)";

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);