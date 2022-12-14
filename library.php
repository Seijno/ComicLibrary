<?php

session_start();
$session = session_id();

if (empty($_SESSION)) {
    header("Location: login.php");
}

include "connect.php";

$query = $conn->prepare("SELECT * FROM library WHERE user_id = :id");
$query->bindParam(":id", $_SESSION["id"]);
$query->execute();

$result = $query->fetch(PDO::FETCH_ASSOC);

if ($result) {
    $array = str_replace(", ", " ", $result["book_id"]);
    $array = explode(" ", $array);
    
    foreach ($array as $book) {
        $query = $conn->prepare("SELECT * FROM book WHERE id = :id");
        $query->bindParam(":id", $book);
        $query->execute();

        $result = $query->fetch(PDO::FETCH_ASSOC);

        echo $result["title"];
    }
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
    
</body>
</html>