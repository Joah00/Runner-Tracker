<?php
$latitude = $_GET['latitude'];
$longitude = $_GET['longitude'];

// Generate the map URL using the latitude and longitude
$mapUrl = "https://maps.googleapis.com/maps/api/staticmap?center=" . $latitude . "," . $longitude . "&zoom=14&size=400x400&key=AIzaSyBEP7RVtlNm7r173pnGTqAWWhEkQlEWCzM";

// Output the map URL
echo $mapUrl;
?>
s