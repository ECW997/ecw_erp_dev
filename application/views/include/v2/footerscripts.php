
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
<!-- <script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script> -->
<script src="<?php echo base_url() ?>assets/js/scripts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
<script data-search-pseudo-elements defer
src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js"></script>
<script src="<?php echo base_url() ?>assets/bootstrap5-2/js/bootstrap.bundle.js"></script>
<script src="<?php echo base_url() ?>assets/bootstrap5-2/js/bootstrap.bundle.min.js"></script>
<!-- <script src="<?php echo base_url() ?>assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script> -->
<script src="<?php echo base_url() ?>assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/script.js"></script>
<script src="<?php echo base_url() ?>assets/js/jobcard.js"></script>
<script src="<?php echo base_url() ?>assets/js/bootstrap-notify.js"></script>
<script src="<?php echo base_url() ?>assets/js/select2.full.js"></script>
<script src="<?php echo base_url() ?>assets/js/jquery.serializejson.js"></script>
<script src="<?php echo base_url() ?>assets/slick/slick.js"></script>
<script src="<?php echo base_url() ?>assets/js/print.js"></script>
<script src="<?php echo base_url() ?>assets/js/jquery.hotkeys.js"></script>
<script src="<?php echo base_url() ?>assets/js/table2csv.js"></script>
<script src="https://cdn.datatables.net/buttons/2.1.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.print.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>


<script>
$("body").toggleClass("sidenav-toggled");

function success_toastify(actionText) {
    Toastify({
        text: actionText,
        duration: 5000,
        close: true,
        gravity: "top",
        position: "right",
        backgroundColor: "linear-gradient(to right, #28a745, #218838)",
        style: {
            color: "#fff",
            fontSize: "16px",
            borderRadius: "15px",
            padding: "18px 30px",
            boxShadow: "0px 4px 8px rgba(0, 0, 0, 0.2)"
        },
    }).showToast();
}

function success_Update_toastify(actionText) {
    Toastify({
        text: actionText,
        duration: 5000,
        close: true,
        gravity: "top",
        position: "right",
        backgroundColor: "linear-gradient(to right, #f4a100,rgb(216, 139, 7))",
        style: {
            color: "#fff",
            fontSize: "16px",
            borderRadius: "15px",
            padding: "18px 30px",
            boxShadow: "0px 4px 8px rgba(0, 0, 0, 0.2)"
        },
    }).showToast();
}

function error_toastify(actionText) {
    Toastify({
        text: actionText,
        duration: 5000,
        close: true,
        gravity: "top",
        position: "right",
        backgroundColor: "linear-gradient(to right,rgb(189, 44, 44),rgb(161, 39, 39))",
        style: {
            color: "#fff",
            fontSize: "16px",
            borderRadius: "15px",
            padding: "18px 30px",
            boxShadow: "0px 4px 8px rgba(0, 0, 0, 0.2)"
        },
    }).showToast();
}

var response_code = $('#action_response_code').val();
var actionText = $('#actiontext').val();

if (actionText) {
    if (response_code == '201') {
        success_toastify(actionText);
    } else if (response_code == '200') {
        success_Update_toastify(actionText);
    } else {
        error_toastify(actionText);
        if (response_code == '401') {
            setTimeout(function() {
                window.location.href = "<?php echo base_url(); ?>Welcome/Logout";
            }, 2000);
        }
    }
}

$(document).ready(function() {
    const $scrollContainer = $('.scrollbar');

    $scrollContainer.on('mousedown', function(e) {
        let startX = e.pageX - $scrollContainer.offset().left;
        let scrollLeft = $scrollContainer.scrollLeft();

        $scrollContainer.on('mousemove', function(e) {
            const x = e.pageX - $scrollContainer.offset().left;
            const walk = (x - startX) * 2;
            $scrollContainer.scrollLeft(scrollLeft - walk);
        });

        $(document).on('mouseup', function() {
            $scrollContainer.off('mousemove');
            $(document).off('mouseup');
        });
    });
});

function falseResponse(obj) {
    error_toastify(obj.message)
    if (obj.code == '401') {
        setTimeout(function() {
            window.location.href = "<?php echo base_url(); ?>Welcome/Logout";
            exit();
        }, 2000);
    }
    return;
}
</script>