<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Add_media extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('common/common_media');
		$this->load->model('dashboard/settings/common_model', 'CModel');

		//check for admin login session
		is_admin_logged_in();
	}

	public function add_media($folder_id,$media_id=null)
	{	
		$orders = array(
			'media_id' => 'desc',
		);
		$limit = 100;
		$offset = 0;

		//check if $media_id is passed for editing respective media
		if (isset($media_id)) {
			$data['edit_media_id'] = $media_id;
		}else{
			$data['edit_media_id'] = 'null';
		}


		//if ajax request
		if ($this->input->method() == 'post') {
			$post_data = json_decode($_POST['data']);
			$limit = $post_data->limit;
			$offset = $post_data->offset;
		}
		$parent_folders = $data['parent_folders'] = $this->CModel->get_taxonomy_names_by_parent_id('media',$folder_id);
		$data['parent_folder_id'] = $folder_id;
		$attributes = array(
			'alt_text'
		);
		$filter_keys_and_values = array(
			'user_type' => 'admin'
		);
		$medias = $data['medias'] = $this->CModel->get_rows_from('media','*',$attributes,null,$orders,$limit,$offset,$folder_id);
		$admin_id = $data['admin_id'] = $this->session->admin_id;
		foreach ($medias as $media) {
			//file size before adding _thumb
			if (file_exists(FCPATH.$media->media_path)) {
				$filesize = filesize(FCPATH.$media->media_path);
				$file_dimension = getimagesize(FCPATH.$media->media_path);
			}
			//if no file exists just send 0 value
			else{
				$filesize = 0;
				$file_dimension[0] = 0;
				$file_dimension[1] = 0;
			}
			

			$ext = explode('.',$media->media_path);
			$ext = '.'.end($ext);
			$ext_with_thumb = '_thumb' . $ext;
			$file_name_without_ext = explode('.',$media->media_path);
			$file_name_without_ext = current($file_name_without_ext);
			$file_name_with_thumb_ext = $file_name_without_ext . $ext_with_thumb;
			$media->media_path = $file_name_with_thumb_ext;

			//check for byte, kb or mb to display
			//check for byte
			if ($filesize <= 1024) 
			{
				$filesize = round($filesize) . ' b';
			}
			//check for kb
			elseif($filesize <= 1048576)
			{
				$filesize = round($filesize/1000) . ' kb';
			}
			//check for mb
			else
			{
				$filesize = round($filesize/1000000) . ' mb';
			}
			$media->media_size = $filesize;
			$media->media_dimension = $file_dimension[0] . ' by ' . $file_dimension[1] . ' px';
		}
		//not a ajax request
		if ($this->input->method() == 'get') 
		{
			$this->load->view('dashboard/templates/header');
			$this->load->view('dashboard/media/add_media',$data);
			$this->load->view('dashboard/templates/footer');
		}
		
		//if ajax request
		else{
			$data = json_decode($_POST['data']);
			$limit = $data->limit;
			$offset = $data->offset;
			echo json_encode($medias);
		}
		
	}

	public function view_medias($type)
	{	
		$this->load->view('dashboard/templates/header');
		$this->load->view('dashboard/media/add_media');
		$this->load->view('dashboard/templates/footer');
	}


	

	
}