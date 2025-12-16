<?php defined('BASEPATH') or exit('No direct script access allowed');

class Ticketsasset_model extends CI_Model
{

	private $table = 'tickets_asset';

	public function create($data = [])
	{

		return $this->db->insert($this->table, $data);
	}


	public function addressedtickets()
	{
		$email = $this->session->userdata['email'];
		$role = $this->session->userdata['user_role'];
		$fdate = date('Y-m-d', strtotime($_SESSION['from_date']) + 24 * 60 * 60);
		$tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
		//print_r($this->session->userdata);
		$datasetnew = array();
		$i = 0;
		if ($this->input->get('depsec') != 1 && $this->input->get('depsec') != '') {
			$this->db->where('type', 'interim');
			$this->db->where('description', $this->input->get('depsec'));
			$query = $this->db->get('department');
			$result = $query->result();
			foreach ($result as $t) {
				$datasetnew[$i++] = $t->dprt_id;
			}
		}


		$firstname = $this->session->userdata['firstname'];
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->where('status', 'Addressed');
		//echo '(created_on >= "'.$tdate.'" AND created_on <= "'.$fdate.'")';
		$this->db->where('created_on >=', $tdate);
		$this->db->where('created_on <=', $fdate);



		if ($this->input->get('type') != 1 && $this->input->get('type') != '') {
			$this->db->where('departmentid', $this->input->get('type'));
		} else {
			if (count($datasetnew) > 0) {
				$this->db->where_in('departmentid', $datasetnew);
			}
		}

		$this->db->order_by('id', 'desc');
		$query = $this->db->get();
		$result  = $query->result();
		$dataset = array();

		$i = 0;
		//echo '<pre>';
		foreach ($result as $row) {
			//print_r($row); 
			// $this->db->where('dprt_id', $row->departmentid);
			if ($row->departmentid_trasfered != 0) {
				$this->db->where('dprt_id', $row->departmentid_trasfered);
			} else {
				$this->db->where('dprt_id', $row->departmentid);
			}
			$query = $this->db->get('department');
			$department = $query->result();
			if (isset($_SESSION['ward']) && $_SESSION['ward'] != 'ALL') {
				// Use ward only if floorwise doesn't exist
				$this->db->where('bf_feedback_asset_creation.locationsite', $_SESSION['ward']);
			} elseif (count($this->session->userdata['floor_ward']) > 0) {
				$floorwiseArray = $this->session->userdata['floor_ward'];
				$this->db->where_in('bf_feedback_asset_creation.locationsite', $floorwiseArray);
			}

			$this->db->where('id', $row->feedbackid);
			$query = $this->db->get('bf_feedback_asset_creation');
			$feedback = $query->result();

			if (count($feedback) == 0) {
				continue;
			}


			$pos = strpos($this->session->userdata['department_access'][$department[0]->type][$department[0]->setkey], $department[0]->slug);

			if ($pos !== false && count($this->session->userdata['department_access'][$department[0]->type]) > 0) {
				//$slug = $row->feedbackid.preg_replace('/[^A-Za-z0-9-]+/', '-', $department[0]->dprt_id);
				$dataset[$i] = $row;


				$dataset[$i] = $row;
				$dataset[$i]->feed = json_decode($feedback[0]->dataset);
				$feed = json_decode($feedback[0]->dataset);
				$dataset[$i]->patinet->name = $feed->name;
				$dataset[$i]->patinet->patient_id = $feed->patientid;
				$dataset[$i]->patinet->mobile = $feed->contactnumber;
				$dataset[$i]->patinet->ward = $feed->ward;
				$dataset[$i]->patinet->bed_no = $feed->bedno;
				$dataset[$i]->patinet->admissiondate = $feed->admissiondate;

				$dataset[$i]->department = $department[0];
				if ($row->rating == 2) {
					$dataset[$i]->ratingt = 'Poor';
				} else {
					$dataset[$i]->ratingt = 'Worst';
				}
			} elseif ($role <= 3) {
				//$slug = $row->feedbackid.preg_replace('/[^A-Za-z0-9-]+/', '-', $department[0]->name);
				$dataset[$i] = $row;
				$dataset[$i]->feed = json_decode($feedback[0]->dataset);
				$feed = json_decode($feedback[0]->dataset);
				$dataset[$i]->patinet->name = $feed->name;
				$dataset[$i]->patinet->patient_id = $feed->patientid;
				$dataset[$i]->patinet->mobile = $feed->contactnumber;
				$dataset[$i]->patinet->ward = $feed->ward;
				$dataset[$i]->patinet->bed_no = $feed->bedno;
				$dataset[$i]->patinet->admissiondate = $feed->admissiondate;

				$dataset[$i]->department = $department[0];
				if ($row->rating == 2) {
					$dataset[$i]->ratingt = 'Poor';
				} else {
					$dataset[$i]->ratingt = 'Worst';
				}
			}
			$i++;
		}

		return $dataset;
	}

	public function read()
	{
		$email = $this->session->userdata['email'];
		$role = $this->session->userdata['user_role'];
		$fdate = date('Y-m-d', strtotime($_SESSION['from_date']) + 24 * 60 * 60);
		$tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
		//print_r($this->session->userdata);
		$datasetnew = array();
		$i = 0;
		if ($this->input->get('depsec') != 1 && $this->input->get('depsec') != '') {
			$this->db->where('type', 'interim');
			$this->db->where('description', $this->input->get('depsec'));
			$query = $this->db->get('department');
			$result = $query->result();
			foreach ($result as $t) {
				$datasetnew[$i++] = $t->dprt_id;
			}
		}


		$firstname = $this->session->userdata['firstname'];
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->where('status !=', 'Closed');
		$this->db->where('status !=', 'Addressed');
		//echo '(created_on >= "'.$tdate.'" AND created_on <= "'.$fdate.'")';
		$this->db->where('created_on >=', $tdate);
		$this->db->where('created_on <=', $fdate);



		if ($this->input->get('type') != 1 && $this->input->get('type') != '') {
			$this->db->where('departmentid', $this->input->get('type'));
		} else {
			if (count($datasetnew) > 0) {
				$this->db->where_in('departmentid', $datasetnew);
			}
		}

		$this->db->order_by('id', 'desc');
		$query = $this->db->get();
		$result  = $query->result();
		$dataset = array();

		$i = 0;
		//echo '<pre>';
		foreach ($result as $row) {
			//print_r($row); 
			// $this->db->where('dprt_id', $row->departmentid);
			if ($row->departmentid_trasfered != 0) {
				$this->db->where('dprt_id', $row->departmentid_trasfered);
			} else {
				$this->db->where('dprt_id', $row->departmentid);
			}

			$query = $this->db->get('department');
			$department = $query->result();
			if (isset($_SESSION['ward']) && $_SESSION['ward'] != 'ALL') {
				// Use ward only if floorwise doesn't exist
				$this->db->where('bf_feedback_asset_creation.locationsite', $_SESSION['ward']);
			} elseif (count($this->session->userdata['floor_ward']) > 0) {
				$floorwiseArray = $this->session->userdata['floor_ward'];
				$this->db->where_in('bf_feedback_asset_creation.locationsite', $floorwiseArray);
			}

			$this->db->where('id', $row->feedbackid);
			$query = $this->db->get('bf_feedback_asset_creation');
			$feedback = $query->result();

			if (count($feedback) == 0) {
				continue;
			}

			$pos = strpos($this->session->userdata['department_access'][$department[0]->type][$department[0]->setkey], $department[0]->slug);

			if ($pos !== false && count($this->session->userdata['department_access'][$department[0]->type]) > 0) {
				//$slug = $row->feedbackid.preg_replace('/[^A-Za-z0-9-]+/', '-', $department[0]->dprt_id);
				$dataset[$i] = $row;


				$dataset[$i] = $row;
				$dataset[$i]->feed = json_decode($feedback[0]->dataset);
				$feed = json_decode($feedback[0]->dataset);
				$dataset[$i]->patinet->name = $feed->name;
				$dataset[$i]->patinet->patient_id = $feed->patientid;
				$dataset[$i]->patinet->mobile = $feed->contactnumber;
				$dataset[$i]->patinet->ward = $feed->ward;
				$dataset[$i]->patinet->bed_no = $feed->bedno;
				$dataset[$i]->patinet->admissiondate = $feed->admissiondate;

				$dataset[$i]->department = $department[0];
				if ($row->rating == 2) {
					$dataset[$i]->ratingt = 'Poor';
				} else {
					$dataset[$i]->ratingt = 'Worst';
				}
			} elseif ($role <= 3) {
				//$slug = $row->feedbackid.preg_replace('/[^A-Za-z0-9-]+/', '-', $department[0]->name);
				$dataset[$i] = $row;
				$dataset[$i]->feed = json_decode($feedback[0]->dataset);
				$feed = json_decode($feedback[0]->dataset);
				$dataset[$i]->patinet->name = $feed->name;
				$dataset[$i]->patinet->patient_id = $feed->patientid;
				$dataset[$i]->patinet->mobile = $feed->contactnumber;
				$dataset[$i]->patinet->ward = $feed->ward;
				$dataset[$i]->patinet->bed_no = $feed->bedno;
				$dataset[$i]->patinet->admissiondate = $feed->admissiondate;

				$dataset[$i]->department = $department[0];
				if ($row->rating == 2) {
					$dataset[$i]->ratingt = 'Poor';
				} else {
					$dataset[$i]->ratingt = 'Worst';
				}
			}
			$i++;
		}

		return $dataset;
	}

	public function count_asset_repairs($ticketid)
	{
		$this->db->select('COUNT(*) as repair_count');
		$this->db->from('asset_ticket_message atm');
		$this->db->join('bf_feedback_asset_creation fac', 'fac.id = atm.ticketid');
		$this->db->where('atm.ticketid', $ticketid);
		$this->db->where_in('atm.ticket_status', ['Asset in Repair', 'Asset Repair']);

		$query = $this->db->get();

		return $query->row() ? $query->row()->repair_count : 0;
	}






	public function asset_dispose_tickets()
	{

		$fdate = date('Y-m-d', strtotime($_SESSION['from_date']) + 24 * 60 * 60);
		$tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
		// Select all columns from the 'bf_feedback_asset_creation' table
		$this->db->select("*");
		$this->db->from('bf_feedback_asset_creation');
		$this->db->where('assignstatus', 'Asset Dispose');
		$this->db->where('datetime >=', $tdate);
		$this->db->where('datetime <=', $fdate);
		if ($_SESSION['ward'] !== 'ALL') {
			$this->db->where('locationsite', $_SESSION['ward']);
		}
		// Execute the query
		$query = $this->db->get();

		// Check if the query returns any rows
		if ($query->num_rows() > 0) {
			// Return the result as an array of objects
			$floor_asset = $this->session->userdata['floor_asset'];
			$tickets =  $query->result();
			$outputTickets =  array();
			foreach ($tickets as $row) {
				$dataSet = json_decode($row->dataset);
				$depart = $row->depart;
				if (!in_array($depart, $floor_asset) && !in_array($this->session->user_role, [2, 3])) {
					continue;
				}
				$outputTickets[] = $row;
			}
			return $outputTickets;
		} else {
			// If no data is found, return an empty array or false depending on your need
			return [];
		}
	}




	public function asset_lost_tickets()
	{
		$fdate = date('Y-m-d', strtotime($_SESSION['from_date']) + 24 * 60 * 60);
		$tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
		// Select all columns from the 'bf_feedback_asset_creation' table
		$this->db->select("*");
		$this->db->from('bf_feedback_asset_creation');
		$this->db->where('assignstatus', 'Asset Lost');
		$this->db->where('datetime >=', $tdate);
		$this->db->where('datetime <=', $fdate);
		if ($_SESSION['ward'] !== 'ALL') {
			$this->db->where('locationsite', $_SESSION['ward']);
		}
		// Execute the query
		$query = $this->db->get();

		// Check if the query returns any rows
		if ($query->num_rows() > 0) {
			// Return the result as an array of objects
			$floor_asset = $this->session->userdata['floor_asset'];
			$tickets =  $query->result();
			$outputTickets =  array();
			foreach ($tickets as $row) {
				$dataSet = json_decode($row->dataset);
				$depart = $row->depart;
				if (!in_array($depart, $floor_asset) && !in_array($this->session->user_role, [2, 3])) {
					continue;
				}
				$outputTickets[] = $row;
			}
			return $outputTickets;
		} else {
			// If no data is found, return an empty array or false depending on your need
			return [];
		}
	}



	public function asset_reassign_tickets()
	{
		$fdate = date('Y-m-d', strtotime($_SESSION['from_date']) + 24 * 60 * 60);
		$tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
		// Select all columns from the 'bf_feedback_asset_creation' table
		$this->db->select("*");
		$this->db->from('bf_feedback_asset_creation');
		$this->db->where('assignstatus', 'Asset Reassign');
		$this->db->where('datetime >=', $tdate);
		$this->db->where('datetime <=', $fdate);
		if ($_SESSION['ward'] !== 'ALL') {
			$this->db->where('locationsite', $_SESSION['ward']);
		}
		// Execute the query
		$query = $this->db->get();

		// Check if the query returns any rows
		if ($query->num_rows() > 0) {
			// Return the result as an array of objects
			return $query->result();
		} else {
			// If no data is found, return an empty array or false depending on your need
			return [];
		}
	}



	public function asset_repair_tickets()
	{
		// Select all columns from the 'bf_feedback_asset_creation' table
		$fdate = date('Y-m-d', strtotime($_SESSION['from_date']) + 24 * 60 * 60);
		$tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
		$this->db->select("*");
		$this->db->from('bf_feedback_asset_creation');
		$this->db->where('assignstatus', 'Asset Malfunction');
		// $this->db->where_in('assignstatus', ['Asset Repair', 'Asset Broken']);
		$this->db->where('datetime >=', $tdate);
		$this->db->where('datetime <=', $fdate);
		if ($_SESSION['ward'] !== 'ALL') {
			$this->db->where('locationsite', $_SESSION['ward']);
		}
		// Execute the query
		$query = $this->db->get();

		// Check if the query returns any rows
		if ($query->num_rows() > 0) {
			// Return the result as an array of objects
			$floor_asset = $this->session->userdata['floor_asset'];
			$tickets =  $query->result();
			$outputTickets =  array();
			foreach ($tickets as $row) {
				$dataSet = json_decode($row->dataset);
				$depart = $row->depart;
				if (!in_array($depart, $floor_asset) && !in_array($this->session->user_role, [2, 3])) {
					continue;
				}
				$outputTickets[] = $row;
			}
			return $outputTickets;
		} else {
			// If no data is found, return an empty array or false depending on your need
			return [];
		}
	}

	public function asset_sold_tickets()
	{
		// Select all columns from the 'bf_feedback_asset_creation' table
		$fdate = date('Y-m-d', strtotime($_SESSION['from_date']) + 24 * 60 * 60);
		$tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
		$this->db->select("*");
		$this->db->from('bf_feedback_asset_creation');
		$this->db->where('assignstatus', 'Asset Sold');
		$this->db->where('datetime >=', $tdate);
		$this->db->where('datetime <=', $fdate);
		if ($_SESSION['ward'] !== 'ALL') {
			$this->db->where('locationsite', $_SESSION['ward']);
		}
		// Execute the query
		$query = $this->db->get();

		// Check if the query returns any rows
		if ($query->num_rows() > 0) {
			// Return the result as an array of objects
			$floor_asset = $this->session->userdata['floor_asset'];
			$tickets =  $query->result();
			$outputTickets =  array();
			foreach ($tickets as $row) {
				$dataSet = json_decode($row->dataset);
				$depart = $row->depart;
				if (!in_array($depart, $floor_asset) && !in_array($this->session->user_role, [2, 3])) {
					continue;
				}
				$outputTickets[] = $row;
			}
			return $outputTickets;
		} else {
			// If no data is found, return an empty array or false depending on your need
			return [];
		}
	}



	public function asset_broken_tickets()
	{
		// Select all columns from the 'bf_feedback_asset_creation' table
		$fdate = date('Y-m-d', strtotime($_SESSION['from_date']) + 24 * 60 * 60);
		$tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
		$this->db->select("*");
		$this->db->from('bf_feedback_asset_creation');
		$this->db->where('assignstatus', 'Asset Broken');
		$this->db->where('datetime >=', $tdate);
		$this->db->where('datetime <=', $fdate);
		if ($_SESSION['ward'] !== 'ALL') {
			$this->db->where('locationsite', $_SESSION['ward']);
		}
		// Execute the query
		$query = $this->db->get();

		// Check if the query returns any rows
		if ($query->num_rows() > 0) {
			// Return the result as an array of objects
			$floor_asset = $this->session->userdata['floor_asset'];
			$tickets =  $query->result();
			$outputTickets =  array();
			foreach ($tickets as $row) {
				$dataSet = json_decode($row->dataset);
				$depart = $row->depart;
				if (!in_array($depart, $floor_asset) && $this->session->user_role != 2) {
					continue;
				}
				$outputTickets[] = $row;
			}
			return $outputTickets;
		} else {
			// If no data is found, return an empty array or false depending on your need
			return [];
		}
	}




	public function asset_assign_tickets()
	{
		$email = $this->session->userdata['email'];
		$role = $this->session->userdata['user_role'];

		$fdate = date('Y-m-d', strtotime($_SESSION['from_date']) + 24 * 60 * 60);
		$tdate = date('Y-m-d', strtotime($_SESSION['to_date']));

		// Get the selected users from checkboxes if needed
		$assigned_user_ids = $this->input->post('users_transfer');
		$assigned_user_ids_str = !empty($assigned_user_ids) ? implode(',', $assigned_user_ids) : '';

		$this->db->select('bf_feedback_asset_creation.*, tickets_asset.transfer_approval_status, tickets_asset.transfer_to');
		$this->db->from('bf_feedback_asset_creation');
		$this->db->join('tickets_asset', 'tickets_asset.id = bf_feedback_asset_creation.id', 'right');

		$this->db->group_start();
		$this->db->where("bf_feedback_asset_creation.assignee IS NOT NULL AND bf_feedback_asset_creation.assignee != ''");
		$this->db->or_where("bf_feedback_asset_creation.depart IS NOT NULL AND bf_feedback_asset_creation.depart != ''");
		$this->db->group_end();

		$this->db->where('bf_feedback_asset_creation.datetime >=', $tdate);
		$this->db->where('bf_feedback_asset_creation.datetime <=', $fdate);

		if ($_SESSION['ward'] !== 'ALL') {
			$this->db->where('bf_feedback_asset_creation.locationsite', $_SESSION['ward']);
		}

		// Apply the approval status logic from alltickets()
		if (in_array($role, [2, 3])) {
			$this->db->where_in('tickets_asset.transfer_approval_status', ['approved', 'pending', 'denied']);
		} else {
			$this->db->group_start();
			$this->db->where('tickets_asset.transfer_approval_status', 'approved');

			// OR show denied tickets only if current user is not in the transfer_to list
			$this->db->or_group_start();
			$this->db->where('tickets_asset.transfer_approval_status', 'denied');
			$this->db->where("(tickets_asset.transfer_to IS NULL OR tickets_asset.transfer_to = '' OR FIND_IN_SET(" . $this->session->userdata('user_id') . ", tickets_asset.transfer_to) = 0)");
			$this->db->group_end();

			$this->db->group_end();
		}

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			$floor_asset = $this->session->userdata['floor_asset'];
			$tickets = $query->result();
			$outputTickets = array();

			foreach ($tickets as $row) {
				$dataSet = json_decode($row->dataset);
				$depart = $row->depart;

				if (!in_array($depart, $floor_asset) && !in_array($role, [2, 3])) {
					continue;
				}

				$outputTickets[] = $row;
			}
			return $outputTickets;
		} else {
			return [];
		}
	}

	public function asset_unallocate_tickets()
	{
		$email = $this->session->userdata['email'];
		$role = $this->session->userdata['user_role'];

		$fdate = date('Y-m-d', strtotime($_SESSION['from_date']) + 24 * 60 * 60);
		$tdate = date('Y-m-d', strtotime($_SESSION['to_date']));

		// Get the selected users from checkboxes if needed
		$assigned_user_ids = $this->input->post('users_transfer');
		$assigned_user_ids_str = !empty($assigned_user_ids) ? implode(',', $assigned_user_ids) : '';

		$this->db->select('bf_feedback_asset_creation.*, tickets_asset.transfer_approval_status, tickets_asset.transfer_to');
		$this->db->from('bf_feedback_asset_creation');
		$this->db->join('tickets_asset', 'tickets_asset.id = bf_feedback_asset_creation.id', 'right');

		// Combined conditions for unallocated assets
		$this->db->where_in('bf_feedback_asset_creation.assignstatus', ['Asset Reassign', 'Asset in Use', 'Asset Assign', 'Asset Transfer', 'Pending Transfer']);
		$this->db->where("(bf_feedback_asset_creation.depart IS NULL OR bf_feedback_asset_creation.depart = '')");
		$this->db->where("(bf_feedback_asset_creation.assignee IS NULL OR bf_feedback_asset_creation.assignee = '')");

		$this->db->where('bf_feedback_asset_creation.datetime >=', $tdate);
		$this->db->where('bf_feedback_asset_creation.datetime <=', $fdate);

		if ($_SESSION['ward'] !== 'ALL') {
			$this->db->where('bf_feedback_asset_creation.locationsite', $_SESSION['ward']);
		}

		// Apply the approval status logic from alltickets()
		if (in_array($role, [2, 3])) {
			$this->db->where_in('tickets_asset.transfer_approval_status', ['approved', 'pending', 'denied']);
		} else {
			$this->db->group_start();
			$this->db->where('tickets_asset.transfer_approval_status', 'approved');

			// OR show denied tickets only if current user is not in the transfer_to list
			$this->db->or_group_start();
			$this->db->where('tickets_asset.transfer_approval_status', 'denied');
			$this->db->where("(tickets_asset.transfer_to IS NULL OR tickets_asset.transfer_to = '' OR FIND_IN_SET(" . $this->session->userdata('user_id') . ", tickets_asset.transfer_to) = 0)");
			$this->db->group_end();

			$this->db->group_end();
		}

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			$floor_asset = $this->session->userdata['floor_asset'];
			$tickets = $query->result();
			$outputTickets = array();

			foreach ($tickets as $row) {
				$dataSet = json_decode($row->dataset);
				$depart = $row->depart;

				if (!in_array($depart, $floor_asset) && !in_array($role, [2, 3])) {
					continue;
				}

				$outputTickets[] = $row;
			}
			return $outputTickets;
		} else {
			return [];
		}
	}

	public function asset_use_tickets()
	{
		$email = $this->session->userdata['email'];
		$role = $this->session->userdata['user_role'];

		$fdate = date('Y-m-d', strtotime($_SESSION['from_date']) + 24 * 60 * 60);
		$tdate = date('Y-m-d', strtotime($_SESSION['to_date']));

		// Get the selected users from checkboxes if needed
		$assigned_user_ids = $this->input->post('users_transfer');
		$assigned_user_ids_str = !empty($assigned_user_ids) ? implode(',', $assigned_user_ids) : '';

		$this->db->select('bf_feedback_asset_creation.*, tickets_asset.transfer_approval_status, tickets_asset.transfer_to');
		$this->db->from('bf_feedback_asset_creation');
		$this->db->join('tickets_asset', 'tickets_asset.id = bf_feedback_asset_creation.id', 'right');
		$this->db->where_in('bf_feedback_asset_creation.assignstatus', ['Asset Reassign', 'Asset in Use', 'Asset Assign', 'Asset Transfer', 'Pending Transfer']);

		$this->db->where('bf_feedback_asset_creation.datetime >=', $tdate);
		$this->db->where('bf_feedback_asset_creation.datetime <=', $fdate);

		if ($_SESSION['ward'] !== 'ALL') {
			$this->db->where('bf_feedback_asset_creation.locationsite', $_SESSION['ward']);
		}

		// Apply the same approval status logic from alltickets()
		if (in_array($role, [2, 3])) {
			$this->db->where_in('tickets_asset.transfer_approval_status', ['approved', 'pending', 'denied']);
		} else {
			$this->db->group_start();
			$this->db->where('tickets_asset.transfer_approval_status', 'approved');

			// OR show denied tickets only if current user is not in the transfer_to list
			$this->db->or_group_start();
			$this->db->where('tickets_asset.transfer_approval_status', 'denied');
			$this->db->where("(tickets_asset.transfer_to IS NULL OR tickets_asset.transfer_to = '' OR FIND_IN_SET(" . $this->session->userdata('user_id') . ", tickets_asset.transfer_to) = 0)");
			$this->db->group_end();

			$this->db->group_end();
		}

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			$floor_asset = $this->session->userdata['floor_asset'];
			$tickets = $query->result();
			$outputTickets = array();

			foreach ($tickets as $row) {
				$dataSet = json_decode($row->dataset);
				$depart = $row->depart;

				if (!in_array($depart, $floor_asset) && !in_array($role, [2, 3])) {
					continue;
				}

				$outputTickets[] = $row;
			}
			return $outputTickets;
		} else {
			return [];
		}
	}

	public function asset_transfer_tickets()
	{
		$fdate = date('Y-m-d', strtotime($_SESSION['from_date']) + 24 * 60 * 60);
		$tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
		// Select all columns from the 'bf_feedback_asset_creation' table
		$this->db->select("*");
		$this->db->from('bf_feedback_asset_creation');
		$this->db->where('assignstatus', 'Asset Transfer');
		$this->db->where('datetime >=', $tdate);
		$this->db->where('datetime <=', $fdate);
		if ($_SESSION['ward'] !== 'ALL') {
			$this->db->where('locationsite', $_SESSION['ward']);
		}
		// Execute the query
		$query = $this->db->get();

		// Check if the query returns any rows
		if ($query->num_rows() > 0) {
			// Return the result as an array of objects
			return $query->result();
		} else {
			// If no data is found, return an empty array or false depending on your need
			return [];
		}
	}





	public function asset_warranty_reports()
	{
		$email = $this->session->userdata['email'];
		$role = $this->session->userdata['user_role'];
		// Select all columns from the 'bf_feedback_asset_creation' table
		$fdate = date('Y-m-d', strtotime($_SESSION['from_date']) + 24 * 60 * 60);
		$tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
		$this->db->select("*");
		$this->db->from('bf_feedback_asset_creation');
		$this->db->where('datetime >=', $tdate);
		$this->db->where('datetime <=', $fdate);
		if ($_SESSION['ward'] !== 'ALL') {
			$this->db->where('locationsite', $_SESSION['ward']);
		}

		// Execute the query
		$query = $this->db->get();

		// Check if the query returns any rows
		if ($query->num_rows() > 0) {
			// Return the result as an array of objects
			$floor_asset = $this->session->userdata['floor_asset'];
			$tickets =  $query->result();

			$outputTickets =  array();

			foreach ($tickets as $row) {
				$dataSet = json_decode($row->dataset);
				$depart = $row->depart;
				if (!in_array($depart, $floor_asset) && !in_array($this->session->user_role, [2, 3])) {
					continue;
				}
				$outputTickets[] = $row;
			}
			return $outputTickets;
		} else {
			// If no data is found, return an empty array or false depending on your need
			return [];
		}
	}


	public function asset_contract_reports()
	{
		$email = $this->session->userdata['email'];
		$role = $this->session->userdata['user_role'];
		// Select all columns from the 'bf_feedback_asset_creation' table
		$fdate = date('Y-m-d', strtotime($_SESSION['from_date']) + 24 * 60 * 60);
		$tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
		$this->db->select("*");
		$this->db->from('bf_feedback_asset_creation');
		$this->db->where('datetime >=', $tdate);
		$this->db->where('datetime <=', $fdate);
		if ($_SESSION['ward'] !== 'ALL') {
			$this->db->where('locationsite', $_SESSION['ward']);
		}

		// Execute the query
		$query = $this->db->get();

		// Check if the query returns any rows
		if ($query->num_rows() > 0) {
			// Return the result as an array of objects
			$floor_asset = $this->session->userdata['floor_asset'];
			$tickets =  $query->result();

			$outputTickets =  array();

			foreach ($tickets as $row) {
				$dataSet = json_decode($row->dataset);
				$depart = $row->depart;
				if (!in_array($depart, $floor_asset) && !in_array($this->session->user_role, [2, 3])) {
					continue;
				}
				$outputTickets[] = $row;
			}
			return $outputTickets;
		} else {
			// If no data is found, return an empty array or false depending on your need
			return [];
		}
	}


	public function alltickets()
	{
		$email = $this->session->userdata['email'];
		$role = $this->session->userdata['user_role'];

		// Add your exact date filtering code
		$fdate = date('Y-m-d', strtotime($_SESSION['from_date']) + 24 * 60 * 60);
		$tdate = date('Y-m-d', strtotime($_SESSION['to_date']));



		$this->db->select('bf_feedback_asset_creation.*, tickets_asset.transfer_approval_status, tickets_asset.transfer_to');
		$this->db->from('bf_feedback_asset_creation');
		$this->db->join('tickets_asset', 'tickets_asset.id = bf_feedback_asset_creation.id', 'right');

		// Add your date where clauses exactly as you want them
		$this->db->where('bf_feedback_asset_creation.datetime >=', $tdate);
		$this->db->where('bf_feedback_asset_creation.datetime <=', $fdate);

		if ($_SESSION['ward'] !== 'ALL') {
			$this->db->where('bf_feedback_asset_creation.locationsite', $_SESSION['ward']);
		}

		// If user role is 2 or 3, show 'approved' or 'pending', else only 'approved'
		// 		if (in_array($role, [2, 3])) {
		// 			$this->db->where_in('tickets_asset.transfer_approval_status', ['approved', 'pending', 'denied', 'approved_by_admin']);
		// 		}

		$query = $this->db->get();
		$result = $query->result();

		// echo '<pre>';
		// print_r($result);
		// echo '</pre>';
		// exit;

		$outputTickets = array();
		$floor_asset = $this->session->userdata['floor_asset'];

		//var_dump($floor_asset);
		foreach ($result as $row) {



			if (!in_array($role, [2, 3])) {
				if (!in_array($row->transfer_approval_status, ['approved', 'pending', 'denied', 'approved_by_admin'])) {
					continue;
				}
				$dataSet = json_decode($row->dataset);
				$depart = $row->depart;


				if (!in_array($depart, $floor_asset) && !in_array($role, [2, 3])) {
					continue;
				}
				$outputTickets[] = $row;
			} else {
				$outputTickets[] = $row;
			}
		}
		//exit;
		return $outputTickets;
	}


	public function asset_preventive_tickets()
	{
		$email = $this->session->userdata['email'];
		$role = $this->session->userdata['user_role'];
		// Select all columns from the 'bf_feedback_asset_creation' table
		$fdate = date('Y-m-d', strtotime($_SESSION['from_date']) + 24 * 60 * 60);
		$tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
		$this->db->select("*");
		$this->db->from('bf_feedback_asset_creation');
		$this->db->where('datetime >=', $tdate);
		$this->db->where('datetime <=', $fdate);
		if ($_SESSION['ward'] !== 'ALL') {
			$this->db->where('locationsite', $_SESSION['ward']);
		}

		// Execute the query
		$query = $this->db->get();

		// Check if the query returns any rows
		if ($query->num_rows() > 0) {
			// Return the result as an array of objects
			$floor_asset = $this->session->userdata['floor_asset'];
			$tickets =  $query->result();

			$outputTickets =  array();

			foreach ($tickets as $row) {
				$dataSet = json_decode($row->dataset);
				$depart = $row->depart;
				if (!in_array($depart, $floor_asset) && !in_array($this->session->user_role, [2, 3])) {
					continue;
				}
				$outputTickets[] = $row;
			}
			return $outputTickets;
		} else {
			// If no data is found, return an empty array or false depending on your need
			return [];
		}
	}

	public function asset_calibration_tickets()
	{
		$email = $this->session->userdata['email'];
		$role = $this->session->userdata['user_role'];
		// Select all columns from the 'bf_feedback_asset_creation' table
		$fdate = date('Y-m-d', strtotime($_SESSION['from_date']) + 24 * 60 * 60);
		$tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
		$this->db->select("*");
		$this->db->from('bf_feedback_asset_creation');
		$this->db->where('datetime >=', $tdate);
		$this->db->where('datetime <=', $fdate);
		if ($_SESSION['ward'] !== 'ALL') {
			$this->db->where('locationsite', $_SESSION['ward']);
		}

		// Execute the query
		$query = $this->db->get();

		// Check if the query returns any rows
		if ($query->num_rows() > 0) {
			// Return the result as an array of objects
			$floor_asset = $this->session->userdata['floor_asset'];
			$tickets =  $query->result();

			$outputTickets =  array();

			foreach ($tickets as $row) {
				$dataSet = json_decode($row->dataset);
				$depart = $row->depart;
				if (!in_array($depart, $floor_asset) && !in_array($this->session->user_role, [2, 3])) {
					continue;
				}
				$outputTickets[] = $row;
			}
			return $outputTickets;
		} else {
			// If no data is found, return an empty array or false depending on your need
			return [];
		}
	}




	public function asset_qrcode()
	{
		// Select all columns from the 'bf_feedback_asset_creation' table
		$fdate = date('Y-m-d', strtotime($_SESSION['from_date']) + 24 * 60 * 60);
		$tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
		$this->db->select("*");
		$this->db->from('bf_feedback_asset_creation');
		$this->db->where('datetime >=', $tdate);
		$this->db->where('datetime <=', $fdate);
		if ($_SESSION['ward'] !== 'ALL') {
			$this->db->where('locationsite', $_SESSION['ward']);
		}

		// Execute the query
		$query = $this->db->get();

		// Check if the query returns any rows
		if ($query->num_rows() > 0) {
			// Return the result as an array of objects
			$floor_asset = $this->session->userdata['floor_asset'];
			$tickets =  $query->result();
			$outputTickets =  array();
			foreach ($tickets as $row) {
				$dataSet = json_decode($row->dataset);
				$depart = $row->depart;
				if (!in_array($depart, $floor_asset) && $this->session->user_role != 2) {
					continue;
				}
				$outputTickets[] = $row;
			}
			return $outputTickets;
		} else {
			// If no data is found, return an empty array or false depending on your need
			return [];
		}
	}

	public function asset_financial_metrices()
	{
		// Select all columns from the 'bf_feedback_asset_creation' table
		$fdate = date('Y-m-d', strtotime($_SESSION['from_date']) + 24 * 60 * 60);
		$tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
		$this->db->select("*");
		$this->db->from('bf_feedback_asset_creation');
		$this->db->where('datetime >=', $tdate);
		$this->db->where('datetime <=', $fdate);
		if ($_SESSION['ward'] !== 'ALL') {
			$this->db->where('locationsite', $_SESSION['ward']);
		}

		// Execute the query
		$query = $this->db->get();

		// Check if the query returns any rows
		if ($query->num_rows() > 0) {
			// Return the result as an array of objects
			$floor_asset = $this->session->userdata['floor_asset'];
			$tickets =  $query->result();
			$outputTickets =  array();
			foreach ($tickets as $row) {
				$dataSet = json_decode($row->dataset);
				$depart = $row->depart;
				if (!in_array($depart, $floor_asset) && $this->session->user_role != 2) {
					continue;
				}
				$outputTickets[] = $row;
			}
			return $outputTickets;
		} else {
			// If no data is found, return an empty array or false depending on your need
			return [];
		}
	}

	// public function count_all_ticket_types() {


	//     // Prepare the date range
	//     $fdate = date('Y-m-d', strtotime($_SESSION['from_date']) + 24 * 60 * 60);
	//     $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));

	//     // Fetch all data within the date range
	//     $this->db->select('assignstatus');
	//     $this->db->from('bf_feedback_asset_creation');
	//     $this->db->where('datetime >=', $tdate);
	//     $this->db->where('datetime <=', $fdate);

	//     // Execute the query
	//     $query = $this->db->get();

	//     // Initialize the counters for each ticket type
	//     $ticket_counts = [
	//         'Asset Assign' => 0,
	//         'Asset Broken' => 0,
	//         'Asset Repair' => 0,
	//         'Asset Reassign' => 0,
	//         'Asset Lost' => 0,
	//         'Asset Dispose' => 0
	//     ];

	//     // Check if the query returns any rows
	//     if ($query->num_rows() > 0) {
	//         // Get the results as an array
	//         $results = $query->result_array();

	//         // Iterate through each result and count the statuses
	//         foreach ($results as $row) {
	//             $status = $row['assignstatus'];

	//             // If the status exists in our array, increment its count
	//             if (array_key_exists($status, $ticket_counts)) {
	//                 $ticket_counts[$status]++;
	//             }
	//         }
	//     }

	//     // Return the ticket counts as JSON
	//     return $ticket_counts;
	// }

	// public function alltickets()
	// {

	// 	$email = $this->session->userdata['email'];
	// 	$role = $this->session->userdata['user_role'];
	// 	$fdate = date('Y-m-d', strtotime($_SESSION['from_date']) + 24 * 60 * 60);
	// 	$tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
	// 	//print_r($this->session->userdata);
	// 	$datasetnew = array();
	// 	$i = 0;
	// 	if ($this->input->get('depsec') != 1 && $this->input->get('depsec') != '') {
	// 		$this->db->where('type', 'esr');
	// 		$this->db->where('description', $this->input->get('depsec'));
	// 		$query = $this->db->get('department');
	// 		$result = $query->result();
	// 		foreach ($result as $t) {
	// 			$datasetnew[$i++] = $t->dprt_id;
	// 		}
	// 	}


	// 	$firstname = $this->session->userdata['firstname'];
	// 	$this->db->select("*");
	// 	$this->db->from($this->table);
	// 	//echo '(created_on >= "'.$tdate.'" AND created_on <= "'.$fdate.'")';
	// 	$this->db->where('created_on >=', $tdate);
	// 	$this->db->where('created_on <=', $fdate);


	// 	if ($this->input->get('type') != 1 && $this->input->get('type') != '') {
	// 		$this->db->where('departmentid', $this->input->get('type'));
	// 	} else {
	// 		if (count($datasetnew) > 0) {
	// 			$this->db->where_in('departmentid', $datasetnew);
	// 		}
	// 	}
	// 	$this->db->order_by('id', 'desc');
	// 	$query = $this->db->get();
	// 	$result  = $query->result();
	// 	$dataset = array();

	// 	$i = 0;
	// 	//echo '<pre>';
	// 	foreach ($result as $row) {
	// 		//print_r($row); 
	// 		// $this->db->where('dprt_id', $row->departmentid);
	// 		if ($row->departmentid_trasfered != 0) {
	// 			$this->db->where('dprt_id', $row->departmentid_trasfered);
	// 		} else {
	// 			$this->db->where('dprt_id', $row->departmentid);
	// 		}
	// 		$query = $this->db->get('department');
	// 		$department = $query->result();

	// 		if (isset($_SESSION['ward']) && $_SESSION['ward'] != 'ALL') {
	// 			$this->db->where('bf_feedback_asset_creation.locationsite', $_SESSION['ward']);
	// 		}
	// 		$this->db->where('id', $row->feedbackid);
	// 		$query = $this->db->get('bf_feedback_asset_creation');
	// 		$feedback = $query->result();

	// 		if (count($feedback) == 0) {
	// 			continue;
	// 		}


	// 		$pos = strpos($this->session->userdata['department_access'][$department[0]->type][$department[0]->setkey], $department[0]->slug);

	// 		if ($pos !== false && count($this->session->userdata['department_access'][$department[0]->type]) > 0) {
	// 			//$slug = $row->feedbackid.preg_replace('/[^A-Za-z0-9-]+/', '-', $department[0]->dprt_id);
	// 			$dataset[$i] = $row;


	// 			$dataset[$i] = $row;
	// 			$dataset[$i]->feed = json_decode($feedback[0]->dataset);
	// 			$feed = json_decode($feedback[0]->dataset);
	// 			$dataset[$i]->patinet->name = $feed->name;
	// 			$dataset[$i]->patinet->patient_id = $feed->patientid;
	// 			$dataset[$i]->patinet->mobile = $feed->contactnumber;
	// 			$dataset[$i]->patinet->ward = $feed->ward;
	// 			$dataset[$i]->patinet->bed_no = $feed->bedno;
	// 			$dataset[$i]->patinet->admissiondate = $feed->admissiondate;

	// 			$dataset[$i]->department = $department[0];
	// 			if ($row->rating == 2) {
	// 				$dataset[$i]->ratingt = 'Poor';
	// 			} else {
	// 				$dataset[$i]->ratingt = 'Worst';
	// 			}
	// 		} elseif ($role <= 3) {
	// 			//$slug = $row->feedbackid.preg_replace('/[^A-Za-z0-9-]+/', '-', $department[0]->name);
	// 			$dataset[$i] = $row;
	// 			$dataset[$i]->feed = json_decode($feedback[0]->dataset);
	// 			$feed = json_decode($feedback[0]->dataset);
	// 			$dataset[$i]->patinet->name = $feed->name;
	// 			$dataset[$i]->patinet->patient_id = $feed->patientid;
	// 			$dataset[$i]->patinet->mobile = $feed->contactnumber;
	// 			$dataset[$i]->patinet->ward = $feed->ward;
	// 			$dataset[$i]->patinet->bed_no = $feed->bedno;
	// 			$dataset[$i]->patinet->admissiondate = $feed->admissiondate;

	// 			$dataset[$i]->department = $department[0];
	// 			if ($row->rating == 2) {
	// 				$dataset[$i]->ratingt = 'Poor';
	// 			} else {
	// 				$dataset[$i]->ratingt = 'Worst';
	// 			}
	// 		}
	// 		$i++;
	// 	}

	// 	return $dataset;
	// }


	public function read_close()
	{
		$email = $this->session->userdata['email'];
		$role = $this->session->userdata['user_role'];
		$fdate = date('Y-m-d', strtotime($_SESSION['from_date']) + 24 * 60 * 60);
		$tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
		//print_r($this->session->userdata);
		$datasetnew = array();
		$i = 0;
		if ($this->input->get('depsec') != 1 && $this->input->get('depsec') != '') {
			$this->db->where('type', 'interim');
			$this->db->where('description', $this->input->get('depsec'));
			$query = $this->db->get('department');
			$result = $query->result();
			foreach ($result as $t) {
				$datasetnew[$i++] = $t->dprt_id;
			}
		}


		$firstname = $this->session->userdata['firstname'];
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->where('status', 'closed');
		//echo '(created_on >= "'.$tdate.'" AND created_on <= "'.$fdate.'")';
		$this->db->where('created_on >=', $tdate);
		$this->db->where('created_on <=', $fdate);



		if ($this->input->get('type') != 1 && $this->input->get('type') != '') {
			$this->db->where('departmentid', $this->input->get('type'));
		} else {
			if (count($datasetnew) > 0) {
				$this->db->where_in('departmentid', $datasetnew);
			}
		}
		$this->db->order_by('id', 'desc');
		$query = $this->db->get();
		$result  = $query->result();
		$dataset = array();

		$i = 0;
		//echo '<pre>';
		foreach ($result as $row) {

			// $this->db->where('dprt_id', $row->departmentid);
			if ($row->departmentid_trasfered != 0) {
				$this->db->where('dprt_id', $row->departmentid_trasfered);
			} else {
				$this->db->where('dprt_id', $row->departmentid);
			}

			$query = $this->db->get('department');
			$department = $query->result();
			if (isset($_SESSION['ward']) && $_SESSION['ward'] != 'ALL') {
				// Use ward only if floorwise doesn't exist
				$this->db->where('bf_feedback_asset_creation.locationsite', $_SESSION['ward']);
			} elseif (count($this->session->userdata['floor_ward']) > 0) {
				$floorwiseArray = $this->session->userdata['floor_ward'];
				$this->db->where_in('bf_feedback_asset_creation.locationsite', $floorwiseArray);
			}

			$this->db->where('id', $row->feedbackid);
			$query = $this->db->get('bf_feedback_asset_creation');
			$feedback = $query->result();

			if (count($feedback) == 0) {
				continue;
			}



			$pos = strpos($this->session->userdata['department_access'][$department[0]->type][$department[0]->setkey], $department[0]->slug);

			if ($pos !== false && count($this->session->userdata['department_access'][$department[0]->type]) > 0) {
				//$slug = $row->feedbackid.preg_replace('/[^A-Za-z0-9-]+/', '-', $department[0]->dprt_id);
				$dataset[$i] = $row;
				$dataset[$i]->feed = json_decode($feedback[0]->dataset);
				$feed = json_decode($feedback[0]->dataset);

				$dataset[$i]->patinet->bed_no = $feed->bedno;
				$dataset[$i]->patinet->name = $feed->name;
				$dataset[$i]->patinet->patient_id = $feed->patientid;
				$dataset[$i]->patinet->mobile = $feed->contactnumber;
				$dataset[$i]->patinet->ward = $feed->ward;
				$dataset[$i]->patinet->admissiondate = $feed->admissiondate;
				$dataset[$i]->department = $department[0];
				if ($row->rating == 2) {
					$dataset[$i]->ratingt = 'Poor';
				} else {
					$dataset[$i]->ratingt = 'Worst';
				}
				$this->db->where('ticketid', $row->id);
				$this->db->order_by('id', 'desc');
				$query = $this->db->get('asset_ticket_message');
				$closed = $query->result();
				$dataset[$i]->closed_on = $closed[0]->created_on;
				$dataset[$i]->replymessage = $closed;
			} elseif ($role <= 3) {
				//$slug = $row->feedbackid.preg_replace('/[^A-Za-z0-9-]+/', '-', $department[0]->name);
				$dataset[$i] = $row;
				$dataset[$i]->feed = json_decode($feedback[0]->dataset);
				$feed = json_decode($feedback[0]->dataset);

				$dataset[$i]->patinet->bed_no = $feed->bedno;
				$dataset[$i]->patinet->name = $feed->name;
				$dataset[$i]->patinet->patient_id = $feed->patientid;
				$dataset[$i]->patinet->mobile = $feed->contactnumber;
				$dataset[$i]->patinet->ward = $feed->ward;
				$dataset[$i]->patinet->admissiondate = $feed->admissiondate;
				$dataset[$i]->department = $department[0];
				if ($row->rating == 2) {
					$dataset[$i]->ratingt = 'Poor';
				} else {
					$dataset[$i]->ratingt = 'Worst';
				}
				$this->db->where('ticketid', $row->id);
				$this->db->order_by('id', 'desc');
				$query = $this->db->get('asset_ticket_message');
				$closed = $query->result();
				$dataset[$i]->closed_on = $closed[0]->created_on;
				$dataset[$i]->replymessage = $closed;
			}
			$i++;
		}
		//echo '<pre>';
		//exit;
		//print_r($dataset); exit;

		return $dataset;
	}

	public function read_by_id($id = null)
	{

		$result = $this->db->select("*")
			->from($this->table)
			->where('id', $id)
			->get()
			->result();
		$dataset = array();
		$i = 0;
		foreach ($result as $row) {





			$dataset[$i] = $row;


			$this->db->where('dprt_id', $row->departmentid);
			$query = $this->db->get('department');
			$department = $query->result();
			$dataset[$i]->department = $department[0];
			$this->db->where('ticketid', $row->id);
			$query = $this->db->get('asset_ticket_message');
			$reply = $query->result();
			$dataset[$i]->replymessage = $reply;
			$this->db->where('id', $row->feedbackid);
			$query = $this->db->get('bf_feedback_asset_creation');
			$feedback = $query->result();

			$feed = json_decode($feedback[0]->dataset);
			$dataset[$i]->patinet->bed_no = $feed->bedno;
			$dataset[$i]->patinet->admissiondate = $feed->admissiondate;
			$dataset[$i]->patinet->name = $feed->name;
			$dataset[$i]->patinet->patient_id = $feed->patientid;
			$dataset[$i]->patinet->mobile = $feed->contactnumber;
			$dataset[$i]->patinet->ward = $feed->ward;
			$dataset[$i]->feedback = json_decode($feedback[0]->dataset);
			if ($row->rating == 2) {
				$dataset[$i]->ratingt = 'Poor';
			} else {
				$dataset[$i]->ratingt = 'Worst';
			}
			$i++;
		}
		return $dataset;
	}

	public function update($data = [])
	{
		if ($this->read_by_id($data['guid'])) {
			return $this->db->where('guid', $data['guid'])
				->update($this->table, $data);
		} else {
			return $this->db->insert($this->table, $data);
		}
	}

	public function delete($dprt_id = null)
	{
		$this->db->where('guid', $dprt_id)
			->delete($this->table);

		if ($this->db->affected_rows()) {
			return true;
		} else {
			return false;
		}
	}

	public function department_list()
	{
		$result = $this->db->select("*")
			->from($this->table)
			->where('status', 1)
			->get()
			->result();

		$list[''] = display('select_department');
		if (!empty($result)) {
			foreach ($result as $value) {
				$list[$value->dprt_id] = $value->name;
			}
			return $list;
		} else {
			return false;
		}
	}
}
