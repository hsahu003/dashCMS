<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('dashboard/settings/common_model', 'CModel');

	}

	/**
	* @param $module | 'string' | name of the module for which taxonomy is fecthed
	* @param $parent_id | int | parent id to find out child | '0' can also be passed to get all the top most *parents
	* @param $ajax | int | set it to '1' if it's an ajax request
	*/
	public function get_taxonomy_names_by_parent_id($module,$parent_id,$ajax='0')
	{	
		$data = $this->CModel->get_taxonomy_names_by_parent_id($module,$parent_id);
		if ($ajax==1) {
			 echo json_encode($data);
		}else{
			return $data;
		}
		
	}

	public function ajax_get_rows_from(){

		$data = json_decode($_POST['data']);

		$table = $data->table;
		$columns = isset($data->columns)? $data->columns : '*';
		$attributes = isset($data->attributes) ?  $data->attributes : null;
		$filter_keys_and_values = isset($data->filter_keys_and_values) ? (array) $data->filter_keys_and_values : null;
		$orders = isset($data->orders)? (array) $data->orders : null;
		$limit =  isset($data->limit)? $data->limit : null;
		$offset = isset($data->offset)? $data->offset : null;
		$taxonomy_id = isset($data->taxonomy_id)? $data->taxonomy_id : null;


		$return_data = $this->CModel->get_rows_from($table,$columns,$attributes,$filter_keys_and_values,$orders,$limit,$offset,$taxonomy_id);

		echo json_encode($return_data);
	}

	// public function edit_table_row($table,$row_id)
	// {	
		
	// }
	

}