<?php 

// echo "<pre>";
// print_r($_POST);
// exit;
// <?php
// Define the list of expected index names
$expectedIndexes = array('ip_hospital_selection', 'ebook_ip_psat', 'ebook_ip_nps', 'ebook_ip_tickets','ebook_ip_bar','ip_response_chart','');

// Iterate through each expected index name
foreach ($expectedIndexes as $indexName) {
    // Check if the index exists in the $_POST array
    if (array_key_exists($indexName, $_POST)) {
        // Retrieve the image data for the current index
        $imageData = $_POST[$indexName];

        // Remove the data type definition from the base64 string before decoding it
        $filteredData = explode(',', $imageData);

        // Check if the data is in the expected format
        if (count($filteredData) == 2) {
            $decodedData = base64_decode($filteredData[1]);

            // Specify the path and name for the new PNG file
            $filePath = 'assets/ebook_images/' . $indexName . '.png';

            // Save the decoded data to a file
            if (file_put_contents($filePath, $decodedData)) {
                echo "$indexName was saved successfully.";
            } else {
                echo "There was an error saving $indexName.";
            }
        } else {
            echo "The provided data is not in the expected format. ($indexName)";
        }
    } else {
        echo "No image data received. ($indexName)";
    }
}
?>
