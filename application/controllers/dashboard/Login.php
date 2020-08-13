<?php 
class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('common/common_media');
		$this->load->helper('form');
		$this->load->model('dashboard/settings/admin_model', 'AModel');
	}

	public function index(){
		
		// redirect('/dashboard');	
		// if($this->input->method() == 'get')
		// {
		// 	if($this->session->logged_in){
		// 		redirect('dashboard');
		// 	}
		// }
		// else
		// {
			$this->load->library('form_validation');

			// Validations
			$this->form_validation->set_rules('username','User Name/Email','required');
			$this->form_validation->set_rules('password','Password','required');

			// Run Validations
			if($this->form_validation->run() === FALSE)
			{
				$errors = array_values($this->form_validation->error_array());
				$data = array('execute' => 'failure','message' => $errors[0]);
				$this->load->view('dashboard/login',$data);
			}
			// Validation Ok
			else
			{	
				$user = $this->AModel->get_admin($this->input->post('username'));
				if(password_verify('Wonderheis1', '$2y$10$W7YphenzwOFldCpYI.2Yr.Jbg')){
						echo "match";
				}else{
					echo "doesnt match";
				}
				echo $this->input->post('password') . " ".$user['password'];
				// if(password_verify($this->input->post('password'), $user['password'])){
				// 	$userdata = array(
				// 		'user_id' => $user['ID'],
				// 		'firstName' => $user['firstName'],
				// 		'lastName' => $user['lastName'],
				// 		'email' => $user['email'],
				// 		'mobile' => $user['mobile'],
				// 		'superAdmin' => $user['superAdmin'],
				// 		'status' => '1',
				// 		'logged_in' => true,
				// 	);
				// 	redirect('/dashboard');
				// }

			}
		// }
		
	}

}


 ?>