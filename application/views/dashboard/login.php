<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
<head>
	<title><?= isset($title)?$title:$GLOBALS['dashboard_default_title'].' '.'Login'?></title>
	<?php add_head_admin(); ?>
</head>
<body>
	<section class="height-100-vh admin-background-color">
		<div class="container-ctr flex">
			<div class="container width-100">
				<div class="row flex-col">
					<div class="col mb-3">
						<div class="row flex">
							<div class="col">
								<?= display_logo('white','130px', site_url('dashboard'));?>	
							</div>
							<div class="col mx-2 vertical-line-extra-thin gray-60">
								
							</div>
							<div class="col flex">
								<?= display_img('admins-1.0-logo-white.svg','admins',true,'135px','');?>
							</div>
						</div>
					</div>
					<div class="col width-100 col-3">
						<?php if(isset($execute)):?>
							<div class="error-display-container">
								<div class="container mb-4 border-radius-2 error-container">
									<?=$message?>
								</div>
							</div>
						<?php endif?>
					</div>
					<div class="col-3 white p-4 shadow-softer border-radius-2 width-100">
						<?=form_open('dashboard/login','')?>
							<div class="row">	
								<div class="col width-100">
									<div class="form-element flex-col">
										<label>Email/Username</label>
										<input class="mb-2 p-3 font-size-3" type="text" name="username" value="">
									</div>	
								</div>
								<div class="col width-100">
									<div class="form-element flex-col">
										<label>Password</label>
										<input class="mb-2 p-3 font-size-3" id="password" type="password" name="password" value="">
									</div>	
								</div>
								<!-- <div class="col width-100 unselectable">
									<div class="row space-between"> 	
										<div class="col flex">	
											<input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
											<small class="font-size-2p5 ml-1 f-gray-60">Remeber me</small>
										</div>
										<div class="col">
											<small class="font-size-2p5 ml-1 f-gray-60">Forgot Password?</small>
										</div>
									</div>
								</div> -->
								<div class="col width-100 mt-4">
									<div class="form-element">
										<input class="btn-rect-rounded py-3 px-5 width-100 f-white gray-70" type="submit" name="submit" value="Login">
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
		
	</div>
	<?php add_foot_admin(); ?>
</body>
</html>