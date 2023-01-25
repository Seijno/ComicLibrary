<?php include "header.php"; ?>
    <!-- Form to add a book to database -->
    <div class="container">
    <div class="row justify-content-center gx-2">
        <form action="add_book.php" method="post" class="col-12 col-sm-12 col-md-6" enctype="multipart/form-data">
            <h2>Add Book</h2>

            <?php
                // get the store id from the owner_id
                require_once('connect.php');
                $query = "SELECT id FROM store WHERE owner_id = :id";
                $statement = $conn->prepare($query);
                $statement->bindValue(':id', $_SESSION['id']);
                $statement->execute();
                $store = $statement->fetch();
                $statement->closeCursor();
            ?>

            <input type="hidden" name="store_id" value="<?php echo $store['id']; ?>">

            <label for="title">Title:</label>
            <input type="text" name="title" id="title" class="w-100 p-2 mb-2">
            <label for="author">Author:</label>
            <input type="text" id="author" name="author" class="w-100 p-2 mb-2">
            <label for="genre">Genre:</label>
            <input type="text" name="genre" id="genre" class="w-100 p-2 mb-2">
            <label for="price">Price:</label>
            <input type="number" name="price" id="price" step="any" min="0" class="w-100 p-2 mb-2">
            <label for="description">Description:</label>
            <textarea name="description" id="description" cols="30" rows="3" class="w-100 p-2 mb-2"></textarea>
            <label for="image">Cover Image:</label>
            <input type="file" name="image" id="image" accept="image/*" class="w-100 p-2 mb-2">

            <label for="pdf">PDF:</label>
            <input type="file" name="pdf" id="pdf" accept="application/pdf" class="w-100 p-2 mb-2">

            <input type="submit" name="add_book" value="Add book" class="btn btn-primary">
            <a href="overview.php" class="btn btn-light">Cancel</a>
        </form>
    </div>
</div>
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
    <?php include "footer.php"; ?>
</body>
</html>