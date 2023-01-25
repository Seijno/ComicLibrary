<?php

include "../connect.php";

// if session is not started, start session
if (!isset($_SESSION)) {
    session_start();
}
// if user is not an admin, redirect to login page
if (!isset($_SESSION['id']) || $_SESSION['role'] != 1) {
    header("Location: ../login.php");
}

// get all store requests from database and display them in a table
function getAllRequests() {
    include "../connect.php";
    $query = $conn->prepare("SELECT store_request.id, store_owner_id, store_name, username, email FROM store_request INNER JOIN user ON store_request.store_owner_id = user.id");
    $query->execute();

    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    if(!$result) {
        echo "<p>No store requests</p>";
        return;
    }

    foreach ($result as $request) {
        $id = $request["id"];
        $store_name = $request["store_name"];
        $owner = $request["username"];
        $email = $request["email"];
        echo "<tr>";
        echo "<td>$store_name</td>";
        echo "<td>$owner</td>";
        echo "<td>$email</td>";
        echo "<td><a href='?accept=$id'>Accept</a></td>";
        echo "<td><a href='?reject=$id'>Reject</a></td>";
        echo "</tr>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store requests</title>
</head>
<body>
    <h2>Store requests</h2>
    
    <!-- create a table -->
    <table>
        <tr>
            <th>Store name</th>
            <th>Owner</th>
            <th>Email</th>
            <th></th>
            <th></th>
        </tr>
        <!-- display all store requests -->
        <?php getAllRequests(); ?>
    </table>
</body>
</html>

<?php

// on accept add store to store table and delete store request from store_request table
if (isset($_GET["accept"])) {
    $id = $_GET["accept"];
    include "../connect.php";
    $query = $conn->prepare("SELECT * FROM store_request WHERE id = $id");
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);

    // delete store request
    $query = "INSERT INTO store (name, owner_id) VALUES (:store_name, :store_owner_id)";
    $statement = $conn->prepare($query);
    $statement->bindValue(':store_name', $result["store_name"]);
    $statement->bindValue(':store_owner_id', $result["store_owner_id"]);
    $statement->execute();
    $statement->closeCursor();
    
    // delete store request
    $query = $conn->prepare("DELETE FROM store_request WHERE id = $id");
    $query->execute();

    // change user role to store owner
    $query = $conn->prepare("UPDATE user SET role = 2 WHERE id = " . $result["store_owner_id"]);
    $query->execute();


    header("Location: shop_request.php");
}

// on reject delete store request from store_request table
if (isset($_GET["reject"])) {
    $id = $_GET["reject"];
    include "../connect.php";
    $query = $conn->prepare("DELETE FROM store_request WHERE id = $id");
    $query->execute();
    header("Location: shop_request.php");
}
