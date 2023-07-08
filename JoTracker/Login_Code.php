<?php
session_start();


$servername = "localhost";
$username = "root";
$password = "";
$database = "jotracker";
	
// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $email = $_POST['email'];
  $password = $_POST['pswd'];

  $sql = "SELECT * FROM user WHERE email='$email' AND password='$password'";

  $result = $conn->query($sql);
  if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $email = $row['email'];
    $password = $row['password'];
    $_SESSION['ID'] = $row['userid'];
    header('Location: Main.php');
    exit();
  } else {
    header('Location: LoginError.php');
    exit();
  }
}
?>