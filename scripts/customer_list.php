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
$table = 'tbl_customer';

// Table's primary key
$primaryKey = 'idtbl_customer';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`u`.`idtbl_customer`', 'dt' => 'idtbl_customer', 'field' => 'idtbl_customer' ),
	array( 'db' => '`u`.`customer_name`', 'dt' => 'customer_name', 'field' => 'customer_name' ),
    // array( 'db' => '`u`.`customer_vehicle_number`', 'dt' => 'customer_vehicle_number', 'field' => 'customer_vehicle_number' ),
    array( 'db' => '`u`.`customer_mobile_num`', 'dt' => 'customer_mobile_num', 'field' => 'customer_mobile_num' ),
    array( 'db' => '`u`.`customer_mobile_num_2`', 'dt' => 'customer_mobile_num_2', 'field' => 'customer_mobile_num_2' ),
    array( 'db' => '`u`.`nic_number`', 'dt' => 'nic_number', 'field' => 'nic_number' ),
    array( 'db' => '`u`.`dob`', 'dt' => 'dob', 'field' => 'dob' ),
    array( 'db' => '`u`.`email`', 'dt' => 'email', 'field' => 'email' ),
    array( 'db' => '`u`.`address`', 'dt' => 'address', 'field' => 'address' ),
    array( 'db' => '`u`.`address_2`', 'dt' => 'address_2', 'field' => 'address_2' ),
    array( 'db' => '`ua`.`district_name`', 'dt' => 'district_name', 'field' => 'district_name' ),
    // array( 'db' => '`ub`.`brand_name`', 'dt' => 'brand_name', 'field' => 'brand_name' ),
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

$joinQuery = "FROM `tbl_customer` AS `u`
             LEFT JOIN `tbl_district` AS `ua` ON `u`.`district` = `ua`.`idtbl_district`";

$extraWhere = "`u`.`status` IN (1, 2) AND `u`.`company_branch_id`='$companyID'";

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);