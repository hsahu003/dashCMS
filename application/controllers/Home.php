<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('common/common_media');
		$this->load->model('dashboard/settings/common_model', 'CModel');

	}

	public function index()
	{	
		$this->load->view('frontend/templates/header.php');
		$this->load->view('frontend/home/home.php');
		$this->load->view('frontend/templates/footer.php');
	}
}
