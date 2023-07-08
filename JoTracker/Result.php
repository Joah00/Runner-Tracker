<?php
require('User_Header.php');

// Check if the record ID is provided in the URL
if (isset($_GET['id'])) {
    // Retrieve the record ID from the URL
    $recordId = $_GET['id'];

    // Connect to the database (same code as before)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "jotracker";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve the record based on the ID
    $sql = "SELECT * FROM record WHERE record_id = '$recordId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $longitude = $row['longitude'];
        $latitude = $row['latitude'];
        $coordinate = $row['coordinate'];
        $date = $row['date'];
        $timeStart = date('H:i:s', strtotime($row['time_start']));
        $timeEnd = date('H:i:s', strtotime($row['time_end']));
        $distance = $row['distance'];
        $elapsedTime = $row['eslapsed_time'];
        $speed = $row['speed'];
		$age = $row['age'];
		$gender = $row['gender'];
		$height = $row['height'];
		$weight = $row['weight'];
        $coordinates = json_decode($coordinate, true);
    } else {
        // If the record is not found, display an error message or redirect to an error page
        echo "Record not found";
        exit;
    }
} else {
    // If the record ID is not provided in the URL, display an error message or redirect to an error page
    echo "Invalid request";
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Result Page</title>
    <!-- Add the Google Maps API script -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBEP7RVtlNm7r173pnGTqAWWhEkQlEWCzM"></script>
	<link rel="stylesheet" href="CSS/Main_Page_Design.css">
    <style>
        #map {
            height: 400px;
        }
    </style>
    <!-- Add Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>

<body>
    <h1>Result Page</h1>
    

    <!-- Add a map container -->
    <div id="map"></div>

    <script>
        function showRoute() {
            var mapOptions = {
                center: {
                    lat: <?php echo $latitude; ?>,
                    lng: <?php echo $longitude; ?>
                },
                zoom: 15
            };

            // Create a map instance
            var map = new google.maps.Map(document.getElementById("map"), mapOptions);

            // Create a marker at the specified location
            var marker = new google.maps.Marker({
                position: {
                    lat: <?php echo $latitude; ?>,
                    lng: <?php echo $longitude; ?>
                },
                map: map,
                title: "Start Location"
            });

            // Create an array to store the LatLng objects
            var LatLngArray = [];

            // Convert each coordinate to a LatLng object and add it to the array
            <?php foreach ($coordinates as $coord): ?>
            LatLngArray.push(new google.maps.LatLng(<?php echo $coord['lat']; ?>, <?php echo $coord['lng']; ?>));
            <?php endforeach; ?>

            // Create a polyline with the LatLng array
            var routePath = new google.maps.Polyline({
                path: LatLngArray,
                geodesic: true,
                strokeColor: "#FF0000",
                strokeOpacity: 1.0,
                strokeWeight: 2
            });

            // Set the polyline on the map
            routePath.setMap(map);
        }

        // Call the showRoute function when the page is loaded
        google.maps.event.addDomListener(window, 'load', showRoute);
    </script>

    <!-- Add Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>

</html>
<!--Record Information-->
<div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Record Information</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th>Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Distance (KM)</th>
                        <th>Elapsed Time</th>
                        <th>Speed (KM / Min)</th>
                    </tr>
                    <tr>
                        <td><?php echo $date; ?></td>
                        <td><?php echo $timeStart; ?></td>
                        <td><?php echo $timeEnd; ?></td>
                        <td><?php echo $distance; ?> KM</td>
                        <td><?php echo $elapsedTime; ?></td>
                        <td><?php echo $speed; ?> KM / Min</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

<!--BMI-->
<!--BMI-->
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">BMI RESULT</h5>
        </div>
		<div class="card">
        <div class="card-body">
            <div class="bmi-result">
                <?php
                // Perform BMI calculation
                $heightInMeters = $height / 100; // Convert height from cm to meters
                $bmi = $weight / ($heightInMeters * $heightInMeters);

                // Determine BMI category
                $category = "";
                if ($bmi < 18.5) {
                    $category = "Underweight";
                } elseif ($bmi >= 18.5 && $bmi < 25) {
                    $category = "Normal Weight";
                } elseif ($bmi >= 25 && $bmi < 30) {
                    $category = "Overweight";
                } elseif ($bmi >= 30) {
                    $category = "Obese";
                }
                ?>
                <h3>BMI: <?php echo number_format($bmi, 2); ?></h3>
                <p>Category: <?php echo $category; ?></p>
            </div>
        </div>
    </div>
</div>

<?php

$conn->close();
?>
