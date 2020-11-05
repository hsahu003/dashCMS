<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('common/common_media');
		$this->load->model('dashboard/settings/admin_model', 'AModel');

		// checks if admin is logged or redirects to login page
		is_admin_logged_in();
	}

	//view admin
	public function view_admins($filterKey,$filterValue=''){

			//get admins from user table
			if ($filterKey == 'all') {
				$data['users'] = $this->AModel->get_all_admin('user_image_id');
			}else{
				$data['users'] = $this->AModel->get_all_admin('user_image_id',$filterKey,$filterValue);
			}
			
			$data['total_user'] = count($data['users']);
			$data['filterValue'] = $filterValue;
			$data['filterKey'] = $filterKey;

			if ($filterKey == 'status') {
				if ($filterValue == '1') {
					$data['sortby'] = 'Active Admins';
				}else{
					$data['sortby'] = 'Disabled Admins';
				}
			}elseif ($filterKey == 'superadmin') {
				if ($filterValue == '1') {
					$data['sortby'] = 'Super Admins';
				}
			}elseif ($filterKey == 'all') {
					$data['sortby'] = 'All Admins';
			}

			$this->load->view('dashboard/templates/header');
			$this->load->view('dashboard/settings/admin/view_admins',$data);
			$this->load->view('dashboard/templates/footer');
		
	}

	//add admin
	public function add_admin(){

			$this->load->helper('form');

			//if form is not submitted
			if($this->input->method() == 'get'){
				$this->load->view('dashboard/templates/header');
				$this->load->view('dashboard/settings/admin/add_admin');
				$this->load->view('dashboard/templates/footer');
			}else{
				$this->load->library('form_validation');

				//validation of form input
				$this->form_validation->set_rules('firstname','First Name','required');
				$this->form_validation->set_rules('lastname','Last Name','required');
				$this->form_validation->set_rules('email','Email','required|valid_email|is_unique[admin.email]');
				$this->form_validation->set_rules('username','User Name','required|is_unique[admin.username]');
				$this->form_validation->set_rules('password','Password','required|min_length[6]');
				$this->form_validation->set_rules('passwordConfirmed','Password Confirmation','required|matches[password]');

				// Run Validations
				if($this->form_validation->run() === FALSE){
					$errors = array_values($this->form_validation->error_array());
					$data = array('execute' => 'failure','message' => $errors[0]);
					$this->load->view('dashboard/templates/header');
					$this->load->view('dashboard/settings/admin/add_admin',$data);
					$this->load->view('dashboard/templates/footer');
				}else{
					//preparing array to insert into user table
					$time = date("Y-m-d H:i:s");
					$user = array(
						'firstName' => $this->input->post('firstname'),
						'lastName' => $this->input->post('lastname'),
						'email' => $this->input->post('email'),
						'username' => $this->input->post('username'),
						'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
						'passwordRecovery' => '',
						'role' => $this->input->post('role'),
						'status' => $this->input->post('status'),
						'lastLogin' => $time,
						'dateCreated' => $time,
					);

					//inserts array into user table and returns the newly created user id
					$userID = $this->AModel->insert_admin($user);

					if ($this->input->post('image_id') != '') {
						$userMeta = array(
						'adminID' => $userID,
						//refer trello for user metaKey list
						'metaKey' => 'user_image_id',
						'metaValue' => $this->input->post('image_id')
						);

						$this->AModel->insert_admin_meta($userMeta);
					}

					redirect('/dashboard/settings/admin/view');
				}
			}
	}

	//remove admin
	public function remove_admin($adminIDs)
	{

		$data = [];

		if (is_string($adminIDs))
        {
            $adminIDs = explode(',', $adminIDs);
        }

		foreach ($adminIDs as $adminID) 
		{
			//get user 
			$user = $this->AModel->get_admin($adminID);

			//do not delete the super admin
			if ($user['superAdmin'] == '1') {
				$data['superAdmin'] = true;
				return $data;
			}
			else
			{
				$this->AModel->remove_admin($adminID);
				$data['superAdmin'] = false;
				return $data;
			}
		}
	}

	public function disable_admin($adminIDs){

		$data = [];

		if (is_string($adminIDs))
        {
            $adminIDs = explode(',', $adminIDs);
        }

		foreach ($adminIDs as $adminID) 
		{
			//get user 
			$user = $this->AModel->get_admin($adminID);

			//do not delete the super admin
			if ($user['superAdmin'] == '1') {
				$data['superAdmin'] = true;
				return $data;
			}
			else
			{
				$this->AModel->disable_admin($adminID);
				$data['superAdmin'] = false;
				return $data;
			}
		}

	}

	public function edit_admin($adminID){
	

		$this->load->helper('form');

		//get user
		$admin = $this->AModel->get_admin($adminID,'user_image_id');
		$data['admin'] = $admin;

		switch ($admin['role']) {
			case 'editor':
				$roleDesc = 'Editor (can add and edit content | cannot: manage admins, edit the settings)';
				break;
			case 'visitor':
				$roleDesc = 'Viewer (can view only)';
				break;
			case 'moderator':
				$roleDesc = 'Moderator (can add, edit and delete content, edit some settings | cannot: manage admins)';
				break;
			case 'admin':
				$roleDesc = 'Super Admin (cannot disable super admin account)';
				break;
		}
		$data['roleDesc'] = $roleDesc;

		if (false) {
			# code...
		}
		else
		{
			$this->load->view('dashboard/templates/header',$data);
			$this->load->view('dashboard/settings/admin/edit_admin');
			$this->load->view('dashboard/templates/footer');
		}

		

	}

	//remove admin ajax
	public function ajax_remove_admin(){

		foreach (json_decode($_POST['data']) as $adminID) 
		{ 
			$data = $this->remove_admin($adminID);
			if ($data['superAdmin'] === true) 
			{
				echo 'Super admin can not be deleted';
			}
		}
	}

	//disable admin ajax
	public function ajax_disable_admin(){

		foreach (json_decode($_POST['data']) as $adminID) 
		{ 
			$data = $this->disable_admin($adminID);
			if ($data['superAdmin'] === true) 
			{
				echo 'Super admin can not be Disabled';
			}
		}
	}

	

}
