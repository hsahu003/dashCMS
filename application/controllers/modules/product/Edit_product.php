<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Edit_product extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('common/common_media');
		$this->load->model('dashboard/settings/common_model', 'CModel');
		$this->load->model('dashboard/modules/product/product_model', 'PModel');
		$this->load->helper('form');

		//check for admin login session
		is_admin_logged_in();

	}

	function edit($product_id)
	{
		$attributes = array(
				'currency_symbol',
			);
		$countries = $data['countries'] = $this->CModel->get_rows_from('country','country_id,country',$attributes);
		$parent_categories = $data['parent_categories'] = $this->CModel->get_taxonomy_names_by_parent_id('product','0');

		//get product data
		$attributes = array(
			'shipping_options',
			'product_prices',
			'product_primary_image',
			'product_gallery_images',
			'product_category_id',
			'product_countries_id'
		);
		$product_data = $this->CModel->get_row('product','*',$product_id,$attributes);

		$product_value_object = new stdClass();
		foreach ($product_data as $key => $product_value) {
			$product_value_object->$key = $product_value;
		}

		//object to send to view
		$product = new stdClass();
		//product details 
		$product->id = $product_value_object->product_id;
		$product->name = $product_value_object->title;
		$product->desc = $product_value_object->description;
		$product->specs = json_decode($product_value_object->specifications);
		$product->primary_price = $product_value_object->price;
		$product->primary_sale_price = $product_value_object->sale_price;
		$product->status = $product_value_object->status;
		$product->shipping_options = json_decode($product_value_object->shipping_options);
		$product->product_prices = json_decode($product_value_object->product_prices);
		$product->primary_image = $product_value_object->product_primary_image;
		$product->gallary_images = explode(',',$product_value_object->product_gallery_images);
		$product->category_id = $product_value_object->product_category_id;
		$product->selling_countries_id = explode(',', $product_value_object->product_countries_id);

		//joining countries data with selected country data
		foreach ($countries as $key => $country) {
			for ($i=0; $i < count($product->selling_countries_id); $i++) { 
				if ($country->country_id == $product->selling_countries_id[$i]) {
					$country->selling_here = true;
				}
			}
			
		}

		foreach ($countries as $key => $country) {
			if (!isset($country->selling_here)) {
				$country->selling_here = false;
			}
		}

		//joining prices data with selected country data
		$product->product_prices = (array) $product->product_prices; 

		foreach ($countries as $key => $country) {
			for ($i=0; $i < count($product->product_prices); $i++) { 
				if ($country->country_id == $product->product_prices[$i]->country_id) {
					$product->product_prices[$i]->country_name = $country->country;
					$product->product_prices[$i]->currency_symbol = $country->currency_symbol;
				}
			}
			
		}

		//joining shipping options with selected country data
		//create empty array for selected coutries
		$shipping_options_selected_countries = [];
		for ($i=0; $i < count($product->selling_countries_id); $i++) { 
			$shipping_options_selected_countries[$i] = new stdClass();
		}

		//add country ID to shipping_options_selected_countries array
		foreach ($countries as $key => $country) {
			for ($i=0; $i < count($shipping_options_selected_countries); $i++) {
				if ($product->selling_countries_id[$i] == $country->country_id) {
					$shipping_options_selected_countries[$i]->country_id = $product->selling_countries_id[$i];
					$shipping_options_selected_countries[$i]->country_name = $country->country;
					$shipping_options_selected_countries[$i]->shipping_options = [];
				}
			}
		}

		for ($i=0; $i < count($product->selling_countries_id); $i++) { 
			foreach ($product->shipping_options as $country_id => $options_id_array) {
				if ($product->selling_countries_id[$i] == $country_id) {
					for ($j=0; $j < count($options_id_array); $j++) { 
						$shipping_options_selected_countries[$i]->shipping_options[$j] = new stdClass();
						$shipping_options_selected_countries[$i]->shipping_options[$j]->option_id = $options_id_array[$j];
						$shipping_options_selected_countries[$i]->shipping_options[$j]->option_name = $this->CModel->get_row('shipping_option','name',$options_id_array[$j])['name'];
					}
				}
			}
		}


		$product->shipping_options_selected_countries = $shipping_options_selected_countries;

		//preparing category data for selected product
		$parent_categories_collections = array();
		$category_id = $product->category_id;
		
		$all_parents = $this->CModel->get_parents_by_taxonomy_id($category_id);


		for ($i=0; $i < count($all_parents); $i++) {
			$parent_id = $all_parents[$i]['parent_id'];
			$parent_categories = $this->CModel->get_taxonomy_names_by_parent_id('product',$parent_id);
			
			foreach ($parent_categories as $parent_category) {
				if ($all_parents[$i]['product_taxonomy_id'] == $parent_category->taxonomy_id) {
					$parent_category->selected = true;
				}else{
					$parent_category->selected = false;
				}
			}
			$parent_categories_collections[] = $parent_categories;
		}

		
		$parent_categories_collections = array_reverse($parent_categories_collections);

		$product->parent_categories_collections = $parent_categories_collections;

		//preparing specs data for selected product
		$product->specs = (array) $product->specs;

		//preparing product image
		$product->primary_image_src = $this->CModel->get_row('media','media_path',$product->primary_image);
		$product->primary_image_src = site_url($product->primary_image_src);

		$product->gallary_images_src = [];

		for ($i=0; $i < count($product->gallary_images); $i++) { 
			$product->gallary_images_src[$i] = site_url($this->CModel->get_row('media','media_path',$product->gallary_images[$i]));
		}



		if ($this->input->method() == 'get') 
		{	
			$data['countries'] = $countries;
			$data['parent_categories'] = $parent_categories;
			$data['product'] = $product;
			$this->load->view('dashboard/templates/header');
			$this->load->view('dashboard/product/product/edit_product',$data);
			$this->load->view('dashboard/templates/footer');
		}else{
			
			//parent_id from the form
			$category_ids = $this->input->post('category_id[]');
			if (count($category_ids)>1 && end($category_ids) == 'na') {
				$category_id = prev($category_ids);
			}
			elseif(end($category_ids) != 'na')
			{
				$category_id = end($category_ids);
			}

			$product_name = $this->input->post('product_name');
			$product_desc = $this->input->post('description');

			/*Validations for product name
			* rule: two products with same name under one category should not be allowed
			*/

			$is_valid =  $this->PModel->edit_product_name_validation($product_name,$category_id,$product_id);
			if ($is_valid == false) {
				$data = array('execute' => 'failure','message' => 'product name already exists in the same category');
				$data['countries'] = $countries;
				$data['parent_categories'] = $parent_categories; 
				$data['product'] = $product;
				$this->load->view('dashboard/templates/header');
				$this->load->view('dashboard/product/product/edit_product',$data);
				$this->load->view('dashboard/templates/footer');
			}else{		
				//prepare object for price
				$product_prices = $this->input->post('price');
				$product_sale_prices = $this->input->post('sale_price');
				$product_prices_array = [];


				for ($i=0; $i < count($product_prices); $i++) { 
					//creating array for each price country wise
					$product_prices_array[$i] = [];
					$temp_array_price = explode(',', $product_prices[$i]);
					$temp_array_sale_price = explode(',', $product_sale_prices[$i]);
					//populating the array
					$product_prices_array[$i]['country_id'] = $temp_array_price[0];
					$product_prices_array[$i]['price'] = $temp_array_price[1];
					$product_prices_array[$i]['sale_price'] = $temp_array_sale_price[1];

				}

				//convert price array into object
				$prices_object = (object) $product_prices_array;
				//convert object into json string
			    $product_prices_json = json_encode($prices_object);



			    //prepare object for shipping options
				$shipping_options = $this->input->post('shipping_option[]');
				$shipping_options_array = [];

				$last_country_id = null;
				for ($i=0; $i < count($shipping_options); $i++) { 
					$temp_array_shipping_option = explode(',',$shipping_options[$i]);

					if ($last_country_id != null && $last_country_id != $temp_array_shipping_option[0]) {
						$last_country_id = null;
					}
					

					if ($last_country_id == null) {
						$shipping_options_array[$temp_array_shipping_option[0]] = [];
						$last_country_id = $temp_array_shipping_option[0];
					}

				}

				foreach ($shipping_options_array as $key => $shipping_option) {
					for ($i=0; $i < count($shipping_options); $i++) 
					{ 
						$temp_array_shipping_option = explode(',',$shipping_options[$i]);
						if ($temp_array_shipping_option[0] == $key) {
							$shipping_option[] = $temp_array_shipping_option[1];
							// var_dump($shipping_option);
						}
					}

					$shipping_options_array[$key] = $shipping_option;
				}


				//convert shipping option prepared array into object
				$shipping_options_object = (object) $shipping_options_array;
				//convert object into json string
				$product_shipping_options = json_encode($shipping_options_object);

			    //primary price & sale price
			    for ($i=0; $i < count($product_prices); $i++) {
			    	//get primary shop country id
			    	$filter_keys_and_values = array(
			    		'setting_name' => 'primary_shop_country_id'
			    		);
			    	$primary_country_id = $this->CModel->get_row('setting','setting_value',null,null,$filter_keys_and_values)['setting_value'];

			    	$temp_array_price = explode(',', $product_prices[$i]);
			    	$temp_array_sale_price = explode(',', $product_sale_prices[$i]);

			    	if ($primary_country_id == $temp_array_price[0]) {
			    		//primary price
			    		$product_primary_price = $temp_array_price[1];
			    		//primary sale price
			    		$product_primary_sale_price = $temp_array_sale_price[1];
			    	}
			    }

				//prepare object for specs
				$spec_titles = $this->input->post('spec_title');
				$spec_details = $this->input->post('spec_details');
				$specs_object = new stdClass();

				for ($i=0; $i < count($this->input->post('spec_title')); $i++) { 
					$spec_title = $spec_titles[$i];
					$specs_object->$spec_title = $spec_details[$i];
				}

				//converting specs object into json string
				$product_specs = json_encode($specs_object);

				$product_status = $this->input->post('status');
				$user_updated_id = $this->session->admin_id;
				$product_selling_countries = $this->input->post('country_id[]');
				$product_selling_countries_id = implode(',', $product_selling_countries);

				$product_primary_price = $product_primary_price;
				$product_primary_sale_price = $product_primary_sale_price;
				$product_name = $product_name;
				$product_desc = $product_desc;
				$product_prices_json = $product_prices_json;
				$product_specs = $product_specs;
				$product_status = $product_status;
				$product_shipping_options = $product_shipping_options;
				$user_updated_id = $user_updated_id;
				$product_selling_countries = $product_selling_countries;

				//add into product table
				$product_data = array(
					'title' => $product_name,
					'description' => $product_desc,
					'specifications' => $product_specs,
					'price' => $product_primary_price,
					'sale_price' => $product_primary_sale_price,
					'status' => $product_status,
					'last_updated' => null,
					'user_updated_id' => $user_updated_id,
				);
				$this->CModel->edit_table_row('product',$product_id,$product_data);
				//add into product attribute table
				$product_attribute_data = array(
					array(
						'product_id' => $product_id,
						'attribute' => 'shipping_options',
						'value' => $product_shipping_options,
						'last_updated' => null,
						'user_updated_id' => $user_updated_id
					),
					array(
						'product_id' => $product_id,
						'attribute' => 'product_prices',
						'value' => $product_prices_json,
						'last_updated' => null,
						'user_updated_id' => $user_updated_id
					),
					array(
						'product_id' => $product_id,
						'attribute' => 'product_countries_id',
						'value' => $product_selling_countries_id,
						'last_updated' => null,
						'user_updated_id' => $user_updated_id
					)
				);

				$this->CModel->edit_attribute_table_row('product',$product_id,$product_attribute_data);
				//add category id into product_taxonomy_map
				// $category_data = array(
				// 	'product_id' => $product_id,
				// 	'product_taxonomy_id' => $product_category_id
				// );

				// $this->CModel->add_into_table('product_taxonomy_map',$category_data);
				// }

				redirect('dashboard/product/view-all');


		}
		
		
	}
}
}