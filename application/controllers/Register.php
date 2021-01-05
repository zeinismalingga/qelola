<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

	public function index()
	{
		$this->form_validation->set_rules('name', 'Full Name', 'required|trim');
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
				'is_unique' => 'This email has already registered!'
		]);
		$this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]');	
		$this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');	

		if($this->form_validation->run() == false){
			$this->load->view('register');
		}else{
			$data = [
				'name' => $this->input->post('name', true),
				'email' => $this->input->post('email', true),
				'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
				'role_id' => 2,
				'is_active' => 1
			];

			$this->db->insert('user', $data);
			$this->session->set_flashdata('message', '<div class="alert alert-success">Congratulation! your account has been created. Please Login</div>');
			redirect('login');
		}
		
	}
}
