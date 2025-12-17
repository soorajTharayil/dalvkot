<?php
include('db.php');
include('../new_messages/get_user.php');
$time = time();
$data = json_decode(file_get_contents('php://input'), true);
$username = $data['userid'];
$password = $data['password'];
$query = 'SELECT * FROM user WHERE (email="' . $username . '" OR mobile="' . $username . '") AND password="' . md5($password) . '"';

$object = mysqli_query($con, $query);
$result = mysqli_fetch_object($object);
if ($result) {
    //   $query = 'UPDATE  bf_coordinator set filest="'.$time.'" WHERE guid="'.$username.'" ';
    //   $object = mysqli_query($con,$query);
    $response['status'] = 'success';
    $response['userid'] = $result->user_id;
    $response['email'] = $result->email;
    $response['empid'] = $result->emp_id;
    $response['name'] = $result->firstname;
    $response['mobile'] = $result->mobile;
    $response['picture'] = $result->picture;

    $response['data'] = json_decode($result->departmentpermission);
    $response['IP-MODULE'] = get_user_by_access('IP-MODULE', $con, $result->user_id, $result->user_role);
    $response['OP-MODULE'] = get_user_by_access('OP-MODULE', $con, $result->user_id, $result->user_role);
    $response['PCF-MODULE'] = get_user_by_access('PCF-MODULE', $con, $result->user_id, $result->user_role);
    $response['ISR-MODULE'] = get_user_by_access('ISR-MODULE', $con, $result->user_id, $result->user_role);
    $response['INCIDENT-MODULE'] = get_user_by_access('INCIDENT-MODULE', $con, $result->user_id, $result->user_role);
    $response['GRIEVANCE-MODULE'] = get_user_by_access('GRIEVANCE-MODULE', $con, $result->user_id, $result->user_role);
    $response['ADF-MODULE'] = get_user_by_access('ADF-MODULE', $con, $result->user_id, $result->user_role);
    $response['USER-ACTIVITY'] = get_user_by_access('USER-ACTIVITY', $con, $result->user_id, $result->user_role);
    $response['MANAGE-TICKETS'] = get_user_by_access('MANAGE-TICKETS', $con, $result->user_id, $result->user_role);
    $response['SHARE-LINKS'] = get_user_by_access('SHARE-LINKS', $con, $result->user_id, $result->user_role);
    $response['QR-CODES'] = get_user_by_access('QR-CODES', $con, $result->user_id, $result->user_role);

    $response['PREMS-MODULE'] = get_user_by_access('PREMS-MODULE', $con, $result->user_id, $result->user_role);
    $response['PREMS1']  = get_user_by_access('PREMS-FORM1',  $con, $result->user_id, $result->user_role);
    $response['PREMS2']  = get_user_by_access('PREMS-FORM2',  $con, $result->user_id, $result->user_role);
    $response['PREMS3']  = get_user_by_access('PREMS-FORM3',  $con, $result->user_id, $result->user_role);
    $response['PREMS4']  = get_user_by_access('PREMS-FORM4',  $con, $result->user_id, $result->user_role);
    $response['PREMS5']  = get_user_by_access('PREMS-FORM5',  $con, $result->user_id, $result->user_role);
    $response['PREMS6']  = get_user_by_access('PREMS-FORM6',  $con, $result->user_id, $result->user_role);
    $response['PREMS7']  = get_user_by_access('PREMS-FORM7',  $con, $result->user_id, $result->user_role);
    $response['PREMS8']  = get_user_by_access('PREMS-FORM8',  $con, $result->user_id, $result->user_role);
    $response['PREMS9']  = get_user_by_access('PREMS-FORM9',  $con, $result->user_id, $result->user_role);
    $response['PREMS10'] = get_user_by_access('PREMS-FORM10', $con, $result->user_id, $result->user_role);
    $response['PREMS11'] = get_user_by_access('PREMS-FORM11', $con, $result->user_id, $result->user_role);
    $response['PREMS12'] = get_user_by_access('PREMS-FORM12', $con, $result->user_id, $result->user_role);
    $response['PREMS13'] = get_user_by_access('PREMS-FORM13', $con, $result->user_id, $result->user_role);
    $response['PREMS14'] = get_user_by_access('PREMS-FORM14', $con, $result->user_id, $result->user_role);
    $response['PREMS15'] = get_user_by_access('PREMS-FORM15', $con, $result->user_id, $result->user_role);
    $response['PREMS16'] = get_user_by_access('PREMS-FORM16', $con, $result->user_id, $result->user_role);
    $response['PREMS17'] = get_user_by_access('PREMS-FORM17', $con, $result->user_id, $result->user_role);



    $response['IP-TICKETS-DASHBOARD'] = get_user_by_access('IP-TICKETS-DASHBOARD', $con, $result->user_id, $result->user_role);
    $response['IP-TOTAL-TICKETS'] = get_user_by_access('IP-TOTAL-TICKETS', $con, $result->user_id, $result->user_role);
    $response['IP-OPEN-TICKETS'] = get_user_by_access('IP-OPEN-TICKETS', $con, $result->user_id, $result->user_role);
    $response['IP-ADDRESSED-TICKETS'] = get_user_by_access('IP-ADDRESSED-TICKETS', $con, $result->user_id, $result->user_role);
    $response['IP-CLOSED-TICKETS'] = get_user_by_access('IP-CLOSED-TICKETS', $con, $result->user_id, $result->user_role);
    $response['IP-REOPEN-TICKETS'] = get_user_by_access('IP-REOPEN-TICKETS', $con, $result->user_id, $result->user_role);
    $response['IP-TRANSFER-TICKETS'] = get_user_by_access('IP-TRANSFER-TICKETS', $con, $result->user_id, $result->user_role);


    $response['OP-TICKETS-DASHBOARD'] = get_user_by_access('OP-TICKETS-DASHBOARD', $con, $result->user_id, $result->user_role);
    $response['OP-TOTAL-TICKETS'] = get_user_by_access('OP-TOTAL-TICKETS', $con, $result->user_id, $result->user_role);
    $response['OP-OPEN-TICKETS'] = get_user_by_access('OP-OPEN-TICKETS', $con, $result->user_id, $result->user_role);
    $response['OP-ADDRESSED-TICKETS'] = get_user_by_access('OP-ADDRESSED-TICKETS', $con, $result->user_id, $result->user_role);
    $response['OP-CLOSED-TICKETS'] = get_user_by_access('OP-CLOSED-TICKETS', $con, $result->user_id, $result->user_role);
    $response['OP-REOPEN-TICKETS'] = get_user_by_access('OP-REOPEN-TICKETS', $con, $result->user_id, $result->user_role);
    $response['OP-TRANSFER-TICKETS'] = get_user_by_access('OP-TRANSFER-TICKETS', $con, $result->user_id, $result->user_role);


    $response['PC-COMPLAINTS-DASHBOARD'] = get_user_by_access('PC-COMPLAINTS-DASHBOARD', $con, $result->user_id, $result->user_role);
    $response['COMPLAINTS-DASHBOARD'] = get_user_by_access('COMPLAINTS-DASHBOARD', $con, $result->user_id, $result->user_role);
    $response['TOTAL-COMPLAINTS'] = get_user_by_access('TOTAL-COMPLAINTS', $con, $result->user_id, $result->user_role);
    $response['OPEN-COMPLAINTS'] = get_user_by_access('OPEN-COMPLAINTS', $con, $result->user_id, $result->user_role);
    $response['ADDRESSED-COMPLAINTS'] = get_user_by_access('ADDRESSED-COMPLAINTS', $con, $result->user_id, $result->user_role);
    $response['CLOSED-COMPLAINTS'] = get_user_by_access('CLOSED-COMPLAINTS', $con, $result->user_id, $result->user_role);
    $response['PC-REOPEN-COMPLAINTS'] = get_user_by_access('PC-REOPEN-COMPLAINTS', $con, $result->user_id, $result->user_role);
    $response['PC-TRANSFER-COMPLAINTS'] = get_user_by_access('PC-TRANSFER-COMPLAINTS', $con, $result->user_id, $result->user_role);


    $response['ISR-REQUESTS-DASHBOARD'] = get_user_by_access('ISR-REQUESTS-DASHBOARD', $con, $result->user_id, $result->user_role);
    $response['REQUESTS-DASHBOARD'] = get_user_by_access('REQUESTS-DASHBOARD', $con, $result->user_id, $result->user_role);
    $response['TOTAL-REQUESTS'] = get_user_by_access('TOTAL-REQUESTS', $con, $result->user_id, $result->user_role);
    $response['OPEN-REQUESTS'] = get_user_by_access('OPEN-REQUESTS', $con, $result->user_id, $result->user_role);
    $response['ADDRESSED-REQUESTS'] = get_user_by_access('ADDRESSED-REQUESTS', $con, $result->user_id, $result->user_role);
    $response['CLOSED-REQUESTS'] = get_user_by_access('CLOSED-REQUESTS', $con, $result->user_id, $result->user_role);
    $response['ISR-REOPEN-REQUESTS'] = get_user_by_access('ISR-REOPEN-REQUESTS', $con, $result->user_id, $result->user_role);
    $response['ISR-TRANSFER-REQUESTS'] = get_user_by_access('ISR-TRANSFER-REQUESTS', $con, $result->user_id, $result->user_role);
    $response['ISR-ASSIGNED-REQUEST'] = get_user_by_access('ISR-ASSIGNED-REQUEST', $con, $result->user_id, $result->user_role);



    $response['INC-INCIDENTS-DASHBOARD'] = get_user_by_access('INC-INCIDENTS-DASHBOARD', $con, $result->user_id, $result->user_role);
    $response['INCIDENTS-DASHBOARD'] = get_user_by_access('TOTAL-INCIDENTS', $con, $result->user_id, $result->user_role);
    $response['TOTAL-INCIDENTS'] = get_user_by_access('TOTAL-INCIDENTS', $con, $result->user_id, $result->user_role);
    $response['OPEN-INCIDENTS'] = get_user_by_access('OPEN-INCIDENTS', $con, $result->user_id, $result->user_role);
    $response['ADDRESSED-INCIDENTS'] = get_user_by_access('ADDRESSED-INCIDENTS', $con, $result->user_id, $result->user_role);
    $response['CLOSED-INCIDENTS'] = get_user_by_access('CLOSED-INCIDENTS', $con, $result->user_id, $result->user_role);
    $response['IN-REOPEN-INCIDENTS'] = get_user_by_access('IN-REOPEN-INCIDENTS', $con, $result->user_id, $result->user_role);
    $response['IN-TRANSFER-INCIDENTS'] = get_user_by_access('IN-TRANSFER-INCIDENTS', $con, $result->user_id, $result->user_role);
    $response['IN-ASSIGNED-INCIDENTS'] = get_user_by_access('IN-ASSIGNED-INCIDENTS', $con, $result->user_id, $result->user_role);
    $response['IN-REASSIGNED-INCIDENTS'] = get_user_by_access('IN-REASSIGNED-INCIDENTS', $con, $result->user_id, $result->user_role);
    $response['DESCRIBING-INCIDENTS'] = get_user_by_access('DESCRIBING-INCIDENTS', $con, $result->user_id, $result->user_role);
    $response['IN-VERIFY-INCIDENTS'] = get_user_by_access('IN-VERIFY-INCIDENTS', $con, $result->user_id, $result->user_role);
    $response['IN-DELETE-INCIDENTS'] = get_user_by_access('IN-DELETE-INCIDENTS', $con, $result->user_id, $result->user_role);

    $response['QUALITY-MODULE'] = get_user_by_access('QUALITY-MODULE', $con, $result->user_id, $result->user_role);
    $response['AUDIT-MODULE'] = get_user_by_access('AUDIT-MODULE', $con, $result->user_id, $result->user_role);
    $response['KPI1'] = get_user_by_access('QUALITY-KPI1', $con, $result->user_id, $result->user_role);
    $response['KPI2'] = get_user_by_access('QUALITY-KPI2', $con, $result->user_id, $result->user_role);
    $response['KPI3'] = get_user_by_access('QUALITY-KPI3', $con, $result->user_id, $result->user_role);
    $response['KPI4'] = get_user_by_access('QUALITY-KPI4', $con, $result->user_id, $result->user_role);
    $response['KPI5'] = get_user_by_access('QUALITY-KPI5', $con, $result->user_id, $result->user_role);
    $response['KPI6'] = get_user_by_access('QUALITY-KPI6', $con, $result->user_id, $result->user_role);
    $response['KPI7'] = get_user_by_access('QUALITY-KPI7', $con, $result->user_id, $result->user_role);
    $response['KPI8'] = get_user_by_access('QUALITY-KPI8', $con, $result->user_id, $result->user_role);
    $response['KPI9'] = get_user_by_access('QUALITY-KPI9', $con, $result->user_id, $result->user_role);
    $response['KPI10'] = get_user_by_access('QUALITY-KPI10', $con, $result->user_id, $result->user_role);
    $response['KPI11'] = get_user_by_access('QUALITY-KPI11', $con, $result->user_id, $result->user_role);
    $response['KPI12'] = get_user_by_access('QUALITY-KPI12', $con, $result->user_id, $result->user_role);
    $response['KPI13'] = get_user_by_access('QUALITY-KPI13', $con, $result->user_id, $result->user_role);
    $response['KPI14'] = get_user_by_access('QUALITY-KPI14', $con, $result->user_id, $result->user_role);
    $response['KPI15'] = get_user_by_access('QUALITY-KPI15', $con, $result->user_id, $result->user_role);
    $response['KPI16'] = get_user_by_access('QUALITY-KPI16', $con, $result->user_id, $result->user_role);
    $response['KPI17'] = get_user_by_access('QUALITY-KPI17', $con, $result->user_id, $result->user_role);
    $response['KPI18'] = get_user_by_access('QUALITY-KPI18', $con, $result->user_id, $result->user_role);
    $response['KPI19'] = get_user_by_access('QUALITY-KPI19', $con, $result->user_id, $result->user_role);
    $response['KPI20'] = get_user_by_access('QUALITY-KPI20', $con, $result->user_id, $result->user_role);
    $response['KPI21'] = get_user_by_access('QUALITY-KPI21', $con, $result->user_id, $result->user_role);
    $response['KPI21a'] = get_user_by_access('QUALITY-KPI21a', $con, $result->user_id, $result->user_role);
    $response['KPI22'] = get_user_by_access('QUALITY-KPI22', $con, $result->user_id, $result->user_role);
    $response['KPI23a'] = get_user_by_access('QUALITY-KPI23a', $con, $result->user_id, $result->user_role);
    $response['KPI23b'] = get_user_by_access('QUALITY-KPI23b', $con, $result->user_id, $result->user_role);
    $response['KPI23c'] = get_user_by_access('QUALITY-KPI23c', $con, $result->user_id, $result->user_role);
    $response['KPI23d'] = get_user_by_access('QUALITY-KPI23d', $con, $result->user_id, $result->user_role);
    $response['KPI24'] = get_user_by_access('QUALITY-KPI24', $con, $result->user_id, $result->user_role);
    $response['KPI25'] = get_user_by_access('QUALITY-KPI25', $con, $result->user_id, $result->user_role);
    $response['KPI26'] = get_user_by_access('QUALITY-KPI26', $con, $result->user_id, $result->user_role);
    $response['KPI27'] = get_user_by_access('QUALITY-KPI27', $con, $result->user_id, $result->user_role);
    $response['KPI28'] = get_user_by_access('QUALITY-KPI28', $con, $result->user_id, $result->user_role);
    $response['KPI29'] = get_user_by_access('QUALITY-KPI29', $con, $result->user_id, $result->user_role);
    $response['KPI30'] = get_user_by_access('QUALITY-KPI30', $con, $result->user_id, $result->user_role);
    $response['KPI31'] = get_user_by_access('QUALITY-KPI31', $con, $result->user_id, $result->user_role);
    $response['KPI32'] = get_user_by_access('QUALITY-KPI32', $con, $result->user_id, $result->user_role);
    $response['KPI33'] = get_user_by_access('QUALITY-KPI33', $con, $result->user_id, $result->user_role);

    $response['KPI34'] = get_user_by_access('QUALITY-KPI34', $con, $result->user_id, $result->user_role);
    $response['KPI35'] = get_user_by_access('QUALITY-KPI35', $con, $result->user_id, $result->user_role);
    $response['KPI36'] = get_user_by_access('QUALITY-KPI36', $con, $result->user_id, $result->user_role);
    $response['KPI37'] = get_user_by_access('QUALITY-KPI37', $con, $result->user_id, $result->user_role);
    $response['KPI38'] = get_user_by_access('QUALITY-KPI38', $con, $result->user_id, $result->user_role);
    $response['KPI39'] = get_user_by_access('QUALITY-KPI39', $con, $result->user_id, $result->user_role);
    $response['KPI40'] = get_user_by_access('QUALITY-KPI40', $con, $result->user_id, $result->user_role);
    $response['KPI41'] = get_user_by_access('QUALITY-KPI41', $con, $result->user_id, $result->user_role);
    $response['KPI42'] = get_user_by_access('QUALITY-KPI42', $con, $result->user_id, $result->user_role);
    $response['KPI43'] = get_user_by_access('QUALITY-KPI43', $con, $result->user_id, $result->user_role);
    $response['KPI44'] = get_user_by_access('QUALITY-KPI44', $con, $result->user_id, $result->user_role);
    $response['KPI45'] = get_user_by_access('QUALITY-KPI45', $con, $result->user_id, $result->user_role);
    $response['KPI46'] = get_user_by_access('QUALITY-KPI46', $con, $result->user_id, $result->user_role);
    $response['KPI47'] = get_user_by_access('QUALITY-KPI47', $con, $result->user_id, $result->user_role);
    $response['KPI48'] = get_user_by_access('QUALITY-KPI48', $con, $result->user_id, $result->user_role);
    $response['KPI49'] = get_user_by_access('QUALITY-KPI49', $con, $result->user_id, $result->user_role);
    $response['KPI50'] = get_user_by_access('QUALITY-KPI50', $con, $result->user_id, $result->user_role);
    $response['KPI51'] = get_user_by_access('QUALITY-KPI51', $con, $result->user_id, $result->user_role);

    $response['AUDIT1'] = get_user_by_access('AUDIT-FORM1', $con, $result->user_id, $result->user_role);
    $response['AUDIT2'] = get_user_by_access('AUDIT-FORM2', $con, $result->user_id, $result->user_role);
    $response['AUDIT3'] = get_user_by_access('AUDIT-FORM3', $con, $result->user_id, $result->user_role);
    $response['AUDIT4'] = get_user_by_access('AUDIT-FORM4', $con, $result->user_id, $result->user_role);
    $response['AUDIT5'] = get_user_by_access('AUDIT-FORM5', $con, $result->user_id, $result->user_role);
    $response['AUDIT6'] = get_user_by_access('AUDIT-FORM6', $con, $result->user_id, $result->user_role);
    $response['AUDIT7'] = get_user_by_access('AUDIT-FORM7', $con, $result->user_id, $result->user_role);
    $response['AUDIT8'] = get_user_by_access('AUDIT-FORM8', $con, $result->user_id, $result->user_role);
    $response['AUDIT9'] = get_user_by_access('AUDIT-FORM9', $con, $result->user_id, $result->user_role);
    $response['AUDIT10'] = get_user_by_access('AUDIT-FORM10', $con, $result->user_id, $result->user_role);
    $response['AUDIT11'] = get_user_by_access('AUDIT-FORM11', $con, $result->user_id, $result->user_role);
    $response['AUDIT12'] = get_user_by_access('AUDIT-FORM12', $con, $result->user_id, $result->user_role);
    $response['AUDIT13'] = get_user_by_access('AUDIT-FORM13', $con, $result->user_id, $result->user_role);
    $response['AUDIT14'] = get_user_by_access('AUDIT-FORM14', $con, $result->user_id, $result->user_role);
    $response['AUDIT15'] = get_user_by_access('AUDIT-FORM15', $con, $result->user_id, $result->user_role);
    $response['AUDIT16'] = get_user_by_access('AUDIT-FORM16', $con, $result->user_id, $result->user_role);
    $response['AUDIT17'] = get_user_by_access('AUDIT-FORM17', $con, $result->user_id, $result->user_role);
    $response['AUDIT18'] = get_user_by_access('AUDIT-FORM18', $con, $result->user_id, $result->user_role);
    $response['AUDIT19'] = get_user_by_access('AUDIT-FORM19', $con, $result->user_id, $result->user_role);
    $response['AUDIT20'] = get_user_by_access('AUDIT-FORM20', $con, $result->user_id, $result->user_role);
    $response['AUDIT21'] = get_user_by_access('AUDIT-FORM21', $con, $result->user_id, $result->user_role);
    $response['AUDIT22'] = get_user_by_access('AUDIT-FORM22', $con, $result->user_id, $result->user_role);
    $response['AUDIT23'] = get_user_by_access('AUDIT-FORM23', $con, $result->user_id, $result->user_role);
    $response['AUDIT24'] = get_user_by_access('AUDIT-FORM24', $con, $result->user_id, $result->user_role);
    $response['AUDIT25'] = get_user_by_access('AUDIT-FORM25', $con, $result->user_id, $result->user_role);
    $response['AUDIT26'] = get_user_by_access('AUDIT-FORM26', $con, $result->user_id, $result->user_role);
    $response['AUDIT27'] = get_user_by_access('AUDIT-FORM27', $con, $result->user_id, $result->user_role);
    $response['AUDIT28'] = get_user_by_access('AUDIT-FORM28', $con, $result->user_id, $result->user_role);
    $response['AUDIT29'] = get_user_by_access('AUDIT-FORM29', $con, $result->user_id, $result->user_role);
    $response['AUDIT30'] = get_user_by_access('AUDIT-FORM30', $con, $result->user_id, $result->user_role);
    $response['AUDIT31'] = get_user_by_access('AUDIT-FORM31', $con, $result->user_id, $result->user_role);
    $response['AUDIT32'] = get_user_by_access('AUDIT-FORM32', $con, $result->user_id, $result->user_role);
    $response['AUDIT33'] = get_user_by_access('AUDIT-FORM33', $con, $result->user_id, $result->user_role);
    $response['AUDIT34'] = get_user_by_access('AUDIT-FORM34', $con, $result->user_id, $result->user_role);



    $response['ASSET-DASHBOARD'] = get_user_by_access('ASSET-DASHBOARD', $con, $result->user_id, $result->user_role);
    $response['PREVENTIVE-MAINTENANCE-FORM'] = get_user_by_access('PREVENTIVE-MAINTENANCE-FORM', $con, $result->user_id, $result->user_role);
    $response['ASSET-CALLIBRATION-FORM'] = get_user_by_access('ASSET-CALLIBRATION-FORM', $con, $result->user_id, $result->user_role);
    $response['EDIT-ASSET'] = get_user_by_access('EDIT-ASSET', $con, $result->user_id, $result->user_role);
    $response['DELETE-ASSET'] = get_user_by_access('DELETE-ASSET', $con, $result->user_id, $result->user_role);

    $response['EDIT-PREVENTIVE-MAINTENANCE'] = get_user_by_access('EDIT-PREVENTIVE-MAINTENANCE', $con, $result->user_id, $result->user_role);


    $response['REGISTER-ASSET-FORM'] = get_user_by_access('REGISTER-ASSET-FORM', $con, $result->user_id, $result->user_role);
    $response['WARRANTY-FORM'] = get_user_by_access('WARRANTY-FORM', $con, $result->user_id, $result->user_role);
    $response['AMC-CMC-FORM'] = get_user_by_access('AMC-CMC-FORM', $con, $result->user_id, $result->user_role);
} else {
    $response['status'] = 'fail';
    $response['message'] = 'Invalid Email Id / Mobile Number / Password';
}
echo $pk = json_encode($response);
exit;
