	<?php if (count($this->data['OBJ']) > 0): ?>
		<div id="dataContent">		
		<div id="paging" class="pagination pagination-centered">
			<ul>
				<?php if ($this->data['paging']['previous'] != -1): ?>
					<li <?php if ($this->data['paging']['current'] == $this->data['paging']['previous']) _e('class="disabled"'); ?>>
						<a <?php if ($this->data['paging']['current'] != $this->data['paging']['previous']) _e('href="' . URL . "product/getList/{$this->data['paging']['previous']}/{$this->data['sortBy']}/{$this->data['sortAs']}/{$this->data['perPage']}/{$this->data['option']}/{$this->data['search']}" . '"'); ?>>Prev</a>
					</li>
				<?php endif; ?>

				<?php foreach ($this->data['paging']['pages'] as $page): ?>
					<li <?php if ($page == $this->data['paging']['current']) _e('class="active"'); ?>>
						<a <?php if($this->data['paging']['current'] != $page) _e('href="' . URL . "product/getList/{$page}/{$this->data['sortBy']}/{$this->data['sortAs']}/{$this->data['perPage']}/{$this->data['option']}/{$this->data['search']}" . '"'); ?>><?php _e($page); ?></a>
					</li>
				<?php endforeach; ?>

				<?php if ($this->data['paging']['next'] > 0): ?>
					<li <?php if ($this->data['paging']['current'] == $this->data['paging']['next']) _e('class="disabled"'); ?>>
						<a <?php if($this->data['paging']['current'] != $this->data['paging']['next']) _e('href="' . URL . "product/getList/{$this->data['paging']['next']}/{$this->data['sortBy']}/{$this->data['sortAs']}/{$this->data['perPage']}/{$this->data['option']}/{$this->data['search']}" . '"'); ?>>Next</a>
					</li>
				<?php endif; ?>
			</ul>
		</div>
		<script>
			$('#paging ul li a').click( function() {
				event.preventDefault();
				$('#paging ul li a').each(function () { 
					$('#dataContent').load($(this).attr("href"));				
				});         
			});

		</script>					
	<table id="table" class="table table-bordered table-condensed">
		<thead>
			<tr>
				<th></th>
				<th>Product Number</th>
				<th>Name</th>
				<th>Brand</th>
				<th>Qty per Unit</th>
				<th>Date Added</th>
				<th>Comments</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($this->data['OBJ'] as $rows): ?>
			<tr>
				<td style="vertical-align:middle" ><?php if($rows->image): ?><center><img height="75px" width="75px" src="<?php _e(URL . "public/image/" . $rows->image); ?>" /></center><?php endif; ?></td>
				<td style="vertical-align:middle" ><?php _e($rows->productNumber); ?></td>
				<td style="vertical-align:middle" ><?php _e($rows->Name) ?></td>
				<td style="vertical-align:middle" ><?php _e($rows->brands_id) ?></td>
				<td style="vertical-align:middle" ><?php _e($rows->qtyUnit) ?></td>
				<td style="vertical-align:middle" ><?php _e($rows->dateAdded) ?></td>
				<td style="vertical-align:middle" ><?php _e($rows->comment) ?></td>
				<td style="vertical-align:middle" ><a href="<?php _e(URL . 'product/manage/' . $rows->productNumber); ?>" class="btn btn-primary">Edit</a></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	</div>
	<?php else: ?>
		<h3>No  results</h3>
	<?php endif; ?>
	