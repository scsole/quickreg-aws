<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <title>Hello World!</title>
  </head>
  <body>
    <div class="container">
      <?php
        $db_host   = 'mysql';
        $db_name   = 'quickreg';
        $db_user   = 'webuser';
        $db_passwd = 'insecure_pw';

        $pdo_dsn = "mysql:host=$db_host;dbname=$db_name;charset=utf8";

        $conn   = new PDO($pdo_dsn, $db_user, $db_passwd);
        $query  = $conn->query("SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'quickreg'");
        $tables = $query->fetchAll(PDO::FETCH_COLUMN);

        if (empty($tables)) {
            echo '<p class="text-center">Database <code>quickreg</code> contains no tables.</p>';
        } else {
            echo '<p class="text-center">Database <code>quickreg</code> contains the following tables:</p>';
            echo '<ul class="text-center">';
            foreach ($tables as $table) {
                echo "<li>{$table}</li>";
            }
            echo '</ul>';
        }
      ?>
    </div>
  </body>
</html>
