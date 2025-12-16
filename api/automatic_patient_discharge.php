<?php

include('db.php');


    // SQL query to update checked_status to 'inactive' for discharged patients after 48 hours.
    $sql = "UPDATE patient_discharge SET check_status = 'inactive' 
            WHERE check_status = 'active' 
            AND TIMESTAMPDIFF(HOUR, datedischarged, NOW()) >= 1";

//     // Execute the SQL query
    if (mysqli_query($con, $sql)) {
        echo "Updated successfully for database $d.<br>";
    } else {
        echo "Error updating records for database $d: " . mysqli_error($con) . "<br>";
    }


// $curl = curl_init();
// curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
// curl_setopt($curl, CURLOPT_URL, $baseurl.'api/curl.php');
// curl_exec($curl);
?>
