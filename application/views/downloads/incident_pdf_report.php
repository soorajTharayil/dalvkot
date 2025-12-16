<?php
$fdate = $_SESSION['from_date'];
$tdate = $_SESSION['to_date'];

$d1 = date('d/m/Y', strtotime($tdate));
$d2 = date('d/m/Y', strtotime($fdate));

$setup = 'setup_incident';

$table_feedback = 'bf_feedback_incident';
$table_patients = 'bf_employees_incident';
$sorttime = 'asc';
$setup = 'setup_incident';
$asc = 'asc';
$desc = 'desc';
$table_tickets = 'tickets_incident';
$open = 'Open';
$closed = 'Closed';
$addressed = 'Addressed';
$table_ticket_action = 'ticket_incident_message';

$sresult = $this->incident_model->setup_result($setup);



$logo = base_url('uploads/') . $this->session->userdata['logo'];
$title = array();
$title = $this->session->userdata['title'];


$ticket_resolution_rate = $this->incident_model->ticket_resolution_rate($table_tickets, $closed, $table_feedback);


// $feedbacktaken = $this->efeedor_model->get_feedback('bf_patients','bf_feedback_int',$fdatet,$tdate);
$close_rate = $this->incident_model->ticket_rate($table_tickets, $status, $table_feedback, $table_ticket_action);
$ticket_close_rate = secondsToTime($close_rate);

$ip_tickets_count = $this->ticketsincidents_model->alltickets();
$ip_open_tickets = $this->ticketsincidents_model->read();
$ip_closed_tickets = $this->ticketsincidents_model->read_close();
$ip_addressed_tickets = $this->ticketsincidents_model->addressedtickets();

$feedbacktaken = $this->incident_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);
$all_tickets = $this->incident_model->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);
$sresult = $this->efeedor_model->setup_result($setup);
$ticket = $this->incident_model->get_tickets($table_feedback, $table_tickets);


$tickets = array();
$ticketbydepartment = array();
$ticketbydepartmentopen = array();
$ticketbydepartmentname = array();
foreach ($ticket as $row) {
	$this->db->where('id', $row->feedbackid);
	$query = $this->db->get('bf_feedback_incident');
	$patient = $query->result();
	// 
	$this->db->where('dprt_id', $row->departmentid);
	$query = $this->db->get('department');
	$department = $query->result();
	// print_r($department);
	// exit;
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
	$ticketbydepartment_percentage[$key] = round($value / $total_tickets * 100);
}

$ticketdepart = arsort($ticketbydepartment);

// $d1 = date('d/m/Y', strtotime($tdate));
// $d2 = date('d/m/Y', strtotime($fdatet));
$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Efeedor');
$pdf->SetTitle('INCIDENT REPORT  - ' . $d1 . ' to ' . $d2 . '  ');
$pdf->SetSubject('INCIDENT REPORT - ' . $d1 . ' to ' . $d2 . '  ');



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
if ($_SESSION['ward'] != 'ALL') {
	$ward = $_SESSION['ward'];
}

// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

// create some HTML content
$html .= '<span style="text-align:center;"><img src="' . $logo . '" style="height:30px; width:100px;margin-bottom:-3px;"></span>';
$html .= '<h2 style="text-align:center;">' . $title . '</h2>';
$html .= '<h2 style="text-align:center;">VYKO INCIDENT REPORT </h2>';
$html .= '<p><span style="text-align:left;">SHOWING DATA FROM ' . $ward . '- ' . $d1 . ' TO ' . $d2 . '</span></p>';


$html .= '<table border="1" cellpadding="5" >
    <tr>
        <td colspan="2" style="text-align:center;"><b>INCIDENT REPORT</b></td>
    </tr>
    <tr>
        <td width="80%">TOTAL INCIDENTS</td>
        <td width="20%">' . count($ip_tickets_count) . '</td>
    </tr>
    <tr>
        <td width="80%">OPEN INCIDENTS</td>
        <td width="20%">' . count($ip_open_tickets) . '</td>
    </tr>';

if (ticket_addressal('incident_addressal') === true) {
	$html .= '<tr>
        <td width="80%">ADDRESSED INCIDENTS</td>
        <td width="20%">' . count($ip_addressed_tickets) . '</td>
    </tr>';
}

$html .= '<tr>
        <td width="80%">CLOSED INCIDENTS</td>
        <td width="20%">' . count($ip_closed_tickets) . '</td>
    </tr>
    <tr>
        <td width="80%">INCIDENT RESOLUTION RATE</td>
        <td width="20%">' . $ticket_resolution_rate . '%</td>
    </tr>
</table>';

$html .= '<p><br /></p>';
$html .= '<p><br /></p>';

$html .= '<table border="1" cellpadding="5">
					<tr>
						<td  colspan="3" style="text-align:center;" ><b>INCIDENTS RECEIVED BY CATEGORY</b></td>
					</tr>
					<tr>
						<td style="width:60%">CATEGORY </td>
						<td style="width:20%">PERCENTAGE </td>
						<td style="width:20%">BY NO. OF INCIDENTS </td>
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
						<td  colspan="3" style="text-align:center;"><b>INCIDENTS ANALYSIS</b></td>
					</tr>
					<tr>
						<td>HIGHEST INCIDENTS RECEIVED </td>
						<td>' . $ticketbydepartmentname[$highest_complain] . '</td>
						<td>' . $ticketbydepartment_percentage[$highest_complain] . '%</td>
					</tr>
					<tr>
						<td>LEAST INCIDENTS RECEIVED</td>
						<td>' . $ticketbydepartmentname[$lowest_complain] . '</td>
						<td>' . $ticketbydepartment_percentage[$lowest_complain] . '%</td>
					</tr>
				  </table>';

$html .= '<p><br /></p>';
$html .= '<p><br /></p>';

$html .= '</table>';
$html = str_replace('NAN', '0', $html);
// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');


// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('INCIDENTS REPORT  - ' . $d1 . ' to ' . $d2 . ' .pdf', 'I');
