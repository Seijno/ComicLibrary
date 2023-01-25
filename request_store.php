<?php

// if session is not started, start session
if (!isset($_SESSION)) {
    session_start();
}

// if user is not logged in or role is admin/store owner, redirect to login page
if (!isset($_SESSION['id']) || $_SESSION['role'] == 1 || $_SESSION['role'] == 2) {
    header("Location: login.php");
}
?>

<?php include "header.php"; ?>   
    <div class="container">
    <div class="row justify-content-center gx-2">
        <form action="request_store.php" method="post" class="col-12 col-sm-12 col-md-6" enctype="multipart/form-data">
            <h2>Request store</h2>

            <div id="result"></div>

            <!-- store request form  -->
            <div class="form-group mb-3">
                <label for="name">Store name</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <!-- two buttons an update and back to overview -->
            <input type="submit" name="request_store" value="Request" class="btn btn-primary">
            <!-- back button which goes back to the last page he was on -->
            <input type="button" value="Back" class="btn btn-light" onclick="history.back(-1)" />
        </form>
    </div>
</div>
</body>
</html>

<?php

// insert store request to database
if (isset($_POST["request_store"])) {
    include_once("connect.php");

    $query = "INSERT INTO store_request (store_name, store_owner_id) VALUES (:name, :user_id)";
    $statement = $conn->prepare($query);
    $statement->bindValue(':name', $_POST["name"]);
    $statement->bindValue(':user_id', $_SESSION["id"]);
    $statement->execute();
    $statement->closeCursor();

    // success message
    echo "<script>document.getElementById('result').innerHTML = '<div class=\"alert alert-success\" role=\"alert\">Store request succesfully sent!</div>';</script>";
}