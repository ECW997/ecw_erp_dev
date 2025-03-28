<?php 
if(current_url()!=base_url()){
    if ($this->session->userdata('loggedin') == 0 && !$this->session->userdata('userid')) {
	echo "<script>window.location.href='" . base_url() . "';</script>";
        exit();
     
    }
}

function menucheck($arraymenu, $menuID){
    foreach($arraymenu as $array){
        if($array->menuid==$menuID && $array->access_status=='1'){
            return $array->access_status;
        }
    }
    return '0';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Edirisingha Cushion Works</title>
    <link href="<?php echo base_url() ?>assets/css/styles.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="<?php echo base_url() ?>assets/img/ecw2.jpg" />
    <script data-search-pseudo-elements defer
        src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js"></script>
    <!-- Datepicker CSS -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.24.1/feather.min.js"></script>
    <link href="<?php echo base_url() ?>assets/css/style.css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>assets/css/animate.css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>assets/css/select2.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/font-awesome-line-awesome/css/all.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/slick/slick.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/icofont/icofont.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/flaticon/flaticon.css">




    <!-- Include Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Include jQuery (required for Select2) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Include Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <style>
    .table tr {
        cursor: pointer;
    }
    </style>
</head>

<body class="nav-fixed">
<!-- <div id="snow"></div> -->

    <!-- <div class="snowflakes" aria-hidden="true">
        <div class="snowflake">
            <div class="inner"> <img style="width: 20px;" src="<?php echo base_url('images/s1.png'); ?>"></div>
        </div>
        <div class="snowflake">
            <div class="inner"> <img style="width: 30px;" src="<?php echo base_url('images/s1.png'); ?>"></div>
        </div>
        <div class="snowflake">
            <div class="inner"> <img style="width: 30px;" src="<?php echo base_url('images/s6.png'); ?>"></div>
        </div>
         <div class="snowflake">
            <div class="inner"> <img style="width: 20px;" src="<?php echo base_url('images/s1.png'); ?>"></div>
        </div>
        <div class="snowflake">
            <div class="inner"> <img style="width: 20px;" src="<?php echo base_url('images/s1.png'); ?>"></div>
        </div>
        <div class="snowflake">
            <div class="inner"> <img style="width: 30px;" src="<?php echo base_url('images/s3.png'); ?>"></div>
        </div>
        <div class="snowflake">
            <div class="inner"> <img style="width: 20px;" src="<?php echo base_url('images/s1.png'); ?>"></div>
        </div>
        <div class="snowflake">
            <div class="inner"> <img style="width: 30px;" src="<?php echo base_url('images/s6.png'); ?>"></div>
        </div>
        <div class="snowflake">
            <div class="inner"> <img style="width: 20px;" src="<?php echo base_url('images/s1.png'); ?>"></div>
        </div>
        <div class="snowflake">
            <div class="inner"> <img style="width: 30px;" src="<?php echo base_url('images/s3.png'); ?>"></div>
        </div>
        <div class="snowflake">
            <div class="inner"> <img style="width: 20px;" src="<?php echo base_url('images/s1.png'); ?>"></div>
        </div>
        <div class="snowflake">
            <div class="inner"> <img style="width: 30px;" src="<?php echo base_url('images/s6.png'); ?>"></div>
        </div>
        <div class="snowflake">
            <div class="inner"> <img style="width: 30px;" src="<?php echo base_url('images/s1.png'); ?>"></div>
        </div>
        <div class="snowflake">
            <div class="inner"> <img style="width: 20px;" src="<?php echo base_url('images/s1.png'); ?>"></div>
        </div>
        <div class="snowflake">
            <div class="inner"> <img style="width: 30px;" src="<?php echo base_url('images/s3.png'); ?>"></div>
        </div>
    </div> -->