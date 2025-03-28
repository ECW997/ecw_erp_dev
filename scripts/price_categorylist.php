<?php
$table = 'tbl_price_category_type';


$primaryKey = 'idtbl_price_category_type';

$columns = array(
	array( 'db' => '`u`.`idtbl_price_category_type`', 'dt' => 'idtbl_price_category_type', 'field' => 'idtbl_price_category_type' ),
	array( 'db' => '`u`.`price_category_type`', 'dt' => 'price_category_type', 'field' => 'price_category_type' ),
	array( 'db' => '`u`.`status`', 'dt' => 'status', 'field' => 'status' ),
);

require('config.php');
$sql_details = array(
	'user' => $db_username,
	'pass' => $db_password,
	'db'   => $db_name,
	'host' => $db_host
);

require('ssp.customized.class.php' );

$joinQuery = "FROM `tbl_price_category_type` AS `u`";

$extraWhere = "`u`.`status` IN (1, 2)";

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);