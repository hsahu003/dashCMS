<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
<head>
	<title><?= isset($title)?$title:$GLOBALS['dashboard_default_title']?></title>
	<?php add_head_admin(); ?>
	
</head>
<body>
	<nav class="navbar unselectable">
		<div class="navbar_container flex space-between">
			<div class="container ml-3">
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

			<div class="container flex mr-3">
				<div class="row flex">
					<div class="col admin_img flex mr-2">
						<img src="<?= display_img('dash-user.png')?>">
					</div>
					<div class="col flex mr-4">
						<?= $this->session->firstName.' '.$this->session->lastName; ?>
					</div>
					<div class="col btn-rect-rounded border-none mr-2">
						<a href="<?= site_url('dashboard/logout');?>">
							Logout
						</a>
						
					</div>
					<div class="col btn-rect-rounded border-none mr-2">
						My Account
					</div>
				</div>
				<div class="row">
					<div class="col flex ml-3">
						<?= display_icon('notification_icon_black','admins','20px','')?>
					</div>
					<div class="col flex ml-3">
						<?= display_icon('home_icon_black','admins','20px',base_url())?>
					</div>
					<div class="col flex ml-3">
						<?= display_icon('setting_icon_black','admins','20px',site_url('dashboard/settings'))?>
					</div>
				</div>
			</div>
		</div>
	</nav>

	<div class="container flex space-between position-relative">
		<div class="container unselectable dashborad-navigation-container">
			<!--shop menu-->
			<div class="container">
				<div class="row module-name flex pointer space-between">
					<div class="col"><i class="fas fa-store mr-2"></i></i>Shop</div>
					<div class="col flex module-expand-btn"><i class="fas fa-chevron-right"></i></div>
				</div>
				<div class="row flex-col flex-start-x feature-name-container">
					<div class="col flex space-between feature-name">
						<a href="#">
							<span class="hover-over">Orders</span>
						</a>
					</div>
					<div class="col flex space-between feature-name">
						<a href="#">
							<span class="hover-over">Customers</span>
						</a>
					</div>
				</div>
			</div>
			<!--products menu-->
			<div class="container">
				<div class="row module-name flex pointer space-between">
					<div class="col"><i class="fas fa-boxes mr-2"></i>Products</div>
					<div class="col flex flex module-expand-btn"><i class="fas fa-chevron-right"></i></div>
				</div>
				<div class="row flex-col flex-start-x feature-name-container">
					<div class="col flex space-between feature-name">
						<a href="<?= site_url('dashboard/product/view-all');?>">
							<span class="hover-over">All Products</span>
						</a>
					</div>
					<div class="col feature-name">
						<a href="<?= site_url('dashboard/product/add');?>">
							<span class="hover-over">Add New</span>
						</a>
					</div>
					<div class="col flex space-between feature-name">
						<a href="<?= site_url('dashboard/product/category');?>">
							<span class="hover-over">Categories</span>
						</a>
					</div>
					<!-- <div class="col flex space-between feature-name">
						<a href="#">
							<span class="hover-over">Attributes</span>
						</a>
					</div> -->
				</div>
			</div>
			<!--Shop Settings-->
			<div class="container">
				<div class="row module-name flex pointer space-between">
					<div class="col"><i class="fas fa-sliders-h mr-2"></i>Shop Settings</div>
					<div class="col flex module-expand-btn"><i class="fas fa-chevron-right"></i></div>
				</div>
				<div class="row flex-col flex-start-x feature-name-container">
					<div class="col flex space-between feature-name">
						<a href="<?= site_url('dashboard/shop-setting/location');?>">
							<span class="hover-over">Locations</span>
						</a>
					</div>
					<div class="col flex space-between feature-name">
						<a href="<?= site_url('dashboard/shop-setting/shipping');?>">
							<span class="hover-over">Shippings</span>
						</a>
					</div>
					<div class="col flex space-between feature-name">
						<a href="<?= site_url('dashboard/shop-setting/coupon');?>">
							<span class="hover-over">Coupons</span>
						</a>
					</div>
				</div>
			</div>

			<!--Media menu-->
			<div class="container">
				<div class="row module-name flex pointer space-between">
					<div class="col"><i class="fa fa-picture-o mr-2 font-weight-700000"></i>Media</div>
					<div class="col flex module-expand-btn"><i class="fas fa-chevron-right"></i></div>
				</div>
				<div class="row flex-col flex-start-x feature-name-container">
					<div class="col feature-name">
						<a href="<?= site_url('dashboard/media/folder/0/add');?>">
							<span class="hover-over">Library</span>
						</a>
					</div>
					<div class="col feature-name">
						<a href="<?= site_url('dashboard/media/settings');?>">
							<span class="hover-over">Settings</span>
						</a>
					</div>
				</div>
			</div>
			<!--Blogs-->
			<div class="container">
				<div class="row module-name flex pointer space-between">
					<div class="col"><i class="far fa-newspaper mr-2"></i>Blogs</div>
					<div class="col flex module-expand-btn"><i class="fas fa-chevron-right"></i></div>
				</div>
				<div class="row flex-col flex-start-x feature-name-container">
					<div class="col feature-name">Coming Soon...</div>
				</div>
			</div>
			<!--Analytics-->
			<div class="container ">
				<div class="row module-name flex pointer space-between">
					<div class="col"><i class="fas fa-chart-line mr-2"></i>Analytics</div>
					<div class="col flex module-expand-btn"><i class="fas fa-chevron-right"></i></div>
				</div>
				<div class="row flex-col flex-start-x feature-name-container">
					<div class="col feature-name">Coming Soon...</div>
				</div>
			</div>
			<div class="container ">
				<div class="row module-name flex pointer space-between">
					<div class="col"><i class="fas fa-headset mr-2"></i>Developer Support</div>
					<div class="col flex module-expand-btn"><i class="fas fa-chevron-right"></i></div>
				</div>
				<div class="row flex-col flex-start-x feature-name-container">
					<div class="col feature-name">Coming Soon...</div>
				</div>
			</div>
		</div>
