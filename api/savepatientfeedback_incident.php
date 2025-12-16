<?php
include('db.php');

$patinet_id = $_GET['patient_id'];
$d = file_get_contents('php://input');

$data = json_decode($d, true);

if (count($data) > 1) {




    date_default_timezone_set('Asia/Kolkata');
    $data['section'] = 'INCIDENT';
    $bed = $data['bedno'];
    $ward = $data['ward'];
    $sql = 'SELECT * FROM `bf_ward_esr` WHERE title="' . $ward . '"';
    $ward = mysqli_query($con, $sql);
    $wardd = mysqli_fetch_object($ward);


    $data['name'] = strtoupper($data['name']);
    $today = date('Y-m-d');
    //$query = 'SELECT * FROM  `patients_from_admission` WHERE  mobile="' . $data['contactnumber'] . '"';
    // $query = 'SELECT * FROM  `bf_employees_incident` WHERE  mobile="' . $data['contactnumber'] . '"';
    // $res = mysqli_query($con, $query);
    //if ($res->num_rows == 0) {
    $query = 'INSERT INTO `bf_employees_incident` (`guid`, `name`, `patient_id`, `mobile`, `email`,`admited_date`,`ward`,`bed_no`) VALUES ("' . time() . '","' . $data['name'] . '","' . $data['patientid'] . '","' . $data['contactnumber'] . '","' . $data['email'] . '","' . date('Y-m-d H:i:s') . '","' . $wardd->title . '","' . $bed . '")';
    $result = mysqli_query($con, $query);
    $rid = mysqli_insert_id($con);
    // } else {
    //     $patient_detail = mysqli_fetch_object($res);

    //     //$query = 'UPDATE `bf_employees_incident` SET discharged_date= "' . date('Y-m-d H:i:s') . '"   WHERE  patient_id="' . $data['patientid'] . '"';
    //     //mysqli_query($con, $query);
    //     $rid = $patient_detail->id; 
    // }
    $patinet_id = $data['patientid'];
    $query = 'SELECT * FROM  `bf_feedback_incident` WHERE  patientid="' . $patinet_id . '"';
    $res = mysqli_query($con, $query);
    if (mysqli_fetch_object($res)) {
        /*$response['status'] = 'fail';
        $response['message'] = 'Data was already submitted for this patient';
        echo json_encode($response);
        exit;*/
    }
    $query = 'SELECT * FROM  `setup_incident` WHERE 1';

    $overall = mysqli_query($con, $query);
    $prcount = 0;
    $overalltotal = 0;
    while ($pr = mysqli_fetch_object($overall)) {

        if ($data[$pr->shortkey] >= 1) {
            $overalltotal += $data[$pr->shortkey];
            $prcount++;
        } else {
            $data[$pr->shortkey] = '';
        }
    }

    if ($prcount == 0) {
        $data['overallScore'] = '';
    } else {
        $data['overallScore'] = round($overalltotal / $prcount);
    }
    if (isset($data['source']) && $data['source'] == 'WLink') {
        $source = 'Link';
    } elseif (isset($data['source']) && $data['source'] != 'WLink') {
        $source = $data['source'];
    } else {
        $source = 'APP';
    }


    $bed = $data['bedno'];
    $image = $data['image'];
    $file = $data['file'];
    $ward = $data['ward'];
    $priority = $data['priority'];
    $incident_type = $data['incident_type'];
    $sql = 'SELECT * FROM `bf_ward_esr` WHERE title="' . $ward . '"';
    $ward = mysqli_query($con, $sql);
    $wardd = mysqli_fetch_object($ward);



  $query = 'INSERT INTO `bf_feedback_incident`(`datetime`,`datet`,`remarks`, `nurseid`, `patientid`, `dataset`, `source`,`ward`,`bed_no`,`pid`,`image`,`file`) 
  VALUES ("' . date('Y-m-d H:i:s') . '","' . $today . '","' . $data['remarks'] . '","' . $_GET['administratorId'] . '","' . $patinet_id . '","' . mysqli_real_escape_string($con, json_encode($data)) . '","' . $source . '","' . $wardd->title . '","' . $bed . '","' . $rid . '","' . $image . '","' . $file . '")';


    $result = mysqli_query($con, $query);
    $fid = mysqli_insert_id($con);

    $query = 'SELECT * FROM department WHERE type ="incident"';
    $result = mysqli_query($con, $query);
    while ($r = mysqli_fetch_object($result)) {
        //print_r($r); 
        //print_r($data['parameter']);

        // foreach ($data['parameter']['question'] as $key => $value) {
        //     if ($r->slug == $value['shortkey']) {
        //         //var_dump($value);
        //         if ($value['valuetext'] == true) {
        //             $query = 'INSERT INTO `tickets_incident`(`created_by`, `departmentid`, `rating`, `anymessage`, `feedbackid`) VALUES ("' . $patinet_id . '","' . $r->dprt_id . '","1","' . $data['other'] . '","' . $fid . '")';
        //             mysqli_query($con, $query);
        //         }
        //     }
        // }

        foreach ($data['reason'] as $key => $value) {
            if ($r->slug == $key) {
                //var_dump($value);
                if ($value == true) {
                    $query = 'INSERT INTO `tickets_incident` (`created_by`, `departmentid`, `rating`, `anymessage`, `feedbackid`,`ward`,`priority`,`incident_type`) VALUES ("' . $patinet_id . '","' . $r->dprt_id . '","' . $value . '","' . $data['comments'] . '","' . $fid . '","' . $wardd->title . '","' . $priority . '","' . $incident_type . '")';                    mysqli_query($con, $query);
                }
            }
        }
    }
    $response['status'] = 'success';
    $response['message'] = 'Data saved sucessfully';

    echo json_encode($response);

    mysqli_close($con);
}


// $curl = curl_init();
// curl_setopt($curl, CURLOPT_URL, $baseurl . 'messages/alertfeedback_int.php');
// $result = curl_exec($curl);


// $curl = curl_init();
// curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
// curl_setopt($curl, CURLOPT_URL, $baseurl . 'PHPMailer/mail_interim.php');
// $result = curl_exec($curl);


//TRIGGER CURL.php
$curl = curl_init();
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_URL, $baseurl . 'api/curl.php');
curl_exec($curl);
