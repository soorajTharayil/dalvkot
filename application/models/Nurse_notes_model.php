<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Nurse_notes_model extends CI_Model {

	private $table = 'bf_brand_two';

	public function create($data = [])
	{
		$data['guid'] = time();
		return $this->db->insert($this->table,$data);
	}

	public function read()
	{
		return $this->db->select("*")
			->from($this->table)
			->order_by('id','asc')
			->get()
			->result();
	}

	public function read_by_id($dprt_id = null)
	{
		return $this->db->select("*")
			->from($this->table)
			->where('id',$dprt_id)
			->get()
			->row();
	}

	public function update($data = [])
	{
		return $this->db->where('id',$data['id'])
			->update($this->table,$data);
	}

	public function delete($dprt_id = null)
	{
		$this->db->where('id',$dprt_id)
			->delete($this->table);

		if ($this->db->affected_rows()) {
			return true;
		} else {
			return false;
		}
	}



 }
