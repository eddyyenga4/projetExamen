<?php
session_start(); // TOUJOURS démarrer la session au tout début du fichier
require_once 'db.php'; 

$verification_status = '';
$email_to_verify = '';

// Récupérer l'email de l'URL si présent (envoyé depuis la page d'envoi du code)
if (isset($_GET['email']) && filter_var($_GET['email'], FILTER_VALIDATE_EMAIL)) {
    $email_to_verify = htmlspecialchars($_GET['email']);
} elseif (isset($_POST['hiddenEmail']) && filter_var($_POST['hiddenEmail'], FILTER_VALIDATE_EMAIL)) {
    $email_to_verify = htmlspecialchars($_POST['hiddenEmail']);
}

// Vérifier si le formulaire de confirmation a été soumis
if (isset($_POST['btnConfirm'])) {
    $enteredCode = trim($_POST['inputToken']);
    $submittedEmail = filter_var($_POST['hiddenEmail'], FILTER_SANITIZE_EMAIL);

    if (!filter_var($submittedEmail, FILTER_VALIDATE_EMAIL)) {
        $verification_status = "<div class='alert alert-danger' role='alert'>Adresse email invalide soumise.</div>";
    } elseif (empty($enteredCode)) {
        $verification_status = "<div class='alert alert-warning' role='alert'>Veuillez saisir le code de confirmation.</div>";
    } else {
        // Requête pour vérifier le code
        $query = "SELECT id FROM email_verifications 
                  WHERE email = ? AND verification_code = ? AND is_used = 0 AND expires_at > NOW()";
        $stmt = mysqli_prepare($conn, $query);
        
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ss", $submittedEmail, $enteredCode);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);

            if ($row) {
                // Code valide : Marquer comme utilisé
                $updateQuery = "UPDATE email_verifications SET is_used = 1 WHERE id = ?";
                $updateStmt = mysqli_prepare($conn, $updateQuery);
                
                if ($updateStmt) {
                    mysqli_stmt_bind_param($updateStmt, "i", $row['id']);
                    mysqli_stmt_execute($updateStmt);
                    mysqli_stmt_close($updateStmt);
                }

                // Enregistrer dans la session
                $_SESSION['email_valide'] = true;
                $_SESSION['email_utilisateur'] = $submittedEmail;

                // Rediriger
                header("Location: formulaire.html?validated_email=" . urlencode($submittedEmail));
                exit();
            } else {
                $verification_status = "<div class='alert alert-danger' role='alert'>Code de confirmation invalide, expiré ou déjà utilisé. Veuillez réessayer.</div>";
            }

            mysqli_stmt_close($stmt);
        } else {
            error_log("Erreur de préparation de requête : " . mysqli_error($conn));
            $verification_status = "<div class='alert alert-danger' role='alert'>Une erreur est survenue lors de la vérification. Veuillez réessayer.</div>";
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
        .main-signup-header {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            max-width: 700px;
            width: 100%;
            text-align: center;
        }
        .form-group {
            margin-bottom: 25px;
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
        .main-signin-footer {
            margin-top: 30px;
        }
        .main-signin-footer a {
            color: #007bff;
            text-decoration: none;
            font-weight: 500;
        }
        .main-signin-footer a:hover {
            text-decoration: underline;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
            font-size: 15px;
            text-align: left;
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
    </style>
<body class="main-body app sidebar-mini ltr">

    <div class="main-container container-fluid">
        <div class="row no-gutter">

<div class="col-md-12 col-lg-12 d-flex justify-content-center">
    <div class="login py-5 w-100" style="max-width: 700px;">
        <div class="card-login shadow-lg p-6 bg-white rounded">
            <div class="main-signup-header">
                <h2 class="text-dark text-center">Confirmation de l'email</h2>
                <h5 class="fw-semibold mb-4 text-center text-dark">
                    Veuillez renseigner le code de confirmation reçu par email
                </h5>

                <?php
                // Afficher les messages d'état (succès, erreur, avertissement)
                if (!empty($verification_status)) {
                    echo $verification_status;
                }
                ?>

                <form name="form1" id="form1" method="post" action="" >
                    <div class="form-group mb-3 " >
                        <label for="inputToken">Code de confirmation</label>
                        <input class="form-control" type="text" name="inputToken" id="inputToken"
                            placeholder="Saisir votre code de confirmation" required pattern="\d{14}"
                            title="Le code doit contenir 14 chiffres">
                        <input type="hidden" name="hiddenEmail"
                            value="<?php echo htmlspecialchars($email_to_verify); ?>">
                    </div>

                    <button type="submit" class="btn btn-dark w-100" name="btnConfirm" id="btnConfirm"
                        value="Confirmer">Confirmer</button>
                </form>

                <div class="main-signin-footer mt-4 text-center">
                    <p><a href="index.php">Retour</a></p>
                </div>
            </div>
        </div>

        <div class="text-center mt-3">
            <small>&copy; Tous droits réservés OGI-2025</small>
        </div>
    </div>
</div>

    </div>

    
  <!-- Scripts -->
  <!-- Bootstrap core JavaScript -->
  <script src="vendors/jquery/jquery.min.js"></script>
  <script src="vendors/bootstrap/js/bootstrap.bundle.min.js"></script>

  <script src="assets/js/isotope.min.js"></script>
  <script src="assets/js/owl-carousel.js"></script>
  <script src="assets/js/lightbox.js"></script>
  <script src="assets/js/tabs.js"></script>
  <script src="assets/js/video.js"></script>
  <script src="assets/js/slick-slider.js"></script>
  <script src="assets/js/custom.js"></script>
  <script>
    //according to loftblog tut
    $('.nav li:first').addClass('active');

    var showSection = function(showSection, isAnimate) {
      var direction = showSection.replace(/#/, ''),
        reqSection = $('.section').filter('[data-section="' + direction + '"]'),
        reqSectionPos = reqSection.offset().top - 0;

      if (isAnimate) {
        $('body, html').animate({
          scrollTop: reqSectionPos
        }, 800);
      } else {
        $('body, html').scrollTop(reqSectionPos);
      }

    };

    var checkSection = function() {
      $('.section').each(function() {
        var $this = $(this),
          topEdge = $this.offset().top - 80,
          bottomEdge = topEdge + $this.height(),
          wScroll = $(window).scrollTop();
        if (topEdge < wScroll && bottomEdge > wScroll) {
          var currentId = $this.data('section'),
            reqLink = $('a').filter('[href*=\\#' + currentId + ']');
          reqLink.closest('li').addClass('active').
          siblings().removeClass('active');
        }
      });
    };

    $('.main-menu, .responsive-menu, .scroll-to-section').on('click', 'a', function(e) {
      e.preventDefault();
      showSection($(this).attr('href'), true);
    });

    $(window).scroll(function() {
      checkSection();
    });
  </script>
</body>

</html>
