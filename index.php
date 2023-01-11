<?php include "connect.php"; ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Stripbook</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
  </head>
  <body>
    <section id="header">
      <div id="header" class="container-fluid py-4">
        <div class="row">
        <div class="col-6">
            <h2>comiclibrary</h2>
          </div>
          <div class="col-6 d-flex flex-row-reverse">
            <div class="p-2"><a href="login.php">Login</a></div>
            <div class="p-2"><a href="cart.php">Cart</a></div>
            <div class="p-2"><a href="library.php">Library</a></div>
            <div class="p-2"><a href="store.php">Shop</a></div>
          </div>
        </div>
      </div>
    </section>
    <div class="py-5"></div>
    <section id="content">
      <div class="container">
        <div class="row justify-content-center">
          <div class="py-2"></div>
          <div class="col-12 text-center"><h3>De grootste online stripboeken bib.</h3></div>
          <div class="col-6 py-5">
            <h4><a href="#">Nieuw</a></h4><br>
            <h4><a href="#">Binnenkort</a></h4><br>
            <h4><a href="#">Contact</a></h4>
          </div>
          <div class="col-6">
            <div id="carousel" class="carousel slide" data-bs-ride="carousel">
              <div class="carousel-inner">
                <div class="carousel-item active">
                  <img src="../img/topg.jpg" class="d-block img-fluid" alt="...">
                </div>
                <div class="carousel-item">
                  <img src="../img/manga.jpg" class="d-block img-fluid" alt="...">
                </div>
                <div class="carousel-item">
                  <img src="../img/annefrank.jpg" class="d-block img-fluid" alt="...">
                </div>
              </div>
              <button class="carousel-control-prev" type="button" data-bs-target="#carousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#carousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </section>
    <div class="py-5"></div>
    <section id="footer">
      <div class="container">
        <div class="row justify-content-evenly">
          <div class="col-4">
            <div class="text-center">
              <h6>Nieuwsbrief</h6>
            </div>
          </div>
          <div class="col-4">
            <div class="text-center">
              <h6>Contact</h6>
              <p>email: comiclibrary@support.com<br>
                 telephone number: +31 6 12345678<br>
                 adres: 2311WV Amsterdam<br>
                 oosterhoekstraat 37</p>
            </div>
          </div>
          <div class="col-4">
            <div class="text-center">
              <h6>Navigatie</h6>
              <a href="#">upcoming</a>
            </div>
          </div>
        </div>
      </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  </body>
</html>