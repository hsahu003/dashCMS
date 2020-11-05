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
					View Shipping options
			</div>
			<div class="container">
				<div class="row">
					<div class="col width-100 shadow-softer">
						<table class="border-radius-table-2">
							<thead class="thead-dark">
								<tr>
									<th>Option Name</th>
									<th>Option Country</th>
									<th>Cost</th>
									<!-- <th>Action</th> -->
								</tr>
							</thead>
							<tbody>
								<?php foreach($options as $option): ?>
								<tr>
									<td><?= $option->name; ?></td>
									<td><?= $option->country; ?></td>
									<td><?= $option->currency_symbol.' '; ?><?= $option->cost; ?></td>
									<!-- <td>
										<a class="underline" href="">
											Delete
										</a>
										<a class="ml-2 underline" href="<?= site_url('dashboard/shop-setting/shipping/edit/state/'.$option->shipping_option_id)?>">
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
<script type="text/javascript">
	function sort_states(filter)
	{
		window.location =  site_url('dashboard/shop-setting/location/view/state/c/' + filter.value);
	}
</script>