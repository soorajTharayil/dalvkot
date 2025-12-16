<?php
include('db.php');

$patient_id = $_GET['patient_id'];
$d = file_get_contents('php://input');

$data = json_decode($d, true);

if (count($data) > 1) {
    date_default_timezone_set('Asia/Kolkata');
    $data['name'] = strtoupper($data['name']);
    $today = date('Y-m-d');

    $name = $data['name'];
    $location = $data['location'];
    $email = $data['email'];
    $contactnumber = $data['contactnumber'];

    // Create an associative array with the fields to be consolidated

    $dataset = ['checklist' => $data['checklist']];

    switch ($data['checklist']) {
        case 'Code Red':
            $dataset['initial_assessment_hr1'] = $data['initial_assessment_hr1'];
            $dataset['initial_assessment_hr2'] = $data['initial_assessment_hr2'];
            $dataset['number_of_code'] = $data['number_of_code'];
            $dataset['initial_assessment_hr3'] = $data['initial_assessment_hr3'];
            $dataset['respondents'] = $data['respondents'];
            $dataset['situation'] = $data['situation'];
            $dataset['fire'] = $data['fire'];
            $dataset['demonstrated'] = $data['demonstrated'];
            $dataset['lift'] = $data['lift'];
            $dataset['doors'] = $data['doors'];
            $dataset['safety'] = $data['safety'];
            $dataset['transportation'] = $data['transportation'];
            $dataset['action'] = $data['action'];
            $dataset['assembly_point'] = $data['assembly_point'];
            $dataset['follow_up'] = $data['follow_up'];
            $dataset['initial_assessment_hr4'] = $data['initial_assessment_hr4'];
            $dataset['deviations'] = $data['deviations'];
            $dataset['debrief'] = $data['debrief'];
            $dataset['initial_assessment_hr5'] = $data['initial_assessment_hr5'];
            $dataset['comments'] = $data['dataAnalysis'];
            break;
        case 'Code Pink':
            $dataset['initial_assessment_hr1'] = $data['initial_assessment_hr1'];
            $dataset['initial_assessment_hr2'] = $data['initial_assessment_hr2'];
            $dataset['number_of_code'] = $data['number_of_code'];
            $dataset['child_announce'] = $data['child_announce'];
            $dataset['code_pink_team'] = $data['code_pink_team'];
            $dataset['exit_points'] = $data['exit_points'];
            $dataset['security_guard'] = $data['security_guard'];
            $dataset['counseling_to_mother'] = $data['counseling_to_mother'];
            $dataset['searched'] = $data['searched'];
            $dataset['suspicious'] = $data['suspicious'];
            $dataset['cctv'] = $data['cctv'];
            $dataset['handing'] = $data['handing'];
            $dataset['events'] = $data['events'];
            $dataset['initial_assessment_hr4'] = $data['initial_assessment_hr4'];
            $dataset['deviations'] = $data['deviations'];
            $dataset['debrief_p'] = $data['debrief_p'];
            $dataset['initial_assessment_hr5'] = $data['initial_assessment_hr5'];
            $dataset['comments'] = $data['dataAnalysis'];
            break;
        case 'Code Blue':
            $dataset['initial_assessment_hr1'] = $data['initial_assessment_hr1'];
            $dataset['initial_assessment_hr2'] = $data['initial_assessment_hr2'];
            $dataset['number_of_code'] = $data['number_of_code'];
            $dataset['initial_assessment_hr3'] = $data['initial_assessment_hr3'];
            $dataset['respondents'] = $data['respondents'];
            $dataset['emergency'] = $data['emergency'];
            $dataset['identified'] = $data['identified'];
            $dataset['response'] = $data['response'];
            $dataset['circulation'] = $data['circulation'];
            $dataset['airway'] = $data['airway'];
            $dataset['breathing'] = $data['breathing'];
            $dataset['cpr'] = $data['cpr'];
            $dataset['compressions'] = $data['compressions'];
            $dataset['rescue'] = $data['rescue'];
            $dataset['mode'] = $data['mode'];
            $dataset['safety_measure'] = $data['safety_measure'];
            $dataset['lift_avail'] = $data['lift_avail'];
            $dataset['shift_ccu'] = $data['shift_ccu'];
            $dataset['initial_assessment_hr4'] = $data['initial_assessment_hr4'];
            $dataset['medical'] = $data['medical'];
            $dataset['adequate'] = $data['adequate'];
            $dataset['condition'] = $data['condition'];
            $dataset['shock'] = $data['shock'];
            $dataset['deviations_c'] = $data['deviations_c'];
            $dataset['repetition'] = $data['repetition'];
            $dataset['debriefed'] = $data['debriefed'];
            $dataset['initial_assessment_hr5'] = $data['initial_assessment_hr5'];
            $dataset['comments'] = $data['dataAnalysis'];
            break;

    }


    // Convert the associative array to a JSON string
    $dataset_json = json_encode($dataset);

    // Insert the JSON string into the 'dataset' column
    $query = 'INSERT INTO `bf_feedback_code_originals` (`name`,`location`,`mobile`,`email`,`datetime`,`datet`,`dataset`) 
    VALUES ("' . $name . '","' . $location . '","' . $contactnumber . '","' . $email . '","' . date('Y-m-d H:i:s') . '","' . $today . '","' . mysqli_real_escape_string($con, $dataset_json) . '")';

    $result = mysqli_query($con, $query);
    $fid = mysqli_insert_id($con);

    $response['status'] = 'success';
    $response['message'] = 'Data saved successfully';

    echo json_encode($response);

    mysqli_close($con);
}

// TRIGGER CURL.php
$curl = curl_init();
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_URL, $baseurl . 'api/curl.php');
curl_exec($curl);
