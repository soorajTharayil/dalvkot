<?php defined('BASEPATH') or exit('No direct script access allowed');

class Ticketsesr_model extends CI_Model
{

	private $table = 'tickets_esr';

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
			$this->db->where('type', 'esr');
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
				$this->db->where('bf_feedback_esr.ward', $_SESSION['ward']);
			}elseif (count($this->session->userdata['floor_ward_esr']) > 0) {
				$floorwiseArray = $this->session->userdata['floor_ward_esr'];
				$this->db->where_in('bf_feedback_esr.ward', $floorwiseArray);
			}
			$this->db->where('id', $row->feedbackid);
			$query = $this->db->get('bf_feedback_esr');
			$feedback = $query->result();

			if (count($feedback) == 0) {
				continue;
			}


			$pos = strpos($this->session->userdata['department_access'][$department[0]->type][$department[0]->setkey], $department[0]->slug);
				
			if (($pos !== false && count($this->session->userdata['department_access'][$department[0]->type]) > 0 ) || $row->assign_to == $this->session->userdata['user_id']) {
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
	public function assignedtickets()
	{
		$email = $this->session->userdata['email'];
		$role = $this->session->userdata['user_role'];
		$fdate = date('Y-m-d', strtotime($_SESSION['from_date']) + 24 * 60 * 60);
		$tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
		//print_r($this->session->userdata);
		$datasetnew = array();
		$i = 0;
		if ($this->input->get('depsec') != 1 && $this->input->get('depsec') != '') {
			$this->db->where('type', 'esr');
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
		$this->db->where('status', 'Assigned');
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
				$this->db->where('bf_feedback_esr.ward', $_SESSION['ward']);
			}elseif (count($this->session->userdata['floor_ward_esr']) > 0) {
				$floorwiseArray = $this->session->userdata['floor_ward_esr'];
				$this->db->where_in('bf_feedback_esr.ward', $floorwiseArray);
			}
			$this->db->where('id', $row->feedbackid);
			$query = $this->db->get('bf_feedback_esr');
			$feedback = $query->result();

			if (count($feedback) == 0) {
				continue;
			}


			$pos = strpos($this->session->userdata['department_access'][$department[0]->type][$department[0]->setkey], $department[0]->slug);
				
			if (($pos !== false && count($this->session->userdata['department_access'][$department[0]->type]) > 0 ) || $row->assign_to == $this->session->userdata['user_id']) {
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
		$i = 0;
		if ($this->input->get('depsec') != 1 && $this->input->get('depsec') != '') {
			$this->db->where('type', 'esr');
			$this->db->where('description', $this->input->get('depsec'));
			$query = $this->db->get('department');
			$result = $query->result();
			foreach ($result as $t) {
				$datasetnew[$i++] = $t->dprt_id;
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
				$this->db->where('bf_feedback_esr.ward', $_SESSION['ward']);
			}elseif (count($this->session->userdata['floor_ward_esr']) > 0) {
				$floorwiseArray = $this->session->userdata['floor_ward_esr'];
				$this->db->where_in('bf_feedback_esr.ward', $floorwiseArray);
			}
			$this->db->where('id', $row->feedbackid);
			$query = $this->db->get('bf_feedback_esr');
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
		$i = 0;
		if ($this->input->get('depsec') != 1 && $this->input->get('depsec') != '') {
			$this->db->where('type', 'esr');
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
				$this->db->where('bf_feedback_esr.ward', $_SESSION['ward']);
			}elseif (count($this->session->userdata['floor_ward_esr']) > 0) {
				$floorwiseArray = $this->session->userdata['floor_ward_esr'];
				$this->db->where_in('bf_feedback_esr.ward', $floorwiseArray);
			}
			$this->db->where('id', $row->feedbackid);
			$query = $this->db->get('bf_feedback_esr');
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
			} elseif ($role <= 20)  {
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
			$this->db->where('type', 'esr');
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
				$this->db->where('bf_feedback_esr.ward', $_SESSION['ward']);
			}elseif (count($this->session->userdata['floor_ward_esr']) > 0) {
				$floorwiseArray = $this->session->userdata['floor_ward_esr'];
				$this->db->where_in('bf_feedback_esr.ward', $floorwiseArray);
			}
			$this->db->where('id', $row->feedbackid);
			$query = $this->db->get('bf_feedback_esr');
			$feedback = $query->result();

			if (count($feedback) == 0) {
				continue;
			}

			$pos = strpos($this->session->userdata['department_access'][$department[0]->type][$department[0]->setkey], $department[0]->slug);
				
			if (($pos !== false && count($this->session->userdata['department_access'][$department[0]->type]) > 0 ) || $row->assign_to == $this->session->userdata['user_id']) {
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
		$i = 0;
		if ($this->input->get('depsec') != 1 && $this->input->get('depsec') != '') {
			$this->db->where('type', 'esr');
			$this->db->where('description', $this->input->get('depsec'));
			$query = $this->db->get('department');
			$result = $query->result();
			foreach ($result as $t) {
				$datasetnew[$i++] = $t->dprt_id;
			}
		}

		$empid = $this->session->userdata['departmenthead']->empid;
		$firstname = $this->session->userdata['firstname'];
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->where('status', 'Open');
		$this->db->where('created_on >=', $tdate);
		$this->db->where('created_on <=', $fdate);
		$this->db->where('created_by', $empid);


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
				$this->db->where('bf_feedback_esr.ward', $_SESSION['ward']);
			}elseif (count($this->session->userdata['floor_ward_esr']) > 0) {
				$floorwiseArray = $this->session->userdata['floor_ward_esr'];
				$this->db->where_in('bf_feedback_esr.ward', $floorwiseArray);
			}
			$this->db->where('id', $row->feedbackid);
			$query = $this->db->get('bf_feedback_esr');
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
		//print_r($this->session->userdata);
		$datasetnew = array();
		$i = 0;
		if ($this->input->get('depsec') != 1 && $this->input->get('depsec') != '') {
			$this->db->where('type', 'esr');
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
		//echo '(created_on >= "'.$tdate.'" AND created_on <= "'.$fdate.'")';
		$this->db->where('created_on >=', $tdate);
		$this->db->where('created_on <=', $fdate);
		// if (in_array($this->session->userdata['user_role'], [4,10, 11])) {
	
		// 		 $this->db->or_where('assign_to', $this->session->userdata['user_id']); // Assigned tickets
		// 		$this->db->or_like('assign_to', $this->session->userdata['user_id']); // Partial match for assigned
		
		// }

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
		//echo count($result); exit;
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
				$this->db->where('bf_feedback_esr.ward', $_SESSION['ward']);
			}elseif (count($this->session->userdata['floor_ward_esr']) > 0) {
				$floorwiseArray = $this->session->userdata['floor_ward_esr'];
				$this->db->where_in('bf_feedback_esr.ward', $floorwiseArray);
			}
			$this->db->where('id', $row->feedbackid);
			$query = $this->db->get('bf_feedback_esr');
			$feedback = $query->result();

			if (count($feedback) == 0) {
				continue;
			}
			//echo '<pre>';
			//print_r($row); exit;
			$pos = strpos($this->session->userdata['department_access'][$department[0]->type][$department[0]->setkey], $department[0]->slug);
				
			if (($pos !== false && count($this->session->userdata['department_access'][$department[0]->type]) > 0 ) || $row->assign_to == $this->session->userdata['user_id']) {
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
	public function alltickets_individual_user()
	{
		$email = $this->session->userdata['email'];
		$role = $this->session->userdata['user_role'];
		$fdate = date('Y-m-d', strtotime($_SESSION['from_date']) + 24 * 60 * 60);
		$tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
		//print_r($this->session->userdata);
		$datasetnew = array();
		$i = 0;
		if ($this->input->get('depsec') != 1 && $this->input->get('depsec') != '') {
			$this->db->where('type', 'esr');
			$this->db->where('description', $this->input->get('depsec'));
			$query = $this->db->get('department');
			$result = $query->result();
			foreach ($result as $t) {
				$datasetnew[$i++] = $t->dprt_id;
			}
		}
		$empid = $this->session->userdata['departmenthead']->empid;

		$firstname = $this->session->userdata['firstname'];
		$this->db->select("*");
		$this->db->from($this->table);
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
				$this->db->where('bf_feedback_esr.ward', $_SESSION['ward']);
			}elseif (count($this->session->userdata['floor_ward_esr']) > 0) {
				$floorwiseArray = $this->session->userdata['floor_ward_esr'];
				$this->db->where_in('bf_feedback_esr.ward', $floorwiseArray);
			}
			$this->db->where('id', $row->feedbackid);
			$query = $this->db->get('bf_feedback_esr');
			$feedback = $query->result();

			if (count($feedback) == 0) {
				continue;
			}	
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
		$i = 0;
		if ($this->input->get('depsec') != 1 && $this->input->get('depsec') != '') {
			$this->db->where('type', 'esr');
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
				$this->db->where('bf_feedback_esr.ward', $_SESSION['ward']);
			}elseif (count($this->session->userdata['floor_ward_esr']) > 0) {
				$floorwiseArray = $this->session->userdata['floor_ward_esr'];
				$this->db->where_in('bf_feedback_esr.ward', $floorwiseArray);
			}
			$this->db->where('id', $row->feedbackid);
			$query = $this->db->get('bf_feedback_esr');
			$feedback = $query->result();

			if (count($feedback) == 0) {
				continue;
			}



			$pos = strpos($this->session->userdata['department_access'][$department[0]->type][$department[0]->setkey], $department[0]->slug);
				
			if (($pos !== false && count($this->session->userdata['department_access'][$department[0]->type]) > 0 ) || $row->assign_to == $this->session->userdata['user_id']) {
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
				$query = $this->db->get('ticket_esr_message');
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
				$query = $this->db->get('ticket_esr_message');
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
		$i = 0;
		if ($this->input->get('depsec') != 1 && $this->input->get('depsec') != '') {
			$this->db->where('type', 'esr');
			$this->db->where('description', $this->input->get('depsec'));
			$query = $this->db->get('department');
			$result = $query->result();
			foreach ($result as $t) {
				$datasetnew[$i++] = $t->dprt_id;
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
				$this->db->where('bf_feedback_esr.ward', $_SESSION['ward']);
			}elseif (count($this->session->userdata['floor_ward_esr']) > 0) {
				$floorwiseArray = $this->session->userdata['floor_ward_esr'];
				$this->db->where_in('bf_feedback_esr.ward', $floorwiseArray);
			}
			$this->db->where('id', $row->feedbackid);
			$query = $this->db->get('bf_feedback_esr');
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
				
				$this->db->where('ticketid', $row->id);
				$this->db->order_by('id', 'desc');
				$query = $this->db->get('ticket_esr_message');
				$closed = $query->result();
				$dataset[$i]->closed_on = $closed[0]->created_on;
				$dataset[$i]->replymessage = $closed;

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
			$query = $this->db->get('ticket_esr_message');
			$reply = $query->result();
			$dataset[$i]->replymessage = $reply;
			$this->db->where('id', $row->feedbackid);
			$query = $this->db->get('bf_feedback_esr');
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
