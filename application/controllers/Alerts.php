<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coordinator extends CI_Controller {

	// public function __construct()
	// {
	// 	// parent::__construct();

	// 	// $this->load->model(array(
	// 	// 	'coordinator_model'
	// 	// ));

	// 	if ($this->session->userdata('isLogIn') == false
			
	// 	)
	// 	redirect('login');

	// }

	public function index()
	{
		$data['title'] = 'Manage Alerts';
		#-------------------------------#
		// $data['departments'] = $this->coordinator_model->read();
		$data['content'] = $this->load->view('timemanagement/index',true);
		$this->load->view('layout/main_wrapper',$data);
	}
}