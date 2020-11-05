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
		<!-- <div class="container m-4 p-4 border-radius-2 nested-dashboard-working-area">
			<div class="container">
				<div class="row flex-col align-items-y">
					<div class="col" id="positive_quote">
						Quote loading...
					</div>
					<div class="col mt-2" id="positive_author">
						Author
					</div>
				</div>
			</div>
		</div> -->
		<div class="container m-4 p-4 border-radius-2 nested-dashboard-working-area">
			<div class="container">
				<div class="row flex align-items-y">
					<div class="col">
						Welcome to Dash | Admins
					</div>
				</div>
			</div>
		</div>
	</div>
</div>