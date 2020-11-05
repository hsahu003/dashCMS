<?php 	
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {
	public function __construct()
        {
        	$this->load->database();
            $this->load->model('dashboard/settings/common_model', 'CModel');
        }
     
     
     public function insert_admin($data)
        {
            $this->db->insert('admin', $data);
            return $this->db->insert_id();
        }
    
    public function insert_admin_meta($data){

        $this->db->insert('adminmeta',$data);
    }


    //accepts the metaKey(s) if user meta data also requires
    public function get_all_admin($metaKeys=null,$filterKey='',$filterValue=''){
        $this->db->select('*');
        $this->db->from('admin');
        if ($filterKey != '' && $filterValue != '') {
         $this->db->where($filterKey,$filterValue);
        }
        $query = $this->db->get();
        $admins = $query->result();

        // print_r($admins);
        // exit();


        if (is_string($metaKeys))
        {
            $metaKeys = explode(',', $metaKeys);
        }

        if ($metaKeys != null)
        {
            foreach ($admins as $key => $admin) {

                foreach ($metaKeys as $key => $metaKey)
                {
                    $media_id = $this->get_admin_meta($admin->ID,$metaKey,true);
                    $admin->{$metaKey} = $this->CModel->get_row('media','media_path',$media_id);
                }
            }
        }

        return $admins;
    }



    public function get_admin_meta($adminID,$metaKey,$onlyValue=false){
        $this->db->select('metaKey,metaValue');
        $this->db->from('adminmeta');
        $this->db->where('adminID',$adminID);
        $this->db->where('metaKey',$metaKey);
        $query = $this->db->get();
        $row_array = $query->row_array();

        //to avoid error msg if metakaey is passed but it does not exist in database
        if (is_array($row_array)) 
        {
            //onlyValue on being true returns only the metaValue
            if ($onlyValue === true)
            {
                return $row_array['metaValue'];
            }
            else
            {
                //it returns the metakey string parameter as key and returned metaValue as value
                $newArray = array(
                    $row_array['metaKey'] => $row_array['metaValue']
                );
                return $newArray = (object) $newArray;
            }
        }
    }

    /**
    * 
    * @param $username | either username or userid or email
    * @param $attributes | array or string | attributes name either in array or comman separated string
    * @param $filter_keys_and_values | array | to select rows with condition, where value matches the 
    *   key(column)
    * @return one user's complete detail in object array
    */
    public function get_admin($username,$metaKeys=null,$filter_keys_and_values=null){

            $this->db->where('email',$username);
            $this->db->or_where('username',$username);
            //get user by primary ID
            $this->db->or_where('ID',$username);
            if ($filter_keys_and_values!=null) 
            {
                foreach ($filter_keys_and_values as $key => $value) 
                {
                    $this->db->where($key,$value);
                }
            }
    		$query = $this->db->get('admin');
    		$admin =  $query->row_array();

            if (is_string($metaKeys))
            {
                $metaKeys = explode(',', $metaKeys);
            }

            if ($metaKeys != null)
            {
                foreach ($metaKeys as $key => $metaKey)
                {
                    $media_id = $this->get_admin_meta($admin['ID'],$metaKey,true);
                    $admin[$metaKey] = $this->CModel->get_row('media','media_path',$media_id);
                }
            }

            return $admin;
    }

    //remove admin
    public function remove_admin($adminID)
    {   
        //deletes row from user tabel
        $this->db->where('ID', $adminID);
        $this->db->delete('admin');

        //deletes row from adminmeta tabel
        $this->db->where('adminID', $adminID);
        $this->db->delete('adminmeta');
    }

    public function disable_admin($adminID){
        $this->db->set('status', '0');
        $this->db->where('ID', $adminID);
        $this->db->update('admin');
    }
}
?>