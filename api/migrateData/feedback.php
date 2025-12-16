<?php
include("../../env.php");

// Connect to your database
$servername = $config_set['DBHOST'];
$username = $config_set['DBUSER'];
$password = $config_set['DBPASSWORD'];
$dbname = $config_set['DBNAME'];

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the parameter 'type' is set in the GET request
if (isset($_GET['type'])) {
    $type = $_GET['type'];
    $startId = $_GET['id'];

    // Define your SQL query based on the 'type' parameter
    switch ($type) {
        case 'IP':
            $table = "bf_feedback";
            $ticket_table = "tickets";
            break;
        case 'OP':
            $table = "bf_outfeedback";
            $ticket_table = "ticketsop";
            break;
        case 'INT':
            $table = "bf_feedback_int";
            break;
        case 'ISR':
            $table = "bf_feedback_esr";
            break;
        case 'INCIDENT':
            $table = "bf_feedback_incident";
            break;
        case 'GRIEVANCE':
            $table = "bf_feedback_grievance";
            break;
            // Add more cases for other types if needed
        default:
            $table = ""; // Handle the case if 'type' is not recognized
    }

    if (!empty($table)) {
        // Query to get data from the specified table where ID > 12
        $sql = "SELECT * FROM $table WHERE id > $startId  LIMIT 10";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Fetch data and encode it in JSON format
            $data = array();
            while ($row = $result->fetch_assoc()) {
                $feedbackId = $row['id'];
                $sql = "SELECT * FROM $ticket_table WHERE feedbackid = $feedbackId";
                $tickets =  $conn->query($sql);
                $ticketArray = [];
                while ($t = $tickets->fetch_assoc()) {
                    $ticketArray[] = $t;
                }
                $row['tickets'] = $ticketArray;
                $data[] = $row;
            }
            echo json_encode($data);
        } else {
            // If no data found, send empty JSON array
            echo json_encode(array());
        }
    } else {
        // Handle the case if 'type' is not recognized
        echo "Invalid type parameter";
    }
} else {
    // Handle the case if 'type' parameter is not set
    echo "Type parameter is missing";
}

// Close the database connection
$conn->close();
