<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Subscription extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model(array(
			'dashboard_model',
			'efeedor_model',
			'subscription_model',
			'ipd_model',
			'opf_model',
			'pc_model',
			'isr_model',
			'incident_model',
			'grievance_model',
			'admissionfeedback_model',

		));
		if ($this->session->userdata('isLogIn') == false)
			redirect('login');

		
	}

	public function index()
	{

		if ($this->session->userdata('isLogIn') == false)
			redirect('login');
		$data['title'] = '<i class="fa fa-gear"></i> Settings';
		$data['content'] = $this->load->view('all_settings', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}


	public function organization()
	{
		$data['title'] = 'Subscription Details';

		if ($_POST) {

			if ($this->input->post('delivered_on')) {
				$data_d = date('Y-m-d', strtotime($this->input->post('delivered_on')));
			}
			if ($this->input->post('delivered_end')) {
				$data_end = date('Y-m-d', strtotime($this->input->post('delivered_end')));
			}

			$data = array(
				'plan' => $this->input->post('plan'),
				'billing_cycle' => $this->input->post('billing_cycle'),
				'billing_status' => $this->input->post('billing_status'),
				'product' => $this->input->post('product'),
				'module_included' => $this->input->post('module_included'),
				'usage_limit' => $this->input->post('usage_limit'),
				'delivered_on' => $data_d,
				'delivered_end' => $data_end
			);



			$this->db->insert('subscription', $data);
		}

		$data['content'] = $this->load->view('subscription_view', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}
}
