<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model(array(
			'users_model'
		));

		if (
			$this->session->userdata('isLogIn') == false

		)
			redirect('login');
		if ($this->session->userdata('user_role') >= 3)
			redirect('dashboard/noaccess');
	}

	public function index()
	{

		$data['title'] = 'MANAGE USERS';
		#-------------------------------#
		$data['departments'] = $this->users_model->read();
		//print_r($data); exit;
		$data['content'] = $this->load->view('users/index', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}

	public function create()
	{
		$data['title'] = 'CREATING NEW';
		#-------------------------------#
		$this->form_validation->set_rules('name', 'Name Required', 'required|max_length[100]');
		$this->form_validation->set_rules('password', 'Password Requried', 'trim');

		//$this->form_validation->set_rules('status', display('status') ,'required');

		$this->form_validation->set_rules('mobile', 'Mobile Number', 'required|exact_length[10]|numeric');
        $this->form_validation->set_rules('alternate_mobile', 'Alternate Mobile Number', 'trim|exact_length[10]|numeric|callback_check_phone_numbers');

		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('alternate_email', 'Alternate Email', 'trim|valid_email|callback_check_emails');


		#-------------------------------#
		$data['department'] = (object)$postData = [
			'firstname' 		  => $this->input->post('name', true),
			'password' 		  => md5($this->input->post('password', true)),
			'email' 		  => $this->input->post('email', true),
			'alternate_email' 		  => $this->input->post('alternate_email', true),
			'mobile' 		  => $this->input->post('mobile', true),
			'alternate_mobile' 		  => $this->input->post('alternate_mobile', true),
			'user_role' 		  => $this->input->post('user_role', true),
			'departmentpermission' 		  => json_encode($_POST),
		];

		#-------------------------------#
		if ($this->form_validation->run() === true) {
			#if empty $dp

			if (empty($_POST['ids'])) {
				$this->db->where('email', $postData['email']);
				$result = $this->db->get('user');
				$datat = $result->result();

				if ($datat) {
					$this->session->set_flashdata('exception', 'Error: Email Id already exit');
					$data['content'] = $this->load->view('users/form', $data, true);
					$this->load->view('layout/main_wrapper', $data);
				} else {
					if ($this->input->post('userrole') == 'SuperAdmin') {
						$postData['user_role'] = 2;
					} elseif ($this->input->post('userrole') ==  'Admin') {
						$postData['user_role'] = 3;
					} elseif ($this->input->post('userrole') ==  'Department Head') {
						$postData['user_role'] = 4;
					} elseif ($this->input->post('userrole') ==  'Admission Section') {
						$postData['user_role'] = 5;
					}

					if ($this->users_model->create($postData)) {
						#set success message
						$this->session->set_flashdata('message', display('save_successfully'));
					} else {
						#set exception message
						$this->session->set_flashdata('exception', display('please_try_again'));
					}
					redirect('users');
				}
			} else {
				if ($this->users_model->update($postData)) {
					#set success message
					$this->session->set_flashdata('message', display('update_successfully'));
				} else {
					#set exception message
					$this->session->set_flashdata('exception', display('please_try_again'));
				}
				redirect('users');
			}
		} else {
			if ($this->input->post('userrole') == 'SuperAdmin') {
				$postData['user_role'] = 2;
			} elseif ($this->input->post('userrole') ==  'Admin') {
				$postData['user_role'] = 3;
			} elseif ($this->input->post('userrole') ==  'Department Head') {
				$postData['user_role'] = 4;
			} elseif ($this->input->post('userrole') ==  'Admission Section') {
				$postData['user_role'] = 5;
			}
			$data['depip'] = $this->users_model->department_list('inpatient');
			$data['depop'] = $this->users_model->department_list('outpatient');
			$data['depin'] = $this->users_model->department_list('interim');
			$data['deppsr'] = $this->users_model->department_list('service');
			$data['depesr'] = $this->users_model->department_list('esr');
			$data['depempex'] = $this->users_model->department_list('employees');
			$data['depinci'] = $this->users_model->department_list('incident');
			$data['depadf'] = $this->users_model->department_list('adf');
			$data['depgrievance'] = $this->users_model->department_list('grievance');

			$data['content'] = $this->load->view('users/form', $data, true);
			$this->load->view('layout/main_wrapper', $data);
		}
	}

	public function check_phone_numbers($alternate_mobile) {
        $primary_mobile = $this->input->post('mobile');

        if ($alternate_mobile == $primary_mobile) {
            $this->form_validation->set_message('check_phone_numbers', 'The Alternate Mobile Number must be different from the Mobile Number.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

	public function check_emails($alternate_email) {
        $primary_email = $this->input->post('email');

        if ($alternate_email == $primary_email) {
            $this->form_validation->set_message('check_emails', 'The Alternate Email must be different from the Email.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

	public function edit($dprt_id = null)
	{
		$data['title'] = 'UPDATING USER RECORDS';
		#-------------------------------#
		$data['department'] = $this->users_model->read_by_id($dprt_id);
		$data['depip'] = $this->users_model->department_list('inpatient');
		$data['depop'] = $this->users_model->department_list('outpatient');
		$data['depin'] = $this->users_model->department_list('interim');
		$data['deppsr'] = $this->users_model->department_list('service');
		$data['depesr'] = $this->users_model->department_list('esr');
		$data['depempex'] = $this->users_model->department_list('employees');
		$data['depinci'] = $this->users_model->department_list('incident');
		$data['depadf'] = $this->users_model->department_list('adf');
		$data['depgrievance'] = $this->users_model->department_list('grievance');

		if ($this->input->post('userrole') == 'SuperAdmin') {
			$postData['user_role'] = 2;
		} elseif ($this->input->post('userrole') ==  'Admin') {
			$postData['user_role'] = 3;
		} elseif ($this->input->post('userrole') ==  'Department Head') {
			$postData['user_role'] = 4;
		} elseif ($this->input->post('userrole') ==  'Admission Section') {
			$postData['user_role'] = 5;
		}
// print_r($_POST);
// exit;
		$data['content'] = $this->load->view('users/form', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}


	public function delete($dprt_id = null)
	{
		if ($this->users_model->delete($dprt_id)) {
			#set success message
			$this->session->set_flashdata('message', display('delete_successfully'));
		} else {
			#set exception message
			$this->session->set_flashdata('exception', display('please_try_again'));
		}
		redirect('users');
	}


	public function create_or_update()
	{
		$this->output->set_content_type('application/json');
		try {
			$json = json_decode($this->input->raw_input_stream, true);

			if (json_last_error() !== JSON_ERROR_NONE) {
				return $this->output->set_output(json_encode([
					'status' => false,
					'message' => 'Invalid JSON input'
				]));
			}

			// Required fields
			$required = ['name', 'email', 'mobile', 'user_role'];
			$errors = [];

			foreach ($required as $field) {
				if (empty($json[$field])) {
					$errors[$field] = ucfirst($field) . ' is required';
				}
			}

			if (!empty($json['email']) && !filter_var($json['email'], FILTER_VALIDATE_EMAIL)) {
				$errors['email'] = 'Invalid email format';
			}

			if (!empty($json['alternate_email']) && $json['alternate_email'] == $json['email']) {
				$errors['alternate_email'] = 'Alternate email must differ from primary email';
			}

			if (!empty($json['alternate_mobile']) && $json['alternate_mobile'] == $json['mobile']) {
				$errors['alternate_mobile'] = 'Alternate mobile must differ from primary mobile';
			}

			if (!empty($errors)) {
				return $this->output->set_output(json_encode([
					'status' => false,
					'message' => 'Validation failed',
					'errors' => $errors
				]));
			}

			$department_permission = isset($json['departmentpermission']) ? $json['departmentpermission'] : [];

			$department_permission['ids'] = $json['ids'] ?? '';
			$department_permission['name'] = $json['name'] ?? '';
			$department_permission['designation'] = $json['designation'] ?? '';
			$department_permission['empid'] = $json['empid'] ?? '';
			$department_permission['email'] = $json['email'] ?? '';
			$department_permission['mobile'] = $json['mobile'] ?? '';
			$department_permission['password'] = $json['password'] ?? '';
			$department_permission['userrole'] = $json['user_role'] ?? '';
			// Prepare data
			$data = [
				'firstname' => $json['name'],
				'lastname' => $json['role_name'],
				'email' => $json['email'],
				'mobile' => $json['mobile'],
				'user_role' => $json['user_role'],
				'password' => isset($json['password']) ? md5($json['password']) : null,
				'departmentpermission' => json_encode($department_permission),
			];

			// Create or update logic
			if (empty($json['id'])) {
				// CREATE: check duplicate email
				$exists = $this->db->get_where('user', ['email' => $data['email']])->row();
				if ($exists) {
					return $this->output->set_output(json_encode([
						'status' => false,
						'message' => 'Email already exists'
					]));
				}

				$success = $this->users_model->create($data);

				return $this->output->set_output(json_encode([
					'status' => $success ? true : false,
					'message' => $success ? 'User created successfully' : 'Failed to create user'
				]));
			} else {
				// UPDATE
				$data['user_id'] = $json['id'];
				$success = $this->users_model->update($data);

				return $this->output->set_output(json_encode([
					'status' => $success ? true : false,
					'message' => $success ? 'User updated successfully' : 'Failed to update user'
				]));
			}
		} catch (Exception $e) {
			return $this->output->set_output(json_encode([
				'status' => false,
				'message' => 'Server error',
				'error' => $e->getMessage()
			]));
		}
	}
}
