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
    <nav class="navbar navbar-expand-sm navbar-light bg-light">
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
    <div class="container mt-3">
      <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

        <!-- Name -->
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="first_name">First name</label>
            <input type="text" class="form-control" name="first_name" id="first_name" placeholder="First name" maxlength="255" required>
          </div>
          <div class="form-group col-md-6">
            <label for="last_name">Last name</label>
            <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last name" maxlength="255" required>
          </div>
        </div>

        <!-- Profile -->
        <div class="form-row">
          <div class="form-group col-md-3">
            <label for="dob">Date of Birth</label>
            <input type="date" class="form-control" name="dob" id="dob" required>
          </div>

          <div class="form-group col-md-9">
            <label for="club">Club</label>
            <input type="text" class="form-control" name="club" id="club" placeholder="Optional" maxlength="255">
          </div>
        </div>

        <div class="form-group">
          <legend class="col-form-label pt-0">Gender</legend>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender" id="female" value="female" required>
            <label class="form-check-label" for="female">Female</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender" id="male" value="male">
            <label class="form-check-label" for="male">Male</label>
          </div>
        </div>

        <!-- Contact information -->
        <div class="form-group">
          <label for="email_address">Email address</label>
          <input type="email" class="form-control" name="email_address" id="email_address" aria-describedby="emailHelp" placeholder="Your email address" maxlength="254" required>
          <small id="emailHelp" class="form-text text-muted">So we can let you know when the next event is</small>
        </div>

        <!-- Emergency information -->
        <div class="form-group">
          <label for="medical_conditions">Medical Conditions</label>
          <input type="text" class="form-control" name="medical_conditions" id="medical_conditions" aria-describedby="medicalConditionsHelp" placeholder="Anything that you think might impact your participation" maxlength="255">
          <small id="medicalConditionsHelp" class="form-text text-muted">This is only used in case of an emergency</small>
        </div>

        <div class="form-group">
          <label for="emergency_contact_name">Emergency Contact</label>
          <input type="text" class="form-control" name="emergency_contact_name" id="emergency_contact_name" placeholder="Who we should contact in an emergency" maxlength="255" required>
        </div>

        <div class="form-group">
          <label for="emergency_contact_number">Emergency Contact Number</label>
          <input type="text" class="form-control" name="emergency_contact_number" id="emergency_contact_number" placeholder="Number(s) for emergency contact" maxlength="40" required>
        </div>

        <!-- Submit components -->
        <div class="form-group">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="accepted_terms" id="accepted_terms" required>
            <label class="form-check-label" for="accepted_terms">I have read and accepted the <a href="#">terms and conditions</a></label>
          </div>
        </div>

        <div class="form-group">
          <button type="submit" class="btn btn-primary">Register</button>
        </div>
      </form>            
    </div>

    <!-- Feedback -->
    <div class="container">
<?php
/**
 * Returns true if date is in the form yyyy-mm-dd.
 */
function validate_date($date) {
  $date = DateTime::createFromFormat("Y-m-d", $date);
  return $date !== false && !array_sum($date::getLastErrors());
}

if ($_SERVER["REQUEST_METHOD"] == "POST"){
  // Check if variables are set.
  if (isset($_POST['first_name'],
    $_POST['last_name'],
    $_POST['gender'],
    $_POST['dob'],
    $_POST['club'],
    $_POST['email_address'],
    $_POST['medical_conditions'],
    $_POST['emergency_contact_name'],
    $_POST['emergency_contact_number'])
  ) {

    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $gender = trim($_POST['gender']);
    $dob = trim($_POST['dob']);
    $club = trim($_POST['club']);
    $email_address = trim($_POST['email_address']);
    $medical_conditions = trim($_POST['medical_conditions']);
    $emergency_contact_name = trim($_POST['emergency_contact_name']);
    $emergency_contact_number = trim($_POST['emergency_contact_number']);

    // Validate data before it enters the database.
    if (strlen($first_name) > 0 && strlen($first_name) <= 255
      && strlen($last_name) > 0 && strlen($last_name) <= 255
      && ($gender == "female" || $gender == "male")
      && validate_date($dob)
      && strlen($club) <= 255
      && filter_var($email_address, FILTER_VALIDATE_EMAIL)
      && strlen($medical_conditions) <= 255
      && strlen($emergency_contact_name) > 0 && strlen($emergency_contact_name) <= 255
      && strlen($emergency_contact_number) > 0 && strlen($emergency_contact_number) <= 40
    ) {
      try {
        // Setup the database connection.
        $db_host   = 'mysql';
        $db_name   = 'quickreg';
        $db_user   = 'webuser';
        $db_passwd = 'insecure_pw';
        $pdo_dsn   = "mysql:host=$db_host;dbname=$db_name;charset=utf8";

        $pdo = new PDO($pdo_dsn, $db_user, $db_passwd);
        
        /*
         * Disable the emulation of prepared statements and capture errors in
         * logs instead of printing them to the screen
         */
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Use prepared statements to prevent SQL injection.
        $sql = 'INSERT INTO registrations (
                first_name,
                last_name,
                gender,
                dob,
                club,
                email_address,
                medical_conditions,
                emergency_contact_name,
                emergency_contact_number,
                registration_timestamp
            ) VALUES (
                :first_name,
                :last_name,
                :gender,
                :dob,
                :club,
                :email_address,
                :medical_conditions,
                :emergency_contact_name,
                :emergency_contact_number,
                Now()
            )';

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':dob', $dob);
        $stmt->bindParam(':email_address', $email_address);
        $stmt->bindParam(':emergency_contact_name', $emergency_contact_name);
        $stmt->bindParam(':emergency_contact_number', $emergency_contact_number);

        // Use null values if applicable for optionals
        if (!empty($club)) {
          $stmt->bindParam(':club', $club);
        } else {
          $stmt->bindValue(':club', null, PDO::PARAM_INT);
        }
        if (!empty($medical_conditions)) {
          $stmt->bindParam(':medical_conditions', $medical_conditions);
        } else {
          $stmt->bindValue(':medical_conditions', null, PDO::PARAM_INT);
        }

        $stmt->execute();

        // Display user feedback.
        echo '<div class="alert alert-success" role="alert">
            Thank you for registering! You name should now appear in the <a href="/registration-numbers.php" class="alert-link">Registration Numbers</a>
          </div>';

      } catch (PDOException $e) {
        error_log('PDOException - ' . $e->getMessage(), 0);

        if ($e->errorInfo[1] == 1062){
          echo '<div class="alert alert-primary" role="alert">
              It seems that you have already registered. Please check the <a href="/registration-numbers.php" class="alert-link">Registration Numbers</a> to double check if you have registered. If you have registered your name does not appear on the registration numbers then please contact us.
            </div>';
        } else {
          /*
           * Stop executing, return an Internal Server Error HTTP status code
           * (500), and display an error.
           */
          http_response_code(500);
          die('<div class="alert alert-danger" role="alert">
              It seems something has gone wrong on our end. Please try registering again or try later.
            </div>');
        }
      }
    } else {
      /*
       * If data validation failed, stop executing, return a 'Bad request'
       * HTTP status code (400), and display an error.
       */
      http_response_code(400);
      die('<div class="alert alert-danger" role="alert">
        Error processing bad or malformed request
      </div>');
    }
  }
}
?>
    </div>

    <!-- JavaScript at the end of page to load last -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>
