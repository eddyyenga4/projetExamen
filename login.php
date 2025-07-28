<?php
session_start();
include 'db.php'; // Assure-toi que $conn est bien une connexion mysqli

if (isset($_POST['send'])) {
    extract($_POST); // $email, $password

    $rec = $conn->prepare("SELECT * FROM compte_etudiant WHERE email = ? AND mot_de_passe = ?");
    $rec->bind_param("ss", $email, $password);
    $rec->execute();
    $result = $rec->get_result(); // Nécessaire avec MySQLi
    $cpt = $result->num_rows;

    if ($cpt == 1) {
        $info = $result->fetch_assoc();

        $_SESSION['id'] = $info['id'];
        $_SESSION['email'] = $info['email'];
        $_SESSION['nom'] = $info['nom'];

        header("Location: formulaire.html?id=" . $_SESSION['id']);
        exit;
    } else {
        $erreur = "❌ Email ou mot de passe incorrect.";
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
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
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
              <input type="email" name="email" class="form-control" required>
            </div>

          
            <center><button type="submit" class="btn btn-danger" name="send" style="margin-top:9px;">Se connecter</button></center>          </form>
          
        </div>
      </div>
    </div>
  </section>

</body>
</html>
