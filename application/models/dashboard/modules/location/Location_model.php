<?php 	 
defined('BASEPATH') OR exit('No direct script access allowed');


class Location_model extends CI_Model {
	public function __construct()
        {
            $this->load->database();
            $this->load->model('dashboard/settings/common_model', 'CModel');
        }
}
?>