<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
	<?php
// API endpoint URL
$apiUrl = 'https://www.postman.com/supply-participant-3851085/workspace/cars-rental/request/27594897-d4b4699e-0c36-434f-8bec-0a89b63f8e03?ctx=documentation';

// Make an HTTP GET request to the API
$response = file_get_contents($apiUrl);

// Decode the JSON response into a PHP array
$data = json_decode($response, true);

// Check if the API request was successful
if ($data && isset($data['status']) && $data['status'] === 'success') {
    // Display the data
    foreach ($data['results'] as $item) {
        echo '<p>' . $item['Name'] . ': ' . $item['Description'] . '</p>';
    }
} else {
    // API request failed
    echo 'Error retrieving data from the API.';
}
?>

</body>
</html>