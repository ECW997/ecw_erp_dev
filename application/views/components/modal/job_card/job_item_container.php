<?php if ($data['status']): ?>
    <?php if (!empty($data['data'])): ?>
        <?php foreach ($data['data'] as $subJob): ?>
            <div class="mb-3">
                <p class="mb-0">
                    <a class="jobSubItem text-info" data-toggle="collapse"
                       href="#collapse<?= $subJob['sub_job_category']['idtbl_sub_job_category'] ?>"
                       role="button" aria-expanded="false"
                       aria-controls="collapse<?= $subJob['sub_job_category']['idtbl_sub_job_category'] ?>">
                        <i class="fas fa-caret-right text-dark"></i>
                        <?= $subJob['sub_job_category']['sub_job_category'] ?>
                    </a>
                </p>
                <div class="collapse sub-job-collapse"
                     id="collapse<?= $subJob['sub_job_category']['idtbl_sub_job_category'] ?>"
                     data-subjob-id="<?= $subJob['sub_job_category']['idtbl_sub_job_category']; ?>">
                    <div class="card card-body">
                        <?php foreach ($subJob['job_options'] as $jobOptionGroup): ?>
                            <div class="mb-3 p-2 border border-1 bg-light job_item_form">
                                <h6 class="text-secondary"><?= $jobOptionGroup['job_option_group']['GroupName']; ?></h6>  
                                    <?php foreach ($jobOptionGroup['job_options'] as $jobOption): ?>
                                        <?php if ($jobOption['job_option']['OptionType'] == 'Primary' || $jobOption['job_option']['OptionType'] == 'Type'): ?>
                                        <?php
                                            $optionType = $jobOption['job_option']['OptionType'];
                                            $option = $jobOption['job_option'];

                                            $optionId = $option['JobOptionID'];
                                            $optionName = $option['OptionName'];
                                            $groupId = $jobOptionGroup['job_option_group']['id'];
                                            $GroupName = $jobOptionGroup['job_option_group']['GroupName'];
                                            $subJobId = $subJob['sub_job_category']['idtbl_sub_job_category'];
                                            $uniqueKey = $subJobId . '_' . $groupId . '_' . $optionId;
                                            $isRequired = $option['IsRequired'] == 1 ? 'required' : '';
                                            $selectedValue = $option['job_details_option_value'] ?? null;
                                            $price = $option['price'] ?? '';
                                            $list_price = $option['list_price'] ?? '';
                                            $qty = $option['qty'] ?? '';
                                            $total = $option['total'] ?? '';
                                            $net_amount = $option['net_amount'] ?? '';
                                            $line_discount = $option['line_discount'] ?? '';
                                            $line_discount_type = $option['line_discount_type'] ?? null;
                                            $line_discount_pc = $option['line_discount_pc'] ?? '';

                                        ?>
                                        <div class="row align-items-center mb-2 job-option-row" data-level="0">
                                            <div class="col-md-6 d-flex">
                                                <div class="flex-fill me-2">
                                                    <h6 class="mb-1"><?= $option['OptionName']; ?></h6>
                                                    <select
                                                        class="form-select form-select-sm job-option-select job_option_f"
                                                        id="job_option_<?= $optionId ?>" name="job_option_<?= $optionId ?>"
                                                        data-option-type="<?= $option['OptionType']; ?>"
                                                        data-option-id="<?= $optionId ?>"
                                                        data-option-group="<?= $groupId ?>"
                                                        data-sub-job-category="<?= $subJobId ?>" data-level="0"
                                                        data-subjob-name="<?= $subJob['sub_job_category']['sub_job_category'] ?>"
                                                        data-option-group-name="<?= $jobOptionGroup['job_option_group']['GroupName'] ?>"
                                                        data-option-name="<?= $optionName ?>"
                                                        data-pre-value="<?= $selectedValue ?>"
                                                        onchange="loadChildOption(this,null,1);"
                                                        <?= ($selectedValue != '') ? '' : '' ?>>
                                                        <option value="">Select an option</option>
                                                        <?php foreach ($jobOption['option_values'] as $optionValue): ?>
                                                        <option <?= ($selectedValue == $optionValue['id']) ? 'selected' : '' ?> value="<?= $optionValue['id'] ?>"  data-parent-id="<?= $optionValue['ParentOptionValueID'] ?? '0' ?>">
                                                            <?= $optionValue['ValueName'] ?>
                                                        </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>

                                                <div class="child-options-wrapper flex-fill"
                                                    data-parent-option-id="<?= $optionId ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-2 text-end">
                                                <label class="form-label mb-1">Price</label>
                                                <input class="form-control form-control-sm text-end item-price item_price_f"
                                                    type="number" step="any"
                                                    id="item_price_<?= $uniqueKey ?>"
                                                    name="item_price_<?= $uniqueKey ?>"
                                                    data-original_price="<?= $price ?>"
                                                    data-uniq-id="<?= $uniqueKey ?>"
                                                    value="<?= $list_price ?>"
                                                    onkeyup="addToJobCard(2);">
                                            </div>
                                            <div class="col-md-2 text-end">
                                                <label class="form-label mb-1">QTY</label>
                                                <input class="form-control form-control-sm text-end item-qty item_qty_f"
                                                    type="number" step="any"
                                                    id="item_qty_<?= $uniqueKey ?>"
                                                    name="item_qty_<?= $uniqueKey ?>"
                                                    data-uniq-id="<?= $uniqueKey ?>"
                                                    value="<?= $qty ?>"
                                                    onkeyup="addToJobCard(2);">
                                            </div>
                                            <div class="col-md-2 text-end">
                                                <label class="form-label mb-1">Total Price</label>
                                                <input class="form-control form-control-sm text-end item-total-price item_total_price_f"
                                                    type="number" step="any" readonly
                                                    id="item_total_price_<?= $uniqueKey ?>"
                                                    name="item_total_price_<?= $uniqueKey ?>"
                                                    data-uniq-id="<?= $uniqueKey ?>"
                                                    value="<?= $total ?>">
                                            </div>
                                        </div>
                                        <div class="row align-items-center mb-2 ">
                                        	<div class="offset-md-6 col-md-2 text-end">
                                        		<label class="form-label mb-1">Line Discount Type</label>
                                                <select class="form-select form-select-sm w-100 line_discount_type"
                                                 id="line_discount_type_<?= $uniqueKey ?>"
                                                 name="line_discount_type_<?= $uniqueKey ?>" 
                                                 data-uniq-id="<?= $uniqueKey ?>"
                                                 onchange="addToJobCard(2);">
                                                    <option <?= ($line_discount_type == '1') ? 'selected' : '' ?> value="1">percentage (%)</option>
                                                    <option <?= ($line_discount_type == '2') ? 'selected' : '' ?> value="2">Amount</option>
                                                </select>
                                        	</div>
                                        	<div class="col-md-2 text-end">
                                        		<label class="form-label mb-1">Line Discount</label>
                                        		<input class="form-control form-control-sm text-end line_discount" type="number"
                                        			step="any" id="line_discount_<?= $uniqueKey ?>"
                                        			name="line_discount_<?= $uniqueKey ?>"
                                        			data-uniq-id="<?= $uniqueKey ?>"
                                                    value="<?= $line_discount_pc ?>"
                                                    onkeyup="addToJobCard(2);">
                                        	</div>
                                        	<div class="col-md-2 text-end">
                                        		<label class="form-label mb-1">Net Price</label>
                                        		<input class="form-control form-control-sm text-end item-net-price" type="number"
                                        			step="any" readonly id="item_net_price_<?= $uniqueKey ?>"
                                        			name="item_net_price_<?= $uniqueKey ?>"
                                        			data-uniq-id="<?= $uniqueKey ?>"
                                                    value="<?= $net_amount ?>">
                                        	</div>
                                        </div>
                                        <hr>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <div class="conditional-options-container"></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="mb-3">
            <h3 class="text-center">No records found!</h3>
        </div>
    <?php endif; ?>
<?php endif; ?>


<script>
    if (typeof editedSubJobs !== 'undefined' && editedSubJobs instanceof Set) {
        editedSubJobs.clear();
    } else {
        var editedSubJobs = new Set();
    }

    $(document).on('change input', '.sub-job-collapse input, .sub-job-collapse select', function () {
        let subJobId = $(this).closest('.sub-job-collapse').data('subjob-id');
        if (subJobId) {
            editedSubJobs.add(subJobId);
        }
    });

    $(document).ready(function() {
        var jobData = <?php echo json_encode($data); ?>;
                
        jobData.data.forEach(function(item) {
            var subJobIdsToShow = item.sub_job_category.idtbl_sub_job_category;
            item.job_options.forEach(function(jitem) {
                  jitem.job_options.forEach(function(option) {
                    if(option.job_option.edited == true){
                        $('.sub-job-collapse').each(function () {
                            var subJobId = $(this).data('subjob-id');
                            if (subJobIdsToShow == subJobId) {
                                $(this).addClass('show'); 
                            }
                        });
                    }
                  });     
            });
        });

        $('.job-option-select').each(function() {
            var select = $(this);  
            var el = this;    

            if (select.val() && select.val() !== "") {
                setTimeout(() => {
                    if (jobData.status && jobData.data) {
                        if (jobData.data.length > 0) {
                            jobData.data.forEach(function(item) {
                                if (item.job_options && item.job_options.length > 0) {
                                    item.job_options.forEach(function(jobOptionObj) {
                                        var jobOption = jobOptionObj.job_options;
                                        jobOption.forEach(function(value) {
                                            if (value && value.job_option.OptionType === "Conditional") {
                                                value.option_values.forEach(function(valuelist) {
                                                    if (value.job_option.job_details_option_value) {
                                                        if (value.job_option.job_details_option_value == valuelist.id) {
                                                            if (select.val() == valuelist.ParentOptionValueID) {
                                                                loadChildOption(el, valuelist.id, 2); 
                                                            }
                                                        }
                                                    }
                                                });
                                            }
                                        });
                                    });
                                }
                            });
                        } else {
                            console.log("No job data available");
                        }
                    } else {
                        console.log("Failed to load job data or invalid response");
                    }
                }, 100);
            }
        });

        $('#item_total_net_price').text(jobData.meta.full_total);
        
        let price_cat = $('#price_category'); 
        let selectedCategoryId = jobData.meta.price_category_id;
        let selectedCategoryText = jobData.meta.price_category_text || 'Selected'; 

        if (selectedCategoryId) {
            let option = new Option(selectedCategoryText, selectedCategoryId, true, true);
            price_cat.append(option).trigger('change');
        }

    });

    $(document).on('input change', '.item-price, .item-qty,.line_discount_type, .line_discount, .item_discount', function () {   
        var uniqId = $(this).data('uniq-id');
        var price = parseFloat($('#item_price_'+uniqId).val()) || 0;
        var qty = parseFloat($('#item_qty_'+uniqId).val()) || 0;
        var netPrice = price * qty;
        $('#item_total_price_'+uniqId).val(netPrice.toFixed(2));

        var lineDiscountType = $('#line_discount_type_'+uniqId).val();
        var lineDiscount = parseFloat($('#line_discount_'+uniqId).val()) || 0;

        let line_final_total = (lineDiscountType == '1' ? (netPrice - (netPrice * lineDiscount / 100)) : (netPrice - lineDiscount)) ;
        $('#item_net_price_'+uniqId).val(line_final_total.toFixed(2));
        updateTotalNetPrice();
    });

    function loadChildOption(selectElement, editId, insertOption) {
        
        var selectedOption = $(selectElement);
        var selectedOptionValue = selectedOption.val();
        var optionType = selectedOption.data('option-type'); 
        var subJobCategoryID = selectedOption.data('sub-job-category'); 
        var optionGroupID = selectedOption.data('option-group'); 
        var jobOptionID = selectedOption.data('option-id');
        var currentWrapper = selectedOption.closest('.job-option-wrapper');
        var subJobName = selectedOption.data('subjob-name');
        var optionGroupName = selectedOption.data('option-group-name');

        if (selectedOptionValue) {
            $.ajax({
                type: "POST",
                url: '<?php echo base_url() ?>JobCard/getItemParentOptions',
                dataType: 'json',
                data: {
                    subJobCategoryID: subJobCategoryID,
                    selectedOptionValue: selectedOptionValue
                },
                success: function(res) {
                    if (res.status && res.data.length > 0) {
                        let html = '';

                        res.data.forEach(function(group) {
                        var jobOption = group.job_option;
                        var optionValues = group.option_values;
                        
                        if (optionValues.length > 0) {
                            var escapeHtml = (unsafe) => {
                                return unsafe?.toString()
                                    .replace(/&/g, "&amp;")
                                    .replace(/</g, "&lt;")
                                    .replace(/>/g, "&gt;")
                                    .replace(/"/g, "&quot;")
                                    .replace(/'/g, "&#039;") || '';
                            };

                            html += `
                                <div class="ms-2 flex-fill">
                                    <h6 class="mb-1">${escapeHtml(jobOption.OptionName)}</h6>
                                    <select class="form-select form-select-sm job-option-select job_parent_option_f"
                                        data-option-type="${escapeHtml(jobOption.OptionType)}"
                                        data-option-id="${escapeHtml(jobOption.JobOptionID)}"
                                        data-option-group="${escapeHtml(jobOption.OptionGroupID)}"
                                        data-sub-job-category="${escapeHtml(jobOption.JobSubcategoryID)}"
                                        data-subjob-name="${escapeHtml(subJobName)}"
                                        data-option-group-name="${escapeHtml(optionGroupName)}"
                                        data-option-name="${escapeHtml(jobOption.OptionName)}"
                                        data-pre-value="${escapeHtml(editId)}"
                                        ${jobOption.IsRequired == 1 ? 'required' : ''}
                                        onchange="loadChildOption(this,null,1)">
                                        <option value="">Select an option</option>`;
                                      
                            optionValues.forEach(function(val) {
                                html += `<option value="${escapeHtml(val.id)}" data-parent-id="${escapeHtml(val.ParentOptionValueID || '0')}" ${val.id == editId ? 'selected' : ''}>
                                            ${escapeHtml(val.ValueName)}
                                        </option>`;

                            });

                            html += `
                                    </select>
                                </div>
                            `;
                        }
                    });
                        if (html !== '') {
                            $(`.child-options-wrapper[data-parent-option-id="${jobOptionID}"]`).html(html);
                        }
                        getOptionvaluePrice(subJobCategoryID,optionGroupID,selectedOptionValue,jobOptionID,selectedOption,insertOption);
                    }else {
                        $(`.child-options-wrapper[data-parent-option-id="${jobOptionID}"]`).html('');
                        getOptionvaluePrice(subJobCategoryID,optionGroupID,selectedOptionValue,jobOptionID,selectedOption,insertOption);
                    }
            },
            error: function() {
                console.error("Failed to load conditional options.");
            }
            });
        }else{
            $(`.child-options-wrapper[data-parent-option-id="${jobOptionID}"]`).html('');
        }
    }

    var lastRequestedOptionValueId = null;
    function getOptionvaluePrice(subJobCategoryID,optionGroupID,selectedOptionValue,jobOptionID,selectedOption,insertOption){
        if(insertOption == '2'){
            return false;
        }

        lastRequestedOptionValueId = selectedOptionValue;

        var price_category = $('#price_category').val();
        $.ajax({
                type: "POST",
                dataType: 'json',
                url: '<?php echo base_url() ?>JobCard/getOptionvaluePrice',
                data: { optionValueId: selectedOptionValue, 
                        priceCategoryId: price_category},
                success: function(result) { 
                    if(result.status && selectedOptionValue === lastRequestedOptionValueId){
                        var priceSelector = '#item_price_' + subJobCategoryID + '_' + optionGroupID+'_'+jobOptionID;
                        var $priceInput = $(priceSelector);
                        $priceInput
                            .val(result.data.Price)
                            .data('original_price', result.data.Price); 
                        setTimeout(() => addToJobCard(2), 5000);
                    }else{
                        addToJobCard(2);
                    }
                }
        });    
    }

    function updateTotalNetPrice() {
        let total = 0;
        let discount = parseFloat($('#item_discount').val()) || 0;
        let discount_type = $('#discount_type').val();
        $('.item-net-price').each(function () {
            var val = parseFloat($(this).val()) || 0;
            total += val;
        });

        let final_total = (discount_type == '1' ? (total - (total * discount / 100)) : (total - discount)) ;

        $('#item_total_net_price').text(final_total.toFixed(2));
    }


</script>
