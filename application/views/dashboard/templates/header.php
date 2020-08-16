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
						Dash User
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
						<?= display_icon('notification_icon_black',true,'20px','')?>
					</div>
					<div class="col flex ml-3">
						<?= display_icon('home_icon_black',true,'20px',base_url())?>
					</div>
					<div class="col flex ml-3">
						<?= display_icon('setting_icon_black',true,'20px',site_url('dashboard/settings'))?>
					</div>
				</div>
			</div>
		</div>
	</nav>

	<div class="container flex space-between position-relative">
		<div class="container unselectable dashborad-navigation-container">
			<div class="container">
				<div class="row module-name flex pointer space-between">
					<div class="col"><i class="fas fa-file mr-2"></i>News</div>
					<div class="col flex flex module-expand-btn"><i class="fas fa-chevron-right"></i></div>
				</div>
				<div class="row flex-col flex-start-x feature-name-container">
					<div class="col flex space-between feature-name">
						<span class="hover-over">Publish News</span>
						<span><i class="fas fa-circle"></i></span>
					</div>
					<div class="col feature-name">All Posts</div>
				</div>
			</div>
			<div class="container">
				<div class="row module-name flex pointer space-between">
					<div class="col"><i class="fas fa-question-circle mr-2"></i>Customer Queries</div>
					<div class="col flex module-expand-btn"><i class="fas fa-chevron-right"></i></div>
				</div>
				<div class="row flex-col flex-start-x feature-name-container">
					<div class="col feature-name">feature1</div>
					<div class="col feature-name">feature2</div>
					<div class="col feature-name">feature1</div>
					<div class="col feature-name">feature2</div>
				</div>
			</div>
			<div class="container">
				<div class="row module-name flex pointer space-between">
					<div class="col"><i class="fab fa-microblog mr-2"></i>Blogs</div>
					<div class="col flex module-expand-btn"><i class="fas fa-chevron-right"></i></div>
				</div>
				<div class="row flex-col flex-start-x feature-name-container">
					<div class="col feature-name">feature1</div>
					<div class="col feature-name">feature2</div>
					<div class="col feature-name">feature1</div>
					<div class="col feature-name">feature2</div>
				</div>
			</div>
			<div class="container ">
				<div class="row module-name flex pointer space-between">
					<div class="col"><i class="fas fa-chart-line mr-2"></i>Analytics</div>
				</div>
			</div>
			<div class="container ">
				<div class="row module-name flex pointer space-between">
					<div class="col"><i class="fas fa-solar-panel mr-2"></i>Projects</div>
				</div>
			</div>
			<div class="container ">
				<div class="row module-name flex pointer space-between">
					<div class="col"><i class="fas fa-star mr-2"></i>Customer Review</div>
				</div>
			</div>
			<div class="container ">
				<div class="row module-name flex pointer space-between">
					<div class="col"><i class="fas fa-headset mr-2"></i>Developer Support</div>
				</div>
			</div>
			<div class="container ">
				<div class="row module-name flex pointer space-between">
					<div class="col">Careers</div>
				</div>
			</div>
		</div>
