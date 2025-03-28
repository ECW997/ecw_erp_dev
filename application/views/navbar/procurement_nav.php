<div class="row column_title">
	<div class="col-md-12">
		<div class="page_title">
			<div class="row nowrap">
				<div class="dropdown">
					<?php if(menucheck($menuprivilegearray, 36)==1){ ?>
					<a role="button" class="btn navbtncolor" id="uom_link" data-target="#" href="<?php echo base_url().'ProcurementMasterController/Uom'; ?>">UOM <span class="caret"></span></a>
					<?php } ?>
				</div>
				<div class="dropdown">
							<a  role="button" data-toggle="dropdown" class="btn navbtncolor" data-target="#" href="#" id="inventory_link">
							Inventory Item <span class="caret"></span></a>
							<ul class="dropdown-menu multi-level dropdownmenucolor" role="menu" aria-labelledby="dropdownMenu">

							<?php if(menucheck($menuprivilegearray, 37)==1){ ?>
							<li><a role="button" class="dropdown-item" id="kichen_link" data-target="#" href="<?php echo base_url().'ProcurementMasterController/KitchenItem'; ?>">Kitchen Item<span class="caret"></span></a> </li>
							<?php } if(menucheck($menuprivilegearray, 25)==1){ ?>
			   				<li> <a role="button" class="dropdown-item" id="welfaire_link" data-target="#" href="<?php echo base_url().'PlantationMasterController/Welfaireinfo'; ?>">Welfaire <span class="caret"></span></a></li>
							<?php } if(menucheck($menuprivilegearray, 26)==1){ ?>
			   				<li> <a role="button" class="dropdown-item" id="toolsequipment_link" data-target="#" href="<?php echo base_url().'PlantationMasterController/Toolsequipment'; ?>">Tool & Equipment <span class="caret"></span></a></li>
							<?php } ?>
							<li class="dropdown-submenu dropdown-item">
								<a class="dropdown-submenu dropdown-item submenulistpadding" tabindex="-1" href="#">Chemicle</a>
								<ul class="dropdown-menu dropdownmenucolor">
									<?php if(menucheck($menuprivilegearray, 38)==1){ ?>
									<li><a role="button" class="dropdown-item" id="fungicides_link" data-target="#" href="<?php echo base_url().'ProcurementMasterController/Fungicides'; ?>">Fungicides<span class="caret"></span></a> </li>
									<?php }if(menucheck($menuprivilegearray, 39)==1){ ?>
									<li><a role="button" class="dropdown-item" id="pesticides_link" data-target="#" href="<?php echo base_url().'ProcurementMasterController/Pesticides'; ?>">Pesticides<span class="caret"></span></a> </li>
									<?php } if(menucheck($menuprivilegearray, 23)==1){ ?>
									<li> <a role="button" class="dropdown-item" id="weedicides_link" data-target="#" href="<?php echo base_url().'PlantationMasterController/Chemicals'; ?>">Weedicides <span class="caret"></span></a> </li>
									<?php } if(menucheck($menuprivilegearray, 24)==1){ ?>
									<li> <a role="button" class="dropdown-item" id="fertilizer_link" data-target="#" href="<?php echo base_url().'PlantationMasterController/Fertilizers'; ?>">Fertilizer <span class="caret"></span></a></li>									
									<?php } if(menucheck($menuprivilegearray, 40)==1){ ?>
									<li><a role="button" class="dropdown-item" id="others_chemicle_link" data-target="#chemicle" href="<?php echo base_url().'ProcurementMasterController/Others'; ?>">Others <span class="caret"></span></a> </li>
									<?php } ?>
								</ul>
							</li>	
						</ul>
				</div>
				<div class="dropdown">
					<?php if(menucheck($menuprivilegearray, 36)==1){ ?>
					<a role="button" class="btn navbtncolor" id="uom_link" data-target="#" href="<?php echo base_url().'ProcurementMasterController/Uom'; ?>">Quotation <span class="caret"></span></a>
					<?php } ?>
				</div>
				<div class="dropdown">
						<a  role="button" data-toggle="dropdown" class="btn navbtncolor" data-target="#" href="#" id="porder_grn_master_link">
						Purchase / GRN <span class="caret"></span></a>
						<ul class="dropdown-menu multi-level dropdownmenucolor" role="menu" aria-labelledby="dropdownMenu">

						<?php if(menucheck($menuprivilegearray, 34)==1){ ?>
						<li><a role="button" class="dropdown-item" id="purchaseorder_link" data-target="#" href="<?php echo base_url().'ProcurementMasterController/PurchaseOrder'; ?>">Purchase Order<span class="caret"></span></a> </li>

						<?php } if(menucheck($menuprivilegearray, 35)==1){ ?>
						<li><a role="button" class="dropdown-item" id="grn_link" data-target="#" href="<?php echo base_url().'ProcurementMasterController/Grn'; ?>">GRN <span class="caret"></span></a> </li>
						<?php } ?>
					</ul>
			   </div>
			   <div class="dropdown">
					<?php if(menucheck($menuprivilegearray, 42)==1){ ?>
					<a role="button" class="btn navbtncolor" id="invoice_link" data-target="#" href="<?php echo base_url().'ProcurementMasterController/PaymentReceipt'; ?>">Payment Receipt <span class="caret"></span></a>
					<?php } ?>
				</div>
				<div class="dropdown">
						<a  role="button" data-toggle="dropdown" class="btn navbtncolor" data-target="#" href="#" id="stock_masterlink">
						Stock <span class="caret"></span></a>
						<ul class="dropdown-menu multi-level dropdownmenucolor" role="menu" aria-labelledby="dropdownMenu">

						<?php if(menucheck($menuprivilegearray, 41)==1){ ?>
						<li><a role="button" class="dropdown-item" id="stock_link" data-target="#" href="<?php echo base_url().'ProcurementMasterController/Stock'; ?>">Stock<span class="caret"></span></a> </li>

						<?php } if(menucheck($menuprivilegearray, 35)==1){ ?>
						<li><a role="button" class="dropdown-item" id="stocktranfer_link" data-target="#" href="<?php echo base_url().'ProcurementMasterController/grn'; ?>">Stock Tranfer <span class="caret"></span></a> </li>
						<?php } ?>
					</ul>
			   </div>
			</div>
		</div>
	</div>
</div>
