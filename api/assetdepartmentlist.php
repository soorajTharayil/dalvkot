<?php
$i = 0;
include('db.php');

// First query for bf_departmentasset
$sql = 'SELECT * FROM `bf_departmentasset` WHERE 1 ORDER BY title ASC';
$result = mysqli_query($con, $sql);
$num1 = mysqli_num_rows($result);
$j = 0;
$data = array(); // Initialize the $data array

if ($num1 > 0) {
    while ($row = mysqli_fetch_object($result)) {
        $data['ward'][$j]['title'] = $row->title;
        $data['ward'][$j]['guid'] = $row->guid;
        $data['ward'][$j]['bedno'] = explode(',', $row->bed_no);
        $data['ward'][$j]['method'] = $row->method;

        $i++;
        $j++;
    }
}

// Reset index counter for the next array
$j = 0;

// Second query for user table
$sql2 = 'SELECT * FROM `user` WHERE 1 ORDER BY firstname ASC';
$result2 = mysqli_query($con, $sql2);
$num2 = mysqli_num_rows($result2);

if ($num2 > 0) {
    while ($row2 = mysqli_fetch_object($result2)) {
        $data['user'][$j]['firstname'] = $row2->firstname;
        $data['user'][$j]['user_id'] = $row2->user_id;
        $j++;
    }
}

// Reset index counter for the bf_asset_location array
$j = 0;

// Third query for bf_asset_location table
$sql3 = 'SELECT title FROM `bf_asset_location` ORDER BY title ASC';
$result3 = mysqli_query($con, $sql3);
$num3 = mysqli_num_rows($result3);

if ($num3 > 0) {
    while ($row3 = mysqli_fetch_object($result3)) {
        $data['depart'][$j]['title'] = $row3->title;
        $data['depart'][$j]['guid'] = $row3->guid;

        $j++;
    }
}

// Reset index counter for the next array
$j = 0;

// fourth query for bf_asset_grade table
$sql4 = 'SELECT * FROM `bf_asset_grade` ORDER BY title ASC';
$result4 = mysqli_query($con, $sql4);
$num4 = mysqli_num_rows($result4);

if ($num4 > 0) {
    while ($row4 = mysqli_fetch_object($result4)) {
        $data['grade'][$j]['title'] = $row4->title;
        $data['grade'][$j]['guid'] = $row4->guid;
        $data['grade'][$j]['bed_no'] = $row4->bed_no;
        $data['grade'][$j]['bed_nom'] = $row4->bed_nom;

        $j++;
    }
}


// Check for matching asset in bf_feedback_asset_creation table
$assetname = isset($_GET['assetname']) ? $_GET['assetname'] : '';
$assetcode = isset($_GET['assetcode']) ? $_GET['assetcode'] : '';

if (!empty($assetname) && !empty($assetcode)) {
    $sql4 = 'SELECT * FROM `bf_feedback_asset_creation` WHERE assetname = ? AND patientid = ?';
    $stmt = $con->prepare($sql4);
    $stmt->bind_param("ss", $assetname, $assetcode);
    $stmt->execute();
    $result4 = $stmt->get_result();

    if ($result4->num_rows > 0) {
        $data['asset_details'] = $result4->fetch_assoc(); // Return matched asset data
    } else {
        $data['asset_details'] = null; // No match found
    }

    $stmt->close();


    // Fetch all assets with the same assetcode
    $sql_all_assets = 'SELECT * FROM `bf_feedback_asset_creation` WHERE patientid LIKE ? ORDER BY patientid ASC';
    $stmt_all = $con->prepare($sql_all_assets);
    
    $searchPattern = $assetcode . '%';
    $stmt_all->bind_param("s", $searchPattern);
    $stmt_all->execute();
    $result_all = $stmt_all->get_result();

    $all_assets = [];
    while ($row = $result_all->fetch_assoc()) {
        $all_assets[] = $row;
    }
    
    $data['all_assets'] = $all_assets; // Store all matching assets
    $stmt_all->close();
}

echo json_encode($data);
mysqli_close($con);
