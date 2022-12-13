<?php
include_once("connect.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <!-- Login form -->
    <form action="login.php" method="post">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" required>
        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>
        <input type="submit" value="Login">
    </form>

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
        // If the user is in the database, check if the password is correct
        if ($user != false) {
            if (password_verify($_POST['password'], $user['password'])) {
                // Start a session
                session_start();
                // Set the session variables
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                // Redirect to the home page
                header("Location: index.php");
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