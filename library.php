<?php

// if session is not started, start session
if (!isset($_SESSION)) {
    session_start();
}

// if user is not logged in, redirect to login page
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
}
?>


<?php include "header.php"; ?>   
    <div class="container">
        <div id='library' class="library container py-4">
            <div class="row justify-content-start gx-5">
                <form action="" method="post" class="col-12 col-sm-6 col-md-8 d-flex">
                    <input type="search" name="search_input" id="search_input" class="py-2 form-control">
                    <input type="submit" name="search" value="Search" class="py-2 px-3 ms-2 btn btn-primary">
                </form>
            </div>

            <div class="row justify-content-center gy-5 gx-5">
                <div class="col-12 col-sm-6 col-md-8">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <!-- sort table rows using sortTable -->
                                    <th onclick="sortTable(1)">Title</th>
                                    <th onclick="sortTable(2)">Description</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="library-list">
                            <?php 
                                // if search is empty/not set, get all books else search for books
                                if (!isset($_POST["search"]) || $_POST["search"] == "") {
                                    getBooks();
                                } else {
                                    searchBooks();
                                }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-6 col-md-4">
                    <div id="coverPreview" class="bg-light">
                        <img id="coverImage" class="p-4 mx-auto">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

        // display book cover if link is hovered
        var links = document.getElementsByClassName("bookLink");
        for (var i = 0; i < links.length; i++) {
            links[i].addEventListener("mouseover", function(e) {
                // get book id from the href link
                var id = e.target.href.split("=")[1];

                // get book image and change source of cover image
                var request = new XMLHttpRequest();
                request.open("GET", "get_book.php?id=" + id, true);
                request.send();
                request.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        // parse image from json
                        var book = JSON.parse(this.responseText);
                        var coverImage = document.getElementById("coverImage");
                        coverImage.style.display = "block";
                        coverImage.src = "data:image/jpeg;base64," + book[0].image;
                    }
                }
            });

            // hide image when mouse leaves link
            links[i].addEventListener("mouseout", function() {
                var coverImage = document.getElementById("coverImage");
                coverImage.style.display = "none";
            });
        }

        // confirm deletion of book preventing default redirect if user cancels
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
// get books that user has added to library
function getBooks() {
    include "connect.php";
    $query = "SELECT library.user_id, library.book_id, book.title, book.description, book.image FROM library INNER JOIN book ON library.user_id = :user_id AND library.book_id = book.id";
    $statement = $conn->prepare($query);
    $statement->bindValue(':user_id', $_SESSION["id"]);
    $statement->execute();
    $books = $statement->fetchAll();
    $statement->closeCursor();
    
    displayBooks($books);
}

// search for books in library by title, genre or author
function searchBooks() {
    include "connect.php";
    $query = "SELECT library.user_id, library.book_id, book.title, book.description, book.image FROM library INNER JOIN book ON library.user_id = :user_id AND library.book_id = book.id AND (title LIKE :search OR genre LIKE :search OR author LIKE :search)";
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
            $id = $book["book_id"];
            $title = $book["title"];
            $description = $book["description"];

            echo "
            <tr>
                <td class='align-middle'>
                    <a class='bookLink mb-0' href='read_pdf.php?id=$id' style='font-weight: 500;'>$title</a>
                </td>
                <td class='align-middle'>
                    <p class='mb-0' style='font-weight: 500;'>$description</p>
                </td>
                <td class='align-middle'>
                    <a onclick='confirm_deletion()' class='deleteButton link-danger' href='library.php?remove=$id'><i class='delete-btn bi bi-trash3'></i></a>
                </td>
            </tr>
            ";
        
        }

    } else {
        echo "<script>document.getElementById('library-list').innerHTML = 'No books found';</script>";
    }
}

// remove book from user library
if (isset($_GET["remove"])) {
    include "connect.php";
    $query = "DELETE FROM library WHERE user_id = :user_id AND book_id = :book_id";
    $statement = $conn->prepare($query);
    $statement->bindValue(':user_id', $_SESSION["id"]);
    $statement->bindValue(':book_id', $_GET["remove"]);
    $statement->execute();
    $statement->closeCursor();
    echo "<script>location.replace('library.php');</script>";

}
?>
<?php include "footer.php"; ?>