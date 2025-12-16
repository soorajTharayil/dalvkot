<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Opatient_model extends CI_Model {

	private $table = "bf_opatients";

	public function create($data = [])
	{
		$data['guid'] = time();
		return $this->db->insert($this->table,$data);
	}

	public function read()
	{

		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->where('admited_date',0);

		if(isset($_SESSION['ward']) && $_SESSION['ward'] != 'ALL'){
			$this->db->where('ward',$_SESSION['ward']);
		}
		$this->db->order_by('admited_date','desc');
		$query = $this->db->get();
		return $query->result();
	}

	public function readdischarged()
	{
		if(isset($_SESSION['ward']) && $_SESSION['ward'] != 'ALL'){
			$this->db->where('ward',$_SESSION['ward']);
		}
		return $this->db->select("*")
			->from($this->table)
			->where('admited_date  <',date('Y-m-d'))
			->order_by('admited_date','desc')
			->limit(500)
			->get()
			->result();
	}

	public function wardlist(){
		return $this->db->select("*")
			->from('bf_departmentop')
			->order_by('title','asc')
			->get()
			->result();
	}

	public function read_by_id($id = null)
	{
		return $this->db->select("*")
			->from($this->table)
			->where('id',$id)
			->get()
			->row();
	}

	public function update($data = [])
	{
		return $this->db->where('id',$data['id'])
			->update($this->table,$data);
	}

	public function delete($id = null)
	{
		$response = $this->db->select("*")
			->from($this->table)
			->where('id',$id)
			->get()
			->row();

		$response2 = $this->db->select("*")
				->from('bf_nursing_handover')
				->where('patientid',$response->patient_id)
				->get()
				->row();
		//count($response2);
		if(count($response2) == 0){

			$this->db->where('id',$id)
				->delete($this->table);

		if ($this->db->affected_rows()) {
			return true;
		} else {
			return false;
		}
		}{
		return false;
	}
	}

}
