<?php
$fdate = $_GET['fdate'];
$tdate = $_GET['tdate']; 

// $this->db->where('user_id',2);
// $query = $this->db->get('user');
// $user = $query->result();
// $logo = base_url().$user[0]->picture;

$logo = base_url('uploads/').$this->session->userdata['logo'];
$title=array();
$title = $this->session->userdata['title'];


//$this->db->select('bf_feedback.*,bf_patients.name as pname,bf_patients.patient_id as pid');
//$this->db->from('bf_feedback');
//$this->db->join('bf_patients', 'bf_patients.patient_id = bf_feedback.patientid', 'inner');

//if (isset($_SESSION['ward']) && $_SESSION['ward'] != 'ALL'){
	//$this->db->where('bf_patients.ward', $_SESSION['ward']);
//}

$fdate = date('Y-m-d', strtotime($fdate)); 
$fdatet = date('Y-m-d 23:59:59', strtotime($fdate) );
//$this->db->where('bf_feedback.datet <=', $fdatet);
//$this->db->where('bf_feedback.datet >=', $tdate);
//$this->db->order_by('datetime', 'desc');
//$this->db->group_by('bf_patients.patient_id');
//$query = $this->db->get();
//$feedbacktaken = $query->result();
		// /* START TABLES FROM DATABASE */

		// $table_feedback = 'bf_feedback';
		// $table_patients = 'bf_patients';
		// $sorttime = 'asc';
		// $setup = 'setup';
		// $asc = 'asc';
		// $desc = 'desc';
		// $table_tickets = 'tickets';
		// $open = 'Open';
		// $closed = 'Closed';
		// $addressed = 'Addressed';






$feedbacktaken = $this->efeedor_model->get_feedback('bf_patients','bf_feedback',$fdatet,$tdate);
$all_tickets = $this->efeedor_model->get_tickets('bf_feedback', 'tickets', $fdatet, $tdate);
$ticket_resolution_rate = $this->efeedor_model->ticket_resolution_rate($all_tickets);
$ticket_close_rate = $this->efeedor_model->ticket_close_rate($all_tickets);

foreach($feedbacktaken as $r){
    $this->db->where('feedbackid', $r->id);
    $query = $this->db->get('tickets');
    $dtata = $query->result();
    if (count($dtata) > 0){
    	//$param = json_decode($r->dataset);
    	$below3++;
    }
    $param = json_decode($r->dataset);
    //if($param->recommend1Score*1 > 0){
    	if ($param->recommend1Score > 4){
    		
    			$promoter = $promoter + 1;
    		
    	}else{
    		if($param->recommend1Score == 4 || $param->recommend1Score == 3.5){
    			$passive = $passive + 1;
    		}else{
    			$depromoter = $depromoter + 1;
    		}
    	}
    //}
    
    if($param->overallScore*1  == 1){
    	$patientrating1 = $patientrating1 +1;
    }
    if($param->overallScore*1  == 2){
    	$patientrating2 = $patientrating2 +1;
    }
    if($param->overallScore*1  == 3){
    	$patientrating3 = $patientrating3 +1;
    }
    if($param->overallScore*1  == 4){
    	$patientrating4 = $patientrating4 +1;
    }
    if($param->overallScore*1  == 5){
    	$patientrating5 = $patientrating5 +1;
    }
}
$permoterpercentage = round((($promoter-$depromoter)/($depromoter+$promoter+$passive))*100);
$patientpercentage1 = round((($patientrating1/($promoter+$depromoter+$passive))*100));
$patientpercentage2 = round((($patientrating2/($promoter+$depromoter+$passive))*100));
$patientpercentage3 = round((($patientrating3/($promoter+$depromoter+$passive))*100));
$patientpercentage4 = round((($patientrating4/($promoter+$depromoter+$passive))*100));
$patientpercentage5 = round((($patientrating5/($promoter+$depromoter+$passive))*100));

$for5 = array();
$for4 = array();
$for3 = array();
$for2 = array();
$for1 = array();
$for1 = array();
$for = array();
foreach($feedbacktaken as $row){
	$param = json_decode($row->dataset);
	if($param->overallScore == 5){
		$for5['overallScore'] = $for5['overallScore'] + 1;
	}
	if($param->overallScore == 4){
		$for4['overallScore'] = $for4['overallScore'] + 1;
	}
	if($param->overallScore == 3){
		$for3['overallScore'] = $for3['overallScore'] + 1;
	}
	if($param->overallScore == 2){
		$for2['overallScore'] = $for2['overallScore'] + 1;
	}
	if($param->overallScore == 1){
		$for1['overallScore'] = $for1['overallScore'] + 1;
	}
	$for['overallScore'] = $for['overallScore'] + 1;
	$for['overallScoresum'] = $for['overallScoresum'] + $param->overallScore;
	
}		
$average = round((($for5['overallScore']*5+$for4['overallScore']*4+$for3['overallScore']*3+$for2['overallScore']*2+$for1['overallScore']*1)/($for['overallScore']*5))*5,1);
$value5 = round((($for5['overallScore']*5)/($for['overallScore']*5))*100,1)*1;
$value4 = round((($for4['overallScore']*5)/($for['overallScore']*5))*100,1)*1;
$value3 = round((($for3['overallScore']*5)/($for['overallScore']*5))*100,1)*1;
$value2 = round((($for2['overallScore']*5)/($for['overallScore']*5))*100,1)*1;
$value1 = round((($for1['overallScore']*5)/($for['overallScore']*5))*100,1)*1;

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

$tcount = 0;
foreach($overallarray as $row => $v){
	foreach($feedbacktaken as $r){
		$param = json_decode($r->dataset, true);
		foreach($param as $k => $rval){
			if ($k == $row){
				if ($param[$k] != ''){
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
foreach($overallarray as $row => $v){
	$count = 0;
	foreach($feedbacktaken as $r){
		$param = json_decode($r->dataset, true);
		foreach($param as $k => $rval){
			if ($k == $row){
				if ($param[$k] != ''){
					$count++;
				}
			}
		}
	}

	if (count($feedbacktaken) > 0){
		$percentage = ($count / $tcount) * 100;
	}else{
		$percentage = 0;
	}
	$selectionarray[$row] = round($percentage,2);
	$selectionarrayname[$row] = $v;
	$selectionarrayvalue[$row] = $count;
}


arsort($selectionarray);

$total_feedback = count($feedbacktaken);
$satisfied_patient = count($feedbacktaken) - $below3;
$unsatisfied_patinets = $below3;
$satisfaction_index = round((count($feedbacktaken) - $below3)/(count($feedbacktaken)) * 100).'%';
//print_r($feedbacktaken);
//exit;



$this->db->select('tickets.*,bf_patients.name as pname');
$this->db->from('tickets');

$this->db->join('bf_feedback','bf_feedback.id = tickets.feedbackid','left');
$this->db->join('bf_patients','bf_patients.patient_id = bf_feedback.patientid','left');
$this->db->where('bf_feedback.datet <=',$fdatet);
$this->db->where('bf_feedback.datet >=',$tdate );
$this->db->order_by('datetime', 'desc');
$query = $this->db->get();
$ticket = $query->result();

$tickets = array();
$ticketbydepartment = array();
$ticketbydepartmentopen = array();
$ticketbydepartmentname = array();
foreach($ticket as $row){
	$this->db->where('patient_id',$row->created_by);
	$query = $this->db->get('bf_patients');
	$patient = $query->result();
	
	$this->db->where('dprt_id',$row->departmentid);
	$query = $this->db->get('department');
	$department = $query->result();
	
	$slug2 = preg_replace('/[^A-Za-z0-9-]+/', '-', $department[0]->description);
	$row->slug = $slug2;
	$slug = $patient[0]->id.preg_replace('/[^A-Za-z0-9-]+/', '-', $department[0]->description);
	$tickets[] = $row;
	
	
	$ticketbydepartment[$slug2] = $ticketbydepartment[$slug2]*1+1;
	$ticketbydepartmentname[$slug2] = $department[0]->description;
}

$opent = 0;
$closedt = 0;
$total_tickets = 0;

foreach($tickets as $t){
	//$ticketbydepartment[$slug2] = $ticketbydepartment[$slug2]*1+1;
	if($t->status == 'Open'){
		$opent++;
		$ticketbydepartmentopen[$t->slug] = $ticketbydepartmentopen[$t->slug]*1+1;
	}else{
		$closedt++;
	}
	$total_tickets++;
	
}
foreach($ticketbydepartment as $key => $value){
    $ticketbydepartment_percentage[$key] = round($value/$total_tickets * 100);
}



$ticketdepart = arsort($ticketbydepartment);		

// $this->db->order_by('id');
// $query = $this->db->get('setup');
// $sresult = $query->result();


$sresult = $this->efeedor_model->setup_result('setup');

$setarray = array();
$questioarray = array();
foreach($sresult as $r){
	$setarray[$r->type] = $r->title;
}
foreach($sresult as $r){
	$questioarray[$r->type][$r->shortkey] = $r->shortname;
}
$arraydata = array();
foreach($questioarray as $setr){
	foreach($setr as $k => $v){
		$arraydata[$k] = $v;
	}
}
foreach($arraydata as $key => $set){
	$scoresets[$key] = 0;
	$scoresetcount[$key] = 0;
	$positive[$key] = 0;
	$negative[$key] = 0;
}

foreach($arraydata as $key => $set){
	$score = 0;
	$maxscore = 0;
	foreach($feedbacktaken as $r){
		$param = json_decode($r->dataset);
		foreach($param as $k => $p){
			if ($k == $key){
				if ($p > 0){
					$scoresets[$key] = $scoresets[$key] + $p;
					$scoresetcount[$key] = $scoresetcount[$key] + 1;					//print_r($key); 					//print_r($param); exit;		
					
					if ($p > 2){
						$positive[$key] = $positive[$key] + 1;
					}else{	
					if ($p != 0){
						$negative[$key] = $negative[$key] + 1;						}
					}
				}
			}
		}
	}
}
foreach($scoresets as $k => $val){
	$scoreseto[$k] = round(($val / ($scoresetcount[$k] * 5)) * 100);
	$positives[$k] = round(($positive[$k]/$scoresetcount[$k])   * 100);
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
foreach($scoreseto as $key => $value){
	if($k == 0){
		$highestname = $arraydata[$key];
		$highestvalue = $value;
		$k = 1;
	}else{
		$lowestname = $arraydata[$key];
		$lowestvalue = $value;
	}
}
$d1 = date('d/m/Y',strtotime($tdate));
$d2 = date('d/m/Y',strtotime($fdatet));
$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Efeedor');
$pdf->SetTitle('IP - OVERALL PATIENTS FEEDBACK REPORT  - '.$d1.' to '.$d2.'  ');
$pdf->SetSubject('IP - OVERALL PATIENTS FEEDBACK REPORT  - '.$d1.' to '.$d2.'  ');



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

// create some HTML content
$html = '<table style="width:100%;">
			<tr>
				<td style="text-align:left;"><img src="'.$logo.'" style="height:40px; width:100px;"></td>
				
			</tr>
		</table>';
		
$html .='<h2 style="text-align:center;">'.$title.'</h2>';
$html .='<h2 style="text-align:center;">EFEEDOR INPATIENT DISCHARGE FEEDBACK REPORT </h2>';
$html .='<p style="text-align:left;">SHOWING DATA FROM '.$d1.' TO '.$d2.'</p>';

$html .= '<table border="1" cellpadding="5">
			<tr>
				<td colspan="2" style="text-align:center;"><b>OVERALL FEEDBACK REPORT</b></td>
			</tr>
				<tr>
				<td width="85%">TOTAL FEEDBACKS </td>
				<td width="15%">'.$total_feedback.'</td>
			</tr>
			<tr>
				<td>SATISFIED PATIENTS </td>
				<td>'.$satisfied_patient.'</td>
			</tr>
			<tr>
				<td>UNSATISFIED PATIENTS </td>
				<td>'.$unsatisfied_patinets.'</td>
			</tr>
			<tr>
				<td>TOTAL TICKETS</td>
				<td>'.$total_tickets.'</td>
			</tr>
			<tr>
				<td>SATISFACTION INDEX</td>
				<td>'.$satisfaction_index.'</td>
			</tr>
			<tr>
				<td>NET PROMOTERS PERCENTAGE(NPS)</td>
				<td>'.$permoterpercentage.'%</td>
			</tr>
			<tr>
				<td>TICKET RESOLUTION RATE</td>
				<td>'.$ticket_resolution_rate.'%</td>
			</tr>
			<tr>
				<td>AVERAGE RESOLUTION TIME</td>
				<td>'.secondsToTime($ticket_close_rate).'</td>
			</tr>
		  </table>';
		  
$html .='<p><br /></p>';		  
$html .='<p><br /></p>';		  
		  
$html .= '<table border="1" cellpadding="5">
			<tr>
				<td colspan="3" style="text-align:center;"><b>PARAMETER WISE PERFORMANCE ANALYSIS</b></td>
			</tr>
		
			<tr>
				<td width="45%">TOP PERFORMING PARAMETER </td>
				<td width="45%">'.$highestname.'</td>
				<td width="10%">'.$highestvalue.'%</td>
			</tr>
			<tr>
				<td width="45%">LEAST PERFORMING PARAMETER </td>
				<td width="45%">'.$lowestname.'</td>
				<td width="10%">'.$lowestvalue.'%</td>
			</tr>
		  </table>';
		  
$html .='<p><br /></p>';		  
$html .='<p><br /></p>';
		  
$html .= '<table border="1" cellpadding="5">
			<tr>
				<td  style="text-align:center;" width="80%"><b>RATING PARAMETERS</b></td>
				<td  style="text-align:center;" width="20%"><b>PERFORMANCE</b></td>
			</tr>';
			foreach($scoreseto  as $key => $value){
			    $html .='<tr>
				    <td width="80%">'.$arraydata[$key].'</td>
				    <td width="20%">'.$value.'%</td>
			
	        		</tr>';
			}
$html .='</table>';

$html .='<p><br /></p>';		  
$html .='<p><br /></p>';
		  
$html .= '<table border="1" cellpadding="5" >
			<tr>
				<td  colspan="2" style="text-align:center;"><b>TICKETS/ COMPLAINTS REPORT</b></td>
			</tr>
			<tr>
				<td width="80%">TOTAL COMPLAINTS</td>
				<td width="20%">'.$total_tickets.'</td>
			
			</tr>
			<tr>
				<td width="80%">OPEN COMPLAINTS</td>
				<td width="20%">'.$opent.'</td>
			
			</tr>
			<tr>
				<td width="80%">CLOSED COMPLAINTS</td>
				<td width="20%">'.$closedt.'</td>
			
			</tr>
			<tr>
				<td width="80%">COMPLAINT RESOLUTION RATES</td>
				<td width="20%">'.$ticket_resolution_rate.'%</td>
			
			</tr>
			<tr>
				<td width="80%">AVERAGE RESOLUTION TIME</td>
				<td width="20%">'.secondsToTime($ticket_close_rate).'</td>
			
			</tr>
		  </table>';
		  
$html .='<p><br /></p>';		  
$html .='<p><br /></p>';
		  
$html .= '<table border="1" cellpadding="5">
			<tr>
				<td  colspan="3" style="text-align:center;" ><b>TICKETS/ COMPLAINTS RECEIVED BY DEPARTMENT</b></td>
			</tr>
			<tr>
				<td style="width:60%">DEPARTMENT </td>
				<td style="width:20%">BY PERCENTAGE </td>
				<td style="width:20%">BY NO. OF COMPLAINTS </td>
			</tr>';
			$highest_complain = '';
			$lowest_complain = '';
			$i = 0;
			foreach($ticketbydepartment as $key=>$depart){
    			$closed = $ticketbydepartment[$key] - $ticketbydepartmentopen[$key];
    			$open = $ticketbydepartmentopen[$key]*1;
    			if($i == 0){
    			    $highest_complain = $key;
    			}
    			$lowest_complain = $key;
    			$html .='<tr>
    				<td>'.$ticketbydepartmentname[$key].'</td>
    				<td>'.$ticketbydepartment_percentage[$key].'%</td>
    				<td>'.$ticketbydepartment[$key].'</td>
    			
    			</tr>';
    			$i++;
			}
			
$html .='</table>';
		  
$html .='<p><br /></p>';		  
$html .='<p><br /></p>';
		  
$html .= '<table border="1" cellpadding="5">
			<tr>
				<td  colspan="3" style="text-align:center;"><b>TICKETS/ COMPLAINTS ANALYSIS</b></td>
			</tr>
			<tr>
				<td>HIGHEST COMPLAINTS RECEIVED </td>
				<td>'.$ticketbydepartmentname[$highest_complain].'</td>
				<td>'.$ticketbydepartment_percentage[$highest_complain].'%</td>
			</tr>
			<tr>
				<td>LEAST COMPLAINTS RECEIVED</td>
				<td>'.$ticketbydepartmentname[$lowest_complain].'</td>
				<td>'.$ticketbydepartment_percentage[$lowest_complain].'%</td>
			</tr>
		  </table>';
		  
$html .='<p><br /></p>';		  
$html .='<p><br /></p>';
		  
$html .= '<table border="1" cellpadding="5">
			<tr>
				<td  colspan="2" style="text-align:center;"><b>NET PROMOTERS ANALYSIS( NPS)</b> </td>
			</tr>
			<tr>
				<td width="80%">NET PROMOTERS PERCENTAGE(NPS) </td>
				
				<td width="20%">'.$permoterpercentage.'%</td>
			</tr>
			<tr>
				<td  width="80%">NO. OF PROMOTERS</td>
			
				<td width="20%">'.$promoter.'</td>
			</tr>
			<tr>
				<td  width="80%">NO. OF DETRACTORS</td>
			
				<td width="20%">'.$depromoter.'</td>
			</tr>
			<tr>
				<td  width="80%">NO. OF PASSIVES</td>
			
				<td  width="20%">'.$passive.'</td>
			</tr>
		  </table>';

$html .='<p><br /></p>';		  
$html .='<p><br /></p>';
	  

		  
$html .= '<table border="1" cellpadding="5">
			<tr>
				<td  style="text-align:center;"><b>OVERALL RATING BREAKDOWN</b></td>
				<td  style="text-align:center;"><b>BY PERCENTAGE</b></td>
				<td  style="text-align:center;"><b>BY NO. OF PATIENTS</b></td>
			</tr>
			<tr>
				<td>EXCELLENT(5)</td>
				<td>'.round($value5).'%</td>
				<td>'.$for5['overallScore'].'</td>
			</tr>
			<tr>
				<td>GOOD(4)</td>
				<td>'.round($value4).'%</td>
				<td>'.$for4['overallScore'].'</td>
			</tr>
			<tr>
				<td>AVERAGE(3) </td>
				<td>'.round($value3).'%</td>
				<td>'.$for3['overallScore'].'</td>
			</tr>
			<tr>
				<td>POOR(2) </td>
				<td>'.round($value2).'%</td>
				<td>'.$for2['overallScore'].'</td>
			</tr>
			<tr>
				<td>WORST(1)</td>
				<td>'.round($value1).'%</td>
				<td>'.$for1['overallScore'].'</td>
			</tr>
		  </table>';
		  
$html .='<p><br /></p>';		  
$html .='<p><br /></p>';

$html .= '<table border="1" cellpadding="5">
			<tr>
				<td  colspan="3" style="text-align:center;"><b>WHY PATIENT\'S CHOSE YOUR HOSPITAL</b></td>
			</tr>
			<tr><td width="70%">Basis of Hospital selection</td><td width="15%">Percentage of Patients</td><td width="15%">	No. of Patients</td></tr>';
			foreach($selectionarray as $key => $value){
			$html .='<tr>
				<td>'.$selectionarrayname[$key].' </td>
				<td>'.round($value).'%</td>
				<td>'.$selectionarrayvalue[$key].'</td></tr>';
			}
$html .='</table>';
$html = str_replace('NAN','0',$html);			
// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');


// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('IP - OVERALL PATIENTS FEEDBACK REPORT  - '.$d1.' to '.$d2.' .pdf', 'I');
