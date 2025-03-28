<div class="row column_title">
	<div class="col-md-12">
		<div class="page_title">
			<div class="row nowrap">
				<div class="dropdown">
				<a  role="button" data-toggle="dropdown" class="btn navbtncolor" data-target="#" href="#" id="plantationmaster">
               Master Data <span class="caret"></span></a>
			   <ul class="dropdown-menu multi-level dropdownmenucolor" role="menu" aria-labelledby="dropdownMenu">

			   	<?php if(menucheck($menuprivilegearray, 21)==1){ ?>
			   	<li><a role="button" class="dropdown-item" id="jobcategory_link" data-target="#" href="<?php echo base_url().'PlantationMasterController/Travellingtransport'; ?>">Travelling & Transport<span class="caret"></span></a> </li>

			   	<?php } if(menucheck($menuprivilegearray, 22)==1){ ?>
			   	<li><a role="button" class="dropdown-item" id="jobtitile_link" data-target="#" href="<?php echo base_url().'PlantationMasterController/Landperperation'; ?>">Land Perpetration <span class="caret"></span></a> </li>
				
				<?php } if(menucheck($menuprivilegearray, 27)==1){ ?>
			   	<li> <a role="button" class="dropdown-item" id="workshift_link" data-target="#" href="<?php echo base_url().'PlantationMasterController/Utilitybills'; ?>">Utility Bills <span class="caret"></span></a></li>
				
				<?php } if(menucheck($menuprivilegearray, 28)==1){ ?>
			   	<li> <a role="button" class="dropdown-item" id="workshift_link" data-target="#" href="<?php echo base_url().'PlantationMasterController/Otherexpencesinfo'; ?>">Other Expencess <span class="caret"></span></a></li>

			   	<?php } ?>
			   </ul>
			   </div>
			   <div class="dropdown">
					<?php if(menucheck($menuprivilegearray, 29)==1){ ?>
					<a role="button" class="btn navbtncolor" id="plantation_link" data-target="#" href="<?php echo base_url().'PlantationController/Plantationinfo'; ?>">Plantations<span class="caret"></span></a>
					<?php } ?>
				</div>
				<div class="dropdown">
					<?php if(menucheck($menuprivilegearray, 30)==1){ ?>
						<a role="button" class="btn navbtncolor" id="inputexp_link" data-target="#" href="<?php echo base_url().'PlantationController/inputandexpenditures'; ?>">Input & Expenditures<span class="caret"></span></a>
					<?php } ?>
				</div>

				<div class="dropdown">
					<?php if(menucheck($menuprivilegearray, 32)==1){ ?>
						<a role="button" class="btn navbtncolor" id="harvestincome_link" data-target="#" href="<?php echo base_url().'PlantationController/harvestandincome'; ?>">Harvest & Income<span class="caret"></span></a>
					<?php } ?>
				</div>

				<div class="dropdown">
					<?php if(menucheck($menuprivilegearray, 31)==1){ ?>
						<a role="button" class="btn navbtncolor" id="approvedinputexp_link" data-target="#" href="<?php echo base_url().'PlantationController/approvedinputandexpenditures'; ?>">Approved Input & Expenditures<span class="caret"></span></a>
					<?php } ?>
				</div>

				<div class="dropdown">
					<?php if(menucheck($menuprivilegearray, 33)==1){ ?>
						<a role="button" class="btn navbtncolor" id="approvedharvestincome_link" data-target="#" href="<?php echo base_url().'PlantationController/approvedharvestandincome'; ?>">Approved Harvest & Income<span class="caret"></span></a>
					<?php } ?>
				</div>

			</div>
		</div>
	</div>
</div>
