<?php include "header.php"; ?>

<div class="container">
    <h2>Cart</h2>

    <form action='checkout.php' method='post'>
        <div id='cart' class="cart container py-4">
            <div class="row justify-content-center">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="h5">Book</th>
                                <th>Author</th>
                                <th>Genre</th>
                                <th>Price</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="cart-list">
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col mb-3">
                <button type="submit" class="btn btn-primary my-3" name="buy">Checkout</button>
            </div>
            <div class="col text-end">
                <p id="total" class=""></p>
            </div>
        </div>
    </form>
</div>

<script>
    var books = removeDuplicates(JSON.parse(localStorage.getItem('cart')));
    
    // create an array to store prices
    var prices = [];

    // Check if cart is empty
    if (books != null && books.length > 0) {

        // loop through books and append them to the cart
        for (var i = 0; i < books.length; i++) {
            var id = books[i].id;

            // request book data from database
            var request = new XMLHttpRequest();
            request.open("GET", "get_book.php?id=" + id, true);
            request.send();
            request.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // parse data from json
                    var book = JSON.parse(this.responseText)[0];

                    // get price and add it to the prices array
                    var price = parseFloat(book.price);
                    prices.push(price);

                    // display total price
                    $('#total').html(`Total: €${prices.reduce((a, b) => a + b, 0)}`);

                    // display book to on cart list
                    $('#cart-list').append(`
                        <tr>
                            <th>
                                <div class="d-flex align-items-center">
                                    <img src="data:image/jpeg;base64, ${book.image}" class="img-fluid rounded-3" style="width: 120px;" alt="Book cover">
                                    <div class="flex-column ms-4">
                                        <p class="mb-2">${book.title}</p>
                                        <p class="mb-0 text-secondary">${book.description}</p>
                                    </div>
                                </div>
                            </th>
                            <td class="align-middle">
                                <p class="mb-0" style="font-weight: 500;">${book.author}</p>
                            </td>
                            <td class="align-middle">
                                <p class="mb-0" style="font-weight: 500;">${book.genre}</p>
                            </td>
                            <td class="align-middle">
                                <p class="mb-0" style="font-weight: 500;">€${book.price}</p>
                            </td>

                            <td class="align-middle">
                                <input type="hidden" name="id[]" value="${book.id}">
                                <a class='removeButton link-danger' onclick='removeFromCart(${book.id})'><i class='delete-btn bi bi-x fs-4'></i></a>
                            </td>
                        </tr>
                        `);
                    }
                }
            }
        } else {
            // replace cart with message and remove checkout button
            $('#cart').html(`
            <div class="alert alert-secondary" role="alert">
                Your cart is empty!
            </div>
            `);
            $('button[name="buy"]').remove();
        }

        // remove duplicate books from cart
        function removeDuplicates(books) {
            var newBooks = [];
            
            // if books is null return null
            if (books == null) {
                return null;
            }
            
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