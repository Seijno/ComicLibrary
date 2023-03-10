<?php

// if session is not started, start session
if (!isset($_SESSION)) {
    session_start();
}

// if user is not an admin, redirect to login page
if (!isset($_SESSION['id']) || $_SESSION['role'] != 1) {
    header("Location: ../login.php");
}


function getAllAccounts() {
    include "../connect.php";
    $query = $conn->prepare("SELECT * FROM user");
    $query->execute();

    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    
    foreach ($result as $user) {
        $id = $user["id"];
        echo "<li>" . $user["email"];
        echo " <a href='edit_user.php?id=$id'>Edit</a></li>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
</head>
<body>
    <h2>Users</h2>
    <ul>
        <?php getAllAccounts(); ?>
    </ul>
</body>
</html>