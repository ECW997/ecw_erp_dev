<?php 
$controllermenu=$this->router->fetch_class();
$functionmenu=uri_string();
$functionmenu2=$this->router->fetch_method();

$menuprivilegearray=$menuaccess;

if($functionmenu2=='Useraccount'){
    $addcheck=checkprivilege($menuprivilegearray, 1, 1);
    $editcheck=checkprivilege($menuprivilegearray, 1, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 1, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 1, 4);
}
else if($functionmenu2=='Usertype'){
    $addcheck=checkprivilege($menuprivilegearray, 2, 1);
    $editcheck=checkprivilege($menuprivilegearray, 2, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 2, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 2, 4);
}
else if($functionmenu2=='Userprivilege'){
    $addcheck=checkprivilege($menuprivilegearray, 3, 1);
    $editcheck=checkprivilege($menuprivilegearray, 3, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 3, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 3, 4);
}
else if($functionmenu=='MainJobCategory'){
    $addcheck=checkprivilege($menuprivilegearray, 4, 1);
    $editcheck=checkprivilege($menuprivilegearray, 4, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 4, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 4, 4);
    $approve1check=checkprivilege($menuprivilegearray, 4, 5);
    $approve2check=checkprivilege($menuprivilegearray, 4, 6);
    $approve3check=checkprivilege($menuprivilegearray, 4, 7);
    $approve4check=checkprivilege($menuprivilegearray, 4, 8);
    $cancelcheck=checkprivilege($menuprivilegearray, 4, 9);
}
else if($functionmenu=='SubJobCategory'){
    $addcheck=checkprivilege($menuprivilegearray, 5, 1);
    $editcheck=checkprivilege($menuprivilegearray, 5, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 5, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 5, 4);
    $approve1check=checkprivilege($menuprivilegearray, 5, 5);
    $approve2check=checkprivilege($menuprivilegearray, 5, 6);
    $approve3check=checkprivilege($menuprivilegearray, 5, 7);
    $approve4check=checkprivilege($menuprivilegearray, 5, 8);
    $cancelcheck=checkprivilege($menuprivilegearray, 5, 9);
}
else if($functionmenu=='JobOptionGroup'){
    $addcheck=checkprivilege($menuprivilegearray, 6, 1);
    $editcheck=checkprivilege($menuprivilegearray, 6, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 6, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 6, 4);
    $approve1check=checkprivilege($menuprivilegearray, 6, 5);
    $approve2check=checkprivilege($menuprivilegearray, 6, 6);
    $approve3check=checkprivilege($menuprivilegearray, 6, 7);
    $approve4check=checkprivilege($menuprivilegearray, 6, 8);
    $cancelcheck=checkprivilege($menuprivilegearray, 6, 9);
}
else if($functionmenu=='JobOption'){
    $addcheck=checkprivilege($menuprivilegearray, 7, 1);
    $editcheck=checkprivilege($menuprivilegearray, 7, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 7, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 7, 4);
    $approve1check=checkprivilege($menuprivilegearray, 7, 5);
    $approve2check=checkprivilege($menuprivilegearray, 7, 6);
    $approve3check=checkprivilege($menuprivilegearray, 7, 7);
    $approve4check=checkprivilege($menuprivilegearray, 7, 8);
    $cancelcheck=checkprivilege($menuprivilegearray, 7, 9);
}
else if($functionmenu=='JobOptionValue'){
    $addcheck=checkprivilege($menuprivilegearray, 8, 1);
    $editcheck=checkprivilege($menuprivilegearray, 8, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 8, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 8, 4);
    $approve1check=checkprivilege($menuprivilegearray, 8, 5);
    $approve2check=checkprivilege($menuprivilegearray, 8, 6);
    $approve3check=checkprivilege($menuprivilegearray, 8, 7);
    $approve4check=checkprivilege($menuprivilegearray, 8, 8);
    $cancelcheck=checkprivilege($menuprivilegearray, 8, 9);
}
else if($functionmenu=='Price_category'){
    $addcheck=checkprivilege($menuprivilegearray, 9, 1);
    $editcheck=checkprivilege($menuprivilegearray, 9, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 9, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 9, 4);
    $approve1check=checkprivilege($menuprivilegearray, 9, 5);
    $approve2check=checkprivilege($menuprivilegearray, 9, 6);
    $approve3check=checkprivilege($menuprivilegearray, 9, 7);
    $approve4check=checkprivilege($menuprivilegearray, 9, 8);
    $cancelcheck=checkprivilege($menuprivilegearray, 9, 9);
}
else if($functionmenu=='Job_price_details'){
    $addcheck=checkprivilege($menuprivilegearray, 10, 1);
    $editcheck=checkprivilege($menuprivilegearray, 10, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 10, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 10, 4);
    $approve1check=checkprivilege($menuprivilegearray, 10, 5);
    $approve2check=checkprivilege($menuprivilegearray, 10, 6);
    $approve3check=checkprivilege($menuprivilegearray, 10, 7);
    $approve4check=checkprivilege($menuprivilegearray, 10, 8);
    $cancelcheck=checkprivilege($menuprivilegearray, 10, 9);
}
else if($functionmenu=='Customer'){
    $addcheck=checkprivilege($menuprivilegearray, 11, 1);
    $editcheck=checkprivilege($menuprivilegearray, 11, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 11, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 11, 4);
    $approve1check=checkprivilege($menuprivilegearray, 11, 5);
    $approve2check=checkprivilege($menuprivilegearray, 11, 6);
    $approve3check=checkprivilege($menuprivilegearray, 11, 7);
    $approve4check=checkprivilege($menuprivilegearray, 11, 8);
    $cancelcheck=checkprivilege($menuprivilegearray, 11, 9);
}
else if( $functionmenu == 'JobCard' || $functionmenu == 'JobCard/jobCardDetailIndex' || strpos($functionmenu, 'JobCard/jobCardDetailIndex/') === 0){
    $addcheck=checkprivilege($menuprivilegearray, 12, 1);
    $editcheck=checkprivilege($menuprivilegearray, 12, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 12, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 12, 4);
    $approve1check=checkprivilege($menuprivilegearray, 12, 5);
    $approve2check=checkprivilege($menuprivilegearray, 12, 6);
    $approve3check=checkprivilege($menuprivilegearray, 12, 7);
    $approve4check=checkprivilege($menuprivilegearray, 12, 8);
    $cancelcheck=checkprivilege($menuprivilegearray, 12, 9);
}
else if($functionmenu=='Invoice' || $functionmenu == 'Invoice/invoiceDetailIndex' || strpos($functionmenu, 'Invoice/invoiceDetailIndex/') === 0){
    $addcheck=checkprivilege($menuprivilegearray, 13, 1);
    $editcheck=checkprivilege($menuprivilegearray, 13, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 13, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 13, 4);
    $approve1check=checkprivilege($menuprivilegearray, 13, 5);
    $approve2check=checkprivilege($menuprivilegearray, 13, 6);
    $approve3check=checkprivilege($menuprivilegearray, 13, 7);
    $approve4check=checkprivilege($menuprivilegearray, 13, 8);
    $cancelcheck=checkprivilege($menuprivilegearray, 13, 9);
}
else if($functionmenu=='Payment' || $functionmenu == 'Payment/paymentDetailIndex' || strpos($functionmenu, 'Payment/paymentDetailIndex/') === 0){
    $addcheck=checkprivilege($menuprivilegearray, 14, 1);
    $editcheck=checkprivilege($menuprivilegearray, 14, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 14, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 14, 4);
    $approve1check=checkprivilege($menuprivilegearray, 14, 5);
    $approve2check=checkprivilege($menuprivilegearray, 14, 6);
    $approve3check=checkprivilege($menuprivilegearray, 14, 7);
    $approve4check=checkprivilege($menuprivilegearray, 14, 8);
    $cancelcheck=checkprivilege($menuprivilegearray, 14, 9);
}
else if($functionmenu=='Media_library'){
    $addcheck=checkprivilege($menuprivilegearray, 15, 1);
    $editcheck=checkprivilege($menuprivilegearray, 15, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 15, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 15, 4);
    $approve1check=checkprivilege($menuprivilegearray, 15, 5);
    $approve2check=checkprivilege($menuprivilegearray, 15, 6);
    $approve3check=checkprivilege($menuprivilegearray, 15, 7);
    $approve4check=checkprivilege($menuprivilegearray, 15, 8);
    $cancelcheck=checkprivilege($menuprivilegearray, 15, 9);
}
else if($functionmenu=='Map'){
    $addcheck=checkprivilege($menuprivilegearray, 16, 1);
    $editcheck=checkprivilege($menuprivilegearray, 16, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 16, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 16, 4);
    $approve1check=checkprivilege($menuprivilegearray, 16, 5);
    $approve2check=checkprivilege($menuprivilegearray, 16, 6);
    $approve3check=checkprivilege($menuprivilegearray, 16, 7);
    $approve4check=checkprivilege($menuprivilegearray, 16, 8);
    $cancelcheck=checkprivilege($menuprivilegearray, 16, 9);
}
else if($functionmenu=='InvoiceOutstandingReport'){
    $addcheck=checkprivilege($menuprivilegearray, 17, 1);
    $editcheck=checkprivilege($menuprivilegearray, 17, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 17, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 17, 4);
    $approve1check=checkprivilege($menuprivilegearray, 17, 5);
    $approve2check=checkprivilege($menuprivilegearray, 17, 6);
    $approve3check=checkprivilege($menuprivilegearray, 17, 7);
    $approve4check=checkprivilege($menuprivilegearray, 17, 8);
    $cancelcheck=checkprivilege($menuprivilegearray, 17, 9);
}
else if($functionmenu=='SalesOrder' || $functionmenu == 'SalesOrder/salesOrderDetailIndex' || strpos($functionmenu, 'SalesOrder/salesOrderDetailIndex/') === 0){
    $addcheck=checkprivilege($menuprivilegearray, 18, 1);
    $editcheck=checkprivilege($menuprivilegearray, 18, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 18, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 18, 4);
    $approve1check=checkprivilege($menuprivilegearray, 18, 5);
    $approve2check=checkprivilege($menuprivilegearray, 18, 6);
    $approve3check=checkprivilege($menuprivilegearray, 18, 7);
    $approve4check=checkprivilege($menuprivilegearray, 18, 8);
    $cancelcheck=checkprivilege($menuprivilegearray, 18, 9);
}

else if($functionmenu=='AssignEmployeeToJob'){
    $addcheck=checkprivilege($menuprivilegearray, 19, 1);
    $editcheck=checkprivilege($menuprivilegearray, 19, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 19, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 19, 4);
    $approve1check=checkprivilege($menuprivilegearray, 19, 5);
    $approve2check=checkprivilege($menuprivilegearray, 19, 6);
    $approve3check=checkprivilege($menuprivilegearray, 19, 7);
    $approve4check=checkprivilege($menuprivilegearray, 19, 8);
    $cancelcheck=checkprivilege($menuprivilegearray, 19, 9);
}

else if($functionmenu=='Finance'){
    $addcheck=checkprivilege($menuprivilegearray, 15, 1);
    $editcheck=checkprivilege($menuprivilegearray, 15, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 15, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 15, 4);
    $approve1check=checkprivilege($menuprivilegearray, 15, 5);
    $approve2check=checkprivilege($menuprivilegearray, 15, 6);
    $approve3check=checkprivilege($menuprivilegearray, 15, 7);
    $approve4check=checkprivilege($menuprivilegearray, 15, 8);
    $cancelcheck=checkprivilege($menuprivilegearray, 15, 9);
}



function checkprivilege($arraymenu, $menuID, $type){
    foreach($arraymenu as $array){
        if($array->menuid==$menuID){
            if($type==1){
                return $array->add;
            }
            else if($type==2){
                return $array->edit;
            }
            else if($type==3){
                return $array->statuschange;
            }
            else if($type==4){
                return $array->remove;
            }
            else if($type==5){
                return $array->approve1;
            }
            else if($type==6){
                return $array->approve2;
            }
            else if($type==7){
                return $array->approve3;
            }
            else if($type==8){
                return $array->approve4;
            }
            else if($type==9){
                return $array->cancel;
            }
        }
    }
}
?>
<!-- <div id="snow"></div> -->
<textarea class="d-none"
    id="action_response_code"><?php if($this->session->flashdata('res')) {echo $this->session->flashdata('res');} ?></textarea>
<textarea class="d-none"
    id="actiontext"><?php if($this->session->flashdata('msg')) {echo $this->session->flashdata('msg');} ?></textarea>

<nav class="sidenav shadow-right sidenav-light" style="background-color:#212529;color:#fff;">
    <div class="sidenav-menu">
        <div class="nav accordion" id="accordionSidenav">
            <div class="sidenav-menu-heading">Core</div>
            <a class="nav-link p-0 px-3 py-2 text-light" href="<?php echo base_url().'Auth/Dashboard'; ?>">
                <!-- <div class="nav-link-icon"><i class="fas fa-desktop"></i></div> -->
                <div class="nav-link-icon">
                    <lord-icon src="https://cdn.lordicon.com/fowheryq.json" trigger="loop" state="loop-all"
                        colors="primary:#ffffff,secondary:#3080e8,tertiary:#3080e8,quaternary:#3080e8"
                        style="width:25px;height:25px">
                    </lord-icon>
                </div>Dashboard
            </a>

            <?php if(menucheck($menuprivilegearray, 4)==1 || menucheck($menuprivilegearray, 5)==1 || menucheck($menuprivilegearray, 6)==1 || menucheck($menuprivilegearray, 7)==1 || menucheck($menuprivilegearray, 8)==1 || menucheck($menuprivilegearray, 9)==1){ ?>
            <a class="nav-link p-0 px-3 py-2 collapsed text-light" href="javascript:void(0);" data-toggle="collapse"
                data-target="#collapseSales_masterfile" aria-expanded="false" aria-controls="collapseSales_masterfile">
                <div class="nav-link-icon">
                    <!-- <i class="fas fa-user-cog"></i> -->
                    <lord-icon src="https://cdn.lordicon.com/oxgyjdir.json" trigger="loop" state="loop-spin"
                        colors="primary:#000000,secondary:#3080e8" style="width:25px;height:25px">
                    </lord-icon>
                </div>Sales Master Files
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse <?php if($functionmenu=="MainJobCategory" || $functionmenu=="SubJobCategory" || $functionmenu=="JobOptionGroup" || $functionmenu=="JobOption" || $functionmenu=="JobOptionValue" || $functionmenu=="Price_category"){echo 'show';} ?>"
                id="collapseSales_masterfile" data-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                    <?php if(menucheck($menuprivilegearray, 4)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-light" href="<?php echo base_url().'MainJobCategory'; ?>">Main
                        Jobs Category</a>
                    <?php } if(menucheck($menuprivilegearray, 5)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-light" href="<?php echo base_url().'SubJobCategory'; ?>">Sub
                        Jobs Category</a>
                    <?php } if(menucheck($menuprivilegearray, 6)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-light" href="<?php echo base_url().'JobOptionGroup'; ?>">Job
                        Option Group</a>
                    <?php } if(menucheck($menuprivilegearray, 7)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-light" href="<?php echo base_url().'JobOption'; ?>">Job
                        Option</a>
                    <?php } if(menucheck($menuprivilegearray, 8)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-light" href="<?php echo base_url().'JobOptionValue'; ?>">Job
                        Option Value</a>
                    <?php } if(menucheck($menuprivilegearray, 9)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-light" href="<?php echo base_url().'Price_category'; ?>">Price
                        Category Type</a>
                    <?php } ?>
                </nav>
            </div>
            <?php } ?>

            <?php if(menucheck($menuprivilegearray, 10)==1){ ?>
            <a class="nav-link p-0 px-3 py-2 text-light" href="<?php echo base_url().'Job_price_details'; ?>">
                <div class="nav-link-icon">
                    <!-- <i class="fas fa-id-card"></i> -->
                    <lord-icon src="https://cdn.lordicon.com/adeleafr.json" trigger="loop" delay="2000"
                        colors="primary:#000000,secondary:#3080e8,tertiary:#66a1ee" style="width:25px;height:25px">
                    </lord-icon>
                </div>Job Price Detail
            </a>
            <?php }?>

            <?php if(menucheck($menuprivilegearray, 11)==1){ ?>
            <a class="nav-link p-0 px-3 py-2 text-light" href="<?php echo base_url().'Customer'; ?>">
                <!-- <div class="nav-link-icon"><i class="fas fa-user-friends"></i></div> -->
                <div class="nav-link-icon">
                    <lord-icon src="https://cdn.lordicon.com/daeumrty.json" trigger="loop" delay="2000"
                        colors="primary:#ffffff,secondary:#3080e8,tertiary:#3080e8,quaternary:#3080e8"
                        style="width:25px;height:25px">
                    </lord-icon>
                </div>
                Customer
            </a>
            <?php }?>

            <?php if(menucheck($menuprivilegearray, 12)==1){ ?>
            <a class="nav-link p-0 px-3 py-2 text-light" href="<?php echo base_url().'JobCard'; ?>">
                <div class="nav-link-icon">
                    <!-- <i class="fas fa-id-card-alt"></i> -->
                    <lord-icon src="https://cdn.lordicon.com/tbabdzcy.json" trigger="loop" delay="2000"
                        colors="primary:#242424,secondary:#3080e8" style="width:25px;height:25px">
                    </lord-icon>
                </div>Job Card
            </a>
            <?php }?>

            <?php if(menucheck($menuprivilegearray, 19)==1){ ?>
            <a class="nav-link p-0 px-3 py-2 text-light" href="<?php echo base_url().'AssignEmployeeToJob'; ?>">
                <div class="nav-link-icon">
                    <!-- <i class="fas fa-id-card-alt"></i> -->
                    <lord-icon src="https://cdn.lordicon.com/tbabdzcy.json" trigger="loop" delay="2000"
                        colors="primary:#242424,secondary:#3080e8" style="width:25px;height:25px">
                    </lord-icon>
                </div>Assign Employee To Job
            </a>
            <?php }?>

            <?php if(menucheck($menuprivilegearray, 18)==1){ ?>
            <a class="nav-link p-0 px-3 py-2 text-light" href="<?php echo base_url().'SalesOrder'; ?>">
                <div class="nav-link-icon">
                    <lord-icon src="https://cdn.lordicon.com/tbabdzcy.json" trigger="loop" delay="2000"
                        colors="primary:#242424,secondary:#3080e8" style="width:25px;height:25px">
                    </lord-icon>
                </div>Sales Order
            </a>
            <?php }?>

            <?php if(menucheck($menuprivilegearray, 13)==1){ ?>
            <a class="nav-link p-0 px-3 py-2 text-light" href="<?php echo base_url().'Invoice'; ?>">
                <div class="nav-link-icon">
                    <lord-icon src="https://cdn.lordicon.com/jwmqentq.json" trigger="loop" delay="2000"
                        colors="primary:#000000,secondary:#66a1ee,tertiary:#3080e8" style="width:25px;height:25px">
                    </lord-icon>
                    <!-- <i class="fas fa-receipt"></i> -->
                </div>Invoice
            </a>
            <?php }?>

            <?php if(menucheck($menuprivilegearray, 14)==1){ ?>
            <a class="nav-link p-0 px-3 py-2 text-light" href="<?php echo base_url().'Payment'; ?>">
                <div class="nav-link-icon">
                    <lord-icon src="https://cdn.lordicon.com/kkdnopsh.json" trigger="loop" delay="2000"
                        colors="primary:#242424,secondary:#3080e8,tertiary:#ffffff" style="width:25px;height:25px">
                    </lord-icon>
                    <!-- <i class="fas fa-cash-register"></i> -->
                </div>Payments
            </a>
            <?php }?>

            <!-- <?php
                function renderNavLink($menuId, $page, $iconSrc, $iconColors, $check_cashier_shift, $menuprivilegearray) {
                    if (!menucheck($menuprivilegearray, $menuId)) {
                        return;
                    }

                    // $isApproved = isset($check_cashier_shift['status']) && $check_cashier_shift['status'] && $check_cashier_shift['shift']['opening_approved_at'] !== null; 
                    $isApproved = isset($check_cashier_shift['status']) && $check_cashier_shift['status'];

                    if ($isApproved) {
                        $href = base_url() . $page;
                        $extraClass = '';
                        $dataAttr = '';
                    } else {
                        $href = 'javascript:void(0)';
                        $extraClass = ' start-shift-link';
                        $dataAttr = ' data-page="'.$page.'"';
                    }
                    ?>
                    <a class="nav-link p-0 px-3 py-2 text-light<?= $extraClass ?>" href="<?= $href ?>"<?= $dataAttr ?>>
                        <div class="nav-link-icon">
                            <lord-icon src="<?= $iconSrc ?>" trigger="loop" delay="2000"
                                colors="<?= $iconColors ?>" style="width:25px;height:25px">
                            </lord-icon>
                        </div>
                        <?= $page ?>
                    </a>
            <?php 
                } 
                $check_cashier_shift = isset($check_cashier_shift) ? $check_cashier_shift : [];
                $menuprivilegearray = isset($menuprivilegearray) ? $menuprivilegearray : [];

                renderNavLink(13, "Invoice", "https://cdn.lordicon.com/jwmqentq.json", "primary:#000000,secondary:#66a1ee,tertiary:#3080e8", $check_cashier_shift, $menuprivilegearray);
                renderNavLink(14, "Payment", "https://cdn.lordicon.com/kkdnopsh.json", "primary:#242424,secondary:#3080e8,tertiary:#ffffff", $check_cashier_shift, $menuprivilegearray);
            ?> -->

            <?php if(menucheck($menuprivilegearray, 15)==1){ ?>
                <a class="nav-link p-0 px-3 py-2 collapsed text-light" href="javascript:void(0);" 
                data-toggle="collapse" data-target="#collapseCashier" aria-expanded="false" aria-controls="collapseCashier">
                    <div class="nav-link-icon">
                        <lord-icon src="https://cdn.lordicon.com/kkdnopsh.json" trigger="loop" delay="2000"
                            colors="primary:#3080e8,secondary:#000000,tertiary:#ffffff" style="width:25px;height:25px">
                        </lord-icon>
                    </div>
                    Cashier
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>

                <div class="collapse <?php if(in_array($functionmenu, [
                    "CashierShift","CashHandover","CashierSummary","CashierAdjustments",
                    "CashLedger","CashMovements","IOUSettlements"
                ])){echo 'show';} ?>" 
                id="collapseCashier" data-parent="#accordionSidenav">

                    <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                        
                        <?php if(menucheck($menuprivilegearray, 15)==1){ ?>
                        <a class="nav-link p-0 px-3 py-1 text-light"
                            href="<?php echo base_url().'CashierShift'; ?>">
                            Cashier Shift</a>
                        <?php } ?>

                        <?php if(menucheck($menuprivilegearray, 15)==1){ ?>
                        <a class="nav-link p-0 px-3 py-1 text-light"
                            href="<?php echo base_url().'CashHandover'; ?>">
                            Cash Handover</a>
                        <?php } ?>

                        <?php if(menucheck($menuprivilegearray, 15)==1){ ?>
                        <a class="nav-link p-0 px-3 py-1 text-light"
                            href="<?php echo base_url().'CashierSummary'; ?>">
                            Shift Summary</a>
                        <?php } ?>

                        <?php if(menucheck($menuprivilegearray, 15)==1){ ?>
                        <a class="nav-link p-0 px-3 py-1 text-light"
                            href="<?php echo base_url().'CashierAdjustments'; ?>">
                            Adjustments</a>
                        <?php } ?>

                        <?php if(menucheck($menuprivilegearray, 15)==1){ ?>
                        <a class="nav-link p-0 px-3 py-1 text-light"
                            href="<?php echo base_url().'CashLedger'; ?>">
                            Transaction Ledger</a>
                        <?php } ?>

                        <?php if(menucheck($menuprivilegearray, 15)==1){ ?>
                        <a class="nav-link p-0 px-3 py-1 text-light"
                            href="<?php echo base_url().'CashMovements'; ?>">
                            Cash Movements</a>
                        <?php } ?>

                        <?php if(menucheck($menuprivilegearray, 15)==1){ ?>
                        <a class="nav-link p-0 px-3 py-1 text-light"
                            href="<?php echo base_url().'IOUSettlements'; ?>">
                            IOU Settlements</a>
                        <?php } ?>

                    </nav>
                </div>
            <?php } ?>


            <?php if(menucheck($menuprivilegearray, 15)==1){ ?>
            <a class="nav-link p-0 px-3 py-2 text-light" href="<?php echo base_url().'Finance'; ?>">
                <!-- <div class="nav-link-icon"><i class="fas fa-photo-video"></i></div> -->
                <div class="nav-link-icon">
                    <lord-icon src="https://cdn.lordicon.com/kkdnopsh.json" trigger="loop" delay="2000"
                        colors="primary:#242424,secondary:#3080e8,tertiary:#ffffff,quaternary:#ebe6ef,quinary:#ffffff,senary:#242424,septenary:#f24c00"
                        style="width:25px;height:25px">
                    </lord-icon>
                </div>
                Finance
            </a>
            <?php }?>

            <?php if(menucheck($menuprivilegearray, 15)==1){ ?>
            <a class="nav-link p-0 px-3 py-2 text-light" href="<?php echo base_url().'Media_library'; ?>">
                <!-- <div class="nav-link-icon"><i class="fas fa-photo-video"></i></div> -->
                <div class="nav-link-icon">
                    <lord-icon src="https://cdn.lordicon.com/wyupmbaf.json" trigger="loop" delay="2000"
                        colors="primary:#242424,secondary:#3080e8,tertiary:#ffffff,quaternary:#ebe6ef,quinary:#ffffff,senary:#242424,septenary:#f24c00"
                        style="width:25px;height:25px">
                    </lord-icon>
                </div>
                Media Library
            </a>
            <?php }?>

            <?php if(menucheck($menuprivilegearray, 16)==1){ ?>
            <a class="nav-link p-0 px-3 py-2 text-light" href="<?php echo base_url().'Map'; ?>">
                <!-- <div class="nav-link-icon"><i class="fas fa-map-marked-alt"></i></div> -->
                <div class="nav-link-icon">
                    <lord-icon src="https://cdn.lordicon.com/dhmavvpz.json" trigger="loop" delay="2000"
                        colors="primary:#121331,secondary:#3080e8" style="width:25px;height:25px">
                    </lord-icon>
                </div>
                Map
            </a>
            <?php }?>

            <?php if(menucheck($menuprivilegearray, 17)==1){ ?>
            <a class="nav-link p-0 px-3 py-2 collapsed text-light" href="javascript:void(0);" data-toggle="collapse"
                data-target="#collapseReport" aria-expanded="false" aria-controls="collapseReport">
                <!-- <div class="nav-link-icon"><i class="far fa-file-alt"></i></div> -->
                <div class="nav-link-icon">
                    <lord-icon src="https://cdn.lordicon.com/tobsqthh.json" trigger="loop" delay="2000"
                        colors="primary:#3080e8,secondary:#000000,tertiary:#ffffff" style="width:25px;height:25px">
                    </lord-icon>
                </div>
                Reports
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse <?php if($functionmenu=="InvoiceOutstandingReport" | $functionmenu=="Appointment_Report" | $functionmenu=="Cancel_Appointment_Report" | $functionmenu=="Coordinator_wise_inquiry_Report" | $functionmenu=="Followup_report" | $functionmenu=="Inquiry_transfer_report" | $functionmenu=="Job_Done_Inquiry_Report" | $functionmenu=="Inquiry_Source_Report" | $functionmenu=="SalesPerson_wise_callcenter_inquiry_Report" | $functionmenu=="Customer_Inquiry_Summary_Report"){echo 'show';} ?>"
                id="collapseReport" data-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                    <?php if(menucheck($menuprivilegearray, 17)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-light"
                        href="<?php echo base_url().'InvoiceOutstandingReport'; ?>">Customer Invoice Outstanding
                        Report</a>
                    <?php } if(menucheck($menuprivilegearray, 56)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-light"
                        href="<?php echo base_url().'Customer_Inquiry_Summary_Report'; ?>">Customer Inquiry Summary
                        Report</a>
                    <?php } ?>
                </nav>
            </div>
            <?php } ?>


            <?php if(menucheck($menuprivilegearray, 1)==1 || menucheck($menuprivilegearray, 2)==1 || menucheck($menuprivilegearray, 3)==1){ ?>
            <a class="nav-link p-0 px-3 py-2 collapsed text-light" href="javascript:void(0);" data-toggle="collapse"
                data-target="#collapseUser" aria-expanded="false" aria-controls="collapseUser">
                <!-- <div class="nav-link-icon"><i class="fas fa-user"></i></div> -->
                <div class="nav-link-icon">
                    <lord-icon src="https://cdn.lordicon.com/hroklero.json" trigger="loop" delay="2000"
                        state="hover-nodding" colors="primary:#3080e8,secondary:#ffffff" style="width:25px;height:25px">
                    </lord-icon>
                </div>
                User Account
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse <?php if($functionmenu=="Useraccount" || $functionmenu=="Usertype" || $functionmenu=="Userprivilege"){echo 'show';} ?>"
                id="collapseUser" data-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                    <?php if(menucheck($menuprivilegearray, 1)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-light"
                        href="<?php echo base_url().'User/Useraccount'; ?>">User Account</a>
                    <?php } if(menucheck($menuprivilegearray, 2)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-light"
                        href="<?php echo base_url().'User/Usertype'; ?>">Type</a>
                    <?php } if(menucheck($menuprivilegearray, 3)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-light"
                        href="<?php echo base_url().'User/Userprivilege'; ?>">Privilege</a>
                    <?php } ?>
                </nav>
            </div>
            <?php } ?>
        </div>
    </div>
    <div class="sidenav-footer">
        <div class="sidenav-footer-content">
            <div class="sidenav-footer-subtitle">Logged in as:</div>
            <div class="sidenav-footer-title"><?php echo ucfirst($_SESSION['name']); ?></div>
        </div>
    </div>
</nav>