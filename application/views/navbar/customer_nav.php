<div class="row column_title">
	<div class="col-md-12">
		<div class="page_title">
			<div class="row nowrap">
				<div class="dropdown">
					<?php if(menucheck($menuprivilegearray, 19)==1){ ?>
					<a role="button" class="btn navbtncolor" id="customer_link" data-target="#" href="<?php echo base_url().'CustomerController/Customerinfo'; ?>">Buyers <span class="caret"></span></a>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>
