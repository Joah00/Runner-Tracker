<?php
require('User_Header.php');
session_start();
$userid = $_SESSION['ID'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <title>About Us</title>
</head>

<body>

  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <img src="Images/run.png" alt="" class="img-fluid">
      </div>
      <div class="col-md-6">
        <h1>About Us</h1>
        <p>At our running tracker, we are passionate about empowering runners of all levels to achieve their fitness goals. Our innovative platform provides a comprehensive suite of tools to enhance your running experience and track your progress precisely. Whether you're a beginner just starting your running journey or a seasoned athlete aiming for a personal best, our tracker offers real-time GPS tracking, distance, pace, calorie tracking, and insightful analytics to help you analyze and improve your performance. With a user-friendly interface and customizable features, we strive to make your running sessions more enjoyable, motivating, and rewarding. Join us today, and let's conquer new milestones together.</p>
      </div>
    </div>
  </div>


  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <br>
        <br>
        <br>
      <p>Our exercise tracker provides numerous benefits for individuals looking to enhance their fitness journey. Our intuitive and user-friendly platform allows users to track their workouts, monitor progress, and stay motivated. With the ability to log various exercises, record sets and repetitions, and track durations, our tracker provides a comprehensive overview of your fitness routine.
</p>
        <p>Additionally, the tracker offers insightful analytics and personalized recommendations based on your goals and performance, enabling you to make informed decisions and optimize your training. By leveraging the power of our exercise tracker, you can effectively monitor your progress, stay accountable, and achieve better results, ultimately leading to improved health and overall well-being.</p>
      </div>
      <div class="col-md-6">
        <h1>Why Use Us</h1>
        <img src="Images/think.jpg" alt="" class="img-fluid">
      </div>
    </div>
  </div>

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>
