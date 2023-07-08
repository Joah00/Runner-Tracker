<!DOCTYPE>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
		<style>
				body{
				background-image: url("Images/Background.png");
				background-size: cover;
			}
		</style>
	</head>
</html>
<?php

session_start();
$user_id = $_SESSION['ID'];
$date = $_POST['startTime'];

$end_time = $_POST['endTime'];
$start_longitude = $_POST['longitude'];
$start_latitude = $_POST['latitude'];
$coordinates = $_POST['coordinates'];
$speed = $_POST['speed'];
$distance = $_POST['distance'];
$elapsed_time = $_POST['elapsedTime'];
$age = $_POST['user_age'];
$gender = $_POST['user_gender'];
$height = $_POST['user_height'];
$weight = $_POST['user_weight'];
$routeCoordinates = json_decode($coordinates, true);


/*echo $user_id;
echo "Start Time: ", $start_time;
echo "End Time: ", $end_time;
echo "Longitude: ", $start_longitude;
echo "Latitude: ", $start_latitude;
echo "Coordinate: ", $coordinates;
echo "Speed: ", $speed;
echo "Distance: ", $distance;
echo "Elapsed Time: ", $elapsed_time;*/

foreach ($routeCoordinates as $coordinate) {
    $latitude = $coordinate['lat'];
    $longitude = $coordinate['lng'];

   
}

/*echo "Age: " . $age . "<br>";
echo "Gender: " . $gender . "<br>";
echo "Height: " . $height . "<br>";
echo "Weight: " . $weight . "<br>";*/

$servername = "localhost";
$username = "root";
$password = "";
$database = "jotracker";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("INSERT INTO record (user_id, date, time_start, time_end, longitude, latitude, coordinate, speed, distance, eslapsed_time, age, gender, height, weight) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$user_id, $date, $date, $end_time, $start_longitude, $start_latitude, $coordinates, $speed, $distance, $elapsed_time, $age, $gender, $height, $weight]);

    if ($stmt->rowCount() > 0) {
		?>
<div class="d-flex align-items-center justify-content-center vh-100">
  <div class="text-center">
    <h1>RESULT SAVED</h1>
    <h2>View Your Result In History</h2>
    <a href="Main.php" class="btn btn-primary btn-lg">Back To Home</a>
  </div>
</div>
<?php
    } else {
        echo "Error: Unable to insert data into the database.";
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

$conn = null;
