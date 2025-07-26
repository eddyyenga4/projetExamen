<?php
$conn = new mysqli("localhost","root","","mobondo");

// Vérification
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}
?>
