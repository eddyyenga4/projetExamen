<?php
include 'db.php';
$success= "";

if (isset($_POST["envoyer"])) {
  $nom = $_POST['nom'];
  $email = $_POST['email'];
  $sujet = $_POST['sujet'];
  $message = $_POST['message'];


    $stmt = $conn->prepare("INSERT INTO messages_contact(nom, email, sujet, message) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$nom, $email, $sujet, $message])) {
      $success = "✅ Votre message a été envoyé avec succès.";
    } else {
      $error = "❌ Une erreur s'est produite lors de l'envoi du message.";
    }
  
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Contact - Mon Site</title>
  <link rel="stylesheet" href="assets/css/fontawesome.css" />
  <link rel="stylesheet" href="assets/css/owl.css" />
  <link rel="stylesheet" href="assets/css/lightbox.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

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
      filter: blur(4px) brightness(0.7);
    }

    .contact-section {
      background-color: rgba(255, 255, 255, 0.85);
      padding: 60px 30px;
      border-radius: 12px;
      box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
      max-width: 700px;
      margin: 40px auto;
    }

    .page-header {
      background: linear-gradient(to right, #7a0000, #0059b3);
      color: white;
      padding: 40px 20px;
      border-radius: 10px;
      margin-bottom: 40px;
      text-align: center;
      max-width: 700px;
      margin-left: auto;
      margin-right: auto;
    }

    .form-label {
      font-weight: 600;
      color: #7a0000;
    }

    .btn-danger {
      background-color: #7a0000;
      border-color: #7a0000;
    }

    .btn-danger:hover {
      background-color: #5a0000;
      border-color: #5a0000;
    }

    .btn-secondary {
      background-color: #0059b3;
      border-color: #0059b3;
      color: white;
    }

    .btn-secondary:hover {
      background-color: #004080;
      border-color: #004080;
      color: white;
    }

    /* Container du bouton retour */
    .back-btn-container {
      max-width: 700px;
      margin: 30px auto 10px auto;
      padding-left: 30px;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .contact-section,
      .page-header,
      .back-btn-container {
        padding: 30px 20px;
        max-width: 90vw;
        margin-left: auto;
        margin-right: auto;
      }
    }
  </style>
</head>

<body>

  <div class="back-btn-container" style="margin-top: 20px;">
  <button class="btn btn-secondary" onclick="window.location.href='index.php'">← Retour</button>
</div>


  <div class="page-header">
    <h2>Contactez-nous</h2>
    <p>Nous sommes à votre écoute. Envoyez-nous un message via ce formulaire.</p>
  </div>

  <div class="contact-section">
    <?php if ($success): ?>
      <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>

    <form id="contactForm" method="POST" novalidate>
      <div class="mb-3">
        <label for="nom" class="form-label">Nom complet</label>
        <input type="text" class="form-control" id="nom" name="nom" placeholder="Votre nom complet" required />
        <div class="invalid-feedback">Veuillez entrer votre nom complet.</div>
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">Adresse Email</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="exemple@domaine.com" required />
        <div class="invalid-feedback">Veuillez entrer une adresse email valide.</div>
      </div>

      <div class="mb-3">
        <label for="sujet" class="form-label">Sujet</label>
        <input type="text" class="form-control" id="sujet" name="sujet" placeholder="Sujet de votre message" required />
        <div class="invalid-feedback">Veuillez préciser le sujet.</div>
      </div>

      <div class="mb-3">
        <label for="message" class="form-label">Message</label>
        <textarea class="form-control" id="message" name="message" rows="5" placeholder="Votre message ici..." required></textarea>
        <div class="invalid-feedback">Le message ne peut pas être vide.</div>
      </div>

      <div class="text-end">
        <button type="submit" name="envoyer" class="btn btn-danger">Envoyer</button>
      </div>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    (() => {
      'use strict';
      const form = document.getElementById('contactForm');
      form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    })();
  </script>
</body>
</html>
