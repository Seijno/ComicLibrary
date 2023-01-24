<?php 
// Get the database connection
require_once('connect.php');

// Get the id from the url
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

<?php include "header.php"; ?>  
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