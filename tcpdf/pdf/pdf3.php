<?php
//============================================================+
// File name   : example_061.php
// Begin       : 2010-05-24
// Last Update : 2014-01-25
//
// Description : Example 061 for TCPDF class
//               XHTML + CSS
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: XHTML + CSS
 * @author Nicola Asuni
 * @since 2010-05-25
 */

// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');
error_reporting(0);
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 061');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 061', PDF_HEADER_STRING);

// set header and footer fonts
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', '', 9);

// add a page
$pdf->AddPage('P','LETTER');

/* NOTE:
 * *********************************************************
 * You can load external XHTML using :
 *
 * $html = file_get_contents('/path/to/your/file.html');
 *
 * External CSS files will be automatically loaded. 
 * Sometimes you need to fix the path of the external CSS.
 * *********************************************************
 */

// define some HTML content with style

							include('../../api/db.php');
$sql = 'SELECT * FROM `bf_patients` WHERE patient_id = "'.$_GET['patient_id'].'"' ;			
$result = mysqli_query($con,$sql);	
$rowp = mysqli_fetch_object($result);
						
$basic =' <div ><table border="1" cellpadding="0" cellspacing="0" style="width:640px">
						<tr><td colspan="5" style="text-align:center;"><h1>Handover Checklist </h1></td></tr>	
							<tr>
								<td > Patient Name:'.$rowp->name.'</td>
								<td > IP NO: '.$rowp->patient_id.'</td>
								<td  > Ward: '.$rowp->ward.'</td>
								<td  > Bed No: '.$rowp->bed_no.'</td>
								<td  > Primary Consultant: '.$rowp->location.'</td>
							</tr>
						</table>';
$sql = 'SELECT * FROM `bf_nursing_handover` WHERE  patientid="'.$_REQUEST['patient_id'].'"' ;			
$result = mysqli_query($con,$sql);	
$total = 0;
$data = array();
$datanur = array();
$html = '';

while($r = mysqli_fetch_object($result)){
	
	$jdata = json_decode($r->handover);
	foreach($jdata as $key => $rd){
		$data[$r->datet][str_replace('12-','',$key)][$r->shiftValue] = $rd;
	}
	$total++;
	$datanur[$r->datet][$r->shiftValue] = $r->nurseid;
	$datare[$r->datet][$r->shiftValue] = $r->remarks;
}

$sql = 'SELECT * FROM `bf_nursing_handover` WHERE patientid="'.$_REQUEST['patient_id'].'" GROUP BY datet ORDER BY datet asc' ;			
$dater = mysqli_query($con,$sql);	
$rowcount = 0;
$datearray = array();
$totaldays = 0;
while($date = mysqli_fetch_object($dater)){
	$rowcount +=3;
	$totaldays++;
	$datearray[] = $date->datet;
	
}


foreach($datearray as $hdate){
	$html .=$basic;
	$html .='<table border="1"  cellpadding="0" cellspacing="0">'; 
	$html .='<tr><td style="width:400px;">DATE</td><td colspan="3" style="text-align:center; width:240px;">'.$hdate.'</td></tr>';
	$html .='<tr><td>Shift</td><td style="width:80px; text-align:center;">Morning</td><td style="width:80px; text-align:center;">Afternoon</td><td style="width:80px; text-align:center;">Evening</td></tr>';
	$html .='<tr><td>NURSE</td>';
	for($pq=1;$pq<4;$pq++){ 
		$sql = 'SELECT * FROM `bf_nurse` WHERE guid="'.$datanur[$datearray[$keynurse]]['Shift'.$pq].'"' ;			
		$nuserr = mysqli_query($con,$sql);	
		$nus = mysqli_fetch_object($nuserr);
		$html .='<td>'.$nus->name.'</td>';
	}
	$html .='</tr>';
	$sql = 'SELECT * FROM `bf_category` WHERE 1 order by id asc' ;			
	$result = mysqli_query($con,$sql);	
	$category = mysqli_num_rows($result);
	while($row = mysqli_fetch_object($result)){
		if($row->status == 1){
			$html .='<tr><td style="text-align:left;">'.str_replace('--','',$row->title).'</td>';
			for($pq=1;$pq<4;$pq++){ 
				$shift = $pq;
				$html .='<td style="text-align:center;">'.$data[$hdate][$row->id]['Shift'.$shift].'</td>';
			}
			$html .='</tr>';
		}else{
			$html .='<tr><td colspan="4"><b>'.str_replace('--','',$row->title).'</b></td></tr>';
		}
	}
	$html .='</table><br />';

}
//echo  $html .= '</tr></table>';
//exit;
// output the HTML content
$pdf->writeHTML($html, true, false, true, false, 'I');
// ---------------------------------------------------------



$filename = 'handover'.$_REQUEST['patient_id'];

//Close and output PDF document
$pdf->Output($filename.'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
