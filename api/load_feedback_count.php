<?php
// Include database connection
include "db.php";

// Get the JSON input and convert it to a PHP object
$input = file_get_contents("php://input");
$data = json_decode($input, true);

// Initialize the response
$response = [];

// Check if 'module' is provided
if (isset($data["module"])) {
    // Handle IP feedback count
    if ($data["module"] == "IP") {
        $query = "SELECT COUNT(*) as totalIPFeedback FROM bf_feedback";
        $result = mysqli_query($con, $query);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $response = [
                "totalIPFeedback" => $row["totalIPFeedback"],
            ];
        } else {
            $response = [
                "error" => true,
                "message" => "Database query failed for IP",
            ];
        }
    }
    // Handle OP feedback count
    elseif ($data["module"] == "OP") {
        $query = "SELECT COUNT(*) as totalOPFeedback FROM bf_outfeedback";
        $result = mysqli_query($con, $query);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $response = [
                "totalOPFeedback" => $row["totalOPFeedback"],
            ];
        } else {
            $response = [
                "error" => true,
                "message" => "Database query failed for OP",
            ];
        }
    }
    // If module is invalid
    else {
        $response = [
            "error" => true,
            "message" => "Invalid module specified",
        ];
    }
} else {
    // If no module is provided
    $response = [
        "error" => true,
        "message" => "Module not provided",
    ];
}

// Set the content type to JSON and return the response
header("Content-Type: application/json");
echo json_encode($response);

// Close the database connection
mysqli_close($con);
?>
