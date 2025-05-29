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
				<form action="" id="jobCardForm"></form>
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

    const $el = $(target);
    $el.find('input, textarea, select').val('');
    $el.find('input[type="checkbox"], input[type="radio"]').prop('checked', false);
    $el.find('.collapse.show').collapse('hide');

    var icon = $el.find('svg');
    icon.css('transform', '');

    isUnsaved = false;
}

function addToJobCard(inputMethod){
    let allValid = true;
    const validatedGroups = {};
    const jobData = [];
    const structuredJobData = {};

    let idtbl_jobcard = <?= json_encode($job_main_data[0]['idtbl_jobcard'] ?? '') ?>;
    
    if(idtbl_jobcard == ''){
        error_toastify('Job Card Not Created or Selected!');
        return;
    }
 
    editedSubJobs.forEach(function (subJobId) {
        const section = $('#collapse' + subJobId);
        const requiredFields = section.find('[required]');
        let sectionValid = true;


        requiredFields.each(function () {
            const $field = $(this);
            const val = $field.val()?.trim();

            if (!val || val == "0" ||  val == "") {
                $field.addClass('is-invalid');
                sectionValid = false;
            } else {
                $field.removeClass('is-invalid');
            }
        });

        section.find('.job-option-select').each(function () {
            const selectedVal = $(this).val()?.trim();
            const optionType = $(this).data('option-type');
            const optionID = $(this).data('option-id');
            const subJobCategoryID = $(this).data('sub-job-category');
            const optionGroupID = $(this).data('option-group');
            const groupKey = subJobCategoryID + '_' + optionGroupID+'_'+optionID;

            const priceField = $('#item_price_' + groupKey);
            const qtyField = $('#item_qty_' + groupKey);
            const netPriceField = $('#item_total_price_' + groupKey);
            const finalNetPriceField = $('#item_net_price_' + groupKey);

            if (!priceField.length && !qtyField.length && !netPriceField.length && !finalNetPriceField.length) {
                return;
            }

            if (validatedGroups[groupKey]) {
                return; 
            }

            const groupHasSelection = section.find(`.job-option-select[data-sub-job-category="${subJobCategoryID}"][data-option-group="${optionGroupID}"][data-option-id="${optionID}"]`)
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
            const $select = $(this);
            const selectedVal = $select.val()?.trim();
            const selectedOption = $select.find('option:selected');
            const selectedText = selectedOption.text().trim();
            const parentId = selectedOption.data('parent-id');

            if (!selectedVal) return;

            const priceCategory = $('#price_category').val();
            const mainJobID = $('#jobIdLabel').text();
            const discountType = $('#discount_type').val();
            const discountAmount = $('#item_discount').val() || 0;
            const itemTotalNetPrice = $('#item_total_net_price').text() || 0;

            const optionType = $(this).data('option-type');
            const subJobCategoryID = $(this).data('sub-job-category');
            const optionGroupID = $(this).data('option-group');
            const optionID = $(this).data('option-id');
            const subJobName = $(this).data('subjob-name');
            const optionGroupName = $(this).data('option-group-name');
            const OptionName = $(this).data('option-name');
            var preValue = $(this).data('pre-value');
            const groupKey = subJobCategoryID + '_' + optionGroupID+'_'+optionID;

            const price = $('#item_price_' + groupKey).val()?.trim();
            const originalPrice = $('#item_price_' + groupKey).data('original_price');
            const qty = $('#item_qty_' + groupKey).val()?.trim();
            const netPrice = $('#item_total_price_' + groupKey).val()?.trim();
            const lineDiscountType = $('#line_discount_type_' + groupKey).val()?.trim();
            const lineInputDiscount = $('#line_discount_' + groupKey).val()?.trim();
            const finalNetPrice = $('#item_net_price_' + groupKey).val()?.trim();

            const lineDiscount = netPrice - finalNetPrice;

            preValue = preValue || selectedVal;

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
        const $modalBody = $('.modal.show .modal-body');
        const $invalidField = $modalBody.find('.is-invalid:first');

        if ($invalidField.length) {
            const scrollOffset = $invalidField.offset().top - $modalBody.offset().top + $modalBody.scrollTop() - 100;

            $modalBody.animate({
                scrollTop: scrollOffset
            }, 500);
        }
        return;
    }

    // arrange data
    const finalDataArray = [];

    for (const mainJobID in jobData) {
        const mainJob = jobData[mainJobID];
        const structuredJobData = mainJob.details;

        const transformedDetails = {};

        for (const subJobCategoryID in structuredJobData) {
            const subJobData = structuredJobData[subJobCategoryID];
            transformedDetails[subJobCategoryID] = {};

            for (const optionGroupID in subJobData) {
                const groupData = subJobData[optionGroupID];
                const typeOptions = groupData.Type || [];
                const primaryOptions = groupData.Primary || [];
                const conditionalOptions = groupData.Conditional || [];

                const conditionalMap = {};
                conditionalOptions.forEach(cond => {
                    const parentId = cond.parent_id;
                    if (!conditionalMap[parentId]) {
                        conditionalMap[parentId] = [];
                    }
                    conditionalMap[parentId].push({
                        ...cond,
                        option_type: "Conditional"
                    });
                });

                const groupArray = [];

                typeOptions.forEach(type => {
                    const optionValueId = type.option_value_id;
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
                jobData: finalDataArray
            },
            url: '<?php echo base_url() ?>JobCard/insertJobCardDetail',
            success: function(result) {
                if (result.status == true) {
                    if(inputMethod == 1){
                        success_toastify(result.message);
                        $('#addJobItemModal').modal('hide');
                        reSetContent('#jobCardForm');
                        setTimeout(function() {
                            location.reload();
                        }, 500);
                    }
                } else {
                    falseResponse(result);
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