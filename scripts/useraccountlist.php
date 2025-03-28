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
$table = 'tbl_user';

// Table's primary key
$primaryKey = 'idtbl_user';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`u`.`idtbl_user`', 'dt' => 'idtbl_user', 'field' => 'idtbl_user' ),
	array( 'db' => '`u`.`name`', 'dt' => 'name', 'field' => 'name' ),
	array( 'db' => '`u`.`username`', 'dt' => 'username', 'field' => 'username' ),
	array( 'db' => '`u`.`status`', 'dt' => 'status', 'field' => 'status' ),
	array( 'db' => '`co`.`company`', 'dt' => 'company', 'field' => 'company' ),
	array( 'db' => '`br`.`branch`', 'dt' => 'branch', 'field' => 'branch' ),
	array( 'db' => '`ua`.`type`', 'dt' => 'type', 'field' => 'type' )
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

$joinQuery = "FROM `tbl_user` AS `u` 
				JOIN `tbl_user_type` AS `ua` ON (`ua`.`idtbl_user_type` = `u`.`tbl_user_type_idtbl_user_type`)
				LEFT JOIN `tbl_company` AS `co` ON (`co`.`idtbl_company` = `u`.`company_id`)
				LEFT JOIN `tbl_company_branch` AS `br` ON (`br`.`idtbl_company_branch` = `u`.`branch_id`)";

if($_POST['userID']==1){
    $extraWhere = "`u`.`status` IN (1, 2)";
}
else{
    $extraWhere = "`u`.`status` IN (1, 2) AND `u`.`idtbl_user`>1";
}

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);
