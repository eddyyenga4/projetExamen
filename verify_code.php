<?php

require_once 'db.php';

$verification_result = ''; // Variable pour stocker le résultat de la vérification

if (isset($_POST['btnVerifyBrevet'])) {
    $brevet_number_input = trim($_POST['brevetNumber']);

    // Validation du format du numéro de brevet (ex: N.0005-KIN/2025-OGI)
    // Expression régulière pour un format strict: N. suivi de 4 chiffres, puis -KIN/, 4 chiffres pour l'année, puis -OGI
    if (!preg_match('/^N\.\d{4}-KIN\/\d{4}-OGI$/', $brevet_number_input)) {
        $verification_result = "<div class='alert alert-danger' role='alert'>Format du numéro de brevet invalide. Exemple attendu: N.####-KIN/####-OGI</div>";
    } else {
        try {
            // Préparer la requête pour rechercher le numéro de brevet
            $stmt = $conn->prepare("SELECT nom, postnom, prenom, formation_nom, date_debut, date_fin, numero_brevet, etat FROM certifications WHERE numero_brevet = ?");
            $stmt->execute([$brevet_number_input]);
            $certification = $stmt->fetch(mode: PDO::FETCH_ASSOC);
            if ($certification) {
                // Brevet trouvé, afficher les détails
                $etat_text = ($certification['etat'] == 1) ? '<span style="color: green; font-weight: bold;">Validé (Brevet émis)</span>' : '<span style="color: orange; font-weight: bold;">En cours de traitement (Non encore émis)</span>';
            echo "

            <script>
            Swal.fire({
                title: '🎓 Brevet trouvé !',
                html: `
                    <div style='text-align: left; font-size: 16px; line-height: 1.6; padding: 10px;'>
                        <p><strong>Numéro de Brevet :</strong> <span style='color: #2d89ef; font-weight: bold;'>" . htmlspecialchars($certification['numero_brevet']) . "</span></p>
                        
                        <p><strong>Nom Complet :</strong>
                        " . htmlspecialchars($certification['nom'] . ' ' . $certification['postnom'] . ' ' . $certification['prenom']) . "</p>

                        <p><strong>Formation :</strong>
                        " . htmlspecialchars($certification['formation_nom']) . "</p>

                        <p><strong>Période :</strong>
                        Du <span style='color: green;'>" . htmlspecialchars(date('d/m/Y', strtotime($certification['date_debut']))) . "</span> 
                        au <span style='color: green;'>" . htmlspecialchars(date('d/m/Y', strtotime($certification['date_fin']))) . "</span></p>

                        <p><strong>État du Brevet :</strong>
                        <span style='color: darkgreen; font-weight: bold;'>" . $etat_text . "</span></p>
                    </div>
                `,
                icon: 'success',
                confirmButtonText: 'Fermer',
                confirmButtonColor: '#3085d6',
                width: 600,
                
            });
            </script>
            ";


            } else {
                // Brevet non trouvé
                $verification_result = "<div class='alert alert-warning' role='alert'>Aucun brevet trouvé avec ce numéro. Veuillez vérifier le numéro et réessayer.</div>";
            }
        } catch (PDOException $e) {
            error_log("Erreur de base de données lors de la vérification du brevet: " . $e->getMessage());
            $verification_result = "<div class='alert alert-danger' role='alert'>Une erreur est survenue lors de la vérification. Veuillez réessayer.</div>";
        }
    }
}
?>


<style>
  body {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      background-color: #f8f9fa;
      margin: 0;
  }

  .center-wrapper {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      padding: 30px 15px;
  }

  .main-signup-header {
      background-color: #ffffff;
      padding: 40px 30px;
      border-radius: 8px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 650px;
      text-align: center;
      overflow-y: auto;
  }

  .form-group {
      margin-bottom: 25px;
      text-align: left;
  }

  .form-control {
      border-radius: 5px;
      padding: 12px 15px;
      font-size: 16px;
      border: 1px solid #ced4da;
      width: 100%;
      box-sizing: border-box;
  }

  .btn-dark {
      background-color: #343a40;
      border-color: #343a40;
      color: #ffffff;
      padding: 12px 20px;
      font-size: 18px;
      border-radius: 30px;
      width: 100%;
      cursor: pointer;
  }

  .btn-dark:hover {
      background-color: #23272b;
      border-color: #23272b;
  }

  .alert {
      padding: 15px;
      margin-bottom: 20px;
      border-radius: 4px;
      font-size: 15px;
      text-align: left;
      overflow-wrap: break-word;
  }

  .alert-success {
      color: #155724;
      background-color: #d4edda;
      border-color: #c3e6cb;
  }

  .alert-danger {
      color: #721c24;
      background-color: #f8d7da;
      border-color: #f5c6cb;
  }

  .alert-warning {
      color: #856404;
      background-color: #fff3cd;
      border-color: #ffeeba;
  }

  @media (max-width: 576px) {
      .main-signup-header {
          padding: 30px 20px;
          font-size: 15px;
      }

      .btn-dark {
          font-size: 16px;
      }
  }
  form {
  position: relative;
  z-index: 10;
}


</style>


<body class="main-body app sidebar-mini ltr">
  <div class="main-container container-fluid">
    <div class="center-wrapper">
      <div class="main-signup-header">
        <h2 class="text-dark text-center">Vérification de l'Authenticité du Brevet</h2>
        <h5 class="fw-semibold mb-4 text-center">Entrez le numéro de brevet pour vérifier</h5>

        <?= $verification_result ?>

        <form role="form" method="POST" action="">
          <div class="form-group">
            <label for="brevetNumber">Numéro de Brevet</label>
            <input class="form-control" type="text" name="brevetNumber" id="brevetNumber" 
                   placeholder="Ex: N.####-KIN/####-OGI" required 
                   value="<?= isset($_POST['brevetNumber']) ? htmlspecialchars($_POST['brevetNumber']) : '' ?>">
            <small class="form-text text-muted mt-2">
              Veuillez entrer le numéro de brevet exactement tel qu'il apparaît sur le document (ex: N.0000-KIN/2000-OGI).
            </small>
          </div>

          <button type="submit" class="btn btn-dark btn-rounded btn-block" name="btnVerifyBrevet">
            Vérifier le Brevet
          </button>
        </form>

        <hr class="my-4" />
        <div class="text-center"><small>&copy; Tous droits réservés OGI-2025</small></div>
      </div>
    </div>
  </div>
</body>


</html>
