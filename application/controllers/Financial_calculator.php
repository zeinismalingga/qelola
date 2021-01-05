<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Financial_calculator extends CI_Controller {

	public function index()
	{	
		$data['title'] = 'Financial Calculator';
		$this->load->view('template/header', $data);
		$this->load->view('user/financial_calculator');
		$this->load->view('template/footer');
	}

}
