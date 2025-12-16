<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Messageop extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_user_by_sms_activity($type)
	{

		$user_list = array();

		$query = $this->db->get_where('features', array('feature_name' => $type));
		$feature_result = $query->row();



		$feature_id = $feature_result->feature_id;

		$user_permission_query = 'SELECT * FROM `role_permissions` WHERE status = 1 AND `feature_id` =' . $feature_id;
		$permission_result = $this->db->query($user_permission_query);

		foreach ($permission_result->result() as $role_permission) {
			$role = $role_permission->role_id;

			$user_query = 'SELECT * FROM `user` WHERE `user_role` =' . $role;
			$user_result = $this->db->query($user_query);

			foreach ($user_result->result() as $user) {
				$user_list[] = $user;
			}
		}

		return $user_list;
	}

	public function inweeklyreport()
	{
		$fdate = date('Y-m-d', strtotime('-1 days'));
		$tdate = date('Y-m-d 00:00:00', strtotime('-7 days'));
		$this->db->select('bf_outfeedback.*,bf_opatients.name as pname,bf_opatients.patient_id as pid');
		$this->db->from('bf_outfeedback');
		$this->db->join('bf_opatients', 'bf_opatients.patient_id = bf_outfeedback.patientid', 'inner');
		$fdate = date('Y-m-d', strtotime($fdate) + 86399);
		$fdatet = date('Y-m-d H:i:s', strtotime($fdate) + 86399);
		$this->db->where('bf_outfeedback.datet <=', $fdatet);
		$this->db->where('bf_outfeedback.datet >=', $tdate);
		$this->db->order_by('datetime', 'desc');
		$query = $this->db->get();
		$feedbacktaken = $query->result();
		$promoter = 0;
		$depromoter = 0;
		$passive = 0;
		foreach ($feedbacktaken as $r) {
			$this->db->where('feedbackid', $r->id);
			$query = $this->db->get('ticketsop');
			$dtata = $query->result();
			if (count($dtata) > 0) {
				//$param = json_decode($r->dataset);
				$below3++;
			}
			$param = json_decode($r->dataset);
			if ($param->recommend1Score * 1 > 0) {
				if ($param->recommend1Score > 4) {
					$promoter = $promoter + 1;
				} else {
					if ($param->recommend1Score == 4) {
						$passive = $passive + 1;
					} else {
						$depromoter = $depromoter + 1;
					}
				}
			}
		}
		$d1 = date('Md', strtotime($tdate));
		$d2 = date('Md', strtotime($fdatet));
		$message1 = 'Weekly OP feedbacks report: ' . $d1 . ' to ' . $d2 . '%0a%0aTotal feedbacks:' . count($feedbacktaken) . '%0aSatisfied Patients:' . (count($feedbacktaken) - $below3) . '%0aUnsatisfied Patients:' . $below3 . '%0aSatisfaction Index:' . round((count($feedbacktaken) - $below3) / (count($feedbacktaken)) * 100) . '%25%0aNPS Score:' . round(($promoter / ($depromoter + $promoter + $passive)) * 100) . '%25';


		$TEMPID = '1607100000000084992';
		$user = $this->get_user_by_sms_activity('OP-WEEKLY-FEEDBACKS-REPORT-SMS');
		foreach ($user as $rowuser) {
			$number = $rowuser->mobile;
			$this->sendsms($message1, $number, $TEMPID);
		}
	}

	public function inmonthlyreport()
	{
		$fdate = date('Y-m-d', strtotime('-1 days'));
		$tdate = date('Y-m-d', strtotime('-30 days'));
		$this->db->select('bf_outfeedback.*,bf_opatients.name as pname,bf_opatients.patient_id as pid');
		$this->db->from('bf_outfeedback');
		$this->db->join('bf_opatients', 'bf_opatients.patient_id = bf_outfeedback.patientid', 'inner');

		if (isset($_SESSION['ward']) && $_SESSION['ward'] != 'ALL') {
			$this->db->where('bf_opatients.ward', $_SESSION['ward']);
		}

		$fdate = date('Y-m-d', strtotime($fdate) + 86399);
		$fdatet = date('Y-m-d H:i:s', strtotime($fdate) + 86399);
		$this->db->where('bf_outfeedback.datet <=', $fdatet);
		$this->db->where('bf_outfeedback.datet >=', $tdate);
		$this->db->order_by('datetime', 'desc');
		$query = $this->db->get();
		$feedbacktaken = $query->result();
		$promoter = 0;
		$depromoter = 0;
		$passive = 0;
		foreach ($feedbacktaken as $r) {
			//print_r($r);
			$this->db->where('feedbackid', $r->id);
			$query = $this->db->get('ticketsop');
			$dtata = $query->result();
			if (count($dtata) > 0) {
				//$param = json_decode($r->dataset);
				$below3++;
			}
			$param = json_decode($r->dataset);
			if ($param->recommend1Score * 1 > 0) {
				if ($param->recommend1Score > 4) {
					$promoter = $promoter + 1;
				} else {
					if ($param->recommend1Score == 4) {
						$passive = $passive + 1;
					} else {
						$depromoter = $depromoter + 1;
					}
				}
			}
		}

		$d1 = date('Md', strtotime($tdate));
		$d2 = date('Md', strtotime($fdatet));
		$message1 = 'Monthly OP feedbacks report: ' . $d1 . ' to ' . $d2 . '%0a%0aTotal feedbacks:' . count($feedbacktaken) . '%0aSatisfied Patients:' . (count($feedbacktaken) - $below3) . '%0aUnsatisfied Patients:' . $below3 . '%0aSatisfaction Index:' . round((count($feedbacktaken) - $below3) / (count($feedbacktaken)) * 100) . '%25%0aNPS Score:' . round(($promoter / ($depromoter + $promoter + $passive)) * 100) . '%25';

		//$query = ;


		$TEMPID = '1607100000000084994';
		$user = $this->get_user_by_sms_activity('OP-MONTHLY-FEEDBACKS-REPORT-SMS');
		foreach ($user as $rowuser) {
			$number = $rowuser->mobile;
			$this->sendsms($message1, $number, $TEMPID);
		}
	}
	//Not working because of zero Ticket
	public function weeklyipticketreport()
	{
		$fdate = date('Y-m-d', strtotime('-1 days'));
		$tdate = date('Y-m-d 00:00:00', strtotime('-7 days'));
		$fdate = date('Y-m-d', strtotime($fdate) + 86399);
		$fdatet = date('Y-m-d H:i:s', strtotime($fdate) + 86399);
		$this->db->select('ticketsop.*,bf_opatients.name as pname');
		$this->db->from('ticketsop');

		$this->db->join('bf_outfeedback', 'bf_outfeedback.id = ticketsop.feedbackid', 'left');
		$this->db->join('bf_opatients', 'bf_opatients.patient_id = bf_outfeedback.patientid', 'left');
		$this->db->where('bf_outfeedback.datet <=', $fdate);
		$this->db->where('bf_outfeedback.datet >=', $tdate);
		$this->db->order_by('datetime', 'desc');
		$query = $this->db->get();
		$ticket = $query->result();

		$tickets = array();
		$ticketbydepartment = array();
		$ticketbydepartmentopen = array();
		$ticketbydepartmentname = array();
		foreach ($ticket as $row) {
			$this->db->where('patient_id', $row->created_by);
			$query = $this->db->get('bf_opatients');
			$patient = $query->result();

			$this->db->where('dprt_id', $row->departmentid);
			$query = $this->db->get('department');
			$department = $query->result();
			$slug2 = preg_replace('/[^A-Za-z0-9-]+/', '-', $department[0]->description);
			$row->slug = $slug2;
			$slug = $patient[0]->id . preg_replace('/[^A-Za-z0-9-]+/', '-', $department[0]->description);
			$tickets[] = $row;


			$ticketbydepartment[$slug2] = $ticketbydepartment[$slug2] * 1 + 1;
			$ticketbydepartmentname[$slug2] = $department[0]->description;
		}

		$opent = 0;
		$closedt = 0;
		foreach ($tickets as $t) {
			//$ticketbydepartment[$slug2] = $ticketbydepartment[$slug2]*1+1;
			if ($t->status == 'Open') {
				$opent++;
				$ticketbydepartmentopen[$t->slug] = $ticketbydepartmentopen[$t->slug] * 1 + 1;
			} else {
				$closedt++;
			}
		}
		$d1 = date('Md', strtotime($tdate));
		$d2 = date('Md', strtotime($fdatet));
		/*$message2 = 'Weekly OP Tickets Report: '.$d1.' to '.$d2.'%0a%0aTotal tickets:'.count($tickets).'%0aTickets Open:'.$opent.'%0aTickets Closed:'.$closedt.'%0a%0a';
		$ticketdepart = arsort($ticketbydepartment);
		foreach($ticketbydepartment as $key=>$depart){
			$closed = $ticketbydepartment[$key] - $ticketbydepartmentopen[$key];
			$open = $ticketbydepartmentopen[$key]*1;
			$message2 .=$ticketbydepartmentname[$key].':Total:'.$ticketbydepartment[$key].', Open:'.$open.', Closed:'.$closed.'%0a';
		}*/
		$message2 = 'Weekly OP Tickets Report: ' . $d1 . ' to ' . $d2 . '%0aTotal tickets: ' . count($tickets) . '%0aTickets Open: ' . $opent . '%0aTickets closed: ' . $closedt . '%0aTo view more details, please login to dashboard and click the link below:%0a' . base_url() . '';

		$TEMPID = '1607100000000141422';

		$user = $this->get_user_by_sms_activity('OP-WEEKLY-TICKETS-REPORT-SMS');
		foreach ($user as $rowuser) {
			$number = $rowuser->mobile;
			$this->sendsms($message2, $number, $TEMPID);
		}
	}
	//Not working because of zero Ticket
	public function montlyipticketreport()
	{
		$fdate = date('Y-m-d', strtotime('-1 days'));
		$tdate = date('Y-m-d', strtotime('-30 days'));
		$fdate = date('Y-m-d', strtotime($fdate) + 86399);
		$fdatet = date('Y-m-d H:i:s', strtotime($fdate) + 86399);
		$this->db->select('ticketsop.*,bf_opatients.name as pname');
		$this->db->from('ticketsop');

		$this->db->join('bf_outfeedback', 'bf_outfeedback.id = ticketsop.feedbackid', 'left');
		$this->db->join('bf_opatients', 'bf_opatients.patient_id = bf_outfeedback.patientid', 'left');
		$this->db->where('bf_outfeedback.datet <=', $fdate);
		$this->db->where('bf_outfeedback.datet >=', $tdate);
		$this->db->order_by('datetime', 'desc');
		$query = $this->db->get();
		$ticket = $query->result();

		$tickets = array();
		$ticketbydepartment = array();
		$ticketbydepartmentopen = array();
		$ticketbydepartmentname = array();
		foreach ($ticket as $row) {
			$this->db->where('patient_id', $row->created_by);
			$query = $this->db->get('bf_opatients');
			$patient = $query->result();

			$this->db->where('dprt_id', $row->departmentid);
			$query = $this->db->get('department');
			$department = $query->result();
			$slug2 = preg_replace('/[^A-Za-z0-9-]+/', '-', $department[0]->description);
			$row->slug = $slug2;
			$slug = $patient[0]->id . preg_replace('/[^A-Za-z0-9-]+/', '-', $department[0]->description);
			$tickets[] = $row;


			$ticketbydepartment[$slug2] = $ticketbydepartment[$slug2] * 1 + 1;
			$ticketbydepartmentname[$slug2] = $department[0]->description;
		}

		$opent = 0;
		$closedt = 0;
		foreach ($tickets as $t) {
			//$ticketbydepartment[$slug2] = $ticketbydepartment[$slug2]*1+1;
			if ($t->status == 'Open') {
				$opent++;
				$ticketbydepartmentopen[$t->slug] = $ticketbydepartmentopen[$t->slug] * 1 + 1;
			} else {
				$closedt++;
			}
		}
		$d1 = date('Md', strtotime($tdate));
		$d2 = date('Md', strtotime($fdatet));
		/*$message2 = 'Monthly OP Tickets Report: '.$d1.' to '.$d2.'%0a%0aTotal tickets:'.count($tickets).'%0aTickets Open:'.$opent.'%0aTickets Closed:'.$closedt.'%0a%0a';
		$ticketdepart = arsort($ticketbydepartment);
		foreach($ticketbydepartment as $key=>$depart){
			$closed = $ticketbydepartment[$key] - $ticketbydepartmentopen[$key];
			$open = $ticketbydepartmentopen[$key]*1;
			$message2 .=$ticketbydepartmentname[$key].':Total:'.$ticketbydepartment[$key].', Open:'.$open.', Closed:'.$closed.'%0a';
		}*/
		$message2 = 'Monthly OP Tickets Report: ' . $d1 . ' to ' . $d2 . '%0aTotal tickets: ' . count($tickets) . '%0aTickets Open: ' . $opent . '%0aTickets closed: ' . $closedt . '%0aTo view more details, please login to dashboard and click the link below:' . base_url() . '';

		$TEMPID = '1607100000000141423';
		$user = $this->get_user_by_sms_activity('OP-MONTHLY-TICKETS-REPORT-SMS');
		foreach ($user as $rowuser) {
			$number = $rowuser->mobile;
			$this->sendsms($message2, $number, $TEMPID);
		}
	}



	public function weeklynpsscore()
	{
		$fdate = date('Y-m-d', strtotime('-1 days'));
		$tdate = date('Y-m-d 00:00:00', strtotime('-7 days'));
		$this->db->select('bf_outfeedback.*,bf_opatients.name as pname,bf_opatients.patient_id as pid');
		$this->db->from('bf_outfeedback');
		$this->db->join('bf_opatients', 'bf_opatients.patient_id = bf_outfeedback.patientid', 'inner');

		if (isset($_SESSION['ward']) && $_SESSION['ward'] != 'ALL') {
			$this->db->where('bf_opatients.ward', $_SESSION['ward']);
		}

		$fdate = date('Y-m-d', strtotime($fdate) + 86399);
		$fdatet = date('Y-m-d H:i:s', strtotime($fdate) + 86399);
		$this->db->where('bf_outfeedback.datet <=', $fdatet);
		$this->db->where('bf_outfeedback.datet >=', $tdate);
		$this->db->order_by('datetime', 'desc');
		$query = $this->db->get();
		$feedbacktaken = $query->result();
		$promoter = 0;
		$depromoter = 0;
		$passive = 0;
		foreach ($feedbacktaken as $r) {
			$this->db->where('feedbackid', $r->id);
			$query = $this->db->get('ticketsop');
			$dtata = $query->result();
			if (count($dtata) > 0) {
				//$param = json_decode($r->dataset);
				$below3++;
			}
			$param = json_decode($r->dataset);
			if ($param->recommend1Score * 1 > 0) {
				if ($param->recommend1Score > 4) {
					$promoter = $promoter + 1;
				} else {
					if ($param->recommend1Score == 4) {
						$passive = $passive + 1;
					} else {
						$depromoter = $depromoter + 1;
					}
				}
			}
		}
		$d1 = date('Md', strtotime($tdate));
		$d2 = date('Md', strtotime($fdatet));
		$permoterpercentage = round(($promoter / ($depromoter + $promoter + $passive)) * 100);
		$total = $depromoter + $promoter;
		$message1 = 'Weekly NPS Analysis: ' . $d1 . ' to ' . $d2 . '%0a%0aNet Promoters Score: ' . $permoterpercentage . '%25%0a';
		$message1 .= 'No. of Promoters: ' . $promoter . '/' . $total . '%0a';
		$message1 .= 'No. of Demoters: ' . $depromoter . '/' . $total . '%0a';
		$message1 .= 'No. of Passives: ' . $passive . '/' . $total . '%0a';
		$message1 .= 'NPS increased by 13%25 from last week';



		$TEMPID = '1607100000000084996';
		$user = $this->get_user_by_sms_activity('OP-WEEKLY-NPS-REPORT-SMS');
		foreach ($user as $rowuser) {
			$number = $rowuser->mobile;
			$this->sendsms($message1, $number, $TEMPID);
		}
	}

	public function monthlynpsscore()
	{
		$fdate = date('Y-m-d', strtotime('-1 days'));
		$tdate = date('Y-m-d', strtotime('-30 days'));
		$this->db->select('bf_outfeedback.*,bf_opatients.name as pname,bf_opatients.patient_id as pid');
		$this->db->from('bf_outfeedback');
		$this->db->join('bf_opatients', 'bf_opatients.patient_id = bf_outfeedback.patientid', 'inner');

		if (isset($_SESSION['ward']) && $_SESSION['ward'] != 'ALL') {
			$this->db->where('bf_opatients.ward', $_SESSION['ward']);
		}

		$fdate = date('Y-m-d', strtotime($fdate) + 86399);
		$fdatet = date('Y-m-d H:i:s', strtotime($fdate) + 86399);
		$this->db->where('bf_outfeedback.datet <=', $fdatet);
		$this->db->where('bf_outfeedback.datet >=', $tdate);
		$this->db->order_by('datetime', 'desc');
		$query = $this->db->get();
		$feedbacktaken = $query->result();
		$promoter = 0;
		$depromoter = 0;
		$passive = 0;
		foreach ($feedbacktaken as $r) {
			$this->db->where('feedbackid', $r->id);
			$query = $this->db->get('ticketsop');
			$dtata = $query->result();
			if (count($dtata) > 0) {
				//$param = json_decode($r->dataset);
				$below3++;
			}
			$param = json_decode($r->dataset);
			if ($param->recommend1Score * 1 > 0) {
				if ($param->recommend1Score > 4) {
					$promoter = $promoter + 1;
				} else {
					if ($param->recommend1Score == 4) {
						$passive = $passive + 1;
					} else {
						$depromoter = $depromoter + 1;
					}
				}
			}
		}
		$d1 = date('Md', strtotime($tdate));
		$d2 = date('Md', strtotime($fdatet));
		$permoterpercentage = round(($promoter / ($depromoter + $promoter + $passive)) * 100);
		$total = $depromoter + $promoter;
		$message1 = 'Monthly NPS Analysis: ' . $d1 . ' to ' . $d2 . '%0a%0aNet Promoters Score: ' . $permoterpercentage . '%25%0a';
		$message1 .= 'No. of Promoters: ' . $promoter . '/' . $total . '%0a';
		$message1 .= 'No. of Demoters: ' . $depromoter . '/' . $total . '%0a';
		//$message1 .= 'No. of Passives: '.$passive.'/'.$total.'%0a';
		$message1 .= 'NPS increased by 13%25 from last month';


		//$query = ;

		$this->db->where('user_id', 2);
		$query = $this->db->get('user');
		$user = $query->result();

		$number = $user[0]->mobile;

		$TEMPID = '1607100000000084997';
		$user = $this->get_user_by_sms_activity('OP-MONTHLY-NPS-REPORT-SMS');
		foreach ($user as $rowuser) {
			$number = $rowuser->mobile;
			$this->sendsms($message1, $number, $TEMPID);
		}
	}

	public function weeklyiphospitalselection()
	{
		$fdate = date('Y-m-d', strtotime('-1 days'));
		$tdate = date('Y-m-d 00:00:00', strtotime('-7 days'));
		$overallarray = array(
			'location' => 'Location',
			'specificservice' => 'Specific services offered',
			'referred' => 'Referred by doctors',
			'friend' => 'Friend/Family recommendation',
			'previous' => 'Previous experience',
			'docAvailability' => 'Insurance facilities',
			'companyRecommend' => 'Company Recommendation',
			'otherReason' => 'Print or Online Media'
		);
		$this->db->select('bf_outfeedback.*,bf_opatients.name as pname,bf_opatients.patient_id as pid');
		$this->db->from('bf_outfeedback');
		$this->db->join('bf_opatients', 'bf_opatients.patient_id = bf_outfeedback.patientid', 'inner');

		if (isset($_SESSION['ward']) && $_SESSION['ward'] != 'ALL') {
			$this->db->where('bf_opatients.ward', $_SESSION['ward']);
		}

		$fdate = date('Y-m-d', strtotime($fdate) + 86399);
		$fdatet = date('Y-m-d H:i:s', strtotime($fdate) + 86399);
		$this->db->where('bf_outfeedback.datet <=', $fdatet);
		$this->db->where('bf_outfeedback.datet >=', $tdate);
		$this->db->order_by('datetime', 'desc');
		$query = $this->db->get();
		$feedbacktaken = $query->result();
		$tcount = 0;

		foreach ($overallarray as $row => $v) {
			foreach ($feedbacktaken as $r) {
				$param = json_decode($r->dataset, true);
				foreach ($param as $k => $rval) {
					if ($k == $row) {
						if ($param[$k] != '') {
							$tcount++;
						}
					}
				}
			}
		}
		$message = 'Vyko Weekly Insights:%0a';
		$d1 = date('Md', strtotime($tdate));
		$d2 = date('Md', strtotime($fdatet));
		$message .= 'Do you know why patients chose your hospital between ' . $d1 . ' to ' . $d2 . '?%0a';
		$message .= 'Out of ' . count($feedbacktaken) . ' patients,%0a';
		$ratebartext = '';
		$ratebarparanamev = '';
		$t = 0;
		$selectionarray = array();
		$selectionarrayname = array();
		foreach ($overallarray as $row => $v) {
			$count = 0;
			foreach ($feedbacktaken as $r) {
				$param = json_decode($r->dataset, true);
				foreach ($param as $k => $rval) {
					if ($k == $row) {
						if ($param[$k] != '') {
							$count++;
						}
					}
				}
			}

			if (count($feedbacktaken) > 0) {
				$percentage = round(($count / $tcount) * 100);
			} else {
				$percentage = 0;
			}
			$selectionarray[$row] = $percentage;
			$selectionarrayname[$row] = $v;
		}

		arsort($selectionarray);
		foreach ($selectionarray as $key => $value) {
			$message .= $value . '%25 due to ' . $selectionarrayname[$key] . '%0a';
		}
		$message = $message . '.';

		$TEMPID = '1607100000000084998';
		$user = $this->get_user_by_sms_activity('OP-WEEKLY-HOSPITAL-SELECTION-ANALYSIS-SMS');
		foreach ($user as $rowuser) {

			$number = $rowuser->mobile;
			$this->sendsms($message, $number, $TEMPID);
		}
	}

	public function montylyiphospitalselection()
	{
		$fdate = date('Y-m-d', strtotime('-1 days'));
		$tdate = date('Y-m-d', strtotime('-30 days'));
		$overallarray = array(
			'location' => 'Location',
			'specificservice' => 'Specific services offered',
			'referred' => 'Referred by doctors',
			'friend' => 'Friend/Family recommendation',
			'previous' => 'Previous experience',
			'docAvailability' => 'Insurance facilities',
			'companyRecommend' => 'Company Recommendation',
			'otherReason' => 'Print or Online Media'
		);
		$this->db->select('bf_outfeedback.*,bf_opatients.name as pname,bf_opatients.patient_id as pid');
		$this->db->from('bf_outfeedback');
		$this->db->join('bf_opatients', 'bf_opatients.patient_id = bf_outfeedback.patientid', 'inner');

		if (isset($_SESSION['ward']) && $_SESSION['ward'] != 'ALL') {
			$this->db->where('bf_opatients.ward', $_SESSION['ward']);
		}

		$fdate = date('Y-m-d', strtotime($fdate) + 86399);
		$fdatet = date('Y-m-d H:i:s', strtotime($fdate) + 86399);
		$this->db->where('bf_outfeedback.datet <=', $fdatet);
		$this->db->where('bf_outfeedback.datet >=', $tdate);
		$this->db->order_by('datetime', 'desc');
		$query = $this->db->get();
		$feedbacktaken = $query->result();
		$tcount = 0;

		foreach ($overallarray as $row => $v) {
			foreach ($feedbacktaken as $r) {
				$param = json_decode($r->dataset, true);
				foreach ($param as $k => $rval) {
					if ($k == $row) {
						if ($param[$k] != '') {
							$tcount++;
						}
					}
				}
			}
		}
		$message = 'Vyko Monthly Insights:%0a';
		$d1 = date('Md', strtotime($tdate));
		$d2 = date('Md', strtotime($fdatet));
		$message .= 'Do you know why patients chose your hospital between ' . $d1 . ' to ' . $d2 . '?%0a';
		$message .= 'Out of ' . count($feedbacktaken) . ' patients%0a';
		$ratebartext = '';
		$ratebarparanamev = '';
		$t = 0;
		$selectionarray = array();
		$selectionarrayname = array();
		foreach ($overallarray as $row => $v) {
			$count = 0;
			foreach ($feedbacktaken as $r) {
				$param = json_decode($r->dataset, true);
				foreach ($param as $k => $rval) {
					if ($k == $row) {
						if ($param[$k] != '') {
							$count++;
						}
					}
				}
			}

			if (count($feedbacktaken) > 0) {
				$percentage = round(($count / $tcount) * 100);
			} else {
				$percentage = 0;
			}
			$selectionarray[$row] = $percentage;
			$selectionarrayname[$row] = $v;
		}

		arsort($selectionarray);
		foreach ($selectionarray as $key => $value) {
			$message .= $value . '%25 due to ' . $selectionarrayname[$key] . '%0a';
		}


		$TEMPID = '1607100000000084999';
		$user = $this->get_user_by_sms_activity('OP-MONTHLY-HOSPITAL-SELECTION-ANALYSIS-SMS');
		foreach ($user as $rowuser) {
			$number = $rowuser->mobile;
			$this->sendsms($message, $number, $TEMPID);
		}
	}


	public function weeklyinsighthighlow()
	{
		//$fdate = date('Y-m-d');
		$fdate = date('Y-m-d', strtotime('-1 days'));
		$tdate = date('Y-m-d 00:00:00', strtotime('-7 days'));
		$this->db->order_by('id');
		$query = $this->db->get('setupop');
		$sresult = $query->result();
		$setarray = array();
		$questioarray = array();
		foreach ($sresult as $r) {
			$setarray[$r->type] = $r->title;
		}
		foreach ($sresult as $r) {
			$questioarray[$r->type][$r->shortkey] = $r->shortname;
		}
		$arraydata = array();
		foreach ($questioarray as $setr) {
			foreach ($setr as $k => $v) {
				$arraydata[$k] = $v;
			}
		}
		foreach ($arraydata as $key => $set) {
			$scoresets[$key] = 0;
			$scoresetcount[$key] = 0;
			$positive[$key] = 0;
			$negative[$key] = 0;
		}

		$this->db->select('bf_outfeedback.*,bf_opatients.name as pname,bf_opatients.patient_id as pid');
		$this->db->from('bf_outfeedback');
		$this->db->join('bf_opatients', 'bf_opatients.patient_id = bf_outfeedback.patientid', 'inner');

		if (isset($_SESSION['ward']) && $_SESSION['ward'] != 'ALL') {
			$this->db->where('bf_opatients.ward', $_SESSION['ward']);
		}
		$fdate = date('Y-m-d', strtotime($fdate) + 86399);
		$fdatet = date('Y-m-d H:i:s', strtotime($fdate) + 86399);
		$this->db->where('bf_outfeedback.datet <=', $fdatet);
		$this->db->where('bf_outfeedback.datet >=', $tdate);
		$this->db->order_by('datetime', 'desc');
		$query = $this->db->get();
		$feedbacktaken = $query->result();
		foreach ($arraydata as $key => $set) {
			$score = 0;
			$maxscore = 0;
			foreach ($feedbacktaken as $r) {
				$param = json_decode($r->dataset);
				foreach ($param as $k => $p) {
					if ($k == $key) {
						if ($p > 0) {
							$scoresets[$key] = $scoresets[$key] + $p;
							$scoresetcount[$key] = $scoresetcount[$key] + 1;					//print_r($key); 					//print_r($param); exit;		

							if ($p > 2) {
								$positive[$key] = $positive[$key] + 1;
							} else {
								if ($p != 0) {
									$negative[$key] = $negative[$key] + 1;
								}
							}
						}
					}
				}
			}
		}
		foreach ($scoresets as $k => $val) {
			$scoreseto[$k] = round(($val / ($scoresetcount[$k] * 5)) * 100);

			$positives[$k] = round(($positive[$k] / $scoresetcount[$k])   * 100);

			$positive[$k] = $positive[$k];

			$negative[$k] = $negative[$k];

			// $negative[$k] = round(($negative[$k]/$scoresetcount[$k])   * 100);

			$scoreset[$k] = $positive[$k] + $negative[$k];
		}
		arsort($scoreseto);

		$k = 0;
		$highestname = '';
		$lowestname = '';
		$highestvalue = '';
		$lowestvalue = '';
		foreach ($scoreseto as $key => $value) {
			if ($k == 0) {
				$highestname = $arraydata[$key];
				$highestvalue = $value;
				$k = 1;
			} else {
				$lowestname = $arraydata[$key];
				$lowestvalue = $value;
			}
		}
		$d1 = date('Md', strtotime($tdate));
		$d2 = date('Md', strtotime($fdatet));

		$message = 'Vyko Weekly Insights:%0a';
		$message .= 'The Highest and least performing feedback parameter from ' . $d1 . ' to ' . $d2 . ' are%0a';
		$message .= $highestname . ':' . $highestvalue . '%25%0a';
		$message .= $lowestname . ':' . $lowestvalue . '%25';

		$TEMPID = '1607100000000085000';
		$user = $this->get_user_by_sms_activity('OP-WEEKLY-TOP-&-LEAST-PERFORMING-PARAMETERS-SMS');
		foreach ($user as $rowuser) {
			$number = $rowuser->mobile;
			$this->sendsms($message, $number, $TEMPID);
		}
	}



	public function monthlyinsighthighlow()
	{
		//$fdate = date('Y-m-d');
		$fdate = date('Y-m-d', strtotime('-1 days'));
		$tdate = date('Y-m-d', strtotime('-30 days'));
		$this->db->order_by('id');
		$query = $this->db->get('setupop');
		$sresult = $query->result();
		$setarray = array();
		$questioarray = array();
		foreach ($sresult as $r) {
			$setarray[$r->type] = $r->title;
		}
		foreach ($sresult as $r) {
			$questioarray[$r->type][$r->shortkey] = $r->shortname;
		}
		$arraydata = array();
		foreach ($questioarray as $setr) {
			foreach ($setr as $k => $v) {
				$arraydata[$k] = $v;
			}
		}
		foreach ($arraydata as $key => $set) {
			$scoresets[$key] = 0;
			$scoresetcount[$key] = 0;
			$positive[$key] = 0;
			$negative[$key] = 0;
		}

		$this->db->select('bf_outfeedback.*,bf_opatients.name as pname,bf_opatients.patient_id as pid');
		$this->db->from('bf_outfeedback');
		$this->db->join('bf_opatients', 'bf_opatients.patient_id = bf_outfeedback.patientid', 'inner');

		if (isset($_SESSION['ward']) && $_SESSION['ward'] != 'ALL') {
			$this->db->where('bf_opatients.ward', $_SESSION['ward']);
		}
		$fdate = date('Y-m-d', strtotime($fdate) + 86399);
		$fdatet = date('Y-m-d H:i:s', strtotime($fdate) + 86399);
		$this->db->where('bf_outfeedback.datet <=', $fdatet);
		$this->db->where('bf_outfeedback.datet >=', $tdate);
		$this->db->order_by('datetime', 'desc');
		$query = $this->db->get();
		$feedbacktaken = $query->result();
		foreach ($arraydata as $key => $set) {
			$score = 0;
			$maxscore = 0;
			foreach ($feedbacktaken as $r) {
				$param = json_decode($r->dataset);
				foreach ($param as $k => $p) {
					if ($k == $key) {
						if ($p > 0) {
							$scoresets[$key] = $scoresets[$key] + $p;
							$scoresetcount[$key] = $scoresetcount[$key] + 1;					//print_r($key); 					//print_r($param); exit;		

							if ($p > 2) {
								$positive[$key] = $positive[$key] + 1;
							} else {
								if ($p != 0) {
									$negative[$key] = $negative[$key] + 1;
								}
							}
						}
					}
				}
			}
		}
		foreach ($scoresets as $k => $val) {
			$scoreseto[$k] = round(($val / ($scoresetcount[$k] * 5)) * 100);

			$positives[$k] = round(($positive[$k] / $scoresetcount[$k])   * 100);

			$positive[$k] = $positive[$k];

			$negative[$k] = $negative[$k];

			// $negative[$k] = round(($negative[$k]/$scoresetcount[$k])   * 100);

			$scoreset[$k] = $positive[$k] + $negative[$k];
		}
		arsort($scoreseto);

		$k = 0;
		$highestname = '';
		$lowestname = '';
		$highestvalue = '';
		$lowestvalue = '';
		foreach ($scoreseto as $key => $value) {
			if ($k == 0) {
				$highestname = $arraydata[$key];
				$highestvalue = $value;
				$k = 1;
			} else {
				$lowestname = $arraydata[$key];
				$lowestvalue = $value;
			}
		}
		$d1 = date('Md', strtotime($tdate));
		$d2 = date('Md', strtotime($fdatet));

		$message = 'Vyko Monthly Insights:%0a';
		$message .= 'The Highest and least performing feedback parameter from ' . $d1 . ' to ' . $d2 . ' are%0a';
		$message .= $highestname . ':' . $highestvalue . '%25%0a';
		$message .= $lowestname . ':' . $lowestvalue . '%25';

		$TEMPID = '1607100000000085001';
		$user = $this->get_user_by_sms_activity('OP-MONTHLY-TOP-&-LEAST-PERFORMING-PARAMETERS-SMS');
		foreach ($user as $rowuser) {
			$number = $rowuser->mobile;
			$this->sendsms($message, $number, $TEMPID);
		}
	}

	public function weeklyratinganalysis()
	{
		//$fdate = date('Y-m-d');
		$fdate = date('Y-m-d', strtotime('-1 days'));
		$tdate = date('Y-m-d 00:00:00', strtotime('-7 days'));

		$this->db->select('bf_outfeedback.*,bf_opatients.name as pname,bf_opatients.patient_id as pid');
		$this->db->from('bf_outfeedback');
		$this->db->join('bf_opatients', 'bf_opatients.patient_id = bf_outfeedback.patientid', 'inner');

		if (isset($_SESSION['ward']) && $_SESSION['ward'] != 'ALL') {
			$this->db->where('bf_opatients.ward', $_SESSION['ward']);
		}
		$fdate = date('Y-m-d', strtotime($fdate) + 86399);
		$fdatet = date('Y-m-d H:i:s', strtotime($fdate) + 86399);
		$this->db->where('bf_outfeedback.datet <=', $fdatet);
		$this->db->where('bf_outfeedback.datet >=', $tdate);
		$this->db->order_by('datetime', 'desc');
		$query = $this->db->get();
		$feedbacktaken = $query->result();
		$for5 = array();
		$for4 = array();
		$for3 = array();
		$for2 = array();
		$for1 = array();
		$for1 = array();
		$for = array();
		foreach ($feedbacktaken as $row) {
			$param = json_decode($row->dataset);
			if ($param->overallScore == 5) {
				$for5['overallScore'] = $for5['overallScore'] + 1;
			}
			if ($param->overallScore == 4) {
				$for4['overallScore'] = $for4['overallScore'] + 1;
			}
			if ($param->overallScore == 3) {
				$for3['overallScore'] = $for3['overallScore'] + 1;
			}
			if ($param->overallScore == 2) {
				$for2['overallScore'] = $for2['overallScore'] + 1;
			}
			if ($param->overallScore == 1) {
				$for1['overallScore'] = $for1['overallScore'] + 1;
			}
			$for['overallScore'] = $for['overallScore'] + 1;
			$for['overallScoresum'] = $for['overallScoresum'] + $param->overallScore;
		}

		$d1 = date('Md', strtotime($tdate));
		$d2 = date('Md', strtotime($fdatet));
		$average = round(round($for['overallScoresum'] / ($for['overallScore'] * 5), 1) * 5, 1);
		$value5 = round((($for5['overallScore'] * 5) / ($for['overallScore'] * 5)) * 100, 1);
		$value4 = round((($for4['overallScore'] * 5) / ($for['overallScore'] * 5)) * 100, 1);
		$value3 = round((($for3['overallScore'] * 5) / ($for['overallScore'] * 5)) * 100, 1);
		$value2 = round((($for2['overallScore'] * 5) / ($for['overallScore'] * 5)) * 100, 1);
		$value1 = round((($for1['overallScore'] * 5) / ($for['overallScore'] * 5)) * 100, 1);
		$message = 'Vyko Weekly Insights:%0a';
		$message .= 'Average patient rating from ' . $d1 . ' to ' . $d2 . '-' . $average . '/5%0a';
		$message .= 'Excellent:' . $value5 . '%25%0a';
		$message .= 'Very Good:' . $value4 . '%25%0a';
		$message .= 'Good:' . $value3 . '%25%0a';
		$message .= 'Poor:' . $value2 . '%25%0a';
		$message .= 'Worst:' . $value1 . '%25%0a';

		$TEMPID = '1607100000000085002';
		$user = $this->get_user_by_sms_activity('OP-WEEKLY-RATING-ANALYSIS-SMS');
		foreach ($user as $rowuser) {
			$number = $rowuser->mobile;
			$this->sendsms($message, $number, $TEMPID);
		}
	}


	public function monthlyratinganalysis()
	{
		//$fdate = date('Y-m-d');
		$fdate = date('Y-m-d', strtotime('-1 days'));
		$tdate = date('Y-m-d', strtotime('-30 days'));

		$this->db->select('bf_outfeedback.*,bf_opatients.name as pname,bf_opatients.patient_id as pid');
		$this->db->from('bf_outfeedback');
		$this->db->join('bf_opatients', 'bf_opatients.patient_id = bf_outfeedback.patientid', 'inner');

		if (isset($_SESSION['ward']) && $_SESSION['ward'] != 'ALL') {
			$this->db->where('bf_opatients.ward', $_SESSION['ward']);
		}
		$fdate = date('Y-m-d', strtotime($fdate) + 86399);
		$fdatet = date('Y-m-d H:i:s', strtotime($fdate) + 86399);
		$this->db->where('bf_outfeedback.datet <=', $fdatet);
		$this->db->where('bf_outfeedback.datet >=', $tdate);
		$this->db->order_by('datetime', 'desc');
		$query = $this->db->get();
		$feedbacktaken = $query->result();
		$for5 = array();
		$for4 = array();
		$for3 = array();
		$for2 = array();
		$for1 = array();
		$for1 = array();
		$for = array();
		foreach ($feedbacktaken as $row) {
			$param = json_decode($row->dataset);
			if ($param->overallScore == 5) {
				$for5['overallScore'] = $for5['overallScore'] + 1;
			}
			if ($param->overallScore == 4) {
				$for4['overallScore'] = $for4['overallScore'] + 1;
			}
			if ($param->overallScore == 3) {
				$for3['overallScore'] = $for3['overallScore'] + 1;
			}
			if ($param->overallScore == 2) {
				$for2['overallScore'] = $for2['overallScore'] + 1;
			}
			if ($param->overallScore == 1) {
				$for1['overallScore'] = $for1['overallScore'] + 1;
			}
			$for['overallScore'] = $for['overallScore'] + 1;
			$for['overallScoresum'] = $for['overallScoresum'] + $param->overallScore;
		}

		$d1 = date('Md', strtotime($tdate));
		$d2 = date('Md', strtotime($fdatet));
		$average = round(round($for['overallScoresum'] / ($for['overallScore'] * 5), 1) * 5, 1);
		$value5 = round((($for5['overallScore'] * 5) / ($for['overallScore'] * 5)) * 100, 1);
		$value4 = round((($for4['overallScore'] * 5) / ($for['overallScore'] * 5)) * 100, 1);
		$value3 = round((($for3['overallScore'] * 5) / ($for['overallScore'] * 5)) * 100, 1);
		$value2 = round((($for2['overallScore'] * 5) / ($for['overallScore'] * 5)) * 100, 1);
		$value1 = round((($for1['overallScore'] * 5) / ($for['overallScore'] * 5)) * 100, 1);
		$message = 'Vyko Monthly Insights:%0a';
		$message .= 'Average patient rating from ' . $d1 . ' to ' . $d2 . '-' . $average . '/5%0a';
		$message .= 'Excellent:' . $value5 . '%25%0a';
		$message .= 'Very Good:' . $value4 . '%25%0a';
		$message .= 'Good:' . $value3 . '%25%0a';
		$message .= 'Poor:' . $value2 . '%25%0a';
		$message .= 'Worst:' . $value1 . '%25%0a';

		$TEMPID = '1607100000000085003';
		$user = $this->get_user_by_sms_activity('OP-MONTHLY-RATING-ANALYSIS-SMS');
		foreach ($user as $rowuser) {
			$number = $rowuser->mobile;
			$this->sendsms($message, $number, $TEMPID);
		}
	}

	public function sendsms($sms, $mobile, $TEMPID)
	{
		/*$username = 'di78-ehrapp';
		$password = 'digi123';
		$senderid = 'FEEDOR';
		//$number = '7892845605';
		$setting = $this->db->get('setting')->result();
		$HID = $setting[0]->description;
		$COMPANYNAME = '-%20ITATONE';
		
		$number = $mobile;
		$sms = str_replace('&','and',$sms);
		$sms = str_replace('NAN','0',$sms);
		$message = 'HID:'.$HID.'%0a'.str_replace(' ','%20',$sms).'%0a'.$COMPANYNAME;;
		
		//exit;
		echo $url = 'http://sms.digimiles.in/bulksms/bulksms?username='.$username.'&password='.$password.'&type=0&dlr=1&entityid=1201159118005685119&tempid='.$TEMPID.'&destination='.$number.'&source='.$senderid.'&message='.$message;
		//exit;
		$curl_handle=curl_init();
		  curl_setopt($curl_handle,CURLOPT_URL,$url);
		  curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,2);
		  curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,1);
		  $buffer = curl_exec($curl_handle);
		  curl_close($curl_handle);
		  if (empty($buffer)){
			  print "Nothing returned from url.<p>";
		  }
		  else{
			  echo 'Done';
			  print $buffer;
		  }*/
		$setting = $this->db->get('setting')->result();
		$HID = $setting[0]->description;
		$COMPANYNAME = '-%20ITATONE';
		$number = $mobile;
		//$number = 7349519468;

		$sms = 'HID:' . $HID . '%0a' . str_replace(' ', '%20', $sms) . '%0a' . $COMPANYNAME;
		$number = $mobile;
		//$number = 7349519468;
		$sms = str_replace(' ', '%20', $sms);
		$sms = str_replace('&', 'and', $sms);
		$sms = str_replace('NAN', '0', $sms);

		include('/home/efeedor/globalconfig.php');
		$query = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`,`template_id`, `HID`) VALUES ("message","' . $sms . '",0,"' . $mobile . '","' . $TEMPID . '","' . $HID . '")';
		$conn_g->query($query);

		$conn_g->close();
		/*$d = array(
				'type'=>'message',
				'status'=>0,
				'mobile_email'=>$mobile,
				'message'=>$sms,
				'template_id'=>$TEMPID
			 );
		$this->db->insert('notification',$d);*/
	}

	public function shedule_messages()
	{
		//$section = array('IP','OP','HC','EM');
		$shedules = $this->db->get('shedule_notification')->result();

		foreach ($shedules as $row) {
			$day = date('l');
			$hour = date('H');
			$min = date('i');
			$date = date('d');
			$hourapi = date('H', strtotime($row->time));
			$dateapi = $row->datevalue;
			$minapi = date('i', strtotime($row->time));
			$dayapi = $row->day;
			if (strpos($row->path, 'email') === false) {
				if (strpos($row->path, 'message/') === false) {
					$fun = str_replace('/', '', str_replace('messageop/', '', $row->path));
					if ($row->datevalue == 0) {
						if ($day == $dayapi && $hour == $hourapi && $min == $minapi) {
							//echo $fun; exit;
							$this->$fun($r);
						}
					} else {
						if ($date == $dateapi && $hour == $hourapi && $min == $minapi) {
							$this->$fun($r);
						}
					}
				}
			}
		}
	}
}
