<?php include "header.php"; ?>  
   
<?php

// get the post id of the book to edit and if not set, redirect to the overview page

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // get the book data from the database
    require_once('connect.php');
    $query = "SELECT * FROM book WHERE id = $id";
    $statement = $conn->prepare($query);
    $statement->execute();
    $book = $statement->fetch();
    $statement->closeCursor();
} else {
    header('Location: overview.php');
} 
?>

<!-- Form to edit the book data with the input fields already filled with book data -->
<div class="container">
    <div class="row justify-content-center gx-2">
        <form action="edit_book.php" method="post" class="col-12 col-sm-12 col-md-6" enctype="multipart/form-data">
            <h2>Edit Book</h2>

            <input type="hidden" name="book_id" value="<?php echo $book['id']; ?>">
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" class="w-100 p-2 mb-2" value="<?php echo $book['title']; ?>"><br>
            <label for="author">Author:</label>
            <input type="text" id="author" name="author" class="w-100 p-2 mb-2" value="<?php echo $book['author']; ?>"><br>
            <label for="genre">Genre:</label>
            <input type="text" id="genre" name="genre" class="w-100 p-2 mb-2" value="<?php echo $book['genre']; ?>"><br>
            <label for="price">Price:</label>
            <input type="number" id="price" name="price" step="any" min="0" class="w-100 p-2 mb-2" value="<?php echo $book['price']; ?>"><br>
            <label for="description">Description:</label>
            <textarea name="description" id="description" cols="30" rows="4" class="w-100 p-2 mb-2"><?php echo $book['description']; ?></textarea><br>
            
            <label for="image">Cover image:</label>
            <input type="file" name="image" id="image" accept="image/*" class="w-100 p-2 mb-2"><br>
                        
            <label for="pdf">PDF:</label>
            <input type="file" name="pdf" id="pdf" accept="application/pdf" class="w-100 p-2 mb-2"><br>

            <!-- two buttons an update and back to overview -->
            <input type="submit" name="update_book" value="Update book" class="btn btn-primary">
            <a href="overview.php" class="btn btn-light">Cancel</a>
        </form>
    </div>
</div>
</body>
</html>

<?php 

// check if the edit form has been submitted
if (isset($_POST['update_book'])) {

    // get the input data from the form
    $book_id = $_POST['book_id'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    
    // sql queries based on if the image and/or pdf has been edited or not
    $update = "UPDATE book SET title = :title, author = :author, genre = :genre, price = :price, description = :description WHERE id = :book_id";
    $update_img = "UPDATE book SET title = :title, author = :author, genre = :genre, price = :price, description = :description, image = :image WHERE id = :book_id";
    $update_pdf = "UPDATE book SET title = :title, author = :author, genre = :genre, price = :price, description = :description, pdf = :pdf WHERE id = :book_id";
    $update_img_pdf = "UPDATE book SET title = :title, author = :author, genre = :genre, price = :price, description = :description, image = :image, pdf = :pdf WHERE id = :book_id";

    require_once('connect.php');
    
    // statement based on if the image and/or pdf has been edited or not
    if (!empty($_FILES['image']['tmp_name']) && !empty($_FILES['pdf']['tmp_name'])) {
        print_r($_FILES);
        $image = file_get_contents($_FILES['image']['tmp_name']);
        $pdf = file_get_contents($_FILES['pdf']['tmp_name']);
        $statement = $conn->prepare($update_img_pdf);
        $statement->bindValue(':image', $image);
        $statement->bindValue(':pdf', $pdf);

    } else if (!empty($_FILES['image']['tmp_name'])) {
        $image = file_get_contents($_FILES['image']['tmp_name']);
        $statement = $conn->prepare($update_img);
        $statement->bindValue(':image', $image);

    } else if (!empty($_FILES['pdf']['tmp_name'])) {
        $pdf = file_get_contents($_FILES['pdf']['tmp_name']);
        $statement = $conn->prepare($update_pdf);
        $statement->bindValue(':pdf', $pdf);

    } else {
        $statement = $conn->prepare($update);
    }

    $statement->bindValue(':title', $title);
    $statement->bindValue(':author', $author);
    $statement->bindValue(':genre', $genre);
    $statement->bindValue(':price', $price);
    $statement->bindValue(':description', $description);
    $statement->bindValue(':book_id', $book_id);
    $statement->execute();
    $statement->closeCursor();
}

?>