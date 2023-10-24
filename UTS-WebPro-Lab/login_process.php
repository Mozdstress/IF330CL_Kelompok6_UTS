<?php
    if(!isset($_SESSION)){
        session_start();
      }
require_once('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = ?";
    $result = $db->prepare($sql);
    $result->execute([$username]);

    if ($result->rowCount() > 0) {
        $user = $result->fetch(PDO::FETCH_ASSOC);

        if (password_verify($password, $user['password'])) {
            // Login berhasil
            $_SESSION['user'] = $user;
            header('Location: index.php');
        } else {
            // Password salah
            $_SESSION['login_error'] = "Username or Password is incorrect";
            header('Location: login.php');
        }
    } else {
        // Username tidak ditemukan
        $_SESSION['login_error'] = "Username or Password is incorrect";
        header('Location: login.php');
    }
}

?>