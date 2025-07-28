<?php
session_start();
include 'db.php'; // $conn est une connexion mysqli (avec mysqli_connect)

require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$error = '';
$success = '';

if (isset($_POST['valider'])) {
    $email = filter_var($_POST['emailAdress'], FILTER_SANITIZE_EMAIL);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Veuillez entrer une adresse email valide.";
    } else {
        $verificationCode = str_pad(mt_rand(1, 99999999999999), 14, '0', STR_PAD_LEFT);

        // Assurer l'unicité du code
        do {
            $stmt_check_code = mysqli_prepare($conn, "SELECT COUNT(*) FROM email_verifications WHERE verification_code = ?");
            mysqli_stmt_bind_param($stmt_check_code, "s", $verificationCode);
            mysqli_stmt_execute($stmt_check_code);
            mysqli_stmt_bind_result($stmt_check_code, $count);
            mysqli_stmt_fetch($stmt_check_code);
            mysqli_stmt_close($stmt_check_code);

            $is_code_unique = ($count == 0);
            if (!$is_code_unique) {
                $verificationCode = str_pad(mt_rand(1, 99999999999999), 14, '0', STR_PAD_LEFT);
            }
        } while (!$is_code_unique);

        $expiresAt = date('Y-m-d H:i:s', strtotime('+30 minutes'));

        // Supprimer les anciens codes
        $stmt_delete_old = mysqli_prepare($conn, "DELETE FROM email_verifications WHERE email = ? AND is_used = 0 AND expires_at > NOW()");
        mysqli_stmt_bind_param($stmt_delete_old, "s", $email);
        mysqli_stmt_execute($stmt_delete_old);
        mysqli_stmt_close($stmt_delete_old);

        // Insérer le nouveau code
        $stmt_insert = mysqli_prepare($conn, "INSERT INTO email_verifications (email, verification_code, expires_at) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt_insert, "sss", $email, $verificationCode, $expiresAt);
        if (!mysqli_stmt_execute($stmt_insert)) {
            $error = "Erreur lors de l'enregistrement du code.";
        }
        mysqli_stmt_close($stmt_insert);

        // --- Envoi d'e-mail ---
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'ogisylla18@gmail.com';
            $mail->Password   = 'lnbd jxgp haqw iuqo'; // mot de passe d'application
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

            $mail->setFrom('bundya005@gmail.com', 'Département d\'Inscription BAKUBWA');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = "Département de la Préinscription BAKUBWA : Votre code de confirmation";

            $primaryColor = '#007bff';
            $accentColor = '#FFA500';

            $mail->Body = '
              <div style="font-family: \'Roboto\', \'Helvetica Neue\', \'Arial\', sans-serif; font-size: 14px; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden; background-color: #ffffff;">
                    <div style="background-color: ' . $primaryColor . '; color: #ffffff; padding: 20px; text-align: center; border-bottom: 3px solid ' . $accentColor . ';">
                        <h2 style="margin: 0; font-size: 20px; font-weight: bold;">Département d\'Inscription BAKUBWA</h2>
                    </div>
                    <div style="padding: 30px;">
                        <p style="font-size: 15px;">Bonjour,</p>
                        <p style="font-size: 15px;">Merci de votre intérêt pour le Département d\'Inscription BAKUBWA.</p>
                        <p style="font-size: 15px;">Votre code de confirmation est : <br><strong style="font-size: 22px; color: ' . $primaryColor . '; letter-spacing: 2px; display: block; text-align: center; margin: 15px 0; padding: 10px; background-color: #f0f8ff; border-radius: 5px;">' . htmlspecialchars($verificationCode) . '</strong></p>
                        <p style="font-size: 15px;">Ce code expirera dans <strong>30 minutes</strong>. Veuillez l\'utiliser pour confirmer votre adresse email afin de poursuivre votre démarche.</p>
                        <p style="font-size: 14px; color: #777;">Si vous n\'avez pas initié cette demande, veuillez ignorer cet e-mail.</p>
                        <p style="font-size: 15px;">Cordialement,</p>
                        <p style="font-size: 15px; margin-bottom: 5px;">L\'équipe du Département d\'Inscription BAKUBWA</p>
                        <p style="font-size: 15px; margin-top: 0; font-weight: bold; color: ' . $primaryColor . ';">BUNDYA MUKULAMNYA (Chargé de la préinscription)</p>
                    </div>
                    <div style="background-color: #f7f7f7; color: #666; padding: 20px; text-align: center; font-size: 11px; border-top: 1px solid #eee;">
                        <p>&copy; ' . date('Y') . ' Département de la Préinscription BAKUBWA. Tous droits réservés.</p>
                    </div>
                </div>
            ';

            $mail->AltBody = "Bonjour,\n\nMerci de votre intérêt pour le Département de la Préinscription BAKUBWA.\n\nVotre code de confirmation est : " . $verificationCode . "\n\nCe code expirera dans 30 minutes. Veuillez l'utiliser pour confirmer votre adresse email afin de poursuivre votre démarche.\n\nSi vous n'avez pas initié cette demande, veuillez ignorer cet e-mail.\n\nCordialement,\nL'équipe du Département de la Préinscription BAKUBWA\nSYLLA HABDOURA HAMAN (Chargé de formation)\n\n© " . date('Y') . " Département de la Préinscription BAKUBWA. Tous droits réservés." . $verificationCode;

            $mail->CharSet = 'UTF-8';
            $mail->send();

            $success = "Un code de vérification a été envoyé.";
            header("Location: verify_code.php?email=" . urlencode($email));
            exit();

        } catch (Exception $e) {
            $error = "L'e-mail n'a pas pu être envoyé. Erreur : {$mail->ErrorInfo}";

            // Supprimer le code si envoi échoué
            $stmt_delete_failed = mysqli_prepare($conn, "DELETE FROM email_verifications WHERE verification_code = ?");
            mysqli_stmt_bind_param($stmt_delete_failed, "s", $verificationCode);
            mysqli_stmt_execute($stmt_delete_failed);
            mysqli_stmt_close($stmt_delete_failed);
        }
    }
}
?>




<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="TemplateMo">
  <title>Connexion - Université BBM</title>

  <!-- Bootstrap & CSS -->
  <link href="vendors/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/fontawesome.css">
  <link rel="stylesheet" href="assets/css/templatemo-edu-meeting.css">
  <link rel="stylesheet" href="assets/css/owl.css">
  <link rel="stylesheet" href="assets/css/lightbox.css">

  <style>
    body::before {
      content: "";
      background: url('assets/images/banner-bg.jpg') no-repeat center center/cover;
      position: fixed;
      top: 0;
      left: 0;
      width: 100vw;
      height: 100vh;
      z-index: -1;
      filter: blur(5px);
    }

    .login-section {
      padding: 60px 0;
      background-color: rgba(248, 249, 250, 0.9);
    }

    .login-card {
      background: white;
      border-radius: 10px;
      box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
      overflow: hidden;
    }

    .login-left {
      background-color: #7a0000;
      color: white;
      padding: 30px;
    }

    .login-form {
      padding: 30px;
    }

    .error-message {
      color: red;
      font-size: 0.9em;
    }
  </style>
</head>

<body>

  <!-- Sous-header -->
  <div class="sub-header">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-sm-8">
          <div class="left-content">
            <p>Bienvenue sur le site officiel de <em>l'Université BBM</em>, centre d'excellence pour l'éducation supérieure en RDC.</p>
          </div>
        </div>
        <div class="col-lg-4 col-sm-4">
          <div class="right-icons">
            <ul>
              <li><a href="#"><i class="fa fa-facebook"></i></a></li>
              <li><a href="#"><i class="fa fa-twitter"></i></a></li>
              <li><a href="#"><i class="fa fa-behance"></i></a></li>
              <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Header -->
  <header class="header-area header-sticky">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <nav class="main-nav">
            <a href="index.html" class="logo" style="color: #7a0000;">
              Université BBM
            </a>
            <ul class="nav"></ul>
            <a class='menu-trigger'><span></span></a>
          </nav>
        </div>
      </div>
    </div>
  </header>

  <br>

  <br>

  <br>

  <!-- Section Connexion -->
  <section class="login-section">
    <div class="container">
      <div class="row login-card">
        <!-- Gauche -->
        <div class="col-md-6 login-left">
          <h2>Accédez à votre espace étudiant</h2>
          <p style="color: #f8f9fac4;">
            Connectez-vous avec votre adresse e-mail et le mot de passe utilisé lors de la création du compte.
          </p>
          <p style="color: #f8f9fac4;">
            En cas d’oubli, vous pouvez réinitialiser votre mot de passe ou contacter le support technique.
          </p>
          <p style="color: #f8f9fac4;">
            Vos identifiants sont confidentiels et ne doivent pas être partagés.
          </p>
        </div>

        <!-- Droite -->
        <div class="col-md-6 login-form">
          <?php if (isset($erreur)): ?>
            <div class="alert alert-danger text-center"><?= $erreur ?></div>
          <?php endif; ?>


          <h4><center>Bienvenue</center></h4>
          <form action="#" method="POST">
            <div class="form-group">
              <label for="email">Adresse e-mail</label>
              <input type="email" name="emailAdress" class="form-control" required>
            </div>

          
            <center><button type="submit" class="btn btn-danger" name="valider" style="margin-top:9px;">Se connecter</button></center>          </form>
          
        </div>
      </div>
    </div>
  </section>

</body>
</html>
