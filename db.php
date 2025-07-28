<?php
$conn = new mysqli("localhost","root","2024","mobondo");

// Vérification
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}
?>
