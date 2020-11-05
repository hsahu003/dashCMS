<?php 	
defined('BASEPATH') OR exit('No direct script access allowed');
 ?><!--Continuing from views/dashboard/templated/header.php-->
	<div class="container dashborad-working-area">
		<?php if(isset($execute)):?>
			<div class="error-display-container error-display-container-add-admin">
				<div class="container m-4 border-radius-2 error-container">
					<?=$message?>
				</div>
			</div>
		<?php endif?>
		<div class="container m-4 p-4 border-radius-2 nested-dashboard-working-area">
			<div class="font-size-4p5 font-weight-5 mb-2 f-color-3">
					View Products 
			</div>
			<div class="container">
				<div class="row">
					<div class="col width-100 shadow-softer">
						<table class="border-radius-table-2">
							<thead class="thead-dark">
								<tr>
									<th>Sr. No.</th>	
									<th>Product Name</th>
									<th>Category</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php $index=1; foreach($products as $product): ?>
								<tr>
									<td><?= $index++; ?></td>
									<td><?= $product->name; ?></td>
									<td><?= $product->category; ?></td>
									<td>
										<!-- <a href="#">
											Delete
										</a> -->
										<a href="<?= site_url('dashboard/product/edit/'.$product->product_id)?>">
											Edit
										</a>
									</td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>