<?php defined('BASEPATH') or exit('No direct script access allowed');

class Patient_model extends CI_Model
{

	private $patient_from_admission = "patients_from_admission";
	private $patient_admitted = "patient_admitted";
	private $patient_discharged = "patient_discharge";

	public function create($data = [])
	{

		$data['guid'] = time();
		$response1 = $this->db->insert($this->patient_from_admission, $data);

		$response2 = $this->db->insert($this->patient_admitted, $data);
		if ($response1 && $response2 === true) {
			if ($this->db->affected_rows()) {
				return true;
			} else {
				return false;
			}
		} else {

			return false;
		}
	}

	public function read()
	{
		// $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
		// $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));

		$this->db->select("*");
		$this->db->from($this->patient_from_admission);
		if (isset($_SESSION['ward']) && $_SESSION['ward'] != 'ALL') {
			$this->db->where('ward', $_SESSION['ward']);
		}
		// $this->db->where('created_on <=', $fdate);
		// $this->db->where('created_on >=', $tdate);
		$this->db->order_by('id', 'asc');
		$query = $this->db->get();
		return $query->result();
	}


	public function readdischarged()
	{
		// $fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
		// $tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
		if (isset($_SESSION['ward']) && $_SESSION['ward'] != 'ALL') {
			$this->db->where('ward', $_SESSION['ward']);
		}

		return $this->db->select("*")
			->from($this->patient_discharged)
			// ->where('created_by !=', NULL)
			// ->where('updated_by !=', NULL)
			// ->order_by('discharged_date', 'desc')
			// ->where('created_on <=', $fdate)
			// ->where('created_on >=', $tdate)
			->limit(500)
			->get()
			->result();
	}

	public function wardlist()
	{
		return $this->db->select("*")
			->from('bf_ward')
			->order_by('title', 'asc')
			->get()
			->result();
	}

	public function read_by_id($id = null)
	{
		return $this->db->select("*")
			->from($this->patient_from_admission)
			->where('id', $id)
			->get()
			->row();
	}

	public function update($data = [])
	{
		return $this->db->where('id', $data['id'])
			->update($this->patient_from_admission, $data);
	}

	// public function delete($id = null)
	// {
	// 	$response = $this->db->select("*")
	// 		->from($this->patient_from_admisadmitted)
	// 		->where('id', $id)
	// 		->get()
	// 		->row();

	// 	$response2 = $this->db->select("*")
	// 		->from('bf_nursing_handover')
	// 		->where('patientid', $response->patient_id)
	// 		->get()
	// 		->row();
	// 	//count($response2);
	// 	if (count($response2) == 0) {

	// 		$this->db->where('id', $id)
	// 			->delete($this->patient_admitted);

	// 		if ($this->db->affected_rows()) {
	// 			return true;
	// 		} else {
	// 			return false;
	// 		}
	// 	} {
	// 		return false;
	// 	}
	// }

	public function set_discharge($id = null)
	{
		if ($id === null) {
			return;
		}


		$data = $this->db->select("*")
			->from($this->patient_from_admission)
			->where('patient_id', $id)
			->get()
			->row_array();
		// Check if data is not null
		if ($data === null) {
			return;
		} else {
			$data['datedischarged'] = date('Y-m-d H:i:s');
			$data['check_status'] = 'active';
			$data['email_status'] = '0';

			// Insert the patient data to the patient_discharged table
			$this->db->insert($this->patient_discharged, $data);

			// Delete the patient from the patient_from_admission table
			$this->db->where('patient_id', $id)
				->delete($this->patient_from_admission);
			return true;
		}
	}

	public function dama($id = null)
	{
		if ($id === null) {
			return;
		}


		$data = $this->db->select("*")
			->from($this->patient_from_admission)
			->where('patient_id', $id)
			->get()
			->row_array();
		// Check if data is not null
		if ($data === null) {
			return;
		} else {
			$data['datedischarged'] = date('Y-m-d H:i:s');
			$data['check_status'] = 'inactive';
			$data['messagestatus'] = "2";

			// Insert the patient data to the patient_discharged table
			$this->db->insert($this->patient_discharged, $data);

			// Delete the patient from the patient_from_admission table
			$this->db->where('patient_id', $id)
				->delete($this->patient_from_admission);
			return true;
		}
	}
}
