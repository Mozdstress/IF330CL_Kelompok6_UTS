<?php
   if(!isset($_SESSION)){
    session_start();
  }
?>
<?php
if (!isset($_SESSION)) {
    session_start();
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="form.css">
    <style>
        .header {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .header img {
            width: 170px;
            height: auto;
        }

        section {
            background-image: url('img/login-bg.jpg'); /* Ganti dengan path gambar latar belakang Anda */
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
    </style>
</head>

<body>
    <section class="vh-100">
        <div class="form-container">
            <form action="register_process.php" method="post">
                <div id="login-form">
                    <h2 class="header">
                        <img src="img/logo.png" alt="Logo">
                    </h2>
                    <div>
                        <input type="text" name="fullname" placeholder="Full Name" autocomplete="off" required />
                        <input type="text" name="reg-username" placeholder="Username" autocomplete="off" required />
                        <input type="password" name="reg-password" placeholder="Password" autocomplete="off" required />
                        <select name="gender" required>
                            <option value="" disabled selected hidden>Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                        <input type="date" name="birthdate" placeholder="Birthdate" style="color: gray;" required />
                        <div class="text-start">
                            <p>Already have an account? <span><a href="login.php">Login here</a></span></p>
                        </div>
                        <button type="submit" value="Submit">Register</button>
                        <?php
                        if (isset($_SESSION['regist_message'])) {
                            echo '<p class="register-message">' . $_SESSION['regist_message'] . '</p>';
                            unset($_SESSION['regist_message']);
                        }
                        ?>
                    </div>
                </div>
            </form>
        </div>
    </section>
</body>
</html>