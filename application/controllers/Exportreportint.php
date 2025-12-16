<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Exportreportint extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();


		if ($this->session->userdata('isLogIn') == false)
			redirect('login');
	}


	public function expormainint()
	{
		$fdate = $_GET['fdate'];
		$tdate = $_GET['tdate'];
		$fdate = date('Y-m-d', strtotime($fdate));
		$fdatet = date('Y-m-d 23:59:59', strtotime($fdate));
		// $fdate = $_GET['fdate'];
		// $tdate = $_GET['tdate'];
		// $this->db->select('bf_feedback_int.*,bf_patients.name as pname,bf_patients.patient_id as pid');
		// $this->db->from('bf_feedback_int');
		// $this->db->join('bf_patients', 'bf_patients.patient_id = bf_feedback_int.pid', 'inner');

		// if (isset($_SESSION['ward']) && $_SESSION['ward'] != 'ALL'){
		// 	$this->db->where('bf_feedback_int.ward', $_SESSION['ward']);
		// }

		// $fdate = date('Y-m-d', strtotime($fdate) + 3600 * 12);
		// $fdatet = date('Y-m-d 23:59:59', strtotime($fdate));
		// $this->db->where('bf_feedback_int.datet <=', $fdatet);
		// $this->db->where('bf_feedback_int.datet >=', $tdate);
		// $this->db->order_by('datetime', 'desc');
		// $query = $this->db->get();


		$feedbacktaken = $this->efeedor_model->get_feedback('bf_patients', 'bf_feedback_int', $fdatet, $tdate);
		// $feedbacktaken = $query->result();
		//print_r($feedbacktaken);
		//exit;

		$this->db->order_by('id');
		$query = $this->db->get('setup_int');
		$sresult = $query->result();
		$setarray = array();
		$questioarray = array();

		foreach ($sresult as $r) {
			$setarray[$r->type] = $r->title;
		}




		foreach ($sresult as $r) {
			$questioarray[$r->type][$r->shortkey] = $r->shortname;
		}

		$arraydata = array();

		foreach ($questioarray as $setr) {
			foreach ($setr as $k => $v) {
				$arraydata[$k] = $v;
			}
		}






		$header[0] = 'Date';
		$header[1] = 'Patient Name';
		$header[2] = 'Patient ID';
		//		$header[3] = 'Mobile Number';
		//	$header[4] = 'Email id';
		$j = 5;
		foreach ($arraydata as $k => $r) {
			$header[$j] = $r;
			$j++;
		}

		//$header[$j++] = 'Overall Rating';

		//	$header[$j++] = 'Staff Name';

		$header[$j++] = 'General Comment';

		foreach ($setarray as $r) {

			$header[$j] = $r;

			$j++;
		}
		$dataexport = array();
		$i = 0;
		foreach ($feedbacktaken as $row) {
			$data = json_decode($row->dataset, true);
			$dataexport[$i]['date'] = date('d-m-Y', strtotime($row->datetime));
			$dataexport[$i]['name'] = $data['name'];
			$dataexport[$i]['patient_id'] = $data['patientid'];
			//	$dataexport[$i]['mobile'] = $data['contactnumber'];
			//	$dataexport[$i]['email'] = $data['email'];
			foreach ($arraydata as $k => $r) {
				$dataexport[$i][$k] = $data[$k];
			}
			//$dataexport[$i]['overallScore'] = $data['overallScore'];

			//$dataexport[$i]['staffname'] = $data['staffname'];

			$dataexport[$i]['suggestionText'] = $data['suggestionText'];
			foreach ($setarray as $key => $t) {

				if ($data['comment'][$key] != '') {

					$dataexport[$i][$key] = $data['comment'][$key];
				} else {

					$dataexport[$i][$key] = '';
				}
			}
			$i++;
		}



		ob_end_clean();
		$fileName = 'PATIENT COMPLAINTS REPORT - ' . date('d-m-Y', strtotime($_GET['tdate'])) . ' to ' . date('d-m-Y', strtotime($_GET['fdate'])) . '.csv';
		header('Pragma: public');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Cache-Control: private', false);
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment;filename=' . $fileName);
		if (isset($dataexport[0])) {
			$fp = fopen('php://output', 'w');
			//print_r($header);
			fputcsv($fp, $header, ',');
			foreach ($dataexport as $values) {
				//print_r($values); exit;
				fputcsv($fp, $values, ',');
			}
			fclose($fp);
		}
		ob_flush();
		exit;
	}
}
