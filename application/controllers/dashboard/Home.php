<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('common/common_media');

		//check for login session
		is_admin_logged_in();
	}

	function index(){

		$this->load->view('dashboard/templates/header');
		$this->load->view('dashboard/home');
		$this->load->view('dashboard/templates/footer');
		
	}



	
}