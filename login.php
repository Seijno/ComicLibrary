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
                    <p class="py-3">Welkom terug!</p>
                    <form method="post" action="store.php">
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
    <div class="py-5"></div>
    <section id="footer">
      <div class="container">
        <div class="row justify-content-evenly">
          <div class="col-4">
            <div class="text-center">
              <h6>Nieuwsbrief</h6>
            </div>
          </div>
          <div class="col-4">
            <div class="text-center">
              <h6>Contact</h6>
              <p>email: comiclibrary@support.com<br>
                 telephone number: +31 6 12345678<br>
                 adres: 2311WV Amsterdam<br>
                 oosterhoekstraat 37</p>
            </div>
          </div>
          <div class="col-4">
            <div class="text-center">
              <h6>Navigatie</h6>
              <a href="#">upcoming</a>
            </div>
          </div>
        </div>
      </div>
    </section>

<?php
 include "footer.php";
    // Check if the username and password fields are set commit
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