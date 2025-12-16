<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SetupEfeeder extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$dates = get_from_to_date();
		$this->load->model(array(
			'dashboard_model',
			'efeedor_model',
			'ticketsint_model',
			'tickets_model',
			'ticketsop_model',
			'setting_model'
		));
	}



	function questionjsonemp()
	{
		$this->db->group_by('title');
		$this->db->order_by('id');
		$query = $this->db->get('setupemployees');
		$result = $query->result();
		$set = array();
		$i = 0;
		foreach ($result as $r) {
			$this->db->where('title', $r->title);
			$this->db->order_by('id');
			$query = $this->db->get('setupemployees');
			$qr = $query->result();
			$set[$i]['category'] = $r->title;
			$set[$i]['categoryk'] = $r->titlek;
			$set[$i]['settitle'] = $r->type;
			$set[$i]['errortitle'] = false;
			$set[$i]['question'] = $qr;

			$i++;
		}
		echo json_encode($set);
		exit;
	}


	function questionjson()
	{
		$this->db->where('parent', 1);
		$this->db->where('display', 1);
		$this->db->group_by('title');
		$this->db->order_by('sort_order');
		$query = $this->db->get('setup');
		$result = $query->result();
		$set = array();
		$i = 0;
		$negative = array();
		foreach ($result as $r) {
			$this->db->where('type', $r->type);
			$this->db->where('parent', 1);
			$this->db->order_by('id');
			$query = $this->db->get('setup');
			$qr = $query->result();
			foreach ($qr as $key => $row) {
				$set[$i]['category'] = $r->title;
				$set[$i]['categoryk'] = $r->titlek;
				$set[$i]['categorym'] = $r->titlem;
				$set[$i]['settitle'] = $r->type;
				$set[$i]['errortitle'] = false;
				$set[$i]['positivebox'] = false;
				$set[$i]['question'] = $qr;
				//$set[$i]['question']->negative = [];
				$this->db->where('type', $r->type);
				$this->db->where('parent', 0);
				// $this->db->where('display', 1);
				$this->db->order_by('display');
				$query = $this->db->get('setup');
				$qr1 = $query->result();
				foreach ($qr1 as $q) {
					$set[$i]['question'][$key]->negative[] = $q;
				}
			}

			// $set[$i]['negative'] = $negative;
			$i++;
		}
		echo json_encode($set);
	}

	function questionjson_pdf()
	{
		$this->db->where('parent', 1);
		$this->db->where('display', 1);
		$this->db->group_by('title');
		$this->db->order_by('sort_order');
		$query = $this->db->get('setup_pdf');
		$result = $query->result();
		$set = array();
		$i = 0;
		$negative = array();
		foreach ($result as $r) {
			$this->db->where('type', $r->type);
			$this->db->where('parent', 1);
			$this->db->order_by('id');
			$query = $this->db->get('setup_pdf');
			$qr = $query->result();
			foreach ($qr as $key => $row) {
				$set[$i]['category'] = $r->title;
				$set[$i]['categoryk'] = $r->titlek;
				$set[$i]['categorym'] = $r->titlem;
				$set[$i]['settitle'] = $r->type;
				$set[$i]['errortitle'] = false;
				$set[$i]['positivebox'] = false;
				$set[$i]['question'] = $qr;
				//$set[$i]['question']->negative = [];
				$this->db->where('type', $r->type);
				$this->db->where('parent', 0);
				$this->db->where('display', 1);
				$this->db->order_by('id');
				$query = $this->db->get('setup_pdf');
				$qr1 = $query->result();
				foreach ($qr1 as $q) {
					$set[$i]['question'][$key]->negative[] = $q;
				}
			}

			// $set[$i]['negative'] = $negative;
			$i++;
		}
		echo json_encode($set);
	}

	function questionjson_doctors_feedback()
	{
		$this->db->where('parent', 1);
		$this->db->where('display', 1);
		$this->db->group_by('title');
		$this->db->order_by('sort_order');
		$query = $this->db->get('setup_doctor');
		$result = $query->result();
		$set = array();
		$i = 0;
		$negative = array();
		foreach ($result as $r) {
			$this->db->where('type', $r->type);
			$this->db->where('parent', 1);
			$this->db->order_by('id');
			$query = $this->db->get('setup_doctor');
			$qr = $query->result();
			foreach ($qr as $key => $row) {
				$set[$i]['category'] = $r->title;
				$set[$i]['categoryk'] = $r->titlek;
				$set[$i]['categorym'] = $r->titlem;
				$set[$i]['settitle'] = $r->type;
				$set[$i]['errortitle'] = false;
				$set[$i]['positivebox'] = false;
				$set[$i]['question'] = $qr;
				//$set[$i]['question']->negative = [];
				$this->db->where('type', $r->type);
				$this->db->where('parent', 0);
				$this->db->where('display', 1);
				$this->db->order_by('id');
				$query = $this->db->get('setup_doctor');
				$qr1 = $query->result();
				foreach ($qr1 as $q) {
					$set[$i]['question'][$key]->negative[] = $q;
				}
			}

			// $set[$i]['negative'] = $negative;
			$i++;
		}
		echo json_encode($set);
	}

	function questionjson_doctors_opd_feedback()
	{
		$this->db->where('parent', 1);
		$this->db->where('display', 1);
		$this->db->group_by('title');
		$this->db->order_by('sort_order');
		$query = $this->db->get('setup_doctor_opd');
		$result = $query->result();
		$set = array();
		$i = 0;
		$negative = array();
		foreach ($result as $r) {
			$this->db->where('type', $r->type);
			$this->db->where('parent', 1);
			$this->db->order_by('id');
			$query = $this->db->get('setup_doctor_opd');
			$qr = $query->result();
			foreach ($qr as $key => $row) {
				$set[$i]['category'] = $r->title;
				$set[$i]['categoryk'] = $r->titlek;
				$set[$i]['categorym'] = $r->titlem;
				$set[$i]['settitle'] = $r->type;
				$set[$i]['errortitle'] = false;
				$set[$i]['positivebox'] = false;
				$set[$i]['question'] = $qr;
				//$set[$i]['question']->negative = [];
				$this->db->where('type', $r->type);
				$this->db->where('parent', 0);
				$this->db->where('display', 1);
				$this->db->order_by('id');
				$query = $this->db->get('setup_doctor_opd');
				$qr1 = $query->result();
				foreach ($qr1 as $q) {
					$set[$i]['question'][$key]->negative[] = $q;
				}
			}

			// $set[$i]['negative'] = $negative;
			$i++;
		}
		echo json_encode($set);
	}


	function questionjson_type2()
	{
		$this->db->where('parameter', 0);
		$this->db->group_by('title');
		$this->db->order_by('id');
		$query = $this->db->get('setup');
		$result = $query->result();
		$set = array();
		$i = 0;
		$worst = array();
		$poor = array();
		$average = array();
		$good = array();
		$excellent = array();
		foreach ($result as $r) {
			$this->db->where('type', $r->type);
			$this->db->where('parent', 1);
			$this->db->order_by('id');
			$query = $this->db->get('setup');
			$qr = $query->result();
			foreach ($qr as $key => $row) {
				$set[$i]['category'] = $r->title;
				$set[$i]['categoryk'] = $r->titlek;
				$set[$i]['categorym'] = $r->titlem;
				$set[$i]['settitle'] = $r->type;
				$set[$i]['errortitle1'] = false;
				$set[$i]['question'] = $qr;

				$this->db->where('type', $r->type);
				$this->db->where('parent', 0);
				$this->db->where('parameter', 1);
				$this->db->order_by('id');
				$query = $this->db->get('setup');
				$qr1 = $query->result();
				foreach ($qr1 as $q) {
					$set[$i]['question'][$key]->worst[] = $q;
				}
			}
			foreach ($qr as $key => $row) {
				$set[$i]['category'] = $r->title;
				$set[$i]['categoryk'] = $r->titlek;
				$set[$i]['categorym'] = $r->titlem;
				$set[$i]['settitle'] = $r->type;
				$set[$i]['errortitle2'] = false;
				$set[$i]['question'] = $qr;

				$this->db->where('type', $r->type);
				$this->db->where('parent', 0);
				$this->db->where('parameter', 2);
				$this->db->order_by('id');
				$query = $this->db->get('setup');
				$qr1 = $query->result();
				foreach ($qr1 as $q) {
					$set[$i]['question'][$key]->poor[] = $q;
				}
			}
			foreach ($qr as $key => $row) {
				$set[$i]['category'] = $r->title;
				$set[$i]['categoryk'] = $r->titlek;
				$set[$i]['categorym'] = $r->titlem;
				$set[$i]['settitle'] = $r->type;
				$set[$i]['errortitle3'] = false;
				$set[$i]['question'] = $qr;

				$this->db->where('type', $r->type);
				$this->db->where('parent', 0);
				$this->db->where('parameter', 3);
				$this->db->order_by('id');
				$query = $this->db->get('setup');
				$qr1 = $query->result();
				foreach ($qr1 as $q) {
					$set[$i]['question'][$key]->average[] = $q;
				}
			}
			foreach ($qr as $key => $row) {
				$set[$i]['category'] = $r->title;
				$set[$i]['categoryk'] = $r->titlek;
				$set[$i]['categorym'] = $r->titlem;
				$set[$i]['settitle'] = $r->type;
				$set[$i]['errortitle4'] = false;
				$set[$i]['question'] = $qr;

				$this->db->where('type', $r->type);
				$this->db->where('parent', 0);
				$this->db->where('parameter', 4);
				$this->db->order_by('id');
				$query = $this->db->get('setup');
				$qr1 = $query->result();
				foreach ($qr1 as $q) {
					$set[$i]['question'][$key]->good[] = $q;
				}
			}
			foreach ($qr as $key => $row) {
				$set[$i]['category'] = $r->title;
				$set[$i]['categoryk'] = $r->titlek;
				$set[$i]['categorym'] = $r->titlem;
				$set[$i]['settitle'] = $r->type;
				$set[$i]['errortitle5'] = false;
				$set[$i]['question'] = $qr;

				$this->db->where('type', $r->type);
				$this->db->where('parent', 0);
				$this->db->where('parameter', 5);
				$this->db->order_by('id');
				$query = $this->db->get('setup');
				$qr1 = $query->result();
				foreach ($qr1 as $q) {
					$set[$i]['question'][$key]->excellent[] = $q;
				}
			}

			// $set[$i]['negative'] = $negative;
			$i++;
		}
		echo json_encode($set);
	}


	function promjson()
	{
		$this->db->where('parent', 1);
		$this->db->group_by('title');
		$this->db->order_by('id');
		$query = $this->db->get('setup_prom');
		$result = $query->result();
		$set = array();
		$i = 0;
		$negative = array();
		foreach ($result as $r) {
			$this->db->where('type', $r->type);
			$this->db->where('parent', 1);
			$this->db->order_by('id');
			$query = $this->db->get('setup_prom');
			$qr = $query->result();
			foreach ($qr as $key => $row) {
				$set[$i]['category'] = $r->title;
				$set[$i]['categoryk'] = $r->titlek;
				$set[$i]['categorym'] = $r->titlem;
				$set[$i]['settitle'] = $r->type;
				$set[$i]['errortitle'] = false;
				$set[$i]['mark'] = $r->mark;
				$set[$i]['question'] = $qr;
				//$set[$i]['question']->negative = [];
				$this->db->where('type', $r->type);
				$this->db->where('parent', 0);
				$this->db->order_by('id');
				$query = $this->db->get('setup_prom');
				$qr1 = $query->result();
				foreach ($qr1 as $q) {
					$set[$i]['question'][$key]->negative[] = $q;
				}
			}

			// $set[$i]['negative'] = $negative;
			$i++;
		}
		echo json_encode($set);
	}

	function questionjson_social()
	{
		$this->db->where('display', 1);
		$this->db->where('parent', 1);
		$this->db->group_by('title');
		$this->db->order_by('sort_order');
		$query = $this->db->get('setup_social');
		$result = $query->result();
		$set = array();
		$i = 0;
		$negative = array();
		foreach ($result as $r) {
			$this->db->where('type', $r->type);
			$this->db->where('parent', 1);
			$this->db->order_by('id');
			$query = $this->db->get('setup_social');
			$qr = $query->result();
			foreach ($qr as $key => $row) {
				$set[$i]['category'] = $r->title;
				$set[$i]['categoryk'] = $r->titlek;
				$set[$i]['categorym'] = $r->titlem;
				$set[$i]['settitle'] = $r->type;
				$set[$i]['icon'] = $r->icon;
				$set[$i]['errortitle'] = false;
				$set[$i]['question'] = $qr;
				//$set[$i]['question']->negative = [];
				$this->db->where('type', $r->type);
				$this->db->where('parent', 0);
				$this->db->order_by('id');
				$query = $this->db->get('setup_social');
				$qr1 = $query->result();
				foreach ($qr1 as $q) {
					$set[$i]['question'][$key]->negative[] = $q;
				}
			}

			// $set[$i]['negative'] = $negative;
			$i++;
		}
		echo json_encode($set);
		exit;
	}




	function questionjson_int()
	{
		$this->db->where('display', 1);
		$this->db->where('parent', 1);
		$this->db->group_by('title');
		$this->db->order_by('sort_order');
		$query = $this->db->get('setup_int');
		$result = $query->result();
		$set = array();
		$i = 0;
		$negative = array();
		foreach ($result as $r) {
			$this->db->where('type', $r->type);
			$this->db->where('parent', 1);
			$this->db->order_by('id');
			$query = $this->db->get('setup_int');
			$qr = $query->result();
			foreach ($qr as $key => $row) {
				$set[$i]['category'] = $r->title;
				$set[$i]['categoryk'] = $r->titlek;
				$set[$i]['categorym'] = $r->titlem;
				$set[$i]['settitle'] = $r->type;
				$set[$i]['icon'] = $r->icon;
				$set[$i]['errortitle'] = false;
				$set[$i]['question'] = $qr;
				//$set[$i]['question']->negative = [];
				$this->db->where('type', $r->type);
				$this->db->where('parent', 0);
				$this->db->order_by('id');
				$query = $this->db->get('setup_int');
				$qr1 = $query->result();
				foreach ($qr1 as $q) {
					$set[$i]['question'][$key]->negative[] = $q;
				}
			}

			// $set[$i]['negative'] = $negative;
			$i++;
		}
		echo json_encode($set);
		exit;
	}




	function questionsinc()
	{
		$this->db->where('parent', 1);
		$this->db->where('display', 1);
		$this->db->group_by('title');
		$this->db->order_by('id');
		$query = $this->db->get('setup_incident');
		$result = $query->result();
		$set = array();
		$i = 0;
		$negative = array();
		foreach ($result as $r) {
			$this->db->where('type', $r->type);
			$this->db->where('parent', 1);
			$this->db->order_by('id');
			$query = $this->db->get('setup_incident');
			$qr = $query->result();
			foreach ($qr as $key => $row) {
				$set[$i]['category'] = $r->title;
				$set[$i]['categoryk'] = $r->titlek;
				$set[$i]['categorym'] = $r->titlem;
				$set[$i]['settitle'] = $r->type;
				$set[$i]['icon'] = $r->icon;
				$set[$i]['errortitle'] = false;
				$set[$i]['question'] = $qr;
				//$set[$i]['question']->negative = [];
				$this->db->where('type', $r->type);
				$this->db->where('parent', 0);
				$this->db->order_by('id');
				$query = $this->db->get('setup_incident');
				$qr1 = $query->result();
				foreach ($qr1 as $q) {
					$set[$i]['question'][$key]->negative[] = $q;
				}
			}

			// $set[$i]['negative'] = $negative;
			$i++;
		}
		echo json_encode($set);
		exit;
	}


function questionsgrievance()
	{
		$this->db->where('parent', 1);
		$this->db->where('display', 1);
		$this->db->group_by('title');
		$this->db->order_by('id');
		$query = $this->db->get('setup_grievance');
		$result = $query->result();
		$set = array();
		$i = 0;
		$negative = array();
		foreach ($result as $r) {
			$this->db->where('type', $r->type);
			$this->db->where('parent', 1);
			$this->db->order_by('id');
			$query = $this->db->get('setup_grievance');
			$qr = $query->result();
			foreach ($qr as $key => $row) {
				$set[$i]['category'] = $r->title;
				$set[$i]['categoryk'] = $r->titlek;
				$set[$i]['categorym'] = $r->titlem;
				$set[$i]['settitle'] = $r->type;
				$set[$i]['icon'] = $r->icon;
				$set[$i]['errortitle'] = false;
				$set[$i]['question'] = $qr;
				//$set[$i]['question']->negative = [];
				$this->db->where('type', $r->type);
				$this->db->where('parent', 0);
				$this->db->order_by('id');
				$query = $this->db->get('setup_grievance');
				$qr1 = $query->result();
				foreach ($qr1 as $q) {
					$set[$i]['question'][$key]->negative[] = $q;
				}
			}

			// $set[$i]['negative'] = $negative;
			$i++;
		}
		echo json_encode($set);
		exit;
	}



	function questionjson_esr()
	{
		$this->db->where('parent', 1);
		$this->db->where('display', 1);
		$this->db->group_by('title');
		
		$this->db->order_by('sort_order');
		$query = $this->db->get('setup_esr');
		$result = $query->result();
		$set = array();
		$i = 0;
		$negative = array();
		foreach ($result as $r) {
			$this->db->where('type', $r->type);
			$this->db->where('parent', 1);
			$this->db->order_by('id');
			$query = $this->db->get('setup_esr');
			$qr = $query->result();
			foreach ($qr as $key => $row) {
				$set[$i]['category'] = $r->title;
				$set[$i]['categoryk'] = $r->titlek;
				$set[$i]['categorym'] = $r->titlem;
				$set[$i]['settitle'] = $r->type;
				$set[$i]['icon'] = $r->icon;
				$set[$i]['errortitle'] = false;
				$set[$i]['question'] = $qr;
				//$set[$i]['question']->negative = [];
				$this->db->where('type', $r->type);
				$this->db->where('parent', 0);
				$this->db->order_by('id');
				$query = $this->db->get('setup_esr');
				$qr1 = $query->result();
				foreach ($qr1 as $q) {
					$set[$i]['question'][$key]->negative[] = $q;
				}
			}

			// $set[$i]['negative'] = $negative;
			$i++;
		}
		echo json_encode($set);
		exit;
	}



	function op_questionjson()
	{
		$this->db->where('parent', 1);
		$this->db->where('display', 1);
		$this->db->group_by('title');
		$this->db->order_by('sort_order');

		$query = $this->db->get('setupop');
		$result = $query->result();
		$set = array();
		$i = 0;
		$negative = array();
		foreach ($result as $r) {
			$this->db->where('title', $r->title);
			$this->db->where('parent', 1);
			$this->db->order_by('id');
			$query = $this->db->get('setupop');
			$qr = $query->result();
			foreach ($qr as $key => $row) {
				$set[$i]['category'] = $r->title;
				$set[$i]['categoryk'] = $r->titlek;
				$set[$i]['categorym'] = $r->titlem;
				$set[$i]['settitle'] = $r->type;
				$set[$i]['errortitle'] = false;
				$set[$i]['question'] = $qr;
				//$set[$i]['question']->negative = [];
				$this->db->where('title', $r->title);
				$this->db->where('parent', 0);
				$this->db->where('display', 1);

				$this->db->order_by('id');
				$query = $this->db->get('setupop');
				$qr1 = $query->result();
				foreach ($qr1 as $q) {
					$set[$i]['question'][$key]->negative[] = $q;
				}
			}

			// $set[$i]['negative'] = $negative;
			$i++;
		}
		echo json_encode($set);
	}


	function adf_question()
	{
		$this->db->where('parent', 1);
		$this->db->where('display', 1);
		$this->db->group_by('title');
		$this->db->order_by('sort_order');

		$query = $this->db->get('setup_adf');
		$result = $query->result();
		$set = array();
		$i = 0;
		$negative = array();
		foreach ($result as $r) {
			$this->db->where('title', $r->title);
			$this->db->where('parent', 1);
			$this->db->order_by('id');
			$query = $this->db->get('setup_adf');
			$qr = $query->result();
			foreach ($qr as $key => $row) {
				$set[$i]['category'] = $r->title;
				$set[$i]['categoryk'] = $r->titlek;
				$set[$i]['categorym'] = $r->titlem;
				$set[$i]['settitle'] = $r->type;
				$set[$i]['errortitle'] = false;
				$set[$i]['question'] = $qr;
				//$set[$i]['question']->negative = [];
				$this->db->where('title', $r->title);
				$this->db->where('parent', 0);
				$this->db->where('display', 1);

				$this->db->order_by('id');
				$query = $this->db->get('setup_adf');
				$qr1 = $query->result();
				foreach ($qr1 as $q) {
					$set[$i]['question'][$key]->negative[] = $q;
				}
			}

			// $set[$i]['negative'] = $negative;
			$i++;
		}
		echo json_encode($set);
	}

	function departmetnip()
	{ exit;
		$this->db->where('type', 'inpatient');
		$this->db->delete('department');

		// $this->db->where('parent', 1);
		$this->db->order_by('id');
		$query = $this->db->get('setup');
		$result = $query->result();

		$set = array();
		$i = 0;
		foreach ($result as $r) {
			$ipd = array(
				'name' => $r->shortname,
				'description' => $r->title,
				'status' => 1,
				'slug' => $r->shortkey,
				'setkey' => $r->type,
				'type' => 'inpatient',
			);
			$this->db->insert('department', $ipd);
		}
		echo 'Done';
		//echo json_encode($set);
		exit;
	}


	function departmetnop()
	{ exit;
		$this->db->where('type', 'outpatient');
		$this->db->delete('department');

		$this->db->order_by('id');
		$query = $this->db->get('setupop');
		$result = $query->result();
		$set = array();
		$i = 0;
		foreach ($result as $r) {
			$ipd = array(
				'name' => $r->shortname,
				'description' => $r->title,
				'status' => 1,
				'setkey' => $r->type,
				'slug' => $r->shortkey,
				'type' => 'outpatient',
			);
			$this->db->insert('department', $ipd);
		}
		echo 'Done';
		//echo json_encode($set);
		exit;
	}


	function setupadf()
	{
		$this->db->where('type', 'adf');
		$this->db->delete('department');

		$this->db->order_by('id');
		$query = $this->db->get('setup_adf');
		$result = $query->result();
		$set = array();
		$i = 0;
		foreach ($result as $r) {
			$ipd = array(
				'name' => $r->shortname,
				'description' => $r->title,
				'status' => 1,
				'setkey' => $r->type,
				'slug' => $r->shortkey,
				'type' => 'adf',
			);
			$this->db->insert('department', $ipd);
		}
		echo 'Done';
		//echo json_encode($set);
		exit;
	}

	function departmentinterim()
	{ exit;
		$this->db->where('type', 'interim');
		$this->db->delete('department');

		$this->db->order_by('id');
		$query = $this->db->get('setup_int');
		$result = $query->result();
		$set = array();
		$i = 0;
		foreach ($result as $r) {
			$ipd = array(
				'name' => $r->shortname,
				'description' => $r->title,
				'status' => 1,
				'setkey' => $r->type,
				'slug' => $r->shortkey,
				'type' => 'interim',
			);
			$this->db->insert('department', $ipd);
		}
		echo 'Done';
		//echo json_encode($set);
		exit;
	}

	function setupexp()
	{
		$this->db->where('type', 'employees');
		$this->db->delete('department');

		$this->db->order_by('id');
		$query = $this->db->get('setupemployees');
		$result = $query->result();
		$set = array();
		$i = 0;
		foreach ($result as $r) {
			$ipd = array(
				'name' => $r->shortname,
				'description' => $r->title,
				'status' => 1,
				'slug' => $r->shortkey,
				'type' => 'employees',
			);
			$this->db->insert('department', $ipd);
		}
		echo 'Done';
		// echo json_encode($set);
		exit;
	}

	function setuppsr()
	{
		$this->db->where('type', 'service');
		$this->db->delete('department');

		$this->db->order_by('id');
		$query = $this->db->get('setup_service');
		$result = $query->result();
		$set = array();
		$i = 0;
		foreach ($result as $r) {
			$ipd = array(
				'name' => $r->shortname,
				'description' => $r->title,
				'status' => 1,
				'slug' => $r->shortkey,
				'type' => 'service',
			);
			$this->db->insert('department', $ipd);
		}
		echo 'Done';
		// echo json_encode($set);
		exit;
	}

	function setupesr()
	{
		$this->db->where('type', 'esr');
		$this->db->delete('department');

		$this->db->order_by('id');
		$query = $this->db->get('setup_esr');
		$result = $query->result();
		$set = array();
		$i = 0;
		foreach ($result as $r) {
			$ipd = array(
				'name' => $r->shortname,
				'description' => $r->title,
				'status' => 1,
				'setkey' => $r->type,
				'slug' => $r->shortkey,
				'type' => 'esr',
			);
			$this->db->insert('department', $ipd);
		}
		echo 'Done';
		// echo json_encode($set);
		exit;
	}

	function setupincident()
	{
		$this->db->where('type', 'incident');
		$this->db->delete('department');

		$this->db->order_by('id');
		$query = $this->db->get('setup_incident');
		$result = $query->result();
		$set = array();
		$i = 0;
		foreach ($result as $r) {
			$ipd = array(
				'name' => $r->shortname,
				'description' => $r->title,
				'status' => 1,
				'setkey' => $r->type,
				'slug' => $r->shortkey,
				'type' => 'incident',
			);
			$this->db->insert('department', $ipd);
		}
		echo 'Done';
		// echo json_encode($set);
		exit;
	}
}
