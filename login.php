<?php

// check if useris already logged in if so redirect to store page
if (isset($_SESSION['username'])) {
    header('Location: store.php');
}

include_once("connect.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="css/signin.css">
    <title>Login</title>
</head>

<body class="text-center" cz-shortcut-listen="true">

    <main class="form-signin w-100 m-auto">
        <form method="post" action="">
            <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

            <div class="form-floating">
                <input type="text" class="form-control" id="username" name="username" placeholder="name@example.com">
                <label for="username">Username</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                <label for="password">Password</label>
            </div>
            <button class="w-100 btn btn-lg btn-danger" type="submit">Sign in</button>
        </form>
        <div class="text-center">
            <p>New here? Create an account <a href="register.php">here</a>!</p>
        </div>
    </main>
</body>
<?php
    // Check if the username and password fields are set
    if (isset($_POST['username']) && isset($_POST['password'])) {
        // Check if the user is in the database
        $query = "SELECT * FROM user WHERE username = :username";
        $statement = $conn->prepare($query);
        $statement->bindValue(':username', $_POST['username']);
        $statement->execute();
        $user = $statement->fetch();
        $statement->closeCursor();
        // If the user is  in the database, check if the password is correct
        if ($user != false) {
            if (password_verify($_POST['password'], $user['password'])) {
                // Start a session
                session_start();
                // Set the session variables
                $_SESSION["id"] = $user["id"];
                $_SESSION['username'] = $user['username'];
                $_SESSION['id'] = $user['id'];
                // Redirect to the home page
                header("Location: overview.php");
            } else {
                echo "Incorrect password";
            }
        } else {
            echo "User does not exist";
        }
    }
    ?>



</body>

</html>