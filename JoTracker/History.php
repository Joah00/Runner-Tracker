<?php
require('User_Header.php');
?>

<!doctype html>
<html>
<head>
    <link rel="stylesheet" href="CSS/Main_Page_Design.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <meta charset="utf-8">
    <title>History</title>
</head>

<body>
<?php
session_start();
$userid = $_SESSION['ID'];

// Connect to the database (same code as before)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jotracker";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve data from the database
$sql = "SELECT * FROM record WHERE user_id = '$userid'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>History Page</title>
    <!-- Add the Google Maps API script -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBEP7RVtlNm7r173pnGTqAWWhEkQlEWCzM"></script>  <!--API for google map, same as previous map on the first page-->
    <style>
        #map {
            height: 400px;
        }
    </style>
</head>

<body>
<h1>History Page</h1>
<div class="container">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Date</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Distance (KM)</th>
                <th>Elapsed Time</th>
                <th>Speed (KM / Min)</th>
                <th>View Result</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['date'] . "</td>";
                    echo "<td>" . date('H:i:s', strtotime($row['time_start'])) . "</td>";
                    echo "<td>" . date('H:i:s', strtotime($row['time_end'])) . "</td>";
                    echo "<td>" . $row['distance'] . " KM</td>";
                    echo "<td>" . $row['eslapsed_time'] . "</td>";
                    echo "<td>" . $row['speed'] . " KM / Min</td>";
                    echo "<td><a href='Result.php?id=" . $row['record_id'] . "' class='btn btn-primary'>View Result</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No records found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

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

</body>

</html>

<?php
$conn->close();
?>
