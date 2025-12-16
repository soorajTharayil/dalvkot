<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UserManagement extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model(array(
			'UserManagement_model'
		));

		if (
			$this->session->userdata('isLogIn') == false

		)
			redirect('login');
	}

	public function index()
	{

		$data['title'] = 'MANAGE USERS';
		#-------------------------------#
		$data['department_descriptions'] = $this->UserManagement_model->get_all_descriptions();

		//print_r($data); exit;
		$data['content'] = $this->load->view('user_management/index', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}



	public function create()
	{
		$data['title'] = 'CREATING NEW USER';

		// Add custom validation rule for email and mobile
		$this->form_validation->set_rules(
			'email',
			'Email',
			'trim|valid_email|callback_check_contact_details'
		);
		$this->form_validation->set_rules(
			'mobile',
			'Mobile Number',
			'trim|exact_length[10]|numeric|callback_check_contact_details'
		);

		#-------------------------------#

		if (empty($_POST['ids'])) {
			$this->form_validation->set_rules('name', 'Name', 'required|max_length[100]');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|callback_check_password');
		}

		if ($this->input->post('userrole')) {
			$roleFeature = $this->db->where('role_id', $this->input->post('userrole'))->get('roles')->result();
			$last_name = $roleFeature[0]->role_name;
		}

		#-------------------------------#
		$data['department'] = (object)$postData = [
			'firstname'            => $this->input->post('name', true),
			'designation'            => $this->input->post('designation', true),
			'password'             => md5($this->input->post('password', true)),
			'email'                => $this->input->post('email', true),
			'mobile'               => $this->input->post('mobile', true),
			'emp_id'     => $this->input->post('empid', true),
			'user_role'            => $this->input->post('userrole', true),
			'lastname'             => $last_name,
			'departmentpermission' => json_encode($_POST),
		];

		#-------------------------------#
		if ($this->form_validation->run() === true) {
			#if empty $dp

			if (empty($_POST['ids'])) {
				$this->db->where('email', $postData['email']);
				$this->db->where('email !=', ''); // Exclude rows where email is an empty string
				$this->db->where('email IS NOT NULL'); // Exclude rows where email is NULL
				$result = $this->db->get('user');
				$datat = $result->result();

				if ($datat) {
					$this->session->set_flashdata('exception', 'Error: Email Id already exit');
					$data['content'] = $this->load->view('UserManagement/form', $data, true);
					$this->load->view('layout/main_wrapper', $data);
				} else {


					if ($this->UserManagement_model->create($postData)) {

						#set success message
						$this->session->set_flashdata('message', display('save_successfully'));
					} else {
						#set exception message
						$this->session->set_flashdata('exception', display('please_try_again'));
					}
					$curl = curl_init();
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($curl, CURLOPT_URL, base_url() . 'api/curl.php');
					curl_exec($curl);
					redirect('UserManagement');
				}
			} else {
				if ($this->UserManagement_model->update($postData)) {
					#set success message
					$this->session->set_flashdata('message', display('update_successfully'));
				} else {
					#set exception message
					$this->session->set_flashdata('exception', display('please_try_again'));
				}
				redirect('UserManagement');
			}
		} else {
			//print_r($_POST); exit;
			$data['depip'] = $this->UserManagement_model->department_list('inpatient');
			$data['depop'] = $this->UserManagement_model->department_list('outpatient');
			$data['depin'] = $this->UserManagement_model->department_list('interim');
			$data['deppsr'] = $this->UserManagement_model->department_list('service');
			$data['depesr'] = $this->UserManagement_model->department_list('esr');
			$data['depempex'] = $this->UserManagement_model->department_list('employees');
			$data['depinci'] = $this->UserManagement_model->department_list('incident');
			$data['depadf'] = $this->UserManagement_model->department_list('adf');
			$data['depgrievance'] = $this->UserManagement_model->department_list('grievance');

			//redirect('UserManagement/edit/5');
			$data['content'] = $this->load->view('user_management/form', $data, true);
			$this->load->view('layout/main_wrapper', $data);
		}
	}



	public function create_edit()
	{
		$data['title'] = 'EDIT';
		// Add custom validation rule for email and mobile
		$this->form_validation->set_rules(
			'email',
			'Email',
			'trim|valid_email|callback_check_contact_details'
		);
		$this->form_validation->set_rules(
			'mobile',
			'Mobile Number',
			'trim|exact_length[10]|numeric|callback_check_contact_details'
		);

		#-------------------------------#

		$this->form_validation->set_rules('name', 'Name', 'required|max_length[100]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|callback_check_password');

		$last_name = ''; // Initialize last_name to avoid undefined variable notice
		if ($this->input->post('userrole')) {
			$roleFeature = $this->db->where('role_id', $this->input->post('userrole'))->get('roles')->result();
			if (!empty($roleFeature)) {
				$last_name = $roleFeature[0]->role_name;
			}
		}

		#-------------------------------#
		$data['department'] = (object)$postData = [
			'firstname'            => $this->input->post('name', true),
			'designation'          => $this->input->post('designation', true),
			'password'             => md5($this->input->post('password', true)),
			'email'                => $this->input->post('email', true),
			'mobile'               => $this->input->post('mobile', true),
			'emp_id'               => $this->input->post('empid', true),
			'user_role'            => $this->input->post('userrole', true),
			'lastname'             => $last_name,
			'departmentpermission' => json_encode($_POST),
		];

		#-------------------------------#
		if ($this->form_validation->run() === true) {
			# Check if `ids` is set in POST data for update operation

			if ($this->UserManagement_model->update($postData)) {
				# Set success message
				$this->session->set_flashdata('message', display('update_successfully'));
			} else {
				# Set exception message
				$this->session->set_flashdata('exception', display('please_try_again'));
			}
			redirect('UserManagement');
		} else {

			$data['depip'] = $this->UserManagement_model->department_list('inpatient');
			$data['depop'] = $this->UserManagement_model->department_list('outpatient');
			$data['depin'] = $this->UserManagement_model->department_list('interim');
			$data['deppsr'] = $this->UserManagement_model->department_list('service');
			$data['depesr'] = $this->UserManagement_model->department_list('esr');
			$data['depempex'] = $this->UserManagement_model->department_list('employees');
			$data['depinci'] = $this->UserManagement_model->department_list('incident');
			$data['depadf'] = $this->UserManagement_model->department_list('adf');
			$data['depgrievance'] = $this->UserManagement_model->department_list('grievance');

			$data['content'] = $this->load->view('user_management/form_edit', $data, true);
			$this->load->view('layout/main_wrapper', $data);
		}
	}

	public function check_contact_details($value)
	{
		$email = $this->input->post('email');
		$mobile = $this->input->post('mobile');

		if (empty($email) && empty($mobile)) {
			$this->form_validation->set_message(
				'check_contact_details',
				'Either Email or Mobile Number is required.'
			);
			return false;
		}
		return true;
	}


	public function check_mobile($mobile)
	{
		if ($this->UserManagement_model->is_mobile_exists($mobile)) {
			$this->form_validation->set_message('check_mobile', 'The {field} is already registered in the system.');
			return FALSE;
		} else {
			return TRUE;
		}
	}

	public function check_email($email)
	{
		if ($this->UserManagement_model->is_email_exists($email)) {
			$this->form_validation->set_message('check_email', 'The {field} is already registered in the system.');
			return FALSE;
		} else {
			return TRUE;
		}
	}

	public function check_password($password)
	{
		if (
			strlen($password) < 8 ||
			!preg_match('/[A-Z]/', $password) ||
			!preg_match('/[a-z]/', $password) ||
			!preg_match('/\d/', $password) ||
			!preg_match('/[\W_]/', $password)
		) {

			$this->form_validation->set_message('check_password', 'The {field} must be at least 8 characters long, contain at least one uppercase letter, one lowercase letter, one digit, and one special character (e.g., !@#$%^&()-_+=).');
			return FALSE;
		} else {
			return TRUE;
		}
	}


	public function edit($dprt_id = null)
	{
		$data['title'] = 'UPDATING USER RECORDS';
		#-------------------------------#
		$data['department'] = $this->UserManagement_model->read_by_id($dprt_id);
		$data['depip'] = $this->UserManagement_model->department_list('inpatient');
		$data['depop'] = $this->UserManagement_model->department_list('outpatient');
		$data['depin'] = $this->UserManagement_model->department_list('interim');
		$data['deppsr'] = $this->UserManagement_model->department_list('service');
		$data['depesr'] = $this->UserManagement_model->department_list('esr');
		$data['depempex'] = $this->UserManagement_model->department_list('employees');
		$data['depinci'] = $this->UserManagement_model->department_list('incident');
		$data['depadf'] = $this->UserManagement_model->department_list('adf');
		$data['depgrievance'] = $this->UserManagement_model->department_list('grievance');


		$data['content'] = $this->load->view('user_management/form_edit', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}

	public function role_edit($dprt_id = null)
	{
		$data['title'] = 'UPDATING ROLE RECORDS';
		#-------------------------------#
		$data['department'] = $this->UserManagement_model->role_edit($dprt_id);




		$data['content'] = $this->load->view('user_management/role_create', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}


	public function delete($dprt_id = null)
	{
		if ($this->UserManagement_model->delete($dprt_id)) {
			#set success message
			$this->session->set_flashdata('message', display('delete_successfully'));
		} else {
			#set exception message
			$this->session->set_flashdata('exception', display('please_try_again'));
		}
		redirect('UserManagement');
	}

	public function email($dprt_id = null)
	{
		if ($dprt_id === null) {
			show_error('Invalid Department ID');
			return;
		}

		$this->load->model('UserManagement_model');

		$result = $this->UserManagement_model->update_email_status($dprt_id);

		if ($result) {
			$this->session->set_flashdata('message', 'Email status successfully updated');
		} else {
			$this->session->set_flashdata('message', 'Failed to update email status');
		}

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_URL, base_url() . 'api/curl.php');
		curl_exec($curl);
		// Redirect or load a view
		redirect('UserManagement'); // Replace 'some_page' with your desired route
	}

	public function sms($dprt_id = null)
	{
		if ($dprt_id === null) {
			show_error('Invalid Department ID');
			return;
		}

		$this->load->model('UserManagement_model');

		$result = $this->UserManagement_model->update_sms_status($dprt_id);

		if ($result) {
			$this->session->set_flashdata('message', 'SMS status successfully updated');
		} else {
			$this->session->set_flashdata('message', 'Failed to update SMS status');
		}

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_URL, base_url() . 'api/curl.php');
		curl_exec($curl);
		// Redirect or load a view
		redirect('UserManagement'); // Replace 'some_page' with your desired route
	}

	public function whatsapp($dprt_id = null)
	{
		if ($dprt_id === null) {
			show_error('Invalid Department ID');
			return;
		}

		$this->load->model('UserManagement_model');

		$result = $this->UserManagement_model->update_whatsapp_status($dprt_id);

		if ($result) {
			$this->session->set_flashdata('message', 'Whatsapp status successfully updated');
		} else {
			$this->session->set_flashdata('message', 'Failed to update Whatsapp status');
		}

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_URL, base_url() . 'api/curl.php');
		curl_exec($curl);
		// Redirect or load a view
		redirect('UserManagement'); // Replace 'some_page' with your desired route
	}

	public function role_delete($dprt_id = null)
	{
		if ($this->UserManagement_model->role_delete($dprt_id)) {
			#set success message
			$this->session->set_flashdata('message', display('delete_successfully'));
		} else {
			#set exception message
			$this->session->set_flashdata('exception', display('please_try_again'));
		}
		redirect('UserManagement/roles');
	}


	public function roles()
	{

		$data['title'] = 'MANAGE ROLES';
		#-------------------------------#
		$data['role_list'] = $this->UserManagement_model->role_list();
		//print_r($data); exit;
		$data['content'] = $this->load->view('user_management/roles', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}

	public function role_permission()
	{
		if ($_POST) {
			//print_r($_POST); exit;
			$NewPermission = $_POST['feature'];

			$this->UserManagement_model->save_role_permission($NewPermission, $this->uri->segment(3));
		}
		$data['title'] = 'ROLE PERMISSION ';
		#-------------------------------#
		$data['groupedPermissions'] = $this->UserManagement_model->role_permission($this->uri->segment(3));
		$data['content'] = $this->load->view('user_management/role_permission', $data, true);
		$this->load->view('layout/main_wrapper', $data);
		// redirect('UserManagement/roles');
	}

	public function user_permission()
	{

		if ($_POST) {


			//  print_r($_POST); exit;
			$NewPermission = null;
			$floor_ward = null;
			$floor_ward_esr = null;
			$floor_asset = null;

			$department = null;
			if (isset($_POST['feature'])) {
				$NewPermission = $_POST['feature'];
			} elseif (isset($_POST['usermanagement'])) {
				$NewPermission = [];
			}
			if (isset($_POST['floor_ward'])) {
				$floor_ward = $_POST['floor_ward'];
			} elseif (isset($_POST['floor'])) {
				$floor_ward = [];
			}
			if (isset($_POST['floor_ward_esr'])) {
				$floor_ward_esr = $_POST['floor_ward_esr'];
			} elseif (isset($_POST['floor_esr'])) {
				$floor_ward_esr = [];
			}
			if (isset($_POST['department'])) {
				$department = $_POST['department'];
			} elseif (isset($_POST['departmentpermission'])) {
				$department = [];
			}

			if (isset($_POST['department'])) {
				$department = $_POST['department'];
				$floor_asset = $_POST['assetDepartment'];
			} elseif (isset($_POST['departmentpermission'])) {
				$department = [];
				$floor_asset = $_POST['assetDepartment'];
			}




			$this->UserManagement_model->save_user_permission($NewPermission, $floor_ward, $floor_ward_esr, $floor_asset, $department, $this->uri->segment(3));
		}
		$data['title'] = 'USER PERMISSION ';
		#-------------------------------#
		$data['groupedPermissions'] = $this->UserManagement_model->user_permission($this->uri->segment(3), $this->uri->segment(4));
		$data['departmentList'] = $this->UserManagement_model->departmentList();
		$data['content'] = $this->load->view('user_management/user_permission', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}


	public function role_create()
	{
		$data['title'] = 'ADDING ROLES';
		$this->form_validation->set_rules('role_name', display('department_name'), 'required|max_length[100]');

		$data['role'] = (object)$postData = [

			'role_id' 	  => $this->input->post('role_id', true),
			'role_name' 		  => $this->input->post('role_name', true),
			'description' 		  => $this->input->post('role_description', true),


		];
		if ($this->form_validation->run() === true) {
			if (empty($postData['role_id'])) {
				if ($this->UserManagement_model->role_create($postData)) {
					$this->session->set_flashdata('message', display('save_successfully'));
				} else {
					$this->session->set_flashdata('exception', display('please_try_again'));
				}
				redirect('UserManagement/roles');
			} else {
				// Update existing role
				if ($this->UserManagement_model->role_update($postData)) {
					$this->session->set_flashdata('message', display('update_successfully'));
				} else {
					$this->session->set_flashdata('exception', display('please_try_again'));
				}
				redirect('UserManagement/roles');
			}
		} else {
			// Form validation failed, load view with validation errors
			$data['content'] = $this->load->view('user_management/role_create', $data, true);
			$this->load->view('layout/main_wrapper', $data);
		}
	}
}
