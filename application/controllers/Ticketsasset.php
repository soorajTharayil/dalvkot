<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ticketsasset extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model(array(
			'ticketsasset_model',
			'asset_model'
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

		$data['title'] = 'PC- OPEN TICKETS LIST';
		#-------------------------------#
		$data['departments'] = $this->ticketsasset_model->read();
		// print_r($data['departments']);
		$data['content'] = $this->load->view('asset/ticket', $data, true);
		$this->load->view('layout/main_wrapper', $data);
		$this->session->set_userdata('referred_from', NULL);
	}

	public function alltickets()
	{

		if ($this->session->userdata('isLogIn') == false)
			redirect('login');

		$data['title'] = 'PC- ALL TICKETS LIST';
		#-------------------------------#
		$data['departments'] = $this->ticketsasset_model->alltickets();
		$data['content'] = $this->load->view('asset/alltickets', $data, true);
		$this->load->view('layout/main_wrapper', $data);
		$this->session->set_userdata('referred_from', NULL);
	}

	public function asset_qrcode()
	{

		if ($this->session->userdata('isLogIn') == false)
			redirect('login');

		$data['title'] = 'ASSET QR CODE LIST';
		#-------------------------------#
		$data['departments'] = $this->ticketsasset_model->asset_qrcode();
		$data['content'] = $this->load->view('asset/asset_qrcode', $data, true);
		$this->load->view('layout/main_wrapper', $data);
		$this->session->set_userdata('referred_from', NULL);
	}

	public function addressedtickets()
	{
		if ($this->session->userdata('isLogIn') == false)
			redirect('login');

		$data['title'] = 'PC- ADDRESSED TICKETS LIST';
		#-------------------------------#
		$data['departments'] = $this->ticketsasset_model->addressedtickets();

		$data['content'] = $this->load->view('asset/addressedtickets', $data, true);
		$this->load->view('layout/main_wrapper', $data);
		$this->session->set_userdata('referred_from', NULL);
	}


	public function ticket_track()
	{


		$data['title'] = 'PC- TICKET DETAILS';
		$data['departments'] = $this->ticketsasset_model->read_by_id($this->uri->segment(3));
		$data['content'] = $this->load->view('asset/track', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}

	public function ticket_close()
	{
		if ($this->session->userdata('isLogIn') == false)
			redirect('login');

		$data['title'] = 'PC- CLOSED TICKETS LIST';
		$data['departments'] = $this->ticketsasset_model->read_close();
		$data['content'] = $this->load->view('asset/ticket_close', $data, true);

		$this->load->view('layout/main_wrapper', $data);
		$this->session->set_userdata('referred_from', NULL);
	}

	public function track_close()
	{
		if ($this->session->userdata('isLogIn') == false)
			redirect('login');

		$data['title'] = 'PC- CLOSED TICKET DETAILS';
		$data['departments'] = $this->ticketsasset_model->read_by_id($this->uri->segment(3));
		$data['content'] = $this->load->view('asset/track_close', $data, true);
		$this->load->view('layout/main_wrapper', $data);
		$this->session->set_userdata('referred_from', NULL);
	}

	public function show_asset_repairs($ticketid)
	{
		$this->load->model('ticketsasset_model');

		$repair_count = $this->ticketsasset_model->count_asset_repairs($ticketid);

		$data['repair_count'] = $repair_count;

		$this->load->view('layout/main_wrapper', $data);
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
			$this->db->update('tickets_int', $updatedepartment);

			$dataset = array(
				'reply' => $this->input->post('reply'),
				'message' => $message,
				'action' => $action,
				'action_meta' => json_encode($action_meta),
				'ticketid' => $this->input->post('id'),
				'ticket_status' => 'Transfered',
				'created_by' => $this->session->userdata('user_id'),
			);

			$this->db->insert('ticket_int_message', $dataset);
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_URL, base_url() . 'api/curl.php');
			curl_exec($curl);
			redirect('asset/track/' . $this->input->post('id'));
		} else {

			if ($this->input->post('status') == 'Asset Dispose') {


				$action = 'Asset Dispose by ' . $this->session->userdata['fullname'];
				$message = $this->session->userdata['fullname'];
				$updatedepartmen = array('status' => 'Asset Dispose');
				$this->db->where('id', $this->input->post('id'));
				$this->db->update('tickets_asset', $updatedepartmen);

				$updatedepartmen_feedback = array('assignstatus' => 'Asset Dispose');
				$this->db->where('id', $this->input->post('id'));
				$this->db->update('bf_feedback_asset_creation', $updatedepartmen_feedback);

				$dataset = array(
					'reply' => $this->input->post('reply'),
					'message' => $message,
					'action' => $action,
					'ticket_status' => 'Asset Dispose',
					'created_by' => $this->session->userdata('user_id'),
					'ticketid' => $this->input->post('id')
				);

				$this->db->insert('asset_ticket_message', $dataset);
				redirect('asset/track/' . $this->input->post('id'));
			} elseif ($this->input->post('status') == 'Asset Lost') {

				$action = 'Asset Lost by ' . $this->session->userdata['fullname'];
				$message = $this->session->userdata['fullname'];
				$updatedepartmen = array('status' => 'Asset Lost');
				$this->db->where('id', $this->input->post('id'));
				$this->db->update('tickets_asset', $updatedepartmen);

				$updatedepartmen_feedback = array('assignstatus' => 'Asset Lost');
				$this->db->where('id', $this->input->post('id'));
				$this->db->update('bf_feedback_asset_creation', $updatedepartmen_feedback);

				$dataset = array(
					'reply' => $this->input->post('reply'),
					'message' => $message,
					'action' => $action,
					'ticket_status' => 'Asset Lost',
					'created_by' => $this->session->userdata('user_id'),
					'ticketid' => $this->input->post('id')
				);

				$this->db->insert('asset_ticket_message', $dataset);
				redirect('asset/track/' . $this->input->post('id'));
			} elseif ($this->input->post('status') == 'Asset Reassign') {
				// Get the selected users from checkboxes
				$assigned_user_ids = $this->input->post('users_reassign'); // Assuming 'users' is the name of your checkbox array


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

				$action = 'Asset Re-assigned to ' . $assigned_user_names_str;
				$message = $this->session->userdata('fullname');

				// Update the ticket Asset
				$updatedepartment = array(

					'status' => 'Re-assigned',
					'reassign_by' =>  $this->session->userdata('user_id'),

					'reassign_to' => $assigned_user_ids_str // Store comma-separated IDs in 'assign_to' field
				);

				$this->db->where('id', $this->input->post('id'));
				$this->db->update('tickets_asset', $updatedepartment);

				$updatedepartmen_feedback = array('assignstatus' => 'Re-assigned');
				$this->db->where('id', $this->input->post('id'));
				$this->db->update('bf_feedback_asset_creation', $updatedepartmen_feedback);
				// Insert message into ticket message table
				$dataset = array(
					'reply' => $this->input->post('reply'), // Assuming 'assign_reply' is the input field for reply
					'message' => $message,
					'action' => $action,
					'ticket_status' => 'Re-assigned',
					'created_by' => $this->session->userdata('user_id'),
					'ticketid' => $this->input->post('id'),
					'depart' => $this->input->post('deparment_name')
				);

				$this->db->insert('asset_ticket_message', $dataset);

				redirect('asset/track/' . $this->input->post('id'));
			} elseif ($this->input->post('status') == 'Asset Malfunction') {

				$action = 'Asset Malfunction by ' . $this->session->userdata['fullname'];
				$message = $this->session->userdata['fullname'];
				$updatedepartmen = array('status' => 'Asset Malfunction');
				$this->db->where('id', $this->input->post('id'));
				$this->db->update('tickets_asset', $updatedepartmen);

				$updatedepartmen_feedback = array('assignstatus' => 'Asset Malfunction');
				$this->db->where('id', $this->input->post('id'));
				$this->db->update('bf_feedback_asset_creation', $updatedepartmen_feedback);

				$dataset = array(
					'reply' => $this->input->post('reply'),
					'message' => $message,
					'action' => $action,
					'repair_start_time' => $this->input->post('repair_start_date_time'),
					'ticket_status' => 'Asset Malfunction',
					'created_by' => $this->session->userdata('user_id'),
					'ticketid' => $this->input->post('id'),

				);

				$this->db->insert('asset_ticket_message', $dataset);
				redirect('asset/track/' . $this->input->post('id'));
			} elseif ($this->input->post('status') == 'Asset Sold') {

				$action = 'Asset Sold by ' . $this->session->userdata['fullname'];
				$message = $this->session->userdata['fullname'];
				$updatedepartmen = array('status' => 'Asset Sold');
				$this->db->where('id', $this->input->post('id'));
				$this->db->update('tickets_asset', $updatedepartmen);

				$updatedepartmen_feedback = array('assignstatus' => 'Asset Sold');
				$this->db->where('id', $this->input->post('id'));
				$this->db->update('bf_feedback_asset_creation', $updatedepartmen_feedback);

				$dataset = array(
					'reply' => $this->input->post('reply'),
					'message' => $message,
					'action' => $action,
					'sold_start_date_time' => $this->input->post('sold_start_date_time'),
					'sale_price' => $this->input->post('sale_price'),
					'ticket_status' => 'Asset Sold',
					'created_by' => $this->session->userdata('user_id'),
					'ticketid' => $this->input->post('id'),

				);

				$this->db->insert('asset_ticket_message', $dataset);
				redirect('asset/track/' . $this->input->post('id'));
			} elseif ($this->input->post('status') == 'Preventive Maintenance') {

				$action = 'Preventive Maintenance by ' . $this->session->userdata['fullname'];
				$message = $this->session->userdata['fullname'];
				// $updatedepartmen = array('status' => 'Preventive Maintenance');
				// $this->db->where('id', $this->input->post('id'));
				// $this->db->update('tickets_asset', $updatedepartmen);

				$updatedepartmen_feedback = array(

					'preventive_maintenance_date' => $this->input->post('preventive_maintenance_date'),
					'upcoming_preventive_maintenance_date' => $this->input->post('upcoming_preventive_maintenance_date'),
					'reminder_alert_1' => $this->input->post('reminder_alert_1'),
					'reminder_alert_2' => $this->input->post('reminder_alert_2')

				);

				$this->db->where('id', $this->input->post('id'));
				$this->db->update('bf_feedback_asset_creation', $updatedepartmen_feedback);

				// // Print the query
				// echo $this->db->last_query();
				// exit;

				$dataset = array(
					'reply' => $this->input->post('reply'),
					'message' => $message,
					'action' => $action,
					'preventive_maintenance_date' => $this->input->post('preventive_maintenance_date'),
					'upcoming_preventive_maintenance_date' => $this->input->post('upcoming_preventive_maintenance_date'),
					'reminder_alert_1' => $this->input->post('reminder_alert_1'),
					'reminder_alert_2' => $this->input->post('reminder_alert_2'),
					'ticket_status' => 'Preventive Maintenance',
					'created_by' => $this->session->userdata('user_id'),
					'ticketid' => $this->input->post('id')
				);

				$this->db->insert('asset_ticket_message', $dataset);
				redirect('asset/track/' . $this->input->post('id'));
			} elseif ($this->input->post('status') == 'Asset Calibration') {

				$action = 'Asset Calibration updated by ' . $this->session->userdata['fullname'];
				$message = $this->session->userdata['fullname'];
				// $updatedepartmen = array('status' => 'Preventive Maintenance');
				// $this->db->where('id', $this->input->post('id'));
				// $this->db->update('tickets_asset', $updatedepartmen);

				$updatedepartmen_feedback = array(

					'asset_calibration_date' => $this->input->post('asset_calibration_date'),
					'upcoming_calibration_date' => $this->input->post('upcoming_calibration_date'),
					'calibration_reminder_alert_1' => $this->input->post('calibration_reminder_alert_1'),
					'calibration_reminder_alert_2' => $this->input->post('calibration_reminder_alert_2')

				);

				$this->db->where('id', $this->input->post('id'));
				$this->db->update('bf_feedback_asset_creation', $updatedepartmen_feedback);

				// // Print the query
				// echo $this->db->last_query();
				// exit;

				$dataset = array(
					'reply' => $this->input->post('reply'),
					'message' => $message,
					'action' => $action,
					'asset_calibration_date' => $this->input->post('asset_calibration_date'),
					'upcoming_calibration_date' => $this->input->post('upcoming_calibration_date'),
					'calibration_reminder_alert_1' => $this->input->post('calibration_reminder_alert_1'),
					'calibration_reminder_alert_2' => $this->input->post('calibration_reminder_alert_2'),
					'ticket_status' => 'Asset Calibration',
					'created_by' => $this->session->userdata('user_id'),
					'ticketid' => $this->input->post('id')
				);

				$this->db->insert('asset_ticket_message', $dataset);
				redirect('asset/track/' . $this->input->post('id'));
			} elseif ($this->input->post('status') == 'Asset Restore') {

				$action = 'Asset restored by ' . $this->session->userdata['fullname'];
				$message = $this->session->userdata['fullname'];
				$updatedepartmen = array('status' => 'Asset in Use');
				$this->db->where('id', $this->input->post('id'));
				$this->db->update('tickets_asset', $updatedepartmen);

				$updatedepartmen_feedback = array('assignstatus' => 'Asset in Use');
				$this->db->where('id', $this->input->post('id'));
				$this->db->update('bf_feedback_asset_creation', $updatedepartmen_feedback);

				// // Print the query
				// echo $this->db->last_query();
				// exit;

				$dataset = array(
					'reply' => $this->input->post('reply'),
					'message' => $message,
					'action' => $action,
					'restore_start_date_time' => $this->input->post('restore_start_date_time'),
					'expense_cost' => $this->input->post('expense_cost'),
					'ticket_status' => 'Asset Restore',
					'created_by' => $this->session->userdata('user_id'),
					'ticketid' => $this->input->post('id')
				);

				$this->db->insert('asset_ticket_message', $dataset);
				redirect('asset/track/' . $this->input->post('id'));
			} elseif ($this->input->post('status') == 'Asset Warranty') {

				$action = 'Asset Warranty updated by ' . $this->session->userdata['fullname'];
				$message = $this->session->userdata['fullname'];
				// $updatedepartmen = array('status' => 'Preventive Maintenance');
				// $this->db->where('id', $this->input->post('id'));
				// $this->db->update('tickets_asset', $updatedepartmen);

				$this->db->select('dataset');
				$this->db->where('id', $this->input->post('id'));
				$query = $this->db->get('bf_feedback_asset_creation');
				$row = $query->row();

				if ($row) {
					$existingDataset = json_decode($row->dataset, true); // Decode the existing JSON data

					if (is_array($existingDataset)) {
						// Update only the incident_type field
						$existingDataset['warrenty'] = $this->input->post('warrenty');
						$existingDataset['warrenty_end'] = $this->input->post('warrenty_end');

						// Encode back to JSON
						$updatedDataset = json_encode($existingDataset);

						$updatedepartmen_feedback = array(
							'warrenty' => $this->input->post('warrenty'),
							'warrenty_end' => $this->input->post('warrenty_end'),
							'dataset' => $updatedDataset
						);

						$this->db->where('id', $this->input->post('id'));
						$this->db->update('bf_feedback_asset_creation', $updatedepartmen_feedback);
					}
				}

				// // Print the query
				// echo $this->db->last_query();
				// exit;

				$dataset = array(
					'reply' => $this->input->post('reply'),
					'message' => $message,
					'action' => $action,
					'warrenty' => $this->input->post('warrenty'),
					'warrenty_end' => $this->input->post('warrenty_end'),
					'ticket_status' => 'Asset Warranty',
					'created_by' => $this->session->userdata('user_id'),
					'ticketid' => $this->input->post('id')
				);

				$this->db->insert('asset_ticket_message', $dataset);
				redirect('asset/track/' . $this->input->post('id'));
			} elseif ($this->input->post('status') == 'Asset AMC/CMC') {

				$action = 'Asset AMC/ CMC updated by ' . $this->session->userdata['fullname'];
				$message = $this->session->userdata['fullname'];
				// $updatedepartmen = array('status' => 'Preventive Maintenance');
				// $this->db->where('id', $this->input->post('id'));
				// $this->db->update('tickets_asset', $updatedepartmen);

				$this->db->select('dataset');
				$this->db->where('id', $this->input->post('id'));
				$query = $this->db->get('bf_feedback_asset_creation');
				$row = $query->row();

				if ($row) {
					$existingDataset = json_decode($row->dataset, true); // Decode the existing JSON data

					if (is_array($existingDataset)) {
						// Update only the incident_type field
						$contract = $this->input->post('contract');
						$contractStartDate = $this->input->post('contract_start_date');
						$contractEndDate = $this->input->post('contract_end_date');
						$contractServiceCharges = $this->input->post('contract_service_charges');

						$existingDataset['contract'] = $contract;

						if ($contract === 'AMC') {
							$existingDataset['amcStartDate'] = $contractStartDate;
							$existingDataset['amcEndDate'] = $contractEndDate;
							$existingDataset['amcServiceCharges'] = $contractServiceCharges;
						} elseif ($contract === 'CMC') {
							$existingDataset['cmcStartDate'] = $contractStartDate;
							$existingDataset['cmcEndDate'] = $contractEndDate;
							$existingDataset['cmcServiceCharges'] = $contractServiceCharges;
						}


						// Encode back to JSON
						$updatedDataset = json_encode($existingDataset);


						$updatedepartmen_feedback = array(

							'contract' => $this->input->post('contract'),
							'contract_start_date' => $this->input->post('contract_start_date'),
							'contract_end_date' => $this->input->post('contract_end_date'),
							'contract_service_charges' => $this->input->post('contract_service_charges'),
							'dataset' => $updatedDataset

						);

						$this->db->where('id', $this->input->post('id'));
						$this->db->update('bf_feedback_asset_creation', $updatedepartmen_feedback);
					}
				}
				// // Print the query
				// echo $this->db->last_query();
				// exit;

				$dataset = array(
					'reply' => $this->input->post('reply'),
					'message' => $message,
					'action' => $action,
					'contract' => $this->input->post('contract'),
					'contract_start_date' => $this->input->post('contract_start_date'),
					'contract_end_date' => $this->input->post('contract_end_date'),
					'contract_service_charges' => $this->input->post('contract_service_charges'),
					'ticket_status' => 'Asset AMC/CMC',
					'created_by' => $this->session->userdata('user_id'),
					'ticketid' => $this->input->post('id')
				);

				$this->db->insert('asset_ticket_message', $dataset);
				redirect('asset/track/' . $this->input->post('id'));
			} elseif ($this->input->post('status') == 'Asset Broken') {

				$action = 'Asset Broken by ' . $this->session->userdata['fullname'];
				$message = $this->session->userdata['fullname'];
				$updatedepartmen = array('status' => 'Asset Broken');
				$this->db->where('id', $this->input->post('id'));
				$this->db->update('tickets_asset', $updatedepartmen);

				$updatedepartmen_feedback = array('assignstatus' => 'Asset Broken');
				$this->db->where('id', $this->input->post('id'));
				$this->db->update('bf_feedback_asset_creation', $updatedepartmen_feedback);

				$dataset = array(
					'reply' => $this->input->post('reply'),
					'message' => $message,
					'action' => $action,
					'ticket_status' => 'Asset Broken',
					'created_by' => $this->session->userdata('user_id'),
					'ticketid' => $this->input->post('id')
				);

				$this->db->insert('asset_ticket_message', $dataset);
				redirect('asset/track/' . $this->input->post('id'));
			} elseif ($this->input->post('status') == 'Asset Assign') {


				// Get the selected users from checkboxes
				$assigned_user_ids = $this->input->post('users'); // Assuming 'users' is the name of your checkbox array



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
				$action = 'Asset Assigned to ' . $assigned_user_names_str;
				$message = $this->session->userdata('fullname');


				$updatedepartmen = array('status' => 'Asset Assign');
				$this->db->where('id', $this->input->post('id'));
				$this->db->update('tickets_asset', $updatedepartmen);

				$updatedepartmen_feedback = array('assignstatus' => 'Asset Assign');
				$this->db->where('id', $this->input->post('id'));
				$this->db->update('bf_feedback_asset_creation', $updatedepartmen_feedback);

				$dataset = array(
					'reply' => $this->input->post('reply'),
					'message' => $message,
					'action' => $action,
					'ticket_status' => 'Asset Assign',
					'created_by' => $this->session->userdata('user_id'),
					'ticketid' => $this->input->post('id'),
					'depart' => $this->input->post('deparment_name')

				);

				$this->db->insert('asset_ticket_message', $dataset);
				redirect('asset/track/' . $this->input->post('id'));
			} elseif ($this->input->post('status') == 'Asset Transfer') {

				// Get the selected users from checkboxes
				$assigned_user_ids = $this->input->post('users_transfer');
				$assigned_user_ids_str = implode(',', $assigned_user_ids);
			
				// Fetch user names
				$this->db->select('firstname');
				$this->db->from('user');
				$this->db->where_in('user_id', $assigned_user_ids);
				$query = $this->db->get();
				$assigned_user_names = array_column($query->result_array(), 'firstname');
				$assigned_user_names_str = implode(',', $assigned_user_names);
			
				// Action and message
				$action = 'Asset transfer requested to ' . $assigned_user_names_str;
				$message = $this->session->userdata('fullname');
			
				//Pending Transfer instead of directly transferring
				$pendingTransferData = array(
					'status' => 'Pending Transfer', 
					'transfer_to' => $assigned_user_ids_str,
					'depart' => $this->input->post('deparment_name'),
					'transfer_email_status' => 0,
					'transfer_approval_status' => 'pending'
				);
			
				$this->db->where('id', $this->input->post('id'));
				$this->db->update('tickets_asset', $pendingTransferData);
			
				// Update feedback asset record
				$this->db->select('dataset');
				$this->db->where('id', $this->input->post('id'));
				$query = $this->db->get('bf_feedback_asset_creation');
				$row = $query->row();
				if ($row) {
					$existingDataset = json_decode($row->dataset, true);
					if (is_array($existingDataset)) {
						$existingDataset['depart'] = $this->input->post('deparment_name');
						$updatedDataset = json_encode($existingDataset);
			
						$updateFeedback = array(
							'assignstatus' => 'Pending Transfer',
							'depart_transfer' => $this->input->post('deparment_name'),
							'depart' => $this->input->post('deparment_name'),
							'dataset' => $updatedDataset
						);
			
						$this->db->where('id', $this->input->post('id'));
						$this->db->update('bf_feedback_asset_creation', $updateFeedback);
					}
				}
			
				// Log the message
				$dataset = array(
					'reply' => $this->input->post('reply'),
					'message' => $message,
					'action' => $action,
					'ticket_status' => 'Pending Transfer',
					'created_by' => $this->session->userdata('user_id'),
					'ticketid' => $this->input->post('id'),
					'depart' => $this->input->post('deparment_name')
				);
			
				$this->db->insert('asset_ticket_message', $dataset);
			
				// Trigger email/API
				$curl = curl_init();
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($curl, CURLOPT_URL, base_url() . 'api/curl.php');
				curl_exec($curl);
			
				// Redirect to ticket view
				redirect('asset/track/' . $this->input->post('id'));
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

				$this->db->insert('ticket_int_message', $dataset);
			}
		}
		redirect('asset/track/' . $this->input->post('id'));
	}
}
