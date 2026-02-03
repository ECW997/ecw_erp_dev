<?php include APPPATH . "views/include/header.php"; ?>
<?php include APPPATH . "views/include/topnavbar.php"; ?>
<style>
.card-header {
    background-color: white;
    border-bottom: 1px solid #6c757d;
    padding: 1rem 2rem;
}
label {
    color: #6c757d;
    font-weight: 700;
    font-size: 0.85rem;
    white-space: nowrap;
    margin-bottom: 0;
    line-height: 1.5;
}
.alert-warning {
    background-color: #fff3cd;
    border-color: #ffc107;
    color: #856404;
}
</style>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <?php include APPPATH . "views/include/menubar.php"; ?>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="page-header page-header-light bg-white shadow">
                <div class="container-fluid">
                    <div class="page-header-content py-3 d-flex justify-content-between align-items-center">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i class="fas fa-exclamation-triangle text-danger"></i></div>
                            <span>Emergency Action - Sales Order Cancellation</span>
                        </h1>
                        <div>
                            <a href="<?= base_url('AdminPortal') ?>" class="btn btn-secondary btn-sm px-4 p-2">
                                <i class="fas fa-arrow-left mr-2"></i>Back to Portal
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="alert alert-warning" role="alert">
                    <h5 class="alert-heading"><i class="fas fa-exclamation-triangle mr-2"></i>Warning: Emergency Action</h5>
                    <p class="mb-0">This action will permanently cancel the sales order relation and all linked records (sales orders, exclude sales orders, invoices, exclude invoices, payments, and temp payments). This action cannot be undone. Please verify all details before proceeding.</p>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Sales Order Relation Details</h5>
                    </div>
                    <div class="card-body">
                        <form id="emergencyActionForm">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sales_order_relation_id">Sales Order Relation ID <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="sales_order_relation_id" name="sales_order_relation_id" required>
                                        <small class="form-text text-muted">Enter the Sales Order Relation ID to cancel</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <button type="button" class="btn btn-info btn-block" id="verifyBtn">
                                            <i class="fas fa-search mr-2"></i>Verify & Load Details
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- Sales Order Details Display -->
                        <div id="salesOrderDetails" style="display: none;">
                            <hr>
                            <h5>Sales Order Relation Information</h5>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <table class="table table-sm table-bordered">
                                        <tr>
                                            <th width="40%">Job Card ID:</th>
                                            <td id="detail_jobcard_id">-</td>
                                        </tr>
                                        <tr>
                                            <th>Job Card No:</th>
                                            <td id="detail_jobcard_no">-</td>
                                        </tr>
                                        <tr>
                                            <th>Total Job Card Price:</th>
                                            <td id="detail_total_price">-</td>
                                        </tr>
                                        <tr>
                                            <th>Confirmed Order Value:</th>
                                            <td id="detail_confirmed_value">-</td>
                                        </tr>
                                        <tr>
                                            <th>Branch:</th>
                                            <td id="detail_branch">-</td>
                                        </tr>
                                        <tr>
                                            <th>Status:</th>
                                            <td id="detail_status">-</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <!-- Series 1: Sales Order, Invoice, Payment Details -->
                            <div class="card mb-3">
                                <div class="card-header bg-primary text-white">
                                    <h6 class="mb-0"><i class="fas fa-shopping-cart mr-2"></i>Series 1: Sales Order, Invoice & Payment Details</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <!-- Sales Order Section -->
                                        <div class="col-md-4">
                                            <h6 class="text-primary border-bottom pb-2">Sales Order</h6>
                                            <table class="table table-sm table-bordered">
                                                <tr>
                                                    <th width="50%">SO ID:</th>
                                                    <td id="series1_so_id">-</td>
                                                </tr>
                                                <tr>
                                                    <th>SO Number:</th>
                                                    <td id="series1_so_no">-</td>
                                                </tr>
                                                <tr>
                                                    <th>Status:</th>
                                                    <td id="series1_so_status">-</td>
                                                </tr>
                                                <tr>
                                                    <th>Sub Total:</th>
                                                    <td id="series1_so_subtotal">-</td>
                                                </tr>
                                                <tr>
                                                    <th>Discount:</th>
                                                    <td id="series1_so_discount">-</td>
                                                </tr>
                                                <tr>
                                                    <th>Net Total:</th>
                                                    <td id="series1_so_net_total">-</td>
                                                </tr>
                                                <tr>
                                                    <th>Details Count:</th>
                                                    <td id="series1_so_details_count">-</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <!-- Invoice Section -->
                                        <div class="col-md-4">
                                            <h6 class="text-success border-bottom pb-2">Invoice</h6>
                                            <table class="table table-sm table-bordered">
                                                <tr>
                                                    <th width="50%">Invoice ID:</th>
                                                    <td id="series1_inv_id">-</td>
                                                </tr>
                                                <tr>
                                                    <th>Invoice Number:</th>
                                                    <td id="series1_inv_no">-</td>
                                                </tr>
                                                <tr>
                                                    <th>Grand Total:</th>
                                                    <td id="series1_inv_total">-</td>
                                                </tr>
                                                <tr>
                                                    <th>Status:</th>
                                                    <td id="series1_inv_status">-</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <!-- Payment Section -->
                                        <div class="col-md-4">
                                            <h6 class="text-info border-bottom pb-2">Payments</h6>
                                            <div id="series1_payments_list">
                                                <p class="text-muted mb-0">No payments found</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Series 2: Exclude Sales Order, Exclude Invoice, Temp Payment Details -->
                            <div class="card mb-3">
                                <div class="card-header bg-warning text-dark">
                                    <h6 class="mb-0"><i class="fas fa-exchange-alt mr-2"></i>Series 2: Exclude Sales Order, Exclude Invoice & Temp Payment Details</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <!-- Exclude Sales Order Section -->
                                        <div class="col-md-4">
                                            <h6 class="text-warning border-bottom pb-2">Exclude Sales Order</h6>
                                            <table class="table table-sm table-bordered">
                                                <tr>
                                                    <th width="50%">ESO ID:</th>
                                                    <td id="series2_eso_id">-</td>
                                                </tr>
                                                <tr>
                                                    <th>ESO Number:</th>
                                                    <td id="series2_eso_no">-</td>
                                                </tr>
                                                <tr>
                                                    <th>Status:</th>
                                                    <td id="series2_eso_status">-</td>
                                                </tr>
                                                <tr>
                                                    <th>Sub Total:</th>
                                                    <td id="series2_eso_subtotal">-</td>
                                                </tr>
                                                <tr>
                                                    <th>Discount:</th>
                                                    <td id="series2_eso_discount">-</td>
                                                </tr>
                                                <tr>
                                                    <th>Net Total:</th>
                                                    <td id="series2_eso_net_total">-</td>
                                                </tr>
                                                <tr>
                                                    <th>Details Count:</th>
                                                    <td id="series2_eso_details_count">-</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <!-- Exclude Invoice Section -->
                                        <div class="col-md-4">
                                            <h6 class="text-danger border-bottom pb-2">Exclude Invoice</h6>
                                            <table class="table table-sm table-bordered">
                                                <tr>
                                                    <th width="50%">Exclude Inv ID:</th>
                                                    <td id="series2_einv_id">-</td>
                                                </tr>
                                                <tr>
                                                    <th>Exclude Inv Number:</th>
                                                    <td id="series2_einv_no">-</td>
                                                </tr>
                                                <tr>
                                                    <th>Grand Total:</th>
                                                    <td id="series2_einv_total">-</td>
                                                </tr>
                                                <tr>
                                                    <th>Status:</th>
                                                    <td id="series2_einv_status">-</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <!-- Temp Payment Section -->
                                        <div class="col-md-4">
                                            <h6 class="text-secondary border-bottom pb-2">Temp Payments</h6>
                                            <div id="series2_temp_payments_list">
                                                <p class="text-muted mb-0">No temp payments found</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Confirmation Form -->
                        <div id="confirmationForm" style="display: none;">
                            <hr>
                            <h5>Action Confirmation</h5>
                            <div class="form-group">
                                <label for="reason">Reason for Emergency Action <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="reason" name="reason" rows="4" required placeholder="Please provide a detailed reason for this emergency action..."></textarea>
                                <small class="form-text text-muted">This reason will be logged for audit purposes</small>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="confirmCheck" required>
                                    <label class="custom-control-label" for="confirmCheck">
                                        I understand that this action will permanently cancel the sales order relation and all linked records. This action cannot be undone.
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="button" class="btn btn-danger btn-lg" id="executeBtn">
                                    <i class="fas fa-exclamation-triangle mr-2"></i>Execute Emergency Action
                                </button>
                                <button type="button" class="btn btn-secondary btn-lg ml-2" onclick="window.location.href='<?= base_url('AdminPortal') ?>'">
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php include APPPATH . "views/include/footerbar.php"; ?>
    </div>
</div>
<?php include APPPATH . "views/include/footerscripts.php"; ?>
<script>
var base_url = '<?= base_url() ?>';
var salesOrderRelationId = null;
var branchId = null;

// Branch name mapping
var branchNames = {
    1: 'Nittambuwa',
    2: 'Negombo'
};

$(document).ready(function() {
    $('#verifyBtn').on('click', function() {
        var relationId = $('#sales_order_relation_id').val();
        
        if (!relationId) {
            showAlert('Please enter a Sales Order Relation ID', 'danger');
            return;
        }

        $('#verifyBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Loading...');

        $.ajax({
            url: base_url + 'AdminPortal/getSalesOrderDetails',
            type: 'POST',
            data: {
                sales_order_id: relationId
            },
            dataType: 'json',
            success: function(response) {
                $('#verifyBtn').prop('disabled', false).html('<i class="fas fa-search mr-2"></i>Verify & Load Details');
                
                if (response.status && response.data) {
                    var data = response.data;
                    salesOrderRelationId = relationId;
                    // Store branch_id from response (now it's just an integer, not an object)
                    branchId = data.branch ? parseInt(data.branch) : null;
                    
                    // Get branch name from mapping
                    var branchName = branchId && branchNames[branchId] ? branchNames[branchId] : (branchId ? 'Branch ' + branchId : '-');
                    
                    // Populate basic details
                    $('#detail_jobcard_id').text(data.jobcard_id || '-');
                    $('#detail_jobcard_no').text(data.jobcard_no || '-');
                    $('#detail_total_price').text(data.total_jobcard_price ? parseFloat(data.total_jobcard_price).toFixed(2) : '-');
                    $('#detail_confirmed_value').text(data.confirmed_order_value ? parseFloat(data.confirmed_order_value).toFixed(2) : '-');
                    $('#detail_branch').text(branchName);
                    $('#detail_status').text(data.status || '-');
                    
                    // Series 1: Sales Order, Invoice, Payment Details
                    if (data.series1) {
                        var series1 = data.series1;
                        
                        // Sales Order Details
                        if (series1.sales_order) {
                            $('#series1_so_id').text(series1.sales_order.id || '-');
                            $('#series1_so_no').text(series1.sales_order.salesorder_no || '-');
                            $('#series1_so_status').text(series1.sales_order.status || '-');
                            $('#series1_so_subtotal').text(series1.sales_order.sub_total ? parseFloat(series1.sales_order.sub_total).toFixed(2) : '-');
                            $('#series1_so_discount').text(series1.sales_order.discount_amount ? parseFloat(series1.sales_order.discount_amount).toFixed(2) : '-');
                            $('#series1_so_net_total').text(series1.sales_order.net_total ? parseFloat(series1.sales_order.net_total).toFixed(2) : '-');
                            $('#series1_so_details_count').text(series1.sales_order_details_count || '0');
                        } else {
                            $('#series1_so_id').text('-');
                            $('#series1_so_no').text('No Sales Order');
                            $('#series1_so_status').text('-');
                            $('#series1_so_subtotal').text('-');
                            $('#series1_so_discount').text('-');
                            $('#series1_so_net_total').text('-');
                            $('#series1_so_details_count').text('0');
                        }
                        
                        // Invoice Details
                        if (series1.invoice) {
                            $('#series1_inv_id').text(series1.invoice.id || '-');
                            $('#series1_inv_no').text(series1.invoice.invoice_number || '-');
                            $('#series1_inv_total').text(series1.invoice.inv_grand_total ? parseFloat(series1.invoice.inv_grand_total).toFixed(2) : '-');
                            $('#series1_inv_status').text(series1.invoice.inv_status || '-');
                        } else {
                            $('#series1_inv_id').text('-');
                            $('#series1_inv_no').text('No Invoice');
                            $('#series1_inv_total').text('-');
                            $('#series1_inv_status').text('-');
                        }
                        
                        // Payments List
                        if (series1.payments && series1.payments.length > 0) {
                            var paymentsHtml = '<table class="table table-sm table-bordered mb-0">';
                            paymentsHtml += '<thead><tr><th>Receipt No</th><th>Amount</th><th>Date</th></tr></thead><tbody>';
                            series1.payments.forEach(function(pay) {
                                paymentsHtml += '<tr>';
                                paymentsHtml += '<td><strong>' + (pay.receipt_number || 'N/A') + '</strong></td>';
                                paymentsHtml += '<td>' + (pay.total_received_amount ? parseFloat(pay.total_received_amount).toFixed(2) : '-') + '</td>';
                                paymentsHtml += '<td>' + (pay.receipt_date || '-') + '</td>';
                                paymentsHtml += '</tr>';
                            });
                            paymentsHtml += '</tbody></table>';
                            $('#series1_payments_list').html(paymentsHtml);
                        } else {
                            $('#series1_payments_list').html('<p class="text-muted mb-0">No payments found</p>');
                        }
                    }
                    
                    // Series 2: Exclude Sales Order, Exclude Invoice, Temp Payment Details
                    if (data.series2) {
                        var series2 = data.series2;
                        
                        // Exclude Sales Order Details
                        if (series2.exclude_sales_order) {
                            $('#series2_eso_id').text(series2.exclude_sales_order.id || '-');
                            $('#series2_eso_no').text(series2.exclude_sales_order.salesorder_no || '-');
                            $('#series2_eso_status').text(series2.exclude_sales_order.status || '-');
                            $('#series2_eso_subtotal').text(series2.exclude_sales_order.sub_total ? parseFloat(series2.exclude_sales_order.sub_total).toFixed(2) : '-');
                            $('#series2_eso_discount').text(series2.exclude_sales_order.discount_amount ? parseFloat(series2.exclude_sales_order.discount_amount).toFixed(2) : '-');
                            $('#series2_eso_net_total').text(series2.exclude_sales_order.net_total ? parseFloat(series2.exclude_sales_order.net_total).toFixed(2) : '-');
                            $('#series2_eso_details_count').text(series2.exclude_sales_order_details_count || '0');
                        } else {
                            $('#series2_eso_id').text('-');
                            $('#series2_eso_no').text('No Exclude Sales Order');
                            $('#series2_eso_status').text('-');
                            $('#series2_eso_subtotal').text('-');
                            $('#series2_eso_discount').text('-');
                            $('#series2_eso_net_total').text('-');
                            $('#series2_eso_details_count').text('0');
                        }
                        
                        // Exclude Invoice Details
                        if (series2.exclude_invoice) {
                            $('#series2_einv_id').text(series2.exclude_invoice.id || '-');
                            $('#series2_einv_no').text(series2.exclude_invoice.invoice_number || '-');
                            $('#series2_einv_total').text(series2.exclude_invoice.inv_grand_total ? parseFloat(series2.exclude_invoice.inv_grand_total).toFixed(2) : '-');
                            $('#series2_einv_status').text(series2.exclude_invoice.inv_status || '-');
                        } else {
                            $('#series2_einv_id').text('-');
                            $('#series2_einv_no').text('No Exclude Invoice');
                            $('#series2_einv_total').text('-');
                            $('#series2_einv_status').text('-');
                        }
                        
                        // Temp Payments List
                        if (series2.temp_payments && series2.temp_payments.length > 0) {
                            var tempPaymentsHtml = '<table class="table table-sm table-bordered mb-0">';
                            tempPaymentsHtml += '<thead><tr><th>Receipt No</th><th>Amount</th><th>Date</th></tr></thead><tbody>';
                            series2.temp_payments.forEach(function(pay) {
                                tempPaymentsHtml += '<tr>';
                                tempPaymentsHtml += '<td><strong>' + (pay.receipt_number || 'N/A') + '</strong></td>';
                                tempPaymentsHtml += '<td>' + (pay.total_received_amount ? parseFloat(pay.total_received_amount).toFixed(2) : '-') + '</td>';
                                tempPaymentsHtml += '<td>' + (pay.receipt_date || '-') + '</td>';
                                tempPaymentsHtml += '</tr>';
                            });
                            tempPaymentsHtml += '</tbody></table>';
                            $('#series2_temp_payments_list').html(tempPaymentsHtml);
                        } else {
                            $('#series2_temp_payments_list').html('<p class="text-muted mb-0">No temp payments found</p>');
                        }
                    }
                    
                    $('#salesOrderDetails').slideDown();
                    $('#confirmationForm').slideDown();
                } else {
                    showAlert(response.message || 'Failed to load sales order details', 'danger');
                }
            },
            error: function(xhr) {
                $('#verifyBtn').prop('disabled', false).html('<i class="fas fa-search mr-2"></i>Verify & Load Details');
                var errorMsg = 'Error loading details';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                showAlert(errorMsg, 'danger');
            }
        });
    });

    $('#executeBtn').on('click', function() {
        if (!$('#confirmCheck').is(':checked')) {
            showAlert('Please confirm that you understand the consequences of this action', 'warning');
            return;
        }

        if (!$('#reason').val().trim()) {
            showAlert('Please provide a reason for this emergency action', 'warning');
            return;
        }

        if (!confirm('Are you absolutely sure you want to execute this emergency action? This cannot be undone!')) {
            return;
        }

        $('#executeBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Executing...');

        if (!branchId) {
            showAlert('Branch information not available. Please verify the sales order relation again.', 'danger');
            return;
        }

        $.ajax({
            url: base_url + 'AdminPortal/executeEmergencyAction',
            type: 'POST',
            data: {
                sales_order_relation_id: salesOrderRelationId,
                reason: $('#reason').val(),
                branch_id: branchId
            },
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    showAlert('Emergency action executed successfully', 'success');
                    setTimeout(function() {
                        window.location.href = base_url + 'AdminPortal';
                    }, 2000);
                } else {
                    $('#executeBtn').prop('disabled', false).html('<i class="fas fa-exclamation-triangle mr-2"></i>Execute Emergency Action');
                    showAlert(response.message || 'Failed to execute emergency action', 'danger');
                }
            },
            error: function(xhr) {
                $('#executeBtn').prop('disabled', false).html('<i class="fas fa-exclamation-triangle mr-2"></i>Execute Emergency Action');
                var errorMsg = 'Error executing action';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                showAlert(errorMsg, 'danger');
            }
        });
    });

    function showAlert(message, type) {
        var alertHtml = '<div class="alert alert-' + type + ' alert-dismissible fade show" role="alert">' +
            message +
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
            '<span aria-hidden="true">&times;</span>' +
            '</button></div>';
        $('.container-fluid').first().prepend(alertHtml);
        setTimeout(function() {
            $('.alert').fadeOut();
        }, 5000);
    }
});
</script>
