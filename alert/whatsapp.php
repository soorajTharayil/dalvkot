<?php
date_default_timezone_set("Asia/Calcutta");

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
$query = "SELECT * FROM notifications_whatsapp WHERE status = 'pending' LIMIT 1";
$stmt = $pdo->prepare($query);
$stmt->execute();

// Check if any pending notification exists
if ($notification = $stmt->fetch(PDO::FETCH_ASSOC)) {

    // Prepare data for the API
    $data = [
        "apiKey" => "6hASavMbFsYyz112baQsQB5s7oAV82tFMV6lWSQhEWA43Ain1P4TteszKTUJ",  // Your API key
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
    $url = 'https://api.tellephant.com/v1/send-message';

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
    $response = curl_exec($ch);

    // Check for cURL errors
    if (curl_errno($ch)) {
        // Update status to 'failed'
        $updateQuery = "UPDATE notifications_whatsapp SET status = 'failed', updated_at = NOW() WHERE id = :id";
        $updateStmt = $pdo->prepare($updateQuery);
        $updateStmt->execute([':id' => $notification['id']]);
        echo 'cURL Error: ' . curl_error($ch);
    } else {
        // Get the HTTP response code
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($httpCode >= 200 && $httpCode < 300) {
            // Successful response, update status to 'sent'
            $updateQuery = "UPDATE notifications_whatsapp SET status = 'sent', updated_at = NOW() WHERE id = :id";
            $updateStmt = $pdo->prepare($updateQuery);
            $updateStmt->execute([':id' => $notification['id']]);

            $updateQuery = "UPDATE notifications_whatsapp 
            SET status = 'duplicate', updated_at = NOW() 
            WHERE destination = :destination AND meta = :meta AND status = 'pending'";

            $updateStmt = $pdo->prepare($updateQuery);

            $updateStmt->execute([
                ':destination' => $notification['destination'],
                ':meta' => $notification['meta']
            ]);


            echo "Notification sent successfully.";
        } else {
            // HTTP error, update status to 'failed'
            $updateQuery = "UPDATE notifications_whatsapp SET status = 'failed', updated_at = NOW() WHERE id = :id";
            $updateStmt = $pdo->prepare($updateQuery);
            $updateStmt->execute([':id' => $notification['id']]);
            echo "HTTP Error: " . $httpCode;
        }
    }

    // Close the cURL session
    curl_close($ch);

} else {
    echo "No pending notifications found.";
}

// Close the database connection
$pdo = null;
?>

<!-- <script>

setInterval(function() {
  window.location.reload();
}, 1000);

</script> -->