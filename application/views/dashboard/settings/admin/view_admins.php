<?php 	
defined('BASEPATH') OR exit('No direct script access allowed');
 ?><!--Continuing from views/dashboard/templated/header.php-->
<div class="text">
	
</div>
		<div class="container dashborad-working-area">
			<div class="error-display-container">
				<div class="container m-4 border-radius-2 error-container">
					
				</div>
			</div>
			<div class="container m-4 p-4 border-radius-2 nested-dashboard-working-area">
				<div class="font-size-4p5 font-weight-5 mb-2 f-color-3">
					<?= ucfirst($sortby); ?>
				</div>
				<div class="row flex-col dashboard-widget-container">
					<div class="row flex width-100 space-between align-items-y">
						<div class="col space-between dashboard-widget">
							<div class="border-radius-top-2 p-3 width-100 border-b">
								Admins (<?= $total_user?>)
							</div>
							<div class="dashboard-widget-controls pb-4">
								<div class="container">
									
									<div class="row unselectable flex space-between">
										<div class="col flex">
											<?php if($filterKey == 'status' && $filterValue == '1'): ?>
											<div onclick="disable_admin()" class="col btn-rect-rounded px-4 danger-100">
												<i class="fas fa-trash mr-1"></i>Disable Admin
											</div>
											<a href="<?= site_url('dashboard/settings/admin/add'); ?>">
											<div class="col btn-rect-rounded px-4 success-100 ml-2">
												<i class="fas fa-plus mr-1"></i></i>Add New
											</div>
											</a>
											<?php elseif($filterKey == 'status' && $filterValue == '0'): ?>
												<div onclick="re_enable_admin()" class="col btn-rect-rounded px-4 success-100">
												</i>Enable Admin
											</div>
											<?php else: ?>
											<a href="<?= site_url('dashboard/settings/admin/add'); ?>">
											<div class="col btn-rect-rounded px-4 success-100 ml-2">
											<i class="fas fa-plus mr-1"></i></i>Add New
											</div>
											</a>
											<?php endif ?>
										</div>
										<div class="col">
											<select onchange="sort_admins(this)">
												<option value="">Sort Admins</option>
												<option value="all">All</option>
												<option value="status/0">Disabled</option>
												<option value="status/1">Active</option>
												<option value="superadmin/1">Super Admins</option>
											</select>
										</div>
										
									</div>
									
									<div class="row mt-4">
										<div class="col width-100">
											<table>	
													<tr>
														<th></th>
														<th>ID</th>
														<th>Name</th>
														<th>Username</th>
														<th>Email</th>
														<th>Role</th>
														<th>Status</th>
														<th>Last logged</th>
														<th>Added</th>
													</tr>
													<?php $index = 0; foreach($users as $user): $index++ ?>
													<tr>
														<td><input type="checkbox" name="select" class="admin-selected" data-UID="<?= $user->ID ?>"></td>	
														<td><?= $index ?></td>
														<td><img src="<?= null !== $user->user_image ? base_url($user->user_image) : display_img('user_icon.svg','icons') ?>"><?= $user->firstName?></td>
														<td><?= $user->username ?></td>
														<td><?= $user->email ?></td>
														<td><?= $user->role ?></td>
														<td><?= $user->status == 1 ?'Active':'Disabled'; ?></td>
														<td><?= date('d-M-y', strtotime($user->lastLogin)) ?></td>
														<td><?= date('d-M-y', strtotime($user->dateCreated)) ?></td>

													</tr>
													<?php endforeach ?>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row flex width-100 space-between align-items-y">
						
					</div>
				</div>
			</div>
		</div>
</div>