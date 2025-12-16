<?php

// Include database connection
include('db.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get the raw POST data and decode the JSON
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Extract the form data
$ticketId = $data['ticketId'] ?? null;
$module = $data['module'] ?? null;
$status = $data['status'] ?? null;
$addressDetails = $data['addressDetails'] ?? null;
$reopenDetails = $data['reopenDetails'] ?? null;
$verifyDetails = $data['verifyDetails'] ?? null;
$describeDetails = $data['describeDetails'] ?? null;
$assignDetail = $data['assignDetails'] ?? null;

$assignTo = $data['assignTo'] ?? null;
$reAssignTo = $data['reAssignTo'] ?? null;


$departmentTransfer = $data['departmentTransfer'] ?? null;
$sourceDepartmentTransfer = $data['sourceDepartmentTransfer'] ?? null;
$transferComments = $data['transferComments'] ?? null;

$rca = $data['rca'] ?? null;
$capa = $data['capa'] ?? null;
$resNote = $data['resNote'] ?? null;

$name = $data['name'] ?? null;
$ids = $data['ids'] ?? null;



$comment = $data['comment'] ?? null;
$picture = $data['picture'] ?? null;

// Validate required fields
if (!$ticketId || !$status) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields: ticketId or status']);
    exit;
}

if (isset($data["module"]) && $data["module"] == "IP") {
    if (!isset($status, $ticketId)) {
        die(json_encode(['success' => false, 'message' => 'Missing required parameters: status or ticketId']));
    }

    $query = "UPDATE tickets SET status = ? WHERE id = ?";
    $stmt = mysqli_prepare($con, $query);
    if (!$stmt) {
        die(json_encode(['success' => false, 'message' => 'Prepare failed: ' . mysqli_error($con)]));
    }
    mysqli_stmt_bind_param($stmt, 'si', $status, $ticketId);
    $result = mysqli_stmt_execute($stmt);
    if (!$result) {
        die(json_encode(['success' => false, 'message' => 'Execute failed: ' . mysqli_error($con)]));
    }

    if (isset($data['departmentTransfer'])) {
        $sql = 'SELECT * FROM `setup` WHERE id=' . $data['departmentTransfer'];
        $result = mysqli_query($con, $sql);
        $num1 = mysqli_fetch_array($result);
        $type = $num1['type'];
        $sql = 'SELECT * FROM `department` WHERE setkey="' . $type . '" AND type="inpatient"';
        $result = mysqli_query($con, $sql);
        $num1 = mysqli_fetch_array($result);
        $departmentTransfer = $num1['dprt_id'];
        $query = "UPDATE tickets SET departmentid_trasfered = ? WHERE id = ?";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, 'si', $departmentTransfer, $ticketId);
        $result = mysqli_stmt_execute($stmt);
    }

    if ($result) {
        if ($status === 'Closed') {
            $actionMessage = "Closed by " . $name;

            $query = "INSERT INTO ticket_message (ticket_status, message, action, ticketid, corrective, rootcause) 
                      VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($con, $query);
            mysqli_stmt_bind_param($stmt, 'sssiss', $status, $name, $actionMessage, $ticketId, $capa, $rca);
        } elseif ($status === 'Addressed') {
            $actionMessage = "Addressed by " . $name;

            $query = "INSERT INTO ticket_message (ticket_status, message, action, ticketid, reply) 
                      VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($con, $query);
            mysqli_stmt_bind_param($stmt, 'sssis', $status, $name, $actionMessage, $ticketId, $addressDetails);
        } elseif ($status === 'Reopen') {
            $actionMessage = "Reopened by " . $name;

            $query = "INSERT INTO ticket_message (ticket_status, message, action, ticketid, reply) 
                      VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($con, $query);
            mysqli_stmt_bind_param($stmt, 'sssis', $status, $name, $actionMessage, $ticketId, $reopenDetails);
        } elseif ($status === 'Transfered') {
            $actionMeta = json_encode([
                "action" => "Transfered",
                "sourceDepartmentId" => $sourceDepartmentTransfer,
                "targetDepartmentId" => $departmentTransfer
            ]);
            if (json_last_error() !== JSON_ERROR_NONE) {
                die(json_encode(['success' => false, 'message' => 'JSON encoding error: ' . json_last_error_msg()]));
            }
            $actionMessage = "Transfered by " . $name;

            $query = "INSERT INTO ticket_message (ticket_status, message, action, action_meta, ticketid, reply) 
                      VALUES (?, ?, 'Transfered', ?, ?, ?)";
            $stmt = mysqli_prepare($con, $query);
            mysqli_stmt_bind_param($stmt, 'sssis', $status, $name, $actionMeta, $ticketId, $transferComments);
        }

        if (isset($stmt)) {
            $result = mysqli_stmt_execute($stmt);
            if (!$result) {
                die(json_encode(['success' => false, 'message' => 'Error saving ticket message: ' . mysqli_error($con)]));
            }
        }

        echo json_encode(['success' => true, 'message' => 'Ticket details updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating ticket details']);
    }
}



if (isset($data["module"]) && $data["module"] === "OP") {
    // Validate required variables
    if (!isset($status, $ticketId)) {
        echo json_encode(['success' => false, 'message' => 'Missing required parameters: status or ticketId']);
        return;
    }

    // Update ticket status
    $query = "UPDATE ticketsop SET status = ? WHERE id = ?";
    $stmt = mysqli_prepare($con, $query);
    if (!$stmt) {
        echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . mysqli_error($con)]);
        return;
    }

    mysqli_stmt_bind_param($stmt, 'si', $status, $ticketId);
    $result = mysqli_stmt_execute($stmt);
    if (!$result) {
        echo json_encode(['success' => false, 'message' => 'Execute failed: ' . mysqli_error($con)]);
        return;
    }

    // Update department transfer if applicable
    if (isset($data['departmentTransfer'])) {
        $sql = 'SELECT * FROM `setupop` WHERE id=' . $data['departmentTransfer'];
        $result = mysqli_query($con, $sql);
        $num1 = mysqli_fetch_array($result);
        $type = $num1['type'];
        $sql = 'SELECT * FROM `department` WHERE setkey="' . $type . '" AND type="outpatient"';
        $result = mysqli_query($con, $sql);
        $num1 = mysqli_fetch_array($result);
        $departmentTransfer = $num1['dprt_id'];
        $query = "UPDATE ticketsop SET departmentid_trasfered = ? WHERE id = ?";
        $stmt = mysqli_prepare($con, $query);
        if (!$stmt) {
            echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . mysqli_error($con)]);
            return;
        }

        mysqli_stmt_bind_param($stmt, 'si', $departmentTransfer, $ticketId);
        $result = mysqli_stmt_execute($stmt);
        if (!$result) {
            echo json_encode(['success' => false, 'message' => 'Execute failed: ' . mysqli_error($con)]);
            return;
        }
    }

    // Insert message based on status
    $query = "";
    if ($status === 'Closed') {
        $actionMessage = "Closed by " . $name;

        $query = "INSERT INTO ticketop_message (ticket_status, message, action, ticketid, corrective, rootcause) 
                  VALUES (?, ? , ?, ?, ?, ?)";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, 'sssiss', $status, $name, $actionMessage, $ticketId, $capa, $rca);
    } elseif ($status === 'Addressed') {
        $actionMessage = "Addressed by " . $name;

        $query = "INSERT INTO ticketop_message (ticket_status, message, action, ticketid, reply) 
                  VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, 'sssis', $status, $name, $actionMessage, $ticketId, $addressDetails);
    } elseif ($status === 'Reopen') {
        $actionMessage = "Reopened by " . $name;

        $query = "INSERT INTO ticketop_message (ticket_status, message, action, ticketid, reply) 
                  VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, 'sssis', $status, $name, $actionMessage, $ticketId, $reopenDetails);
    } elseif ($status === 'Transfered') {
        // Prepare JSON for action_meta
        $actionMeta = json_encode([
            "action" => "Transfered",
            "sourceDepartmentId" => $sourceDepartmentTransfer,
            "targetDepartmentId" => $departmentTransfer
        ]);

        if (json_last_error() !== JSON_ERROR_NONE) {
            echo json_encode(['success' => false, 'message' => 'JSON encoding error: ' . json_last_error_msg()]);
            return;
        }
        $actionMessage = "Transfered by " . $name;


        $query = "INSERT INTO ticketop_message (ticket_status, message, action, action_meta, ticketid, reply) 
                  VALUES (?, ?, 'Transfered', ?, ?, ?)";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, 'sssis', $status, $name, $actionMeta, $ticketId, $transferComments);
    }

    // Execute message insertion if applicable
    if (!empty($query) && isset($stmt)) {
        $result = mysqli_stmt_execute($stmt);
        if (!$result) {
            echo json_encode(['success' => false, 'message' => 'Error saving ticket message: ' . mysqli_error($con)]);
            return;
        }
    }

    // Respond with success
    echo json_encode(['success' => true, 'message' => 'Ticket details updated successfully']);
}


if (isset($data["module"]) && $data["module"] === "PCF") {
    // Validate required variables
    if (!isset($status, $ticketId)) {
        echo json_encode(['success' => false, 'message' => 'Missing required parameters: status or ticketId']);
        return;
    }

    // Update ticket status
    $query = "UPDATE tickets_int SET status = ? WHERE id = ?";
    $stmt = mysqli_prepare($con, $query);
    if (!$stmt) {
        echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . mysqli_error($con)]);
        return;
    }

    mysqli_stmt_bind_param($stmt, 'si', $status, $ticketId);
    $result = mysqli_stmt_execute($stmt);
    if (!$result) {
        echo json_encode(['success' => false, 'message' => 'Execute failed: ' . mysqli_error($con)]);
        return;
    }

    // Update department transfer if applicable
    if (isset($data['departmentTransfer'])) {
        $sql = 'SELECT * FROM `setup_int` WHERE id=' . $data['departmentTransfer'];
        $result = mysqli_query($con, $sql);
        $num1 = mysqli_fetch_array($result);
        $type = $num1['type'];
        $sql = 'SELECT * FROM `department` WHERE setkey="' . $type . '" AND type="interim"';
        $result = mysqli_query($con, $sql);
        $num1 = mysqli_fetch_array($result);
        $departmentTransfer = $num1['dprt_id'];
        $query = "UPDATE tickets_int SET departmentid_trasfered = ? WHERE id = ?";
        $stmt = mysqli_prepare($con, $query);
        if (!$stmt) {
            echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . mysqli_error($con)]);
            return;
        }

        mysqli_stmt_bind_param($stmt, 'si', $departmentTransfer, $ticketId);
        $result = mysqli_stmt_execute($stmt);
        if (!$result) {
            echo json_encode(['success' => false, 'message' => 'Execute failed: ' . mysqli_error($con)]);
            return;
        }
    }

    // Insert a message based on the status
    $query = "";
    if ($status === 'Closed') {
        $actionMessage = "Closed by " . $name;
        $query = "INSERT INTO ticket_int_message (ticket_status, message, action, ticketid, corrective, rootcause) 
                  VALUES (?, ? , ?, ?, ?, ?)";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, 'sssiss', $status, $name, $actionMessage, $ticketId, $capa, $rca);
    } elseif ($status === 'Addressed') {
        $actionMessage = "Addressed by " . $name;

        $query = "INSERT INTO ticket_int_message (ticket_status, message, action, ticketid, reply) 
                  VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, 'sssis', $status, $name, $actionMessage, $ticketId, $addressDetails);
    } elseif ($status === 'Reopen') {
        $actionMessage = "Reopened by " . $name;

        $query = "INSERT INTO ticket_int_message (ticket_status, message, action, ticketid, reply) 
                  VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, 'sssis', $status, $name, $actionMessage, $ticketId, $reopenDetails);
    } elseif ($status === 'Transfered') {
        // Prepare JSON for action_meta
        $actionMeta = json_encode([
            "action" => "Transfered",
            "sourceDepartmentId" => $sourceDepartmentTransfer,
            "targetDepartmentId" => $departmentTransfer
        ]);

        if (json_last_error() !== JSON_ERROR_NONE) {
            echo json_encode(['success' => false, 'message' => 'JSON encoding error: ' . json_last_error_msg()]);
            return;
        }

        $actionMessage = "Transfered by " . $name;

        $query = "INSERT INTO ticket_int_message (ticket_status, message, action, action_meta, ticketid, reply) 
                  VALUES (?, ?, 'Transfered', ?, ?, ?)";
        $stmt = mysqli_prepare($con, $query);
        if (!$stmt) {
            echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . mysqli_error($con)]);
            return;
        }

        mysqli_stmt_bind_param($stmt, 'sssis', $status, $name, $actionMeta, $ticketId, $transferComments);
    }

    // Execute the message insertion if applicable
    if (!empty($query)) {
        $result = mysqli_stmt_execute($stmt);
        if (!$result) {
            echo json_encode(['success' => false, 'message' => 'Error saving ticket message: ' . mysqli_error($con)]);
            return;
        }
    }

    // Respond with success
    echo json_encode(['success' => true, 'message' => 'Ticket details updated successfully']);
}



if (isset($data["module"]) && $data["module"] == "ISR") {
    // Update the ticket status
    $query = "UPDATE tickets_esr SET status = ? WHERE id = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, 'si', $status, $ticketId);
    $result = mysqli_stmt_execute($stmt);
    // Update department transfer if applicable
    if (isset($data['departmentTransfer'])) {
        $sql = 'SELECT * FROM `setup_esr` WHERE id=' . $data['departmentTransfer'];
        $result = mysqli_query($con, $sql);
        $num1 = mysqli_fetch_array($result);
        $type = $num1['type'];
        $sql = 'SELECT * FROM `department` WHERE setkey="' . $type . '" AND type="esr"';
        $result = mysqli_query($con, $sql);
        $num1 = mysqli_fetch_array($result);
        $departmentTransfer = $num1['dprt_id'];
        $query = "UPDATE tickets_esr SET departmentid_trasfered = ? WHERE id = ?";
        $stmt = mysqli_prepare($con, $query);
        if (!$stmt) {
            echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . mysqli_error($con)]);
            return;
        }

        mysqli_stmt_bind_param($stmt, 'si', $departmentTransfer, $ticketId);
        $result = mysqli_stmt_execute($stmt);
        if (!$result) {
            echo json_encode(['success' => false, 'message' => 'Execute failed: ' . mysqli_error($con)]);
            return;
        }
    }
    if (isset($data['assignTo'])) {
        foreach ($data['assignTo'] as $k => $r) {
            $users[] = $k;
        }
        $query = "UPDATE tickets_esr SET assign_to = ? WHERE id = ?";
        $stmt = mysqli_prepare($con, $query);
        if (!$stmt) {
            echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . mysqli_error($con)]);
            return;
        }
        $userText = implode(',', $users);
        mysqli_stmt_bind_param($stmt, 'si', $userText, $ticketId);
        $result = mysqli_stmt_execute($stmt);
        if (!$result) {
            echo json_encode(['success' => false, 'message' => 'Execute failed: ' . mysqli_error($con)]);
            return;
        }
    }
    if ($result) {
        // Insert a message based on the status
        if ($status === 'Closed') {
            if ($picture && isset($picture['filename']) && isset($picture['filedata'])) {
                // Check if it's an image (jpeg, jpg, png)
                $fileExtension = pathinfo($picture['filename'], PATHINFO_EXTENSION);
                $imageExtensions = ['jpg', 'jpeg', 'png'];

                if (in_array(strtolower($fileExtension), $imageExtensions)) {

                    $fileData = $picture['filename'];
                } else {
                    $fileData = $picture['filename'];
                }
            } else {
                $fileData = null;
            }

            $actionMessage = "Closed by " . $name;

            $query = "INSERT INTO ticket_esr_message (ticket_status, message, action, ticketid, corrective, rootcause, resolution_note, picture) 
					  VALUES (?, ? , ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($con, $query);
            mysqli_stmt_bind_param($stmt, 'sssissss', $status, $name, $actionMessage, $ticketId, $capa, $rca, $resNote, $fileData);


            $updateQuery = "UPDATE tickets_esr SET closed_ticket_alert = 0 WHERE id = ?";
            $updateStmt = mysqli_prepare($con, $updateQuery);
            mysqli_stmt_bind_param($updateStmt, 'i', $ticketId);
            mysqli_stmt_execute($updateStmt);
        } elseif ($status === 'Addressed') {
            $actionMessage = "Addressed by " . $name;

            $query = "INSERT INTO ticket_esr_message (ticket_status, message, action, ticketid, reply) 
					  VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($con, $query);
            mysqli_stmt_bind_param($stmt, 'sssis', $status, $name, $actionMessage, $ticketId, $addressDetails);
        } elseif ($status === 'Reopen') {
            $actionMessage = "Reopened by " . $name;

            $query = "INSERT INTO ticket_esr_message (ticket_status, message, action, ticketid, reply) 
					  VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($con, $query);
            mysqli_stmt_bind_param($stmt, 'sssis', $status, $name, $actionMessage, $ticketId, $reopenDetails);

            $updateQuery = "UPDATE tickets_esr SET reopen_ticket_alert = 0 WHERE id = ?";
            $updateStmt = mysqli_prepare($con, $updateQuery);
            mysqli_stmt_bind_param($updateStmt, 'i', $ticketId);
            mysqli_stmt_execute($updateStmt);
        } elseif ($status === 'Assigned') {

            $assigned_user_ids = array_keys($assignTo); // Array of user IDs

            if (!empty($assigned_user_ids) && is_array($assigned_user_ids)) {
                $assigned_user_ids_str = implode(',', array_map('intval', $assigned_user_ids));
            } else {
                die("Error: assigned_user_ids is not an array or is empty.");
            }
            $query = "SELECT firstname FROM user WHERE user_id IN ($assigned_user_ids_str)";
            $stmt = mysqli_prepare($con, $query);
            
            if ($stmt) {
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
            
                $firstnames = [];
                while ($row = mysqli_fetch_assoc($result)) {
                    $firstnames[] = $row['firstname'];
                }
                mysqli_stmt_close($stmt);
            } else {
                die("Query failed: " . mysqli_error($con));
            }
            
            // Convert firstnames to a comma-separated string
            $assigned_user_names_str = !empty($firstnames) ? implode(',', $firstnames) : "Unknown";
            $action = 'Assigned to ' . $assigned_user_names_str;

            $actionMessage = "Assigned by " . $name;


            $query = "INSERT INTO ticket_esr_message (ticket_status, message, action, ticketid, reply) 
					  VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($con, $query);
            mysqli_stmt_bind_param($stmt, 'sssis', $status, $name, $action, $ticketId, $assignDetail);

            // Update tickets_incident table with the new values
            $updateQuery = "UPDATE tickets_esr SET assigned_message = 0, assigned_email = 0 WHERE id = ?";
            $updateStmt = mysqli_prepare($con, $updateQuery);
            mysqli_stmt_bind_param($updateStmt, 'i', $ticketId);
            mysqli_stmt_execute($updateStmt);
        } elseif ($status === 'Transfered') {
            // Prepare JSON for action_meta
            $actionMeta = json_encode([
                "action" => "Transfered",
                "sourceDepartmentId" => $sourceDepartmentTransfer,
                "targetDepartmentId" => $departmentTransfer
            ]);

            if (json_last_error() !== JSON_ERROR_NONE) {
                echo json_encode(['success' => false, 'message' => 'JSON encoding error: ' . json_last_error_msg()]);
                return;
            }

            $actionMessage = "Transfered by " . $name;

            $query = "INSERT INTO ticket_esr_message (ticket_status, message, action, action_meta, ticketid, reply) 
					  VALUES (?, ?, 'Transfered', ?, ?, ?)";
            $stmt = mysqli_prepare($con, $query);
            if (!$stmt) {
                echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . mysqli_error($con)]);
                return;
            }

            mysqli_stmt_bind_param($stmt, 'sssis', $status, $name, $actionMeta, $ticketId, $transferComments);
        }

        // Execute the message insertion if applicable
        if (isset($stmt)) {
            $result = mysqli_stmt_execute($stmt);
        }

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Ticket details updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error saving ticket message']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating ticket details']);
    }
}

if (isset($data["module"]) && $data["module"] == "INCIDENT") {
    // Update the ticket status
    $query = "UPDATE tickets_incident SET status = ? WHERE id = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, 'si', $status, $ticketId);
    $result = mysqli_stmt_execute($stmt);
    // Update department transfer if applicable
    if (isset($data['departmentTransfer'])) {
        $sql = 'SELECT * FROM `setup_incident` WHERE id=' . $data['departmentTransfer'];
        $result = mysqli_query($con, $sql);
        $num1 = mysqli_fetch_array($result);
        $type = $num1['type'];
        $sql = 'SELECT * FROM `department` WHERE setkey="' . $type . '" AND type="incident"';
        $result = mysqli_query($con, $sql);
        $num1 = mysqli_fetch_array($result);
        $departmentTransfer = $num1['dprt_id'];
        $query = "UPDATE tickets_incident SET departmentid_trasfered = ? WHERE id = ?";
        $stmt = mysqli_prepare($con, $query);
        if (!$stmt) {
            echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . mysqli_error($con)]);
            return;
        }

        mysqli_stmt_bind_param($stmt, 'si', $departmentTransfer, $ticketId);
        $result = mysqli_stmt_execute($stmt);
        if (!$result) {
            echo json_encode(['success' => false, 'message' => 'Execute failed: ' . mysqli_error($con)]);
            return;
        }
    }
    if (isset($data['assignTo'])) {
        foreach ($data['assignTo'] as $k => $r) {
            $users[] = $k;
        }
        $query = "UPDATE tickets_incident SET assign_to = ? WHERE id = ?";
        $stmt = mysqli_prepare($con, $query);
        if (!$stmt) {
            echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . mysqli_error($con)]);
            return;
        }
        $userText = implode(',', $users);
        mysqli_stmt_bind_param($stmt, 'si', $userText, $ticketId);
        $result = mysqli_stmt_execute($stmt);
        if (!$result) {
            echo json_encode(['success' => false, 'message' => 'Execute failed: ' . mysqli_error($con)]);
            return;
        }
    }
    if (isset($data['reAssignTo'])) {
        foreach ($data['reAssignTo'] as $k => $r) {
            $users[] = $k;
        }
        $query = "UPDATE tickets_incident SET reassign_to = ? WHERE id = ?";
        $stmt = mysqli_prepare($con, $query);
        if (!$stmt) {
            echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . mysqli_error($con)]);
            return;
        }
        $userText = implode(',', $users);
        mysqli_stmt_bind_param($stmt, 'si', $userText, $ticketId);
        $result = mysqli_stmt_execute($stmt);
        if (!$result) {
            echo json_encode(['success' => false, 'message' => 'Execute failed: ' . mysqli_error($con)]);
            return;
        }
    }
    if ($result) {
        // Insert a message based on the status
        if ($status === 'Closed') {
            if ($picture && isset($picture['filename']) && isset($picture['filedata'])) {
                // Check if it's an image (jpeg, jpg, png)
                $fileExtension = pathinfo($picture['filename'], PATHINFO_EXTENSION);
                $imageExtensions = ['jpg', 'jpeg', 'png'];

                if (in_array(strtolower($fileExtension), $imageExtensions)) {

                    $fileData = $picture['filename'];
                } else {
                    $fileData = $picture['filename'];
                }
            } else {
                $fileData = null;
            }

            $actionMessage = "Closed by " . $name;

            $query = "INSERT INTO ticket_incident_message (ticket_status, message, action, ticketid, corrective, rootcause, resolution_note, picture) 
                      VALUES (?, ? , ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($con, $query);
            mysqli_stmt_bind_param($stmt, 'sssissss', $status, $name, $actionMessage, $ticketId, $capa, $rca, $resNote, $fileData);
        } elseif ($status === 'Reopen') {
            $actionMessage = "Reopened by " . $name;

            $query = "INSERT INTO ticket_incident_message (ticket_status, message, action, ticketid, reply) 
					  VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($con, $query);
            mysqli_stmt_bind_param($stmt, 'sssis', $status, $name, $actionMessage, $ticketId, $reopenDetails);
        } elseif ($status === 'Verified') {
            $actionMessage = "Verified by " . $name;

            $query = "INSERT INTO ticket_incident_message (ticket_status, message, action, ticketid, reply) 
					  VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($con, $query);
            mysqli_stmt_bind_param($stmt, 'sssis', $status, $name, $actionMessage, $ticketId, $verifyDetails);


            $updateQuery = "UPDATE tickets_incident SET status = 'Closed', verified_status = 1 WHERE id = ?";
            $updateStmt = mysqli_prepare($con, $updateQuery);
            mysqli_stmt_bind_param($updateStmt, 'i', $ticketId);
            mysqli_stmt_execute($updateStmt);
        } elseif ($status === 'Described') {
            $actionMessage = "Described by " . $name;

            $query = "INSERT INTO ticket_incident_message (ticket_status, message, action, ticketid, reply) 
					  VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($con, $query);
            mysqli_stmt_bind_param($stmt, 'sssis', $status, $name, $actionMessage, $ticketId, $describeDetails);

            // Update tickets_incident table
            $updateQuery = "UPDATE tickets_incident SET status = 'Described', describe_message = 0, describe_email = 0, describe_by = ? WHERE id = ?";
            $updateStmt = mysqli_prepare($con, $updateQuery);
            mysqli_stmt_bind_param($updateStmt, 'ii', $ids, $ticketId);
            mysqli_stmt_execute($updateStmt);
        } elseif ($status === 'Assigned') {

            $assigned_user_ids = array_keys($assignTo); // Array of user IDs

            if (!empty($assigned_user_ids) && is_array($assigned_user_ids)) {
                $assigned_user_ids_str = implode(',', array_map('intval', $assigned_user_ids));
            } else {
                die("Error: assigned_user_ids is not an array or is empty.");
            }
            $query = "SELECT firstname FROM user WHERE user_id IN ($assigned_user_ids_str)";
            $stmt = mysqli_prepare($con, $query);
            
            if ($stmt) {
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
            
                $firstnames = [];
                while ($row = mysqli_fetch_assoc($result)) {
                    $firstnames[] = $row['firstname'];
                }
                mysqli_stmt_close($stmt);
            } else {
                die("Query failed: " . mysqli_error($con));
            }
            
            // Convert firstnames to a comma-separated string
            $assigned_user_names_str = !empty($firstnames) ? implode(',', $firstnames) : "Unknown";
            $action = 'Incident Assigned to ' . $assigned_user_names_str;

            $actionMessage = "Assigned by " . $name;

            $query = "INSERT INTO ticket_incident_message (ticket_status, message, action, ticketid, reply) 
					  VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($con, $query);
            mysqli_stmt_bind_param($stmt, 'sssis', $status, $name, $action, $ticketId, $assignDetail);


            // Update tickets_incident table with the new values
            $updateQuery = "UPDATE tickets_incident SET assign_by = ?, assigned_message = 0, describe_message = -1, assigned_email = 0 WHERE id = ?";
            $updateStmt = mysqli_prepare($con, $updateQuery);
            mysqli_stmt_bind_param($updateStmt, 'ii', $ids, $ticketId); // Assuming $ids is the correct assign_by value
            mysqli_stmt_execute($updateStmt);
        } elseif ($status === 'Re-assigned') {

            $assigned_user_ids = array_keys($reAssignTo); // Array of user IDs

            if (!empty($assigned_user_ids) && is_array($assigned_user_ids)) {
                $assigned_user_ids_str = implode(',', array_map('intval', $assigned_user_ids));
            } else {
                die("Error: assigned_user_ids is not an array or is empty.");
            }
            $query = "SELECT firstname FROM user WHERE user_id IN ($assigned_user_ids_str)";
            $stmt = mysqli_prepare($con, $query);
            
            if ($stmt) {
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
            
                $firstnames = [];
                while ($row = mysqli_fetch_assoc($result)) {
                    $firstnames[] = $row['firstname'];
                }
                mysqli_stmt_close($stmt);
            } else {
                die("Query failed: " . mysqli_error($con));
            }
            
            // Convert firstnames to a comma-separated string
            $assigned_user_names_str = !empty($firstnames) ? implode(',', $firstnames) : "Unknown";
            $action = 'Incident re-assigned to ' . $assigned_user_names_str;


            $actionMessage = "Re-assigned by " . $name;

            $query = "INSERT INTO ticket_incident_message (ticket_status, message, action, ticketid, reply) 
					  VALUES (?, ? , ? , ?, ?)";
            $stmt = mysqli_prepare($con, $query);
            mysqli_stmt_bind_param($stmt, 'sssis', $status, $name, $action, $ticketId, $assignDetail);


            $updateQuery = "UPDATE tickets_incident SET reassign_by = ?, reassigned_message = 0, describe_message = -1, reassigned_email = 0 WHERE id = ?";
            $updateStmt = mysqli_prepare($con, $updateQuery);
            mysqli_stmt_bind_param($updateStmt, 'ii', $ids, $ticketId); // Assuming $ids is the correct assign_by value
            mysqli_stmt_execute($updateStmt);
        } elseif ($status === 'Transfered') {
            // Prepare JSON for action_meta
            $actionMeta = json_encode([
                "action" => "Transfered",
                "sourceDepartmentId" => $sourceDepartmentTransfer,
                "targetDepartmentId" => $departmentTransfer
            ]);

            if (json_last_error() !== JSON_ERROR_NONE) {
                echo json_encode(['success' => false, 'message' => 'JSON encoding error: ' . json_last_error_msg()]);
                return;
            }
            $actionMessage = "Transfered by " . $name;


            $query = "INSERT INTO ticket_incident_message (ticket_status, message, action, action_meta, ticketid, reply) 
					  VALUES (?, ?, 'Transfered', ?, ?, ?)";
            $stmt = mysqli_prepare($con, $query);
            if (!$stmt) {
                echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . mysqli_error($con)]);
                return;
            }

            mysqli_stmt_bind_param($stmt, 'sssis', $status, $name, $actionMeta, $ticketId, $transferComments);
        }


        // Execute the message insertion if applicable
        if (isset($stmt)) {
            $result = mysqli_stmt_execute($stmt);
        }

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Ticket details updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error saving ticket message']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating ticket details']);
    }
}
// Close the statement and database connection
if (isset($stmt)) {
    mysqli_stmt_close($stmt);
}
mysqli_close($con);
