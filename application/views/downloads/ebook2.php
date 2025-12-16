<?php

include 'logics.php';



$fdate = $_SESSION['from_date'];
$tdate = $_SESSION['to_date'];

//  echo '<pre>';
// print_r($feeds);
// exit;



$d1 = date('d/m/Y', strtotime($tdate));
$d2 = date('d/m/Y', strtotime($fdate));


$logo = base_url('uploads/') . $this->session->userdata['logo'];
$EFlogo = base_url('assets/icon/log.png');
$title = array();
$title = $this->session->userdata['title'];

$ebook_ip_bar = base_url('/assets/ebook_images/ebook_ip_bar.png');
$ebook_ip_nps = base_url('/assets/ebook_images/ebook_ip_nps.png');
$ebook_ip_psat = base_url('/assets/ebook_images/ebook_ip_psat.png');
$ebook_ip_tickets = base_url('/assets/ebook_images/ebook_ip_tickets.png');
$ip_response_chart = base_url('/assets/ebook_images/ip_response_chart.png');
$ip_hospital_selection = base_url('/assets/ebook_images/ip_hospital_selection.png');


$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Efeedor');
$pdf->SetTitle('EFEEDOR E-BOOK- ' . $d1 . ' to ' . $d2 . '  ');
$pdf->SetSubject('EFEEDOR E-BOOK- ' . $d1 . ' to ' . $d2 . '  ');


// set header and footer fonts
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
// $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);

// set font
$pdf->SetFont('dejavusans', '', 11);
// add a page
$pdf->AddPage();

// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)
$bind_content = '';
$bind_content .= '<p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p>';
$bind_content .= '<span style="text-align:center; margin-bottom:5px;"><img src="' . $logo . '" style="height:40px; width:120px;margin-bottom:10px;"></span>';
$bind_content .= '<h2 style="text-align:center;">' . $title . '</h2>';
$bind_content .= '<h1 style="text-align:center;">EFEEDOR E-BOOK</h1>';

$bind_content .= '<h4 style="text-align:center;">' . $d1 . ' TO ' . $d2 . '</h4>';
$bind_content .= '<br>';




// $imagePath = base_url('assets/icon/log.png'); // Path to the saved chart image
// $pdf->Image($imagePath, $x = 100, $y = 100, $w = 100, $h = 40, $type = '', $link = '', $align = '', $resize = false, $dpi = 300, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = true, $hidden = false, $fitonpage = false);


$bind_content .= '<p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p><p></p>';
$bind_content .= '<p></p>';
// $html .= '<p></p>';
// $html .= '<p></p>';
$bind_content .= '<span style="text-align:center;background: transparent; width: 100%;"><a href="https://efeedor.com/"><img src="' . $EFlogo . '" style="height:35px; width:80px;margin-bottom:-3px;"></a></span>';
$bind_content .= '<p></p>';

$pdf->writeHTML($bind_content, true, false, true, false, '');
// $pdf->AddPage();
$index_content = '';

$index_content .= '<h3 style="text-align:center;" id="index_page">INDEX</h3>';
$index_content .= '<hr>';
$index_content .= '<p></p>';

$index_content .= '<table border="1" cellpadding="5">
					<tr>
						<td width="10%">SL.</td>
						<td width="70%">Content</td>
						<td width="20%">Page No.</td>
					</tr>		
					<tr>
			
					<td width="10%">1</td>
					<td width="70%">INPATIENT DISCHARGE FEEDBACKS</td>
					<td width="20%">2</td>
				
				</tr>
				  </table>';

// $pdf->writeHTML($index_content, true, false, true, false, '');
// $pdf->AddPage();

$html = '';

// $html .= '<p></p>';
// $html .= '<p></p>';
// $html .= '<p></p>';
// $html .= '<p></p>';

// $html .= '<h4>Overview</h4>';
// $html .= '<p></p>';
// $html .= '<h4>Response Data</h4>';
// $html .= '<p style="text-align:justify;">You have gathered feedback from ' . $totalfeeds . ' patients feedbacks for the selected period. Among these, ' . $feedbacks_from_app . ' patients provided feedback through the Mobile App, ' . $feedbacks_from_link . ' patients via Online Link, and ' . $feedbacks_from_qr . ' patients via QR Code.</p>';



// $html .= '<h4>Patient Satisfaction Analysis(PSAT)</h4>';
// $html .= '<p style="text-align:justify;">Out of the ' . $totalfeeds . ' patient feedback responses collected, ' . $satisfied_patients_count . ' patients conveyed satisfaction with their healthcare experience, indicating positive outcomes and service delivery. Conversely, ' . $unsatisfied_patients_count  . ' patients expressed dissatisfaction, signaling areas of improvement or concerns within the organization\'s services. With this, ' . $title . ' has achieved a Patient Satisfaction Score of  ' . $overall_psat_score . '%, The score serves as a valuable metric for evaluating patient experiences and guiding efforts towards continual improvement in service quality and patient satisfaction. </p>';



// $html .= '<h4>Net Promoter Analysis(NPS)</h4>';
// $html .= '<p style="text-align:justify;">Out of the ' . $totalfeeds . ' patient feedback responses collected, ' . $promoters_count . ' patients were classified as promoters, indicating they were highly satisfied with their experience and are likely to recommend the hospital to others. On the other hand,  ' . $detractors_count  . ' atients were identified as detractors, expressing dissatisfaction with their experience and possibly sharing negative opinions. Additionally, ' . $passive_count . ' patients fell into the passive category, indicating they were generally satisfied but not as enthusiastic as promoters. As a result of this feedback distribution, ' . $title . ' attained a Net Promoter Score of ' . $overall_nps_score . '%, reflecting the overall sentiment of patients towards the hospital\'s services. </p>';


if ($ip_module == true) {
	$html .= '<h3 style="text-align:center;" id="ip_discharge_feedback">INPATIENT DISCHARGE FEEDBACKS</h3>';
	$html .= '<hr>';
	$html .= '<p></p>';
	$html .= '<p></p>';

	$html .= '<p></p>';
	$html .= '<h4>Response Data</h4>';
	// $html .= '<p style="text-align:justify;">You have gathered feedback from ' . $feed['ip_feedback'] . ' patients feedbacks for the selected period. Among these, ' .  $ip_app . ' patients provided feedback through the Mobile App, ' .  $ip_web . ' patients via Online Link, and ' . $ip_qr . ' patients via QR Code.</p>';
	$html .= '<p style="text-align:justify;">You have gathered feedback from ' .
		(isset($feed['ip_feedback']) ? $feed['ip_feedback'] . ' patient feedbacks for the selected period' . (isset($ip_app) || isset($ip_web) || isset($ip_qr) ? '. Among these, ' : '.') : '') .
		(isset($ip_app) ? $ip_app . ' patients provided feedback through the Mobile App' . (isset($ip_web) || isset($ip_qr) ? ', ' : '.') : '') .
		(isset($ip_web) ? $ip_web . ' patients via Online Link' . (isset($ip_qr) ? ', ' : '.') : '') .
		(isset($ip_qr) ? $ip_qr . ' patients via QR Code.' : '') .
		'</p>';
	$html .= '<p style="text-align:center;background: transparent; width: 100%;"><img src="' . $ebook_ip_bar  . '" style="height:250px; width:500px;"></p>';

	$html .= '<p style="text-align:justify;">Furthermore, it was discovered that' .
		(isset($lang['ip_1']) ? ', ' . $lang['ip_1'] . ' were completed in English' : '') .
		(isset($lang['ip_2']) ? ', ' . $lang['ip_2'] . ' in ' . $instance_lang2 : '') .
		(isset($lang['ip_3']) ? ', ' . $lang['ip_3'] . ' in ' . $instance_lang3 : '') .
		'.</p>';

	$html .= '<p></p>';
	$html .= '<p></p>';
	$html .= '<p style="text-align:center;background: transparent; width: 100%;"><img src="' . $ebook_ip_bar  . '" style="height:250px; width:500px;"></p>';

	$html .= '<p></p>';
	$html .= '<h4 id="ip_psat">Patient Satisfaction Analysis(PSAT)</h4>';
	$html .= '<p style="text-align:justify;">Out of the ' . $feed['ip_feedback'] . ' patient feedback responses collected, ' . $feed['ip_satisfied_count'] . ' patients conveyed satisfaction with their healthcare experience, indicating positive outcomes and service delivery. Conversely, ' . $feed['ip_unsatisfied_count'] . ' patients expressed dissatisfaction, signaling areas of improvement or concerns within the organization\'s services.</p>';
	$html .= '<p></p>';
	$html .= '<p style="text-align:center;background: transparent; width: 100%;"><img src="' . $ebook_ip_psat  . '" style="height:150px; width:400px;"></p>';
	$html .= '<p></p>';
	$html .= '<i><p style="' . $ip_psat_color . 'text-align:justify;">Based on the provided scores, ' . $title . ' has attained a <b> Patient Satisfaction Score of ' . $feed['ip_psat_score'] . '%</b>.</p></i>';
	if ($ip_low_psat == true) {
		$html .= '<p style="text-align:justify;">PSAT scores below approximately 60% could be considered low in the healthcare industry. This suggests that there are significant issues impacting patient satisfaction that need to be addressed promptly to improve overall service quality.</p>';
	} elseif ($ip_medium_psat == true) {
		$html .= '<p style="text-align:justify;">PSAT scores falling between approximately 60% and 80% may be considered medium in the healthcare industry. While satisfaction levels are relatively positive, there may still be areas for improvement to enhance patient experiences.</p>';
	} else {
		$html .= '<p style="text-align:justify;"><p>PSAT scores typically above 80% are often considered high in the healthcare industry. This indicates a high level of satisfaction among patients with the services provided.</p>';
	}


	$html .= '<h4 id="ip_nps">Net Promoter Analysis(NPS)</h4>';
	$html .= '<p style="text-align:justify;">Out of the ' . $feed['ip_feedback'] . ' patient feedback responses collected, ' .  $feed['ip_promoters_count'] . ' patients were classified as promoters, indicating they were highly satisfied with their experience and are likely to recommend the hospital to others. On the other hand,  ' .  $feed['ip_detractors_count']  . ' patients were identified as detractors, expressing dissatisfaction with their experience and possibly sharing negative opinions. Additionally, ' .  $feed['ip_passives_count'] . ' patients fell into the passive category, indicating they were generally satisfied but not as enthusiastic as promoters.</p>';
	$html .= '<p></p>';
	$html .= '<p style="text-align:center;background: transparent; width: 100%;"><img src="' . $ebook_ip_nps  . '" style="height:150px; width:400px;"></p>';

	$html .= '<p></p>';
	$html .= '<i><p style="' . $ip_nps_color . 'text-align:justify;">As a result of this feedback distribution, ' . $title . ' attained a <b> Net Promoter Score of ' . $feed['ip_nps_score'] . '%</b>.</p></i>';
	if ($ip_low_nps == true) {
		$html .= '<p style="text-align:justify;">NPS scores below approximately 30% could be considered low in the healthcare industry. This suggests that there may be significant issues impacting patient satisfaction and loyalty that need to be addressed urgently.</p>';
	} elseif ($ip_medium_nps == true) {
		$html .= '<p style="text-align:justify;">NPS scores falling between approximately 30% and 70% may be considered medium in the healthcare industry. While there are more promoters than detractors, there may be room for improvement in certain areas to further enhance patient satisfaction and loyalty.</p>';
	} else {
		$html .= '<p style="text-align:justify;">In the healthcare industry, NPS scores ranging from approximately 70% to 100% are often considered high. This indicates exceptionally high levels of patient satisfaction and loyalty.</p>';
	}


	$html .= '<h4 id="ip_hospital_sel">Hospital Selection Analysis</h4>';
	$html .= '<p></p>';

	$html .= '<p style="text-align:center;background: transparent; width: 100%;"><img src="' . $ip_hospital_selection  . '" style="height:220px; width:300px;"></p>';

	$html .= '<p style="text-align:justify;">Out of the ' . $feed['ip_feedback'] . ' patient feedback responses collected, ' . $ip_max_hospital_selection['count'] . ' choose <b>"' .  $ip_max_hospital_selection['title'] . '"</b> as their reason for selecting ' . $title . '.</p>';
	$html .= '<p style="text-align:justify;">You have to focus on <b>"' .  $ip_min_hospital_selection['title'] . '"</b> which was selected only ' . $ip_min_hospital_selection['count'] . ' times as their reason for selecting ' . $title . '.</p>';
	$html .= '<p></p>';
	$html .= '<p></p>';
	$html .= '<h4 id="ip_hospital_sel">Tickets</h4>';
	$html .= '<p></p>';

	$html .= '<p style="text-align:center;background: transparent; width: 100%;"><img src="' . $ebook_ip_tickets  . '" style="height:220px; width:300px;"></p>';
}




$html = str_replace('NAN', '0', $html);
// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');


// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('EFEEDOR E-BOOK-  ' . $d1 . ' to ' . $d2 . ' .pdf', 'I');
