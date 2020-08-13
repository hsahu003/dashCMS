<?php

class Commons extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('common/common_media');
		$this->load->model('dashboard/settings/common_model', 'CModel');
	}

	function index(){
		$this->load->view('dashboard/templates/header');
		$this->load->view('dashboard/settings/index');
		$this->load->view('dashboard/templates/footer');
	}


	//ajax requests
	function ajax_add_image(){

		//upload file
        $config['upload_path'] = './assets/images/uploads';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';



        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('file')) {
            	echo $this->upload->display_errors();
       		}else{
       			//creating thumbnail for the image
                $data = $this->upload->data();
         		$hello['source_image'] = $data['full_path'];
         		$hello['new_image'] = $data['file_path'] . $data['raw_name'] . '_thumb.jpg';
				$this->load->library('image_manipulation',$hello);
				$this->image_manipulation->thumb();
				
				

				//updating the media database with image
				$time = date("Y-m-d H:i:s");
				$image_data = array(
					'name' => $data['file_name'],
					'type' => $data['file_type'],
					'path' => '/assets/images/uploads/' . $data['file_name'],
					'dateUploaded' => $time,
					'authorID' => '1'//$this->session->user_id
				);
				$image_id = $this->CModel->add_image($image_data);

				//sending the processed data
				$array = array(
						'image' =>  site_url('/assets/images/uploads/') .  $data['file_name'],
						'image_path' => '/assets/images/uploads/' . $data['file_name'],
						'image_id' => $image_id
				);
				$json = json_encode($array);
				echo $json;
            }

	}

	function ajax_remove_image(){

	}

}

?>