<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH."controllers/modules/shop_setting/shipping/Shipping.php");

class Option extends Shipping {
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');

		//check for admin login session
		is_admin_logged_in();

	}

	public function view()
	{	
		$attributes = array(
			'so_country',
			'so_country_state',
			'so_delivery_dutation'
		);
		$options = $data['options'] = $this->CModel->get_rows_from('shipping_option','*',$attributes);
		foreach ($options as $option) {
			$country_id = $option->so_country;
			$attributes = array(
				'currency_symbol',
			);
			$country_details = $this->CModel->get_row('country','*',$country_id,$attributes);
			$option->country_id = $country_details['country_id'];
			$option->country = $country_details['country'];
			$option->currency_symbol = $country_details['currency_symbol'];
		}
		$this->load->view('dashboard/templates/header');
		$this->load->view('dashboard/shop_setting/shipping/option/view_options',$data);
		$this->load->view('dashboard/templates/footer');
	}

	public function get_options_by_country_id($country_id){
		$filter_keys_and_values = array(
			'attribute' => 'so_country',
			'value' => $country_id
		);
		$result = $this->CModel->get_joined_rows_from('shipping_option','shipping_option_attribute','shipping_option_id',$filter_keys_and_values);

		echo json_encode($result);
	}

	// adds new shipping option in the data base
	public function add(){

		$attributes = array(
				'currency_symbol'
			);
		$countries = $data['countries'] = $this->CModel->get_rows_from('country','country_id,country',$attributes);
		if($this->input->method() == 'get')
		{	
			$this->load->view('dashboard/templates/header');
			$this->load->view('dashboard/shop_setting/shipping/option/add_option',$data);
			$this->load->view('dashboard/templates/footer');
		}else{
			//Validations
			$this->load->library('form_validation');

			$country_id = $this->input->post('option_country');

			$this->form_validation->set_rules('option_name', 'Option Name', 'required|is_unique_through_attribute_relative_to_other_table[shipping_option.name.so_country.'.$country_id.']');
			$this->form_validation->set_rules('option_country', 'Country', 'required');
			$this->form_validation->set_rules('option_country_state', 'State' , 'required');
			$this->form_validation->set_rules('option_cost', 'Shipping Cost', 'required');

			//run validation
			$this->form_validation->run();
			$this->form_validation->set_message('is_unique_through_attribute_relative_to_other_table', '{field} already exists in database.');

			//Run Validations
			if($this->form_validation->run() === FALSE)
			{
				$errors = array_values($this->form_validation->error_array());
				$data = array('execute' => 'failure','message' => $errors[0]);
				$data['countries'] = $countries;
				$this->load->view('dashboard/templates/header');
				$this->load->view('dashboard/shop_setting/shipping/option/add_option',$data);
				$this->load->view('dashboard/templates/footer');
			}else{
				$time = date("Y-m-d H:i:s");
				$data = array(
					'name' => $this->input->post('option_name'),
					'cost' => $this->input->post('option_cost'),
					'description' => $this->input->post('description'),
					'date_created' => $time,
					'last_updated' => null,
					'user_created_id' => $this->session->admin_id,
					'user_updated_id' => null

				);

				$shipping_option_id = $this->CModel->add_into_table('shipping_option',$data);

				$attribute_data = array(
					array(
						'shipping_option_id' => $shipping_option_id,
						'attribute' => 'so_country',
						'value' => $this->input->post('option_country'),
						'date_create' => $time,
						'last_updated' => null
					),
					array(
						'shipping_option_id' => $shipping_option_id,
						'attribute' => 'so_country_state',
						'value' => $this->input->post('option_country_state'),
						'date_create' => $time,
						'last_updated' => null
					),
					array(
						'shipping_option_id' => $shipping_option_id,
						'attribute' => 'so_delivery_dutation',
						'value' => $this->input->post('option_delivery_duration'),
						'date_create' => $time,
						'last_updated' => null
					)
				);

				$this->CModel->add_into_attribute_table('shipping_option',$attribute_data);

				redirect(site_url('dashboard/shop-setting/shipping/view/option'));
			}

		}
	}

	function edit($option_id){
		
	}

}