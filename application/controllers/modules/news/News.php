<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class News extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('style');

		//check for admin login session
		is_admin_logged_in();
	}

	function index(){
		$this->load->view('dashboard/templates/header');
		$this->load->view('dashboard/news/publish-new');
		$this->load->view('dashboard/templates/footer');
	}

	function publish_new(){
		$this->load->view('dashboard/templates/header');
		$this->load->view('dashboard/news/publish-new');
		$this->load->view('dashboard/templates/footer');
	}

	function all_posts(){
		$this->load->view('dashboard/templates/header');
		$this->load->view('dashboard/news/all-posts');
		$this->load->view('dashboard/templates/footer');
	}

	
}