<?php
    $i = 0;
    include('db.php');

    // First query for bf_departmentasset
    $sql = 'SELECT * FROM `bf_quality_benchmark` WHERE 1 ORDER BY title ASC';			
    $result = mysqli_query($con, $sql);	
    $num1 = mysqli_num_rows($result);
    $j = 0;	
    $data = array(); // Initialize the $data array

    if ($num1 > 0) {
        while ($row = mysqli_fetch_object($result)) {	
            $data['benchmark'][$j]['title'] = $row->title;
            $data['benchmark'][$j]['guid'] = $row->guid;
            $data['benchmark'][$j]['bedno'] = explode(',', $row->bed_no);
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

    // // Reset index counter for the bf_asset_location array
    // $j = 0;

    // // Third query for bf_asset_location table
    // $sql3 = 'SELECT title FROM `bf_asset_location` ORDER BY title ASC';
    // $result3 = mysqli_query($con, $sql3);	
    // $num3 = mysqli_num_rows($result3);

    // if ($num3 > 0) {
    //     while ($row3 = mysqli_fetch_object($result3)) {	
    //         $data['depart'][$j]['title'] = $row3->title;
    //         $data['depart'][$j]['guid'] = $row3->guid;

    //         $j++;
    //     }
    // }

    echo json_encode($data);
    mysqli_close($con);
?>
