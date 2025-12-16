<?php
defined('BASEPATH') or exit('No direct script access allowed');


function notice($show)
{
	if ($show == 'display_notice') {
		return false; //to show a notice on top 
	} elseif ($show == 'dev_info') {
		return false; //to show devlopment information on hospital login
	} else {
		return false;
	}
}

function ismodule_active($module)
{
	$modules = $_SESSION['modules'];
	//echo $module;
	//var_dump($modules); exit;
	if(isset($modules[$module]) && $modules[$module] === true){
		return true;
	}
	return false;
	// function is used to activate/deactive the module
	 if ($module == 'rootcause') {
		return true;
	} else if ($module == 'escalation') {     //done
		return true;
	} else if ($module == 'escalation_adf') {   //done
		return true;
	} else if ($module == 'nps_promoter_comment') {
		return true;
	} else if ($module == 'nps_passive_comment') {
		return true;
	} else if ($module == 'nps_detractor_comment') {
		return true;
	} else if ($module == 'archived_data') {
		return false;
	} else if ($module == 'int_tat') {   //done
		return false;
	} else if ($module == 'esr_tat') {    //done
		return true;
	} else if ($module == 'adf_tat') {    //done
		return false;
	} else if ($module == 'ManageSLA') {   //done
		return true;
	} else {
		return false;
	}
}



function get_from_to_date()
{
	$y = date('Y');

	$pagetitle = 'NO TITLE';
	// $tdate = date('Y-m-d', strtotime('-30 days')); //change for default time 30 days
	// 	$_SESSION['from_date'] = $fdate;
	// 	$_SESSION['to_date'] = $tdate;
	if (!isset($_SESSION['from_date']) && !isset($_SESSION['to_date'])) {
		$fdate = date('Y-m-d', time());
	    $tdate  = date('Y-m-01'); // First day of the current month
	    //  $tdate = date('Y-m-d', strtotime('-30 days')); //change for default time 30 days
		// $tdate = date('Y-m-d', strtotime('-90 days'));
		//  $tdate = date('Y-m-d', strtotime('-365 days'));

		$_SESSION['from_date'] = $fdate;
		$_SESSION['to_date'] = $tdate;

		// $pagetitle = 'Last 90 Days';
		//$pagetitle = 'Last 30 Days';
	    $pagetitle = "Current Month";

		// $pagetitle = 'Last 365 Days';


		$_SESSION['pagetitle'] = $pagetitle;
	} else {
		$fdate = $_SESSION['from_date'];
		$tdate = $_SESSION['to_date'];
	}

	//$pagetitle = 'Last 90 Days';
	// $pagetitle = 'Last 30 Days'; //change for default time 30 days
	if (isset($_GET['today'])) {
		$pagetitle = "Last 24 Hours";
	}
	if (isset($_GET['this_month'])) {
		$pagetitle = "Current Month";
	}
	if (isset($_GET['last_month'])) {
		$pagetitle = "Previous Month";
	}
	if (isset($_GET['weekly'])) {
		$pagetitle = "Last 7 Days";
	}
	if (isset($_GET['yearm'])) {
		$pagetitle = "Last 30 Days";
	}
	if (isset($_GET['quaterly'])) {
		$pagetitle = "Last 90 Days";
	}
	if (isset($_GET['year'])) {
		$pagetitle = "Last 365 Days";
	}
	if (strtotime($tdate) < strtotime('26-07-2018')) {
		$tdate = '2018-07-26';
	}
	if (isset($_GET['year'])) {
		$year = $_GET['year'];
		$fdate = date('Y-m-d', time());
		$tdate = date('Y-m-d', strtotime('-365 days'));
		$_SESSION['from_date'] = $fdate;
		$_SESSION['to_date'] = $tdate;
	}
	if (isset($_GET['quaterly'])) {
		$fdate = date('Y-m-d', time());
		$tdate = date('Y-m-d', strtotime('-90 days'));
		$_SESSION['from_date'] = $fdate;
		$_SESSION['to_date'] = $tdate;
	}
	if (isset($_GET['mon'])) {
		$year = $_GET['yearm'];
		$month = $_GET['mon'];
		$lastdate = date('t', strtotime($year . '-' . $month . '-01'));
		// $fdate = $year.'-'.$month.'-01';
		// $tdate = $year.'-'.$month.'-'.$lastdate;
		// $fdate = date('Y-m-d', strtotime('-1 days'));
		$fdate = date('Y-m-d');
		$tdate = date('Y-m-d', strtotime('-30 days'));
		$_SESSION['from_date'] = $fdate;
		$_SESSION['to_date'] = $tdate;
	}
	if (isset($_GET['weekly'])) {

		$fdate = date('Y-m-d');
		$tdate = date('Y-m-d', strtotime('-6 days'));
		$_SESSION['from_date'] = $fdate;
		$_SESSION['to_date'] = $tdate;
	}
	if (isset($_GET['fdate']) && isset($_GET['tdate'])) {
		$fdate = $_GET['fdate'];
		$tdate = $_GET['tdate'];
		$_SESSION['from_date'] = $fdate;
		$_SESSION['to_date'] = $tdate;
		if ($fdate != $tdate) {
			$pagetitle = 'Custom';
		} else {
			$pagetitle = "Last 24 Hours";
		}
	}
	if (isset($_GET['this_month'])) {
		$tdate  = date('Y-m-01'); // First day of the current month
		$fdate = date('Y-m-d'); // Current date
		$_SESSION['from_date'] = $fdate;
		$_SESSION['to_date'] = $tdate;
		$days = (int)date('d');
		$pagetitle = "Current Month";
	}
	if (isset($_GET['today_only'])) {
		$fdate = date('Y-m-d'); // Today's date
		$tdate = date('Y-m-d'); // Today's date
		$_SESSION['from_date'] = $fdate;
		$_SESSION['to_date'] = $tdate;
		$pagetitle = "Today";
	}
	
	if (isset($_GET['previous_day'])) {
		$fdate = date('Y-m-d', strtotime('-1 day')); // Previous day's date
		$tdate = date('Y-m-d', strtotime('-1 day')); // Previous day's date
		$_SESSION['from_date'] = $fdate;
		$_SESSION['to_date'] = $tdate;
		$pagetitle = "Previous Day";
	}
	if (isset($_GET['last_month'])) {
		$tdate = date('Y-m-01', strtotime('first day of previous month')); // First day of last month
		$fdate = date('Y-m-t', strtotime('last day of previous month')); // Last day of last month
		$_SESSION['from_date'] = $fdate;
		$_SESSION['to_date'] = $tdate;
		$days = (int)date('t', strtotime('-1 month'));
		$pagetitle = "Previous Month";
	}

	if ($pagetitle == 'NO TITLE') {
		$pagetitle = $_SESSION['pagetitle'];
	} else {
		$_SESSION['pagetitle'] = $pagetitle;
	}
	$days = 0;
	// if(isset($_GET['fdate'])){
	$fdate = date('Y-m-d', strtotime($fdate));
	$tdate = date('Y-m-d', strtotime($tdate));
	$days = floor((strtotime($fdate) - strtotime($tdate)) / (60 * 60 * 24));
	$dset['fdate'] = $fdate;
	$dset['tdate'] = $tdate;
	$dset['days'] = $days;
	$_SESSION['days'] = $days;


	$dset['pagetitle'] = $pagetitle;
	return $dset;
}

function isfeature_active($feature)
{
	$features = $_SESSION['feature'];
	
	
	if(isset($features[$feature]) && $features[$feature] == true){
		return true;
	}
	return false;
}


function isSection_active($section)
{
	$sections = $_SESSION['section'];
	
	
	if(isset($sections[$section]) && $sections[$section] == true){
		return true;
	}
	return false;
}





function patientlink($show)
{
	// Patient tracking link
	if ($show == 'patient_phone') {
		return true;
	} else if ($show == 'department_phone') {
		return true;
	} else if ($show == 'int_page') {
		return true;
	} else {
		return false;
	}
}

function pagetoload($module)
{
	if ($module == 'inpatient_modules') {
		return $module;
	} else if ($module == 'outpatient_modules') {
		return $module;
	} else if ($module == 'adf_modules') {
		return $module;
	} else if ($module == 'complaint_modules') {
		return $module;
	} else if ($module == 'grievance_modules') {
		return $module;
	} else if ($module == 'esr_modules') {
		return $module;
	} else if ($module == 'incident_modules') {
		return $module;
	} else if ($module == 'empex_page') {
		return $module;
	} else {
		return false;
	}
}







function secondsToTime($inputSeconds)
{
	$secondsInAMinute = 60;
	$secondsInAnHour  = 60 * $secondsInAMinute;
	$secondsInADay    = 24 * $secondsInAnHour;

	// extract days
	$days = floor($inputSeconds / $secondsInADay);

	// extract hours
	$hourSeconds = $inputSeconds % $secondsInADay;
	$hours = floor($hourSeconds / $secondsInAnHour);

	// extract minutes
	$minuteSeconds = $hourSeconds % $secondsInAnHour;
	$minutes = floor($minuteSeconds / $secondsInAMinute);

	// extract the remaining seconds
	$remainingSeconds = $minuteSeconds % $secondsInAMinute;
	$seconds = ceil($remainingSeconds);

	// return the final array
	if ($days > 1) {
		return '<span class="count-number">' . $days . '</span> Days';
	} elseif ($days > 0) {
		return '<span class="count-number">' . $days . '</span> Day';
	} elseif ($hours > 0) {
		return '<span class="count-number">' . $hours . '</span> Hrs';
	} else {
		return '<span class="count-number">' . $minutes . '</span> Min';
	}
}


function secondsToTimeforreport($inputSeconds)
{

	$secondsInAMinute = 60;
	$secondsInAnHour  = 60 * $secondsInAMinute;
	$secondsInADay    = 24 * $secondsInAnHour;

	// extract days
	$days = floor($inputSeconds / $secondsInADay);

	// extract hours
	$hourSeconds = $inputSeconds % $secondsInADay;
	$hours = floor($hourSeconds / $secondsInAnHour);

	// extract minutes
	$minuteSeconds = $hourSeconds % $secondsInAnHour;
	$minutes = floor($minuteSeconds / $secondsInAMinute);

	// extract the remaining seconds
	$remainingSeconds = $minuteSeconds % $secondsInAMinute;
	$seconds = ceil($remainingSeconds);

	// return the final array
	if ($days > 1) {
		return  $days . ' Days';
	} elseif ($days > 0) {
		return  $days . ' Days';
	} elseif ($hours > 0) {
		return  $hours . ' Hrs';
	} else {
		return  $minutes . ' Min';
	}
}

function is_mobile()
{
	$useragent = $_SERVER['HTTP_USER_AGENT'];
	if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent)) {
		return true;
	} else {
		return false;
	}
}

// To show Top navigational filter
function show_filter($segment_1, $segment_2)
{
	$show = true;

	if ($segment_1 == 'settings') {
		$show = false;
	}
	
	if ($segment_1 == 'UserManagement') {
		$show = false;
	}
	if ($segment_1 == 'users') {
		$show = false;
	}
	if ($segment_1 == 'escalation') {
		$show = false;
	}
	if ($segment_1 == 'escalation_op') {
		$show = false;
	}
	if ($segment_1 == 'escalation_int') {
		$show = false;
	}
	if ($segment_1 == 'escalation_esr') {
		$show = false;
	}
	if ($segment_1 == 'escalation_incident') {
		$show = false;
	}
	if ($segment_1 == 'department') {
		$show = false;
	}
	if ($segment_1 == 'departmentop') {
		$show = false;
	}
	if ($segment_1 == 'ward') {
		$show = false;
	}
	if ($segment_1 == 'role') {
		$show = false;
	}
	if ($segment_1 == 'employee') {
		$show = false;
	}
	if ($segment_1 == 'wardesr') {
		$show = false;
	}
	if ($segment_1 == 'subscription') {
		$show = false;
	}
	if ($segment_1 == 'report') {
		$show = true;
	}
	
	if ($segment_2 == 'create') {
		$show = false;
	}
	if ($segment_2 == 'patient_complaint') {
		$show = false;
	}
	if ($segment_2 == 'employee_complaint') {
		$show = false;
	}
	if ($segment_2 == 'track') {
		$show = false;
	}
	if ($segment_2 == 'admin_track') {
		$show = false;
	}
	if ($segment_2 == 'patient_feedback') {
		$show = false;
	}
	if ($segment_2 == 'tickets_list') {
		$show = true;
	}

	if ($segment_2 == 'form') {
		$show = false;
	}
	if ($segment_2 == 'profile') {
		$show = false;
	}
	if ($segment_2 == 'departmenthead') {
		$show = false;
	}
	
	if ($segment_2 == 'settings') {
		$show = false;
	}
	if ($segment_2 == 'dep_tat_edit') {
		$show = false;
	}
	if ($segment_2 == 'asset_qrcode') {
		$show = false;
	}
	if ($segment_1 == 'assetgrade') {
		$show = false;
	}
	if ($segment_1 == 'departmentasset') {
		$show = false;
	}
	if ($segment_1 == 'assetlocation') {
		$show = false;
	}
	return $show;
}


// for showing and calendar in the row:
function hidecalender($segment_1)
{
	$show = $segment_1;

	// $h3[] = ('users';'escalation'. 'department'.'ward'. 'patient'. 'settings');
	$h3 = array();
	$h3 = ['view','patientop','UserManagement','subscription', 'role', 'users', 'escalation', 'department', 'ward', 'patient', 'settings', 'departmentop', 'wardesr', 'employee', 'escalation_esr', 'escalation_int', 'escalation_op', 'escalation_incident', 'asset', 'assetgrade', 'departmentasset', 'assetlocation'];
	$TEMP123 = in_array($show, $h3);
	return $TEMP123;
}

function hide_cal_seg2($segment_2)
{
	$show = $segment_2;

	// $h3[] = ('users';'escalation'. 'department'.'ward'. 'patient'. 'settings');
	$h3 = array();
	$h3 = ['form','trend_analytic','profile', 'welcome', 'admin_track', 'tickets_list', 'settings', 'patient_feedback', 'patient_complaint', 'employee_complaint', 'dep_tat', 'dep_tat_edit', 'asset_qrcode'];
	$TEMP123 = in_array($show, $h3);
	return $TEMP123;
}



// function getStartAndEndDate($week, $year,$minDate,$maxDate)
// {
// 	$dto = new DateTime();
// 	$dto->setISODate($year, $week);
// 	$ret['week_start'] = $dto->format('d');
// 	$dto->modify('+6 days');
// 	$ret['week_end'] = $dto->format('d');
// 	return $ret;
// }


function getStartAndEndDate($date, $maxDate, $minDate)
{
	// Convert input strings to DateTime objects
	$dateObj = new DateTime($date);
	$minDateObj = new DateTime($minDate);
	$maxDateObj = new DateTime($maxDate);

	// Clone the dateObj to avoid modifying the original date
	$startOfWeek = clone $dateObj;
	$endOfWeek = clone $dateObj;

	// Modify startOfWeek to the beginning of the week (Monday)
	$startOfWeek->modify('Monday this week');
	// Modify endOfWeek to the end of the week (Sunday)
	$endOfWeek->modify('Sunday this week');

	// Format start and end of the week
	$weekStart = $startOfWeek->format('Y-m-d');
	$weekEnd = $endOfWeek->format('Y-m-d');
	$maxDateObj->format('Y-m-d');
	// Adjust start date if it's before minDate
	if ($minDateObj > $startOfWeek) {
		$weekStart = $minDateObj->format('Y-m-d');
	}

	// Adjust end date if it's after maxDate
	if ($endOfWeek > $maxDateObj) {
		$weekEnd = $maxDateObj->format('Y-m-d');
		//$weekEnd = 'DATE'   ;
	}

	// Return the adjusted dates
	return [
		'week_start' => date('d', strtotime($weekStart)),
		'week_end' => date('d', strtotime($weekEnd)),
		'mon' => date('F', strtotime($weekStart)),
	];
}


// page wise controlls on the listing
// what to show on each pages for feedback modules
// PSAT
function psat_satisfied_page($show)
{
	if ($show == 'department_rating') {
		return false; //to show departments with rating >= 3
	} elseif ($show == 'overall_comments') {
		return true; //to show overall comment
	} elseif ($show == 'nps_score') {
		return false; //to show NPS score
	} else {
		return false;
	}
}


function psat_unsatisfied_page($show)
{
	if ($show == 'department_rating') {
		return true; //to show departments with rating <= 3
	} elseif ($show == 'overall_comments') {
		return false; //to show overall comment
	} elseif ($show == 'reason') {
		return true; //to show reasons
	} elseif ($show == 'nps_score') {
		return true; //to show NPS score
	} else {
		return false;
	}
}

// NPS 
function nps_promoters_page($show)
{
	if ($show == 'nps_comment') {
		return false; //for nps comment
	} elseif ($show == 'overall_comments') {
		return true; //for overall comment
	} elseif ($show == 'avg_rating') {
		return true; //to show average rating
	} else {
		return false;
	}
}

function nps_detractors_page($show)
{
	if ($show == 'nps_comment') {
		return true; //for show nps comment
	} elseif ($show == 'overall_comments') {
		return true; //for overall comment
	} elseif ($show == 'avg_rating') {
		return true; //to show average rating
	} else {
		return false;
	}
}


function nps_passives_page($show)
{
	if ($show == 'nps_comment') {
		return false; //for nps comment
	} elseif ($show == 'overall_comments') {
		return true; //for overall comment
	} elseif ($show == 'avg_rating') {
		return true; //to show average rating
	} else {
		return false;
	}
}

// to enable/disbale any coloumn in feedback report
function allfeedbacks_page($show)
{
	if ($show == 'nps_comment') {
		return true; //to show nps comment
	} elseif ($show == 'overall_comments') {
		return true; //to show overall comment
	} elseif ($show == 'avg_rating') {
		return true; //to show average rating
	} elseif ($show == 'nps_score') {
		return true; //to show NPS parameter
	} elseif ($show == 'psat_score') {
		return true; //to show psat(satisfied/unsatisfied)
	} elseif ($show == 'feedback_id') {
		return false; //to show feedbackid 
	} else {
		return false;
	}
}


function feedbacks_capa($show)
{
	if ($show == 'nps_comment') {
		return false; //to show nps comment
	} elseif ($show == 'overall_comments') {
		return true; //to show overall comment
	} elseif ($show == 'avg_rating') {
		return true; //to show average score
	} elseif ($show == 'nps_score') {
		return true; //to show NPS score
	} elseif ($show == 'psat_score') {
		return true; //to show psat score 
	} elseif ($show == 'feedback_id') {
		return false; //to show feedbackid 
	} else {
		return false;
	}
}



// to enable/disbale tat feature in IP
function ip_tat($show)
{
	if ($show == 'open_ticket') {
		return false; //to show tat in open ticket page
	} elseif ($show == 'tat_exists') {
		return true; //if tat exists
	} elseif ($show == 'close_ticket') {
		return false; //to show tat in close ticket page
	} elseif ($show == 'admin_link') {
		return false; //to show tat status in admin tracking link
	} elseif ($show == 'department_link') {
		return false; //to show tat status in department head tracking link
	} else {
		return false;
	}
}

//// to enable/disbale tat feature in admission module
function adf_tat($show)
{
	if ($show == 'open_ticket') {
		return false; //to show tat in open ticket page
	} elseif ($show == 'tat_exists') {
		return true; //if tat exists
	} elseif ($show == 'close_ticket') {
		return false; //to show tat in close ticket page
	} elseif ($show == 'admin_link') {
		return false; //to show tat status in admin tracking link
	} elseif ($show == 'department_link') {
		return false; //to show tat status in department head tracking link
	} else {
		return false;
	}
}


// // to enable/disbale tat feature in OP
function op_tat($show)
{
	if ($show == 'open_ticket') {
		return false; //to show tat in open ticket page
	} elseif ($show == 'tat_exists') {
		return true; //if tat exists
	} elseif ($show == 'close_ticket') {
		return false; //to show tat in close ticket page
	} elseif ($show == 'admin_link') {
		return false; //to show tat status in admin tracking link
	} elseif ($show == 'department_link') {
		return false; //to show tat status in department head tracking link
	} else {
		return false;
	}
}


// to enable/disbale tat feature in patient complaints
function int_tat($show)
{
	if ($show == 'open_ticket') {
		return false; //to show tat in open ticket page
	} elseif ($show == 'tat_exists') {
		return true; //if tat exists
	} elseif ($show == 'close_ticket') {
		return false; //to show tat in close ticket page
	} elseif ($show == 'department_link') {
		return false; //to show tat in department head tracking link
	} elseif ($show == 'patient_link') {
		return false; //to show tat in patient tracking link
	} elseif ($show == 'department_rating') {
		return false; //to show star in patient link after the tickect is closed
	} elseif ($show == 'department_information') {
		return false; //to show department head details in patient tracking link
	} else {
		return false;
	}
}

// to enable/disbale tat feature in service request
function isr_tat($show)
{
	if ($show == 'open_ticket') {
		return false; //to show tat in open ticket page
	} elseif ($show == 'tat_exists') {
		return true; //if tat exists
	} elseif ($show == 'close_ticket') {
		return false; //to show tat in close ticket page
	} elseif ($show == 'department_link') {
		return false; //to show tat in department head tracking link
	} elseif ($show == 'employee_link') {
		return false; //to show tat in  employee  tracking link
	} elseif ($show == 'department_information') {
		return false; //to show department head details in employee tracking link
	} else {
		return false;
	}
}


// to enable/disbale tat feature in incident
function incident_tat($show)
{
	if ($show == 'open_ticket') {
		return false; //to show tat in open ticket page
	} elseif ($show == 'tat_exists') {
		return true; //if tat exists 
	} elseif ($show == 'close_ticket') {
		return false; //to show tat in close ticket page
	} elseif ($show == 'department_link') {
		return false; //to show tat in department head tracking link
	} elseif ($show == 'employee_link') {
		return false; //to show tat in employee tracking link
	} elseif ($show == 'department_information') {
		return false; //to show department head details in employee tracking link
	} else {
		return false;
	}
}




// to enable/disbale tat feature in grievance
function grievance_tat($show)
{
	if ($show == 'open_ticket') {
		return false; //to show tat in open ticket page
	} elseif ($show == 'tat_exists') {
		return true; //if tat exists 
	} elseif ($show == 'close_ticket') {
		return false; //to show tat in close ticket page
	} elseif ($show == 'department_link') {
		return false; //to show tat in department head tracking link
	} elseif ($show == 'employee_link') {
		return false; //to show tat in  employee  tracking link
	} elseif ($show == 'department_information') {
		return false; //to show department head details in employee tracking link
	} else {
		return false;
	}
}

//admission module patient bed number condition
function admission_bedno($show)
{
	if ($show == 'dropdown') {
		return false; //if it is true bedno-dropdown, else textbox
	} elseif ($show == 'email') {
		return true; //to show email
	} elseif ($show == 'alternate') {
		return true; //to show alternate email and alternate mobile
	} else {
		return false;
	}
}

function dama($show)
{
	if ($show == 'dama') {
		return true; //show the option for death or dama
	} else {
		return false;
	}
}


// To show address ticket feature
function ticket_addressal($show)
{
	if ($show == 'ip_addressal') {
		return true;
	} elseif ($show == 'op_addressal') {
		return true;
	} elseif ($show == 'pc_addressal') {
		return true;
	} elseif ($show == 'adf_addressal') {
		return true;
	} elseif ($show == 'grievance_addressal') {
		return true;
	} elseif ($show == 'isr_addressal') {
		return true;
	} elseif ($show == 'incident_addressal') {
		return true;
	} else {
		return false;
	}
}

// for sagar hospital while closing the ticket
function close_comment($show)
{
	if ($show == 'ip_close_comment') {
		return false;
	} elseif ($show == 'op_close_comment') {
		return false;
	} elseif ($show == 'pc_close_comment') {
		return false;
	} elseif ($show == 'isr_close_comment') {
		return false;
	} elseif ($show == 'inc_close_comment') {
		return false;
	} elseif ($show == 'sg_close_comment') {
		return false;
	} elseif ($show == 'adf_close_comment') {
		return false;
	} else {
		return false;
	}
}


// function lang_loader($section, $para)
// {
// 	if ($section == 'ip') {
// 		$file = 'assets/lang/' . $section . '_lang.csv';
// 	} elseif ($section == 'op') {
// 		$file = 'assets/lang/' . $section . '_lang.csv';
// 	} elseif ($section == 'adf') {
// 		$file = 'assets/lang/' . $section . '_lang.csv';
// 	} elseif ($section == 'pcf') {
// 		$file = 'assets/lang/' . $section . '_lang.csv';
// 	} elseif ($section == 'isr') {
// 		$file = 'assets/lang/' . $section . '_lang.csv';
// 	} elseif ($section == 'inc') {
// 		$file = 'assets/lang/' . $section . '_lang.csv';
// 	} elseif ($section == 'sg') {
// 		$file = 'assets/lang/' . $section . '_lang.csv';
// 	}elseif ($section == 'global') {
// 		$file = 'assets/lang/' . $section . '_lang.csv';
// 	} else {
// 		return $para;
// 	}

// 	$filename = $file;

// 	// Open the file
// 	$handle = fopen($filename, "r");

// 	// Initialize an empty array
// 	$array = [];
// 	$valueText  = null;
// 	// Check if the file is opened successfully
// 	if ($handle !== FALSE) {
// 		// Loop through each line of the file
// 		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
// 			// Assuming there are only two columns per row
// 			$key = trim($data[0]);
// 			$value = $data[1];
// 			if ($para === $key) {
// 				$valueText = $value;
// 			}
// 			// Add to the associative array

// 		}
// 		// Close the file
// 		fclose($handle);
// 	}

// 	// Print the array

// 	if ($valueText !== null) {
// 		return $valueText;
// 	} else {
// 		return $para;
// 	}
// }

function lang_loader($section, $para)
{

    // Create a unique session key for the section
    $sessionKey = "lang_cache_" . $section;

    // Check if the section is already in the session
    if (!isset($_SESSION[$sessionKey])) {
        $file = 'assets/lang/' . $section . '_lang.csv';

        // Check if the file exists before trying to open it
        if (!file_exists($file)) {
            return $para;
        }

        // Open the file and load language values into the session
        $handle = fopen($file, "r");
        $langData = [];

        if ($handle !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $key = trim($data[0]);
                $value = $data[1];
                $langData[$key] = $value;
            }
            fclose($handle);
        }

        // Store the language data in the session
        $_SESSION[$sessionKey] = $langData;
    }

    // Retrieve the language value from the session
    $langData = $_SESSION[$sessionKey];

    // Return the corresponding value or the original parameter if not found
    return isset($langData[$para]) ? $langData[$para] : $para;
}