<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecw_software";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$filename = "year_list.csv";
// echo "Error opening file<br>";
if (($handle = fopen($filename, "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
    $master_data = trim($data[0]);
    $status = 1;

	$currdate=date('Y-m-d H:i:s');

    // echo $batchno;

    $insertSql = "INSERT INTO `tbl_vehicle_year`(`year_name`, `status`, `insertdatetime`,`updateuser`,`updatedatetime`, `tbl_user_idtbl_user`) 
    VALUES ('$master_data','$status','$currdate', null, null, '1')";


        if (mysqli_query($conn, $insertSql)) {
            echo "Record added successfully<br>";
        } else {
            echo "Error adding record or updating record: " . mysqli_error($conn) . "<br>";
        }
    }
    fclose($handle);
} else {
    echo "Error opening file<br>";
}

mysqli_close($conn);
?>