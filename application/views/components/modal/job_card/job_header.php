<div class="modal fade" id="jobHeaderModal" tabindex="-1" aria-labelledby="jobHeaderModalLabel" aria-hidden="true"
    data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="jobHeaderModalLabel">New Job Card - Job Header Details</h5>
                <button type="button" class="btn-close btn-close-white " data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3 row">
                    <div class="col">
                        <h6 class="col-form-label me-2 text-nowrap">Confirm Customer Info</h6>
                        <input type="text" class="form-control mb-2 required-field" id="cus_name" name="cus_name"
                            placeholder="Customer Name">
                        <input type="text" class="form-control mb-2" id="contact_no" name="contact_no"
                            placeholder="Contact No">
                        <input type="text" class="form-control" id="nic_number" name="nic_number" placeholder="NIC No">
                    </div>
                    <div class="col">
                        <h6 class="col-form-label me-2 text-nowrap">Address</h6>
                        <input type="text" class="form-control mb-2 required-field" id="address1" name="address1"
                            placeholder="Address 1">
                        <input type="text" class="form-control mb-2" id="address2" name="address2"
                            placeholder="Address 2">
                        <input type="text" class="form-control" id="email" name="email" placeholder="E-mail">
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col-6">
                        <h6 class="col-form-label me-2 text-nowrap">Schedule Date</h6>
                        <input type="date" class="form-control required-field" id="schedule_date" name="schedule_date"
                            placeholder="Schedule Date">
                    </div>
                    <div class="col-6">
                        <h6 class="col-form-label me-2 text-nowrap">Handover_date</h6>
                        <input type="date" class="form-control required-field" id="handover_date" name="handover_date"
                            placeholder="Delivery Date">
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col-6">
                        <h6 class="col-form-label me-2 text-nowrap">VAT Reg Type <span class="text-danger">*</span></h6>
                        <select class="form-control form-control-sm " id="vat_reg_type" name="vat_reg_type" required>
                            <option value="">Select VAT Type</option>
                            <option value="1">Non VAT</option>
                            <option value="2">VAT</option>
                            <option value="3">SVAT</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <h6 class="col-form-label me-2 text-nowrap">VAT Registration No <span
                                class="text-danger">*</span></h6>
                        <input type="text" class="form-control " id="vat_number" name="vat_number"
                            placeholder="VAT Registration No">
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col-6">
                        <h6 class="col-form-label me-2 text-nowrap">Price Category</h6>
                        <select class="form-control form-control-sm required-field" id="pc_category" name="pc_category"
                            required style="pointer-events: none;">
                            <option value="">Select</option>
                        </select>

                    </div>
                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="createJobCardBtn" class="btn btn-primary">Create Job Card<i
                        class="fas fa-plus-circle ml-2"></i></i></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="createJobCardConfirmModal" tabindex="-1" aria-labelledby="createJobCardConfirmModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content next-step-confirmation">
            <div class="modal-header next-step-header">
                <h5 class="next-step-title" id="createJobCardConfirmModalLabel">Proceed to Create Job Card</h5>
                <button type="button" class="btn-close next-step-btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <i class="fas fa-question-circle next-step-icon"></i>
                <p class="mb-0">Are you sure you want to proceed?<br>This action will create a new Job Card and cannot
                    be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary next-step-btn-cancel" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancel
                </button>
                <button type="button" class="btn btn-primary next-step-btn-confirm" onclick="confirmCreateJobCard()">
                    <i class="fas fa-arrow-right me-2"></i>Proceed
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="jobHeaderModal_edit" tabindex="-1" aria-labelledby="jobHeaderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4">
            <div class="modal-header bg-warning">
                <h5 class="modal-title text-white" id="jobHeaderModalLabel">Edit Job Card - Job Header Details</h5>
                <button type="button" class="btn-close btn-close-white " data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3 row">
                    <div class="col">
                        <label class="form-label">Confirm Customer Info</label>
                        <input type="text" class="form-control mb-2" id="edit_cus_name" name="edit_cus_name"
                            placeholder="Customer Name">
                        <input type="text" class="form-control" id="edit_contact_no" name="edit_contact_no"
                            placeholder="Contact No">
                    </div>
                    <div class="col">
                        <label class="form-label">Address</label>
                        <input type="text" class="form-control mb-2" id="edit_address1" name="edit_address1"
                            placeholder="Address 1">
                        <input type="text" class="form-control" id="edit_address2" name="edit_address2"
                            placeholder="Address 2">
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col-6">
                        <label class="col-form-label">Schedule Date</label>
                        <input type="datetime-local" class="form-control" id="edit_schedule_date"
                            name="edit_schedule_date" placeholder="Schedule Date">
                    </div>
                    <div class="col-6">
                        <label class="col-form-label">Delivery Date</label>
                        <input type="date" class="form-control" id="edit_delivery_date" name="edit_delivery_date"
                            placeholder="Delivery Date">
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col-6">
                        <label class="col-form-label">Price Category</label>
                        <select class="form-select" id="p_category" name="p_category">
                            <option selected>Open this select menu</option>
                            <option value="1">Small</option>
                            <option value="2">Medium</option>
                            <option value="3">Large</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="createJobCardBtn" class="btn btn-warning">Edit Job Card<i
                        class="fas fa-plus-circle ml-2"></i></i></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="main_job_details" tabindex="-1" aria-labelledby="jobHeaderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4">
            <div class="modal-header bg-dark ">
                <h5 class="modal-title text-white" id="jobHeaderModalLabel">Sample Job Details Model</h5>
                <button type="button" class="btn-close btn-close-white " data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h1>Job Options Here</h1>
            </div>
            <div class="modal-footer">
                <button type="button" id="createJobCardBtn" class="btn btn-dark">Create<i
                        class="fas fa-plus-circle ml-2"></i></i></button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).on('click', '#createJobCardBtn', function() {
    let isValid = true;
    $('.required-field').each(function() {
        let value = $(this).val();

        if (!value || value === "") {
            $(this).addClass('is-invalid');
            isValid = false;
        } else {
            $(this).removeClass('is-invalid');
        }
    });
    if (isValid) {
        $('#createJobCardConfirmModal').modal('show');
    }
})

$(document).ready(function() {

    let price_category = $('#pc_category');

    price_category.select2({
        placeholder: 'Select...',
        width: '100%',
        allowClear: true,
        ajax: {
            url: '<?php echo base_url() ?>JobCard/getPriceCategory',
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
});


function confirmCreateJobCard() {
    customerData.name = $('#cus_name').val();
    customerData.contact = $('#contact_no').val();
    customerData.address1 = $('#address1').val();
    customerData.address2 = $('#address2').val();
    customerData.schedule_date = $('#schedule_date').val();
    customerData.handover_date = $('#handover_date').val();
    customerData.status = 'DRAFT';
    customerData.price_category = $('#pc_category').val();
    customerData.vat_reg_type = $('#vat_reg_type').val();
    customerData.vat_number = $('#vat_number').val();
    customerData.nic = $('#nic_number').val();
    customerData.email = $('#email').val();
    customerData.vat_type = $('#vat_reg_type').val();
    customerData.vat_number = $('#vat_number').val();

    $('#createJobCardConfirmModal').modal('hide');
    $('#jobHeaderModal').modal('hide');
    $('#jobHeaderModal_edit').modal('hide');
    $('#main_job_details').modal('hide');
    $('.modal-backdrop').remove();

    createNewJobCard();
}

function confirmEditJobCard() {
    customerData.name = $('#cus_name').val();
    customerData.contact = $('#contact_no').val();
    customerData.address1 = $('#address1').val();
    customerData.address2 = $('#address2').val();
    customerData.schedule_date = $('#schedule_date').val();
    customerData.handover_date = $('#handover_date').val();
    customerData.status = 'DRAFT';
    customerData.price_category = $('#pc_category').val();

    $('#createJobCardConfirmModal').modal('hide');
    $('#jobHeaderModal').modal('hide');
    $('#jobHeaderModal_edit').modal('hide');
    $('#main_job_details').modal('hide');
    $('.modal-backdrop').remove();

    editJobCard();
}

function createNewJobCard() {
    $.ajax({
        type: "POST",
        dataType: 'json',
        data: {
            data: customerData
        },
        url: '<?php echo base_url() ?>JobCard/createJobCard',
        success: function(result) {
            if (result.status == true) {
                success_toastify(result.message);
                setTimeout(function() {
                    window.location.href = '<?= base_url("JobCard/jobCardDetailIndex/") ?>' + result
                        .data;
                }, 1000);
            } else {
                falseResponse(result);
            }
        }
    });
}
</script>