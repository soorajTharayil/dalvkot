<?php
/*
// mysql_connect("database-host", "username", "password")
$conn = mysql_connect("localhost","root","root") 
			or die("cannot connected");

// mysql_select_db("database-name", "connection-link-identifier")
@mysql_select_db("test",$conn);
*/

/**
 * mysql_connect is deprecated
 * using mysqli_connect instead
 */
include("../env.php");





$databaseHost = $config_set['DBHOST'];

$databaseName = $config_set['DBNAME'];
$databaseUsername = $config_set['DBUSER'];
$databasePassword = $config_set['DBPASSWORD'];

$con = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName); 
 
?>
