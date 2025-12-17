<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Audit_frequency extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model(array(
			'audit_frequency_model',
			'dashboard_model',
			'efeedor_model',
		));
		if ($this->session->userdata('isLogIn') == false)
			redirect('login');
		if ($this->session->userdata['user_role'] > 2) {

			redirect('dashboard/noaccess');
		}
	}

	public function index()
	{
		$data['title'] = 'MANAGE AUDIT FREQUENCY AND SCHEDULING';
		#-------------------------------#
		$data['departments'] = $this->audit_frequency_model->read();
		$data['content'] = $this->load->view('audit_frequency/audit_frequency', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}

	public function create()
	{
		$data['title'] = 'ADD AUDITS';
		#-------------------------------#
		$this->form_validation->set_rules('name', display('department_name'), 'required|max_length[100]');


		#-------------------------------#
		$data['department'] = (object)$postData = [
			'guid' 	  => $this->input->post('guid', true),
			'title' 		  => $this->input->post('name', true),
			'audit_type' 		  => $this->input->post('audit_type', true),
			'bed_no' => $this->input->post('description', true),
			'frequency' => $this->input->post('frequency', true),
			'target' => $this->input->post('target', true)


		];
		#-------------------------------#
		if ($this->form_validation->run() === true) {

			#if empty $dprt_id then insert data
			if (empty($postData['guid'])) {
				if ($this->audit_frequency_model->create($postData)) {
					#set success message
					$this->session->set_flashdata('message', display('save_successfully'));
				} else {
					#set exception message
					$this->session->set_flashdata('exception', display('please_try_again'));
				}
				redirect('audit_frequency');
			} else {
				if ($this->audit_frequency_model->update($postData)) {
					#set success message
					$this->session->set_flashdata('message', display('update_successfully'));
				} else {
					#set exception message
					$this->session->set_flashdata('exception', display('please_try_again'));
				}
				redirect('audit_frequency/edit/' . $postData['guid']);
			}
		} else {
			$data['content'] = $this->load->view('audit_frequency/audit_frequency_form', $data, true);
			$this->load->view('layout/main_wrapper', $data);
		}
	}

	public function edit($dprt_id = null)
	{
		$data['title'] = 'EDIT AUDITS';
		#-------------------------------#
		$data['department'] = $this->audit_frequency_model->read_by_id($dprt_id);
		$data['content'] = $this->load->view('audit_frequency/audit_frequency_form', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}


	public function delete($dprt_id = null)
	{
		if ($this->audit_frequency_model->delete($dprt_id)) {
			#set success message
			$this->session->set_flashdata('message', display('delete_successfully'));
		} else {
			#set exception message
			$this->session->set_flashdata('exception', display('please_try_again'));
		}
		redirect('audit_frequency');
	}
}
