<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Register Online</title>
  </head>
  <body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container">
        <a class="navbar-brand" href="/">QuickREG</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarToggler">
          <div class="navbar-nav">
            <a class="nav-item nav-link active" href="#">Register Online</a>
            <a class="nav-item nav-link" href="/registration-numbers.php">Registration Numbers</a>
          </div>
        </div>
      </div>
    </nav>

    <!-- Registration form -->
    <fieldset>
      <legend><h1>Register</h1></legend>
      <form action="" method="POST">
        <label for="first_name">First Name</label>
        <input type="text" name="first_name" id="first_name" maxlength="255" required>

        <br>
        <label for="last_name">Last Name</label>
        <input type="text" name="last_name" id="last_name" maxlength="255" required>

        <br>
        <label>Gender</label>
        <input type="radio" id="male" name="gender" value="male" required>
          <label for="male">Male</label>
          <input type="radio" id="female" name="gender" value="female" required>
          <label for="female">Female</label>

         <br> 
        <label for="club">Club</label>
        <input type="text" name="club" id="club" maxlength="255">

        <br>
        <label for="dob">Date of Birth</label>
        <input type="date" name="dob" id="dob" required>

        <br>
        <label for="email_address">Email Address</label>
        <input type="email" name="email_address" id="email_address" required maxlength="254">

        <br>
        <label for="medical_conditions">Medical Conditions</label>
        <input type="text" name="medical_conditions" id="medical_conditions" maxlength=255">

        <br>
        <label for="emergency_contact_name">Emergency Contact Name</label>
        <input type="text" name="emergency_contact_name" id="emergency_contact_name" required maxlength="255">

        <br>
        <label for="emergency_contact_number">Emergency Contact Number</label>
        <input type="text" name="emergency_contact_number"  id="emergency_contact_number" required maxlength="40">
        <br>
        <button>Register</button>
      </form>            
    </fieldset>

    <!-- JavaScript at the end of page to load last -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>

<?php
  function throw_if_null($key, $value){
    if ($value == null){
      throw new Exception("$key is null!");
    }
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST"){

    $first_name = $_POST['first_name'];
    throw_if_null("first_name", $first_name);

    $last_name = $_POST['last_name'];
    throw_if_null("last_name", $last_name);

    $gender = $_POST['gender'];
    throw_if_null("gender", $gender);


    $dob = $_POST['dob'];
    throw_if_null("dob", $dob);


    $club = $_POST['club'];

    $email_address = $_POST['email_address'];
    throw_if_null("email_address", $email_address);

    $medical_conditions = $_POST['medical_conditions'];

    $emergency_contact_name = $_POST['emergency_contact_name'];
    throw_if_null("emergency_contact_name", $emergency_contact_name);

    $emergency_contact_number = $_POST['emergency_contact_number'];
    throw_if_null("emergency_contact_number", $emergency_contact_number);

    $db_host   = 'mysql';
    $db_name   = 'quickreg';
    $db_user   = 'webuser';
    $db_passwd = 'insecure_pw';

    $registration_timestamp = date('Y-m-d H:i:s');

    $pdo_dsn = "mysql:host=$db_host;dbname=$db_name;charset=utf8";
    $conn   	= new PDO($pdo_dsn, $db_user, $db_passwd);
    $sql 		= "INSERT INTO registrations (first_name, last_name, gender, dob, club, email_address, medical_conditions, emergency_contact_name, emergency_contact_number, registration_timestamp) VALUES (:first_name, :last_name, :gender, :dob, :club, :email_address, :medical_conditions, :emergency_contact_name, :emergency_contact_number, :registration_timestamp)";
    
    $stmt 		= $conn->prepare($sql);

    $stmt->bindParam(':first_name',               $first_name);
    $stmt->bindParam(':last_name',                $last_name);
    $stmt->bindParam(':gender',                   $gender);
    $stmt->bindParam(':dob',                      $dob);
    $stmt->bindParam(':club',                     $club);
    $stmt->bindParam(':email_address',            $email_address);
    $stmt->bindParam(':medical_conditions',       $medical_conditions);
    $stmt->bindParam(':emergency_contact_name',   $emergency_contact_name);
    $stmt->bindParam(':emergency_contact_number', $emergency_contact_number);
    $stmt->bindParam(':registration_timestamp',   $registration_timestamp);

    $stmt->execute();

  echo '<p>Thank you for registering!</p>';
  }
?>
