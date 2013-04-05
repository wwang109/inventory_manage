<script type="text/javascript">
	$(document).ready(function() {
		$('#productNumber').focus();
		if($('select#brandlist').val() != 'other') {
			$('#brandbox').hide();
		}
		$("select").change(function() {
			if($('select#brandlist').val() != 'other')
				$('#brandbox').hide();
			else 
				$('#brandbox').show();
		})
		.change();	
		
		$('#delete').click(function() {
			if(confirm('Are you sure?')) {
				$('#delete').attr('href', '<?php _e(URL . 'product/delete/'); ?>' + $('#productNumber').val());
				return; 
			}
			else
				return;
		});
				
	});
</script>

<div class="row-fluid">
	<div class="page-header">
		<h3>Product(s) Manage</h3>
	</div>
	<div>
		<form class="form-horizontal" action="<?php _e(URL) ?>product/add" method="post" enctype="multipart/form-data" >
					
		  	<div class="control-group">
		    	<label class="control-label">Product Number</label>
		    	<div class="controls">
		      		<input type="text" id="productNumber" name="productNumber" value="<?php if(isset($this->data->productNumber)) _e($this->data->productNumber); elseif(isset($this->data[0])) _e($this->data);?>" />
		    	</div>
		  	</div>
		  	
		  	<div class="control-group">
		    	<label class="control-label">Product Name</label>
		    	<div class="controls">
		      		<input type="text" id="productName" name="productName" value="<?php if(isset($this->data->Name)) _e($this->data->Name) ?>" />
		    	</div>
		  	</div>
		  	<div class="control-group">
		  		<label class="control-label">Brand</label>
		  		<div class="controls">
		  			<select name="brandlist" id="brandlist">
		  				<?php foreach($this->brand as $brand): ?>
		  					<option value="<?php _e($brand->brandName); ?>"><?php _e($brand->brandName); ?></option>
		  				<?php endforeach; ?>
					</select>
		  		</div>
		  		<div  class="controls">
		  			<input type="text" name="brand" id="brandbox" value="<?php if(isset($this->data->Brand)) _e($this->data->Brand) ?>" />
		  		</div>		  		
		  	</div>
		  	<div class="control-group">
		  		<label class="control-label">Quantity Per Unit</label>
		  		<div class="controls">
		  			<input class="input-mini" name="qtyUnit" id="qtyUnit" value="<?php if(isset($this->data->qtyUnit)) _e($this->data->qtyUnit) ?>" />
		  		</div>
		  	</div>
		  	
		  	<div class="control-group">
		  		<label class="control-label">Comment</label>
		  		<div class="controls">
		  			<textarea rows="3" name="comment"><?php if(isset($this->data->comment)) _e($this->data->comment) ?></textarea>
		  		</div>
		  	</div>

		  	<div class="control-group">
		  		<label class="control-label">Image</label>
		  		<div class="controls">
		  			<input type="file" name="qqfile" id="qqfile" />
		  		</div>
		  	</div>		  			  			  	
			<div class="form-actions" id="formAction">
  				<button type="submit" class="btn btn-primary" >Save changes</button>
  				<button type="reset" class="btn">Cancel</button>
  				<a class="btn btn-danger" id="delete">Remove Product</a>
			</div>
			
		</form>

	</div>

</div>

