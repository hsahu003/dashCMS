<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH."controllers/commons/Common.php");

class Product extends Common {
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('common/common_media');
		$this->load->model('dashboard/settings/common_model', 'CModel');

		//check for admin login session
		is_admin_logged_in();
	}

	public function view_all(){
		$attributes = array(
			'product_category_id'
		);
		$orders = array(
			'product_id'=> 'DESC'
		);

		$products = $this->CModel->get_rows_from('product','product_id,title as name',$attributes,null,$orders,null,null,null);

		foreach ($products as $product) {
			$product->category = $this->CModel->get_row('product_taxonomy','name',$product->product_category_id,null,null)['name'];
		}
		$data['products'] = $products;
		$this->load->view('dashboard/templates/header');
		$this->load->view('dashboard/product/product/view_products',$data);
		$this->load->view('dashboard/templates/footer');
	}
}