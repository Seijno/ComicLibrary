<?php

include "connect.php";

session_start();
$session = session_id();

$query = $conn->prepare("SELECT * FROM library WHERE user_id = :id");
$query->bindParam(":id", $_SESSION["id"]);
$query->execute();

$result = $query->fetch(PDO::FETCH_ASSOC);

if ($result) {
    $array = str_replace(",", " ", $result["book_id"]);
    $array = explode(" ", $array);
    
    if (!in_array($_GET["id"], $array)) {
        header("Location: library.php");
    }
}

$query = $conn->prepare("SELECT * FROM book WHERE id = :id");
$query->bindParam(":id", $_GET["id"]);
$query->execute();

$result = $query->fetch(PDO::FETCH_ASSOC);

if ($result) {
    $file = $result["pdf"];
    header('Content-type: application/pdf');
    echo $file;
    exit();
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
    <?php echo base64_encode($pdf);?>
</body>
</html>