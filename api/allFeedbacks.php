<?php
// Include database connection
include "db.php";

// Get the JSON input and convert it to a PHP object
$input = file_get_contents("php://input");
$data = json_decode($input, true);

// Initialize the response
$response = [];

// Check if 'module' and 'section' are provided
if (isset($data["module"]) && isset($data["section"])) {
    // Handle IP and OP feedback
    if ($data["module"] == "IP") {
        // Query for IP: retrieve patientname, id, floor, and bednumber
        $query = "SELECT patientname, id, floor, bednumber, date FROM bf_feedback WHERE section = '{$data['section']}'";
        $result = mysqli_query($con, $query);

        if ($result) {
            $feedbackData = [];
            while ($row = mysqli_fetch_assoc($result)) {
                // Collect the specific fields for IP
                $feedbackData[] = [
                    'patientname' => $row['patientname'],
                    'id' => $row['id'],
                    'floor' => $row['floor'],
                    'bednumber' => $row['bednumber'],
                    'date' => $row['date']
                ];
            }
            $response = [
                "feedback" => $feedbackData
            ];
        } else {
            $response = [
                "error" => true,
                "message" => "Database query failed for IP feedback"
            ];
        }
    } elseif ($data["module"] == "OP") {
        // Query for OP: retrieve patientname, id, and department
        $query = "SELECT patientname, id, department, date FROM bf_feedback WHERE section = '{$data['section']}'";
        $result = mysqli_query($con, $query);

        if ($result) {
            $feedbackData = [];
            while ($row = mysqli_fetch_assoc($result)) {
                // Collect the specific fields for OP
                $feedbackData[] = [
                    'patientname' => $row['patientname'],
                    'id' => $row['id'],
                    'department' => $row['department'],
                    'date' => $row['date']
                ];
            }
            $response = [
                "feedback" => $feedbackData
            ];
        } else {
            $response = [
                "error" => true,
                "message" => "Database query failed for OP feedback"
            ];
        }
    } else {
        $response = [
            "error" => true,
            "message" => "Invalid module specified"
        ];
    }
} else {
    $response = [
        "error" => true,
        "message" => "Module or section not provided"
    ];
}

// Set the content type to JSON and return the response
header("Content-Type: application/json");
echo json_encode($response);

// Close the database connection
mysqli_close($con);
