<div class="row column_title">
	<div class="col-md-12">
		<div class="page_title">
			<div class="row nowrap">
				<div class="dropdown">
					<?php if(menucheck($menuprivilegearray, 14)==1){ ?>
					<a role="button" class="btn navbtncolor" id="producttype_link" data-target="#" href="<?php echo base_url().'ProductController/Producttype'; ?>">Product Type<span class="caret"></span></a>
					<?php } if(menucheck($menuprivilegearray, 15)==1){ ?>
					<a role="button" class="btn navbtncolor" id="productcategory_link" data-target="#" href="<?php echo base_url().'ProductController/Productcategory'; ?>">Product Category <span class="caret"></span></a>
					<?php } if(menucheck($menuprivilegearray, 16)==1){ ?>
					<a role="button" class="btn navbtncolor" id="productgrading_link" data-target="#" href="<?php echo base_url().'ProductController/Productgrading'; ?>">Product Grading <span class="caret"></span></a>
					<?php } if(menucheck($menuprivilegearray, 17)==1){ ?>
					<a role="button" class="btn navbtncolor" id="product_link" data-target="#" href="<?php echo base_url().'ProductController/Productsinfo'; ?>">Product <span class="caret"></span></a>
					<?php } if(menucheck($menuprivilegearray, 20)==1){ ?>
					<a role="button" class="btn navbtncolor" id="item_link" data-target="#" href="<?php echo base_url().'ProductController/Itemsinfo'; ?>">Items <span class="caret"></span></a>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>
