<?php if ($data['status']): ?>
    <?php if (!empty($data['data'])): ?>
        <div class="job-card-container">
            <div class="job-categories-accordion">
                <?php foreach ($data['data'] as $subJob): ?>
                    <div class="category-card mb-3">
                        <p class="mb-0 category-header">
                            <a class="jobSubItem btn btn-link w-100 text-start d-flex align-items-center" data-toggle="collapse"
                            href="#collapse<?= $subJob['sub_job_category']['idtbl_sub_job_category'] ?>"
                            role="button" aria-expanded="false"
                            aria-controls="collapse<?= $subJob['sub_job_category']['idtbl_sub_job_category'] ?>">
                                <i class="fas fa-folder-open me-2 text-primary"></i>
                                <span class="fw-semibold"><?= $subJob['sub_job_category']['sub_job_category'] ?></span>
                            <i class="fas fa-chevron-down ms-auto transition-all"></i>
                            </a>
                        </p>
                        <div class="collapse sub-job-collapse"
                            id="collapse<?= $subJob['sub_job_category']['idtbl_sub_job_category'] ?>"
                            data-subjob-id="<?= $subJob['sub_job_category']['idtbl_sub_job_category']; ?>">
                            <div class="card card-body category-body">
                                <?php foreach ($subJob['job_options'] as $jobOptionGroup): ?>
                                    <div class="option-group-card mb-4 border rounded">
                                        <div class="option-group-header bg-light p-3 border-bottom">
                                            <h5 class="mb-0 d-flex align-items-center">
                                                <i class="fas fa-tasks me-2 text-secondary"></i>
                                                <?= $jobOptionGroup['job_option_group']['GroupName']; ?>
                                            </h5>
                                        </div>
                                        <div class="option-group-body p-3">
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
                                                    $remark = $option['remark'] ?? '';
                                                ?>
                                                <div class="option-item mb-4" data-option-container="<?= $uniqueKey ?>">
                                                    <div class="job-option-row option-row row g-3 align-items-center" data-level="0">
                                                        <div class="col-md-6">
                                                            <div class="option-select-container">
                                                                <label class="form-label fw-medium text-dark mb-1">
                                                                    <i class="fas fa-cog me-1 text-muted"></i>
                                                                    <?= $option['OptionName']; ?>
                                                                </label>
                                                                <select class="form-select job-option-select job_option_f"
                                                                    id="job_option_<?= $optionId ?>" 
                                                                    name="job_option_<?= $optionId ?>"
                                                                    data-uniq-id="<?= $uniqueKey ?>"
                                                                    data-option-type="<?= $option['OptionType']; ?>"
                                                                    data-option-id="<?= $optionId ?>"
                                                                    data-option-group="<?= $groupId ?>"
                                                                    data-sub-job-category="<?= $subJobId ?>" 
                                                                    data-level="0"
                                                                    data-subjob-name="<?= $subJob['sub_job_category']['sub_job_category'] ?>"
                                                                    data-option-group-name="<?= $jobOptionGroup['job_option_group']['GroupName'] ?>"
                                                                    data-option-name="<?= $optionName ?>"
                                                                    data-option-description="<?= $option['Description']; ?>"
                                                                    data-pre-value="<?= $selectedValue ?>"
                                                                    onchange="loadChildOption(this,null,1,'<?= $uniqueKey ?>');"
                                                                    >
                                                                    <option value="">Select an option</option>
                                                                    <?php foreach ($jobOption['option_values'] as $optionValue): ?>
                                                                    <option value="<?= $optionValue['id'] ?>" data-parent-id="<?= $optionValue['ParentOptionValueID'] ?? '0' ?>">
                                                                        <?= $optionValue['ValueName'] ?>
                                                                    </option>
                                                                    <?php endforeach; ?>
                                                                </select>        
                                                            </div>
                                                            <div class="child-options-wrapper mt-2"
                                                                data-parent-option-id="<?= $optionId ?>">
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-6">
                                                            <div class="pricing-section bg-light p-2 rounded">
                                                                <div class="row g-2">
                                                                    <div class="col-md-4">
                                                                        <label class="form-label small mb-1">Unit Price</label>
                                                                        <input class="form-control form-control-sm text-end item-price item_price_f"
                                                                            type="number" step="any"
                                                                            id="item_price_<?= $uniqueKey ?>"
                                                                            name="item_price_<?= $uniqueKey ?>"
                                                                            data-original_price="<?= $price ?>"
                                                                            data-uniq-id="<?= $uniqueKey ?>"
                                                                            value=""
                                                                            onkeyup="schedulePriceUpdate(this);">
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <label class="form-label small mb-1">Qty</label>
                                                                        <input class="form-control form-control-sm text-end item-qty item_qty_f"
                                                                            type="number" step="any"
                                                                            id="item_qty_<?= $uniqueKey ?>"
                                                                            name="item_qty_<?= $uniqueKey ?>"
                                                                            data-uniq-id="<?= $uniqueKey ?>"
                                                                            value=""
                                                                            onkeyup="schedulePriceUpdate(this);">
                                                                    </div>
                                                                    <div class="col-md-5">
                                                                        <label class="form-label small mb-1">Total</label>
                                                                        <input class="form-control form-control-sm text-end item-total-price item_total_price_f"
                                                                            type="number" step="any" readonly
                                                                            id="item_total_price_<?= $uniqueKey ?>"
                                                                            name="item_total_price_<?= $uniqueKey ?>"
                                                                            data-uniq-id="<?= $uniqueKey ?>"
                                                                            value="">
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="row g-2 mt-2">
                                                                    <div class="col-md-4">
                                                                        <label class="form-label small mb-1">Discount Type</label>
                                                                        <select class="form-select form-select-sm line_discount_type"
                                                                        id="line_discount_type_<?= $uniqueKey ?>"
                                                                        name="line_discount_type_<?= $uniqueKey ?>" 
                                                                        data-uniq-id="<?= $uniqueKey ?>"
                                                                        onchange="schedulePriceUpdate(this);">
                                                                            <option value="1">%</option>
                                                                            <option value="2">Amount</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <label class="form-label small mb-1">Discount</label>
                                                                        <input class="form-control form-control-sm text-end line_discount" 
                                                                            type="number" step="any" min="0"
                                                                            id="line_discount_<?= $uniqueKey ?>"
                                                                            name="line_discount_<?= $uniqueKey ?>"
                                                                            data-uniq-id="<?= $uniqueKey ?>"
                                                                            value=""
                                                                            onkeyup="schedulePriceUpdate(this);">
                                                                    </div>
                                                                    <div class="col-md-5">
                                                                        <label class="form-label small mb-1">Net Price</label>
                                                                        <input class="form-control form-control-sm text-end item-net-price" 
                                                                            type="number" step="any" readonly 
                                                                            id="item_net_price_<?= $uniqueKey ?>"
                                                                            name="item_net_price_<?= $uniqueKey ?>"
                                                                            data-uniq-id="<?= $uniqueKey ?>"
                                                                            value="">
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label class="form-label small mb-1">
                                                                Remark 
                                                                <span id="remark_save_status_<?= $uniqueKey ?>" class="text-danger"></span>
                                                            </label>
                                                            <input class="form-control form-control-sm text-left item-price remark_f" 
                                                                type="text" id="remark_<?= $uniqueKey ?>" name="remark_<?= $uniqueKey ?>" 
                                                                value="" data-uniq-id="<?= $uniqueKey ?>" 
                                                                oninput="markRemarkUnsaved(this)" 
                                                                onkeydown="if (event.key === 'Enter') handleRemarkEnter(this);">
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr class="my-3">
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                            <div class="conditional-options-container"></div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php else: ?>
        <div class="empty-state text-center py-5 bg-light rounded">
            <i class="fas fa-inbox fa-3x mb-3"></i>
            <h4 class="text-muted">No records found</h4>
            <p class="text-muted">There are no job categories available</p>
        </div>
    <?php endif; ?>
<?php endif; ?>

<script>
    $(document).ready(function() {
       initSelect2();
    });
    if (typeof editedSubJobs !== 'undefined' && editedSubJobs instanceof Set) {
        editedSubJobs.clear();
    } else {
        var editedSubJobs = new Set();
    }

    window.pendingRequests = window.pendingRequests || {};
    window.lastRequestedOptionValueId = window.lastRequestedOptionValueId || null;
    window.loadingPromises = [];
    window.isInitialLoadComplete = false;
    window.activeAjaxCalls = 0;
    window.hasEditedData = false;
    window.initialLoadStarted = false;

    function showLoadingModal() {
        const $modal = $('#loadingModal');
        if (!$modal.hasClass('show') || $modal.css('display') !== 'block') {
            $modal.modal('show');
            $modal.one('shown.bs.modal', function() {
                console.log('Spinner fully shown and visible');
            });
            
            console.log('Showing spinner...');
        }
    }

    function hideLoadingModal() {
        const $modal = $('#loadingModal');
        if ($modal.hasClass('show')) {
            $modal.one('hidden.bs.modal', function() {
                console.log('Spinner fully hidden');
                addMoreOptionsAfterLoad();
            }).modal('hide');
            
            console.log('Hiding spinner...');
        } else {
            addMoreOptionsAfterLoad();
        }
    }

    function trackAjaxCall() {
        activeAjaxCalls++;
        showLoadingModal();
        console.log('AJAX started, active calls:', activeAjaxCalls);
    }

    function completeAjaxCall() {
        if (activeAjaxCalls > 0) {
            activeAjaxCalls--;
        }
        console.log('AJAX call completed, active calls:', activeAjaxCalls);
        if (activeAjaxCalls === 0 && isInitialLoadComplete) {
            setTimeout(hideLoadingModal, 100); 
        }
    }

    function addMoreOptionsAfterLoad() {
        $('#loadingModal').removeAttr('style').css('display', '');
        $('.modal-backdrop').remove();
        
        console.log('Adding additional options now that initial load is complete');
    }

    function init() { 
        setupEditedSubJobs();
        setupPriceCategory();
        isInitialLoadComplete = true;
        hideLoadingModal();

        // processInitialData().then(() => {
        //     console.log('Initial load complete');
        //     isInitialLoadComplete = true;
        //     if (hasEditedData) {
        //         console.log('Initialization started');
        //         showLoadingModal();
        //     }
        // }).catch(error => {
        //     console.error('Initialization error:', error);
        //     isInitialLoadComplete = true;
        //     hideLoadingModal();
        // });
    }

    function setupEditedSubJobs() {
        $(document).on('change input', '.sub-job-collapse input, .sub-job-collapse select', function() {
            const $input = $(this);
            const $collapse = $input.closest('.sub-job-collapse');
            const subJobId = $collapse.data('subjob-id');
            
            if (subJobId) {
                editedSubJobs.add(subJobId);
                
                if ($input.hasClass('job-option-select')) {
                    const optionId = $input.data('option-id');
                    const optionGroupId = $input.data('option-group');
                    
                    const relatedInputs = $(`
                        .sub-job-collapse[data-subjob-id="${subJobId}"] 
                        input[data-option-id="${optionId}"],
                        .sub-job-collapse[data-subjob-id="${subJobId}"] 
                        select[data-option-id="${optionId}"]
                    `);
                    
                    const uniqueKey = `${subJobId}_${optionGroupId}_${optionId}`;
                    const priceInputs = $(`
                        #item_price_${uniqueKey},
                        #item_qty_${uniqueKey},
                        #item_total_price_${uniqueKey},
                        #line_discount_type_${uniqueKey},
                        #line_discount_${uniqueKey},
                        #item_net_price_${uniqueKey}
                    `);
                    
                    const allRelated = relatedInputs.add(priceInputs);
                    
                    allRelated.each(function() {
                        $(this).data('edited', true);
                    });
                }
                
                $input.data('edited', true);
            }
        });
    }
    
    function setupPriceCategory() {
        const jobData = <?php echo json_encode($data); ?>;
        const selectedCategoryId = jobData.meta.price_category_id;
        const selectedCategoryText = jobData.meta.price_category_text || 'Selected';
        
        if (selectedCategoryId) {
            $('#price_category').append(
                new Option(selectedCategoryText, selectedCategoryId, true, true)
            ).trigger('change');
        }
    }

    function processInitialData() {
        return new Promise((resolve) => {
            const jobData = <?php echo json_encode($data); ?>;
            const $subJobCollapses = $('.sub-job-collapse');
            
            if (!jobData.status || !jobData.data || jobData.data.length === 0) {
                console.log('No data available - empty state');
                resolve();
                return;
            }
            
            // Process all items
            const subJobPromises = jobData.data.map(item => {
                const subJobId = item.sub_job_category.idtbl_sub_job_category;
                const $collapse = $subJobCollapses.filter(`[data-subjob-id="${subJobId}"]`);

                const hasEditedInSubJob = item.job_options?.some(jitem =>
                    jitem.job_options?.some(option => option.job_option?.edited)
                );

                if (hasEditedInSubJob) {
                    console.log(`Showing sub-job collapse for ${subJobId} due to edited data`);
                    $collapse.addClass('show');
                }

                return Promise.resolve();
            });

            
            Promise.all(subJobPromises).then(() => {
                if (jobData.meta?.full_total) {
                    $('#item_total_net_price').text(jobData.meta.full_total);
                }
                resolve();
            });
        });
    }
    
    function setupOptionSelects() {
        const jobData = <?php echo json_encode($data); ?>;
        
        setTimeout(() => {
            $('.job-option-select').each(function() {
                const $select = $(this);
                const subJobCategory = $select.data('sub-job-category');
                const optionGroup = $select.data('option-group');
                const optionId = $select.data('option-id');

                const parentUniqueKey = `${subJobCategory}_${optionGroup}_${optionId}`;

                const description = $select.data('option-description');
                if ($select.val() && description === 'image') {
                     loadChildOption($select, null, 2, parentUniqueKey);
                }

                if ($select.val()) {
                    processSelectedOption($select, jobData, parentUniqueKey);
                }
            });
        }, 50);
    }
    
    function processSelectedOption($select, jobData, parentUniqueKey) {
        if (!jobData.data) return;
     
        jobData.data.forEach(item => {
            if (!item.job_options) return;
            
            item.job_options.forEach(jobOptionObj => {
                const jobOptions = jobOptionObj.job_options;
                if (!jobOptions) return;
                
                jobOptions.forEach(option => {
                    const jobOption = option.job_option;
                    // if(jobOption.OptionType == "Type" || jobOption.OptionType == "Primary"){
                    //     parentUniqueKey = jobOption.JobSubcategoryID + '_' + jobOption.OptionGroupID + '_' + jobOption.JobOptionID;
                    // }

                    if (jobOption.OptionType === "Conditional" && jobOption.job_details_option_value && Array.isArray(option.option_values)) 
                        {  
                            option.option_values.forEach(valuelist => {
                                if (
                                    jobOption.job_details_option_value == valuelist.id &&
                                    $select.val() == valuelist.ParentOptionValueID
                                ) {
                                    loadChildOption($select[0], jobOption, 2, parentUniqueKey);
                                }
                            });
                        }
                });
            });
        });
    }
    
    function debounce(func, wait) {
        let timeout;
        return function() {
            const context = this, args = arguments;
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(context, args), wait);
        };
    }
    
    function handlePriceUpdate(selectElement) {
        const $input = $(selectElement);
        const uniqId = $input.data('uniq-id');
        
        const $priceInput = $('#item_price_' + uniqId);
        const $qtyInput = $('#item_qty_' + uniqId);
        const $discountInput = $('#line_discount_' + uniqId);

        const price = parseFloat($priceInput.val()) || 0;
        const qty = parseFloat($qtyInput.val()) || 0;
        const lineDiscountType = $('#line_discount_type_' + uniqId).val();
        const lineDiscount = parseFloat($discountInput.val()) || 0;

        if (price < 0 || qty < 0 || lineDiscount < 0) {
            if (price < 0) $priceInput.val('');
            if (qty < 0) $qtyInput.val('');
            if (lineDiscount < 0) $discountInput.val('');

            return;
        }

        const netPrice = price * qty;
        const lineFinalTotal = (lineDiscountType == '1' 
            ? (netPrice - (netPrice * lineDiscount / 100)) 
            : (netPrice - lineDiscount));

        $('#item_total_price_'+uniqId).val(netPrice.toFixed(2));
        $('#item_net_price_'+uniqId).val(lineFinalTotal.toFixed(2));
        
        updateTotalNetPrice();
    }

    function schedulePriceUpdate(selectElement) {
        if (window.priceUpdateTimer) {
            clearTimeout(window.priceUpdateTimer);
        }
        
        window.priceUpdateTimer = setTimeout(function() {
            handlePriceUpdate(selectElement);
            addToJobCard(2);
        }, 300);
    }

    function updateTotalNetPrice() {
        let total = 0;
        let discount = parseFloat($('#item_discount').val()) || 0;
        discount = discount < 0 ? 0 : discount;
        let discountType = $('#discount_type').val();
        
        $('.item-net-price').each(function() {
            total += parseFloat($(this).val()) || 0;
        });
        
        let finalTotal = (discountType == '1' 
            ? (total - (total * discount / 100)) 
            : (total - discount));
        
        $('#item_total_net_price').text(finalTotal.toFixed(2));
        
    }
    
    function loadChildOption(selectElement, editjobOption, insertOption, parentUniqueKey) {
        const $selectedOption = $(selectElement);
        const selectedOptionValue = $selectedOption.val();
        const jobcard_id = $('#jobcard_id').val();
        const optionType = $selectedOption.data('option-type');
        const subJobCategoryID = $selectedOption.data('sub-job-category');
        const optionGroupID = $selectedOption.data('option-group');
        const jobOptionID = $selectedOption.data('option-id');
        const subJobName = $selectedOption.data('subjob-name');
        const optionGroupName = $selectedOption.data('option-group-name');

        const childWrapperSelector = `.child-options-wrapper[data-parent-option-id="${jobOptionID}"]`;

        if (selectedOptionValue === '' || selectedOptionValue === null) {
            clearRowData(parentUniqueKey); 
            $(childWrapperSelector).html('');
            return false;
        }
        
        trackAjaxCall();

        if (!selectedOptionValue) {
            completeAjaxCall();
            return Promise.resolve();
        }

        if (pendingRequests[selectedOptionValue]) {
            pendingRequests[selectedOptionValue].abort();
            delete pendingRequests[selectedOptionValue];
        }

        const xhr = $.ajax({
            type: "POST",
            url: '<?php echo base_url() ?>JobCard/getItemParentOptions',
            dataType: 'json',
            data: {
                jobcard_id: jobcard_id,
                subJobCategoryID: subJobCategoryID,
                selectedOptionValue: selectedOptionValue
            },
            success: function(res) {
                if (!res.status || !res.data || res.data.length === 0) {
                    $(childWrapperSelector).html('');
                    Promise.resolve(
                        getOptionValuePrice(selectElement,subJobCategoryID, optionGroupID, selectedOptionValue, jobOptionID, $selectedOption, insertOption, parentUniqueKey)
                    ).finally(completeAjaxCall);
                    return;
                }
   
                let html = res.data.map(group => {
                    const jobOption = group.job_option;
                    const optionValues = group.option_values;

                    if (!optionValues || optionValues.length === 0) return '';
                    let uniqueKey = `${escapeHtml(jobOption.JobSubcategoryID)}_${escapeHtml(jobOption.OptionGroupID)}_${escapeHtml(jobOption.JobOptionID)}`;
                    
                    const isMediaType = ['image', 'pdf', 'file'].includes(jobOption.Description);

                    if (isMediaType) {
                        return `
                            <div class="ms-2 flex-fill">
                                <h6 class="mb-1">${escapeHtml(jobOption.OptionName)}</h6>
                                <img src="https://devapi.ecw.lk/storage/${optionValues[0].ValueName ? escapeHtml(optionValues[0].ValueName) : 'https://via.placeholder.com/50'}"
                                    id="preview_image_${jobOption.JobOptionID}"
                                    data-option-type="${escapeHtml(jobOption.OptionType)}"
                                    data-option-id="${escapeHtml(jobOption.JobOptionID)}"
                                    data-option-group="${escapeHtml(jobOption.OptionGroupID)}"
                                    data-sub-job-category="${escapeHtml(jobOption.JobSubcategoryID)}"
                                    data-subjob-name="${escapeHtml(subJobName)}"
                                    data-option-group-name="${escapeHtml(optionGroupName)}"
                                    data-option-name="${escapeHtml(jobOption.OptionName)}"
                                    data-pre-value="${escapeHtml(jobOption.option_value_id)}"
                                    alt="Preview"
                                    class="rounded border"
                                    style="width: 150px; height: auto;">
                            </div>
                            <div class="row align-items-center mb-2 job-option-row" data-level="1">
                                <div class="child-options-wrapper flex-fill" data-parent-option-id="${jobOption.JobOptionID}"></div>
                            </div>
                        `;
                    } else {
                        return `
                            <div class="ms-2 flex-fill">
                                <h6 class="mb-1">${escapeHtml(jobOption.OptionName)}</h6>
                                <select class="form-select form-select-sm job-option-select job_parent_option_f"
                                        data-option-type="${escapeHtml(jobOption.OptionType)}"
                                        data-uniq-id="${parentUniqueKey}"
                                        data-option-id="${escapeHtml(jobOption.JobOptionID)}"
                                        data-option-group="${escapeHtml(jobOption.OptionGroupID)}"
                                        data-sub-job-category="${escapeHtml(jobOption.JobSubcategoryID)}"
                                        data-subjob-name="${escapeHtml(subJobName)}"
                                        data-option-group-name="${escapeHtml(optionGroupName)}"
                                        data-option-name="${escapeHtml(jobOption.OptionName)}"
                                        data-option-description="${escapeHtml(jobOption.Description)}"
                                        data-pre-value="${escapeHtml(jobOption.option_value_id)}"
                                        ${jobOption.IsRequired == 1 ? 'required' : ''}
                                        onchange="loadChildOption(this, null, 1, '${parentUniqueKey}')">
                                    <option value="">Select an option</option>
                                    ${optionValues.map(val => `
                                        <option value="${escapeHtml(val.id)}"
                                                data-parent-id="${escapeHtml(val.ParentOptionValueID || '0')}">
                                            ${escapeHtml(val.ValueName)}
                                        </option>
                                    `).join('')}
                                </select>
                                
                            ${res.data.length > 1 ? (() => {
                                const selectedVal = optionValues.find(v => v.id == jobOption.option_value_id);
                                const unitPrice = selectedVal ? (selectedVal.edited_price ?? 0) : (jobOption.list_price ?? 0);
                                const originalPrice = selectedVal ? (selectedVal.original_price ?? 0) : (jobOption.price ?? 0);

                                return `
                                    <div class="cols-6 w-50 d-none">
                                        <label class="form-label text-muted">Unit Price</label>
                                        <input type="number"
                                            class="form-control form-control-sm"
                                            parentId="${parentUniqueKey}"
                                            id="unit_price_${uniqueKey}"
                                            value=""
                                            name="unit_price"
                                            placeholder="Enter unit price"
                                            data-original_price="${originalPrice}"
                                            step="0.01"
                                            min="0" onkeyup="schedulePriceUpdate();">
                                    </div>
                                `;
                            })() : ''}
                            </div>
                            <div class="row align-items-center mb-2 job-option-row" data-level="1">
                                <div class="child-options-wrapper flex-fill" data-parent-option-id="${jobOption.JobOptionID}"></div>
                            </div>
                        `;
                    }
                }).join('');

                $(childWrapperSelector).html(html);
                initSelect2();
                Promise.resolve(
                    getOptionValuePrice(
                        selectElement,
                        subJobCategoryID,
                        optionGroupID,
                        selectedOptionValue,
                        jobOptionID,
                        $selectedOption,
                        insertOption,
                        parentUniqueKey
                    )
                ).finally(completeAjaxCall);
            },
            error: function(xhr, status, error) {
                if (status !== 'abort') {
                    console.error("Failed to load conditional options:", error);
                    $(childWrapperSelector).html('<div class="text-danger">Error loading options</div>');
                }
                completeAjaxCall();
            },
            complete: function() {
                delete pendingRequests[selectedOptionValue];
            }
        });

        pendingRequests[selectedOptionValue] = xhr;
    }
    
    function getOptionValuePrice(selectElement,subJobCategoryID, optionGroupID, selectedOptionValue, jobOptionID, $selectedOption, insertOption, parentUniqueKey) {
        if (insertOption == '2') {
            return Promise.resolve();
        }
      
        trackAjaxCall();
        lastRequestedOptionValueId = selectedOptionValue;
        const price_category = $('#price_category').val();
        
        const xhr = $.ajax({
            type: "POST",
            dataType: 'json',
            url: '<?php echo base_url() ?>JobCard/getOptionvaluePrice',
            data: { 
                optionValueId: selectedOptionValue, 
                priceCategoryId: price_category
            },
            success: function(result) { 
                if (result.status && selectedOptionValue === lastRequestedOptionValueId) {
                    const linePriceSelector = '#unit_price_' + subJobCategoryID + '_' + optionGroupID + '_' + jobOptionID;
                    const priceSelector = '#item_price_' + parentUniqueKey;
                    const $linePriceInput = $(linePriceSelector);
                    const $priceInput = $(priceSelector);
                    //  console.log(parentUniqueKey, result.data.Price);
                    if ($linePriceInput.length) {
                        $linePriceInput
                        .val(result.data.Price)
                        .data('original_price', result.data.Price);

                        let total = 0;
                        let count = 0;
                        $(`input[name="unit_price"][parentId="${parentUniqueKey}"]`).each(function () {
                            const val = parseFloat($(this).val()) || 0;
                            total += val;
                            count++;
                        });

                        let average = count ? total / count : 0;
                        
                        $priceInput
                            .val(average.toFixed(2))
                            .data('original_price', average);
                        setTimeout(() => schedulePriceUpdate(selectElement), 500);
                    }else{
                            const price = parseFloat(result.data.Price) || 0;
                            $priceInput
                                .val(price.toFixed(2))
                                .data('original_price', price);
                            setTimeout(() => schedulePriceUpdate(selectElement), 500);
                    }
                } else {
                    schedulePriceUpdate(selectElement);
                }
            },
            complete: completeAjaxCall
        });
        
        return xhr;
    }

    function initSelect2(){
        $('.job-option-select').select2({
            dropdownParent: $('#addJobItemModal'),
            theme: "classic",
            width: '100%',
        });
    }

    function markRemarkUnsaved(inputElement) {
        var uniqId = $(inputElement).data('uniq-id');
        var $statusEl = $('#remark_save_status_' + uniqId);
        $statusEl.text('Not Saved').removeClass('text-success').addClass('text-danger');
    }

    function handleRemarkEnter(inputElement) {
        var uniqId = $(inputElement).data('uniq-id');
        addToJobCard(2);
        var $statusEl = $('#remark_save_status_' + uniqId);
        $statusEl.text('Saved').removeClass('text-danger').addClass('text-success');
    }


    $('.remark_f').on('input', function () {
        let remarkTimeouts = {};
        const inputElement = this;
        const uniqId = $(inputElement).data('uniq-id');

        clearTimeout(remarkTimeouts[uniqId]);

        remarkTimeouts[uniqId] = setTimeout(function () {
            addToJobCard(2); 
            
            $('#remark_save_status_' + uniqId)
                .text('Saved')
                .removeClass('text-danger')
                .addClass('text-success');
        }, 1500);
    });

    function clearRowData(parentUniqueKey){
        $('#item_price_' + parentUniqueKey).val('').removeClass('is-invalid');
        $('#item_qty_' + parentUniqueKey).val('').removeClass('is-invalid');
        $('#item_total_price_' + parentUniqueKey).val('').removeClass('is-invalid');
        $('#line_discount_type_' + parentUniqueKey).val('1').removeClass('is-invalid');
        $('#line_discount_' + parentUniqueKey).val('').removeClass('is-invalid');
        $('#item_net_price_' + parentUniqueKey).val('').removeClass('is-invalid');
    }

    function escapeHtml(unsafe) {
        return unsafe?.toString()
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;") || '';
    }

    $(document).ready(function() {
        console.log('Document ready - starting initialization');
        init();
    });

</script>