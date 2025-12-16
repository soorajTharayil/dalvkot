<?php defined('BASEPATH') or exit('No direct script access allowed');

class Questions_model extends CI_Model
{

	private $table = "setup";
	private $tableop = "setupop";
	private $tableint = "setup_int";


	public function create($data = [])
	{
		//	print_r($data);
		$this->db->insert($this->table, $data);
		return $this->db->insert($this->table, $data);
	}

	public function readipquestions()
	{

		$this->db->select("*");
		$this->db->order_by("type", "asc");
		$this->db->from($this->table);


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

	public function updateop($data = [])
	{
		return $this->db->where('id', $data['id'])
			->update($this->tableop, $data);
	}

	public function updateint($data = [])
	{
		return $this->db->where('id', $data['id'])
			->update($this->tableint, $data);
	}
}
