<?php
include('db.php');

date_default_timezone_set('Asia/Kolkata');

$patinet_id = $_GET['patient_id'] ?? null;
$administratorId = $_GET['administratorId'] ?? null;

$d = file_get_contents('php://input');
$data = json_decode($d, true);

if (!is_array($data) || count($data) < 1) {
    echo json_encode(['status' => 'fail', 'message' => 'Invalid payload']);
    exit;
}

/* ---------------- SAFE RISK MATRIX ---------------- */
$risk_matrix = null;
if (isset($data['risk_matrix']['level'])) {
    $risk_matrix = $data['risk_matrix']['level'];
}

/* ---------------- SAFE INCIDENT DATE ---------------- */
$incident_occured_in = null;
if (!empty($data['incident_occured_in'])) {
    try {
        $dt = new DateTime($data['incident_occured_in'], new DateTimeZone('UTC'));
        $dt->setTimezone(new DateTimeZone('Asia/Kolkata'));
        $incident_occured_in = $dt->format('d M, Y - g:i A');
    } catch (Exception $e) {
        $incident_occured_in = null;
    }
}

/* ---------------- BASIC DATA ---------------- */
$data['section'] = 'INCIDENT';
$data['name'] = strtoupper($data['name'] ?? '');

$bed  = $data['bedno'] ?? '';
$ward = $data['ward'] ?? '';

/* ---------------- GET WARD ---------------- */
$wardd = null;
$wq = mysqli_query($con, 'SELECT * FROM bf_ward_esr WHERE title="' . mysqli_real_escape_string($con, $ward) . '"');
if ($wq) {
    $wardd = mysqli_fetch_object($wq);
}

/* ---------------- INSERT EMPLOYEE INCIDENT ---------------- */
$query = '
INSERT INTO bf_employees_incident
(`guid`,`name`,`patient_id`,`mobile`,`email`,`admited_date`,`ward`,`bed_no`)
VALUES (
"' . time() . '",
"' . mysqli_real_escape_string($con, $data['name']) . '",
"' . mysqli_real_escape_string($con, $data['patientid']) . '",
"' . mysqli_real_escape_string($con, $data['contactnumber']) . '",
"' . mysqli_real_escape_string($con, $data['email']) . '",
"' . date('Y-m-d H:i:s') . '",
"' . ($wardd->title ?? '') . '",
"' . mysqli_real_escape_string($con, $bed) . '"
)';

mysqli_query($con, $query);
$rid = mysqli_insert_id($con);

/* ---------------- CALCULATE OVERALL SCORE ---------------- */
$overall = mysqli_query($con, 'SELECT * FROM setup_incident');
$prcount = 0;
$overalltotal = 0;

while ($pr = mysqli_fetch_object($overall)) {
    if (isset($data[$pr->shortkey]) && $data[$pr->shortkey] >= 1) {
        $overalltotal += $data[$pr->shortkey];
        $prcount++;
    } else {
        $data[$pr->shortkey] = '';
    }
}

$data['overallScore'] = ($prcount > 0) ? round($overalltotal / $prcount) : '';

/* ---------------- SOURCE ---------------- */
if (($data['source'] ?? '') === 'WLink') {
    $source = 'Link';
} elseif (!empty($data['source'])) {
    $source = $data['source'];
} else {
    $source = 'APP';
}

/* ---------------- FILES ---------------- */
$image = $data['image'] ?? '';
$files_name = mysqli_real_escape_string($con, json_encode($data['files_name'] ?? []));

/* ---------------- INSERT FEEDBACK ---------------- */
$dataset = mysqli_real_escape_string($con, json_encode($data));
$today = date('Y-m-d');

$query = '
INSERT INTO bf_feedback_incident
(`datetime`,`datet`,`remarks`,`nurseid`,`patientid`,`dataset`,`source`,`ward`,`bed_no`,`pid`,`image`,`file`)
VALUES (
"' . date('Y-m-d H:i:s') . '",
"' . $today . '",
"' . mysqli_real_escape_string($con, $data['remarks'] ?? '') . '",
"' . mysqli_real_escape_string($con, $administratorId) . '",
"' . mysqli_real_escape_string($con, $data['patientid']) . '",
"' . $dataset . '",
"' . $source . '",
"' . ($wardd->title ?? '') . '",
"' . mysqli_real_escape_string($con, $bed) . '",
"' . $rid . '",
"' . mysqli_real_escape_string($con, $image) . '",
"' . $files_name . '"
)';

$result = mysqli_query($con, $query);

if (!$result) {
    echo json_encode([
        'status' => 'fail',
        'sql_error' => mysqli_error($con),
        'query' => $query
    ]);
    exit;
}

$fid = mysqli_insert_id($con);

/* ---------------- CREATE TICKETS ---------------- */
$priority = trim(str_replace('–', '-', $data['priority'] ?? ''));
$incident_type = $data['incident_type'] ?? '';

$dept = mysqli_query($con, 'SELECT * FROM department WHERE type="incident"');

while ($r = mysqli_fetch_object($dept)) {
    foreach (($data['reason'] ?? []) as $key => $value) {
        if ($r->slug === $key && $value == true) {
            $tq = '
            INSERT INTO tickets_incident
            (`created_by`,`departmentid`,`rating`,`anymessage`,`feedbackid`,`ward`,`priority`,`incident_type`,`assigned_risk`,`incident_occured_in`)
            VALUES (
            "' . mysqli_real_escape_string($con, $data['patientid']) . '",
            "' . $r->dprt_id . '",
            "1",
            "' . mysqli_real_escape_string($con, $data['comments'] ?? '') . '",
            "' . $fid . '",
            "' . ($wardd->title ?? '') . '",
            "' . mysqli_real_escape_string($con, $priority) . '",
            "' . mysqli_real_escape_string($con, $incident_type) . '",
            "' . mysqli_real_escape_string($con, $risk_matrix) . '",
            "' . mysqli_real_escape_string($con, $incident_occured_in) . '"
            )';
            mysqli_query($con, $tq);
        }
    }
}

/* ---------------- SUCCESS RESPONSE ---------------- */
echo json_encode([
    'status' => 'success',
    'message' => 'Data saved successfully',
    'feedback_id' => $fid
]);

mysqli_close($con);

/* ---------------- TRIGGER CRON ---------------- */
$curl = curl_init();
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_URL, $baseurl . 'api/curl.php');
curl_exec($curl);
curl_close($curl);
