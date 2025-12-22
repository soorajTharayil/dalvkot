<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Ticketsincident extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array(
			'ticketsincidents_model',
			'incident_model'
		));
		$dates = get_from_to_date();
		if (isset($_SESSION['from_date']) && isset($_SESSION['to_date'])) {

			$fdate = $_SESSION['from_date'];
			$tdate = $_SESSION['to_date'];
		} else {
			$fdate = date('Y-m-d', time());
			$tdate = date('Y-m-d', strtotime('-365 days'));
			$_SESSION['from_date'] = $fdate;
			$_SESSION['to_date'] = $tdate;
		}
		if (($this->session->userdata('isLogIn') === false)) {
			$this->session->set_userdata('referred_from', current_url());
		} else {
			$this->session->set_userdata('referred_from', NULL);
		}
	}



	public function index()
	{
		if ($this->session->userdata('isLogIn') == false)
			redirect('login');

		$data['title'] = 'INC- OPEN INCIDENTS LIST';
		#-------------------------------#
		$data['departments'] = $this->ticketsincidents_model->read();

		$data['content'] = $this->load->view('ticketsincident/ticket', $data, true);
		$this->load->view('layout/main_wrapper', $data);
		$this->session->set_userdata('referred_from', NULL);
	}

	public function alltickets()
	{

		if ($this->session->userdata('isLogIn') == false)
			redirect('login');

		$data['title'] = 'INC- ALL INCIDENTS LIST';
		#-------------------------------#
		$data['departments'] = $this->ticketsincidents_model->alltickets();
		$data['content'] = $this->load->view('ticketsincident/alltickets', $data, true);
		$this->load->view('layout/main_wrapper', $data);
		$this->session->set_userdata('referred_from', NULL);
	}

	public function addressedtickets()
	{
		if ($this->session->userdata('isLogIn') == false)
			redirect('login');

		$data['title'] = 'INC- ADDRESSED INCIDENTS LIST';
		#-------------------------------#
		$data['departments'] = $this->ticketsincidents_model->addressedtickets();

		$data['content'] = $this->load->view('ticketsincident/addressedtickets', $data, true);
		$this->load->view('layout/main_wrapper', $data);
		$this->session->set_userdata('referred_from', NULL);
	}


	public function ticket_track()
	{


		$data['title'] = 'INC- INCIDENTS DETAILS';
		$data['departments'] = $this->ticketsincidents_model->read_by_id($this->uri->segment(3));
		$data['content'] = $this->load->view('ticketsincident/track', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}

	public function ticket_close()
	{
		if ($this->session->userdata('isLogIn') == false)
			redirect('login');

		$data['title'] = 'INC- CLOSED INCIDENTS LIST';
		$data['departments'] = $this->ticketsincidents_model->read_close();
		$data['content'] = $this->load->view('ticketsincident/ticket_close', $data, true);

		$this->load->view('layout/main_wrapper', $data);
		$this->session->set_userdata('referred_from', NULL);
	}

	public function track_close()
	{
		if ($this->session->userdata('isLogIn') == false)
			redirect('login');

		$data['title'] = 'INC- CLOSED INCIDENTS DETAILS';
		$data['departments'] = $this->ticketsincidents_model->read_by_id($this->uri->segment(3));
		$data['content'] = $this->load->view('ticketsincident/track_close', $data, true);
		$this->load->view('layout/main_wrapper', $data);
		$this->session->set_userdata('referred_from', NULL);
	}




	public function create($dprt_id = null)
	{

		// print_r($_POST);
		// exit;
		if ($this->input->post('deparment') != 0) {
			$this->db->where('dprt_id', $this->input->post('deparment'));

			$query = $this->db->get('department');
			$department = $query->result();
			$action = 'Moved From  ' . $this->input->post('reply_departmen') . ' To ' . $department[0]->description;
			$action_meta = array(
				'action' => 'Transfered',
				'sourceDepartmentId' => $this->input->post('reply_department_id'),
				'targetDepartmentId' => $this->input->post('deparment')
			);

			$message = $this->session->userdata['fullname'];
			$updatedepartment = array('departmentid_trasfered' => $this->input->post('deparment'), 'emailstatus' => 0, 'status' => 'Transfered', 'transfer_ticket_alert' => '0');
			$this->db->where('id', $this->input->post('id'));
			// print_r($updatedepartment); exit;

			$this->db->update('tickets_incident', $updatedepartment);

			$dataset = array(
				'reply' => $this->input->post('reply'),
				'message' => $message,
				'action' => $action,
				'action_meta' => json_encode($action_meta),
				'ticketid' => $this->input->post('id'),
				'ticket_status' => 'Transfered',
				'created_by' => $this->session->userdata('user_id'),
			);

			$this->db->insert('ticket_incident_message', $dataset);
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_URL, base_url() . 'api/curl.php');
			curl_exec($curl);
			redirect('incident/opentickets');
		} else {
			// print_r($_POST);
			// exit;
			if ($this->input->post('status') == 'Closed') {



				$result = $this->db->select("*")
					->from('tickets_incident')
					->where('id', $this->input->post('id'))
					->get()
					->result();
				//print_r($result); exit;			
				$results = $this->db->select("*")
					->from('department')
					->where('dprt_id', $result[0]->departmentid)
					->get()
					->result();
				$resultss = $this->db->select("*")
					->from('department')
					->where('description', $results[0]->description)
					->get()
					->result();
				//print_r($resultss); exit;
				$action = 'Incident Closed by ' . $this->session->userdata['fullname'];
				$message = $this->session->userdata['fullname'];
				//foreach($resultss as $tickets){
				if ($this->input->post('status_patient_verified') && $this->input->post('status_patient_verified') == 'Verified') {
					$verified_by_patient = 1;
				} else {
					$verified_by_patient = 0;
				}
				$updatedepartmen = array(
					'status' => $this->input->post('status'),
					// 'closed_ticket_alert' => '0',
					'patient_verified_status' => $verified_by_patient // Added patient_verified_status
				);

				$this->db->where('id', $this->input->post('id'));
				//$this->db->where('created_by',$result[0]->created_by);
				$this->db->update('tickets_incident', $updatedepartmen);
				//}
				if (close_comment('inc_close_comment') === true) {
					$comment = $this->input->post('comment');
				} else {
					$comment = NULL;
				}

				// Load necessary libraries and helpers
				$this->load->library('upload');

				// Collect inputs with null fallback
				$reply = $this->input->post('reply') ?: NULL;
				$corrective = $this->input->post('corrective') ?: NULL;
				$preventive = $this->input->post('preventive') ?: NULL;
				$rootcause = $this->input->post('rootcause') ?: NULL;
				$fivewhy_1 = $this->input->post('fivewhy_1') ?: NULL;
				$fivewhy_2 = $this->input->post('fivewhy_2') ?: NULL;
				$fivewhy_3 = $this->input->post('fivewhy_3') ?: NULL;
				$fivewhy_4 = $this->input->post('fivewhy_4') ?: NULL;
				$fivewhy_5 = $this->input->post('fivewhy_5') ?: NULL;
				$fivewhy2h_1 = $this->input->post('fivewhy2h_1') ?: NULL;
				$fivewhy2h_2 = $this->input->post('fivewhy2h_2') ?: NULL;
				$fivewhy2h_3 = $this->input->post('fivewhy2h_3') ?: NULL;
				$fivewhy2h_4 = $this->input->post('fivewhy2h_4') ?: NULL;
				$fivewhy2h_5 = $this->input->post('fivewhy2h_5') ?: NULL;
				$fivewhy2h_6 = $this->input->post('fivewhy2h_6') ?: NULL;
				$fivewhy2h_7 = $this->input->post('fivewhy2h_7') ?: NULL;
				$rca_tool = $this->input->post('rca_method') ?: NULL;
				$verification_comment = $this->input->post('verification_comment') ?: NULL;
				$comment = $comment ?: NULL;
				$message = $message ?: NULL;
				$resolution_note = $this->input->post('resolution_note') ?: NULL;
				$action = $action ?: NULL;
				$created_by = $this->session->userdata('user_id');
				$ticketid = $this->input->post('id');

				// Build dataset
				$dataset = array(
					'reply' => $reply,
					'corrective' => $corrective,
					'preventive' => $preventive,
					'rootcause' => $rootcause,
					'fivewhy_1' => $fivewhy_1,
					'fivewhy_2' => $fivewhy_2,
					'fivewhy_3' => $fivewhy_3,
					'fivewhy_4' => $fivewhy_4,
					'fivewhy_5' => $fivewhy_5,
					'fivewhy2h_1' => $fivewhy2h_1,
					'fivewhy2h_2' => $fivewhy2h_2,
					'fivewhy2h_3' => $fivewhy2h_3,
					'fivewhy2h_4' => $fivewhy2h_4,
					'fivewhy2h_5' => $fivewhy2h_5,
					'fivewhy2h_6' => $fivewhy2h_6,
					'fivewhy2h_7' => $fivewhy2h_7,
					'rca_tool' => $rca_tool,
					'verification_comment' => $verification_comment,
					'comment' => $comment,
					'message' => $message,
					'resolution_note' => $resolution_note,
					'action' => $action,
					'ticket_status' => 'Closed',
					'created_by' => $created_by,
					'ticketid' => $ticketid,
				);

				// ======================
// MULTIPLE FILE UPLOAD (WORKS WITH MULTIPLE INPUT FIELDS)
// ======================
				if (!empty($_FILES['picture']['name'][0])) {

					$uploadedFiles = [];

					$config['upload_path'] = './assets/images/capaimage/';
					$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf|doc|docx|xls|xlsx|txt|csv|zip|rar|bmp|tiff|mp4|avi|mov|m4a|wav|wma';
					$config['max_size'] = 10240; // 10MB limit

					// Loop through each uploaded file
					foreach ($_FILES['picture']['name'] as $key => $name) {
						if (!empty($name)) {
							$_FILES['file']['name'] = $_FILES['picture']['name'][$key];
							$_FILES['file']['type'] = $_FILES['picture']['type'][$key];
							$_FILES['file']['tmp_name'] = $_FILES['picture']['tmp_name'][$key];
							$_FILES['file']['error'] = $_FILES['picture']['error'][$key];
							$_FILES['file']['size'] = $_FILES['picture']['size'][$key];

							// Rename to avoid spaces and duplicate conflicts
							$cleanName = preg_replace('/\s+/', '_', pathinfo($_FILES['file']['name'], PATHINFO_FILENAME));
							$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
							$config['file_name'] = time() . '_' . $cleanName . '.' . $ext;

							$this->upload->initialize($config);

							if ($this->upload->do_upload('file')) {
								$uploadData = $this->upload->data();
								$uploadedFiles[] = $uploadData['file_name'];
							}
						}
					}

					// Store uploaded filenames as a JSON array like ["1.jpg","2.pdf"]
					if (!empty($uploadedFiles)) {
						$dataset['picture'] = json_encode(array_values($uploadedFiles), JSON_UNESCAPED_SLASHES);
					}
				}

				// Insert into DB
				$this->db->insert('ticket_incident_message', $dataset);


				if ($this->input->post('status_patient_verified') && $this->input->post('status_patient_verified') == 'Verified') {
					redirect('track/inc/' . $this->input->post('id'));
				} else {
					redirect('incident/alltickets');
				}

				$this->session->set_flashdata('message', '<span style="color: green;">Ticket is closed</span>');
			}

			if ($this->input->post('status') == 'ClosedSave') {

				$action = 'Incident RCA Submitted by ' . $this->session->userdata['fullname'];
				$message = $this->session->userdata['fullname'];
				$rootcause = $this->input->post('rootcause') ?: NULL;
				// Load necessary libraries and helpers
				$this->load->library('upload');

				//print_r($picture); exit;
				$dataset = array(

					'fivewhy_1' => $this->input->post('fivewhy_1'),
					'fivewhy_2' => $this->input->post('fivewhy_2'),
					'fivewhy_3' => $this->input->post('fivewhy_3'),
					'fivewhy_4' => $this->input->post('fivewhy_4'),
					'fivewhy_5' => $this->input->post('fivewhy_5'),
					'fivewhy2h_1' => $this->input->post('fivewhy2h_1'),
					'fivewhy2h_2' => $this->input->post('fivewhy2h_2'),
					'fivewhy2h_3' => $this->input->post('fivewhy2h_3'),
					'fivewhy2h_4' => $this->input->post('fivewhy2h_4'),
					'fivewhy2h_5' => $this->input->post('fivewhy2h_5'),
					'fivewhy2h_6' => $this->input->post('fivewhy2h_6'),
					'fivewhy2h_7' => $this->input->post('fivewhy2h_7'),
					'rca_tool' => $this->input->post('rca_method'),
					'ticket_status' => 'Submitted RCA',
					'rootcause' => $rootcause,
					'message' => $message,
					'action' => $action,

					'created_by' => $this->session->userdata('user_id'),
					'ticketid' => $this->input->post('id'),
				);




				$this->db->insert('ticket_incident_message', $dataset);


				// redirect('incident/closedtickets');
				$this->session->set_flashdata('message', '<span style="color: green;">RCA Saved</span>');
			} elseif ($this->input->post('status') == 'Reopen') {

				if ($this->input->post('status_patient') && $this->input->post('status_patient') == 'Patient') {

					$action = 'Reopened by the user (' . $this->input->post('patient_reopen_name') . ')';
					$message = $this->input->post('patient_reopen_name');
				} else {
					$action = 'Reopened by ' . $this->session->userdata['fullname'];
					$message = $this->session->userdata['fullname'];
				}


				$updatedepartmen = array('status' => $this->input->post('status'), 'addressed' => 0, 'reopen_ticket_alert' => '0');
				$this->db->where('id', $this->input->post('id'));
				$this->db->update('tickets_incident', $updatedepartmen);

				$dataset = array(
					'reply' => $this->input->post('reply'),
					'message' => $message,
					'action' => $action,
					'ticket_status' => 'Reopen',
					'created_by' => $this->session->userdata('user_id'),
					'ticketid' => $this->input->post('id')
				);

				$this->db->insert('ticket_incident_message', $dataset);
				$curl = curl_init();
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($curl, CURLOPT_URL, base_url() . 'api/curl.php');
				curl_exec($curl);
				if ($this->input->post('status_patient') && $this->input->post('status_patient') == 'Patient') {

					redirect('track/inc/' . $this->input->post('id'));
				} else {
					redirect('incident/opentickets');
				}
			} elseif ($this->input->post('status') == 'Verified') {

				$action = 'Incident Verified by ' . $this->session->userdata['fullname'];
				$message = $this->session->userdata['fullname'];
				$updatedepartmen = array('status' => 'Closed', 'verified_status' => 1);
				$this->db->where('id', $this->input->post('id'));
				$this->db->update('tickets_incident', $updatedepartmen);

				$dataset = array(
					'reply' => $this->input->post('reply'),
					'message' => $message,
					'action' => $action,
					'ticket_status' => 'Verified',
					'created_by' => $this->session->userdata('user_id'),
					'ticketid' => $this->input->post('id')
				);

				$this->db->insert('ticket_incident_message', $dataset);
				// $curl = curl_init();
				// curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
				// curl_setopt($curl, CURLOPT_URL, base_url() . 'api/curl.php');
				// curl_exec($curl);
				redirect('incident/alltickets');
			} elseif ($this->input->post('status') == 'Monitor') {
				// print_r($_POST);
				// exit;
				$action = 'Commented by ' . $this->session->userdata['fullname'];
				$message = $this->session->userdata['fullname'];


				$dataset = array(
					'process_monitor_note' => $this->input->post('process_monitor_note'),
					'message' => $message,
					'action' => $action,
					'ticket_status' => 'Comment from Process Monitor',
					'created_by' => $this->session->userdata('user_id'),
					'ticketid' => $this->input->post('id')
				);

				$this->db->insert('ticket_incident_message', $dataset);
				// $curl = curl_init();
				// curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
				// curl_setopt($curl, CURLOPT_URL, base_url() . 'api/curl.php');
				// curl_exec($curl);
				redirect('incident/alltickets');
			} elseif ($this->input->post('status') == 'Assigned') {
				// print_r($_POST); exit;

				// Get selected users
				$assigned_user_ids = $this->input->post('users'); // Team Leaders
				$assigned_user_ids_for_team_member = $this->input->post('users_for_team_member'); // ðŸ†• Team Members
				$assigned_user_ids_for_process_monitor = $this->input->post('users_for_process_monitor'); // Process Monitors

				// Validation: all three must be selected
				// if (empty($assigned_user_ids) || empty($assigned_user_ids_for_team_member) || empty($assigned_user_ids_for_process_monitor)) {
				// 	echo "<script>alert('Please select Team Leader(s), Team Member(s), and Process Monitor(s) before assigning.');window.history.back();</script>";
				// 	exit;
				// }

				// âœ… Validate only Team Leader(s)
				if (empty($assigned_user_ids)) {
					echo "<script>
                         alert('Please select Team Leader(s) before assigning.');
                         window.history.back();
                    </script>";
					exit;
				}

				//Ensure arrays are defined even if nothing selected
				$assigned_user_ids_for_team_member = !empty($assigned_user_ids_for_team_member) ? $assigned_user_ids_for_team_member : [];
				$assigned_user_ids_for_process_monitor = !empty($assigned_user_ids_for_process_monitor) ? $assigned_user_ids_for_process_monitor : [];

				//Convert arrays to comma-separated strings (safe even if empty)
				$assigned_user_ids_str = implode(',', $assigned_user_ids);
				$assigned_user_ids_str_for_team_member = implode(',', $assigned_user_ids_for_team_member);
				$assigned_user_ids_str_for_process_monitor = implode(',', $assigned_user_ids_for_process_monitor);

				//Fetch Team Leader details
				$this->db->select('firstname, designation');
				$this->db->from('user');
				$this->db->where_in('user_id', $assigned_user_ids);
				$query = $this->db->get();
				$assigned_users = $query->result_array();

				$assigned_user_names = array_map(function ($user) {
					return $user['firstname'] . ' (' . $user['designation'] . ')';
				}, $assigned_users);
				$assigned_user_names_str = implode(', ', $assigned_user_names);

				//Fetch Team Member details (only if selected)
				$assigned_user_names_for_team_member = [];
				if (!empty($assigned_user_ids_for_team_member)) {
					$this->db->select('firstname, designation');
					$this->db->from('user');
					$this->db->where_in('user_id', $assigned_user_ids_for_team_member);
					$query = $this->db->get();
					$assigned_users_for_team_member = $query->result_array();

					$assigned_user_names_for_team_member = array_map(function ($user) {
						return $user['firstname'] . ' (' . $user['designation'] . ')';
					}, $assigned_users_for_team_member);
				}
				$assigned_user_names_str_for_team_member = implode(', ', $assigned_user_names_for_team_member);

				//Fetch Process Monitor details (only if selected)
				$assigned_user_names_for_process_monitor = [];
				if (!empty($assigned_user_ids_for_process_monitor)) {
					$this->db->select('firstname, designation');
					$this->db->from('user');
					$this->db->where_in('user_id', $assigned_user_ids_for_process_monitor);
					$query = $this->db->get();
					$assigned_users_for_process_monitor = $query->result_array();

					$assigned_user_names_for_process_monitor = array_map(function ($user) {
						return $user['firstname'] . ' (' . $user['designation'] . ')';
					}, $assigned_users_for_process_monitor);
				}
				$assigned_user_names_str_for_process_monitor = implode(', ', $assigned_user_names_for_process_monitor);


				$assigned_user_names_for_process_monitor = array_map(function ($user) {
					return $user['firstname'] . ' (' . $user['designation'] . ')';
				}, $assigned_users_for_process_monitor);
				$assigned_user_names_str_for_process_monitor = implode(', ', $assigned_user_names_for_process_monitor);

				$action = 'Incident Assigned to Team Leader(s): ' . $assigned_user_names_str;
				$message = $this->session->userdata('fullname');
				$action_for_process_monitor = $assigned_user_names_str_for_process_monitor;

				// Update tickets
				$updatedepartment = array(
					'status' => 'Assigned',
					'assign_by' => $this->session->userdata('user_id'),
					'assigned_message' => 0,
					'assign_tat_due_date' => $this->input->post('assign_due_date'),
					'describe_message' => -1,
					'assign_tat_due_date_status' => 0,
					'assigned_email' => 0,
					'assign_to' => $assigned_user_ids_str,
					'assign_for_team_member' => $assigned_user_ids_str_for_team_member, // ðŸ†•
					'assign_for_process_monitor' => $assigned_user_ids_str_for_process_monitor
				);
				$this->db->where('id', $this->input->post('id'));
				$this->db->update('tickets_incident', $updatedepartment);

				$updatedepartment_feedback = array(
					'whatsapp_assign_status' => 0
				);
				$this->db->where('id', $this->input->post('feedbackid'));
				$this->db->update('bf_feedback_incident', $updatedepartment_feedback);

				// Insert message
				$dataset = array(
					'reply' => $this->input->post('reply'),
					'message' => $message,
					'action' => $action,
					'assign_tat_due_date' => $this->input->post('assign_due_date'),
					'action_for_team_member' => $assigned_user_names_str_for_team_member, // ðŸ†•
					'action_for_process_monitor' => $action_for_process_monitor,
					'ticket_status' => 'Assigned',
					'created_by' => $this->session->userdata('user_id'),
					'ticketid' => $this->input->post('id')
				);
				$this->db->insert('ticket_incident_message', $dataset);

				// Call API
				$curl = curl_init();
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($curl, CURLOPT_URL, base_url() . 'api/curl.php');
				curl_exec($curl);

				redirect('incident/opentickets');
			} elseif ($this->input->post('status') == 'Re-assigned') {
				// Get selected users
				// print_r($_POST); exit;
				$assigned_user_ids = $this->input->post('users_reassign'); // Team Leaders
				$assigned_user_ids_for_team_member = $this->input->post('users_reassign_for_team_member'); // ðŸ†• Team Members
				$assigned_user_ids_for_process_monitor = $this->input->post('users_reassign_for_process_monitor'); // Process Monitors

				if (!empty($assigned_user_ids)) {

					// Prepare comma-separated IDs
					$assigned_user_ids_str = implode(',', $assigned_user_ids);
					$assigned_user_ids_str_for_team_member = implode(',', $assigned_user_ids_for_team_member);
					$assigned_user_ids_str_for_process_monitor = implode(',', $assigned_user_ids_for_process_monitor);
					print_r($assigned_user_ids_str_for_team_member);
					// Fetch team leader details
					$this->db->select('firstname, designation');
					$this->db->from('user');
					$this->db->where_in('user_id', $assigned_user_ids);
					$query = $this->db->get();
					$assigned_users = $query->result_array();

					$assigned_user_names = array_map(function ($user) {
						return $user['firstname'] . ' (' . $user['designation'] . ')';
					}, $assigned_users);
					$assigned_user_names_str = implode(', ', $assigned_user_names);

					// Fetch team member details
					$this->db->select('firstname, designation');
					$this->db->from('user');
					$this->db->where_in('user_id', $assigned_user_ids_for_team_member);
					$query = $this->db->get();
					$assigned_users_for_team_member = $query->result_array();

					$assigned_user_names_for_team_member = array_map(function ($user) {
						return $user['firstname'] . ' (' . $user['designation'] . ')';
					}, $assigned_users_for_team_member);
					$assigned_user_names_str_for_team_member = implode(', ', $assigned_user_names_for_team_member);

					// Fetch process monitor details
					$this->db->select('firstname, designation');
					$this->db->from('user');
					$this->db->where_in('user_id', $assigned_user_ids_for_process_monitor);
					$query = $this->db->get();
					$assigned_users_for_process_monitor = $query->result_array();

					$assigned_user_names_for_process_monitor = array_map(function ($user) {
						return $user['firstname'] . ' (' . $user['designation'] . ')';
					}, $assigned_users_for_process_monitor);
					$assigned_user_names_str_for_process_monitor = implode(', ', $assigned_user_names_for_process_monitor);

					$action = 'Incident Re-assigned to Team Leader(s): ' . $assigned_user_names_str;
					$message = $this->session->userdata('fullname');
					$action_for_process_monitor = $assigned_user_names_str_for_process_monitor;

					// Update tickets
					$updatedepartment = array(
						'status' => 'Re-assigned',
						'reassign_by' => $this->session->userdata('user_id'),
						'reassigned_message' => 0,
						'describe_message' => -1,
						'assign_tat_due_date_status' => 0,
						'assign_tat_due_date' => $this->input->post('reassign_due_date'),
						'reassigned_email' => 0,
						'assign_to' => implode(',', $assigned_user_ids),
						'reassign_to' => implode(',', $assigned_user_ids),
						'reassign_for_team_member' => implode(',', $assigned_user_ids_for_team_member),
						'reassign_for_process_monitor' => implode(',', $assigned_user_ids_for_process_monitor)
					);

					$this->db->where('id', $this->input->post('id'));
					$this->db->update('tickets_incident', $updatedepartment);

					$updatedepartment_feedback = array(
						'whatsapp_reassign_status' => 0
					);
					$this->db->where('id', $this->input->post('feedbackid'));
					$this->db->update('bf_feedback_incident', $updatedepartment_feedback);

					// Insert message
					$dataset = array(
						'reply' => $this->input->post('reply'),
						'message' => $message,
						'action' => $action,
						'assign_tat_due_date' => $this->input->post('reassign_due_date'),
						'reassign_action_for_team_member' => $assigned_user_names_str_for_team_member, // ðŸ†•
						'reassign_action_for_process_monitor' => $action_for_process_monitor,
						'ticket_status' => 'Re-assigned',
						'created_by' => $this->session->userdata('user_id'),
						'ticketid' => $this->input->post('id')
					);
					$this->db->insert('ticket_incident_message', $dataset);
				}

				// Call API
				$curl = curl_init();
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($curl, CURLOPT_URL, base_url() . 'api/curl.php');
				curl_exec($curl);

				redirect('incident/opentickets');
			} elseif ($this->input->post('status') == 'Described') {
				// print_r($_POST);
				// exit;
				// Update the ticket incident status to "Described"
				$updatedepartment = array(
					'status' => 'Described',
					'describe_message' => 0,
					'describe_email' => 0,
					'describe_by' => $this->session->userdata('user_id')
				);

				$this->db->where('id', $this->input->post('id'));
				$this->db->update('tickets_incident', $updatedepartment);

				$action = 'Incident Explained by ' . $this->session->userdata['fullname'] . ' (' . $this->session->userdata['designation'] . ')';

				$message = $this->session->userdata['fullname'];

				$updatedepartment_feedback = array(
					'whatsapp_describe_status' => 0
				);

				$this->db->where('id', $this->input->post('feedbackid'));
				$this->db->update('bf_feedback_incident', $updatedepartment_feedback);

				$rootcause_value = '';

				if ($this->input->post('rootcause_describe_brief')) {
					$rootcause_value = $this->input->post('rootcause_describe_brief');
				} else {
					$rootcause_value = $this->input->post('rootcause_describe');
				}
				$dataset = array(
					'reply' => $this->input->post('reply'),
					'message' => $message,

					'action' => $action,
					'ticket_status' => 'Described',
					'fivewhy_1_describe' => $this->input->post('fivewhy_1_describe'),
					'fivewhy_2_describe' => $this->input->post('fivewhy_2_describe'),
					'fivewhy_3_describe' => $this->input->post('fivewhy_3_describe'),
					'fivewhy_4_describe' => $this->input->post('fivewhy_4_describe'),
					'fivewhy_5_describe' => $this->input->post('fivewhy_5_describe'),
					'fivewhy2h_1_describe' => $this->input->post('fivewhy2h_1_describe'),
					'fivewhy2h_2_describe' => $this->input->post('fivewhy2h_2_describe'),
					'fivewhy2h_3_describe' => $this->input->post('fivewhy2h_3_describe'),
					'fivewhy2h_4_describe' => $this->input->post('fivewhy2h_4_describe'),
					'fivewhy2h_5_describe' => $this->input->post('fivewhy2h_5_describe'),
					'fivewhy2h_6_describe' => $this->input->post('fivewhy2h_6_describe'),
					'fivewhy2h_7_describe' => $this->input->post('fivewhy2h_7_describe'),
					'rca_tool_describe' => $this->input->post('rca_method_describe'),
					'corrective_describe' => $this->input->post('corrective_describe'),
					'preventive_describe' => $this->input->post('preventive_describe'),
					'rootcause_describe' => $this->input->post('rootcause_describe'),
					'rootcause_describe_brief' => $this->input->post('rootcause_describe_brief'),
					'verification_comment_describe' => $this->input->post('verification_comment_describe'),
					'created_by' => $this->session->userdata('user_id'),
					'ticketid' => $this->input->post('id')
				);

				// ======================
// MULTIPLE FILE UPLOAD for describe_picture[]
// ======================

				// Load upload library
				$this->load->library('upload');

				if (!empty($_FILES['describe_picture']['name'][0])) {

					$uploadedFiles = [];

					// Common upload config
					$config['upload_path'] = FCPATH . 'assets/images/describeimage/';
					$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf|doc|docx|xls|xlsx|txt|csv|zip|rar|bmp|tiff|mp4|avi|mov|m4a|wav|wma';
					$config['max_size'] = 10240; // 10 MB limit

					foreach ($_FILES['describe_picture']['name'] as $key => $name) {

						if (!empty($name)) {

							// Prepare each file for upload
							$_FILES['file']['name'] = $_FILES['describe_picture']['name'][$key];
							$_FILES['file']['type'] = $_FILES['describe_picture']['type'][$key];
							$_FILES['file']['tmp_name'] = $_FILES['describe_picture']['tmp_name'][$key];
							$_FILES['file']['error'] = $_FILES['describe_picture']['error'][$key];
							$_FILES['file']['size'] = $_FILES['describe_picture']['size'][$key];

							// Clean file name and make it unique
							$cleanName = preg_replace('/\s+/', '_', pathinfo($_FILES['file']['name'], PATHINFO_FILENAME));
							$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
							$config['file_name'] = time() . '_' . $cleanName . '.' . $ext;

							// Initialize upload for each file
							$this->upload->initialize($config);

							// Upload the file
							if ($this->upload->do_upload('file')) {
								$uploadData = $this->upload->data();
								$uploadedFiles[] = $uploadData['file_name'];
							}
						}
					}

					// Store all uploaded filenames as JSON
					if (!empty($uploadedFiles)) {
						$dataset['describe_picture'] = json_encode($uploadedFiles, JSON_UNESCAPED_SLASHES);
					}
				}

				// Insert dataset into the 'ticket_incident_message' table
				$this->db->insert('ticket_incident_message', $dataset);

				$curl = curl_init();
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($curl, CURLOPT_URL, base_url() . 'api/curl.php');
				curl_exec($curl);
				// Redirect to opentickets after describing the incident
				redirect('incident/track/' . $this->input->post('id'));
			} elseif ($this->input->post('status') == 'Addressed') {

				$action = 'Incident Addressed by ' . $this->session->userdata['fullname'];
				$message = $this->session->userdata['fullname'];
				$updatedepartmen = array('addressed' => 1, 'status' => 'Addressed');
				$this->db->where('id', $this->input->post('id'));
				$this->db->update('tickets_incident', $updatedepartmen);

				$dataset = array(
					'reply' => $this->input->post('reply'),
					'message' => $message,
					'action' => $action,
					'ticket_status' => 'Addressed',
					'created_by' => $this->session->userdata('user_id'),
					'ticketid' => $this->input->post('id')
				);

				$this->db->insert('ticket_incident_message', $dataset);
				redirect('incident/addressedtickets');
			} elseif ($this->input->post('status') == 'Rejected') {

				$action = 'Incident Rejected by ' . $this->session->userdata['fullname'];
				$message = $this->session->userdata['fullname'];
				$updatedepartmen = array('status' => 'Rejected');
				$this->db->where('id', $this->input->post('id'));
				$this->db->update('tickets_incident', $updatedepartmen);

				$dataset = array(
					'reply' => $this->input->post('reply'),
					'message' => $message,
					'action' => $action,
					'ticket_status' => 'Rejected',
					'created_by' => $this->session->userdata('user_id'),
					'ticketid' => $this->input->post('id')
				);

				$this->db->insert('ticket_incident_message', $dataset);
				redirect('incident/rejecttickets');
			} elseif ($this->input->post('status') == 'Delete') {

				$action = 'Incident Deleted by ' . $this->session->userdata['fullname'];
				$message = $this->session->userdata['fullname'];
				$updatedepartmen = array('status' => 'Deleted');
				$this->db->where('id', $this->input->post('id'));
				$this->db->update('tickets_incident', $updatedepartmen);

				// $dataset = array(
				// 	'reply' => $this->input->post('reply'),
				// 	'message' => $message,
				// 	'action' => $action,
				// 	'ticket_status' => 'Deleted',
				// 	'created_by' => $this->session->userdata('user_id'),
				// 	'ticketid' => $this->input->post('id')
				// );

				// $this->db->insert('ticket_incident_message', $dataset);
				redirect('incident/alltickets');
			} else {
				$action = 'Comment';
				$message = $this->session->userdata['fullname'];
				$dataset = array(
					'reply' => $this->input->post('reply'),
					'message' => $message,
					'action' => $action,
					'created_by' => $this->session->userdata('user_id'),
					'ticketid' => $this->input->post('id')
				);

				$this->db->insert('ticket_incident_message', $dataset);
			}
		}
		redirect('incident/track/' . $this->input->post('id'));
	}

	public function edit_priority_serverity($dprt_id = null)
	{
		//  print_r($_POST);
		// exit;
		if ($this->input->post('status') == 'EditSeverity') {

			$updatedepartment_inc = array('incident_type' => $this->input->post('incident_type'));
			$this->db->where('feedbackid', $this->input->post('id'));
			$this->db->update('tickets_incident', $updatedepartment_inc);

			// Fetch the existing dataset from the database
			$this->db->select('dataset');
			$this->db->where('pid', $this->input->post('id'));
			$query = $this->db->get('bf_feedback_incident');
			$row = $query->row();

			if ($row) {
				$existingDataset = json_decode($row->dataset, true); // Decode the existing JSON data

				if (is_array($existingDataset)) {
					// Update only the incident_type field
					$existingDataset['incident_type'] = $this->input->post('incident_type');

					// Encode back to JSON
					$updatedDataset = json_encode($existingDataset);

					// Update the database
					$updatedepartment = array('dataset' => $updatedDataset);
					$this->db->where('pid', $this->input->post('id'));
					$this->db->update('bf_feedback_incident', $updatedepartment);

					if ($this->db->affected_rows() > 0) {
						$empid = $this->input->post('pid'); // Assuming 'id' contains the employee ID
						redirect('incident/employee_complaint?empid=' . urlencode($empid));
					} else {
						echo "No changes made.";
					}
				} else {
					echo "Invalid dataset format.";
				}
			} else {
				echo "Record not found.";
			}
		}
	}

	public function edit_priority_type($dprt_id = null)
	{
		//  print_r($_POST);
		//  exit;
		if ($this->input->post('status') == 'EditPriority') {

			$updatedepartment_inc = array('priority' => $this->input->post('priority'));
			$this->db->where('feedbackid', $this->input->post('id'));
			$this->db->update('tickets_incident', $updatedepartment_inc);

			// Fetch the existing dataset from the database
			$this->db->select('dataset');
			$this->db->where('pid', $this->input->post('id'));
			$query = $this->db->get('bf_feedback_incident');
			$row = $query->row();

			if ($row) {
				$existingDataset = json_decode($row->dataset, true); // Decode the existing JSON data

				if (is_array($existingDataset)) {
					// Update only the incident_type field
					$existingDataset['priority'] = $this->input->post('priority');

					// Encode back to JSON
					$updatedDataset = json_encode($existingDataset);

					// Update the database
					$updatedepartment = array('dataset' => $updatedDataset);
					$this->db->where('pid', $this->input->post('id'));
					$this->db->update('bf_feedback_incident', $updatedepartment);

					if ($this->db->affected_rows() > 0) {
						$empid = $this->input->post('pid'); // Assuming 'id' contains the employee ID
						redirect('incident/employee_complaint?empid=' . urlencode($empid));
					} else {
						echo "No changes made.";
					}
				} else {
					echo "Invalid dataset format.";
				}
			} else {
				echo "Record not found.";
			}
		}
	}
	public function update_risk_matrix($dprt_id = null)
	{
		// print_r($_POST);
		// exit;
		if ($this->input->post('status') == 'EditAssignedRisk') {

			$updatedepartment_inc = array('assigned_risk' => $this->input->post('level'));
			$this->db->where('feedbackid', $this->input->post('id'));
			$this->db->update('tickets_incident', $updatedepartment_inc);

			// Fetch the existing dataset from the database
			$this->db->select('dataset');
			$this->db->where('pid', $this->input->post('id'));
			$query = $this->db->get('bf_feedback_incident');
			$row = $query->row();

			if ($row) {
				$existingDataset = json_decode($row->dataset, true); // Decode JSON

				if (is_array($existingDataset)) {
					// Add/Update risk_matrix
					$existingDataset['risk_matrix'] = array(
						'impact' => $this->input->post('impact'),
						'likelihood' => $this->input->post('likelihood'),
						'level' => $this->input->post('level')
					);

					// Add/Update datetime (use timestamp)
					$existingDataset['datetime'] = round(microtime(true) * 1000); // JS-style ms timestamp



					// Encode back to JSON
					$updatedDataset = json_encode($existingDataset);

					// Update the database
					$updatedepartment = array('dataset' => $updatedDataset);
					$this->db->where('pid', $this->input->post('id'));
					$this->db->update('bf_feedback_incident', $updatedepartment);

					if ($this->db->affected_rows() > 0) {
						$empid = $this->input->post('pid');
						redirect('incident/employee_complaint?empid=' . urlencode($empid));
					} else {
						echo "No changes made.";
					}
				} else {
					echo "Invalid dataset format.";
				}
			} else {
				echo "Record not found.";
			}
		}
	}

// 	public function update_described_rca()
// 	{

// 		if (ob_get_length())
// 			@ob_end_clean();
// 		header('Content-Type: application/json; charset=utf-8');
// 		header('Cache-Control: no-store, no-cache, must-revalidate');
// 		header('Pragma: no-cache');

// 		$id = $this->input->post('id');
// 		if (empty($id)) {
// 			echo json_encode(['status' => 'error', 'message' => 'Missing ID']);
// 			return;
// 		}

// 		$this->load->model('ticketsincidents_model');
// 		$this->load->library('upload');

// 		// === Map Form Fields ===
// 		$updateData = [
// 			'rootcause_describe_brief' => $this->input->post('rca_in_brief'),
// 			'rootcause_describe' => $this->input->post('rca'),
// 			'rca_tool_describe' => $this->input->post('tool_applied'),
// 			'fivewhy_1_describe' => $this->input->post('why_1'),
// 			'fivewhy_2_describe' => $this->input->post('why_2'),
// 			'fivewhy_3_describe' => $this->input->post('why_3'),
// 			'fivewhy_4_describe' => $this->input->post('why_4'),
// 			'fivewhy_5_describe' => $this->input->post('why_5'),
// 			'fivewhy2h_1_describe' => $this->input->post('what_happened'),
// 			'fivewhy2h_2_describe' => $this->input->post('why_did_it_happen'),
// 			'fivewhy2h_3_describe' => $this->input->post('where_did_it_happen'),
// 			'fivewhy2h_4_describe' => $this->input->post('when_did_it_happen'),
// 			'fivewhy2h_5_describe' => $this->input->post('who_was_involved'),
// 			'fivewhy2h_6_describe' => $this->input->post('how_did_it_happen'),
// 			'fivewhy2h_7_describe' => $this->input->post('how_much_how_many_impact_cost'),
// 			'corrective_describe' => $this->input->post('corrective_action'),
// 			'preventive_describe' => $this->input->post('preventive_action'),
// 			'verification_comment_describe' => $this->input->post('lesson_learned')
// 		];

// 		foreach ($updateData as $k => $v) {
// 			$updateData[$k] = (isset($v) && trim($v) !== '') ? trim($v) : null;
// 		}

// 		// === File Upload ===
// 		$uploadPath = FCPATH . 'assets/images/describeimage/';
// 		$config = [
// 			'upload_path' => $uploadPath,
// 			'allowed_types' => 'jpg|jpeg|png|gif|pdf|doc|docx|xls|xlsx|txt|csv|zip|rar|bmp|tiff|mp4|avi|mov|m4a|wav|wma',
// 			'max_size' => 10240
// 		];
// 		$this->upload->initialize($config);

// 		// Fetch existing files
// 		$record = $this->db->get_where('ticket_incident_message', ['id' => $id])->row();
// 		$existingFiles = [];
// 		if (!empty($record->describe_picture)) {
// 			$existingFiles = explode(',', $record->describe_picture);
// 		}

// 		// Handle removed files
// 		$removedFiles = $this->input->post('remove_files');
// 		if (is_array($removedFiles)) {
// 			foreach ($removedFiles as $f) {
// 				$f = trim($f);
// 				$filePath = $uploadPath . $f;
// 				if (file_exists($filePath))
// 					@unlink($filePath);
// 				$existingFiles = array_diff($existingFiles, [$f]);
// 			}
// 		}

// 		// Handle new uploads
// 		$newFiles = [];
// 		if (!empty($_FILES['describe_picture']['name'][0])) {
// 			$fileCount = count($_FILES['describe_picture']['name']);
// 			for ($i = 0; $i < $fileCount; $i++) {
// 				$_FILES['file']['name'] = time() . '_' . $_FILES['describe_picture']['name'][$i];
// 				$_FILES['file']['type'] = $_FILES['describe_picture']['type'][$i];
// 				$_FILES['file']['tmp_name'] = $_FILES['describe_picture']['tmp_name'][$i];
// 				$_FILES['file']['error'] = $_FILES['describe_picture']['error'][$i];
// 				$_FILES['file']['size'] = $_FILES['describe_picture']['size'][$i];

// 				$this->upload->initialize($config);
// 				if ($this->upload->do_upload('file')) {
// 					$data = $this->upload->data();
// 					$newFiles[] = $data['file_name'];
// 				} else {
// 					log_message('error', 'Upload Error: ' . $this->upload->display_errors('', ''));
// 				}
// 			}
// 		}

// 		// Combine remaining + new
// 		$allFiles = array_merge($existingFiles, $newFiles);
// 		$updateData['describe_picture'] = !empty($allFiles) ? implode(',', $allFiles) : null;

// 		// === Save to DB ===
// 		$ok = $this->ticketsincidents_model->update_rca_details($id, $updateData);

// 		echo json_encode([
// 			'status' => $ok ? 'success' : 'error',
// 			'message' => $ok ? 'RCA updated successfully' : 'Database update failed'
// 		]);
// 	}

    public function update_described_rca()
    {
    	if (ob_get_length()) @ob_end_clean();
    	header('Content-Type: application/json; charset=utf-8');
    	header('Cache-Control: no-store, no-cache, must-revalidate');
    	header('Pragma: no-cache');
    
    	$id = $this->input->post('id');
    	if (empty($id)) {
    		echo json_encode(['status' => 'error', 'message' => 'Missing ID']);
    		return;
    	}
    
    	$this->load->model('ticketsincidents_model');
    	$this->load->library('upload');
    
    	// ========================
    	// ✅ FORM DATA MAP
    	// ========================
    	$updateData = [
    		'rootcause_describe_brief'       => $this->input->post('rca_in_brief'),
    		'rootcause_describe'             => $this->input->post('rca'),
    		'rca_tool_describe'              => $this->input->post('tool_applied'),
    		'fivewhy_1_describe'             => $this->input->post('why_1'),
    		'fivewhy_2_describe'             => $this->input->post('why_2'),
    		'fivewhy_3_describe'             => $this->input->post('why_3'),
    		'fivewhy_4_describe'             => $this->input->post('why_4'),
    		'fivewhy_5_describe'             => $this->input->post('why_5'),
    		'fivewhy2h_1_describe'           => $this->input->post('what_happened'),
    		'fivewhy2h_2_describe'           => $this->input->post('why_did_it_happen'),
    		'fivewhy2h_3_describe'           => $this->input->post('where_did_it_happen'),
    		'fivewhy2h_4_describe'           => $this->input->post('when_did_it_happen'),
    		'fivewhy2h_5_describe'           => $this->input->post('who_was_involved'),
    		'fivewhy2h_6_describe'           => $this->input->post('how_did_it_happen'),
    		'fivewhy2h_7_describe'           => $this->input->post('how_much_how_many_impact_cost'),
    		'corrective_describe'            => $this->input->post('corrective_action'),
    		'preventive_describe'            => $this->input->post('preventive_action'),
    		'verification_comment_describe' => $this->input->post('lesson_learned')
    	];
    
    	// Clean empty values
    	foreach ($updateData as $k => $v) {
    		$updateData[$k] = (isset($v) && trim($v) !== '') ? trim($v) : null;
    	}
    
    	// ========================
    	// ✅ FILE UPLOAD CONFIG
    	// ========================
    	$uploadPath = FCPATH . 'assets/images/describeimage/';
    	$config = [
    		'upload_path'   => $uploadPath,
    		'allowed_types' => 'jpg|jpeg|png|gif|pdf|doc|docx|xls|xlsx|txt|csv|zip|rar|bmp|tiff|mp4|avi|mov|m4a|wav|wma',
    		'max_size'      => 10240
    	];
    
    	// ========================
    	// ✅ FETCH EXISTING FILES (JSON)
    	// ========================
    	$record = $this->db->get_where('ticket_incident_message', ['id' => $id])->row();
    
    	$existingFiles = [];
    	if (!empty($record->describe_picture)) {
    		$decoded = json_decode($record->describe_picture, true);
    		if (is_array($decoded)) {
    			$existingFiles = $decoded;
    		}
    	}
    
    	// ========================
    	// ✅ REMOVE FILES
    	// ========================
    	$removedFiles = $this->input->post('remove_files');
    	if (is_array($removedFiles)) {
    		foreach ($removedFiles as $f) {
    			$f = trim($f);
    			$filePath = $uploadPath . $f;
    			if (file_exists($filePath)) {
    				@unlink($filePath);
    			}
    			$existingFiles = array_diff($existingFiles, [$f]);
    		}
    	}
    
    	// ========================
    	// ✅ NEW FILE UPLOADS
    	// ========================
    	$newFiles = [];
    
    	if (!empty($_FILES['describe_picture']['name'][0])) {
    
    		$fileCount = count($_FILES['describe_picture']['name']);
    
    		for ($i = 0; $i < $fileCount; $i++) {
    
    			$_FILES['file']['name']     = $_FILES['describe_picture']['name'][$i];
    			$_FILES['file']['type']     = $_FILES['describe_picture']['type'][$i];
    			$_FILES['file']['tmp_name'] = $_FILES['describe_picture']['tmp_name'][$i];
    			$_FILES['file']['error']    = $_FILES['describe_picture']['error'][$i];
    			$_FILES['file']['size']     = $_FILES['describe_picture']['size'][$i];
    
    			$cleanName = preg_replace('/\s+/', '_', pathinfo($_FILES['file']['name'], PATHINFO_FILENAME));
    			$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
    			$config['file_name'] = time() . '_' . $cleanName . '.' . $ext;
    
    			$this->upload->initialize($config);
    
    			if ($this->upload->do_upload('file')) {
    				$data = $this->upload->data();
    				$newFiles[] = $data['file_name'];
    			}
    		}
    	}
    
    	// ========================
    	// ✅ FINAL JSON SAVE
    	// ========================
    	$allFiles = array_merge($existingFiles, $newFiles);
    
    	$updateData['describe_picture'] = !empty($allFiles)
    		? json_encode(array_values($allFiles), JSON_UNESCAPED_SLASHES)
    		: null;
    
    	// ========================
    	// ✅ DB UPDATE
    	// ========================
    	$ok = $this->ticketsincidents_model->update_rca_details($id, $updateData);
    
    	echo json_encode([
    		'status'  => $ok ? 'success' : 'error',
    		'message' => $ok ? 'RCA updated successfully' : 'Database update failed'
    	]);
    }

   public function update_closed_rca()
    {
        if (ob_get_length()) @ob_end_clean();
        header('Content-Type: application/json; charset=utf-8');
        
        $id = $this->input->post('id');
        if (empty($id)) {
            echo json_encode(['status' => 'error', 'message' => 'Missing ID']);
            return;
        }
    
        $this->load->model('ticketsincidents_model');
    
        // --- RCA FIELD DATA ---
        $updateData = [
            'rca_tool' => $this->input->post('tool_applied'),
            'rootcause' => $this->input->post('rca'),
            'fivewhy_1' => $this->input->post('why_1'),
            'fivewhy_2' => $this->input->post('why_2'),
            'fivewhy_3' => $this->input->post('why_3'),
            'fivewhy_4' => $this->input->post('why_4'),
            'fivewhy_5' => $this->input->post('why_5'),
            'fivewhy2h_1' => $this->input->post('what_happened'),
            'fivewhy2h_2' => $this->input->post('why_did_it_happen'),
            'fivewhy2h_3' => $this->input->post('where_did_it_happen'),
            'fivewhy2h_4' => $this->input->post('when_did_it_happen'),
            'fivewhy2h_5' => $this->input->post('who_was_involved'),
            'fivewhy2h_6' => $this->input->post('how_did_it_happen'),
            'fivewhy2h_7' => $this->input->post('how_much_how_many_impact_cost'),
            'corrective' => $this->input->post('closure_corrective_action'),
            'preventive' => $this->input->post('closure_preventive_action'),
            'verification_comment' => $this->input->post('closure_verification_remark'),
        ];
    
        foreach ($updateData as $k => $v) {
            $updateData[$k] = (isset($v) && trim($v) !== '') ? trim($v) : null;
        }
            
        // --- FILE HANDLING ---
        $uploadPath = FCPATH . 'assets/images/capaimage/';
        if (!is_dir($uploadPath))
            mkdir($uploadPath, 0777, true);
    
        // Fetch current record
        $record = $this->db->where('id', $id)->get('ticket_incident_message')->row();
        $existingFiles = [];
        if ($record && !empty($record->picture)) {
            $existingFiles = json_decode($record->picture, true);
            if (!is_array($existingFiles)) {
                $existingFiles = [];
            }
        }
      
        // --- No removals: KEEP all old files intact ---
        // Skip remove_files logic entirely to preserve all old images
    
        // --- Handle new uploads ---
        $newFiles = [];
        if (!empty($_FILES['pictures']['name'][0])) {
            foreach ($_FILES['pictures']['name'] as $key => $filename) {
                $tmpName = $_FILES['pictures']['tmp_name'][$key];
                $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                $newName = uniqid('capa_') . '.' . $ext;
    
                if (move_uploaded_file($tmpName, $uploadPath . $newName)) {
                    $newFiles[] = $newName;
                }
            }
        }
    
        // --- Merge old + new ---
        $finalFiles = array_values(array_unique(array_merge($existingFiles, $newFiles)));
    
        // --- Save final list ---
        $updateData['picture'] = !empty($finalFiles) ? json_encode($finalFiles) : json_encode([]);
    
        // --- Update database ---
        $ok = $this->ticketsincidents_model->update_closed_rca($id, $updateData);
    
        echo json_encode([
            'status' => $ok ? 'success' : 'error',
            'message' => $ok ? 'Closed RCA updated successfully' : 'Database update failed',
            'files' => $finalFiles
        ]);
    }

}
