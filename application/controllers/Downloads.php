<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Downloads extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$dates = get_from_to_date();
		$this->load->model(array(
			'dashboard_model',
			'efeedor_model',
			'ticketsint_model',
			'tickets_model',
			'ticketsop_model',
			'setting_model',
            'employee_model'
		));
	}


    public function index()
	{
		$data['title'] = 'Downloads';
		$data['patients'] = $this->employee_model->read();
		$data['content'] = $this->load->view('downloads',$data, true);
		$this->load->view('layout/main_wrapper', $data);

	}
}
