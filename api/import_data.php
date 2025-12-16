<?php
include('db.php');
$data = $_POST['data'];
$table = $_GET['table'];
foreach ($data as $row) {
    // Escape the keys and values to prevent SQL injection
    $columns = array_map(function ($value) {
        return "`" . str_replace("`", "``", $value) . "`"; }, array_keys($row));
    $values = array_map(function ($value) {
        return "'" . str_replace("'", "''", $value) . "'"; }, array_values($row));
    if ($table == 'patient_admitted' && $table == 'patients_from_admission' || $table == 'healthcare_employees') {
        $columns[] = '`guid`';
        $values[] = "'".guid()."'";
    }
    // Create the SQL for this row
    $sql = "INSERT INTO `" . $table . "` (" . implode(", ", $columns) . ") VALUES (" . implode(", ", $values) . ");";
    $insertQueries[] = $sql;
}
foreach ($insertQueries as $query) {
    $result = mysqli_query($con, $query);
		
}
echo 'success';

function guid()
{
    mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid = substr($charid, 0, 8).$hyphen
            .substr($charid, 8, 4).$hyphen
            .substr($charid,12, 4).$hyphen
            .substr($charid,16, 4).$hyphen
            .substr($charid,20,12);
        return $uuid;
}
