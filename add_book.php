<?php include "header.php"; ?>  
    <!-- Form to add a book to database -->
    <h2>Add Book</h2>
    <form action="add_book.php" enctype="multipart/form-data" method="post">
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
        <input type="file" name="pdf" id="pdf" accept="application/pdf"><br>
        <label for="image">Cover image:</label>
        <input type="file" name="image" id="image" accept="image/*"><br>
        <label for="store_id">Store:</label>
        <select name="store_id" id="store_id">
            <?php
            require_once('connect.php');
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
        </select><br>
        <input type="submit" name="add_book" value="Add Book">
        <a href="overview.php">Back to overview</a>
    </form>
    <br>    
    <?php 

    // add book to database
    if (isset($_POST['add_book'])) {
        $image = file_get_contents($_FILES['image']['tmp_name']);
        $pdf = file_get_contents($_FILES['pdf']['tmp_name']);

        $query = "INSERT INTO book (title, author, genre, price, description, pdf, image, store_id) VALUES (:title, :author, :genre, :price, :description, :pdf, :image, :store_id)";
        $statement = $conn->prepare($query);
        $statement->bindValue(':title', $_POST['title']);
        $statement->bindValue(':author', $_POST['author']);
        $statement->bindValue(':genre', $_POST['genre']);
        $statement->bindValue(':price', $_POST['price']);
        $statement->bindValue(':description', $_POST['description']);
        $statement->bindValue(':pdf', $pdf);
        $statement->bindValue(':image', $image);
        $statement->bindValue(':store_id', $_POST['store_id']);
        $statement->execute();
        $statement->closeCursor();
        
        // redirect to overview
        header("Location: overview.php");
    }

    ?>
</body>
</html>