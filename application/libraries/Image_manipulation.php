<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Image_manipulation {

        //properties
	public $source_image_full_path;
	public $source_image_size;
        public $source_image_path;
        public $source_image_name;
	public $source_image_name_wo_ext;
	public $source_image_ext;
        public $source_image_width;
        public $source_image_height;
	public $new_image_full_path;
        public $new_image_name;
        public $new_image_width;
        public $new_image_height;
	public $params = [];

      


        public function __construct($params = array())
        {	

                $this->params = $params;
        }

        public function thumb(){

                //full path of the source image along with name
                $this->source_image_full_path =  $this->params['source_image'];
                $this->source_image_size =  filesize($this->params['source_image']);
                $this->source_image_path = dirname($this->source_image_full_path) . '/';
                $this->source_image_name = basename($this->source_image_full_path);
                $this->source_image_ext = explode(".", $this->source_image_name);
                $this->source_image_ext = end($this->source_image_ext);
                $this->source_image_name_wo_ext = str_replace('.' . $this->source_image_ext, '', $this->source_image_name);
                //full path of the new image along with name
                if (array_key_exists("new_image",$this->params)) {
                        $this->new_image_full_path =  $this->params['new_image'];
                        $this->new_image_name = basename($this->new_image_full_path);
                }else{
                        $this->new_image_full_path =  $this->source_image_path . $this->source_image_name_wo_ext . '_thumb.' . $this->source_image_ext;
                        $this->new_image_name = basename($this->new_image_full_path) . '_thumb.' . $this->source_image_ext;
                }

                //source image's width and height
                list($this->source_image_width, $this->source_image_height) = getimagesize($this->source_image_full_path);

                if (array_key_exists("width",$this->params)) {
                        $this->new_image_width = $this->params['width'];
                }else{
                        $this->new_image_width = 200;
                }

                if (array_key_exists("height",$this->params)) {
                        $this->new_image_height = $this->params['height'];
                }else{
                        // if height of source image is not provided then calculate height maintaining aspect ratio
                        $this->new_image_height = ($this->source_image_height/$this->source_image_width) * $this->new_image_width;
                }

		$this->new_image = '';
		$this->path = $this->new_image_full_path;
                $this->tmp_image = imagecreatetruecolor($this->new_image_width, $this->new_image_height);

		switch ($this->source_image_ext) {
		        case "png":
                $mime = mime_content_type($this->source_image_full_path);
		              if ($mime == 'image/png') {
                            imagealphablending($this->tmp_image, false);
                            imagesavealpha($this->tmp_image,true);
                            $transparent = imagecolorallocatealpha($this->tmp_image, 255, 255, 255, 127);
                            imagefilledrectangle($this->tmp_image, 0, 0, $this->new_image_width, $this->new_image_height, $transparent);
                            $this->new_image = imagecreatefrompng($this->source_image_full_path);
                      }
                      //for png file with mime image/jpeg
                      else{
                        $this->new_image = imagecreatefromjpeg($this->source_image_full_path);
                      };
                              
		              break;
			case "jpg":
			case "jpeg":
            case 'jfif':
			      $this->new_image = imagecreatefromjpeg($this->source_image_full_path);
			      break;
            case 'gif':
                  $this->new_image = imagecreatefromgif($this->source_image_full_path);
                  break;
            case 'webp':
                  $this->new_image = imagecreatefromwebp($this->source_image_full_path);
                  break;
			}

		
		imagecopyresampled($this->tmp_image, $this->new_image, 0, 0, 0, 0, $this->new_image_width, $this->new_image_height, $this->source_image_width, $this->source_image_height);

                switch ($this->source_image_ext) 
                {
                case "png":
                    imagepng($this->tmp_image, $this->path, 9);
                    break;
                case "jpg":
                case "jpeg":
                case 'jfif':
                    imagejpeg($this->tmp_image, $this->path, 100);
                    break;
                case "gif":
                    imagegif($this->tmp_image, $this->path, 100);
                    break;
                case "webp":
                imagewebp($this->tmp_image, $this->path, 100);
                break;
                }
                
		imagedestroy($this->new_image);
		imagedestroy($this->tmp_image);

                

                //resetting the properties
                $this->props_reset();
				
        }

        public function props_reset(){
                $this->source_image_full_path  = '';
                $this->source_image_size  = '';
                $this->source_image_path  = '';
                $this->source_image_name  = '';
                $this->source_image_name_wo_ext  = '';
                $this->source_image_ext  = '';
                $this->source_image_width  = '';
                $this->source_image_height  = '';
                $this->new_image_full_path  = '';
                $this->new_image_name  = '';
                $this->new_image_width  = '';
                $this->new_image_height  = '';
                $this->tmp_image  = '';
                $this->new_image = '';
                $this->path = '';
                $this->params  = [];
        }
}