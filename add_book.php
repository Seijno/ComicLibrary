<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add book</title>
</head>
<body>
    <!-- Form to add a book to database -->
    <h2>Add Book</h2>
    <form action="add_book.php" method="post">
        <label for="title">Title:</label>
        <input type="text" name="title" id="title"><br>
        <label for="author">Author:</label>
        <input type="text" name="author" id="author"><br>
        <label for="genre">Genre:</label>
        <input type="text" name="genre" id="genre"><br>
        <label for="price">Price:</label>
        <input type="text" name="price" id="price"><br>
        <label for="description">Description:</label>
        <textarea name="description" id="description" cols="30" rows="10"></textarea><br>
        <label for="pdf">PDF:</label>
        <input type="file" name="pdf" id="pdf"><br>
        <label for="store_id">Store:</label>
        <select name="store_id" id="store_id">
            <?php
            require_once('conn.php');
            // Get all stores in the database
            $query = "SELECT id, name FROM store";
            $statement = $conn->prepare($query);
            $statement->execute();
            $stores = $statement->fetchAll();
            $statement->closeCursor();
            // display stores in a select
            foreach ($stores as $store) {
                echo "<option value='" . $store['id'] . "'>" . $store['name'] . "</option>";
            }
            ?>
        <input type="submit" name="add_book" value="Add Book">
        <a href="overview.php">Back to overview</a>
    </form>
    <br>    
    <?php 
    

    ?>
</body>
</html>