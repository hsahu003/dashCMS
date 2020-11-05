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
		Edit Shipping Option
	</div>
	<?=form_open('dashboard/shop-setting/shipping/add/option','')?>
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
									<label class="width-100 px-2">Option Name</label>
									<input class="mb-2 p-3" type="text" name="option_name" value="<?= set_value('option_name')?>">
								</div>
							</div>
							<!--Description-->
							<div class="col">
								<div class="form-element flex-col mr-4 mt-0">
									<label class="width-100 px-2 optional">Description</label>
									<textarea name="description" rows='4' cols="50"></textarea>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--dash widget for country for shipping option-->
			<div class="col ds-col-4 dashboard-widget">
				<div class="container">
					<div class="row align-items-x-start flex border-b">
						<div class="col">
							<div class="border-radius-top-2 p-3 width-100">
								Country for shipping option
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
						<label>Select Country</label>
						<input type="hidden" name="hidden_countries" value='<?php echo json_encode($countries) ?>'>
						<select onchange="sort_states(this)" name="option_country">
							<!--keep this default value empty for the form submit purpose-->
							<option value=''>----Select Country----</option>
							<option selected value="<?= $country->country_id ?>"><?= $country->country?></option>
						</select>
					</div>
				</div>
			</div>
		</div>
		<!--new row -->
		<div class="row dashboard-widget-container align-items-y">
			<!--dash widget for states for shipping options-->
			<div class="col ds-col-7 dashboard-widget">
				<div class="container">
					<div class="row align-items-x-start flex border-b">
						<div class="col">
							<div class="border-radius-top-2 p-3 width-100">
								States for shipping option
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
							<div class="row px-child-2 state_details_row">
								<div class="col ds-col-4">
									<div class="form-element flex-col mb-2">
										<label>Select State</label>
										<select class="p-3 select_shipping_state" name="option_country_state">
											<option>----Select State----</option>
											<option value="0" selected>All States</option>
										</select>
									</div>
								</div>
								<div class="col ds-col-3">
									<div class="form-element flex-col mb-2">
										<label>Shipping Cost <span class="bold" id="option_currency"></span></label>
										<input class="mb-2 p-3" type="text" name="option_cost" value="<?= set_value('option_cost')?>">
									</div>
								</div>
								<div class="col ds-col-4">
									<div class="form-element flex-col mb-2">
										<label class="optional">Delivery Duration</label>
										<input class="mb-2 p-3" type="text" name="option_delivery_duration" value="<?= set_value('option_delivery_duration')?>">
									</div>
								</div>
								<div class="col ds-col-1 flex pointer" id="add_state_details">
									<div class="font-size-4p5">
										+
									</div>
								</div>
							</div>
							<div class="row px-2" id="option_submit_btn">
								<div class="col">
									<!--Submit button-->
									<div class="form-element flex-col">
										<input class="btn-rect-rounded border-soft px-5" type="submit" name="submit" value="Add Shipping Option">
									</div>
								</div>
							</div>
						</div>
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
		//currently this is off
		return;
		var clone = state_details_row.cloneNode(true);
		state_details_row_container.insertBefore(clone,option_submit_btn);
	}

	add_state_details.addEventListener("click", add_state_details_row);
	/*----------------------------------------------------------------------------------------*/
	var select_shipping_state = document.getElementsByClassName('select_shipping_state')[0]
	var option_shipping_state = select_shipping_state.getElementsByTagName('option');
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
</script>