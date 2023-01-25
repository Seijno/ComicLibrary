<?php include "header.php"; ?>
    <?php

    // Get all books from the database and display them in a collumn of cards with the book data
    require_once('connect.php');
    $query = "SELECT * FROM book";
    $statement = $conn->prepare($query);
    $statement->execute();
    $books = $statement->fetchAll();
    $statement->closeCursor();
    ?>

    <div id="shoppingCart" class="ms-3">
        <a href="./cart.php"><i class="bi bi-cart4"></i></a>
        <a href="./cart.php"><span id="cart-count" class="badge badge-pill badge-danger">0</span></a>
    </div>

    <div class="container mx-auto mb-5">
        <h2 class="row">Store</h2>
        
        <div class="row justify-content-between align-items-center">
            <?php
            foreach ($books as $book) {
                $id = $book['id'];
                $title = $book['title'];
                $price = $book['price'];
                $image = $book['image'];

                echo "
                <div class='card' style='width: 18rem;'>
                    <img class='card-img-top' src='data:image/jpeg;base64,".base64_encode($image)."' alt='Book cover'/>
                    <div class='card-body'>
                        <a href='./product.php?id=".$id."'><h3 class='card-title text-nowrap'>$title</h3></a>
                        <p class='card-text'>€$price</p>
                        <form method='post'>
                            <input type='hidden' name='id[]' value='$id'>
                            <button type='submit' class='btn btn-primary' name='add_to_cart'>Add to cart</button>
                        </form>
                    </div>
                </div>
                ";
            }
            ?>
        </div>
    </div>

    <script>
        // refresh amount of books in cart when page is loaded
        document.addEventListener('DOMContentLoaded', function() {
            getCartCount();
        });

        // remove duplicate books from cart
        function removeDuplicates(books) {
            var newBooks = [];

            for (var i = 0; i < books.length; i++) {
                var book = books[i];
                var duplicate = false;

                for (var j = 0; j < newBooks.length; j++) {
                    var newBook = newBooks[j];
                    if (book.id == newBook.id) {
                        duplicate = true;
                    }
                }

                if (!duplicate) {
                    newBooks.push(book);
                }
            }

            return newBooks;
        }

        // get and set amount of books in cart
        function getCartCount() {
            let shopping_cart = localStorage.getItem('cart');
            console.log(shopping_cart);

            if (shopping_cart != null) {
                let books = removeDuplicates(JSON.parse(shopping_cart));
                document.getElementById('cart-count').innerHTML = books.length;
            }
        }

        <?php
        // if add to cart button is pressed add the book to the cart
        if (isset($_POST['add_to_cart'])) {
            $id = $_POST['id'][0];
            $query = "SELECT * FROM book WHERE id = :id";
            $statement = $conn->prepare($query);
            $statement->bindValue(':id', $id);
            $statement->execute();
            $book = $statement->fetch();
            $statement->closeCursor();

            $id = $book['id'];

            // add book to local storage cart
            echo "
                let cart = localStorage.getItem('cart');
                if (cart == null) {
                    let products = [];
                    let product = {id: $id};
                    products.push(product);
                    localStorage.setItem('cart', JSON.stringify(products));
                } else {
                    let products = JSON.parse(cart);
                    let product = {id: $id};
                    products.push(product);
                    localStorage.setItem('cart', JSON.stringify(products));
                }";
        }
        ?>
        
    </script>

    <?php include "footer.php"; ?>
</body>
</html>