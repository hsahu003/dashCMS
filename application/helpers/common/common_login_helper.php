<?php 	
defined('BASEPATH') OR exit('No direct script access allowed');

function is_admin_logged_in() {
    // Get current CodeIgniter instance
    $CI =& get_instance();
    // We need to use $CI->session instead of $this->session
    $admin_logged_in = $CI->session->admin_logged_in;
    $firstName = $CI->session->firstName;
    //active or disabled status
    $status = $CI->session->status;
    if ($admin_logged_in && $status == 1)	
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