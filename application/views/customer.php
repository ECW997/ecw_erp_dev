<?php 
include "include/header.php";  
include "include/topnavbar.php"; 
?>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <?php include "include/menubar.php"; ?>
    </div>
    <div id="layoutSidenav_content">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@24.6.0/build/css/intlTelInput.css">
        <style>
        #porderviewmodal .modal-content {
            border: 4px solid #0982e6;
            /* Light blue color */
            border-radius: 25px;
            /* Optional: Add rounded corners */
        }
        </style>
        <main>
            <div class="page-header page-header-light bg-white shadow">
                <div class="container-fluid">
                    <div class="page-header-content py-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fas fa-user-check"></i></div>
                            <span>Customer</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="container-fluid mt-2 p-0 p-2">
                            <div class="card">
                                <div class="card-body p-0 p-2">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                            <form action="<?php echo base_url() ?>Customer/Customerinsertupdate"
                                                method="post" autocomplete="off">
                                                <div class="form-row mb-1">
                                                    <div class="col">
                                                        <label class="small font-weight-bold text-dark">Company*</label>
                                                        <input type="text" id="f_company_name" name="f_company_name"
                                                            class="form-control form-control-sm" required readonly>
                                                    </div>
                                                    <div class="col">
                                                        <label class="small font-weight-bold text-dark">Company
                                                            Branch*</label>
                                                        <input type="text" id="f_branch_name" name="f_branch_name"
                                                            class="form-control form-control-sm" required readonly>
                                                    </div>
                                                    <input type="hidden" name="f_company_id" id="f_company_id">
                                                    <input type="hidden" name="f_branch_id" id="f_branch_id">

                                                    <div class="col">
                                                        <label class="small font-weight-bold text-dark">Customer Vehicle
                                                            Number*</label>
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="customer_vehicle_number" id="customer_vehicle_number"
                                                            list="vehicle_suggestions">
                                                        <datalist id="vehicle_suggestions">
                                                        </datalist>
                                                    </div>
                                                    <div class="col">
                                                        <label class="small font-weight-bold text-dark">Customer
                                                            Name*</label>
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="customer_name" id="customer_name" required>
                                                    </div>
                                                </div>

                                                <div class="form-row mb-1">
                                                    <div class="col">
                                                        <label class="small font-weight-bold text-dark">Mobile
                                                            Number*</label>
                                                        <div class="input-group">
                                                            <input type="text" id="customer_mobile_num"
                                                                name="customer_mobile_num"
                                                                class="form-control form-control-sm" pattern="\+?[0-9]*"
                                                                title="Please enter a valid phone number"
                                                                style="width: 18rem;" required>
                                                            <div class="input-group-append">
                                                                <button class="btn btn-success btn-sm whatsapp-btn"
                                                                    type="button" onclick="openWhatsApp()">
                                                                    <i class="fab fa-whatsapp"></i> Chat
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col">
                                                        <label class="small font-weight-bold text-dark">Mobile
                                                            Number 2*</label>
                                                        <div class="input-group">
                                                            <input type="text" id="customer_mobile_num_2"
                                                                name="customer_mobile_num_2"
                                                                class="form-control form-control-sm" pattern="\+?[0-9]*"
                                                                title="Please enter a valid phone number"
                                                                style="width: 22rem;">
                                                        </div>
                                                    </div>

                                                    <div class="col">
                                                        <label class="small font-weight-bold text-dark">Email</label>
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="email" id="email" data-field="email"
                                                            oninput="autoSuggestEmail()">
                                                    </div>

                                                    <div class="col">
                                                        <label class="small font-weight-bold text-dark">NIC No*</label>
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="nic_no" id="nic_no" required>
                                                    </div>

                                                    <div class="col">
                                                        <label class="small font-weight-bold text-dark">DOB</label>
                                                        <input type="date" class="form-control form-control-sm"
                                                            name="customer_dob" id="customer_dob">
                                                    </div>
                                                </div>



                                                <div class="form-row mb-1">
                                                    <div class="col">
                                                        <label class="small font-weight-bold text-dark">Address Line
                                                            1</label>
                                                        <textarea class="form-control form-control-sm"
                                                            name="customer_address" id="customer_address"
                                                            style="height: 32px; "></textarea>
                                                    </div>

                                                    <div class="col">
                                                        <label class="small font-weight-bold text-dark">Address Line
                                                            2</label>
                                                        <textarea class="form-control form-control-sm"
                                                            name="address_line2" id="address_line2"
                                                            style="height: 33px; "></textarea>
                                                    </div>
                                                    <div class="col">
                                                        <label class="small font-weight-bold text-dark">City</label>
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="city" id="city">
                                                    </div>
                                                    <div class="col">
                                                        <label class="small font-weight-bold text-dark">District</label>
                                                        <select class="form-control form-control-sm selecter2 px-0"
                                                            name="district" id="district">
                                                            <option value="">Select</option>
                                                            <?php foreach($districtlist->result() as $rowdistrictlist){ ?>
                                                            <option
                                                                value="<?php echo $rowdistrictlist->idtbl_district ?>">
                                                                <?php echo $rowdistrictlist->district_name ?>
                                                            </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-row mb-1">
                                                <div class="col-3">
                                                        <label class="small font-weight-bold text-dark">Tax
                                                            Type*</label>
                                                        <select class="form-control form-control-sm selecter2 px-0"
                                                            name="tax_type" id="tax_type" required>
                                                            <option value="1">None Tax</option>
                                                            <option value="2">Direct Tax</option>
                                                            <option value="3">Indirect Tax</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-3">
                                                        <label class="small font-weight-bold text-dark">Tax
                                                            Number</label>
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="tax_number" id="tax_number">
                                                    </div>

                                                    <div class="col-3">
                                                        <!-- <label class="small font-weight-bold text-dark">Inquiry
                                                            ID</label> -->
                                                        <input type="hidden" class="form-control form-control-sm"
                                                            name="inquiry_id" id="inquiry_id">
                                                        <!-- <input type="hidden" class="form-control form-control-sm"
                                                            name="vehi_model_id" id="vehi_model_id"> -->
                                                        <!-- <input type="hidden" class="form-control form-control-sm"
                                                            name="vehi_brand_id" id="vehi_brand_id"> -->
                                                    </div>
                                                </div>
                                                <div class="form-group mt-2 text-right">
                                                    <button type="submit" id="submitBtn"
                                                        class="btn btn-primary btn-sm px-4"
                                                        <?php if($addcheck==0){echo 'disabled';} ?>><i
                                                            class="far fa-save"></i>&nbsp;Add</button>
                                                </div>

                                                <input type="hidden" name="recordOption" id="recordOption" value="1">
                                                <input type="hidden" name="recordID" id="recordID" value="">
                                            </form>
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
                                                                <th>#</th>
                                                                <th>Customer Name</th>
                                                                <th>NIC Number</th>
                                                                <th>Address</th>
                                                                <th>District</th>
                                                                <th>Mobile Number</th>
                                                                <th>Mobile Number 2</th>
                                                                <th>Email</th>
                                                                <th>DOB</th>
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
#approve:hover {
    animation: pulse 0.5s infinite;
    border-color: #4CAF50;
    /* Change border color on hover */
    background-color: #4CAF50;
    /* Change background color on hover */
    color: #fff;
    /* Change text color on hover */
}
</style>

<div id="purchaseview">
    <div class="modal fade" id="porderviewmodal" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel" style="color: blue; font-weight: bold;">Customer
                        Vehicle Details
                    </h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form autocomplete="off">
                        <div class="row">
                            <div class="col-4">
                                <label class="small font-weight-bold text-dark">Customer Vehicle
                                    Number*</label>
                                <input type="text" class="form-control form-control-sm"
                                    name="customer_vehicle_number_model" id="customer_vehicle_number_model"
                                    list="vehicle_suggestions" required>
                                <datalist id="vehicle_suggestions">
                                </datalist>
                            </div>
                            <div class="col-4">
                                <label class="small font-weight-bold text-dark">Vehicle
                                    Brand*</label>
                                <select class="form-control form-control-sm selecter2 px-0" name="vehi_brand_id_model"
                                    id="vehi_brand_id_model" required>
                                    <option value="">Select</option>
                                    <?php foreach($brandlist->result() as $rowbrandlist){ ?>
                                    <option value="<?php echo $rowbrandlist->idtbl_vehicle_brand ?>">
                                        <?php echo $rowbrandlist->brand_name ?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-4">
                                <label class="small font-weight-bold text-dark">Vehicle
                                    Model</label>
                                <select class="form-control form-control-sm selecter2 px-0" name="vehi_model_id_model"
                                    id="vehi_model_id_model">
                                    <option value="">Select</option>
                                </select>
                            </div>
                        </div>
                        <div class="card-body p-0 p-2">
                            <br>
                            <div class="row">
                                <div class="col-8"></div>
                                <div class="col-4">
                                    <div class="form-group mt-2 text-right">
                                        <button type="button" id="submitBtnModel" class="btn btn-primary btn-sm px-4"
                                            onclick="insert_vehicle();"><i class="far fa-save"></i>&nbsp;Add</button>
                                    </div>

                                    <input type="hidden" id="approvebtn_2" name="approvebtn_2">
                                </div>
                            </div>
                        </div>
                        <!-- <input type="text" name="detailIDomodel" id="detailIDomodel" value=""> -->
                        <input type="hidden" name="recordOptionModel" id="recordOptionModel" value="1">
                        <input type="hidden" name="recordIDTomodel" id="recordIDTomodel" value="">
                    </form>
                    </br>

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
                                                        <th>Vehicle Number</th>
                                                        <th>Vehicle Brand</th>
                                                        <th>Vehicle Model</th>
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


                    <!-- <div id="viewhtml"></div> -->

                </div>
            </div>
        </div>
    </div>
</div>

<?php include "include/footerscripts.php"; ?>

<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@24.6.0/build/js/intlTelInput.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.22/jspdf.plugin.autotable.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
function openWhatsApp() {
    var customerNumber = document.getElementById("customer_mobile_num").value;
    if (customerNumber) {
        // Replace leading zero or "+" with country code if necessary
        var whatsappUrl = "https://wa.me/" + customerNumber;
        window.open(whatsappUrl, '_blank');
    } else {
        alert("Please enter a valid mobile number.");
    }
}
</script>


<script>
document.getElementById('customer_vehicle_number_model').addEventListener('input', function(e) {
    let input = e.target.value.toUpperCase().replace(/\s+/g, ''); // Remove spaces and ensure uppercase
    input = input.replace(/[^A-Z0-9]/g, ''); // Allow only alphanumeric characters

    // Format input for 2 characters, followed by a dash, then 4 numbers
    if (input.length > 2 && input.length <= 6) {
        input = input.slice(0, 2) + '-' + input.slice(2);
    }
    // Handle longer formats like 'CAA-1458' (3 letters, 4 numbers)
    else if (input.length > 6) {
        input = input.slice(0, 3) + '-' + input.slice(3);
    }

    e.target.value = input;
});
</script>

<script>
function autoSuggestEmail() {
    const emailField = document.getElementById('email');
    const value = emailField.value;
    if (value.includes('@') && !value.includes('@gmail.com') && value.indexOf('@') === value.length - 1) {
        emailField.value = value + 'gmail.com';
    }
}
</script>


<script>
$(document).ready(function() {
    sessionStorage.clear();

    $('#f_company_id').val('<?php echo ($_SESSION['company_id']); ?>');
    $('#f_company_name').val('<?php echo ($_SESSION['companyname']); ?>');
    $('#f_branch_id').val('<?php echo ($_SESSION['branch_id']); ?>');
    $('#f_branch_name').val('<?php echo ($_SESSION['branchname']); ?>');


    $('#district').select2({
        width: '100%',
    });
    $('#tax_type').select2({
        width: '100%',
    });


    var addcheck = '<?php echo $addcheck; ?>';
    var editcheck = '<?php echo $editcheck; ?>';
    var statuscheck = '<?php echo $statuscheck; ?>';
    var deletecheck = '<?php echo $deletecheck; ?>';


    $('#customer_vehicle_number').on('keyup', function() {
        var inputText = $(this).val();
        if (inputText.length > 0) {
            $.ajax({
                url: '<?php echo base_url('Customer/Get_existing_customer'); ?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    customer_vehicle_number: inputText
                },
                success: function(data) {
                    $('#vehicle_suggestions').empty();
                    if (data.length > 0) {
                        $.each(data, function(index, item) {
                            $('#vehicle_suggestions').append(
                                $('<option>', {
                                    value: item.vehicle_number,
                                    text: item.customer_name,
                                })
                                .attr('data-customer_name', item.customer_name)
                                .attr('data-customer_mobile_num', item
                                    .customer_number)
                                .attr('data-customer_mobile_num_2', item
                                    .customer_number2)
                                .attr('data-vehicle_model_name', item
                                    .model_name)
                                .attr('data-vehicle_brand_name', item
                                    .brand_name)
                                .attr('data-nic_no', item.nic)
                                .attr('data-customer_address', item.address)
                                .attr('data-email', item.email)
                                .attr('data-city', item.city)
                                .attr('data-district', item.district)
                                .attr('data-address_line2', item.address_2)
                                .attr('data-customer_dob', item.dob)
                                .attr('data-inquiry_number', item
                                    .inquiry_number)
                                .attr('data-inquiry_id', item
                                    .idtbl_customer_inquiry)
                                .attr('data-vehi_brand_id', item
                                    .vehicle_brand_id)
                                .attr('data-vehi_model_id', item
                                    .vehicle_model_id)
                            );
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching vehicle years:', error);
                }
            });
        } else {
            $('#vehicle_suggestions').empty();
        }
    });

    $('#customer_vehicle_number').on('input', function() {
        var selectedVehicleNumber = $(this).val();
        // alert(selectedVehicleNumber);
        var selectedOption = $('#vehicle_suggestions option[value="' + selectedVehicleNumber + '"]');

        let input = selectedVehicleNumber.toUpperCase().replace(/\s+/g, '');
        $(this).val(input);

        if (selectedOption.length) {
            var customerName = selectedOption.attr('data-customer_name');
            var customerNumber = selectedOption.attr('data-customer_mobile_num');
            var customerNumber2 = selectedOption.attr('data-customer_mobile_num_2');
            var modelName = selectedOption.attr('data-vehicle_model_name');
            var brandName = selectedOption.attr('data-vehicle_brand_name');
            var nic_Number = selectedOption.attr('data-nic_no');
            var cus_Address = selectedOption.attr('data-customer_address');
            var email = selectedOption.attr('data-email');
            var city = selectedOption.attr('data-city');
            var district = selectedOption.attr('data-district');
            var cus_Address_2 = selectedOption.attr('data-address_line2');
            var cus_Dob = selectedOption.attr('data-customer_dob');
            var cus_inquiry_number = selectedOption.attr('data-inquiry_number');
            var cus_inquiry_Id = selectedOption.attr('data-inquiry_id');
            var brand_Id = selectedOption.attr('data-vehi_brand_id');
            var model_Id = selectedOption.attr('data-vehi_model_id');

            $('#customer_name').val(customerName);
            $('#customer_mobile_num').val(customerNumber);
            $('#customer_mobile_num_2').val(customerNumber2);
            $('#nic_no').val(nic_Number);
            $('#customer_address').val(cus_Address);
            $('#email').val(email);
            $('#city').val(city);
            $('#district').val(district).trigger('change');
            $('#address_line2').val(cus_Address_2);
            $('#customer_dob').val(cus_Dob);
            $('#inquiry_number').val(cus_inquiry_number);
            $('#inquiry_id').val(cus_inquiry_Id);

        }
        // Do nothing to the fields if no matching option exists.
    });


    function initializeIntlTelInput(selector) {
        const input = $(selector)[0];

        const iti = window.intlTelInput(input, {
            initialCountry: "auto",
            // separateDialCode: true,
            geoIpLookup: callback => { 
                $.getJSON("https://ipapi.co/json")
                    .done(function(data) {
                        callback(data.country_code);
                    })
                    .fail(function() {
                        callback("us");
                    });
            },
            useFullscreenPopup: false,
            // loadUtilsOnInit: "https://cdn.jsdelivr.net/npm/intl-tel-input@24.6.0/build/js/utils.js",
        });

        // Set the initial dial code when the country is detected on page load
        iti.promise.then(function() {
            const dialCode = iti.getSelectedCountryData().dialCode;
            $(input).val(`+${dialCode}`);
        });

        return iti;
    }

    const itiCustomerNumber = initializeIntlTelInput("#customer_mobile_num");
    const itiCustomerNumber2 = initializeIntlTelInput("#customer_mobile_num_2");


    $('#printporder').click(function() {

        printJS({
            printable: 'purchaseview',
            type: 'html',
            css: 'assets/css/styles.css',
            header: 'Purchase Order Request',
            onPrintSuccess: function() {
                var printButton = document.getElementById('printporder');
                printButton.style.display = 'none';
            }
        });
    });

    // var customer_id = 1;

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
                title: 'Customer Information',
                text: '<i class="fas fa-file-csv mr-2"></i> CSV',
            },
            {
                className: 'btn btn-danger btn-sm',
                text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
                action: function(e, dt, node, config) {
                    exportPDF();
                }
            }
            // 'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        ajax: {
            url: "<?php echo base_url() ?>scripts/customer_list.php",
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

            {
                "data": "idtbl_customer"
            },
            {
                "data": "customer_name"
            },
            {
                "data": "nic_number"
            },
            {
                "data": null,
                "render": function(data, type, row) {

                    return row.address + " " + (row.address_2 == null ? ' ' : row.address_2);

                }
            },
            {
                "data": "district_name"
            },
            {
                "data": "customer_mobile_num"
            },
            {
                "data": "customer_mobile_num_2"
            },
            {
                "data": "email"
            },
            {
                "data": "dob"
            }, 

            {
                "targets": -1,
                "className": 'text-right',
                "data": null,
                "render": function(data, type, full) {
                    var button = '';
                    var customer_id = full['idtbl_customer'];
                    // View Customer Vehicle button
                    button +=
                        '<button class="btn btn-dark btn-sm btnview mr-1" id="' +
                        full[
                            'idtbl_customer'] +
                        '"title="View Vehicle Details"><i class="fas fa-folder-plus"></i></button>';

                    // Job Card button
                    button +=
                        '<a href="<?php echo base_url() ?>JobCard/?customer_id=' + customer_id +
                        '" ' +
                        'target="_self" class="btn btn-secondary btn-sm mr-1 " ' +
                        '" title="Job Card"><i class="fas fa-book"></i></a>';
                    // //Quotation button
                    // button +=
                    //     '<button title="Quotation" class="btn btn-orange btn-sm btnQuotation mr-1" id="' +
                    //     full['idtbl_customer'] +
                    //     '" onclick="exportSummaryPDF();"><i class="fas fa-file-contract"></i></button>';


                    // //Job Summary button

                    // button +=
                    //     '<button title="Job Summary" class="btn btn-pink btn-sm btnSummary mr-1" id="' +
                    //     full['idtbl_customer'] +
                    //     '" onclick="exportJobSummaryPDF();"><i class="fas fa-file-alt"></i></button>';

                    // button +=
                    //     '<button title="Invoice" class="btn btn-info btn-sm btnInvoice mr-1" id="' +
                    //     full['idtbl_customer'] +
                    //     '" onclick="exportInvoicePDF();"><i class="fas fa-file-contract"></i></button>';

                    button += '<button class="btn btn-primary btn-sm btnEdit mr-1 ';
                    if (editcheck != 1) {
                        button += 'd-none';
                    }
                    button += '" id="' + full['idtbl_customer'] +
                        '"title="Edit Customer""><i class="fas fa-pen"></i></button>';
                    if (full['status'] == 1) {
                        button +=
                            '<a href="<?php echo base_url() ?>Customer/Customerstatus/' +
                            full['idtbl_customer'] +
                            '/2" onclick="return deactive_confirm()" target="_self" class="btn btn-success btn-sm mr-1 ';
                        if (statuscheck != 1) {
                            button += 'd-none';
                        }
                        button += '"><i class="fas fa-check"></i></a>';
                    } else {
                        button +=
                            '<a href="<?php echo base_url() ?>Customer/Customerstatus/' +
                            full['idtbl_customer'] +
                            '/1" onclick="return active_confirm()" target="_self" class="btn btn-warning btn-sm mr-1 ';
                        if (statuscheck != 1) {
                            button += 'd-none';
                        }
                        button += '"><i class="fas fa-times"></i></a>';
                    }
                    button +=
                        '<a href="<?php echo base_url() ?>Customer/Customerstatus/' +
                        full['idtbl_customer'] +
                        '/3" onclick="return delete_confirm()" target="_self" class="btn btn-danger btn-sm ';
                    if (deletecheck != 1) {
                        button += 'd-none';
                    }
                    button += '"title="Delete Customer""><i class="fas fa-trash-alt"></i></a>';

                    return button;
                }
            }
        ],
        drawCallback: function(settings) {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });


    $('#dataTable').on('click', '.btnview', function() {
        var id = $(this).attr('id');
        $('#recordIDTomodel').val(id);
        $('#porderviewmodal').modal('show');


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
                        exportPDF();
                    }
                }
                // 'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            ajax: {
                url: "<?php echo base_url() ?>scripts/customer_vehicle_list.php",
                type: "POST", // you can use GET
                "data": function(d) {
                    return $.extend({}, d, {
                        "tbl_customer_idtbl_customer": id,
                    });
                }
            },
            "order": [
                [0, "desc"]
            ],
            "columns": [

                {
                    "data": "idtbl_customer_vehicle_detail"
                },
                {
                    "data": "customer_vehicle_number"
                },
                {
                    "data": "brand_name"
                },
                {
                    "data": "model_name"
                },
                {
                    "targets": -1,
                    "className": 'text-right',
                    "data": null,
                    "render": function(data, type, full) {
                        var button = '';
                        // View Customer Vehicle button
                        button +=
                            '<button class="btn btn-dark btn-sm btnview mr-1" id="' +
                            full[
                                'idtbl_customer'] +
                            '"title="Job card"><i class="fas fa-folder-plus"></i></button>';
                        // Edit Customer Vehicle button
                        button +=
                            '<button class="btn btn-primary btn-sm btnEditModel mr-1 ';
                        if (editcheck != 1) {
                            button += 'd-none';
                        }
                        button += '" id="' + full['idtbl_customer_vehicle_detail'] +
                            '"title="Edit Vehicle""><i class="fas fa-pen"></i></button>';
                        // Delete Customer Vehicle button
                        button +=
                            '<button class="btn btn-danger btn-sm btnDelete ';
                        if (deletecheck != 1) {
                            button += 'd-none';
                        }
                        button +=
                            '" id="' + full['idtbl_customer_vehicle_detail'] +
                            '" "title="Delete Vehicle""><i class="fas fa-trash-alt"></i></button>';
                        return button;
                    }
                }
            ],
            drawCallback: function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });
    });


    //  delete button click in model
    $('#dataTable2').on('click', '.btnDelete', function() {
        var vehicleId = $(this).attr('id');
        if (confirm('Are you sure you want to delete this vehicle?')) {
            $.ajax({
                url: "<?php echo base_url(); ?>Customer/Customer_vehiclestatus/" + vehicleId +
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
        var r = confirm("Are you sure, You want to Edit this Vehicle?");
        if (r == true) {
            var id = $(this).attr('id');
            $.ajax({
                type: "POST",
                data: {
                    recordID: id
                },
                url: '<?php echo base_url() ?>Customer/Customer_Vehicle_edit',
                success: function(result) {
                    var obj = JSON.parse(result);

                    $('#recordIDTomodel').val(obj.id);
                    $('#customer_vehicle_number_model').val(obj.customer_vehicle_number);
                    $('#vehi_brand_id_model').val(obj.vehicle_brand_id).trigger(
                        'change');
                    setTimeout(function() {
                        $('#vehi_model_id_model').val(obj.vehicle_model_id).trigger(
                            'change');
                    }, 500);

                    $('#recordOptionModel').val('2');
                    $('#submitBtnModel').html(
                        '<i class="far fa-save"></i>&nbsp;Update');

                    $('#porderviewmodal').modal('show');
                },
                error: function() {
                    toastr.error('An error occurred while fetching the vehicle data.',
                        'Error');
                }
            });
        }
    });

    $('#dataTable tbody').on('click', '.btnEdit', function() {
        var r = confirm("Are you sure, You want to Edit this Customer? ");
        if (r == true) {
            var id = $(this).attr('id');
            $.ajax({
                type: "POST",
                data: {
                    recordID: id
                },
                url: '<?php echo base_url() ?>Customer/Customeredit',
                success: function(result) { //alert(result);
                    var obj = JSON.parse(result);
                    $('#recordID').val(obj.id);
                    $('#customer_name').val(obj.customer_name);
                    // $('#customer_vehicle_number').val(obj.customer_vehicle_number);
                    $('#customer_mobile_num').val(obj.customer_mobile_num);
                    $('#customer_mobile_num_2').val(obj.customer_mobile_num_2);
                    $('#customer_dob').val(obj.dob);
                    $('#customer_address').val(obj.address);
                    $('#address_line2').val(obj.address_2);
                    $('#city').val(obj.city);
                    $('#email').val(obj.email);
                    $('#district').val(obj.district).trigger('change');
                    $('#tax_type').val(obj.tax_type).trigger('change');
                    $('#tax_number').val(obj.tax_number);
                    $('#nic_no').val(obj.nic_number);

                    $('#recordOption').val('2');
                    $('#submitBtn').html('<i class="far fa-save"></i>&nbsp;Update');

                    $('#customer_vehicle_number').val(obj.customer_vehicle_number).prop(
                        'readonly', true);
                }
            });
        }
    });


});


function exportSummaryPDF() {
    const baseUrl = "<?php echo base_url(); ?>Customer/quotationPDF";
    const url = `${baseUrl}`;
    window.open(url, '_blank');
}

function exportJobSummaryPDF() {
    const baseUrl = "<?php echo base_url(); ?>Customer/jobSummaryPDF";
    const url = `${baseUrl}`;
    window.open(url, '_blank');
}

function exportInvoicePDF() {
    const baseUrl = "<?php echo base_url(); ?>Customer/invoicePDF";
    const url = `${baseUrl}`;
    window.open(url, '_blank');
}

function exportPDF() {
    const {
        jsPDF
    } = window.jspdf;
    const doc = new jsPDF({
        orientation: 'landscape',
        unit: 'pt',
        format: 'A4'
    });

    doc.addFont("<?php echo base_url() ?>assets/fonts/roboto/Roboto-Regular.ttf", "Roboto", "normal");
    doc.addFont("<?php echo base_url() ?>assets/fonts/roboto/Roboto-Bold.ttf", "Roboto", "bold");

    doc.setFont("Roboto", "normal");

    const table = document.querySelector('#dataTable');
    const headers = [];
    const bodyData = [];

    // Extract table headers and body data, excluding the last column ("Actions")
    table.querySelectorAll('thead th').forEach((th, index) => {
        if (index !== 10) { // Skip the "Actions" column (index 9)
            headers.push(th.innerText.trim());
        }
    });

    table.querySelectorAll('tbody tr').forEach(tr => {
        const rowData = [];
        tr.querySelectorAll('td').forEach((td, index) => {
            if (index !== 10) { // Skip the "Actions" column (index 9)
                rowData.push(td.innerText.trim());
            }
        });
        bodyData.push(rowData);
    });

    if (bodyData.length === 0) {
        console.warn('No data found.');
        alert('No data found. Please check your DataTable.');
        return;
    }

    // Debug output (optional)
    console.log('Headers:', headers);
    console.log('Body Data:', bodyData);

    // Generate PDF using filtered headers and body data
    doc.autoTable({
        head: [headers],
        body: bodyData,
        theme: 'striped',
        styles: {
            fontSize: 7,
            lineWidth: 0.1,
            textColor: [0, 0, 0],
            lineColor: [0, 0, 0],
            cellWidth: 'wrap',
            overflow: 'linebreak',
            font: "Roboto",
            fontStyle: "normal"
        },
        headStyles: {
            fillColor: [173, 216, 230], // Light blue color (RGB)
            textColor: [0, 0, 0], // Black text color
            fontStyle: 'bold',
            lineWidth: 0.1,
            lineColor: [0, 0, 0],
            font: "Roboto",
            fontStyle: 'bold',
        },
        margin: {
            top: 40,
            left: 37,
        },
        didDrawPage: function(data) {
            doc.setFont("Roboto", "bold");
            doc.text('Customer Information', doc.internal.pageSize.getWidth() / 2, 30, {
                align: 'center'
            });
            doc.setFont("Roboto", "normal");
        }
    });

    doc.save('Customer Information.pdf');
}

function insert_vehicle() {
    var model_vehicle_number = $('#customer_vehicle_number_model').val();
    var model_vehicle_brand_id = $('#vehi_brand_id_model').val();
    var model_vehicle_model_id = $('#vehi_model_id_model').val();
    var recordIDTomodel = $('#recordIDTomodel').val();
    var recordOptionModel = $('#recordOptionModel').val();

    $.ajax({
        url: '<?php echo base_url(); ?>Customer/addvehicle_detail',
        type: 'POST',
        data: {
            model_vehicle_number: model_vehicle_number,
            model_vehicle_brand_id: model_vehicle_brand_id,
            model_vehicle_model_id: model_vehicle_model_id,
            recordIDTomodel: recordIDTomodel,
            recordOptionModel: recordOptionModel
        },
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                toastr.success(response.message, 'Success');
                $('#dataTable2').DataTable().ajax.reload();

                $('#customer_vehicle_number_model').val('');
                $('#vehi_brand_id_model').val('').trigger('change');
                $('#vehi_model_id_model').val('').trigger('change');
            } else {
                toastr.error(response.message, 'Error');
            }
        },
        error: function() {
            toastr.error('An error occurred.', 'Error');
        }
    });
}

function deactive_confirm() {
    return confirm("Are you sure you want to deactive this Customer?");
}

function active_confirm() {
    return confirm("Are you sure you want to active this Customer?");
}

function delete_confirm() {
    return confirm("Are you sure you want to remove this Customer?");
}

function delete_confirm_model() {
    return confirm("Are you sure you want to remove this Vehicle?");
}
</script>
<?php include "include/footer.php"; ?>