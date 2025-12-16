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
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
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
$pdf->SetFont('helvetica', '', 10);

// add a page
$pdf->AddPage('L','LETTER');

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
								
$basic =' <table border="1">
						<tr><td colspan="6" align:center;><h1>Vital </h1></td></tr>	
							<tr>
								<td colspan="3"> Patient Name:'.$rowp->name.'</td>
								<td  colspan="3"> IP NO: '.$rowp->patient_id.'</td>
							</tr>
						</table>';
$basic .= '

<table border="0">
	<tr>
		<td colspan="2" style="width:200px;">
		<table border="1">
			<tr>
				
				<td>Date </td>
			</tr>
			<tr>
				
				<td>Time </td>
			</tr>
			<tr>
				
				<td>Shift </td>
			</tr>
			<tr>
				
				<td>Nurse </td>
			</tr>
			<tr><td>Temperature </td></tr>
			<tr><td>Pulse </td></tr>
			<tr><td>SPO2 </td></tr>
			<tr><td>BP-Systolic / BP-Diastolic  </td></tr>
			<tr><td>Respiratory </td></tr>
			<tr><td>Intake </td></tr>
			<tr><td>Output </td></tr>
			<tr><td>Drain </td></tr>
			<tr><td>Pain </td></tr>
			<tr><td>Weight </td></tr>
			<tr><td>GRBS </td></tr>
			<tr><td>GCS Score </td></tr>
			<tr><td>Braden Scale </td></tr>
			<tr><td>Others </td></tr>
			<tr><td>Edema </td></tr>
			<tr><td>Palor </td></tr>
			<tr><td>Icterus </td></tr>
			<tr><td>Tracheal Section </td></tr>
			<tr><td>Vomiting </td></tr>
			<tr><td>Mobility </td></tr>
			
			
			
			
		</table>
		</td>';
 
$sql = 'SELECT * FROM `bf_nursing_vitalreport` WHERE patientid="'.$_GET['patient_id'].'" ORDER BY datetime asc ' ;		
$result = mysqli_query($con,$sql);	
$html = '';
$i=1;
$page = 0;
$mypage = 1;
	while($row = mysqli_fetch_object($result)){
	
	if($page%9 == 0){
		$pdf->AddPage('L','LETTER');
		$pdf->setPage($mypage++);
		$pdf->writeHTMLCell(100, '11', '', '', $html, 1, 1, 1, true, 'J', true);
		$html = $basic;
	}
	$r = json_decode($row->values);
	$sql = 'SELECT * FROM `bf_nurse` WHERE guid="'.$r->nurse_id.'"' ;			
	$nuserr = mysqli_query($con,$sql);	
	$nus = mysqli_fetch_object($nuserr);
	$html .= ' 
	<td  style="padding:1px !important; width:100px;">
		<table  border="1">
			<tr>
				
				<td>&nbsp;'.date('d/M/Y',strtotime($r->datetime)).'</td>
			</tr>
			<tr>
				
				<td>&nbsp;'.date('H:i',strtotime($r->datetime)).'</td>
			</tr>
			<tr>
				
				<td>&nbsp;'.$r->shiftValue.' </td>
			</tr>
			<tr>
				<td>&nbsp;'.$nus->name.'</td>
			
			</tr>
			
			<tr><td>&nbsp;'.$r->tempValue.'F</td></tr>
			<tr><td>&nbsp;'.$r->pulseValue.' /min</td></tr>
			<tr><td>&nbsp;'.$r->spo2Value.'%</td></tr>
			<tr><td>&nbsp;'.$r->bpsystolic.' /'.$r->bpdiastolic.' /mmhg</td></tr>
			<tr><td>&nbsp;'.$r->respValue.' /min</td></tr>
			<tr><td>&nbsp;'.$r->intakeValue.' /ml</td></tr>
			<tr><td>&nbsp;'.$r->outputValue.' /ml</td></tr>
			<tr><td>&nbsp;'.$r->drainValue.' /ml</td></tr>
			<tr><td>&nbsp;'.$r->painValue.' /10</td></tr>
			<tr><td>&nbsp;'.$r->weightValue.'kg</td></tr>
			<tr><td>&nbsp;'.$r->grbsValue.'mg/dl</td></tr>
			<tr><td>&nbsp;'.$r->gcsValue.'/15</td></tr>
			<tr><td>&nbsp;'.$r->bradenValue.'</td></tr>
			<tr><td>&nbsp;'.$r->othersValue.'</td></tr>
			<tr><td>&nbsp;'.$r->edemaValue.'</td></tr>
			<tr><td>&nbsp;'.$r->palorValue.'</td></tr>
			<tr><td>&nbsp;'.$r->icterusValue.'</td></tr>
			<tr><td>&nbsp;'.$r->trachealValue.'</td></tr>
			<tr><td>&nbsp;'.$r->vomitingValue.'</td></tr>
			<tr><td>&nbsp;'.$r->mobilityValue.'</td></tr>
		
			
		</table>
	</td>';
	$page++;
	if($page%9 == 0){
		$html .= '</tr></table>';
	}
 } 
//echo  $html .= '</tr></table>';
//exit;
// output the HTML content
//echo $html; exit;
$pdf->writeHTML($html, true, false, true, false, '');
// ---------------------------------------------------------



//Close and output PDF document
$pdf->Output('example_061.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
