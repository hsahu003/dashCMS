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
		Edit <?= $product->name; ?>
	</div>
	<?php $attributes = array('id' => 'add_product_form'); ?>
	<?=form_open('dashboard/product/edit/'.$product->id,$attributes)?>
	<div class="row dashboard-widget-container align-items-y">
		<div class="col ds-col-6 dashboard-widget">
			<div class="container">
				<div class="row align-items-x-start flex border-b">
					<div class="col">
						<div class="border-radius-top-2 p-3 width-100">
							Name & Description
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
				
				
				<div class="dashboard-widget-controls p-4">
					<div class="container">
						<div class="row ds-row-cols-12 flex px-child-1 space-between mb-child-3">
							<!--Option Name-->
							<div class="col">
								<div class="form-element flex-col mr-4 mt-0">
									<label class="width-100 px-2">Product Name</label>
									<input class="mb-2 p-3" type="text" name="product_name" value="<?= $product->name; ?>">
								</div>
							</div>
							<!--Description-->
							<div class="col">
								<div class="form-element flex-col mr-4 mt-0">
									<label class="width-100 px-2">Product Description</label>
									<textarea name="description" rows='4' cols="50" name="product_decsription"><?= $product->desc; ?></textarea>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--dash widget for Sell this product in countries-->
			<div class="col ds-col-4 dashboard-widget">
				<div class="container">
					<div class="row align-items-x-start flex border-b">
						<div class="col">
							<div class="border-radius-top-2 p-3 width-100">
								Sell this product in countries:
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

				<div class="dashboard-widget-controls p-4">
					<div class="form-element flex-col mb-2">
						<input type="hidden" name="hidden_countries" value='<?php echo json_encode($countries) ?>'>
						<!-- <select onchange="sort_states(this)" name="option_country"> -->
							<!--keep this default value empty for the form submit purpose-->
							<div class="container">
								<div class="row">
									<?php $index = 0; foreach($countries as $country): $index++; ?>
									<?php if($country->selling_here): ?>
									<div class="col">	
									<label><?= $country->country ?></label>
									<input type="hidden" name="">
									<input checked onclick="things_by_county(this)" type="checkbox" name="country_id[]" value="<?= $country->country_id ?>" data-div-recogniser='<?= $index-1?>' data-country-name= "<?= $country->country?>"/>
									</div>
									<?php else: ?>
									<div class="col">	
									<label><?= $country->country ?></label>
									<input onclick="things_by_county(this)" type="checkbox" name="country_id[]" value="<?= $country->country_id ?>" data-div-recogniser='<?= $index-1?>' data-country-name= "<?= $country->country?>"/>
									</div>
									<?php endif; ?>	
									<?php endforeach; ?>
								</div>
							</div>
					</div>
				</div>
			</div>
			
		</div>
		<!--new row -->
		<div class="row dashboard-widget-container align-items-y">
			<!--dash widget for price -->
			<div class="col ds-col-6 dashboard-widget">
				<div class="container">
					<div class="row align-items-x-start flex border-b">
						<div class="col">
							<div class="border-radius-top-2 p-3 width-100">
								Price
							</div>
						</div>
						<div class="col">
							<div class="tooltip">
								<span><?= display_icon('tool_tip_circle','','17px','')?></span>
									<span class="tooltiptext">Tooltip text</span>
							</div>
						</div>
					</div>

					<div class="dashboard-widget-controls">
						<div class="container price-row-container">
							<div class="row price-row">
								
								<table class="border-radius-table-2 price-table">
									<thead class="">
										<tr>
											<th></th>
											<th></th>
											<th>Price</th>
											<th>
												<div class="container">
													<div class="row flex">
														<div class="col">
															<div class="border-radius-top-2 p-3 width-100">
																Sale Price
															</div>
														</div>
														<div class="col">
															<div class="tooltip">
																<span><?= display_icon('tool_tip_circle','','17px','')?>
																</span>
																<span class="tooltiptext font-weight-normal">Leave this field empty if there is no sale price
																</span>
															</div>
														</div>
													</div>
												</div>
											</th>
										</tr>
									</thead>
									<?php foreach($product->product_prices as $price): ?>
									<tbody class="price-tbody" data-tbody-recogniser="0">
										<tr>
											<td><?= $price->country_name; ?></td>
											<td><?= $price->currency_symbol;?></td>
											<td>
												<input type="text" name="price[]" class="input-price" data-country-id-for-price="<?= $price->country_id; ?>" value="<?= $price->price ?>">
											</td>
											<td>
												<input type="text" name="sale_price[]" class="input-sale-price" data-country-id-for-price="<?= $price->country_id?>" value="<?= $price->sale_price;?>">
											</td>
										</tr>
									</tbody>
								<?php endforeach; ?>
								</table>
							</div>
						</div>
					</div>

				</div>
			</div>
			<!--dash widget for shipping options for this product-->
			<div class="col ds-col-4 dashboard-widget">
				<div class="container">
					<div class="row align-items-x-start flex border-b">
						<div class="col">
							<div class="border-radius-top-2 p-3 width-100">
								Shipping options for this product:
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
				<div class="dashboard-widget-controls ">
					<div class="container shipping_country_container">
						<?php foreach($product->shipping_options_selected_countries as $country): ?>
						<div class="row flex-col align-items-y shipping_country_row border-b my-2" data-div-recogniser="0">
							<div class="col mb-2 bold">
								shipping options for <?= $country->country_name; ?>
							</div>
							<div class="col mb-2">
								<div class="container">
									<div class="row flex-col align-items-y shipping_option_row">
										<?php foreach($country->shipping_options as $option): ?>
										<div class="col mb-2">
											<input checked type="checkbox" class="mr-2 input-shipping-option" data-country-id-for-shipping-option="<?= $country->country_id; ?>" value="<?= $option->option_id?>" name="shipping_option[]" >
											<label>
											<?= $option->option_name?> <?= '('.$country->country_name.')'?>
											</label>
										</div>
										<?php endforeach; ?>
									</div>
								</div>
							</div>
						</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
			<!--dash widget for states for postal code settings-->
			<!-- <div class="col ds-col-4 dashboard-widget">
				<div class="container">
					<div class="row align-items-x-start flex border-b">
						<div class="col">
							<div class="border-radius-top-2 p-3 width-100">
								Postal Code Settings
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
			</div> -->
		</div>
		<!--new row-->
		<div class="row dashboard-widget-container align-items-y">
			<!--dash widget for specifications-->
			<div class="col ds-col-6 dashboard-widget">
				<div class="container">
					<div class="row align-items-x-start flex border-b">
						<div class="col">
							<div class="border-radius-top-2 p-3 width-100">
								Specifications
							</div>
						</div>
						<div class="col">
							<div class="tooltip">
								<span><?= display_icon('tool_tip_circle','','17px','')?></span>
									<span class="tooltiptext">Tooltip text</span>
							</div>
						</div>
					</div>
					<div class="dashboard-widget-controls">
						<div class="container" id="state_details_row_container">
							<?php $index=0; foreach($product->specs as $key => $value): $index++;?>
								<?php if($index==1): ?>
							<div class="row px-child-2 state_details_row unselectable">
								<div class="col ds-col-5">
									<div class="form-element flex-col mb-2">
										<label>Title</label>
										<input class="mb-2 p-3" type="text" name="spec_title[]" value="<?= $key;?>">
									</div>
								</div>
								<div class="col ds-col-5">
									<div class="form-element flex-col mb-2">
										<label>Details<span class="bold" id="option_currency"></span></label>
										<input class="mb-2 p-3" type="text" name="spec_details[]" value="<?= $value;?>">
									</div>
								</div>
								<div class="col ds-col-1 flex pointer" id="add_state_details">
									<div class="font-size-5">
										+
									</div>
								</div>
							</div>
							<?php else: ?>
							<div class="row px-child-2 state_details_row unselectable">
								<div class="col ds-col-5">
									<div class="form-element flex-col mb-2">
										<label>Title</label>
										<input class="mb-2 p-3" type="text" name="spec_title[]" value="<?= $key;?>">
									</div>
								</div>
								<div class="col ds-col-5">
									<div class="form-element flex-col mb-2">
										<label>Details<span class="bold" id="option_currency"></span></label>
										<input class="mb-2 p-3" type="text" name="spec_details[]" value="<?= $value;?>">
									</div>
								</div>
								<div class="col ds-col-1 flex pointer font-size-4" onclick="removeSpecRow(this)">
									<i class="fa fa-trash" aria-hidden="true"></i>
								</div>
							</div>
							<?php endif; ?>
						<?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>
			<!--dash widget for product category-->
			<div class="col ds-col-4 dashboard-widget">
				<div class="container">
					<div class="row align-items-x-start flex border-b">
						<div class="col">
							<div class="border-radius-top-2 p-3 width-100">
								Product Category
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
				<div class="dashboard-widget-controls">
					<div class="col" id="parent_categories_container" >
						<?php $index = 0; foreach($product->parent_categories_collections as $parent_categories): $index++;?>
							<div class="form-element flex-col mb-2 parent_categories" data-div-counter='<?= $index-1?>'>
								
									<label>level <?= $index?> Parent</label>
									<select onchange="childs_by_parent_id(this)" class="p-3 select_tag" name="category_id[]">
										<?php foreach($parent_categories as $parent_category): ?>
										<?php if($parent_category->selected === true): ?>
											<option selected value="<?= $parent_category->taxonomy_id ?>"><?= $parent_category->name ?></option>
										<?php endif; ?>
										<?php endforeach; ?>
									</select>
							</div>
						<?php endforeach; ?>
					</div>

				</div>
			</div>
		</div>
		<!--new row-->
		<div class="row dashboard-widget-container align-items-y">
			<!--dash widget product images-->
			<div class="col dashboard-widget set-image-dash-widget ds-col-6" data-sigle-image="1">
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
						<div class="col individual_media_content_container selected-image-on-widget-control-col flex"><img src="<?= $product->primary_image_src; ?>"></div></div>
					</div>
				</div>
			</div>
		</div>
			<!--dash widget for product status-->
			<div class="col ds-col-4 dashboard-widget">
				<div class="container">
					<div class="row align-items-x-start flex border-b">
						<div class="col">
							<div class="border-radius-top-2 p-3 width-100">
								Status
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
				<div class="dashboard-widget-controls">
					<div class="col">
						<div class="form-element flex-col mb-2">
							<label>Product Status</label>
							<select class="p-3" name="status">
								<option value="">----Status----</option>
								<?php if($product->status=='active'): ?>
								<option selected value="active">Active</option>
								<option value="disabled">Disabled</option>
								<?php elseif($product->status == 'disabled'): ?>
								<option value="active">Active</option>
								<option selected value="disabled">Disabled</option>
								<?php endif; ?>
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--new row-->
		<div class="row dashboard-widget-container align-items-y">
			<div class="col dashboard-widget set-image-dash-widget ds-col-6" data-sigle-image="0">
			<div class="container">
				<div class="row flex border-b space-between">
					<div class="col">
						<div class="container">
							<div class="row align-items-y-center">
								<div class="col">
									<div class="border-radius-top-2 p-3 width-100">
										Product Images									
									</div>
								</div>
								<div class="col">
									<div class="tooltip">
										<span><img style="width:17px;" src="http://localhost/current-projects/CI/CI-TEMPLATE/assets/images/icons/tool_tip_circle.svg"></span>
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
							<?php foreach($product->gallary_images_src as $gallary_image): ?>
							<div class="col individual_media_content_container selected-image-on-widget-control-col flex">
								<img src="<?= $gallary_image; ?>">
							</div>
						<?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>
		</div>

		</div>
		<!--adding form submit button-->
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="form-element flex-col">
						<div class="btn-rect-rounded border-soft px-5 bg-blue-primary f-white" onclick="submit_form()">
							Edit Product
						</div>
					</div>
				</div>
			</div>
		</div>
		</form>
	</div>
</div>
<!--end of the div stared in header.php-->
</div>
<script type="text/javascript">
	/*----------------------------------------------------------------------------------------*/
	var add_state_details = document.getElementById('add_state_details');
	var state_details_row = document.getElementsByClassName('state_details_row')[0];
	var state_details_row_container = document.getElementById('state_details_row_container');
	var option_submit_btn = document.getElementById('option_submit_btn');
	function add_state_details_row() {
		var clone = state_details_row.cloneNode(true);
		//remove the add button
		clone.querySelector('#add_state_details').remove();
		//add row remove button
		var row_remove_button = document.createElement('div');
		row_remove_button.className = "col ds-col-1 flex pointer font-size-4";
		row_remove_button.setAttribute('onclick','removeSpecRow(this)')
		row_remove_button.innerHTML = "<i class='fa fa-trash' aria-hidden='true'></i>";
		//emty the clonnes fields (title & details fields)
		//title
		clone.childNodes[1].childNodes[1].childNodes[3].value = "";
		//details
		clone.childNodes[3].childNodes[1].childNodes[3].value = "";

		clone.appendChild(row_remove_button)
		state_details_row_container.insertBefore(clone,option_submit_btn);
	}

	function removeSpecRow(filter){
		filter.parentElement.remove();
	}

	add_state_details.addEventListener("click", add_state_details_row);
	/*----------------------------------------------------------------------------------------*/
	var select_shipping_state = document.getElementsByClassName('select_shipping_state')[0]
	// var option_shipping_state = select_shipping_state.getElementsByTagName('option');
	var option_currency = document.getElementById('option_currency');
	var hidden_countries = document.getElementsByName('hidden_countries')[0];
	hidden_countries = JSON.parse(hidden_countries.value)
	function sort_states(filter){
		//set currency code in option_currency
		for (var i = 0; i < hidden_countries.length; i++) {
			if (hidden_countries[i].country_id == filter.value) {
				option_currency.innerText = '('+hidden_countries[i].currency_symbol+')';
			}
		}

		//currenty rest of this is off
		return;
		//get the states by country with ajax and polulate states
		var url = 'commons/common/ajax-get-rows';
		var data = {table:'state',
			columns:'*',
			attributes: null,
			filter_keys_and_values: {'country_id':filter.value}
		};
		data = "data="+JSON.stringify(data);
		ajax({
			url: site_url(url),
			type: 'POST',
			data: data,
			onSuccess: function(return_data){
				
				return_data = JSON.parse(return_data);

				//if not any state with country
				if (return_data.length==0){
					var option_shipping_state_length = [].slice.call(option_shipping_state).length;
					for (var i = option_shipping_state_length-1; i > 0; i--) {
						option_shipping_state[i].remove();
					}
				}else{
					for (var i = 0; i < return_data.length; i++) {
						var option_tag = document.createElement('option');
						option_tag.innerText = return_data[i].state;
						select_shipping_state.appendChild(option_tag)
					}
				}

				
				console.log(return_data);
				//populate states

			}
		})
		
	}

	/**-----------------------------------------------------------------------------------------------*/
	var shipping_country_container = document.getElementsByClassName('shipping_country_container')[0];

	function populate_shipping_options(filter)
	{
		var remove_id = filter.getAttribute('data-div-recogniser');

		if (filter.checked) 
		{
			//get the shipping options by country
			var url = 'dashboard/shop-setting/shipping/get_by_country/option/'+filter.value
			url = site_url(url);
			ajax({
				url:url,
				onSuccess: function(return_data){
					return_data = JSON.parse(return_data);
					/*populate the shipping option*/

					/*created input type checkboxes for each option*/
					var shipping_country_row = document.createElement('div');
					shipping_country_row.className = "row flex-col align-items-y shipping_country_row border-b my-2";
					shipping_country_row.setAttribute('data-div-recogniser',remove_id)
					var div_for_country_name = document.createElement('div');
					div_for_country_name.className = "col mb-2 bold";
					div_for_country_name.innerText = "shipping options for "+ filter.getAttribute('data-country-name');
 					var div_col_container = document.createElement('div');
					div_col_container.className = "col mb-2";
					var div_container = document.createElement('div');
					div_container.className = "container";
					var div_row = document.createElement('div');
					div_row.className = "row flex-col align-items-y shipping_option_row";

					for (var i = 0; i < return_data.length; i++) {
						console.log(return_data[i])
						var div = document.createElement('div');
						div.className = "col mb-2";
						var input = document.createElement('input');
						input.type = 'checkbox';
						input.className = 'mr-2 input-shipping-option';
						input.setAttribute('data-country-id-for-shipping-option',filter.value)
						input.name = 'shipping_option[]';
						input.value = return_data[i].shipping_option_id
						var label = document.createElement('label');
						label.innerText = return_data[i].name + " ("+filter.getAttribute('data-country-name')+")"
						div.appendChild(input);
						div.appendChild(label);
						div_row.appendChild(div);


					}

						div_container.appendChild(div_row);
						div_col_container.appendChild(div_container);
						shipping_country_row.appendChild(div_for_country_name);
						shipping_country_row.appendChild(div_col_container);
						shipping_country_container.appendChild(shipping_country_row);

					// <div class="col">
					// 						<input type="checkbox" name="">
					// 						<label>Option 1</label>
					// 					</div>

				}
			})
		}else
		{	
			//remove the populated shipping options on uncheck country
			var to_remove = document.getElementsByClassName('shipping_country_row')
			
			for (var i = 0; i < to_remove.length; i++) 
			{
				if (remove_id == to_remove[i].getAttribute('data-div-recogniser')) {
						to_remove[i].remove();
				}
			}
		}
	}

	function populate_price_row(filter){

		var remove_id = filter.getAttribute('data-div-recogniser');

		if (filter.checked) 
		{	
			//get price row container 
			var price_table = document.getElementsByClassName('price-table')[0]

			//get country name and currency
			var hidden_countries = document.getElementsByName('hidden_countries')[0];
			hidden_countries = JSON.parse(hidden_countries.value);
			//populate the currency row
			for (var i = 0; i < hidden_countries.length; i++) {
				if (filter.value == hidden_countries[i].country_id) {
					var tbody = document.createElement('tbody');
					tbody.className = "price-tbody";
					tbody.setAttribute('data-tbody-recogniser',remove_id);
					var tr2 = document.createElement('tr');
					var td1 = document.createElement('td');
					td1.innerText = hidden_countries[i].country;
					var td2 = document.createElement('td');
					td2.innerText = hidden_countries[i].currency_symbol;
					var td3 = document.createElement('td');
					var td4 = document.createElement('td');
					var input_price = document.createElement('input');
					input_price.type = "text";
					input_price.name = "price[]";
					input_price.className = 'input-price';
					input_price.setAttribute('data-country-id-for-price',hidden_countries[i].country_id)
					var input_sale_price = document.createElement('input');
					input_sale_price.type = "text";
					input_sale_price.name = "sale_price[]";
					input_sale_price.className = 'input-sale-price';
					input_sale_price.setAttribute('data-country-id-for-price',hidden_countries[i].country_id)
					
					//td3
					td3.appendChild(input_price)
					td4.appendChild(input_sale_price)
					//tr2
					tr2.appendChild(td1)
					tr2.appendChild(td2)
					tr2.appendChild(td3)
					tr2.appendChild(td4)

					//tbody 
					tbody.appendChild(tr2)

					//table - final append on html markup
					price_table.appendChild(tbody)
				}
			}
			
		}else
		{	
			//remove the populated price tbody row on uncheck country
			var to_remove = document.getElementsByClassName('price-tbody')
			
			for (var i = 0; i < to_remove.length; i++) 
			{
				if (remove_id == to_remove[i].getAttribute('data-tbody-recogniser')) {
						to_remove[i].remove();
				}
			}
		}
	}

	function things_by_county(filter)
	{	
		populate_shipping_options(filter);
		populate_price_row(filter);	

	}

	/*--------------------------------------fucntion for product category-----------------*/
	var parent_categories_container = document.getElementById('parent_categories_container');
		var parent_categories = document.getElementsByClassName('parent_categories');
		var clone = document.getElementsByClassName('parent_categories')[0];
		var select_tag = clone.getElementsByClassName('select_tag')
		
		
		var div_counter = 0;

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

	/*----------------------------------------------------------------------------------------*/
	var input_price = document.getElementsByClassName('input-price');
	function set_price_value_with_country_id(){
		for (var i = 0; i < input_price.length; i++) {
			//get raw value
			var value = input_price[i].value
			//get country id
			var country_id = input_price[i].getAttribute('data-country-id-for-price');
			//update value with country id
			input_price[i].value = country_id+','+value;
		}
	}

	var input_sale_price = document.getElementsByClassName('input-sale-price');
	function set_sale_price_value_with_country_id(){
		for (var i = 0; i < input_sale_price.length; i++) {
			//get raw value
			var value = input_sale_price[i].value
			//get country id
			var country_id = input_sale_price[i].getAttribute('data-country-id-for-price');
			//update value with country id
			input_sale_price[i].value = country_id+','+value;
		}
	}

	var input_shipping_option = document.getElementsByClassName('input-shipping-option');
	function set_shipping_option_value_with_country_id(){
		for (var i = 0; i < input_shipping_option.length; i++) {
			//get raw value
			var value = input_shipping_option[i].value
			//get country id
			var country_id = input_shipping_option[i].getAttribute('data-country-id-for-shipping-option');
			//update value with country id
			input_shipping_option[i].value = country_id+','+value;
		}
	}

	function validate_form() {
		var bool_array = []
		//check if product name is not empty
	  var product_name = document.getElementsByName('product_name')[0].value;
	  if (product_name == "") {
	    alert("Product name must be filled out");
	    bool_array.push(false)
	  }else{
	  	bool_array.push(true)
	  }

	  //check if atleast one country is selected
	  var country_id = document.getElementsByName('country_id[]')
	  var j = 0;
	  for (var i = 0; i < country_id.length; i++) {
	  	if (country_id[i].checked == true) {
	  		j++
	  	}
	  }

	  if (j == 0) {
	  	alert("atleast one country should be selected");
	  	bool_array.push(false)
	  }else{
	  	bool_array.push(true)
	  }

	  //check if price filed is not empty
	  var price_fields = document.getElementsByName('price[]');
	  for (var i = 0; i < price_fields.length; i++) {
	  	if (price_fields[i].value == '') {
	  		alert("populated price field can not remain empty");
	  		bool_array.push(false)
	  	}else{
	  		bool_array.push(true)
	  	}
	  }

	  //check if alteast one shipping option is selected for respective country
	  var shipping_options = document.getElementsByName('shipping_option[]');
	  var f = [];
	  for (var i = 0; i < country_id.length; i++) {
	  	f[i] = []
	  }
	  for (var i = 0; i < country_id.length; i++) {
	  	for (var j = 0; j < shipping_options.length; j++) {
	  		if (country_id[i].value == shipping_options[j].getAttribute('data-country-id-for-shipping-option')) {
	  			if (shipping_options[j].checked == true) {
			  		f[i].push('1')
			  	}else{
			  		f[i].push('0')
			  	}
	  		}
	  	}
	  }

	  console.log(f)

	  for (var i = 0; i < f.length; i++) {
	  	if (f[i].length != 0) {
	  		for (var j = 0; j < f[i].length; j++) {
		  		if(f[i].indexOf("1") == -1){
		  			alert('alteast one shipping option must be choosen for selected country')
		  			bool_array.push(false)
		  		}else{
		  			bool_array.push(true)
		  		}
		  	}
	  	}
	  }

	  //check if product category has been selected or not
	  var category_ids =  document.getElementsByName('category_id[]')
	  if (category_ids[0].value == 'na') {
	  	alert('please choose the product category')
	  	bool_array.push(false)
	  }else{
	  	bool_array.push(true)
	  }

	  //check if product primary image has been setup or not
	  // var primary_image = document.getElementsByName('primary_image')[0];
	  // if (primary_image.value=='') {
	  // 	alert('please select the primary image for the product')
	  // 	bool_array.push(false)
	  // }else{
	  // 	bool_array.push(true)
	  // }

	  //check if product status is not null
	  var status = document.getElementsByName('status')[0];
	  if (status.value == '') {
	  	alert('please choose the status for product')
	  	bool_array.push(false)
	  }else{
	  	bool_array.push(true)
	  }
	  

	  for (var i = 0; i < bool_array.length; i++) {
	  	if (bool_array[i] == false) {
	  		return false;
	  	}
	  }

	  return true;
	}

	function submit_form(){
		//form validation
		if (validate_form()) {
			//link country with price value and sale price value
			set_price_value_with_country_id();
			set_sale_price_value_with_country_id();

			//link shipping option id with country id
			set_shipping_option_value_with_country_id();
			document.getElementById("add_product_form").submit();
		}
		
	}
</script>