<?php include "connect.php";
// check if useris already logged in if so redirect to store page
if (isset($_SESSION['username'])) {
    header('Location: store.php');
}
 ?>
<!doctype html>
<html lang="en">
<?php include "header.php"; ?>
    <section id="loginform">
        <div class="container">
            <div class="justify-content-center row">
                <div class="col-5 text-center" id="form">
                    <p class="py-3">Welkom!</p>
                    <!-- register form -->
                    <form method="post" action="store.php">
                        <label class="py-3" for="email">Email:</label>
                        <input type="email" id="email" name="email" placeholder="pieter@gmail.com" required>
                        <br>
                        <label class="py-3" for="username">Username:</label>
                        <input type="text" id="username" name="username" placeholder="Pieter" required>
                        <br>
                        <label class="py-3" for="password">Password:</label>
                        <input type="password" name="password" id="password" placeholder="password" required>
                        <br>
                        <label class="py-3" for="confirmPassword">Confirm password:</label>
                        <input type="password" name="confirmPassword" id="confirmPassword" placeholder="confirm password" required>
                        <br>
                        <button class="w-100 btn btn-lg btn-danger" type="submit">Sign up</button>
                        <div class="text-center py-2">
                            <p>already a account here? Login <a href="login.php">here</a>!</p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php
    include "footer.php";
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
                header("Location: login.php");
            } else {
                echo "User already exists";
            }
        } else {
            echo "Passwords do not match";
        }
    }
    ?>