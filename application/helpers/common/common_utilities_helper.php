<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//converts the separated by commas string into array
function if_str_thn_arr($data)
{
	if(is_string($data))
	{
		$data = explode(',', $data);
	}
	return $data;
}


function add_image_btn($multi_image=false,$input_field_name){
	//generates html for add image button
	if ($multi_image == true) {
		$image_btn = 'multiple-image-button';
	}else{
		$image_btn = 'single-image-button';
	}
	?>
	<div class="add-image-button border-soft flex <?= $image_btn?>">
		<label class="add-image-btn-label border-none height-100 btn-rect-rounded color-none">
			<img class="add-image-icon" src="<?= display_img('add_icon.svg','admins/icons',false,'25px')?>">
			<input type="file" data-url='ajax/add-image' class="common-image-input" id="file" name="file">
			<input type="hidden" name="<?= $input_field_name; ?>" value="" class="ajax_image_return">
		</label>

		<div class="image-uploded">
			<img style="width: 100%" src="">
			<div class="common-remove-image-button flex">
				<img class="remove-image-icon" src="<?= display_img('add_icon.svg','admins/icons',false,'25px')?>">
			</div>
		</div>
	</div>
	<?php
}

function add_head_admin(){
 	?>
 	<!-- Style sheets-->
	<link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/css/common/common_style.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/css/common/common_dashboard_style.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/css/special/special_dashboard_style.css">
	<!-- Header javascripts -->
  	<script type="text/javascript" src="<?= base_url();?>assets/js/common_main_header.js"></script>
  	<script type="text/javascript" src="<?= base_url();?>assets/js/header.js"></script>
	<!--Font Awesome-->
	<script src="https://kit.fontawesome.com/6ba12bffe8.js" crossorigin="anonymous"></script>
	<!--Tiny MCE-->
	<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
 	<?php
}

function add_foot_admin(){
	?>
		<script type="text/javascript" src="<?= base_url();?>assets/js/common_main.js"></script>
		<script type="text/javascript" src="<?= base_url();?>assets/js/common_dashboard_main.js"></script>
	<?php
}
?>