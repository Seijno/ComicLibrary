<?php
include_once("connect.php");
?>

<!-- 
todo: 
    Beveliging zodat alleen admins de pagina kunnen zien
    edit pagina aanmaken en delete functie aanpassen
-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overview</title>
</head>
<body>
    
    <!-- search bar to search for books by titel -->
    <form action='overview.php' method='post'>
        <label for='search'>Search</label>
        <input type='text' name='search' id='search'>
        <input type='submit' value='Search'>
    </form>

    <?php
    
    // Get all books in the database
    $query = "SELECT id, title, description, price FROM book";
    $statement = $conn->prepare($query);
    $statement->execute();
    $books = $statement->fetchAll();
    $statement->closeCursor();

    // if the search bar is filled in, search for books with the titel that contains the search string
    if (isset($_POST['search'])) {
        $query = "SELECT id, title, description, price FROM book WHERE title LIKE :search";
        $statement = $conn->prepare($query);
        $statement->bindValue(':search', "%" . $_POST['search'] . "%");
        $statement->execute();
        $books = $statement->fetchAll();
        $statement->closeCursor();
    }

    // display books in a table with a edit and delete button
    echo "<table>";
    echo "<tr><th></th><th>Titel</th><th>Beschrijving</th><th>Prijs</th><th></th><th></th></tr>";
    foreach ($books as $book) {
        echo "<tr>";
        echo "<td><form action='edit_book.php' method='post'><input type='hidden' name='id' value='" . $book['id'] . "'><input type='submit' name='edit' value='Edit'></form></td>";
        echo "<td>" . $book['title'] . "</td>";
        echo "<td>" . $book['description'] . "</td>";
        echo "<td>" . $book['price'] . "</td>";
        echo "<td><form action='overview.php' method='post'><input type='hidden' name='id' value='" . $book['id'] . "'><input type='submit' name='delete' value='Delete'></form></td>";
        echo "</tr>";
    }
    echo "</table>";

    // delete book from database
    if (isset($_POST['delete'])) {
        $query = "DELETE FROM book WHERE id = :id";
        $statement = $conn->prepare($query);
        $statement->bindValue(':id', $_POST['id']);
        $statement->execute();
        $statement->closeCursor();
    }
    ?>
</body>
</html>