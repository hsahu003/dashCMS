<?php 	
defined('BASEPATH') OR exit('No direct script access allowed');
 ?><!--Continuing from views/dashboard/templated/header.php-->
<div class="text">
	
</div>
		<div class="container dashborad-working-area">	
			<div class="container m-4 p-4 border-radius-2 nested-dashboard-working-area">
				<div class="font-size-4p5 font-weight-5 mb-2 f-color-3">
					Settings
				</div>
				<div class="row flex-col dashboard-widget-container">
					<div class="row flex width-100 space-between">
						<div class="col space-between dashboard-widget">
							<div class="border-radius-top-2 p-3 width-100 border-b font-size-4">
								Admins
							</div>
							<div class="dashboard-widget-controls">
								<div class="container">
									<div class="row">
										<a href="<?= site_url('dashboard/settings/admin/view'); ?>">
											<div class="col btn-rect-rounded mr-2 border-soft">
												View Admins
											</div>
										</a>

										<a href="<?= site_url('dashboard/settings/admin/add'); ?>">
											<div class="col btn-rect-rounded mr-2 border-soft">
												Add New
											</div>
										</a>
									</div>
								</div>
							</div>
						</div>

						<div class="col space-between dashboard-widget">
							<div class="border-radius-top-2 p-3 width-100 border-b font-size-4">
								Admins
							</div>
						</div>

					</div>
					<div class="row flex width-100 space-between align-items-y">
						
					</div>
				</div>
			</div>
		</div>
</div>