<div class="modal fade" id="addJobItemModal" tabindex="-1" aria-labelledby="addJobItemModalLabel" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content rounded-4">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-white" id="addJobItemModalLabel">
                    Add Job Item to <span id="jobNameLabel"></span>
                </h5>
				<button type="button" class="btn-close btn-close-white addJobItemCloseBtn"
					aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row d-flex align-items-center">
					<div class="col-12 col-md-3 mb-2 mb-md-0">
						<h2>Job Card</h2>
					</div>
					<div class="col-12 col-md-3 d-flex align-items-center mb-2 mb-md-0">
						<h6 class="col-form-label me-2 text-nowrap">P.C.</h6>
						<select class="form-select form-select-sm" id="price_category" name="price_category">
							<option value="">Select</option>
						</select>
					</div>
					<div class="col-12 col-md-4 d-flex justify-content-md-end align-items-center mb-2 mb-md-0">
                        <div class="input-group input-group-sm justify-content-md-end align-items-center me-2">
                        	<div class="input-group-prepend">
                        		<h6 class="col-form-label me-1 text-nowrap">Discount</h6>
                        	</div>
                        	<select class="form-select form-select-sm w-50 discount_type" id="discount_type" onchange="updateTotalNetPrice();">
                        		<option value="1">percentage (%)</option>
                        		<option value="2">Amount</option>
                        	</select>
                        </div>
						<input class="form-control form-control-sm text-end item_discount w-50" type="number" step="any" id="item_discount"
							name="item_discount">
					</div>
					<div class="col-12 col-md-2 d-flex justify-content-md-end align-items-center">
						<h2 class="me-2 text-nowrap">Total:</h2>
						<h2 id="item_total_net_price" class="me-2 text-nowrap">0</h2>
					</div>
				</div>
				<hr>
				<form action="" id="jobCardForm" class="jobcard-body"></form>
			</div>
			<div class="modal-footer">
				<button type="button" id="addToJobCardBtn" class="btn btn-info" onclick="addToJobCard(1);">Add to Job Card<i
						class="fas fa-plus-circle ml-2"></i></i></button>
			</div>
            <input type="hidden" id="jobIdLabel" name="jobIdLabel">
		</div>
	</div>
</div>

<div class="modal fade" id="addItemCloseConfirmModal" tabindex="-1" aria-labelledby="addItemCloseConfirmModalLabel"
    aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content delete-confirmation">
            <div class="modal-header delete-header">
                <h5 class="delete-title" id="addItemCloseConfirmModalLabel">Unsaved Changes</h5>
                <button type="button" class="btn-close delete-btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <i class="fas fa-question-circle delete-warning-icon"></i>
                <p class="mb-0">Are you sure you want to close this modal?<br>Any unsaved data will be lost.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary delete-btn-cancel" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancel
                </button>
                <button type="button" class="btn btn-primary delete-btn-confirm" onclick="confirmCloseBtn()">
                    <i class="fas fa-arrow-right me-2"></i>Yes, Close Without Saving
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let isUnsaved = false;

$(document).on('change', '#jobCardForm input, #jobCardForm select', function() {
    isUnsaved = true;
});

$(document).on('click', '.addJobItemCloseBtn', function(e) {
    var item_total_net_price = parseFloat($('#item_total_net_price').text().replace(/,/g, ''));

    if (item_total_net_price > 0 && isUnsaved) {
        e.preventDefault();
        $('#addItemCloseConfirmModal').modal('show');
    } else {
        $('#addJobItemModal').modal('hide');
        reSetContent('#jobCardForm');
    }
});


$(document).ready(function() {

    let price_category = $('#price_category');

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
 
function confirmCloseBtn() {
    isUnsaved = false;
    $('#addItemCloseConfirmModal').modal('hide');
    setTimeout(() => {
        $('#addJobItemModal').modal('hide');
        $('.modal-backdrop').remove();
        reSetContent('#jobCardForm');
        location.reload();
    }, 500);
}

function reSetContent(target) {
    $('#item_pc_category').val('');
    $('#item_discount').val(0);
    $('#item_total_net_price').text('0');

    var $el = $(target);
    $el.find('input, textarea, select').val('');
    $el.find('input[type="checkbox"], input[type="radio"]').prop('checked', false);
    $el.find('.collapse.show').collapse('hide');

    var icon = $el.find('svg');
    icon.css('transform', '');

    isUnsaved = false;
}

function addToJobCard(inputMethod){
    const btn = document.getElementById('addToJobCardBtn');
    if(inputMethod == 1){
        if (btn) btn.disabled = true;
        btn.innerHTML = `Adding <span class="spinner-border spinner-border-sm ml-2" role="status" aria-hidden="true"></span>`;
    
        setTimeout(function () {
            continueAddToJobCard(inputMethod,btn);
        }, 3000);
    }else{
        continueAddToJobCard(inputMethod,btn);
    }

}

function continueAddToJobCard(inputMethod,btn){
    let allValid = true;
    var validatedGroups = {};
    var jobData = [];
    var structuredJobData = {};
    var selectedVal;

    let idtbl_jobcard = <?= json_encode($job_main_data[0]['idtbl_jobcard'] ?? '') ?>;
    
    if(idtbl_jobcard == ''){
        error_toastify('Job Card Not Created or Selected!');
        return;
    }
 
    editedSubJobs.forEach(function (subJobId) {
        var section = $('#collapse' + subJobId);
        var requiredFields = section.find('[required]');
        let sectionValid = true;


        requiredFields.each(function () {
            var $field = $(this);
            var val = $field.val()?.trim();

            if (!val || val == "0" ||  val == "") {
                $field.addClass('is-invalid');
                sectionValid = false;
            } else {
                $field.removeClass('is-invalid');
            }
        });

        section.find('.job-option-select').each(function () {
            var selectedVal = $(this).val()?.trim();
            var optionType = $(this).data('option-type');
            var optionID = $(this).data('option-id');
            var subJobCategoryID = $(this).data('sub-job-category');
            var optionGroupID = $(this).data('option-group');
            var groupKey = subJobCategoryID + '_' + optionGroupID+'_'+optionID;

            var priceField = $('#item_price_' + groupKey);
            var qtyField = $('#item_qty_' + groupKey);
            var netPriceField = $('#item_total_price_' + groupKey);
            var finalNetPriceField = $('#item_net_price_' + groupKey);

            if (!priceField.length && !qtyField.length && !netPriceField.length && !finalNetPriceField.length) {
                return;
            }

            if (validatedGroups[groupKey]) {
                return; 
            }

            var groupHasSelection = section.find(`.job-option-select[data-sub-job-category="${subJobCategoryID}"][data-option-group="${optionGroupID}"][data-option-id="${optionID}"]`)
                                        .toArray()
                                        .some(el => $(el).val()?.trim() !== "");

            if (groupHasSelection) {

                if (!priceField.val()?.trim() || priceField.val().trim() === "0") {
                    priceField.addClass('is-invalid');
                    allValid = false;
                } else {
                    priceField.removeClass('is-invalid');
                }

                if (!qtyField.val()?.trim() || qtyField.val().trim() === "0") {
                    qtyField.addClass('is-invalid');
                    allValid = false;
                } else {
                    qtyField.removeClass('is-invalid');
                }

                if (!netPriceField.val()?.trim() || netPriceField.val().trim() === "0") {
                    netPriceField.addClass('is-invalid');
                    allValid = false;
                } else {
                    netPriceField.removeClass('is-invalid');
                }

                if (!finalNetPriceField.val()?.trim() || finalNetPriceField.val().trim() === "0") {
                    finalNetPriceField.addClass('is-invalid');
                    allValid = false;
                } else {
                    finalNetPriceField.removeClass('is-invalid');
                }
            } else {
                priceField.removeClass('is-invalid');
                qtyField.removeClass('is-invalid');
                netPriceField.removeClass('is-invalid');
                finalNetPriceField.removeClass('is-invalid');
            }

            validatedGroups[groupKey] = true;
        });

        section.find('.job-option-select').each(function () {
            var $select = $(this);
            selectedVal = $select.val()?.trim();
            var selectedOption = $select.find('option:selected');
            var selectedText = selectedOption.text().trim();
            var parentId = selectedOption.data('parent-id');

            if (!selectedVal) return;

            var priceCategory = $('#price_category').val();
            var mainJobID = $('#jobIdLabel').text();
            var discountType = $('#discount_type').val();
            var discountAmount = $('#item_discount').val() || 0;
            var itemTotalNetPrice = $('#item_total_net_price').text() || 0;

            var optionType = $(this).data('option-type');
            var subJobCategoryID = $(this).data('sub-job-category');
            var optionGroupID = $(this).data('option-group');
            var optionID = $(this).data('option-id');
            var subJobName = $(this).data('subjob-name');
            var optionGroupName = $(this).data('option-group-name');
            var OptionName = $(this).data('option-name');
            var preValue = $(this).data('pre-value');
            var groupKey = subJobCategoryID + '_' + optionGroupID+'_'+optionID;

            var price = parseFloat($('#item_price_' + groupKey).val()?.trim()) || 0;
            var originalPrice = parseFloat($('#item_price_' + groupKey).data('original_price')) || 0;

            var qty = $('#item_qty_' + groupKey).val()?.trim();
            var netPrice = $('#item_total_price_' + groupKey).val()?.trim();
            var lineDiscountType = $('#line_discount_type_' + groupKey).val()?.trim();
            var lineInputDiscount = $('#line_discount_' + groupKey).val()?.trim();
            var finalNetPrice = $('#item_net_price_' + groupKey).val()?.trim();

            var lineDiscount = netPrice - finalNetPrice;

            preValue = preValue || selectedVal;
            $(this).data('pre-value', selectedVal);

            if (!jobData[mainJobID]){
                jobData[mainJobID] ={
                    main_job_id: mainJobID,
                    discount_type:discountType,
                    discount:discountAmount,
                    main_job_total_price:itemTotalNetPrice,
                    details: {}
                }
            }

            if (!structuredJobData[subJobCategoryID]) {
                structuredJobData[subJobCategoryID] = {};
            }

            if (!structuredJobData[subJobCategoryID][optionGroupID]) {
                structuredJobData[subJobCategoryID][optionGroupID] = {
                    Type: [],
                    Primary: [],
                    Conditional: []
                };
            }

            if (["Type", "Primary", "Conditional"].includes(optionType)) {
                structuredJobData[subJobCategoryID][optionGroupID][optionType].push({
                    price_category:priceCategory,
                    subjob_name:subJobName,
                    option_group_name:optionGroupName,
                    option_name:OptionName,
                    option_value_name:selectedText,
                    option_id: optionID,
                    option_value_id: selectedVal,
                    original_price: originalPrice || "0",
                    input_price: price || "0",
                    qty: qty || "0",
                    total_price: netPrice || "0",
                    line_discount_type: lineDiscountType || "0",
                    line_input_discount: lineInputDiscount || "0",
                    line_discount: lineDiscount || "0",
                    final_net_price: finalNetPrice || "0",
                    parent_id:parentId,
                    pre_value:preValue
                });
            }

            jobData[mainJobID].details = structuredJobData;
        });

        if (!sectionValid) {
            allValid = false;
            section.collapse('show');
        }
    });


    if (!allValid) {
        // error_toastify('Please fill all required fields in the edited sections.');
        var $modalBody = $('.modal.show .modal-body');
        var $invalidField = $modalBody.find('.is-invalid:first');

        if ($invalidField.length) {
            var scrollOffset = $invalidField.offset().top - $modalBody.offset().top + $modalBody.scrollTop() - 100;

            $modalBody.animate({
                scrollTop: scrollOffset
            }, 500);
        }
        return;
    }

    // arrange data
    var finalDataArray = [];

    for (var mainJobID in jobData) {
        var mainJob = jobData[mainJobID];
        var structuredJobData = mainJob.details;

        var transformedDetails = {};

        for (var subJobCategoryID in structuredJobData) {
            var subJobData = structuredJobData[subJobCategoryID];
            transformedDetails[subJobCategoryID] = {};

            for (var optionGroupID in subJobData) {
                var groupData = subJobData[optionGroupID];
                var typeOptions = groupData.Type || [];
                var primaryOptions = groupData.Primary || [];
                var conditionalOptions = groupData.Conditional || [];

                var conditionalMap = {};
                conditionalOptions.forEach(cond => {
                    var parentId = cond.parent_id;
                    if (!conditionalMap[parentId]) {
                        conditionalMap[parentId] = [];
                    }
                    conditionalMap[parentId].push({
                        ...cond,
                        option_type: "Conditional"
                    });
                });

                var groupArray = [];

                typeOptions.forEach(type => {
                    var optionValueId = type.option_value_id;
                    groupArray.push({
                        ...type,
                        option_type: "Type",
                        conditionals: conditionalMap[optionValueId] || []
                    });
                });

                primaryOptions.forEach(primary => {
                    groupArray.push({
                        ...primary,
                        option_type: "Primary"
                    });
                });

                transformedDetails[subJobCategoryID][optionGroupID] = groupArray;
            }
        }

        finalDataArray.push({
            input_method: inputMethod,
            job_card_id: idtbl_jobcard,
            main_job_id: mainJob.main_job_id,
            discount_type: mainJob.discount_type,
            discount: mainJob.discount,
            main_job_total_price: mainJob.main_job_total_price,
            details: transformedDetails
        });
    }

    console.log(finalDataArray);
    // console.log("Prepared Job Data: ", jobData);

    $.ajax({
            type: "POST",
            dataType: 'json',
            data: {
                jobData: finalDataArray,
                inputMethod: inputMethod
            },
            url: '<?php echo base_url() ?>JobCard/insertJobCardDetail',
            success: function(result) {
                if (result.status == true) {
                    if(inputMethod == 1){
                        success_toastify(result.message);
                        btn.disabled = false;
                        btn.innerHTML = `Add to Job Card <i class="fas fa-plus-circle ml-2"></i>`;
                        $('#addJobItemModal').modal('hide');
                        reSetContent('#jobCardForm');
                        setTimeout(function() {
                            location.reload();
                        }, 200)
                    }
                } else {
                    falseResponse(result);
                    btn.disabled = false;
                    btn.innerHTML = `Add to Job Card <i class="fas fa-plus-circle ml-2"></i>`;
                }
            }
    });

}

$(document).on('hidden.bs.modal', function () {
    if ($('.modal.show').length > 0) {
        $('body').addClass('modal-open');
    }
});

</script>