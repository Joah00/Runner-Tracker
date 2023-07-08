<?php
require( 'User_Header.php' );
session_start();
$userid = $_SESSION[ 'ID' ];

?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="CSS/Main_Page_Design.css">
<title>JoTracker</title>
<style>
/* Adjust the map container size */
#map {
    height: 400px;
    width: 100%;
}
/* Responsive styles */
.container {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 20px;
    text-align: center;
}
#trackingButton {
    margin-top: 20px;
}
#trackingInfo {
    margin-top: 20px;
}

/* Responsive map size */
@media (max-width: 768px) {
/* Adjust the map size for smaller devices */
#map {
    height: 300px;
}
}
/* Modal styles */
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
}
.modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
}


/* Responsive styles */
@media (max-width: 768px) {
/* Adjust the modal size for smaller devices */
.modal-content {
    width: 90%;
}
}
</style>
</head>
<body>
<form id="hiddenForm" style="display: none;" method="POST" action="Test_Display.php">
  <input type="hidden" id="startTime" name="startTime">
  <input type="hidden" id="endTime" name="endTime">
  <input type="hidden" id="longitude" name="longitude">
  <input type="hidden" id="latitude" name="latitude">
  <input type="hidden" id="coordinates" name="coordinates">
  <input type="hidden" id="speed" name="speed">
  <input type="hidden" id="distance" name="distance">
  <input type="hidden" id="elapsedTime" name="elapsedTime">
  <input type="hidden" id="user_age" name="user_age">
  <input type="hidden" id="user_gender" name="user_gender">
  <input type="hidden" id="user_height" name="user_height">
  <input type="hidden" id="user_weight" name="user_weight">
</form>
<div class="container my-5">
  <div id="userInfoModal" class="modal">
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="userInfoForm">
          <div class="modal-header">
            <h5 class="modal-title">User Information</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="age">Age:</label>
              <input type="number" class="form-control" id="age" name="age" required>
            </div>
            <div class="form-group">
              <label for="gender">Gender:</label>
              <select class="form-control" id="gender" name="gender" required>
                <option value="male">Male</option>
                <option value="female">Female</option>
              </select>
            </div>
            <div class="form-group">
              <label for="height">Height (cm):</label>
              <input type="number" class="form-control" id="height" name="height" required>
            </div>
            <div class="form-group">
              <label for="weight">Weight (kg):</label>
              <input type="number" class="form-control" id="weight" name="weight" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Start Tracking</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div id="map" class="my-4"></div>
  <p id="demo"></p>
  <div id="trackingInfo"></div>
  <button id="trackingButton" class="btn btn-primary my-4" onclick="toggleTracking()">Start Tracking</button>
</div>
<script>
        var x = document.getElementById("trackingInfo");
        var map;
        var marker;
        var watchId; // Variable to store the watch position ID
        var routeCoordinates = [];
        var startTime; // Variable to store the start time
        var tracking = false; // Variable to track if tracking is currently active

        var userInfoModal = document.getElementById("userInfoModal");

        function toggleTracking() {
            if (!tracking) {
                openModal();
            } else {
                stopTracking();
            }
        }

        function openModal() {
            userInfoModal.style.display = "block";
        }

        function closeModal() {
            userInfoModal.style.display = "none";
        }

        // Submit the form and start tracking
        document.getElementById("userInfoForm").addEventListener("submit", function (event) {
            event.preventDefault();
            closeModal();
            startTracking();
        });

        function startTracking() {
    if (navigator.geolocation) {
        // Enable tracking by continuously watching the position
        watchId = navigator.geolocation.watchPosition(showPosition, handleError, {
            enableHighAccuracy: true,
            maximumAge: 0,
            timeout: 5000
        });
        startTime = new Date(); // Set the start time
        startTime.setHours(startTime.getHours() + 6); // Adjust start time to Malaysia time zone (+8 hours)
        tracking = true;
        // Set the start time
        var startTimeInput = document.getElementById("startTime");
        startTimeInput.value = startTime.toISOString(); // Convert the start time to ISO format

        // Start the clock
        startClock();

        document.getElementById("trackingButton").innerHTML = "Stop Tracking";
    } else {
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}

function startClock() {
    var seconds = 0;
    var clockInterval = setInterval(function () {
        const hours = Math.floor(seconds / 3600);
        const minutes = Math.floor((seconds % 3600) / 60);
        const remainingSeconds = seconds % 60;
        const timeString = pad(hours) + ":" + pad(minutes) + ":" + pad(remainingSeconds);
        document.getElementById("demo").innerHTML = timeString;
        seconds++;
    }, 1000);
}

function pad(value) {
    return String(value).padStart(2, '0');
}


        /*function stopTracking() {
            if (navigator.geolocation) {
                // Stop watching the position
                navigator.geolocation.clearWatch(watchId);
                var endTime = new Date(); // Set the end time
                var elapsedTime = endTime - startTime; // Calculate the elapsed time in milliseconds
    			var hours = Math.floor(elapsedTime / (1000 * 60 * 60)); // Convert milliseconds to hours
    			var minutes = Math.floor((elapsedTime % (1000 * 60 * 60)) / (1000 * 60)); // Convert remaining milliseconds to minutes
				var seconds = Math.floor((elapsedTime % (1000 * 60)) / 1000); // Convert remaining milliseconds to seconds

                // Get the latest latitude and longitude
                var latitude = routeCoordinates[routeCoordinates.length - 1].lat;
                var longitude = routeCoordinates[routeCoordinates.length - 1].lng;

                // Calculate and display the distance
                var distance = calculateDistance() / 1000; // Mters to KM
				
				
                x.innerHTML = "Start Time: " + startTime +
                    "<br>End Time: " + endTime +
                    "<br>Elapsed Time: " + hours + " hours, " + minutes + " minutes, " + seconds + " seconds" +
                    "<br>Latest Latitude: " + latitude +
                    "<br>Latest Longitude: " + longitude +
                    "<br>Distance: " + distance.toFixed(2) + " KM";

                // Calculate and display the speed
                var speed = calculateSpeed(distance, elapsedTime);
                x.innerHTML += "<br>Speed: " + speed.toFixed(2) + " meters/minute";

                // Calculate and display the BMI
                var age = parseInt(document.getElementById("age").value);
                var gender = document.getElementById("gender").value;
                var height = parseInt(document.getElementById("height").value);
                var weight = parseInt(document.getElementById("weight").value);
                var bmi = calculateBMI(height, weight);
                var bmiCategory = getBMICategory(bmi);

                x.innerHTML += "<br><br>Age: " + age +
                    "<br>Gender: " + gender +
                    "<br>Height: " + height + " cm" +
                    "<br>Weight: " + weight + " kg" +
                    "<br>BMI: " + bmi.toFixed(2) +
                    "<br>Category: " + bmiCategory;

                tracking = false;
                document.getElementById("trackingButton").innerHTML = "Start Tracking";
				
            }
			
        }*/
		
		function stopTracking() {
    if (navigator.geolocation) {
        // Stop watching the position
        navigator.geolocation.clearWatch(watchId);
        var endTime = new Date(); // Set the end time
		endTime.setHours(endTime.getHours() + 6); // Adjust end time to Malaysia time zone (+8 hours)
        var elapsedTime = Math.floor(endTime - startTime) / 1000; // Calculate the elapsed time in milliseconds
		// Start date and time seperate
//         var startDate = startTimeObj.toISOString().split("T")[0];
//    var startTime = startTimeObj.toISOString().split("T")[1].slice(0, 8);
//    var endDate = endTimeObj.toISOString().split("T")[0];
//    var endTime = endTimeObj.toISOString().split("T")[1].slice(0, 8);
		
		
        var hours = Math.floor(elapsedTime / (1000 * 60 * 60)); // Convert milliseconds to hours
        var minutes = Math.floor((elapsedTime % (1000 * 60 * 60)) / (1000 * 60)); // Convert remaining milliseconds to minutes
        var seconds = Math.floor((elapsedTime % (1000 * 60)) / 1000); // Convert remaining milliseconds to seconds

        // Get the latest latitude and longitude
        var latitude = routeCoordinates[routeCoordinates.length - 1].lat;
        var longitude = routeCoordinates[routeCoordinates.length - 1].lng;

        // Calculate and display the distance
        var distance = calculateDistance() / 1000; // Mters to KM
        x.innerHTML = "Start Time: " + startTime +
            "<br>End Time: " + endTime +
            "<br>Elapsed Time: " + hours + " hours, " + minutes + " minutes, " + seconds + " seconds" +
            "<br>Latest Latitude: " + latitude +
            "<br>Latest Longitude: " + longitude +
            "<br>Distance: " + distance.toFixed(2) + " KM";

        // Calculate and display the speed
        var speed = calculateSpeed(distance, elapsedTime);
        x.innerHTML += "<br>Speed: " + speed.toFixed(2) + " meters/minute";

        // Calculate and display the BMI
        var age = parseInt(document.getElementById("age").value);
        var gender = document.getElementById("gender").value;
        var height = parseInt(document.getElementById("height").value);
        var weight = parseInt(document.getElementById("weight").value);
        var bmi = calculateBMI(height, weight);
        var bmiCategory = getBMICategory(bmi);

        x.innerHTML += "<br><br>Age: " + age +
            "<br>Gender: " + gender +
            "<br>Height: " + height + " cm" +
            "<br>Weight: " + weight + " kg" +
            "<br>BMI: " + bmi.toFixed(2) +
            "<br>Category: " + bmiCategory;

		
        // Set the form values
        document.getElementById("longitude").value = longitude;
        document.getElementById("latitude").value = latitude;
        document.getElementById("coordinates").value = JSON.stringify(routeCoordinates);
        document.getElementById("speed").value = speed.toFixed(2);
        document.getElementById("distance").value = distance.toFixed(2);
        document.getElementById("elapsedTime").value = elapsedTime;
var endTimeInput = document.getElementById("endTime");
    endTimeInput.value = endTime.toISOString(); // Convert the end time to ISO format
        // Show the hidden form and submit it
		document.getElementById("user_age").value = age;
        document.getElementById("user_gender").value = gender;
        document.getElementById("user_height").value = height;
        document.getElementById("user_weight").value = weight;
		
		
		
		
        document.getElementById("hiddenForm").style.display = "block";
        document.getElementById("hiddenForm").submit();

        tracking = false;
        document.getElementById("trackingButton").innerHTML = "Start Tracking";
    }
}

		








        function showPosition(position) {
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;

            // Update the route coordinates
            routeCoordinates.push({ lat: latitude, lng: longitude });

            // Display the current latitude and longitude
            //x.innerHTML = "Latitude: " + latitude + "<br>Longitude: " + longitude;

            // Display the map using the current coordinates and route
            displayMap(latitude, longitude);
        }

        function displayMap(latitude, longitude) {
            // Create a map centered at the given latitude and longitude
            if (!map) {
                map = new google.maps.Map(document.getElementById('map'), {
                    center: { lat: latitude, lng: longitude },
                    zoom: 16 // Adjust the zoom level as needed
                });
            }

            // Create a marker at the current position
            if (!marker) {
                marker = new google.maps.Marker({
                    position: { lat: latitude, lng: longitude },
                    map: map
                });
            }

            // Update the marker position
            marker.setPosition({ lat: latitude, lng: longitude });

            // Create a Polyline to display the route
            var routePath = new google.maps.Polyline({
                path: routeCoordinates,
                geodesic: true,
                strokeColor: '#FF0000',
                strokeOpacity: 1.0,
                strokeWeight: 2
            });

            // Set the Polyline on the map
            routePath.setMap(map);
        }

        function calculateDistance() {
            var distance = 0;
            for (var i = 1; i < routeCoordinates.length; i++) {
                distance += getDistance(
                    routeCoordinates[i - 1].lat,
                    routeCoordinates[i - 1].lng,
                    routeCoordinates[i].lat,
                    routeCoordinates[i].lng
                );
            }
            return distance;
        }

        function getDistance(lat1, lon1, lat2, lon2) {
            var R = 6371; // Radius of the earth in km
            var dLat = deg2rad(lat2 - lat1); // deg2rad below
            var dLon = deg2rad(lon2 - lon1);
            var a =
                Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
                Math.sin(dLon / 2) * Math.sin(dLon / 2);
            var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            var d = R * c; // Distance in km
            return d * 1000; // Convert to meters
        }

        function deg2rad(deg) {
            return deg * (Math.PI / 180);
        }

        function calculateSpeed(distance, elapsedTime) {
            var minutes = elapsedTime / (1000 * 60); // Convert milliseconds to seconds
			var speed = distance / 1000 / minutes;
            return minutes;
        }

        function calculateBMI(height, weight) {
            var heightMeters = height / 100; // Convert height to meters
            return weight / (heightMeters * heightMeters);
        }

        function getBMICategory(bmi) {
            if (bmi < 18.5) {
                return "Underweight";
            } else if (bmi >= 18.5 && bmi < 25) {
                return "Normal weight";
            } else if (bmi >= 25 && bmi < 30) {
                return "Overweight";
            } else {
                return "Obese";
            }
        }

        function handleError(error) {
            switch (error.code) {
                case error.PERMISSION_DENIED:
                    x.innerHTML = "User denied the request for Geolocation."
                    break;
                case error.POSITION_UNAVAILABLE:
                    x.innerHTML = "Location information is unavailable."
                    break;
                case error.TIMEOUT:
                    x.innerHTML = "The request to get user location timed out."
                    break;
                case error.UNKNOWN_ERROR:
                    x.innerHTML = "An unknown error occurred."
                    break;
            }
        }
    </script> 
<script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBEP7RVtlNm7r173pnGTqAWWhEkQlEWCzM&callback=initMap">
<!--API for google map, it has many functions including polyline according to the coordinate detected, getter for coordinate-->
    </script>
<?php
?>
</body>
</html>
