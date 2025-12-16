<?php
// $fdate = $dates['fdate'];
// $tdate = $dates['tdate'];
// $fdate = $_SESSION['fdate'];
// $tdate = $_SESSION['tdate'];
// include 'ip_table_variables.php';

$fdate = $_SESSION['from_date'];
$tdate = $_SESSION['to_date'];

$d1 = date('d/m/Y', strtotime($tdate));
$d2 = date('d/m/Y', strtotime($fdate));

$setup = 'setup';

$table_feedback = 'bf_feedback_doctors';
$table_patients = 'bf_opatients';
$sorttime = 'asc';
$setup = 'setup_doctor';
$asc = 'asc';
$desc = 'desc';
$table_tickets = 'tickets_doctor';
$open = 'Open';
$closed = 'Closed';
$addressed = 'Addressed';
$table_ticket_action = 'ticket_doctor_message';

if (isset($setup) && !empty($setup)) {
    $sresult = $this->doctorsfeedback_model->setup_result($setup);
}

// $this->db->where('user_id',2);
// $query = $this->db->get('user');
// $user = $query->result();
// $logo = base_url().$user[0]->picture;

$logo = base_url('uploads/') . $this->session->userdata['logo'];
$title = array();
$title = $this->session->userdata['title'];

$close_rate = $this->doctorsfeedback_model->ticket_rate($table_tickets, $status, $table_feedback, $table_ticket_action);
$ticket_close_rate = secondsToTime($close_rate);



$feedbacktaken = $this->doctorsfeedback_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);
$ip_feedbacks_count = $this->doctorsfeedback_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);

// To see the total tickets count
$ip_tickets_count = $this->ticketsdoctor_model->alltickets();
$ip_open_tickets = $this->ticketsdoctor_model->read();
$ip_closed_tickets = $this->ticketsdoctor_model->read_close();
$ip_addressed_tickets = $this->ticketsdoctor_model->addressedtickets();

// IP ANALYTICS
$ip_nps = $this->doctorsfeedback_model->nps_analytics($table_feedback, $asc, $setup);
$ip_nps_tool = 'Promoters: ' . ($ip_nps['promoters_count']) . ', ' . "Detractors: " . ($ip_nps['detractors_count']) . ', ' . "Passives: " . ($ip_nps['passives_count']);
$ip_psat = $this->doctorsfeedback_model->psat_analytics($table_patients, $table_feedback, $table_tickets, $sorttime);
$ip_psat_tool = 'Satisfied Feedbacks: ' . ($ip_psat['satisfied_count']) . ', ' . "Unsatisfied Feedbacks: " . ($ip_psat['unsatisfied_count']) . '. ';
//  . "Neutral: " . ($ip_psat['neutral_count']);
$key_highlights = $this->doctorsfeedback_model->key_highlights($table_patients, $table_feedback, $sorttime, $setup);

$ticket_resolution_rate = $this->doctorsfeedback_model->ticket_resolution_rate($table_tickets, $closed, $table_feedback);

$ip_satisfied_count = $this->doctorsfeedback_model->get_satisfied_count($table_feedback, $table_tickets);
$ip_unsatisfied_count = $this->doctorsfeedback_model->get_unsatisfied_count($table_feedback, $table_tickets);

// $feedbacktaken = $this->efeedor_model->get_feedback('bf_patients', 'bf_feedback', $fdatet, $tdate);
// $all_tickets = $this->efeedor_model->get_tickets('bf_feedback', 'tickets', $fdatet, $tdate);

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
$value5 = round((($for5['overallScore'] * 5) / ($for['overallScore'] * 5)) * 100, 1) * 1;
$value4 = round((($for4['overallScore'] * 5) / ($for['overallScore'] * 5)) * 100, 1) * 1;
$value3 = round((($for3['overallScore'] * 5) / ($for['overallScore'] * 5)) * 100, 1) * 1;
$value2 = round((($for2['overallScore'] * 5) / ($for['overallScore'] * 5)) * 100, 1) * 1;
$value1 = round((($for1['overallScore'] * 5) / ($for['overallScore'] * 5)) * 100, 1) * 1;



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


$ticket = $this->doctorsfeedback_model->get_tickets($table_feedback, $table_tickets);

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



$opent = 0;
$closedt = 0;
$total_tickets = 0;

foreach ($tickets as $t) {
	//$ticketbydepartment[$slug2] = $ticketbydepartment[$slug2]*1+1;
	if ($t->status == 'Open') {
		$opent++;
		$ticketbydepartmentopen[$t->slug] = $ticketbydepartmentopen[$t->slug] * 1 + 1;
	} else {
		$closedt++;
	}
	$total_tickets++;
}
foreach ($ticketbydepartment as $key => $value) {
	$ticketbydepartment_percentage[$key] = round($value / count($ip_feedbacks_count) * 100);
}



$ticketdepart = arsort($ticketbydepartment);


$sresult = $this->efeedor_model->setup_result($setup);

$setarray = array();
$questioarray = array();
foreach ($sresult as $r) {
	$setarray[$r->type] = $r->title;
}
foreach ($sresult as $r) {
	$questioarray[$r->type][$r->shortkey] = $r->shortname;
}


$department_rating = array();
foreach($questioarray as $type => $row){
    foreach($row as $k => $r){
    	$department_rating[$k][1] = 0;
    	$department_rating[$k][2] = 0;
    	$department_rating[$k][3] = 0;
    	$department_rating[$k][4] = 0;
    	$department_rating[$k][5] = 0;
	foreach ($feedbacktaken as $f) {
           $param = json_decode($f->dataset,true);
	   if($param[$k]*1 > 0){
		$p = $param[$k]*1;
		$department_rating[$k][$p] += 1;
	   }
	  
	   	
	}	
    }
	
    	
}
//print_r($department_rating);
//exit;


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

$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Efeedor');
$pdf->SetTitle('OT - OVERALL DOCTORS FEEDBACK REPORT  - ' . $d1 . ' to ' . $d2 . '  ');
$pdf->SetSubject('OT - OVERALL DOCTORS FEEDBACK REPORT  - ' . $d1 . ' to ' . $d2 . '  ');



// set header and footer fonts
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);


// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);

// set some language-dependent strings (optional)


// ---------------------------------------------------------

// set font
$pdf->SetFont('dejavusans', '', 10);

// add a page
$pdf->AddPage();

// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)
if ($_SESSION['ward'] != 'ALL') {
	$ward = $_SESSION['ward'];
}

$html .= '<span style="text-align:center;"><img src="' . $logo . '" style="height:30px; width:100px;margin-bottom:-3px;"></span>';
$html .= '<h2 style="text-align:center;">' . $title . '</h2>';
$html .= '<h2 style="text-align:center;">VYKO OT DOCTOR FEEDBACK REPORT </h2>';
$html .= '<p><span style="text-align:left;">SHOWING DATA FROM ' . $ward . '- ' . $d1 . ' TO ' . $d2 . '</span></p>';

$html .= '<table border="1" cellpadding="5">
					<tr>
						<td colspan="2" style="text-align:center;"><b>OVERALL FEEDBACK REPORT</b></td>
					</tr>
						<tr>
						<td width="85%">TOTAL FEEDBACKS </td>
						<td width="15%">' . count($ip_feedbacks_count) . '</td>
					</tr>
					<tr>
						<td>SATISFIED FEEDBACKS </td>
						<td>' . $ip_psat['satisfied_count'] . '</td>
					</tr>
					<tr>
						<td>UNSATISFIED FEEDBACKS </td>
						<td>' . $ip_psat['unsatisfied_count'] . '</td>
					</tr>
					<tr>
						<td>TOTAL TICKETS</td>
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
						<td>' . $ticket_close_rate . '</td>
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
						<td  style="text-align:center;" width="20%"><b>DEPARTMENT</b></td>
						<td  style="text-align:center;" width="15%"><b>EXCELLENT</b></td>
						<td  style="text-align:center;" width="10%"><b>GOOD</b></td>
						<td  style="text-align:center;" width="15%"><b>AVERAGE</b></td>
						<td  style="text-align:center;" width="10%"><b>POOR</b></td>
						<td  style="text-align:center;" width="10%"><b>WORST</b></td>
						<td  style="text-align:center;" width="20%"><b>PERFORMANCE</b></td>
					</tr>';
foreach ($scoreseto  as $key => $value) {
	
	$html .= '<tr>

							<td width="20%">' . $arraydata[$key] . '</td>
							<td width="15%">' . $department_rating[$key][5] . '</td>
							<td width="10%">' . $department_rating[$key][4] . '</td>
							<td width="15%">' . $department_rating[$key][3] . '</td>
							<td width="10%">' . $department_rating[$key][2] . '</td>
							<td width="10%">' . $department_rating[$key][1] . '</td>
							<td width="20%">' . $value . '%</td>
						
					
							</tr>';
}
$html .= '</table>';

$html .= '<p><br /></p>';
$html .= '<p><br /></p>';

$html .= '<table border="1" cellpadding="5" >
    <tr>
        <td colspan="2" style="text-align:center;"><b>TICKETS/ COMPLAINTS REPORT</b></td>
    </tr>
    <tr>
        <td width="80%">TOTAL TICKETS</td>
        <td width="20%">' . count($ip_tickets_count) . '</td>
    </tr>
    <tr>
        <td width="80%">OPEN TICKETS</td>
        <td width="20%">' . count($ip_open_tickets) . '</td>
    </tr>';

if (ticket_addressal('op_addressal') === true) {
	$html .= '<tr>
        <td width="80%">ADDRESSED TICKETS</td>
        <td width="20%">' . count($ip_addressed_tickets) . '</td>
    </tr>';
}

$html .= '<tr>
        <td width="80%">CLOSED TICKETS</td>
        <td width="20%">' . count($ip_closed_tickets) . '</td>
    </tr>
    <tr>
        <td width="80%">TICKET RESOLUTION RATE</td>
        <td width="20%">' . $ticket_resolution_rate . '%</td>
    </tr>
</table>';

$html .= '<p><br /></p>';
$html .= '<p><br /></p>';


$html .= '<table border="1" cellpadding="5">
					<tr>
						<td  colspan="3" style="text-align:center;" ><b>TICKETS/ COMPLAINTS RECEIVED BY DEPARTMENT</b></td>
					</tr>
					<tr>
						<td style="width:60%">DEPARTMENT</td>
						<td style="width:20%">PERCENTAGE</td>
						<td style="width:20%">NUMBER OF TICKETS</td>

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
						<td>HIGHEST TICKETS RECEIVED </td>
						<td>' . $ticketbydepartmentname[$highest_complain] . '</td>
						<td>' . $ticketbydepartment_percentage[$highest_complain] . '%</td>
					</tr>
					<tr>
						<td>LEAST TICKETS RECEIVED</td>
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
						<td  style="text-align:center;"><b>BY NO. OF DOCTORS</b></td>
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
						<td  colspan="3" style="text-align:center;"><b>HOSPITAL STRENGTH ANALYSIS</b></td>
					</tr>
					<tr>
						<td  style="text-align:center;"><b>REASONS</b></td>
						<td  style="text-align:center;"><b>PERCENTAGE</b></td>
						<td  style="text-align:center;"><b>BY NO. OF DOCTORS</b></td>
					</tr>';



$choice_of_hospitals = $this->doctorsfeedback_model->reason_to_choose_hospital($table_feedback, $sorttime);
foreach ($choice_of_hospitals as $key => $object) {
	$html .= '<tr>
						<td>' . $object->title . ' </td>
						<td>' . $object->percentage . '%</td>
						<td>' . $object->count . '</td>
						</tr>';
}



$html .= '</table>';





$html = str_replace('NAN', '0', $html);
// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');


// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('OT - OVERALL DOCTORS FEEDBACK REPORT  - ' . $d1 . ' to ' . $d2 . ' .pdf', 'I');
