<?php 	
defined('BASEPATH') OR exit('No direct script access allowed');

function is_admin_logged_in() {
    // Get current CodeIgniter instance
    $CI =& get_instance();
    // We need to use $CI->session instead of $this->session
    $admin_logged_in = $CI->session->admin_logged_in;
    if ($admin_logged_in)	
    {
    	return true; 
    } 
    else
    {
    	//go to login page
		redirect('dashboard/login');
		exit();
    }
}

 ?>