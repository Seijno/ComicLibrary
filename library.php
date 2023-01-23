<?php

session_start();
$session = session_id();

if (empty($_SESSION)) {
    header("Location: login.php");
}

// Get books that user has added to library
function getBooks() {
    include_once "connect.php";
    $query = $conn->prepare("SELECT * FROM library WHERE user_id = :id");
    $query->bindParam(":id", $_SESSION["id"]);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    // Display books
    if ($result) {
        foreach ($result as $book) {
            $query = $conn->prepare("SELECT * FROM book WHERE id = :id");
            $query->bindParam(":id", $book["book_id"]);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                $id = $result["id"];
                echo "<a href='read_pdf.php?id=$id' target='_blank'>" . $result["title"] . "</a><br>";
            }
        }
    }
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
    <form action="" method="post">
        <input type="search" name="search_input" id="search_input">
        <input type="submit" name="search" value="Search">
    </form>
    <?php 
        // If search is empty/not set, get all books
        if (!isset($_POST["search"]) || $_POST["search"] == "") {
            getBooks();
        } 
    ?>
</body>
</html>

<?php

include_once "connect.php";

// Search for books in library
if (isset($_POST['search'])) {
    $query = "SELECT library.user_id, library.book_id, book.title, book.image FROM library INNER JOIN book ON library.user_id = :user_id AND library.book_id = book.id WHERE book.title LIKE :search";
    $statement = $conn->prepare($query);
    $statement->bindValue(':user_id', $_SESSION["id"]);
    $statement->bindValue(':search', "%" . $_POST['search_input'] . "%");
    $statement->execute();
    $books = $statement->fetchAll();
    $statement->closeCursor();

    // Display books
    if ($books) {
        foreach ($books as $book) {
            $id = $book["book_id"];
            echo "<a href='read_pdf.php?id=$id' target='_blank'>" . $book["title"] . "</a><br>";
        }
    } else {
        echo "No books found";
    }
}

?>