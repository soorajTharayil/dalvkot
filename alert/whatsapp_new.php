<?php

date_default_timezone_set("Asia/Calcutta");

$host = "localhost";
$username = "myapp_user";
$password = "strong_password";
$dbname = "myapp_db";

$API_KEY = "6hASavMbFsYyz112baQsQB5s7oAV82tFMV6lWSQhEWA43Ain1P4TteszKTUJ"; // ← put your Tellephant API key here

try {
  $pdo = new PDO("mysql:host=$host;dbname=$dbname",$username,$password,[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) { die("DB error: ".$e->getMessage()); }

// 1 pending
$stmt = $pdo->prepare("SELECT * FROM notifications_whatsapp WHERE status='pending' LIMIT 1");
$stmt->execute();

if ($n = $stmt->fetch(PDO::FETCH_ASSOC)) {

  // Tellephant expects E.164 without '+' (e.g., 9198XXXXXXXX)
  $to = preg_replace('/\D/','',$n['destination']); 

  // Build payload per docs: apikey, to, channels, whatsapp.{contentType,text}
  $payload = [
    "apikey"   => $API_KEY,
    "to"       => $to,
    "channels" => ["whatsapp"],
    "whatsapp" => [
      "contentType" => "text",
      "text"        => $n['userName'] ?? "Hello from Efeedor"  // or your own text field
    ],
  ];

  $ch = curl_init("https://api.tellephant.com/v1/send-message");
  curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST           => true,
    CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
    CURLOPT_POSTFIELDS     => json_encode($payload, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE),
  ]);

  $response = curl_exec($ch);
  $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  $curlErr  = curl_error($ch);
  curl_close($ch);

  // Better error visibility
  $respObj = json_decode($response, true);
  $msg = $respObj['message'] ?? $response;

  if ($curlErr) {
    $pdo->prepare("UPDATE notifications_whatsapp SET status='failed', updated_at=NOW(), error_msg=:m WHERE id=:id")
        ->execute([':m'=>"cURL: $curlErr", ':id'=>$n['id']]);
    echo "cURL error: $curlErr";
  } elseif ($httpCode>=200 && $httpCode<300) {
    $pdo->prepare("UPDATE notifications_whatsapp SET status='sent', updated_at=NOW() WHERE id=:id")
        ->execute([':id'=>$n['id']]);

    // mark duplicates still pending with same destination+meta
    $pdo->prepare("UPDATE notifications_whatsapp SET status='duplicate', updated_at=NOW() 
                   WHERE destination=:d AND meta=:m AND status='pending'")
        ->execute([':d'=>$n['destination'], ':m'=>$n['meta']]);

    echo "Sent ✅";
  } else {
    $pdo->prepare("UPDATE notifications_whatsapp SET status='failed', updated_at=NOW(), error_msg=:m WHERE id=:id")
        ->execute([':m'=>"HTTP $httpCode: $msg", ':id'=>$n['id']]);
    echo "HTTP $httpCode: $msg";
  }
} else {
  echo "No pending notifications.";
}


?>
