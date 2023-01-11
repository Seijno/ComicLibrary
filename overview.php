<?php
include_once("connect.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overview</title>
    <style>
        th {
            cursor: pointer;
        }
    </style>
</head>
<body>

    <h2>Overview</h2>
    
    <!-- search bar to search for books by titel -->
    <form action='overview.php' method='post'>
        <input type='text' name='search' id='search'>
        <input type='submit' value='Search'>
    </form>

    <!-- button to add a book -->
    <form action='add_book.php' method='post'>
        <input type='submit' name='add' value='Add Book'>
    </form>

    <?php
    // delete book from database 
    if (isset($_POST['delete'])) {
        $query = "DELETE FROM book WHERE id = :id";
        $statement = $conn->prepare($query);
        $statement->bindValue(':id', $_POST['id']);
        $statement->execute();
        $statement->closeCursor();
    }
    
    // Get all books from the database where the store owner is the current user
    session_start();
    $query = "SELECT book.id, book.title, book.description, book.price FROM book INNER JOIN store WHERE store.id = book.store_id AND store.owner_id = :owner_id";
    $statement = $conn->prepare($query);
    $statement->bindValue(':owner_id', $_SESSION['id']);
    $statement->execute();
    $books = $statement->fetchAll();
    $statement->closeCursor();

    // if the search bar is filled in, search for books with the titel that contains the search string only get the books from the current user
    if (isset($_POST['search'])) {
        $query = "SELECT book.id, book.title, book.description, book.price FROM book INNER JOIN store WHERE store.id = book.store_id AND store.owner_id = :owner_id AND book.title LIKE :search";
        $statement = $conn->prepare($query);
        $statement->bindValue(':owner_id', $_SESSION['id']);
        $statement->bindValue(':search', '%' . $_POST['search'] . '%');
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
    ?>

    <script>
        // if the user clicks on the delete button, ask for confirmation
        var deleteButtons = document.getElementsByName('delete');
        for (var i = 0; i < deleteButtons.length; i++) {
            deleteButtons[i].addEventListener('click', function(e) {
                if (!confirm('Are you sure you want to delete this book?')) {
                    e.preventDefault();
                }
            });
        }

        // if the user clicks on th inside the table header, sort the table by the column
        var tableHeader = document.getElementsByTagName('th');
        for (var i = 0; i < tableHeader.length; i++) {
            tableHeader[i].addEventListener('click', function(e) {
                sortTable(e.target.cellIndex);
            });
        }

        // sort the table by the column and reverse the order if the column is already sorted
        function sortTable(column) {
            var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
            table = document.getElementsByTagName('table')[0];
            switching = true;
            dir = "asc";
            while (switching) {
                switching = false;
                rows = table.getElementsByTagName('tr');
                for (i = 1; i < (rows.length - 1); i++) {
                    shouldSwitch = false;
                    x = rows[i].getElementsByTagName('td')[column];
                    y = rows[i + 1].getElementsByTagName('td')[column];
                    if (dir == "asc") {
                        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    } else if (dir == "desc") {
                        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    }
                }
                if (shouldSwitch) {
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                    switchcount++;
                } else {
                    if (switchcount == 0 && dir == "asc") {
                        dir = "desc";
                        switching = true;
                    }
                }
            }
        }
    </script>
</body>
</html>