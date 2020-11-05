<?php    
defined('BASEPATH') OR exit('No direct script access allowed');


class Product_model extends CI_Model {
    public function __construct()
        {
            $this->load->database();
            $this->load->model('dashboard/settings/common_model', 'CModel');
        }
    //checks if a the name of product being added is already under a category
    public function add_product_name_validation($product_name,$category_id){
        $this->db->select('*');
        $this->db->from('product as p');
        $this->db->join('product_taxonomy_map as ptm', 'p.product_id = ptm.product_id');
        $this->db->join('product_taxonomy as pt', 'pt.product_taxonomy_id = ptm.product_taxonomy_id');
        $this->db->where('p.title',$product_name);
        $this->db->where('pt.taxonomy', 'category');
        $this->db->where('ptm.product_taxonomy_id', $category_id);

        $query = $this->db->get();
        return ($query->num_rows() === 0) ? TRUE : FALSE;
    }

    public function edit_product_name_validation($product_name,$category_id,$product_id){
        $this->db->select('*');
        $this->db->from('product as p');
        $this->db->join('product_taxonomy_map as ptm', 'p.product_id = ptm.product_id');
        $this->db->join('product_taxonomy as pt', 'pt.product_taxonomy_id = ptm.product_taxonomy_id');
        $this->db->where('p.title',$product_name);
        $this->db->where('pt.taxonomy', 'category');
        $this->db->where('ptm.product_taxonomy_id', $category_id);
        $this->db->where('p.product_id != ', $product_id);

        $query = $this->db->get();
        return ($query->num_rows() === 0) ? TRUE : FALSE;
    }

    /**
    *
    * @param $taxonomy_ids | array | array of the taxonomy ids
    */

    public function get_all_products($columns='*',$attributes=null,$filter_keys_and_values=null,$orders=null,$limit=null,$offset=null,$taxonomy_ids=null){

        if (!isset($taxonomy_ids)) {
            $taxonomy_ids = array(
                null
            );
        }

        $data_array_cate_wise = array();
        $data_array_cate_wise_for_final_return = array();
        $data_array_product_wise = array();


        for ($i=0; $i < count($taxonomy_ids); $i++) { 
           $data_array_cate_wise[$i] = array();
           $data_array_cate_wise_for_final_return[$i] = array();
            $data_array_cate_wise[$i] = $this->CModel->get_rows_from('product','*, m.description as p_desc',$attributes,$filter_keys_and_values,$orders,$limit,$offset,$taxonomy_ids[$i]);
        }


        //array category wise
        for ($i=0; $i < count($data_array_cate_wise); $i++) { 
            //array product wise
            for ($j=0; $j < count($data_array_cate_wise[$i]); $j++) {
                $data_array_product_wise[$j] = array();
                //object for each product
                $product = new stdClass();
                //populate the data for individual products
                $product->p_id = $data_array_cate_wise[$i][$j]->product_id;
                $product->p_name = $data_array_cate_wise[$i][$j]->title;
                $product->p_desc = $data_array_cate_wise[$i][$j]->p_desc;
                $specs = json_decode($data_array_cate_wise[$i][$j]->specifications);
                $specs_array = (array) $specs;
                $product->p_specs_array = $specs_array;
                $product->p_primary_price = (int) $data_array_cate_wise[$i][$j]->price;
                $product->p_primary_sale_price = (int) $data_array_cate_wise[$i][$j]->sale_price;

                //savings in percent
                $difference_of_price = ($product->p_primary_price - $product->p_primary_sale_price);
                $saving_in_percent = round(($difference_of_price / $product->p_primary_price) * 100) .'%';
                $product->p_saving_in_percent = $saving_in_percent;
                //savings in amount
                $product->p_saving_in_percent = $difference_of_price;

                //prices
                //if attribute for prices is set
                if (isset($data_array_cate_wise[$i][$j]->product_prices)) {
                    $prices = json_decode($data_array_cate_wise[$i][$j]->product_prices);
                    $prices = (array) $prices;
                    $prices_array_country_wise = array();
                    for ($k=0; $k < count($prices); $k++) { 
                        $prices_array_country_wise[$k] = array();
                        $prices_array_country_wise[$k]['country_id'] = $prices[$k]->country_id;
                        $attributes = array(
                            'currency_symbol',
                        );
                        $country_details = $this->CModel->get_row('country','*',$prices[$k]->country_id,$attributes);
                        
                        $prices_array_country_wise[$k]['country_name'] = $country_details['country'];
                        $prices_array_country_wise[$k]['currency'] = $country_details['currency_symbol'];
                        $prices_array_country_wise[$k]['price'] = $prices[$k]->price;
                        $prices_array_country_wise[$k]['sale_price'] = $prices[$k]->sale_price;
                    }
                    $product->p_prices = $prices_array_country_wise;
                }
                $product->p_status = $data_array_cate_wise[$i][$j]->status;
                $filter_keys_and_values = array(
                    'product_id' => $product->p_id
                );
                $category_id = $this->CModel->get_row('product_taxonomy_map','product_taxonomy_id',null,null,$filter_keys_and_values)['product_taxonomy_id'];
                $product->p_category_id = $category_id;
                //shipping option
                if (isset($data_array_cate_wise[$i][$j]->shipping_options)) {
                    $shipping_options = json_decode($data_array_cate_wise[$i][$j]->shipping_options);
                    $shipping_options_array_country_wise = array();
                    $shipping_options = (array) $shipping_options;
                    foreach ($shipping_options as $country_id => $shipping_option) {
                        $shipping_options_array_country_wise[$country_id] = array();
                        for ($l=0; $l < count($shipping_option); $l++) { 
                            $attributes = array('so_delivery_dutation');
                            $option_details = $this->CModel->get_row('shipping_option','name,cost,description',$shipping_option[$l],$attributes);
                            $shipping_options_array_country_wise[$country_id][$l]['option_name'] = $option_details['name'];
                            $shipping_options_array_country_wise[$country_id][$l]['cost'] = $option_details['cost'];
                            $shipping_options_array_country_wise[$country_id][$l]['description'] = $option_details['description'];
                            $shipping_options_array_country_wise[$country_id][$l]['duration'] = $option_details['so_delivery_dutation'];
                        }
                    }
                    $product->shipping_options = $shipping_options_array_country_wise;
                }

                if (isset($data_array_cate_wise[$i][$j]->product_primary_image)) {
                    $primary_image_id = $data_array_cate_wise[$i][$j]->product_primary_image;
                    $product->primary_image = $this->CModel->get_row('media','media_path',$primary_image_id)['media_path'];
                    $media_path = $product->primary_image;
                    $ext = explode('.',$media_path);
                    $ext = '.'.end($ext);
                    $ext_with_thumb = '_thumb' . $ext;
                    $file_name_without_ext = explode('.',$media_path);
                    $file_name_without_ext = current($file_name_without_ext);
                    $file_name_with_thumb_ext = $file_name_without_ext . $ext_with_thumb;
                    $product->primary_image_thumb = $file_name_with_thumb_ext;

                }

                if (isset($data_array_cate_wise[$i][$j]->product_gallery_images)) {
                    $product->gallary_image = explode(',',$data_array_cate_wise[$i][$j]->product_gallery_images);
                }
                $data_array_product_wise[$j][] = $product;

                //if category id is passed
                if ($taxonomy_ids[0] != null) {
                    $data_array_product_wise[$j]['cate_details'] = array();
                    $cate_details = $this->CModel->get_row('product_taxonomy','name, description',$taxonomy_ids[$i]);
                    $data_array_product_wise[$j]['cate_details']['cate_name'] = $cate_details['name'];
                    $data_array_product_wise[$j]['cate_details']['cate_desc'] = $cate_details['description'];
                }
                
            }
            $data_array_cate_wise_for_final_return[$i] = $data_array_product_wise;
            $data_array_product_wise = [];
        }

        return $data_array_cate_wise_for_final_return;
        
    }

    public function get_product($product_id,$columns='*',$attributes=null,$filter_keys_and_values=null){

        $filter_key_and_value = array(
            'product_id' => $product_id,
        );

        if (isset($filter_keys_and_values)) {
            $filter_keys_and_values = array_merge($filter_key_and_value,$filter_keys_and_values);
        }else{
            $filter_keys_and_values = $filter_key_and_value;
        }

        $product_data_array = $this->CModel->get_rows_from('product','*, m.description as p_desc',$attributes,$filter_keys_and_values);
        
        //object for each product
        $product = new stdClass();
        //populate the data for individual products
        $product->p_id = $product_data_array[0]->product_id;
        $product->p_name = $product_data_array[0]->title;
        $product->p_desc = $product_data_array[0]->p_desc;
        $specs = json_decode($product_data_array[0]->specifications);
        $specs_array = (array) $specs;
        $product->p_specs_array = $specs_array;
        $product->p_primary_price = (int) $product_data_array[0]->price;
        $product->p_primary_sale_price = (int) $product_data_array[0]->sale_price;

        //savings in percent
        $difference_of_price = ($product->p_primary_price - $product->p_primary_sale_price);
        $saving_in_percent = round(($difference_of_price / $product->p_primary_price) * 100) .'%';
        $product->p_saving_in_percent = $saving_in_percent;
        //savings in amount
        $product->p_saving_in_percent = $difference_of_price;


        //prices
        if (isset($product_data_array[0]->product_prices)) {
            $prices = json_decode($product_data_array[0]->product_prices);
            $prices = (array) $prices;
            $prices_array_country_wise = array();
            for ($k=0; $k < count($prices); $k++) { 
                $prices_array_country_wise[$k] = array();
                $prices_array_country_wise[$k]['country_id'] = $prices[$k]->country_id;
                $attributes = array(
                    'currency_symbol',
                );
                $country_details = $this->CModel->get_row('country','*',$prices[$k]->country_id,$attributes);
                
                $prices_array_country_wise[$k]['country_name'] = $country_details['country'];
                $prices_array_country_wise[$k]['currency'] = $country_details['currency_symbol'];
                $prices_array_country_wise[$k]['price'] = $prices[$k]->price;
                $prices_array_country_wise[$k]['sale_price'] = $prices[$k]->sale_price;
            }
            $product->p_prices = $prices_array_country_wise;
        }
        
        $product->p_status = $product_data_array[0]->status;
        $filter_keys_and_values = array(
            'product_id' => $product->p_id
        );
        $category_id = $this->CModel->get_row('product_taxonomy_map','product_taxonomy_id',null,null,$filter_keys_and_values)['product_taxonomy_id'];
        $product->p_category_id = $category_id;
        //shipping option
        if (isset($product_data_array[0]->shipping_options)) {
            $shipping_options = json_decode($product_data_array[0]->shipping_options);
            $shipping_options_array_country_wise = array();
            $shipping_options = (array) $shipping_options;
            foreach ($shipping_options as $country_id => $shipping_option) {
                $shipping_options_array_country_wise[$country_id] = array();
                for ($l=0; $l < count($shipping_option); $l++) { 
                    $attributes = array('so_delivery_dutation');
                    $option_details = $this->CModel->get_row('shipping_option','name,cost,description',$shipping_option[$l],$attributes);
                    $shipping_options_array_country_wise[$country_id][$l]['option_name'] = $option_details['name'];
                    $shipping_options_array_country_wise[$country_id][$l]['cost'] = $option_details['cost'];
                    $shipping_options_array_country_wise[$country_id][$l]['description'] = $option_details['description'];
                    $shipping_options_array_country_wise[$country_id][$l]['duration'] = $option_details['so_delivery_dutation'];
                }
            }
            $product->shipping_options = $shipping_options_array_country_wise;
        }
        
        if (isset($product_data_array[0]->product_primary_image)) {
            $product->primary_image = $product_data_array[0]->product_primary_image;
        }
        if (isset($product_data_array[0]->product_gallery_images)) {
            $product->gallary_image = explode(',',$product_data_array[0]->product_gallery_images);
        }
        
        return $product;
        
    }
}