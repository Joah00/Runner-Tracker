<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <!-- reCAPTCHA script -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link rel="stylesheet" type="text/css" href="CSS/Login.css">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
    <style>
        div#api {
            text-align: -webkit-center;
        }
		.password-container .password-toggle-btn {
    border: none;
    background: none;
    color: #000;
    cursor: pointer;
    font-size: 14px;
    margin-top: 5px;
}
    </style>
</head>
<body>

<div class="main">
    <input type="checkbox" id="chk" aria-hidden="true">

    <div class="signup">
    <form action="Register_Code.php" method="POST">
        <label for="chk" aria-hidden="true">Sign up</label>
        <input type="text" name="username" placeholder="Username" required="">
        <div class="password-container">
        <input type="email" name="email" placeholder="Email" required="">
            <input type="password" name="pswd" id="signupPassword" placeholder="Password" required="">
            <button type="button" class="password-toggle-btn" id="signupPassword-toggle-btn" onclick="togglePasswordVisibility('signupPassword')">
                Show Password
            </button>
        </div>
        <button type="submit">Sign up</button>
            <div class="form-group" id="api">
                <div class="g-recaptcha" data-sitekey="6LcAVuomAAAAAHeDaTYllZD1gEM7OVddtGAqvtjs"></div>
            </div>
        </form>
    </div>
    <div class="login">
    <form action="Login_Code.php" method="POST">
        <label for="chk" aria-hidden="true">Login</label>
        <input type="email" name="email" placeholder="Email" required="">
        <div class="password-container">
            <input type="password" name="pswd" id="loginPassword" placeholder="Password" required="">
            <button type="button" class="password-toggle-btn" id="loginPassword-toggle-btn" onclick="togglePasswordVisibility('loginPassword')">
                Show Password
            </button>
        </div>
        <button type="submit">Login</button>
            <div class="form-group" id="api">
                <div class="g-recaptcha" data-sitekey="6LcAVuomAAAAAHeDaTYllZD1gEM7OVddtGAqvtjs"></div>  <!--API for recaptha-->
            </div>
        </form>
    </div>
</div>

<script>
    function togglePasswordVisibility(inputId) {
        const passwordInput = document.getElementById(inputId);
        const passwordToggleBtn = document.getElementById(inputId + "-toggle-btn");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            passwordToggleBtn.textContent = "Hide Password";
        } else {
            passwordInput.type = "password";
            passwordToggleBtn.textContent = "Show Password";
        }
    }

    
</script>

</body>
</html>
