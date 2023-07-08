<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/styles2.css">
    <link rel="stylesheet" href="CSS/Main_Page_Design.css">
    <title>BMI Calculator</title>
</head>
<body>
  <header>
    <img class="logo" src="Images/logo.svg" alt="logo">
    <nav>
        <ul class="nav__links">
            <li><a href="Main.html">Home</a></li>
            <li><a href="#">Features</a></li>
            <li><a href="AboutUs.html">About Us</a></li>
        </ul>
    </nav>
    <a class="cta" href="Register info.html"><button>Register BMI</button></a>
</header>
    <div class="container">
        <div class="box">
          <h1>BMI Calculator</h1>
          <div class="content">


            <div class="input">
                <label for="height">Age</label>
                <input type="text" class="text-input" id="age" autocomplete="off" required/>
            </div>

            <div class="gender">

                <label class="container">
                    <input type="radio" name="radio" id="m"><p class="text">Male</p>
                    <span class="checkmark"></span>
                  </label>


                <label class="container">
                    <input type="radio" name="radio" id="f" ><p class="text">Female</p>
                      <span class="checkmark"></span>
                    </label>

            </div>

            <div class="containerHW">
            <div class="inputH">
              <label for="height">Height(cm)</label>
              <input type="number" id="height" required>
            </div>

            <div class="inputW">
              <label for="weight">Weight(kg)</label>
              <input type="number" id="weight" required>
            </div>
          </div>

            <button class="calculate" id="submit" onclick="calculate();">Calculate BMI</button>
          </div>
          <div class="result">
            <p>Your BMI is</p>
            <div id="result">00.00</div>
            <p class="comment"></p>
          </div>

        </div>
      </div>
    <!-- The Modal -->
    <div id="myModal" class="modal">
      <!-- Modal content -->
    <div class="modal-content">
      <span class="close">&times;</span>
      <p id="modalText"></p>
    </div></div>
 
<script src="JS/script.js"></script>

</body>
</html>