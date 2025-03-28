<?php 
include "include/header.php";  

include "include/topnavbar.php"; 
?>
<?php
$jobcard_id = isset($_GET['jobcard_id']) ? $_GET['jobcard_id'] : '';
$vehi_model_id = isset($_GET['model_id']) ? $_GET['model_id'] : '';
$price_cat_id = isset($_GET['price_cat_id']) ? $_GET['price_cat_id'] : '';
?>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <?php include "include/menubar.php"; ?>
    </div>
    <div id="layoutSidenav_content">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

        <style>
        #myModal .modal-content {
            border: 4px solid #0982e6;
            background: #212529;
            border-radius: 25px;
        }

        #extraChargeModal .modal-content {
            border: 4px solid #0982e6;
            border-radius: 25px;
        }

        .no-margin-top {
            margin-top: 0;
        }

        .custom-label {
            font-size: 13px;
            color: blue;
            font-weight: bold;
        }

        .custom-hr {
            border: 1px solid;
            margin-top: 25px;
            margin-bottom: 5px;
        }

        .custom-hr1 {
            border: 2px solid;
            margin-bottom: 0px;
        }

        .light-pink-bg {
            background-color: #E3F2FD;
            padding: 10px;
            border-radius: 5px;
        }


        .form-check-input {
            width: 15px;
            height: 15px;
        }

        .form-row {
            margin-bottom: 15px;
        }

        .col {
            position: relative;
        }

        input[type="checkbox"] {
            display: none;
        }

        .checkbox-container {
            display: flex;
            align-items: center;
            cursor: pointer;
            margin-top: 25px;
        }

        .checkbox-label {
            position: relative;
            padding-left: 30px;
            font-weight: bold;
            color: #333;
            font-size: 14px;
            display: inline-block;
        }

        .checkbox-label:before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            border: 2px solid #007bff;
            border-radius: 4px;
            background-color: #fff;
            transition: all 0.3s ease;
        }

        input[type="checkbox"]:checked+.checkbox-label:before {
            background-color: #007bff;
            border-color: #007bff;
        }

        input[type="checkbox"]:checked+.checkbox-label:after {
            content: '\f00c';
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            position: absolute;
            left: 5px;
            top: 50%;
            transform: translateY(-50%);
            color: white;
            font-size: 14px;
            opacity: 1;
            transition: opacity 0.3s ease;
        }

        input[type="checkbox"]:not(:checked)+.checkbox-label:after {
            opacity: 0;
        }

        input[type="checkbox"]:checked+.checkbox-label {
            color: #007bff;
            animation: labelAnimation 0.3s ease;
        }

        @keyframes labelAnimation {
            0% {
                transform: translateX(10px);
                opacity: 0;
            }

            100% {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .table-warning th,
        .table-warning td,
        .table-warning thead th,
        .table-warning tbody+tbody {
            border-color: rgb(227 230 236);
        }

        .table-warning,
        .table-warning>th,
        .table-warning>td {
            background-color: rgba(255, 255, 255, 0);
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(255, 255, 255, 0);
        }

        .popover {
            max-width: 400px;
            font-size: 16px;
            border: 1px solid #ff0000;
            font-size: 14px;
        }

        .bs-popover-bottom>.arrow::before,
        .bs-popover-auto[x-placement^=bottom]>.arrow::before {
            top: 0;
            border-width: 0 0.5rem 0.5rem 0.5rem;
            border-bottom-color: #ff0000;
        }
        </style>
        <main>
            <div class="page-header page-header-light bg-white shadow">
                <div class="container-fluid">
                    <div class="page-header-content py-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="far fa-newspaper"></i></div>
                            <span>Job Card Information</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <form id="createorderform" autocomplete="off">
                                    <div class="form-row mb-1">
                                        <div class="col">
                                            <label class="small font-weight-bold text-dark">Job Card Number*</label>
                                            <input type="text" class="form-control form-control-sm " id="jobcard_num"
                                                name="jobcard_num" readonly style="font-weight: bold;" />
                                        </div>
                                        <div class="col">
                                            <label class="small font-weight-bold text-dark">Vehicle Model*</label>
                                            <input type="text" class="form-control form-control-sm " id="vehicle_model"
                                                name="vehicle_model" readonly style="font-weight: bold;" />
                                        </div>
                                        <div class="col">
                                            <label class="small font-weight-bold text-dark">Price Category Type*</label>
                                            <select class="form-control form-control-sm select2"
                                                name="price_category_id" id="price_category_id">
                                                <option value="">Select</option>
                                                <?php foreach($price_categorylist->result() as $rowprice_categorylist){ ?>
                                                <option
                                                    value="<?php echo $rowprice_categorylist->idtbl_price_category_type ?>">
                                                    <?php echo $rowprice_categorylist->price_category_type ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <label class="small font-weight-bold text-dark">Job Card Id*</label>
                                            <input type="number" class="form-control form-control-sm" id="jobcard_id"
                                                name="jobcard_id" readonly value="<?php echo $jobcard_id; ?>" />
                                        </div>
                                        <div class="col">
                                            <label class="small font-weight-bold text-dark">Vehicle Model Id*</label>
                                            <input type="number" class="form-control form-control-sm" id="vehi_model_id"
                                                name="vehi_model_id" readonly value="<?php echo $vehi_model_id; ?>" />
                                        </div>
                                        <div class="col">
                                            <label class="small font-weight-bold text-dark">Price Category Id*</label>
                                            <input type="number" class="form-control form-control-sm" id="price_cat_id"
                                                name="price_cat_id" readonly value="<?php echo $price_cat_id; ?>" />
                                        </div>
                                    </div>

                                    <div id="accordion">
                                        <?php foreach($mainjoblist->result() as $rowmainjoblist){ ?>
                                        <div class="card">
                                            <div class="card-header" style="background-color: lightblue;"
                                                id="heading<?php echo $rowmainjoblist->idtbl_main_job_category ?>">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link" data-toggle="collapse"
                                                        data-target="#collapse<?php echo $rowmainjoblist->idtbl_main_job_category ?>"
                                                        aria-expanded="false"
                                                        aria-controls="collapse<?php echo $rowmainjoblist->idtbl_main_job_category ?>"
                                                        data-id="<?php echo $rowmainjoblist->idtbl_main_job_category ?>">
                                                        <span style="font-weight: bold; color: blue; font-size: 18px;">
                                                            <?php echo $rowmainjoblist->main_job_category ?>
                                                        </span>
                                                    </button>
                                                </h5>

                                            </div>

                                            <div id="collapse<?php echo $rowmainjoblist->idtbl_main_job_category ?>"
                                                class="collapse"
                                                aria-labelledby="heading<?php echo $rowmainjoblist->idtbl_main_job_category ?>"
                                                data-parent="#accordion">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <label class="small font-weight-bold text-dark d-none">Main job
                                                            id*</label>
                                                        <input type="hidden" class="form-control form-control-sm"
                                                            id="main_job_id"
                                                            name="main_job_id_<?php echo $rowmainjoblist->idtbl_main_job_category ?>"
                                                            required
                                                            value="<?php echo $rowmainjoblist->idtbl_main_job_category ?>" />

                                                        <div class="col">
                                                            <label class="small font-weight-bold text-dark">Sub Job
                                                                Category*</label>
                                                            <select class="form-control form-control-sm  select2"
                                                                name="sub_job_category"
                                                                id="sub_job_category_<?php echo $rowmainjoblist->idtbl_main_job_category ?>"
                                                                data-maincategoryid="<?php echo $rowmainjoblist->idtbl_main_job_category ?>">
                                                                <option value="">Select</option>
                                                            </select>
                                                        </div>

                                                        <div class="col" id="seatConditionDiv">
                                                            <label class="small font-weight-bold text-dark">Seat
                                                                Condition*</label>
                                                            <select class="form-control form-control-sm select2"
                                                                name="seat_condition_id"
                                                                id="seat_condition_id_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>">
                                                                <option value="">Select</option>
                                                                <?php foreach($seat_conditionlist->result() as $rowseat_conditionlist){ ?>
                                                                <option
                                                                    value="<?php echo $rowseat_conditionlist->idtbl_seat_condition ?>">
                                                                    <?php echo $rowseat_conditionlist->condition_type ?>
                                                                </option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>



                                                        <div class="col" id="seatTypeDiv">
                                                            <label class="small font-weight-bold text-dark">Seat
                                                                Type*</label>
                                                            <select class="form-control form-control-sm select2"
                                                                name="seat_type_id" id="seat_type_id">
                                                                <option value="">Select</option>
                                                            </select>
                                                        </div>

                                                        <div class="col">
                                                            <label class="small font-weight-bold text-dark">Job
                                                                Description*</label>
                                                            <select
                                                                class="form-control form-control-sm selecter2 px-0 select2"
                                                                name="job_name" data-field="sales_job_details_id"
                                                                id="job_name_<?php echo $rowmainjoblist->idtbl_main_job_category ?>"
                                                                data-maincategoryid="<?php echo $rowmainjoblist->idtbl_main_job_category ?>"
                                                                required onchange="checkedDublicate(this)">
                                                                <option value="">Select</option>
                                                            </select>
                                                            <div id="sales_job_details_id_errorMsg"
                                                                style="color: red; display: none;font-size: 0.8rem;">
                                                            </div>
                                                        </div>

                                                        <div class="col" id="category_typeDiv">
                                                            <label class="small font-weight-bold text-dark">Category
                                                                Type*</label>
                                                            <select class="form-control form-control-sm select2"
                                                                name="category_type_id"
                                                                id="category_type_id_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>"
                                                                data-maincategoryid="<?php echo $rowmainjoblist->idtbl_main_job_category ?>">
                                                                <option value="">Select</option>
                                                                <?php foreach($categorytypelist->result() as $rowcategorytypelist) { 
                                                                if ($rowcategorytypelist->idtbl_price_category_type != 5 && $rowcategorytypelist->idtbl_price_category_type != 6) { ?>
                                                                <option
                                                                    value="<?php echo $rowcategorytypelist->idtbl_price_category_type ?>">
                                                                    <?php echo $rowcategorytypelist->price_category_type ?>
                                                                </option>
                                                                <?php } } ?>
                                                            </select>
                                                        </div>

                                                        <div class="col" id="repair_typeDiv" style="display:none;">
                                                            <label class="small font-weight-bold text-dark">Repair
                                                                Type*</label>
                                                            <select class="form-control form-control-sm select2"
                                                                name="repair_type_id"
                                                                id="repair_type_id_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>"
                                                                data-maincategoryid="<?php echo $rowmainjoblist->idtbl_main_job_category ?>">
                                                                <option value="">Select</option>
                                                                <?php foreach($repairtypelist->result() as $rowrepairtypelist){ ?>
                                                                <option
                                                                    value="<?php echo $rowrepairtypelist->idtbl_seat_repair_category ?>">
                                                                    <?php echo $rowrepairtypelist->sub_Repair_job_name ?>
                                                                </option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>


                                                        <div class="col" id="materialDiv">
                                                            <label
                                                                class="small font-weight-bold text-dark">Material*</label>
                                                            <select
                                                                class="form-control form-control-sm selecter2 px-0 select2"
                                                                name="material_id"
                                                                id="material_id_<?php echo $rowmainjoblist->idtbl_main_job_category ?>"
                                                                data-maincategoryid="<?php echo $rowmainjoblist->idtbl_main_job_category ?>">
                                                                <option value="">Select</option>
                                                                <?php foreach($materiallist->result() as $rowmateriallist){ ?>
                                                                <option
                                                                    value="<?php echo $rowmateriallist->idtbl_material ?>">
                                                                    <?php echo $rowmateriallist->material_code . " " . $rowmateriallist->material_type; ?>
                                                                </option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>

                                                        <div class="col">
                                                            <label class="small font-weight-bold text-dark">Material
                                                                Colour*</label>
                                                            <select class="form-control form-control-sm select2"
                                                                name="material_color"
                                                                id="material_color_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>">
                                                                <option value="">Select</option>
                                                                <?php foreach($thread_colorlist->result() as $rowthread_colorlist){ ?>
                                                                <option
                                                                    value="<?php echo $rowthread_colorlist->idtbl_thread_colour ?>">
                                                                    <?php echo $rowthread_colorlist->thread_colour ?>
                                                                </option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>

                                                        <div class="col">
                                                            <label class="small font-weight-bold text-dark">Thread
                                                                Colour*</label>
                                                            <select class="form-control form-control-sm select2"
                                                                name="thread_color"
                                                                id="thread_color_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>">
                                                                <option value="">Select</option>
                                                                <?php foreach($thread_colorlist->result() as $rowthread_colorlist){ ?>
                                                                <option
                                                                    value="<?php echo $rowthread_colorlist->idtbl_thread_colour ?>">
                                                                    <?php echo $rowthread_colorlist->thread_colour ?>
                                                                </option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>

                                                        <div class="col">
                                                            <label class="small font-weight-bold text-dark">Stitch
                                                                Style</label>
                                                            <select class="form-control form-control-sm select2"
                                                                name="stitch_style"
                                                                id="stitch_style_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>">
                                                                <option value="">Select</option>
                                                                <?php foreach($stitch_stylelist->result() as $rowstitch_stylelist){ ?>
                                                                <option
                                                                    value="<?php echo $rowstitch_stylelist->idtbl_stitch_style ?>">
                                                                    <?php echo $rowstitch_stylelist->stitch_style ?>
                                                                </option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>

                                                        <div class="col">
                                                            <label class="small font-weight-bold text-dark">Job
                                                                Price*</label>
                                                            <input type="number" class="form-control form-control-sm "
                                                                id="jobprice_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>"
                                                                name="jobprice"
                                                                onkeyup="finaltotalcalculate(<?php echo $rowmainjoblist->idtbl_main_job_category; ?>);" />
                                                        </div>
                                                        <div class="col">
                                                            <label class="small font-weight-bold text-dark">Qty*</label>
                                                            <input type="number" class="form-control form-control-sm "
                                                                id="qty_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>"
                                                                name="qty"
                                                                onkeyup="finaltotalcalculate(<?php echo $rowmainjoblist->idtbl_main_job_category; ?>);"
                                                                required />
                                                        </div>


                                                        <!-- Seat repair add button -->

                                                        <div class="col-md-12 text-right mt-2"
                                                            id="seatRepairJobButtonDiv">
                                                            <button class="btn btn-warning btn-sm"
                                                                id="clonebtn_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>"
                                                                name="clonebtn_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>"
                                                                onclick="multipleRepairAdd(<?php echo $rowmainjoblist->idtbl_main_job_category; ?>);"><i
                                                                    class="fas fa-plus text-dark"></i></button>
                                                        </div>

                                                        <!-- Seat set add button -->

                                                        <div class="col-md-12 text-right mt-2"
                                                            id="japanSeatJobButtonDiv">
                                                            <button class="btn btn-warning btn-sm"
                                                                id="clonebtn_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>"
                                                                name="clonebtn_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>"
                                                                onclick="multipleSeatsAdd(<?php echo $rowmainjoblist->idtbl_main_job_category; ?>);"><i
                                                                    class="fas fa-plus text-dark"></i></button>
                                                        </div>

                                                        <!-- Seat set table -->

                                                        <div class="col-md-12 mt-2" id="japanSeatJobTbableDiv">
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered table-hover"
                                                                    id="japanSeatJobTable">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Job Description</th>
                                                                            <th>Job Price</th>
                                                                            <th>Qty</th>
                                                                            <th class="text-right">Total</th>
                                                                            <th class="text-right">Action</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="japanSeatJobTableBody">
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </Div>

                                                        <!-- Seat Repair table -->

                                                        <div class="col-md-12 mt-2" id="seatRepairJobTbableDiv">
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered table-hover"
                                                                    id="seatRepairJobTbable">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Job Description</th>
                                                                            <th>Repair Type</th>
                                                                            <th>Price Category Type</th>
                                                                            <th>Job Price</th>
                                                                            <th>Qty</th>
                                                                            <th class="text-right">Total</th>
                                                                            <th class="text-right">Action</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="seatRepairJobTbableBody">
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </Div>


                                                    </div>

                                                    <hr id="hr_1" class="custom-hr1">
                                                    <br>

                                                    <div class="row"
                                                        id="middle_contentDiv_<?php echo $rowmainjoblist->idtbl_main_job_category ?>">
                                                        <div class="col-4"
                                                            id="productionAdviceDivVehi_<?php echo $rowmainjoblist->idtbl_main_job_category ?>">
                                                            <label class="small font-weight-bold text-dark">Production
                                                                Advice*</label>
                                                            <div class="row">
                                                                <div class="col text-center">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="production_advice"
                                                                            id="oem_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>"
                                                                            value="1" checked>
                                                                        <label class="form-check-label" for="oem">
                                                                            <img style="width: 180px; height: 250px;"
                                                                                src="<?php echo base_url('images/OEM.png'); ?>"
                                                                                alt="OEM">
                                                                            <br><b>OEM</b>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="col text-center">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="production_advice"
                                                                            id="oem2_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>"
                                                                            value="2">
                                                                        <label class="form-check-label" for="oem2">
                                                                            <img style="width: 180px; height: 250px;"
                                                                                src="<?php echo base_url('images/OEM_Custom.png'); ?>"
                                                                                alt="OEM2">
                                                                            <br><b>OEM Custom Cloth</b>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="col text-center">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="production_advice"
                                                                            id="oem3_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>"
                                                                            value="3">
                                                                        <label class="form-check-label" for="oem3">
                                                                            <img style="width: 180px; height: 250px;"
                                                                                src="<?php echo base_url('images/Custom.png'); ?>"
                                                                                alt="OEM3">
                                                                            <br><b>Custom Design</b>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="col-4"
                                                            id="productionAdviceDivBike_<?php echo $rowmainjoblist->idtbl_main_job_category ?>">
                                                            <label class="small font-weight-bold text-dark">Production
                                                                Advice*</label>
                                                            <div class="row">
                                                                <div class="col text-center">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="production_advice"
                                                                            id="oem_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>"
                                                                            value="1" checked>
                                                                        <label class="form-check-label" for="oem">
                                                                            <img style="width: 350px; height: 180px;"
                                                                                src="<?php echo base_url('images/bike_seat_oem.png'); ?>"
                                                                                alt="OEM">
                                                                            <br><b>OEM</b>
                                                                        </label>
                                                                    </div>
                                                                </div>

                                                                <div class="col text-center">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="production_advice"
                                                                            id="oem3_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>"
                                                                            value="3">
                                                                        <label class="form-check-label" for="oem3">
                                                                            <img style="width: 350px; height: 180px;"
                                                                                src="<?php echo base_url('images/bike_seat_custome.png'); ?>"
                                                                                alt="OEM3">
                                                                            <br><b>Custom Design</b>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="col-8">
                                                            <!-- <hr id="hr_row1" class="custom-hr"> -->
                                                            <label id="label_row1" class="custom-label"
                                                                onclick="toggleSection('cover_design_div_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>')">
                                                                <i class="fa fa-cog"></i> Cover Design Section <span
                                                                    class="toggle-icon"></span>
                                                            </label>

                                                            <div class="form-row mb-3 light-pink-bg section-content"
                                                                id="cover_design_div_<?php echo $rowmainjoblist->idtbl_main_job_category ?>"
                                                                style="display: none;">

                                                                <div class="col">
                                                                    <label
                                                                        class="small font-weight-bold text-dark">Price
                                                                        Category Type*</label>
                                                                    <select class="form-control form-control-sm select2"
                                                                        name="price_category_id_in_cover_design"
                                                                        id="price_category_id_in_cover_design<?php echo $rowmainjoblist->idtbl_main_job_category; ?>"
                                                                        data-maincategoryid="<?php echo $rowmainjoblist->idtbl_main_job_category ?>">
                                                                        <option value="">Select</option>
                                                                        <?php foreach($price_categorylist->result() as $rowprice_categorylist){ ?>
                                                                        <option
                                                                            value="<?php echo $rowprice_categorylist->idtbl_price_category_type ?>">
                                                                            <?php echo $rowprice_categorylist->price_category_type ?>
                                                                        </option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>


                                                                <div class="col">

                                                                    <label class="checkbox-container">
                                                                        <input type="checkbox"
                                                                            id="add_cover_design_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>"
                                                                            name="add_cover_design" value="0"
                                                                            data-maincategoryid="<?php echo $rowmainjoblist->idtbl_main_job_category ?>"
                                                                            onchange="handleAddMaterialDesignChange(<?php echo $rowmainjoblist->idtbl_main_job_category; ?>)">
                                                                        <span class="checkbox-label">Add Cover
                                                                            Design</span>
                                                                    </label>
                                                                </div>
                                                                <div class="col">
                                                                    <label
                                                                        class="small font-weight-bold text-dark">Cover
                                                                        Design Charge</label>
                                                                    <input type="number"
                                                                        class="form-control form-control-sm"
                                                                        id="cover_design_charge_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>"
                                                                        name="cover_design_charge" value="0"
                                                                        onkeyup="finaltotalcalculate(<?php echo $rowmainjoblist->idtbl_main_job_category; ?>);" />
                                                                </div>
                                                                <div class="col-3"
                                                                    id="cover_design_qty_div_<?php echo $rowmainjoblist->idtbl_main_job_category ?>">
                                                                    <label
                                                                        class="small font-weight-bold text-dark">Cover
                                                                        Design Qty</label>
                                                                    <input type="number"
                                                                        class="form-control form-control-sm "
                                                                        id="cover_design_qty_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>"
                                                                        name="cover_design_qty" value="0"
                                                                        onkeyup="finaltotalcalculate(<?php echo $rowmainjoblist->idtbl_main_job_category; ?>);"
                                                                        required />
                                                                </div>
                                                            </div>

                                                            <hr id="hr_row8" class="custom-hr">
                                                            <label id="label_row8" class="custom-label"
                                                                onclick="toggleSection('material_incert_div_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>')">
                                                                <i class="fa fa-cog"></i> Special Material Incert
                                                                Section <span class="toggle-icon"></span>
                                                            </label>

                                                            <div class="form-row mb-3 light-pink-bg section-content"
                                                                id="material_incert_div_<?php echo $rowmainjoblist->idtbl_main_job_category ?>"
                                                                style="display: none;">

                                                                <div class="col">
                                                                    <label
                                                                        class="small font-weight-bold text-dark">Type</label>
                                                                    <select
                                                                        class="form-control form-control-sm selecter2 px-0 select2"
                                                                        name="material_incert_type"
                                                                        id="material_incert_type_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>"
                                                                        data-maincategoryid="<?php echo $rowmainjoblist->idtbl_main_job_category ?>">
                                                                        <option value="">Select</option>
                                                                        <option value="1">Local</option>
                                                                        <option value="2">Imported</option>
                                                                    </select>
                                                                </div>
                                                                
                                                                <div class="col">
                                                                    <label
                                                                        class="small font-weight-bold text-dark">Special
                                                                        Material Incert</label>
                                                                    <select
                                                                        class="form-control form-control-sm selecter2 px-0 select2"
                                                                        name="material_incert"
                                                                        id="material_incert_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>"
                                                                        data-maincategoryid="<?php echo $rowmainjoblist->idtbl_main_job_category ?>">
                                                                        <option value="">Select</option>
                                                                        <option value="1">None</option>
                                                                        <option value="2">Covering Area- 10%</option>
                                                                        <option value="3">Covering Area- 30%</option>
                                                                        <option value="4">Covering Area- 50%</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col">
                                                                    <label
                                                                        class="small font-weight-bold text-dark">Special
                                                                        Material Incert Charge</label>
                                                                    <input type="number"
                                                                        class="form-control form-control-sm"
                                                                        id="material_incert_charge_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>"
                                                                        name="material_incert_charge" value="0"
                                                                        onkeyup="finaltotalcalculate(<?php echo $rowmainjoblist->idtbl_main_job_category; ?>);" />
                                                                </div>
                                                                <div class="col-3"
                                                                    id="material_incert_qty_div_<?php echo $rowmainjoblist->idtbl_main_job_category ?>">
                                                                    <label class="small font-weight-bold text-dark">
                                                                        Special Material Incert Qty</label>
                                                                    <input type="number"
                                                                        class="form-control form-control-sm "
                                                                        id="material_incert_qty_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>"
                                                                        name="_qty" value="0"
                                                                        onkeyup="finaltotalcalculate(<?php echo $rowmainjoblist->idtbl_main_job_category; ?>);"
                                                                        required />
                                                                </div>
                                                            </div>

                                                            <hr id="hr_row2" class="custom-hr">
                                                            <label id="label_row2" class="custom-label"
                                                                onclick="toggleSection('Stitch_Design_Section_div_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>')">
                                                                <i class="fa fa-cog"></i> Stitch Design Section <span
                                                                    class="toggle-icon"></span>
                                                            </label>

                                                            <div id="Stitch_Design_Section_div_<?php echo $rowmainjoblist->idtbl_main_job_category ?>"
                                                                style="display: none;">
                                                                <div class="form-row mb-3 light-pink-bg section-content"
                                                                    id="stitch_design_div_<?php echo $rowmainjoblist->idtbl_main_job_category ?>">

                                                                    <div class="col">
                                                                        <label
                                                                            class="small font-weight-bold text-dark">Price
                                                                            Category Type*</label>
                                                                        <select
                                                                            class="form-control form-control-sm select2"
                                                                            name="price_category_id_in_stitch"
                                                                            id="price_category_id_in_stitch<?php echo $rowmainjoblist->idtbl_main_job_category; ?>"
                                                                            data-maincategoryid="<?php echo $rowmainjoblist->idtbl_main_job_category ?>">
                                                                            <option value="">Select</option>
                                                                            <?php foreach($price_categorylist->result() as $rowprice_categorylist){ ?>
                                                                            <option
                                                                                value="<?php echo $rowprice_categorylist->idtbl_price_category_type ?>">
                                                                                <?php echo $rowprice_categorylist->price_category_type ?>
                                                                            </option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col">
                                                                        <label
                                                                            class="small font-weight-bold text-dark">Stitch
                                                                            Design</label>
                                                                        <button
                                                                            class="btn btn-success btn-sm w-100 px-4 d-flex align-items-center justify-content-center"
                                                                            onclick="openModal(<?php echo $rowmainjoblist->idtbl_main_job_category; ?>)"
                                                                            style="height: 33px;">
                                                                            <i
                                                                                class="fas fa-palette fa-spin fa-lg me-3"></i>
                                                                            <span class="fw-bold"><b>Add Stitch
                                                                                    Design</b></span>
                                                                        </button>
                                                                    </div>

                                                                    <label
                                                                        class="small font-weight-bold text-dark d-none">Stitch
                                                                        Design Id</label>
                                                                    <input type="hidden"
                                                                        class="form-control form-control-sm "
                                                                        id="design_id_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>"
                                                                        name="design_id"
                                                                        data-maincategoryid="<?php echo $rowmainjoblist->idtbl_main_job_category ?>" />

                                                                    <div class="col-3">
                                                                        <label
                                                                            class="small font-weight-bold text-dark">Stitch
                                                                            Design Charge</label>
                                                                        <input type="number"
                                                                            class="form-control form-control-sm "
                                                                            id="design_charge_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>"
                                                                            name="design_charge" value="0"
                                                                            onkeyup="finaltotalcalculate(<?php echo $rowmainjoblist->idtbl_main_job_category; ?>);" />
                                                                    </div>
                                                                    <div class="col-2"
                                                                        id="stitch_style_qty_div_<?php echo $rowmainjoblist->idtbl_main_job_category ?>">
                                                                        <label
                                                                            class="small font-weight-bold text-dark">Stitch
                                                                            Design Qty</label>
                                                                        <input type="number"
                                                                            class="form-control form-control-sm "
                                                                            id="stitch_design_qty_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>"
                                                                            name="stitch_design_qty" value="0"
                                                                            onkeyup="finaltotalcalculate(<?php echo $rowmainjoblist->idtbl_main_job_category; ?>);"
                                                                            required />
                                                                    </div>
                                                                </div>


                                                                <div class="form-row mb-3 light-pink-bg">
                                                                    <div class="col"
                                                                        id="thread_colordiv_<?php echo $rowmainjoblist->idtbl_main_job_category ?>">
                                                                        <label
                                                                            class="small font-weight-bold text-dark">Thread
                                                                            Colour*</label>
                                                                        <select
                                                                            class="form-control form-control-sm select2"
                                                                            name="thread_color"
                                                                            id="thread_color_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>">
                                                                            <option value="">Select</option>
                                                                            <?php foreach($thread_colorlist->result() as $rowthread_colorlist){ ?>
                                                                            <option
                                                                                value="<?php echo $rowthread_colorlist->idtbl_thread_colour ?>">
                                                                                <?php echo $rowthread_colorlist->thread_colour ?>
                                                                            </option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col">
                                                                        <label
                                                                            class="small font-weight-bold text-dark">Stitch
                                                                            Style</label>
                                                                        <select
                                                                            class="form-control form-control-sm select2"
                                                                            name="stitch_style"
                                                                            id="stitch_style_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>">
                                                                            <option value="">Select</option>
                                                                            <?php foreach($stitch_stylelist->result() as $rowstitch_stylelist){ ?>
                                                                            <option
                                                                                value="<?php echo $rowstitch_stylelist->idtbl_stitch_style ?>">
                                                                                <?php echo $rowstitch_stylelist->stitch_style ?>
                                                                            </option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <hr id="hr_row3" class="custom-hr">
                                                            <label id="label_row3" class="custom-label"
                                                                onclick="toggleSection('logo_Section_div_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>')">
                                                                <i class="fa fa-cog"></i> Logo Section <span
                                                                    class="toggle-icon"></span>
                                                            </label>


                                                            <div id="logo_Section_div_<?php echo $rowmainjoblist->idtbl_main_job_category ?>"
                                                                style="display: none;">
                                                                <div class="form-row mb-3 light-pink-bg section-content"
                                                                    id="logochargediv_<?php echo $rowmainjoblist->idtbl_main_job_category ?>">
                                                                    <div class="col">
                                                                        <label
                                                                            class="small font-weight-bold text-dark">Add
                                                                            logo</label>
                                                                        <select
                                                                            class="form-control form-control-sm select2 add_logo"
                                                                            name="add_logo"
                                                                            id="add_logo_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>"
                                                                            data-category="<?php echo $rowmainjoblist->idtbl_main_job_category; ?>">
                                                                            <option value="" data-price="0">Select
                                                                            </option>
                                                                            <?php foreach($logo_status_list->result() as $rowlogo_status_list){ ?>
                                                                            <option
                                                                                value="<?php echo $rowlogo_status_list->idtbl_logo_status ?>"
                                                                                data-price="<?php echo $rowlogo_status_list->price ?>">
                                                                                <?php echo $rowlogo_status_list->logo_status ?>
                                                                            </option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>

                                                                    <div class="col">
                                                                        <label
                                                                            class="small font-weight-bold text-dark">Logo
                                                                            Charge</label>
                                                                        <input type="number"
                                                                            class="form-control form-control-sm "
                                                                            id="logo_charge_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>"
                                                                            name="logo_charge" value="0"
                                                                            onkeyup="finaltotalcalculate(<?php echo $rowmainjoblist->idtbl_main_job_category; ?>);"
                                                                            required />
                                                                    </div>

                                                                    <div class="col-2">
                                                                        <label
                                                                            class="small font-weight-bold text-dark">Logo
                                                                            Qty</label>
                                                                        <input type="number"
                                                                            class="form-control form-control-sm "
                                                                            id="logo_qty_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>"
                                                                            name="logo_qty" value="0"
                                                                            onkeyup="finaltotalcalculate(<?php echo $rowmainjoblist->idtbl_main_job_category; ?>);"
                                                                            required />
                                                                    </div>
                                                                </div>

                                                                <div class="form-row mb-3 light-pink-bg"
                                                                    id="logodiv_<?php echo $rowmainjoblist->idtbl_main_job_category ?>">
                                                                    <div class="col">
                                                                        <label
                                                                            class="small font-weight-bold text-dark">Logo
                                                                            Type*</label>
                                                                        <select
                                                                            class="form-control form-control-sm select2"
                                                                            name="logo"
                                                                            id="logo_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>">
                                                                            <option value="">Select</option>
                                                                            <?php foreach($logolist->result() as $rowlogolist){ ?>
                                                                            <option
                                                                                value="<?php echo $rowlogolist->idtbl_logo ?>">
                                                                                <?php echo $rowlogolist->logo_type ?>
                                                                            </option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>

                                                                    <div class="col" id="logo_colorDiv">
                                                                        <label
                                                                            class="small font-weight-bold text-dark">Logo
                                                                            Colour*</label>
                                                                        <select
                                                                            class="form-control form-control-sm select2"
                                                                            name="logo_color"
                                                                            id="logo_color_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>">
                                                                            <option value="">Select</option>
                                                                            <?php foreach($logo_colorlist->result() as $rowlogo_colorlist){ ?>
                                                                            <option
                                                                                value="<?php echo $rowlogo_colorlist->idtbl_logo_colour ?>">
                                                                                <?php echo $rowlogo_colorlist->logo_colour_type ?>
                                                                            </option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <hr id="hr_row4" class="custom-hr">
                                                            <label id="label_row4" class="custom-label"
                                                                onclick="toggleSection('dot_design_div_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>')">
                                                                <i class="fa fa-cog"></i> Perforation Section <span
                                                                    class="toggle-icon"></span>
                                                            </label>

                                                            <div class="form-row mb-3 light-pink-bg section-content"
                                                                id="dot_design_div_<?php echo $rowmainjoblist->idtbl_main_job_category ?>"
                                                                style="display: none;">
                                                                <div class="col">
                                                                    <label
                                                                        class="small font-weight-bold text-dark">Price
                                                                        Category Type*</label>
                                                                    <select class="form-control form-control-sm select2"
                                                                        name="price_category_id_in_dot"
                                                                        id="price_category_id_in_dot<?php echo $rowmainjoblist->idtbl_main_job_category; ?>"
                                                                        data-maincategoryid="<?php echo $rowmainjoblist->idtbl_main_job_category ?>">
                                                                        <option value="">Select</option>
                                                                        <?php foreach($price_categorylist->result() as $rowprice_categorylist){ ?>
                                                                        <option
                                                                            value="<?php echo $rowprice_categorylist->idtbl_price_category_type ?>">
                                                                            <?php echo $rowprice_categorylist->price_category_type ?>
                                                                        </option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>

                                                                <div class="col">
                                                                    <label class="small font-weight-bold text-dark">Dot
                                                                        Design</label>
                                                                    <select
                                                                        class="form-control form-control-sm selecter2 px-0 select2"
                                                                        name="dot_design"
                                                                        id="dot_design_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>"
                                                                        data-maincategoryid="<?php echo $rowmainjoblist->idtbl_main_job_category ?>">
                                                                        <option value="">Select</option>
                                                                        <option value="1">None</option>
                                                                        <option value="2">OEM Dot Design</option>
                                                                        <option value="3">Custom Dot Design</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col">
                                                                    <label class="small font-weight-bold text-dark">Dot
                                                                        Design Charge</label>
                                                                    <input type="number"
                                                                        class="form-control form-control-sm"
                                                                        id="dot_design_charge_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>"
                                                                        name="dot_design_charge" value="0"
                                                                        onkeyup="finaltotalcalculate(<?php echo $rowmainjoblist->idtbl_main_job_category; ?>);" />
                                                                </div>
                                                                <div class="col-2"
                                                                    id="dot_design_qty_div_<?php echo $rowmainjoblist->idtbl_main_job_category ?>">
                                                                    <label class="small font-weight-bold text-dark">Dot
                                                                        Design Qty</label>
                                                                    <input type="number"
                                                                        class="form-control form-control-sm "
                                                                        id="dot_design_qty_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>"
                                                                        name="dot_design_qty" value="0"
                                                                        onkeyup="finaltotalcalculate(<?php echo $rowmainjoblist->idtbl_main_job_category; ?>);"
                                                                        required />
                                                                </div>
                                                            </div>

                                                            <hr id="hr_row5" class="custom-hr">
                                                            <label id="label_row5" class="custom-label"
                                                                onclick="toggleSection('cushion_repair_div_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>')">
                                                                <i class="fa fa-cog"></i> Cushion Repair Section <span
                                                                    class="toggle-icon"></span>
                                                            </label>

                                                            <div class="form-row mb-3 light-pink-bg section-content"
                                                                id="cushion_repair_div_<?php echo $rowmainjoblist->idtbl_main_job_category ?>"
                                                                style="display: none;">

                                                                <div class="col">
                                                                    <label
                                                                        class="small font-weight-bold text-dark">Price
                                                                        Category Type*</label>
                                                                    <select class="form-control form-control-sm select2"
                                                                        name="price_category_id_cushion_repair"
                                                                        id="price_category_id_cushion_repair<?php echo $rowmainjoblist->idtbl_main_job_category; ?>"
                                                                        data-maincategoryid="<?php echo $rowmainjoblist->idtbl_main_job_category ?>">
                                                                        <option value="">Select</option>
                                                                        <?php foreach($price_categorylist->result() as $rowprice_categorylist){ ?>
                                                                        <option
                                                                            value="<?php echo $rowprice_categorylist->idtbl_price_category_type ?>">
                                                                            <?php echo $rowprice_categorylist->price_category_type ?>
                                                                        </option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col">
                                                                    <label
                                                                        class="small font-weight-bold text-dark">Cushion
                                                                        Repair*</label>
                                                                    <select class="form-control form-control-sm select2"
                                                                        name="cushion_repair"
                                                                        id="cushion_repair_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>"
                                                                        data-maincategoryid="<?php echo $rowmainjoblist->idtbl_main_job_category ?>">
                                                                        <option value="">Select</option>
                                                                        <option value="1">None</option>
                                                                        <option value="2">Cushion Repair</option>
                                                                        <option value="3">Custom Cushion Repair</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col">
                                                                    <label
                                                                        class="small font-weight-bold text-dark">Cushion
                                                                        Repair Charge</label>
                                                                    <input type="number"
                                                                        class="form-control form-control-sm "
                                                                        id="cushion_repair_charge_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>"
                                                                        name="cushion_repair_charge" value="0"
                                                                        onkeyup="finaltotalcalculate(<?php echo $rowmainjoblist->idtbl_main_job_category; ?>);" />
                                                                </div>
                                                                <div class="col-3"
                                                                    id="cushion_repair_qty_div_<?php echo $rowmainjoblist->idtbl_main_job_category ?>">
                                                                    <label
                                                                        class="small font-weight-bold text-dark">Cushion
                                                                        Repair Qty</label>
                                                                    <input type="number"
                                                                        class="form-control form-control-sm "
                                                                        id="cushion_repair_qty_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>"
                                                                        name="cushion_repair_qty" value="0"
                                                                        onkeyup="finaltotalcalculate(<?php echo $rowmainjoblist->idtbl_main_job_category; ?>);"
                                                                        required />
                                                                </div>
                                                            </div>


                                                            <hr id="hr_row9" class="custom-hr">
                                                            <label id="label_row9" class="custom-label"
                                                                onclick="toggleSection('cushion_modification_div_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>')">
                                                                <i class="fa fa-cog"></i> Cushion Modification Section
                                                                <span class="toggle-icon"></span>
                                                            </label>

                                                            <div class="form-row mb-3 light-pink-bg section-content"
                                                                id="cushion_modification_div_<?php echo $rowmainjoblist->idtbl_main_job_category ?>"
                                                                style="display: none;">
                                                                <div class="col">
                                                                    <label
                                                                        class="small font-weight-bold text-dark">Price
                                                                        Category Type*</label>
                                                                    <select class="form-control form-control-sm select2"
                                                                        name="price_category_id_in_cushion_modification"
                                                                        id="price_category_id_in_cushion_modification<?php echo $rowmainjoblist->idtbl_main_job_category; ?>"
                                                                        data-maincategoryid="<?php echo $rowmainjoblist->idtbl_main_job_category ?>">
                                                                        <option value="">Select</option>
                                                                        <?php foreach($price_categorylist->result() as $rowprice_categorylist){ ?>
                                                                        <option
                                                                            value="<?php echo $rowprice_categorylist->idtbl_price_category_type ?>">
                                                                            <?php echo $rowprice_categorylist->price_category_type ?>
                                                                        </option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>

                                                                <div class="col"
                                                                    id="mateal_div_<?php echo $rowmainjoblist->idtbl_main_job_category ?>">
                                                                    <label class="checkbox-container">
                                                                        <input type="checkbox"
                                                                            id="add_cushion_modification_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>"
                                                                            name="add_cushion_modification" value="0"
                                                                            data-maincategoryid="<?php echo $rowmainjoblist->idtbl_main_job_category ?>"
                                                                            onchange="handleAddMaterialDesignChange(<?php echo $rowmainjoblist->idtbl_main_job_category; ?>)">
                                                                        <span class="checkbox-label">Cushion
                                                                            Modification</span>
                                                                    </label>
                                                                </div>
                                                                <div class="col"
                                                                    id="materi_div_<?php echo $rowmainjoblist->idtbl_main_job_category ?>">
                                                                    <label
                                                                        class="small font-weight-bold text-dark">Cushion
                                                                        Modification Charge</label>
                                                                    <input type="number"
                                                                        class="form-control form-control-sm"
                                                                        id="cushion_modifi_charge_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>"
                                                                        name="cushion_modifi_charge" value="0"
                                                                        onkeyup="finaltotalcalculate(<?php echo $rowmainjoblist->idtbl_main_job_category; ?>);" />
                                                                </div>

                                                                <div class="col-3"
                                                                    id="material_qty_div_<?php echo $rowmainjoblist->idtbl_main_job_category ?>">
                                                                    <label
                                                                        class="small font-weight-bold text-dark">Cushion
                                                                        Modification Qty</label>
                                                                    <input type="number"
                                                                        class="form-control form-control-sm "
                                                                        id="cushion_modifi_qty_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>"
                                                                        name="cushion_modifi_qty" value="0"
                                                                        onkeyup="finaltotalcalculate(<?php echo $rowmainjoblist->idtbl_main_job_category; ?>);"
                                                                        required />
                                                                </div>
                                                            </div>


                                                            <hr id="hr_row6" class="custom-hr">
                                                            <label id="label_row6" class="custom-label"
                                                                onclick="toggleSection('material_div_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>')">
                                                                <i class="fa fa-cog"></i> Cushion Replacement Section
                                                                <span class="toggle-icon"></span>
                                                            </label>

                                                            <div class="form-row mb-3 light-pink-bg section-content"
                                                                id="material_div_<?php echo $rowmainjoblist->idtbl_main_job_category ?>"
                                                                style="display: none;">

                                                                <div class="col">
                                                                    <label
                                                                        class="small font-weight-bold text-dark">Price
                                                                        Category Type*</label>
                                                                    <select class="form-control form-control-sm select2"
                                                                        name="price_category_id_in_cushion_replacement"
                                                                        id="price_category_id_in_cushion_replacement<?php echo $rowmainjoblist->idtbl_main_job_category; ?>"
                                                                        data-maincategoryid="<?php echo $rowmainjoblist->idtbl_main_job_category ?>">
                                                                        <option value="">Select</option>
                                                                        <?php foreach($price_categorylist->result() as $rowprice_categorylist){ ?>
                                                                        <option
                                                                            value="<?php echo $rowprice_categorylist->idtbl_price_category_type ?>">
                                                                            <?php echo $rowprice_categorylist->price_category_type ?>
                                                                        </option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>

                                                                <div class="col">
                                                                    <label class="checkbox-container">
                                                                        <input type="checkbox"
                                                                            id="add_cushion_replacement_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>"
                                                                            name="add_cushion_replacement" value="0"
                                                                            data-maincategoryid="<?php echo $rowmainjoblist->idtbl_main_job_category ?>"
                                                                            onchange="handleAddMaterialDesignChange(<?php echo $rowmainjoblist->idtbl_main_job_category; ?>)">
                                                                        <span class="checkbox-label">Cushion
                                                                            Replacement</span>
                                                                    </label>
                                                                </div>
                                                                <div class="col"
                                                                    id="material_charge_div_<?php echo $rowmainjoblist->idtbl_main_job_category ?>">
                                                                    <label
                                                                        class="small font-weight-bold text-dark">Cushion
                                                                        Replacement Charge</label>
                                                                    <input type="number"
                                                                        class="form-control form-control-sm"
                                                                        id="cushion_replacement_charge_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>"
                                                                        name="cushion_replacement_charge" value="0"
                                                                        onkeyup="finaltotalcalculate(<?php echo $rowmainjoblist->idtbl_main_job_category; ?>);" />
                                                                </div>

                                                                <div class="col-3"
                                                                    id="material_qty_div_<?php echo $rowmainjoblist->idtbl_main_job_category ?>">
                                                                    <label
                                                                        class="small font-weight-bold text-dark">Cushion
                                                                        Replacement Qty</label>
                                                                    <input type="number"
                                                                        class="form-control form-control-sm "
                                                                        id="cushion_replacement_qty_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>"
                                                                        name="cushion_replacement_qty" value="0"
                                                                        onkeyup="finaltotalcalculate(<?php echo $rowmainjoblist->idtbl_main_job_category; ?>);"
                                                                        required />
                                                                </div>
                                                            </div>

                                                            <hr id="hr_row7" class="custom-hr">
                                                            <label id="label_row7" class="custom-label"
                                                                onclick="toggleSection('hybrid_div_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>')">
                                                                <i class="fa fa-cog"></i> Hybrid Comfort Section <span
                                                                    class="toggle-icon"></span>
                                                            </label>

                                                            <div class="form-row mb-3 light-pink-bg section-content"
                                                                id="hybrid_div_<?php echo $rowmainjoblist->idtbl_main_job_category ?>"
                                                                style="display: none;">
                                                                <div class="col">
                                                                    <label
                                                                        class="small font-weight-bold text-dark">Hybrid
                                                                        Comfort Layer*</label>
                                                                    <select
                                                                        class="form-control form-control-sm select2 hybrid_comfort_layer"
                                                                        name="hybrid_comfort_layer"
                                                                        id="hybrid_comfort_layer_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>"
                                                                        data-category="<?php echo $rowmainjoblist->idtbl_main_job_category; ?>">
                                                                        <option value="" data-price="0">Select</option>
                                                                        <?php foreach($comfort_layerlist->result() as $rowcomfort_layerlist){ ?>
                                                                        <option
                                                                            value="<?php echo $rowcomfort_layerlist->idtbl_hybrid_comfort ?>"
                                                                            data-price="<?php echo $rowcomfort_layerlist->price ?>">
                                                                            <?php echo $rowcomfort_layerlist->hybrid_comfort_name ?>
                                                                        </option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>

                                                                <div class="col">
                                                                    <label
                                                                        class="small font-weight-bold text-dark">Hybrid
                                                                        Comfort Charge</label>
                                                                    <input type="number"
                                                                        class="form-control form-control-sm hybrid_comfort_price"
                                                                        id="hybrid_comfort_price_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>"
                                                                        name="hybrid_comfort_price" value="0"
                                                                        onkeyup="finaltotalcalculate(<?php echo $rowmainjoblist->idtbl_main_job_category; ?>);"
                                                                        required />
                                                                </div>

                                                                <div class="col-3">
                                                                    <label
                                                                        class="small font-weight-bold text-dark">Hybrid
                                                                        Comfort Qty</label>
                                                                    <input type="number"
                                                                        class="form-control form-control-sm "
                                                                        id="hybrid_comfort_qty_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>"
                                                                        name="hybrid_comfort_qty" value="0"
                                                                        onkeyup="finaltotalcalculate(<?php echo $rowmainjoblist->idtbl_main_job_category; ?>);"
                                                                        required />
                                                                </div>
                                                            </div>

                                                            <hr id="hr_row10" class="custom-hr">
                                                            <label id="label_row10" class="custom-label"
                                                                onclick="toggleSection('pipening_div_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>')">
                                                                <i class="fa fa-cog"></i> Pipeing Design Section <span
                                                                    class="toggle-icon"></span>
                                                            </label>

                                                            <div class="form-row mb-3 light-pink-bg section-content"
                                                                id="pipening_div_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>"
                                                                style="display: none;">
                                                                <div class="col">
                                                                    <label
                                                                        class="small font-weight-bold text-dark">Pipeing
                                                                        Design Type</label>
                                                                    <select
                                                                        class="form-control form-control-sm selecter2 px-0 select2"
                                                                        name="pipening_design"
                                                                        id="pipening_design_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>"
                                                                        data-maincategoryid="<?php echo $rowmainjoblist->idtbl_main_job_category ?>">
                                                                        <option value="">Select</option>
                                                                        <option value="1">None</option>
                                                                        <option value="2">Type 1</option>
                                                                        <option value="3">Type 2</option>
                                                                        <option value="4">Type 3</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col">
                                                                    <label
                                                                        class="small font-weight-bold text-dark">Pipeing
                                                                        Design Charge</label>
                                                                    <input type="number"
                                                                        class="form-control form-control-sm"
                                                                        id="pipening_design_charge_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>"
                                                                        name="pipening_design_charge" value="0"
                                                                        onkeyup="finaltotalcalculate(<?php echo $rowmainjoblist->idtbl_main_job_category; ?>);" />
                                                                </div>
                                                                <div class="col-2"
                                                                    id="pipening_design_qty_div_<?php echo $rowmainjoblist->idtbl_main_job_category ?>">
                                                                    <label
                                                                        class="small font-weight-bold text-dark">Pipeing
                                                                        Design Qty</label>
                                                                    <input type="number"
                                                                        class="form-control form-control-sm "
                                                                        id="pipening_design_qty_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>"
                                                                        name="pipening_design_qty" value="0"
                                                                        onkeyup="finaltotalcalculate(<?php echo $rowmainjoblist->idtbl_main_job_category; ?>);"
                                                                        required />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr id="hr_2" style="border: 2px solid ;">
                                                    <br>

                                                    <div class="row">
                                                        <div class="col">
                                                            <label class="small font-weight-bold text-dark">Gross
                                                                Amount*</label>
                                                            <input type="number" class="form-control form-control-sm "
                                                                id="gross_amount_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>"
                                                                name="gross_amount" readonly />
                                                        </div>
                                                        <div class="col">
                                                            <label
                                                                class="small font-weight-bold text-dark">Discount(%)*</label>
                                                            <input type="number" class="form-control form-control-sm "
                                                                id="discount_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>"
                                                                name="discount" value="0"
                                                                onkeyup="finaltotalcalculate(<?php echo $rowmainjoblist->idtbl_main_job_category; ?>);" />
                                                        </div>
                                                        <div class="col">
                                                            <label class="small font-weight-bold text-dark">Discount
                                                                Amount*</label>
                                                            <input type="number" class="form-control form-control-sm "
                                                                id="discount_amount_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>"
                                                                name="discount_amount" value="0" readonly />
                                                        </div>
                                                        <div class="col">
                                                            <label class="small font-weight-bold text-dark">Sub
                                                                Total*</label>
                                                            <input type="number" class="form-control form-control-sm "
                                                                id="sub_total_<?php echo $rowmainjoblist->idtbl_main_job_category; ?>"
                                                                name="sub_total" readonly />
                                                        </div>
                                                    </div>

                                                    <div class="form-group mt-2 text-right">
                                                        <input type="hidden" name="recordID"
                                                            id="recordID_<?php echo $rowmainjoblist->idtbl_main_job_category ?>"
                                                            value="">
                                                        <input type="hidden" name="recordOption"
                                                            id="recordOption_<?php echo $rowmainjoblist->idtbl_main_job_category ?>"
                                                            value="1">
                                                        <button type="button" id="btncreateorder"
                                                            class="btn btn-primary btn-sm px-4"
                                                            <?php if($addcheck==0){echo 'disabled';} ?>
                                                            onclick="insertAndUpdate(<?php echo $rowmainjoblist->idtbl_main_job_category ?>);"><i
                                                                class="fas fa-save"></i>&nbsp;Create Job </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <hr>


                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="scrollbar pb-3" id="style-2">
                            <div id="maindataTable"></div>
                        </div>
                    </div>


                </div>
            </div>

        </main>
        <?php include "include/footerbar.php"; ?>
    </div>
</div>

<!-- Seat Texture Details Modal -->


<div class="modal fade" id="myModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="seatTextureModalLabel" style="color: white;"><b>Stitch Design Types</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-12">
                    <div class="row">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="st_design_model_main_category_ID" />
                <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Close</button>
                <button type="button" class="btn btn-success applybtn">Apply Stitch Design</button>
            </div>
        </div>
    </div>
</div>


<!-- Add Extra Charges Modal -->
<div class="modal fade" id="extraChargeModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel" style="color: blue; font-weight: bold;">Add Extra
                    Charges
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo base_url() ?>JobCard_information/extraChargeUpdate" method="post"
                autocomplete="off">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <label class="small font-weight-bold text-dark">Accessory Name</label>
                            <select class="form-control form-control-sm selecter2 px-0" name="accessory_id"
                                id="accessory_id" required>
                                <option value="">Select</option>
                                <?php foreach($assessorylist->result() as $rowassessorylist){ ?>
                                <option value="<?php echo $rowassessorylist->idtbl_accessories ?>"
                                    data-price="<?php echo $rowassessorylist->accessory_price; ?>">
                                    <?php echo $rowassessorylist->accessory_name ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="small font-weight-bold text-dark">Price</label>
                            <input type="number" class="form-control form-control-sm px-0" id="charge_amount"
                                name="charge_amount" required>
                        </div>
                        <div class="col-6">
                            <label class="small font-weight-bold text-dark">Fixing Charge</label>
                            <input type="number" class="form-control form-control-sm px-0" id="fixing_amount"
                                name="fixing_amount" required>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="extra_main_id" id="extra_main_id">
                <input type="hidden" name="extra_sub_id" id="extra_sub_id">
                <input type="hidden" name="extra_job_id" id="extra_job_id">
                <input type="hidden" name="extra_seattype_id" id="extra_seattype_id">
                <input type="hidden" name="extra_jobcard_id" id="extra_jobcard_id">

                <input type="hidden" name="extra_jobcard_details_id" id="extra_jobcard_details_id">
                <div class="card-body p-0 p-2">
                    <div class="row">
                        <div class="col-8"></div>
                        <div class="col-4">
                            <div class="form-group mt-2 text-right">
                                <button type="button" id="submitBtnModel" class="btn btn-primary btn-sm px-4"
                                    onclick="insert_accessory();"><i class="far fa-save"></i>&nbsp;Add</button>
                            </div>

                            <input type="hidden" id="approvebtn_2" name="approvebtn_2">
                        </div>
                    </div>
                </div>

                <input type="hidden" name="recordOptionModel" id="recordOptionModel" value="1">
                <input type="hidden" name="recordIDTomodel" id="recordIDTomodel" value="">


            </form>


            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-12">
                                <div class="scrollbar pb-3" id="style-2">
                                    <table class="table table-bordered table-striped table-sm nowrap w-100"
                                        id="dataTable2">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Accessory Name</th>
                                                <th>Price</th>
                                                <th>Fixing Charge</th>
                                                <th>Total Charge</th>
                                                <th class="text-right">Actions</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Table Button -->
<button class="btn btn-secondary btn-sm" onclick="addextrachargeJobCard(1)">Add Extra Charges</button>



<?php include "include/footerscripts.php"; ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
$(document).ready(function() {
    $('#accessory_id').change(function() {
        var accessoryPrice = $(this).find('option:selected').data('price');

        $('#charge_amount').val(accessoryPrice);
    });
});
</script>


<script>
function openModal(main_job_id) {
    $("#myModal").modal("show");
    $('#st_design_model_main_category_ID').val(main_job_id);

    $.ajax({
        url: "<?php echo base_url('JobCard_information/GetDesigns'); ?>",
        type: "GET",
        dataType: "json",
        success: function(response) {
            let content = '';
            response.forEach(function(design) {
                content += `
                    <div class="col text-center">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="stitchingDesign_${main_job_id}" id="stitchingDesign_${design.idtbl_stitching_design}" value="${design.idtbl_stitching_design}">
                            <label class="form-check-label" for="design_${design.idtbl_stitching_design}">
                                <img style="width: 200px; height: 220px;" src="<?php echo base_url('images/Stitching_img/'); ?>${design.image_path}" alt="${design.image_path}">
                                <br><b style="color: white;">${design.stitching_code}</b>
                            </label>
                        </div>
                    </div>`;
            });
            $('#myModal .modal-body .row').html(content);
        },
        error: function(error) {
            console.error("Error fetching designs:", error);
        }
    });
}


function closeModal() {
    var modal = document.getElementById('myModal');
    modal.style.display = 'none';
}
</script>
<script>
$(document).ready(function() {
    $('.select2').select2({
        width: '100%',
    });
    $('#seat_type_id').select2({
        width: '100%',
    });
    $('#accessory_id').select2({
        dropdownParent: $('#extraChargeModal'),
        width: '100%',
    });


    var addcheck = '<?php echo $addcheck; ?>';
    var editcheck = '<?php echo $editcheck; ?>';
    var statuscheck = '<?php echo $statuscheck; ?>';
    var deletecheck = '<?php echo $deletecheck; ?>';

    $(document).ready(function() {
        var main_job_category_id = $('#main_job_id').val();

        $('#logo_' + main_job_category_id).on('select2:select', function() {
            const selectedValue = $(this).val();

            if (selectedValue == 2 || selectedValue == 1) {
                $('#logo_color_' + main_job_category_id).prop('disabled', true);
            } else {
                $('#logo_color_' + main_job_category_id).prop('disabled', false);
            }
        });

        $('#seatTypeDiv').addClass('d-none');
        $('#seatConditionDiv').addClass('d-none');
        $('#category_typeDiv').addClass('d-none');
        $('#repair_typeDiv').addClass('d-none');
        $('#materialDiv').removeClass('d-none');
        $('#japanSeatJobTbableDiv').addClass('d-none');
        $('#seatRepairJobTbableDiv').addClass('d-none');
        $('#japanSeatJobButtonDiv').addClass('d-none');
        $('#seatRepairJobButtonDiv').addClass('d-none');
        $('#productionAdviceDivBike_' + main_job_category_id).addClass('d-none');
        $('#cover_design_div_' + main_job_category_id).addClass('d-none');
        $('#middle_contentDiv_' + main_job_category_id).addClass('d-none');
        $('#hr_1').removeClass('d-none');
        $('#hr_1').addClass('d-none');

        $('#sub_job_category_' + main_job_category_id).on('select2:select', function() {
            const selectedValue_2 = $(this).val();

            if (selectedValue_2 === '1') {
                $('#seatTypeDiv').addClass('d-none');
                $('#seatConditionDiv').addClass('d-none');
                $('#materialDiv').removeClass('d-none');
                $('#middle_contentDiv_' + main_job_category_id).removeClass('d-none');
                $('#productionAdviceDivVehi_' + main_job_category_id).removeClass('d-none');
                $('#productionAdviceDivBike_' + main_job_category_id).addClass('d-none');
                $('#logodiv_' + main_job_category_id).removeClass('d-none');
                $('#logochargediv_' + main_job_category_id).removeClass('d-none');
                $('#thread_colordiv_' + main_job_category_id).removeClass('d-none');
                $('#material_div_' + main_job_category_id).removeClass('d-none');
                $('#material_charge_div_' + main_job_category_id).removeClass('d-none');
                $('#cover_design_div_' + main_job_category_id).removeClass('d-none');
                $('#japanSeatJobTbableDiv').addClass('d-none');
                $('#seatRepairJobTbableDiv').addClass('d-none');
                $('#japanSeatJobButtonDiv').addClass('d-none');
                $('#seatRepairJobButtonDiv').addClass('d-none');
                $('#category_typeDiv').addClass('d-none');
                $('#repair_typeDiv').addClass('d-none');
                $('#material_qty_div_' + main_job_category_id).removeClass('d-none');
                $('#dot_design_qty_div_' + main_job_category_id).removeClass('d-none');
                $('#stitch_style_qty_div_' + main_job_category_id).removeClass('d-none');
                $('#cushion_repair_qty_div_' + main_job_category_id).removeClass('d-none');
                $('#cover_design_qty_div_' + main_job_category_id).removeClass('d-none');
                $('#hybrid_div_' + main_job_category_id).removeClass('d-none');
                $('#hr_1').removeClass('d-none');

            } else if (selectedValue_2 === '8') {
                $('#seatTypeDiv').addClass('d-none');
                $('#seatConditionDiv').addClass('d-none');
                $('#materialDiv').removeClass('d-none');
                $('#middle_contentDiv_' + main_job_category_id).removeClass('d-none');
                $('#productionAdviceDivVehi_' + main_job_category_id).addClass('d-none');
                $('#productionAdviceDivBike_' + main_job_category_id).removeClass('d-none');
                $('#logochargediv_' + main_job_category_id).addClass('d-none');
                $('#logodiv_' + main_job_category_id).addClass('d-none');
                $('#thread_colordiv_' + main_job_category_id).removeClass('d-none');
                $('#material_div_' + main_job_category_id).addClass('d-none');
                $('#material_charge_div_' + main_job_category_id).addClass('d-none');
                $('#cover_design_div_' + main_job_category_id).removeClass('d-none');
                $('#japanSeatJobTbableDiv').addClass('d-none');
                $('#seatRepairJobTbableDiv').addClass('d-none');
                $('#japanSeatJobButtonDiv').addClass('d-none');
                $('#seatRepairJobButtonDiv').addClass('d-none');
                $('#category_typeDiv').addClass('d-none');
                $('#repair_typeDiv').addClass('d-none');
                $('#material_qty_div_' + main_job_category_id).addClass('d-none');
                $('#dot_design_qty_div_' + main_job_category_id).addClass('d-none');
                $('#stitch_style_qty_div_' + main_job_category_id).addClass('d-none');
                $('#cushion_repair_qty_div_' + main_job_category_id).addClass('d-none');
                $('#cover_design_qty_div_' + main_job_category_id).addClass('d-none');
                $('#hybrid_div_' + main_job_category_id).addClass('d-none');
                $('#hr_1').removeClass('d-none');


            } else if (selectedValue_2 === '9') {
                $('#seatTypeDiv').addClass('d-none');
                $('#seatConditionDiv').addClass('d-none');
                $('#materialDiv').addClass('d-none');
                $('#middle_contentDiv_' + main_job_category_id).addClass('d-none');
                $('#japanSeatJobTbableDiv').addClass('d-none');
                $('#seatRepairJobTbableDiv').removeClass('d-none');
                $('#japanSeatJobButtonDiv').addClass('d-none');
                $('#seatRepairJobButtonDiv').removeClass('d-none');
                $('#productionAdviceDivVehi_' + main_job_category_id).addClass('d-none');
                $('#productionAdviceDivBike_' + main_job_category_id).addClass('d-none');
                $('#category_typeDiv').removeClass('d-none');
                $('#repair_typeDiv').removeClass('d-none');
                $('#hr_1').addClass('d-none');


            } else {
                $('#seatTypeDiv').removeClass('d-none');
                $('#seatConditionDiv').removeClass('d-none');
                $('#materialDiv').addClass('d-none');
                $('#middle_contentDiv_' + main_job_category_id).addClass('d-none');
                $('#japanSeatJobTbableDiv').removeClass('d-none');
                $('#seatRepairJobTbableDiv').addClass('d-none');
                $('#japanSeatJobButtonDiv').removeClass('d-none');
                $('#seatRepairJobButtonDiv').addClass('d-none');
                $('#productionAdviceDivVehi_' + main_job_category_id).addClass('d-none');
                $('#productionAdviceDivBike_' + main_job_category_id).addClass('d-none');
                $('#category_typeDiv').addClass('d-none');
                $('#repair_typeDiv').addClass('d-none');
                $('#hr_1').addClass('d-none');
            }

        });
    });



    $(document).ready(function() {
        $(".hybrid_comfort_layer").change(function() {
            var selectedOption = $(this).find("option:selected");
            var price = parseFloat(selectedOption.data("price")) || 0;
            var categoryId = $(this).data("category");

            $("#hybrid_comfort_price_" + categoryId).val(price);

            finaltotalcalculate(categoryId);
        });
    });

    $(document).ready(function() {
        $(".add_logo").change(function() {
            var selectedOption = $(this).find("option:selected");
            var price = parseFloat(selectedOption.data("price")) || 0;
            var categoryId = $(this).data("category");

            $("#logo_charge_" + categoryId).val(price);

            finaltotalcalculate(categoryId);
        });
    });


    $(document).ready(function() {

        $('#myModal .applybtn').on('click', function() {
            var main_job_id = $('#st_design_model_main_category_ID').val();
            const selectedDesignId = $('input[name="stitchingDesign_' + main_job_id +
                '"]:checked').val();

            if (!selectedDesignId) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning!',
                    text: 'Please select a Design before applying.',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK',
                    backdrop: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    showConfirmButton: true,
                    showClass: {
                        popup: ''
                    },
                    hideClass: {
                        popup: ''
                    }
                });
                return;
            }
            $('#design_id_' + main_job_id).val(selectedDesignId);
            getStitchingDesignPrice(selectedDesignId, main_job_id);

            $('#myModal').modal('hide');
            updateProductionAdvice(main_job_id);

        });
    });



    $(document).on('click', '[data-toggle="collapse"]', function() {
        var main_job_category_id = $(this).data('id');
        var jobNameSelect = $('#job_name_' + main_job_category_id);
        jobNameSelect.empty();
        jobNameSelect.append("<option value=''>Select</option>");

        var collapseElement = $('#collapse' + main_job_category_id);

        collapseElement.on('shown.bs.collapse', function() {
            $.ajax({
                url: '<?php echo base_url('SalesJobsDetails/Getsubjobcategory'); ?>',
                type: 'post',
                data: {
                    main_job_category_id: main_job_category_id
                },
                dataType: 'json',
                success: function(response) {
                    var len = response.length;
                    var subJobCategoryId =
                        '#sub_job_category_' +
                        main_job_category_id;

                    $(subJobCategoryId).empty();
                    $(subJobCategoryId).append(
                        "<option value=''>Select</option>");

                    for (var i = 0; i < len; i++) {
                        var id = response[i][
                            'idtbl_sub_job_category'
                        ];
                        var name = response[i][
                            'sub_job_category'
                        ];
                        $(subJobCategoryId).append(
                            "<option value='" + id + "'>" +
                            name + "</option>");
                    }
                }
            });
        });
        collapseElement.on('hidden.bs.collapse', function() {
            var subJobCategoryId = '#sub_job_category_' +
                main_job_category_id;
            $(subJobCategoryId).empty();
            $(subJobCategoryId).append("<option value=''>Select</option>");
        });
    });


    $(document).on('change', '[id^="sub_job_category_"]', function() {
        var main_job_category_id = $(this).data('maincategoryid');
        var sub_job_category_id = $(this).val();

        if (sub_job_category_id != '' && sub_job_category_id != '2') {
            $.ajax({
                url: '<?php echo base_url('JobCard_information/Getsalesjobdetails'); ?>',
                type: 'post',
                data: {
                    main_job_category_id: main_job_category_id,
                    sub_job_category_id: sub_job_category_id
                },
                dataType: 'json',
                success: function(response) {
                    var len = response.length;

                    var jobNameSelect = $('#job_name_' +
                        main_job_category_id);
                    jobNameSelect.empty();
                    jobNameSelect.append(
                        "<option value=''>Select</option>");


                    for (var i = 0; i < len; i++) {
                        var id = response[i][
                            'idtbl_sales_jobs_details'
                        ];
                        var name = response[i]['sales_job_name'];

                        jobNameSelect.append("<option value='" + id +
                            "'>" + name +
                            "</option>");
                    }

                    updateProductionAdvice(main_job_category_id);
                }
            });
        } else {
            var jobNameSelect = $('#job_name_' + main_job_category_id);
            jobNameSelect.empty();
            jobNameSelect.append("<option value=''>Select</option>");
            $('#material_id_' + main_job_category_id).val('').trigger('change');
            resetSeat_coverFields(main_job_category_id);
            updateProductionAdvice(main_job_category_id);
        }
    });



    $(document).on('change', '[id^="seat_condition_id_"]', function() {
        var main_job_category_id = $('#main_job_id').val();

        $('#jobprice_' + main_job_category_id).val('');
        $('#job_name_' + main_job_category_id).val('').trigger('change');
        $('#seat_type_id').val('').trigger('change');
        $('#qty_' + main_job_category_id).val('');

    });

    $(document).on('change', '[id^="material_incert_type_"]', function() {
        var main_job_category_id = $('#main_job_id').val();

        $('#material_incert_' + main_job_category_id).val('').trigger('change');
        $('#material_incert_charge_' + main_job_category_id).val('0');
        $('#material_incert_qty_' + main_job_category_id).val('0');

    });

    $(document).on('change', '[id^="price_category_id_in_cover_design"]', function() {
        var main_job_category_id = $('#main_job_id').val();

        $('#add_cover_design_' + main_job_category_id).prop('checked', false);
        $('#cover_design_charge_' + main_job_category_id).val('');
        $('#cover_design_qty_' + main_job_category_id).val('');

    });

    $(document).on('change', '[id^="price_category_id_in_stitch"]', function() {
        var main_job_category_id = $('#main_job_id').val();

        $('#design_id_' + main_job_category_id).val('');
        $('#design_charge_' + main_job_category_id).val('');
        $('#stitch_design_qty_' + main_job_category_id).val(''); 

    });

    $(document).on('change', '[id^="price_category_id_in_dot"]', function() {
        var main_job_category_id = $('#main_job_id').val();

        $('#dot_design_' + main_job_category_id).val('').trigger('change');
        $('#dot_design_charge_' + main_job_category_id).val('');
        $('#dot_design_qty_' + main_job_category_id).val(''); 

    });

    $(document).on('change', '[id^="price_category_id_cushion_repair"]', function() {
        var main_job_category_id = $('#main_job_id').val();

        $('#cushion_repair_' + main_job_category_id).val('').trigger('change');
        $('#cushion_repair_charge_' + main_job_category_id).val('');
        $('#cushion_repair_qty_' + main_job_category_id).val(''); 

    });

    $(document).on('change', '[id^="price_category_id_in_cushion_modification"]', function() {
        var main_job_category_id = $('#main_job_id').val();

        $('#add_cushion_modification_' + main_job_category_id).prop('checked', false);
        $('#cushion_modifi_charge_' + main_job_category_id).val('');
        $('#cushion_modifi_qty_' + main_job_category_id).val(''); 

    });

    $(document).on('change', '[id^="price_category_id_in_cushion_replacement"]', function() {
        var main_job_category_id = $('#main_job_id').val();

        $('#add_cushion_replacement_' + main_job_category_id).prop('checked', false);
        $('#cushion_replacement_charge_' + main_job_category_id).val('');
        $('#cushion_replacement_qty_' + main_job_category_id).val(''); 

    });


    $(document).on('change', '[id^="sub_job_category_"]', function() {
        var main_job_category_id = $(this).data('maincategoryid');
        var sub_job_category_id = $(this).val();


        if (sub_job_category_id != '') {
            $.ajax({
                url: '<?php echo base_url('JobCard_information/Getseat_type'); ?>',
                type: 'post',
                data: {
                    main_job_category_id: main_job_category_id,
                    sub_job_category_id: sub_job_category_id
                },
                dataType: 'json',
                success: function(response) {
                    var len = response.length;

                    var jobNameSelect = $('#seat_type_id');
                    jobNameSelect.empty();
                    jobNameSelect.append(
                        "<option value=''>Select</option>");


                    for (var i = 0; i < len; i++) {
                        var id = response[i][
                            'idtbl_seat_type'
                        ];
                        var name = response[i]['seat_type'];

                        jobNameSelect.append("<option value='" + id +
                            "'>" + name +
                            "</option>");
                    }

                    $('#material_id_' + main_job_category_id).val('').trigger('change');
                    $('#seat_condition_id_' + main_job_category_id).val('').trigger(
                        'change');
                    resetSeat_coverFields(main_job_category_id);
                }
            });
        }
    });



    $(document).on('change', '[id^="seat_type_id"]', function() {
        var main_job_category_id = $('#main_job_id').val();
        var sub_job_category_id = $('#sub_job_category_' + main_job_category_id).val();
        var seat_condition_id = $('#seat_condition_id_' + main_job_category_id).val();
        var seat_type_id = $(this).val();

        if (seat_type_id != '') {
            $.ajax({
                url: '<?php echo base_url('JobCard_information/Get_japanseat_jobdetails'); ?>',
                type: 'post',
                data: {
                    main_job_category_id: main_job_category_id,
                    sub_job_category_id: sub_job_category_id,
                    seat_type_id: seat_type_id,
                    seat_condition_id: seat_condition_id
                },
                dataType: 'json',
                success: function(response) {
                    var len = response.length;

                    var jobNameSelect = $('#job_name_' +
                        main_job_category_id);
                    jobNameSelect.empty();
                    jobNameSelect.append(
                        "<option value=''>Select</option>");


                    for (var i = 0; i < len; i++) {
                        var id = response[i][
                            'idtbl_sales_jobs_details'
                        ];
                        var name = response[i]['sales_job_name'];
                        jobNameSelect.append("<option value='" + id +
                            "'>" + name +
                            "</option>");
                    }

                    $('#jobprice_' + main_job_category_id).val('');
                    $('#material_id_' + main_job_category_id).val('').trigger('change');
                    resetSeat_coverFields(main_job_category_id);
                }
            });
        } else {
            // var jobNameSelect = $('#job_name_' + main_job_category_id);
            // jobNameSelect.empty();
            // jobNameSelect.append("<option value=''>Select</option>");
        }

    });

    $(document).on('change', '[id^="job_name_"]', function() {
        var main_job_category_id = $('#main_job_id').val();
        var sub_job_category_id = $('#sub_job_category_' + main_job_category_id).val();
        var job_id = $(this).val();

        if (seat_type_id != '') {
            $.ajax({
                url: '<?php echo base_url('JobCard_information/Get_repair_typedetails'); ?>',
                type: 'post',
                data: {
                    main_job_category_id: main_job_category_id,
                    sub_job_category_id: sub_job_category_id,
                    job_id: job_id
                },
                dataType: 'json',
                success: function(response) {
                    var len = response.length;

                    var jobNameSelect = $('#repair_type_id_' +
                        main_job_category_id);
                    jobNameSelect.empty();
                    jobNameSelect.append(
                        "<option value=''>Select</option>");


                    for (var i = 0; i < len; i++) {
                        var id = response[i][
                            'idtbl_seat_repair_category'
                        ];
                        var name = response[i]['sub_Repair_job_name'];
                        jobNameSelect.append("<option value='" + id +
                            "'>" + name +
                            "</option>");
                    }
                    $('#category_type_id_' + main_job_category_id).val('').trigger(
                        'change');

                }
            });
        } else {
            // var jobNameSelect = $('#job_name_' + main_job_category_id);
            // jobNameSelect.empty();
            // jobNameSelect.append("<option value=''>Select</option>");
        }

    });


    $(document).on('change', '[id^="job_name"]', function() {
        var vehicle_model_id = $('#vehi_model_id').val();
        var main_job_category_id = $(this).data('maincategoryid');
        var sub_job_category = $('#sub_job_category_' + main_job_category_id).val();
        var job_name = $('#job_name_' + main_job_category_id).val();
        var material_id = '0';
        var seat_type_id = $('#seat_type_id').val();
        var seat_condition_id = $('#seat_condition_id_' + main_job_category_id).val();

        $('#material_id_' + main_job_category_id).val('').css('pointer-events', 'fill');

        if (vehicle_model_id && main_job_category_id && sub_job_category && job_name) {
            $.ajax({
                type: "POST",
                data: {
                    material_id: material_id,
                    vehicle_model_id: vehicle_model_id,
                    main_job_category: main_job_category_id,
                    sub_job_category: sub_job_category,
                    job_name: job_name,
                    seat_type_id: seat_type_id,
                    seat_condition_id: seat_condition_id
                },
                url: '<?php echo base_url() ?>JobCard_information/getJobprice',
                success: function(result) {
                    var obj = JSON.parse(result);
                    $('#jobprice_' + main_job_category_id).val(obj.price);

                    if (obj.material_id == '0') {
                        $('#material_id_' + main_job_category_id).val('').css(
                            'pointer-events', 'none');
                    }
                    $('#qty_' + main_job_category_id).val('');
                    $('#material_id_' + main_job_category_id).val('').trigger('change');
                    resetSeat_coverFields(main_job_category_id)

                }
            });
        } else {

        }
    });


    $(document).on('change', '[id^="material_id_"]', function() {
        var main_job_category_id = $(this).data('maincategoryid');

        var material_id = $('#material_id_' + main_job_category_id).val();
        var vehicle_model_id = $('#vehi_model_id').val();
        var main_job_category = $('#main_job_id').val();
        var sub_job_category = $('#sub_job_category_' + main_job_category_id).val();
        var job_name = $('#job_name_' + main_job_category_id).val();

        if (material_id && vehicle_model_id && main_job_category && sub_job_category && job_name) {
            $.ajax({
                type: "POST",
                data: {
                    material_id: material_id,
                    vehicle_model_id: vehicle_model_id,
                    main_job_category: main_job_category,
                    sub_job_category: sub_job_category,
                    job_name: job_name
                },
                url: '<?php echo base_url() ?>JobCard_information/getJobprice',
                success: function(result) {
                    var obj = JSON.parse(result);
                    $('#jobprice_' + main_job_category_id).val(obj.price);
                    finaltotalcalculate(main_job_category_id);
                    resetSeat_coverFields(main_job_category_id)


                }
            });
        }
        return false;

    });



    $(document).on('change', '[id^="repair_type_id_"]', function() {
        var main_job_category_id = $(this).data('maincategoryid');

        var repair_type_id = $('#repair_type_id_' + main_job_category_id).val();
        var vehicle_model_id = $('#vehi_model_id').val();
        var main_job_category = $('#main_job_id').val();
        var sub_job_category = $('#sub_job_category_' + main_job_category_id).val();
        var job_name = $('#job_name_' + main_job_category_id).val();

        if (repair_type_id && vehicle_model_id && main_job_category && sub_job_category && job_name) {
            $.ajax({
                type: "POST",
                data: {
                    repair_type_id: repair_type_id,
                    vehicle_model_id: vehicle_model_id,
                    main_job_category: main_job_category,
                    sub_job_category: sub_job_category,
                    job_name: job_name
                },
                url: '<?php echo base_url() ?>JobCard_information/getJobprice',
                success: function(result) {
                    var obj = JSON.parse(result);
                    $('#jobprice_' + main_job_category_id).val(obj.price);

                    finaltotalcalculate(main_job_category_id);
                    resetSeat_coverFields(main_job_category_id);

                }
            });
        }
        return false;
    });



    $(document).on('change', '[id^="category_type_id_"]', function() {
        var main_job_category_id = $(this).data('maincategoryid');

        var category_type_id = $('#category_type_id_' + main_job_category_id).val();
        var vehicle_model_id = $('#vehi_model_id').val();
        var main_job_category = $('#main_job_id').val();
        var sub_job_category = $('#sub_job_category_' + main_job_category_id).val();
        var job_name = $('#job_name_' + main_job_category_id).val();

        if (category_type_id && vehicle_model_id && main_job_category && sub_job_category && job_name) {
            $.ajax({
                type: "POST",
                data: {
                    category_type_id: category_type_id,
                    vehicle_model_id: vehicle_model_id,
                    main_job_category: main_job_category,
                    sub_job_category: sub_job_category,
                    job_name: job_name
                },
                url: '<?php echo base_url() ?>JobCard_information/getJobprice',
                success: function(result) {
                    var obj = JSON.parse(result);
                    $('#jobprice_' + main_job_category_id).val(obj.price);

                    finaltotalcalculate(main_job_category_id);
                    resetSeat_coverFields(main_job_category_id);
                }
            });
        }
        return false;
    });




    $(document).ready(function() {
        function checkConditions() {
            var mainJobId = $('#main_job_id').val();
            var subJobCategory = $('#sub_job_category_' + mainJobId).val();
            var jobName = $('#job_name_' + mainJobId).val();

            if (mainJobId == "1" && subJobCategory == "9" && (jobName == "26" || jobName == "28" ||
                    jobName == "29")) {
                $("#repair_typeDiv").show();
                $("#category_typeDiv").hide();
            } else {
                $("#repair_typeDiv").hide();
                $("#category_typeDiv").show();
            }
        }

        $(document).on('change', '[id^=sub_job_category_], [id^=job_name_]', function() {
            checkConditions();
        });

        checkConditions();
    });


    $(document).ready(function() {
        var jobcard_id = $('#jobcard_id').val();
        console.log('jobcard_id:', jobcard_id);

        if (jobcard_id != '') {
            $.ajax({
                url: '<?php echo base_url('JobCard_information/GetjobcardNumber'); ?>',
                type: 'POST',
                data: {
                    jobcard_id: jobcard_id

                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#jobcard_num').val(response.job_card_number);
                    } else {}
                },
            });
        } else {
            console.error('Jobcard ID is empty!');
        }
    });

    $(document).ready(function() {
        var main_job_category_id = $('#main_job_id').val();
        var price_cat_id = $('#price_cat_id').val();
        // console.log('main_job_id:', main_job_category_id);

        if (price_cat_id != '') {
            $.ajax({
                url: '<?php echo base_url('JobCard_information/GetPrice_cat'); ?>',
                type: 'POST',
                data: {
                    price_cat_id: price_cat_id

                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        var selectedValue = response.idtbl_price_category_type;

                        // Set value for price_category_id
                        $('#price_category_id').val(selectedValue).trigger('change');

                        // Also set the same value for price_categoryid
                        $('#price_category_id_in_dot' + main_job_category_id).val(
                            selectedValue).trigger('change');
                        $('#price_category_id_in_stitch' + main_job_category_id).val(
                            selectedValue).trigger('change');
                        $('#price_category_id_in_cover_design' + main_job_category_id).val(
                            selectedValue).trigger('change');
                        $('#price_category_id_cushion_repair' + main_job_category_id).val(
                            selectedValue).trigger('change');
                        $('#price_category_id_in_cushion_modification' +
                            main_job_category_id).val(
                            selectedValue).trigger('change');
                        $('#price_category_id_in_cushion_replacement' +
                            main_job_category_id).val(
                            selectedValue).trigger('change');

                    } else {

                    }
                },
            });
        } else {
            console.error('Cate ID is empty!');
        }
        // When price_category_id is changed

        $('#price_category_id').on('change', function() {
            var selectedValue = $(this).val();
            $('#price_category_id_in_dot' + main_job_category_id).val(selectedValue).trigger(
                'change');
            $('#price_category_id_in_stitch' + main_job_category_id).val(selectedValue).trigger(
                'change');
            $('#price_category_id_in_cover_design' + main_job_category_id).val(selectedValue)
                .trigger('change');
            $('#price_category_id_cushion_repair' + main_job_category_id).val(
                selectedValue).trigger('change');
            $('#price_category_id_in_cushion_modification' + main_job_category_id).val(
                selectedValue).trigger('change');
            $('#price_category_id_in_cushion_replacement' +
                main_job_category_id).val(
                selectedValue).trigger('change');

            //reset dot design fields//
            $('#dot_design_' + main_job_category_id).val('').trigger('change');
            $('#dot_design_charge_' + main_job_category_id).val('0').trigger('change');
            $('#dot_design_qty_' + main_job_category_id).val('0').trigger('change');

            //reset stitch design fields//
            $('#design_id_' + main_job_category_id).val('').trigger('change');
            $('#design_charge_' + main_job_category_id).val('0').trigger('change');
            $('#stitch_design_qty_' + main_job_category_id).val('0').trigger('change');

            //reset cover design fields//
            $('#add_cover_design_' + main_job_category_id).prop('checked', false);
            $('#cover_design_charge_' + main_job_category_id).val('0').trigger('change');
            $('#cover_design_qty_' + main_job_category_id).val('0').trigger('change');

            //reset cushion repair fields//
            $('#cushion_repair_' + main_job_category_id).val('').trigger('change');
            $('#cushion_repair_charge_' + main_job_category_id).val('0').trigger('change');
            $('#cushion_repair_qty_' + main_job_category_id).val('0').trigger('change');

            //reset cushion modification fields//
            $('#add_cushion_modification_' + main_job_category_id).prop('checked', false);
            $('#cushion_modifi_charge_' + main_job_category_id).val('0').trigger('change');
            $('#cushion_modifi_qty_' + main_job_category_id).val('0').trigger('change');

            //reset cushion replacement fields//
            $('#add_cushion_replacement_' + main_job_category_id).prop('checked', false);
            $('#cushion_replacement_charge_' + main_job_category_id).val('0').trigger('change');
            $('#cushion_replacement_qty_' + main_job_category_id).val('0').trigger('change');

        });
    });


    $(document).ready(function() {
        var vehi_model_id = $('#vehi_model_id').val();
        console.log('vehi_model_id:', vehi_model_id);

        if (vehi_model_id != '') {
            $.ajax({
                url: '<?php echo base_url('JobCard_information/GetvehicleModel'); ?>',
                type: 'POST',
                data: {
                    vehi_model_id: vehi_model_id

                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#vehicle_model').val(response.model_name);
                    } else {}
                },
            });
        } else {
            console.error('Vehicle Model ID is empty!');
        }
    });



    var jobcard_id = $('#jobcard_id').val();


    dataTable();

    $('#dataTable tbody').on('click', '.btnEdit', function() {
        var r = confirm("Are you sure, You want to Edit this ? ");
        if (r == true) {
            var id = $(this).attr('id');
            $.ajax({
                type: "POST",
                data: {
                    recordID: id
                },
                url: '<?php echo base_url() ?>Vehicle_year/Vehicle_yearedit',
                success: function(result) {
                    var obj = JSON.parse(result);
                    $('#recordID').val(obj.id);
                    $('#year_name').val(obj.year_name);

                    $('#recordOption').val('2');
                    $('#submitBtn').html(
                        '<i class="far fa-save"></i>&nbsp;Update');
                }
            });
        }
    });
});

$(document).on('change', '[id^="material_incert_"]', function() {
    var material_incert = $(this).val();
    var main_job_category_id = $(this).data('maincategoryid');
    var material_incert_type = $('#material_incert_type_' + main_job_category_id).val();

    // console.log('material_incert_type:', material_incert_type);

    material_insertPrice(material_incert, main_job_category_id,material_incert_type);
    updateProductionAdvice(main_job_category_id);
});

$(document).on('change', '[id^="pipening_design_"]', function() {
    var pipening_design = $(this).val();
    var main_job_category_id = $(this).data('maincategoryid');

    getpipening_designPrice(pipening_design, main_job_category_id);
    updateProductionAdvice(main_job_category_id);
});


$(document).on('change', '[id^="dot_design_"]', function() {
    var dot_design = $(this).val();
    var main_job_category_id = $(this).data('maincategoryid');

    getDotDesignPrice(dot_design, main_job_category_id);
    updateProductionAdvice(main_job_category_id);
});

$(document).on('change', '[id^="add_logo_"]', function() {
    var logo_status = $(this).val();
    var main_job_category_id = $(this).data('category');

    console.log('logo_status:', logo_status, 'main_job_category_id:', main_job_category_id);

    updateProductionAdvice(main_job_category_id);
});

$(document).on('change', '[id^="cushion_repair_"]', function() {
    var cushion_repair = $(this).val();
    var main_job_category_id = $(this).data('maincategoryid');

    getCushion_repairPrice(cushion_repair, main_job_category_id);
    updateProductionAdvice(main_job_category_id);
});


$(document).on('change', '[id^="add_cushion_replacement_"]', function() {
    var main_job_category_id = $(this).data('maincategoryid');
    if (this.checked) {
        getCushionReplacementPrice(main_job_category_id);
    } else {
        $('#cushion_replacement_charge_' + main_job_category_id).val(0);
        finaltotalcalculate(main_job_category_id);
    }

});

$(document).on('change', '[id^="add_cushion_modification_"]', function() {
    var main_job_category_id = $(this).data('maincategoryid');
    if (this.checked) {
        getcushionModificationPrice(main_job_category_id);
    } else {
        $('#cushion_modifi_charge_' + main_job_category_id).val(0);
        finaltotalcalculate(main_job_category_id);
    }

});

$(document).on('change', '[id^="add_cover_design_"]', function() {
    var main_job_category_id = $(this).data('maincategoryid');
    if (this.checked) {
        getcoverDesignPrice(main_job_category_id);
    } else {
        $('#cover_design_charge_' + main_job_category_id).val(0);
        finaltotalcalculate(main_job_category_id);
    }

});


function toggleSection(sectionId) {
    $("#" + sectionId).slideToggle();
    let label = $("label[onclick='toggleSection(\"" + sectionId + "\")']");
    let icon = label.find(".toggle-icon");
    // icon.text(icon.text() === "+" ? "-" : "+");
}


function getCushionReplacementPrice(main_job_category_id) {
    var vehicle_model_id = $('#vehi_model_id').val();
    var job_id = $('#job_name_' + main_job_category_id).val();
    var price_cat_id = $('#price_category_id_in_cushion_replacement' + main_job_category_id).val();

    if (vehicle_model_id) {
        $.ajax({
            url: '<?php echo base_url('JobCard_information/getCushionReplacementPrice'); ?>',
            type: 'POST',
            data: {
                vehicle_model_id: vehicle_model_id,
                job_id: job_id,
                price_cat_id: price_cat_id,
            },
            success: function(response) {
                var obj = JSON.parse(response);
                $('#cushion_replacement_charge_' + main_job_category_id).val(obj.material_design_price);

                finaltotalcalculate(main_job_category_id);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching material design price:', error);
            }
        });
    } else {
        console.error('Vehicle model ID is empty!');
    }
}


function getcushionModificationPrice(main_job_category_id) {
    var vehicle_model_id = $('#vehi_model_id').val();
    var job_id = $('#job_name_' + main_job_category_id).val();
    var price_cat_id = $('#price_category_id_in_cushion_modification' + main_job_category_id).val();


    if (vehicle_model_id) {
        $.ajax({
            url: '<?php echo base_url('JobCard_information/getcushionModificationPrice'); ?>',
            type: 'POST',
            data: {
                vehicle_model_id: vehicle_model_id,
                job_id: job_id,
                price_cat_id: price_cat_id,
            },
            success: function(response) {
                var obj = JSON.parse(response);
                $('#cushion_modifi_charge_' + main_job_category_id).val(obj.cushion_modify_price);

                finaltotalcalculate(main_job_category_id);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching material design price:', error);
            }
        });
    } else {
        console.error('Vehicle model ID is empty!');
    }
}


function getcoverDesignPrice(main_job_category_id) {
    var vehicle_model_id = $('#vehi_model_id').val();
    var job_id = $('#job_name_' + main_job_category_id).val();
    var price_cat_id = $('#price_category_id_in_cover_design' + main_job_category_id).val();

    if (vehicle_model_id) {
        $.ajax({
            url: '<?php echo base_url('JobCard_information/getcoverDesignPrice'); ?>',
            type: 'POST',
            data: {
                vehicle_model_id: vehicle_model_id,
                job_id: job_id,
                price_cat_id: price_cat_id,
            },
            success: function(response) {
                var obj = JSON.parse(response);
                $('#cover_design_charge_' + main_job_category_id).val(obj.cover_design_price);

                finaltotalcalculate(main_job_category_id);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching material design price:', error);
            }
        });
    } else {
        console.error('Vehicle model ID is empty!');
    }
}

function getCushion_repairPrice(cushion_repair, main_job_category_id) {
    var vehicle_model_id = $('#vehi_model_id').val();
    var job_id = $('#job_name_' + main_job_category_id).val();
    var price_cat_id = $('#price_category_id_cushion_repair' + main_job_category_id).val();

    if (cushion_repair != '') {
        $.ajax({
            url: '<?php echo base_url('JobCard_information/getCushion_repairPrice'); ?>',
            type: 'POST',
            data: {
                cushion_repair: cushion_repair,
                vehicle_model_id: vehicle_model_id,
                job_id: job_id,
                price_cat_id: price_cat_id,
            },
            success: function(response) {
                var obj = JSON.parse(response);
                $('#cushion_repair_charge_' + main_job_category_id).val(obj.cushion_pepair_price);

                finaltotalcalculate(main_job_category_id);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching dot design price:', error);
            }
        });
    } else {
        console.error('cushion repair  ID is empty!');
    }
}


function getDotDesignPrice(dot_design, main_job_category_id) {
    var vehicle_model_id = $('#vehi_model_id').val();
    var job_id = $('#job_name_' + main_job_category_id).val();
    var price_cat_id = $('#price_category_id_in_dot' + main_job_category_id).val();

    // console.log('price_category_id_in_dot:', price_cat_id);

    if (dot_design != '') {
        $.ajax({
            url: '<?php echo base_url('JobCard_information/GetDotdesignPrice'); ?>',
            type: 'POST',
            data: {
                dot_design: dot_design,
                vehicle_model_id: vehicle_model_id,
                job_id: job_id,
                price_cat_id: price_cat_id
            },
            success: function(response) {
                var obj = JSON.parse(response);
                $('#dot_design_charge_' + main_job_category_id).val(obj.dot_design_price);

                finaltotalcalculate(main_job_category_id);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching dot design price:', error);
            }
        });
    } else {
        console.error('Dot design ID is empty!');
    }
}


function material_insertPrice(material_incert, main_job_category_id, material_incert_type) {
    var vehicle_model_id = $('#vehi_model_id').val();
    var job_id = $('#job_name_' + main_job_category_id).val();
    // var material_incert_type = $('#material_incert_type_' + main_job_category_id).val();

    console.log('mateerial_incert_type:', material_incert_type, 'main_job_category_id:', main_job_category_id, 'material_incert:', material_incert);

    if (material_incert != '' && material_incert_type != '') {
        $.ajax({
            url: '<?php echo base_url('JobCard_information/material_insertPrice'); ?>',
            type: 'POST',
            data: {
                material_incert: material_incert,
                vehicle_model_id: vehicle_model_id,
                material_incert_type: material_incert_type,
                job_id: job_id
            },
            success: function(response) {
                var obj = JSON.parse(response);
                $('#material_incert_charge_' + main_job_category_id).val(obj.special_material_incert_price);

                finaltotalcalculate(main_job_category_id);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching Material Insert price:', error);
            }
        });
    } else {
        console.error('Material Insert ID is empty!');
    }
}



function getpipening_designPrice(pipening_design, main_job_category_id) {
    var vehicle_model_id = $('#vehi_model_id').val();
    var job_id = $('#job_name_' + main_job_category_id).val();

    // console.log('price_category_id_in_dot:', price_cat_id);

    if (pipening_design != '') {
        $.ajax({
            url: '<?php echo base_url('JobCard_information/getpipening_designPrice'); ?>',
            type: 'POST',
            data: {
                pipening_design: pipening_design,
                vehicle_model_id: vehicle_model_id,
                job_id: job_id
            },
            success: function(response) {
                var obj = JSON.parse(response);
                $('#pipening_design_charge_' + main_job_category_id).val(obj.pipening_design_price);

                finaltotalcalculate(main_job_category_id);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching pipening design price:', error);
            }
        });
    } else {
        console.error('pipening design ID is empty!');
    }
}


function getStitchingDesignPrice(design_id, main_job_id) {
    var vehicle_model_id = $('#vehi_model_id').val();
    var job_id = $('#job_name_' + main_job_id).val();
    var price_cat_id = $('#price_category_id_in_stitch' + main_job_id).val();

    console.log('price_category_id:', price_cat_id);

    if (design_id != '') {
        $.ajax({
            url: '<?php echo base_url('JobCard_information/GetdesignPrice'); ?>',
            type: 'POST',
            data: {
                design_id: design_id,
                vehicle_model_id: vehicle_model_id,
                job_id: job_id,
                price_cat_id: price_cat_id
            },
            success: function(response) {
                var obj = JSON.parse(response);
                $('#design_charge_' + main_job_id).val(obj.design_price);

                finaltotalcalculate(main_job_id);
            },
        });
    } else {
        console.error('Design ID is empty!');
    }
}


function finaltotalcalculate(main_job_id) {

    var defult_logo_charge = 2600;
    var finalgrosstotal = 0;

    var sub_job_category = $('#sub_job_category_' + main_job_id).val();
    var discount = parseFloat($("#discount_" + main_job_id).val());
    if (isNaN(discount)) {
        discount = 0;
        $("#discount_" + main_job_id).val(0);
    }

    if (sub_job_category == '8') {
        var qty = parseFloat($("#qty_" + main_job_id).val());
        var job_price = parseFloat($("#jobprice_" + main_job_id).val());

        if (isNaN(qty)) {
            qty = 0;
            $("#qty_" + main_job_id).val(0);
        }

        if (isNaN(job_price)) {
            job_price = 0;
            $("#jobprice_" + main_job_id).val(0);
        }

        finalgrosstotal = qty * job_price;

        // Gross amount calculation with design amount

        var design_charge = parseFloat($("#design_charge_" + main_job_id).val());
        finalgrosstotal = finalgrosstotal + (isNaN(design_charge) ? 0 : design_charge);

        // Gross amount calculation with Dot design amount

        var dot_design_charge = parseFloat($("#dot_design_charge_" + main_job_id).val());
        finalgrosstotal = finalgrosstotal + (isNaN(dot_design_charge) ? 0 : dot_design_charge);

        // Gross amount calculation with cushion Repair amount

        var cushion_repair_charge = parseFloat($("#cushion_repair_charge_" + main_job_id).val());
        finalgrosstotal = finalgrosstotal + (isNaN(cushion_repair_charge) ? 0 : cushion_repair_charge);

        // Gross amount calculation with cover design amount

        var cover_design_charge_ = parseFloat($("#cover_design_charge_" + main_job_id).val());
        finalgrosstotal = finalgrosstotal + (isNaN(cover_design_charge_) ? 0 : cover_design_charge_);





    } else if (sub_job_category == '1') {
        var qty = parseFloat($("#qty_" + main_job_id).val());
        var job_price = parseFloat($("#jobprice_" + main_job_id).val());

        if (isNaN(qty)) {
            qty = 0;
            $("#qty_" + main_job_id).val(0);
        }

        if (isNaN(job_price)) {
            job_price = 0;
            $("#jobprice_" + main_job_id).val(0);
        }

        finalgrosstotal = qty * job_price;

        // Gross amount calculation with logo price
        var input_logo_charge = $('#logo_charge_' + main_job_id).val();
        var logo_qty = parseFloat($("#logo_qty_" + main_job_id).val());

        if (isNaN(logo_qty)) {
            logo_qty = 0;
            $("#logo_qty_" + main_job_id).val(0);
        }

        finalgrosstotal = finalgrosstotal + ((isNaN(input_logo_charge) ? 0 : input_logo_charge) * (isNaN(
            logo_qty) ? 0 : logo_qty));

        // Gross amount calculation with design amount

        var design_charge = parseFloat($("#design_charge_" + main_job_id).val());
        var design_charge_qty = parseFloat($("#stitch_design_qty_" + main_job_id).val());

        if (isNaN(design_charge_qty)) {
            design_charge_qty = 0;
            $("#stitch_design_qty_" + main_job_id).val(0);
        }

        finalgrosstotal = finalgrosstotal + ((isNaN(design_charge) ? 0 : design_charge) * (isNaN(design_charge_qty) ?
            0 : design_charge_qty));

        // Gross amount calculation with Dot design amount

        var dot_design_charge = parseFloat($("#dot_design_charge_" + main_job_id).val());
        var dot_design_qty = parseFloat($("#dot_design_qty_" + main_job_id).val());

        if (isNaN(dot_design_qty)) {
            dot_design_qty = 0;
            $("#dot_design_qty_" + main_job_id).val(0);
        }
        finalgrosstotal = finalgrosstotal + ((isNaN(dot_design_charge) ? 0 : dot_design_charge) * (isNaN(
            dot_design_qty) ? 0 : dot_design_qty));

        // Gross amount calculation with cushion Repair amount

        var cushion_repair_charge = parseFloat($("#cushion_repair_charge_" + main_job_id).val());
        var cushion_repair_qty = parseFloat($("#cushion_repair_qty_" + main_job_id).val());

        if (isNaN(cushion_repair_qty)) {
            cushion_repair_qty = 0;
            $("#cushion_repair_qty_" + main_job_id).val(0);
        }

        finalgrosstotal = finalgrosstotal + ((isNaN(cushion_repair_charge) ? 0 : cushion_repair_charge) * (isNaN(
            cushion_repair_qty) ? 0 : cushion_repair_qty));

        // Gross amount calculation with material design amount

        var cushion_replacement_charge = parseFloat($("#cushion_replacement_charge_" + main_job_id).val());
        var cushion_replacement_qty = parseFloat($("#cushion_replacement_qty_" + main_job_id).val());

        if (isNaN(cushion_replacement_qty)) {
            cushion_replacement_qty = 0;
            $("#cushion_replacement_qty_" + main_job_id).val(0);
        }

        finalgrosstotal = finalgrosstotal + ((isNaN(cushion_replacement_charge) ? 0 : cushion_replacement_charge) * (
            isNaN(
                cushion_replacement_qty) ? 0 : cushion_replacement_qty));

        // Gross amount calculation with cover design amount

        var cover_design_charge_ = parseFloat($("#cover_design_charge_" + main_job_id).val());
        var cover_design_qty = parseFloat($("#cover_design_qty_" + main_job_id).val());

        if (isNaN(cover_design_qty)) {
            cover_design_qty = 0;
            $("#cover_design_qty_" + main_job_id).val(0);
        }

        finalgrosstotal = finalgrosstotal + ((isNaN(cover_design_charge_) ? 0 : cover_design_charge_) * (isNaN(
            cover_design_qty) ? 0 : cover_design_qty));

        // Gross amount calculation with Hybrid Comfort Layer amount

        var hybrid_comfort_price = parseFloat($("#hybrid_comfort_price_" + main_job_id).val());
        var hybrid_comfort_qty = parseFloat($("#hybrid_comfort_qty_" + main_job_id).val());

        if (isNaN(hybrid_comfort_qty)) {
            hybrid_comfort_qty = 0;
            $("#hybrid_comfort_qty_" + main_job_id).val(0);
        }

        finalgrosstotal = finalgrosstotal + ((isNaN(hybrid_comfort_price) ? 0 : hybrid_comfort_price) * (isNaN(
            hybrid_comfort_qty) ? 0 : hybrid_comfort_qty));



    } else if (sub_job_category == '9') {
        $("#seatRepairJobTbable tbody tr:visible .japan_seat_total_price").each(function() {
            var rowTotal = parseFloat($(this).text());
            if (!isNaN(rowTotal)) {
                finalgrosstotal += rowTotal;
            }
        });

    } else {
        $("#japanSeatJobTable tbody tr:visible .japan_seat_total_price").each(function() {
            var rowTotal = parseFloat($(this).text());
            if (!isNaN(rowTotal)) {
                finalgrosstotal += rowTotal;
            }
        });
    }

    $('#gross_amount_' + main_job_id).val(finalgrosstotal.toFixed(2));
    $('#sub_total_' + main_job_id).val(finalgrosstotal.toFixed(2));

    // Discount amount calculation
    var discount_amount = (finalgrosstotal / 100) * discount;
    $('#discount_amount_' + main_job_id).val(discount_amount.toFixed(2));

    // Subtotal after discount
    var finalsub_total = finalgrosstotal - discount_amount;
    $('#sub_total_' + main_job_id).val(finalsub_total.toFixed(2));
}


function checkedDublicate(input) {

    // var inputValue = input.value;
    // var tablename = 'tbl_vehicle_year';
    // var columnName = input.getAttribute('data-field');

    // $.ajax({
    //     url: '<?php echo base_url() ?>CheckDublicate/check_duplicate',
    //     type: 'POST',
    //     data: {
    //         input_value: inputValue,
    //         tablename: tablename,
    //         column_name: columnName
    //     },
    //     dataType: 'json',
    //     success: function(response) {
    //         if (response.status === 'error') {
    //             $('#' + columnName + '_errorMsg').text(response.message).show();
    //         } else {
    //             $('#' + columnName + '_errorMsg').hide();
    //         }
    //     }
    // });
}

function insertAndUpdate(main_jobID) {

    var jobcard_id = $('#jobcard_id').val();
    var main_job_id = main_jobID;
    var sub_job_category = $('#sub_job_category_' + main_jobID).val();
    var seat_condition_id = $('#seat_condition_id_' + main_jobID).val();
    var seat_type_id = $('#seat_type_id').val();
    var job_name = $('#job_name_' + main_jobID).val();
    var jobprice = $("#jobprice_" + main_jobID).val();
    var qty = $("#qty_" + main_jobID).val();

    var tbody_2 = $("#seatRepairJobTbable tbody tr:visible");
    seatRepairTbableData = [];

    var tbody = $("#japanSeatJobTable tbody tr:visible");
    japanSeatTableData = [];

    if (sub_job_category == '1' || sub_job_category == '8') {
        if (!sub_job_category || !job_name || !jobprice || !qty) {
            toastr.error('Please fill out all required fields.', 'Validation Error');
            $('#btncreateorder')
                .prop('disabled', false)
                .html('<i class="fas fa-save mr-2"></i> Create Job Price');
            return;
        }

    } else if (sub_job_category == '9') {
        if (tbody_2.children().length > 0) {
            $("#seatRepairJobTbable tbody tr:visible").each(function() {
                item = {}
                $(this).find('td').each(function(col_idx) {
                    item["col_" + (col_idx + 1)] = $(this).text();
                });

                seatRepairTbableData.push(item);
            });
        } else {
            toastr.error('Please fill out table.', 'Validation Error');
            $('#btncreateorder')
                .prop('disabled', false)
                .html('<i class="fas fa-save mr-2"></i> Create Job Price');
            return false;
        }


    } else {
        if (tbody.children().length > 0) {
            $("#japanSeatJobTable tbody tr:visible").each(function() {
                item = {}
                $(this).find('td').each(function(col_idx) {
                    item["col_" + (col_idx + 1)] = $(this).text();
                });

                japanSeatTableData.push(item);
            });
        } else {
            toastr.error('Please fill out table.', 'Validation Error');
            $('#btncreateorder')
                .prop('disabled', false)
                .html('<i class="fas fa-save mr-2"></i> Create Job Price');
            return false;
        }
    }



    var material_id = $('#material_id_' + main_jobID).val();
    var production_advice = $('input[name="production_advice"]:checked').val();
    var logo = $('#add_logo_' + main_jobID).is(`:checked`) ? 1 : 0;
    var logo_charge = $('#logo_charge_' + main_jobID).val();
    var logo_type = $('#logo_' + main_jobID).val();
    var logo_color = $('#logo_color_' + main_jobID).val();
    var thread_color = $('#thread_color_' + main_jobID).val();
    var dot_design = $('#dot_design_' + main_jobID).val();
    var dot_design_charge = $('#dot_design_charge_' + main_jobID).val();
    var stitch_design_id = $('#design_id_' + main_jobID).val();
    var stitch_design_charge = $('#design_charge_' + main_jobID).val();
    var stitch_style = $('#stitch_style_' + main_jobID).val();
    var add_cushion_replacement = $('#add_cushion_replacement_' + main_jobID).is(`:checked`) ? 1 : 0;
    var cushion_replacement_charge = $('#cushion_replacement_charge_' + main_jobID).val();
    var add_cover_design = $('#add_cover_design_' + main_jobID).is(`:checked`) ? 1 : 0;
    var cover_design_charge = $('#cover_design_charge_' + main_jobID).val();
    var cushion_repair = $('#cushion_repair_' + main_jobID).val();
    var cushion_repair_charge = $('#cushion_repair_charge_' + main_jobID).val();
    var hybrid_comfort_layer = $('#hybrid_comfort_layer_' + main_jobID).val();
    var hybrid_comfort_price = $('#hybrid_comfort_price_' + main_jobID).val();
    var hybrid_comfort_qty = $("#hybrid_comfort_qty_" + main_jobID).val();
    var logo_qty = $("#logo_qty_" + main_jobID).val();
    var dot_design_qty = $("#dot_design_qty_" + main_jobID).val();
    var stitch_design_qty = $("#stitch_design_qty_" + main_jobID).val();
    var cushion_replacement_qty = $("#cushion_replacement_qty_" + main_jobID).val();
    var cushion_repair_qty = $("#cushion_repair_qty_" + main_jobID).val();
    var cover_design_qty = $("#cover_design_qty_" + main_jobID).val();


    var gross_amount = $('#gross_amount_' + main_jobID).val();
    var discount = $('#discount_' + main_jobID).val();
    var discount_amount = $('#discount_amount_' + main_jobID).val();
    var sub_total = $('#sub_total_' + main_jobID).val();


    var recordOption = $('#recordOption_' + main_jobID).val();
    var recordID = $('#recordID_' + main_jobID).val();


    $.ajax({
        type: "POST",
        data: {
            jobcard_id: jobcard_id,
            main_job_id: main_job_id,
            sub_job_category: sub_job_category,
            seat_condition_id: seat_condition_id,
            seat_type_id: seat_type_id,
            job_name: job_name,
            material_id: material_id,
            jobprice: jobprice,
            qty: qty,
            production_advice: production_advice,
            logo_charge: logo_charge,
            logo: logo,
            logo_type: logo_type,
            logo_color: logo_color,
            thread_color: thread_color,
            dot_design: dot_design,
            dot_design_charge: dot_design_charge,
            stitch_design_id: stitch_design_id,
            stitch_design_charge: stitch_design_charge,
            stitch_style: stitch_style,
            add_cushion_replacement: add_cushion_replacement,
            cushion_replacement_charge: cushion_replacement_charge,
            add_cover_design: add_cover_design,
            cover_design_charge: cover_design_charge,
            cushion_repair: cushion_repair,
            cushion_repair_charge: cushion_repair_charge,
            japanSeatTableData: japanSeatTableData,
            seatRepairTbableData: seatRepairTbableData,
            logo_qty: logo_qty,
            dot_design_qty: dot_design_qty,
            stitch_design_qty: stitch_design_qty,
            cushion_replacement_qty: cushion_replacement_qty,
            cushion_repair_qty: cushion_repair_qty,
            cover_design_qty: cover_design_qty,
            hybrid_comfort_layer: hybrid_comfort_layer,
            hybrid_comfort_price: hybrid_comfort_price,
            hybrid_comfort_qty: hybrid_comfort_qty,

            gross_amount: gross_amount,
            discount: discount,
            discount_amount: discount_amount,
            sub_total: sub_total,
            recordOption: recordOption,
            recordID: recordID

        },
        url: '<?php echo base_url() ?>JobCard_information/JobCard_informationinsertupdate',
        success: function(result) {
            var objfirst = JSON.parse(result);
            if (objfirst.status == 1) {
                var actionData = JSON.parse(objfirst.action);
                toastr.success(actionData.message, 'Success');
                // $('#dataTable').DataTable().ajax.reload();
                dataTable();
                resetInputFields(main_jobID);
            } else {
                toastr.error(actionData.message, 'Error');
            }
            $('#btncreateorder').prop('disabled', false).html(
                '<i class="fas fa-save mr-2"></i> Create Job Price')
        }
    });

}

function resetInputFields(main_jobID) {
    $('#sub_job_category_' + main_jobID).val('').trigger('change');
    $('#seat_condition_id_' + main_jobID).val('').trigger('change');
    $('#seat_type_id').val('').trigger('change');
    $('#job_name_' + main_jobID).val('').trigger('change');
    $('#jobprice_' + main_jobID).val('');
    $('#qty_' + main_jobID).val('');
    $('#add_logo_' + main_jobID).val('').trigger('change');

    $("input[name='production_advice']").prop("checked", false);
    $('#recordOption_' + main_jobID).val('1');
    $('#logo_' + main_jobID).val('').trigger('change');
    $('#logo_color_' + main_jobID).val('').trigger('change');
    $('#logo_charge_' + main_jobID).val('');
    $('#material_id_' + main_jobID).val('').trigger('change');
    $('#thread_color_' + main_jobID).val('').trigger('change');
    $('#dot_design_' + main_jobID).val('').trigger('change');
    $('#dot_design_charge_' + main_jobID).val('');
    $('#design_id_' + main_jobID).val('');
    $('#design_charge_' + main_jobID).val('');
    $('#stitch_style_' + main_jobID).val('').trigger('change');
    $('#add_cushion_replacement_' + main_jobID).prop('checked', false);
    $('#cushion_replacement_charge_' + main_jobID).val('');
    $('#add_cover_design_' + main_jobID).prop('checked', false);
    $('#cover_design_charge_' + main_jobID).val('');
    $('#cushion_repair_' + main_jobID).val('').trigger('change');
    $('#cushion_repair_charge_' + main_jobID).val('');

    $('#gross_amount_' + main_jobID).val('');
    $('#discount_' + main_jobID).val('');
    $('#discount_amount_' + main_jobID).val('');
    $('#sub_total_' + main_jobID).val('');

    $("#japanSeatJobTable tbody").empty();

}

function resetSeat_coverFields(main_jobID) {

    $('#qty_' + main_jobID).val('');
    $('#add_logo_' + main_jobID).val('').trigger('change');

    $('#logo_qty_' + main_jobID).val('0');
    $('#dot_design_qty_' + main_jobID).val('0');
    $('#cushion_repair_qty_' + main_jobID).val('0');
    $('#stitch_design_qty_' + main_jobID).val('0');
    $('#cushion_modifi_qty_' + main_jobID).val('0');
    $('#cushion_replacement_qty_' + main_jobID).val('0');
    $('#hybrid_comfort_qty_' + main_jobID).val('0');
    $('#pipening_design_qty_' + main_jobID).val('0');

    $("input[name='production_advice']").prop("checked", false);
    $('#logo_' + main_jobID).val('').trigger('change');
    $('#logo_color_' + main_jobID).val('').trigger('change');
    $('#logo_charge_' + main_jobID).val('0');

    $('#thread_color_' + main_jobID).val('').trigger('change');
    $('#dot_design_' + main_jobID).val('').trigger('change');
    $('#dot_design_charge_' + main_jobID).val('0');
    $('#design_id_' + main_jobID).val('');
    $('#design_charge_' + main_jobID).val('0');
    $('#stitch_style_' + main_jobID).val('').trigger('change');
    $('#add_cushion_replacement_' + main_jobID).prop('checked', false);
    $('#cushion_replacement_charge_' + main_jobID).val('0');
    $('#cushion_repair_' + main_jobID).val('').trigger('change');
    $('#cushion_repair_charge_' + main_jobID).val('0');
    $('#add_cover_design_' + main_jobID).prop('checked', false);
    $('#cover_design_charge_' + main_jobID).val('0');

    $('#add_cushion_modification_' + main_jobID).prop('checked', false);
    $('#cushion_modifi_charge_' + main_jobID).val('0');

    $('#hybrid_comfort_layer_' + main_jobID).val('').trigger('change');
    $('#hybrid_comfort_price_' + main_jobID).val('0');

    $('#pipening_design_' + main_jobID).val('').trigger('change');
    $('#pipening_design_charge_' + main_jobID).val('');
    $('#cover_design_charge_' + main_jobID).val('');
    $('#material_incert_type_' + main_jobID).val('').trigger('change');

    $('#gross_amount_' + main_jobID).val('0');
    $('#discount_' + main_jobID).val('0');
    $('#discount_amount_' + main_jobID).val('0');
    $('#sub_total_' + main_jobID).val('0');


}

function updateProductionAdvice(mainCategoryID) {

    var dotDesignValue = $('#dot_design_' + mainCategoryID).val();
    var cushionRepairValue = $('#cushion_repair_' + mainCategoryID).val();
    var designID = $('#design_id_' + mainCategoryID).val();
    var logo_status = $('#add_logo_' + mainCategoryID).val();
    console.log('add_logo_:', logo_status);

    if (designID !== "") {
        $('#oem3_' + mainCategoryID).prop('checked', true);
    } else {
        if (dotDesignValue == "3" || cushionRepairValue == "3" || logo_status == "3") {
            $('#oem3_' + mainCategoryID).prop('checked', true);
        } else if (dotDesignValue == "2" || cushionRepairValue == "2" || logo_status == "2") {
            $('#oem_' + mainCategoryID).prop('checked', true);
        } else {
            $('#oem_' + mainCategoryID).prop('checked', false);
        }
    }
}

function handleAddMaterialDesignChange(mainCategoryID) {
    var checkbox = $('#add_cushion_replacement_' + mainCategoryID);

    if (checkbox.is(':checked')) {
        checkbox.val(1);
        $('#oem3_' + mainCategoryID).prop('checked', true);
        $('#oem_' + mainCategoryID).prop('checked', false);
    } else {
        checkbox.val(0);
        $('#oem_' + mainCategoryID).prop('checked', true);
        $('#oem3_' + mainCategoryID).prop('checked', false);
        updateProductionAdvice(mainCategoryID);
    }
}

function handleAddCoverDesignChange(mainCategoryID) {
    var checkbox = $('#add_cover_design_' + mainCategoryID);

    if (checkbox.is(':checked')) {
        checkbox.val(1);
        $('#oem3_' + mainCategoryID).prop('checked', true);
    } else {
        checkbox.val(0);
        updateProductionAdvice(mainCategoryID);
    }
}




function multipleRepairAdd(main_id) {
    var sub_job_category = $('#sub_job_category_' + main_id).val();
    var sub_job_category_text = $('#sub_job_category_' + main_id + ' option:selected').text();

    var repair_type_id = $('#repair_type_id_' + main_id).val();
    var repair_type_text = $('#repair_type_id_' + main_id + ' option:selected').text();
    repair_type_text = repair_type_text === "Select" || !repair_type_id ? "" :
        repair_type_text;

    var category_type_id = $('#category_type_id_' + main_id).val();
    var category_type_text = $('#category_type_id_' + main_id + ' option:selected').text();
    category_type_text = category_type_text === "Select" || !category_type_id ? "" :
        category_type_text;

    var job_name = $('#job_name_' + main_id).val();
    var job_name_text = $('#job_name_' + main_id + ' option:selected').text();

    var jobprice = parseFloat($("#jobprice_" + main_id).val());
    var qty = parseFloat($("#qty_" + main_id).val());

    if (!job_name || job_name === '') {
        alert("Please select a job before adding.");
        return;
    }

    if (!jobprice || jobprice === '' || !qty || qty === '') {
        alert("Please enter both price and quantity.");
        return;
    }

    var total = (jobprice * qty).toFixed(2);

    var html = '';
    html += '<tr>';
    html += '<td>' + job_name_text + '</td>';
    html += '<td class="d-none">' + job_name + '</td>';
    html += '<td>' + repair_type_text + '</td>';
    html += '<td class="d-none">' + (repair_type_id ? repair_type_id : '') + '</td>';
    html += '<td>' + category_type_text + '</td>';
    html += '<td class="d-none">' + (category_type_id ? category_type_id : '') + '</td>';
    html += '<td>' + jobprice + '</td>';
    html += '<td>' + qty + '</td>';
    html += '<td class="text-right japan_seat_total_price">' + total + '</td>';
    html += '<td class="text-right"><button class="btn btn-sm btn-danger" onclick="deletejapansetjobrow(this, ' +
        main_id + ');"><i class="fas fa-trash-alt"></i></button></td>';
    html += '</tr>';

    $("#seatRepairJobTbable tbody").append(html);

    $('#job_name_' + main_id).val('').trigger('change');
    $('#repair_type_id_' + main_id).val('').trigger('change');
    $('#category_type_id_' + main_id).val('').trigger('change');
    $("#jobprice_" + main_id).val('');
    $("#qty_" + main_id).val('');

    finaltotalcalculate(main_id);
}



function multipleSeatsAdd(main_id) {
    var sub_job_category = $('#sub_job_category_' + main_id).val();
    var sub_job_category_text = $('#sub_job_category_' + main_id + ' option:selected').text();

    var seat_condition_id = $('#seat_condition_id_' + main_id).val();
    var seat_condition_text = $('#seat_condition_id_' + main_id + ' option:selected').text();

    var seat_type_id = $('#seat_type_id_' + main_id).val();
    var seat_type_text = $('#seat_type_id_' + main_id + ' option:selected').text();

    var job_name = $('#job_name_' + main_id).val();
    var job_name_text = $('#job_name_' + main_id + ' option:selected').text();

    var jobprice = parseFloat($("#jobprice_" + main_id).val());
    var qty = parseFloat($("#qty_" + main_id).val());

    if (!job_name || job_name === '') {
        alert("Please select a job before adding.");
        return;
    }

    if (!jobprice || jobprice === '' || !qty || qty === '') {
        alert("Please enter both price and quantity.");
        return;
    }

    var total = (jobprice * qty).toFixed(2);

    var html = '';
    html += '<tr>';
    html += '<td>' + job_name_text + '</td>';
    html += '<td class="d-none">' + job_name + '</td>';
    html += '<td>' + jobprice + '</td>';
    html += '<td>' + qty + '</td>';
    html += '<td class="text-right japan_seat_total_price">' + total + '</td>';
    html += '<td class="text-right"><button class="btn btn-sm btn-danger" onclick="deletejapansetjobrow(this, ' +
        main_id + ');"><i class="fas fa-trash-alt"></i></button></td>';
    html += '</tr>';

    $("#japanSeatJobTable tbody").append(html);

    $('#job_name_' + main_id).val('').trigger('change');
    $("#jobprice_" + main_id).val('');
    $("#qty_" + main_id).val('');

    finaltotalcalculate(main_id);
}

function deletejapansetjobrow(button, main_id) {
    $(button).closest('tr').remove();
    finaltotalcalculate(main_id);
}

function dataTable() {
    var jobcard_id = $('#jobcard_id').val();
    $.ajax({
        url: '<?php echo base_url() ?>JobCard_information/showDataTable',
        type: 'POST',
        data: {
            jobcard_id: jobcard_id
        },
        success: function(response) {
            $('#maindataTable').html(response);
        }
    });
    $('#dataTable').DataTable;
    showPropOver();
}

function showPropOver() {
    $('[data-toggle="popover"]').popover({
        html: true
    });

    $(document).on('click', function(e) {
        $('[data-toggle="popover"]').each(function() {
            if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e
                    .target).length === 0) {
                $(this).popover('hide');
            }
        });
    });
}


// extra charges

function addextrachargeJobCard(main_id, sub_id, seattype, job_id, job_card_id, jobcard_details_id) {
    $('#extra_main_id').val(main_id);
    $('#extra_sub_id').val(sub_id);
    $('#extra_seattype_id').val(seattype);
    $('#extra_job_id').val(job_id);
    $('#extra_jobcard_id').val(job_card_id);
    $('#extra_jobcard_details_id').val(jobcard_details_id);
    $('#recordIDTomodel').val(job_id);
    $('#extraChargeModal').modal('show');


    $('#dataTable2').DataTable({
        "destroy": true,
        "processing": true,
        "serverSide": true,
        dom: "<'row'<'col-sm-5'B><'col-sm-2'l><'col-sm-5'f>>" + "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        responsive: true,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
        "buttons": [{
                extend: 'csv',
                className: 'btn btn-success btn-sm',
                title: 'Customer Information',
                text: '<i class="fas fa-file-csv mr-2"></i> CSV',
            },
            {
                className: 'btn btn-danger btn-sm',
                text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
                action: function(e, dt, node, config) {

                }
            }
        ],
        ajax: {
            url: "<?php echo base_url() ?>scripts/accessorylist.php",
            type: "POST",
            "data": function(d) {
                return $.extend({}, d, {
                    "main_job_id": main_id,
                    "sub_job_id": sub_id,
                    "job_details_id": jobcard_details_id,
                });
            }
        },
        "order": [
            [0, "desc"]
        ],
        "columns": [

            {
                "data": "idtbl_accessory_detail"
            },
            {
                "data": "accessory_name"
            },
            {
                "data": "accessory_amount"
            },
            {
                "data": "fixing_charge_amount"
            },
            {
                "data": "tot_extra_charge_amount"
            },
            {
                "targets": -1,
                "className": 'text-right',
                "data": null,
                "render": function(data, type, full) {
                    var button = '';

                    // Edit button
                    button +=
                        '<button class="btn btn-primary btn-sm btnEditModel mr-1 ';

                    button += '" id="' + full['idtbl_accessory_detail'] +
                        '"title="Edit Vehicle""><i class="fas fa-pen"></i></button>';
                    // Delete  button
                    button +=
                        '<button class="btn btn-danger btn-sm btnDelete ';

                    button +=
                        '" id="' + full['idtbl_accessory_detail'] +
                        '" "title="Delete Vehicle""><i class="fas fa-trash-alt"></i></button>';
                    return button;
                }
            }
        ],
        drawCallback: function(settings) {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });

}


//  delete button model
$('#dataTable2').on('click', '.btnDelete', function() {
    var details_id = $(this).attr('id');

    if (confirm('Are you sure you want to delete this Extra Charge?')) {
        $.ajax({
            url: "<?php echo base_url(); ?>JobCard_information/Extra_charges_status/" + details_id +
                "/3",
            type: "POST",
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    toastr.success(response.message, 'Success');
                    $('#dataTable2').DataTable().ajax.reload();
                } else {
                    toastr.error(response.message, 'Error');
                }
            },
            error: function() {
                toastr.error('An error occurred.', 'Error');
            }

        });
    }
});

// Model data Edit
$('#dataTable2').on('click', '.btnEditModel', function() {
    var r = confirm("Are you sure, You want to Edit this Extra Charge?");
    if (r == true) {
        var id = $(this).attr('id');
        $.ajax({
            type: "POST",
            data: {
                recordID: id
            },
            url: '<?php echo base_url() ?>JobCard_information/Extra_charges_edit',
            success: function(result) {
                var obj = JSON.parse(result);

                $('#recordIDTomodel').val(obj.id);
                $('#accessory_id').val(obj.accessory_id).trigger(
                    'change');
                $('#charge_amount').val(obj.accessory_amount);
                $('#fixing_amount').val(obj.fixing_amount);
                // setTimeout(function() {
                //     $('#vehi_model_id_model').val(obj.vehicle_model_id).trigger(
                //         'change');
                // }, 500);

                $('#recordOptionModel').val('2');
                $('#submitBtnModel').html(
                    '<i class="far fa-save"></i>&nbsp;Update');

                $('#extraChargeModal').modal('show');
            },
        });
    }
});


function insert_accessory() {
    var model_main_id = $('#extra_main_id').val();
    var model_sub_id = $('#extra_sub_id').val();
    var model_extra_job_id = $('#extra_job_id').val();
    var model_extra_jobcard_id = $('#extra_jobcard_id').val();
    var model_extra_job_id = $('#extra_job_id').val();
    var extra_jobcard_details_id = $('#extra_jobcard_details_id').val();
    var model_seattype_id = $('#extra_seattype_id').val();
    var model_accessory_id = $('#accessory_id').val();
    var model_charge_amount = parseFloat($('#charge_amount').val()) || 0;
    var model_fixing_amount = parseFloat($('#fixing_amount').val()) || 0;
    var tot_extra_charge_amount = model_charge_amount + model_fixing_amount;

    var recordIDTomodel = $('#recordIDTomodel').val();
    var recordOptionModel = $('#recordOptionModel').val();

    console.log('Total Extra Charge Amount', tot_extra_charge_amount);


    $.ajax({
        url: '<?php echo base_url(); ?>JobCard_information/AddextraCharge',
        type: 'POST',
        data: {
            model_main_id: model_main_id,
            model_sub_id: model_sub_id,
            model_seattype_id: model_seattype_id,
            model_accessory_id: model_accessory_id,
            model_charge_amount: model_charge_amount,
            model_fixing_amount: model_fixing_amount,
            tot_extra_charge_amount: tot_extra_charge_amount,
            extra_jobcard_details_id: extra_jobcard_details_id,
            recordIDTomodel: recordIDTomodel,
            recordOptionModel: recordOptionModel
        },
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                toastr.success(response.message, 'Success');
                $('#dataTable2').DataTable().ajax.reload();
            } else {
                toastr.error(response.message, 'Error');
            }
        },
        error: function() {
            toastr.error('An error occurred.', 'Error');
        }
    });
}


function deleteJobCard(idtbl_job_card_detail) {

    if (confirm('Are you sure you want to delete this job card?')) {
        $.ajax({
            type: 'POST',
            data: {
                recordID: idtbl_job_card_detail
            },
            url: '<?php echo base_url(); ?>JobCard_information/DeleteJobCard',
            success: function(result) { //alert(result);
                var objfirst = JSON.parse(result);
                if (objfirst.status == 1) {
                    var actionData = JSON.parse(objfirst.action);
                    toastr.success(actionData.message, 'Success');
                    dataTable();
                } else {
                    toastr.error(actionData.message, 'Error');
                }
            }
        });
    }
}



function deactive_confirm() {
    return confirm("Are you sure you want to deactive this?");
}

function active_confirm() {
    return confirm("Are you sure you want to active this?");
}

function delete_confirm() {
    return confirm("Are you sure you want to remove this?");
}
</script>
<?php include "include/footer.php"; ?>