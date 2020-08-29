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
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
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
      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">Last Name</th>
            <th scope="col">First Name</th>
            <th scope="col">Bib Number</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $db_host   = 'mysql';
            $db_name   = 'quickreg';
            $db_user   = 'webuser';
            $db_passwd = 'insecure_pw';

            $pdo_dsn = "mysql:host=$db_host;dbname=$db_name;charset=utf8";

            $pdo   = new PDO($pdo_dsn, $db_user, $db_passwd);
            $query = $pdo->query("SELECT last_name,first_name,id FROM registrations
                                  ORDER BY last_name, first_name");

            while($row = $query->fetch()){
              echo "<tr>
                      <td>".$row["last_name"]."</td>
                      <td>".$row["first_name"]."</td>
                      <td>".$row["id"]."</td>
                    </tr>";
            }
          ?>
        </tbody>
      </table>
    </div>

    <!-- JavaScript at the end of page to load last -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>