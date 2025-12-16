<?php 
$servername = "localhost";
$username = "myapp_user";
$password = "strong_password";
$dbname = "myapp_db";

// Create connection
$conn_g = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn_g->connect_error) {
  die("Connection failed: " . $conn_g->connect_error);
}

?>