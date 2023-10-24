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
    <title>Login Page</title>
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
    </style>
</head>


<body>
    <section class="vh-100">
        <div class="form-container">
            <form action="login_process.php" method="post">
                <div id="login-form">
                    <h2 class="header">
                        <img src="img/logo.png" alt="Logo">
                    </h2>
                    <div>
                        <input type="text" name="username" placeholder="Username" autocomplete="off" required />
                        <input type="password" name="password" placeholder="Password" autocomplete="off" required />
                        <div class="text-start">
                            <p>Don't have an account? <span><a href="register.php">Register Now</a></span></p>
                        </div>
                        <button type="submit" value="Submit">Login</button>
                        <?php
                        if (isset($_SESSION['login_error'])) {
                            echo '<p class="error-message">' . $_SESSION['login_error'] . '</p>';
                            unset($_SESSION['login_error']);
                        }
                        ?>
                    </div>
                </div>
            </form>
        </div>
    </section>
</body>

</html>