<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ward extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model(array(
			'dashboard_model',
			'efeedor_model',
			'ticketsint_model',
			'tickets_model',
			'ticketsop_model',
			'ipd_model',
			'opf_model',
			'pc_model',
            'admissionfeedback_model',
			'departmenthead_model',
			'setting_model',
			'ward_model',
		));
		$this->session->set_userdata([
			'active_menu' => array('ip_dashboard', 'ip_ticket', 'ip_reports', 'ip_patients', 'ip_settings', 'ip_dep', 'ip_analysis'),
		]);
		if ($this->session->userdata('isLogIn') == false)
			redirect('login');
		
		
	}

	public function index()
	{
		$data['title'] = 'MANAGE FLOOR/WARDS';
		#-------------------------------#
		$data['departments'] = $this->ward_model->read();
		$data['content'] = $this->load->view('ward', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}

	public function create()
	{
		$data['title'] = 'ADDING FLOOR/WARD';
		#-------------------------------#
		$this->form_validation->set_rules('name', display('department_name'), 'required|max_length[100]');


		#-------------------------------#
		$data['department'] = (object)$postData = [
			'guid' 	  => $this->input->post('guid', true),
			'title' 		  => $this->input->post('name', true),
			'titlek' 		  => $this->input->post('name', true),
			'titlem' 		  => $this->input->post('name', true),
			'smallname' 		  => $this->input->post('smallname', true),
			'bed_no' => $this->input->post('description', true),
			'bed_nok' => $this->input->post('description', true),
			'bed_nom' => $this->input->post('description', true),

		];
		#-------------------------------#
		if ($this->form_validation->run() === true) {

			#if empty $dprt_id then insert data
			if (empty($postData['guid'])) {
				if ($this->ward_model->create($postData)) {
					#set success message
					$this->session->set_flashdata('message', display('save_successfully'));
				} else {
					#set exception message
					$this->session->set_flashdata('exception', display('please_try_again'));
				}
				redirect('ward');
			} else {
				if ($this->ward_model->update($postData)) {
					#set success message
					$this->session->set_flashdata('message', display('update_successfully'));
				} else {
					#set exception message
					$this->session->set_flashdata('exception', display('please_try_again'));
				}
				redirect('ward');
			}
		} else {
			$data['content'] = $this->load->view('ward_form', $data, true);
			$this->load->view('layout/main_wrapper', $data);
		}
	}

	public function edit($dprt_id = null)
	{
		$data['title'] = 'UPDATING FLOOR/WARD';
		#-------------------------------#
		$data['department'] = $this->ward_model->read_by_id($dprt_id);
		$data['content'] = $this->load->view('ward_form', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}


	public function delete($dprt_id = null)
	{
		if ($this->ward_model->delete($dprt_id)) {
			#set success message
			$this->session->set_flashdata('message', display('delete_successfully'));
		} else {
			#set exception message
			$this->session->set_flashdata('exception', display('please_try_again'));
		}
		redirect('ward');
	}
}
