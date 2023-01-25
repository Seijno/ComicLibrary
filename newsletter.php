<?php 
// if email is set, send confirmation email
if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $to = $email;
    $subject = "Comic Library - Nieuwsbrief";
    $message = "Bedankt voor het inschrijven op onze nieuwsbrief! Klik op de link om je deelname te bevestigen:";
    $headers = "From: ";
    mail($to, $subject, $message, $headers);
    echo "<script>alert('Klik op de link in de e-mail om je deelname te bevestigen.')</script>";

    // redirect back to previous page
    echo "<script>window.location.href = document.referrer;</script>";

}

?>