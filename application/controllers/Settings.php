<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Settings extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model(array(
			'dashboard_model',
			'efeedor_model',
			'setting_model',
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


	public function escalationip()
	{
		redirect('escalation');
	}


	public function escalationop()
	{
		redirect('escalation_op');
	}


	public function escalationpc()
	{
		redirect('escalation_int');
	}

	public function escalationisr()
	{
		redirect('escalation_esr');
	}
	public function escalationincident()
	{
		redirect('escalation_incident');
	}
	public function escalationgrievance()
	{
		redirect('escalation_grievance');
	}
	public function roles()
	{
		redirect('role');
	}


	public function pc_tat()
	{
		redirect('pc/dep_tat_edit');
	}
	public function op_tat()
	{
		redirect('opf/dep_tat_edit');
	}
	public function ip_tat()
	{
		redirect('ipd/dep_tat_edit');
	}

	public function isr_tat()
	{
		redirect('isr/dep_tat_edit');
	}
	public function incident_tat()
	{
		redirect('incident/dep_tat_edit');
	}
	public function grievance_tat()
	{
		redirect('grievance/dep_tat_edit');
	}

	public function sites_ip()
	{
		redirect('ward');
	}



	public function sites_isr()
	{
		redirect('wardesr');
	}


	public function sites_op()
	{
		redirect('departmentop');
	}

	public function sites_op_location()
	{
		redirect('departmentop_location');
	}
	public function asset_group()
	{
		redirect('departmentasset');
	}

	public function asset_location()
	{
		redirect('assetlocation');
	}

	public function asset_grade()
	{
		redirect('assetgrade');
	}

	public function quality_benchmark()
	{
		redirect('qualitybenchmark');
	}

	public function audit_department()
	{
		redirect('auditdepartment');
	}

	public function audit_patient_category()
	{
		redirect('audit_patient_category');
	}

	public function audit_safety_department()
	{
		redirect('audit_safety_department');
	}

	public function audit_safety_adherence_dept()
	{
		redirect('audit_safety_adherence_dept');
	}


	public function audit_np_ratio_icu()
	{
		redirect('audit_np_ratio_icu');
	}

	public function audit_np_ratio_ward()
	{
		redirect('audit_np_ratio_ward');
	}

	public function audit_hand_designation()
	{
		redirect('audit_hand_designation');
	}

	public function audit_hand_indication()
	{
		redirect('audit_hand_indication');
	}

	public function audit_hand_action()
	{
		redirect('audit_hand_action');
	}

	public function audit_hand_compliance()
	{
		redirect('audit_hand_compliance');
	}

	public function audit_transfusion_type()
	{
		redirect('audit_transfusion_type');
	}

	public function audit_patient_status()
	{
		redirect('audit_patient_status');
	}

	public function audit_emergency_code()
	{
		redirect('audit_emergency_code');
	}



	public function staffs()
	{
		redirect('employee');
	}


	public function supplementary_info()
	{
		$data['title'] = 'SUPPLEMENTARY INFO';
		// print_r($_POST);
		if ($_POST) {

			if ($this->input->post('delivered_on')) {
				$data_d = date('Y-m-d', strtotime($this->input->post('delivered_on')));
			}

			$data = array(

				'google_review_link' => $this->input->post('google_review_link'),
				'validity_key' => $this->input->post('validity_key'),
				'online_feedback' => $this->input->post('online_feedback'),
				'ip_feedback' => $this->input->post('ip_feedback'),
				'op_feedback' => $this->input->post('op_feedback'),
				'pcf_feedback' => $this->input->post('pcf_feedback'),
				'esr_feedback' => $this->input->post('esr_feedback'),
				'inci_feedback' => $this->input->post('inci_feedback'),
				'sg_feedback' => $this->input->post('sg_feedback'),
				'adf_feedback' => $this->input->post('adf_feedback'),
				'staff_log_feedback' => $this->input->post('staff_log_feedback'),
				'notice_message' => $this->input->post('notice_message'),
				'delivered_on' => $data_d,
				'psat_score' => $this->input->post('psat_score'), // Save PSAT Score
				'nps_score' => $this->input->post('nps_score')
			);

			// If user role is not 0, then only update specific fields
			if ($this->session->userdata('user_role') == 2) {
				$data = array(
					'psat_score' => $this->input->post('psat_score'), // Save PSAT Score
					'nps_score' => $this->input->post('nps_score')
				);
			}

			$this->db->where('setting_id', 2);
			$this->db->update('setting', $data);
			$this->upload_apk();

			$this->upload_qucode();
			$this->upload_ipqucode();
			$this->upload_opqucode();
			$this->upload_ipposterqucode();
			$this->upload_opposterqucode();
		}

		$data['content'] = $this->load->view('settings', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}

	public function organization_profile()
	{
		$data['title'] = 'Organization Profile';

		if ($_POST) {



			$data = array(
				'title' => $this->input->post('title'),
				'description' => $this->input->post('description'),
				'industry' => $this->input->post('industry'),
				'website' => $this->input->post('website'),
				'location' => $this->input->post('location'),
				'address' => $this->input->post('hos_address')

			);



			$this->db->where('setting_id', 2);
			$this->db->update('setting', $data);
			$this->upload_logo();
		}

		$data['content'] = $this->load->view('organization_profile', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}

	public function upload_apk()
	{
		$config['upload_path']   = './uploads/';
		$config['allowed_types'] = '*';
		$this->load->library('upload', $config);
		if (!$this->upload->do_upload('android_apk')) {
			$error = array('error' => $this->upload->display_errors());
			// print_r($error); exit;
		} else {
			$data = array('upload_data' => $this->upload->data());
			$android_apk = $data['upload_data']['file_name'];
			$d = array(
				'android_apk' => $android_apk
			);
			$this->db->where('setting_id', 2);
			$this->db->update('setting', $d);
		}
		return true;
	}

	public function upload_qucode()
	{
		$config['upload_path']   = './uploads/';
		$config['allowed_types'] = '*';
		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('qr_code_image')) {

			$error = array('error' => $this->upload->display_errors());
		} else {
			$data = array('upload_data' => $this->upload->data());

			$qr_code_image = $data['upload_data']['file_name'];
			$d = array(
				'qr_code_image' => $qr_code_image
			);

			$this->db->where('setting_id', 2);
			$this->db->update('setting', $d);
		}

		return true;
	}
	public function upload_ipqucode()
	{
		$config['upload_path']   = './uploads/';
		$config['allowed_types'] = '*';
		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('ip_qr_code_image')) {

			$error = array('error' => $this->upload->display_errors());
		} else {
			$data = array('upload_data' => $this->upload->data());

			$ip_qr_code_image = $data['upload_data']['file_name'];
			$d = array(
				'ip_qr_code_image' => $ip_qr_code_image
			);

			$this->db->where('setting_id', 2);
			$this->db->update('setting', $d);
		}
		return true;
	}
	public function upload_opqucode()
	{
		$config['upload_path']   = './uploads/';
		$config['allowed_types'] = '*';
		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('op_qr_code_image')) {

			$error = array('error' => $this->upload->display_errors());
		} else {
			$data = array('upload_data' => $this->upload->data());

			$op_qr_code_image = $data['upload_data']['file_name'];
			$d = array(
				'op_qr_code_image' => $op_qr_code_image
			);
			$this->db->where('setting_id', 2);
			$this->db->update('setting', $d);
		}
		return true;
	}
	public function upload_ipposterqucode()
	{
		$config['upload_path']   = './uploads/';
		$config['allowed_types'] = '*';
		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('ipposter_qr_code_image')) {

			$error = array('error' => $this->upload->display_errors());
		} else {
			$data = array('upload_data' => $this->upload->data());

			$ipposter_qr_code_image = $data['upload_data']['file_name'];
			$d = array(
				'ipposter_qr_code_image' => $ipposter_qr_code_image
			);
			$this->db->where('setting_id', 2);
			$this->db->update('setting', $d);
		}
		return true;
	}
	public function upload_opposterqucode()
	{
		$config['upload_path']   = './uploads/';
		$config['allowed_types'] = '*';
		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('opposter_qr_code_image')) {

			$error = array('error' => $this->upload->display_errors());
		} else {
			$data = array('upload_data' => $this->upload->data());

			$opposter_qr_code_image = $data['upload_data']['file_name'];
			$d = array(
				'opposter_qr_code_image' => $opposter_qr_code_image
			);
			$this->db->where('setting_id', 2);
			$this->db->update('setting', $d);
		}
		return true;
	}
	public function upload_logo()
	{
		$config['upload_path']   = './uploads/';
		$config['allowed_types'] = '*';
		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('logo')) {

			$error = array('error' => $this->upload->display_errors());
		} else {
			$data = array('upload_data' => $this->upload->data());

			$logo = $data['upload_data']['file_name'];
			$d = array(
				'logo' => $logo
			);
			$this->db->where('setting_id', 2);
			$this->db->update('setting', $d);
		}
		// print_r($d);
		// exit;
		return true;
	}
}
