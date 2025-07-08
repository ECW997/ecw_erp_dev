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
else if($functionmenu=='Userprivilege'){
    $addcheck=checkprivilege($menuprivilegearray, 3, 1);
    $editcheck=checkprivilege($menuprivilegearray, 3, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 3, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 3, 4);
}
else if($functionmenu=='Company'){
    $addcheck=checkprivilege($menuprivilegearray, 4, 1);
    $editcheck=checkprivilege($menuprivilegearray, 4, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 4, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 4, 4);
}
else if($functionmenu=='Branch'){
    $addcheck=checkprivilege($menuprivilegearray, 5, 1);
    $editcheck=checkprivilege($menuprivilegearray, 5, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 5, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 5, 4);
}
else if($functionmenu=='Vehicle_brand'){
    $addcheck=checkprivilege($menuprivilegearray, 6, 1);
    $editcheck=checkprivilege($menuprivilegearray, 6, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 6, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 6, 4);
}
else if($functionmenu=='Vehicle_model'){
    $addcheck=checkprivilege($menuprivilegearray, 7, 1);
    $editcheck=checkprivilege($menuprivilegearray, 7, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 7, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 7, 4);
}
else if($functionmenu=='Vehicle_series'){
    $addcheck=checkprivilege($menuprivilegearray, 8, 1);
    $editcheck=checkprivilege($menuprivilegearray, 8, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 8, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 8, 4);
}
else if($functionmenu=='Vehicle_generation'){
    $addcheck=checkprivilege($menuprivilegearray, 9, 1);
    $editcheck=checkprivilege($menuprivilegearray, 9, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 9, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 9, 4);
}
else if($functionmenu=='Vehicle_year'){
    $addcheck=checkprivilege($menuprivilegearray, 10, 1);
    $editcheck=checkprivilege($menuprivilegearray, 10, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 10, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 10, 4);
}
else if($functionmenu=='Jobs'){
    $addcheck=checkprivilege($menuprivilegearray, 14, 1);
    $editcheck=checkprivilege($menuprivilegearray, 14, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 14, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 14, 4);
}
else if($functionmenu=='Vehicle_type'){
    $addcheck=checkprivilege($menuprivilegearray, 16, 1);
    $editcheck=checkprivilege($menuprivilegearray, 16, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 16, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 16, 4);
}
else if($functionmenu=='Leather_Type'){
    $addcheck=checkprivilege($menuprivilegearray, 20, 1);
    $editcheck=checkprivilege($menuprivilegearray, 20, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 20, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 20, 4);
}

else if($functionmenu=='Hood_Material'){
    $addcheck=checkprivilege($menuprivilegearray, 21, 1);
    $editcheck=checkprivilege($menuprivilegearray, 21, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 21, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 21, 4);
}

else if($functionmenu=='Carpet'){
    $addcheck=checkprivilege($menuprivilegearray, 22, 1);
    $editcheck=checkprivilege($menuprivilegearray, 22, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 22, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 22, 4);
}

else if($functionmenu=='Stitching_Design'){
    $addcheck=checkprivilege($menuprivilegearray, 23, 1);
    $editcheck=checkprivilege($menuprivilegearray, 23, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 23, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 23, 4);
}

else if($functionmenu=='Seat_Type'){
    $addcheck=checkprivilege($menuprivilegearray, 24, 1);
    $editcheck=checkprivilege($menuprivilegearray, 24, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 24, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 24, 4);
}

else if($functionmenu=='Logo'){
    $addcheck=checkprivilege($menuprivilegearray, 25, 1);
    $editcheck=checkprivilege($menuprivilegearray, 25, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 25, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 25, 4);
}

else if($functionmenu=='Logo_Colour'){
    $addcheck=checkprivilege($menuprivilegearray, 26, 1);
    $editcheck=checkprivilege($menuprivilegearray, 26, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 26, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 26, 4);
}

else if($functionmenu=='Thread_Colour'){
    $addcheck=checkprivilege($menuprivilegearray, 27, 1);
    $editcheck=checkprivilege($menuprivilegearray, 27, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 27, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 27, 4);
}

else if($functionmenu=='Stitch_Style'){
    $addcheck=checkprivilege($menuprivilegearray, 28, 1);
    $editcheck=checkprivilege($menuprivilegearray, 28, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 28, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 28, 4);
}
else if($functionmenu=='Payment_Method'){
    $addcheck=checkprivilege($menuprivilegearray, 29, 1);
    $editcheck=checkprivilege($menuprivilegearray, 29, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 29, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 29, 4);
}
else if($functionmenu=='Job_price_details'){
    $addcheck=checkprivilege($menuprivilegearray, 40, 1);
    $editcheck=checkprivilege($menuprivilegearray, 40, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 40, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 40, 4);
    $approvecheck=checkprivilege($menuprivilegearray, 40, 5);
    $all_followup=checkprivilege($menuprivilegearray, 40, 6);
}
else if($functionmenu=='Price_category'){
    $addcheck=checkprivilege($menuprivilegearray, 42, 1);
    $editcheck=checkprivilege($menuprivilegearray, 42, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 42, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 42, 4);
}
else if($functionmenu=='Department'){
    $addcheck=checkprivilege($menuprivilegearray, 45, 1);
    $editcheck=checkprivilege($menuprivilegearray, 45, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 45, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 45, 4);
}
else if($functionmenu=='Employee'){
    $addcheck=checkprivilege($menuprivilegearray, 46, 1);
    $editcheck=checkprivilege($menuprivilegearray, 46, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 46, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 46, 4);
}
else if($functionmenu=='Jobtitle'){
    $addcheck=checkprivilege($menuprivilegearray, 47, 1);
    $editcheck=checkprivilege($menuprivilegearray, 47, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 47, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 47, 4);
}
else if($functionmenu=='Customer'){
    $addcheck=checkprivilege($menuprivilegearray, 48, 1);
    $editcheck=checkprivilege($menuprivilegearray, 48, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 48, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 48, 4);
}
else if($functionmenu=='MainJobCategory'){
    $addcheck=checkprivilege($menuprivilegearray, 49, 1);
    $editcheck=checkprivilege($menuprivilegearray, 49, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 49, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 49, 4);
}
else if($functionmenu=='SubJobCategory'){
    $addcheck=checkprivilege($menuprivilegearray, 50, 1);
    $editcheck=checkprivilege($menuprivilegearray, 50, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 50, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 50, 4);
}
else if($functionmenu=='Material'){
    $addcheck=checkprivilege($menuprivilegearray, 51, 1);
    $editcheck=checkprivilege($menuprivilegearray, 51, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 51, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 51, 4);
}
else if($functionmenu=='SalesJobsDetails'){
    $addcheck=checkprivilege($menuprivilegearray, 52, 1);
    $editcheck=checkprivilege($menuprivilegearray, 52, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 52, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 52, 4);
}
else if($functionmenu=='JobCard'){
    $addcheck=checkprivilege($menuprivilegearray, 53, 1);
    $editcheck=checkprivilege($menuprivilegearray, 53, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 53, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 53, 4);
}
else if($functionmenu=='AssignEmployeeToJob'){
    $addcheck=checkprivilege($menuprivilegearray, 57, 1);
    $editcheck=checkprivilege($menuprivilegearray, 57, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 57, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 57, 4);
}
else if($functionmenu=='JobCard_information'){
    $addcheck=checkprivilege($menuprivilegearray, 58, 1);
    $editcheck=checkprivilege($menuprivilegearray, 58, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 58, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 58, 4);
}
else if($functionmenu=='AssignEmployeeToJobDashboad'){
    $addcheck=checkprivilege($menuprivilegearray, 59, 1);
    $editcheck=checkprivilege($menuprivilegearray, 59, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 59, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 59, 4);
}
else if($functionmenu=='SupervisorAssignEmployeeToJob'){
    $addcheck=checkprivilege($menuprivilegearray, 61, 1);
    $editcheck=checkprivilege($menuprivilegearray, 61, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 61, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 61, 4);
}
else if($functionmenu=='JobOptionGroup'){
    $addcheck=checkprivilege($menuprivilegearray, 62, 1);
    $editcheck=checkprivilege($menuprivilegearray, 62, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 62, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 62, 4);
}
else if($functionmenu=='JobOption'){
    $addcheck=checkprivilege($menuprivilegearray, 63, 1);
    $editcheck=checkprivilege($menuprivilegearray, 63, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 63, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 63, 4);
}
else if($functionmenu=='JobOptionValue'){
    $addcheck=checkprivilege($menuprivilegearray, 64, 1);
    $editcheck=checkprivilege($menuprivilegearray, 64, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 64, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 64, 4);
}
else if($functionmenu=='Map'){
    $addcheck=checkprivilege($menuprivilegearray, 65, 1);
    $editcheck=checkprivilege($menuprivilegearray, 65, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 65, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 65, 4);
}
else if($functionmenu=='JobOptionValue'){
    $addcheck=checkprivilege($menuprivilegearray, 64, 1);
    $editcheck=checkprivilege($menuprivilegearray, 64, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 64, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 64, 4);
}
else if($functionmenu=='Map'){
    $addcheck=checkprivilege($menuprivilegearray, 65, 1);
    $editcheck=checkprivilege($menuprivilegearray, 65, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 65, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 65, 4);
}
else if($functionmenu=='Media_library'){
    $addcheck=checkprivilege($menuprivilegearray, 66, 1);
    $editcheck=checkprivilege($menuprivilegearray, 66, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 66, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 66, 4);
}
else if($functionmenu=='Invoice'){
    $addcheck=checkprivilege($menuprivilegearray, 67, 1);
    $editcheck=checkprivilege($menuprivilegearray, 67, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 67, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 67, 4);
}
else if($functionmenu=='Payment'){
    $addcheck=checkprivilege($menuprivilegearray, 67, 1);
    $editcheck=checkprivilege($menuprivilegearray, 67, 2);
    $statuscheck=checkprivilege($menuprivilegearray, 67, 3);
    $deletecheck=checkprivilege($menuprivilegearray, 67, 4);
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
                return $array->approve;
            }else if($type==6){
                return $array->all_followup;
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
            <a class="nav-link p-0 px-3 py-2 text-light" href="<?php echo base_url().'Welcome/Dashboard'; ?>">
                <div class="nav-link-icon"><i class="fas fa-desktop"></i></div>
                Dashboard
            </a>

            <?php if(menucheck($menuprivilegearray, 4)==1 | menucheck($menuprivilegearray, 5)==1 | menucheck($menuprivilegearray, 45)==1){ ?>
            <a class="nav-link p-0 px-3 py-2 collapsed text-light" href="javascript:void(0);" data-toggle="collapse"
                data-target="#collapseCompany" aria-expanded="false" aria-controls="collapseCompany">
                <div class="nav-link-icon"><i class="fas fa-city"></i></div>Company Information
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse <?php if($functionmenu=="Company" | $functionmenu=="Branch" | $functionmenu=="Department"){echo 'show';} ?>"
                id="collapseCompany" data-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                    <?php if(menucheck($menuprivilegearray, 4)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-light" href="<?php echo base_url().'Company'; ?>">Company</a>
                    <?php } if(menucheck($menuprivilegearray, 5)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-light" href="<?php echo base_url().'Branch'; ?>">Branch</a>
                    <?php } if(menucheck($menuprivilegearray, 45)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-light"
                        href="<?php echo base_url().'Department'; ?>">Department</a>
                    <?php } ?>
                </nav>
            </div>
            <?php } ?>

            <?php if(menucheck($menuprivilegearray, 6)==1  | menucheck($menuprivilegearray, 8)==1 | menucheck($menuprivilegearray, 9)==1 | menucheck($menuprivilegearray, 10 )==1 | menucheck($menuprivilegearray, 16)==1 | menucheck($menuprivilegearray, 7)==1 ){ ?>
            <a class="nav-link p-0 px-3 py-2 collapsed text-light" href="javascript:void(0);" data-toggle="collapse"
                data-target="#collapseVehicle" aria-expanded="false" aria-controls="collapseVehicle">
                <div class="nav-link-icon"><i class="fas fa-car"></i></div>Vehicle Information
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse <?php if($functionmenu=="Vehicle_brand" | $functionmenu=="Vehicle_series" | $functionmenu=="Vehicle_generation" | $functionmenu=="Vehicle_year" | $functionmenu=="Vehicle_type" | $functionmenu=="Vehicle_model"){echo 'show';} ?>"
                id="collapseVehicle" data-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                    <?php if(menucheck($menuprivilegearray, 6)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-light"
                        href="<?php echo base_url().'Vehicle_brand'; ?>">Vehicle
                        Brand</a>
                    <?php }if(menucheck($menuprivilegearray, 8)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-light"
                        href="<?php echo base_url().'Vehicle_series'; ?>">Vehicle Series</a>
                    <?php }if(menucheck($menuprivilegearray, 9)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-light"
                        href="<?php echo base_url().'Vehicle_generation'; ?>">Vehicle Generation</a>
                    <?php }if(menucheck($menuprivilegearray, 10)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-light" href="<?php echo base_url().'Vehicle_year'; ?>">Vehicle
                        Year</a>
                    <?php }if(menucheck($menuprivilegearray, 16)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-light" href="<?php echo base_url().'Vehicle_type'; ?>">Vehicle
                        Type</a>
                    <?php } if(menucheck($menuprivilegearray, 7)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-light"
                        href="<?php echo base_url().'Vehicle_model'; ?>">Vehicle
                        Model</a>
                    <?php } ?>
                </nav>
            </div>
            <?php } ?>

            <?php if(menucheck($menuprivilegearray, 64)==1 || menucheck($menuprivilegearray, 21)==1 || menucheck($menuprivilegearray, 22)==1 || menucheck($menuprivilegearray, 23)==1 || menucheck($menuprivilegearray, 24 )==1 || menucheck($menuprivilegearray, 25)==1 || menucheck($menuprivilegearray, 26 )==1 || menucheck($menuprivilegearray, 27)==1 || menucheck($menuprivilegearray, 28 || menucheck($menuprivilegearray, 29)==1 || menucheck($menuprivilegearray, 42)==1 || menucheck($menuprivilegearray, 49 )==1 || menucheck($menuprivilegearray, 50 )==1 || menucheck($menuprivilegearray, 51)==1 || menucheck($menuprivilegearray, 52)==1 || menucheck($menuprivilegearray, 62)==1 || menucheck($menuprivilegearray, 63)==1 || menucheck($menuprivilegearray, 64)==1 )==1 ){ ?>
            <a class="nav-link p-0 px-3 py-2 collapsed text-light" href="javascript:void(0);" data-toggle="collapse"
                data-target="#collapseSales_masterfile" aria-expanded="false" aria-controls="collapseSales_masterfile">
                <div class="nav-link-icon"><i class="fas fa-user-cog"></i></div>Sales Master Files
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse <?php if($functionmenu=="Leather_Type" | $functionmenu=="Hood_Material" | $functionmenu=="Carpet" | $functionmenu=="Stitching_Design" | $functionmenu=="Seat_Type" | $functionmenu=="Logo" | $functionmenu=="Logo_Colour" | $functionmenu=="Thread_Colour" | $functionmenu=="Stitch_Style" | $functionmenu=="Payment_Method" | $functionmenu=="Price_category" | $functionmenu=="Material" | $functionmenu=="MainJobCategory" | $functionmenu=="SubJobCategory" | $functionmenu=="SalesJobsDetails" | $functionmenu=="JobOptionGroup" | $functionmenu=="JobOption" | $functionmenu=="JobOptionValue"){echo 'show';} ?>"
                id="collapseSales_masterfile" data-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                    <?php if(menucheck($menuprivilegearray, 49)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-light" href="<?php echo base_url().'MainJobCategory'; ?>">Main
                        Jobs Category</a>
                    <?php }if(menucheck($menuprivilegearray, 50)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-light" href="<?php echo base_url().'SubJobCategory'; ?>">Sub
                        Jobs Category</a>
                    <?php }if(menucheck($menuprivilegearray, 62)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-light" href="<?php echo base_url().'JobOptionGroup'; ?>">Job Option Group</a>

                    <?php }if(menucheck($menuprivilegearray, 63)==1){ ?>
                        <a class="nav-link p-0 px-3 py-1 text-light" href="<?php echo base_url().'JobOption'; ?>">Job Option</a>

                    <?php }if(menucheck($menuprivilegearray, 64)==1){ ?>
                        <a class="nav-link p-0 px-3 py-1 text-light" href="<?php echo base_url().'JobOptionValue'; ?>">Job Option Value</a>

                    <?php }if(menucheck($menuprivilegearray, 52)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-light"
                        href="<?php echo base_url().'SalesJobsDetails'; ?>">Jobs Details</a>
                    <?php }if(menucheck($menuprivilegearray, 51)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-light"
                        href="<?php echo base_url().'Material'; ?>">Material</a>
                    <?php } if(menucheck($menuprivilegearray, 20)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-light" href="<?php echo base_url().'Leather_Type'; ?>">Leather
                        Type</a>
                    <?php }if(menucheck($menuprivilegearray, 22)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-light" href="<?php echo base_url().'Carpet'; ?>">Carpet</a>
                    <?php }if(menucheck($menuprivilegearray, 23)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-light"
                        href="<?php echo base_url().'Stitching_Design'; ?>">Stitching Design</a>
                    <?php }if(menucheck($menuprivilegearray, 24)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-light" href="<?php echo base_url().'Seat_Type'; ?>">Seat
                        Type</a>

                    <?php }if(menucheck($menuprivilegearray, 25)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-light" href="<?php echo base_url().'Logo'; ?>">Logo</a>
                    <?php }if(menucheck($menuprivilegearray, 26)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-light" href="<?php echo base_url().'Logo_Colour'; ?>">Logo
                        Colour</a>
                    <?php }if(menucheck($menuprivilegearray, 27)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-light" href="<?php echo base_url().'Thread_Colour'; ?>">Thread
                        Colour</a>

                    <?php }if(menucheck($menuprivilegearray, 28)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-light" href="<?php echo base_url().'Stitch_Style'; ?>">Stitch
                        Style</a>
                    <?php }if(menucheck($menuprivilegearray, 29)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-light"
                        href="<?php echo base_url().'Payment_Method'; ?>">Payment Method</a>

                    <?php }if(menucheck($menuprivilegearray, 42)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-light" href="<?php echo base_url().'Price_category'; ?>">Price
                        Category Type</a>
                    <?php } ?>
                </nav>
            </div>
            <?php } ?>

            <?php if(menucheck($menuprivilegearray, 46)==1){ ?>
            <a class="nav-link p-0 px-3 py-2 text-light" href="<?php echo base_url().'Employee'; ?>">
                <div class="nav-link-icon"><i class="fas fa-users"></i></div> Employee
            </a>
            <?php }?>

            <?php if(menucheck($menuprivilegearray, 40)==1){ ?>
            <a class="nav-link p-0 px-3 py-2 text-light" href="<?php echo base_url().'Job_price_details'; ?>">
                <div class="nav-link-icon"><i class="fas fa-id-card"></i></div>Job Price Detail
            </a>
            <?php }?>

            <?php if(menucheck($menuprivilegearray, 48)==1){ ?>
            <a class="nav-link p-0 px-3 py-2 text-light" href="<?php echo base_url().'Customer'; ?>">
                <div class="nav-link-icon"><i class="fas fa-id-card-alt"></i></div>Customer
            </a>
            <?php }?>

            <?php if(menucheck($menuprivilegearray, 53)==1){ ?>
            <a class="nav-link p-0 px-3 py-2 text-light" href="<?php echo base_url().'JobCard'; ?>">
                <div class="nav-link-icon"><i class="fas fa-id-card-alt"></i></div>Job Card
            </a>
            <?php }?>

            <?php if(menucheck($menuprivilegearray, 67)==1){ ?>
            <a class="nav-link p-0 px-3 py-2 text-light" href="<?php echo base_url().'Invoice'; ?>">
                <div class="nav-link-icon"><i class="fas fa-cash-register"></i></div>Invoice
            </a>
            <?php }?>

            <?php if(menucheck($menuprivilegearray, 67)==1){ ?>
            <a class="nav-link p-0 px-3 py-2 text-light" href="<?php echo base_url().'Payment'; ?>">
                <div class="nav-link-icon"><i class="fas fa-cash-register"></i></div>Payments
            </a>
            <?php }?>

            <?php if(menucheck($menuprivilegearray, 58)==1){ ?>
            <a class="nav-link p-0 px-3 py-2 text-light" href="<?php echo base_url().'JobCard_information'; ?>">
                <div class="nav-link-icon"><i class="fas fa-id-card"></i></div>Job Card Information
            </a>
            <?php }?>

            <?php if(menucheck($menuprivilegearray, 59)==1){ ?>
            <a class="nav-link p-0 px-3 py-2 text-light" href="<?php echo base_url().'AssignEmployeeToJobDashboad'; ?>">
                <div class="nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>Assign Employee To Job Dashboad
            </a>
            <?php }?>

            <?php if(menucheck($menuprivilegearray, 61)==1){ ?>
            <a class="nav-link p-0 px-3 py-2 text-light"
                href="<?php echo base_url().'SupervisorAssignEmployeeToJob'; ?>">
                <div class="nav-link-icon"><i class="fas fa-user-edit"></i></div>Supervisor Assign Employee To Job
            </a>
            <?php }?>

            <?php if(menucheck($menuprivilegearray, 57)==1){ ?>
            <a class="nav-link p-0 px-3 py-2 text-light" href="<?php echo base_url().'AssignEmployeeToJob'; ?>">
                <div class="nav-link-icon"><i class="fas fa-id-card"></i></div>Assign Employee To Job
            </a>
            <?php }?>

            <?php if(menucheck($menuprivilegearray, 65)==1){ ?>

            <a class="nav-link p-0 px-3 py-2 text-light" href="<?php echo base_url().'Map'; ?>">
                <div class="nav-link-icon"><i class="fas fa-id-card"></i></div>Map
            </a>
            <?php }?>


            <?php if(menucheck($menuprivilegearray, 66)==1){ ?>
            <a class="nav-link p-0 px-3 py-2 text-light" href="<?php echo base_url().'Media_library'; ?>">
                <div class="nav-link-icon"><i data-feather="map"></i></div>Media Library
            </a>
            <?php }?>


            <?php if(menucheck($menuprivilegearray, 1)==1 | menucheck($menuprivilegearray, 2)==1 | menucheck($menuprivilegearray, 3)==1 | menucheck($menuprivilegearray, 4)==1){ ?>
            <a class="nav-link p-0 px-3 py-2 collapsed text-light" href="javascript:void(0);" data-toggle="collapse"
                data-target="#collapseUser" aria-expanded="false" aria-controls="collapseUser">
                <div class="nav-link-icon"><i class="fas fa-user"></i></div>
                User Account
                <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse <?php if($functionmenu=="Useraccount" | $functionmenu=="Usertype" | $functionmenu=="Userprivilege"){echo 'show';} ?>"
                id="collapseUser" data-parent="#accordionSidenav">
                <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                    <?php if(menucheck($menuprivilegearray, 1)==1){ ?>
                    <a class="nav-link p-0 px-3 py-1 text-light"
                        href="<?php echo base_url().'User/Useraccount'; ?>">User
                        Account</a>
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