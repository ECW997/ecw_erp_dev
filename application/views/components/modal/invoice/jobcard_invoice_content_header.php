<style>
.tooltip-inner {
    max-width: none !important;
    padding: 0;
    text-align: left;
}

.custom-tooltip-box {
    width: 240px;
    padding: 8px;
    border-radius: 4px;
}

.disabled-pointer-events {
    pointer-events: none;
}

.vl {
    border-left: 4px solid rgb(60, 90, 180);
    height: 100px;
}

.font-weight-600 {
    font-weight: 600;
}
</style>


<div class="card">
    <div class="card-body p-0 p-2">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <form id="createorderform" autocomplete="off">
                    <div class="row">
                        <div class="col-3">
                            <label class="small font-weight-bold text-dark">Date <span
                                    class="text-danger">*</span></label>
                            <input type="date" class="form-control form-control-sm" placeholder="" name="date" id="date"
                                value="<?php echo date('Y-m-d') ?>" required readonly>

                        </div>
                        <div class="col-3">
                            <label class="small font-weight-bold text-dark">Job Card Number <span
                                    class="text-danger">*</span></label>
                            <select class="form-control form-control-sm  px-0" name="customer" id="customer" required>
                                <option value="">Select</option>

                            </select>
                        </div>
                        <div class="col-3">
                            <label class="small font-weight-bold text-dark">Customer <span
                                    class="text-danger">*</span></label>
                            <input type="number" step="any" name="customer_name" class="form-control form-control-sm"
                                id="customer_name" required>
                        </div>
                        <div class="col-3">
                            <label class="small font-weight-bold text-dark">Address <span
                                    class="text-danger">*</span></label>
                            <input type="number" step="any" name="customer_address" class="form-control form-control-sm"
                                id="customer_address" required>
                        </div>
                    </div>


                    <div class="row">

                        <div class="col-3">
                            <label class="small font-weight-bold text-dark">Vehicle No <span
                                    class="text-danger">*</span></label>
                            <input type="number" step="any" name="customer_address" class="form-control form-control-sm"
                                id="customer_address" required>
                        </div>
                        <div class="col-3">
                            <label class="small font-weight-bold text-dark">VAT Reg No </label>
                            <input type="number" step="any" name="customer_address" class="form-control form-control-sm"
                                id="customer_address" required>
                        </div>
                        <div class="col-3">
                            <label class="small font-weight-bold text-dark">Vehicle In Date <span
                                    class="text-danger">*</span></label>
                            <input type="date" class="form-control form-control-sm" placeholder="" name="date" id="date"
                                value="<?php echo date('Y-m-d') ?>" required>
                        </div>
                        <div class="col-3">
                            <input type="text" id="inquerydetailsid" name="inquerydetailsid"
                                class="form-control form-control-sm" />
                        </div>
                    </div>


                    <!-- <div class="form-group mt-2 text-right">
                        <button type="button" id="formsubmit" class="btn btn-primary btn-sm px-4"><i
                                class="fas fa-plus"></i>&nbsp;Add
                            to
                            list</button>
                        <input name="submitBtn" type="submit" value="Save" id="submitBtn" class="d-none">
                    </div> -->
                    <input type="hidden" name="refillprice" id="refillprice" value="">
                    <input type="hidden" name="recordOption" id="recordOption" value="1">
                </form>

            </div>
        </div>
    </div> 
</div>



<script>
function addCommas(nStr) {
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}
</script>