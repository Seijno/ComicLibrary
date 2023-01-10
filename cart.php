<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
    <title>Cart</title>
</head>
<body>
<h2>Cart</h2>

<form action='checkout.php' method='post'>
    <div id="cart"></div>
    <div id="total"></div>
</form>

<script>
    // get books from localstorage
    var books = removeDuplicates(JSON.parse(localStorage.getItem('cart')));
    var total = 0;

    // check if cart is empty
    if (books.length > 0) {
        // loop through books and append them to the cart
        for (var i = 0; i < books.length; i++) {
            var book = books[i];
            var id = book.id;
            var title = book.title;
            var price = book.price;

            total += price;

            $('#cart').append(`
                <div class="card">
                    <h3>${title}</h3>
                    <p>$${price}</p>
                    <input type="hidden" name="id[]" value="${id}">
                    <button type="button" onclick="removeFromCart(${id})">Remove</button><br><br><br>
                </div>
            `);
        }

        // add buy button and total price
        $('#total').append(`
            <button type="submit" name="buy">Buy</button>
            <h3>Total: $${total}</h3>
        `);
    } else {
        // if cart is empty display message
        $('#cart').append(`
            <div class="card">
                <h3>Cart is empty</h3>
            </div>
        `);
    }

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

    // remove book from cart
    function removeFromCart(id) {
        var books = JSON.parse(localStorage.getItem('cart'));
        var newBooks = [];

        for (var i = 0; i < books.length; i++) {
            var book = books[i];
            if (book.id != id) {
                newBooks.push(book);
            }
        }

        localStorage.setItem('cart', JSON.stringify(newBooks));
        location.reload();
    }

</script>
</body>
</html>