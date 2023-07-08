<?php
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Database credentials
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "jotracker";

    // Create a new connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the SQL statement using prepared statements
    $sql = "INSERT INTO user (username, email, password) VALUES (?, ?, ?)";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    // Bind the parameters
    $stmt->bind_param("sss", $_POST['username'], $_POST['email'], $_POST['pswd']);

    // Check if the Username already exists
    $checkUsernameQuery = "SELECT * FROM user WHERE username = ?";
    $checkUsernameStmt = $conn->prepare($checkUsernameQuery);
    $checkUsernameStmt->bind_param("s", $_POST['username']);
    $checkUsernameStmt->execute();
    $checkUsernameResult = $checkUsernameStmt->get_result();
    if ($checkUsernameResult->num_rows > 0) {
        echo '<script>alert("USERNAME ALREADY EXISTS!");</script>';
        $checkUsernameStmt->close();
        $conn->close();
		
        die();
    }
    $checkUsernameStmt->close();

    // Check if the Email already exists
    $checkEmailQuery = "SELECT * FROM user WHERE `email` = ?";
    $checkEmailStmt = $conn->prepare($checkEmailQuery);
    $checkEmailStmt->bind_param("s", $_POST['email']);
    $checkEmailStmt->execute();
    $checkEmailResult = $checkEmailStmt->get_result();
    if ($checkEmailResult->num_rows > 0) {
        echo '<script>alert("PHONE NUMBER ALREADY EXISTS!");</script>';
        $checkEmailStmt->close();
        $conn->close();
		
        die();
    }
    $checkEmailStmt->close();

    



    // Execute the statement
    if ($stmt->execute()) {
        echo '<script>alert("Registration successful!");</script>';
        header("Location: Login.php");
        die();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();

    // Close the connection
    $conn->close();
}
?>
