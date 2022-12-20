<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store</title>
</head>
<body>
    <h2>Store</h2>

    <?php

    // Get all books from the database and display them in a collumn of cards with the book data
    require_once('connect.php');
    $query = "SELECT * FROM book";
    $statement = $conn->prepare($query);
    $statement->execute();
    $books = $statement->fetchAll();
    $statement->closeCursor();

    foreach ($books as $book) {
        $id = $book['id'];
        $title = $book['title'];
        $price = $book['price'];
        $image = $book['image'];


        echo "
        <div class='card'>
            <img src='data:image/jpeg;base64,".base64_encode($image)."'/>
            <a href='./product.php?id=".$id."'><h3>$title</h3></a>
            <p>$price</p>
            <form action='#' method='post'>
                <input type='hidden' name='id' value='$id'>
                <button type='submit' name='add_to_cart'>Add to cart</button>
            </form>
        </div>
        ";
    }

    // if add to cart button is pressed add the book to the cart
    if (isset($_POST['add_to_cart'])) {
        $id = $_POST['id'];
        $query = "SELECT * FROM book WHERE id = :id";
        $statement = $conn->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $book = $statement->fetch();
        $statement->closeCursor();

        $id = $book['id'];
        $title = $book['title'];
        $price = $book['price'];
        $image = $book['image'];

        echo "
        <script>
            let cart = localStorage.getItem('cart');
            if (cart == null) {
                let products = [];
                let product = {id: $id, title: '$title', price: $price, image: '$image'};
                products.push(product);
                localStorage.setItem('cart', JSON.stringify(products));
            } else {
                let products = JSON.parse(cart);
                let product = {id: $id, title: '$title', price: $price, image: '$image'};
                products.push(product);
                localStorage.setItem('cart', JSON.stringify(products));
            }
        </script>
        ";
    }
    

    ?>
</body>
</html>