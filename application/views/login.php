<?php include "include/header.php"; ?>
<?php
 $companyaql="SELECT * FROM `tbl_company`";
 $companylist = $this->db->query($companyaql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>CodePen - Animated SVG Avatar v2</title>
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
    <link href="<?php echo base_url() ?>assets/css/login.css" rel="stylesheet">

</head>

<body>

    <video id="intro-video" autoplay muted playsinline>
        <source src="<?php echo base_url() ?>images/intro.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <textarea class="d-none"
        id="logintext"><?php if($this->session->flashdata('loginmsg')) {echo $this->session->flashdata('loginmsg');} ?></textarea>
    <div id="particles-js" style="position:fixed; width:100%; height:100%; z-index:0;"></div>
    <div id="login-page"
        style="background-image: url('images/login_bg1.jpg'); background-size: cover; background-repeat: no-repeat; background-position: center center;">
        <img class="login_logo" src="<?php echo base_url() ?>images/ecw_logo3.png" />
        <!-- partial:index.partial.html -->
        <form id="loginform" action="<?php echo base_url() ?>Auth/LoginUser" method="post">
            <div class="svgContainer">
                <div>
                    <svg class="mySVG" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                        viewBox="0 0 200 200">
                        <defs>
                            <circle id="armMaskPath" cx="100" cy="100" r="100" />
                        </defs>
                        <clipPath id="armMask">
                            <use xlink:href="#armMaskPath" overflow="visible" />
                        </clipPath>
                        <circle cx="100" cy="100" r="100" fill="#a9ddf3" />
                        <g class="body">
                            <path class="bodyBGchanged" style="display: none;" fill="#FFFFFF"
                                d="M200,122h-35h-14.9V72c0-27.6-22.4-50-50-50s-50,22.4-50,50v50H35.8H0l0,91h200L200,122z" />
                            <path class="bodyBGnormal" stroke="#3A5E77" stroke-width="2.5" stroke-linecap="round"
                                stroke-linejoinn="round" fill="#FFFFFF"
                                d="M200,158.5c0-20.2-14.8-36.5-35-36.5h-14.9V72.8c0-27.4-21.7-50.4-49.1-50.8c-28-0.5-50.9,22.1-50.9,50v50 H35.8C16,122,0,138,0,157.8L0,213h200L200,158.5z" />
                            <path fill="#DDF1FA"
                                d="M100,156.4c-22.9,0-43,11.1-54.1,27.7c15.6,10,34.2,15.9,54.1,15.9s38.5-5.8,54.1-15.9 C143,167.5,122.9,156.4,100,156.4z" />
                        </g>
                        <g class="earL">
                            <g class="outerEar" fill="#ddf1fa" stroke="#3a5e77" stroke-width="2.5">
                                <circle cx="47" cy="83" r="11.5" />
                                <path d="M46.3 78.9c-2.3 0-4.1 1.9-4.1 4.1 0 2.3 1.9 4.1 4.1 4.1" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </g>
                            <g class="earHair">
                                <rect x="51" y="64" fill="#FFFFFF" width="15" height="35" />
                                <path
                                    d="M53.4 62.8C48.5 67.4 45 72.2 42.8 77c3.4-.1 6.8-.1 10.1.1-4 3.7-6.8 7.6-8.2 11.6 2.1 0 4.2 0 6.3.2-2.6 4.1-3.8 8.3-3.7 12.5 1.2-.7 3.4-1.4 5.2-1.9"
                                    fill="#fff" stroke="#3a5e77" stroke-width="2.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </g>
                        </g>
                        <g class="earR">
                            <g class="outerEar">
                                <circle fill="#DDF1FA" stroke="#3A5E77" stroke-width="2.5" cx="153" cy="83" r="11.5" />
                                <path fill="#DDF1FA" stroke="#3A5E77" stroke-width="2.5" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M153.7,78.9 c2.3,0,4.1,1.9,4.1,4.1c0,2.3-1.9,4.1-4.1,4.1" />
                            </g>
                            <g class="earHair">
                                <rect x="134" y="64" fill="#FFFFFF" width="15" height="35" />
                                <path fill="#FFFFFF" stroke="#3A5E77" stroke-width="2.5" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M146.6,62.8 c4.9,4.6,8.4,9.4,10.6,14.2c-3.4-0.1-6.8-0.1-10.1,0.1c4,3.7,6.8,7.6,8.2,11.6c-2.1,0-4.2,0-6.3,0.2c2.6,4.1,3.8,8.3,3.7,12.5 c-1.2-0.7-3.4-1.4-5.2-1.9" />
                            </g>
                        </g>
                        <path class="chin"
                            d="M84.1 121.6c2.7 2.9 6.1 5.4 9.8 7.5l.9-4.5c2.9 2.5 6.3 4.8 10.2 6.5 0-1.9-.1-3.9-.2-5.8 3 1.2 6.2 2 9.7 2.5-.3-2.1-.7-4.1-1.2-6.1"
                            fill="none" stroke="#3a5e77" stroke-width="2.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path class="face" fill="#DDF1FA"
                            d="M134.5,46v35.5c0,21.815-15.446,39.5-34.5,39.5s-34.5-17.685-34.5-39.5V46" />
                        <path class="hair" fill="#FFFFFF" stroke="#3A5E77" stroke-width="2.5" stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M81.457,27.929 c1.755-4.084,5.51-8.262,11.253-11.77c0.979,2.565,1.883,5.14,2.712,7.723c3.162-4.265,8.626-8.27,16.272-11.235 c-0.737,3.293-1.588,6.573-2.554,9.837c4.857-2.116,11.049-3.64,18.428-4.156c-2.403,3.23-5.021,6.391-7.852,9.474" />
                        <g class="eyebrow">
                            <path fill="#FFFFFF"
                                d="M138.142,55.064c-4.93,1.259-9.874,2.118-14.787,2.599c-0.336,3.341-0.776,6.689-1.322,10.037 c-4.569-1.465-8.909-3.222-12.996-5.226c-0.98,3.075-2.07,6.137-3.267,9.179c-5.514-3.067-10.559-6.545-15.097-10.329 c-1.806,2.889-3.745,5.73-5.816,8.515c-7.916-4.124-15.053-9.114-21.296-14.738l1.107-11.768h73.475V55.064z" />
                            <path fill="#FFFFFF" stroke="#3A5E77" stroke-width="2.5" stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M63.56,55.102 c6.243,5.624,13.38,10.614,21.296,14.738c2.071-2.785,4.01-5.626,5.816-8.515c4.537,3.785,9.583,7.263,15.097,10.329 c1.197-3.043,2.287-6.104,3.267-9.179c4.087,2.004,8.427,3.761,12.996,5.226c0.545-3.348,0.986-6.696,1.322-10.037 c4.913-0.481,9.857-1.34,14.787-2.599" />
                        </g>
                        <g class="eyeL">
                            <circle cx="85.5" cy="78.5" r="3.5" fill="#3a5e77" />
                            <circle cx="84" cy="76" r="1" fill="#fff" />
                        </g>
                        <g class="eyeR">
                            <circle cx="114.5" cy="78.5" r="3.5" fill="#3a5e77" />
                            <circle cx="113" cy="76" r="1" fill="#fff" />
                        </g>
                        <g class="mouth">
                            <path class="mouthBG" fill="#617E92"
                                d="M100.2,101c-0.4,0-1.4,0-1.8,0c-2.7-0.3-5.3-1.1-8-2.5c-0.7-0.3-0.9-1.2-0.6-1.8 c0.2-0.5,0.7-0.7,1.2-0.7c0.2,0,0.5,0.1,0.6,0.2c3,1.5,5.8,2.3,8.6,2.3s5.7-0.7,8.6-2.3c0.2-0.1,0.4-0.2,0.6-0.2 c0.5,0,1,0.3,1.2,0.7c0.4,0.7,0.1,1.5-0.6,1.9c-2.6,1.4-5.3,2.2-7.9,2.5C101.7,101,100.5,101,100.2,101z" />
                            <path style="display: none;" class="mouthSmallBG" fill="#617E92"
                                d="M100.2,101c-0.4,0-1.4,0-1.8,0c-2.7-0.3-5.3-1.1-8-2.5c-0.7-0.3-0.9-1.2-0.6-1.8 c0.2-0.5,0.7-0.7,1.2-0.7c0.2,0,0.5,0.1,0.6,0.2c3,1.5,5.8,2.3,8.6,2.3s5.7-0.7,8.6-2.3c0.2-0.1,0.4-0.2,0.6-0.2 c0.5,0,1,0.3,1.2,0.7c0.4,0.7,0.1,1.5-0.6,1.9c-2.6,1.4-5.3,2.2-7.9,2.5C101.7,101,100.5,101,100.2,101z" />
                            <path style="display: none;" class="mouthMediumBG"
                                d="M95,104.2c-4.5,0-8.2-3.7-8.2-8.2v-2c0-1.2,1-2.2,2.2-2.2h22c1.2,0,2.2,1,2.2,2.2v2 c0,4.5-3.7,8.2-8.2,8.2H95z" />
                            <path style="display: none;" class="mouthLargeBG"
                                d="M100 110.2c-9 0-16.2-7.3-16.2-16.2 0-2.3 1.9-4.2 4.2-4.2h24c2.3 0 4.2 1.9 4.2 4.2 0 9-7.2 16.2-16.2 16.2z"
                                fill="#617e92" stroke="#3a5e77" stroke-linejoin="round" stroke-width="2.5" />
                            <defs>
                                <path id="mouthMaskPath"
                                    d="M100.2,101c-0.4,0-1.4,0-1.8,0c-2.7-0.3-5.3-1.1-8-2.5c-0.7-0.3-0.9-1.2-0.6-1.8 c0.2-0.5,0.7-0.7,1.2-0.7c0.2,0,0.5,0.1,0.6,0.2c3,1.5,5.8,2.3,8.6,2.3s5.7-0.7,8.6-2.3c0.2-0.1,0.4-0.2,0.6-0.2 c0.5,0,1,0.3,1.2,0.7c0.4,0.7,0.1,1.5-0.6,1.9c-2.6,1.4-5.3,2.2-7.9,2.5C101.7,101,100.5,101,100.2,101z" />
                            </defs>
                            <clipPath id="mouthMask">
                                <use xlink:href="#mouthMaskPath" overflow="visible" />
                            </clipPath>
                            <g clip-path="url(#mouthMask)">
                                <g class="tongue">
                                    <circle cx="100" cy="107" r="8" fill="#cc4a6c" />
                                    <ellipse class="tongueHighlight" cx="100" cy="100.5" rx="3" ry="1.5" opacity=".1"
                                        fill="#fff" />
                                </g>
                            </g>
                            <path clip-path="url(#mouthMask)" class="tooth" style="fill:#FFFFFF;"
                                d="M106,97h-4c-1.1,0-2-0.9-2-2v-2h8v2C108,96.1,107.1,97,106,97z" />
                            <path class="mouthOutline" fill="none" stroke="#3A5E77" stroke-width="2.5"
                                stroke-linejoin="round"
                                d="M100.2,101c-0.4,0-1.4,0-1.8,0c-2.7-0.3-5.3-1.1-8-2.5c-0.7-0.3-0.9-1.2-0.6-1.8 c0.2-0.5,0.7-0.7,1.2-0.7c0.2,0,0.5,0.1,0.6,0.2c3,1.5,5.8,2.3,8.6,2.3s5.7-0.7,8.6-2.3c0.2-0.1,0.4-0.2,0.6-0.2 c0.5,0,1,0.3,1.2,0.7c0.4,0.7,0.1,1.5-0.6,1.9c-2.6,1.4-5.3,2.2-7.9,2.5C101.7,101,100.5,101,100.2,101z" />
                        </g>
                        <path class="nose"
                            d="M97.7 79.9h4.7c1.9 0 3 2.2 1.9 3.7l-2.3 3.3c-.9 1.3-2.9 1.3-3.8 0l-2.3-3.3c-1.3-1.6-.2-3.7 1.8-3.7z"
                            fill="#3a5e77" />
                        <g class="arms" clip-path="url(#armMask)">
                            <g class="armL" style="visibility: hidden;">
                                <polygon fill="#DDF1FA" stroke="#3A5E77" stroke-width="2.5" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-miterlimit="10"
                                    points="121.3,98.4 111,59.7 149.8,49.3 169.8,85.4" />
                                <path fill="#DDF1FA" stroke="#3A5E77" stroke-width="2.5" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-miterlimit="10"
                                    d="M134.4,53.5l19.3-5.2c2.7-0.7,5.4,0.9,6.1,3.5v0c0.7,2.7-0.9,5.4-3.5,6.1l-10.3,2.8" />
                                <path fill="#DDF1FA" stroke="#3A5E77" stroke-width="2.5" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-miterlimit="10"
                                    d="M150.9,59.4l26-7c2.7-0.7,5.4,0.9,6.1,3.5v0c0.7,2.7-0.9,5.4-3.5,6.1l-21.3,5.7" />

                                <g class="twoFingers">
                                    <path fill="#DDF1FA" stroke="#3A5E77" stroke-width="2.5" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-miterlimit="10"
                                        d="M158.3,67.8l23.1-6.2c2.7-0.7,5.4,0.9,6.1,3.5v0c0.7,2.7-0.9,5.4-3.5,6.1l-23.1,6.2" />
                                    <path fill="#A9DDF3"
                                        d="M180.1,65l2.2-0.6c1.1-0.3,2.2,0.3,2.4,1.4v0c0.3,1.1-0.3,2.2-1.4,2.4l-2.2,0.6L180.1,65z" />
                                    <path fill="#DDF1FA" stroke="#3A5E77" stroke-width="2.5" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-miterlimit="10"
                                        d="M160.8,77.5l19.4-5.2c2.7-0.7,5.4,0.9,6.1,3.5v0c0.7,2.7-0.9,5.4-3.5,6.1l-18.3,4.9" />
                                    <path fill="#A9DDF3"
                                        d="M178.8,75.7l2.2-0.6c1.1-0.3,2.2,0.3,2.4,1.4v0c0.3,1.1-0.3,2.2-1.4,2.4l-2.2,0.6L178.8,75.7z" />
                                </g>
                                <path fill="#A9DDF3"
                                    d="M175.5,55.9l2.2-0.6c1.1-0.3,2.2,0.3,2.4,1.4v0c0.3,1.1-0.3,2.2-1.4,2.4l-2.2,0.6L175.5,55.9z" />
                                <path fill="#A9DDF3"
                                    d="M152.1,50.4l2.2-0.6c1.1-0.3,2.2,0.3,2.4,1.4v0c0.3,1.1-0.3,2.2-1.4,2.4l-2.2,0.6L152.1,50.4z" />
                                <path fill="#FFFFFF" stroke="#3A5E77" stroke-width="2.5" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M123.5,97.8 c-41.4,14.9-84.1,30.7-108.2,35.5L1.2,81c33.5-9.9,71.9-16.5,111.9-21.8" />
                                <path fill="#FFFFFF" stroke="#3A5E77" stroke-width="2.5" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M108.5,60.4 c7.7-5.3,14.3-8.4,22.8-13.2c-2.4,5.3-4.7,10.3-6.7,15.1c4.3,0.3,8.4,0.7,12.3,1.3c-4.2,5-8.1,9.6-11.5,13.9 c3.1,1.1,6,2.4,8.7,3.8c-1.4,2.9-2.7,5.8-3.9,8.5c2.5,3.5,4.6,7.2,6.3,11c-4.9-0.8-9-0.7-16.2-2.7" />
                                <path fill="#FFFFFF" stroke="#3A5E77" stroke-width="2.5" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M94.5,103.8 c-0.6,4-3.8,8.9-9.4,14.7c-2.6-1.8-5-3.7-7.2-5.7c-2.5,4.1-6.6,8.8-12.2,14c-1.9-2.2-3.4-4.5-4.5-6.9c-4.4,3.3-9.5,6.9-15.4,10.8 c-0.2-3.4,0.1-7.1,1.1-10.9" />
                                <path fill="#FFFFFF" stroke="#3A5E77" stroke-width="2.5" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M97.5,63.9 c-1.7-2.4-5.9-4.1-12.4-5.2c-0.9,2.2-1.8,4.3-2.5,6.5c-3.8-1.8-9.4-3.1-17-3.8c0.5,2.3,1.2,4.5,1.9,6.8c-5-0.6-11.2-0.9-18.4-1 c2,2.9,0.9,3.5,3.9,6.2" />
                            </g>
                            <g class="armR" style="visibility: hidden;">
                                <path fill="#ddf1fa" stroke="#3a5e77" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-miterlimit="10" stroke-width="2.5"
                                    d="M265.4 97.3l10.4-38.6-38.9-10.5-20 36.1z" />
                                <path fill="#ddf1fa" stroke="#3a5e77" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-miterlimit="10" stroke-width="2.5"
                                    d="M252.4 52.4L233 47.2c-2.7-.7-5.4.9-6.1 3.5-.7 2.7.9 5.4 3.5 6.1l10.3 2.8M226 76.4l-19.4-5.2c-2.7-.7-5.4.9-6.1 3.5-.7 2.7.9 5.4 3.5 6.1l18.3 4.9M228.4 66.7l-23.1-6.2c-2.7-.7-5.4.9-6.1 3.5-.7 2.7.9 5.4 3.5 6.1l23.1 6.2M235.8 58.3l-26-7c-2.7-.7-5.4.9-6.1 3.5-.7 2.7.9 5.4 3.5 6.1l21.3 5.7" />
                                <path fill="#a9ddf3"
                                    d="M207.9 74.7l-2.2-.6c-1.1-.3-2.2.3-2.4 1.4-.3 1.1.3 2.2 1.4 2.4l2.2.6 1-3.8zM206.7 64l-2.2-.6c-1.1-.3-2.2.3-2.4 1.4-.3 1.1.3 2.2 1.4 2.4l2.2.6 1-3.8zM211.2 54.8l-2.2-.6c-1.1-.3-2.2.3-2.4 1.4-.3 1.1.3 2.2 1.4 2.4l2.2.6 1-3.8zM234.6 49.4l-2.2-.6c-1.1-.3-2.2.3-2.4 1.4-.3 1.1.3 2.2 1.4 2.4l2.2.6 1-3.8z" />
                                <path fill="#fff" stroke="#3a5e77" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2.5"
                                    d="M263.3 96.7c41.4 14.9 84.1 30.7 108.2 35.5l14-52.3C352 70 313.6 63.5 273.6 58.1" />
                                <path fill="#fff" stroke="#3a5e77" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2.5"
                                    d="M278.2 59.3l-18.6-10 2.5 11.9-10.7 6.5 9.9 8.7-13.9 6.4 9.1 5.9-13.2 9.2 23.1-.9M284.5 100.1c-.4 4 1.8 8.9 6.7 14.8 3.5-1.8 6.7-3.6 9.7-5.5 1.8 4.2 5.1 8.9 10.1 14.1 2.7-2.1 5.1-4.4 7.1-6.8 4.1 3.4 9 7 14.7 11 1.2-3.4 1.8-7 1.7-10.9M314 66.7s5.4-5.7 12.6-7.4c1.7 2.9 3.3 5.7 4.9 8.6 3.8-2.5 9.8-4.4 18.2-5.7.1 3.1.1 6.1 0 9.2 5.5-1 12.5-1.6 20.8-1.9-1.4 3.9-2.5 8.4-2.5 8.4" />
                            </g>
                        </g>
                    </svg>
                </div>
            </div>

            <div class="inputGroup inputGroup1">
                <label for="loginEmail" id="loginEmailLabel">User Name</label>
                <input type="email" id="username" name="username" maxlength="254" />
            </div>
            <div class="inputGroup inputGroup2">
                <label for="loginPassword" id="loginPasswordLabel">Password</label>
                <input type="password" id="password" name="password" />
                <label id="showPasswordToggle" for="showPasswordCheck">Show
                    <input id="showPasswordCheck" type="checkbox" />
                    <div class="indicator"></div>
                </label>
            </div>
            <div class="inputGroup inputGroup1">
                <label>Company*</label>
                <select class="" name="company_id" id="company_id" required>
                    <option value="">Select</option>
                    <?php foreach($companylist->result() as $rowcompanylist){ ?>
                    <option value="<?php echo $rowcompanylist->idtbl_company ?>">
                        <?php echo $rowcompanylist->company ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="inputGroup inputGroup1">
                <label>Company Branch*</label>
                <select class="" name="branch_id" id="branch_id" required>
                    <option value="">Select</option>

                </select>
            </div>
            <input type="hidden" name="company_text" id="company_text">
            <input type="hidden" name="branch_text" id="branch_text">
            <div class="inputGroup inputGroup3">
                <button id="login">Log in</button>
            </div>
            <div class="col-md-12 small text-center">Forgot your password? <a href="#"></a></div>
            <div class="help-text">
                    <p>Need help? Contact your system administrator</p>
                </div>
        </form>
        
    </div>
    




    <!-- partial -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
    $(document).ready(function() {
        sessionStorage.clear();

        $('#company_id').change(function() {
            var company_id = $(this).val();
            if (company_id != '') {
                $.ajax({
                    url: '<?php echo base_url('Company/Getcompanybranch'); ?>',
                    type: 'post',
                    data: {
                        company_id: company_id
                    },
                    dataType: 'json',
                    success: function(response) {
                        var len = response.length;
                        $('#branch_id').empty();
                        $('#branch_id').append("<option value=''>Select</option>");
                        for (var i = 0; i < len; i++) {
                            var id = response[i]['idtbl_company_branch'];
                            var name = response[i]['branch'];
                            $('#branch_id').append("<option value='" + id + "'>" + name +
                                "</option>");
                        }
                    }
                });
            } else {
                $('#branch_id').empty();
                $('#branch_id').append("<option value=''>Select</option>");
            }
        });


        $('#branch_id').change(function() {
            var companyname = $("#company_id option:selected").text().trim();;
            var branchname = $("#branch_id option:selected").text().trim();;

            $('#company_text').val(companyname);
            $('#branch_text').val(branchname);
        })
    });

    const video = document.getElementById('intro-video');
    const loginPage = document.getElementById('login-page');
    const loginForm = document.getElementById('loginform');
    const particlesJsDiv = document.getElementById('particles-js');

    // Listen for the video to end
    video.addEventListener('ended', () => {
        video.style.display = 'none';
        loginPage.style.display = 'flex';
        loginForm.style.display = 'block';
        particlesJsDiv.style.display = 'block';

        // Initialize particles.js after showing the div
        particlesJS("particles-js", {
            particles: {
                number: {
                    value: 80,
                    density: {
                        enable: true,
                        value_area: 800
                    }
                },
                color: {
                    value: "#ffffff"
                },
                shape: {
                    type: "circle",
                    stroke: {
                        width: 0,
                        color: "#000000"
                    },
                    polygon: {
                        nb_sides: 5
                    },
                    image: {
                        src: "img/github.svg",
                        width: 100,
                        height: 100
                    }
                },
                opacity: {
                    value: 0.5,
                    random: false,
                    anim: {
                        enable: false,
                        speed: 1,
                        opacity_min: 0.1,
                        sync: false
                    }
                },
                size: {
                    value: 5,
                    random: true,
                    anim: {
                        enable: false,
                        speed: 40,
                        size_min: 0.1,
                        sync: false
                    }
                },
                line_linked: {
                    enable: true,
                    distance: 150,
                    color: "#ffffff",
                    opacity: 0.4,
                    width: 1
                },
                move: {
                    enable: true,
                    speed: 8,
                    direction: "none",
                    random: true,
                    straight: false,
                    out_mode: "out",
                    bounce: true,
                    attract: {
                        enable: false,
                        rotateX: 600,
                        rotateY: 1200
                    }
                }
            },
            interactivity: {
                detect_on: "canvas",
                events: {
                    onhover: {
                        enable: true,
                        mode: "repulse"
                    },
                    onclick: {
                        enable: true,
                        mode: "push"
                    },
                    resize: true
                },
                modes: {
                    grab: {
                        distance: 400,
                        line_linked: {
                            opacity: 1
                        }
                    },
                    bubble: {
                        distance: 400,
                        size: 40,
                        duration: 2,
                        opacity: 8,
                        speed: 3
                    },
                    repulse: {
                        distance: 200,
                        duration: 0.4
                    },
                    push: {
                        particles_nb: 4
                    },
                    remove: {
                        particles_nb: 2
                    }
                }
            },
            retina_detect: true
        });


    });

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

    var actionText = $('#logintext').val();

    if (actionText) {
        error_toastify(actionText);
    }
    </script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/gsap/1.20.3/TweenMax.min.js'></script>
    <script src="<?php echo base_url() ?>assets/js/MorphSVGPlugin.js"></script>
    <script src="<?php echo base_url() ?>assets/js/login.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
    <!-- <script>
    document.addEventListener("DOMContentLoaded", function() {
        particlesJS("particles-js", {
            particles: {
                number: { value: 80, density: { enable: true, value_area: 800 } },
                color: { value: "#ffffff" },
                shape: {
                    type: "circle",
                    stroke: { width: 0, color: "#000000" },
                    polygon: { nb_sides: 5 },
                    image: { src: "img/github.svg", width: 100, height: 100 }
                },
                opacity: { value: 0.5, random: false, anim: { enable: false, speed: 1, opacity_min: 0.1, sync: false } },
                size: { value: 5, random: true, anim: { enable: false, speed: 40, size_min: 0.1, sync: false } },
                line_linked: { enable: true, distance: 150, color: "#ffffff", opacity: 0.4, width: 1 },
                move: { enable: true, speed: 8, direction: "none", random: true, straight: false, out_mode: "out", bounce: true, attract: { enable: false, rotateX: 600, rotateY: 1200 } }
            },
            interactivity: {
                detect_on: "canvas",
                events: {
                    onhover: { enable: true, mode: "repulse" },
                    onclick: { enable: true, mode: "push" },
                    resize: true
                },
                modes: {
                    grab: { distance: 400, line_linked: { opacity: 1 } },
                    bubble: { distance: 400, size: 40, duration: 2, opacity: 8, speed: 3 },
                    repulse: { distance: 200, duration: 0.4 },
                    push: { particles_nb: 4 },
                    remove: { particles_nb: 2 }
                }
            },
            retina_detect: true
        });
    });
    </script> -->
<footer class="page-footer">
    <div class="footer-content">
        <p class="footer-text">
            © <?php echo date('Y') ?> ECW Software Solutions. All rights reserved.
        </p>
        <p class="footer-subtext">Powered by ERP Management System v1.0</p>
    </div>
</footer>
</body>

</html>