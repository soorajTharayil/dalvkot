<?php defined('BASEPATH') or exit('No direct script access allowed');

class Questionip_model extends CI_Model
{

	private $table = "setup";

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
		$this->db->order_by('id', 'asc');
		$query = $this->db->get();
		return $query->result();
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

	// public function delete($id = null)
	// {
	// 	$response = $this->db->select("*")
	// 		->from($this->table)
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
	// 			->delete($this->table);

	// 		if ($this->db->affected_rows()) {
	// 			return true;
	// 		} else {
	// 			return false;
	// 		}
	// 	} {
	// 		return false;
	// 	}
	}

	public function patient_discharge($data = [])
	{
		return $this->db->where('id', $data['id'])
			->update($this->table, $data);
	}
}
