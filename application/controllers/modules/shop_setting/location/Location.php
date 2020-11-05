<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Location extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('common/common_media');
		$this->load->model('dashboard/settings/common_model', 'CModel');

		//check for admin login session
		is_admin_logged_in();

	}

	function index(){
		$this->load->view('dashboard/templates/header');
		$this->load->view('dashboard/shop_setting/location/index');
		$this->load->view('dashboard/templates/footer');
	}
}