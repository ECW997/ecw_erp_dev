<?php 
include "include/header.php";  
include "include/topnavbar.php"; 
?>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <?php include "include/menubar.php"; ?>
    </div>
    <div id="layoutSidenav_content">
        <style>
        #porderviewmodal .modal-content {
            border: 4px solid #0982e6;
            /* Light blue color */
            border-radius: 25px;
            /* Optional: Add rounded corners */
        }

        #porderviewmodal2 .modal-content {
            border: 4px solid #0982e6;
            /* Light blue color */
            border-radius: 25px;
            /* Optional: Add rounded corners */
        }
        </style>

        <style>
        .input-like {
            display: inline-block;
            padding: 6px 12px;
            border: 1px solid #ced4da;
            /* Matches the default Bootstrap input border color */
            border-radius: 4px;
            /* Matches the default Bootstrap input border radius */
            background-color: #fff;
            /* White background */
            color: #495057;
            /* Text color */
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
            /* Inner shadow to match input fields */
            width: 100%;
            height: 50%;
        }
        </style>
        <style>
        .whatsapp-btn {
            transition: transform 0.3s ease, background-color 0.3s ease;
        }

        .whatsapp-btn:hover {
            transform: scale(1.1);
            background-color: #25d366;
            /* WhatsApp green */
        }

        .whatsapp-btn:active {
            transform: scale(0.95);
        }
        </style>
        <!-- Modal -->

        <style>
        .table tbody tr {
            cursor: default;
        }

        .table-warning,
        .table-warning>th,
        .table-warning>td {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .table-warning th,
        .table-warning td,
        .table-warning thead th,
        .table-warning tbody+tbody {
            border-color: rgba(0, 0, 0, 0.05);
        }
        </style>


        <main>
            <div class="page-header page-header-light bg-white shadow">
                <div class="container-fluid">
                    <div class="page-header-content py-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fas fa-calendar-times"></i></div>
                            <span>Cancel Appointment Customer Inquiry</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="container-fluid mt-2 p-0 p-2">
                            <div class="container-fluid mt-2 p-0 p-2">
                                <div class="card">
                                    <div class="card-body p-0 p-2">
                                        <div class="form-row mb-1">
                                            <div class="col-2">
                                                <div style="display: flex; align-items: center; margin-top: 10px;">
                                                    <!-- Red square and description -->
                                                    <div
                                                        style="width: 20px; height: 20px; background-color: #FFB2D0; margin-right: 10px; border: 2px solid black;">
                                                    </div>
                                                    <span>Non follow up</span>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div style="display: flex; align-items: center; margin-top: 10px;">
                                                    <!-- Blue square and description -->
                                                    <div
                                                        style="width: 20px; height: 20px; background-color: #ccffcc; margin-right: 10px; border: 2px solid black;">
                                                    </div>
                                                    <span>First follow up</span>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div style="display: flex; align-items: center; margin-top: 10px;">
                                                    <!-- Green square and description -->
                                                    <div
                                                        style="width: 20px; height: 20px; background-color: #FAF884; margin-right: 10px; border: 2px solid black;">
                                                    </div>
                                                    <span>Second follow up</span>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div
                                                    style="display: flex; align-items: center; margin-top: 10px; border: 2px;">
                                                    <!-- Green square and description -->
                                                    <div
                                                        style="width: 20px; height: 20px; background-color: #6CC417; margin-right: 10px;border: 2px solid black;">
                                                    </div>
                                                    <span>Follow up done</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="container-fluid mt-2 p-0 p-2">
                                <div class="card">
                                    <div class="card-body p-0 p-2">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="scrollbar pb-3" id="style-2">
                                                    <table
                                                        class="table table-bordered table-striped table-sm nowrap w-100"
                                                        id="dataTable">
                                                        <thead>
                                                            <tr>
                                                                <th>Inquiry Number</th>
                                                                <th>Inquiry Source </th>
                                                                <th>Customer Name</th>
                                                                <th>Mobile Number</th>
                                                                <th>Vehicle Number</th>
                                                                <th>Vehicle Brand</th>
                                                                <th>Vehicle Model</th>
                                                                <th>Vehicle Year</th>
                                                                <th>Sales Person</th>
                                                                <th>Coordinator</th>
                                                                <th>Appointment</th>
                                                                <th>Appointment Date</th>
                                                                <th>Image Delivery</th>
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
            </div>
        </main>
        <?php include "include/footerbar.php"; ?>
    </div>
</div>
<style>
/* Add this style block to your HTML or external CSS file */

/* Define the animation */
@keyframes pulse {
    0% {
        transform: scale(1);
    }

    50% {
        transform: scale(1.1);
    }

    100% {
        transform: scale(1);
    }
}

/* Apply the animation to the button on hover */
#submitBtn:hover {
    animation: pulse 0.5s infinite;
    border-color: #4CAF50;
    /* Change border color on hover */
    background-color: #4CAF50;
    /* Change background color on hover */
    color: #fff;
    /* Change text color on hover */
}

#submitBtn_2:hover {
    animation: pulse 0.5s infinite;
    border-color: #4CAF50;
    /* Change border color on hover */
    background-color: #4CAF50;
    /* Change background color on hover */
    color: #fff;
    /* Change text color on hover */
}
</style>
<!-- Modal -->
<div id="purchaseview">
    <div class="modal fade" id="porderviewmodal" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel" style="color: blue;">View Customer Inquiry & Follow
                        Ups</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6 text-left">
                            <img src="./images/ecw_logo_2.jpg" alt="" width="40%" style="margin-top: -15px;">
                        </div>
                        <div class="col-6">
                            <h2 style="margin-bottom: 2px; color: black;font-family: cursive;font-size:20px;font-weight: bold; padding:0;"
                                class="text-right">Customer Inquiry<span id="pr"></span></h2>
                            <p style="margin-bottom: 2px; font-family: cursive;font-size:15px; font-weight: bold; padding-top: 8px;padding:0;"
                                class="text-right" class="text-right"><span id="viewcompanyname"></span>
                            </p>
                            <p style="margin-bottom: 2px; font-family: cursive;font-size:15px; font-weight: bold; padding-top: 8px;padding:0;"
                                class="text-right" class="text-right"> <span id="viewbranchname"></span>
                            </p>
                            <!-- <p style="margin-bottom: 2px; font-family: cursive;font-size:15px;padding-top: 8px;padding:0;"
                                class="text-right"><span id="porder_number"></span></p> -->
                            <!-- <p style="margin-bottom: 2px;" class="text-right">0775678923 <span id="pronumber"></span>
							</p> -->
                            <!-- Other elements go here -->

                        </div>
                    </div>
                    </br>
                    <div class="row">
                        <div class="col-6">
                            <p style="margin-bottom: 2px; font-family: cursive;font-size:15px; font-weight: bold; padding-top: 8px;padding:0;"
                                class="text-left">Customer Name:&nbsp;<span id="customername"></span></P>
                            <p style="margin-bottom: 2px; font-family: cursive;font-size:15px; font-weight: bold; padding-top: 8px;padding:0;"
                                class="text-left">Vehicle Brand:&nbsp;<span id="brandname"></span></P>
                            <p style="margin-bottom: 2px;" class="text-left"><span id="porderaddress1"></span></p>
                            <p style="margin-bottom: 2px;" class="text-left"><span id="porderaddress2"></span></p>
                            <p style="margin-bottom: 2px;" class="text-left"><span id="pordercity"></span></p>
                            <p style="margin-bottom: 2px;" class="text-left"><span id="porderstate"></span></p>
                        </div>
                    </div>



                    <div id="viewhtml"></div>
                    <h5
                        style="text-align: left; font-family: cursive; font-size: 15px; font-weight: bold; color: #FF4500;">
                        First Follow up information</h5>

                    <div class="row">
                        <div class="col-6">
                            <p style="margin-bottom: 2px; font-family: cursive;font-size:15px; font-weight: bold; padding-top: 8px;padding:0;"
                                class="text-left">Sales Person Name:&nbsp;<span id="s_personname"></span></P>
                        </div>
                        <div class="col-6">
                            <p style="margin-bottom: 2px; font-family: cursive; font-size: 15px; font-weight: bold; padding-top: 8px; padding: 0;"
                                class="text-left"> First Follow up Status:&nbsp;<span id="follow_1"></span></p>
                        </div>
                        <div class="col-6">
                            <p style="margin-bottom: 2px; font-family: cursive;font-size:15px; font-weight: bold; padding-top: 8px;padding:0;"
                                class="text-left">Customer Reply:&nbsp;<span id="customer_reply"></span></P>
                        </div>
                        <div class="col-6">
                            <p style="margin-bottom: 2px; font-family: cursive;font-size:15px; font-weight: bold; padding-top: 8px;padding:0;"
                                class="text-left">Remark:&nbsp;<span id="remark"></span></P>

                        </div>
                    </div>

                    <br>

                    <h5
                        style="text-align: left; font-family: cursive; font-size: 15px; font-weight: bold; color: #FF4500;">
                        Second Follow up information</h5>

                    <div class="row">
                        <div class="col-6">
                            <p style="margin-bottom: 2px; font-family: cursive; font-size: 15px; font-weight: bold; padding-top: 8px; padding: 0;"
                                class="text-left"> Second Follow up Status:&nbsp;<span id="follow_2"></span></p>
                        </div>
                        <div class="col-6">
                            <p style="margin-bottom: 2px; font-family: cursive;font-size:15px; font-weight: bold; padding-top: 8px;padding:0;"
                                class="text-left">Customer Reply:&nbsp;<span id="customer_reply_2"></span></P>
                        </div>
                        <div class="col-6">
                            <p style="margin-bottom: 2px; font-family: cursive;font-size:15px; font-weight: bold; padding-top: 8px;padding:0;"
                                class="text-left">Remark:&nbsp;<span id="remark2"></span></P>

                        </div>
                    </div>


                    <br>

                    <h5
                        style="text-align: left; font-family: cursive; font-size: 15px; font-weight: bold; color: #FF4500;">
                        Third Follow up information</h5>

                    <div class="row">
                        <div class="col-6">
                            <p style="margin-bottom: 2px; font-family: cursive; font-size: 15px; font-weight: bold; padding-top: 8px; padding: 0;"
                                class="text-left"> Third Follow up Status:&nbsp;<span id="follow_3"></span></p>
                        </div>
                        <div class="col-6">
                            <p style="margin-bottom: 2px; font-family: cursive;font-size:15px; font-weight: bold; padding-top: 8px;padding:0;"
                                class="text-left">Customer Reply:&nbsp;<span id="customer_reply_3"></span></P>
                        </div>
                        <div class="col-6">
                            <p style="margin-bottom: 2px; font-family: cursive;font-size:15px; font-weight: bold; padding-top: 8px;padding:0;"
                                class="text-left">Remark:&nbsp;<span id="remark3"></span></P>

                        </div>
                    </div>

                </div>
                <input type="hidden" class="form-control form-control-sm" name="tableId" id="tableId" required readonly>
            </div>
        </div>
    </div>
</div>


<!-- Modal View 2-->
<div id="purchaseview">
    <div class="modal fade" id="porderviewmodal2" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel"
                        style="color: blue; font-weight: bold; font-size: 1.5em;">
                        Reschedule Appointment
                    </h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-6 text-left">
                            <img src="./images/ecw_logo_2.jpg" alt="" width="40%" style="margin-top: -15px;">
                        </div>
                        <div class="col-6">
                            <h2 style="margin-bottom: 2px; color: black;font-family: cursive;font-size:20px;font-weight: bold; padding:0;"
                                class="text-right">Customer Inquiry<span id="pr"></span></h2>
                            <p style="margin-bottom: 2px; font-family: cursive;font-size:15px; font-weight: bold; padding-top: 8px;padding:0;"
                                class="text-right" class="text-right"><span id="viewcompanyname2"></span>
                            </p>
                            <p style="margin-bottom: 2px; font-family: cursive;font-size:15px; font-weight: bold; padding-top: 8px;padding:0;"
                                class="text-right" class="text-right"> <span id="viewbranchname2"></span>
                            </p>

                        </div>
                    </div>
                    </br>
                    <div class="row">
                        <div class="col-6">
                            <p style="margin-bottom: 2px; font-family: cursive;font-size:15px; font-weight: bold; padding-top: 8px;padding:0;"
                                class="text-left">Customer Name:&nbsp;<span id="customername2"></span></P>
                            <p style="margin-bottom: 2px; font-family: cursive;font-size:15px; font-weight: bold; padding-top: 8px;padding:0;"
                                class="text-left">Vehicle Brand:&nbsp;<span id="brandname2"></span></P>
                            <p style="margin-bottom: 2px; font-family: cursive;font-size:15px; font-weight: bold; padding-top: 8px;padding:0;"
                                class="text-left">Date of old Appointment:&nbsp;<span id="old_appointment_date"></span></P>
                            </p>
                            </p>
                        </div>
                    </div>
                    <!-- <div id="viewhtml2"></div> -->
                    <form action="<?php echo base_url() ?>Cancel_appointment/Cancel_appointment_insertupdate"
                        method="post" autocomplete="off">
                        <div class="row">


                            <div class="col-6">
                                <label class="small font-weight-bold text-dark">Reschedule
                                    Date*</label>
                                <input type="date" class="form-control form-control-sm" name="rescheduledate"
                                    id="rescheduledate" value="<?php echo date("Y-m-d"); ?>"
                                    min="<?php echo date("Y-m-d"); ?>" required>
                            </div>
                            <div class="col-6">
                                <label class="small font-weight-bold text-dark">Remark</label>
                                <textarea class="form-control form-control-sm px-0" name="reschedule_remark" id="reschedule_remark "
                                    placeholder="Enter your remarks here" required></textarea>
                            </div>
                        </div>
                        <div class="card-body p-0 p-2">
                            <br>
                            <div class="row">
                                <div class="col-8"></div>
                                <div class="col-4">
                                    <button type="submit" name="submitBtn_2" id="submitBtn_2"
                                        class="btn btn-success btn-m fa-pull-right animated-button" title="Approve"><i
                                            class="fas fa-check"></i>&nbsp;Reschedule</button>
                                    <input type="hidden" id="approvebtn_2" name="approvebtn_2">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" class="form-control form-control-sm" name="recordID2" id="recordID2"
                            required readonly>
                        <input type="hidden" name="recordOption" id="recordOption" value="2">
                        <!-- <input type="text" name="recordID" id="recordID" value=""> -->
                    </form>

                    <!-- <div id="viewhtml"></div> -->

                </div>
            </div>
        </div>
    </div>
</div>



<?php include "include/footerscripts.php"; ?>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Set the value of follow_1
    var follow_1_value = 1; // Example value

    var follow_1_span = document.getElementById('follow_1');

    if (follow_1_value === 1) {
        follow_1_span.innerHTML = "Done!";
        follow_1_span.style.color = "green";
        follow_1_span.style.fontWeight = "bold"; // Ensure the text is bold
    } else {
        follow_1_span.innerHTML = "Pending!";
        follow_1_span.style.color = "red";
        follow_1_span.style.fontWeight = "bold"; // Keep bold even for Pending
    }
});
document.addEventListener("DOMContentLoaded", function() {
    // Set the value of follow_2
    var follow_2_value = 1; // Example value

    var follow_2_span = document.getElementById('follow_2');

    if (follow_2_value === 1) {
        follow_2_span.innerHTML = "Done!";
        follow_2_span.style.color = "green";
        follow_2_span.style.fontWeight = "bold"; // Ensure the text is bold
    } else {
        follow_2_span.innerHTML = "Pending!";
        follow_2_span.style.color = "red";
        follow_2_span.style.fontWeight = "bold"; // Keep bold even for Pending
    }
});

document.addEventListener("DOMContentLoaded", function() {
    // Set the value of follow_3
    var follow_3_value = 1; // Example value

    var follow_3_span = document.getElementById('follow_3');

    if (follow_3_value === 1) {
        follow_3_span.innerHTML = "Done!";
        follow_3_span.style.color = "green";
        follow_3_span.style.fontWeight = "bold"; // Ensure the text is bold
    } else {
        follow_3_span.innerHTML = "Pending!";
        follow_3_span.style.color = "red";
        follow_3_span.style.fontWeight = "bold"; // Keep bold even for Pending
    }
});
</script>

<script>
$(document).ready(function() {
    // Open the modal when the page loads

    $('#f_company_id').val('<?php echo ($_SESSION['company_id']); ?>');
    $('#f_company_name').val('<?php echo ($_SESSION['companyname']); ?>');
    $('#f_branch_id').val('<?php echo ($_SESSION['branch_id']); ?>');
    $('#f_branch_name').val('<?php echo ($_SESSION['branchname']); ?>');


});
</script>

<script>
$(document).ready(function() {

    var addcheck = '<?php echo $addcheck; ?>';
    var editcheck = '<?php echo $editcheck; ?>';
    var statuscheck = '<?php echo $statuscheck; ?>';
    var deletecheck = '<?php echo $deletecheck; ?>';

    $('#dataTable').DataTable({
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
                title: 'Customer Inquiry Information',
                text: '<i class="fas fa-file-csv mr-2"></i> CSV',
            },
            {
                extend: 'pdf',
                className: 'btn btn-danger btn-sm',
                title: 'Customer Inquiry Information',
                text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
            },
            {
                extend: 'print',
                title: 'Customer Inquiry Information',
                className: 'btn btn-primary btn-sm',
                text: '<i class="fas fa-print mr-2"></i> Print',
                customize: function(win) {
                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                },
            },
            // 'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        ajax: {
            url: "<?php echo base_url() ?>scripts/cancel_appointment_inquirylist.php",
            type: "POST", // you can use GET
            "data": function(d) {
                return $.extend({}, d, {
                    "company_branch_id": '<?php echo ($_SESSION['branch_id']); ?>',
                });
            }
        },
        "order": [
            [0, "desc"]
        ],
        "columns": [
            // {
            //     "data": function(row) {
            //         return "POR000" + row.idtbl_print_porder_req;
            //     }
            // },
            {
                "data": "inquiry_number"
            },
            {
                "data": "inquiry_source_name"
            },
            {
                "data": "customer_name"
            },
            {
                "data": "customer_number"
            },
            {
                "data": "vehicle_number"
            },
            {
                "data": "brand_name"
            },
            {
                "data": "model_name"
            },
            {
                "data": "year_name"
            },
            {
                "data": "sales_person_name"
            },
            {
                "data": "coordinator_name"
            },

            {
                "targets": -1,
                "className": '',
                "data": null,
                "render": function(data, type, full) {
                    if (full['appointment'] == 1) {
                        return '<i class="fas fa-check text-success mr-2"></i>Confirm Appointment';
                    } else {
                        return '<i class="fa fa-times text-danger mr-2"></i>Not Confirm Appointment';
                    }
                }
            },
            {
                "data": "appointmentdate",
                "render": function(data, type, full) {
                    if (full['appointment'] == 1) {
                        return data; // Show the appointment date if appointment is confirmed
                    } else {
                        return ''; // Or return empty if not confirmed
                    }
                }
            },
            {
                "targets": -1,
                "className": '',
                "data": null,
                "render": function(data, type, full) {
                    if (full['imageDelivery'] == 1) {
                        return '<i class="fas fa-check text-success mr-2"></i>Sent';
                    } else {
                        return '<i class="fa fa-times text-danger mr-2"></i>Not Sent';
                    }
                }
            },

            {
                "targets": -1,
                "className": 'text-right',
                "data": null,
                "render": function(data, type, full) {
                    var button = '';
                    button += '<button class="btn btn-dark btn-sm btnview mr-1" id="' +
                        full[
                            'idtbl_customer_inquiry'] +
                        '"title="View Inquiry & Follow ups"><i class="fas fa-eye"></i></button>';
                    // third Follow up
                    if (data.cancel_status == 1) {
                        button += '<button class="btn btn-success btn-sm btnview2 mr-1" id="' +
                            full['idtbl_customer_inquiry'] +
                            '"title="Reschedule Appointment"><i class="fas fa-calendar-check"></i></button>';
                    }


                    return button;
                }
            }
        ],
        "createdRow": function(row, data, dataIndex) {
            if (data.first_follow_up == 0) {
                // Light red color
                $(row).css({
                    'background-color': '#FFB2D0',
                    'color': 'black',
                });
            }

            if (data.first_follow_up == 1) {
                // Light green color
                $(row).css({
                    'background-color': '#ccffcc',
                    'color': 'black',
                });
            }

            if (data.second_follow_up == 1) {
                // Light yellow color 
                $(row).css({
                    'background-color': '#FAF884',
                    'color': 'black',
                });
            }

            if (data.third_follow_up == 1) {


                $(row).css({
                    'background-color': '#6CC417',
                    'color': 'black',
                    'font-weight': 'bold'
                });
            }
        },
        drawCallback: function(settings) {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });

    $('#dataTable tbody').on('click', '.btnview', function() {
        var id = $(this).attr('id');
        $('#tableId').val(id);
        $('#approvebtn').val(id);
        $('#procode').html(id);
        $.ajax({
            type: "POST",
            data: {
                recordID: id
            },
            url: '<?php echo base_url() ?>Cancel_appointment/Customer_inquiryrview',
            success: function(result) { //alert(result);

                $('#porderviewmodal').modal('show');
                $('#viewhtml').html(result);
            }
        });

        $.ajax({
            type: "POST",
            data: {
                recordID: id
            },
            url: '<?php echo base_url() ?>Cancel_appointment/Inquiryviewheader',
            success: function(result) { //alert(result);
                var obj = JSON.parse(result);
                // $('#porderdate').text(obj.orderdate);

                $('#customername').text(obj.customername);
                $('#brandname').text(obj.brandname);
                $('#follow_1').text(obj.followup_1);
                $('#customer_reply').text(obj.customer_reply);
                $('#remark').text(obj.remark);
                $('#s_personname').text(obj.s_personname);
                $('#porderaddress1').text(obj.address1);
                $('#porderaddress2').text(obj.address2);
                $('#pordercity').text(obj.city);
                $('#porderstate').text(obj.state);
                $('#porder_number').text(obj.porder_no);

                $('#viewcompanyname').text(obj.companyname);
                $('#viewbranchname').text(obj.branchname);



                $('#follow_2').text(obj.follow_2);
                $('#customer_reply_2').text(obj.customer_reply_2);
                $('#remark2').text(obj.remark2);

                $('#follow_3').text(obj.follow_3);
                $('#customer_reply_3').text(obj.customer_reply_3);
                $('#remark3').text(obj.remark3);
                //console.log(obj);
            }
        });
    });


    // BtnView2 *************************************************************
    $('#dataTable tbody').on('click', '.btnview2', function() {
        var id = $(this).attr('id');
        $('#recordID2').val(id);
        $('#approvebtn_2').val(id);
        $('#procode').html(id);
        $.ajax({
            type: "POST",
            data: {
                recordID2: id
            },
            url: '<?php echo base_url() ?>Cancel_appointment/Customer_inquiryrview_2',
            success: function(result) { //alert(result);

                $('#porderviewmodal2').modal('show');
                // $('#viewhtml2').html(result);
            }
        });

        $.ajax({
            type: "POST",
            data: {
                recordID2: id
            },
            url: '<?php echo base_url() ?>Cancel_appointment/Inquiryviewheader_2',
            success: function(result) { //alert(result);
                var obj = JSON.parse(result);
                // $('#porderdate').text(obj.orderdate);

                $('#customername2').text(obj.customername);
                $('#brandname2').text(obj.brandname);
                $('#old_appointment_date').text(obj.old_appointment_date);
                $('#porderaddress1').text(obj.address1);
                $('#porderaddress2').text(obj.address2);
                $('#pordercity').text(obj.city);
                $('#porderstate').text(obj.state);
                $('#porder_number').text(obj.porder_no);

                $('#viewcompanyname2').text(obj.companyname);
                $('#viewbranchname2').text(obj.branchname);

                $('#customer_reply_id_3').val(obj.customer_reply_id_3);
                $('#remark_3').text(obj.remark_3);
                //console.log(obj);
            }
        });
    });



});

function deactive_confirm() {
    return confirm("Are you sure you want to deactive this?");
}

function active_confirm() {
    return confirm("Are you sure you want to confirm this purchase order Request?");
}

function delete_confirm() {
    return confirm("Are you sure you want to remove this?");
}

function addCommas(nStr) {
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

function action(data) { //alert(data);
    var obj = JSON.parse(data);
    $.notify({
        // options
        icon: obj.icon,
        title: obj.title,
        message: obj.message,
        url: obj.url,
        target: obj.target
    }, {
        // settings
        element: 'body',
        position: null,
        type: obj.type,
        allow_dismiss: true,
        newest_on_top: false,
        showProgressbar: false,
        placement: {
            from: "top",
            align: "center"
        },
        offset: 100,
        spacing: 10,
        z_index: 1031,
        delay: 5000,
        timer: 1000,
        url_target: '_blank',
        mouse_over: null,
        animate: {
            enter: 'animated fadeInDown',
            exit: 'animated fadeOutUp'
        },
        onShow: null,
        onShown: null,
        onClose: null,
        onClosed: null,
        icon_type: 'class',
        template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
            '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
            '<span data-notify="icon"></span> ' +
            '<span data-notify="title">{1}</span> ' +
            '<span data-notify="message">{2}</span>' +
            '<div class="progress" data-notify="progressbar">' +
            '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
            '</div>' +
            '<a href="{3}" target="{4}" data-notify="url"></a>' +
            '</div>'
    });
}
</script>
<?php include "include/footer.php"; ?>