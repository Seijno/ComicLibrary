<?php
// if session is not started, start session
if (!isset($_SESSION)) {
    session_start();
}
// if user is not an admin, redirect to login page
if (!isset($_SESSION['id']) || $_SESSION['role'] != 1) {
    header("Location: ../login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
</head>
<body>
    <h2>Admin</h2>
    <ul>
        <li><a href="shop_request.php">Store requests</a></li>
        <li><a href="user_list.php">Users</a></li>
    </ul>
</body>
</html>