<script type="text/javascript">         
	$(document).ready(function() { 
		var text;
		var option = $('#options').val();     
		$('#add').click(function() {
			text = $('#txtbox').val(); 
			$('#add').attr('href', '<?php _e(URL . 'product/manage/'); ?>' + text);	
		});                           
		
    });   
</script>  

<div class="row-fluid">
	<div class="page-header">
		<h3>Product</h3>
	</div>
	<form class="form-inline" >
		<input id="txtbox" type="text">
		<select id="options">
			<option value="productNumber">Product Number</option>
			<option value="name">Name</option>
			<option value="brand">Brand</option>
		</select>
		<button id="search" class="btn btn-primary">
			<i class="icon-search icon-white"></i> Search
		</button>
		<a id="add" class="btn btn-info"><i class="icon-plus icon-white"></i> Add Product</a>
	</form>
	<?php if (count($this->data['OBJ']) > 0): ?>
		<div class="pagination pagination-centered">
			<ul>
				<?php if ($this->data['paging']['previous'] != -1): ?>
					<li <?php if ($this->data['paging']['current'] == $this->data['paging']['previous']) _e('class="disabled"'); ?>>
						<a <?php if ($this->data['paging']['current'] != $this->data['paging']['previous']) _e('href="' . URL . "product/index/{$this->data['paging']['previous']}/{$this->data['sortBy']}/{$this->data['sortAs']}" . '"'); ?>>Prev</a>
					</li>
				<?php endif; ?>

				<?php foreach ($this->data['paging']['pages'] as $page): ?>
					<li <?php if ($page == $this->data['paging']['current']) _e('class="active"'); ?>>
						<a <?php if($this->data['paging']['current'] != $page) _e('href="' . URL . "product/index/{$page}/{$this->data['sortBy']}/{$this->data['sortAs']}" . '"'); ?>><?php _e($page); ?></a>
					</li>
				<?php endforeach; ?>

				<?php if ($this->data['paging']['next'] > 0): ?>
					<li <?php if ($this->data['paging']['current'] == $this->data['paging']['next']) _e('class="disabled"'); ?>>
						<a <?php if($this->data['paging']['current'] != $this->data['paging']['next']) _e('href="' . URL . "product/index/{$this->data['paging']['next']}/{$this->data['sortBy']}/{$this->data['sortAs']}" . '"'); ?>>Next</a>
					</li>
				<?php endif; ?>
			</ul>
		</div>			
	<table class="table table-bordered table-condensed">
		<thead>
			<tr>
				<th></th>
				<th><a href="<?php _e(URL . "product/index/{$this->data['paging']['current']}/productNumber/" . ($this->data['sortAs'] == 'desc' ? 'asc' : 'desc')); ?>">Product Number</a></th>
				<th><a href="<?php _e(URL . "product/index/{$this->data['paging']['current']}/Name/" . ($this->data['sortAs'] == 'desc' ? 'asc' : 'desc')); ?>">Name</a></th>
				<th><a href="<?php _e(URL . "product/index/{$this->data['paging']['current']}/Brand/" . ($this->data['sortAs'] == 'desc' ? 'asc' : 'desc')); ?>">Brand</a></th>
				<th><a href="<?php _e(URL . "product/index/{$this->data['paging']['current']}/qtyUnit/" . ($this->data['sortAs'] == 'desc' ? 'asc' : 'desc')); ?>">QTY PER</a></th>
				<th><a href="<?php _e(URL . "product/index/{$this->data['paging']['current']}/dateAdded/" . ($this->data['sortAs'] == 'desc' ? 'asc' : 'desc')); ?>">Date Added</a></th>
				<th>Comments</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($this->data['OBJ'] as $rows): ?>
			<tr>
				<td style="vertical-align:middle" ><?php if($rows->image): ?><center><img height="75px" width="75px" src="<?php _e(URL . "public/image/" . $rows->image); ?>" /></center><?php endif; ?></td>
				<td style="vertical-align:middle" ><?php _e($rows->productNumber); ?></td>
				<td style="vertical-align:middle" ><?php _e($rows->Name) ?></td>
				<td style="vertical-align:middle" ><?php _e($rows->Brand) ?></td>
				<td style="vertical-align:middle" ><?php _e($rows->qtyUnit) ?></td>
				<td style="vertical-align:middle" ><?php _e($rows->dateAdded) ?></td>
				<td style="vertical-align:middle" ><?php _e($rows->comment) ?></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<?php endif; ?>
</div>
