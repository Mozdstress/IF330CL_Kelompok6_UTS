<?php
if(!isset($_SESSION)){
    session_start();
  }
require_once('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = $_POST['fullname'];
    $regUsername = $_POST['reg-username'];
    $regPassword = $_POST['reg-password'];
    $gender = $_POST['gender'];
    $birthdate = $_POST['birthdate'];

    if (!empty($fullname) && !empty($regUsername) && !empty($regPassword) && !empty($gender) && !empty($birthdate)) {
        // Cek username terdaftar atau ga
        $checkUsernameSQL = "SELECT username FROM users WHERE username = ?";
        $checkUsernameResult = $db->prepare($checkUsernameSQL);
        $checkUsernameResult->execute([$regUsername]);

        if ($checkUsernameResult->rowCount() == 0) {
            // kalo belum ada, bisa register
            $registerSQL = "INSERT INTO users (fullname, username, password, gender, birthdate) VALUES (?, ?, ?, ?, ?)";
            $registerResult = $db->prepare($registerSQL);
            $registerResult->execute([$fullname, $regUsername, password_hash($regPassword, PASSWORD_BCRYPT), $gender, $birthdate]);

            $_SESSION['regist_message'] = "Account successfully registered";
            header('Location: register.php');
        } else {
            $_SESSION['regist_message'] = "Username already taken";
            header('Location: register.php');
        }
    }
}
?>