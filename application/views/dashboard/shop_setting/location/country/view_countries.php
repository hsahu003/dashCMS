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
					View Countries
			</div>
			<div class="container">
				<div class="row">
					<div class="col width-100 shadow-softer">
						<table class="border-radius-table-2">
							<thead class="thead-dark">
								<tr>
									<th>Country</th>
									<th>ISO Country Code</th>
									<th>ISO Currency Code</th>
									<th>ISO Currency Symbol</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($countries as $country): ?>
								<tr>
									<td><?= $country->country; ?></td>
									<td><?= $country->country_code; ?></td>
									<td><?= $country->currency_code; ?></td>
									<td><?= $country->currency_symbol; ?></td>
									<td>
										<a class="underline" href="<?= site_url('dashboard/shop-setting/location/delete/country/'.$country->country_id)?>">
											Delete
										</a>
										<a class="ml-2 underline" href="<?= site_url('dashboard/shop-setting/location/edit/country/'.$country->country_id)?>">
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