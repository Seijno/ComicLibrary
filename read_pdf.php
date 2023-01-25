<?php include "header.php"; ?>  
    <div class="pdf-container container">
        <div class="row">
            <?php GetPDF(); ?>

            <div class="col-12">
                <a href="library.php" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <?php include "footer.php"; ?> 
</body>
</html>

<?php
// get the pdf file from the database and display it
function GetPDF() {
    include "connect.php";
    AuthPDF();

    $query = $conn->prepare("SELECT pdf FROM book WHERE id = :id");
    $query->bindParam(":id", $_GET["id"]);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        echo "<embed src='data:application/pdf;base64," . base64_encode($result["pdf"]) . "' type='application/pdf' class='vw-100'>'";
    } else {
        header("Location: library.php");
    }  
}

// check if user owns the book they want to read
function AuthPDF() {
    include "connect.php";

    // check if user is a store owner to determine which books they can read
    if (isset($_SESSION["role"]) && $_SESSION["role"] == "2") {
        // their own books & library books | store owner
        $query = $conn->prepare("SELECT book_id FROM library WHERE user_id = :id AND book_id = :book_id UNION SELECT id FROM book WHERE store_id = :id AND id = :book_id");
    } else {
        // library books | user
        $query = $conn->prepare("SELECT book_id FROM library WHERE user_id = :id AND book_id = :book_id");
    }

    $query->bindParam(":id", $_SESSION["id"]);
    $query->bindParam(":book_id", $_GET["id"]);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);

    if (empty($result)) {
        header("Location: library.php");
    } 
}

?>