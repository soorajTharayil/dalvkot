<?php
//date_default_timezone_set("Asia/Calcutta");
// echo "The time is " . date("h:i:sa");
//exit;
$host = "localhost";
$username = "myapp_user";
$password = "strong_password";
$dbname = "myapp_db";

// Create a new PDO instance for database connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}




// Fetch pending notifications
$time = date("Y-m-d H:i:s");
$query = "SELECT * FROM whatsapp_escalation 
          WHERE status = 'pending' AND sheduled_at <= :currentTime 
          ORDER BY sheduled_at ASC LIMIT 1";
// Prepare the query
$stmt = $pdo->prepare($query);
$stmt->execute([':currentTime' => $time]);

$notifications_object = $stmt->fetchAll(PDO::FETCH_ASSOC);
print_r($notifications_object);
// Check if any pending notifications exist
foreach ($notifications_object as $notification) {
    echo '1';
    $meta = json_decode($notification['meta']); // Decode the meta column

    // Construct the URL for status check
    echo $urlstatus = $meta->config_set_url . '/api/ticket_status.php?ticket_id=' . $meta->ticket->id . '&section=' . $meta->ticket->type;

    // Initialize cURL for status check
    $curl_handle = curl_init();
    curl_setopt($curl_handle, CURLOPT_URL, $urlstatus);
    curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
    $response_status = curl_exec($curl_handle);
    curl_close($curl_handle);

    // Set message status based on response
    var_dump($response_status);

    if ($response_status === 'OPEN' || $response_status === 'ADDRESSED') {

        echo '2';


        echo '3';

        // Prepare data for the API
        $data = [
            "apiKey" => "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjY3MDk4YzlhYWQyNWMwMGJhNTc3ZDMyZCIsIm5hbWUiOiJJVEFUT05FIFBPSU5UIENPTlNVTFRJTkcgTExQIDczNDUiLCJhcHBOYW1lIjoiQWlTZW5zeSIsImNsaWVudElkIjoiNjcwOThjOWFhZDI1YzAwYmE1NzdkMzFlIiwiYWN0aXZlUGxhbiI6IkJBU0lDX01PTlRITFkiLCJpYXQiOjE3Mjg2NzkwNjZ9.W8HYV-9uRaI8-wEb5rvqV-6pL0npe4RGlXAllPRsZPs",  // Your API key
            "campaignName" => $notification['campaignName'],
            "destination" => $notification['destination'],
            "userName" => $notification['userName'],
            "templateParams" => json_decode($notification['templateParams'], true),
            "source" => $notification['source'],
            "media" => json_decode($notification['media'], true),
            "buttons" => json_decode($notification['buttons'], true),
            "carouselCards" => json_decode($notification['carouselCards'], true),
            "location" => json_decode($notification['location'], true),
            "paramsFallbackValue" => json_decode($notification['paramsFallbackValue'], true)
        ];

        // Define the API endpoint
        $url = 'https://backend.aisensy.com/campaign/t1/api/v2';

        // Initialize cURL session
        $ch = curl_init($url);

        // Set cURL options
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        // Execute the cURL request
        $response = json_decode(curl_exec($ch));
        
        // Check for cURL errors
        if ($response->success === false) {
            echo '5';

            // Update status to 'failed'
            $updateQuery = "UPDATE whatsapp_escalation SET status = 'failed', updated_at = NOW() WHERE id = :id";
            $updateStmt = $pdo->prepare($updateQuery);
            $updateStmt->execute([':id' => $notification['id']]);
            echo 'cURL Error: ' . curl_error($ch);
        } else {
            // Get the HTTP response code
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            if ($httpCode >= 200 && $httpCode < 300) {
                // Successful response, update status to 'sent'
                $updateQuery = "UPDATE whatsapp_escalation SET status = 'sent', updated_at = NOW() WHERE id = :id";
                $updateStmt = $pdo->prepare($updateQuery);
                $updateStmt->execute([':id' => $notification['id']]);
                echo "Notification sent successfully.";
            } else {
                echo '6';

                // HTTP error, update status to 'failed'
                $updateQuery = "UPDATE whatsapp_escalation SET status = 'failed', updated_at = NOW() WHERE id = :id";
                $updateStmt = $pdo->prepare($updateQuery);
                $updateStmt->execute([':id' => $notification['id']]);
                echo "HTTP Error: " . $httpCode;
            }
        }

        // Close the cURL session
        curl_close($ch);
    } else {
        echo '4';

        // HTTP error, update status to 'failed'
        $updateQuery = "UPDATE whatsapp_escalation SET status = 'failed', updated_at = NOW() WHERE id = :id";
        $updateStmt = $pdo->prepare($updateQuery);
        $updateStmt->execute([':id' => $notification['id']]);
        echo "HTTP Error: " . $httpCode;
    }
}


// Close the database connection
$pdo = null;
