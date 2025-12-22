<?php defined('BASEPATH') or exit('No direct script access allowed');



class Incident_model extends CI_Model
{

	public function comm($table_patient, $table_feedback, $sorttime, $setup)
	{
		$fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
		$tdate = date('Y-m-d', strtotime($_SESSION['to_date']));

		$this->db->select($table_feedback . '.*');
		$this->db->from($table_feedback);
		$this->db->join($table_patient, $table_patient . '.id = ' . $table_feedback . '.pid', 'inner');

		if (isset($_SESSION['ward']) && $_SESSION['ward'] != 'ALL') {
			$this->db->where($table_feedback . '.ward', $_SESSION['ward']);
		}

		$this->db->where($table_feedback . '.datet <=', $fdate);
		$this->db->where($table_feedback . '.datet >=', $tdate);
		$this->db->order_by('datetime', $sorttime);

		$query = $this->db->get();
		$feedback = $query->result();

		$chosenSet = $this->input->get('set');
		$results = [];  // An array to store the results


		$this->db->select($setup . '.*');
		$this->db->where($setup . '.type', $chosenSet);
		$query = $this->db->get($setup);
		$sresult = $query->result();
		if ($chosenSet) {
			foreach ($sresult as $r) {
				$setarray[$r->type] = $r->title;
				$questionarray[$r->shortkey] = $r->shortkey;
				$shortname[$r->shortkey] = $r->shortname;
			}
		}
		// }


		foreach ($feedback as $row) {
			$param = json_decode($row->dataset, true);

			if (isset($chosenSet) && isset($param['comment'][$chosenSet])) {
				// $commentData[$chosenSet] = $param['comment'][$chosenSet];
				$commentData['feedbackid'] = $row->id;
				$commentData['datetime'] = $param['datetime'];
				$commentData['name'] = $param['name'];
				$commentData['patientid'] = $param['patientid'];
				$commentData['contactnumber'] = $param['contactnumber'];
				$commentData['avg_rating'] = $param['overallScore'];
				$commentData['nps_score'] = $param['recommend1Score'];
				$commentData['ovr_com'] = $param['suggestionText'];
				foreach ($setarray as $key => $t) {
					if ($param['comment'][$key]) {
						$commentData['comment'] = $param['comment'][$key];
						// $dataexport[$i]['reason'] = $data;
					}
				}
				foreach ($questionarray as $key => $t3) {
					if ($param['reason'][$key]) {
						$commentData['reason'][] = $shortname[$key];
					}
				}
				// $commentData['name'] = $param['name'];
				$results[] = $commentData;
			} elseif (!isset($chosenSet)) {
				$commentData['feedbackid'] = $row->id;

				$commentData['datetime'] = $param['datetime'];
				$commentData['name'] = $param['name'];
				$commentData['patientid'] = $param['patientid'];
				$commentData['contactnumber'] = $param['contactnumber'];
				$commentData['avg_rating'] = $param['overallScore'];
				$commentData['nps_score'] = $param['recommend1Score'] * 2;
				$commentData['ovr_com'] = $param['suggestionText'];
				$results[] = $commentData;
			} else {
				continue; // Skip this iteration if the set is chosen but the comment doesn't exist for it
			}



			// $results[] = $commentData;
		}
		// print_r($results);
		return $results;
	}


	public function commentwords($table_patient, $table_feedback, $sorttime)
	{
		$fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
		$tdate = date('Y-m-d', strtotime($_SESSION['to_date']));

		$this->db->select($table_feedback . '.*');
		$this->db->from($table_feedback);
		$this->db->join($table_patient, $table_patient . '.id = ' . $table_feedback . '.pid', 'inner');
		if (isset($_SESSION['ward']) && $_SESSION['ward'] != 'ALL') {
			$this->db->where($table_feedback . '.ward', $_SESSION['ward']);
		}
		$this->db->where($table_feedback . '.datet <=', $fdate);
		$this->db->where($table_feedback . '.datet >=', $tdate);
		$this->db->order_by('datetime', $sorttime);

		$query = $this->db->get();
		$feedback = $query->result();

		$chosenSet = $this->input->get('set'); // Get the chosen set from the dropdown

		$allUniqueWords = [];

		//... [Your stopwords initialization code here, I'm skipping this for brevity] ...
		$conjunctions = [
			"and", "but", "or", "nor", "for", "so", "yet",
			"although", "because", "since", "unless", "while",
			"either...or", "neither...nor"
		];

		$prepositions = [
			"about", "above", "across", "after", "against", "along", "among",
			"around", "at", "before", "behind", "below", "beneath", "beside",
			"between", "beyond", "by", "down", "during", "for", "from", "in",
			"inside", "into", "near", "of", "off", "on", "onto", "out",
			"outside", "over", "through", "to", "under", "up", "with", "without"
		];

		$interjections = [
			"ah!", "aha!", "alas!", "ouch!", "hey!", "wow!", "oh!", "oops!",
			"yikes!", "hmm...", "shh!"
		];

		$pronouns = [
			"I", "you", "he", "she", "it", "we", "they", "mine", "yours",
			"his", "hers", "ours", "theirs", "myself", "yourself", "himself",
			"herself", "itself", "ourselves", "yourselves", "themselves", "who",
			"whom", "whose", "which", "that", "this", "that", "these", "those",
			"who", "whom", "whose", "which", "what", "anybody", "anyone",
			"something", "nothing", "everything", "all", "both", "few", "many",
			"neither", "several", "some", "such"
		];

		$fillerWords = [
			"um", "uh", "you know", "like", "basically", "actually",
			"seriously", "literally", "just", "really"
		];

		$articles = [
			"the", "a", "an"
		];

		$others = [
			"a", "about", "above", "after", "again", "against", "all", "am", "an", "and", "any", "are",
			"as", "at", "be", "because", "been", "before", "being", "below", "between", "both", "but",
			"by", "can't", "cannot", "could", "did", "do", "does", "doing", "don't", "down", "during",
			"each", "few", "for", "from", "further", "had", "has", "have", "having", "he", "he'd", "he'll",
			"he's", "her", "here", "here's", "hers", "herself", "him", "himself", "his", "how", "how's", "i",
			"i'd", "i'll", "i'm", "i've", "if", "in", "into", "is", "it", "it's", "its", "itself", "let's", "me",
			"more", "most", "my", "myself", "nor", "of", "on", "once", "only", "or", "other", "ought", "our",
			"ours", "ourselves", "out", "over", "own", "same", "she", "she'd", "she'll", "she's", "should", "so",
			"some", "such", "than", "that", "that's", "the", "their", "theirs", "them", "themselves", "then",
			"there", "there's", "these", "they", "they'd", "they'll", "they're", "they've", "this", "those",
			"through", "to", "too", "under", "until", "up", "very", "was", "we", "we'd", "we'll", "we're",
			"we've", "were", "what", "what's", "when", "when's", "where", "where's", "which", "while", "who",
			"who's", "whom", "why", "why's", "with", "would", "you", "you'd", "you'll", "you're", "you've",
			"your", "yours", "yourself", "yourselves", "not", "can", "1", "2", "3", "4", "5", "6", "7", "8", "9", "0", " "
		];

		$stopwords = array_merge($conjunctions, $prepositions, $interjections, $pronouns, $fillerWords, $articles, $others);

		// print_r($stopwords);
		// If you want the stopwords in lowercase for case-insensitive matching:
		$stopwords = array_map('strtolower', $stopwords);

		foreach ($feedback as $row) {
			$param = json_decode($row->dataset, true);

			if (isset($chosenSet) && isset($param['comment'][$chosenSet])) {
				$words = array_map('strtolower', preg_split('/\s+/', $param['comment'][$chosenSet]));
			} elseif (!isset($chosenSet)) {
				$words = $param['suggestionText'] ? array_map('strtolower', preg_split('/\s+/', $param['suggestionText'])) : [];
			} else {
				continue; // Skip this iteration if the set is chosen but the comment doesn't exist for it
			}

			foreach ($words as $word) {
				$word = strtolower(trim($word, ",.!?|/"));

				if (!in_array($word, $stopwords)) {
					if (isset($allUniqueWords[$word])) {
						$allUniqueWords[$word]++;
					} else {
						$allUniqueWords[$word] = 1;
					}
				}
			}
		}


		$wordCounts = [];
		foreach ($allUniqueWords as $word => $count) {
			if ($count > 3) {
				$wordCounts[] = [$word, $count];
			}
		}
		usort($wordCounts, function ($a, $b) {
			return $b[1] - $a[1];
		});

		return $wordCounts;
	}



//keep
	public function key_highlights2($table_patients, $table_feedback, $sorttime, $setup)
	{
		$question_list_parent = $this->setup_result($setup);
		$question_list_reasons = $this->setup_sub_result($setup);
		$feedback_data = $this->patient_and_feedback($table_patients, $table_feedback, $sorttime, $setup);
		$i = 0;
		$z = 0;
		$set = array();
		$set1 = array();


		foreach ($question_list_parent as $row) {
			$set[$i]['parent_param'] = $row->shortname;
			$set[$i]['parent_percentage'] = $this->get_total_feedback_rating_percentage($row->shortkey, $feedback_data);
			// $set[$i]['parent_count'] = $this->get_total_feedback_rating_count($row->shortkey, $feedback_data);
			$set[$i]['shortkey'] =  $row->shortkey;
			$res['parent'] = $set;
			$i++;
		}

		foreach ($question_list_reasons as $row2) {
			$set1[$z]['sub_param'] = $row2->shortname;
			$set1[$z]['sub_count'] = $this->get_feedback_for_reason($row2->shortkey, $feedback_data);
			$set1[$z]['shortkey'] =  $row2->shortkey;
			$res['sub'] = $set1;
			$z++;
		}

		return $res;

		print_r($res);
	}
//keep
	private function get_total_feedback_rating_percentage($key, $feedback)
	{
		$total = 0;
		$total_incidence = 0;
		foreach ($feedback as $row) {
			$dataset = json_decode($row->dataset, true);

			if (isset($dataset[$key]) && $dataset[$key] > 0) {
				$total_incidence++;
				$total = $total + $dataset[$key];
			}
		}
		if ($total_incidence > 0) {
			$percentage = round(($total / ($total_incidence * 5)) * 100);
		} else {
			$percentage = 0;
		}
		return $percentage;
	}

//keep
	private function get_feedback_for_reason($key, $feedback)
	{
		$total = 0;
		$total_incidence = 0;

		foreach ($feedback as $row) {
			$dataset = json_decode($row->dataset, true);
			if (isset($dataset['reason']) && is_array($dataset['reason'])) {
				if (isset($dataset['reason'][$key]) && $dataset['reason'][$key] > 0) {
					$total_incidence++;
					$total = $total + $dataset['reason'][$key];
				}
			}
		}
		return $total;
	}

//keep
	public function ticket_rate($table_tickets, $status, $table_feedback, $table_ticket_action)
	{
		$fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
		$tdate = date('Y-m-d', strtotime($_SESSION['to_date']));


		$get_tickes = $this->get_tickets($table_feedback, $table_tickets);
		$closed_tickets = 0;
		$time = 0;
		$this->db->select('*');
		$this->db->from($table_ticket_action);
		$query = $this->db->get();
		$alltickets = $query->result();

		foreach ($get_tickes as $row) {
			foreach ($alltickets as $t) {
				if ($t->ticketid == $row->id && $row->status == 'Closed') {
					// print_r($t);
					$closed_tickets++;
					$time += strtotime($t->created_on) - strtotime($row->created_on);
				}
			}
		}
		if ($closed_tickets > 0 && $time > 0) {
			$seconds = $time / $closed_tickets;
		} else {
			$seconds = 0;
		}
		return $seconds;
	}

	
//keep
	public function ticket_resolution_rate($table_tickets, $status, $table_feedback)
	{
		$fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
		$tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
		$this->db->select('*');
		$this->db->from($table_tickets);
		$this->db->join($table_feedback, $table_feedback . '.id=' . $table_tickets . '.feedbackid');
		if (isset($_SESSION['ward']) && $_SESSION['ward'] != 'ALL') {
			$this->db->where($table_feedback . '.ward', $_SESSION['ward']);
		}
		$this->db->where($table_tickets . '.created_on <=', $fdate . ' 23:59:59');
		$this->db->where($table_tickets . '.created_on >=', $tdate);
		$query = $this->db->get();
		$alltickets = $query->result();
		$tickets = 0;
		foreach ($alltickets as $t) {
			if ($t->status == $status) {
				$tickets++;
			}
		}
		if ($tickets > 0 && count($alltickets) > 0) {
			$countofclosed = round(($tickets / count($alltickets)) * 100);
			return $countofclosed;
		} else {
			return 0;
		}
	}

//keep
	public function setup_result($table)
	{
		$this->db->order_by('sort_order');
		$this->db->where('parent', 1);
		$query = $this->db->get($table);
		return $result = $query->result();
	}


//keep
	public function setup_sub_result($table)
	{
		$this->db->order_by('id');
		$this->db->where('parent', 0);
		$query = $this->db->get($table);
		return $result = $query->result();
	}


	public function tickets_recived_by_department($type, $table_feedback, $table_tickets)
	{
		$department = $this->get_department($type);
		$get_tickes = $this->get_tickets($table_feedback, $table_tickets);
		$set = array();
		$i = 0;
		foreach ($department as $key => $row) {
			// exit;
			if (count($get_tickes) >= 1) {

				$data =  $this->get_toal_ticket_by_department($row->dprt_id, $get_tickes);
				$percentage  = $data['percentage'];
				$total_count  = $data['total_count'];
				$total_count = $data['total_count'];
				$open_tickets = $data['open_tickets'];
				$closed_tickets = $data['closed_tickets'];
				$addressed_tickets = $data['addressed_tickets'];
				$res_time = $data['res_time'];
				$tr_rate = $data['tr_rate'];
				$set[$i]['department'] = $row->description;
				$set[$i]['percentage'] = $percentage;
				$set[$i]['count'] = $total_count;
				$set[$i]['closed_tickets'] = $closed_tickets;
				$set[$i]['open_tickets'] = $open_tickets;
				$set[$i]['addressed_tickets'] = $addressed_tickets;
				$set[$i]['tr_rate'] = $tr_rate;
				$set[$i]['res_time'] = $res_time;
				$i++;
			}
		}
		return $set;
	}

	//keep
	public function get_toal_ticket_by_department($key, $tickes)
	{
		$total = 0;
		$total_percentage = 0;
		$open_tickets = 0;
		$closed_tickets = 0;
		$addressed_tickets = 0;
		$time = 0;
		foreach ($tickes as $row) {
			if ($row->departmentid == $key) {
				$total++;
			}
		}
		foreach ($tickes as $row) {
			if ($row->departmentid == $key && $row->status == 'Open') {
				$open_tickets++;
			} elseif ($row->departmentid == $key && $row->status == 'Addressed') {
				$addressed_tickets++;
			} elseif ($row->departmentid == $key && $row->status == 'Closed') {
				$closed_tickets++;
				$time += strtotime($row->last_modified) - strtotime($row->created_on);
			}
		}
		if ($total > 0 && count($tickes) > 0) {
			$total_percentage = round(($total / count($tickes)) * 100);
		}
		if ($closed_tickets > 0 && count($tickes) > 0) {
			$tr_rate = round(($closed_tickets / count($tickes)) * 100);
			$seconds = $time / $closed_tickets;
		} else {
			$tr_rate = 0;
			$seconds = 0;
		}



		$data = array();
		$data['percentage'] = $total_percentage;
		$data['total_count'] = $total;
		$data['open_tickets'] = $open_tickets;
		$data['closed_tickets'] = $closed_tickets;
		$data['addressed_tickets'] = $addressed_tickets;
		$data['tr_rate'] = $tr_rate;
		$data['res_time'] = $seconds;
		return $data;
	}


	public function get_department($type)
	{
		$this->db->where('type', $type);
		$this->db->group_by('setkey');
		$query = $this->db->get('department');
		return $department = $query->result();
	}

	public function get_departmentint($type)
	{
		$this->db->where('type', $type);
		$query = $this->db->get('department');
		return $department = $query->result();
	}

	public function check_demo($settings)
	{
		$this->db->select($settings . '.*');
		$this->db->from($settings);
		$query = $this->db->get();
		$response  = $query->result();
		return $response;
	}

	public function get_satisfied_count($table_feedback, $table_tickets)
	{
		$fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
		$tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
		$this->db->select($table_feedback . '.*');
		$this->db->from($table_feedback);
		$this->db->where($table_feedback . '.datet <=', $fdate);
		$this->db->where($table_feedback . '.datet >=', $tdate);
		if (isset($_SESSION['ward']) && $_SESSION['ward'] != 'ALL') {
			$this->db->where($table_feedback . '.ward', $_SESSION['ward']);
		}
		$query = $this->db->get();
		$all_feedback = $query->result();
		$this->db->select($table_tickets . ".*");
		$this->db->from($table_tickets);
		$this->db->where($table_tickets . '.created_on <=', $fdate . ' 23:59:59');
		$this->db->where($table_tickets . '.created_on >=', $tdate);
		$query = $this->db->get();
		$all_tickets = $query->result();
		$satisfied = 0;
		foreach ($all_feedback as $row) {
			$check = true;
			foreach ($all_tickets as $t) {
				if ($row->id == $t->feedbackid && $check == true) {
					$satisfied = $satisfied - 1;
				}
			}
			if ($check == true) {
				$satisfied = $satisfied + 1;
				$check = false;
			}
		}
		return $satisfied;
	}



	public function get_unsatisfied_count($table_feedback, $table_tickets)
	{
		$fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
		$tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
		$this->db->select($table_feedback . '.*');
		$this->db->from($table_feedback);
		$this->db->where($table_feedback . '.datet <=', $fdate);
		$this->db->where($table_feedback . '.datet >=', $tdate);
		if (isset($_SESSION['ward']) && $_SESSION['ward'] != 'ALL') {
			$this->db->where($table_feedback . '.ward', $_SESSION['ward']);
		}
		$this->db->join($table_tickets, $table_tickets . '.feedbackid = ' . $table_feedback . '.id');
		$query = $this->db->get();
		$all_feedback = $query->result();
		$unsatisfied = 0;
		foreach ($all_feedback as $row) {
			if ($row) {
				$unsatisfied = $unsatisfied + 1;
			}
		}
		return $unsatisfied;
	}
//keep
	function convertSecondsToTime($inputSeconds)
	{
		$isNegative = $inputSeconds < 0 ? true : false;

		// Always work with positive values for calculations
		$inputSeconds = abs($inputSeconds);

		$days = floor($inputSeconds / 86400);
		$inputSeconds %= 86400;

		$hours = floor($inputSeconds / 3600);
		$inputSeconds %= 3600;

		$minutes = floor($inputSeconds / 60);
		$inputSeconds %= 60;

		$seconds = $inputSeconds;

		return array(
			'isNegative' => $isNegative,
			'days' => $days,
			'hours' => $hours,
			'minutes' => $minutes,
			'seconds' => $seconds
		);
	}


//keep
	public function tickets_feeds($table_feedback, $table_tickets, $sorttime, $status)
	{
		$fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
		$tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
		$this->db->select($table_feedback . ".*");
		$this->db->from($table_feedback);
		$this->db->join($table_tickets, $table_tickets . '.feedbackid = ' . $table_feedback . '.id');
		if (isset($_SESSION['ward']) && $_SESSION['ward'] != 'ALL') {
			$this->db->where($table_feedback . '.ward', $_SESSION['ward']);
		}
		$this->db->where($table_tickets . '.status=', $status);
		$this->db->where($table_feedback . '.datet <=', $fdate);
		$this->db->where($table_feedback . '.datet >=', $tdate);
		$this->db->order_by('datetime', $sorttime);
		$query = $this->db->get();
		return $feedbackandticket = $query->result();
	}


//keep
	public function patient_and_feedback($table_patient, $table_feedback, $sorttime)
	{
		$fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
		$tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
		$this->db->select($table_feedback . '.*');
		$this->db->from($table_feedback);
		$this->db->join($table_patient, $table_patient . '.id = ' . $table_feedback . '.pid', 'inner');
		if (isset($_SESSION['ward']) && $_SESSION['ward'] != 'ALL') {
			$this->db->where($table_feedback . '.ward', $_SESSION['ward']);
		}
		$this->db->where($table_feedback . '.datet <=', $fdate);
		$this->db->where($table_feedback . '.datet >=', $tdate);
		$this->db->order_by('datetime', $sorttime);
		$query = $this->db->get();
		return $patientandfeedback  = $query->result();
	}

//keep	
	public function feedback_and_ticket($table_feedback, $table_tickets, $sorttime)
	{
		$fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
		$tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
		$this->db->select($table_feedback . ".*");
		$this->db->from($table_feedback);
		$this->db->join($table_tickets, $table_tickets . '.feedbackid = ' . $table_feedback . '.id');
		if (isset($_SESSION['ward']) && $_SESSION['ward'] != 'ALL') {
			$this->db->where($table_feedback . '.ward', $_SESSION['ward']);
		}
		$this->db->where($table_feedback . '.datet <=', $fdate);
		$this->db->where($table_feedback . '.datet >=', $tdate);
		$this->db->order_by('datetime', $sorttime);
		$query = $this->db->get();
		return $feedbackandticket = $query->result();
	}

	//keep
	public function get_tickets($table_feedback, $table_tickets)
	{
		$fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
		$tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
		$this->db->select($table_tickets . ".*");
		$this->db->from($table_feedback);
		$this->db->join($table_tickets, $table_tickets . '.feedbackid = ' . $table_feedback . '.id');
		if (isset($_SESSION['ward']) && $_SESSION['ward'] != 'ALL') {
			$this->db->where($table_feedback . '.ward', $_SESSION['ward']);
		}elseif (count($this->session->userdata['floor_ward']) > 0) {
			$floorwiseArray = $this->session->userdata['floor_ward'];
			$this->db->where_in($table_feedback . '.ward', $floorwiseArray);
		}
		$this->db->where($table_feedback . '.datet <=', $fdate);
		$this->db->where($table_feedback . '.datet >=', $tdate);
		$query = $this->db->get();
		return 	$feedbackandticket = $query->result();
	}


	public function get_tickets2($table_feedback, $table_tickets)
	{
		$fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
		$tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
		$this->db->select($table_feedback . ".*");
		$this->db->from($table_tickets);
		$this->db->join($table_tickets, $table_tickets . '.feedbackid = ' . $table_feedback . '.id');
		if (isset($_SESSION['ward']) && $_SESSION['ward'] != 'ALL') {
			$this->db->where($table_feedback . '.ward', $_SESSION['ward']);
		}
		$this->db->where($table_feedback . '.datet <=', $fdate);
		$this->db->where($table_feedback . '.datet >=', $tdate);
		$query = $this->db->get();
		return 		$tickets23 = $query->result();
	}

	public function nps_analytics($table_feedback, $sorttime)
	{
		$fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
		$tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
		$this->db->select($table_feedback . '.*');
		$this->db->from($table_feedback);
		if (isset($_SESSION['ward']) && $_SESSION['ward'] != 'ALL') {
			$this->db->where($table_feedback . '.ward', $_SESSION['ward']);
		}
		$this->db->where($table_feedback . '.datet <=', $fdate);
		$this->db->where($table_feedback . '.datet >=', $tdate);
		$this->db->order_by('datetime', $sorttime);
		$query = $this->db->get();
		$nps_analytics = $query->result();


		$promoters_count = 0;
		$detractors_count = 0;
		$passives_count = 0;

		$promoters_feedback = array();
		$detractors_feedback = array();
		$passives_feedback = array();

		foreach ($nps_analytics as $row) {
			$param = json_decode($row->dataset);
			$rating = $param->recommend1Score * 2;
			if ($rating >= 9) {
				$promoters_count++;
				$promoters_feedback[$row->id] = $param;
			} elseif ($rating <= 6) {
				$detractors_count++;
				$detractors_feedback[$row->id] = $param;
			} else {
				$passives_count++;
				$passives_feedback[$row->id] = $param;
			}
		}

		$nps_score = count($nps_analytics) > 0 ? round((($promoters_count - $detractors_count) / count($nps_analytics)) * 100) : 0;

		$targetNPS = 0.85;
		$totalResponses = count($nps_analytics);
		$x = (($targetNPS * $totalResponses) + (100 * $detractors_count) - (100 * $promoters_count)) / (100 - $targetNPS);
		$neededPromoters = ceil($x) + $promoters_count;


		$nps = array();
		$nps['nps_score'] = $nps_score;
		$nps['promoters_count'] = $promoters_count;
		$nps['promoters_feedbacks'] = $promoters_feedback;
		$nps['detractors_count'] = $detractors_count;
		$nps['detractors_feedback'] = $detractors_feedback;
		$nps['passives_count'] = $passives_count;
		$nps['passives_feedback'] = $passives_feedback;
		$nps['to_reach_benchmark'] = 	$neededPromoters;
		// echo $neededPromoters;
		return $nps;
	}



	public function psat_analytics($table_patients, $table_feedback, $table_tickets, $sorttime)
	{
		$all_tickets = $this->get_tickets($table_feedback, $table_tickets);
		$feedback_data = $this->patient_and_feedback($table_patients, $table_feedback, $sorttime);
		$satisfied_count = 0;
		$unsatisfied_count = 0;
		$neutral_count = 0;

		foreach ($feedback_data as $row) {
			$param = json_decode($row->dataset);
			$nps_score = ($param->recommend1Score * 2);
			$ticket_data = array();
			foreach ($all_tickets as $t) {
				if ($t->feedbackid == $row->id) {
					$ticket_data[] = $t;
				}
			}
			if (count($ticket_data) == 0 && $nps_score > 6) {
				$satisfied_count++;
				$satisfied_feedback[$row->id] = $param;
			} else {
				$unsatisfied_count++;
				$unsatisfied_feedback[$row->id] = $param;
			}

			// print_r($param);
			// foreach ($all_tickets as $t) {
			// 	if ($t->feedbackid == $row->id) {

			// 		$tickets[$row->id] = $t;
			// 	}
			// }
		}
		$total_count = $satisfied_count + $unsatisfied_count + $neutral_count;
		if ($total_count > 0) {
			$psat_score = round((($total_count - $unsatisfied_count) / $total_count * 100) * 1);
		} else {
			$psat_score = 0;
		}
		$psat = array();
		$psat['psat_score'] = $psat_score;
		$psat['satisfied_count'] = $satisfied_count;
		$psat['satisfied_feedback'] = $satisfied_feedback;
		$psat['unsatisfied_count'] = $unsatisfied_count;
		$psat['unsatisfied_feedback'] = $unsatisfied_feedback;
		// $psat['neutral_count'] = $neutral_count;
		// $psat['neutral_feedbacks'] = $neutral_feedbacks;
		// $psat['tickets'] = $tickets;
		return $psat;
	}





	public function recent_comments($table_feedback, $sorttime, $setup)
	{
		$fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
		$tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
		$this->db->select($table_feedback . '.*');
		$this->db->from($table_feedback);
		if (isset($_SESSION['ward']) && $_SESSION['ward'] != 'ALL') {
			$this->db->where($table_feedback . '.ward', $_SESSION['ward']);
		}
		$this->db->where($table_feedback . '.datet <=', $fdate);
		$this->db->where($table_feedback . '.datet >=', $tdate);
		$this->db->order_by('datetime', $sorttime);
		$query = $this->db->get();
		$recent_comments = $query->result();
		$dataexport = array();
		$this->db->select($setup . '.*');
		$this->db->from($setup);
		$this->db->order_by('id', 'asc');
		$query = $this->db->get();
		$sresult = $query->result();
		foreach ($sresult as $r) {
			$setarray[$r->type] = $r->title;
			$questionarray[$r->shortkey] = $r->shortkey;
		}

		$i = 0;

		foreach ($recent_comments as $row) {
			$data = json_decode($row->dataset, true);
			$dataexport[$i]['id'] = $row->id;
			$dataexport[$i]['name'] = $data['name'];
			$dataexport[$i]['patientid'] = $data['patientid'];
			$dataexport[$i]['ward'] = $data['ward'];
			$dataexport[$i]['bed'] = $data['bedno'];
			$dataexport[$i]['suggestions']  = $data['suggestionText'];
			$dataexport[$i]['avgrating']  = $data['overallScore'];
			foreach ($setarray as $key => $t) {
				if ($data['comment'][$key]) {
					$dataexport[$i]['comment'] = $data['comment'];
				}
				foreach ($questionarray as $skey => $tss) {
					$dataexport[$i]['reason'] = $data['reason'];
				}
			}
			$i++;
		}
		return $dataexport;
	}

	public function feedbacks_data($table_feedback, $sorttime, $setup)
	{
		//date capture from session data
		$fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
		$tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
		$this->db->select($table_feedback . '.*');
		$this->db->from($table_feedback);
		// floor/ ward condition
		if (isset($_SESSION['ward']) && $_SESSION['ward'] != 'ALL') {
			$this->db->where($table_feedback . '.ward', $_SESSION['ward']);
		}
		// date condition for querry
		$this->db->where($table_feedback . '.datet <=', $fdate);
		$this->db->where($table_feedback . '.datet >=', $tdate);
		$this->db->order_by('datetime', $sorttime);
		$query = $this->db->get();
		$feedbacks_data = $query->result();
		$dataexport = array();
		//index varriable
		$i = 0;
		//questions and set for comparison 
		$this->db->select($setup . '.*');
		$this->db->from($setup);
		$this->db->order_by('id', 'asc');
		$query = $this->db->get();
		$sresult = $query->result();
		foreach ($sresult as $r) {
			$setarray[$r->type] = $r->title;
		}
		foreach ($sresult as $r) {
			//change short key to question if question has to be displayed.
			$questionarray[$r->shortkey] = $r->shortkey;
		}

		foreach ($feedbacks_data as $row) {
			$data = json_decode($row->dataset, true);
			$dataexport['id'] = $row->id;
			$dataexport['name'] = $data['name'];
			$dataexport['patientid'] = $data['patientid'];
			$dataexport['mobile'] = $data['contactnumber'];
			$dataexport['ward'] = $data['ward'];
			$dataexport['bed'] = $data['bedno'];
			$dataexport['suggestions']  = $data['suggestionText'];
			$dataexport['average_rating']  = $data['overallScore'];
			$dataexport['source']  = $row->source;
			$dataexport['feedtime']  = date('g:i A, d-m-y', strtotime($row->datetime));
			foreach ($setarray as $key => $t) {
				if ($data['comment'][$key]) {
					$dataexport[$i][$t] = $data['comment'][$key];
					// $dataexport[$i]['reason'] = $data;
				}
			}
			foreach ($questionarray as $key => $t3) {
				if ($data['reason'][$key]) {
					$dataexport[$i]['reason'] = $t3;
				}
			}
			$i++;
		}
		return $dataexport;
		//returns array with all demography of the patient.
	}

	public function reason_to_choose_hospital($table_feedback, $sorttime)
	{
		//date capture from session data
		$fdate = date('Y-m-d', strtotime($_SESSION['from_date']));
		$tdate = date('Y-m-d', strtotime($_SESSION['to_date']));
		$this->db->select($table_feedback . '.*');
		$this->db->from($table_feedback);
		// floor/ ward condition
		if (isset($_SESSION['ward']) && $_SESSION['ward'] != 'ALL') {
			$this->db->where($table_feedback . '.ward', $_SESSION['ward']);
		}
		// date condition for querry
		$this->db->where($table_feedback . '.datet <=', $fdate);
		$this->db->where($table_feedback . '.datet >=', $tdate);
		$this->db->order_by('datetime', $sorttime);
		$query = $this->db->get();
		$reason_to_choose_hospital = $query->result();
		$t = 0;
		$i = 0;
		$piechart = array();
		$choice_array = array('location' => 'Location', 'specificservice' => 'Specific services offered', 'referred' => 'Referred by doctors', 'friend' => 'Friend/Family recommendation', 'previous' => 'Previous experience', 'docAvailability' => 'Insurance facilities', 'companyRecommend' => 'Company Recommendation', 'otherReason' => 'Print or Online Media');
		$tcount = 0;
		foreach ($choice_array as $row => $v) {
			foreach ($reason_to_choose_hospital as $r) {
				$param = json_decode($r->dataset, true);
				foreach ($param as $k => $rval) {
					if ($k == $row) {
						if ($param[$k] != '') {
							$tcount++;
						}
					}
				}
			}
		}
		$t = 0;
		foreach ($choice_array as $row => $v) {
			$count = 0;
			foreach ($reason_to_choose_hospital as $r) {
				$param = json_decode($r->dataset, true);
				foreach ($param as $k => $rval) {
					if ($k == $row) {
						if ($param[$k] != '') {
							$count++;
						}
					}
				}
			}
			if ($count > 0) {
				$percentage = ($count / $tcount) * 100;
			} else {
				$percentage = 0;
			}

			if ($t == 0) {
				$t = 1;
				$piechart[$i]['percentage'] .= round(($percentage));
				$piechart[$i]['title'] .= $v;
				$piechart[$i]['count'] .= $count;
				$oba[$i] = (object)$piechart[$i];
			} else {
				$piechart[$i]['percentage'] .=   round(($percentage));
				$piechart[$i]['title'] .= $v;
				$piechart[$i]['count'] .=  $count;
				$oba[$i] = (object)$piechart[$i];
			}
			$i++;
		}
		return $oba;
	}


//keep
	public function key_highlights($table_patients, $table_feedback, $sorttime, $setup)
	{


		$highestPercentage = -1; // Initial value to ensure any positive value in the array is higher
		$lowestPercentage = 101; // Initial value to ensure any value in the array is lower
		$highestName = "";
		$lowestName = "";

		$highestCount = -1; // Initial value to ensure any positive value in the array is higher
		$lowestCount = PHP_INT_MAX; // Set initial value to the largest possible integer value
		$highestSubParam = "";
		$lowestSubParam = "";

		$res = $this->key_highlights2($table_patients, $table_feedback, $sorttime, $setup);
		foreach ($res['parent'] as $item) {
			$percentage = $item['parent_percentage'];
			if ($percentage > 0) { // exclude zeros
				if ($percentage > $highestPercentage) {
					$highestPercentage = $percentage;
					$highestName = $item['parent_param'];
					$highesthortkey = $item['shortkey'];
				}
				if ($percentage < $lowestPercentage) {
					$lowestPercentage = $percentage;
					$lowestName = $item['parent_param'];
					$lowestshortkey = $item['shortkey'];
				}
			}
		}

		foreach ($res['sub'] as $item) {
			$count = $item['sub_count'];
			if ($count > 0) {
				if ($count > $highestCount) {
					$highestCount = $count;
					$highestSubParam = $item['sub_param'];
					$highestreasonshortkey = $item['shortkey'];
				}
				if ($count < $lowestCount) {
					$lowestCount = $count;
					$lowestSubParam = $item['sub_param'];
					$lowestreasonshortkey = $item['shortkey'];
				}
			}
		}

		$keyhighlights = array();
		$keyhighlights['best_param'] = $highestName;
		$keyhighlights['highestvalue'] = $highestPercentage;
		$keyhighlights['highesthortkey'] = $highesthortkey;

		$keyhighlights['lowest_param'] = $lowestName;
		$keyhighlights['lowestvalue'] = $lowestPercentage;
		$keyhighlights['lowestshortkey'] = $lowestshortkey;

		$keyhighlights['badparam'] = $highestSubParam;


		$keyhighlights['highestCount'] = $highestCount;
		$keyhighlights['highestSubParam'] = $highestSubParam;
		$keyhighlights['highestreasonshortkey'] = $highestreasonshortkey;


		$keyhighlights['lowestCount'] = $lowestCount;
		$keyhighlights['lowestSubParam'] = $lowestSubParam;
		$keyhighlights['lowestreasonshortkey'] = $lowestreasonshortkey;


		// print_r($keyhighlights);
		return $keyhighlights;
	}


//keep
	public function tickets_recived_by_department_interim($type, $table_feedback, $table_tickets)
	{
		$department = $this->get_departmentint($type);
		$i = 0;
		$all_tickes = $this->get_tickets($table_feedback, $table_tickets);
		$report = array();
		$response = array();
		$department_set = array();
		foreach ($department as $departmentRow) {
			if (isset($department_set[$departmentRow->setkey])) {
				$department_set[$departmentRow->setkey]['department_id_set'][] = $departmentRow->dprt_id;
			} else {
				$department_set[$departmentRow->setkey] = array();
				$department_set[$departmentRow->setkey]['department_id_set'] = array();
				$department_set[$departmentRow->setkey]['department_id_set'][] = $departmentRow->dprt_id;
				$department_set[$departmentRow->setkey]['department_name'] = $departmentRow->description;
			}
			asort($department_set);
		}
		$set = array();
		foreach ($department_set as $key => $department_set_row) {
			// echo '<pre>';
			// print_r($department_set_row); exit;
			$data =  $this->get_toal_ticket_by_department_interim($all_tickes, $department_set_row);
			$percentage  = $data['percentage'];
			$total_count  = $data['total_count'];
			$open_tickets = $data['open_tickets'];
			$closed_tickets = $data['closed_tickets'];
			$addressed_tickets = $data['addressed_tickets'];
			$tr_rate = $data['tr_rate'];
			$res_time = $data['res_time'];
			// $total_tickets = $data['total_tickets'];
			$set[$i]['department'] = $department_set_row['department_name'];
			$set[$i]['percentage'] = $percentage;
			$set[$i]['total_count'] = $total_count;
			$set[$i]['closed_tickets'] = $closed_tickets;
			$set[$i]['open_tickets'] = $open_tickets;
			$set[$i]['addressed_tickets'] = $addressed_tickets;
			$set[$i]['tr_rate'] = $tr_rate;
			$set[$i]['res_time'] = $res_time;
			$i++;
		}
		return $set;
	}

//keep
	private function get_toal_ticket_by_department_interim($tickes, $department_set_row)
	{
		$total_count = 0;
		$total_percentage = 0;
		$open_tickets = 0;
		$closed_tickets = 0;
		$addressed_tickets = 0;
		$time = 0;
		foreach ($tickes as $row) {
			if (in_array($row->departmentid, $department_set_row['department_id_set'])) {
				$total_count++;
			}
		}
		foreach ($tickes as $row) {
			if (in_array($row->departmentid, $department_set_row['department_id_set']) && $row->status == 'Open') {
				$open_tickets++;
			}
			if (in_array($row->departmentid, $department_set_row['department_id_set']) && $row->status == 'Closed') {
				$closed_tickets++;
				$time += strtotime($row->last_modified) - strtotime($row->created_on);
			}
			if (in_array($row->departmentid, $department_set_row['department_id_set']) && $row->status == 'Addressed') {
				$addressed_tickets++;
			}
		}
		if ($total_count > 0 && count($tickes) > 0) {
			$total_percentage = round(($total_count / count($tickes)) * 100);
		}
		if ($closed_tickets > 0 && count($tickes) > 0) {
			$tr_rate = round(($closed_tickets / count($tickes)) * 100);
			$seconds = $time / $closed_tickets;
		} else {
			$tr_rate = 0;
		}

		$data = array();
		$data['percentage'] = $total_percentage;
		$data['total_count'] = $total_count;
		$data['open_tickets'] = $open_tickets;
		$data['closed_tickets'] = $closed_tickets;
		$data['addressed_tickets'] = $addressed_tickets;
		$data['tr_rate'] = $tr_rate;
		$data['res_time'] = $seconds;
		// $data['total_tickets'] = count($tickes);
		return $data;
	}
}
