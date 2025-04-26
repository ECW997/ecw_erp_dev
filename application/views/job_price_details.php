<?php 
include "include/header.php";  

include "include/topnavbar.php"; 
?>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <style>
        #porderviewmodal .modal-content {
            border: 4px solid #0982e6;
            border-radius: 25px;
        }
        </style>
        <?php include "include/menubar.php"; ?>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="page-header page-header-light bg-white shadow">
                <div class="container-fluid">
                    <div class="page-header-content py-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class='fas fa-id-card'></i></div>
                            <span>Pricing</span>
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
                                        <div class="col-3">
                                            <label class="small font-weight-bold">Main Job Category*</label>
                                            <select class="form-control form-control-sm " name="main_job_category"
                                                id="main_job_category" required>
                                                <option value="">Select</option>
                                            </select>
                                        </div>
                                        <div class="col-3">
                                            <label class="small font-weight-bold">Sub Job Category*</label>
                                            <select class="form-control form-control-sm " name="sub_job_category"
                                                id="sub_job_category" onchange="showPricingDetailsList(this.value);"
                                                required>
                                                <option value="">Select</option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body p-0 p-2">
                            <div class="col-12">
                                <div class="scrollbar pb-3" id="style-2">
                                    <div id="dataTable"></div>
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

<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content rounded-4">
			<div class="modal-header bg-primary">
				<h5 class="modal-title text-white" id="updateModalLabel">Price Update</h5>
				<button type="button" class="close btn-close-white" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" id="updateModalContent">
			</div>
            <input type="text" id="option_value_id" name="option_value_id" hidden/>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary priceUpdateBtn"><i
						class="fas fa-save mr-2"></i>Update</button>
			</div>
		</div>
	</div>
</div>

<?php include "include/footerscripts.php"; ?>

<script>
    var addcheck='<?php echo $addcheck; ?>';
    var editcheck='<?php echo $editcheck; ?>';
    var statuscheck='<?php echo $statuscheck; ?>';
    var deletecheck='<?php echo $deletecheck; ?>';

    let main_job_category = $('#main_job_category');
    let sub_job_category = $('#sub_job_category');

    main_job_category.select2({
        placeholder: 'Select...',
        width: '100%',
        allowClear: true,
        ajax: {
            url: '<?php echo base_url() ?>SubJobCategory/getMainJob',
            dataType: 'json',
            data: function(params) {
                return {
                    term: params.term || '',
                    page: params.page || 1,
                }
            },
            cache: true,
            processResults: function(data) {
                if (data.status == true) {
                    return {
                        results: data.data.item,
                        pagination: {
                            more: data.data.item.length > 0
                        }
                    }
                } else {
                    falseResponse(data);
                }
            }
        }
    });

    sub_job_category.select2({
        placeholder: 'Select...',
        width: '100%',
        allowClear: true,
        ajax: {
            url: '<?php echo base_url() ?>SubJobCategory/getSubJob',
            dataType: 'json',
            data: function(params) {
                return {
                    term: params.term || '',
                    page: params.page || 1,
                    mainJob: main_job_category.val()
                }
            },
            cache: true,
            processResults: function(data) {
                if (data.status == true) {
                    return {
                        results: data.data.item,
                        pagination: {
                            more: data.data.item.length > 0
                        }
                    }
                } else {
                    falseResponse(data);
                }
            }
        }
    });

    function showPricingDetailsList(sub_id){  
        if(sub_id == ''){
            return false;
        }

        $("#dataTable").html('');
        $.ajax({
            type: "GET",
            url: '<?php echo base_url() ?>Job_price_details/jobOptionPricingDetailsList',
            data: { sub_id: sub_id, 
                    editcheck: editcheck,
                    statuscheck: statuscheck,
                    deletecheck: deletecheck },
            success: function (result) {
                if(result){
                    $("#dataTable").html(result);
                }  
            },
            error: function () {
                $("#" + tableOption).html('<p class="text-center text-danger">Error fetching data!</p>');
            }
        });
    }

    $(document).on('click', '.detailEditBtn', function() {
        var id = $(this).attr('id');
        var valuename = $(this).attr('valuename');
        var subCategoryText = $('#sub_job_category option:selected').text();
        $("#option_value_id").val(id);
        $("#updateModalContent").html('');
        $('#updateModal').modal('show');
        $.ajax({
            type: "GET",
            url: '<?php echo base_url() ?>Job_price_details/jobOptionPricingUpdateDetailsList/',
            data: { id: id, 
                    valuename: valuename,
                    subCategoryText: subCategoryText},
            success: function(result) { 
                if(result){
                    $("#updateModalContent").html(result);
                }  
            }
        });
    });

    $(document).on('click', '.priceUpdateBtn', function() {
        var updatedData = [];
        var recordID = $("#option_value_id").val();
        $('.row-price-item').each(function() {
            var $row = $(this);
            var price_category_id = $row.data('price_category_id');

            var priceInput = $row.find('.price-input');
            var dateInput = $row.find('.date-input');
            var statusInput = $row.find('.status-input');

            var isPriceChanged = priceInput.val() !== priceInput.attr('data-original');
            var isDateChanged = dateInput.val() !== dateInput.attr('data-original');
            var isStatusChanged = statusInput.val() !== statusInput.attr('data-original');

            if (isPriceChanged || isDateChanged || isStatusChanged) {
                updatedData.push({
                    price_category_id: price_category_id,
                    price: priceInput.val(),
                    valid_from: dateInput.val(),
                    status: statusInput.val()
                });
            }
        });
        if (updatedData.length > 0) {
            $.ajax({
                type: "POST",
                dataType: 'json',
                data: {
                    updatedData: updatedData,
                    recordID:recordID
                },
                url: '<?php echo base_url() ?>Job_price_details/jobOptionPricingUpdate',
                success: function(result) { 
                    if (result.status == true) {
                        success_toastify(result.message);
                        setTimeout(function() {
                            $("#updateModalContent").html('');
                            $('#updateModal').modal('hide');
                            showPricingDetailsList(sub_job_category.val());
                        }, 1000);
                    } else {
                        falseResponse(result);
                    }
                }
            });
            
        } else {
            error_toastify('No changes detected!');
        }
    });

        
    function checkedDublicate(input) {

        var inputValue = input.value;
        var tablename = 'tbl_job_price';
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
                    $('#' + columnName + '_errorMsg').text(
                            "This Job is already Priced.Please Edit it or add another job ")
                        .css('font-weight', 'bold')
                        .show();
                } else {
                    $('#' + columnName + '_errorMsg').hide();
                }
            }
        });
    }

    function productDelete(btn) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to remove this Job?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $(btn).closest('tr').remove();
                Swal.fire(
                    'Deleted!',
                    'The job has been removed.',
                    'success'
                );
            }
        });
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

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<?php include "include/footer.php"; ?>