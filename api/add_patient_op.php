<?php
include("../env.php");
header('content-type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: *');
$db['hostname'] = $config_set['DBHOST'];
$db['username'] = $config_set['DBUSER'];
$db['password'] = $config_set['DBPASSWORD'];
$db['database'] = $config_set['DBNAME'];
// Database connection



$conn = new mysqli($db['hostname'], $db['username'], $db['password'], $db['database']);
if ($conn->connect_error) {
    die(json_encode(['status' => false, 'message' => 'Database connection failed']));
}

// Token validation
$headers = getallheaders();
$valid_token = 'b2a5e7c9d3f1428c8f57a3e91a6f4f123op';
if (!isset($headers['Token']) || $headers['Token'] !==  $valid_token) {
    echo json_encode(['status' => false, 'message' => 'Unauthorized access']);
    exit;
}

// Get input data
$data = json_decode(file_get_contents('php://input'), true);
file_put_contents("debug.txt", print_r($data, true)); // Write input to file for inspection

// Debug: Print request data in readable format

// Debug: Print request data

// Validate input
 $errors = [];
 if (empty($data['name']) || strlen($data['name']) > 250) {
     $errors[] = 'First Name is required and should not exceed 250 characters.';
 }
 if (empty($data['patient_id'])) {
     $errors[] = 'Patient ID is required.';
 }
 if (empty($data['mobile']) || !is_numeric($data['mobile'])) {
     $errors[] = 'Valid Mobile number is required.';
 }
 if (!empty($errors)) {
     echo json_encode(['status' => false, 'message' => $errors]);
     exit;
 }

$id = isset($data['id']) ? $data['id'] : null;
$patient_id = $data['patient_id'];
$mobile = $data['mobile'];
$error = false;

// Check for duplicates if creating new patient
if (!$id) {
    $check_patient_id = $conn->prepare("SELECT * FROM patients_from_admission_op WHERE patient_id = ?");
    if ($check_patient_id === false) {
        die(json_encode(['status' => false, 'message' => 'Prepare failed: ' . $conn->error]));
    }
    $check_patient_id->bind_param('s', $patient_id);
    $check_patient_id->execute();
    $result = $check_patient_id->get_result();
    if ($result->num_rows > 0) {
        echo json_encode(['status' => false, 'message' => 'Duplicate Patient ID']);
        exit;
    }

    $check_mobile = $conn->prepare("SELECT * FROM patients_from_admission_op WHERE mobile = ?");
    if ($check_mobile === false) {
        die(json_encode(['status' => false, 'message' => 'Prepare failed: ' . $conn->error]));
    }
    $check_mobile->bind_param('s', $mobile);
    $check_mobile->execute();
    $result = $check_mobile->get_result();
    if ($result->num_rows > 0) {
        echo json_encode(['status' => false, 'message' => 'Duplicate Mobile Number']);
        exit;
    }

    $check_both = $conn->prepare("SELECT * FROM patients_from_admission_op WHERE patient_id = ? AND mobile = ?");
    if ($check_both === false) {
        die(json_encode(['status' => false, 'message' => 'Prepare failed: ' . $conn->error]));
    }
    $check_both->bind_param('ss', $patient_id, $mobile);
    $check_both->execute();
    $result = $check_both->get_result();
    if ($result->num_rows > 0) {
        echo json_encode(['status' => false, 'message' => 'Duplicate Patient ID and Mobile Number']);
        exit;
    }
}

// Prepare data for insert/update
$name = $data['name'];
$hospital_id = isset($data['hospital_id']) ? $data['hospital_id'] : null;
$email = isset($data['email']) ? $data['email'] : null;
$gender = isset($data['gender']) ? $data['gender'] : null;
$age = isset($data['age']) ? $data['age'] : null;
$admitedfor = isset($data['admitedfor']) ? $data['admitedfor'] : null;
$ward = isset($data['ward']) ? $data['ward'] : null;
$consultant = isset($data['consultant']) ? $data['consultant'] : null;
$bed_no = isset($data['bed_no']) ? $data['bed_no'] : null;
$admited_date = isset($data['admited_date']) ? date('Y-m-d H:i', strtotime($data['admited_date'])) : date('Y-m-d H:i');
$discharged_date = isset($data['discharged_date']) ? date('Y-m-d H:i', strtotime($data['discharged_date'])) : null;

if (!$id) {
    // Insert new patient
    $stmt = $conn->prepare("INSERT INTO patients_from_admission_op (name, hospital_id, email, mobile, patient_id, gender, age, admitedfor, ward, consultant, bed_no, admited_date, discharged_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        die(json_encode(['status' => false, 'message' => 'Prepare failed: ' . $conn->error]));
    }
    $stmt->bind_param('sssssssssssss', $name, $hospital_id, $email, $mobile, $patient_id, $gender, $age, $admitedfor, $ward, $consultant, $bed_no, $admited_date, $discharged_date);

    if ($stmt->execute()) {
        echo json_encode(['status' => true, 'message' => 'Patient created successfully']);
    } else {
        echo json_encode(['status' => false, 'message' => 'Failed to create patient, please try again']);
    }
} else {
    // Update existing patient
    $stmt = $conn->prepare("UPDATE patients_from_admission_op SET name = ?, hospital_id = ?, email = ?, mobile = ?, patient_id = ?, gender = ?, age = ?, admitedfor = ?, ward = ?, consultant = ?, bed_no = ?, admited_date = ?, discharged_date = ? WHERE id = ?");
    if ($stmt === false) {
        die(json_encode(['status' => false, 'message' => 'Prepare failed: ' . $conn->error]));
    }
    $stmt->bind_param('sssssssssssssi', $name, $hospital_id, $email, $mobile, $patient_id, $gender, $age, $admitedfor, $ward, $consultant, $bed_no, $admited_date, $discharged_date, $id);

    if ($stmt->execute()) {
        echo json_encode(['status' => true, 'message' => 'Patient updated successfully']);
    } else {
        echo json_encode(['status' => false, 'message' => 'Failed to update patient, please try again']);
    }
}

$conn->close();
?>
