<div class="row column_title">
	<div class="col-md-12">
		<div class="page_title">
			<div class="row nowrap">
				<div class="dropdown">
				<a  role="button" data-toggle="dropdown" class="btn navbtncolor" data-target="#" href="#" id="employeemaster">
               Master Data <span class="caret"></span></a>
			   <ul class="dropdown-menu multi-level dropdownmenucolor" role="menu" aria-labelledby="dropdownMenu">

			   	<?php if(menucheck($menuprivilegearray, 7)==1){ ?>
			   	<li><a role="button" class="dropdown-item" id="jobcategory_link" data-target="#" href="<?php echo base_url().'JobController/Jobcategory'; ?>">Job Category <span class="caret"></span></a> </li>

			   	<?php } if(menucheck($menuprivilegearray, 8)==1){ ?>
			   	<li><a role="button" class="dropdown-item" id="jobtitile_link" data-target="#" href="<?php echo base_url().'JobController/Jobtitle'; ?>">Job Title <span class="caret"></span></a> </li>

			   	<?php } if(menucheck($menuprivilegearray, 9)==1){ ?>
			   	<li> <a role="button" class="dropdown-item" id="jobemployement_link" data-target="#" href="<?php echo base_url().'JobController/JobEmpStatus'; ?>">Job Employment Status <span class="caret"></span></a> </li>

			   	<?php } if(menucheck($menuprivilegearray, 12)==1){ ?>
			   	<li> <a role="button" class="dropdown-item" id="workshift_link" data-target="#" href="<?php echo base_url().'ShiftController/Shiftinfo'; ?>">Work Shifts <span class="caret"></span></a></li>

			   	<?php } ?>
			   </ul>
			   </div>
			   <div class="dropdown">
					<?php if(menucheck($menuprivilegearray, 13)==1){ ?>
					<a role="button" class="btn navbtncolor" id="employee_link" data-target="#" href="<?php echo base_url().'Employeecontroller/Employeedetails'; ?>">Employee Info <span class="caret"></span></a>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>
