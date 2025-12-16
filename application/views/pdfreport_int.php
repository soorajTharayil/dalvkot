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

//$this->db->select('bf_feedback_int.*,bf_patients.name as pname,bf_patients.patient_id as pid');
//$this->db->from('bf_feedback_int');
//$this->db->join('bf_patients', 'bf_patients.patient_id = bf_feedback_int.patientid', 'inner');

//if (isset($_SESSION['ward']) && $_SESSION['ward'] != 'ALL'){
	//$this->db->where('bf_patients.ward', $_SESSION['ward']);
//}

$fdate = date('Y-m-d', strtotime($fdate)); 
$fdatet = date('Y-m-d 23:59:59', strtotime($fdate) );
//$this->db->where('bf_feedback_int.datet <=', $fdatet);
//$this->db->where('bf_feedback_int.datet >=', $tdate);
//$this->db->order_by('datetime', 'desc');
//$this->db->group_by('bf_patients.patient_id');
//$query = $this->db->get();
//$feedbacktaken = $query->result();

$feedbacktaken = $this->efeedor_model->get_feedback('bf_patients','bf_feedback_int',$fdatet,$tdate);
$all_tickets = $this->efeedor_model->get_tickets('bf_feedback_int', 'tickets_int', $fdatet, $tdate);
$ticket_resolution_rate = $this->efeedor_model->ticket_resolution_rate($all_tickets);
$ticket_close_rate = $this->efeedor_model->ticket_close_rate($all_tickets);

foreach($feedbacktaken as $r){
    $this->db->where('feedbackid', $r->id);
    $query = $this->db->get('tickets_int');
    $dtata = $query->result();
    if (count($dtata) > 0){
    	//$param = json_decode($r->dataset);
    	$below3++;
    }
}



$this->db->select('tickets_int.*,bf_patients.name as pname,bf_feedback_int.datet');
$this->db->from('tickets_int');
$this->db->join('bf_feedback_int', 'bf_feedback_int.id = tickets_int.feedbackid', 'inner');
$this->db->join('bf_patients', 'bf_patients.patient_id = bf_feedback_int.patientid', 'inner');
$this->db->where('bf_feedback_int.datet <=', $fdatet);
$this->db->where('bf_feedback_int.datet >=', $tdate);
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

$this->db->order_by('id');
$query = $this->db->get('setup');
$sresult = $query->result();
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
$pdf->SetTitle('PATIENT COMPLAINTS REPORT  - '.$d1.' to '.$d2.'  ');
$pdf->SetSubject('PATIENT COMPLAINTS REPORT  - '.$d1.' to '.$d2.'  ');



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
				<td style="text-align:left;"><img src="'.$logo.'" style="height:40px;"></td>
				
			</tr>
		</table>';
$html .='<h2 style="text-align:center;">'.$title.'</h2>';
$html .='<h2 style="text-align:center;">PATIENT COMPLAINTS REPORT </h2>';
$html .='<p style="text-align:left;">SHOWING DATA FROM '.$d1.' TO '.$d2.'</p>';


		  
$html .= '<table border="1" cellpadding="5" >
			<tr>
				<td  colspan="2" style="text-align:center;"><b>TICKETS/ COMPLAINTS REPORT</b></td>
			</tr>
			<tr>
				<td width="80%">TOTAL TICKETS</td>
				<td width="20%">'.$total_tickets.'</td>
			
			</tr>
			<tr>
				<td width="80%">OPEN TICKETS</td>
				<td width="20%">'.$opent.'</td>
			
			</tr>
			<tr>
				<td width="80%">CLOSED TICKETS</td>
				<td width="20%">'.$closedt.'</td>
			
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

$html .='</table>';
$html = str_replace('NAN','0',$html);			
// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');


// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('PATEINT COMPLAINTS REPORT  - '.$d1.' to '.$d2.' .pdf', 'I');
?>