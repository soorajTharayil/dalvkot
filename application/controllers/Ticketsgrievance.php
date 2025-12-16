<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ticketsgrievance extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model(array(
			'ticketsgrievance_model',
			'grievance_model'
		));
		$dates = get_from_to_date();
		if (isset($_SESSION['from_date']) && isset($_SESSION['to_date'])) {

			$fdate = $_SESSION['from_date'];
			$tdate = $_SESSION['to_date'];
		} else {
			$fdate = date('Y-m-d', time());
			$tdate = date('Y-m-d', strtotime('-365 days'));
			$_SESSION['from_date'] = $fdate;
			$_SESSION['to_date'] = $tdate;
		}
		if (($this->session->userdata('isLogIn') === false)) {
			$this->session->set_userdata('referred_from', current_url());
		} else {
			$this->session->set_userdata('referred_from', NULL);
		}
	}



	public function index()
	{
		if ($this->session->userdata('isLogIn') == false)
			redirect('login');

		$data['title'] = 'STAFF GRIEVANCES- OPEN TICKETS LIST';
		#-------------------------------#
		$data['departments'] = $this->ticketsgrievance_model->read();

		$data['content'] = $this->load->view('grievance/ticket', $data, true);
		$this->load->view('layout/main_wrapper', $data);
		$this->session->set_userdata('referred_from', NULL);
	}

	public function alltickets()
	{

		if ($this->session->userdata('isLogIn') == false)
			redirect('login');

		$data['title'] = 'STAFF GRIEVANCES- ALL TICKETS LIST';
		#-------------------------------#
		$data['departments'] = $this->ticketsgrievance_model->alltickets();
		$data['content'] = $this->load->view('grievance/alltickets', $data, true);
		$this->load->view('layout/main_wrapper', $data);
		$this->session->set_userdata('referred_from', NULL);
	}

	public function addressedtickets()
	{
		if ($this->session->userdata('isLogIn') == false)
			redirect('login');

		$data['title'] = 'STAFF GRIEVANCES- ADDRESSED TICKETS LIST';
		#-------------------------------#
		$data['departments'] = $this->ticketsgrievance_model->addressedtickets();

		$data['content'] = $this->load->view('grievance/addressedtickets', $data, true);
		$this->load->view('layout/main_wrapper', $data);
		$this->session->set_userdata('referred_from', NULL);
	}


	public function ticket_track()
	{


		$data['title'] = 'STAFF GRIEVANCES- TICKET DETAILS';
		$data['departments'] = $this->ticketsgrievance_model->read_by_id($this->uri->segment(3));
		$data['content'] = $this->load->view('grievance/track', $data, true);
		$this->load->view('layout/main_wrapper', $data);
	}

	public function ticket_close()
	{
		if ($this->session->userdata('isLogIn') == false)
			redirect('login');

		$data['title'] = 'STAFF GRIEVANCES- CLOSED TICKETS LIST';
		$data['departments'] = $this->ticketsgrievance_model->read_close();
		$data['content'] = $this->load->view('grievance/ticket_close', $data, true);

		$this->load->view('layout/main_wrapper', $data);
		$this->session->set_userdata('referred_from', NULL);
	}

	public function track_close()
	{
		if ($this->session->userdata('isLogIn') == false)
			redirect('login');

		$data['title'] = 'STAFF GRIEVANCES- CLOSED TICKET DETAILS';
		$data['departments'] = $this->ticketsgrievance_model->read_by_id($this->uri->segment(3));
		$data['content'] = $this->load->view('grievance/track_close', $data, true);
		$this->load->view('layout/main_wrapper', $data);
		$this->session->set_userdata('referred_from', NULL);
	}

	public function create($dprt_id = null)
	{
		if ($this->input->post('deparment') != 0) {
			$this->db->where('dprt_id', $this->input->post('deparment'));
			// print_r($_POST);
			$query = $this->db->get('department');
			$department = $query->result();
			$action = 'Moved From  ' . $this->input->post('reply_departmen') . ' To ' . $department[0]->description;
			$action_meta = array(
				'action'=>'Transfered',
				'sourceDepartmentId'=>$this->input->post('reply_department_id'),
				'targetDepartmentId'=> $this->input->post('deparment')
			);
		
			$message = $this->session->userdata['fullname'];
			$updatedepartment = array('departmentid_trasfered' => $this->input->post('deparment'), 'emailstatus' => 0, 'status' => 'Transfered', 'transfer_ticket_alert' => '0');
			$this->db->where('id', $this->input->post('id'));
			$this->db->update('tickets_grievance', $updatedepartment);

			$dataset = array(
				'reply' => $this->input->post('reply'),
				'message' => $message,
				'action' => $action,
				'action_meta' => json_encode($action_meta),
				'ticketid' => $this->input->post('id'),
				'ticket_status' => 'Transfered',
				'created_by' => $this->session->userdata('user_id'),
			);

			$this->db->insert('ticket_grievance_message', $dataset);
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_URL, base_url() . 'api/curl.php');
			curl_exec($curl);
			redirect('grievance/opentickets');
		} else {

			if ($this->input->post('status') == 'Closed') {


				$result = $this->db->select("*")
					->from('tickets_grievance')
					->where('id', $this->input->post('id'))
					->get()
					->result();
				//print_r($result); exit;			
				$results = $this->db->select("*")
					->from('department')
					->where('dprt_id', $result[0]->departmentid)
					->get()
					->result();
				$resultss = $this->db->select("*")
					->from('department')
					->where('description', $results[0]->description)
					->get()
					->result();
				//print_r($resultss); exit;
				$action = 'Closed by ' . $this->session->userdata['fullname'];
				$message = $this->session->userdata['fullname'];
				//foreach($resultss as $tickets){

				$updatedepartmen = array('status' => $this->input->post('status'));

				$this->db->where('id', $this->input->post('id'));
				//$this->db->where('created_by',$result[0]->created_by);
				$this->db->update('tickets_grievance', $updatedepartmen);
				//}
				if (close_comment('sg_close_comment') === true) {
					$comment = $this->input->post('comment');
				} else {
					$comment = NULL;
				}
				//picture upload
				$picture = $this->fileupload->do_upload(
					'assets/images/capaimage/',
					'picture'
				);
				//print_r($picture); exit;
				$dataset = array(
					'reply' => $this->input->post('reply'),
					'corrective' => $this->input->post('corrective'),
					'preventive' => $this->input->post('preventive'),
					'rootcause' => $this->input->post('rootcause'),
					'comment' => $comment,
					'message' => $message,
					'picture' => (!empty($picture) ? $picture : null),
					'action' => $action,
					'ticket_status' => 'Closed',
					'created_by' => $this->session->userdata('user_id'),
					'ticketid' => $this->input->post('id')
				);

				$this->db->insert('ticket_grievance_message', $dataset);
				// redirect('grievance/closedtickets');
				$this->session->set_flashdata('message', '<span style="color: green;">Ticket is closed</span>');

			} elseif ($this->input->post('status') == 'Reopen') {

				$action = 'Reopened by ' . $this->session->userdata['fullname'];
				$message = $this->session->userdata['fullname'];
				$updatedepartmen = array('status' => $this->input->post('status'), 'addressed' => 0, 'reopen_ticket_alert' => '0');
				$this->db->where('id', $this->input->post('id'));
				$this->db->update('tickets_grievance', $updatedepartmen);

				$dataset = array(
					'reply' => $this->input->post('reply'),
					'message' => $message,
					'action' => $action,
					'ticket_status' => 'Reopen',
					'created_by' => $this->session->userdata('user_id'),
					'ticketid' => $this->input->post('id')
				);

				$this->db->insert('ticket_grievance_message', $dataset);
				$curl = curl_init();
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($curl, CURLOPT_URL, base_url() . 'api/curl.php');
				curl_exec($curl);
				redirect('grievance/opentickets');
			} elseif ($this->input->post('status') == 'Addressed') {

				$action = 'Addressed by ' . $this->session->userdata['fullname'];
				$message = $this->session->userdata['fullname'];
				$updatedepartmen = array('addressed' => 1, 'status' => 'Addressed');
				$this->db->where('id', $this->input->post('id'));
				$this->db->update('tickets_grievance', $updatedepartmen);

				$dataset = array(
					'reply' => $this->input->post('reply'),
					'message' => $message,
					'action' => $action,
					'ticket_status' => 'Addressed',
					'created_by' => $this->session->userdata('user_id'),
					'ticketid' => $this->input->post('id')
				);

				$this->db->insert('ticket_grievance_message', $dataset);
				redirect('grievance/addressedtickets');
			} else {
				$action = 'Comment';
				$message = $this->session->userdata['fullname'];
				$dataset = array(
					'reply' => $this->input->post('reply'),
					'message' => $message,
					'action' => $action,
					'created_by' => $this->session->userdata('user_id'),
					'ticketid' => $this->input->post('id')
				);

				$this->db->insert('ticket_grievance_message', $dataset);
			}
		}
		redirect('grievance/track/' . $this->input->post('id'));
	}
}
