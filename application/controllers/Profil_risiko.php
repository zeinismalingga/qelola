<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profil_risiko extends CI_Controller {

	public function index()
	{	
		$data['title'] = 'Profil Risiko';
		$this->load->view('template/header', $data);
		$this->load->view('user/Profil_risiko');
		$this->load->view('template/footer');
	}

	public function add()
	{	
		$no_1 = $_POST['no_1'];
		$no_2 = $_POST['no_2'];
		$no_3 = $_POST['no_3'];
		$no_4 = $_POST['no_4'];
		$no_5 = $_POST['no_5'];
		$no_6 = $_POST['no_6'];
		$no_7 = $_POST['no_7'];
		$time_horizone = $_POST['time_horizone'];
		$risk_tolerance_score = $_POST['risk_tolerance_score'];

		$user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

		$id_user = $user['id'];

		$data = array(
			'id_user' => $id_user,
			'no_1' => $no_1,
			'no_2' => $no_2,
			'no_3' => $no_3,
			'no_4' => $no_4,
			'no_5' => $no_5,
			'no_6' => $no_6,
			'time_horizone' => $time_horizone,
			'risk_tolerance_score' => $risk_tolerance_score,
		);

		$this->db->insert('profil_risiko', $data);
	}

}
