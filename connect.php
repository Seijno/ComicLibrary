<?php
$servername = "localhost";
$username = "comiclibrary";
$password = "schotanus69";
$db = "comiclibrary";

try {
  $conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
?>