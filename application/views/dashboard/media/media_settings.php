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
					Media Settings
				</div>
				<div class="row flex-col dashboard-widget-container align-items-y">
					<div class="col ds-col-6 dashboard-widget">
						<div class="border-radius-top-2 p-3 width-100 border-b">
							Settings
						</div>
							<div class="dashboard-widget-controls p-4">
								<div class="container">
								<div class="row">
										<a href="<?= site_url('dashboard/media/settings/add-category'); ?>">
										<div class="col btn-rect-rounded mr-2 border-soft">
											Add a Media Category
										</div>
										</a>
								</div>
							</div>
					</div>
				</div>
			</div>
		</div>
</div>