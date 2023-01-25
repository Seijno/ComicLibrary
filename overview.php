<?php
include_once("connect.php");

// start session if not started
if (!isset($_SESSION)) {
    session_start();
}

// if user role is not admin or store owner, redirect back to last page
if (!isset($_SESSION['id']) || $_SESSION['role'] == 0) {
    header("Location: " . $_SERVER['HTTP_REFERER']);
}


?>

<?php include "header.php"; ?>

    <div class="container">
        <div id='overview' class="overview container py-4">
            <div class="row justify-content-center gx-5">
                <h2 class="col-12 col-sm-6 col-md-8 d-flex">Overview</h2>
            </div>

            <div class="row justify-content-center gx-5 pt-4">
                <form action="" method="post" class="col-12 col-sm-6 col-md-8 d-flex">
                    <input type="search" name="search_input" id="search_input" class="py-2 form-control">
                    <input type="submit" name="search" value="Search" class="py-2 px-3 ms-2 btn btn-primary">
                    <a href="add_book.php" class="py-2 ms-2 btn btn-light text-nowrap"><i class="bi bi-plus" style="font-size:1.4em;"></i></a>
                </form>
            </div>

            <div class="row justify-content-center gy-5 gx-5">
                <div class="col-12 col-sm-6 col-md-8">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="overview-list"><?php 
                                // if search is empty/not set, get all books else search for books
                                if (!isset($_POST["search"]) || $_POST["search"] == "") {
                                    getBooks();
                                } else {
                                    searchBooks();
                                }
                            ?></tbody>
                        </table>
                    </div>
                    <!-- <a href="add_book.php" class="btn btn-dark">Add Book</a> -->
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirm_deletion() {
            if (confirm("Are you sure you want to delete this book?") == true) {
            } else {
                event.preventDefault();
            }
        }
    </script>
</body>
</html>

<?php
// get books that the store owner has in his store
function getBooks() {
    include "connect.php";

    $query = "SELECT book.id, book.title, book.description, book.price FROM book INNER JOIN store ON book.store_id = store.owner_id AND store.owner_id = :user_id";
    $statement = $conn->prepare($query);
    $statement->bindValue(':user_id', $_SESSION["id"]);
    $statement->execute();
    $books = $statement->fetchAll();
    $statement->closeCursor();

    displayBooks($books);
}

// search for books in store by title
function searchBooks() {
    include "connect.php";
    $query = "SELECT book.id, book.title, book.description, book.price FROM book INNER JOIN store ON book.store_id = store.owner_id AND store.owner_id = :user_id AND (book.title LIKE :search)";
    $statement = $conn->prepare($query);
    $statement->bindValue(':user_id', $_SESSION["id"]);
    $statement->bindValue(':search', "%" . $_POST["search_input"] . "%");
    $statement->execute();
    $books = $statement->fetchAll();
    $statement->closeCursor();

    displayBooks($books);
}

// display books in a table
function displayBooks($books) {
    if ($books) {
        foreach ($books as $book) {
            $id = $book["id"];
            $title = $book["title"];
            $description = $book["description"];
            $price = $book["price"];

            echo "
            <tr>
                <td class='align-middle'>
                    <a class='editButton link-dark' href='edit_book.php?id=$id'><i class='bi bi-pencil-square'></i></a>
                </td>
                <td class='align-middle'>
                    <a class='bookLink mb-0' href='read_pdf.php?id=$id' target='_blank' style='font-weight: 500;'>$title</a>
                </td>
                <td class='align-middle'>
                    <p class='mb-0' style='font-weight: 500;'>$description</p>
                </td>
                <td class='align-middle'>
                    <p class='mb-0' style='font-weight: 500;'>$price</p>
                </td>
                <td class='align-middle'>
                    <a onclick='confirm_deletion()' class='deleteButton link-danger' href='?remove=$id'><i class='delete-btn bi bi-trash3'></i></a>
                </td>
            </tr>
            ";
        
        }

    } else {
        echo "<script>document.getElementById('overview-list').innerHTML = 'No books found';</script>";
    }
}

// remove book from store owner's store
if (isset($_GET["remove"])) {
    include "connect.php";

    // Check if book belongs to the store owner that is logged in and delete it
    $query = "DELETE book FROM book INNER JOIN store ON book.store_id = store.owner_id WHERE store.owner_id = :user_id AND book.id = :book_id";
    $statement = $conn->prepare($query);
    $statement->bindValue(':user_id', $_SESSION["id"]);
    $statement->bindValue(':book_id', $_GET["remove"]);
    $statement->execute();
    $statement->closeCursor();
    echo "<script>location.replace('overview.php');</script>";
}
?>