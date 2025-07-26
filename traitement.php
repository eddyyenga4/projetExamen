<?php
require 'db.php';

// Récupération des données du formulaire (étape 1)
$nom_complet = $_POST['nom'];
$date_naissance = $_POST['date_naissance'];
$sexe = $_POST['sexe'];
$email = $_POST['email'];
$telephone = $_POST['telephone'];
$pays = $_POST['pays'];
$ville = $_POST['ville'];
$quartier = $_POST['quartier'];
$universite = $_POST['universite'];
$filiere = $_POST['filiere'];
$type_piece = $_POST['type_piece'];
$numero_piece = $_POST['numero_piece'];
$dernier_diplome = $_POST['dernier_diplome'];
$profession = !empty($_POST['profession']) ? $_POST['profession'] : NULL;

// Gestion des fichiers (étape 2)
$photo_identite = 'uploads/' . basename($_FILES['photo_identite']['name']);
$copie_piece = 'uploads/' . basename($_FILES['copie_piece']['name']);
$releve_notes = 'uploads/' . basename($_FILES['releve_notes']['name']);
$autres_documents = '';

if (isset($_FILES['autres_documents']['name']) && is_array($_FILES['autres_documents']['name']) && !empty($_FILES['autres_documents']['name'][0])) {
    $fileNames = [];
    foreach ($_FILES['autres_documents']['name'] as $index => $fileName) {
        $destination = 'uploads/' . basename($fileName);
        move_uploaded_file($_FILES['autres_documents']['tmp_name'][$index], $destination);
        $fileNames[] = $destination;
    }
    $autres_documents = implode(',', $fileNames);
}

// Upload des fichiers principaux
move_uploaded_file($_FILES['photo_identite']['tmp_name'], $photo_identite);
move_uploaded_file($_FILES['copie_piece']['tmp_name'], $copie_piece);
move_uploaded_file($_FILES['releve_notes']['tmp_name'], $releve_notes);

// Requête préparée d'insertion
$stmt = $conn->prepare("
    INSERT INTO preinscription (
        nom_complet, date_naissance, sexe, email, telephone, 
        pays, ville, quartier, universite, filiere,
        type_piece, numero_piece, dernier_diplome, profession, 
        photo_identite, copie_piece, releve_notes, autres_documents
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");

$stmt->bind_param(
    "ssssssssssssssssss",
    $nom_complet, $date_naissance, $sexe, $email, $telephone,
    $pays, $ville, $quartier, $universite, $filiere,
    $type_piece, $numero_piece, $dernier_diplome, $profession,
    $photo_identite, $copie_piece, $releve_notes, $autres_documents
);

if ($stmt->execute()) {
    header("location:felicitation.html");
    exit();
} else {
    echo "Erreur : " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
