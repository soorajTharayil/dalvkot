<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Exportreportop extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		
		
		if ($this->session->userdata('isLogIn') == false) 
			redirect('login'); 
		else{
			redirect('dashboard/swithc?type=9'); 

		}
	}
	
	
	
	
	public function explortopcomment(){
		$fdate = $_GET['fdate'];
		$tdate = $_GET['tdate'];
		$this->db->select('bf_outfeedback.*,bf_opatients.name as pname,bf_opatients.patient_id as pid');
		$this->db->from('bf_outfeedback');
		$this->db->join('bf_opatients', 'bf_opatients.patient_id = bf_outfeedback.patientid', 'inner');

		if (isset($_SESSION['ward']) && $_SESSION['ward'] != 'ALL'){
			$this->db->where('bf_outfeedback.ward', $_SESSION['ward']);
		}

		$fdate = date('Y-m-d', strtotime($fdate) + 3600 * 12);
		$fdatet = date('Y-m-d 23:59:59', strtotime($fdate));
		$this->db->where('bf_outfeedback.datet <=', $fdatet);
		$this->db->where('bf_outfeedback.datet >=', $tdate);
		$this->db->order_by('datetime', 'desc');
		$query = $this->db->get();
		$feedbacktaken = $query->result();
		
		
		$this->db->order_by('id');
		$this->db->where('parent', 1);

		$query = $this->db->get('setupop');
		$sresult = $query->result();
		$setarray = array();
		foreach($sresult as $r){
			$setarray[$r->type] = $r->title;
		}
		$questioarray = array();
		//echo '<pre>';
		//exit;
		$comments = array();
		//header
		$comments[0][0] = 'PATIENTS NAME';
		$comments[0][1] = 'PATIENTS ID';
		$comments[0][2] = 'FEEDBACK DATE';
		$comments[0][3] = 'EMAIL';
		$comments[0][4] = 'CONTACT NUMBER';
		$comments[0][5] = 'GENERAL COMMENT';
		$i = 6;
		foreach($setarray as $r){
			$comments[0][$i] = $r;
			$i++;
		}

		//$comments = array();
		$k = 1;
		foreach($feedbacktaken as $r){
			$d = json_decode($r->dataset,true);
			if(($d['suggestionText'] != '' && $d['suggestionText'] != NULL) || count($d['comment']) > 0){
				$comments[$k][0] = $r->pname;
				$comments[$k][1] = $r->patientid;
				$comments[$k][2] = date('d-M-Y',strtotime($r->datetime));
				//$comments[$k][3] = $r->datetime;
				$comments[$k][3] = $d['email'];
				$comments[$k][4] = $d['contactnumber'];
				$comments[$k][5] = $d['suggestionText'];
				$i = 6;
				foreach($setarray as $key => $t){
					if($d['comment'][$key] != ''){
						$comments[$k][$i] = $d['comment'][$key];
					}else{
						$comments[$k][$i] = '';
					}
					$i++;
				}
				$k++;
			}
			
		}
		
		//print_r($comments);
		ob_end_clean();
		$fileName = 'OP- PATIENTS COMMENTS - '.date('d-m-Y',strtotime($_GET['tdate'])).' to '.date('d-m-Y',strtotime($_GET['fdate'])).'.csv';
		header('Pragma: public');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Cache-Control: private', false);
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment;filename=' . $fileName);    
		if(isset($comments[0])){		
			$fp = fopen('php://output', 'w');
			//fputcsv($fp, $comments[0],',');
			foreach($comments AS $values){
				
				fputcsv($fp, $values, ',');
			}
			fclose($fp);
		}
		ob_flush();
		exit;
		
	
	}
	
	public function expormainip(){
		$fdate = $_GET['fdate'];
		$tdate = $_GET['tdate'];
		$this->db->select('bf_outfeedback.*,bf_opatients.name as pname,bf_opatients.patient_id as pid');
		$this->db->from('bf_outfeedback');
		$this->db->join('bf_opatients', 'bf_opatients.patient_id = bf_outfeedback.patientid', 'inner');

		if (isset($_SESSION['ward']) && $_SESSION['ward'] != 'ALL'){
			$this->db->where('bf_opatients.ward', $_SESSION['ward']);
		}

		$fdate = date('Y-m-d', strtotime($fdate) + 3600 * 12);
		$fdatet = date('Y-m-d 23:59:59', strtotime($fdate));
		$this->db->where('bf_outfeedback.datet <=', $fdatet);
		$this->db->where('bf_outfeedback.datet >=', $tdate);
		$this->db->order_by('datetime', 'desc');
		$query = $this->db->get();
		$feedbacktaken = $query->result();
		//print_r($feedbacktaken);
		//exit;
		
		$this->db->order_by('id');
		$this->db->where('parent', 1);

		$query = $this->db->get('setupop');
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

		
		
		
		
		
		$header[0] = 'Patient Name';
		$header[1] = 'Patient ID';
		$header[2] = 'Mobile Number';
		$header[3] = 'Email id';
		$j = 4;
		foreach($arraydata as $k => $r){
			$header[$j] = $r;
			$j++;
		}
		$header[$j] = 'Overall Rating';
		$dataexport = array();
		$i=0;
		foreach($feedbacktaken as $row){
			$data = json_decode($row->dataset,true);
			$dataexport[$i]['name'] = $data['name'];
			$dataexport[$i]['patient_id'] = $data['patientid'];
			$dataexport[$i]['mobile'] = $data['contactnumber'];
			$dataexport[$i]['email'] = $data['email'];
			foreach($arraydata as $k => $r){
				$dataexport[$i][$k] = $data[$k];
				
			}
			$dataexport[$i]['overallScore'] = $data['overallScore'];
			$i++;
		}
		$newdataset = $dataexport;
		$d = array();
		$p = array();
		$n = array();
		$para = array();
		$for5 = array();
		$for4 = array();
		$for3 = array();
		$for2 = array();
		$for1 = array();
		foreach($dataexport as $row){
			foreach($row as $k => $r){
				if($r*1 > 0){

					$d[$k] = $d[$k] + 1;
					if($r > 2){
						$p[$k] = $p[$k] + 1;
					}else{
						$n[$k] = $n[$k] + 1;
					}
					$para[$k] = $para[$k] + $r;
					if($k == 'overallScore'){
						if($r == 5){
							$for5[$k] = $for5[$k] + 1;
						}
						if($r == 4){
							$for4[$k] = $for4[$k] + 1;
						}
						if($r == 3){
							$for3[$k] = $for3[$k] + 1;
						}
						if($r == 2){
							$for2[$k] = $for2[$k] + 1;
						}
						if($r == 1){
							$for1[$k] = $for1[$k] + 1;
						}
					}
					
						
				}
			}
			
		}
		/*$dataexport[$i]['name'] = '';
		$i++;
		$dataexport[$i]['name'] = 'TOTAL PATIENTS RATED';
		$dataexport[$i]['patient_id'] = '';
		$dataexport[$i]['mobile'] = '';
		$dataexport[$i]['email'] = '';
		foreach($arraydata as $k => $r){
			$dataexport[$i][$k] = $d[$k];
		}
		$i++;
		$dataexport[$i]['name'] = 'PATIENTS RATED POSITIVE';
		$dataexport[$i]['patient_id'] = '';
		$dataexport[$i]['mobile'] = '';
		$dataexport[$i]['email'] = '';
		foreach($arraydata as $k => $r){
			$dataexport[$i][$k] = $p[$k];
		}
		$i++;
		$dataexport[$i]['name'] = 'PATIENTS RATED NEGATIVE';
		$dataexport[$i]['patient_id'] = '';
		$dataexport[$i]['mobile'] = '';
		$dataexport[$i]['email'] = '';
		foreach($arraydata as $k => $r){
			$dataexport[$i][$k] = $n[$k];
		}
		$i++;
		$dataexport[$i]['name'] = '';
		$i++;
		$dataexport[$i]['name'] = '';
		$i++;
		$dataexport[$i]['name'] = 'TOTAL PARAMETER SCORE';
		$dataexport[$i]['patient_id'] = '';
		$dataexport[$i]['mobile'] = '';
		$dataexport[$i]['email'] = '';
		foreach($arraydata as $k => $r){
			$dataexport[$i][$k] = $para[$k];
		}
		$i++;
		$dataexport[$i]['name'] = 'REQUIRED SCORE';
		$dataexport[$i]['patient_id'] = '';
		$dataexport[$i]['mobile'] = '';
		$dataexport[$i]['email'] = '';
		foreach($arraydata as $k => $r){
			$dataexport[$i][$k] = $d[$k]*5;
		}
		$i++;
		$dataexport[$i]['name'] = 'RELATIVE PERFORMANCE';
		$dataexport[$i]['patient_id'] = '';
		$dataexport[$i]['mobile'] = '';
		$dataexport[$i]['email'] = '';
		foreach($arraydata as $k => $r){
			$dataexport[$i][$k] = round(($para[$k]/($d[$k]*5))*100).'%';
		}
		$i++;
		$dataexport[$i]['name'] = '';
		$i++;
		$dataexport[$i]['name'] = '';
		$i++;
		
		$dataexport[$i]['name'] = 'OVERALL RATING ANALYSIS';
		$dataexport[$i]['patient_id'] = 'By No. of Patients';
		$dataexport[$i]['mobile'] = 'By Percentage';
		
		
		$i++;
		
		$dataexport[$i]['name'] = 'EXCELLENT(5)';
		$dataexport[$i]['patient_id'] = $for5['overallScore']*1;
		$dataexport[$i]['mobile'] = round(($for5['overallScore']/$d[$k])*100).'%';
		
		
		$i++;
		$dataexport[$i]['name'] = '';
		$dataexport[$i]['name'] = 'VERY GOOD(4)';
		$dataexport[$i]['patient_id'] = $for4['overallScore']*1;
		$dataexport[$i]['mobile'] = round(($for4['overallScore']/$d[$k])*100).'%';
		
		
		
		$i++;
		
		$dataexport[$i]['name'] = 'GOOD(3)';
		$dataexport[$i]['patient_id'] = $for3['overallScore']*1;
		$dataexport[$i]['mobile'] = round(($for3['overallScore']/$d[$k])*100).'%';
		
		
		
		$i++;
		
		$dataexport[$i]['name'] = 'AVERAGE(2)';
		$dataexport[$i]['patient_id'] = $for2['overallScore']*1;
		$dataexport[$i]['mobile'] = round(($for2['overallScore']/$d[$k])*100).'%';
		
		
		$i++;
		
		$dataexport[$i]['name'] = 'POOR(1)';
		$dataexport[$i]['patient_id'] = $for1['overallScore']*1;
		$dataexport[$i]['mobile'] = round(($for1['overallScore']/$d[$k])*100).'%';
		*/
		
		ob_end_clean();
		$fileName = 'OP- PATIENTS WISE FEEDBACK REPORT - '.date('d-m-Y',strtotime($_GET['tdate'])).' to '.date('d-m-Y',strtotime($_GET['fdate'])).'.csv';
		header('Pragma: public');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Cache-Control: private', false);
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment;filename=' . $fileName);    
		if(isset($dataexport[0])){
			$fp = fopen('php://output', 'w');
			//print_r($header);
			fputcsv($fp, $header,',');
			foreach($dataexport AS $values){
				//print_r($values); exit;
				fputcsv($fp, $values, ',');
			}
			fclose($fp);
		}
		ob_flush();
		exit;
	}
	
	
	public function exportmainipdepartment(){
		$fdate = $_GET['fdate'];
		$tdate = $_GET['tdate'];
		$this->db->select('bf_outfeedback.*,bf_opatients.name as pname,bf_opatients.patient_id as pid');
		$this->db->from('bf_outfeedback');
		$this->db->join('bf_opatients', 'bf_opatients.patient_id = bf_outfeedback.patientid', 'inner');

		if (isset($_SESSION['ward']) && $_SESSION['ward'] != 'ALL'){
			$this->db->where('bf_opatients.ward', $_SESSION['ward']);
		}

		$fdate = date('Y-m-d', strtotime($fdate) + 3600 * 12);
		$fdatet = date('Y-m-d 23:59:59', strtotime($fdate));
		$this->db->where('bf_outfeedback.datet <=', $fdatet);
		$this->db->where('bf_outfeedback.datet >=', $tdate);
		$this->db->order_by('datetime', 'desc');
		$query = $this->db->get();
		$feedbacktaken = $query->result();
		//print_r($feedbacktaken);
		//exit;
		
		$this->db->order_by('id');
		$this->db->where('parent', 1);

		$query = $this->db->get('setupop');
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

		
		
		
		
		$i=0;
		//$header[0] = '';
		$header[1] = '';
		$header[2] = '';
		
		$j = 4;
		foreach($arraydata as $k => $r){
			$header[$j] = $r;
			$j++;
		}
		$dataexport = array();
		$dataexportt = array();
		$i=0;
		foreach($feedbacktaken as $row){
			$data = json_decode($row->dataset,true);
			$dataexportt[$i]['name'] = $data['name'];
			$dataexportt[$i]['patient_id'] = $data['patientid'];
			$dataexportt[$i]['mobile'] = $data['mobile'];
			$dataexportt[$i]['email'] = $data['email'];
			foreach($arraydata as $k => $r){
				$dataexportt[$i][$k] = $data[$k];
				
			}
			$dataexportt[$i]['overallScore'] = $data['overallScore'];
			$i++;
		}
		$newdataset = $dataexport;
		$d = array();
		$p = array();
		$n = array();
		$para = array();
		$for5 = array();
		$for4 = array();
		$for3 = array();
		$for2 = array();
		$for1 = array();
		foreach($dataexportt as $row){
			foreach($row as $k => $r){
				if($r*1 > 0){

					$d[$k] = $d[$k] + 1;
					if($r > 2){
						$p[$k] = $p[$k] + 1;
					}else{
						$n[$k] = $n[$k] + 1;
					}
					$para[$k] = $para[$k] + $r;
					if($k == 'overallScore'){
						if($r == 5){
							$for5[$k] = $for5[$k] + 1;
						}
						if($r == 4){
							$for4[$k] = $for4[$k] + 1;
						}
						if($r == 3){
							$for3[$k] = $for3[$k] + 1;
						}
						if($r == 2){
							$for2[$k] = $for2[$k] + 1;
						}
						if($r == 1){
							$for1[$k] = $for1[$k] + 1;
						}
					}
					
						
				}
			}
			
		}
		$i=0;
		
		/*$dataexport[$i]['name'] = 'OVERALL RATING ANALYSIS';
		$dataexport[$i]['patient_id'] = 'By No. of Patients';
		$dataexport[$i]['mobile'] = 'By Percentage';
		
		
		$i++;
		
		$dataexport[$i]['name'] = 'EXCELLENT(5)';
		$dataexport[$i]['patient_id'] = $for5['overallScore']*1;
		$dataexport[$i]['mobile'] = round(($for5['overallScore']/$d[$k])*100).'%';
		
		
		$i++;
		$dataexport[$i]['name'] = '';
		$dataexport[$i]['name'] = 'VERY GOOD(4)';
		$dataexport[$i]['patient_id'] = $for4['overallScore']*1;
		$dataexport[$i]['mobile'] = round(($for4['overallScore']/$d[$k])*100).'%';
		
		
		
		$i++;
		
		$dataexport[$i]['name'] = 'GOOD(3)';
		$dataexport[$i]['patient_id'] = $for3['overallScore']*1;
		$dataexport[$i]['mobile'] = round(($for3['overallScore']/$d[$k])*100).'%';
		
		
		
		$i++;
		
		$dataexport[$i]['name'] = 'AVERAGE(2)';
		$dataexport[$i]['patient_id'] = $for2['overallScore']*1;
		$dataexport[$i]['mobile'] = round(($for2['overallScore']/$d[$k])*100).'%';
		
		
		$i++;
		
		$dataexport[$i]['name'] = 'POOR(1)';
		$dataexport[$i]['patient_id'] = $for1['overallScore']*1;
		$dataexport[$i]['mobile'] = round(($for1['overallScore']/$d[$k])*100).'%';
		
		$i++;*/
		$dataexport[$i]['name'] = '';
		$k = 0;
		foreach($header as $r){
			$dataexport[$i][$k] = $r;
			$k++;
		}
		$i++;
		$dataexport[$i]['name'] = 'TOTAL PATIENTS RATED';
		//$dataexport[$i]['patient_id'] = '';
		$dataexport[$i]['mobile'] = '';
		$dataexport[$i]['email'] = '';
		foreach($arraydata as $k => $r){
			$dataexport[$i][$k] = $d[$k];
		}
		$i++;
		$dataexport[$i]['name'] = 'PATIENTS RATED POSITIVE';
		//$dataexport[$i]['patient_id'] = '';
		$dataexport[$i]['mobile'] = '';
		$dataexport[$i]['email'] = '';
		foreach($arraydata as $k => $r){
			$dataexport[$i][$k] = $p[$k];
		}
		$i++;
		$dataexport[$i]['name'] = 'PATIENTS RATED NEGATIVE';
		//$dataexport[$i]['patient_id'] = '';
		$dataexport[$i]['mobile'] = '';
		$dataexport[$i]['email'] = '';
		foreach($arraydata as $k => $r){
			$dataexport[$i][$k] = $n[$k];
		}
		$i++;
		$dataexport[$i]['name'] = '';
		$i++;
		$dataexport[$i]['name'] = '';
		$i++;
		$dataexport[$i]['name'] = 'TOTAL PARAMETER SCORE';
		//$dataexport[$i]['patient_id'] = '';
		$dataexport[$i]['mobile'] = '';
		$dataexport[$i]['email'] = '';
		foreach($arraydata as $k => $r){
			$dataexport[$i][$k] = $para[$k];
		}
		$i++;
		$dataexport[$i]['name'] = 'REQUIRED SCORE';
		//$dataexport[$i]['patient_id'] = '';
		$dataexport[$i]['mobile'] = '';
		$dataexport[$i]['email'] = '';
		foreach($arraydata as $k => $r){
			$dataexport[$i][$k] = $d[$k]*5;
		}
		$i++;
		$dataexport[$i]['name'] = 'RELATIVE PERFORMANCE';
		//$dataexport[$i]['patient_id'] = '';
		$dataexport[$i]['mobile'] = '';
		$dataexport[$i]['email'] = '';
		foreach($arraydata as $k => $r){
			$dataexport[$i][$k] = round(($para[$k]/($d[$k]*5))*100).'%';
		}
		$i++;
		$dataexport[$i]['name'] = '';
		$i++;
		$dataexport[$i]['name'] = '';
		$i++;
		//print_r($dataexport); exit;
		
		ob_end_clean();
		$fileName = 'OP- DEPARTMENT WISE REPORT - '.date('d-m-Y',strtotime($_GET['tdate'])).' to '.date('d-m-Y',strtotime($_GET['fdate'])).'.csv';
		header('Pragma: public');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Cache-Control: private', false);
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment;filename=' . $fileName);    
		if(isset($dataexport[0])){
			$fp = fopen('php://output', 'w');
			//print_r($header);
			//fputcsv($fp, $header,',');
			foreach($dataexport AS $values){
				//print_r($values); exit;
				fputcsv($fp, $values, ',');
			}
			fclose($fp);
		}
		ob_flush();
		exit;
	}
	
	
	public function expormainop(){
		$fdate = $_GET['fdate'];
		$tdate = $_GET['tdate'];
		$this->db->select('bf_outfeedback.*,bf_opatients.name as pname,bf_opatients.patient_id as pid');
		$this->db->from('bf_outfeedback');
		$this->db->join('bf_opatients', 'bf_opatients.patient_id = bf_outfeedback.patientid', 'inner');

		if (isset($_SESSION['ward']) && $_SESSION['ward'] != 'ALL'){
			$this->db->where('bf_opatients.ward', $_SESSION['ward']);
		}

		$fdate = date('Y-m-d', strtotime($fdate) + 3600 * 12);
		$fdatet = date('Y-m-d 23:59:59', strtotime($fdate));
		$this->db->where('bf_outfeedback.datet <=', $fdatet);
		$this->db->where('bf_outfeedback.datet >=', $tdate);
		$this->db->order_by('datetime', 'desc');
		$query = $this->db->get();
		$feedbacktaken = $query->result();
		
		
		$this->db->order_by('id');
		$this->db->where('parent', 1);

		$query = $this->db->get('setupop');
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

		
		
		
		
		
		$header[0] = 'Patient Name';
		$header[1] = 'Patient ID';
		$header[2] = 'Mobile Number';
		$header[3] = 'Email id';
		$j = 4;
		foreach($arraydata as $k => $r){
			$header[$j] = $r;
			$j++;
		}
		$header[$j] = 'Overall Rating';
		$dataexport = array();
		$i=0;
		foreach($feedbacktaken as $row){
			$data = json_decode($row->dataset,true);
			$dataexport[$i]['name'] = $data['name'];
			$dataexport[$i]['patient_id'] = $data['patientid'];
			$dataexport[$i]['mobile'] = $data['contactnumber'];
			$dataexport[$i]['email'] = $data['email'];
			foreach($arraydata as $k => $r){
				$dataexport[$i][$k] = $data[$k];
				
			}
			$dataexport[$i]['overallScore'] = $data['overallScore'];
			$i++;
		}
		$newdataset = $dataexport;
		$d = array();
		$p = array();
		$n = array();
		$para = array();
		$for5 = array();
		$for4 = array();
		$for3 = array();
		$for2 = array();
		$for1 = array();
		foreach($dataexport as $row){
			foreach($row as $k => $r){
				if($r*1 > 0){

					$d[$k] = $d[$k] + 1;
					if($r > 2){
						$p[$k] = $p[$k] + 1;
					}else{
						$n[$k] = $n[$k] + 1;
					}
					$para[$k] = $para[$k] + $r;
					if($k == 'overallScore'){
						if($r == 5){
							$for5[$k] = $for5[$k] + 1;
						}
						if($r == 4){
							$for4[$k] = $for4[$k] + 1;
						}
						if($r == 3){
							$for3[$k] = $for3[$k] + 1;
						}
						if($r == 2){
							$for2[$k] = $for2[$k] + 1;
						}
						if($r == 1){
							$for1[$k] = $for1[$k] + 1;
						}
					}
					
						
				}
			}
			
		}
		$dataexport[$i]['name'] = '';
		$i++;
		$dataexport[$i]['name'] = 'TOTAL PATIENTS RATED';
		$dataexport[$i]['patient_id'] = '';
		$dataexport[$i]['mobile'] = '';
		$dataexport[$i]['email'] = '';
		foreach($arraydata as $k => $r){
			$dataexport[$i][$k] = $d[$k];
		}
		$i++;
		$dataexport[$i]['name'] = 'PATIENTS RATED POSITIVE';
		$dataexport[$i]['patient_id'] = '';
		$dataexport[$i]['mobile'] = '';
		$dataexport[$i]['email'] = '';
		foreach($arraydata as $k => $r){
			$dataexport[$i][$k] = $p[$k];
		}
		$i++;
		$dataexport[$i]['name'] = 'PATIENTS RATED NEGATIVE';
		$dataexport[$i]['patient_id'] = '';
		$dataexport[$i]['mobile'] = '';
		$dataexport[$i]['email'] = '';
		foreach($arraydata as $k => $r){
			$dataexport[$i][$k] = $n[$k];
		}
		$i++;
		$dataexport[$i]['name'] = '';
		$i++;
		$dataexport[$i]['name'] = '';
		$i++;
		$dataexport[$i]['name'] = 'TOTAL PARAMETER SCORE';
		$dataexport[$i]['patient_id'] = '';
		$dataexport[$i]['mobile'] = '';
		$dataexport[$i]['email'] = '';
		foreach($arraydata as $k => $r){
			$dataexport[$i][$k] = $para[$k];
		}
		$i++;
		$dataexport[$i]['name'] = 'REQUIRED SCORE';
		$dataexport[$i]['patient_id'] = '';
		$dataexport[$i]['mobile'] = '';
		$dataexport[$i]['email'] = '';
		foreach($arraydata as $k => $r){
			$dataexport[$i][$k] = $d[$k]*5;
		}
		$i++;
		$dataexport[$i]['name'] = 'RELATIVE PERFORMANCE';
		$dataexport[$i]['patient_id'] = '';
		$dataexport[$i]['mobile'] = '';
		$dataexport[$i]['email'] = '';
		foreach($arraydata as $k => $r){
			$dataexport[$i][$k] = round(($para[$k]/($d[$k]*5))*100).'%';
		}
		$i++;
		$dataexport[$i]['name'] = '';
		$i++;
		$dataexport[$i]['name'] = '';
		$i++;
		
		$dataexport[$i]['name'] = 'OVERALL RATING ANALYSIS';
		$dataexport[$i]['patient_id'] = 'By No. of Patients';
		$dataexport[$i]['mobile'] = 'By Percentage';
		
		
		$i++;
		
		$dataexport[$i]['name'] = 'EXCELLENT(5)';
		$dataexport[$i]['patient_id'] = $for5['overallScore']*1;
		$dataexport[$i]['mobile'] = round(($for5['overallScore']/$d[$k])*100).'%';
		
		
		$i++;
		$dataexport[$i]['name'] = '';
		$dataexport[$i]['name'] = 'VERY GOOD(4)';
		$dataexport[$i]['patient_id'] = $for4['overallScore']*1;
		$dataexport[$i]['mobile'] = round(($for4['overallScore']/$d[$k])*100).'%';
		
		
		
		$i++;
		
		$dataexport[$i]['name'] = 'GOOD(3)';
		$dataexport[$i]['patient_id'] = $for3['overallScore']*1;
		$dataexport[$i]['mobile'] = round(($for3['overallScore']/$d[$k])*100).'%';
		
		
		
		$i++;
		
		$dataexport[$i]['name'] = 'AVERAGE(2)';
		$dataexport[$i]['patient_id'] = $for2['overallScore']*1;
		$dataexport[$i]['mobile'] = round(($for2['overallScore']/$d[$k])*100).'%';
		
		
		$i++;
		
		$dataexport[$i]['name'] = 'POOR(1)';
		$dataexport[$i]['patient_id'] = $for1['overallScore']*1;
		$dataexport[$i]['mobile'] = round(($for1['overallScore']/$d[$k])*100).'%';
		
		
		ob_end_clean();
		$fileName = 'OP-Patient & Department wise report - OP - '.date('d-m-Y',strtotime($_GET['tdate'])).' to '.date('d-m-Y',strtotime($_GET['fdate'])).'.csv';
		header('Pragma: public');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Cache-Control: private', false);
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment;filename=' . $fileName);    
		if(isset($dataexport[0])){
			$fp = fopen('php://output', 'w');
			//print_r($header);
			fputcsv($fp, $header,',');
			foreach($dataexport AS $values){
				//print_r($values); exit;
				fputcsv($fp, $values, ',');
			}
			fclose($fp);
		}
		ob_flush();
		exit;
	}
	
	public function expormainfull(){
		$fdate = $_GET['fdate'];
		$tdate = $_GET['tdate'];
		$this->db->select('bf_outfeedback.*,bf_opatients.name as pname,bf_opatients.patient_id as pid');
		$this->db->from('bf_outfeedback');
		$this->db->join('bf_opatients', 'bf_opatients.patient_id = bf_outfeedback.patientid', 'inner');

		if (isset($_SESSION['ward']) && $_SESSION['ward'] != 'ALL'){
			$this->db->where('bf_opatients.ward', $_SESSION['ward']);
		}

		$fdate = date('Y-m-d', strtotime($fdate) + 3600 * 12);
		$fdatet = date('Y-m-d 23:59:59', strtotime($fdate));
		$this->db->where('bf_outfeedback.datet <=', $fdatet);
		$this->db->where('bf_outfeedback.datet >=', $tdate);
		$this->db->order_by('datetime', 'desc');
		$query = $this->db->get();
		$feedbacktaken = $query->result();
		$promoter = 0;
		$depromoter = 0;
		$passive = 0;
		foreach($feedbacktaken as $r){
			$this->db->where('feedbackid', $r->id);
			$query = $this->db->get('ticketsop');
			$dtata = $query->result();
			if (count($dtata) > 0){
				//$param = json_decode($r->dataset);
				$below3++;
			}
			$param = json_decode($r->dataset);
			if($param->recommend1Score*1 > 0){
				if ($param->recommend1Score > 4){
					
						$promoter = $promoter + 1;
					
				}else{
					if($param->recommend1Score == 4 || $param->recommend1Score == 3.5){
						$passive = $passive + 1;
					}else{
						$depromoter = $depromoter + 1;
					}
				}
			}
			
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
		$patientpercentage1 = round((($patientrating1/($promoter+$depromoter+$passive))*100));
		$patientpercentage2 = round((($patientrating2/($promoter+$depromoter+$passive))*100));
		$patientpercentage3 = round((($patientrating3/($promoter+$depromoter+$passive))*100));
		$patientpercentage4 = round((($patientrating4/($promoter+$depromoter+$passive))*100));
		$patientpercentage5 = round((($patientrating5/($promoter+$depromoter+$passive))*100));

		//echo '<pre>';
		//print_r($feedbacktaken);
		$dataexport = array();
		$i=0;
		$dataexport[$i]['row1'] = 'TOTAL FEEDBACKS';
		$dataexport[$i]['row2'] = count($feedbacktaken);
		$dataexport[$i]['row3'] = '';
		$dataexport[$i]['row4'] = '';
		$i++;
		
		$dataexport[$i]['row1'] = 'SATISFIED PATIENTS';
		$dataexport[$i]['row2'] = count($feedbacktaken) - $below3;
		$dataexport[$i]['row3'] = '';
		$dataexport[$i]['row4'] = '';
		$i++;
		
		
		$dataexport[$i]['row1'] = 'UNSATISFIED PATIENTS';
		$dataexport[$i]['row2'] = $below3;
		$dataexport[$i]['row3'] = '';
		$dataexport[$i]['row4'] = '';
		$i++;
		
		
		$dataexport[$i]['row1'] = 'SATISFACTION INDEX';
		$dataexport[$i]['row2'] = round((count($feedbacktaken) - $below3)/(count($feedbacktaken)) * 100).'%';
		$dataexport[$i]['row3'] = '';
		$dataexport[$i]['row4'] = '';
		$i++;
		
		$dataexport[$i]['row1'] = '';
		$dataexport[$i]['row2'] = '';
		$dataexport[$i]['row3'] = '';
		$dataexport[$i]['row4'] = '';
		$i++;
		
		$dataexport[$i]['row1'] = 'NET PROMOTER SCORE';
		$dataexport[$i]['row2'] = round(($promoter/($depromoter+$promoter+$passive))*100).'%';
		$dataexport[$i]['row3'] = '';
		$dataexport[$i]['row4'] = '';
		$i++;
		
		$dataexport[$i]['row1'] = 'NO. OF PROMOTERS';
		$dataexport[$i]['row2'] = $promoter;
		$dataexport[$i]['row3'] = '';
		$dataexport[$i]['row4'] = '';
		$i++;
		
		
		$dataexport[$i]['row1'] = 'NO. OF DETRACTORS';
		$dataexport[$i]['row2'] = $depromoter;
		$dataexport[$i]['row3'] = '';
		$dataexport[$i]['row4'] = '';
		$i++;
		
		$dataexport[$i]['row1'] = 'NO. OF PASSIVES';
		$dataexport[$i]['row2'] = $passive;
		$dataexport[$i]['row3'] = '';
		$dataexport[$i]['row4'] = '';
		$i++;
		
		$dataexport[$i]['row1'] = '';
		$dataexport[$i]['row2'] = '';
		$dataexport[$i]['row3'] = '';
		$dataexport[$i]['row4'] = '';
		$i++;
		
		
		
		$dataexport[$i]['row1'] = 'OVERALL RATING BREAKDOWN';
		$dataexport[$i]['row2'] = 'BY PERCENTAGE';
		$dataexport[$i]['row3'] = 'BY NO. OF PATIENTS';
		$dataexport[$i]['row4'] = '';
		$i++;
		
		$dataexport[$i]['row1'] = 'EXCELLENT(5)';
		$dataexport[$i]['row2'] = $patientpercentage5.'%';
		$dataexport[$i]['row3'] = $patientrating5;
		$dataexport[$i]['row4'] = '';
		$i++;
		
		$dataexport[$i]['row1'] = 'GOOD(4)';
		$dataexport[$i]['row2'] = $patientpercentage4.'%';
		$dataexport[$i]['row3'] = $patientrating4;
		$dataexport[$i]['row4'] = '';
		$i++;
		
		$dataexport[$i]['row1'] = 'AVERAGE(3)';
		$dataexport[$i]['row2'] = $patientpercentage3.'%';
		$dataexport[$i]['row3'] = $patientrating3;
		$dataexport[$i]['row4'] = '';
		$i++;
		
		$dataexport[$i]['row1'] = 'POOR(2)';
		$dataexport[$i]['row2'] = $patientpercentage2.'%';
		$dataexport[$i]['row3'] = $patientrating2;
		$dataexport[$i]['row4'] = '';
		$i++;
		
		$dataexport[$i]['row1'] = 'WORST(1)';
		$dataexport[$i]['row2'] = $patientpercentage1.'%';
		$dataexport[$i]['row3'] = $patientrating1;
		$dataexport[$i]['row4'] = '';
		$i++;
		
		$dataexport[$i]['row1'] = '';
		$dataexport[$i]['row2'] = '';
		$dataexport[$i]['row3'] = '';
		$dataexport[$i]['row4'] = '';
		$i++;
		
		$dataexport[$i]['row1'] = 'WHY PATIENTS CHOSE YOUR HOSPITAL';
		$dataexport[$i]['row2'] = '';
		$dataexport[$i]['row3'] = '';
		$dataexport[$i]['row4'] = '';
		$i++;
		
		
		$dataexport[$i]['row1'] = '';
		$dataexport[$i]['row2'] = '';
		$dataexport[$i]['row3'] = '';
		$dataexport[$i]['row4'] = '';
		$i++;
		
		$dataexport[$i]['row1'] = '';
		$dataexport[$i]['row2'] = 'By Percentage';
		$dataexport[$i]['row3'] = 'By No. of Patients';
		$dataexport[$i]['row4'] = '';
		$i++;
		
		
		
		
		$overallarray = array(
			'location' => 'Location',
			'specificservice' => 'Specific services offered',
			'referred' => 'Referred by doctors',
			'friend' => 'Friend/Family recommendation',
			'previous' => 'Previous experience',
			'docAvailability' => 'Doctors Availability',
			'companyRecommend' => 'Company Recommendation',
			'otherReason' => 'Promotional Coupons'
		);
		
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
			
			$dataexport[$i]['row1'] = $v;
			$dataexport[$i]['row2'] = round($percentage).'%';
			$dataexport[$i]['row3'] = $count;
			$dataexport[$i]['row4'] = '';
			$i++;
			
			
		}
		
		
		$dataexport[$i]['row1'] = '';
		$dataexport[$i]['row2'] = '';
		$dataexport[$i]['row3'] = '';
		$dataexport[$i]['row4'] = '';
		$i++;
		
		
		$dataexport[$i]['row1'] = '';
		$dataexport[$i]['row2'] = '';
		$dataexport[$i]['row3'] = '';
		$dataexport[$i]['row4'] = '';
		$i++;
		
		$this->db->select('ticketsop.*,bf_opatients.name as pname');
		$this->db->from('ticketsop');
		
		$this->db->join('bf_outfeedback','bf_outfeedback.id = ticketsop.feedbackid','left');
		$this->db->join('bf_opatients','bf_opatients.patient_id = bf_outfeedback.patientid','left');
		if(isset($_SESSION['ward']) && $_SESSION['ward'] != 'ALL'){
			$this->db->where('bf_opatients.ward',$_SESSION['ward']);
		}
		$this->db->where('bf_outfeedback.datet <=',$fdate);
		$this->db->where('bf_outfeedback.datet >=',$tdate );
		$this->db->order_by('datetime', 'desc');
		$query = $this->db->get();
		$ticket = $query->result();
		
		$tickets = array();
		$k = 0;
		foreach($ticket as $row){
			$this->db->where('patient_id',$row->created_by);
			$query = $this->db->get('bf_opatients');
			$patient = $query->result();
			
			$this->db->where('dprt_id',$row->departmentid);
			$query = $this->db->get('department');
			$department = $query->result();
			
			//$slug = $patient[0]->id.preg_replace('/[^A-Za-z0-9-]+/', '-', $department[0]->dprt_id);
			$tickets[$k] = $row;
			$k++;
		}
		$opent = 0;
		$closedt = 0;
		foreach($tickets as $t){
		
			if($t->status == 'Open'){
				$opent++;
			}else{
				$closedt++;
			}
			
			
		}
		
		$dataexport[$i]['row1'] = 'TICKETS REPORT';
		$dataexport[$i]['row2'] = '';
		$dataexport[$i]['row3'] = '';
		$dataexport[$i]['row4'] = '';
		$i++;
		
		$dataexport[$i]['row1'] = '';
		$dataexport[$i]['row2'] = '';
		$dataexport[$i]['row3'] = '';
		$dataexport[$i]['row4'] = '';
		$i++;
		
		$dataexport[$i]['row1'] = 'TOTAL TICKETS';
		$dataexport[$i]['row2'] = count($tickets);
		$dataexport[$i]['row3'] = '';
		$dataexport[$i]['row4'] = '';
		$i++;
		
		
		$dataexport[$i]['row1'] = 'OPEN TICKETS';
		$dataexport[$i]['row2'] = $opent;
		$dataexport[$i]['row3'] = '';
		$dataexport[$i]['row4'] = '';
		$i++;
		
		$dataexport[$i]['row1'] = 'CLOSED TICKETS';
		$dataexport[$i]['row2'] = $closedt;
		$dataexport[$i]['row3'] = '';
		$dataexport[$i]['row4'] = '';
		$i++;
		
		
		$dataexport[$i]['row1'] = '';
		$dataexport[$i]['row2'] = '';
		$dataexport[$i]['row3'] = '';
		$dataexport[$i]['row4'] = '';
		$i++;
		
		$dataexport[$i]['row1'] = 'TICKETS RECEIVED BY DEPARTMENT';
		$dataexport[$i]['row2'] = '';
		$dataexport[$i]['row3'] = '';
		$dataexport[$i]['row4'] = '';
		$i++;
		$dataexport[$i]['row1'] = '';
		$dataexport[$i]['row2'] = 'By Percentage';
		$dataexport[$i]['row3'] = 'By No. of Tickets';
		$dataexport[$i]['row4'] = '';
		$i++;
		
		$this->db->where('type','outpatient');
		$this->db->group_by('description');
		$query = $this->db->get('department');
		$result = $query->result();
		$overallarray = array();
		$tcount = 0;
		foreach($result as $ps){
			$this->db->where('type','outpatient');
			$this->db->where('description',$ps->description);
			$query = $this->db->get('department');
			$pq = $query->result();
			foreach($pq as $p){
				foreach($tickets as $rk){
					if($rk->departmentid == $p->dprt_id){
						$tcount++;
					}
				}
			}
		}
		
		
		foreach($result as $ps){
			$count = 0;
			$this->db->where('type','outpatient');
			$this->db->where('description',$ps->description);
			$query = $this->db->get('department');
			$pq = $query->result();
			foreach($pq as $p){
				foreach($tickets as $rk){
					if($rk->departmentid == $p->dprt_id){
						$count++;
					}
				
					
				}
			}
			if(count($tickets) > 0){
				$percentage = ($count/$tcount)*100;
			}else{
				$percentage = 0;
			}
			
			$dataexport[$i]['row1'] = $ps->description;
			$dataexport[$i]['row2'] = round($percentage).'%';
			$dataexport[$i]['row3'] = $count;
			$dataexport[$i]['row4'] = '';
			$i++;
			
		}
		
		ob_end_clean();
		$fileName = 'OP - OVERALL PATIENTS FEEDBACKS REPORT  - '.date('d-m-Y',strtotime($_GET['tdate'])).' to '.date('d-m-Y',strtotime($_GET['fdate'])).'.csv';
		header('Pragma: public');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Cache-Control: private', false);
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment;filename=' . $fileName);    
		if(isset($dataexport[0])){
			$fp = fopen('php://output', 'w');
			//print_r($header);
			//fputcsv($fp, $header,',');
			foreach($dataexport AS $values){
				//print_r($values); exit;
				fputcsv($fp, $values, ',');
			}
			fclose($fp);
		}
		ob_flush();
		exit;
		
		
		exit;
	}
	
	public function expormainpermoter(){
		$fdate = $_GET['fdate'];
		$tdate = $_GET['tdate'];
		$this->db->select('bf_outfeedback.*,bf_opatients.name as pname,bf_opatients.patient_id as pid');
		$this->db->from('bf_outfeedback');
		$this->db->join('bf_opatients', 'bf_opatients.patient_id = bf_outfeedback.patientid', 'inner');

		if (isset($_SESSION['ward']) && $_SESSION['ward'] != 'ALL'){
			$this->db->where('bf_opatients.ward', $_SESSION['ward']);
		}

		$fdate = date('Y-m-d', strtotime($fdate) + 3600 * 12);
		$fdatet = date('Y-m-d 23:59:59', strtotime($fdate));
		$this->db->where('bf_outfeedback.datet <=', $fdatet);
		$this->db->where('bf_outfeedback.datet >=', $tdate);
		$this->db->order_by('datetime', 'desc');
		$query = $this->db->get();
		$feedbacktaken = $query->result();
		$promoter = 0;
		$depromoter = 0;
		$i = 0;
		
		foreach($feedbacktaken as $r){
			$this->db->where('feedbackid', $r->id);
			$query = $this->db->get('ticketsop');
			$dtata = $query->result();
			if (count($dtata) > 0){
				//$param = json_decode($r->dataset);
				$below3++;
			}
			$param = json_decode($r->dataset);
			//if($param->recommend1Score*1 > 0){
				if ($param->recommend1Score <= 2){
					$promoter = $promoter + 1;
					
				}else{
					$depromoter = $depromoter + 1;
					$pdataset[$i] = $param;
				}
			//}
			$i++;
			
			
		}
		
		$dataexport = array();
		$i=0;
		$dataexport[$i]['row1'] = 'Name';
		$dataexport[$i]['row2'] = 'PatientID';
		$dataexport[$i]['row3'] = 'Mobile';
		$dataexport[$i]['row4'] = 'Email';
		$i++;
		foreach($pdataset as $row){
			//print_r($row); exit;
			$dataexport[$i]['row1'] = $row->name;
			$dataexport[$i]['row2'] = $row->patientid;
			$dataexport[$i]['row3'] = $row->contactnumber;
			$dataexport[$i]['row4'] = $row->email;
			$i++;
		}
		
		
		ob_end_clean();
		$fileName = 'OP-Promoters List Report - '.date('d-m-Y',strtotime($_GET['tdate'])).' to '.date('d-m-Y',strtotime($_GET['fdate'])).'.csv';
		header('Pragma: public');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Cache-Control: private', false);
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment;filename=' . $fileName);    
		if(isset($dataexport[0])){
			$fp = fopen('php://output', 'w');
			//print_r($header);
			//fputcsv($fp, $header,',');
			foreach($dataexport AS $values){
				//print_r($values); exit;
				fputcsv($fp, $values, ',');
			}
			fclose($fp);
		}
		ob_flush();
		exit;
		
		
		exit;
	}
	
	public function expormaindemoter(){
		$fdate = $_GET['fdate'];
		$tdate = $_GET['tdate'];
		$this->db->select('bf_outfeedback.*,bf_opatients.name as pname,bf_opatients.patient_id as pid');
		$this->db->from('bf_outfeedback');
		$this->db->join('bf_opatients', 'bf_opatients.patient_id = bf_outfeedback.patientid', 'inner');

		if (isset($_SESSION['ward']) && $_SESSION['ward'] != 'ALL'){
			$this->db->where('bf_opatients.ward', $_SESSION['ward']);
		}

		$fdate = date('Y-m-d', strtotime($fdate) + 3600 * 12);
		$fdatet = date('Y-m-d 23:59:59', strtotime($fdate));
		$this->db->where('bf_outfeedback.datet <=', $fdatet);
		$this->db->where('bf_outfeedback.datet >=', $tdate);
		$this->db->order_by('datetime', 'desc');
		$query = $this->db->get();
		$feedbacktaken = $query->result();
		$promoter = 0;
		$depromoter = 0;
		$i = 0;
		//echo '<pre>';
		
		foreach($feedbacktaken as $r){
			$this->db->where('feedbackid', $r->id);
			$query = $this->db->get('ticketsop');
			$dtata = $query->result();
			if (count($dtata) > 0){
				//$param = json_decode($r->dataset);
				$below3++;
			}
			$param = json_decode($r->dataset);
			//if($param->recommend1Score*1 > 0){
				if ($param->recommend1Score <= 2){
					$promoter = $promoter + 1;
					$pdataset[$i] = $param;
				}else{
					$depromoter = $depromoter + 1;
					
				}
			//}
			$i++;
			
		}
		//print_r($pdataset); exit;
		$dataexport = array();
		$i=0;
		$dataexport[$i]['row1'] = 'Name';
		$dataexport[$i]['row2'] = 'PatientID';
		$dataexport[$i]['row3'] = 'Mobile';
		$dataexport[$i]['row4'] = 'Email';
		$i++;
		foreach($pdataset as $row){
			$dataexport[$i]['row1'] = $row->name;
			$dataexport[$i]['row2'] = $row->patientid;
			$dataexport[$i]['row3'] = $row->contactnumber;
			$dataexport[$i]['row4'] = $row->email;
			$i++;
		}
		
		
		ob_end_clean();
		$fileName = 'OP-Demoters List REPORT - '.date('d-m-Y',strtotime($_GET['tdate'])).' to '.date('d-m-Y',strtotime($_GET['fdate'])).'.csv';
		header('Pragma: public');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Cache-Control: private', false);
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment;filename=' . $fileName);    
		if(isset($dataexport[0])){
			$fp = fopen('php://output', 'w');
			//print_r($header);
			//fputcsv($fp, $header,',');
			foreach($dataexport AS $values){
				//print_r($values); exit;
				fputcsv($fp, $values, ',');
			}
			fclose($fp);
		}
		ob_flush();
		exit;
		
		
		exit;
	}
	
	
	public function expormainbysection(){
		$fdate = $_GET['fdate'];
		$tdate = $_GET['tdate'];
		$this->db->select('bf_outfeedback.*,bf_opatients.name as pname,bf_opatients.patient_id as pid');
		$this->db->from('bf_outfeedback');
		$this->db->join('bf_opatients', 'bf_opatients.patient_id = bf_outfeedback.patientid', 'inner');

		if (isset($_SESSION['ward']) && $_SESSION['ward'] != 'ALL'){
			$this->db->where('bf_opatients.ward', $_SESSION['ward']);
		}

		$fdate = date('Y-m-d', strtotime($fdate) + 3600 * 12);
		$fdatet = date('Y-m-d 23:59:59', strtotime($fdate));
		$this->db->where('bf_outfeedback.datet <=', $fdatet);
		$this->db->where('bf_outfeedback.datet >=', $tdate);
		$this->db->order_by('datetime', 'desc');
		$query = $this->db->get();
		$feedbacktaken = $query->result();
		$promoter = 0;
		$depromoter = 0;
		$i = 0;
		$overallarray = array(
			'location' => 'Location',
			'specificservice' => 'Specific services offered',
			'referred' => 'Referred by doctors',
			'friend' => 'Friend/Family recommendation',
			'previous' => 'Previous experience',
			'docAvailability' => 'Doctors Availability',
			'companyRecommend' => 'Company Recommendation',
			'otherReason' => 'Promotional Coupons'
		);
		
		$pdataset = array();
		$i=0;
		foreach($overallarray as $key=>$row){
			foreach($feedbacktaken as $r){
				
				$paramd = json_decode($r->dataset,true);
				$param = json_decode($r->dataset);
				
				foreach($param as $k =>$value){
					if($k == $key){
						//print_r($param[$key]);
						if($paramd[$key]*1 == 1){
							$pdataset[$i] = $param;
							$pdataset[$i]->category = $row;
							$i++;	
						}
					}
				}
				
			
			}
			
		}
		
		$dataexport = array();
		$i=0;
		$dataexport[$i]['row1'] = 'Name';
		$dataexport[$i]['row2'] = 'PatientID';
		$dataexport[$i]['row3'] = 'Mobile';
		$dataexport[$i]['row4'] = 'Email';
		$dataexport[$i]['row5'] = 'Section';
		$i++;
		foreach($pdataset as $row){
			$dataexport[$i]['row1'] = $row->name;
			$dataexport[$i]['row2'] = $row->patientid;
			$dataexport[$i]['row3'] = $row->contactnumber;
			$dataexport[$i]['row4'] = $row->email;
			$dataexport[$i]['row5'] = $row->category;
			$i++;
		}
		
		
		ob_end_clean();
		$fileName = 'OP- Hospital Chose for Various Reasons - '.date('d-m-Y',strtotime($_GET['tdate'])).' to '.date('d-m-Y',strtotime($_GET['fdate'])).'.csv';
		header('Pragma: public');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Cache-Control: private', false);
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment;filename=' . $fileName);    
		if(isset($dataexport[0])){
			$fp = fopen('php://output', 'w');
			//print_r($header);
			//fputcsv($fp, $header,',');
			foreach($dataexport AS $values){
				//print_r($values); exit;
				fputcsv($fp, $values, ',');
			}
			fclose($fp);
		}
		ob_flush();
		exit;
		
		
		exit;
	}
	
	/*
	public function expormainfullop(){
		$fdate = $_GET['fdate'];
		$tdate = $_GET['tdate'];
		$this->db->select('bf_outfeedback.*,bf_opatients.name as pname,bf_opatients.patient_id as pid');
		$this->db->from('bf_outfeedback');
		$this->db->join('bf_opatients', 'bf_opatients.patient_id = bf_outfeedback.patientid', 'inner');

		if (isset($_SESSION['ward']) && $_SESSION['ward'] != 'ALL'){
			$this->db->where('bf_opatients.ward', $_SESSION['ward']);
		}

		$fdate = date('Y-m-d', strtotime($fdate) + 3600 * 12);
		$fdatet = date('Y-m-d 23:59:59', strtotime($fdate));
		$this->db->where('bf_outfeedback.datet <=', $fdatet);
		$this->db->where('bf_outfeedback.datet >=', $tdate);
		$this->db->order_by('datetime', 'desc');
		$query = $this->db->get();
		$feedbacktaken = $query->result();
		$promoter = 0;
		$depromoter = 0;
		foreach($feedbacktaken as $r){
			$this->db->where('feedbackid', $r->id);
			$query = $this->db->get('ticketsop');
			$dtata = $query->result();
			if (count($dtata) > 0){
				//$param = json_decode($r->dataset);
				$below3++;
			}
			$param = json_decode($r->dataset); 
			if($param->recommend1Score*1 > 0){
				if ($param->recommend1Score > 3){
					$promoter = $promoter + 1;
				}else{
					$depromoter = $depromoter + 1;
				}
			}
		}
		//echo '<pre>';
		//print_r($feedbacktaken);
		$dataexport = array();
		$i=0;
		$dataexport[$i]['row1'] = 'TOTAL FEEDBACKS';
		$dataexport[$i]['row2'] = count($feedbacktaken);
		$dataexport[$i]['row3'] = '';
		$dataexport[$i]['row4'] = '';
		$i++;
		
		$dataexport[$i]['row1'] = 'SATISFIED PATIENTS';
		$dataexport[$i]['row2'] = count($feedbacktaken) - $below3;
		$dataexport[$i]['row3'] = '';
		$dataexport[$i]['row4'] = '';
		$i++;
		
		
		$dataexport[$i]['row1'] = 'UNSATISFIED PATIENTS';
		$dataexport[$i]['row2'] = $below3;
		$dataexport[$i]['row3'] = '';
		$dataexport[$i]['row4'] = '';
		$i++;
		
		
		$dataexport[$i]['row1'] = 'SATISFACTION INDEX';
		$dataexport[$i]['row2'] = round((count($feedbacktaken) - $below3)/(count($feedbacktaken)) * 100).'%';
		$dataexport[$i]['row3'] = '';
		$dataexport[$i]['row4'] = '';
		$i++;
		
		$dataexport[$i]['row1'] = '';
		$dataexport[$i]['row2'] = '';
		$dataexport[$i]['row3'] = '';
		$dataexport[$i]['row4'] = '';
		$i++;
		
		$dataexport[$i]['row1'] = 'NET PROMOTER SCORE';
		$dataexport[$i]['row2'] = round(($promoter/($depromoter+$promoter))*100).'%';
		$dataexport[$i]['row3'] = '';
		$dataexport[$i]['row4'] = '';
		$i++;
		
		$dataexport[$i]['row1'] = 'NO. OF PROMOTERS';
		$dataexport[$i]['row2'] = $promoter;
		$dataexport[$i]['row3'] = '';
		$dataexport[$i]['row4'] = '';
		$i++;
		
		
		$dataexport[$i]['row1'] = 'NO. OF DEMOTERS';
		$dataexport[$i]['row2'] = $depromoter;
		$dataexport[$i]['row3'] = '';
		$dataexport[$i]['row4'] = '';
		$i++;
		
		$dataexport[$i]['row1'] = '';
		$dataexport[$i]['row2'] = '';
		$dataexport[$i]['row3'] = '';
		$dataexport[$i]['row4'] = '';
		$i++;
		
		$dataexport[$i]['row1'] = 'WHY PATIENTS CHOSE YOUR HOSPITAL';
		$dataexport[$i]['row2'] = '';
		$dataexport[$i]['row3'] = '';
		$dataexport[$i]['row4'] = '';
		$i++;
		
		
		$dataexport[$i]['row1'] = '';
		$dataexport[$i]['row2'] = '';
		$dataexport[$i]['row3'] = '';
		$dataexport[$i]['row4'] = '';
		$i++;
		
		$dataexport[$i]['row1'] = '';
		$dataexport[$i]['row2'] = 'By Percentage';
		$dataexport[$i]['row3'] = 'By No. of Patients';
		$dataexport[$i]['row4'] = '';
		$i++;
		
		
		
		
		$overallarray = array(
			'location' => 'Location',
			'specificservice' => 'Specific services offered',
			'referred' => 'Referred by doctors',
			'friend' => 'Friend/Family recommendation',
			'previous' => 'Previous experience',
			'docAvailability' => 'Doctors Availability',
			'companyRecommend' => 'Company Recommendation',
			'otherReason' => 'Promotional Coupons'
		);
		
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
			
			$dataexport[$i]['row1'] = $v;
			$dataexport[$i]['row2'] = round($percentage).'%';
			$dataexport[$i]['row3'] = $count;
			$dataexport[$i]['row4'] = '';
			$i++;
			
			
		}
		
		$dataexport[$i]['row1'] = '';
		$dataexport[$i]['row2'] = '';
		$dataexport[$i]['row3'] = '';
		$dataexport[$i]['row4'] = '';
		$i++;
		
		
		$dataexport[$i]['row1'] = '';
		$dataexport[$i]['row2'] = '';
		$dataexport[$i]['row3'] = '';
		$dataexport[$i]['row4'] = '';
		$i++;
		
		$this->db->select('ticketsop.*,bf_opatients.name as pname');
		$this->db->from('ticketsop');
		
		$this->db->join('bf_outfeedback','bf_outfeedback.id = ticketsop.feedbackid','left');
		$this->db->join('bf_opatients','bf_opatients.patient_id = bf_outfeedback.patientid','left');
		if(isset($_SESSION['ward']) && $_SESSION['ward'] != 'ALL'){
			$this->db->where('bf_opatients.ward',$_SESSION['ward']);
		}
		$this->db->where('bf_outfeedback.datet <=',$fdate);
		$this->db->where('bf_outfeedback.datet >=',$tdate );
		$this->db->order_by('datetime', 'desc');
		$query = $this->db->get();
		$ticket = $query->result();
		
		$tickets = array();
		$i = 0;
		foreach($ticket as $row){
			$this->db->where('patient_id',$row->created_by);
			$query = $this->db->get('bf_opatients');
			$patient = $query->result();
			
			$this->db->where('dprt_id',$row->departmentid);
			$query = $this->db->get('department');
			$department = $query->result();
			
			//$slug = $patient[0]->id.preg_replace('/[^A-Za-z0-9-]+/', '-', $department[0]->dprt_id);
			$tickets[$i] = $row;
			$i++;
		}
		$opent = 0;
		$closedt = 0;
		foreach($tickets as $t){
		
			if($t->status == 'Open'){
				$opent++;
			}else{
				$closedt++;
			}
			
			
		}
		
		$dataexport[$i]['row1'] = 'TICKETS REPORT';
		$dataexport[$i]['row2'] = '';
		$dataexport[$i]['row3'] = '';
		$dataexport[$i]['row4'] = '';
		$i++;
		
		$dataexport[$i]['row1'] = '';
		$dataexport[$i]['row2'] = '';
		$dataexport[$i]['row3'] = '';
		$dataexport[$i]['row4'] = '';
		$i++;
		
		$dataexport[$i]['row1'] = 'TOTAL TICKETS';
		$dataexport[$i]['row2'] = count($tickets);
		$dataexport[$i]['row3'] = '';
		$dataexport[$i]['row4'] = '';
		$i++;
		
		
		$dataexport[$i]['row1'] = 'OPEN TICKETS';
		$dataexport[$i]['row2'] = $opent;
		$dataexport[$i]['row3'] = '';
		$dataexport[$i]['row4'] = '';
		$i++;
		
		$dataexport[$i]['row1'] = 'CLOSED TICKETS';
		$dataexport[$i]['row2'] = $closedt;
		$dataexport[$i]['row3'] = '';
		$dataexport[$i]['row4'] = '';
		$i++;
		
		
		$dataexport[$i]['row1'] = '';
		$dataexport[$i]['row2'] = '';
		$dataexport[$i]['row3'] = '';
		$dataexport[$i]['row4'] = '';
		$i++;
		
		$dataexport[$i]['row1'] = 'TICKETS RECEIVED BY DEPARTMENT';
		$dataexport[$i]['row2'] = '';
		$dataexport[$i]['row3'] = '';
		$dataexport[$i]['row4'] = '';
		$i++;
		$dataexport[$i]['row1'] = '';
		$dataexport[$i]['row2'] = 'By Percentage';
		$dataexport[$i]['row3'] = 'By No. of Tickets';
		$dataexport[$i]['row4'] = '';
		$i++;
		
		$this->db->where('type','outpatient');
		$this->db->group_by('description');
		$query = $this->db->get('department');
		$result = $query->result();
		$overallarray = array();
		$tcount = 0;
		foreach($result as $ps){
			$this->db->where('type','outpatient');
			$this->db->where('description',$ps->description);
			$query = $this->db->get('department');
			$pq = $query->result();
			foreach($pq as $p){
				foreach($tickets as $rk){
					if($rk->departmentid == $p->dprt_id){
						$tcount++;
					}
				}
			}
		}
		
		
		foreach($result as $ps){
			$count = 0;
			$this->db->where('type','outpatient');
			$this->db->where('description',$ps->description);
			$query = $this->db->get('department');
			$pq = $query->result();
			foreach($pq as $p){
				foreach($tickets as $rk){
					if($rk->departmentid == $p->dprt_id){
						$count++;
					}
				
					
				}
			}
			if(count($tickets) > 0){
				$percentage = ($count/$tcount)*100;
			}else{
				$percentage = 0;
			}
			
			$dataexport[$i]['row1'] = $ps->description;
			$dataexport[$i]['row2'] = round($percentage).'%';
			$dataexport[$i]['row3'] = $count;
			$dataexport[$i]['row4'] = '';
			$i++;
			
		}
		
		ob_end_clean();
		$fileName = 'OP-OVERALL FEEDBACKS REPORT - '.date('d-m-Y',strtotime($_GET['tdate'])).' to '.date('d-m-Y',strtotime($_GET['fdate'])).'.csv';
		header('Pragma: public');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Cache-Control: private', false);
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment;filename=' . $fileName);    
		if(isset($dataexport[0])){
			$fp = fopen('php://output', 'w');
			//print_r($header);
			//fputcsv($fp, $header,',');
			foreach($dataexport AS $values){
				//print_r($values); exit;
				fputcsv($fp, $values, ',');
			}
			fclose($fp);
		}
		ob_flush();
		exit;
		
		
		exit;
	} */
}