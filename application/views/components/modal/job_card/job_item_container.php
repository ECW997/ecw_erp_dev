<?php if ($data['status']): ?>
    <?php if (!empty($data['data'])): ?>
        <?php foreach ($data['data'] as $subJob): ?>
            <div class="mb-3">
                <p class="mb-0">
                    <a class="jobSubItem text-info" data-toggle="collapse" href="#collapse<?php echo  $subJob['sub_job_category']['idtbl_sub_job_category'] ?>"
                        role="button" aria-expanded="false" aria-controls="collapse<?php echo  $subJob['sub_job_category']['idtbl_sub_job_category'] ?>">
                        <i class="fas fa-caret-right text-dark"></i>
                        <?php echo  $subJob['sub_job_category']['sub_job_category'] ?> 
                    </a>
                </p>
                <div class="collapse" id="collapse<?php echo  $subJob['sub_job_category']['idtbl_sub_job_category'] ?>">
                	<div class="card card-body">
                        <?php foreach ($subJob['job_options'] as $jobOptionGroup): ?>
                            <div class="mb-3 p-2 border border-1 bg-light">
                            	<h6 class="text-secondary"><?php echo $jobOptionGroup['job_option_group']['GroupName']; ?></h6>
                            	<div class="row">
                            		<div class="col-6">
                            		<?php 
                                    $i = 0;
                                    foreach ($jobOptionGroup['job_options'] as $jobOption): 
                                        if ($jobOption['job_option']['OptionType'] == 'Primary' || $jobOption['job_option']['OptionType'] == 'Type'):
                                            if ($i % 2 == 0): ?>
                            			        <div class="row job-option-wrapper" data-level="0">
                            				<?php endif; ?>
                                                <div class="col-6">
                                                    <h6 class="col-form-label me-2 text-nowrap">
                                                        <?php echo $jobOption['job_option']['OptionName']; ?></h6>
                                                    <select class="form-select form-select-sm job-option-select"
                                                        id="job_option_<?php echo $jobOption['job_option']['JobOptionID']; ?>"
                                                        name="job_option_<?php echo $jobOption['job_option']['JobOptionID']; ?>"
                                                        data-option-type="<?php echo $jobOption['job_option']['OptionType']; ?>"
                                                        data-option-id="<?php echo $jobOption['job_option']['JobOptionID']; ?>"
                                                        data-option-group="<?php echo $jobOptionGroup['job_option_group']['id']; ?>"
                                                        data-sub-job-category="<?php echo $subJob['sub_job_category']['idtbl_sub_job_category']; ?>"
                                                        data-level="0">
                                                        <option value="">Select an option</option>
                                                        <?php foreach ($jobOption['option_values'] as $optionValue): ?>
                                                        <option value="<?php echo $optionValue['id']; ?>">
                                                            <?php echo $optionValue['ValueName']; ?>
                                                        </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <div class="child-options-wrapper" data-parent-option-id="<?php echo $jobOption['job_option']['JobOptionID']; ?>"></div>
                                                </div>
                            				<?php 
                                            if ($i % 2 == 1): ?>
                            			</div> 
                            			<?php endif;
                                            $i++;
                                        endif;
                                    endforeach;
                                    if ($i % 2 != 0): ?>
                            		</div> 
                            		<?php endif; ?>
                            		<div class="conditional-options-container"></div>
                            	</div>
                                <?php
                                    $uniqueKey = $subJob['sub_job_category']['idtbl_sub_job_category'] . '_' . $jobOptionGroup['job_option_group']['id'];
                                ?>
                            	<div class="col-6">
                            		<div class="row justify-content-end">
                            			<div class="col-4">
                            				<h6 class="col-form-label me-2 text-nowrap">Price</h6>
                            				<input class="form-control form-control-sm text-end item-price" type="number" step="any"
                            					id="item_price_<?php echo $uniqueKey; ?>" name="item_price_<?php echo $uniqueKey; ?>" data-uniq-id="<?php echo $uniqueKey; ?>">
                            			</div>
                            			<div class="col-3">
                            				<h6 class="col-form-label me-2 text-nowrap">QTY</h6>
                            				<input class="form-control form-control-sm text-end  item-qty" type="number" step="any"
                            					id="item_qty_<?php echo $uniqueKey; ?>" name="item_qty_<?php echo $uniqueKey; ?>" data-uniq-id="<?php echo $uniqueKey; ?>">
                            			</div>
                            			<div class="col-4">
                            				<h6 class="col-form-label me-2 text-nowrap">Net Price</h6>
                            				<input class="form-control form-control-sm text-end item-net-price" type="number" step="any"
                            					id="item_net_price_<?php echo $uniqueKey; ?>" name="item_net_price_<?php echo $uniqueKey; ?>" data-uniq-id="<?php echo $uniqueKey; ?>" readonly>
                            			</div>
                            		</div>
                            	</div>
                            	</div>
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
                                        <label class="mt-2 fw-bold">${jobOption.OptionName}</label>
                                        <select class="form-select job-option-select"
                                            data-option-id="${jobOption.JobOptionID}"
                                            data-sub-job-category="${jobOption.JobSubcategoryID}">
                                            <option value="">Select an option</option>`;

                                optionValues.forEach(function(val) {
                                    html += `<option value="${val.id}">${val.ValueName}</option>`;
                                });

                                html += `</select>`;
                            }
                        });

                        // Inject the generated HTML into the correct place (conditional options)
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
        }

        getOptionvaluePrice(subJobCategoryID,optionGroupID,selectedOptionValue);
    });

    $(document).on('input', '.item-price, .item-qty', function () {   
        const uniqId = $(this).data('uniq-id');
        const price = parseFloat($('#item_price_'+uniqId).val()) || 0;
        const qty = parseFloat($('#item_qty_'+uniqId).val()) || 0;
        const netPrice = price * qty;
        $('#item_net_price_'+uniqId).val(netPrice.toFixed(2));

        updateTotalNetPrice();
    });

    function getOptionvaluePrice(subJobCategoryID,optionGroupID,selectedOptionValue){
       var price_category = $('#price_category').val();
       $.ajax({
            type: "POST",
            dataType: 'json',
            url: '<?php echo base_url() ?>JobCard/getOptionvaluePrice',
            data: { optionValueId: selectedOptionValue, 
                    priceCategoryId: price_category},
            success: function(result) { 
                if(result.status){
                    $('#item_price_' + subJobCategoryID + '_' + optionGroupID).val(result.data.Price);
                }
            }
        });
    }

    function updateTotalNetPrice() {
        let total = 0;

        $('.item-net-price').each(function () {
            const val = parseFloat($(this).val()) || 0;
            total += val;
        });

        $('#item_total_net_price').text(total.toFixed(2));
    }
</script>
