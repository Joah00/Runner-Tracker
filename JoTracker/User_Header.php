<!DOCTYPE html>
<html>
<head>
<style>
.logo{
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 5px;
    width: 70px;
}
    body{
        background-image:url("Images/Background.jpg");
    }
  </style>

    <!-- Add Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="CSS/styles2.css">
</head>
<body>
    
    <nav class="navbar navbar-expand-lg">
    <img class="logo" src="Images/JoTracker_Logo-.png" alt="">
    <div>
    <h3>JoTracker<h3>
</div>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="Main.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="History.php">History</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="About_Us.php">About Us</a>
            </li>
			
			<li>
				<a class="nav-link" href="#" onclick="confirmLogout()">Logout</i></a>
		</li>
        </ul>
    </nav>

    <!-- Add Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script>function confirmLogout() {
        var result = confirm("Are you sure you want to logout?");
        if (result) {
            window.location.href = "Login.php";
        }
    }</script>
</body>
</html>
