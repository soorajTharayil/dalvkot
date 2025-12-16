<?php 
include('db.php');

// Query and process setup_int data
$sql = 'SELECT * FROM setup_int';
$result_setup_int = mysqli_query($con, $sql);
$search_list_setup_int = array();

if (mysqli_num_rows($result_setup_int) > 0) {
    while ($row = mysqli_fetch_object($result_setup_int)) {
        $search_list_setup_int[] = $row;
    }
}

$groupedData_int = array();

foreach ($search_list_setup_int as $item) {
    $set = $item->type . "_int";
    if (!isset($groupedData_int[$set])) {
        $groupedData_int[$set] = array();
    }
    $groupedData_int[$set][] = $item;
}

// Query and process setup_service data
$sql = 'SELECT * FROM setup_service';
$result_setup_service = mysqli_query($con, $sql);
$search_list_setup_service = array();

if (mysqli_num_rows($result_setup_service) > 0) {
    while ($row = mysqli_fetch_object($result_setup_service)) {
        $search_list_setup_service[] = $row;
    }
}

$groupedData_service = array();

foreach ($search_list_setup_service as $item) {
    $set = $item->type . "_service";
    if (!isset($groupedData_service[$set])) {
        $groupedData_service[$set] = array();
    }
    $groupedData_service[$set][] = $item;
}

// Merge groupedData_int and groupedData_service
$mergedGroupedData = array_merge($groupedData_int, $groupedData_service);

// $mergedGroupedData will now contain the merged data from groupedData_int and groupedData_service
$extractedData = array();

foreach ($mergedGroupedData as $set => $items) {
    foreach ($items as $item) {
        $extractedData[] = array(
            'title' => $item->title,
			
			'id'  => $item->id,
			'type'  => $set,
			'questionk'  => $item->questionk,
			'questionm'  => $item->questionm,
			'titlek'  => $item->titlek,
			'titlem'  => $item->titlem,
            'question' => $item->question
        );
    }
}
function compareTitles($a, $b) {
    return strcmp($a['title'], $b['title']);
}

// Sort the extracted data array based on title
usort($extractedData, 'compareTitles');

// $extractedData will now contain the extracted "title" and "question" properties ordered by title
// $extractedData will now contain the extracted "title" and "question" properties
echo json_encode($extractedData);
exit;
