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
$table = 'employees';

// Table's primary key
$primaryKey = 'id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`u`.`id`', 'dt' => 'id', 'field' => 'id' ),
	array( 'db' => '`u`.`emp_name_with_initial`', 'dt' => 'emp_name_with_initial', 'field' => 'emp_name_with_initial' ),
	array( 'db' => '`u`.`calling_name`', 'dt' => 'calling_name', 'field' => 'calling_name' ),
	array( 'db' => '`u`.`emp_etfno`', 'dt' => 'emp_etfno', 'field' => 'emp_etfno' ),
	array( 'db' => '`u`.`service_no`', 'dt' => 'service_no', 'field' => 'service_no' ),
	array( 'db' => '`dep`.`department_name`', 'dt' => 'department_name', 'field' => 'department_name' ),
	array( 'db' => '`jt`.`jobtitle`', 'dt' => 'jobtitle', 'field' => 'jobtitle' ),
	array( 'db' => '`u`.`emp_mobile`', 'dt' => 'emp_mobile', 'field' => 'emp_mobile' ),
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

$joinQuery = "FROM `employees` AS `u`
			LEFT JOIN `departments` AS `dep` ON `dep`.`id`=`u`.`emp_department`
			LEFT JOIN `job_titles` AS `jt` ON `jt`.`id`=`u`.`job_title_id`";

$extraWhere = "`u`.`deleted` IN (0) AND `u`.`is_resigned` IN (0)";

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);