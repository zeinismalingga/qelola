<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Financial_checkup extends CI_Controller {

	public function index()
	{	
		$data['title'] = 'Financial Checkup';
		$this->load->view('template/header', $data);
		$this->load->view('user/financial_checkup');
		$this->load->view('template/footer');
	}

}
