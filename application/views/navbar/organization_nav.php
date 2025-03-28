<div class="row column_title">
	<div class="col-md-12">
		<div class="page_title">
			<div class="row nowrap">
				<div class="dropdown">
				<?php if(menucheck($menuprivilegearray, 4)==1){ ?>
					<a role="button" class="btn navbtncolor" id="company_link" data-target="#" href="<?php echo base_url().'Coporatecontroller/Companyinfo'; ?>" id="companylink">Company <span class="caret"></span></a>
					<?php } if(menucheck($menuprivilegearray, 5)==1){ ?>
					<a role="button" class="btn navbtncolor" id="location_link" data-target="#" href="<?php echo base_url().'Coporatecontroller/CompanyLocation'; ?>" id="companylink">Location <span class="caret"></span></a>
					<?php } if(menucheck($menuprivilegearray, 6)==1){ ?>
					<a role="button" class="btn navbtncolor" id="department_link" data-target="#" href="<?php echo base_url().'Coporatecontroller/Deparmentinfo'; ?>" id="companylink">Department <span class="caret"></span></a>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>
