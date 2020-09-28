<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Registration Numbers</title>
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
            <a class="nav-item nav-link" href="/registration-form.php">Register Online</a>
            <a class="nav-item nav-link active" href="#">Registration Numbers</a>
          </div>
        </div>
      </div>
    </nav>

    <!-- Registrations table -->
    <div class="container">
      <div class="input-group my-3">
        <div class="input-group-prepend">
          <span class="input-group-text" id="basic-addon1">Search</span>
        </div>
        <input type="text" class="form-control" id="search" onkeyup="filterRegistrations()" placeholder="Name or number accepted" aria-label="Name" aria-describedby="basic-addon2">
      </div>

      <table class="table table-striped" id="registrations">
        <thead>
          <tr>
            <th scope="col">Last Name</th>
            <th scope="col">First Name</th>
            <th scope="col">Registration Number</th>
          </tr>
        </thead>
        <tbody>
<?php
$host = getenv('DB_HOST');
$db   = getenv('DB_NAME');
$user = getenv('DB_USER');
$pass = getenv('DB_PASS');
$charset = 'utf8';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
PDO::ATTR_EMULATE_PREPARES   => false,
];
try {
  $pdo = new PDO($dsn, $user, $pass, $options);

  $stmt = $pdo->prepare('SELECT last_name,first_name,id FROM registrations ORDER BY last_name,first_name');
  $stmt->execute();

  foreach ($stmt as $row) {
    echo '<tr>
            <td>'.$row['last_name'].'</td>
            <td>'.$row['first_name'].'</td>
            <td>'.$row['id'].'</td>
          </tr>';
  }
} catch (PDOException $e) {
  error_log('PDOException - ' . $e->getMessage(), 0);
  http_response_code(500);
  die('<div class="alert alert-danger" role="alert">It seems something has gone wrong on our end. Please try again later.</div>');
}
?>
        </tbody>
      </table>
    </div>

    <script>
    function filterRegistrations() {
      var input, filter, table, tr, td0, td1, td2, i;
      var lastName, firstName, regNumber;

      input = document.getElementById("search");
      filter = input.value.toLowerCase();
      table = document.getElementById("registrations");
      tr = table.getElementsByTagName("tr");

      // Hide rows that don't match
      for (i = 0; i < tr.length; i++) {
        td0 = tr[i].getElementsByTagName("td")[0];
        td1 = tr[i].getElementsByTagName("td")[1];
        td2 = tr[i].getElementsByTagName("td")[2];

        if (td0 && td1 && td2) {
          lastName = td0.textContent || td0.innerText;
          firstName = td1.textContent || td1.innerText;
          regNumber = td2.textContent || td2.innerText;

          if (lastName.toLowerCase().indexOf(filter) > -1
              || firstName.toLowerCase().indexOf(filter) > -1
              || regNumber.indexOf(filter) > -1) {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        }
      }
    }
    </script>

    <!-- JavaScript at the end of page to load last -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>
