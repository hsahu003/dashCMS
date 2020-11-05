<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH."controllers/modules/shop_setting/location/Location.php");

class State extends Location {
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');

		//check for admin login session
		is_admin_logged_in();
	}

	//view states by country
	public function view_states($country_id=null)
	{	
		if(isset($country_id)){
			$attributes = array(
				'state_code'
			);
			$filter_keys_and_values = array(
				'country_id' => $country_id
			); 
			$data['states'] = $this->CModel->get_rows_from('state','*',$attributes,$filter_keys_and_values);
			$data['country'] = $this->CModel->get_row('country','country,country_id',$country_id);

			//do not select the country with $country_id
			$filter_keys_and_values = array(
				'country_id !=' => $country_id
			);
			$data['countries'] = $this->CModel->get_rows_from('country','country,country_id',null,$filter_keys_and_values);
		}else{
			$data['states'] = array();
			$data['countries'] = $this->CModel->get_rows_from('country','country,country_id');
		}
		
		$this->load->view('dashboard/templates/header');
		$this->load->view('dashboard/shop_setting/location/state/view_states',$data);
		$this->load->view('dashboard/templates/footer');
	}

	public function add_state()
	{	
		$countries = $data['countries'] = $this->CModel->get_rows_from('country','country,country_id');
		if($this->input->method() == 'get')
		{	
			$this->load->view('dashboard/templates/header');
			$this->load->view('dashboard/shop_setting/location/state/add_state',$data);
			$this->load->view('dashboard/templates/footer');
		}
		else
		{
			$this->load->library('form_validation');
			//Validations
			$this->form_validation->set_rules('country_id','Country','required');

			$country_id = $this->input->post('country_id');
			$this->form_validation->set_rules('state_name','State Name','required|is_unique_relative_to[state.state.country_id.'.$country_id.']');

			$this->form_validation->set_rules('state_code','ISO State Code','required|is_attribute_unique[state_attribute.value,state_code]|exact_length[5]');
			$this->form_validation->set_message('is_attribute_unique', '{field} already exists in database.');
			$this->form_validation->set_message('is_unique_relative_to', '{field} already exists in database.');
			$this->form_validation->run();

			//Run Validations
			if($this->form_validation->run() === FALSE)
			{
				$errors = array_values($this->form_validation->error_array());
				$data = array('execute' => 'failure','message' => $errors[0]);

				//do not select the country with $country_id
				$filter_keys_and_values = array(
					'country_id !=' => $country_id
				);
				$data['countries'] = $this->CModel->get_rows_from('country','country,country_id',null,$filter_keys_and_values);

				$data['country'] = $this->CModel->get_row('country','country,country_id',$country_id);
				$this->load->view('dashboard/templates/header');
				$this->load->view('dashboard/shop_setting/location/state/add_state',$data);
				$this->load->view('dashboard/templates/footer');
			}
			else
			{
				//prepare data
				$time = date("Y-m-d H:i:s");
				$state = array(
					'state' => $this->input->post('state_name'),
					'country_id' => $this->input->post('country_id'),
					'date_created' => $time,
					'last_updated' => null,
					'user_created_id' => $this->session->admin_id
				);

				$state_id = $this->CModel->add_into_table('state',$state);

				$state_attribute = array(
					array(
						'state_id' => $state_id,
						'attribute' => 'state_code',
						'value' => trim(strtoupper($this->input->post('state_code'))),
						'date_create' => $time,
						'last_updated' => null,
						'user_created_id' => $this->session->admin_id
					)
				);

					$this->CModel->add_into_attribute_table('state',$state_attribute);
				    redirect('dashboard/shop-setting/location/view/state/c/'.$country_id);
				}
			
		}
	}

	public function edit_state($state_id)
	{	
		//get county details to edit
		$attributes = array(
			'state_code'
		);
		$state_details = $this->CModel->get_row('state','*',$state_id,$attributes,null);
		$country_id = $state_details['country_id'];
		$country = $this->CModel->get_row('country','*',$country_id);
		if ($this->input->method() == 'get') {
		
			

			$data['country'] = $country;
			$data['state'] = $state_details;

			$this->load->view('dashboard/templates/header');
			$this->load->view('dashboard/shop_setting/location/state/edit_state',$data);
			$this->load->view('dashboard/templates/footer');
		}
		//thorugh the form
		else
		{
			$this->load->library('form_validation');
			//Validations
			$this->form_validation->set_rules('state_name','State Name','required|edit_unique_relative_to[state.state.state_id.'.$state_id.'.country_id.'.$country_id.']');

			$this->form_validation->set_rules('state_code','ISO State Code','required|edit_unique_attribute[state_attribute.value.state_code.state_id.'.$state_id.']|exact_length[5]');

			$this->form_validation->set_message('edit_unique_relative_to', '{field} already exists in database.');
			$this->form_validation->set_message('edit_unique_attribute', '{field} already exists in database.');
			$this->form_validation->run();

			//Run Validations
			if($this->form_validation->run() === FALSE)
			{
				$errors = array_values($this->form_validation->error_array());
				$data = array('execute' => 'failure','message' => $errors[0]);
				$data['state'] = $state_details;
				$data['country'] = $country;
				$this->load->view('dashboard/templates/header');
				$this->load->view('dashboard/shop_setting/location/state/edit_state',$data);
				$this->load->view('dashboard/templates/footer');
			}
			else
			{
				//prepare data
				$time = date("Y-m-d H:i:s");
				$state = array(
					'state' => $this->input->post('state_name'),
					'last_updated' => null
				);

				$this->CModel->edit_table_row('state',$state_id,$state);

				$state_attribute = array(
					array(
						'state_id' => $state_id,
						'attribute' => 'state_code',
						'value' => trim(strtoupper($this->input->post('state_code'))),
						'last_updated' => null
					)
				);

				$this->CModel->edit_attribute_table_row('state',$state_id,$state_attribute);
				redirect('dashboard/shop-setting/location/view/state/c/'.$country_id);
				}
		}
	}

	public function delete_state($state_id,$country_id=null)
	{	
		$this->CModel->delete_row_attributes_from('state',$state_id);
		$this->CModel->delete_row_from('state',$state_id);

		redirect('dashboard/shop-setting/location/view/state/c/'.$country_id);
	}
}
