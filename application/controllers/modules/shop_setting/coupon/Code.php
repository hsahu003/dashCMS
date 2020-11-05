<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH."controllers/modules/shop_setting/coupon/Coupon.php");

class Code extends Coupon {
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');

		//check for admin login session
		is_admin_logged_in();

	}

	function add(){
		if($this->input->method() == 'get')
		{
			$this->load->view('dashboard/templates/header');
			$this->load->view('dashboard/shop_setting/coupon/code/add_code');
			$this->load->view('dashboard/templates/footer');
		}else{
			//validations
			$this->load->library('form_validation');

			$this->form_validation->set_rules('coupon_name','Coupon Name','required|is_unique[coupon.name]');
			$this->form_validation->set_rules('discount_type','Discount type','required');
			$this->form_validation->set_rules('discount_value','Discount value','required|numeric');
			$this->form_validation->set_rules('valid_till','Valid till','required');
			$this->form_validation->set_rules('coupon_quantity','Coupon quantity','required|numeric');
			$this->form_validation->set_rules('limit_per_person','Limit per_person','required|numeric');

			if ($this->form_validation->run() == FALSE) {
				$errors = array_values($this->form_validation->error_array());
				$data = array('execute' => 'failure','message' => $errors[0]);
				$this->load->view('dashboard/templates/header');
				$this->load->view('dashboard/shop_setting/coupon/code/add_code',$data);
				$this->load->view('dashboard/templates/footer');
			}else{
				//prepare data
				$time = date("Y-m-d H:i:s");
				$coupon_data = array(
					'name' => $this->input->post('coupon_name'),
					'description' => $this->input->post('description'),
					'discount' => $this->input->post('discount_value'),
					'type' => $this->input->post('discount_type'),
					'valid_till' => $this->input->post('valid_till'),
					'quantity' => $this->input->post('coupon_quantity'),
					'limit_per_user' => $this->input->post('limit_per_person'),
					'date_created' => $time,
					'user_created_id' => $this->session->admin_id,
				);

				$this->CModel->add_into_table('coupon',$coupon_data);
			}
		}
		
	}

	public function view_all(){
		$data['coupons'] = $this->CModel->get_rows_from('coupon','*');
		$this->load->view('dashboard/templates/header');
		$this->load->view('dashboard/shop_setting/coupon/code/view_codes',$data);
		$this->load->view('dashboard/templates/footer');
	}
}