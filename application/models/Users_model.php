<?php defined('BASEPATH') or exit('No direct script access allowed');

class Users_model extends CI_Model
{

	private $table = 'user';

	public function create($data = [])
	{

		$this->db->insert($this->table, $data);
		$this->sinkdeparment($_POST, 'NOEMAIL');
		return true;
	}

	public function read()
	{
		return $this->db->select("*")
			->from($this->table)
			->order_by('user_role','asc')
			->get()
			->result();
	}

	public function read_by_id($dprt_id = null)
	{
		return $this->db->select("*")
			->from($this->table)
			->where('user_id', $dprt_id)
			->get()
			->row();
	}

	public function update($data = [])
	{
		// print_r($data); exit;
		if ($this->read_by_id($_POST['ids'])) {
			$ds = $this->read_by_id($_POST['ids']);
			$old_email = $ds->email;
			$this->db->where('user_id', $_POST['ids'])
				->update($this->table, $data);
		} else {
			$this->db->insert($this->table, $data);
		}

		$this->sinkdeparment($_POST, $old_email);
		return true;
	}

	public function sinkdeparment($d, $old_email)
	{

		$data = array(
			'mobile' => '',
			'alternate_mobile' => '',
			'email' => '',
			'alternate_email' => '',
			'pname' => '',
		);
		$this->db->where('email', $old_email);
		$this->db->update('department', $data);
		$ipdepartment = $d['depip'];
		foreach ($ipdepartment as $keyip => $iprow) {
			$this->db->where('dprt_id', $keyip);
			$query = $this->db->get('department');
			$result = $query->result();
			$data = array(
				'mobile' => $d['mobile'],
				'alternate_mobile' => $d['alternate_mobile'],
				'alternate_email' => $d['alternate_email'],
				'email' => $d['email'],
				'pname' => $d['name'],
			);
			$this->db->where('type', 'inpatient');
			$this->db->where('description', $result[0]->description);
			$this->db->update('department', $data);
		}

		$opdepartment = $d['depop'];
		foreach ($opdepartment as $keyip => $iprow) {
			$this->db->where('dprt_id', $keyip);
			$query = $this->db->get('department');
			$result = $query->result();
			$data = array(
				'mobile' => $d['mobile'],
				'alternate_mobile' => $d['alternate_mobile'],
				'alternate_email' => $d['alternate_email'],
				'email' => $d['email'],
				'pname' => $d['name'],
			);
			$this->db->where('type', 'outpatient');
			$this->db->where('description', $result[0]->description);
			$this->db->update('department', $data);
		}

		$indepartment = $d['depin'];
		foreach ($indepartment as $keyip => $iprow) {
			$this->db->where('dprt_id', $keyip);
			$query = $this->db->get('department');
			$result = $query->result();
			$data = array(
				'mobile' => $d['mobile'],
				'alternate_mobile' => $d['alternate_mobile'],
				'alternate_email' => $d['alternate_email'],
				'email' => $d['email'],
				'pname' => $d['name'],
			);
			$this->db->where('type', 'interim');
			$this->db->where('description', $result[0]->description);
			$this->db->update('department', $data);
		}

		$psrdepartment = $d['deppsr'];
		foreach ($psrdepartment as $keyip => $iprow) {
			$this->db->where('dprt_id', $keyip);
			$query = $this->db->get('department');
			$result = $query->result();
			$data = array(
				'mobile' => $d['mobile'],
				'alternate_mobile' => $d['alternate_mobile'],
				'alternate_email' => $d['alternate_email'],
				'email' => $d['email'],
				'pname' => $d['name'],
			);
			$this->db->where('type', 'service');
			$this->db->where('description', $result[0]->description);
			$this->db->update('department', $data);
		}

		$esrdepartment = $d['depesr'];
		foreach ($esrdepartment as $keyip => $iprow) {
			$this->db->where('dprt_id', $keyip);
			$query = $this->db->get('department');
			$result = $query->result();
			$data = array(
				'mobile' => $d['mobile'],
				'alternate_mobile' => $d['alternate_mobile'],
				'alternate_email' => $d['alternate_email'],
				'email' => $d['email'],
				'pname' => $d['name'],
			);
			$this->db->where('type', 'esr');
			$this->db->where('description', $result[0]->description);
			$this->db->update('department', $data);
		}

// --
		$gridepartment = $d['depgrievance'];
		foreach ($gridepartment as $keyip => $iprow) {
			$this->db->where('dprt_id', $keyip);
			$query = $this->db->get('department');
			$result = $query->result();
			$data = array(
				'mobile' => $d['mobile'],
				'alternate_mobile' => $d['alternate_mobile'],
				'alternate_email' => $d['alternate_email'],
				'email' => $d['email'],
				'pname' => $d['name'],
			);
			$this->db->where('type', 'grievance');
			$this->db->where('description', $result[0]->description);
			$this->db->update('department', $data);
		}
// --

		$adfdepartment = $d['depadf'];
		foreach ($adfdepartment as $keyadf => $adfrow) {
			$this->db->where('dprt_id', $keyadf);
			$query = $this->db->get('department');
			$result = $query->result();
			$data = array(
				'mobile' => $d['mobile'],
				'alternate_mobile' => $d['alternate_mobile'],
				'alternate_email' => $d['alternate_email'],
				'email' => $d['email'],
				'pname' => $d['name'],
			);
			$this->db->where('type', 'adf');
			$this->db->where('description', $result[0]->description);
			$this->db->update('department', $data);
		}


		$empexdepartment = $d['depempex'];
		foreach ($empexdepartment as $keyip => $iprow) {
			$this->db->where('dprt_id', $keyip);
			$query = $this->db->get('department');
			$result = $query->result();
			$data = array(
				'mobile' => $d['mobile'],
				'alternate_mobile' => $d['alternate_mobile'],
				'alternate_email' => $d['alternate_email'],
				'email' => $d['email'],
				'pname' => $d['name'],
			);
			$this->db->where('type', 'employees');
			$this->db->where('description', $result[0]->description);
			$this->db->update('department', $data);
		}


		$incidepartment = $d['depinci'];
		foreach ($incidepartment as $keyip => $iprow) {
			$this->db->where('dprt_id', $keyip);
			$query = $this->db->get('department');
			$result = $query->result();
			$data = array(
				'mobile' => $d['mobile'],
				'alternate_mobile' => $d['alternate_mobile'],
				'alternate_email' => $d['alternate_email'],
				'email' => $d['email'],
				'pname' => $d['name'],
			);
			$this->db->where('type', 'incident');
			$this->db->where('description', $result[0]->description);
			$this->db->update('department', $data);
		}
		return true;
	}

	public function delete($dprt_id = null)
	{

		$user = $this->db->where('user_id', $dprt_id)->get($this->table)->result();
		$old_email = $user[0]->email;

		$data = array(
			'mobile' => '',
			'alternate_email' => '',
			'alternate_mobile' => '',
			'email' => '',
			'pname' => ''
		);
		$this->db->where('email', $old_email);
		$this->db->update('department', $data);
		$this->db->where('user_id', $dprt_id)->delete($this->table);

		if ($this->db->affected_rows()) {
			return true;
		} else {
			return false;
		}
	}

	public function department_list($dep)
	{
		$result = $this->db->select("*")
			->from('department')
			->where('type', $dep)
			->group_by('description')
			->get()
			->result();

		return $result;
	}
}
