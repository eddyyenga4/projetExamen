<?php
    require 'db.php';

    header('Content-Type: application/json');

    $identifiant = trim($_POST['code'] ?? '');

    if (!$identifiant) {
        echo json_encode(['status' => 'error', 'message' => 'Identifiant vide.']);
        exit;
    }

    // On vérifie si c’est un email ou un ID numérique
    $sql = "SELECT id, nom_complet, email, date_naissance, photo_identite, DATE(date_soumission) as date_inscription 
            FROM preinscription 
            WHERE email = ? OR id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $identifiant, $identifiant);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($data = $result->fetch_assoc()) {
        echo json_encode([
            'status' => 'success',
            'data' => [
                'nom' => $data['nom_complet'],
                'numero' => $data['id'],
                'email' => $data['email'],
                'date' => date('d/m/Y', strtotime($data['date_inscription'])),
                'photo' => $data['photo_identite']
            ]
        ]);
    } else {
        echo json_encode(['status' => 'not_found', 'message' => 'Aucune donnée trouvée.']);
    }

    $stmt->close();
    $conn->close();
?>
