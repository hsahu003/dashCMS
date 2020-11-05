<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Update_media extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('dashboard/settings/common_model', 'CModel');

		//check for admin login session
		is_admin_logged_in();

	}

	public function update_media($row_id)
	{	
		$data = json_decode($_POST['data']);

		//data for alt text attribute add or update
		$alt_text = $data->alt_text;
		$admin_id = $data->admin_id;
		$user_type = $data->user_type;
		//unset irrelevant fileds for database for media table
		unset($data->alt_text);
		unset($data->admin_id);
		unset($data->user_type);

		//check if the same name is being saved
		$original_media_name_frm_db = $this->CModel->get_row('media','media_name',$row_id)["media_name"];
		$media_name_frm_form = $data->new_media_name;
		$is_same_name = ($media_name_frm_form == $original_media_name_frm_db);
		//check if the new name already exists in database
		$name_already_in_db = $this->CModel->if_row_exists('media','media_name',$data->new_media_name);

		//if new name is same as the old name of same media, no proble proceed further
		if ($is_same_name) 
		{
			$proceed_further = true;
			$return_data['error_media_name'] = 'false';
			$return_data['message_media_name'] = 'same name but okay';
		}
		//if new name of the media matches another media's name in the DB
		elseif ($name_already_in_db) 
		{
			$proceed_further = false;
			$return_data['error_media_name'] = 'true';
			$return_data['message_media_name'] = 'name already exists for another media';
		}
		//new media name is not same and it does not match any other media name in the database
		else
		{
			$proceed_further = true;
			$return_data['error_media_name'] = 'false';
			$return_data['message_media_name'] = 'new name and okay';
		}
		if ($proceed_further) {
			//update the media_path
			$data->media_path = '/assets/images/uploads/' . $data->new_media_name;
			//change the file name in directory
			$old_path = FCPATH.'/assets/images/uploads/' . $data->old_media_name;
			$new_path = FCPATH.'/assets/images/uploads/'. $data->new_media_name;
			rename($old_path,$new_path);
			//chnage the file name for _thumb
			$old_thumbnail_path = FCPATH.'/assets/images/uploads/' . $data->old_media_name_thumb;
			$new_thumbnail_path = FCPATH.'/assets/images/uploads/'. $data->new_media_name_thumb;
			//unset old media name
			rename($old_thumbnail_path,$new_thumbnail_path);
			//unset irrelevant fileds for database
			unset($data->old_media_name);
			unset($data->old_media_name_thumb);
			unset($data->new_media_name_thumb);
			$data->media_name = $data->new_media_name;
			$media_ext = $data->media_ext;
			unset($data->media_ext);
			unset($data->new_media_name);
			//save updated data
			$this->CModel->edit_table_row('media',$row_id,$data);
			//sending the processed data
			$return_data['media_name'] = preg_replace('/\.(jpeg|jpg|png|gif)\b/', '', $data->media_name);
			$return_data['media_ext'] =  $media_ext;
			$return_data['media_path'] = '/assets/images/uploads/' . $data->media_name;	
		}

			//save attributes to media_attributes
			$time = date("Y-m-d H:i:s");
			
			//check if alt text exists in db
			$alt_text_exists_in_db = $this->CModel->if_attribute_exists('media',$row_id,'alt_text');

			if ($alt_text_exists_in_db) {
				//update the row
				$attributes_data = array(
				'attribute' => 'alt_text',
				'value' => $alt_text,
				);
				$this->CModel->edit_attribute_table_row('media',$row_id,$attributes_data);
				$return_data['error_alt_text'] = 'false';
				$return_data['message_alt_text'] = 'alt text updated';
			}
			//
			elseif($alt_text!=null || $alt_text!='')
			{	
				//create new row
				$attributes_data = array(
				'media_id' => $row_id,
				'attribute' => 'alt_text',
				'value' => $alt_text,
				'date_create' => $time,
				'user_created_id' => $admin_id,
				'user_type' => $user_type,
				);
				$this->CModel->add_into_attribute_table('media',$attributes_data);
				$return_data['error_alt_text'] = 'false';
				$return_data['message_alt_text'] = 'alt text created';
			}

		//sending the processed data
		$return_data['alt_text'] = $alt_text;

		$return_data = json_encode($return_data);
		echo $return_data;
		
	}

	public function delete_media($row_id)
	{	
		//file path
		$media_path = $this->CModel->get_row('media','media_path',$row_id,null,null)['media_path'];
		$media_path = FCPATH . $media_path;

		//file thumbnail path
		$ext = explode('.',$media_path);
		$ext = '.'.end($ext);
		$ext_with_thumb = '_thumb' . $ext;
		$file_name_without_ext = explode('.',$media_path);
		$file_name_without_ext = current($file_name_without_ext);
		$file_name_with_thumb_ext = $file_name_without_ext . $ext_with_thumb;
		$file_name_with_thumb_ext = $file_name_with_thumb_ext;
		var_dump($file_name_with_thumb_ext);

		//delete from table
		$this->CModel->delete_row_attributes_from('media',$row_id);
		$this->CModel->delete_row_from('media',$row_id);
		

		//delete the file
		unlink($media_path);
		unlink($file_name_with_thumb_ext);
	}
}