<?php

// check if user is already logged in if so redirect to store page
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
    <title>Register</title>
</head>
<body>
    <form action="register.php" method="post">
        <label for="email">E-mail</label>
        <input type="email" name="email" id="email" required>
        <label for="username">Username</label>
        <input type="text" name="username" id="username" required>
        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>
        <label for="confirmPassword">Confirm Password</label>
        <input type="password" name="confirmPassword" id="confirmPassword" required>
        <input type="submit" value="Register">
    </form>

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

                // Send confirmation email to user (werkt niet zonder mail server)
                // $to = $_POST['email'];
                // $subject = "Comic Library Registration";
                // $message = "Thank you for registering with Comic Library. You can now log in to your account.";
                // mail($to, $subject, $message);                

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