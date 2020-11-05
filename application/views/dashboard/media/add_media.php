<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!--Continuing from views/dashboard/templated/header.php-->
<div class="text">
</div>
		<div class="container dashborad-working-area" id="media_content_container">	
			<?php if(isset($execute)):?>
				<div class="error-display-container error-display-container-add-admin">
					<div class="container m-4 border-radius-2 error-container">
						<?=$message?>
					</div>
				</div>
			<?php endif?>
			<div class="container m-4 p-4 border-radius-2 nested-dashboard-working-area">
				<div class="font-size-4p5 font-weight-5 mb-2 f-color-3">
					Add New Media
				</div>
				<!--add new media button-->
				<div class="row">
					<div class="col btn-rect-rounded">
						<label>
							<input type="file" class="upload_media" name="add_image" id="add_image_btn">
							Add Image
						</label>
					</div>
				</div>
				<div class="row flex-col align-items-y dashboard-widget-container">
					<div class="col ds-col-11 dashboard-widget">
						<div class="container">
							<div class="row flex-child p-3" id="media_container">
								<!--showing root folders-->

								<?php foreach($parent_folders as $folder): ?>
								<a href="<?= site_url('dashboard/media/folder/'.$folder->taxonomy_id.'/add');?>">
								<div class="col individual_folder_container">
									<div class="folder_name_wrapper unselectable">
										<?= $folder->name?>
									</div>
								</div>
								</a>
								<?php endforeach; ?>

								<!--sets the folder's parent id in hidden input field -->
								<input type="hidden" name="parent_folder_id" value="<?= $parent_folder_id?>">

								<?php foreach($medias as $media): ?>
								<div class="col individual_media_content_container">
									<img src="<?= site_url($media->media_path)?>"> 
								</div>
								<?php endforeach; ?>
								<!--loads the data of intial medias into this hidden field-->
								<input type="hidden" name="json" id="initial_json_data" value='<?php echo json_encode($medias) ?>'>
								
							</div>
							<div style="display: none" class="flex mb-3 row" id="media_loading">
								<div class="col">
									<img style="width: 50px;" src="<?=site_url('assets/images/ajax-loader.gif')?>">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
</div>

<!--Edit individual media | hidden by default-->
<div class="hidden-modal-container">
	<div class="hidden_modal border-radius-1 my-3 px-child-3">
		<div class="container">
			<div class="row space-between p-4 align-items-y-center">
				<div class="col">
					Edit Media
				</div>
				<div class="col pointer" id="close_modal_icon">
					<?= display_icon('times-solid','','10px','')?>
				</div>
			</div>
			<div class="horizontal-line-extra-thin"></div>
			<div class="row">
				
				<div class="error-display-container error-display-container-add-admin">
					<div id="error_container_edit_media" class="container m-4 border-radius-2 error-container width-auto">
					</div>
				</div>
				
			</div>

			<div class="row p-4">
				<div class="col ds-col-7 flex">
					<div class="media_modal_image_wrapper">
						<img id="media_modal_image" class="width-100 border-radius-2" src="">
					</div>
				</div>

				<div class="col ds-col-5">
					<div class="row p-4 py-3 pt-0 ds-row-cols-12 align-items-y font-size-2p5">
						<div class="col media-detail-wrapper">
							<span class="font-weight-6 mr-2">Media name</span>
							<span id="media_name"></span>
						</div>
						<div class="col media-detail-wrapper">
							<span class="font-weight-6 mr-2">Media type</span>
							<span id="media_type"></span>
						</div>
						<div class="col media-detail-wrapper">
							<span class="font-weight-6 mr-2">Uploaded on</span>
							<span id="date_created"></span>
						</div>
						<!-- <div class="col media-detail-wrapper">
							<span class="font-weight-6 mr-2">Uploaded by</span>
							<span id="created_by"></span>
						</div> -->
						<div class="col media-detail-wrapper">
							<span class="font-weight-6 mr-2">Media size</span>
							<span id="media_size"></span>
						</div>
						<div class="col media-detail-wrapper">
							<span class="font-weight-6 mr-2">Media dimension</span>
							<span id="media_dimension"></span>
						</div>
						<div class="col media-detail-wrapper link">
							<span><a id="view_full_media" href="" target="_blank">View Full Media</a></span>
						</div>
					</div>

					<div class="row ds-row-cols-12 p-4 py-1">
						<!--hidden fields-->
						<div class="col">
							<input type="hidden" name="media_id" value="">
							<!--array key of media_data array-->
							<input type="hidden" name="array_key" value="">
							<input type="hidden" name="media_type" value="">
							<input type="hidden" name="user_type" value="">
							<input type="hidden" name="admin_id" value="<?= $admin_id?>">
							<input type="hidden" name="edit_media_id" value="<?= $edit_media_id?>">
						</div>
						<div class="col">
							<div class="form-element flex-col mr-4">
								<label>Media Name</label>
								<input class="mb-2 p-3" type="text" name="media_name" value="">
							</div>
						</div>
						<div class="col">
							<div class="form-element flex-col position-relative">
								<div class="row space-between width-100">
									<div class="col"><label>Alt Text</label></div>
									<div class="col">
										<div class="tooltip">
											<span><?= display_icon('tool_tip_circle','','17px','')?></span>
		  									<span class="tooltiptext">Tooltip text</span>
										</div>
									</div>
								</div>
								<input class="mb-2 p-3" type="text" name="alt_text" value="">
							</div>
						</div>
						<div class="col">
							<div class="form-element flex-col">
								<label>Media Categoty</label>
								<select class="p-3" name="status">
									<option value="1">Active</option>
									<option value="0">Disable</option>
								</select>
								<small><a href="#">Cereat new media category</a></small>
							</div>
						</div>
					</div>
					<div class="row p-4 flex space-between">
						<div class="col">
							<div class="btn-rect-rounded px-5" id="save_media_change">Save</div>
						</div>
						<div class="col pointer font-size-2p5 color-red unselectable" id="delete_media_btn">
							delete
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<style type="text/css">
	.upload_media{
		visibility: hidden;
		width: 0px;
	}
	.hidden-modal-container{
		background: #000000ba;
	    width: 100%;
	    min-height: 100%;
	    position: fixed;
	    top: 0px;
	    display: flex;
	    z-index: 100;
	    justify-content: center;
	    visibility: hidden;
	}
	.hidden_modal{
		width: 60%;
	    min-height: 90%;
	    background: #f5f5f5;
	}
	.media-detail-wrapper{
		background: white;
		padding: 5px;
    	padding-left: 10px; 

	}
	.media-detail-wrapper:nth-child(even){
		background: #f9f9f9;
	}
	.media-detail-wrapper:first-child{
		border-radius: 5px 5px 0px 0px!important;
	}
	.media-detail-wrapper:last-child{
		border-radius: 0px 0px 5px 5px!important;
	}
</style>

<script type="text/javascript">

	var media_loading = document.getElementById('media_loading');
	var media_container = document.getElementById('media_container');
	var main_container = document.getElementById('media_content_container');
	var close_modal_icon = document.getElementById('close_modal_icon');
	var view_full_media = document.getElementById('view_full_media');
	var media_name = document.getElementById('media_name');
	var media_type = document.getElementById('media_type');
	var date_created = document.getElementById('date_created');
	var created_by = document.getElementById('created_by');
	var media_size = document.getElementById('media_size');
	var media_dimension = document.getElementById('media_dimension');
	var media_name_input = document.getElementsByName('media_name')[0];
	var alt_text_input = document.getElementsByName('alt_text')[0];
	var media_id_input = document.getElementsByName('media_id')[0];
	var parent_folder_id_input = document.getElementsByName('parent_folder_id')[0];
	var media_type_input = document.getElementsByName('media_type')[0];
	var array_key_input = document.getElementsByName('array_key')[0];
	var admin_id_input = document.getElementsByName('admin_id')[0];
	var edit_media_id_input = document.getElementsByName('edit_media_id')[0];
	var user_type_input = document.getElementsByName('user_type')[0];
	var save_media_change = document.getElementById('save_media_change');
	var delete_media_btn = document.getElementById('delete_media_btn');

	// var error_container is taken in common_main.js
	var error_container_edit_media = document.getElementById('error_container_edit_media');

	var individual_media_content_container = document.getElementsByClassName('individual_media_content_container');



	var initial_json_data = document.getElementById('initial_json_data');
	//gets the initial(before fisrt scroll) media's data 
	var media_data = JSON.parse(initial_json_data.value); 
	console.log(media_data)
	var offset = 100;
	//load more image as the page scrolls
	function load_more_ajax(original_offset)
	{	
		
		var container_height = main_container.offsetHeight;
		var yOffset = window.pageYOffset;
		var window_innerHeight = window.innerHeight;
		var y = yOffset + window_innerHeight;
		console.log('| yOffset '+ yOffset + '| window_innerHeight '+ window_innerHeight + '| y ' + y);
		if (y >= container_height) {
			console.log('offset ' + offset);
			var url = site_url('dashboard/media/folder/0/add');
			var data = {limit:50,offset:offset};
			data = "data="+JSON.stringify(data);
			ajax({
				type:'POST',
				url: url,
            	data:data,
           	 	contentType: true,
            	onSuccess: function(return_data){
            		console.log(return_data)
            		return_data = JSON.parse(return_data);
                	for (var i = 0; i < return_data.length; i++) {
                		media_data.push(return_data[i])
                		var div = document.createElement('div');
                		div.className = 'col individual_media_content_container'
                		var img_tag = document.createElement('img');
                		img_tag.src = site_url(return_data[i].media_path,false);
                		div.append(img_tag);
                		media_container.append(div);
                		console.log('hello')
                	}
                	get_individual_media_content_container();
					grp_add_event(get_individual_media_content_container(),'click',open_media_detail_editor)
            	}
			})
			offset += 50;
		}

	}

	window.addEventListener("scroll",load_more_ajax);

	//add new image
	var add_image_btn = document.getElementById('add_image_btn');
	add_image_btn.addEventListener('change',function(e){
		var div = document.createElement('div');
        div.className = 'col individual_media_content_container';
        var img_tag = document.createElement('img');
        img_tag.src = '#';
        img_tag.className = 'add-image-icon'
        div.append(img_tag);
        media_container.insertBefore(div, individual_media_content_container[0])

        //params for ajax request
		var	url = 'ajax/add-image';
		url = site_url(url);
		e.preventDefault();
		var file_data = add_image_btn.files[0];
		var form_data = new FormData();
		form_data.append('file', file_data);
		//sending the folder id and admin id in ajax request
		form_data.append('folder_id', parent_folder_id_input.value);
		form_data.append('admin_id', admin_id_input.value);
		
        ajax({
	        url:url,
	        data:form_data,
	        contentType: false,
	        beforeSend: function(){
	            img_tag.setAttribute('src',site_url('assets/images/ajax-loader.gif'));
	        },
	        onSuccess: function(return_data){
	            return_data = JSON.parse(return_data);
	            media_data.splice(0,0,return_data)
	            console.log(media_data);
	            img_tag.classList.remove("add-image-icon");
	            img_tag.setAttribute('src',site_url(return_data.media_path));
	            grp_add_event(get_individual_media_content_container(),'click',open_media_detail_editor,true)
	        }
        })
	})

	/**
	*
	* @param args.main_container | selected main container |
	* @param args.parent_element | selected parent element inside which new ajax fetched data will be appended
	* @param args.url | url for ajax request 
	* @param args.data | json data or stringified json data
	*/
	// function load_more_ajax(args)
	// {	
	// 	//arguments
	// 	var main_container = args.main_container;
	// 	var parent_element = args.parent_element;
	// 	var url = args.url;
	// 	var data = args.data;
	// 	var offset = args.offset;
	// 	var limit = args.limit;

	// 	var data = {limit:limit,offset:offset};
	// 	data = JSON.stringify(data);
	// 	data = "data="+data;

	// 	// height of the main container
	// 	var main_container_height = main_container.offsetHeight;
	// 	// number of pixels the document is currently scrolled along the vertical axis (up or down)
	// 	var yOffset = window.pageYOffset;
	// 	// height of the complete widnow (inner)
	// 	var window_innerHeight = window.innerHeight;
	// 	// yoffset + window inner height
	// 	var y = yOffset + window_innerHeight;

	// 	//check if scroll bar has touched bottom of the page
	// 	if (y >= container_height) 
	// 	{
	// 		ajax({
	// 			type:'POST',
	// 			url: url,
 //            	data:data,
 //           	 	contentType: true,
 //            	onSuccess: function(return_data){
 //            		return_data = JSON.parse(return_data);
 //                	args.appendData(return_data);
 //            	}
	// 		})
	// 	}
	// }
	

	/**
	*
	* open media editing page
	*/
	function get_individual_media_content_container(){
		var individual_media_content_container = document.getElementsByClassName('individual_media_content_container');
		console.log('individual_media_content_container'+individual_media_content_container.length)
		return individual_media_content_container;
	}
	
	var hidden_modal_container = document.getElementsByClassName('hidden-modal-container')[0];
	var media_modal_image = document.getElementById('media_modal_image');

	//if url is set to edit the media
	if (edit_media_id_input.value != 'null') {
		//find array key number by media_id
		for (var i = 0; i < media_data.length; i++) {
			if (media_data[i].media_id==edit_media_id_input.value) {
				var j = i
				open_media_detail_editor(j)
				break;
			}
		}
		
	}else{
		show_edit_media_modal_input = false;
	}
	
	function open_media_detail_editor(i)
	{	
		var media_path = media_data[i].media_path;
		media_path = media_path.replace("_thumb", "");
		console.log(media_data[i]);
		media_modal_image.src = site_url(media_path);
		view_full_media.href = site_url(media_path);
		hidden_modal_container.style.display = 'flex';
		hidden_modal_container.style.visibility = 'visible';
		media_name.innerText = media_data[i].media_name;
		media_type.innerText = media_data[i].media_type;
		var date = new Date(media_data[i].date_created);
		var options = {year: 'numeric', month: 'long', day: 'numeric' };
		date_created.innerText = date.toLocaleDateString("en-IN",options);
		media_size.innerText = media_data[i].media_size;
		media_dimension.innerText = media_data[i].media_dimension;
		var x = media_data[i].media_name
		x = x.split('.').slice(0, -1).join('.');
		media_name_input.value =  x;
		alt_text_input.value = media_data[i].alt_text;
		media_id_input.value = media_data[i].media_id;
		media_type_input.value = media_data[i].media_type;
		user_type_input.value = media_data[i].user_type;
		array_key_input.value = i;
		var edit_url = 'dashboard/media/folder/'+parent_folder_id_input.value+'/edit/'+media_id_input.value;
		edit_url = site_url(edit_url);
		window.history.replaceState('page2', 'Title', edit_url);
	}

	function close_media_detail_editor_for_container(event)
	{	
		if(event.target.classList.contains('hidden-modal-container')){
			close_media_detail_editor()
		}
	}

	function close_media_detail_editor()
	{
		hidden_modal_container.style.display = 'none';
		hidden_modal_container.style.visibility = 'hidden';
		//hide the contaier and remove the last error
		error_container_edit_media.style.display = 'none';
		error_container_edit_media.innerText = '';
		window.history.replaceState('page2', 'Title', site_url('dashboard/media/folder/'+parent_folder_id_input.value+'/add'));
	}

	individual_media_content_container = get_individual_media_content_container()
	grp_add_event(individual_media_content_container,'click',open_media_detail_editor)

	hidden_modal_container.addEventListener('click',function(){
		close_media_detail_editor_for_container(event)
	})

	close_modal_icon.addEventListener('click', function(){
		close_media_detail_editor()
	})

	function save_media_edit_changes()
	{	
		//save the changes with ajax
		var url = 'dashboard/media/update-media/'+media_id_input.value;
		url = site_url(url);
		var media_ext = media_name.innerText.split('.').pop();
		var old_media_name = media_name.innerText;
		var old_media_name_thumb = old_media_name.split('.')[0] + '_thumb.' + media_ext;
		var new_media_name = media_name_input.value+'.'+media_ext;
		var new_media_name_thumb = media_name_input.value+'_thumb.'+media_ext;
		var alt_text = alt_text_input.value;
		var admin_id = admin_id_input.value;
		var user_type = user_type_input.value;
		var data = {new_media_name:new_media_name,
			old_media_name:old_media_name,
			old_media_name_thumb: old_media_name_thumb,
			new_media_name_thumb: new_media_name_thumb,
			alt_text:alt_text,
			admin_id:admin_id,
			user_type:user_type,
			media_ext:media_ext};
		//prevent atl text length to 125 characters
		console.log(alt_text.length);
		if (alt_text.length > 125) {
			//show error
			error_container_edit_media.style.display = 'flex';
			error_container_edit_media.innerText = 'Alt text should be under 125 characters';
			return;
		}
		data = "data="+JSON.stringify(data);
		ajax({
	        url:url,
	        data:data,
	        contentType: true,
	        beforeSend: function(){
	            
	        },
	        onSuccess: function(return_data){
	        	return_data = JSON.parse(return_data);
	        	console.log(return_data);
				error_container_edit_media.style.display = 'flex';
				//if new name of the media matches another media's name in the DB
				if (return_data.error_media_name == 'true') {
					error_container_edit_media.innerText = return_data.message_media_name
				}else{
					error_container_edit_media.innerText = 'Changes saved';
					//updating the media_data array with new changes
					media_data[array_key_input.value].media_name = return_data.media_name;
					media_data[array_key_input.value].media_path = return_data.media_path;
					media_name.innerText = return_data.media_name +'.'+ return_data.media_ext;
				}
				//updating the media_data array with new changes
				media_data[array_key_input.value].alt_text = return_data.alt_text;
				
				// window.location = site_url('dashboard/media/folder/0/add');

	        }
        })
		console.log(media_name_input.value + ' ' + alt_text_input.value);
	}

	function delete_media(){
		var cofirm_delete_media = confirm("Delete this media permanently?");
		if (cofirm_delete_media) {
			var url = 'dashboard/media/delete-media/'+media_id_input.value;
			url = site_url(url);
			ajax({
				url: url,
				onSuccess: function(return_data){
					//remove from array media_data
					media_data.splice(array_key_input.value, 1);
					//delete from dom
					individual_media_content_container[array_key_input.value].remove();
					//reapply the grp event
					grp_add_event(get_individual_media_content_container(),'click',open_media_detail_editor,true);
					close_media_detail_editor()
			}
		})
		}
		
	}
	save_media_change.addEventListener('click', function(){
		save_media_edit_changes()
	})

	delete_media_btn.addEventListener('click',function(){
		delete_media()
	})
</script>