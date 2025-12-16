<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ticketsesr extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model(array(
			'ticketsesr_model',
			'isr_model'
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

		$data['title'] = 'ERS- OPEN TICKETS LIST';
		#-------------------------------#
		$data['departments'] = $this->ticketsesr_model->read();

		$data['content'] = $this->load->view('isr/ticket', $data, true);
		$this->load->view('layout/main_wrapper', $data);
		$this->session->set_userdata('referred_from', NULL);
	}

	public function alltickets()
	{

		if ($this->session->userdata('isLogIn') == false)
			redirect('login');

		$data['title'] = 'ERS- ALL TICKETS LIST';
		#-------------------------------#
		$data['departments'] = $this->ticketsesr_model->alltickets();
		$data['content'] = $this->load->view('isr/alltickets', $data, true);
		$this->load->view('layout/main_wrapper', $data);
		$this->session->set_userdata('referred_from', NULL);
	}

	public function addressedtickets()
	{
		if ($this->session->userdata('isLogIn') == false)
			redirect('login');

		$data['title'] = 'ERS- ADDRESSED TICKETS LIST';
		#-------------------------------#
		$data['departments'] = $this->ticketsesr_model->addressedtickets();

		$data['content'] = $this->load->view('isr/addressedtickets', $data, true);
		$this->load->view('layout/main_wrapper', $data);
		$this->session->set_userdata('referred_from', NULL);
	}


	public function ticket_track()
	{


		$data['title'] = 'ERS- TICKET DETAILS';
		$data['departments'] = $this->ticketsesr_model->read_by_id($this->uri->segment(3));
		$data['content'] = $this->load->view('isr/track', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}

	public function ticket_close()
	{
		if ($this->session->userdata('isLogIn') == false)
			redirect('login');

		$data['title'] = 'ERS- CLOSED TICKETS LIST';
		$data['departments'] = $this->ticketsesr_model->read_close();
		$data['content'] = $this->load->view('isr/ticket_close', $data, true);

		$this->load->view('layout/main_wrapper', $data);
		$this->session->set_userdata('referred_from', NULL);
	}

	public function track_close()
	{
		if ($this->session->userdata('isLogIn') == false)
			redirect('login');

		$data['title'] = 'ERS- CLOSED TICKET DETAILS';
		$data['departments'] = $this->ticketsesr_model->read_by_id($this->uri->segment(3));
		$data['content'] = $this->load->view('isr/track_close', $data, true);
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
				'action'=>'Transfered',
				'sourceDepartmentId'=>$this->input->post('reply_department_id'),
				'targetDepartmentId'=> $this->input->post('deparment')
			);
		
			$message = $this->session->userdata['fullname'];
			$updatedepartment = array('departmentid_trasfered' => $this->input->post('deparment'), 'emailstatus' => 0, 'status' => 'Transfered', 'transfer_ticket_alert' => '0');
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('tickets_esr', $updatedepartment);

			$dataset = array(
				'reply' => $this->input->post('reply'),
				'message' => $message,
				'action' => $action,
				'action_meta' => json_encode($action_meta),
				'ticketid' => $this->input->post('id'),
				'ticket_status' => 'Transfered',
				'created_by' => $this->session->userdata('user_id'),
			);

			$this->db->insert('ticket_esr_message', $dataset);
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_URL, base_url() . 'api/curl.php');
			curl_exec($curl);
			redirect('isr/opentickets');
		} else {

			if ($this->input->post('status') == 'Closed') {


				$result = $this->db->select("*")
					->from('tickets_esr')
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
				$action = 'Closed by ' . $this->session->userdata['fullname'];
				$message = $this->session->userdata['fullname'];
				//foreach($resultss as $tickets){

				if ($this->input->post('status_patient_verified') && $this->input->post('status_patient_verified') == 'Verified') {
					$verified_by_patient = 1;
				} else {
					$verified_by_patient = 0;
				}
				
				$updatedepartmen = array(
					'status' => $this->input->post('status'),
					'closed_ticket_alert' => '0',
				
					'patient_verified_status' => $verified_by_patient // Added patient_verified_status
				);

				

				$this->db->where('id', $this->input->post('id'));
				//$this->db->where('created_by',$result[0]->created_by);
				$this->db->update('tickets_esr', $updatedepartmen);
				//}
				if (close_comment('isr_close_comment') === true) {
					$comment = $this->input->post('comment');
				} else {
					$comment = NULL;
				}
				//picture upload
				$picture = $this->fileupload->do_upload(
					'assets/images/capaimage/',
					'picture'
				);
				//print_r($picture); exit;
				$dataset = array(
					'reply' => $this->input->post('reply'),
					'corrective' => $this->input->post('corrective'),
					'preventive' => $this->input->post('preventive'),
					'rootcause' => $this->input->post('rootcause'),
					'comment' => $comment,
					'resolution_note' => $this->input->post('resolution_note'),
					'message' => $message,
					'picture' => (!empty($picture) ? $picture : null),
					'action' => $action,
					'ticket_status' => 'Closed',
					'created_by' => $this->session->userdata('user_id'),
					'ticketid' => $this->input->post('id')
				);

				$this->db->insert('ticket_esr_message', $dataset);

				if ($this->input->post('status_patient_verified') && $this->input->post('status_patient_verified') == 'Verified') {

					redirect('track/isr/' . $this->input->post('id'));

				} else {
					redirect('isr/alltickets');
				}

				$this->session->set_flashdata('message', '<span style="color: green;">Ticket is closed</span>');
				$curl = curl_init();
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($curl, CURLOPT_URL, base_url() . 'api/curl.php');
				curl_exec($curl);


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
				$this->db->update('tickets_esr', $updatedepartmen);

				$dataset = array(
					'reply' => $this->input->post('reply'),
					'message' => $message,
					'action' => $action,
					'ticket_status' => 'Reopen',
					'created_by' => $this->session->userdata('user_id'),
					'ticketid' => $this->input->post('id')
				);

				$this->db->insert('ticket_esr_message', $dataset);
				$curl = curl_init();
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($curl, CURLOPT_URL, base_url() . 'api/curl.php');
				curl_exec($curl);
				if ($this->input->post('status_patient') && $this->input->post('status_patient') == 'Patient') {

					redirect('track/isr/' . $this->input->post('id'));

				} else {
					redirect('isr/opentickets');
				}
				
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
					$action = 'Assigned to ' . $assigned_user_names_str;
					$message = $this->session->userdata('fullname');

					// Update the ticket esr
					$updatedepartment = array(

						'status' => 'Assigned',
						'assigned_message' => 0,
						'assigned_email' => 0,
						'assign_to' => $assigned_user_ids_str // Store comma-separated IDs in 'assign_to' field
					);

					$this->db->where('id', $this->input->post('id'));
					$this->db->update('tickets_esr', $updatedepartment);

					// Insert message into ticket message table
					$dataset = array(
						'reply' => $this->input->post('reply'), // Assuming 'assign_reply' is the input field for reply
						'message' => $message,
						'action' => $action,
						'ticket_status' => 'Assigned',
						'created_by' => $this->session->userdata('user_id'),
						'ticketid' => $this->input->post('id')
					);

					$this->db->insert('ticket_esr_message', $dataset);
				}

				$curl = curl_init();
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($curl, CURLOPT_URL, base_url() . 'api/curl.php');
				curl_exec($curl);

				// Redirect to open tickets page after assigning users
				redirect('isr/track/' . $this->input->post('id'));
			} elseif ($this->input->post('status') == 'Addressed') {

				$action = 'Addressed by ' . $this->session->userdata['fullname'];
				$message = $this->session->userdata['fullname'];
				$updatedepartmen = array('addressed' => 1, 'status' => 'Addressed');
				$this->db->where('id', $this->input->post('id'));
				$this->db->update('tickets_esr', $updatedepartmen);

				$dataset = array(
					'reply' => $this->input->post('reply'),
					'message' => $message,
					'action' => $action,
					'ticket_status' => 'Addressed',
					'created_by' => $this->session->userdata('user_id'),
					'ticketid' => $this->input->post('id')
				);

				$this->db->insert('ticket_esr_message', $dataset);
				redirect('isr/track/' . $this->input->post('id'));
			}  elseif ($this->input->post('status') == 'Rejected') {

				$action = 'Rejected by ' . $this->session->userdata['fullname'];
				$message = $this->session->userdata['fullname'];
				$updatedepartmen = array('status' => 'Rejected');
				$this->db->where('id', $this->input->post('id'));
				$this->db->update('tickets_esr', $updatedepartmen);

				$dataset = array(
					'reply' => $this->input->post('reply'),
					'message' => $message,
					'action' => $action,
					'ticket_status' => 'Rejected',
					'created_by' => $this->session->userdata('user_id'),
					'ticketid' => $this->input->post('id')
				);

				$this->db->insert('ticket_esr_message', $dataset);
				redirect('isr/track/' . $this->input->post('id'));
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

				$this->db->insert('ticket_esr_message', $dataset);
			}
		}
		redirect('isr/track/' . $this->input->post('id'));
	}
}
