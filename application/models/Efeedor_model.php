<?php defined('BASEPATH') or exit('No direct script access allowed');

class Efeedor_model extends CI_Model
{
	public function get_feedback($table_patient, $table_feedback, $fdate, $tdate)
	{
		$this->db->select(
			$table_feedback . '.*,
						' . $table_patient . '.name as pname,
						' . $table_patient . '.patient_id as pid,
						' . $table_patient . '.ward as ward
						'
		);
		$this->db->from($table_feedback);
		$this->db->join($table_patient, $table_patient . '.patient_id=' . $table_feedback . '.patientid', 'inner');
		if (isset($_SESSION['ward']) && $_SESSION['ward'] != 'ALL') {
			$this->db->where($table_patient . '.ward', $_SESSION['ward']);
			// $this->db->like($table_feedback .'.dataset', $_SESSION['ward'],'both');
		}

		$this->db->where($table_feedback . '.datet <=', $fdate);
		$this->db->where($table_feedback . '.datet >=', $tdate);
		$this->db->order_by('datetime', 'desc');
		$this->db->group_by($table_feedback . '.id');
		$query = $this->db->get();
		$result = $query->result();
		// print_r($result);
		// exit;
		return $result;
	}

	// public function get_feedback($table_patient,$table_feedback,$fdate,$tdate){
	// 	$this->db->select(
	// 					$table_feedback.'.*,
	// 					'.$table_patient.'.name as pname,
	// 					'.$table_patient.'.patient_id as pid,
	// 					'.$table_patient.'.ward as ward
	// 					');
	// 	$this->db->from($table_feedback);
	// 	$this->db->join($table_patient, $table_patient.'.patient_id = '.$table_feedback.'.patientid', 'inner');
	// 	// if (isset($_SESSION['ward']) && $_SESSION['ward'] != 'ALL') {
	// 		$this->db->where($table_feedback.'.ward', $_SESSION['ward']);
	// 	// }

	// 	$this->db->where($table_feedback.'.datet <=', $fdate);
	// 	$this->db->where($table_feedback.'.datet >=', $tdate);
	// 	$this->db->order_by('datetime', 'asc');
	// 	// $this->db->group_by($table_feedback.'.id');
	// 	$query = $this->db->get();
	// 	$result = $query->result();
	// 	return $result;
	// }

	public function get_tickets($table_feedback, $table_tickets, $fdate, $tdate)
	{
		$this->db->select($table_tickets . ".*");
		$this->db->from($table_tickets);
		if (isset($_SESSION['ward']) && $_SESSION['ward'] != 'ALL') {
			$this->db->join($table_feedback, $table_feedback . '.id = ' . $table_tickets . '.feedbackid');
			$this->db->where($table_feedback . '.ward', $_SESSION['ward']);
			// $this->db->like($table_feedback . '.dataset', $_SESSION['ward'],'both');
		}
		$this->db->where($table_tickets . '.created_on <=', $fdate);
		$this->db->where($table_tickets . '.created_on >=', $tdate);
		$this->db->order_by('id', 'desc');
		$query = $this->db->get();
		$tickets = $query->result();
		return $tickets;
	}

	public function get_unsatisfied_count($all_feedback, $all_tickets)
	{
		$unsatisfied = 0;
		foreach ($all_feedback as $row) {
			$check = true;
			foreach ($all_tickets as $t) {
				if ($t->feedbackid == $row->id && $check == true) {
					$unsatisfied = $unsatisfied + 1;
					$check = false;
				}
			}
		}
		return $unsatisfied;
	}


	public function PSAT($all_feedback, $all_tickets)
	{
		$unsatisfied = 0;
		$PSAT = 0;
		foreach ($all_feedback as $row) {
			$check = true;
			foreach ($all_tickets as $t) {
				if ($t->feedbackid == $row->id && $check == true) {
					$unsatisfied = $unsatisfied + 1;
					$check = false;
				}
			}
		}
		if (count($all_feedback) > 0) {
			$PSAT = round(((count($all_feedback) - $unsatisfied) / count($all_feedback)) * 100) * 1;
			return $PSAT;
		} else {
			return 0;
		}
	}

	public function get_satisfied_count($all_feedback, $all_tickets)
	{
		$satisfied = 0;
		foreach ($all_feedback as $row) {
			$check = true;
			foreach ($all_tickets as $t) {
				if ($t->feedbackid == $row->id && $check == true) {
					$check = false;
				}
			}
			if ($check == true) {

				$satisfied = $satisfied + 1;
			}
		}
		return $satisfied;
	}



	public function NPS($all_feedback)
	{
		$permoter = 0;
		$demoter = 0;
		$passive = 0;
		foreach ($all_feedback as $row) {
			$param = json_decode($row->dataset);
			$rating = $param->recommend1Score * 2;
			if ($rating > 8) {
				$permoter++;
			} elseif ($rating >= 7 && $rating <= 8) {
				$passive++;
			} else {
				$demoter++;
			}
		}
		if (count($all_feedback) > 0) {
			$NPS = round((($permoter - $demoter) / count(($all_feedback))) * 100) * 1;
			return $NPS;
		} else {
			return 0;
		}
	}


	public function nps_parameter($all_feedback)
	{
		$permoter = 0;
		$demoter = 0;
		$passive = 0;
		foreach ($all_feedback as $row) {
			$param = json_decode($row->dataset);
			$rating = $param->recommend1Score * 2;
			if ($rating > 8) {
				$permoter++;
			} elseif ($rating >= 7 && $rating <= 8) {
				$passive++;
			} else {
				$demoter++;
			}
		}
		$parameters = array();
		$parameters['permoter'] = $permoter;
		$parameters['demoter'] = $demoter;
		$parameters['passive'] = $passive;
		return $parameters;
	}


	public function ticket_resolution_rate($all_tickets)
	{
		$close_tickets = 0;
		foreach ($all_tickets as $row) {
			if ($row->status == 'Closed') {
				$close_tickets++;
			}
		}
		if (count($all_tickets) > 0) {
			return round(($close_tickets / count($all_tickets)) * 100) * 1;
		} else {
			return 0;
		}
	}

	public function ticket_close_rate($all_tickets)
	{
		$total_time_taken_close_ticket = 0;
		$close_tickets = 0;
		foreach ($all_tickets as $row) {
			if ($row->status == 'Closed') {
				$close_tickets++;
				$total_time_taken_close_ticket += strtotime($row->last_modified) - strtotime($row->created_on);
			}
		}

		return $total_time_taken_close_ticket / $close_tickets;
	}


	public function setup_result($table)
	{
		$this->db->order_by('id');
		$this->db->where('parent', 1);
		$query = $this->db->get($table);
		return $result = $query->result();
	}


	
	public function setup4_result($table)
	{
		$this->db->order_by('id');
		// $this->db->where('parent', 1);
		$query = $this->db->get($table);
		return $result = $query->result();
	}
	public function key_value_setup($table)
	{
		$query = $this->db->get($table);
		$result = $query->result();
		$setup_key_pair = array();
		foreach ($result as $row) {
			$setup_key_pair[$row->shortkey] = $row->question;
		}
		return $setup_key_pair;
	}

	public function get_department_old($type)
	{
		$this->db->where('type', $type);
		$this->db->group_by('description');
		$query = $this->db->get('old_department');
		return $department = $query->result();
	}
	
	public function get_department($type)
	{
		$this->db->where('type', $type);
		$this->db->group_by('description');
		$query = $this->db->get('department');
		return $department = $query->result();
	}


	public function closed_tickets($all_tickets)
	{
		$close_tickets = 0;
		foreach ($all_tickets as $row) {
			if ($row->status == 'Closed') {
				$close_tickets++;
			}
		}
		return $close_tickets;
	}

	public function open_tickets($all_tickets)
	{
		$open_tickets = 0;
		foreach ($all_tickets as $row) {
			if ($row->status != 'Closed') {
				$open_tickets++;
			}
		}
		return $open_tickets;
	}
}
