<?php
session_start();
require_once('db.php');

// 1. Koneksi ke Database
$db = new PDO(DSN, DBUSER, DBPASS);

// 2. Query database
$sql = "SELECT * FROM task";
$hasil = $db->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Task Tracker</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
</head>
<body>
    <?php
      // cek user udah login
      if (!isset($_SESSION['user'])) {
        // belum, tampilkan form login
        include('login.php');
      } else {
        // sudah, tampilkan daftar task
        include('list_task.php');
      }
    ?>
  </div>

</body>
</html>