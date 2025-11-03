<link href="<?php echo base_url() ?>assets/css/logout.css" rel="stylesheet">
<style>
/* Keyframes for color animation */
@keyframes colorChange {
    0% {
        color: red;
    }

    25% {
        color: blue;
    }

    50% {
        color: orange;
    }

}

/* Add animation to the brand */
.navbar-brand {
    animation: colorChange 10s infinite;
}

.shake {
    animation: shake 0.5s;
    animation-iteration-count: infinite;
}

@keyframes shake {
    0% {
        transform: translate(3px, 0);
    }

    25% {
        transform: translate(-3px, 0);
    }

    50% {
        transform: translate(3px, 0);
    }

    75% {
        transform: translate(-3px, 0);
    }

    100% {
        transform: translate(0, 0);
    }
}

.profile-image-container {
    width: 150px;
    height: 150px;
    margin: 0 auto;
    position: relative;
}

.profile-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
    border: 4px solid #fff;
    box-shadow: 0 4px 20px 12px rgb(0 0 0 / 22%);
}

.badge {
    padding: 8px 16px;
    font-weight: 500;
}

.btn-outline-primary {
    padding: 8px 20px;
}

.department-info {
    color: #6c757d;
}

</style>




<?php
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://www.textit.biz/creditchk/index.php?id=94770103434&pw=6912");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10); // optional: timeout after 10 seconds
$response = curl_exec($ch);
$curlError = curl_error($ch);
curl_close($ch);

$smsBalance = null;
$formattedSMSBalanceResponse = 'Unavailable';
$balanceColor = 'color:gray';

if ($response !== false && is_numeric($response)) {
    $smsBalance = floatval($response);
    $formattedSMSBalanceResponse = number_format($smsBalance, 2, '.', ',');
    $balanceColor = ($smsBalance <= 49) ? 'color:red' : 'color:#06d106';
}
?>


<nav class="topnav navbar navbar-expand-lg shadow navbar-light" style="background-color:#212529" id="sidenavAccordion">
    <a class="navbar-brand d-none d-sm-block" href="#">

        <img src="<?php echo base_url() ?>assets/img/logo-icon.png" class="logo-img" alt=""
            style="width: 60px; height: 60px; align-items: center; margin-left: 60px; margin-top: -10px;">

        <h5 style="align-items: center; margin-left: 50px; color:white; margin-top:-15px"> ECW ERP </h5>
        <!-- <img src="<?php echo base_url('images/santa.png'); ?>" alt="Logo"
            style="height: 35px; margin-left: -9px;"> -->
    </a>
    <button class="btn btn-icon btn-transparent-light order-1 order-lg-0 me-lg-2" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
    </button>

    <?php if (in_array($_SESSION['typename'], ['Cashier', 'Super Administrator'])): ?>
        <?php if (isset($check_cashier_shift['status']) && $check_cashier_shift['status']): ?>
            <?php if ($check_cashier_shift['code'] == 200): ?>
                <span class="ml-3 text-white bg-success p-2 rounded">Cashier Shift Open</span>
                <!-- <button class="btn btn-warning ml-3" id="cashierShiftBtn">Cashier Shift Open</button> -->
            <?php elseif ($check_cashier_shift['code'] == 403): ?>
                <span class="ml-3 text-white bg-warning p-2 rounded">
                    <?= $check_cashier_shift['message']; ?>
                </span>
            <?php endif; ?>
        <?php else: ?>
            <span class="ml-3 text-white bg-danger p-2 rounded">Cashier Shift Closed</span>
            <!-- <button class="btn btn-danger ml-3" id="cashierShiftOpenBtn" data-toggle="modal" data-target="#startShiftModal">Cashier Shift Closed</button> -->
        <?php endif; ?>
    <?php endif; ?>
 
    <ul class="navbar-nav align-items-center ml-auto">
        <li class="mr-5">
        <marquee
                style="font-size: 20px; color: orange; font-weight: bold;  padding: 10px; text-shadow: 2px 2px 4px #000;">
                <!-- 🎉 Happy New Year! 🎆 🎇 2025 🎆 🎇🎉 සුභ නව වසරක් වේවා!  🎆 🎇 🎉 -->
                <!-- 🎉 EDIRISINGHA CUSHION WORKS ( PVT ) LTD. 🎉 -->
                 SOUTH ASIA'S LARGEST INTERIOR MODIFICATION CENTER
            </marquee>
            </li>


        <?php if (in_array($_SESSION['typename'], ['Super Administrator', 'Administrator', 'Coordinator', 'Showroom Coordinator'])) { ?>
        <li id="sms_balance" style="font-weight: 600; margin-right: 2rem; <?php echo $balanceColor; ?>">
            SMS Balance :- Rs <?php echo $formattedSMSBalanceResponse; ?>
        </li>
        <?php } ?>


        <!-- <div id="snow"></div> -->

        <li id="live_date_time" style="font-weight: 600; margin-right: 1rem; color: #00aaff;">
        </li>
        <div class="background background--light">
            <button class="logoutButton logoutButton--dark" id="logoutButton">
                <svg class="doorway" viewBox="0 0 100 100">
                    <path
                        d="M93.4 86.3H58.6c-1.9 0-3.4-1.5-3.4-3.4V17.1c0-1.9 1.5-3.4 3.4-3.4h34.8c1.9 0 3.4 1.5 3.4 3.4v65.8c0 1.9-1.5 3.4-3.4 3.4z" />
                    <path class="bang"
                        d="M40.5 43.7L26.6 31.4l-2.5 6.7zM41.9 50.4l-19.5-4-1.4 6.3zM40 57.4l-17.7 3.9 3.9 5.7z" />
                </svg>
                <svg class="figure" viewBox="0 0 100 100">
                    <circle cx="52.1" cy="32.4" r="6.4" />
                    <path
                        d="M50.7 62.8c-1.2 2.5-3.6 5-7.2 4-3.2-.9-4.9-3.5-4-7.8.7-3.4 3.1-13.8 4.1-15.8 1.7-3.4 1.6-4.6 7-3.7 4.3.7 4.6 2.5 4.3 5.4-.4 3.7-2.8 15.1-4.2 17.9z" />
                    <g class="arm1">
                        <path
                            d="M55.5 56.5l-6-9.5c-1-1.5-.6-3.5.9-4.4 1.5-1 3.7-1.1 4.6.4l6.1 10c1 1.5.3 3.5-1.1 4.4-1.5.9-3.5.5-4.5-.9z" />
                        <path class="wrist1"
                            d="M69.4 59.9L58.1 58c-1.7-.3-2.9-1.9-2.6-3.7.3-1.7 1.9-2.9 3.7-2.6l11.4 1.9c1.7.3 2.9 1.9 2.6 3.7-.4 1.7-2 2.9-3.8 2.6z" />
                    </g>
                    <g class="arm2">
                        <path
                            d="M34.2 43.6L45 40.3c1.7-.6 3.5.3 4 2 .6 1.7-.3 4-2 4.5l-10.8 2.8c-1.7.6-3.5-.3-4-2-.6-1.6.3-3.4 2-4z" />
                        <path class="wrist2"
                            d="M27.1 56.2L32 45.7c.7-1.6 2.6-2.3 4.2-1.6 1.6.7 2.3 2.6 1.6 4.2L33 58.8c-.7 1.6-2.6 2.3-4.2 1.6-1.7-.7-2.4-2.6-1.7-4.2z" />
                    </g>
                    <g class="leg1">
                        <path
                            d="M52.1 73.2s-7-5.7-7.9-6.5c-.9-.9-1.2-3.5-.1-4.9 1.1-1.4 3.8-1.9 5.2-.9l7.9 7c1.4 1.1 1.7 3.5.7 4.9-1.1 1.4-4.4 1.5-5.8.4z" />
                        <path class="calf1"
                            d="M52.6 84.4l-1-12.8c-.1-1.9 1.5-3.6 3.5-3.7 2-.1 3.7 1.4 3.8 3.4l1 12.8c.1 1.9-1.5 3.6-3.5 3.7-2 0-3.7-1.5-3.8-3.4z" />
                    </g>
                    <g class="leg2">
                        <path
                            d="M37.8 72.7s1.3-10.2 1.6-11.4 2.4-2.8 html Copy code 2.6-2.6c1.7.2 3.6 2.3 3.4 4l-1.8 11.1c-.2 1.7-1.7 3.3-3.4 3.1-1.8-.2-4.1-2.4-3.9-4.2z" />
                        <path class="calf2"
                            d="M29.5 82.3l9.6-10.9c1.3-1.4 3.6-1.5 5.1-.1 1.5 1.4.4 4.9-.9 6.3l-8.5 9.6c-1.3 1.4-3.6 1.5-5.1.1-1.4-1.3-1.5-3.5-.2-5z" />
                    </g>
                </svg>
                <svg class="door" viewBox="0 0 100 100">
                    <path
                        d="M93.4 86.3H58.6c-1.9 0-3.4-1.5-3.4-3.4V17.1c0-1.9 1.5-3.4 3.4-3.4h34.8c1.9 0 3.4 1.5 3.4 3.4v65.8c0 1.9-1.5 3.4-3.4 3.4z" />
                    <circle cx="66" cy="50" r="3.7" />
                </svg>
                <span class="button-text"><b>Log Out</b></span>
            </button>
        </div>
        <li class="nav-item dropdown no-caret mr-3 dropdown-user">
            <a class="btn btn-icon btn-transparent-light dropdown-toggle" id="navbarDropdownUserImage"
                href="javascript:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
                <i class="far fa-user"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right border-0 shadow animated--fade-in-up"
                aria-labelledby="navbarDropdownUserImage">
                <h6 class="dropdown-header d-flex align-items-center" onclick="userAcoountDetails();">
                    <img class="dropdown-user-img" src="<?php echo base_url() ?>images/user.jpg" />
                    <div class="dropdown-user-details">
                        <div class="dropdown-user-details-name"><?php echo ucfirst($_SESSION['name']); ?></div>
                        <div class="dropdown-user-details-email"><?php echo $_SESSION['typename']; ?></div>
                    </div>
                </h6>
                <div class="dropdown-divider"></div>


            </div>
        </li>
    </ul>
</nav>

<div class="modal fade" id="useraccountModalCenter" tabindex="-1" role="dialog"
    aria-labelledby="useraccountModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 25px;border: 4px solid #0982e6;">
            <div class="modal-header">
                <h5 class="modal-title" id="useraccountModalLongTitle">User Account Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center pb-5">
                <div class="profile-image-container mb-4" id="userAccount_Profile_pic"></div>

                <div style="background-color: #d0e3ff;padding: 1rem;margin-top: -6rem;border-radius: 15px;">
                    <h2 class="fs-4 mb-1" style="margin-top: 6rem;" id="userAccountInitialNameLabel"></h2>
                    <p class="mb-3" id="userAccountCallingNameLabel"></p>
                    <div class="badge bg-primary mb-3 text-white" id="userAccountJobTitleLabel"></div>
                    <div class="department-info mb-3">
                        <div class="row justify-content-between mt-3">
                            <div class="col-6 text-left">
                                <p class="mb-2"><strong>Address : </strong></p>
                                <p class="mb-2"><strong>DOB : </strong></p>
                                <p class="mb-2"><strong>Gender : </strong></p>
                                <p class="mb-2"><strong>Contact No : </strong></p>
                                <p class="mb-2"><strong>Email : </strong></p>
                                <p class="mb-2"><strong>NIC No : </strong></p>
                            </div>
                            <div class="col-6 text-left">
                                <p class="mb-2"><span id="userAccount_address_Label"></span></p>
                                <p class="mb-2"><span id="userAccount_dob_Label"></span></p>
                                <p class="mb-2"><span id="userAccount_gender_Label"></span></p>
                                <p class="mb-2"><span id="userAccountMobileNoLabel"></span></p>
                                <p class="mb-2"><span id="userAccount_email_Label"></span></p>
                                <p class="mb-2"><span id="userAccount_nic_Label"></span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="contact-section">
                <div class="d-flex justify-content-center gap-2">
                    <button class="btn btn-outline-primary"><i class="bi bi-envelope-fill"></i> Message</button>
                    <button class="btn btn-outline-primary"><i class="bi bi-telephone-fill"></i> Call</button>
                </div>
            </div> -->
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url() ?>assets/js/logout.js"></script>
<script>
function updateDateTime() {
    const now = new Date();
    const formattedDateTime = now.toLocaleDateString() + ' ' + now.toLocaleTimeString();
    document.getElementById('live_date_time').textContent = formattedDateTime;
}

// Update every second
setInterval(updateDateTime, 1000);
// Initialize immediately
updateDateTime();


function userAcoountDetails() {
    var employee_id = '<?php echo $_SESSION['employee_id']; ?>'
    if (employee_id != '') {
        $.ajax({
            url: '<?php echo base_url('User/Getemployeedetails'); ?>',
            type: 'post',
            data: {
                employee_id: employee_id
            },
            success: function(result) {
                var obj = JSON.parse(result);
                $('#userAccountEtfNoLabel').text(obj.emp_etfno);
                $('#userAccountServiceNoLabel').text(obj.service_no);
                $('#userAccountInitialNameLabel').text(obj.emp_name_with_initial);
                $('#userAccountCallingNameLabel').text(obj.calling_name);
                $('#userAccountMobileNoLabel').text(obj.emp_mobile);
                $('#userAccountDepartmentLabel').text(obj.department_name);
                $('#userAccountJobTitleLabel').text(obj.jobtitle);

                $('#userAccount_address_Label').text(obj.emp_address);
                $('#userAccount_nic_Label').text(obj.emp_national_id);
                $('#userAccount_gender_Label').text(obj.emp_gender);
                $('#userAccount_dob_Label').text(obj.emp_birthday);
                $('#userAccount_email_Label').text(obj.emp_email);

                if (obj.profile_pic_path) {
                    $('#userAccount_Profile_pic').html(
                        '<img style="" src="<?php echo base_url() ?>images/Employee_Profile/' + obj
                        .profile_pic_path + '" alt="Employee Profile Picture" class="profile-image">');
                } else {
                    $('#userAccount_Profile_pic').html(
                        '<img style="" src="<?php echo base_url() ?>images/user.jpg" alt="Employee Profile Picture" class="profile-image">'
                    );
                }

                $('#useraccountModalCenter').modal('show');
            }
        });
    } else {
        $('#userAccountNameLabel').val('');
    }

}
</script>

<script>
document.getElementById("logoutButton").addEventListener("click", function() {
    // Delay for 3 seconds before logging out
    setTimeout(function() {
        window.location.href = "<?php echo base_url(); ?>Auth/Logout";
    }, 2400);
});
</script>