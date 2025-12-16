<?php
// Set the desired timezone (optional if you want the correct timezone for the date)
date_default_timezone_set('Your/Timezone');  // Set this to your desired timezone, e.g., 'Asia/Kolkata'

// Allow cross-origin requests
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit;  // Handle preflight requests for CORS
}

// Define the upload directory
$uploadDirectory = 'file_uploads/';

// Check if the upload directory exists, if not create it
if (!is_dir($uploadDirectory)) {
    mkdir($uploadDirectory, 0755, true);  // Create directory if not exists
}

// Get the uploaded file from $_FILES
$uploadedFile = $_FILES['file'];

if ($uploadedFile['error'] !== UPLOAD_ERR_OK) {
    http_response_code(500);
    echo json_encode(['error' => 'Error uploading file.']);
    exit();
}

// Get the current date only (without time)
$date = date('Y-F-d');  // Format: YYYY-Month-DD

// Get the original filename without any directory path
$originalFilename = basename($uploadedFile['name']);

// Append the date to the filename to avoid conflicts
$uniqueFilename = $date . '_' . $originalFilename;

// Define the target path for the file
$targetPath = $uploadDirectory . $uniqueFilename;

if (move_uploaded_file($uploadedFile['tmp_name'], $targetPath)) {
    // File successfully uploaded
    $fileUrl = $targetPath;  // Path to access the file
    echo json_encode(['file_url' => $fileUrl, 'file_name' => $uniqueFilename]);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Error moving uploaded file.']);
}
?>
