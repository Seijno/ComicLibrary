<?php 
// Get the database connection
require_once('connect.php');

// Get the id from the url and 
$id = $_GET['id'];

// Get the book from the database
$query = "SELECT * FROM book WHERE id = :id";
$statement = $conn->prepare($query);
$statement->bindValue(':id', $id);
$statement->execute();
$book = $statement->fetch();
$statement->closeCursor();

// check if the book exists
if (empty($book)) {
    // if the book does not exist redirect to the store page
    header('Location: store.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $book['title']; ?></title>
</head>
<body>
    <h2>Product Information</h2>

    <?php    
    // Display the book
    echo "<h3>" . $book['title'] . "</h3>";
    echo "<p>Author: " . $book['author'] . "</p>";
    echo "<p>Description: " . $book['description'] . "</p>";
    echo "<p>Genre: " . $book['genre'] . "</p>";
    echo "<p>Price: " . $book['price'] . "</p>";
    ?>
</body>
</html>