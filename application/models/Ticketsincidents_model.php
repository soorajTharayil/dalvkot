<?php defined('BASEPATH') or exit('No direct script access allowed');

class Ticketsincidents_model extends CI_Model
{

	private $table = 'tickets_incident';

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
		$datasetnew_severity = array();
		$datasetnew_priority = array();
		$i = 0;
		$j = 0;
		$k = 0;
		if ($this->input->get('depsec') != 1 && $this->input->get('depsec') != '') {
			$this->db->where('type', 'incident');
			$this->db->where('description', $this->input->get('depsec'));
			$query = $this->db->get('department');
			$result = $query->result();
			foreach ($result as $t) {
				$datasetnew[$i++] = $t->dprt_id;
			}
		}
		if ($this->input->get('depsec_severity') != 1 && $this->input->get('depsec_severity') != '') {
			$this->db->order_by('title');
			$this->db->where('title', $this->input->get('depsec_severity'));
			$query = $this->db->get('incident_type');
			$result = $query->result();
			foreach ($result as $t) {
				$datasetnew_severity[$j++] = $t->title;
			}
		}
		if ($this->input->get('depsec_priority') != 1 && $this->input->get('depsec_priority') != '') {
			$this->db->order_by('title');
			$this->db->where('title', $this->input->get('depsec_priority'));
			$query = $this->db->get('priority');
			$result = $query->result();
			foreach ($result as $t) {
				$datasetnew_priority[$k++] = $t->title;
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
			if (count($datasetnew_severity) > 0) {
				$this->db->where_in('incident_type', $datasetnew_severity);
			}
			if (count($datasetnew_priority) > 0) {
				$this->db->where_in('priority', $datasetnew_priority);
			}
		}

		$this->db->order_by('id', 'desc');
		$query = $this->db->get();
		$result = $query->result();
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
				$this->db->where('bf_feedback_incident.ward', $_SESSION['ward']);
			} elseif (count($this->session->userdata['floor_ward_esr']) > 0) {
				$floorwiseArray = $this->session->userdata['floor_ward_esr'];
				$this->db->where_in('bf_feedback_incident.ward', $floorwiseArray);
			}
			$this->db->where('id', $row->feedbackid);
			$query = $this->db->get('bf_feedback_incident');
			$feedback = $query->result();

			if (count($feedback) == 0) {
				continue;
			}




			$assignToArray = explode(',', $row->assign_to); // Convert CSV to array

			$reassignToArray = explode(',', $row->reassign_to);

			$currentUserId = $this->session->userdata['user_id']; // Get the current user ID

			$pos = strpos($this->session->userdata['department_access'][$department[0]->type][$department[0]->setkey], $department[0]->slug);


			if (
				($pos !== false && count($this->session->userdata['department_access'][$department[0]->type]) > 0)
				|| in_array($currentUserId, $assignToArray) // Check if user ID exists in assign_to
				|| in_array($currentUserId, $reassignToArray)
			) {	//$slug = $row->feedbackid.preg_replace('/[^A-Za-z0-9-]+/', '-', $department[0]->dprt_id);
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
			} elseif ($role <= 3 || $role == 11) {
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

	public function assignedtickets_individual_user()
	{
		$email = $this->session->userdata['email'];
		$role = $this->session->userdata['user_role'];
		$fdate = date('Y-m-d', strtotime($_SESSION['from_date']) + 24 * 60 * 60);
		$tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
		//print_r($this->session->userdata);
		$datasetnew = array();
		$datasetnew_severity = array();
		$datasetnew_priority = array();
		$i = 0;
		$j = 0;
		$k = 0;
		if ($this->input->get('depsec') != 1 && $this->input->get('depsec') != '') {
			$this->db->where('type', 'incident');
			$this->db->where('description', $this->input->get('depsec'));
			$query = $this->db->get('department');
			$result = $query->result();
			foreach ($result as $t) {
				$datasetnew[$i++] = $t->dprt_id;
			}
		}
		if ($this->input->get('depsec_severity') != 1 && $this->input->get('depsec_severity') != '') {
			$this->db->order_by('title');
			$this->db->where('title', $this->input->get('depsec_severity'));
			$query = $this->db->get('incident_type');
			$result = $query->result();
			foreach ($result as $t) {
				$datasetnew_severity[$j++] = $t->title;
			}
		}
		if ($this->input->get('depsec_priority') != 1 && $this->input->get('depsec_priority') != '') {
			$this->db->order_by('title');
			$this->db->where('title', $this->input->get('depsec_priority'));
			$query = $this->db->get('priority');
			$result = $query->result();
			foreach ($result as $t) {
				$datasetnew_priority[$k++] = $t->title;
			}
		}

		$empid = $this->session->userdata['departmenthead']->empid;

		$firstname = $this->session->userdata['firstname'];
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->where('status', 'Assigned');
		//echo '(created_on >= "'.$tdate.'" AND created_on <= "'.$fdate.'")';
		$this->db->where('created_on >=', $tdate);
		$this->db->where('created_on <=', $fdate);
		$this->db->where('created_by', $empid);




		if ($this->input->get('type') != 1 && $this->input->get('type') != '') {
			$this->db->where('departmentid', $this->input->get('type'));
		} else {
			if (count($datasetnew) > 0) {
				$this->db->where_in('departmentid', $datasetnew);
			}
			if (count($datasetnew_severity) > 0) {
				$this->db->where_in('incident_type', $datasetnew_severity);
			}
			if (count($datasetnew_priority) > 0) {
				$this->db->where_in('priority', $datasetnew_priority);
			}
		}

		$this->db->order_by('id', 'desc');
		$query = $this->db->get();
		$result = $query->result();
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
				$this->db->where('bf_feedback_incident.ward', $_SESSION['ward']);
			} elseif (count($this->session->userdata['floor_ward_esr']) > 0) {
				$floorwiseArray = $this->session->userdata['floor_ward_esr'];
				$this->db->where_in('bf_feedback_incident.ward', $floorwiseArray);
			}
			$this->db->where('id', $row->feedbackid);
			$query = $this->db->get('bf_feedback_incident');
			$feedback = $query->result();

			if (count($feedback) == 0) {
				continue;
			}



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

			$i++;
		}

		return $dataset;
	}


	public function describetickets()
	{
		$email = $this->session->userdata['email'];
		$role = $this->session->userdata['user_role'];
		$fdate = date('Y-m-d', strtotime($_SESSION['from_date']) + 24 * 60 * 60);
		$tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
		//print_r($this->session->userdata);
		$datasetnew = array();
		$datasetnew_severity = array();
		$datasetnew_priority = array();
		$i = 0;
		$j = 0;
		$k = 0;
		if ($this->input->get('depsec') != 1 && $this->input->get('depsec') != '') {
			$this->db->where('type', 'incident');
			$this->db->where('description', $this->input->get('depsec'));
			$query = $this->db->get('department');
			$result = $query->result();
			foreach ($result as $t) {
				$datasetnew[$i++] = $t->dprt_id;
			}
		}
		if ($this->input->get('depsec_severity') != 1 && $this->input->get('depsec_severity') != '') {
			$this->db->order_by('title');
			$this->db->where('title', $this->input->get('depsec_severity'));
			$query = $this->db->get('incident_type');
			$result = $query->result();
			foreach ($result as $t) {
				$datasetnew_severity[$j++] = $t->title;
			}
		}
		if ($this->input->get('depsec_priority') != 1 && $this->input->get('depsec_priority') != '') {
			$this->db->order_by('title');
			$this->db->where('title', $this->input->get('depsec_priority'));
			$query = $this->db->get('priority');
			$result = $query->result();
			foreach ($result as $t) {
				$datasetnew_priority[$k++] = $t->title;
			}
		}


		$firstname = $this->session->userdata['firstname'];
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->where('status', 'Described');
		//echo '(created_on >= "'.$tdate.'" AND created_on <= "'.$fdate.'")';
		$this->db->where('created_on >=', $tdate);
		$this->db->where('created_on <=', $fdate);



		if ($this->input->get('type') != 1 && $this->input->get('type') != '') {
			$this->db->where('departmentid', $this->input->get('type'));
		} else {
			if (count($datasetnew) > 0) {
				$this->db->where_in('departmentid', $datasetnew);
			}
			if (count($datasetnew_severity) > 0) {
				$this->db->where_in('incident_type', $datasetnew_severity);
			}
			if (count($datasetnew_priority) > 0) {
				$this->db->where_in('priority', $datasetnew_priority);
			}
		}

		$this->db->order_by('id', 'desc');
		$query = $this->db->get();
		$result = $query->result();
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
				$this->db->where('bf_feedback_incident.ward', $_SESSION['ward']);
			} elseif (count($this->session->userdata['floor_ward_esr']) > 0) {
				$floorwiseArray = $this->session->userdata['floor_ward_esr'];
				$this->db->where_in('bf_feedback_incident.ward', $floorwiseArray);
			}
			$this->db->where('id', $row->feedbackid);
			$query = $this->db->get('bf_feedback_incident');
			$feedback = $query->result();

			if (count($feedback) == 0) {
				continue;
			}




			$assignToArray = explode(',', $row->assign_to); // Convert CSV to array

			$reassignToArray = explode(',', $row->reassign_to);

			$currentUserId = $this->session->userdata['user_id']; // Get the current user ID

			$pos = strpos($this->session->userdata['department_access'][$department[0]->type][$department[0]->setkey], $department[0]->slug);


			if (
				($pos !== false && count($this->session->userdata['department_access'][$department[0]->type]) > 0)
				|| in_array($currentUserId, $assignToArray) // Check if user ID exists in assign_to
				|| in_array($currentUserId, $reassignToArray)
			) {	//$slug = $row->feedbackid.preg_replace('/[^A-Za-z0-9-]+/', '-', $department[0]->dprt_id);
				$dataset[$i] = $row;


				$dataset[$i] = $row;
				$dataset[$i]->feed = json_decode($feedback[0]->dataset);
				$feed = json_decode($feedback[0]->dataset);
				$dataset[$i]->patinet = new stdClass();  // initialize as empty object
				$dataset[$i]->patinet->name = $feed->name ?? null;
				$dataset[$i]->patinet->patient_id = $feed->patientid ?? null;
				$dataset[$i]->patinet->mobile = $feed->contactnumber ?? null;
				$dataset[$i]->patinet->ward = $feed->ward ?? null;
				$dataset[$i]->patinet->bed_no = $feed->bedno ?? null;
				$dataset[$i]->patinet->admissiondate = $feed->admissiondate ?? null;

				$dataset[$i]->department = $department[0];
				if ($row->rating == 2) {
					$dataset[$i]->ratingt = 'Poor';
				} else {
					$dataset[$i]->ratingt = 'Worst';
				}
			} elseif ($role <= 3 || $role == 11) {
				//$slug = $row->feedbackid.preg_replace('/[^A-Za-z0-9-]+/', '-', $department[0]->name);
				$dataset[$i] = $row;
				$dataset[$i]->feed = json_decode($feedback[0]->dataset);
				$feed = json_decode($feedback[0]->dataset);
				$dataset[$i]->patinet = new stdClass();  // initialize as empty object
				$dataset[$i]->patinet->name = $feed->name ?? null;
				$dataset[$i]->patinet->patient_id = $feed->patientid ?? null;
				$dataset[$i]->patinet->mobile = $feed->contactnumber ?? null;
				$dataset[$i]->patinet->ward = $feed->ward ?? null;
				$dataset[$i]->patinet->bed_no = $feed->bedno ?? null;
				$dataset[$i]->patinet->admissiondate = $feed->admissiondate ?? null;

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
		$datasetnew_severity = array();
		$datasetnew_assigned_risk = array();
		$i = 0;
		$j = 0;
		$k = 0;
		$m = 0;
		if ($this->input->get('depsec') != 1 && $this->input->get('depsec') != '') {
			$this->db->where('type', 'incident');
			$this->db->where('description', $this->input->get('depsec'));
			$query = $this->db->get('department');
			$result = $query->result();
			foreach ($result as $t) {
				$datasetnew[$i++] = $t->dprt_id;
			}
		}
		if ($this->input->get('depsec_severity') != 1 && $this->input->get('depsec_severity') != '') {
			$this->db->order_by('title');
			$this->db->where('title', $this->input->get('depsec_severity'));
			$query = $this->db->get('incident_type');
			$result = $query->result();
			foreach ($result as $t) {
				$datasetnew_severity[$j++] = $t->title;
			}
		}
		if ($this->input->get('depsec_priority') != 1 && $this->input->get('depsec_priority') != '') {
			$this->db->order_by('title');
			$this->db->where('title', $this->input->get('depsec_priority'));
			$query = $this->db->get('priority');
			$result = $query->result();
			foreach ($result as $t) {
				$datasetnew_priority[$k++] = $t->title;
			}
		}
		if ($this->input->get('depsec_assigned_risk') != 1 && $this->input->get('depsec_assigned_risk') != '') {
			$this->db->order_by('title');
			$this->db->where('title', $this->input->get('depsec_assigned_risk'));
			$query = $this->db->get('assigned_risk');
			$result = $query->result();
			foreach ($result as $t) {
				$datasetnew_assigned_risk[$m++] = $t->title;
			}
		}

		$likeStringFirst = $this->session->userdata['user_id'] . ',';

		$likeStringSecond = ',' . $this->session->userdata['user_id'];
		$firstname = $this->session->userdata['firstname'];
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->where('status !=', 'Closed');
		$this->db->where('status !=', 'Addressed');
		$this->db->where('status !=', 'Rejected');
		$this->db->where('status !=', 'Deleted'); // Add this line to exclude 'Deleted' status
		//echo '(created_on >= "'.$tdate.'" AND created_on <= "'.$fdate.'")';
		$this->db->where('created_on >=', $tdate);
		$this->db->where('created_on <=', $fdate);
		// if (in_array($this->session->userdata['user_role'], [1, 2, 3, 11])) {
		// 	// $this->db->or_like('assign_to',$likeStringFirst);
		// 	// $this->db->or_like('assign_to',$likeStringSecond);
		// } else {
		// 	$this->db->where('assign_to', $this->session->userdata['user_id']);
		// 	$this->db->or_like('assign_to', $this->session->userdata['user_id']);
		// }

		// if (in_array($this->session->userdata['user_role'], [1, 2, 3, 11])) {
		// 	// print_r($this->session->userdata);
		// 	// exit;
		// 	//$this->db->or_where('assign_to',$likeStringFirst);
		// 	//$this->db->or_like('assign_to',$likeStringSecond);
		// 	//$this->db->or_like('assign_b',$likeStringFirst);
		// } else {
		// 	// print_r($this->session->userdata);
		// 	// exit;
		// 	$this->db->where('reassign_to', $this->session->userdata['user_id']);
		// 	$this->db->or_like('reassign_to', $this->session->userdata['user_id']);
		// }
		if ($this->input->get('type') != 1 && $this->input->get('type') != '') {
			$this->db->where('departmentid', $this->input->get('type'));
		} else {
			if (count($datasetnew) > 0) {
				$this->db->where_in('departmentid', $datasetnew);
			}
			if (count($datasetnew_severity) > 0) {
				$this->db->where_in('incident_type', $datasetnew_severity);
			}
			if (count($datasetnew_priority) > 0) {
				$this->db->where_in('priority', $datasetnew_priority);
			}
			if (count($datasetnew_assigned_risk) > 0) {
				$this->db->where_in('assigned_risk', $datasetnew_assigned_risk);
			}
		}

		$this->db->order_by('id', 'desc');
		$query = $this->db->get();
		$result = $query->result();
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
				$this->db->where('bf_feedback_incident.ward', $_SESSION['ward']);
			} elseif (count($this->session->userdata['floor_ward_esr']) > 0) {
				$floorwiseArray = $this->session->userdata['floor_ward_esr'];
				$this->db->where_in('bf_feedback_incident.ward', $floorwiseArray);
			}
			$this->db->where('id', $row->feedbackid);
			$query = $this->db->get('bf_feedback_incident');
			$feedback = $query->result();

			if (count($feedback) == 0) {
				continue;
			}

			$assignToArray = explode(',', $row->assign_to);
			$reassignToArray = explode(',', $row->reassign_to);
			$assignToArray_for_process_monitor = explode(',', $row->assign_for_process_monitor);
			$assignToArray_for_team_member = explode(',', $row->assign_for_team_member);
			$currentUserId = $this->session->userdata['user_id']; // Get the current user ID


			$pos = strpos($this->session->userdata['department_access'][$department[0]->type][$department[0]->setkey], $department[0]->slug);


			if (
				($pos !== false && count($this->session->userdata['department_access'][$department[0]->type]) > 0)
				|| in_array($currentUserId, $assignToArray) // Check if user ID exists in assign_to
				|| in_array($currentUserId, $reassignToArray)
				|| in_array($currentUserId, $assignToArray_for_process_monitor)
				|| in_array($currentUserId, $assignToArray_for_team_member)
			) {	//$slug = $row->feedbackid.preg_replace('/[^A-Za-z0-9-]+/', '-', $department[0]->dprt_id);
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
			} elseif ($role <= 3 || $role == 11) {
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
	public function read_individual_user()
	{
		$email = $this->session->userdata['email'];
		$role = $this->session->userdata['user_role'];
		$fdate = date('Y-m-d', strtotime($_SESSION['from_date']) + 24 * 60 * 60);
		$tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
		//print_r($this->session->userdata);
		$datasetnew = array();
		$datasetnew_severity = array();
		$datasetnew_priority = array();
		$i = 0;
		$j = 0;
		$k = 0;
		if ($this->input->get('depsec') != 1 && $this->input->get('depsec') != '') {
			$this->db->where('type', 'incident');
			$this->db->where('description', $this->input->get('depsec'));
			$query = $this->db->get('department');
			$result = $query->result();
			foreach ($result as $t) {
				$datasetnew[$i++] = $t->dprt_id;
			}
		}
		if ($this->input->get('depsec_severity') != 1 && $this->input->get('depsec_severity') != '') {
			$this->db->order_by('title');
			$this->db->where('title', $this->input->get('depsec_severity'));
			$query = $this->db->get('incident_type');
			$result = $query->result();
			foreach ($result as $t) {
				$datasetnew_severity[$j++] = $t->title;
			}
		}
		if ($this->input->get('depsec_priority') != 1 && $this->input->get('depsec_priority') != '') {
			$this->db->order_by('title');
			$this->db->where('title', $this->input->get('depsec_priority'));
			$query = $this->db->get('priority');
			$result = $query->result();
			foreach ($result as $t) {
				$datasetnew_priority[$k++] = $t->title;
			}
		}

		$likeStringFirst = $this->session->userdata['user_id'] . ',';

		$likeStringSecond = ',' . $this->session->userdata['user_id'];
		$empid = $this->session->userdata['departmenthead']->empid;

		$firstname = $this->session->userdata['firstname'];
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->where('status', 'Open');
		$this->db->where('created_on >=', $tdate);
		$this->db->where('created_on <=', $fdate);
		$this->db->where('created_by', $empid);

		// if (in_array($this->session->userdata['user_role'], [1, 2, 3, 11])) {
		// 	// $this->db->or_like('assign_to',$likeStringFirst);
		// 	// $this->db->or_like('assign_to',$likeStringSecond);
		// } else {
		// 	$this->db->where('assign_to', $this->session->userdata['user_id']);
		// 	$this->db->or_like('assign_to', $this->session->userdata['user_id']);
		// }

		// if (in_array($this->session->userdata['user_role'], [1, 2, 3, 11])) {
		// 	// print_r($this->session->userdata);
		// 	// exit;
		// 	//$this->db->or_where('assign_to',$likeStringFirst);
		// 	//$this->db->or_like('assign_to',$likeStringSecond);
		// 	//$this->db->or_like('assign_b',$likeStringFirst);
		// } else {
		// 	// print_r($this->session->userdata);
		// 	// exit;
		// 	$this->db->where('reassign_to', $this->session->userdata['user_id']);
		// 	$this->db->or_like('reassign_to', $this->session->userdata['user_id']);
		// }
		if ($this->input->get('type') != 1 && $this->input->get('type') != '') {
			$this->db->where('departmentid', $this->input->get('type'));
		} else {
			if (count($datasetnew) > 0) {
				$this->db->where_in('departmentid', $datasetnew);
			}
			if (count($datasetnew_severity) > 0) {
				$this->db->where_in('incident_type', $datasetnew_severity);
			}
			if (count($datasetnew_priority) > 0) {
				$this->db->where_in('priority', $datasetnew_priority);
			}
		}

		$this->db->order_by('id', 'desc');
		$query = $this->db->get();
		$result = $query->result();
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
				$this->db->where('bf_feedback_incident.ward', $_SESSION['ward']);
			} elseif (count($this->session->userdata['floor_ward_esr']) > 0) {
				$floorwiseArray = $this->session->userdata['floor_ward_esr'];
				$this->db->where_in('bf_feedback_incident.ward', $floorwiseArray);
			}
			$this->db->where('id', $row->feedbackid);
			$query = $this->db->get('bf_feedback_incident');
			$feedback = $query->result();

			if (count($feedback) == 0) {
				continue;
			}


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

			$i++;
		}
		return $dataset;
	}


	public function rejecttickets()
	{
		$email = $this->session->userdata['email'];
		$role = $this->session->userdata['user_role'];
		$fdate = date('Y-m-d', strtotime($_SESSION['from_date']) + 24 * 60 * 60);
		$tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
		//print_r($this->session->userdata);
		$datasetnew = array();
		$datasetnew_severity = array();
		$datasetnew_priority = array();
		$i = 0;
		$j = 0;
		$k = 0;
		if ($this->input->get('depsec') != 1 && $this->input->get('depsec') != '') {
			$this->db->where('type', 'incident');
			$this->db->where('description', $this->input->get('depsec'));
			$query = $this->db->get('department');
			$result = $query->result();
			foreach ($result as $t) {
				$datasetnew[$i++] = $t->dprt_id;
			}
		}
		if ($this->input->get('depsec_severity') != 1 && $this->input->get('depsec_severity') != '') {
			$this->db->order_by('title');
			$this->db->where('title', $this->input->get('depsec_severity'));
			$query = $this->db->get('incident_type');
			$result = $query->result();
			foreach ($result as $t) {
				$datasetnew_severity[$j++] = $t->title;
			}
		}
		if ($this->input->get('depsec_priority') != 1 && $this->input->get('depsec_priority') != '') {
			$this->db->order_by('title');
			$this->db->where('title', $this->input->get('depsec_priority'));
			$query = $this->db->get('priority');
			$result = $query->result();
			foreach ($result as $t) {
				$datasetnew_priority[$k++] = $t->title;
			}
		}


		$firstname = $this->session->userdata['firstname'];
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->where('status', 'Rejected');
		//echo '(created_on >= "'.$tdate.'" AND created_on <= "'.$fdate.'")';
		$this->db->where('created_on >=', $tdate);
		$this->db->where('created_on <=', $fdate);



		if ($this->input->get('type') != 1 && $this->input->get('type') != '') {
			$this->db->where('departmentid', $this->input->get('type'));
		} else {
			if (count($datasetnew) > 0) {
				$this->db->where_in('departmentid', $datasetnew);
			}
			if (count($datasetnew_severity) > 0) {
				$this->db->where_in('incident_type', $datasetnew_severity);
			}
			if (count($datasetnew_priority) > 0) {
				$this->db->where_in('priority', $datasetnew_priority);
			}
		}
		$this->db->order_by('id', 'desc');
		$query = $this->db->get();
		$result = $query->result();
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
				$this->db->where('bf_feedback_incident.ward', $_SESSION['ward']);
			} elseif (count($this->session->userdata['floor_ward_esr']) > 0) {
				$floorwiseArray = $this->session->userdata['floor_ward_esr'];
				$this->db->where_in('bf_feedback_incident.ward', $floorwiseArray);
			}
			$this->db->where('id', $row->feedbackid);
			$query = $this->db->get('bf_feedback_incident');
			$feedback = $query->result();

			if (count($feedback) == 0) {
				continue;
			}


			$assignToArray = explode(',', $row->assign_to); // Convert CSV to array
			$currentUserId = $this->session->userdata['user_id']; // Get the current user ID

			$pos = strpos($this->session->userdata['department_access'][$department[0]->type][$department[0]->setkey], $department[0]->slug);


			if (
				($pos !== false && count($this->session->userdata['department_access'][$department[0]->type]) > 0)
				|| in_array($currentUserId, $assignToArray) // Check if user ID exists in assign_to
				|| $row->reassign_to == $currentUserId
			) { //$slug = $row->feedbackid.preg_replace('/[^A-Za-z0-9-]+/', '-', $department[0]->dprt_id);
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
			} elseif ($role <= 3 || $role == 11) {
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


	public function alltickets()
	{
		$email = $this->session->userdata['email'];
		$role = $this->session->userdata['user_role'];
		$fdate = date('Y-m-d', strtotime($_SESSION['from_date']) + 24 * 60 * 60);
		$tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
		//print_r($this->session->userdata); exit;
		$datasetnew = array();
		$datasetnew_severity = array();
		$datasetnew_priority = array();
		$datasetnew_assigned_risk = array();
		$datasetnew_incident_status = array();
		$datasetnew_incident_assigned_status = array();
		$i = 0;
		$j = 0;
		$k = 0;
		$m = 0;
		$n = 0;
		$o = 0;
		if ($this->input->get('depsec') != 1 && $this->input->get('depsec') != '') {
			$this->db->where('type', 'incident');
			$this->db->where('description', $this->input->get('depsec'));
			$query = $this->db->get('department');
			$result = $query->result();
			foreach ($result as $t) {
				$datasetnew[$i++] = $t->dprt_id;
			}
		}
		if ($this->input->get('depsec_severity') != 1 && $this->input->get('depsec_severity') != '') {
			$this->db->order_by('title');
			$this->db->where('title', $this->input->get('depsec_severity'));
			$query = $this->db->get('incident_type');
			$result = $query->result();
			foreach ($result as $t) {
				$datasetnew_severity[$j++] = $t->title;
			}
		}
		if ($this->input->get('depsec_priority') != 1 && $this->input->get('depsec_priority') != '') {
			$this->db->order_by('title');
			$this->db->where('title', $this->input->get('depsec_priority'));
			$query = $this->db->get('priority');
			$result = $query->result();
			foreach ($result as $t) {
				$datasetnew_priority[$k++] = $t->title;
			}
		}
		if ($this->input->get('depsec_assigned_risk') != 1 && $this->input->get('depsec_assigned_risk') != '') {
			$this->db->order_by('title');
			$this->db->where('title', $this->input->get('depsec_assigned_risk'));
			$query = $this->db->get('assigned_risk');
			$result = $query->result();
			foreach ($result as $t) {
				$datasetnew_assigned_risk[$m++] = $t->title;
			}
		}
		if ($this->input->get('depsec_incident_status') != 1 && $this->input->get('depsec_incident_status') != '') {
			$this->db->order_by('title');
			$this->db->where('title', $this->input->get('depsec_incident_status'));
			$query = $this->db->get('incident_status');
			$result = $query->result();
			foreach ($result as $t) {
				$datasetnew_incident_status[$n++] = $t->title;
			}
		}
		if ($this->input->get('depsec_incident_assigned_status') != 1 && $this->input->get('depsec_incident_assigned_status') != '') {
			$this->db->order_by('smallname');
			$this->db->where('smallname', $this->input->get('depsec_incident_assigned_status'));
			$query = $this->db->get('incident_assigned_status');
			$result = $query->result();
			foreach ($result as $t) {
				$datasetnew_incident_assigned_status[$o++] = $t->smallname;
			}
		}

		$likeStringFirst = $this->session->userdata['user_id'];

		$likeStringSecond = ',' . $this->session->userdata['user_id'];
		$firstname = $this->session->userdata['firstname'];
		$this->db->select("*");
		$this->db->from($this->table);
		//echo '(created_on >= "'.$tdate.'" AND created_on <= "'.$fdate.'")';
		$this->db->where('created_on >=', $tdate);
		$this->db->where('created_on <=', $fdate);

		$this->db->where('status !=', 'Deleted'); // Add this line to exclude 'Deleted' status
		//print_r($this->session->userdata); exit;
		// if (in_array($this->session->userdata['user_role'], [1, 2, 3, 11])) {
		// 	// print_r($this->session->userdata);
		// 	// exit;
		// 	//$this->db->or_where('assign_to',$likeStringFirst);
		// 	//$this->db->or_like('assign_to',$likeStringSecond);
		// 	//$this->db->or_like('assign_b',$likeStringFirst);
		// } else {
		// 	// print_r($this->session->userdata);
		// 	// exit;
		// 	$this->db->where('assign_to', $this->session->userdata['user_id']);
		// 	$this->db->or_like('assign_to', $this->session->userdata['user_id']);
		// }

		// if (in_array($this->session->userdata['user_role'], [1, 2, 3, 11])) {
		// 	// print_r($this->session->userdata);
		// 	// exit;
		// 	//$this->db->or_where('assign_to',$likeStringFirst);
		// 	//$this->db->or_like('assign_to',$likeStringSecond);
		// 	//$this->db->or_like('assign_b',$likeStringFirst);
		// } else {
		// 	// print_r($this->session->userdata);
		// 	// exit;
		// 	$this->db->where('reassign_to', $this->session->userdata['user_id']);
		// 	$this->db->or_like('reassign_to', $this->session->userdata['user_id']);
		// }


		if ($this->input->get('type') != 1 && $this->input->get('type') != '') {
			$this->db->where('departmentid', $this->input->get('type'));
		} else {
			if (count($datasetnew ?? []) > 0) {
				$this->db->where_in('departmentid', $datasetnew);
			}
			if (count($datasetnew_severity ?? []) > 0) {
				$this->db->where_in('incident_type', $datasetnew_severity);
			}
			if (count($datasetnew_priority ?? []) > 0) {
				$this->db->where_in('priority', $datasetnew_priority);
			}
			if (count($datasetnew_assigned_risk ?? []) > 0) {
				$this->db->where_in('assigned_risk', $datasetnew_assigned_risk);
			}
			if (count($datasetnew_incident_status ?? []) > 0) {
				$this->db->where_in('status', $datasetnew_incident_status);
			}
			if (count($datasetnew_incident_assigned_status ?? []) > 0) {
				$this->db->where_in('status', $datasetnew_incident_assigned_status);
			}
		}
		$this->db->order_by('id', 'desc');
		$query = $this->db->get();
		$result = $query->result();

		//print_r($result); exit;
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
				$this->db->where('bf_feedback_incident.ward', $_SESSION['ward']);
			} elseif (count($this->session->userdata['floor_ward_esr']) > 0) {
				$floorwiseArray = $this->session->userdata['floor_ward_esr'];
				$this->db->where_in('bf_feedback_incident.ward', $floorwiseArray);
			}

			$this->db->where('id', $row->feedbackid);
			$query = $this->db->get('bf_feedback_incident');
			$feedback = $query->result();

			if (count($feedback) == 0) {
				continue;
			}
			//echo '<pre>';
			//print_r($this->session->userdata);


			$assignToArray = explode(',', $row->assign_to);
			$reassignToArray = explode(',', $row->reassign_to);
			$assignToArray_for_process_monitor = explode(',', $row->assign_for_process_monitor);
			$assignToArray_for_team_member = explode(',', $row->assign_for_team_member);
			$currentUserId = $this->session->userdata['user_id']; // Get the current user ID


			$pos = strpos($this->session->userdata['department_access'][$department[0]->type][$department[0]->setkey], $department[0]->slug);


			if (
				($pos !== false && count($this->session->userdata['department_access'][$department[0]->type]) > 0)
				|| in_array($currentUserId, $assignToArray) // Check if user ID exists in assign_to
				|| in_array($currentUserId, $reassignToArray)
				|| in_array($currentUserId, $assignToArray_for_process_monitor)
				|| in_array($currentUserId, $assignToArray_for_team_member)
			) {	//$slug = $row->feedbackid.preg_replace('/[^A-Za-z0-9-]+/', '-', $department[0]->dprt_id);
				$dataset[$i] = $row;


				$dataset[$i] = $row;
				$dataset[$i]->feed = json_decode($feedback[0]->dataset);
				$feed = json_decode($feedback[0]->dataset);
				$dataset[$i]->patinet = new stdClass();  // initialize as empty object
				$dataset[$i]->patinet->name = $feed->name ?? null;
				$dataset[$i]->patinet->patient_id = $feed->patientid ?? null;
				$dataset[$i]->patinet->mobile = $feed->contactnumber ?? null;
				$dataset[$i]->patinet->ward = $feed->ward ?? null;
				$dataset[$i]->patinet->bed_no = $feed->bedno ?? null;
				$dataset[$i]->patinet->admissiondate = $feed->admissiondate ?? null;

				$dataset[$i]->department = $department[0];
				if ($row->rating == 2) {
					$dataset[$i]->ratingt = 'Poor';
				} else {
					$dataset[$i]->ratingt = 'Worst';
				}
			} elseif ($role <= 3 || $role == 11) {
				//$slug = $row->feedbackid.preg_replace('/[^A-Za-z0-9-]+/', '-', $department[0]->name);
				$dataset[$i] = $row;
				$dataset[$i]->feed = json_decode($feedback[0]->dataset);
				$feed = json_decode($feedback[0]->dataset);
				$dataset[$i]->patinet = new stdClass();  // initialize as empty object
				$dataset[$i]->patinet->name = $feed->name ?? null;
				$dataset[$i]->patinet->patient_id = $feed->patientid ?? null;
				$dataset[$i]->patinet->mobile = $feed->contactnumber ?? null;
				$dataset[$i]->patinet->ward = $feed->ward ?? null;
				$dataset[$i]->patinet->bed_no = $feed->bedno ?? null;
				$dataset[$i]->patinet->admissiondate = $feed->admissiondate ?? null;

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

	public function alltickets_individual_user()
	{
		$email = $this->session->userdata['email'];
		$role = $this->session->userdata['user_role'];
		$fdate = date('Y-m-d', strtotime($_SESSION['from_date']) + 24 * 60 * 60);
		$tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
		//print_r($this->session->userdata); exit;
		$datasetnew = array();
		$datasetnew_severity = array();
		$datasetnew_priority = array();
		$i = 0;
		$j = 0;
		$k = 0;
		if ($this->input->get('depsec') != 1 && $this->input->get('depsec') != '') {
			$this->db->where('type', 'incident');
			$this->db->where('description', $this->input->get('depsec'));
			$query = $this->db->get('department');
			$result = $query->result();
			foreach ($result as $t) {
				$datasetnew[$i++] = $t->dprt_id;
			}
		}
		if ($this->input->get('depsec_priority') != 1 && $this->input->get('depsec_priority') != '') {
			$this->db->order_by('title');
			$this->db->where('title', $this->input->get('depsec_priority'));
			$query = $this->db->get('priority');
			$result = $query->result();
			foreach ($result as $t) {
				$datasetnew_priority[$k++] = $t->title;
			}
		}
		if ($this->input->get('depsec_severity') != 1 && $this->input->get('depsec_severity') != '') {
			$this->db->order_by('title');
			$this->db->where('title', $this->input->get('depsec_severity'));
			$query = $this->db->get('incident_type');
			$result = $query->result();
			foreach ($result as $t) {
				$datasetnew_severity[$j++] = $t->title;
			}
		}
		if ($this->input->get('depsec_assigned_risk') != 1 && $this->input->get('depsec_assigned_risk') != '') {
			$this->db->order_by('title');
			$this->db->where('title', $this->input->get('depsec_assigned_risk'));
			$query = $this->db->get('assigned_risk');
			$result = $query->result();
			foreach ($result as $t) {
				$datasetnew_severity[$j++] = $t->title;
			}
		}


		$likeStringFirst = $this->session->userdata['user_id'];

		$likeStringSecond = ',' . $this->session->userdata['user_id'];
		$empid = $this->session->userdata['departmenthead']->empid;

		$firstname = $this->session->userdata['firstname'];
		$this->db->select("*");
		$this->db->from($this->table);
		//echo '(created_on >= "'.$tdate.'" AND created_on <= "'.$fdate.'")';
		$this->db->where('created_on >=', $tdate);
		$this->db->where('created_on <=', $fdate);
		$this->db->where('created_by', $empid);

		$this->db->where('status !=', 'Deleted'); // Add this line to exclude 'Deleted' status
		//print_r($this->session->userdata); exit;
		// if (in_array($this->session->userdata['user_role'], [1, 2, 3, 11])) {
		// 	// print_r($this->session->userdata);
		// 	// exit;
		// 	//$this->db->or_where('assign_to',$likeStringFirst);
		// 	//$this->db->or_like('assign_to',$likeStringSecond);
		// 	//$this->db->or_like('assign_b',$likeStringFirst);
		// } else {
		// 	// print_r($this->session->userdata);
		// 	// exit;
		// 	$this->db->where('assign_to', $this->session->userdata['user_id']);
		// 	$this->db->or_like('assign_to', $this->session->userdata['user_id']);
		// }

		// if (in_array($this->session->userdata['user_role'], [1, 2, 3, 11])) {
		// 	// print_r($this->session->userdata);
		// 	// exit;
		// 	//$this->db->or_where('assign_to',$likeStringFirst);
		// 	//$this->db->or_like('assign_to',$likeStringSecond);
		// 	//$this->db->or_like('assign_b',$likeStringFirst);
		// } else {
		// 	// print_r($this->session->userdata);
		// 	// exit;
		// 	$this->db->where('reassign_to', $this->session->userdata['user_id']);
		// 	$this->db->or_like('reassign_to', $this->session->userdata['user_id']);
		// }


		if ($this->input->get('type') != 1 && $this->input->get('type') != '') {
			$this->db->where('departmentid', $this->input->get('type'));
		} else {
			if (count($datasetnew) > 0) {
				$this->db->where_in('departmentid', $datasetnew);
			}
			if (count($datasetnew_severity) > 0) {
				$this->db->where_in('incident_type', $datasetnew_severity);
			}
			if (count($datasetnew_priority) > 0) {
				$this->db->where_in('priority', $datasetnew_priority);
			}
		}
		$this->db->order_by('id', 'desc');
		$query = $this->db->get();
		$result = $query->result();

		//print_r($result); exit;
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
				$this->db->where('bf_feedback_incident.ward', $_SESSION['ward']);
			} elseif (count($this->session->userdata['floor_ward_esr']) > 0) {
				$floorwiseArray = $this->session->userdata['floor_ward_esr'];
				$this->db->where_in('bf_feedback_incident.ward', $floorwiseArray);
			}

			$this->db->where('id', $row->feedbackid);
			$query = $this->db->get('bf_feedback_incident');
			$feedback = $query->result();

			if (count($feedback) == 0) {
				continue;
			}
			//echo '<pre>';
			//print_r($this->session->userdata);



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


			$i++;
		}

		return $dataset;
	}



	public function read_close()
	{
		$email = $this->session->userdata['email'];
		$role = $this->session->userdata['user_role'];
		$fdate = date('Y-m-d', strtotime($_SESSION['from_date']) + 24 * 60 * 60);
		$tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
		//print_r($this->session->userdata);
		$datasetnew = array();
		$datasetnew_severity = array();
		$datasetnew_priority = array();
		$i = 0;
		$j = 0;
		$k = 0;
		if ($this->input->get('depsec') != 1 && $this->input->get('depsec') != '') {
			$this->db->where('type', 'incident');
			$this->db->where('description', $this->input->get('depsec'));
			$query = $this->db->get('department');
			$result = $query->result();
			foreach ($result as $t) {
				$datasetnew[$i++] = $t->dprt_id;
			}
		}
		// if (in_array($this->session->userdata['user_role'], [1, 2, 3, 11])) {
		// 	// print_r($this->session->userdata);
		// 	// exit;
		// 	//$this->db->or_where('assign_to',$likeStringFirst);
		// 	//$this->db->or_like('assign_to',$likeStringSecond);
		// 	//$this->db->or_like('assign_b',$likeStringFirst);
		// } else {
		// 	// print_r($this->session->userdata);
		// 	// exit;
		// 	$this->db->where('assign_to', $this->session->userdata['user_id']);
		// 	$this->db->or_like('assign_to', $this->session->userdata['user_id']);
		// }
		if ($this->input->get('depsec_severity') != 1 && $this->input->get('depsec_severity') != '') {
			$this->db->order_by('title');
			$this->db->where('title', $this->input->get('depsec_severity'));
			$query = $this->db->get('incident_type');
			$result = $query->result();
			foreach ($result as $t) {
				$datasetnew_severity[$j++] = $t->title;
			}
		}
		if ($this->input->get('depsec_priority') != 1 && $this->input->get('depsec_priority') != '') {
			$this->db->order_by('title');
			$this->db->where('title', $this->input->get('depsec_priority'));
			$query = $this->db->get('priority');
			$result = $query->result();
			foreach ($result as $t) {
				$datasetnew_priority[$k++] = $t->title;
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
			if (count($datasetnew_severity) > 0) {
				$this->db->where_in('incident_type', $datasetnew_severity);
			}
			if (count($datasetnew_priority) > 0) {
				$this->db->where_in('priority', $datasetnew_priority);
			}
		}
		$this->db->order_by('id', 'desc');
		$query = $this->db->get();
		$result = $query->result();
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
				$this->db->where('bf_feedback_incident.ward', $_SESSION['ward']);
			} elseif (count($this->session->userdata['floor_ward_esr']) > 0) {
				$floorwiseArray = $this->session->userdata['floor_ward_esr'];
				$this->db->where_in('bf_feedback_incident.ward', $floorwiseArray);
			}
			$this->db->where('id', $row->feedbackid);
			$query = $this->db->get('bf_feedback_incident');
			$feedback = $query->result();

			if (count($feedback) == 0) {
				continue;
			}


			$assignToArray = explode(',', $row->assign_to);
			$reassignToArray = explode(',', $row->reassign_to);
			$assignToArray_for_process_monitor = explode(',', $row->assign_for_process_monitor);
			$assignToArray_for_team_member = explode(',', $row->assign_for_team_member);
			$currentUserId = $this->session->userdata['user_id']; // Get the current user ID


			$pos = strpos($this->session->userdata['department_access'][$department[0]->type][$department[0]->setkey], $department[0]->slug);


			if (
				($pos !== false && count($this->session->userdata['department_access'][$department[0]->type]) > 0)
				|| in_array($currentUserId, $assignToArray) // Check if user ID exists in assign_to
				|| in_array($currentUserId, $reassignToArray)
				|| in_array($currentUserId, $assignToArray_for_process_monitor)
				|| in_array($currentUserId, $assignToArray_for_team_member)
			) { //$slug = $row->feedbackid.preg_replace('/[^A-Za-z0-9-]+/', '-', $department[0]->dprt_id);
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
				$query = $this->db->get('ticket_incident_message');
				$closed = $query->result();
				$dataset[$i]->closed_on = $closed[0]->created_on;
				$dataset[$i]->replymessage = $closed;
			} elseif ($role <= 3 || $role == 11) {
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
				$query = $this->db->get('ticket_incident_message');
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

	public function read_close_individual_user()
	{
		$email = $this->session->userdata['email'];
		$role = $this->session->userdata['user_role'];
		$fdate = date('Y-m-d', strtotime($_SESSION['from_date']) + 24 * 60 * 60);
		$tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
		//print_r($this->session->userdata);
		$datasetnew = array();
		$datasetnew_severity = array();
		$datasetnew_priority = array();
		$i = 0;
		$j = 0;
		$k = 0;
		if ($this->input->get('depsec') != 1 && $this->input->get('depsec') != '') {
			$this->db->where('type', 'incident');
			$this->db->where('description', $this->input->get('depsec'));
			$query = $this->db->get('department');
			$result = $query->result();
			foreach ($result as $t) {
				$datasetnew[$i++] = $t->dprt_id;
			}
		}
		// if (in_array($this->session->userdata['user_role'], [1, 2, 3, 11])) {
		// 	// print_r($this->session->userdata);
		// 	// exit;
		// 	//$this->db->or_where('assign_to',$likeStringFirst);
		// 	//$this->db->or_like('assign_to',$likeStringSecond);
		// 	//$this->db->or_like('assign_b',$likeStringFirst);
		// } else {
		// 	// print_r($this->session->userdata);
		// 	// exit;
		// 	$this->db->where('assign_to', $this->session->userdata['user_id']);
		// 	$this->db->or_like('assign_to', $this->session->userdata['user_id']);
		// }
		if ($this->input->get('depsec_severity') != 1 && $this->input->get('depsec_severity') != '') {
			$this->db->order_by('title');
			$this->db->where('title', $this->input->get('depsec_severity'));
			$query = $this->db->get('incident_type');
			$result = $query->result();
			foreach ($result as $t) {
				$datasetnew_severity[$j++] = $t->title;
			}
		}
		if ($this->input->get('depsec_priority') != 1 && $this->input->get('depsec_priority') != '') {
			$this->db->order_by('title');
			$this->db->where('title', $this->input->get('depsec_priority'));
			$query = $this->db->get('priority');
			$result = $query->result();
			foreach ($result as $t) {
				$datasetnew_priority[$k++] = $t->title;
			}
		}

		$empid = $this->session->userdata['departmenthead']->empid;
		$firstname = $this->session->userdata['firstname'];
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->where('status', 'closed');
		//echo '(created_on >= "'.$tdate.'" AND created_on <= "'.$fdate.'")';
		$this->db->where('created_on >=', $tdate);
		$this->db->where('created_on <=', $fdate);
		$this->db->where('created_by', $empid);



		if ($this->input->get('type') != 1 && $this->input->get('type') != '') {
			$this->db->where('departmentid', $this->input->get('type'));
		} else {
			if (count($datasetnew) > 0) {
				$this->db->where_in('departmentid', $datasetnew);
			}
			if (count($datasetnew_severity) > 0) {
				$this->db->where_in('incident_type', $datasetnew_severity);
			}
			if (count($datasetnew_priority) > 0) {
				$this->db->where_in('priority', $datasetnew_priority);
			}
		}
		$this->db->order_by('id', 'desc');
		$query = $this->db->get();
		$result = $query->result();
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
				$this->db->where('bf_feedback_incident.ward', $_SESSION['ward']);
			} elseif (count($this->session->userdata['floor_ward_esr']) > 0) {
				$floorwiseArray = $this->session->userdata['floor_ward_esr'];
				$this->db->where_in('bf_feedback_incident.ward', $floorwiseArray);
			}
			$this->db->where('id', $row->feedbackid);
			$query = $this->db->get('bf_feedback_incident');
			$feedback = $query->result();

			if (count($feedback) == 0) {
				continue;
			}



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
			$query = $this->db->get('ticket_incident_message');
			$reply = $query->result();
			$dataset[$i]->replymessage = $reply;
			$this->db->where('id', $row->feedbackid);
			$query = $this->db->get('bf_feedback_incident');
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
	public function update_rca_details($id, $data)
	{
		$this->db->where('id', $id);
		return $this->db->update('ticket_incident_message', $data);
	}

	public function update_closed_rca($id, $data)
	{
		$this->db->where('id', $id);
		return $this->db->update('ticket_incident_message', $data);
	}

	public function get_by_id($id)
	{
		return $this->db->where('id', $id)
			->get('ticket_incident_message')   // ← change table name if different
			->row();
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
