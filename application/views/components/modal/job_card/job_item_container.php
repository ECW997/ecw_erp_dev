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
                                            $option = $jobOption['job_option'];
                                            $optionId = $option['JobOptionID'];
                                            $groupId = $jobOptionGroup['job_option_group']['id'];
                                            $subJobId = $subJob['sub_job_category']['idtbl_sub_job_category'];
                                            $uniqueKey = $subJobId . '_' . $groupId . '_' . $optionId;
                                            $isRequired = $option['IsRequired'] == 1 ? 'required' : '';
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
                                                        <?= $isRequired ?>>
                                                        <option value="">Select an option</option>
                                                        <?php foreach ($jobOption['option_values'] as $optionValue): ?>
                                                        <option value="<?= $optionValue['id'] ?>">
                                                            <?= $optionValue['ValueName'] ?>
                                                        </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>

                                                <div class="child-options-wrapper flex-fill"
                                                    data-parent-option-id="<?= $optionId ?>"></div>
                                            </div>

                                            <div class="col-md-2">
                                                <label class="form-label mb-1">Price</label>
                                                <input class="form-control form-control-sm text-end item-price item_price_f"
                                                    type="number" step="any"
                                                    id="item_price_<?= $uniqueKey ?>"
                                                    name="item_price_<?= $uniqueKey ?>"
                                                    data-uniq-id="<?= $uniqueKey ?>">
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label mb-1">QTY</label>
                                                <input class="form-control form-control-sm text-end item-qty item_qty_f"
                                                    type="number" step="any"
                                                    id="item_qty_<?= $uniqueKey ?>"
                                                    name="item_qty_<?= $uniqueKey ?>"
                                                    data-uniq-id="<?= $uniqueKey ?>">
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label mb-1">Net Price</label>
                                                <input class="form-control form-control-sm text-end item-net-price item_net_price_f"
                                                    type="number" step="any" readonly
                                                    id="item_net_price_<?= $uniqueKey ?>"
                                                    name="item_net_price_<?= $uniqueKey ?>"
                                                    data-uniq-id="<?= $uniqueKey ?>">
                                            </div>
                                        </div>
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
    let editedSubJobs = new Set();
    $(document).on('change input', '.sub-job-collapse input, .sub-job-collapse select', function () {
        let subJobId = $(this).closest('.sub-job-collapse').data('subjob-id');
        if (subJobId) {
            editedSubJobs.add(subJobId);
        }
    });

    $(document).on('change', '.job-option-select', function () {
        var selectedOptionValue = $(this).val();   
        var optionType = $(this).data('option-type'); 
        var subJobCategoryID = $(this).data('sub-job-category'); 
        var optionGroupID = $(this).data('option-group'); 
        const jobOptionID = $(this).data('option-id');
        const currentWrapper = $(this).closest('.job-option-wrapper');


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
                            const jobOption = group.job_option;
                            const optionValues = group.option_values;

                            if (optionValues.length > 0) {
                                html += `
                                        <div class="ms-2 flex-fill">
                                            <h6 class="mb-1">${jobOption.OptionName}</h6>
                                            <select class="form-select form-select-sm job-option-select job_parent_option_f"
                                                data-option-type="${jobOption.OptionType}"
                                                data-option-id="${jobOption.JobOptionID}"
                                                data-option-group="${jobOption.OptionGroupID}"
                                                data-sub-job-category="${jobOption.JobSubcategoryID}"
                                                ${jobOption.IsRequired == 1 ? 'required' : ''}>
                                                <option value="">Select an option</option>`;
                                                
                                    optionValues.forEach(function(val) {
                                        html += `<option value="${val.id}">${val.ValueName}</option>`;
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
                    }else {
                            $(`.child-options-wrapper[data-parent-option-id="${jobOptionID}"]`).html('');
                        }
            },
            error: function() {
                console.error("Failed to load conditional options.");
            }
            });
        }else{
            $(`.child-options-wrapper[data-parent-option-id="${jobOptionID}"]`).html('');
        }

        getOptionvaluePrice(subJobCategoryID,optionGroupID,selectedOptionValue,jobOptionID);
    });

    $(document).on('input', '.item-price, .item-qty, .item_discount', function () {   
        const uniqId = $(this).data('uniq-id');
        const price = parseFloat($('#item_price_'+uniqId).val()) || 0;
        const qty = parseFloat($('#item_qty_'+uniqId).val()) || 0;
        const netPrice = price * qty;
        $('#item_net_price_'+uniqId).val(netPrice.toFixed(2));

        updateTotalNetPrice();
    });

    function getOptionvaluePrice(subJobCategoryID,optionGroupID,selectedOptionValue,jobOptionID){
       var price_category = $('#price_category').val();
       $.ajax({
            type: "POST",
            dataType: 'json',
            url: '<?php echo base_url() ?>JobCard/getOptionvaluePrice',
            data: { optionValueId: selectedOptionValue, 
                    priceCategoryId: price_category},
            success: function(result) { 
                if(result.status){
                    $('#item_price_' + subJobCategoryID + '_' + optionGroupID+'_'+jobOptionID).val(result.data.Price);
                }
            }
        });
    }

    function updateTotalNetPrice() {
        let total = 0;
        let discount = parseFloat($('#item_discount').val()) || 0;
        let discount_type = $('#discount_type').val();
        $('.item-net-price').each(function () {
            const val = parseFloat($(this).val()) || 0;
            total += val;
        });

        discount_type
        let final_total = (discount_type == '1' ? (total - (total * discount / 100)) : (total - discount)) ;

        $('#item_total_net_price').text(final_total.toFixed(2));
    }


</script>
