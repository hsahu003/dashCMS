<?php 	 
defined('BASEPATH') OR exit('No direct script access allowed');

class Common_model extends CI_Model {
	public function __construct()
        {
        	$this->load->database();
        }
     

    // media module
    public function add_image($data){
            $this->db->insert('media',$data);
            return $this->db->insert_id();
    }

    
}
?>