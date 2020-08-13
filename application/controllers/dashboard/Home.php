<?php 

class Home extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('common/common_media');
	}

	function index(){
		$this->load->view('dashboard/templates/header');
		$this->load->view('dashboard/home');
		$this->load->view('dashboard/templates/footer');
	}

	
}

 ?>