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
					View States
			</div>
			<div class="container mb-3">
				<div class="row align-items-x-end flex">
					<div class="col mr-2">
						View states by country:
					</div>
					<div class="col">
						<select onchange="sort_states(this)">
							<option value="0">---Select Country---</option>
							<?php if(isset($country)): ?>
								<option selected value="<?=$country['country_id'] ?>"><?=$country['country'] ?></option>
							<?php endif ?>
							<?php 	foreach($countries as $country): ?>
							<option value="<?= $country->country_id ?>"><?= $country->country ?></option>
							<?php endforeach ?>
						</select>
					</div>
				</div>
			</div>
			<div class="container">
				<div class="row">
					<div class="col width-100 shadow-softer">
						<table class="border-radius-table-2">
							<thead class="thead-dark">
								<tr>
									<th>State</th>
									<th>ISO State Code</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($states as $state): ?>
								<tr>
									<td><?= $state->state; ?></td>
									<td><?= $state->state_code; ?></td>
									<td>
										<a class="underline" href="<?= site_url('dashboard/shop-setting/location/delete/state/'.$state->state_id.'/c/'.$state->country_id)?>">
											Delete
										</a>
										<a class="ml-2 underline" href="<?= site_url('dashboard/shop-setting/location/edit/state/'.$state->state_id)?>">
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
<script type="text/javascript">
	function sort_states(filter)
	{
		window.location =  site_url('dashboard/shop-setting/location/view/state/c/' + filter.value);
	}
</script>