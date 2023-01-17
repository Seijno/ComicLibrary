<?php

session_start();
$session = session_id();

if (empty($_SESSION)) {
    header("Location: index.php");
}

include "../connect.php";

function getAllAccounts() {
    // include "../connect.php";

    // $query = $conn->prepare("SELECT * FROM user");
    // $query->execute();

    // $result = $query->fetchAll(PDO::FETCH_ASSOC);

    // foreach ($result as $user) {
    //     echo $user["email"];
        
    // }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <!-- <?php getAllAccounts(); ?> -->
    <?php 

        $query = $conn->prepare("SELECT * FROM user");
        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $user) {
            echo $user["email"];
            
        }

    ?>
</body>
</html>
