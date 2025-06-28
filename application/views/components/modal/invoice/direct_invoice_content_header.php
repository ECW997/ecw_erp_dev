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
        <form id="createorderform" autocomplete="off">
            <div class="row">
                <!-- Date -->
                <div class="col-3">
                    <label class="small font-weight-bold text-dark">Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control form-control-sm" name="date" id="date"
                        value="<?php echo date('Y-m-d') ?>" required readonly>
                </div>

                <!-- Item Selection -->
                <div class="col-3">
                    <label class="small font-weight-bold text-dark">Item <span class="text-danger">*</span></label>
                    <select class="form-control form-control-sm" name="item" id="item" required>
                        <option value="">Select Item</option>
                        <!-- Populate options dynamically -->
                    </select>
                </div>

                <!-- Quantity -->
                <div class="col-3">
                    <label class="small font-weight-bold text-dark">Quantity <span class="text-danger">*</span></label>
                    <input type="number" step="any" name="qty" class="form-control form-control-sm" id="qty" required>
                </div>

                <!-- Customer Name -->
                <div class="col-3">
                    <label class="small font-weight-bold text-dark">Customer Name <span class="text-danger">*</span></label>
                    <input type="text" name="customer_name" class="form-control form-control-sm" id="customer_name" required>
                </div>
            </div>

            <div class="row mt-2">
                <!-- Customer Address -->
                <div class="col-6">
                    <label class="small font-weight-bold text-dark">Customer Address <span class="text-danger">*</span></label>
                    <input type="text" name="customer_address" class="form-control form-control-sm" id="customer_address" required>
                </div>

                <!-- Discount -->
                <div class="col-3">
                    <label class="small font-weight-bold text-dark">Discount</label>
                    <input type="number" step="any" name="discount" class="form-control form-control-sm" id="discount" value="0">
                </div>
            </div>

            <div class="form-group mt-3 text-right">
                <button type="button" id="formsubmit" class="btn btn-primary btn-sm px-4">
                    <i class="fas fa-plus"></i>&nbsp;Add to list
                </button>
                <input name="submitBtn" type="submit" value="Save" id="submitBtn" class="d-none">
            </div>
        </form>
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