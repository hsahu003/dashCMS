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
					Location Settings
				</div>
				<div class="row dashboard-widget-container align-items-y">
					<div class="col ds-col-6 dashboard-widget">
						<div class="container">
							<div class="row align-items-x-start flex border-b">
								<div class="col">
									<div class="border-radius-top-2 p-3 width-100 border-b">
										Add New Location
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
						
							<div class="dashboard-widget-controls p-4">
								<div class="container">
								<div class="row">
										<a href="<?= site_url('dashboard/shop-setting/location/add/country'); ?>">
										<div class="col btn-rect-rounded mr-2 border-soft">
											Add New Country
										</div>
										</a>
										<a href="<?= site_url('dashboard/shop-setting/location/add/state'); ?>">
										<div class="col btn-rect-rounded mr-2 border-soft">
											Add New State
										</div>
										</a>
								</div>
							</div>
						</div>
					</div>
				<div class="col ds-col-6 dashboard-widget">
					<div class="container">
						<div class="row align-items-x-start flex border-b">
							<div class="col">
								<div class="border-radius-top-2 p-3 width-100">
									View Locations
								</div>
							</div>
							<div class="col">
								<div class="tooltip">
									<span><?= display_icon('tool_tip_circle','','17px','')?></span>
										<span class="tooltiptext">Tooltip text</span>
								</div>
							</div>
						</div>
						<div class="dashboard-widget-controls p-4">
							<div class="container">
								<div class="row">
									<a href="<?= site_url('dashboard/shop-setting/location/view/country'); ?>">
										<div class="col btn-rect-rounded mr-2 border-soft">
											View Countries
										</div>
									</a>
									<a href="<?= site_url('dashboard/shop-setting/location/view/state'); ?>">
									<div class="col btn-rect-rounded mr-2 border-soft">
										View States
									</div>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
</div>