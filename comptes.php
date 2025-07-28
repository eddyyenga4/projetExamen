<?php

include("db.php");
if (isset($_POST['valider'])) {
    extract($_POST);
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password1 = $_POST['confirm_password'];

    if ($password1 === $password) {
        
        $inser = $conn->prepare("INSERT INTO compte_etudiant(nom_complet, email, mot_de_passe) VALUES (?, ?, ?)");

        $result = $inser->execute(array($nom, $email,   $password));

        if ($result) {
            echo '<div class="alert alert-success text-center">✅ Compte créé avec succès !</div>';
        } else {
            echo '<div class="alert alert-danger text-center">❌ Une erreur est survenue lors de l\'enregistrement.</div>';
        }
    } else {
        echo '<div class="alert alert-danger text-center">⚠️ Les mots de passe ne correspondent pas.</div>';
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
  <title>Créer un compte - Université BBM</title>

  <!-- Bootstrap & CSS -->
  <link href="vendors/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/fontawesome.css">
  <link rel="stylesheet" href="assets/css/templatemo-edu-meeting.css">
  <link rel="stylesheet" href="assets/css/owl.css">
  <link rel="stylesheet" href="assets/css/lightbox.css">
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>

  <style>
    body::before {
      content: "";
      background: url('assets/images/banner-bg.jpg') no-repeat center center/cover;
      position: fixed;
      top: 0; left: 0;
      width: 100vw;
      height: 100vh;
      z-index: -1;
      filter: blur(5px);
    }

    .register-section {
      padding: 60px 0;
      background-color: rgba(248, 249, 250, 0.9);
    }

    .register-card {
      background: white;
      border-radius: 10px;
      box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
      overflow: hidden;
    }

    .register-left {
      background-color: #7a0000;
      color: white;
      padding: 30px;
    }

    .register-form {
      padding: 30px;
    }

    .error-message {
      color: red;
      font-size: 0.9em;
      display: none;
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

  <!-- Section inscription -->
  <section class="register-section">
    <div class="container">
      <div class="row register-card">
        <!-- Gauche -->
        <div class="col-md-6 register-left">
          <h2>Bienvenue sur l’espace d’inscription</h2>
          <p style="color: #f8f9fac4;">
            Merci de créer un compte pour commencer votre préinscription à l’Université BBM.
          </p>
          <p style="color: #f8f9fac4;">
            Une fois le compte créé, vous recevrez un lien d’accès à votre espace étudiant où vous pourrez compléter les étapes de votre inscription.
          </p>
          <p style="color: #f8f9fac4;">
            <strong>Protection de vos données :</strong> Vos informations personnelles sont traitées avec la plus grande confidentialité. Elles sont exclusivement utilisées dans le cadre de votre processus d’admission et ne seront jamais partagées sans votre consentement.
          </p>
          <p style="color: #f8f9fac4;">
            L’Université BBM applique une politique de sécurité stricte : tous les mots de passe sont chiffrés, et nos systèmes sont régulièrement mis à jour pour garantir la protection de vos données contre tout accès non autorisé.
          </p>
        </div>

        <!-- Droite -->
        <div class="col-md-6 register-form">
          <h4>Créer un compte</h4>
          <form method="POST" >
            <div class="form-group">
              <label for="nom">Nom complet</label>
              <input type="text" name="nom" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="email">Adresse e-mail</label>
              <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="password">Mot de passe</label>
              <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="confirm_password">Retaper le mot de passe</label>
              <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
              <span id="error-message" class="error-message">⚠️ Les mots de passe ne correspondent pas.</span>
            </div>
            <br>

            <br>
            <center><button type="submit" class="btn btn-danger" name="valider">Créer mon compte</button></center>
          </form>
        </div>
      </div>
    </div>
  </section>

  <!-- Script JS de vérification -->
  <script>
    function verifierMotDePasse() {
      var pass = document.getElementById("password").value;
      var confirm = document.getElementById("confirm_password").value;
      var message = document.getElementById("error-message");

      if (pass !== confirm) {
        message.style.display = "block";
        return false;
      } else {
        message.style.display = "none";
        return true;
      }
    }
  </script>
</body>
</html>
