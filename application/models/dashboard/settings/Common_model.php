<?php 	 
defined('BASEPATH') OR exit('No direct script access allowed');

class Common_model extends CI_Model {
	public function __construct()
        {
        	$this->load->database();
        }
     
//-------------------------------------------------------------------------------------------
    /**
    *
    * @param $module | srting | table name
    * @param $columns | array or string | columns name either in array or comma separated string
    * @param $attributes | array or string | attributes name either in array or comman separated string
    * @param $filter_keys_and_values | array | to select rows with condition, where value matches the key *(column)
    * @param $orders | array | may conatin more than one array value | key = column name, value = order 
    * @param $limit | int | 
    * @param $offset | int |
    * @param $taxonomy_id | int |
    * 
    */
    public function get_rows_from($module,$columns='*',$attributes=null,$filter_keys_and_values=null,$orders=null,$limit=null,$offset=null,$taxonomy_id=null)
    {	
    	$module_taxonomy_map = $module . '_taxonomy_map';
        $module_taxonomy = $module . '_taxonomy';
        $module_id = $module.'_id';
        $module_taxonomy_id = $module.'_taxonomy_id ';

    	if (is_string($columns))
        {
            $columns = explode(',', $columns);
        }
    	$this->db->select($columns);
        $this->db->from($module .' as m');

        if ($taxonomy_id!=null) {
            $this->db->join($module_taxonomy_map.' as mtm','m.'.$module_id.' = mtm.'.$module_id);
            $this->db->join($module_taxonomy.' as mt','mtm.'.$module_taxonomy_id.' = mt.'.$module_taxonomy_id,'left');
            $this->db->where('mtm.'.$module_taxonomy_id,$taxonomy_id);
        }

        if ($filter_keys_and_values!=null) 
        {
        	foreach ($filter_keys_and_values as $key => $value) 
        	{
        		$this->db->where($key,$value);
        	}
        }

        if ($orders!=null) 
        {	
        	foreach($orders as $column => $order){
        		$this->db->order_by('m.'.$column , $order);
        	}
        }
    
        $this->db->limit($limit);
        $this->db->offset($offset);
        $query = $this->db->get();
        $rows = $query->result();

        // print_r($rows);
        // exit();


        if (is_string($attributes))
        {
            $attributes = explode(',', $attributes);
        }

        if ($attributes != null)
        { 
            foreach ($rows as $key => $row) {

                foreach ($attributes as $key => $attribute)
                {
                    $row->{$attribute} = $this->get_module_attribute($module,$row->$module_id,$attribute,true);
                }
            }
        }

        return $rows;
    }

    /**
    * joins two tables and then return data based applied conditions
    * @param filter_keys_and_values | array | to select rows with condition, where value matches the key *(column)
    */
    public function get_joined_rows_from($tabel, $tabel_to_join,$id_to_join,$filter_keys_and_values)
    { 
        $this->db->select('*');
        $this->db->from($tabel.' as t');
        $this->db->join($tabel_to_join.' as ttj','t.'.$id_to_join.' = ttj.'.$id_to_join);

        foreach ($filter_keys_and_values as $key => $value) 
        {
            $this->db->where($key,$value);
        }

        $query = $this->db->get();
        return $query->result();

    }

    /**
    *
    * @param $module | srting | table name
    * @param $columns | array or string | columns name either in array or comma separated string
    * @param $id | int | id of the module ex. media_id
    * @param $attributes | array or string | attributes name either in array or comman separated string 
    * @param $filter_keys_and_values | array | to select rows with condition, where value matches the
    */
    public function get_row($module,$columns='*',$id=null,$attributes=null,$filter_keys_and_values=null)
    {   
        $module_id = $module . '_id';
        if (is_string($columns))
        {
            $columns = explode(',', $columns);
        }
        $this->db->select($columns);
        $this->db->from($module);
        if ($id!=null) {
            $this->db->where($module_id,$id);
        }

        if ($filter_keys_and_values!=null) 
        {
            foreach ($filter_keys_and_values as $key => $value) 
            {
                $this->db->where($key,$value);
            }
        }

        $query = $this->db->get();
        $row = $query->row_array();


        if (is_string($attributes))
        {
            $attributes = explode(',', $attributes);
        }

        if ($attributes != null)
        {
                
            foreach ($attributes as $key => $attribute)
            {
                $row[$attribute] = $this->get_module_attribute($module,$id,$attribute,true);
            }
        }

        return $row;
    }

    /**
	*
	* @param $module | srting | table name
	* @param $id | int | id of the module ex. media_id
	* @param $attribute | srting | attribute name
	* @param $onlyValue | bool | wheter only value or along with attribute name
    */
    public function get_module_attribute($module,$id,$attribute,$onlyValue=false)
    {	
    	$module_id = $module . '_id';
    	$this->db->select('attribute,value');
        $this->db->from($module.'_attribute');
        $this->db->where($module_id,$id);
        $this->db->where('attribute',$attribute);
        $query = $this->db->get();
        $row_array = $query->row_array();

        //to avoid error msg if attribute is passed but it does not exist in database
        if (is_array($row_array)) 
        {
            //onlyValue on being true returns only the Value
            if ($onlyValue === true)
            {
                return $row_array['value'];
            }
            else
            {
                //it returns the attribute string parameter as key and returned value as value
                $new_row_array = array(
                    $row_array['attribute'] => $row_array['value']
                );
                return $new_row_array = (object) $new_row_array;
            }
        }
    }

    /**
    * this check if a asked attribute exists for it's parent table's asked row
    * 
    */
    function if_attribute_exists($module,$id,$attribute)
    {
        $value = $this->get_module_attribute($module,$id,$attribute,$onlyValue=true);
        if ($value === null) {
           return false;
        }else{
            return true;
        }
    }

    /**
    * common model
    * @param $module
    * @param $parent_id
    * @param $taxonomy
    */
    public function get_taxonomy_names_by_parent_id($module,$parent_id,$taxonomy=null)
    {   
        $module_taxonomy = $module . '_taxonomy';
        $module_taxonomy_id = $module_taxonomy .'_id';
        $this->db->select('name,'. $module_taxonomy_id . ' as taxonomy_id,parent_id');
        $this->db->from($module_taxonomy);
        $this->db->where('parent_id',$parent_id);
        if (isset($taxonomy)) {
        $this->db->where('taxonomy',$taxonomy);
        }
        $query = $this->db->get();
        $rows = $query->result();

        foreach ($rows as $row) {
            $row->parent_name = $this->get_row($module_taxonomy,'name as parent_name',$row->taxonomy_id,null,null)['parent_name'];
        }

        return $rows;
    }

    /**
    * 
    *
    */
    public function get_all_taxonomy_names_from($module,$taxonomy)
    {
        $module_taxonomy = $module . '_taxonomy';
        $module_taxonomy_id = $module_taxonomy .'_id';
        $this->db->select('name,'. $module_taxonomy_id . ' as taxonomy_id,parent_id');
        $this->db->from($module_taxonomy);
        $this->db->where('taxonomy',$taxonomy);
        $query = $this->db->get();
        $rows = $query->result();

        foreach ($rows as $row) {
            if ($row->parent_id == '0' || $row->parent_id == 0) {
                $row->parent_name = '<b>SUPER '.strtoupper($taxonomy).'</b>';
            }else{
                $row->parent_name = $this->get_row($module_taxonomy,'name as parent_name',$row->parent_id,null,null)['parent_name'];
            }
        }
        return $rows;
    }

    public function get_parents_by_taxonomy_id($taxonomy_id=null)
    {
        $records = array();
        $parent_id = 1;
        while ($parent_id != 0) {
            $record = $this->get_row('product_taxonomy','*',$taxonomy_id);
            $records[] = $record;
            $parent_id = intval($record['parent_id']);
            $taxonomy_id = $parent_id;
        }

        return $records;
    }

//--------------------------------------------------------------------------------------------
    /**
    * Adds data into all kind of database table | general purpose
    * @param $table | string | name of the table to insert data into
    * @param $data | array | datas to insert
    */
    public function add_into_table($table,$data)
    {   
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    } 

//-------------------------------------------------------------------------------------------
    /**
    * adds data into any tabel's attribute table
    * @param $module | string | module's name ex. media
    * @param $data | array or multidimensional array | multidimensional array is for adding more than one 
    * atatribute at once
    */
    function add_into_attribute_table($module,$data)
    {   
        $is_multi_array = (isset($data[0]) && is_array($data[0]));
        $datas = $is_multi_array? $data : [$data];
        foreach ($datas as $data)
            $this->db->insert($module.'_attribute', $data);
    }

    /**
    * updates any kind of attribute table
    * @param $module | string | module's name ex. media
    * @param $module_id | string or int | unique id of module's asked row ex. media_id
    * @param $attribute | 
    * @param $data | array or multidimensional array | multidimensional array is for updating more than one 
    * atatribute at once | only two element in data array one element is attribute second is value 
    */
    function edit_attribute_table_row($module,$module_id,$data)
    {
        $is_multi_array = (isset($data[0]) && is_array($data[0]));
        $datas = $is_multi_array? $data : [$data];
        foreach ($datas as $data){
            $this->db->set('value', $data['value']);
            $this->db->where($module.'_id',$module_id);
            $this->db->where('attribute',$data['attribute']);
            $this->db->update($module.'_attribute');
        }
    }

//-------------------------------------------------------------------------------------------- 

    /**
    * updates any kind of table(module)
    */
    function edit_table_row($table,$row_id,$data)
    {
        $this->db->where($table.'_id',$row_id);
        $this->db->update($table,$data);
    }
//--------------------------------------------------------------------------------------------
    /**
    * this check if a row exists by comparing provided column name and 
    * row value of that column
    */
    function if_row_exists($table,$column_name,$row_value)
    {
        $query = $this->db->query('SELECT COUNT(*) as count FROM '.$table.' WHERE '.$column_name.' = '.'"'.$row_value.'"'.'');
        $row = $query->row();
        return ($row->count > 0) ? true : false;
    }

    /**
    *
    * this checks whether a child row exists example check wheter rows in state
    * table exists for a country
    * @param $child_table | string | name of child table
    * @param $common_id_field | field that connects both the parent and child tables 
    * ex: parent_id is in both the table
    * @param $common_id_value | value of unique id of parent table to example country_id: 21
    * 
    */
    function do_child_rows_exist($child_table,$common_id_field,$common_id_value){
        $this->db->select('*');
        $this->db->from($child_table);
        $this->db->where($common_id_field, $common_id_value);

        $query = $this->db->get();
        return ($query->num_rows() !== 0)? true : false;
    }

//-------------------------------------------------------------------------------------------
    /**
    *
    * deletes row from any kind of table
    */
    function delete_row_from($table,$row_id)
    {   
        $table_id = $table.'_id';
        $this->db->where($table_id, $row_id);
        $this->db->delete($table);
    }

    /**
    *
    * deletes row(s) from any kind of attribute table
    */
    function delete_row_attributes_from($associate_table,$associate_table_row_id)
    {   
        $associate_table_id = $associate_table.'_id';
        $attribute_table = $associate_table.'_attribute';
        $this->db->where($associate_table_id, $associate_table_row_id);
        $this->db->delete($attribute_table);
    }
}
?>