<?php
    error_reporting(0); // Turn off error reporting in production
    include('db.php');

    $data = array();
    $mobile = $_GET['mobile'];
    $email = $_GET['email'];
    $pin = $_GET['pin'];

    // Check for empty input
    if (empty($mobile) || empty($email) || empty($pin)) {
        $data['pinfo'] = 'NO';
        $data['message'] = 'Required fields are missing.';
        echo json_encode($data);
        exit;
    }

    // Prepare SQL statement to prevent SQL injection
    $stmt = mysqli_prepare($con, 'SELECT * FROM `healthcare_employees` WHERE mobile=? OR email=?');
    mysqli_stmt_bind_param($stmt, 'ss', $mobile, $email);
    
    // Execute the query
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_object($result)) {
        if ($row->pin == $pin) {
            $data['pinfo'] = $row;
        } else {
            $data['pinfo'] = 'NO';
            $data['message'] = 'Invalid PIN. Please check and try again.';
        }
    } else {
        $data['pinfo'] = 'NO';
        $data['message'] = 'Error: Unable to proceed to the next page as the mobile number or email id does not match with the available employee data';
    }

    // Close the statement and connection
    mysqli_stmt_close($stmt);
    mysqli_close($con);

    // Return JSON response
    echo json_encode($data);
?>
