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


		if ($this->input->post('deparment') != 0) {
			$this->db->where('dprt_id', $this->input->post('deparment'));
			// print_r($_POST);
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

				//print_r($picture); exit;
				$dataset = array(
					'reply' => $this->input->post('reply'),
					'corrective' => $this->input->post('corrective'),
					'preventive' => $this->input->post('preventive'),
					'rootcause' => $this->input->post('rootcause'),
					'comment' => $comment,
					'message' => $message,
					'resolution_note' => $this->input->post('resolution_note'),
					'action' => $action,
					'ticket_status' => 'Closed',
					'created_by' => $this->session->userdata('user_id'),
					'ticketid' => $this->input->post('id'),
				);

				// Set upload path and allowed file types
				$config['upload_path'] = './assets/images/capaimage/';
				$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf|doc|docx|xls|xlsx|txt|csv|zip|rar|bmp|tiff|mp4|avi|mov|m4a|wav|wma';

				$config['max_size'] = 10240;  // Set max file size (10MB)

				$config['file_name'] = time() . '_' . $_FILES['picture']['name'];  // Generate unique filename

				// Load the upload library with the config settings
				$this->upload->initialize($config);

				// Check if the upload is successful
				if (!$this->upload->do_upload('picture')) {
					// Handle upload error
					$error = array('error' => $this->upload->display_errors());
					// Optionally handle the error (like logging or displaying)
					print_r($error);  // For debugging; you might want to handle it differently
				} else {
					// Handle successful upload
					$uploadData = $this->upload->data();  // Get upload data
					$dataset['picture'] = $uploadData['file_name'];  // Save the uploaded file's name to the dataset
				}


				$this->db->insert('ticket_incident_message', $dataset);
				if ($this->input->post('status_patient_verified') && $this->input->post('status_patient_verified') == 'Verified') {

					redirect('track/inc/' . $this->input->post('id'));
				} else {
					redirect('incident/alltickets');
				}

				// redirect('incident/closedtickets');
				$this->session->set_flashdata('message', '<span style="color: green;">Ticket is closed</span>');
			} elseif ($this->input->post('status') == 'Reopen') {

				if ($this->input->post('status_patient') && $this->input->post('status_patient') == 'Patient') {

					$action = 'Reopened by the user (' . $this->input->post('patient_reopen_name') . ')';
					$message =  $this->input->post('patient_reopen_name');
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
			} elseif ($this->input->post('status') == 'Assigned') {
				// Get the selected users from checkboxes
				$assigned_user_ids = $this->input->post('users'); // Assuming 'users' is the name of your checkbox array

				if (!empty($assigned_user_ids)) {

					// Prepare the comma-separated list of user IDs
					$assigned_user_ids_str = implode(',', $assigned_user_ids);

					// Fetch user names from the user table based on the selected user IDs
					$this->db->select('firstname');
					$this->db->from('user');
					$this->db->where_in('user_id', $assigned_user_ids);
					$query = $this->db->get();
					$assigned_user_names = array_column($query->result_array(), 'firstname');

					// Prepare the comma-separated list of user names
					$assigned_user_names_str = implode(',', $assigned_user_names);

					// Prepare action and message
					$action = 'Incident Assigned to ' . $assigned_user_names_str;
					$message = $this->session->userdata('fullname');

					// Update the ticket incident
					$updatedepartment = array(

						'status' => 'Assigned',
						'assign_by' =>  $this->session->userdata('user_id'),
						'assigned_message' => 0,
						'describe_message' => -1,
						'assigned_email' => 0,

						'assign_to' => $assigned_user_ids_str // Store comma-separated IDs in 'assign_to' field
					);

					$this->db->where('id', $this->input->post('id'));
					$this->db->update('tickets_incident', $updatedepartment);

					// Insert message into ticket message table
					$dataset = array(
						'reply' => $this->input->post('reply'), // Assuming 'assign_reply' is the input field for reply
						'message' => $message,
						'action' => $action,
						'ticket_status' => 'Assigned',
						'created_by' => $this->session->userdata('user_id'),
						'ticketid' => $this->input->post('id')
					);

					$this->db->insert('ticket_incident_message', $dataset);
				}

				$curl = curl_init();
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($curl, CURLOPT_URL, base_url() . 'api/curl.php');
				curl_exec($curl);

				// Redirect to open tickets page after assigning users
				redirect('incident/opentickets');

				$curl = curl_init();
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($curl, CURLOPT_URL, base_url() . 'api/curl.php');
				curl_exec($curl);
			} elseif ($this->input->post('status') == 'Re-assigned') {
				// Get the selected users from checkboxes
				$assigned_user_ids = $this->input->post('users_reassign'); // Assuming 'users' is the name of your checkbox array

				if (!empty($assigned_user_ids)) {

					// Prepare the comma-separated list of user IDs
					$assigned_user_ids_str = implode(',', $assigned_user_ids);

					// Fetch user names from the user table based on the selected user IDs
					$this->db->select('firstname');
					$this->db->from('user');
					$this->db->where_in('user_id', $assigned_user_ids);
					$query = $this->db->get();
					$assigned_user_names = array_column($query->result_array(), 'firstname');

					// Prepare the comma-separated list of user names
					$assigned_user_names_str = implode(',', $assigned_user_names);

					// Prepare action and message
					$action = 'Incident Re-assigned to ' . $assigned_user_names_str;
					$message = $this->session->userdata('fullname');

					// Update the ticket incident
					$updatedepartment = array(

						'status' => 'Re-assigned',
						'reassign_by' =>  $this->session->userdata('user_id'),
						'reassigned_message' => 0,
						'describe_message' => -1,
						'reassigned_email' => 0,
						'reassign_to' => $assigned_user_ids_str // Store comma-separated IDs in 'assign_to' field
					);

					$this->db->where('id', $this->input->post('id'));
					$this->db->update('tickets_incident', $updatedepartment);

					// Insert message into ticket message table
					$dataset = array(
						'reply' => $this->input->post('reply'), // Assuming 'assign_reply' is the input field for reply
						'message' => $message,
						'action' => $action,
						'ticket_status' => 'Re-assigned',
						'created_by' => $this->session->userdata('user_id'),
						'ticketid' => $this->input->post('id')
					);

					$this->db->insert('ticket_incident_message', $dataset);
				}

				$curl = curl_init();
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($curl, CURLOPT_URL, base_url() . 'api/curl.php');
				curl_exec($curl);

				// Redirect to open tickets page after assigning users
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

				$action = 'Incident Described by ' . $this->session->userdata['fullname'];
				$message = $this->session->userdata['fullname'];

				$dataset = array(
					'reply' => $this->input->post('reply'),
					'message' => $message,
					'action' => $action,
					'ticket_status' => 'Described',
					'created_by' => $this->session->userdata('user_id'),
					'ticketid' => $this->input->post('id')
				);

				// Load the upload library
				$this->load->library('upload');

				// Set upload configuration for 'describe_picture' file
				$config['upload_path'] = FCPATH . 'assets/images/describeimage/';
				$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf|doc|docx|xls|xlsx|txt|csv|zip|rar|bmp|tiff|mp4|avi|mov|m4a|wav|wma';
				$config['max_size'] = 10240;  // Max size: 10MB
				$config['file_name'] = time() . '_' . $_FILES['describe_picture']['name'];



				// Initialize upload library with config
				$this->upload->initialize($config);

				// Check if the file upload is successful
				if (!$this->upload->do_upload('describe_picture')) {
					// Handle upload error
					$error = array('error' => $this->upload->display_errors());
					// print_r($error);  // Optionally log or handle errors
				} else {
					// Successful upload, save filename to dataset
					$uploadData = $this->upload->data();
					$dataset['describe_picture'] = $uploadData['file_name'];
				}

				// print_r($dataset); // <-- This will show the data to be inserted
				// exit;

				// Insert dataset into the 'ticket_incident_message' table
				$this->db->insert('ticket_incident_message', $dataset);

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
		if ($this->input->post('status') == 'EditSeverity') {

			$updatedepartment_inc = array('incident_type' => $this->input->post('incident_type'));
			$this->db->where('feedbackid', $this->input->post('id'));
			$this->db->update('tickets_incident', $updatedepartment_inc);

			// Fetch the existing dataset from the database
			$this->db->select('dataset');
			$this->db->where('id', $this->input->post('id'));
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
					$this->db->where('id', $this->input->post('id'));
					$this->db->update('bf_feedback_incident', $updatedepartment);

					if ($this->db->affected_rows() > 0) {
						$empid = $this->input->post('id'); // Assuming 'id' contains the employee ID
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
		if ($this->input->post('status') == 'EditPriority') {

			$updatedepartment_inc = array('priority' => $this->input->post('priority'));
			$this->db->where('feedbackid', $this->input->post('id'));
			$this->db->update('tickets_incident', $updatedepartment_inc);

			// Fetch the existing dataset from the database
			$this->db->select('dataset');
			$this->db->where('id', $this->input->post('id'));
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
					$this->db->where('id', $this->input->post('id'));
					$this->db->update('bf_feedback_incident', $updatedepartment);

					if ($this->db->affected_rows() > 0) {
						$empid = $this->input->post('id'); // Assuming 'id' contains the employee ID
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
}
