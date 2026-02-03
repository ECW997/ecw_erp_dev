<?php include APPPATH . "views/include/header.php"; ?>
<?php include APPPATH . "views/include/topnavbar.php"; ?>
<style>
.card-header {
    background-color: white;
    border-bottom: 1px solid #6c757d;
    padding: 1rem 2rem;
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
                            <div class="page-header-icon"><i class="fas fa-file-alt"></i></div>
                            <span>Emergency Action Log Details</span>
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
                <?php if (isset($log) && $log): ?>
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Log Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="40%">Log ID:</th>
                                        <td><?= $log->id ?? '-' ?></td>
                                    </tr>
                                    <tr>
                                        <th>Date & Time:</th>
                                        <td><?= isset($log->created_at) ? date('Y-m-d H:i:s', strtotime($log->created_at)) : '-' ?></td>
                                    </tr>
                                    <tr>
                                        <th>Action Type:</th>
                                        <td><span class="badge badge-danger"><?= $log->action_type ?? '-' ?></span></td>
                                    </tr>
                                    <tr>
                                        <th>Status:</th>
                                        <td>
                                            <?php 
                                            $status = $log->status ?? 'UNKNOWN';
                                            $badgeClass = $status === 'SUCCESS' ? 'badge-success' : ($status === 'FAILED' ? 'badge-danger' : 'badge-secondary');
                                            ?>
                                            <span class="badge <?= $badgeClass ?>"><?= $status ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Sales Order Relation ID:</th>
                                        <td><?= $log->sales_order_relation_id ?? '-' ?></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="40%">User:</th>
                                        <td><?= isset($log->user) ? $log->user->name : '-' ?></td>
                                    </tr>
                                    <tr>
                                        <th>User ID:</th>
                                        <td><?= $log->user_id ?? '-' ?></td>
                                    </tr>
                                    <tr>
                                        <th>Branch:</th>
                                        <td><?php 
                                            $branchNames = [1 => 'Nittambuwa', 2 => 'Negombo'];
                                            $branchId = isset($log->branch) ? $log->branch : null;
                                            echo $branchId && isset($branchNames[$branchId]) ? $branchNames[$branchId] : ($branchId ? 'Branch ' . $branchId : '-');
                                        ?></td>
                                    </tr>
                                    <tr>
                                        <th>Branch ID:</th>
                                        <td><?= $log->branch_id ?? '-' ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <h6>Reason:</h6>
                                <div class="alert alert-info">
                                    <?= nl2br(htmlspecialchars($log->reason ?? 'No reason provided')) ?>
                                </div>
                            </div>
                        </div>
                        <?php if (isset($log->action_details) && $log->action_details): ?>
                        <div class="row mt-3">
                            <div class="col-12">
                                <h6>Action Details:</h6>
                                <pre class="bg-light p-3 border rounded"><?= json_encode($log->action_details, JSON_PRETTY_PRINT) ?></pre>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if (isset($log->error_message) && $log->error_message): ?>
                        <div class="row mt-3">
                            <div class="col-12">
                                <h6>Error Message:</h6>
                                <div class="alert alert-danger">
                                    <?= nl2br(htmlspecialchars($log->error_message)) ?>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php else: ?>
                <div class="alert alert-warning">
                    Log not found or you don't have permission to view this log.
                </div>
                <?php endif; ?>
            </div>
        </main>
        <?php include APPPATH . "views/include/footerbar.php"; ?>
    </div>
</div>
<?php include APPPATH . "views/include/footerscripts.php"; ?>
