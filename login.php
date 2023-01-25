<?php include "connect.php";

// check if session is already started
if (!isset($_SESSION)) {
session_start();
}

// check if user is already logged in if so redirect to store page
if (isset($_SESSION['id'])) {
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
                    <p class="py-3">Welkom terug!</p>
                    <form method="post" action="login.php">
                        <label class="py-3" for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="pieter@gmail.com" required>
                        <br>
                        <label class="py-3" for="password">Password</label>
                        <input type="password" name="password" id="password" placeholder="password" required>
                        <br>
                        <button class="w-100 btn btn-lg btn-danger" type="submit">Sign in</button>
                        <div class="text-center py-2">
                            <p>New here? Create a account <a href="register.php">here</a>!</p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <?php include "footer.php"; ?>

<?php
    if (isset($_POST['email']) && isset($_POST['password'])) {
        // Check if the user is in the database
        $query = "SELECT * FROM user WHERE email = :email";
        $statement = $conn->prepare($query);
        $statement->bindValue(':email', $_POST['email']);
        $statement->execute();
        $user = $statement->fetch();
        $statement->closeCursor();

        // If the user is  in the database, check if the password is correct
        if ($user != false) {
            if (password_verify($_POST['password'], $user['password'])) {
                // Set the session variables
                $_SESSION["id"] = $user["id"];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];
            } else {
                echo "Incorrect password";
            }
        } else {
            echo "User does not exist";
        }
    }
?>
<!-- commit -->