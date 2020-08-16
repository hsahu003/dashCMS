<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/*
short code for accessing images
 
prduct image.
*/
function product_img_url($image,$size='',$link=Null){

	$product_img_url =  site_url('assets/images/products/' . $image);

	if ($link !== NULL) {
		//outputs img tag wrapped in a tag with link passed
		echo '<a href="'.$link.'"><img style="width:'. $size .';" src="'. $product_img_url .'"></a>';
	}else{
		//output only image with img tag
		echo '<img style="width:'. $size .';" src="'. $product_img_url .'">';
	}
}



 ?>