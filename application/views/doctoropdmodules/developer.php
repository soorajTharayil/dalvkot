


<?php

include 'ip_table_variables.php';


$sresult = $this->opf_model->setup_result($setup);




$for5 = array();
$for4 = array();
$for3 = array();
$for2 = array();
$for1 = array();
$for1 = array();
$for = array();
foreach ($ip_feedbacks_count as $row) {
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
$value5 = round((($for5['overallScore'] * 5) / ($for['overallScore'] * 5)) * 100, 1) * 1;
$value4 = round((($for4['overallScore'] * 5) / ($for['overallScore'] * 5)) * 100, 1) * 1;
$value3 = round((($for3['overallScore'] * 5) / ($for['overallScore'] * 5)) * 100, 1) * 1;
$value2 = round((($for2['overallScore'] * 5) / ($for['overallScore'] * 5)) * 100, 1) * 1;
$value1 = round((($for1['overallScore'] * 5) / ($for['overallScore'] * 5)) * 100, 1) * 1;

$this->db->select($table_tickets . '.*');
$this->db->from($table_tickets);

$this->db->join($table_feedback, $table_feedback . '.id =' . $table_tickets . '.feedbackid', 'left');
$this->db->join($table_patients, $table_patients . '.id =' .  $table_feedback . '.pid', 'left');
$this->db->where($table_feedback . '.datet <=', $fdatet);
$this->db->where($table_feedback . '.datet >=', $tdate);
$this->db->order_by('datetime', $desc);
$query = $this->db->get();
$ticket = $query->result();

$tickets = array();
$ticketbydepartment = array();
$ticketbydepartmentopen = array();
$ticketbydepartmentname = array();
foreach ($ticket as $row) {
	$this->db->where('id', $row->feedbackid);
	$query = $this->db->get($table_feedback);
	$patient = $query->result();

	$this->db->where('dprt_id', $row->departmentid);
	$query = $this->db->get('department');
	$department = $query->result();

	$slug2 = preg_replace('/[^A-Za-z0-9-]+/', ' ', $department[0]->description);
	$row->slug = $slug2;
	$slug = $patient[0]->id . preg_replace('/[^A-Za-z0-9-]+/', ' ', $department[0]->description);
	$tickets[] = $row;

	$ticketbydepartment[$slug2] = $ticketbydepartment[$slug2] * 1 + 1;
	$ticketbydepartmentname[$slug2] = $department[0]->description;
}




foreach ($tickets as $t) {
	if ($t->status == 'Open') {
		$opent++;
		$ticketbydepartmentopen[$t->slug] = $ticketbydepartmentopen[$t->slug] * 1 + 1;
	} else {
		$closedt++;
	}
	$total_tickets++;
}
foreach ($ticketbydepartment as $key => $value) {
	$ticketbydepartment_percentage[$key] = round($value / $total_tickets * 100);
}



$ticketdepart = arsort($ticketbydepartment);



//questions and set for comparison 


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

foreach ($arraydata as $key => $set) {
	$score = 0;
	$maxscore = 0;
	foreach ($ip_feedbacks_count as $r) {
		$param = json_decode($r->dataset);
		foreach ($param as $k => $p) {
			if ($k == $key) {
				if ($p > 0) {
					$scoresets[$key] = $scoresets[$key] + $p;
					$scoresetcount[$key] = $scoresetcount[$key] + 1;
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


$d1 = date('d/m/Y', strtotime($tdate));
$d2 = date('d/m/Y', strtotime($fdatet));


$html .= '<h2 style="text-align:center;">' . $title . '</h2>';
$html .= '<h2 style="text-align:center;">EFEEDOR INPATIENT DISCHARGE FEEDBACK REPORT </h2>';
$html .= '<p style="text-align:left;">SHOWING DATA FROM ' . $d1 . ' TO ' . $d2 . '</p>';

$html .= '<table border="1" cellpadding="5">
			<tr>
				<td colspan="2" style="text-align:center;"><b>OVERALL FEEDBACK REPORT</b></td>
			</tr>
				<tr>
				<td width="85%">'.lang_loader('op','op_total_feedbacks').' </td>
				<td width="15%">' . count($ip_feedbacks_count) . '</td>
			</tr>
			<tr>
				<td>'.lang_loader('op','op_psat_satisfied').' </td>
				<td>' . $ip_psat['satisfied_count'] . '</td>
			</tr>
			<tr>
				<td>'.lang_loader('op','op_unsatisfied_patients').'</td>
				<td>' . $ip_psat['unsatisfied_count'] . '</td>
			</tr>
			<tr>
				<td>'.lang_loader('op','op_total_tickets').'</td>
				<td>' . count($ip_tickets_count) . '</td>
			</tr>
			<tr>
				<td>SATISFACTION INDEX</td>
				<td>' . $ip_psat['psat_score'] . '</td>
			</tr>
			<tr>
				<td>NET PROMOTERS PERCENTAGE(NPS)</td>
				<td>' . $ip_nps['nps_score'] . '%</td>
			</tr>
			<tr>
				<td>TICKET RESOLUTION RATE</td>
				<td>' . $ticket_resolution_rate . '%</td>
			</tr>
			<tr>
				<td>AVERAGE RESOLUTION TIME</td>
				<td>' . secondsToTime($ticket_close_rate) . '</td>
			</tr>
		  </table>';

$html .= '<p><br /></p>';
$html .= '<p><br /></p>';

$html .= '<table border="1" cellpadding="5">
			<tr>
				<td colspan="3" style="text-align:center;"><b>PARAMETER WISE PERFORMANCE ANALYSIS</b></td>
			</tr>
		
			<tr>
				<td width="45%">TOP PERFORMING PARAMETER </td>
				<td width="45%">' . $key_highlights['best_param']  . '</td>
				<td width="10%">' . $key_highlights['highestvalue'] . '%</td>
			</tr>
			<tr>
				<td width="45%">LEAST PERFORMING PARAMETER </td>
				<td width="45%">' . $key_highlights['lowest_param'] . '</td>
				<td width="10%">' . $key_highlights['lowestvalue'] . '%</td>
			</tr>
		  </table>';

$html .= '<p><br /></p>';
$html .= '<p><br /></p>';

$html .= '<table border="1" cellpadding="5">
			<tr>
				<td  style="text-align:center;" width="80%"><b>RATING PARAMETERS</b></td>
				<td  style="text-align:center;" width="20%"><b>PERFORMANCE</b></td>
			</tr>';
foreach ($scoreseto  as $key => $value) {
	$html .= '<tr>
				    <td width="80%">' . $arraydata[$key] . '</td>
				    <td width="20%">' . $value . '%</td>
			
	        		</tr>';
}
$html .= '</table>';

$html .= '<p><br /></p>';
$html .= '<p><br /></p>';

$html .= '<table border="1" cellpadding="5" >
			<tr>
				<td  colspan="2" style="text-align:center;"><b>TICKETS/ COMPLAINTS REPORT</b></td>
			</tr>
			<tr>
				<td width="80%">'.lang_loader('op','op_total_tickets').'</td>
				<td width="20%">' . count($ip_tickets_count) . '</td>
			
			</tr>
			<tr>
				<td width="80%">'.lang_loader('op','op_open_tickets').'</td>
				<td width="20%">' . count($ip_open_tickets) . '</td>
			
			</tr>
			<tr>
				<td width="80%">CLOSED TICKETS</td>
				<td width="20%">' . count($ip_closed_tickets) . '</td>
			
			</tr>
			<tr>
				<td width="80%">TICKET RESOLUTION RATES</td>
				<td width="20%">' . $ticket_resolution_rate . '%</td>
			
			</tr>
			<tr>
				<td width="80%">AVERAGE RESOLUTION TIME</td>
				<td width="20%">' . secondsToTime($ticket_close_rate) . '</td>
			
			</tr>
		  </table>';

$html .= '<p><br /></p>';
$html .= '<p><br /></p>';

$html .= '<table border="1" cellpadding="5">
			<tr>
				<td  colspan="3" style="text-align:center;" ><b>TICKETS/ COMPLAINTS RECEIVED BY DEPARTMENT</b></td>
			</tr>
			<tr>
				<td style="width:60%">DEPARTMENT </td>
				<td style="width:20%">BY PERCENTAGE </td>
				<td style="width:20%">BY NO. OF TICKETS </td>
			</tr>';
$highest_complain = '';
$lowest_complain = '';
$i = 0;
foreach ($ticketbydepartment as $key => $depart) {
	$closed = $ticketbydepartment[$key] - $ticketbydepartmentopen[$key];
	$open = $ticketbydepartmentopen[$key] * 1;
	if ($i == 0) {
		$highest_complain = $key;
	}
	$lowest_complain = $key;
	$html .= '<tr>
    				<td>' . $ticketbydepartmentname[$key] . '</td>
    				<td>' . $ticketbydepartment_percentage[$key] . '%</td>
    				<td>' . $ticketbydepartment[$key] . '</td>
    			
    			</tr>';
	$i++;
}

$html .= '</table>';

$html .= '<p><br /></p>';
$html .= '<p><br /></p>';

$html .= '<table border="1" cellpadding="5">
			<tr>
				<td  colspan="3" style="text-align:center;"><b>TICKETS/ COMPLAINTS ANALYSIS</b></td>
			</tr>
			<tr>
				<td>HIGHEST COMPLAINTS RECEIVED </td>
				<td>' . $ticketbydepartmentname[$highest_complain] . '</td>
				<td>' . $ticketbydepartment_percentage[$highest_complain] . '%</td>
			</tr>
			<tr>
				<td>LEAST COMPLAINTS RECEIVED</td>
				<td>' . $ticketbydepartmentname[$lowest_complain] . '</td>
				<td>' . $ticketbydepartment_percentage[$lowest_complain] . '%</td>
			</tr>
		  </table>';

$html .= '<p><br /></p>';
$html .= '<p><br /></p>';

$html .= '<table border="1" cellpadding="5">
			<tr>
				<td  colspan="2" style="text-align:center;"><b>NET PROMOTERS ANALYSIS( NPS)</b> </td>
			</tr>
			<tr>
				<td width="80%">NET PROMOTERS PERCENTAGE(NPS) </td>
				
				<td width="20%">' . $ip_nps['nps_score'] . '%</td>
			</tr>
			<tr>
				<td  width="80%">NO. OF PROMOTERS</td>
			
				<td width="20%">' . $ip_nps['promoters_count'] . '</td>
			</tr>
			<tr>
				<td  width="80%">NO. OF DETRACTORS</td>
			
				<td width="20%">' . $ip_nps['detractors_count'] . '</td>
			</tr>
			<tr>
				<td  width="80%">NO. OF PASSIVES</td>
			
				<td  width="20%">' . $ip_nps['passives_count'] . '</td>
			</tr>
		  </table>';

$html .= '<p><br /></p>';
$html .= '<p><br /></p>';



$html .= '<table border="1" cellpadding="5">
			<tr>
				<td  style="text-align:center;"><b>OVERALL RATING BREAKDOWN</b></td>
				<td  style="text-align:center;"><b>BY PERCENTAGE</b></td>
				<td  style="text-align:center;"><b>BY NO. OF PATIENTS</b></td>
			</tr>
			<tr>
				<td>EXCELLENT(5)</td>
				<td>' . round($value5) . '%</td>
				<td>' . $for5['overallScore'] . '</td>
			</tr>
			<tr>
				<td>GOOD(4)</td>
				<td>' . round($value4) . '%</td>
				<td>' . $for4['overallScore'] . '</td>
			</tr>
			<tr>
				<td>AVERAGE(3) </td>
				<td>' . round($value3) . '%</td>
				<td>' . $for3['overallScore'] . '</td>
			</tr>
			<tr>
				<td>POOR(2) </td>
				<td>' . round($value2) . '%</td>
				<td>' . $for2['overallScore'] . '</td>
			</tr>
			<tr>
				<td>WORST(1)</td>
				<td>' . round($value1) . '%</td>
				<td>' . $for1['overallScore'] . '</td>
			</tr>
		  </table>';

$html .= '<p><br /></p>';
$html .= '<p><br /></p>';

$html .= '<table border="1" cellpadding="5">
			<tr>
				<td  colspan="3" style="text-align:center;"><b>WHY PATIENT\'S CHOSE YOUR HOSPITAL</b></td>
			</tr>
			<tr><td width="70%">Basis of Hospital selection</td><td width="15%">Percentage of Patients</td><td width="15%">	No. of Patients</td></tr>';
foreach ($selectionarray as $key) {
	$html .= '<tr>
				<td>' . $selectionarrayname[$key] . ' </td>
				<td>' . round($value) . '%</td>
				<td>' . $selectionarrayvalue[$key] . '</td></tr>';
}
$html .= '</table>';


print_r($html);


// print_r($ticketbydepartment);

// tickets for each department end
// $key_highlights = $this->opf_model->key_highlights($table_patients, $table_feedback, $sorttime, $setup);
// print_r($key_highlights);

?>