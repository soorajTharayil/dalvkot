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
						<tr><td colspan="5" style="text-align:center;"><h1>Intake Output Report</h1></td></tr>	
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
$html .='<table border="1" cellpadding="5" cellspacing="0" class="table table-bordered table-hover" >
				<tbody>
					<tr>
						<td  colspan="9">Intake</td>
						<td  colspan="7">Output</td>
					</tr>
					<tr>
						<td colspan="3">ORAL</td>
						<td  colspan="2">R/T FEEd</td>
						<td  colspan="4">I / V / FLUID</td>
						<td>Time</td>
						<td>Urine</td>
						<td>Emesis</td>
						<td>Aspirate</td>
						<td>Drain</td>
						<td>Stool</td>
						<td>Remark</td>
					</tr>
					<tr>
						<td>Time</td>
						<td>Type</td>
						<td>Amount</td>
						<td>Type</td>
						<td>Amount</td>
						<td>Time</td>
						<td>Type</td>
						<td>Started</td>
						<td>Infused</td>
						<td colspan="7">&nbsp;</td>
					</tr>';
$sql = 'SELECT * FROM bf_nursing_intakeoutput WHERE  patientid="'.$_REQUEST['patient_id'].'" group by datet' ;			
$results = mysqli_query($con,$sql);	
while($rp = mysqli_fetch_object($results)){
		$html .='<tr><td colspan="16"><b>DATE:'.$rp->datet.'</b></td></tr>';
		$oral = 0; $rtAmountText =0; $ivInfusedText =0; $outputUrineText =0; $outputEmesisText=0; $outputAspirateEdit= 0; $outputDrainText=0; $outputStoolEdit=0;
		$sql = 'SELECT * FROM bf_nursing_intakeoutput WHERE  patientid="'.$_REQUEST['patient_id'].'" AND datet="'.$rp->datet.'"' ;			
		$result = mysqli_query($con,$sql);	
		while($r = mysqli_fetch_object($result)){
			$data = json_decode($r->values);
			$oral +=$data->oralAmountText;
			$rtAmountText +=$data->rtAmountText*1;
			$ivInfusedText +=$data->ivInfusedText;
			$outputUrineText +=$data->outputUrineText;
			$outputEmesisText +=$data->outputEmesisText;
			$outputAspirateEdit +=$data->outputAspirateEdit;
			$outputDrainText +=$data->outputDrainText;
			$outputStoolEdit +=$data->outputStoolEdit;
			$html .='<tr>
			
						<td>'.$data->oralTimeText.'</td>
						<td>'.$data->oralTypeText.'</td>
						<td>'.$data->oralAmountText.'</td>
						<td>'.$data->rtFeedTypeText.'</td>
						<td>'.$data->rtAmountText.'</td>
						<td>'.$data->ivFluidTimeText.'</td>
						<td>'.$data->ivFluidTypeText.'</td>
						
						<td>'.$data->ivStartedText.'</td>
						<td>'.$data->ivInfusedText.'</td>
						
						<td>'.$data->outputTimeText.'</td>
						<td>'.$data->outputUrineText.'</td>
						<td>'.$data->outputEmesisText.'</td>
						<td>'.$data->outputAspirateEdit.'</td>
						<td>'.$data->outputDrainText.'</td>
						<td>'.$data->outputStoolEdit.'</td>
						<td>'.$data->remarksText.'</td>
						
					</tr>';
		}
		$t1 = $oral +  $ivInfusedText + $rtAmountText; 
		$t2 = $outputUrineText + $outputEmesisText + $outputAspirateEdit + $outputDrainText + $outputStoolEdit;
		$html .='<tr>
	<td>Total</td>
	
			<td></td>
			<td>'.$oral.'</td>
			<td></td>
			<td>'.$rtAmountText.'</td>
			<td></td>
			<td></td>
			
			<td>'.$ivStartedText.'</td>
			<td>'.$ivInfusedText.'</td>
			
			<td></td>
			<td>'.$outputUrineText.'</td>
			<td>'.$outputEmesisText.'</td>
			<td>'.$outputAspirateEdit.'</td>
			<td>'.$outputDrainText.'</td>
			<td>'.$outputStoolEdit.'</td>
			<td></td>
	</tr>
	<tr>
			<td  colspan="9">Grand Total '.$t1.'</td>
			<td  colspan="7">Grand Total '.$t2.'</td>
		</tr>';
}
$html .='<tbody>
     </table>
                  </div>';
//$html = 'HI';
$pdf->writeHTML(utf8_encode($html), true, false, true, false, '');
// ---------------------------------------------------------



$filename = 'handover'.$_REQUEST['patient_id'];

//Close and output PDF document
$pdf->Output($filename.'.pdf', 'I');
//============================================================+
// END OF FILE
//============================================================+
