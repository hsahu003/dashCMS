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
					Edit Admin
					<?php print_r($admin['firstName']) ; ?>
				</div>
				<div class="row flex-col dashboard-widget-container">
					<div class="row flex width-100 space-between align-items-y-start">
						<?=form_open('dashboard/settings/admin/edit',array('class' => 'width-100 flex align-items-y-start'),array('user_image' => 0))?>
						<div style="flex: 1.5" class="col space-between dashboard-widget shadow-none">
							<div class="border-radius-top-2 p-3 width-100 border-b">
								Admin Details
							</div>
							<div class="dashboard-widget-controls p-4">
								<div class="container">
									<div class="row">
										<div class="col width-100 flex-col">
				 							<div class="container width-100">
												<div class="row">
													<div class="col flex width-100">
														<div class="form-element flex-col mr-4">
															<label>First Name</label>
															<input class="mb-2 p-3" type="text" name="firstname" value="<?= $admin['firstName']?>">
														</div>
														<div class="form-element flex-col">
															<label>Last Name</label>
															<input class="mb-2 p-3" type="text" name="lastname" value="<?= $admin['lastName']?>">
											    		</div>
													</div>
												</div>

												<div class="row">
													<div class="col flex width-100">
														<div class="form-element flex-col mr-4">
															<label>Username</label>
															<input class="mb-2 p-3" type="text" name="username" value="<?= $admin['username']?>">
														</div>
														<div class="form-element flex-col">
															<label>Email</label>
															<input class="mb-2 p-3" type="text" name="email"
															 value="<?= $admin['email']?>">
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col flex width-100">
														<div class="form-element flex-col mr-4">
															<label><b>New Password</b></label>
															<input class="mb-2 p-3" type="password" name="password">
														</div>
														<div class="form-element flex-col">
															<label><b>Confirm New Password</b></label>
															<input class="mb-2 p-3" type="password" name="passwordConfirmed">
														</div>
													</div>
												</div>
											</div>
											<div class="form-element flex-col">
												<label>Role</label>
												<select class="p-3" name="role">
													<option value="<?= $admin['role']?>"><?= $roleDesc; ?></option>
													<option value="visitor">Viewer (can view only)</option>
													<option value="editor">Editor (can add and edit content | cannot: manage admins, edit the settings)</option>
													<option value="moderator">Moderator (can add, edit and delete content, edit some settings | cannot: manage admins)</option>
													<option value="admin">Super Admin (cannot disable super admin account)</option>
												</select>
											</div>

											<div class="form-element flex-col">
												<label>Account Status</label>
												<select class="p-3" name="status">
													<option value="1">Active</option>
													<option value="0">Disable</option>
												</select>
											</div>

											<div class="form-element align-items-x-start mt-4">
												<input class="btn-rect-rounded border-soft px-5" type="submit" name="submit" value="Add Admin">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="col space-between dashboard-widget shadow-none">
							<div class="border-radius-top-2 p-3 width-100 border-b">
								Admin Image
							</div>
							<div class="dashboard-widget-controls pb-4">
								<?= add_image_btn(false,'user_image');?> 
							</div>
						</div>
						</form>
					</div>
					<div class="row flex width-100 space-between align-items-y">
						<!-- <?php 
						print_r($array);
						?> -->
					</div>
				</div>
			</div>
		</div>
</div>