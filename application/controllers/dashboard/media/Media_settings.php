<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH."controllers/commons/Common.php");

class Media_settings extends Common {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('common/common_media');
		$this->load->helper('form');
		$this->load->model('dashboard/settings/common_model', 'CModel');

		//check for admin login session
		is_admin_logged_in();
	}

	public function media_settings()
	{
		$this->load->view('dashboard/templates/header');
		$this->load->view('dashboard/media/media_settings');
		$this->load->view('dashboard/templates/footer');
	}

	public function add_media_category()
	{	
		$parent_categories = $this->get_taxonomy_names_by_parent_id('media','0');

		if ($this->input->method() == 'get') {
			$data['parent_categories'] = $parent_categories; 

			$this->load->view('dashboard/templates/header');
			$this->load->view('dashboard/media/add_media_category',$data);
			$this->load->view('dashboard/templates/footer');
			
		}else{
			
			$this->load->library('form_validation');
			//Validations
			$this->form_validation->set_rules('name','Name of category','required|is_unique[media_taxonomy.name]',array('is_unique' => 'This %s category name already exists.'));

			//Run Validations
			if($this->form_validation->run() === FALSE)
			{	
				
				$errors = array_values($this->form_validation->error_array());
				$data = array('execute' => 'failure','message' => $errors[0]);
				$data['parent_categories'] = $parent_categories;

				$this->load->view('dashboard/templates/header');
				$this->load->view('dashboard/media/add_media_category',$data);
				$this->load->view('dashboard/templates/footer');
			}
			else{
				//prepare data
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
				$category = array(
					'name' => $this->input->post('name'),
					'taxonomy' => 'category',
					'description' => $this->input->post('description'),
					'parent_id' => $parent_id
				);
				$this->CModel->add_into_table('media_taxonomy',$category);
				redirect('dashboard/media/settings');
			}
		}
		
	}
}