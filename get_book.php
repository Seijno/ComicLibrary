
<?php
// Get book info and book cover output in base64 format
include_once "connect.php";
$query = "SELECT title, genre, author, price, description, image, id FROM book WHERE id = :id";
$statement = $conn->prepare($query);
$statement->bindValue(':id', $_GET['id']);
$statement->execute();
$book = $statement->fetch();
$statement->closeCursor();

$arr[] = array(
    'title' => $book[0],
    'genre' => $book[1],
    'author' => $book[2],
    'price' => $book[3],
    'description' => $book[4],
    'image' => base64_encode($book[5]),
    'id' => $book[6]
); 

echo json_encode($arr);
?>