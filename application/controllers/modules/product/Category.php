<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH."controllers/commons/Common.php");

class Category extends Common {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('common/common_media');
		$this->load->model('dashboard/settings/common_model', 'CModel');

		//check for admin login session
		is_admin_logged_in();
	}

	function index(){
		$this->load->view('dashboard/templates/header');
		$this->load->view('dashboard/product/category/index');
		$this->load->view('dashboard/templates/footer');
	}

	public function add_product_category()
	{	
		$this->load->helper('form');

		$parent_categories = $this->get_taxonomy_names_by_parent_id('product','0');

		if ($this->input->method() == 'get') {
			$data['parent_categories'] = $parent_categories; 

			$this->load->view('dashboard/templates/header');
			$this->load->view('dashboard/product/category/add_category',$data);
			$this->load->view('dashboard/templates/footer');
			
		}else{
			//parent_id from the form
			$parent_ids = $this->input->post('parent_id[]');
			if (count($parent_ids)>1 && end($parent_ids) == 'na') {
				$parent_id = prev($parent_ids);
			}
			elseif(end($parent_ids) != 'na')
			{
				$parent_id = end($parent_ids);
			}
			else
			{	
				$parent_id = 0;
			}

			$this->load->library('form_validation');

			//Validations
			$category_parent_id = $parent_id;
			$this->form_validation->set_rules('name','Name of category','required|is_unique_taxonomy[product_taxonomy.name.parent_id.'.$category_parent_id.']',array('is_unique_taxonomy' => 'This %s category name already exists.'));

			//Run Validations
			if($this->form_validation->run() === FALSE)
			{	
				
				$errors = array_values($this->form_validation->error_array());
				$data = array('execute' => 'failure','message' => $errors[0]);
				$data['parent_categories'] = $parent_categories;

				$this->load->view('dashboard/templates/header');
				$this->load->view('dashboard/product/category/add_category',$data);
				$this->load->view('dashboard/templates/footer');
			}
			else{
				//prepare data
				$category = array(
					'name' => $this->input->post('name'),
					'taxonomy' => 'category',
					'description' => $this->input->post('description'),
					'parent_id' => $parent_id
				);
				$product_taxonomy_id = $this->CModel->add_into_table('product_taxonomy',$category);
				//prepare_attribuite
				$time = date("Y-m-d H:i:s");
				$user_created_id = $this->session->admin_id;
				$category_attribute_data = array(
						'product_taxonomy_id' => $product_taxonomy_id,
						'attribute' => 'category_image_id',
						'value' => $this->input->post('category_image'),
						'date_created' => $time,
						'last_updated' => null,
						'user_created_id' => $user_created_id
					);
				$this->CModel->add_into_attribute_table('product_taxonomy',$category_attribute_data);
				redirect('dashboard/product/category/view_all');
			}
		}
		
	}

	public function edit_product_category($category_id)
	{	
		$this->load->helper('form');


		$parent_categories_collections = array();
		
		$all_parents = $this->CModel->get_parents_by_taxonomy_id($category_id);


		for ($i=1; $i < count($all_parents); $i++) {
			$parent_id = $all_parents[$i]['parent_id'];
			$parent_categories = $this->get_taxonomy_names_by_parent_id('product',$parent_id);
			
			foreach ($parent_categories as $parent_category) {
				if ($all_parents[$i]['product_taxonomy_id'] == $parent_category->taxonomy_id) {
					$parent_category->selected = true;
				}else{
					$parent_category->selected = false;
				}
			}
			$parent_categories_collections[] = $parent_categories;
		}

		
		$parent_categories_collections = array_reverse($parent_categories_collections);
		$attributes = array('category_image_id');
		$category = $this->CModel->get_row('product_taxonomy','*',$category_id,$attributes);
		if ($category['category_image_id'] != null) {
			$category['category_image'] = site_url($this->CModel->get_row('media','media_path',$category['category_image_id'])['media_path']);
		}else{
			$category['category_image'] = site_url('#');
		}
		
		$category_parent_id = $category['parent_id'];
		$category_taxonomy_id = $category_id;

		if ($this->input->method() == 'get') {
			$data['parent_categories_collections'] = $parent_categories_collections;

			$data['category'] = $category;

			$this->load->view('dashboard/templates/header');
			$this->load->view('dashboard/product/category/edit_category',$data);
			$this->load->view('dashboard/templates/footer');
			
		}else{
			$this->load->library('form_validation');
			//Validations

			$this->form_validation->set_rules('name','Name of category','required|edit_unique_taxonomy[product_taxonomy.name.parent_id.'.$category_parent_id.'.'.$category_taxonomy_id.'.'.']',array('edit_unique_taxonomy' => 'This %s category name already exists.'));

			//Run Validations
			if($this->form_validation->run() === FALSE)
			{	
				
				$errors = array_values($this->form_validation->error_array());
				$data = array('execute' => 'failure','message' => $errors[0]);
				$data['parent_categories_collections'] = $parent_categories_collections;

				$data['category'] = $category;

				$this->load->view('dashboard/templates/header');
				$this->load->view('dashboard/product/category/edit_category',$data);
				$this->load->view('dashboard/templates/footer');
			}
			else{
				//prepare data
				$parent_ids = $this->input->post('parent_id[]');

				if (isset($parent_ids)) {
					if (count($parent_ids)>1 && end($parent_ids) == 'na') {
						$parent_id = prev($parent_ids);
					}
					elseif(end($parent_ids) != 'na')
					{
						$parent_id = end($parent_ids);
					}
					else
					{	
						$parent_id = 0;
					}
				}else{
					$parent_id = 0;
				}
				
				$category = array(
					'name' => $this->input->post('name'),
					'description' => $this->input->post('description'),
				);
				$this->CModel->edit_table_row('product_taxonomy',$category_taxonomy_id,$category);
				redirect('dashboard/product/category/view_all');
			}
		}
		
	}

	function view_all_product_categories(){
		$data['product_categories'] = $this->CModel->get_all_taxonomy_names_from('product','category');
		$this->load->view('dashboard/templates/header');
		$this->load->view('dashboard/product/category/view_categories',$data);
		$this->load->view('dashboard/templates/footer');
	}

	function delete_product_category($id){
		$product_taxonomy_id = $id;

		/*
		* update product_taxonomy_map 
		*/

		//find rows in product_taxonomy_map with $product_taxonomy_id entered in column product_taxonomy_id
		$filter = array(
			'product_taxonomy_id' => $product_taxonomy_id,
		);
		$taxonomy_map_rows_to_update = $this->CModel->get_rows_from('product_taxonomy_map','*',null,$filter,null,null,null,null);

		//replace the product_taxonomy_id column value with 0
		$data = array(
			'product_taxonomy_id' => '0',
		);
		foreach ($taxonomy_map_rows_to_update as $taxonomy_map_rows ) {
			$row_to_update_taxonomy_id = $product_taxonomy_id;
			$this->CModel->edit_table_row('product_taxonomy_map',$row_to_update_taxonomy_id,$data);
		}

		//find the sub categories of deleting row
		$filter = array(
			'parent_id' => $product_taxonomy_id,
		);
		$rows_to_update_parent_id = $this->CModel->get_rows_from('product_taxonomy','*',null,$filter,null,null,null,null);


		//find the parent_id of deleting row
		$parent_id_of_deleting_row = $this->CModel->get_row('product_taxonomy','parent_id',$product_taxonomy_id,null,null)['parent_id'];
		

		//replace the parent_id in sub categories row with parent_id of deleting row
		$data = array(
			'parent_id' => $parent_id_of_deleting_row,
		);
		foreach ($rows_to_update_parent_id as $row_to_update) {
			$row_to_update_taxonomy_id = $row_to_update->product_taxonomy_id;
			$this->CModel->edit_table_row('product_taxonomy',$row_to_update_taxonomy_id,$data);
		}

		
		//delete asked row by user from product_taxonomy
		$this->CModel->delete_row_from('product_taxonomy',$product_taxonomy_id);

		redirect('dashboard/product/category/view_all');

	}

	
}