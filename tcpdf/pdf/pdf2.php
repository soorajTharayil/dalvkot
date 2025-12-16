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
								
$html ='<table border="1" cellpadding="0" cellspacing="0" style="width:100%;">
						<tr><td colspan="5" style="text-align:center;"><h1>Nurshing Care Report</h1></td></tr>	
							<tr>
								<td > Patient Name:'.$rowp->name.'</td>
								<td > IP NO: '.$rowp->patient_id.'</td>
								<td  > Ward: '.$rowp->ward.'</td>
								<td  > Bed No: '.$rowp->bed_no.'</td>
								<td  > Primary Consultant: '.$rowp->location.'</td>
							</tr>
						</table>';
$sql = 'SELECT * FROM `bf_nursing_notes` WHERE patientid="'.$_REQUEST['patient_id'].'" GROUP BY datet,shift ORDER BY datet asc' ;			
$result = mysqli_query($con,$sql);	
$i=1;
while($row = mysqli_fetch_object($result)){
	$data = json_decode($row->notes);
	$sql = 'SELECT * FROM `bf_nurse` WHERE guid="'.$row->nurseid.'"' ;			
	$nuserr = mysqli_query($con,$sql);	
	$nus = mysqli_fetch_object($nuserr);
	$html .= '<h4>'.date('d-M-Y',strtotime($row->datetime)).', '.$row->shift.' By &nbsp;'.$nus->name.' '.$row->nurseid.'</h4>';
	$sql = 'SELECT * FROM `bf_nursing_notes` Where datet="'.$row->datet.'" AND shift="'.$row->shift.'" AND patientid="'.$_REQUEST['patient_id'].'"' ;			
	$resshift = mysqli_query($con,$sql);	
	while($rowshift = mysqli_fetch_object($resshift)){
		$datashift = json_decode($rowshift->notes);
		$sql = 'SELECT * FROM `bf_brand` WHERE guid="'.$datashift->problemNameKey.'"' ;			
		$title = mysqli_query($con,$sql);	
		$t = mysqli_fetch_object($title);
		$html .='<h3 style="background-color:#cccccc;  color:#ffffff;">&nbsp;'.$t->title.'</h3>
				<h4>Related To</h4>
				<ul>';
        foreach ($datashift->relatedAssessmentList as $d) {
			$sql   = 'SELECT * FROM `bf_related` WHERE guid="' . $d . '"';
			$brand = mysqli_query($con, $sql);
			$t     = mysqli_fetch_object($brand);
			$html .='<li>'.$t->title.'</li>';
        }
		$html .='</ul>'; 
		
		$html .='<h4>Intervention</h4>';
		$html .='<ul>';
		foreach($datashift->diagnosisList as $d){
			$sql = 'SELECT * FROM `bf_branditem` WHERE guid="'.$d.'"' ;			
			$brand = mysqli_query($con,$sql);	
			$t = mysqli_fetch_object($brand);
			//print_r($t);
			$html .= '<li>'.$t->title.' </li>'; 
		}				
		$html .='</ul>';
		
		$html .='<p><b>Remark: </b>'.$datashift->diagnosisRemarks.'</p>';
		$hmlt .='<h4>Outcome</h4>';
		$html .='<ul>';
		foreach($datashift->evaluationList as $d){
			$sql = 'SELECT * FROM `bf_evalution` WHERE guid="'.$d.'"' ;			
			$brand = mysqli_query($con,$sql);	
			$t = mysqli_fetch_object($brand);
			$html .='<li>'.$t->title.'</li>';
		}	
		$html .='</ul>';
		$html .='<p><b>Remarks: </b>'.$datashift->evaluationRemarks.'</p><br /><hr /><br /><br />';
	}		
	
}
//$html = 'HI';
$pdf->writeHTML(utf8_encode($html), true, false, true, false, '');
// ---------------------------------------------------------



$filename = 'handover'.$_REQUEST['patient_id'];

//Close and output PDF document
$pdf->Output($filename.'.pdf', 'I');
//============================================================+
// END OF FILE
//============================================================+
