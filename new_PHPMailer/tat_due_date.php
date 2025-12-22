<?php

include('../api/db.php');
include('/home/efeedor/globalconfig.php');
include('get_user.php');



// 1️⃣ STEP 1: Mark all non-assigned tickets as completed (status = 2)
$update_non_assigned = "
    UPDATE tickets_incident 
    SET assign_tat_due_date_status = 2
    WHERE status != 'Assigned'
";
mysqli_query($con, $update_non_assigned);

// 2️⃣ STEP 2: Fetch Assigned tickets where either:
// - today = assign_tat_due_date (first alert)
// - OR every 2 days after assign_tat_due_date (if still assigned)  🆕
$current_date = date('Y-m-d');

$feedback_incident_query = "
    SELECT *, DATEDIFF('$current_date', DATE(assign_tat_due_date)) AS diff_days
    FROM tickets_incident 
    WHERE status = 'Assigned'
      AND assign_tat_due_date IS NOT NULL
      AND DATEDIFF('$current_date', DATE(assign_tat_due_date)) >= 0
      AND (DATEDIFF('$current_date', DATE(assign_tat_due_date)) % 2 = 0)
";
$feedback_incident_result = mysqli_query($con, $feedback_incident_query);

while ($feedback_incident_object = mysqli_fetch_object($feedback_incident_result)) {

    $Subject1 = 'Action Required: Incident Assigned to You as Team Leader at ' . $hospitalname . '';

    $tickets_incident_query = 'SELECT tickets_incident.*, department.*, bf_feedback_incident.* 
        FROM tickets_incident 
        INNER JOIN department ON department.dprt_id = tickets_incident.departmentid 
        INNER JOIN bf_feedback_incident ON bf_feedback_incident.id = tickets_incident.feedbackid 
        WHERE feedbackid = ' . $feedback_incident_object->id . ' 
        GROUP BY department.description';

    $tickets_incident_result = mysqli_query($con, $tickets_incident_query);
// Step 1: Build user_id → firstname map
    $user_query = "SELECT user_id, firstname FROM user WHERE user_id != 1";
    $user_result = mysqli_query($con, $user_query);

    $userMap = [];
    while ($row = mysqli_fetch_assoc($user_result)) {
        $userMap[$row['user_id']] = $row['firstname'];
    }
    while ($tickets_incident_object = mysqli_fetch_object($tickets_incident_result)) {

        $param_incident = json_decode($tickets_incident_object->dataset);
        $ward_floor = $param_incident->ward ?? '';
        $number = $tickets_incident_object->mobile;
        $department = $tickets_incident_object->description;

        $department_query = 'SELECT * FROM  tickets_incident  
            INNER JOIN department ON department.dprt_id = tickets_incident.departmentid   
            WHERE feedbackid = ' . $feedback_incident_object->id . ' 
            AND department.description="' . $tickets_incident_object->description . '"';
        $department_result = mysqli_query($con, $department_query);
        $department_object = mysqli_fetch_object($department_result);
        $created_on = date('g:i A, d-m-y', strtotime($department_object->created_on));

        // Step 2: Convert comma-separated IDs into arrays
        $assign_for_process_monitor_ids = !empty($department_object->assign_for_process_monitor)
            ? explode(',', $department_object->assign_for_process_monitor)
            : [];
        $assign_to_ids = !empty($department_object->assign_to)
            ? explode(',', $department_object->assign_to)
            : [];
        $assign_for_team_member_ids = !empty($department_object->assign_for_team_member)
            ? explode(',', $department_object->assign_for_team_member)
            : [];

        // Step 3: Map IDs → names
        $assign_for_process_monitor_names = array_map(function ($id) use ($userMap) {
            $id = (int) trim($id);
            return $userMap[$id] ?? $id;
        }, $assign_for_process_monitor_ids);

        $assign_to_names = array_map(function ($id) use ($userMap) {
            $id = (int) trim($id);
            return $userMap[$id] ?? $id;
        }, $assign_to_ids);

        $assign_for_team_member_names = array_map(function ($id) use ($userMap) {
            $id = (int) trim($id);
            return $userMap[$id] ?? $id;
        }, $assign_for_team_member_ids);

        // Step 4: Join into comma-separated strings (for email content)
        $actionText_process_monitor = implode(', ', $assign_for_process_monitor_names);
        $names = implode(', ', $assign_to_names);
        $actionText_team_member = implode(', ', $assign_for_team_member_names);

        $TID = $department_object->id;
        $department_head_link = $config_set['BASE_URL'] . 'incident/track/' . $TID;

        // 🆕 If this is a follow-up reminder (after due date), add note
        if ($feedback_incident_object->diff_days > 0) {
            $reminder_text = "<b>Reminder:</b> This incident is still open after {$feedback_incident_object->diff_days} days since due date.<br /><br />";
        } else {
            $reminder_text = "";
        }

        $message1 = 'Dear Team,<br /><br />' . $reminder_text;
        $message1 .= 'We would like to inform you that a new incident has been assigned to you as Team Leader at ' . $hospitalname . '.<br />';
        $message1 .= '<table border="1" cellpadding="5">';
        $message1 .= '
            <tr><td colspan="2" style="text-align:center;"><b>Incident reported on</b></td></tr>
            <tr><td width="40%">Time & Date</td><td width="60%">' . $created_on . '</td></tr>
            <tr><td colspan="2" style="text-align:center;"><b>Incident details</b></td></tr>
            <tr><td width="40%">Incident</td><td width="60%">' . $department_object->name . '</td></tr>
            <tr><td width="40%">Category</td><td width="60%">' . $department . '</td></tr>
            <tr><td width="40%">Incident Occured On</td><td width="60%">' . $department_object->incident_occured_in . '</td></tr>
            <tr><td width="40%">Assigned Risk</td><td width="60%">' . $param_incident->risk_matrix->level . '</td></tr>
            <tr><td width="40%">Assigned Priority</td><td width="60%">' . $param_incident->priority . '</td></tr>
            <tr><td width="40%">Assigned Severity</td><td width="60%">' . $param_incident->incident_type . '</td></tr>
        ';

        if ($param_incident->other) {
            $message1 .= '<tr><td width="40%">Description</td><td width="60%">' . $param_incident->other . '</td></tr>';
        }

        $message1 .= '
            <tr><td colspan="2" style="text-align:center;"><b>Incident reported in</b></td></tr>
            <tr><td width="40%">Floor/Ward</td><td width="60%">' . $feedback_incident_object->ward . '</td></tr>
            <tr><td width="40%">Site</td><td width="60%">' . $feedback_incident_object->bed_no . '</td></tr>
            <tr><td colspan="2" style="text-align:center;"><b>Incident reported by</b></td></tr>
            <tr><td width="40%">Employee name</td><td width="60%">' . $param_incident->name . '</td></tr>
            <tr><td width="40%">Employee ID</td><td width="60%">' . $param_incident->patientid . '</td></tr>
            <tr><td width="40%">Employee role</td><td width="60%">' . $param_incident->role . '</td></tr>
            <tr><td width="40%">Mobile number</td><td width="60%">' . $param_incident->contactnumber . '</td></tr>
            <tr><td width="40%">Email ID</td><td width="60%">' . $param_incident->email . '</td></tr>
            <tr><td width="40%">Assigned to</td><td width="60%">' . $department_object->pname . '</td></tr>
            <tr><td colspan="2" style="text-align:center;"><b>Assigned Details</b></td></tr>
            <tr><td width="40%">Team Leader</td><td width="60%">' . $names . '</td></tr>
            <tr><td width="40%">Team Member</td><td width="60%">' . $actionText_team_member . '</td></tr>
            <tr><td width="40%">Process Monitor</td><td width="60%">' . $actionText_process_monitor . '</td></tr>
        </table>';

        $message1 .= '<br /><br />To view more details and take necessary action, please follow the link below:<br />' . $department_head_link . '<br /><br />';
        $message1 .= 'Your prompt attention to this matter is crucial for patient safety and quality improvement.';
        $message1 .= '<br /><br /><strong>Best Regards,</strong><br />' . $hospitalname . ' ';

        // Get the list of assigned users
        $assign_to_users = explode(',', $feedback_incident_object->assign_to);

        foreach ($assign_to_users as $user_id) {
            $user_query = "SELECT * FROM user WHERE user_id = $user_id";
            $user_result = mysqli_query($con, $user_query);

            if ($user_row = mysqli_fetch_object($user_result)) {
                $email = $user_row->email;
                $query1 = 'INSERT INTO `notification`
                    (`type`, `message`, `status`, `mobile_email`, `subject`, `HID`)
                    VALUES ("email", "' . $conn_g->real_escape_string($message1) . '", 0, "' . $email . '", "' . $conn_g->real_escape_string($Subject1) . '", "' . $HID . '")';
                $conn_g->query($query1);
            }
        }

        // 🆕 Only mark status=1 for initial alert (not for reminders)
        if ($feedback_incident_object->diff_days == 0) {
            $update_query = "UPDATE tickets_incident SET assign_tat_due_date_status = 1 WHERE id = {$feedback_incident_object->id}";
            mysqli_query($con, $update_query);
        }

        echo "✅ Notification sent for Incident ID: {$feedback_incident_object->id} | diff_days={$feedback_incident_object->diff_days}<br>";
    }
}

$con->close();
?>
