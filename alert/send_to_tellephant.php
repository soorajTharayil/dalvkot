<?php
require_once "tellephant.php";

// DB connection (adjust with your credentials)
$host     = "localhost";
$username = "myapp_user";
$password = "strong_password";
$dbname   = "myapp_db";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect: " . $e->getMessage());
}

// Fetch pending notification
$query = "SELECT * FROM notifications_whatsapp WHERE status = 'pending' LIMIT 1";
$stmt = $pdo->prepare($query);
$stmt->execute();

if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $tellephant = new Tellephant();

    // Destination (mobile number)
    $to = $row['destination'];

    // CampaignName = templateId
    $templateId = $row['campaignName'];

    // TemplateParams = JSON from DB (decode to array)
    $params = json_decode($row['templateParams'], true);

    if (!is_array($params)) {
        $params = []; // fallback if not proper JSON
    }

    // Send WhatsApp template message
    $response = $tellephant->sendTemplateMessage($to, $templateId, $params);

    print_r($response);

    // Optional: update status after sending
    if (isset($response['messageId'])) {
        $update = $pdo->prepare("UPDATE notifications_whatsapp SET status = 'sent', updated_at = NOW() WHERE id = ?");
        $update->execute([$row['id']]);
    } else {
        $update = $pdo->prepare("UPDATE notifications_whatsapp SET status = 'failed', updated_at = NOW() WHERE id = ?");
        $update->execute([$row['id']]);
    }
} else {
    echo "No pending notifications found.";
}

