<?php
include_once("connect.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.104.2">
    <title>Comic Library</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.2/examples/sign-in/">

    <link href="/docs/5.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="/docs/5.2/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
    <link rel="icon" href="/docs/5.2/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
    <link rel="icon" href="/docs/5.2/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
    <link rel="manifest" href="/docs/5.2/assets/img/favicons/manifest.json">
    <link rel="mask-icon" href="/docs/5.2/assets/img/favicons/safari-pinned-tab.svg" color="#712cf9">
    <link rel="icon" href="/docs/5.2/assets/img/favicons/favicon.ico">
    <meta name="theme-color" content="#712cf9">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">


    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .b-example-divider {
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }
    </style>


    <!-- Custom styles for this template -->
    <link href="../css/signin.css" rel="stylesheet">
    <style type="text/css">
        @font-face {
            font-family: Roboto;
            src: url("chrome-extension://mcgbeeipkmelnpldkobichboakdfaeon/css/Roboto-Regular.ttf");
        }
    </style>
</head>
<body>
<main class="form-signin w-100 m-auto">
        <form method="POST" action="">
            <h1 class="h3 mb-3 fw-normal">Please sign up</h1>

            <div class="form-floating">
                <input type="email" class="form-control" placeholder="name@example.com" name="email" id="email" required>
                <label for="floatingInput">Email address</label>
            </div>
            <div class="form-floating">
                <input type="text" class="form-control" placeholder="name" name="username" id="username" required>
                <label for="floatingInput">Username</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                <label for="floatingPassword">Password</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Same password" required>
                <label for="floatingPassword">Confirm Password</label>
            </div>

            <div class="checkbox mb-3">
                <label>
                    <input type="checkbox" value="remember-me"> Remember me
                </label>
            </div>
            <button class="w-100 btn btn-lg btn-danger" type="submit">Register</button>
            <p class="text-center">Do you already have a account? Login <a href="login.php">here!</a></p>
            <p class="mt-5 mb-3 text-muted text-center">© 2017–2022</p>
        </form>
    </main>

    <?php
    if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['confirmPassword'])) {
        // Check if the password and confirm password fields match
        if ($_POST['password'] == $_POST['confirmPassword']) {
            // Check if the user is already in the database
            $query = "SELECT * FROM user WHERE username = :username OR email = :email"; 
            $statement = $conn->prepare($query);
            $statement->bindValue(':username', $_POST['username']);
            $statement->bindValue(':email', $_POST['email']);
            $statement->execute();
            $user = $statement->fetch();
            $statement->closeCursor();
            // If the user is not in the database, create a new user
            if ($user == false) {
                $query = "INSERT INTO user (username, email, password) VALUES (:username, :email, :password)";
                $statement = $conn->prepare($query);
                $statement->bindValue(':username', $_POST['username']);
                $statement->bindValue(':email', $_POST['email']);
                $statement->bindValue(':password', password_hash($_POST['password'], PASSWORD_DEFAULT));
                $statement->execute();
                $statement->closeCursor();
                // Redirect to the login page
                header("Location: login.php");
            } else {
                echo "User already exists";
            }
        } else {
            echo "Passwords do not match";
        }
    }
    ?>
</body>
</html>
<!-- needed for commit -->