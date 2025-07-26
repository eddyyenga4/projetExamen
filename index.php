<?php

if (isset($_POST["envoyer"])) {
//bonjours le branham
}

include 'db.php';

if (isset($_POST["envoyer"])) {
  $nom = $_POST['nom'];
  $email = $_POST['email'];
  $sujet = $_POST['sujet'];
  $message = $_POST['message'];


    $stmt = $conn->prepare("INSERT INTO messages_contact(nom, email, sujet, message) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$nom, $email, $sujet, $message])) {
      $success = "✅ Votre message a été envoyé avec succès.";
      header("location:index.php");
    } else {
      $error = "❌ Une erreur s'est produite lors de l'envoi du message.";
    }
  
}






?>



<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="TemplateMo">
  <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900" rel="stylesheet">

  <title>Université BBM - Accueil</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- FontAwesome pour icônes -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

  <!-- Additional CSS Files -->
  <link rel="stylesheet" href="assets/css/fontawesome.css">
  <link rel="stylesheet" href="assets/css/templatemo-edu-meeting.css">
  <link rel="stylesheet" href="assets/css/owl.css">
  <link rel="stylesheet" href="assets/css/lightbox.css">

  <style>
    /* Texte blanc dans la barre de droite */
    .right-icons ul {
      list-style: none;
      padding-left: 0;
      margin: 0;
      display: flex;
      gap: 15px;
      justify-content: flex-end;
      font-weight: 600;
    }

    .right-icons ul li a {
      color: white !important;
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 5px;
      font-size: 0.9rem;
    }

    .right-icons ul li a:hover {
      text-decoration: underline;
    }

    /* Dropdown déconnexion */
    .right-icons ul li.dropdown {
      position: relative;
    }

    .right-icons ul li.dropdown > a {
      cursor: pointer;
      color: white !important;
      display: flex;
      align-items: center;
      gap: 5px;
      font-weight: 600;
    }

    .right-icons ul li.dropdown > a:hover {
      text-decoration: underline;
    }

    /* Contenu du dropdown */
    .right-icons ul li.dropdown .dropdown-content {
      display: none;
      position: absolute;
      right: 0;
      background-color: #222;
      min-width: 220px;
      border-radius: 6px;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
      padding: 10px;
      z-index: 9999;
    }

    /* Afficher au survol */
    .right-icons ul li.dropdown:hover .dropdown-content {
      display: block;
    }

    /* Partie profil dans dropdown */
    .dropdown-content .profile-info {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 10px;
      border-bottom: 1px solid #444;
      padding-bottom: 10px;
    }

    .dropdown-content .profile-info img {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      object-fit: cover;
    }

    .dropdown-content .profile-info span {
      color: white;
      font-weight: 700;
      white-space: nowrap;
    }

    /* Lien déconnexion */
    .dropdown-content a {
      color: white !important;
      font-weight: 600;
      padding: 8px 5px;
      display: block;
      border-radius: 4px;
      text-decoration: none;
    }

    .dropdown-content a:hover {
      background-color: #444;
      color: #ffcc00 !important;
    }
  </style>

</head>

<body>

  <!-- Sub Header -->
  <div class="sub-header">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-sm-8">
          <div class="left-content">
            <p>Bienvenue sur le site officiel de <em>l'Université BBM </em>, centre d'excellence pour l'éducation supérieure en RDC.</p>
          </div>
        </div>
        <div class="col-lg-4 col-sm-4">
          <div class="right-icons">
            <ul>
  <li>
    <a href="apropos.php">
     À propos  <i class="fas fa-info-circle"></i> 
    </a>
  </li>
</ul>

          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ***** Header Area Start ***** -->
  <header class="header-area header-sticky">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <nav class="main-nav">
            <!-- ***** Logo Start ***** -->
            <a href="index.html" class="logo">
              Université
            </a>
            <!-- ***** Logo End ***** -->
            <!-- ***** Menu Start ***** -->

            <ul class="nav">
              <li class="scroll-to-section"><a href="#top" class="active">Accueil</a></li>
              <li><a href="login.php">Faire une pré-inscription</a></li>

              <li><a href="statut.html">Vérifier mon statut</a></li>
              <li><a href="reçu.html">Télécharger mon reçu</a></li>
              <li><a href="contact.php">Contact</a></li>
            </ul>
            <a class='menu-trigger'>
              <span>Menu</span>
            </a>
            <!-- ***** Menu End ***** -->
          </nav>
        </div>
      </div>
    </div>
  </header>
  <!-- ***** Header Area End ***** -->

  <!-- ***** Main Banner Area Start ***** -->
  <section class="section main-banner" id="top" data-section="section1">
    <video autoplay muted loop id="bg-video">
      <source src="assets/images/course-video.mp4" type="video/mp4" />
    </video>

    <div class="video-overlay header-text">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="caption">
              <h6>L'excellence</h6>

              <div class="main-button-red">
                <a href="login.php">Commencer votre inscription</a>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- ***** Main Banner Area End ***** -->

  <section class="services" id="avantages">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="owl-service-item owl-carousel">

            <div class="item">
              <div class="icon">
                <img src="assets/images/service-icon-01.png" alt="Formation de qualité">
              </div>
              <div class="down-content">
                <h4>Formation de qualité</h4>
                <p>Des programmes académiques actualisés, encadrés par des professionnels et adaptés aux besoins du marché.</p>
              </div>
            </div>

            <div class="item">
              <div class="icon">
                <img src="assets/images/service-icon-02.png" alt="Enseignants expérimentés">
              </div>
              <div class="down-content">
                <h4>Enseignants expérimentés</h4>
                <p>Un corps enseignant composé de docteurs, chercheurs et professionnels passionnés par la transmission du savoir.</p>
              </div>
            </div>

            <div class="item">
              <div class="icon">
                <img src="assets/images/service-icon-03.png" alt="Cadre moderne">
              </div>
              <div class="down-content">
                <h4>Cadre moderne</h4>
                <p>Un environnement propice à l’apprentissage : salles équipées, bibliothèque numérique et connexion Internet.</p>
              </div>
            </div>

            <div class="item">
              <div class="icon">
                <img src="assets/images/service-icon-02.png" alt="Séminaires et conférences">
              </div>
              <div class="down-content">
                <h4>Séminaires & Conférences</h4>
                <p>Des rencontres régulières avec des experts pour approfondir vos connaissances et élargir votre réseau.</p>
              </div>
            </div>

            <div class="item">
              <div class="icon">
                <img src="assets/images/service-icon-03.png" alt="Insertion professionnelle">
              </div>
              <div class="down-content">
                <h4>Insertion professionnelle</h4>
                <p>Des partenariats avec les entreprises pour faciliter vos stages, projets pratiques et débouchés professionnels.</p>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="upcoming-meetings" id="meetings">
    <div class="container">

    </div>
  </section>

  <section class="apply-now" id="apply">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 align-self-center">
          <div class="row">
            <div class="col-lg-12">
              <div class="item">
                <h3>Préinscription au programme de Licence</h3>
                <p>Remplissez le formulaire en ligne pour soumettre votre demande d’admission en première année de licence.</p>
                <div class="main-button-red">
                  <div class="scroll-to-section"><a href="#">Remplir le formulaire</a></div>
                </div>
              </div>
            </div>
            <div class="col-lg-12">
              <div class="item">
                <h3>Vous avez des questions ?</h3>
                <p>Contactez notre service des admissions pour toute information complémentaire ou assistance.</p>
                <div class="main-button-yellow">
                  <div class="scroll-to-section"><a href="#contact">Nous contacter</a></div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6 align-self-center">
          <div class="video">
            <a href="https://www.youtube.com/watch?v=HndV87XpkWg" target="_blank"><img src="assets/images/play-icon.png" alt=""></a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="our-courses" id="courses">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="section-heading">
            <h2>Nos formations populaires</h2>
          </div>
        </div>
        <div class="col-lg-12">
          <div class="owl-courses-item owl-carousel">

            <div class="item">
              <img src="assets/images/course-01.jpg" alt="Licence en Informatique">
              <div class="down-content">
                <h4>Licence en Informatique de Gestion</h4>
                <div class="info">
                  <div class="row">
                    <div class="col-8">
                      <ul>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                      </ul>
                    </div>
                    <div class="col-4">
                      <span>700 $</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="item">
              <img src="assets/images/course-02.jpg" alt="Licence en Droit">
              <div class="down-content">
                <h4>Licence en Droit Privé et Public</h4>
                <div class="info">
                  <div class="row">
                    <div class="col-8">
                      <ul>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                      </ul>
                    </div>
                    <div class="col-4">
                      <span>680 $</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="item">
              <img src="assets/images/course-03.jpg" alt="Sciences économiques">
              <div class="down-content">
                <h4>Licence en Sciences Économiques</h4>
                <div class="info">
                  <div class="row">
                    <div class="col-8">
                      <ul>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                      </ul>
                    </div>
                    <div class="col-4">
                      <span>720 $</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="item">
              <img src="assets/images/course-04.jpg" alt="Gestion">
              <div class="down-content">
                <h4>Licence en Gestion des Entreprises</h4>
                <div class="info">
                  <div class="row">
                    <div class="col-8">
                      <ul>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                        <li><i class="fa fa-star"></i></li>
                      </ul>
                    </div>
                    <div class="col-4">
                      <span>750 $</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Tu peux continuer avec d'autres filières ici -->

          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="our-facts" id="chiffres">
    <div class="container">
      <div class="row">
        <div class="col-lg-6">
          <div class="row">
            <div class="col-lg-12">
              <h2>Quelques chiffres sur notre université</h2>
            </div>
            <div class="col-lg-6">
              <div class="row">
                <div class="col-12">
                  <div class="count-area-content percentage">
                    <div class="count-digit">94</div>
                    <div class="count-title">Étudiants diplômés</div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="count-area-content">
                    <div class="count-digit">126</div>
                    <div class="count-title">Enseignants actifs</div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="row">
                <div class="col-12">
                  <div class="count-area-content new-students">
                    <div class="count-digit">2345</div>
                    <div class="count-title">Nouveaux inscrits</div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="count-area-content">
                    <div class="count-digit">32</div>
                    <div class="count-title">Distinctions obtenues</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6 align-self-center">
          <div class="video">
            <a href="https://www.youtube.com/watch?v=HndV87XpkWg" target="_blank">
              <img src="assets/images/play-icon.png" alt="Vidéo de présentation">
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="contact-us" id="contact">
    <div class="container">
      <div class="row">
        <section class="contact-us" id="contact">
          <div class="container">
            <div class="row">
              <div class="col-lg-9 align-self-center">
                <form id="contact" action="#" method="post">
                  <div class="row">
                    <div class="col-lg-12">
                      <h2>Contactez-nous</h2>
                    </div>
                    <div class="col-lg-4">
                      <input name="nom" type="text" id="name" placeholder="Votre nom" required>
                    </div>
                    <div class="col-lg-4">
                      <input name="email" type="email" id="email" placeholder="Votre email" required>
                    </div>
                    <div class="col-lg-4">
                      <input name="sujet" type="text" id="subject" placeholder="Objet" required>
                    </div>
                    <div class="col-lg-12">
                      <textarea name="message" id="message" placeholder="Votre message..." required></textarea>
                    </div>
                    <div class="col-lg-12">
                      <button type="submit" class="button" name="envoyer">Envoyer le message</button>
                    </div>
                  </div>
                </form>
              </div>
              <div class="col-lg-3">
                <div class="right-info">
                  <ul>
                    <li>
                      <h6>Téléphone</h6>

                      <span><a href="tel:+243816853198" style="color:inherit; text-decoration:none;">243 816 853 198</a></span>
                    </li>
                    <li>

                      <h6><a href="mailto:bundya005@gmail.com" style="color:inherit; text-decoration:none;">Email</a></h6>
                      <span></span>
                    </li>
                    <li>
                      <h6>Adresse</h6>
                      <span>Avenue Université, Kinshasa, RDC</span>
                    </li>
                    <li>
                      <h6>
                        <a href="http://www.bbm-branham.wegic.app" style="color:inherit; text-decoration:none;">Site Web</a></h6>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="footer">
            <p>
              &copy; 2025 Université BBM. Tous droits réservés.
            </p>
          </div>
  </section>

  <!-- Scripts -->
  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

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
