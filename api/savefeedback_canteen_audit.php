<?php
include('db.php');

$patinet_id = $_GET['patient_id'];
$d = file_get_contents('php://input');

$data = json_decode($d, true);

if (count($data) > 1) {
	date_default_timezone_set('Asia/Kolkata');
	$data['name'] = strtoupper($data['name']);
	$today = date('Y-m-d');



	$name =	$data['name'];
	$email =	$data['email'];
	$contactnumber =	$data['contactnumber'];


	$designation = $data['department'];


	$identification_details = $data['identification_details'];
	$vital_signs = $data['vital_signs'];
	$surgery = $data['surgery'];
	$complaints_communicated = $data['complaints_communicated'];
	$intake = $data['intake'];
	$output = $data['output'];
	$allergies = $data['allergies'];
	$medication = $data['medication'];
	$diagnostic = $data['diagnostic'];
	$lab_results = $data['lab_results'];
	$pending_investigation = $data['pending_investigation'];
	$medicine_order = $data['medicine_order'];
	$facility_communicated = $data['facility_communicated'];
	$health_education = $data['health_education'];
	$risk_assessment = $data['risk_assessment'];
	$urethral = $data['urethral'];
	$urine_sample = $data['urine_sample'];
	$bystander = $data['bystander'];
	$instruments = $data['instruments'];
	$sterile = $data['sterile'];
	$antibiotics = $data['antibiotics'];
	$surgical_site = $data['surgical_site'];
	$wound = $data['wound'];
	$documented = $data['documented'];

	$adequate_facilities = $data['adequate_facilities'];
	$sufficient_lighting = $data['sufficient_lighting'];
	$storage_facility_for_food = $data['storage_facility_for_food'];
	$personnel_hygiene_facilities = $data['personnel_hygiene_facilities'];
	$food_material_testing = $data['food_material_testing'];
	$incoming_material = $data['incoming_material'];
	$raw_materials_inspection = $data['raw_materials_inspection'];
	$storage_of_materials = $data['storage_of_materials'];
	$raw_materials_cleaning = $data['raw_materials_cleaning'];
	$equipment_sanitization = $data['equipment_sanitization'];
	$frozen_food_thawing = $data['frozen_food_thawing'];
	$vegetarian_and_non_vegetarian = $data['vegetarian_and_non_vegetarian'];
	$cooked_food_cooling = $data['cooked_food_cooling'];
	$food_portioning = $data['food_portioning'];
	$temperature_control = $data['temperature_control'];
	$reheating_food = $data['reheating_food'];
	$oil_suitability = $data['oil_suitability'];
	$vehicles_for_food = $data['vehicles_for_food'];
	$food_non_food_separation = $data['food_non_food_separation'];
	$cutlery_crockery = $data['cutlery_crockery'];
	$packaging_material_quality = $data['packaging_material_quality'];
	$equipment_cleaning = $data['equipment_cleaning'];
	$pm_of_equipment = $data['pm_of_equipment'];
	$measuring_devices = $data['measuring_devices'];
	$pest_control_program = $data['pest_control_program'];
	$drain_design = $data['drain_design'];
	$food_waste_removal = $data['food_waste_removal'];
	$food_handler_medical = $data['food_handler_medical'];
	$ill_individual_exclusion = $data['ill_individual_exclusion'];
	$food_handler_personal = $data['food_handler_personal'];
	$food_handler_protection = $data['food_handler_protection'];
	$consumer_complaints = $data['consumer_complaints'];
	$food_handler_training = $data['food_handler_training'];
	$documentation_and_records = $data['documentation_and_records'];
	$tables_and_chairs = $data['tables_and_chairs'];
	$waiting_time_for_food = $data['waiting_time_for_food'];
	$inpatient_food_schedule = $data['inpatient_food_schedule'];
	$use_of_banned_synthetic = $data['use_of_banned_synthetic'];
	$vegetable_oil = $data['vegetable_oil'];
	$used_oil_disposal = $data['used_oil_disposal'];
	$used_oil_collection = $data['used_oil_collection'];
	$monitoring_food_waste = $data['monitoring_food_waste'];
	$food_waste_reduction = $data['food_waste_reduction'];
	$food_waste_recycling = $data['food_waste_recycling'];
	$surplus_food = $data['surplus_food'];
	$plastic_use = $data['plastic_use'];
	$waste_collection = $data['waste_collection'];
	$recycling_and_reusing = $data['recycling_and_reusing'];
	$awareness_messages = $data['awareness_messages'];
	$celebration = $data['celebration'];
	$healthy_food_choices = $data['healthy_food_choices'];
	$encouraging_healthier = $data['encouraging_healthier'];
	$feedback_system = $data['feedback_system'];


	$comments = $data['dataAnalysis'];
	


   $query = 'INSERT INTO `bf_feedback_canteen_audit` (`name`,`mobile`,`email`,`datetime`,`datet`,`designation`,`staffname`,`identification_details`,`vital_signs`,`surgery`,`complaints_communicated`,`intake`,`output`,`allergies`,`medication`,`diagnostic`,`lab_results`,`pending_investigation`,`medicine_order`,`facility_communicated`,`health_education`,`risk_assessment`,`urethral`,`urine_sample`,`bystander`,`instruments`,`sterile`,`antibiotics`,`surgical_site`,`wound`,`documented`,`comments`, `dataset`) 
   VALUES ("' . $name . '","'  . $contactnumber . '","' . $email . '","' . date('Y-m-d H:i:s') . '","' . $today . '","' . $designation . '","' . $staffname . '","' . $identification_details . '","' . $vital_signs . '","' . $surgery . '","' . $complaints_communicated . '","' . $intake . '","' . $output . '","' . $allergies . '","' . $medication . '","' . $diagnostic . '","' . $lab_results . '","' . $pending_investigation . '","' . $medicine_order . '","' . $facility_communicated . '","' . $health_education . '","' . $risk_assessment . '","' . $urethral . '","' . $urine_sample . '","' . $bystander . '","' . $instruments . '","' . $sterile . '","' . $antibiotics . '","' . $surgical_site . '","' . $wound . '","' . $documented . '","' . $comments . '","' . mysqli_real_escape_string($con, json_encode($data)) . '")';

	$result = mysqli_query($con, $query);
	$fid = mysqli_insert_id($con);

	$response['status'] = 'success';
	$response['message'] = 'Data saved sucessfully';

	echo json_encode($response);


	mysqli_close($con);
}


//TRIGGER CURL.php
$curl = curl_init();
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_URL, $baseurl . 'api/curl.php');
curl_exec($curl);
