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
					View Coupon Codes
			</div>
			<div class="container">
				<div class="row">
					<div class="col width-100 shadow-softer">
						<table class="border-radius-table-2">
							<thead class="thead-dark">
								<tr>
									<th>Coupon Code</th>
									<th>Type</th>
									<th>Value</th>
									<th>Validity</th>
									<th>Total Quantity</th>
									<th>Per Person Limit</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($coupons as $coupon): ?>
								<tr>
									<td><?= $coupon->name; ?></td>
									<td><?= $coupon->type; ?></td>
									<td><?= $coupon->discount; ?></td>
									<td><?= $coupon->valid_till; ?></td>
									<td><?= $coupon->quantity; ?></td>
									<td><?= $coupon->limit_per_user; ?></td>
<!-- 									<td>
										<a class="underline" href="<?= site_url('dashboard/shop-setting/location/delete/country/'.$country->country_id)?>">
											Delete
										</a>
										<a class="ml-2 underline" href="<?= site_url('dashboard/shop-setting/location/edit/country/'.$country->country_id)?>">
											Edit
										</a>
									</td> -->
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