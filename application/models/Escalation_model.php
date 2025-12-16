<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Escalation_model extends CI_Model {

	private $table = 'escalation';

	

	public function read($section)
	{
		return $result = $this->db->where('section',$section)->get('escalation')->result();
	}
	
	public function change_status($section,$status){
		$data = array('status'=>$status);
		$this->db->where('section',$section)->update('escalation',$data);
		return true;
	}
	
	public function read_close()
	{
		$fdate = date('Y-m-d',strtotime($_SESSION['from_date'])+24*60*60);
		$tdate = date('Y-m-d',strtotime($_SESSION['to_date']));
		
		$datasetnew = array();
		$i =0;
		if($this->input->get('depsec') != 1 && $this->input->get('depsec') != ''){
			$this->db->where('type','inpatient');
			$this->db->where('description',$this->input->get('depsec'));
			$query = $this->db->get('department');
			$result = $query->result();
			foreach($result as $t){
				$datasetnew[$i++] = $t->dprt_id;
			}
		}
		$this->db->select("*");
		$this->db->from($this->table);
		$this->db->where('status','closed');
		$this->db->where('created_on >=',$tdate);
		$this->db->where('created_on <=',$fdate);
		if($this->input->get('type') != 1 && $this->input->get('type') != ''){
			$this->db->where('departmentid',$this->input->get('type'));
		}else{
			if(count($datasetnew) > 0) {
				$this->db->where_in('departmentid',$datasetnew);
			}
		}
		$this->db->order_by('id','desc');
		$query = $this->db->get();
		$result = $query->result();
		$dataset = array();
		$i = 0;
		
		
		
		
		foreach($result as $row){
			
			
			$this->db->where('id',$row->feedbackid);
			$query = $this->db->get('bf_feedback');
			$feedback = $query->result();
			
			
			$this->db->where('patient_id',$row->created_by);
			$query = $this->db->get('bf_patients');
			$patient = $query->result();
			$this->db->where('dprt_id',$row->departmentid);
			$query = $this->db->get('department');
			$department = $query->result();
			//$slug = $patient[0]->id.preg_replace('/[^A-Za-z0-9-]+/', '-', $department[0]->dprt_id);
			$dataset[$i] = $row;
			$dataset[$i]->patinet = $patient[0];
			$feed = json_decode($feedback[0]->dataset);
			$dataset[$i]->patinet->bed_no = $feed->bedno;
			$dataset[$i]->patinet->admissiondate = $feed->admissiondate;
			
			$dataset[$i]->department = $department[0];
			if($row->rating == 2){
				$dataset[$i]->ratingt = 'Poor';
			}else{
				$dataset[$i]->ratingt = 'Worst';
			}

			
			$this->db->where('ticketid',$row->id);
			$this->db->order_by('id','desc');
			$query = $this->db->get('ticket_message');
			$closed = $query->result();
			$dataset[$i]->closed_on = $closed[0]->created_on;
			$dataset[$i]->replymessage = $closed;
			$i++;
			
			
		}
		return $dataset;
	}

	public function read_by_id($id = null)
	{
		
		$result = $this->db->select("*")
			->from($this->table)
			->where('id',$id)
			->get()
			->result();
		$dataset = array();
		$i = 0;
		foreach($result as $row){
			
			
			
			
			$this->db->where('patient_id',$row->created_by);
			$query = $this->db->get('bf_patients');
			$patient = $query->result();
			$dataset[$i] = $row;
			$dataset[$i]->patinet = $patient[0];
			
			
			$this->db->where('dprt_id',$row->departmentid);
			$query = $this->db->get('department');
			$department = $query->result();
			$dataset[$i]->department = $department[0];
			$this->db->where('ticketid',$row->id);
			$query = $this->db->get('ticket_message');
			$reply = $query->result();
			$dataset[$i]->replymessage = $reply;
			$this->db->where('id',$row->feedbackid);
			$query = $this->db->get('bf_feedback');
			$feedback = $query->result();
			
			$feed = json_decode($feedback[0]->dataset);
			$dataset[$i]->patinet->bed_no = $feed->bedno;
			$dataset[$i]->patinet->admissiondate = $feed->admissiondate;
			$dataset[$i]->feedback = json_decode($feedback[0]->dataset);
			if($row->rating == 2){
				$dataset[$i]->ratingt = 'Poor';
			}else{
				$dataset[$i]->ratingt = 'Worst';
			}
			$i++;
			
			
		}
		return $dataset;
	}

	public function update($data = [])
	{
		if($this->read_by_id($data['guid'])){
			return $this->db->where('guid',$data['guid'])
				->update($this->table,$data);
		}else{
			return $this->db->insert($this->table,$data);
		}
	}

	public function delete($dprt_id = null)
	{
		$this->db->where('guid',$dprt_id)
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
			->where('status',1)
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
