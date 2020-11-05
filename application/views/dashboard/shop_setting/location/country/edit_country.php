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
		Edit Country
	</div>
	<div class="row flex-col dashboard-widget-container align-items-y">
		<div class="col ds-col-6 dashboard-widget">
			<div class="container">
				<div class="row align-items-x-start flex border-b">
					<div class="col">
						<div class="border-radius-top-2 p-3 width-100">
							Edit Country
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
				
				<?=form_open('dashboard/shop-setting/location/edit/country/'.$country['country_id'],'')?>
				<div class="dashboard-widget-controls p-4">
					<div class="container">
						<div class="row ds-row-cols-12 flex px-child-1 space-between mb-child-3">
							<!--country name-->
							<div class="col">
								<div class="form-element flex-col mr-4 mt-0">
									<label class="width-100 px-2">Country Name</label>
									<!-- <input class="mb-2 p-3" type="text" name="country_name" value="<?= $country['country'] ?>"> -->
									<input class="mb-2 p-3" type="text" name="country_name" value="<?= set_value('country_name') != null ?set_value('country_name') : $country['country']; ?>">
								</div>
							</div>
							<!--country code-->
							<div class="col">
								<div class="form-element flex-col mr-4 mt-0">
									<div class="flex width-100 space-between px-2">
										<label>ISO country code</label>
										<div class="tooltip">
											<span><?= display_icon('tool_tip_circle','','17px','')?></span>
  											<span class="tooltiptext">Eneter 2 characters long ISO country code. Example: for India code is IN. Find ISO code from <a class="underline bold" href="https://www.countrycode.org" target="blank">here</a></span>
  										</div>
									</div> 
									<input class="mb-2 p-3" type="text" name="country_code" value="<?= set_value('country_code') != null ?set_value('country_code') : $country['country_code']; ?>">
								</div>
							</div>
							<!--currency code-->
							<div class="col">
								<div class="form-element flex-col mr-4 mt-0">
									<div class="flex width-100 space-between px-2">
										<label>Currency code</label>
										<div class="tooltip">
											<span><?= display_icon('tool_tip_circle','','17px','')?></span>
  											<span class="tooltiptext">Enter 3 characters long ISO currency code. Example: for India code is INR.
  											Find code from <a class="underline bold" href="https://www.xe.com/symbols.php" target="blank">here</a></span>
										</div>
									</div>
									<input class="mb-2 p-3" type="text" name="currency_code" value="<?= set_value('currency_code') != null ?set_value('currency_code') : $country['currency_code']; ?>">
								</div>
							</div>
							<!--country symbol-->
							<div class="col">
								<div class="form-element flex-col mr-4 mt-0">
									<div class="flex width-100 space-between px-2">
										<label>Currency Symbol</label>
										<div class="tooltip">
											<span><?= display_icon('tool_tip_circle','','17px','')?></span>
  											<span class="tooltiptext">Example: for India symbol is INR.
  											Find code from <a class="underline bold" href="https://www.xe.com/symbols.php" target="blank">here</a></span>
  										</div>
									</div>
									<input class="mb-2 p-3" type="text" name="currency_symbol" value="<?= set_value('currency_symbol') != null ?set_value('currency_symbol') : $country['currency_symbol']; ?>">
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