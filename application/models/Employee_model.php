<?php defined('BASEPATH') or exit('No direct script access allowed');

class Employee_model extends CI_Model
{

	private $table = "healthcare_employees";

	public function create($data = [])
	{
		// print_r($data);
		$data['guid'] = time();
		return $this->db->insert($this->table, $data);
	}

	public function read()
	{

		$this->db->select("*");
		$this->db->from($this->table);
		if (isset($_SESSION['ward']) && $_SESSION['ward'] != 'ALL') {
			$this->db->where('ward', $_SESSION['ward']);
		}
		// $this->db->where('discharged_date =', 0);
		$this->db->order_by('created_on', 'desc');
		$query = $this->db->get();
		return $query->result();
	}




	// public function readdischarged()
	// {

	// 	$this->db->select("*");
	// 	$this->db->from($this->table);
	// 	$this->db->where('discharged_date !=', 0);

	// 	if (isset($_SESSION['ward']) && $_SESSION['ward'] != 'ALL') {
	// 		$this->db->where('ward', $_SESSION['ward']);
	// 	}
	// 	$this->db->order_by('discharged_date', 'desc');
	// 	$query = $this->db->get();
	// 	return $query->result();
	// }

	public function wardlist()
	{
		return $this->db->select("*")
			->from('bf_roles')
			->order_by('title', 'asc')
			->get()
			->result();
	}

	public function read_by_id($id = null)
	{
		return $this->db->select("*")
			->from($this->table)
			->where('id', $id)
			->get()
			->row();
	}

	public function update($data = [])
	{
		return $this->db->where('id', $data['id'])
			->update($this->table, $data);
	}

	public function delete($id = null)
	{


		$this->db->where('id', $id)
			->delete($this->table);

		if ($this->db->affected_rows()) {
			return true;
		} else {
			return false;
		}
	}

	public function patient_discharge($data = [])
	{
		return $this->db->where('id', $data['id'])
			->update($this->table, $data);
	}
}
