<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
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
					Edit Product Category
				</div>
				<div class="row dashboard-widget-container align-items-y">
					<div class="col ds-col-6 dashboard-widget">
						<div class="border-radius-top-2 p-3 width-100 border-b">
							Edit Product Category
						</div>
						<?=form_open('dashboard/product/category/edit_category/'.$category['product_taxonomy_id'],'')?>
							<div class="dashboard-widget-controls p-4">
								<div class="container">
									<div class="row">
										<!--media category name field-->
										<div class="col ds-col-12">
											<div class="form-element flex-col mr-4">
												<label>Name</label>
												<input class="mb-2 p-3" type="text" name="name" value="<?= set_value('name') != null ?set_value('name') : $category['name']; ?>">
											</div>
										</div>
										<!--Select Parent Category-->
										<div class="col" id="parent_categories_container" >
											<?php $index = 0; foreach($parent_categories_collections as $parent_categories): $index++;?>
											<div class="form-element flex-col mb-2 parent_categories" data-div-counter='<?= $index-1?>'>
												
													<label>level <?= $index?> Parent</label>
													<select onchange="childs_by_parent_id(this)" class="p-3 select_tag" name="parent_id[]">
														<?php foreach($parent_categories as $parent_category): ?>
														<?php if($parent_category->selected === true): ?>
															<option selected value="<?= $parent_category->taxonomy_id ?>"><?= $parent_category->name ?></option>
														<?php endif; ?>
														<?php endforeach; ?>
													</select>
											</div>
											<?php endforeach; ?>
										</div>
										
										<div class="form-element flex-col mb-2">
											<label class="optional">Description</label>
											<textarea name="description" rows='4' cols="50"><?= $category['description']?></textarea>
										</div>
										<!--Submit button-->
										<div class="form-element flex-col">
											<input class="btn-rect-rounded border-soft px-5" type="submit" name="submit" value="Edit">
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
					<div class="col ds-col-4 dashboard-widget set-image-dash-widget" data-sigle-image="1">
						<div class="container">
							<div class="row flex border-b space-between">
								<div class="col">
									<div class="container">
										<div class="row align-items-y-center">
											<div class="col">
												<div class="border-radius-top-2 p-3 width-100">
													Product Primary Images									
												</div>
											</div>
											<div class="col">
												<div class="tooltip">
													<span><?= display_icon('tool_tip_circle','','17px','')?></span>
														<span class="tooltiptext">Tooltip text</span>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col px-3">
									<div class="set-image-data-container">
										<div class="btn-rect-rounded set-image-btn line-through" listener="true">
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
									<div class="row selected-image-on-widget-control-row">
									<div class="col individual_media_content_container selected-image-on-widget-control-col flex"><img src="<?= $category['category_image']?>"></div></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
</div>
<script type="text/javascript">

		var parent_categories_container = document.getElementById('parent_categories_container');
		var parent_categories = document.getElementsByClassName('parent_categories');
		var clone = document.getElementsByClassName('parent_categories')[0];
		var select_tag = clone.getElementsByClassName('select_tag')
		
		
		var div_counter = parent_categories.length - 1;

		function clone_new_select_tag_container()
		{
			clone = clone.cloneNode(true)

			/*remove all the options tags within select tags of cloned container
			* except the fist option tag: <option value='0'>none</option>
			*/

			var clone_options = clone.getElementsByTagName('option');
			//helps original option length remain same
			var clone_options_length = [].slice.call(clone_options).length;

			for (var i = 1; i < clone_options_length; i++) 
			{
				/*to not delete the fist option tag we have put above 
				* index as 1
				* otherwise we would have kept it zero
				*/
				clone.getElementsByTagName('option')[1].remove()
			}

			return clone
		}
	
	function childs_by_parent_id(filter)
	{	

		var parent_id = filter.value
		var parent_name = filter.options[filter.selectedIndex].text
		var data_div_counter = filter.parentElement.getAttribute('data-div-counter')
		data_div_counter = parseInt(data_div_counter)
		var url = 'commons/common/get-childs/product/'+parent_id+'/1';

		ajax({
			url: site_url(url),
			contentType: false,
			onSuccess: function(return_data)
			{	
				return_data = JSON.parse(return_data)
				/*clone if return_data has child categories or category
				* then append child categories into new cloned select tag container
				*/
				if (return_data.length!=0) {
					div_counter++;
					//creates a new cloned select tag container
					clone = clone_new_select_tag_container();
					clone.setAttribute("data-div-counter", div_counter);
					var clone_select_tag = clone.getElementsByClassName('select_tag')[0]
					var clone_label_tag = clone.getElementsByTagName('label')[0]
					clone_label_tag.innerHTML = parent_name + " -> Category";

					/*creates options tag for each of categories or childs
					* gives the tags innertext and value
					*/
					for (var i = 0; i < return_data.length; i++) 
					{	
						//creates options tag for each of categories or childs
						var option_tag = document.createElement('option');
						option_tag.innerHTML = return_data[i].name;
						option_tag.value = return_data[i].taxonomy_id;
						clone_select_tag.appendChild(option_tag)
						
					}

					//appends the new cloned select tag container 
					parent_categories_container.appendChild(clone)
					
				}
				/*if parent id does not exists then delete all the below appended select tags if
				* already appeneded
				*/
				else
				{	
					//gets the lenght of all select tag containers
					var parent_categories_length = [].slice.call(parent_categories).length;
					/*deletes all the **below appended** select tag containers
					* data_div_counter is very important in for loop to remove
					* **below appended** select tag containers
					*/
					for (var i = parent_categories_length-1; i > data_div_counter; i--) 
					{
						parent_categories[i].remove()
						div_counter--
					}
						
				}

			},
			//if none is selected in option tag
			onFailure: function(){
				
				if (parent_id == 'na') 
				{	
					//gets the lenght of all select tag containers
					var parent_categories_length = [].slice.call(parent_categories).length;
					/*deletes all the **below appended** select tag containers
					* data_div_counter is very important in for loop to remove
					* **below appended** select tag containers
					*/
					for (var i = parent_categories_length-1; i > data_div_counter; i--) {
						parent_categories[i].remove()
						div_counter--
					}
				}
			}
		})
	}





</script>