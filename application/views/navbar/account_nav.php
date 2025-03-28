<div class="row column_title">
	<div class="col-md-12">
		<div class="page_title">
			<div class="row nowrap">
				<div class="dropdown">
				<?php if(menucheck($menuprivilegearray, 1)==1){ ?>
					<a role="button" class="btn navbtncolor" id="useraccount_link" data-target="#" href="<?php echo base_url().'User/Useraccount'; ?>">User Account <span class="caret"></span></a>
					<?php } if(menucheck($menuprivilegearray, 2)==1){ ?>
					<a role="button" class="btn navbtncolor" id="usertypelink" data-target="#" href="<?php echo base_url().'User/Usertype'; ?>">Type <span class="caret"></span></a>
					<?php } if(menucheck($menuprivilegearray, 3)==1){ ?>
					<a role="button" class="btn navbtncolor" id="previlege_link" data-target="#" href="<?php echo base_url().'User/Userprivilege'; ?>">Privilege <span class="caret"></span></a>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>
