<?php 
include __DIR__ . "/../../../include/header.php";  
include __DIR__ . "/../../../include/topnavbar.php"; 
?>
<div id="layoutSidenav">

    <div id="layoutSidenav_nav">
        <?php include __DIR__ . "/../../../include/menubar.php"; ?>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="page-header page-header-light bg-gray shadow">
                <div class="container-fluid">
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
               <?php 
                    $check = $check_cashier_shift ?? [];
                    if(isset($check['status']) && $check['status'] === true && $check['code'] == 403){
                        include "error_modal.php";
                    } else {
                        if($check['shift']['opening_approved_at'] == 'null'){  //uncheck condition...if want to check using null without qoutation
                            include "open_approve_error_modal.php";
                        }else{
                            include "start_cashier_shift.php";
                        }
                    }
                ?>
            </div>
        </main>
        <?php include __DIR__ . "/../../../include/footerbar.php"; ?>
    </div>
</div>
<?php include __DIR__ . "/../../../include/footerscripts.php"; ?>

<script>
$(document).ready(function(){
    <?php if(isset($check['status']) && $check['status'] === true && $check['code'] == 403): ?>
        $('#cashierErrorModal').modal({
            backdrop: 'static',
            keyboard: false
        });
        $('#cashierErrorModal').modal('show');
    <?php else: ?>
        <?php if($check['shift']['opening_approved_at'] == 'null'): ?>  //uncheck condition...if want to check using null without qoutation
                $('#financeErrorModal').modal({
                    backdrop: 'static',
                    keyboard: false
                });
                $('#financeErrorModal').modal('show');
            <?php else: ?>
                $('#startShiftModal').modal({
                    backdrop: 'static',
                    keyboard: false
                });
                $('#startShiftModal').modal('show');
            <?php endif; ?>
    <?php endif; ?>
});
</script>