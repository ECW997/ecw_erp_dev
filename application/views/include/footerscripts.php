<!--<script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>-->
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/scripts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
<!-- <script src="<?php echo base_url() ?>assets/demo/chart-area-demo.js"></script> -->
<!--<script src="<?php echo base_url() ?>assets/demo/chart-bar-demo.js"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
<!-- <script src="https://cdn.datatables.net/fixedcolumns/3.3.3/js/dataTables.fixedColumns.min.js"></script> -->
<!--<script src="<?php echo base_url() ?>assets/demo/datatables-demo.js"></script>-->
<script src="<?php echo base_url() ?>assets/js/script.js"></script>
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
// sales person re followup second part
function refreshFollowupStatus() {
    fetch("<?php echo base_url('Alert/get_alert_data'); ?>")
        .then(response => response.json())
        .then(data => {
            if (data.refollowupcount >= 1) {
                $('#alert_bar').removeClass('d-none');
                document.getElementById('followup-count').textContent = data.refollowupcount;
            } else {
                $('#alert_bar').addClass('d-none');
            }

            const inquiryList = document.getElementById('inquiry-list');
            inquiryList.innerHTML = '';
            if (data.inquiry_numbers.length > 0) {
                data.inquiry_numbers.forEach(inquiry => {
                    const div = document.createElement('div');
                    div.className =
                        'dropdown-user-details-name refollow_inquiry_no mb-3 border-bottom border-secondary';
                    div.textContent = inquiry;
                    div.addEventListener('click', function() {
                        inquiryNoSave(this.textContent);
                    });

                    inquiryList.appendChild(div);
                });
            } else {
                inquiryList.innerHTML = '<div class="dropdown-user-details-name">No inquiries found</div>';
            }
        })
        .catch(error => console.error('Error refreshing follow-up status:', error));
}

// sales person today active first inquiry
function refreshTodayActiveFirstFollowupStatus() {
    fetch("<?php echo base_url('Alert/get_today_active_first_alert_data'); ?>")
        .then(response => response.json())
        .then(data => {
            if (data.first_active_followupcount >= 1) {
                $('#today_active_first_alert_bar').removeClass('d-none');
                document.getElementById('today_active_firstfollowup_count').textContent = data
                    .first_active_followupcount;
            } else {
                $('#today_active_first_alert_bar').addClass('d-none');
            }

            const inquiryList = document.getElementById('today_active_first_inquiry-list');
            inquiryList.innerHTML = '';
            if (data.first_active_inquiry_numbers.length > 0) {
                data.first_active_inquiry_numbers.forEach(inquiry => {
                    const div = document.createElement('div');
                    div.className =
                        'dropdown-user-details-name today_active_first_inquiry_no mb-3 border-bottom border-secondary';
                    div.textContent = inquiry;
                    div.addEventListener('click', function() {
                        inquiryNoSave(this.textContent);
                    });

                    inquiryList.appendChild(div);
                });
            } else {
                inquiryList.innerHTML = '<div class="dropdown-user-details-name">No inquiries found</div>';
            }
        })
        .catch(error => console.error('Error refreshing follow-up status:', error));
}

// sales person today active second inquiry
function refreshTodayActiveSecondFollowupStatus() {
    fetch("<?php echo base_url('Alert/get_today_active_second_alert_data'); ?>")
        .then(response => response.json())
        .then(data => {
            if (data.second_active_followupcount >= 1) {
                $('#today_active_alert_bar').removeClass('d-none');
                document.getElementById('today_active_secondfollowup_count').textContent = data
                    .second_active_followupcount;
            } else {
                $('#today_active_alert_bar').addClass('d-none');
            }

            const inquiryList = document.getElementById('today_active_second_inquiry-list');
            inquiryList.innerHTML = '';
            if (data.second_active_inquiry_numbers.length > 0) {
                data.second_active_inquiry_numbers.forEach(inquiry => {
                    const div = document.createElement('div');
                    div.className =
                        'dropdown-user-details-name today_active_second_inquiry_no mb-3 border-bottom border-secondary';
                    div.textContent = inquiry;
                    div.addEventListener('click', function() {
                        inquiryNoSave(this.textContent);
                    });

                    inquiryList.appendChild(div);
                });
            } else {
                inquiryList.innerHTML = '<div class="dropdown-user-details-name">No inquiries found</div>';
            }
        })
        .catch(error => console.error('Error refreshing follow-up status:', error));
}

if ('<?php echo ($_SESSION['typename']); ?>' == 'Sales Person') {
    setInterval(refreshFollowupStatus, 5000);
    setInterval(refreshTodayActiveSecondFollowupStatus, 5000);
    setInterval(refreshTodayActiveFirstFollowupStatus, 5000);
}

function inquiryNoSave(inquiryText) {
    var searchInput = $('.dataTables_filter input');
    searchInput.focus();
    searchInput.val(inquiryText).trigger('input');
    navigator.clipboard.writeText(inquiryText).then(function() {
        // alert("Copied to clipboard: " + inquiryText);
    }).catch(function(error) {
        console.error("Failed to copy text: ", error);
    });
}
</script>


<script>
$(function() {
    $('[data-toggle="tooltip"]').tooltip();
    setTimeout(tablerowhighlight, 1000);
});

<?php if($this->router->fetch_class()=='Cashier' && $this->router->fetch_method()=='Dashboard'){}else{ ?>

function tablerowhighlight() {
    $('table tbody').on('click', 'tr', function() {
        $('table tbody>tr').removeClass('table-warning text-dark');
        $(this).addClass('table-warning text-dark');
    });
}
<?php } ?>

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
    if (response_code == '200' || response_code == '201') {
        success_toastify(actionText);
    } else {
        error_toastify(actionText);
        if (response_code == '401') {
            setTimeout(function() {
                window.location.href = "<?php echo base_url(); ?>Welcome/Logout";
                exit();
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

    if ('<?php echo ($_SESSION['typename']); ?>' == 'Sales Person') {
        refreshFollowupStatus();
        refreshTodayActiveSecondFollowupStatus();
        refreshTodayActiveFirstFollowupStatus();

    }

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