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
					View Product Categories
			</div>
			<div class="container">
				<div class="row">
					<div class="col width-100 shadow-softer">
						<table class="border-radius-table-2">
							<thead class="thead-dark">
								<tr>
									<th>Category Name</th>
									<th>Parent Category</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($product_categories as $product_category): ?>
								<tr>
									<td><?= $product_category->name; ?></td>
									<td><?= $product_category->parent_name; ?></td>
									<td>
										<a href="<?= site_url('dashboard/product/category/delete_category/'.$product_category->taxonomy_id)?>">
											Delete
										</a>
										<a href="<?= site_url('dashboard/product/category/edit_category/'.$product_category->taxonomy_id)?>">
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