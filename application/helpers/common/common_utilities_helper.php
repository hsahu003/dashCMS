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


function add_image_btn($multi_image=false){
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
			<input type="hidden" name="image_id" value="" class="ajax_image_id_return">
			<input type="hidden" name="image_path" id="image_path" value="" class="ajax_image_return">
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
/*
*	$load_this_images = array of image ids to pre load (pre select) the respective images 
*/
function add_set_image_btn($container_heading,$class_names_for_most_outer_div=null,$sigle_image=false,$input_field_name,$tooltip_text=null,$load_this_images=null){
	if (!isset($tooltip_text)) {
		$tooltip_text = 'Tooltip text';
	}
	if (!isset($class_names_for_most_outer_div)) {
		$class_names_for_most_outer_div	= 'ds-col-6';
	}
	//disable multiple image select
	if ($sigle_image == true) {
		$sigle_image = '1';
	}else{
		$sigle_image = '0';
	}
	?>
		<div class="col dashboard-widget set-image-dash-widget <?= $class_names_for_most_outer_div ?>" data-sigle-image="<?= $sigle_image?>">
			<div class="container">
				<div class="row flex border-b space-between">
					<div class="col">
						<div class="container">
							<div class="row align-items-y-center">
								<div class="col">
									<div class="border-radius-top-2 p-3 width-100">
										<?= $container_heading; ?>
									</div>
								</div>
								<div class="col">
									<div class="tooltip">
										<span><?= display_icon('tool_tip_circle','','17px','')?></span>
											<span class="tooltiptext"><?= $tooltip_text; ?></span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col px-3">
						<div class="set-image-data-container">
							<div class="btn-rect-rounded set-image-btn">
								Add Image
							</div>
							<!--
							input form will get appended here
							-->
						</div>
					</div>
				</div>
				<!--Dashboard widget controls-->
				<div class="dashboard-widget-controls">
					<div class="container">
						<div class="row">
							<div class="col">
								<input type="hidden" name="<?= $input_field_name; ?>" class="input-set-image-id-field" value="">
							</div>
						</div>
						<div class="row selected-image-on-widget-control-row">
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--By Default hidden media modal-->
		<div style="visibility: hidden" class="hidden-set-image-modal-container">
			<div class="hidden-set-image-modal border-radius-1 my-3 px-child-3">
				<div class="container">
					<!--modal header-->
					<div class="row space-between p-4 align-items-y-center">
						<div class="col">
							Select Image
						</div>
						<div class="col pointer close-set-modal-icon">
							<?= display_icon('times-solid','','10px','')?>
						</div>
					</div>
					<div class="horizontal-line-extra-thin"></div>
					<!--Error-->
					<div class="row">
						<div class="error-display-container error-display-container-set-image-modal">
							<div id="error-container-set-image-modal" class="container m-4 border-radius-2 error-container width-auto">
							</div>
						</div>
					</div>
					<!---->
					<div class="row p-4 pb-3">
						<div class="container width-100 fn_image_container">
							<div class="row white p-2 white border-radius-2 unselectable fn_image_row">
									<!--here populates the image col-->
							</div>
						</div>
					</div>
					<div class="row px-4 align-items-x-end">
						<div class="col">
							<div class="btn-rect-rounded f-white bg-blue-primary px-5 set-image-btn-select">
								Select
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php
}

function add_set_image_btn_script_style()
{
	?>
	<!--js code-->
	<script type="text/javascript">
		/*-------------------------------------------------------------------*/
		var set_image_dash_widget = document.getElementsByClassName('set-image-dash-widget');
		var set_image_btn = document.getElementsByClassName('set-image-btn');
		var hidden_set_image_modal_container = document.getElementsByClassName('hidden-set-image-modal-container');
		var close_set_modal_icon = document.getElementsByClassName('close-set-modal-icon');
		var fn_image_row = document.getElementsByClassName('fn_image_row');
		var fn_image_container = document.getElementsByClassName('fn_image_container');
		var set_image_btn_select = document.getElementsByClassName('set-image-btn-select');
		var input_set_image_id_field = document.getElementsByClassName('input-set-image-id-field');
		var selected_image_on_widget_control_row = document.getElementsByClassName('selected-image-on-widget-control-row');
		var image_on_modal_col =  document.getElementsByClassName('image-on-modal-col');

		function grp_add_event_set_image(className,eventType,eventFun,reset=false)
		{
		    if (typeof className == 'string') {
		        className = document.getElementsByClassName(className)
		    }
		    for(var i = 0; i < className.length; i++){
		        if (reset==true) {
		            className[i].addEventListener(eventType,eventFun.bind(this,i),false);
		        }
		        //check if already added the event listener
		        else if (className[i].getAttribute('listener') == 'true') {
		        //then do nothing
		        }else{
		            className[i].addEventListener(eventType,eventFun.bind(this,i),false);
		            className[i].setAttribute('listener', 'true');
		        }
		        
		    }
		}

		function open_set_media_modal(i,e){

			hidden_set_image_modal_container[i].style.display = 'flex';
			hidden_set_image_modal_container[i].style.visibility = 'visible';

			if (e.target.set_image_btn_first_click == undefined) {
				set_image_btn_first_click = false
			}else{
				set_image_btn_first_click = e.target.set_image_btn_first_click
			}

			//check whether only single image is allowed
			if(set_image_dash_widget[i].getAttribute('data-sigle-image') == '1'){
				var data_sigle_image_on_individual_image = '1'
			}else{
				var data_sigle_image_on_individual_image = '0'
			}
			

			//restrict to fetch initial image data again and again every time btn is clicked
			if (set_image_btn_first_click==false) {
				//populate initial images
				var url = site_url('commons/common/ajax-get-rows');
				var data = {table:'media',
							columns:'*',
							attributes: null,
							limit: 80,
							offset: 0,
							filter_keys_and_values: {'user_type':'admin'},
							orders: {'media_id':'desc'},
						};
				data = "data="+JSON.stringify(data);
				ajax({
					url: url,
					data: data,
					type: 'POST',
					onSuccess: function(return_data){
						return_data = JSON.parse(return_data);
						console.log(return_data);
						for (var j = 0; j < return_data.length; j++) {
                		// media_data.push(return_data[j])
                		var div = document.createElement('div');
                		div.className = 'col individual_media_content_container image-on-modal-col flex';
                		div.setAttribute('data-image-id',return_data[j].media_id);
                		div.setAttribute('data-sigle-image-on-image',data_sigle_image_on_individual_image);
                		div.setAttribute('data-image-path',return_data[j].media_path);
                		div.setAttribute('data-array-id',i);
                		div.setAttribute('onclick','select_image(this)');
                		var img_tag = document.createElement('img');
                		var media_ext = return_data[j].media_path.split('.').pop();
                		var media_path = return_data[j].media_path.split('.')[0]+'_thumb.' + media_ext;
                		img_tag.src = site_url(media_path,false);
                		div.append(img_tag);
                		fn_image_row[i].append(div);
                	}
					}
				})
				//bth clicked for the first time
				e.target.set_image_btn_first_click = true;
			}
			
		}

		//load more image on scroll

		function load_more_on_scroll(i,e){
			var container_height = fn_image_container[i].offsetHeight;
			var initial_row_height = fn_image_row[i].offsetHeight;
			var scrollTop = fn_image_row[i].scrollTop;
			var scrollHeight = fn_image_row[i].scrollHeight;

			if (e.target.fetch_data_exhausted == undefined) {
				fetch_data_exhausted = false
			}else{
				fetch_data_exhausted = e.target.fetch_data_exhausted
			}

			if (e.target.offset == undefined) {
				offset = 80
			}else{
				offset = e.target.offset
			}

			//check whether only single image is allowed
			if(set_image_dash_widget[i].getAttribute('data-sigle-image') == '1'){
				var data_sigle_image_on_individual_image = '1'
			}else{
				var data_sigle_image_on_individual_image = '0'
			}

			if (initial_row_height + scrollTop == scrollHeight) {

				if (fetch_data_exhausted==false) {
					//populate further images
					var url = site_url('commons/common/ajax-get-rows');
					var data = {table:'media',
								columns:'*',
								attributes: null,
								limit: 50,
								offset: offset,
								filter_keys_and_values: {'user_type':'admin'},
								orders: {'media_id':'desc'},
							};
					data = "data="+JSON.stringify(data);
					ajax({
						url: url,
						data: data,
						type: 'POST',
						onSuccess: function(return_data){

							return_data = JSON.parse(return_data);
							if (return_data.length == 0) {
								e.target.fetch_data_exhausted = true;
							}
							// console.log(return_data);
							for (var j = 0; j < return_data.length; j++) {
	                		// media_data.push(return_data[j])
	                		var div = document.createElement('div');
	                		div.setAttribute('data-image-id',return_data[j].media_id);
	                		div.setAttribute('data-sigle-image-on-image',data_sigle_image_on_individual_image);
	                		div.setAttribute('data-image-path',return_data[j].media_path);
                			div.setAttribute('data-array-id',i);
	                		div.className = 'col individual_media_content_container image-on-modal-col flex'
	                		div.setAttribute('onclick','select_image(this)');
	                		var img_tag = document.createElement('img');
	                		var media_ext = return_data[j].media_path.split('.').pop();
	                		var media_path = return_data[j].media_path.split('.')[0]+'_thumb.' + media_ext;
	                		img_tag.src = site_url(media_path,false);
	                		div.append(img_tag);
	                		fn_image_row[i].append(div);
	                	}
						}
					})
					e.target.offset = offset + 50;
				}
				
			}
		}

		/*array to store image id (from db) of images selected from modal*/
		var array_for_set_image = [];
		for (var i = 0; i < set_image_btn.length; i++) {
			array_for_set_image[i] = []
		}

		var previous_array_for_set_image = []
		for (var i = 0; i < set_image_btn.length; i++) {
			previous_array_for_set_image[i] = []
		}

		function add_id_into_set_image_id_array(array_id,image_id){
			array_for_set_image[array_id].push(image_id);
		}

		function remove_id_from_set_image_id_array(array_id,image_id){
			var id_to_remove = array_for_set_image[array_id].indexOf(image_id);
			array_for_set_image[array_id].splice(id_to_remove,1);
		}

		/*array to store image path of images selected from modal*/
		var array_for_set_image_path = [];
		for (var i = 0; i < set_image_btn.length; i++) {
			array_for_set_image_path[i] = []
		}

		var previous_array_for_set_image_path = []
		for (var i = 0; i < set_image_btn.length; i++) {
			previous_array_for_set_image_path[i] = []
		}

		function add_path_into_set_image_path_array(array_id,path){
			array_for_set_image_path[array_id].push(path);
		}

		function remove_path_from_set_image_path_array(array_id,path){
			var path_to_remove = array_for_set_image_path[array_id].indexOf(path);
			array_for_set_image_path[array_id].splice(path_to_remove,1);
		}

		//fires when an image from modal is chicked
		var clicked_to_select_on_image = true;
		function select_image(filter){


			//get id of this image
			var image_id = filter.getAttribute('data-image-id');
			var array_id = filter.getAttribute('data-array-id');
			var image_path = filter.getAttribute('data-image-path');

			//allow only single image to be selected?
			if(filter.getAttribute('data-sigle-image-on-image')=='1'){
				//show selected icon on select
				if (clicked_to_select_on_image == true) {
					var selected_icon_img_tag = document.createElement('img');
					selected_icon_img_tag.className = "checked_icon";
					selected_icon_img_tag.src = site_url('assets/images/admins/icons/check_blue_bg_icon.svg');
					filter.appendChild(selected_icon_img_tag);
					filter.style.transform = 'scale(0.9)';
					clicked_to_select_on_image = false;
					//add id into array
					add_id_into_set_image_id_array(array_id,image_id);
					add_path_into_set_image_path_array(array_id,image_path);
				}else if(clicked_to_select_on_image == false){
					filter.childNodes[1].remove();
					filter.style.transform = 'scale(1)';
					clicked_to_select_on_image = true;
					//remove id from array
					remove_id_from_set_image_id_array(array_id,image_id);
					remove_path_from_set_image_path_array(array_id,image_path);
				}
			}else{
				if (filter.clicked_to_select_on_image == undefined) {
					filter.clicked_to_select_on_image = true
				}else{
					filter.clicked_to_select_on_image = filter.clicked_to_select_on_image
				}
				//show selected icon on select
				if (filter.clicked_to_select_on_image == true) {
					var selected_icon_img_tag = document.createElement('img');
					selected_icon_img_tag.className = "checked_icon";
					selected_icon_img_tag.src = site_url('assets/images/admins/icons/check_blue_bg_icon.svg');
					filter.appendChild(selected_icon_img_tag);
					filter.style.transform = 'scale(0.9)';
					filter.clicked_to_select_on_image = false;
					//add id into array

					add_id_into_set_image_id_array(array_id,image_id);
					add_path_into_set_image_path_array(array_id,image_path);
				}else if(filter.clicked_to_select_on_image == false){
					filter.childNodes[1].remove();
					filter.style.transform = 'scale(1)';
					filter.clicked_to_select_on_image = true;
					//remove id from array
					remove_id_from_set_image_id_array(array_id,image_id);
					remove_path_from_set_image_path_array(array_id,image_path);
				}
			}
			
			

		}
		
		function set_image_in_input_field(i,e){

			// console.log(array_for_set_image[i]);

			if (e.target.first_time_selected_to_set_image_on_widget == true) {
				for (var j = 0; j < previous_array_for_set_image[i].length; j++) {
				selected_image_on_widget_control_row[i].childNodes[1].remove();
				}
			}

			if (e.target.first_time_selected_to_set_image_on_widget == undefined) {
				first_time_selected_to_set_image_on_widget = true
				for (var j = 0; j < array_for_set_image[i].length; j++) {
					console.log(array_for_set_image[i]);
					//array to remove previously selected images when again selecting
					previous_array_for_set_image[i].push(array_for_set_image[i][j])
				}
			}else{
				first_time_selected_to_set_image_on_widget = e.target.first_time_selected_to_set_image_on_widget
			}

			if (first_time_selected_to_set_image_on_widget == true) {
				for (var j = 0; j < array_for_set_image[i].length; j++) {
					var div = document.createElement('div');
	                div.className = 'col individual_media_content_container selected-image-on-widget-control-col flex';
	                var img_tag = document.createElement('img');
	                var src = fn_image_row[i].getElementsByClassName('image-on-modal-col')[j].getAttribute('data-image-path');
	                var src = array_for_set_image_path[i][j];
	                var media_ext = src.split('.').pop();
	                var media_path = src.split('.')[0]+'_thumb.' + media_ext;
	                img_tag.src = site_url(media_path);
	                div.appendChild(img_tag);
					selected_image_on_widget_control_row[i].appendChild(div)
				}
				e.target.first_time_selected_to_set_image_on_widget = false
				//emptying the array
				previous_array_for_set_image[i] = []
				for (var j = 0; j < array_for_set_image[i].length; j++) {
					//array to remove previously selected images when again selecting
					previous_array_for_set_image[i].push(array_for_set_image[i][j])
				}
			}
			//if clicking second time
			else{
				// for (var j = 0; j < previous_array_for_set_image[i].length; j++) {
				// console.log(previous_array_for_set_image[i]);
				// }
				//remove previously selected images
				for (var j = 0; j < previous_array_for_set_image[i].length; j++) {
				selected_image_on_widget_control_row[i].childNodes[1].remove();
				}
				//add new selected images
				for (var j = 0; j < array_for_set_image[i].length; j++) {
					var div = document.createElement('div');
	                div.className = 'col individual_media_content_container selected-image-on-widget-control-col flex';
	                var img_tag = document.createElement('img');
	                var src = array_for_set_image_path[i][j];
	                var media_ext = src.split('.').pop();
	                var media_path = src.split('.')[0]+'_thumb.' + media_ext;
	                img_tag.src = site_url(media_path);
	                div.appendChild(img_tag);
					selected_image_on_widget_control_row[i].appendChild(div)
				}
				e.target.first_time_selected_to_set_image_on_widget = true
				//emptying the array
				previous_array_for_set_image[i] = []
				for (var j = 0; j < array_for_set_image[i].length; j++) {
					//array to remove previously selected images when again selecting
					previous_array_for_set_image[i].push(array_for_set_image[i][j])
				}
			}
			
			var set_image_ids_string = array_for_set_image[i].toString();
			if (set_image_ids_string == '') 
			{
				set_image_ids_string = 'false';
			}

			input_set_image_id_field[i].value = set_image_ids_string;
			close_media_detail_editor(i)
		}

		
		grp_add_event_set_image(set_image_btn_select,'click',set_image_in_input_field);

		function close_set_media_modal_for_container(i,e)
		{	
			if(e.target.classList.contains('hidden-set-image-modal-container')){
				close_media_detail_editor(i)
			}
		}

		function close_media_detail_editor(i)
		{
			hidden_set_image_modal_container[i].style.display = 'none';
			hidden_set_image_modal_container[i].style.visibility = 'hidden';
			//hide the contaier and remove the last error
			// error_container_edit_media.style.display = 'none';
			// error_container_edit_media.innerText = '';
		}

		grp_add_event_set_image(set_image_btn,'click',open_set_media_modal);
		grp_add_event_set_image(close_set_modal_icon,'click',close_media_detail_editor);
		grp_add_event_set_image(fn_image_row,'scroll',load_more_on_scroll);
		grp_add_event_set_image(hidden_set_image_modal_container,'click',close_set_media_modal_for_container);
	</script>
	<!--CSS-->
	<style type="text/css">
		.hidden-set-image-modal-container{
			background: #000000ba;
		    width: 100%;
		    min-height: 100%;
		    position: fixed;
		    top: 0px;
		    left: 0px;
		    display: flex;
		    z-index: 100;
		    justify-content: center;
		}

		.hidden-set-image-modal{
			width: 60%;
    		min-height: 90%;
    		background: #f5f5f5;
		}
		.fn_image_row{
			max-height: 80vh;
			min-height: 80vh;
			overflow: auto;
		}
		.checked_icon{
		    position: absolute;
		    width: 33%!important;
		    top: 5px;
		    right: 5px;
		    filter: drop-shadow(0px 7px 4px #0000006e);
		}
	</style>
	<?php
}