<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Role extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model(array(
			'dashboard_model',
			'efeedor_model',
			'ipd_model',
			'opf_model',
			'pc_model',
			'isr_model',
			'incident_model',
			'grievance_model',
			'admissionfeedback_model',
			'setting_model',
			'role_model',
		));
		$this->session->set_userdata([
			'active_menu' => array('esr_settings'),
		]);
		if ($this->session->userdata('isLogIn') == false)
			redirect('login');
	
	}

	public function index()
	{
		$data['title'] = 'MANAGE STAFF JOB ROLES';
		#-------------------------------#
		$data['departments'] = $this->role_model->read();
		$data['content'] = $this->load->view('esrmodules/emp_roles/index', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}

	public function create()
	{
		$data['title'] = 'ADDING NEW JOB ROLE';
		#-------------------------------#
		$this->form_validation->set_rules('name', display('department_name'), 'required|max_length[100]');


		#-------------------------------#
		$data['department'] = (object)$postData = [
			'guid' 	  => $this->input->post('guid', true),
			'title' 		  => $this->input->post('name', true),
			'smallname' 		  => $this->input->post('name', true),
			'bed_no' => $this->input->post('description', true)

		];
		#-------------------------------#
		if ($this->form_validation->run() === true) {

			#if empty $dprt_id then insert data
			if (empty($postData['guid'])) {
				if ($this->role_model->create($postData)) {
					#set success message
					$this->session->set_flashdata('message', display('save_successfully'));
				} else {
					#set exception message
					$this->session->set_flashdata('exception', display('please_try_again'));
				}
				redirect('role');
			} else {
				if ($this->role_model->update($postData)) {
					#set success message
					$this->session->set_flashdata('message', display('update_successfully'));
				} else {
					#set exception message
					$this->session->set_flashdata('exception', display('please_try_again'));
				}
				redirect('role');
			}
		} else {
			$data['content'] = $this->load->view('esrmodules/emp_roles/role_form', $data, true);
			$this->load->view('layout/main_wrapper', $data);
		}
	}

	public function edit($dprt_id = null)
	{
		$data['title'] = 'UPDATING JOB ROLE';
		#-------------------------------#
		$data['department'] = $this->role_model->read_by_id($dprt_id);
		$data['content'] = $this->load->view('esrmodules/emp_roles/role_form', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}


	public function delete($dprt_id = null)
	{
		if ($this->role_model->delete($dprt_id)) {
			#set success message
			$this->session->set_flashdata('message', display('delete_successfully'));
		} else {
			#set exception message
			$this->session->set_flashdata('exception', display('please_try_again'));
		}
		redirect('role');
	}
}
