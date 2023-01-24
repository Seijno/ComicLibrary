<?php include "header.php"; ?>  
   
<?php

// get the post id of the book to edit and if not set, redirect to the overview page
if (isset($_POST['id'])) {
    $id = $_POST['id'];
} else {
    header('Location: overview.php');
} 

// check if the edit form has been submitted
if (isset($_POST['update_book'])) {
    // get the input data from the form
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $price = $_POST['price'];
    $image = file_get_contents($_FILES['image']['tmp_name']);
    
    // validate the input data
    if (empty($title) || empty($author) || empty($genre) || empty($price) || empty($image)) {
        $result = "Invalid book data. Check all fields and try again.";
    } else {
        // update the book data in the database
        require_once('connect.php');
        $query = "UPDATE book SET title = :title, author = :author, genre = :genre, price = :price, image = :image WHERE id = :id";
        $statement = $conn->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->bindValue(':title', $title);
        $statement->bindValue(':author', $author);
        $statement->bindValue(':genre', $genre);
        $statement->bindValue(':price', $price);
        $statement->bindValue(':image', $image);
        $statement->execute();
        $statement->closeCursor();
        $result = "Book updated successfully.";

        // redirect to the overview page
        header('Location: overview.php');
    }
}

// get the book data from the database
require_once('connect.php');
$query = "SELECT * FROM book WHERE id = $id";
$statement = $conn->prepare($query);
$statement->execute();
$book = $statement->fetch();
$statement->closeCursor();

// Form to edit the book data with the input fields pre-populated with the book data
?>
<h2>Edit Book</h2>
<form action="edit_book.php" method="post">
    <?php 
    // if the result variable is set, display the result message
    if (isset($result))
        echo '<div id="result">' . $result . "</div><br>"; 
    ?>
    <input type="hidden" name="id" value="<?php echo $book['id']; ?>">
    <label>Title:</label>
    <input type="text" name="title" value="<?php echo $book['title']; ?>"><br>
    <label>Author:</label>
    <input type="text" name="author" value="<?php echo $book['author']; ?>"><br>
    <label>Genre:</label>
    <input type="text" name="genre" value="<?php echo $book['genre']; ?>"><br>
    <label>Price:</label>
    <input type="text" name="price" value="<?php echo $book['price']; ?>"><br>
    <label>Cover image:</label>
    <input type="file" name="image" value="<?php echo $book['image']; ?>"><br>

    <label>&nbsp;</label>
    <input type="submit" name="update_book" value="Update Book"><br>
    <a href="overview.php">Back to overview</a>
</form>
</body>
</html>