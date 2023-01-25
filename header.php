<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Comic Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
  </head>
  <body>
    <section id="header">
      <div id="header" class="container-fluid py-4">
        <div class="row">
        <div class="col-6">
            <a href="index.php"><h2>comiclibrary</h2></a>
          </div>
          <div class="col-6 d-flex flex-row-reverse">
            <?php
            if (!isset($_SESSION)) {
              session_start();
            }

            // if user is logged in, show logout button else login & register button
            if (isset($_SESSION["id"])) {
              echo "<div class='p-2'><a href='?logout'>Logout</a></div>";
            } else {
              echo "<div class='p-2'><a href='register.php'>Register</a></div>";
              echo "<div class='p-2'><a href='login.php'>Login</a></div>";
            }
            ?>

            <?php 
            // if role is user, show request button
            if (isset($_SESSION["role"]) && $_SESSION["role"] == "0") {
              echo "<div class='p-2'><a href='request_store.php'>Request</a></div>";
            }
            ?>
            
            <div class="p-2"><a href="cart.php">Cart</a></div>
            <div class="p-2"><a href="library.php">Library</a></div>

            <?php 
            // if role of user is store owner, show overview button hide library and cart button
            if (isset($_SESSION["role"]) && $_SESSION["role"] == "2") {
              echo "<div class='p-2'><a href='overview.php'>Overview</a></div>";
            }
            ?>

            <?php 
            // if role of user is admin, show admin pages
            if (isset($_SESSION["role"]) && $_SESSION["role"] == "1") {
              echo "<div class='p-2'><a href='admin/index.php'>Admin</a></div>";
            }
            ?>

            <div class="p-2"><a href="store.php">Shop</a></div>
          </div>
        </div>
      </div>
    </section>
    <div class="py-5"></div>
    <div class="py-4"></div>

    <?php 
    // if logout is set, destroy session and redirect to login page
    if (isset($_GET["logout"])) {
      session_destroy();
      header("Location: login.php");
    }
    ?>
    <!-- commit -->