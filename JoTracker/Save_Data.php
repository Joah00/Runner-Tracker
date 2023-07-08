<?php

session_start();
$user_id = $_SESSION['ID'];
$start_time = $_POST['startTime'];
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
echo $user_id;
echo "Start Time: ", $start_time;
echo "End Time: ", $end_time;
echo "Longitude: ", $start_longitude;
echo "Latitude: ", $start_latitude;
echo "Coordinate: ", $coordinates;
echo "Speed: ", $speed;
echo "Distance: ", $distance;
echo "Elapsed Time: ", $elapsed_time;

foreach ($routeCoordinates as $coordinate) {
    $latitude = $coordinate['lat'];
    $longitude = $coordinate['lng'];

    // Do something with the latitude and longitude values
    // For example, you can store them in a database or perform calculations
}

echo "Age: " . $age . "<br>";
echo "Gender: " . $gender . "<br>";
echo "Height: " . $height . "<br>";
echo "Weight: " . $weight . "<br>";

$servername = "localhost";
$username = "root";
$password = "";
$database = "jotracker";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("INSERT INTO record (user_id, start_time, end_time, longitude, latitude, coordinate, speed, distance, eslapsed_time, age, gender, height, weight) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$user_id, $start_time, $end_time, $start_longitude, $start_latitude, $coordinates, $speed, $distance, $elapsed_time, $age, $gender, $height, $weight]);

    if ($stmt->rowCount() > 0) {
        echo "Data inserted into the database successfully.";
    } else {
        echo "Error: Unable to insert data into the database.";
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

$conn = null;
