<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!--Continuing from views/dashboard/templated/header.php-->
<div class="text">
	
</div>

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
		Edit State
	</div>
	<div class="row flex-col dashboard-widget-container align-items-y">
		<div class="col ds-col-6 dashboard-widget">
			<div class="container">
				<div class="row align-items-x-start flex border-b">
					<div class="col">
						<div class="border-radius-top-2 p-3 width-100">
							Edit State
						</div>
					</div>
					<div class="col">
						<div class="tooltip">
							<span><?= display_icon('tool_tip_circle','','17px','')?></span>
								<span class="tooltiptext">Tooltip text</span>
						</div>
					</div>
				</div>
			</div>
				
				<?=form_open('dashboard/shop-setting/location/edit/state/'.$state['state_id'],'')?>
				<div class="dashboard-widget-controls p-4">
					<div class="container">
						<div class="row ds-row-cols-12 flex px-child-1 space-between mb-child-3">
							<!--selected country-->
							<div class="col">
								<div class="form-element flex-col mr-4 mt-0 mb-3">
									<label class="width-100 px-2">State's Country</label>
									<select onchange="sort_zones(this)" id="selected_country" name="country_id">
										<option value="">---Select Country---</option>
										<?php if(isset($country)): ?>
											<option selected value="<?=$country['country_id'] ?>"><?=$country['country'] ?></option>
										<?php endif ?>
									</select>
								</div>
							</div>
							<!--state name-->
							<div class="col">
								<div class="form-element flex-col mr-4 mt-0">
									<label class="width-100 px-2">State Name</label>
									<input class="mb-2 p-3" type="text" name="state_name" value="<?= set_value('state_name') != null ?set_value('state_name') : $state['state']; ?>">
								</div>
							</div>
							<!--state code-->
							<div class="col">
								<div class="form-element flex-col mr-4 mt-0">
									<div class="flex width-100 space-between px-2">
										<label>ISO State code</label>
										<div class="tooltip">
											<span><?= display_icon('tool_tip_circle','','17px','')?></span>
  											<span class="tooltiptext">Example: for Indian state maharastra code is IN-MH. Find ISO code from <a class="underline bold" href="https://www.iso.org/obp/ui" target="blank">here</a></span>
  										</div>
									</div>
									<input class="mb-2 p-3" type="text" name="state_code" value="<?= set_value('state_code') != null ?set_value('state_code') : $state['state_code']; ?>">
								</div>
							</div>
						</div>
						<div class="row px-child-1">
							<div class="col">
								<div class="form-element flex-col mt-0">
									<input class="btn-rect-rounded border-soft px-5" type="submit" name="submit" value="Edit">
								</div>
							</div>
						</div>
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!--end of the div stared in header.php-->
</div>