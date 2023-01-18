<?php include "connect.php"; ?>
<!doctype html>
<html lang="en">
<?php include "header.php"; ?>
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
                  <img src="img/topg.jpg" class="d-block img-fluid" alt="...">
                </div>
                <div class="carousel-item">
                  <img src="img/manga.jpg" class="d-block img-fluid" alt="...">
                </div>
                <div class="carousel-item">
                  <img src="img/annefrank.jpg" class="d-block img-fluid" alt="...">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <?php include "footer.php"; ?>