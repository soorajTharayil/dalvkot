<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Escalation_grievance extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('isLogIn') == false)
			redirect('login');

		$this->load->model(array(
			'dashboard_model',
			'efeedor_model',
			'setting_model',
			'escalation_model'
		));
		$dates = get_from_to_date();
		if ($this->session->userdata['user_role'] > 2) {
			redirect('dashboard/noaccess');
		}
	}

	public function index()
	{

		$data['title'] = 'GRIEVANCE- ESCALATION';
		#-------------------------------#

		$data['escalation'] = $this->escalation_model->read('GRIEVANCE');

		$data['content'] = $this->load->view('escalation_grievance/index', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}

	public function action()
	{
		if ($this->uri->segment(3) == 'active') {
			$this->escalation_model->change_status('GRIEVANCE', 'ACTIVE');
		} elseif ($this->uri->segment(3) == 'inactive') {
			$this->escalation_model->change_status('GRIEVANCE', 'INACTIVE');
		}
		redirect('escalation_grievance');
	}



	public function create()
	{
		if ($this->input->post('level1_duration_type')) {
			$section = 'GRIEVANCE';
			if ($this->input->post('level1_duration_type') == 'minutes') {
				$level1_duration_min = $this->input->post('level1_duration_value');
			} elseif ($this->input->post('level1_duration_type') == 'hours') {
				$level1_duration_min = $this->input->post('level1_duration_value') * 60;
			} elseif ($this->input->post('level1_duration_type') == 'days') {
				$level1_duration_min = $this->input->post('level1_duration_value') * 60 * 24;
			} else {
				$level1_duration_min = 0;
			}

			if ($this->input->post('level2_duration_type') == 'minutes') {
				$level2_duration_min = $this->input->post('level2_duration_value');
			} elseif ($this->input->post('level2_duration_type') == 'hours') {
				$level2_duration_min = $this->input->post('level2_duration_value') * 60;
			} elseif ($this->input->post('level2_duration_type') == 'days') {
				$level2_duration_min = $this->input->post('level2_duration_value') * 60 * 24;
			} else {
				$level2_duration_min = 0;
			}
			if ($this->input->post('level1_email_alert') != 'YES') {
				$level1_email_alert = 'NO';
			} else {
				$level1_email_alert = 'YES';
			}
			if ($this->input->post('level1_sms_alert') != 'YES') {
				$level1_sms_alert = 'NO';
			} else {
				$level1_sms_alert = 'YES';
			}
			if ($this->input->post('level2_email_alert') != 'YES') {
				$level2_email_alert = 'NO';
			} else {
				$level2_email_alert = 'YES';
			}

			if ($this->input->post('level2_sms_alert') != 'YES') {
				$level2_sms_alert = 'NO';
			} else {
				$level2_sms_alert = 'YES';
			}
			if($this->input->post('dept_level_email_alert') != 'YES'){
				$dept_level_email_alert = 'NO';
			}else{
				$dept_level_email_alert = 'YES';
			}
			if($this->input->post('dept_level_sms_alert') != 'YES'){
				$dept_level_sms_alert = 'NO';
			}else{
				$dept_level_sms_alert = 'YES';
			}


			$dataset = array(
				"level1_duration_type"		=> 	$this->input->post('level1_duration_type'),
				"level1_duration_value"		=>	$this->input->post('level1_duration_value'),
				"level1_duration_min"		=>	$level1_duration_min,
				"level1_escalate_to"		=>	json_encode($this->input->post('level1_escalate_to')),
				"level1_sms_alert"			=>	$level1_sms_alert,
				"level1_email_alert"		=>	$level1_email_alert,
				"level2_duration_type"		=>	$this->input->post('level2_duration_type'),
				"level2_duration_value"		=>	$this->input->post('level2_duration_value'),
				"dept_level_sms_alert"		=>	$dept_level_sms_alert,
				"dept_level_email_alert"	=>	$dept_level_email_alert,
				"dept_level_escalation_to"	=>	json_encode($this->input->post('dept_level_escalation_to')),
				"level2_duration_min"		=>	$level2_duration_min,
				"level2_escalate_to"		=>	json_encode($this->input->post('level2_escalate_to')),
				"level2_sms_alert"			=>	$level2_sms_alert,
				"level2_email_alert"		=>	$level2_email_alert
			);
			$this->db->where('section', $section)->update('escalation', $dataset);
		}


		redirect('escalation_grievance');
	}
}
