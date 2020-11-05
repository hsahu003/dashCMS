<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Add_product extends CI_Controller {
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

	function add()
	{
		$attributes = array(
				'currency_symbol'
			);
		$countries = $data['countries'] = $this->CModel->get_rows_from('country','country_id,country',$attributes);
		$parent_categories = $data['parent_categories'] = $this->CModel->get_taxonomy_names_by_parent_id('product','0');

		if ($this->input->method() == 'get') 
		{	
			$data['countries'] = $countries;
			$data['parent_categories'] = $parent_categories; 
			$this->load->view('dashboard/templates/header');
			$this->load->view('dashboard/product/product/add_product',$data);
			$this->load->view('dashboard/templates/footer');
		}else{

			//form validation
			$this->load->library('form_validation');
			

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

			$is_valid =  $this->PModel->add_product_name_validation($product_name,$category_id);
			if ($is_valid == false) {
				$data = array('execute' => 'failure','message' => 'product name already exists in the same category');
				$data['countries'] = $countries;
				$data['parent_categories'] = $parent_categories; 
				$this->load->view('dashboard/templates/header');
				$this->load->view('dashboard/product/product/add_product',$data);
				$this->load->view('dashboard/templates/footer');
			}else{

				//prepare object for price
				$product_prices = $this->input->post('price[]');
				$product_sale_prices = $this->input->post('sale_price[]');
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
				$shipping_options = $this->input->post('shipping_option');
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
				$time = date("Y-m-d H:i:s");
				$user_created_id = $this->session->admin_id;
				$product_primary_image = $this->input->post('primary_image');
				$product_other_images = $this->input->post('product_images');
				$product_category_id = $category_id;
				$product_selling_countries = $this->input->post('country_id[]');
				$product_selling_countries_id = implode(',', $product_selling_countries);

				$product_primary_price = $product_primary_price;
				$product_primary_sale_price = $product_primary_sale_price;
				$product_name = $product_name;
				$product_desc = $product_desc;
				$product_prices_json = $product_prices_json;
				$product_specs = $product_specs;
				$product_status = $product_status;
				$date_created = $time;
				$product_shipping_options = $product_shipping_options;
				$product_primary_image = $product_primary_image;
				$product_other_images = $product_other_images;
				$user_created_id = $user_created_id;
				$product_category_id  = $product_category_id;
				$product_selling_countries_id = $product_selling_countries_id;

				//add into product table
				$product_data = array(
					'title' => $product_name,
					'description' => $product_desc,
					'specifications' => $product_specs,
					'price' => $product_primary_price,
					'sale_price' => $product_primary_sale_price,
					'status' => $product_status,
					'date_created' => $date_created,
					'last_updated' => null,
					'user_created_id' => $user_created_id,
				);
				$product_id = $this->CModel->add_into_table('product',$product_data);
				//add into product attribute table
				$product_attribute_data = array(
					array(
						'product_id' => $product_id,
						'attribute' => 'shipping_options',
						'value' => $product_shipping_options,
						'date_created' => $date_created,
						'last_updated' => null,
						'user_created_id' => $user_created_id
					),
					array(
						'product_id' => $product_id,
						'attribute' => 'product_prices',
						'value' => $product_prices_json,
						'date_created' => $date_created,
						'last_updated' => null,
						'user_created_id' => $user_created_id
					),
					array(
						'product_id' => $product_id,
						'attribute' => 'product_primary_image',
						'value' => $product_primary_image,
						'date_created' => $date_created,
						'last_updated' => null,
						'user_created_id' => $user_created_id
					),
					array(
						'product_id' => $product_id,
						'attribute' => 'product_gallery_images',
						'value' => $product_other_images,
						'date_created' => $date_created,
						'last_updated' => null,
						'user_created_id' => $user_created_id
					),
					array(
						'product_id' => $product_id,
						'attribute' => 'product_category_id',
						'value' => $product_category_id,
						'date_created' => $date_created,
						'last_updated' => null,
						'user_created_id' => $user_created_id
					),
					array(
						'product_id' => $product_id,
						'attribute' => 'product_countries_id',
						'value' => $product_selling_countries_id,
						'date_created' => $date_created,
						'last_updated' => null,
						'user_created_id' => $user_created_id
					)
				);

				$this->CModel->add_into_attribute_table('product',$product_attribute_data);
				//add category id into product_taxonomy_map
				$category_data = array(
					'product_id' => $product_id,
					'product_taxonomy_id' => $product_category_id
				);

				$this->CModel->add_into_table('product_taxonomy_map',$category_data);
				redirect('dashboard/product/view-all');
				}

				


		}
		
		
	}
}