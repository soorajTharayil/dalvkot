<?php defined('BASEPATH') or exit('No direct script access allowed');

class Role_model extends CI_Model
{

	private $table = 'bf_roles';

	public function create($data = [])
	{
		$data['guid'] = time();
		return $this->db->insert($this->table, $data);
	}

	public function read()
	{
		return $this->db->select("*")
			->from($this->table)
			->where('title !=', 'ALL')
			->order_by('title', 'asc')
			->get()
			->result();
	}

	public function read_by_id($dprt_id = null)
	{
		return $this->db->select("*")
			->from($this->table)
			->where('guid', $dprt_id)
			->get()
			->row();
	}

	public function update($data = [])
	{
		return $this->db->where('guid', $data['guid'])
			->update($this->table, $data);
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
}
