<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coordinator extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model(array(
			'coordinator_model'
		));

		if ($this->session->userdata('isLogIn') == false
			
		)
		redirect('login');

	}

	public function index()
	{
		$data['title'] = 'Patient Coordinators list';
		#-------------------------------#
		$data['departments'] = $this->coordinator_model->read();
		$data['content'] = $this->load->view('coordinator/coordinator',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	}

 	public function create()
	{
		$data['title'] = 'Add Coordinator';
		#-------------------------------#
		$this->form_validation->set_rules('name', 'Name Required' ,'required|max_length[100]');
		$this->form_validation->set_rules('guid', 'Employee ID Requried','trim');
		$this->form_validation->set_rules('password', 'Password Requried','trim');
		$this->form_validation->set_rules('status', display('status') ,'required');
		#-------------------------------#
		$data['department'] = (object)$postData = [
			'guid' 	  => $this->input->post('guid',true),
			'name' 		  => $this->input->post('name',true),
			'password' 		  => $this->input->post('password',true),
			'status' => $this->input->post('status',true)

		];

		#-------------------------------#
		if ($this->form_validation->run() === true) {
			#if empty $dp
			
			if (empty($postData['guid'])) {
				if ($this->coordinator_model->create($postData)) {
					#set success message
					$this->session->set_flashdata('message', display('save_successfully'));
				} else {
					#set exception message
					$this->session->set_flashdata('exception',display('please_try_again'));
				}
				redirect('coordinator');
			} else {
				if ($this->coordinator_model->update($postData)) {
					#set success message
					$this->session->set_flashdata('message', display('update_successfully'));
				} else {
					#set exception message
					$this->session->set_flashdata('exception',display('please_try_again'));
				}
				redirect('coordinator');
			}

		} else {
			$data['content'] = $this->load->view('coordinator/coordinator_form',$data,true);
			$this->load->view('layout/main_wrapper',$data);
		}
	}

	public function edit($dprt_id = null)
	{
		$data['title'] = display('department_edit');
		#-------------------------------#
		$data['department'] = $this->coordinator_model->read_by_id($dprt_id);
		$data['content'] = $this->load->view('coordinator/coordinator_form',$data,true);
		$this->load->view('layout/main_wrapper',$data);
	}


	public function delete($dprt_id = null)
	{
		if ($this->coordinator_model->delete($dprt_id)) {
			#set success message
			$this->session->set_flashdata('message', display('delete_successfully'));
		} else {
			#set exception message
			$this->session->set_flashdata('exception', display('please_try_again'));
		}
		redirect('coordinator');
	}

}
