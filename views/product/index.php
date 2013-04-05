<script type="text/javascript">         
	$(document).ready(function() { 
		$('#txtbox').focus();
		var text;
		var option = $('#options').val();     
		$('#add').click(function() {
			text = $('#txtbox').val(); 
			$('#add').attr('href', '<?php _e(URL . 'product/manage/'); ?>' + text);	
		});
		$('#content').load('<?php _e(URL . 'product/getList/'); ?>');
		$('#search').submit(function(event) {
			event.preventDefault();
			var link = '<?php _e(URL . 'product/search/'); ?>' + $('select#options').val() + '/' + $('#txtbox').val() + '/';
			$('#content').load(link);
			
		});		
		
		
    });   
</script>  

<div class="row-fluid">
	<div class="page-header">
		<h3>Product</h3>
	</div>
	<form class="form-inline" action="/" id="search" method="post" >
		<input id="txtbox" name="txtbox" type="text">
		<select id="options" name="options">
			<option value="productNumber">Product Number</option>
			<option value="Name">Name</option>
			<option value="Brand">Brand</option>
		</select>
		<button type="submit" id="submit" class="btn btn-primary">
			<i class="icon-search icon-white"></i> Search
		</button>
		<a id="add" class="btn btn-info"><i class="icon-plus icon-white"></i> Add Product</a>
	</form>
	<div id="content"></div>
</div>
