<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH."controllers/modules/shop_setting/location/Location.php");

class Country extends Location {
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');

		//check for admin login session
		is_admin_logged_in();
	}

	public function view_countries()
	{	
		$attributes = array(
			'country_code',
			'currency_code',
			'currency_symbol'
		);
		$data['countries'] = $this->CModel->get_rows_from('country','*',$attributes);
		$this->load->view('dashboard/templates/header');
		$this->load->view('dashboard/shop_setting/location/country/view_countries',$data);
		$this->load->view('dashboard/templates/footer');
	}

	public function add_country()
	{	
		
		if($this->input->method() == 'get')
		{	
			$this->load->view('dashboard/templates/header');
			$this->load->view('dashboard/shop_setting/location/country/add_country');
			$this->load->view('dashboard/templates/footer');
		}
		else
		{
			$this->load->library('form_validation');
			//Validations
			$this->form_validation->set_rules('country_name','Country Name','required|is_unique[country.country]');
			$this->form_validation->set_rules('country_code','ISO Country Code','required|is_attribute_unique[country_attribute.value,country_code]|exact_length[2]');
			$this->form_validation->set_rules('currency_code','ISO Currency Code','required|is_attribute_unique[country_attribute.value,currency_code]|exact_length[3]');
			//two coutries can have same currency symbol like USD and AUD hence same row is allowed
			$this->form_validation->set_rules('currency_symbol','Currency Symbol','required');
			$this->form_validation->set_message('is_attribute_unique', '{field} already exists in database.');
			$this->form_validation->run();

			//Run Validations
			if($this->form_validation->run() === FALSE)
			{
				$errors = array_values($this->form_validation->error_array());
				$data = array('execute' => 'failure','message' => $errors[0]);
				$this->load->view('dashboard/templates/header');
				$this->load->view('dashboard/shop_setting/location/country/add_country',$data);
				$this->load->view('dashboard/templates/footer');
			}
			else
			{
				//prepare data
				$time = date("Y-m-d H:i:s");
				$country = array(
					'country' => $this->input->post('country_name'),
					'date_created' => $time,
					'last_updated' => null,
					'user_created_id' => $this->session->admin_id
				);

				$country_id = $this->CModel->add_into_table('country',$country);

				$country_attribute = array(
					array(
						'country_id' => $country_id,
						'attribute' => 'country_code',
						'value' => trim(strtoupper($this->input->post('country_code'))),
						'date_create' => $time,
						'last_updated' => null,
						'user_created_id' => $this->session->admin_id
					),
					array(
						'country_id' => $country_id,
						'attribute' => 'currency_code',
						'value' => trim(strtoupper($this->input->post('currency_code'))),
						'date_create' => $time,
						'last_updated' => null,
						'user_created_id' => $this->session->admin_id
					),
					array(
						'country_id' => $country_id,
						'attribute' => 'currency_symbol',
						'value' => trim($this->input->post('currency_symbol')),
						'date_create' => $time,
						'last_updated' => null,
						'user_created_id' => $this->session->admin_id
					)
				);

					$this->CModel->add_into_attribute_table('country',$country_attribute);
				    redirect('dashboard/shop-setting/location/view/country');
				}
			
		}
	}

	public function edit_country($country_id)
	{	
		//get county details to edit
		$attributes = array(
			'country_code',
			'currency_code',
			'currency_symbol'
		);
		$country_details = $this->CModel->get_row('country','*',$country_id,$attributes,null);
		if ($this->input->method() == 'get') {
			
			$data['country'] = $country_details;

			$this->load->view('dashboard/templates/header');
			$this->load->view('dashboard/shop_setting/location/country/edit_country',$data);
			$this->load->view('dashboard/templates/footer');
		}
		//thorugh the form
		else
		{
			$this->load->library('form_validation');
			//Validations
			$this->form_validation->set_rules('country_name','Country Name','required|edit_unique[country.country.country_id.'.$country_id.']');

			$this->form_validation->set_rules('country_code','ISO Country Code','required|edit_unique_attribute[country_attribute.value.country_code.country_id.'.$country_id.']|exact_length[2]');


			$this->form_validation->set_rules('currency_code','ISO Currency Code','required|edit_unique_attribute[country_attribute.value.currency_code.country_id.'.$country_id.']|exact_length[3]');

			//two coutries can have same currency symbol like USD and AUD hence same row is allowed
			$this->form_validation->set_rules('currency_symbol','Currency Symbol','required');
			$this->form_validation->set_message('edit_unique', '{field} already exists in database.');
			$this->form_validation->set_message('edit_unique_attribute', '{field} already exists in database.');
			$this->form_validation->run();

			//Run Validations
			if($this->form_validation->run() === FALSE)
			{
				$errors = array_values($this->form_validation->error_array());
				$data = array('execute' => 'failure','message' => $errors[0]);
				$data['country'] = $country_details;
				$this->load->view('dashboard/templates/header');
				$this->load->view('dashboard/shop_setting/location/country/edit_country',$data);
				$this->load->view('dashboard/templates/footer');
			}
			else
			{
				//prepare data
				$time = date("Y-m-d H:i:s");
				$country = array(
					'country' => $this->input->post('country_name'),
					'date_created' => $time,
					'last_updated' => null,
					'user_created_id' => $this->session->admin_id
				);

				$this->CModel->edit_table_row('country',$country_id,$country);

				$country_attribute = array(
					array(
						'country_id' => $country_id,
						'attribute' => 'country_code',
						'value' => trim(strtoupper($this->input->post('country_code'))),
						'date_create' => $time,
						'last_updated' => null,
						'user_created_id' => $this->session->admin_id
					),
					array(
						'country_id' => $country_id,
						'attribute' => 'currency_code',
						'value' => trim(strtoupper($this->input->post('currency_code'))),
						'date_create' => $time,
						'last_updated' => null,
						'user_created_id' => $this->session->admin_id
					),
					array(
						'country_id' => $country_id,
						'attribute' => 'currency_symbol',
						'value' => trim($this->input->post('currency_symbol')),
						'date_create' => $time,
						'last_updated' => null,
						'user_created_id' => $this->session->admin_id
					)
				);	

					$this->CModel->edit_attribute_table_row('country',$country_id,$country_attribute);
				    redirect('dashboard/shop-setting/location/view/country');
				}
		}
	}

	public function delete_country($country_id)
	{	
		//check if state belonging to this country exists in database
		$do_states_exist = $this->CModel->do_child_rows_exist('state','country_id',$country_id);
		
		if (!$do_states_exist) {
			$this->CModel->delete_row_attributes_from('country',$country_id);
			$this->CModel->delete_row_from('country',$country_id);
		}

		redirect('dashboard/shop-setting/location/view/country');
	}
}
