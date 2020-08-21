<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('common/common_media');
		$this->load->helper('form');
		$this->load->model('dashboard/settings/admin_model', 'AModel');

	}

	public function index(){
		
		if($this->input->method() == 'get')
		{
			if($this->session->logged_in){
				redirect('dashboard');
			}
			else
			{
				$this->load->view('dashboard/login');
			}
		}
		else
		{
			$this->load->library('form_validation');

			// Validations
			$this->form_validation->set_rules('username','User Name/Email','required');
			$this->form_validation->set_rules('password','Password','required');

			// Run Validations
			if($this->form_validation->run() === FALSE)
			{
				$errors = array_values($this->form_validation->error_array());
				$data = array('execute' => 'failure','message' => $errors[0]);
				$this->load->view('dashboard/login',$data);
			}
			else
			{	

				// Check user credential
				$admin = $this->AModel->get_admin($this->input->post('username'));
				if(isset($admin) && password_verify($this->input->post('password'), $admin['password'])){
					$adminData = array(
					'admin_id' => $admin['ID'],
					'firstName' => $admin['firstName'],
					'lastName' => $admin['lastName'],
					'email' => $admin['email'],
					'mobile' => $admin['mobile'],
					'role' => $admin['role'],
					'superAdmin' => $admin['superAdmin'],
					'status' => $admin['status'],
					'admin_logged_in' => true,
						);
					$this->session->set_userdata($adminData);
					redirect('dashboard');
				}else{

					// Mismatch user credential
					$data = array('execute' => 'failure','message' => 'email/username and password did not match');
					$this->load->view('dashboard/login',$data);
				}

			}
		}
		
	}

	public function logout()
	{
		if($this->session->admin_logged_in){
			$usersession = array('admin_id','firstName','lastName','email','mobile','role','superAdmin','status','admin_logged_in');
			$this->session->unset_userdata($usersession);
			$this->session->set_flashdata(['execute' => 'success','message' => 'Successfully Logged Out.']);
		}
		redirect('dashboard');
	}

}


 ?>