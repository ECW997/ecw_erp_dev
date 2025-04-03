<?php 
include "include/v2/header.php";  

include "include/v2/topnavbar.php"; 
?>
<?php
// Retrieve the customer_id from the URL
$customer_id = isset($_GET['customer_id']) ? $_GET['customer_id'] : '';
?>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <?php include "include/v2/menubar.php"; ?>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="page-header page-header-light bg-white shadow">
                <div class="container-fluid">
                    <div class="page-header-content py-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fas fa-align-left"></i></div>
                            <span>Job Card</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-8 col-xl-8">
                                <form action="<?php echo base_url() ?>JobCard/JobCardinsertupdate" method="post"
                                    autocomplete="off">
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
                                            <label class="small font-weight-bold text-dark">Date*</label>
                                            <input type="datetime-local" class="form-control form-control-sm"
                                                name="jobcard_date" id="jobcard_date"
                                                value="<?php echo date('Y-m-d\TH:i'); ?>" required readonly>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-row mb-1">
                                        <div class="col">
                                            <label class="small font-weight-bold text-dark">Inquiry No*</label>
                                            <select class="form-control form-control-sm " name="inquiry_id"
                                                id="inquiry_id" onchange="getInquiryDetails(this.value);" required>
                                                <option value="">Select</option>
                                            </select>
                                            <input type="hidden" class="form-control form-control-sm " id="inquiry_no"
                                                name="inquiry_no" readonly />
                                        </div>
                                        <div class="col">
                                            <label class="small font-weight-bold text-dark">Vehicle Number*</label>
                                            <input type="text" class="form-control form-control-sm " id="vehicle_number"
                                                name="vehicle_number" readonly />
                                        </div>
                                        <div class="col">
                                            <label class="small font-weight-bold text-dark">Vehicle
                                                Brand*</label>
                                            <select class="form-control form-control-sm selecter2 px-0"
                                                name="vehicle_brand_id" id="vehicle_brand_id" required readonly
                                                style="pointer-events:none;">
                                                <option value="">Select</option>
                                                <?php foreach($brandlist->result() as $rowbrandlist){ ?>
                                                <option value="<?php echo $rowbrandlist->idtbl_vehicle_brand ?>">
                                                    <?php echo $rowbrandlist->brand_name ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <label class="small font-weight-bold text-dark">Vehicle
                                                Model</label>
                                            <select class="form-control form-control-sm selecter2 px-0"
                                                name="vehicle_model_id" id="vehicle_model_id" readonly
                                                style="pointer-events:none;">
                                                <option value="">Select</option>
                                            </select>
                                        </div>
                                    </div> 
                                    <div class="form-row mb-1">
                                        <div class="col">
                                            <label class="small font-weight-bold text-dark">Payment Method*</label>
                                            <select class="form-control form-control-sm " name="payment_method"
                                                id="payment_method" required>
                                                <option value="">Select</option>
                                                <?php foreach($paymentlist->result() as $rowpaymentlist){ ?>
                                                <option value="<?php echo $rowpaymentlist->idtbl_payment_method ?>">
                                                    <?php echo $rowpaymentlist->payment_type ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <label class="small font-weight-bold text-dark">Job Complete Date*</label>
                                            <input type="date" class="form-control form-control-sm " id="complete_date"
                                                name="complete_date" />
                                        </div>
                                        <div class="col">
                                            <label class="small font-weight-bold text-dark">Handover Date*</label>
                                            <input type="date" class="form-control form-control-sm " id="handover_date"
                                                name="handover_date" />
                                        </div>
                                        <div class="col">
                                            <label class="small font-weight-bold text-dark">Customer*</label>
                                            <input type="text" class="form-control form-control-sm " id="customer_name"
                                                name="customer_name" readonly />
                                        </div>
                                            <input type="number" class="form-control form-control-sm d-none" id="customer_id" name="customer_id"
                                                value="<?php echo $customer_id; ?>" />
                                    </div>
                                    <div class="form-row mb-1">
                                        <div class="col">
                                            <label class="small font-weight-bold text-dark">Sub Total*</label>
                                            <input type="number" step="any" class="form-control form-control-sm" id="subtotal"
                                                name="subtotal" value="0" readonly/>
                                        </div>
                                        <div class="col">
                                            <label class="small font-weight-bold text-dark">Discount(%)*</label>
                                            <input type="number" step="any" class="form-control form-control-sm" id="discount"
                                            name="discount" value="0" onkeyup="calcDiscount();" />
                                        </div>
                                        <div class="col">
                                            <label class="small font-weight-bold text-dark">Discount Amount*</label>
                                            <input type="number" step="any" class="form-control form-control-sm" id="discount_amount"
                                            name="discount_amount" value="0" readonly />
                                        </div>

                                        <div class="col">
                                            <label class="small font-weight-bold text-dark">Net Total*</label>
                                            <input type="number" step="any" class="form-control form-control-sm" id="nettotal"
                                            name="nettotal" value="0" readonly/>
                                        </div>
                                    </div>
                                    <div class="form-group mt-3 text-right">
                                        <button type="submit" id="submitBtn" class="btn btn-primary btn-sm px-4"
                                            <?php if($addcheck==0){echo 'disabled';} ?>><i
                                                class="far fa-save"></i>&nbsp;Add</button>
                                    </div>
                                    <input type="hidden" name="recordOption" id="recordOption" value="1">
                                    <input type="hidden" name="recordID" id="recordID" value="">
                                </form>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
                                <div id="materialmachinetblpart">

                                <table class="table table-striped table-bordered table-sm small" id="tableorder" style="background-color: #e0f7fa;">
                                        <h1 style="font-size: 15px; color: blue;"><b>Customer Inquiry Jobs</b></h1>
                                        <thead>
                                            <tr>
                                                <th class="text-left">Job Description</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbljobinquarybody">
                                        </tbody>
                                    </table>
                                </div>
                                <hr>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="scrollbar pb-3" id="style-2">
                            <table class="table table-bordered table-striped table-sm nowrap w-100" id="dataTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Job Card Number</th>
                                        <th>Date</th>
                                        <th>Vehicle Number</th>
                                        <th>Vehicle Brand</th>
                                        <th>Vehicle Model</th>
                                        <th>Payment Method</th>
                                        <th>Complete Date</th>
                                        <th>Customer</th>
                                        <th>Inquiry No</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </main>
        <?php include "include/v2/footerbar.php"; ?>
    </div>
</div>
<?php include "include/v2/footerscripts.php"; ?>

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
    
    getCustomerInquiry("<?php echo $customer_id; ?>");

    $('#material_id').select2({
        width: '100%',
    });
    $('#payment_method').select2({
        width: '100%',
    });
  
    $('#vehicle_brand_id').change(function() {
        var vehicle_brand_id = $(this).val();
        if (vehicle_brand_id != '') {
            $.ajax({
                url: '<?php echo base_url('Customer_inquiry/Getvehiclemodel'); ?>', // Replace with your actual controller and method
                type: 'post',
                data: {
                    vehicle_brand_id: vehicle_brand_id
                },
                dataType: 'json',
                success: function(response) {
                    var len = response.length;
                    $('#vehicle_model_id').empty();
                    $('#vehicle_model_id').append("<option value=''>Select</option>");
                    for (var i = 0; i < len; i++) {
                        var id = response[i]['idtbl_vehicle_model'];
                        var name = response[i]['model_name'];
                        $('#vehicle_model_id').append("<option value='" + id + "'>" + name +
                            "</option>");
                    }
                }
            });
        } else {
            $('#vehicle_model_id').empty();
            $('#vehicle_model_id').append("<option value=''>Select</option>");
        }
    });


    $('#vehicle_model_id').change(function() {
        var vehicle_model_id = $(this).val();
        if (vehicle_model_id != '') {
            $.ajax({
                url: '<?php echo base_url('Customer_inquiry/Getvehicletype'); ?>',
                type: 'post',
                data: {
                    vehicle_model_id: vehicle_model_id
                },
                dataType: 'json',
                success: function(response) {
                    var len = response.length;
                    $('#vehicle_type_id').empty();
                    $('#vehicle_type_id').append("<option value=''>Select</option>");

                    for (var i = 0; i < len; i++) {
                        var id = response[i]['idtbl_vehicle_type'];
                        var name = response[i]['vehicle_type_name'];
                        // console.log("Vehicle Type ID: " + id + ", Vehicle Type Name: " +
                        //     name);

                        $('#vehicle_type_id').append("<option value='" + id + "'>" + name +
                            "</option>");
                    }
                }
            });
        } else {
            $('#vehicle_type_id').empty();
            $('#vehicle_type_id').append("<option value=''>Select</option>");
        }
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
                    var subJobCategoryId = '#sub_job_category_' +
                        main_job_category_id;

                    $(subJobCategoryId).empty();
                    $(subJobCategoryId).append("<option value=''>Select</option>");

                    for (var i = 0; i < len; i++) {
                        var id = response[i]['idtbl_sub_job_category'];
                        var name = response[i]['sub_job_category'];
                        $(subJobCategoryId).append("<option value='" + id + "'>" +
                            name + "</option>");
                    }
                }
            });
        });
        collapseElement.on('hidden.bs.collapse', function() {
            var subJobCategoryId = '#sub_job_category_' + main_job_category_id;
            $(subJobCategoryId).empty();
            $(subJobCategoryId).append("<option value=''>Select</option>");
        });
    });


    $(document).ready(function() {
        var customer_id = $('#customer_id').val();

        if (customer_id != '') {
            $.ajax({
                url: '<?php echo base_url('JobCard/GetcustomerName'); ?>',
                type: 'POST',
                data: {
                    customer_id: customer_id
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {

                        $('#customer_name').val(response.customer_name);
                        // alert(response.customer_name);
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching customer name:',
                        error);
                }
            });
        }
    });



    $(document).on('change', '[id^="sub_job_category_"]', function() {
        var main_job_category_id = $(this).data('maincategoryid');
        var sub_job_category_id = $(this).val();

        if (sub_job_category_id != '') {
            $.ajax({
                url: '<?php echo base_url('Job_price_details/Getsalesjobdetails'); ?>',
                type: 'post',
                data: {
                    main_job_category_id: main_job_category_id,
                    sub_job_category_id: sub_job_category_id
                },
                dataType: 'json',
                success: function(response) {
                    var len = response.length;

                    var jobNameSelect = $('#job_name_' + main_job_category_id);
                    jobNameSelect.empty();
                    jobNameSelect.append("<option value=''>Select</option>");


                    for (var i = 0; i < len; i++) {
                        var id = response[i]['idtbl_sales_jobs_details'];
                        var name = response[i]['sales_job_name'];

                        jobNameSelect.append("<option value='" + id + "'>" + name +
                            "</option>");
                    }
                }
            });
        } else {
            var jobNameSelect = $('#job_name_' + main_job_category_id);
            jobNameSelect.empty();
            jobNameSelect.append("<option value=''>Select</option>");
        }
    });


    var customer_id = $('#customer_id').val();
    // var vehicle_model_id = $('#vehicle_model_id').val();

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
                title: 'Employee Information',
                text: '<i class="fas fa-file-csv mr-2"></i> csv',
            },
            {
                extend: 'pdf',
                className: 'btn btn-danger btn-sm',
                title: 'Employee Information',
                text: '<i class="fas fa-file-pdf mr-2"></i> PDF',
            },
        ],
        ajax: {
            url: "<?php echo base_url() ?>scripts/jobcardlist.php",
            type: "POST", // you can use GET
            "data": function(d) {
                return $.extend({}, d, {
                    "company_branch_id": '<?php echo ($_SESSION['branch_id']); ?>',
                    "customer_id": customer_id,
                });
            }
        },
        "order": [
            [0, "desc"]
        ],
        "columns": [{
                "data": "idtbl_jobcard"
            },
            {
                "data": "job_card_number"
            },
            {
                "data": function(row) {
                    const jobcard_date = row.jobcard_date.split(' ')[
                        0];
                    return jobcard_date;
                }
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
                "data": "payment_type"
            },
            {
                data: "complete_date",
                render: function(data, type, row) {
                    return data === "0000-00-00" ? "" :
                        data;
                }
            },

            {
                "data": "customer_name"
            },
            {
                "data": "inquiry_number"
            },
            {
                "targets": -1,
                "className": 'text-right',
                "data": null,
                "render": function(data, type, full) {
                    var button = '';
                    button +=
                        '<a href="<?php echo base_url() ?>JobCard_information/?jobcard_id=' +
                        full.idtbl_jobcard +
                        '& model_id=' + full.vehicle_model_id +  '& price_cat_id=' + full.price_category_id + '" ' +
                        'target="_self" class="btn btn-dark btn-sm mr-1" ' +
                        'title="Job Card Information"><i class="fas fa-folder-plus"></i></a>';

                    // Job Card button
                    button +=
                        '<button title="Job Card PDF" class="btn btn-secondary btn-sm btnJobCard mr-1" id="' +
                        full['idtbl_jobcard'] +
                        '" onclick="exportJobCardPDF('+full['idtbl_jobcard']+');"><i class="fas fa-file-invoice"></i></button>';
                    //Quotation button
                    button +=
                        '<button title="Quotation PDF" class="btn btn-orange btn-sm btnQuotation mr-1" id="' +
                        full['idtbl_jobcard'] +
                        '" onclick="exportSummaryPDF();"><i class="fas fa-file-contract"></i></button>';


                    //Job Summary button

                    button +=
                        '<button title="Job Summary PDF" class="btn btn-pink btn-sm btnSummary mr-1" id="' +
                        full['idtbl_jobcard'] +
                        '" onclick="exportJobSummaryPDF();"><i class="fas fa-file-alt"></i></button>';

                    button +=
                        '<button title="Invoice PDF" class="btn btn-info btn-sm btnInvoice mr-1" id="' +
                        full['idtbl_jobcard'] +
                        '" onclick="exportInvoicePDF();"><i class="fas fa-file-contract"></i></button>';


                    button += '<button class="btn btn-primary btn-sm btnEdit mr-1 ';
                    if (editcheck != 1) {
                        button += 'd-none';
                    }
                    button += '" id="' + full['idtbl_jobcard'] +
                        '"><i class="fas fa-pen"></i></button>';
                    if (full['status'] == 1) {
                        button +=
                            '<a href="<?php echo base_url() ?>JobCard/JobCardstatus/' +
                            full['idtbl_jobcard'] +
                            '/2/' +
                            full['customer_id'] +
                            '" onclick="return deactive_confirm()" target="_self" class="btn btn-success btn-sm mr-1 ';
                        if (statuscheck != 1) {
                            button += 'd-none';
                        }
                        button += '"><i class="fas fa-check"></i></a>';
                    } else {
                        button +=
                            '<a href="<?php echo base_url() ?>JobCard/JobCardstatus/' +
                            full['idtbl_jobcard'] +
                            '/1/' +
                            full['customer_id'] +
                            '" onclick="return active_confirm()" target="_self" class="btn btn-warning btn-sm mr-1 ';
                        if (statuscheck != 1) {
                            button += 'd-none';
                        }
                        button += '"><i class="fas fa-times"></i></a>';
                    }
                    button +=
                        '<a href="<?php echo base_url() ?>JobCard/JobCardstatus/' +
                        full['idtbl_jobcard'] +
                        '/3/' +
                        full['customer_id'] +
                        '" onclick="return delete_confirm()" target="_self" class="btn btn-danger btn-sm ';
                    if (deletecheck != 1) {
                        button += 'd-none';
                    }
                    button += '"><i class="fas fa-trash-alt"></i></a>';

                    return button;
                }
            }
        ],
        drawCallback: function(settings) {
            $('[data-toggle="tooltip"]').tooltip();
        }
    });

    $('#dataTable tbody').on('click', '.btnEdit', function() {
        var r = confirm("Are you sure, You want to Edit this Job Card? ");
        if (r == true) {
            var id = $(this).attr('id');
            $.ajax({
                type: "POST",
                data: {
                    recordID: id
                },
                url: '<?php echo base_url() ?>JobCard/JobCardedit',
                success: function(result) {
                    // alert(result.complete_date);
                    var obj = JSON.parse(result);
                    $('#recordID').val(obj.id);
                    $('#inquiry_id').val(obj.inquiry_id);
                    $('#inquiry_no').val(obj.inquiry_number);
                    $('#complete_date').val(obj.complete_date);
                    $('#handover_date').val(obj.handover_date);
                    $('#customer_mobile_num_2').val(obj.customer_mobile_num_2);
                    $('#payment_method').val(obj.peyment_method).trigger('change');
                    $('#vehicle_number').val(obj.vehicle_number).trigger('change');
                    $('#vehicle_brand_id').val(obj.vehicle_brand_id).trigger('change');
                    setTimeout(function() {
                        $('#vehicle_model_id').val(obj.vehicle_model_id).trigger(
                            'change');
                    }, 500); // Ensures the change event is triggered before disabling


                    $('#recordOption').val('2');
                    $('#submitBtn').html('<i class="far fa-save"></i>&nbsp;Update');

                    $('#subtotal').val(obj.sub_total);
                    $('#discount').val(obj.discount);
                    $('#discount_amount').val(obj.discount_amount);
                    $('#nettotal').val(obj.net_total);

                    getInquiryJobList(obj.inquiry_id);
                    // calcDiscount();
                }
            });
        }
    });
});

function getCustomerInquiry(customer_id){
    
    $.ajax({
        url: '<?php echo base_url('JobCard/GetCustomerInquiry'); ?>',
        type: 'post',
        data: {
            customer_id: customer_id
        },
        dataType: 'json',
        success: function(response) {
            var len = response.length;
            $('#inquiry_id').empty();
            $('#inquiry_id').append("<option value=''>Select</option>");
            for (var i = 0; i < len; i++) {
                var id = response[i]['inquiry_id'];
                var name = response[i]['inquiry_number'];
                $('#inquiry_id').append("<option value='" + id + "'>" + name +
                    "</option>");
            }
        }
    });
}

function getInquiryDetails(inquiry_id){
    
    $.ajax({
        url: '<?php echo base_url('JobCard/GetInquiryDetails'); ?>',
        type: 'post',
        data: {
            inquiry_id: inquiry_id
        },
        dataType: 'json',
        success: function(response) {
            var inquiry_id = response[0]['inquiry_id'];
            var inquiry_no = response[0]['inquiry_number'];
            var vehicle_number = response[0]['vehicle_number'];
            var vehicle_brand_id = response[0]['vehicle_brand_id'];
            var vehicle_gen_id = response[0]['vehicle_gen_id'];
            var vehicle_model_id = response[0]['vehicle_model_id'];
            var vehicle_type_id = response[0]['vehicle_type_id'];
            var vehicle_year_id = response[0]['vehicle_year_id'];

            $('#inquiry_no').val(inquiry_no);
            $('#vehicle_number').val(vehicle_number);
            $('#vehicle_brand_id').val(vehicle_brand_id).trigger('change');
            setTimeout(function() {
                $('#vehicle_model_id').val(vehicle_model_id).trigger('change');
            }, 500);
           
            getInquiryJobList(inquiry_id);
        }
    });
}

function getInquiryJobList(inquiry_id) {
    
    var customer_id = "<?php echo $customer_id; ?>";
    if (customer_id && inquiry_id) {
        $.ajax({
            type: "POST",
            data: {
                customer_id: customer_id,
                inquiry_id: inquiry_id
            },
            url: '<?php echo base_url() ?>JobCard/getInquiryJobList',
            success: function(result) { 
                $('#tbljobinquarybody').html(result);
            }
        });
    } else {
        $('#tbljobinquarybody').empty();
    }

}

function getjobPrice() {
    var material_id = $('#material_id').val();
    var vehicle_model_id = $('#vehicle_model_id').val();
    var main_job_category = $('#main_job_category').val();
    var sub_job_category = $('#sub_job_category').val();
    var job_name = $('#job_name').val();

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
            url: '<?php echo base_url() ?>TestJob/getJobprice',
            success: function(result) { //alert(result);
                $('#jobprice').val(result);
            }
        });
    }
    return false;

}

function calcDiscount(){
    var subtotal = $('#subtotal').val();
    var discount = $('#discount').val();
    var discount_amount = (subtotal * discount) / 100;
    var nettotal = subtotal - discount_amount;
    $('#discount_amount').val(discount_amount);
    $('#nettotal').val(nettotal);
}

function checkedDublicate(input) {

    var inputValue = input.value;
    var tablename = 'tbl_vehicle_year';
    var columnName = input.getAttribute('data-field');

    $.ajax({
        url: '<?php echo base_url() ?>CheckDublicate/check_duplicate',
        type: 'POST',
        data: {
            input_value: inputValue,
            tablename: tablename,
            column_name: columnName
        },
        dataType: 'json',
        success: function(response) {
            if (response.status === 'error') {
                $('#' + columnName + '_errorMsg').text(response.message).show();
            } else {
                $('#' + columnName + '_errorMsg').hide();
            }
        }
    });
}

function exportJobCardPDF(jobcard_id) {
    const baseUrl = "<?php echo base_url(); ?>JobCard/jobCardPDF";
    const url = `${baseUrl}?jobcard_id=${encodeURIComponent(jobcard_id)}`;
    window.open(url, '_blank');
}

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
<?php include "include/v2/footer.php"; ?>