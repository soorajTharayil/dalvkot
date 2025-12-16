<?php

// Include the database connection

include('db.php');



// Set the content type to JSON

header('Content-Type: application/json');



// Get the JSON input and decode it into an associative array

$input = file_get_contents('php://input');

$data = json_decode($input, true);



// Check if the ticketId is provided
 //print_r($data);
if (isset($data['module']) && isset($data['ticketId'])  && $data["module"] == "IP") { 

    $ticketId = $data['ticketId'];

	$query = 'SELECT * FROM  `setup` WHERE 1';
	$setup = array();
	$overall = mysqli_query($con,$query);
	while($s =  mysqli_fetch_assoc($overall) ){
		$setup[$s['shortkey']] = $s;
	}

    // Query to get ticket details along with patient and department information

    $query = "

        SELECT 

            t.id as ticketId,

            t.departmentid,

            t.ward,
			d.setkey,

            t.status,

            t.rating,

            t.created_on,

            f.*, 

            d.name as departmentName,    -- Assuming the department table has a `department_name` field

            d.description as departDesc     -- Add other department-related fields as needed

        FROM tickets t

        JOIN bf_feedback f ON t.feedbackid = f.id

        JOIN department d ON t.departmentid = d.dprt_id   -- Join the departments table based on departmentid

        WHERE t.id = '$ticketId'

    ";



    // Execute the query

    $result = mysqli_query($con, $query);



    // Check if the ticket exists

    if (mysqli_num_rows($result) > 0) {

        // Fetch the result as an associative array

        $ticketDetail = mysqli_fetch_assoc($result);

        $ticketDetail['datasetGroup'] = json_decode($ticketDetail['dataset'], true); // Decode JSON dataset
		
		$rset = $ticketDetail['datasetGroup']['reasonSet'][$ticketDetail['setkey']];
		
		foreach($rset as $k=>$r){
			if($r === true){
				
				$reasonText = $setup[$k]['question'];
			}
		}
		$ticketDetail['reasonText']  = $reasonText;

        // Send the ticket, patient, and department details in the response

        $response = array(

            'error' => false,

            'ticketDetail' => $ticketDetail

        );

    } else {

        // If no ticket is found, return an error

        $response = array(

            'error' => true,

            'message' => 'Ticket not found'

        );

    }

}else if (isset($data['module']) && isset($data['ticketId'])  && $data["module"] == "OP") {

    $ticketId = $data['ticketId'];

	$query = 'SELECT * FROM  `setupop` WHERE 1';
	$setup = array();
	$overall = mysqli_query($con,$query);
	while($s =  mysqli_fetch_assoc($overall) ){
		$setup[$s['shortkey']] = $s;
	}

    // Query to get ticket details along with patient and department information

    $query = "

        SELECT 

            t.id as ticketId,

            t.departmentid,

            t.ward,

            t.status,
			d.setkey,

            t.rating,

            t.created_on,

            f.*, 

            d.name as departmentName,    -- Assuming the department table has a `department_name` field

            d.description as departDesc     -- Add other department-related fields as needed

        FROM ticketsop t

        JOIN bf_outfeedback f ON t.feedbackid = f.id

        JOIN department d ON t.departmentid = d.dprt_id   -- Join the departments table based on departmentid

        WHERE t.id = '$ticketId'

    ";



    // Execute the query

    $result = mysqli_query($con, $query);



    // Check if the ticket exists

    if (mysqli_num_rows($result) > 0) {

        // Fetch the result as an associative array

        $ticketDetail = mysqli_fetch_assoc($result);

        $ticketDetail['datasetGroup'] = json_decode($ticketDetail['dataset'], true); // Decode JSON dataset

		$rset = $ticketDetail['datasetGroup']['reasonSet'][$ticketDetail['setkey']];
		
		foreach($rset as $k=>$r){
			if($r === true){
				
				$reasonText = $setup[$k]['question'];
			}
		}
		$ticketDetail['reasonText']  = $reasonText;

        // Send the ticket, patient, and department details in the response

        $response = array(

            'error' => false,

            'ticketDetail' => $ticketDetail

        );

    } else {

        // If no ticket is found, return an error

        $response = array(

            'error' => true,

            'message' => 'Ticket not found'

        );

    }

}else if (isset($data['module']) && isset($data['ticketId'])  && $data["module"] == "ISR") {

    $ticketId = $data['ticketId'];

	$query = 'SELECT * FROM  `setup_esr` WHERE 1';
	$setup = array();
	$overall = mysqli_query($con,$query);
	while($s =  mysqli_fetch_assoc($overall) ){
		$setup[$s['shortkey']] = $s;
	}

    // Query to get ticket details along with patient and department information

    $query = "

        SELECT 

            t.id as ticketId,

            t.departmentid,

            t.ward,

            t.status,

            t.rating,

            t.created_on,

            f.*, 

            d.name as departmentName,    -- Assuming the department table has a `department_name` field

            d.description as departDesc     -- Add other department-related fields as needed

        FROM tickets_esr t

        JOIN bf_feedback_esr f ON t.feedbackid = f.id

        JOIN department d ON t.departmentid = d.dprt_id   -- Join the departments table based on departmentid

        WHERE t.id = '$ticketId'

    ";



    // Execute the query

    $result = mysqli_query($con, $query);



    // Check if the ticket exists

    if (mysqli_num_rows($result) > 0) {

        // Fetch the result as an associative array

        $ticketDetail = mysqli_fetch_assoc($result);

        $ticketDetail['datasetGroup'] = json_decode($ticketDetail['dataset'], true); // Decode JSON dataset
		$rset = $ticketDetail['datasetGroup']['reason'];
		
		foreach($rset as $k=>$r){
				if($r === true){
					
					$reasonText = $setup[$k]['question'];
				}
			}
		$ticketDetail['reasonText']  = $reasonText;
        // Send the ticket, patient, and department details in the response

        $response = array(

            'error' => false,

            'ticketDetail' => $ticketDetail

        );

    } else {

        // If no ticket is found, return an error

        $response = array(

            'error' => true,

            'message' => 'Ticket not found'

        );

    }

}else if (isset($data['module']) && isset($data['ticketId'])  && $data["module"] == "PCF") {

    $ticketId = $data['ticketId'];

	$query = 'SELECT * FROM  `setup_int` WHERE 1';
	$setup = array();
	$overall = mysqli_query($con,$query);
	while($s =  mysqli_fetch_assoc($overall) ){
		$setup[$s['shortkey']] = $s;
	}

    // Query to get ticket details along with patient and department information

    $query = "

        SELECT 

            t.id as ticketId,

            t.departmentid,

            t.ward,

            t.status,

            t.rating,

            t.created_on,

            f.*, 

            d.name as departmentName,    -- Assuming the department table has a `department_name` field

            d.description as departDesc     -- Add other department-related fields as needed

        FROM tickets_int t

        JOIN bf_feedback_int f ON t.feedbackid = f.id

        JOIN department d ON t.departmentid = d.dprt_id   -- Join the departments table based on departmentid

        WHERE t.id = '$ticketId'

    ";



    // Execute the query

    $result = mysqli_query($con, $query);



    // Check if the ticket exists

    if (mysqli_num_rows($result) > 0) {

        // Fetch the result as an associative array

        $ticketDetail = mysqli_fetch_assoc($result);

        $ticketDetail['datasetGroup'] = json_decode($ticketDetail['dataset'], true); // Decode JSON dataset
		$rset = $ticketDetail['datasetGroup']['reason'];
		
		foreach($rset as $k=>$r){
				if($r === true){
					
					$reasonText = $setup[$k]['question'];
				}
			}
		$ticketDetail['reasonText']  = $reasonText;
        // Send the ticket, patient, and department details in the response

        $response = array(

            'error' => false,

            'ticketDetail' => $ticketDetail

        );

    } else {

        // If no ticket is found, return an error

        $response = array(

            'error' => true,

            'message' => 'Ticket not found'

        );

    }

}else if (isset($data['module']) && isset($data['ticketId'])  && $data["module"] == "INCIDENT") {

    $ticketId = $data['ticketId'];

	$query = 'SELECT * FROM  `setup_incident` WHERE 1';
	$setup = array();
	$overall = mysqli_query($con,$query);
	while($s =  mysqli_fetch_assoc($overall) ){
		$setup[$s['shortkey']] = $s;
	}

    // Query to get ticket details along with patient and department information

    $query = "

        SELECT 

            t.id as ticketId,

            t.departmentid,

            t.ward,

            t.status,

            t.rating,

            t.created_on,

            f.*, 

            d.name as departmentName,    -- Assuming the department table has a `department_name` field

            d.description as departDesc     -- Add other department-related fields as needed

        FROM tickets_incident t

        JOIN bf_feedback_incident f ON t.feedbackid = f.id

        JOIN department d ON t.departmentid = d.dprt_id   -- Join the departments table based on departmentid

        WHERE t.id = '$ticketId'

    ";



    // Execute the query

    $result = mysqli_query($con, $query);



    // Check if the ticket exists

    if (mysqli_num_rows($result) > 0) {

        // Fetch the result as an associative array

        $ticketDetail = mysqli_fetch_assoc($result);

        $ticketDetail['datasetGroup'] = json_decode($ticketDetail['dataset'], true); // Decode JSON dataset
		$rset = $ticketDetail['datasetGroup']['reason'];
		
		foreach($rset as $k=>$r){
				if($r === true){
					
					$reasonText = $setup[$k]['question'];
				}
			}
		$ticketDetail['reasonText']  = $reasonText;
        // Send the ticket, patient, and department details in the response

        $response = array(

            'error' => false,

            'ticketDetail' => $ticketDetail

        );

    } else {

        // If no ticket is found, return an error

        $response = array(

            'error' => true,

            'message' => 'Ticket not found'

        );

    }

} else {
	//print_r($data);
    // If ticketId is not provided, return an error

    $response = array(

        'error' => true,

        'message' => 'ticketId is required'

    );

}



// Output the JSON response

echo json_encode($response);



// Close the database connection

mysqli_close($con);

