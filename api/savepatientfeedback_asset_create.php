<?php
include('db.php');
include('phpqrcode/qrlib.php');

$patinet_id = $_GET['patient_id'];
$d = file_get_contents('php://input');
$data = json_decode($d, true);

$fyValues = isset($data['fyAssetValues']) ? json_encode($data['fyAssetValues']) : null;



if (count($data) > 1) {
    date_default_timezone_set('Asia/Kolkata');
    $data['name'] = strtoupper($data['name']);
    $today = date('Y-m-d');

    // Data from the request
    $name =    $data['name'];
    $patientid =    $data['patientid'];
    $assetname =    $data['assetname'];
    $subassetname =    $data['subassetname'];


    $brand =    $data['brand'];
    $model =    $data['model'];
    $serial =    $data['serial'];

    $assetquantity =    $data['assetquantity'];
    $ward = ($data['ward'] !== 'Select Asset Group/ Category') ? $data['ward'] : null;
    $component = ($data['component'] !== 'Select Asset Component') ? $data['component'] : null;
    $depart = ($data['depart'] !== 'Select Asset Department') ? $data['depart'] : null;
    $assigned = ($data['assigned'] !== 'Select Asset User') ? $data['assigned'] : null;
    $email =    $data['email'];
    $contactnumber =    $data['contactnumber'];

    $assetWithPm = ($data['assetWithPm'] !== 'Preventive Maintenance (PM) Applicable') ? $data['assetWithPm'] : null;
    $assetWithWarranty = ($data['assetWithWarranty'] !== 'Asset Warranty Applicable') ? $data['assetWithWarranty'] : null;
    $assetWithAmc = ($data['assetWithAmc'] !== 'Asset AMC/ CMC Applicable') ? $data['assetWithAmc'] : null;
    $assetWithCalibration = ($data['assetWithCalibration'] !== 'Asset Calibration Applicable') ? $data['assetWithCalibration'] : null;



    $unitprice = $data['unitprice'];
    $totalprice = $data['totalprice'];
    $depreciation = $data['depreciation'];
    $locationsite = ($data['locationsite'] !== 'Select Floor/ Area') ? $data['locationsite'] : null;
    $bedno = ($data['bedno'] !== 'Select Site') ? $data['bedno'] : null;
    $supplierinfo = $data['supplierinfo'];
    $servicename = $data['servicename'];
    $servicecon = $data['servicecon'];
    $servicemail = $data['servicemail'];

    $image = $data['image'];
    $data_analysis = $data['dataAnalysis'];
    $assetStatus = "Asset in Use";

    $contract = ($data['contract'] !== 'Select AMC/ CMC') ? $data['contract'] : null;

    if ($contract === 'AMC') {
        $ServiceCharges = $data['amcServiceCharges'];
    } elseif ($contract === 'CMC') {
        $ServiceCharges = $data['cmcServiceCharges'];
    }


    $qr_code_image = $data['qrCodeUrl'];
    $files_name = $data['files_name'];
    $files_name = json_encode($files_name);
    $escaped_files_name = mysqli_real_escape_string($con, $files_name);


    $porder = $data['porder'];
    $invoice = $data['invoice'];
    $grn_no = $data['grn_no'];
    $depreciation = $data['depreciation'];
    $deprValue = $data['calculatedDepreciation'];



    $fyValues = mysqli_real_escape_string($con, is_array($fyValues) ? json_encode($fyValues) : $fyValues);


    $assetCurrentValue = $data['assetCurrentValue'];

    function sanitize_date($date)
    {
        if ($date === 'NaN-aN-aN' || empty($date)) {
            return 'NULL';
        }
        return "'" . $date . "'";
    }

    $purchaseDate = sanitize_date($data['purchaseDate']);
    $lastMaintenance = sanitize_date($data['lastMaintenance']);
    $upcomingMaintenance = sanitize_date($data['upcomingMaintenance']);

    $lastCalibration = sanitize_date($data['lastCalibration']);
    $upcomingCalibration = sanitize_date($data['upcomingCalibration']);

    $warrenty = sanitize_date($data['warrenty']);
    $warrenty_end = sanitize_date($data['warrenty_end']);
    $installDate = sanitize_date($data['installDate']);
    $StartDate = sanitize_date($contract === 'AMC' ? $data['amcStartDate'] : ($contract === 'CMC' ? $data['cmcStartDate'] : ''));
    $EndDate = sanitize_date($contract === 'AMC' ? $data['amcEndDate'] : ($contract === 'CMC' ? $data['cmcEndDate'] : ''));





    // Insert data into `bf_feedback_asset_creation`
    $query1 = 'INSERT INTO `bf_feedback_asset_creation` (`name`, `patientid`, `assetname`, `subassetname`, `brand`, `model`, `serial`, `assetquantity`, `ward`, `component`, `depart`, `assignee`, `mobile`, `email`, `datetime`, `datet`, `purchaseDate`, `warrenty`, `warrenty_end`, `unitprice`, `totalprice`, `depreciation`, `assignstatus`, `locationsite`, `bedno`, `supplierinfo`, `servicename`, `servicecon`, `servicemail`, `image`, `comment`, `dataset`, `preventive_maintenance_date`, `upcoming_preventive_maintenance_date`, `contract`, `contract_start_date`, `contract_end_date`, `contract_service_charges`, `qr_code_image`, `files_name`, `installDate`, `porder`, `invoice`, `grn_no`, `deprValue`, `asset_calibration_date`, `upcoming_calibration_date`, `assetWithPm`, `assetWithWarranty`, `assetWithAmc`, `assetWithCalibration`, `assetCurrentValue`, `fyValues`) 
    VALUES ("' . $name . '", "' . $patientid . '", "' . $assetname . '", "' . $subassetname . '", "' . $brand . '", "' . $model . '", "' . $serial . '", "' . $assetquantity . '", "' . $ward . '", "' . $component . '", "' . $depart . '", "' . $assigned . '", "' . $contactnumber . '", "' . $email . '", "' . date("Y-m-d H:i:s") . '", "' . $today . '", ' . $purchaseDate . ', ' . $warrenty . ', ' . $warrenty_end . ', "' . $unitprice . '", "' . $totalprice . '", "' . $depreciation . '", "' . $assetStatus . '", "' . $locationsite . '", "' . $bedno . '", "' . $supplierinfo . '", "' . $servicename . '", "' . $servicecon . '", "' . $servicemail . '", "' . $image . '", "' . $data_analysis . '", "' . mysqli_real_escape_string($con, json_encode($data)) . '", ' . $lastMaintenance . ', ' . $upcomingMaintenance . ', "' . $contract . '", ' . $StartDate . ', ' . $EndDate . ', "' . $ServiceCharges . '", "' . $qr_code_image . '", "' . $escaped_files_name . '", ' . $installDate . ', "' . $porder . '", "' . $invoice . '", "' . $grn_no . '", "' . $deprValue . '", ' . $lastCalibration . ', ' . $upcomingCalibration . ', "' . $assetWithPm . '", "' . $assetWithWarranty . '", "' . $assetWithAmc . '", "' . $assetWithCalibration . '", "' . $assetCurrentValue . '", "' . $fyValues . '")';



    $result1 = mysqli_query($con, $query1);
    $fid = mysqli_insert_id($con);

    // Insert data into `tickets_asset`
    $query2 = 'INSERT INTO `tickets_asset` (`patientid`, `assetname`, `subassetname`, `brand`, `model`, `serial`, `assetquantity`, `ward`, `component`, `depart`, `assignee`, `purchaseDate`, `warrenty`, `warrenty_end`, `unitprice`, `totalprice`, `depreciation`, `locationsite`, `bedno`, `status`, `supplierinfo`, `created_on`, `contract`, `contract_start_date`, `contract_end_date`, `contract_service_charges`, `deprValue`, `assetWithPm`, `assetWithWarranty`, `assetWithAmc`, `assetWithCalibration`, `assetCurrentValue`) 
    VALUES ("' . $patientid . '", "' . $assetname . '", "' . $subassetname . '", "' . $brand . '", "' . $model . '", "' . $serial . '", "' . $assetquantity . '", "' . $ward . '", "' . $component . '", "' . $depart . '", "' . $assigned . '", ' . $purchaseDate . ', ' . $warrenty . ', ' . $warrenty_end . ', "' . $unitprice . '", "' . $totalprice . '", "' . $depreciation . '", "' . $locationsite . '", "' . $bedno . '", "' . $assetStatus . '", "' . $supplierinfo . '", "' . date("Y-m-d H:i:s") . '", "' . $contract . '", ' . $StartDate . ', ' . $EndDate . ', "' . $ServiceCharges . '", "' . $deprValue . '", "' . $assetWithPm . '", "' . $assetWithWarranty . '", "' . $assetWithAmc . '", "' . $assetWithCalibration . '", "' . $assetCurrentValue . '")';

    $result2 = mysqli_query($con, $query2);


    if ($result1 && $result2) {
        $response['status'] = 'success';
        $response['message'] = 'Data saved successfully in both tables';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Failed to save data';
    }


    echo json_encode($response);

    mysqli_close($con);
}

// TRIGGER CURL.php
$curl = curl_init();
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_URL, $baseurl . 'api/curl.php');
curl_exec($curl);
curl_close($curl);
