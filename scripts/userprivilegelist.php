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
$table = 'tbl_user_privilege';

// Table's primary key
$primaryKey = 'idtbl_user_privilege';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`u`.`idtbl_user_privilege`', 'dt' => 'idtbl_user_privilege', 'field' => 'idtbl_user_privilege' ),
	array( 'db' => '`ua`.`name`', 'dt' => 'name', 'field' => 'name' ),
	array( 'db' => '`ub`.`menu`', 'dt' => 'menu', 'field' => 'menu' ),
	array( 'db' => '`u`.`add`', 'dt' => 'add', 'field' => 'add' ),
	array( 'db' => '`u`.`edit`', 'dt' => 'edit', 'field' => 'edit' ),
	array( 'db' => '`u`.`statuschange`', 'dt' => 'statuschange', 'field' => 'statuschange' ),
	array( 'db' => '`u`.`remove`', 'dt' => 'remove', 'field' => 'remove' ),
	array( 'db' => '`u`.`approve`', 'dt' => 'approve', 'field' => 'approve' ),
	array( 'db' => '`u`.`all_followup`', 'dt' => 'all_followup', 'field' => 'all_followup' ),
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

$joinQuery = "FROM `tbl_user_privilege` AS `u` JOIN `tbl_user` AS `ua` ON (`ua`.`idtbl_user` = `u`.`tbl_user_idtbl_user`) JOIN `tbl_menu_list` AS `ub` ON (`ub`.`idtbl_menu_list` = `u`.`tbl_menu_list_idtbl_menu_list`)";

if($_POST['userID']==1){
    $extraWhere = "`u`.`status` IN (1, 2)";
}
else{
    $extraWhere = "`u`.`status` IN (1, 2) AND `ua`.`idtbl_user`!=1";
}

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);
