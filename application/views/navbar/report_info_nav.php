<div class="row column_title">
	<div class="col-md-12">
		<div class="page_title">
			<div class="row nowrap">
				<div class="dropdown">
				<a  role="button" data-toggle="dropdown" class="btn navbtncolor" data-target="#" href="#" id="plantationreports">
               Plantation Reports<span class="caret"></span></a>
			   <ul class="dropdown-menu multi-level dropdownmenucolor" role="menu" aria-labelledby="dropdownMenu">

			   	<?php if(menucheck($menuprivilegearray, 43)==1){ ?>
			   	<li><a role="button" class="dropdown-item" id="plantationreport_link" data-target="#" href="<?php echo base_url().'ReportController/Inputreport'; ?>">Input Report<span class="caret"></span></a> </li>

			   	<?php } if(menucheck($menuprivilegearray, 44)==1){ ?>
			   	<li><a role="button" class="dropdown-item" id="plantationreport_link" data-target="#" href="<?php echo base_url().'PlantationMasterController/Landperperation'; ?>">Expenditure Report <span class="caret"></span></a> </li>
				
				<?php } if(menucheck($menuprivilegearray, 45)==1){ ?>
			   	<li> <a role="button" class="dropdown-item" id="plantationreport_link" data-target="#" href="<?php echo base_url().'PlantationMasterController/Utilitybills'; ?>">Harvest Report <span class="caret"></span></a></li>
				
				<?php } if(menucheck($menuprivilegearray, 46)==1){ ?>
			   	<li> <a role="button" class="dropdown-item" id="plantationreport_link" data-target="#" href="<?php echo base_url().'PlantationMasterController/Otherexpencesinfo'; ?>">Income Report <span class="caret"></span></a></li>

			   	<?php } ?>
			   </ul>
			   </div>

			</div>
		</div>
	</div>
</div>
