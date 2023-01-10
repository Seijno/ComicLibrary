<?php
include_once("connect.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
</head>
<body>
    <?php
    // check if user is logged in before checkout
    if (isset($_POST['buy'])) {
        session_start();
        if (!isset($_SESSION['id'])) {
            echo "<script>alert('You must create an account to buy books');
            window.location.href = 'register.php';</script>";
        }
    } else {
        // redirect to cart page if cart post data is empty
        header('Location: cart.php');
    }
    
    // display the post data
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    
    // delete cart data from local storage
    // echo "<script>localStorage.removeItem('cart');</>";

    ?>

    <!-- create a checkout page -->
    <h2>Checkout</h2>
    <p>Thank you for your purchase.</p>
    <p>Click <a href="library.php">here</a> to return view your books.</p>
</body>
</html>