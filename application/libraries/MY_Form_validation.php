<?php if ( defined('BASEPATH') === FALSE ) exit('No direct script access allowed');
// this is used as to extend the base form validation class, 

class MY_Form_validation extends CI_Form_validation
{

    function __construct($rules = array())
    {
        parent::__construct($rules);
    }


    public function is_attribute_unique($str, $field)
    {  
        sscanf($field, '%[^.].%[^.,],%[^.]', $table, $field, $attribute);
        $attribute_field = $table.'.attribute';
        return isset($this->CI->db)
            ? ($this->CI->db->limit(1)->get_where($table, array($field => $str,$attribute_field => $attribute))->num_rows() === 0)
            : FALSE;
    }

    public function edit_unique($str, $field)
    {
        sscanf($field, '%[^.].%[^.].%[^.].%[^.]', $table, $field,$id_field,$id);
        return isset($this->CI->db)
            ? ($this->CI->db->limit(1)->get_where($table, array($field => $str, $id_field.' != ' => $id))->num_rows() === 0)
            : FALSE;
    }

    public function edit_unique_attribute($str, $field)
    {   
        sscanf($field, '%[^.].%[^.].%[^.].%[^.].%[^.]', $table, $field, $attribute ,$id_field, $id);
        $attribute_field = $table.'.attribute';
        $this->CI->db->limit(1)->get_where($table, array($field => $str,$attribute_field => $attribute,$id_field.' != ' => $id))->num_rows();
        return isset($this->CI->db)
            ? ($this->CI->db->limit(1)->get_where($table, array($field => $str,$attribute_field => $attribute,$id_field.' != ' => $id))->num_rows() === 0)
            : FALSE;
    }

    public function is_unique_relative_to($str, $field)
    {   
        //here $relative_to is the joining table & and $match_id is used for joining two tables
        sscanf($field, '%[^.].%[^.].%[^.].%[^.]', $table, $field, $relative_to_id_field , $common_id_value);
        $this->CI->db->select('*');
        $this->CI->db->from($table);
        $this->CI->db->where($field,$str);
        $this->CI->db->where($relative_to_id_field, $common_id_value);
        $query = $this->CI->db->get();

        return isset($this->CI->db) ? ($query->num_rows() === 0) : FALSE;
    }

    
    public function is_unique_relative_to_other_table($str, $field)
    {
         sscanf($field, '%[^.].%[^.].%[^.].%[^.]', $table, $field, $relative_to_id_field , $common_id_value);
    }

    public function is_unique_through_attribute_relative_to_other_table($str, $field)
    {
        sscanf($field, '%[^.].%[^.].%[^.].%[^.]', $table, $field, $attribute, $common_id_value);

        $attribute_table = $table.'_attribute';
        $table_id = $table.'_id';

        $this->CI->db->select('at.value');
        $this->CI->db->from($table.' as t');
        $this->CI->db->join( $attribute_table. ' as at', 't.'.$table_id.' = at.'.$table_id);
        $this->CI->db->where('at.attribute',$attribute);
        $this->CI->db->where('t.'.$field,$str);

        $query = $this->CI->db->get();

        if ($query->row_array() != null) {
            $value = $query->row_array()['value'];
        }else{
            $value = '0';
        }
        
        if ($value == '0') {
             $return = true;
        }elseif ($value == $common_id_value) {
             $return = false;
        }
        //$value != $common_id_value
        else{
            $return = true;
        }
        
        return $return;
    }
    public function edit_unique_relative_to($str, $field)
    {   
        //here $relative_to is the joining table & and $match_id is used for joining two tables
        sscanf($field, '%[^.].%[^.].%[^.].%[^.].%[^.].%[^.]', $table, $field, $id_field , $id_field_value, $relative_to_id_field , $common_id_value);
        $this->CI->db->select('*');
        $this->CI->db->from($table);
        $this->CI->db->where($field,$str);
        $this->CI->db->where($id_field.' != ',$id_field_value);
        $this->CI->db->where($relative_to_id_field, $common_id_value);
        $query = $this->CI->db->get();
        return isset($this->CI->db) ? ($query->num_rows() === 0) : FALSE;
    }

    public function is_unique_taxonomy($str, $field){

        sscanf($field, '%[^.].%[^.].%[^.].%[^.]', $table, $field, $parent_id , $parent_id_value);

        $module_taxonomy_id = $table.'_id';
        $this->CI->db->select('*');
        $this->CI->db->from($table);
        $this->CI->db->where($field,$str);
        $this->CI->db->where($parent_id,$parent_id_value);
        $query = $this->CI->db->get();
        return isset($this->CI->db) ? ($query->num_rows() === 0) : FALSE;
    }

    public function edit_unique_taxonomy($str, $field){

        sscanf($field, '%[^.].%[^.].%[^.].%[^.].%[^.]', $table, $field, $parent_id , $parent_id_value, $module_taxonomy_id_value);

        $module_taxonomy_id = $table.'_id';
        $this->CI->db->select('*');
        $this->CI->db->from($table);
        $this->CI->db->where($field,$str);
        $this->CI->db->where($module_taxonomy_id.' != ',$module_taxonomy_id_value);
        $this->CI->db->where($parent_id,$parent_id_value);
        $query = $this->CI->db->get();
        return isset($this->CI->db) ? ($query->num_rows() === 0) : FALSE;
    }
}