<?php
include('db.php');

// Fetch `psat_score` and `nps_score` from the `setting` table
$query = 'SELECT psat_score, nps_score FROM setting';
$result = mysqli_query($con, $query);

// Check if the query returned a result
if ($result) {
    $data = mysqli_fetch_assoc($result);
    
    if ($data) {
        $response['status'] = 'success';
        $response['psat_score'] = $data['psat_score'];
        $response['nps_score'] = $data['nps_score'];
    } else {
        $response['status'] = 'fail';
        $response['message'] = 'No scores found';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Query failed';
}

// Return the JSON response
echo json_encode($response);

mysqli_close($con);
?>
