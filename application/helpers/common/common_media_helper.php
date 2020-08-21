<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

// Displays logo
function display_logo($color = '', $size = '', $logoLink = '' ) {
	//default argument for this function
	if ($color == '') {
		$color = 'color';
	}

	if ($size == '') {
	 	$size = '100%';
	}

	if ($logoLink == '') {
		$logoLink = base_url();
	}

	//generating dynamic link for logo as per the color
	$logoSrc =  base_url() . 'assets/images/logo.' .  $color . '.svg';


	/* default logo file to avoid any error in case wrong argument is passed.

	Note: file_exists() does not work with HTTP addresses, It only supports 
	filesystem paths, therefor $_SERVER['DOCUMENT_ROOT'] has been used.
	*/
	if (file_exists($_SERVER['DOCUMENT_ROOT'].$logoSrc) == false ) {
	 	$logoSrc = base_url() . 'assets/images/logo.color.svg';
	}

	echo '<a href="' . $logoLink . '"><img style="width:'. $size . ';"' .' src="' . $logoSrc . '" class="style-logo" alt="' . $GLOBALS['site_name'] . ' logo' . '" title="' . $GLOBALS['site_name'] . '"></a>';
}


function display_img($image,$sub_folder='',$withNoImgTag=false,$size='',$link=''){

	$img_path = site_url('assets/images/'.$sub_folder. '/'. $image);
	
	if ($withNoImgTag == true) {
		if ($link !== '') {
			//outputs img tag wrapped in a tag with link passed
			echo '<a href="'.$link.'"><img style="width:'. $size .';" src="'. $img_path .'"></a>';
		}else{
			//output only image with img tag
			echo '<img style="width:'. $size .';" src="'. $img_path .'">';
		}
	}else{
		echo $img_path;
	}
}

/*leave $admins_folder '' if image is not there while implementing this function*/
function display_icon($icon,$admins_folder='',$size='100%',$link=''){
	if (substr($icon, -4,4) == '.svg') {
		$icon = str_replace(".svg","",$icon);
	}

	if ($admins_folder!='') {
		$admins_folder = '/' . $admins_folder;
	}else{
		$admins_folder = '/' . $GLOBALS['dashboard_image_folder'];
	}

	$icon_path = site_url('assets/images'. $admins_folder .'/icons/' . $icon . '.svg');

	if ($link !== '') {
		//outputs img tag wrapped in a tag with link passed
		echo '<a href="'.$link.'"><img style="width:'. $size .';" src="'. $icon_path .'"></a>';
	}else{
		//output only image with img tag
		echo '<img style="width:'. $size .';" src="'. $icon_path .'">';
	}
}