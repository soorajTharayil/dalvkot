<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Email_ip_notification_op extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_user_by_email_activity($type)
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

	public function weeklyreport()
	{
		$fdate = date('Y-m-d', strtotime('-1 days'));
		$tdate = date('Y-m-d 00:00:00', strtotime('-7 days'));
		$this->db->select('bf_outfeedback.*,bf_opatients.name as pname,bf_opatients.patient_id as pid');
		$this->db->from('bf_outfeedback');
		$this->db->join('bf_opatients', 'bf_opatients.patient_id = bf_outfeedback.patientid', 'inner');
		$fdate = date('Y-m-d', strtotime($fdate) + 86399);
		$fdatet = date('Y-m-d 23:59:59', strtotime($fdate));
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

		$pdfdownloadlink = base_url() . 'pdfreport/op_report?fdate=' . date('Y-m-d', strtotime($fdatet)) . '&tdate=' . date('Y-m-d', strtotime($tdate)) . '';
		$html = '<p>Hi,</p>
		<p>Here are your weekly OP feedbacks and tickets report for the period ' . $d1 . ' to ' . $d2 . '.</p>
		<table border="1" cellspacing="0" style="width:100%" cellpadding="5">
			<tbody>
				<tr>
					<td>
						Total feedbacks
					</td>
					<td>
						' . count($feedbacktaken) . '
					</td>
				</tr>
				<tr>
					<td>
						Satisfied Patients
					</td>
					<td>
						' . (count($feedbacktaken) - $below3) . '
					</td>
				</tr>
				<tr>
					<td>
						Unsatisfied Patients
					</td>
					<td>
						' . $below3 . '
					</td>
				</tr>
				<tr>
					<td>
						Satisfaction Index
					</td>
					<td>
						' . round((count($feedbacktaken) - $below3) / (count($feedbacktaken)) * 100) . '%
					</td>
				</tr>
				<tr>
					<td>
						Net promoter score
					</td>
					<td>
						' . round(($promoter / ($depromoter + $promoter + $passive)) * 100) . '%
					</td>
				</tr>
				<tr>
					<td>
						Total tickets
					</td>
					<td>
						' . count($tickets) . '
					</td>
				</tr>
				<tr>
					<td>
						Open tickets
					</td>
					<td>
						' . $opent . '
					</td>
				</tr>
				<tr>
					<td>
						Closed tickets
					</td>
					<td>
						' . $closedt . '
					</td>
				</tr>
		
			</tbody>
		</table>';

		$html .= '<p>Tickets by department:</p>
		<table border="1" cellspacing="0" style="width:100%" cellpadding="5">
			<tbody>
				<tr>
					<td>Department</td>
					<td>Total tickets</td>
					<td>Open Tickets</td>
					<td>Closed Tickets</td>
				</tr>';
		$ticketdepart = arsort($ticketbydepartment);

		foreach ($ticketbydepartment as $key => $depart) {
			$closed = $ticketbydepartment[$key] - $ticketbydepartmentopen[$key];
			$open = $ticketbydepartmentopen[$key] * 1;
			$html .= '<tr>
						<td>' . $ticketbydepartmentname[$key] . '</td>
						<td>' . $ticketbydepartment[$key] . '</td>
						<td>' . $open . '</td>
						<td>' . $closed . '</td>
					</tr>';
		}
		$html .= '</tbody></table>';
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
		$average = round((($for5['overallScore'] * 5 + $for4['overallScore'] * 4 + $for3['overallScore'] * 3 + $for2['overallScore'] * 2 + $for1['overallScore'] * 1) / ($for['overallScore'] * 5)) * 5, 1);
		$value5 = round((($for5['overallScore'] * 5) / ($for['overallScore'] * 5)) * 100, 1);
		$value4 = round((($for4['overallScore'] * 5) / ($for['overallScore'] * 5)) * 100, 1);
		$value3 = round((($for3['overallScore'] * 5) / ($for['overallScore'] * 5)) * 100, 1);
		$value2 = round((($for2['overallScore'] * 5) / ($for['overallScore'] * 5)) * 100, 1);
		$value1 = round((($for1['overallScore'] * 5) / ($for['overallScore'] * 5)) * 100, 1);
		$html .= '<p>Patients Rating Analysis:</p>
				<p>The Average Patient rating is ' . $average . ' out of 5</p>
				<p>Rating Breakdown:</p>
				<table border="1" cellspacing="0" style="width:100%" cellpadding="5">
					<tbody>
						<tr>
							<td>Rating Scale</td>
							<td>Percentage of Patients</td>
							<td>No. of Patients</td>
						</tr>
						<tr>
							<td>Excellent</td>
							<td>' . round($value5) . '%</td>
							<td>' . $for5['overallScore'] . '</td>
						</tr>
						<tr>
							<td>Very good</td>
							<td>' . round($value4) . '%</td>
							<td>' . $for4['overallScore'] . '</td>
						</tr>
						<tr>
							<td>Good</td>
							<td>' . round($value3) . '%</td>
							<td>' . $for3['overallScore'] . '</td>
						</tr>
						<tr>
							<td>Poor</td>
							<td>' . round($value2) . '%</td>
							<td>' . $for2['overallScore'] . '</td>
						</tr>
						<tr>
							<td>Worst</td>
							<td>' . round($value1) . '%</td>
							<td>' . $for1['overallScore'] . '</td>
						</tr>
					</tbody>
				</table>';
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
		$html .= '<p>Feedback parameters Analysis:</p>
						<ul>
							<li>The highest performing feedback parameter for the week is ' . $highestname . ' with ' . $highestvalue . '% score. </li>
						</ul>

						<ul>
							<li>The least performing feedback parameter for the week is ' . $lowestname . ' with ' . $lowestvalue . '% score.</li>
						</ul>

						<p>Please login to the below link for detailed view and find attached detailed reports for further references.</p>

						<p>' . base_url() . '</p>

						<p>-</p>
						
						<p>To view the overall feedback reports in PDF format, kindly click the below link:</p>

						<p><a href="' . $pdfdownloadlink . '">' . $pdfdownloadlink . '</a></p>

						<p>Vyko Feedback System</p>';
		$subject = 'Vyko: Weekly OP feedbacks & tickets report';

		$user = $this->get_user_by_email_activity('OP-WEEKLY-FEEDBACKS-REPORT-EMAILS');
		foreach ($user as $rowuser) {
			$emails = $rowuser->email;
			$this->mailsend($html, $subject, $emails);
		}
	}

	public function monthlyreport()
	{
		$fdate = date('Y-m-d', strtotime('-1 days'));
		$tdate = date('Y-m-d', strtotime('-30 days'));
		$this->db->select('bf_outfeedback.*,bf_opatients.name as pname,bf_opatients.patient_id as pid');
		$this->db->from('bf_outfeedback');
		$this->db->join('bf_opatients', 'bf_opatients.patient_id = bf_outfeedback.patientid', 'inner');
		$fdate = date('Y-m-d', strtotime($fdate) + 3600 * 12);
		$fdatet = date('Y-m-d 23:59:59', strtotime($fdate));
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

		$pdfdownloadlink = base_url() . 'pdfreport/op_report?fdate=' . date('Y-m-d', strtotime($fdatet)) . '&tdate=' . date('Y-m-d', strtotime($tdate)) . '';


		$html = '<p>Hi,</p>
		<p>Here are your Monthly OP feedbacks and tickets report for the period ' . $d1 . ' to ' . $d2 . '.</p>
		<table border="1" cellspacing="0" style="width:100%" cellpadding="5">
			<tbody>
				<tr>
					<td>
						Total feedbacks
					</td>
					<td>
						' . count($feedbacktaken) . '
					</td>
				</tr>
				<tr>
					<td>
						Satisfied Patients
					</td>
					<td>
						' . (count($feedbacktaken) - $below3) . '
					</td>
				</tr>
				<tr>
					<td>
						Unsatisfied Patients
					</td>
					<td>
						' . $below3 . '
					</td>
				</tr>
				<tr>
					<td>
						Satisfaction Index
					</td>
					<td>
						' . round((count($feedbacktaken) - $below3) / (count($feedbacktaken)) * 100) . '%
					</td>
				</tr>
				<tr>
					<td>
						Net promoter score
					</td>
					<td>
						' . round(($promoter / ($depromoter + $promoter + $passive)) * 100) . '%
					</td>
				</tr>
				<tr>
					<td>
						Total tickets
					</td>
					<td>
						' . count($tickets) . '
					</td>
				</tr>
				<tr>
					<td>
						Open tickets
					</td>
					<td>
						' . $opent . '
					</td>
				</tr>
				<tr>
					<td>
						Closed tickets
					</td>
					<td>
						' . $closedt . '
					</td>
				</tr>
		
			</tbody>
		</table>';

		$html .= '<p>Tickets by department:</p>
		<table border="1" cellspacing="0" style="width:100%" cellpadding="5">
			<tbody>
				<tr>
					<td>Department</td>
					<td>Total tickets</td>
					<td>Open Tickets</td>
					<td>Closed Tickets</td>
				</tr>';
		$ticketdepart = arsort($ticketbydepartment);

		foreach ($ticketbydepartment as $key => $depart) {
			$closed = $ticketbydepartment[$key] - $ticketbydepartmentopen[$key];
			$open = $ticketbydepartmentopen[$key] * 1;
			$html .= '<tr>
						<td>' . $ticketbydepartmentname[$key] . '</td>
						<td>' . $ticketbydepartment[$key] . '</td>
						<td>' . $open . '</td>
						<td>' . $closed . '</td>
					</tr>';
		}
		$html .= '</tbody></table>';
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
		$average = round((($for5['overallScore'] * 5 + $for4['overallScore'] * 4 + $for3['overallScore'] * 3 + $for2['overallScore'] * 2 + $for1['overallScore'] * 1) / ($for['overallScore'] * 5)) * 5, 1);
		$value5 = round((($for5['overallScore'] * 5) / ($for['overallScore'] * 5)) * 100, 1);
		$value4 = round((($for4['overallScore'] * 5) / ($for['overallScore'] * 5)) * 100, 1);
		$value3 = round((($for3['overallScore'] * 5) / ($for['overallScore'] * 5)) * 100, 1);
		$value2 = round((($for2['overallScore'] * 5) / ($for['overallScore'] * 5)) * 100, 1);
		$value1 = round((($for1['overallScore'] * 5) / ($for['overallScore'] * 5)) * 100, 1);
		$html .= '<p>Patients Rating Analysis:</p>
				<p>The Average Patient rating is ' . $average . ' out of 5</p>
				<p>Rating Breakdown:</p>
				<table border="1" cellspacing="0" style="width:100%" cellpadding="5">
					<tbody>
						<tr>
							<td>Rating Scale</td>
							<td>Percentage of Patients</td>
							<td>No. of Patients</td>
						</tr>
						<tr>
							<td>Excellent</td>
							<td>' . $value5 . '%</td>
							<td>' . $for5['overallScore'] . '</td>
						</tr>
						<tr>
							<td>Very good</td>
							<td>' . $value4 . '%</td>
							<td>' . $for4['overallScore'] . '</td>
						</tr>
						<tr>
							<td>Good</td>
							<td>' . $value3 . '%</td>
							<td>' . $for3['overallScore'] . '</td>
						</tr>
						<tr>
							<td>Poor</td>
							<td>' . $value2 . '%</td>
							<td>' . $for2['overallScore'] . '</td>
						</tr>
						<tr>
							<td>Worst</td>
							<td>' . $value1 . '%</td>
							<td>' . $for1['overallScore'] . '</td>
						</tr>
					</tbody>
				</table>';
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
		$html .= '<p>Feedback parameters Analysis:</p>
						<ul>
							<li>The highest performing feedback parameter for the week is ' . $highestname . ' with ' . $highestvalue . '% score. </li>
						</ul>

						<ul>
							<li>The least performing feedback parameter for the week is ' . $lowestname . ' with ' . $lowestvalue . '% score.</li>
						</ul>

						<p>Please login to the below link for detailed view and find attached detailed reports for further references.</p>

						<p>' . base_url() . '</p>

						<p>-</p>
						<p>To view the overall feedback reports in PDF format, kindly click the below link:</p>

						<p><a href="' . $pdfdownloadlink . '">' . $pdfdownloadlink . '</a></p>

						<p>Vyko Feedback System</p>';
		$subject = 'Vyko: Monthly OP feedbacks & tickets report';
		$user = $this->get_user_by_email_activity('OP-MONTHLY-FEEDBACKS-REPORT-EMAILS');
		foreach ($user as $rowuser) {
			$emails = $rowuser->email;
			$this->mailsend($html, $subject, $emails);
		}
	}


	public function weeklynpsreport()
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
		$fdatet = date('Y-m-d 23:59:59', strtotime($fdate));
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
		$total = $depromoter + $promoter + $passive;

		$html = '<p>Hi,</p>
				<p>Here is your Net Promoter Analysis report on OutPatients for the period ' . $d1 . ' to ' . $d2 . ':</p>
				<p>Net Promoters Score: ' . $permoterpercentage . '%</p>
				<p>No. of Promoters: ' . $promoter . ' out of ' . $total . '</p>
				<p>No. of Demoters: ' . $depromoter . ' out of ' . $total . '</p>
				<p>No. of Passive: ' . $passive . ' out of ' . $total . '</p>
				<p>&nbsp;</p>
				
				<p>&nbsp;</p>
				<p>Please login to the below link for detailed view and find attached detailed reports for further references.</p>
				<p>' . base_url() . '</p>
				<p>-</p>
				<p>Vyko Feedback System</p>';
		$subject = 'Vyko: Weekly NPS Analysis on OutPatients';
		$user = $this->get_user_by_email_activity('OP-WEEKLY-NPS-REPORT-EMAILS');
		foreach ($user as $rowuser) {
			$emails = $rowuser->email;
			$this->mailsend($html, $subject, $emails);
		}
	}

	public function monthlynpsreport()
	{
		$fdate = date('Y-m-d', strtotime('-1 days'));
		$tdate = date('Y-m-d', strtotime('-30 days'));
		$this->db->select('bf_outfeedback.*,bf_opatients.name as pname,bf_opatients.patient_id as pid');
		$this->db->from('bf_outfeedback');
		$this->db->join('bf_opatients', 'bf_opatients.patient_id = bf_outfeedback.patientid', 'inner');

		if (isset($_SESSION['ward']) && $_SESSION['ward'] != 'ALL') {
			$this->db->where('bf_opatients.ward', $_SESSION['ward']);
		}

		$fdate = date('Y-m-d', strtotime($fdate) + 3600 * 12);
		$fdatet = date('Y-m-d 23:59:59', strtotime($fdate));
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
		$total = $depromoter + $promoter + $passive;

		$html = '<p>Hi,</p>
				<p>Here is your Net Promoter Analysis report on OutPatients for the period ' . $d1 . ' to ' . $d2 . ':</p>
				<p>Net Promoters Score: ' . $permoterpercentage . '%</p>
				<p>No. of Promoters: ' . $promoter . ' out of ' . $total . '</p>
				<p>No. of Demoters: ' . $depromoter . ' out of ' . $total . '</p>
				<p>No. of Passive: ' . $passive . ' out of ' . $total . '</p>
				<p>&nbsp;</p>
				
				<p>&nbsp;</p>
				<p>Please login to the below link for detailed view and find attached detailed reports for further references.</p>
				<p>' . base_url() . '</p>
				<p>-</p>
				<p>Vyko Feedback System</p>';
		$subject = 'Vyko: Monthly NPS Analysis on OutPatients';
		$user = $this->get_user_by_email_activity('OP-WEEKLY-HOSPITAL-SELECTION-ANALYSIS-EMAILS');
		foreach ($user as $rowuser) {
			$emails = $rowuser->email;
			$this->mailsend($html, $subject, $emails);
		}
	}

	public function weeklypatientreport()
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
		$fdate = date('Y-m-d', strtotime($fdate) + 86399);
		$fdatet = date('Y-m-d 23:59:59', strtotime($fdate));
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

		$ratebartext = '';
		$ratebarparanamev = '';
		$t = 0;
		$selectionarray = array();
		$selectionarrayname = array();
		$selectionarrayvalue = array();
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
				$percentage = ($count / $tcount) * 100;
			} else {
				$percentage = 0;
			}
			$selectionarray[$row] = round($percentage, 2);
			$selectionarrayname[$row] = $v;
			$selectionarrayvalue[$row] = $count;
		}

		$d1 = date('Md', strtotime($tdate));
		$d2 = date('Md', strtotime($fdatet));
		arsort($selectionarray);

		$html = '<p>Hi,</p>
				<p>Out of ' . $tcount . ' OutPatients who have submitted feedbacks between ' . $d1 . ' to ' . $d2 . ', find out how many of them have selected your hospital for different reasons.</p>';
		$html .= '<table style="width:100%" cellpadding="5"  border="1"><tr><td>Basis of Hospital selection</td><td>Percentage of Patients</td><td>	No. of Patients</td></tr>';
		foreach ($selectionarray as $key => $value) {
			$html .= '<tr>
						<td>' . $selectionarrayname[$key] . '</td>
						<td>' . round($value) . '%</td>
						<td>' . $selectionarrayvalue[$key] . '</td>
					</tr>';
		}
		$html .= '<table>';

		$html .= '<p>&nbsp;</p>
				<p>Please login to the below link for detailed view and find attached detailed reports for further references.</p>
				<p>' . base_url() . '</p>
				<p>-</p>
				<p>Vyko Feedback System</p>';
		$subject = 'Vyko: Weekly Analysis on why your outpatients chose your hospital?';
		$user = $this->get_user_by_email_activity('OP-WEEKLY-FEEDBACKS-REPORT-EMAILS');
		foreach ($user as $rowuser) {
			$emails = $rowuser->email;
			$this->mailsend($html, $subject, $emails);
		}
	}

	public function monthlypatientreport()
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
		$fdate = date('Y-m-d', strtotime($fdate) + 3600 * 12);
		$fdatet = date('Y-m-d 23:59:59', strtotime($fdate));
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

		$ratebartext = '';
		$ratebarparanamev = '';
		$t = 0;
		$selectionarray = array();
		$selectionarrayname = array();
		$selectionarrayvalue = array();
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
				$percentage = ($count / $tcount) * 100;
			} else {
				$percentage = 0;
			}
			$selectionarray[$row] = round($percentage, 2);
			$selectionarrayname[$row] = $v;
			$selectionarrayvalue[$row] = $count;
		}


		arsort($selectionarray);
		$d1 = date('Md', strtotime($tdate));
		$d2 = date('Md', strtotime($fdatet));
		$html = '<p>Hi,</p>
				<p>Out of ' . $tcount . ' OutPatients who have submitted feedbacks between ' . $d1 . ' to ' . $d2 . ', find out how many of them have selected your hospital for different reasons.</p>';
		$html .= '<table style="width:100%" cellpadding="5"  border="1"><tr><td>Basis of Hospital selection</td><td>Percentage of Patients</td><td>	No. of Patients</td></tr>';
		foreach ($selectionarray as $key => $value) {
			$html .= '<tr>
						<td>' . $selectionarrayname[$key] . '</td>
						<td>' . round($value) . '%</td>
						<td>' . $selectionarrayvalue[$key] . '</td>
					</tr>';
		}
		$html .= '<table>';

		$html .= '<p>&nbsp;</p>
				<p>Please login to the below link for detailed view and find attached detailed reports for further references.</p>
				<p>' . base_url() . '</p>
				<p>-</p>
				<p>Vyko Feedback System</p>';
		$subject = 'Vyko: Monthly Analysis on why your outpatients chose your hospital?';
		$user = $this->get_user_by_email_activity('OP-MONTHLY-HOSPITAL-SELECTION-ANALYSIS-EMAILS');
		foreach ($user as $rowuser) {
			$emails = $rowuser->email;
			$this->mailsend($html, $subject, $emails);
		}
	}

	public function shedule_messages()
	{


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
			//echo $row->path;
			//var_dump(strpos($row->path, 'email_ip_notification'));
			if (strpos($row->path, 'email_ip_notification_op') === 0) {
				$fun = str_replace('/', '', str_replace('email_ip_notification_op/', '', $row->path));
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

		echo 'DONE';
	}

	public function mailsend($html, $subject, $emails)
	{

		$setting = $this->db->get('setting')->result();
		$HID = $setting[0]->description;
		$html = 'HID:' . $HID . '<br />' . $html;
		$subject = 'HID:' . $HID . '-' . $subject;
		/*$config = Array(
			'protocol' => 'smtp',
			'smtp_host' => 'mail.Vyko.com',
			'smtp_port' => 25,
			'smtp_user' => 'app@Vyko.com',
			'smtp_pass' => 'admin#@12399',
			'mailtype'  => 'html', 
			'charset' => 'utf-8',
			'wordwrap' => TRUE

		);
		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");
		$this->email->set_mailtype("html");
		//$this->email->set_header('Content-Type', 'text/html');
		$email_body =$html;
		$this->email->from('app@efeedor.com', 'EFEEDOR FEEDBACK SYSTEM');

		//$list = array('dreamvishnu@gmail.com');
		//$list = array('manu@efeedor.com');
		$list = array($emails);
		$this->email->to($list);
		$this->email->subject($subject);
		$this->email->message($email_body);
		$this->email->send();
		$error =  $this->email->print_debugger();*/
		include('/home/efeedor/globalconfig.php');

		$query = 'INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`,`subject` ,`HID`) VALUES ("email","' . $conn_g->real_escape_string($html) . '",0,"' . $conn_g->real_escape_string($emails) . '","' . $conn_g->real_escape_string($subject) . '","' . $HID . '")';

		$conn_g->query($query);

		$conn_g->close();
	}
}
