<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required|trim');

		if($this->form_validation->run() == false){
			$this->load->view('login');
		}else{
			$this->_login();
		}
		
	}


	private function _login(){
		$email = $this->input->post('email');
		$password = $this->input->post('password');

		$user = $this->db->get_where('user', ['email' => $email])->row_array();

		if($user){
			if(password_verify($password, $user['password'])){
				$data = [
					'email' => $user['email'],
					'role_id' => $user['role_id'],
				];

				$this->session->set_userdata($data);

				redirect('financial_calculator');
			}else{
				$this->session->set_flashdata('message', '<div class="alert alert-danger">Wrong password!</div>');
				redirect('login');
			}
		}else{
			$this->session->set_flashdata('message', '<div class="alert alert-danger">Email not registered!</div>');
			redirect('login');
		}
	}
}
