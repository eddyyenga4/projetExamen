<?php
require 'db.php'; // connexion mysqli dans $conn

$input = trim($_POST['identifier']);

if (empty($input)) {
    echo json_encode(['status' => 'error', 'message' => 'Champ vide']);
    exit;
}

$sql = "SELECT statut FROM preinscription WHERE email = ? OR id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $input, $input);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $statut = $row['statut'];
    $message = "";

    switch (strtolower($statut)) {
        case 'accepté':
            $message = "✅ Accepté : Votre dossier est validé.";
            break;
        case 'refusé':
            $message = "❌ Refusé : Veuillez contacter le service des admissions.";
            break;
        case 'en attente':
        default:
            $message = "⏳ En attente : Votre dossier est en cours de traitement.";
            break;
    }

    echo json_encode(['status' => 'success', 'message' => $message]);
} else {
    echo json_encode(['status' => 'not_found', 'message' => 'Aucun dossier trouvé avec cet identifiant.']);
}

$stmt->close();
$conn->close();
?>
