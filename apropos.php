<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>À propos - LAU</title>
  <link rel="stylesheet" href="assets/css/fontawesome.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background: linear-gradient(to right, #f2f2f2, #ffffff);
      font-family: 'Segoe UI', sans-serif;
    }

    .header {
      background: linear-gradient(to right, #7a0000, #0059b3);
      color: white;
      padding: 50px 20px;
      text-align: center;
      border-radius: 0 0 25px 25px;
      animation: slideDown 1s ease-in-out;
    }

    @keyframes slideDown {
      from { transform: translateY(-100px); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }

    .vision, .dev-team, .lau-info {
      background-color: #ffffff;
      border-radius: 12px;
      padding: 30px;
      margin: 30px auto;
      max-width: 1000px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
      opacity: 0;
      transform: translateY(30px);
      transition: all 0.6s ease-in-out;
    }

    .show { opacity: 1; transform: translateY(0); }

    .dev-card {
      text-align: center;
      margin-bottom: 30px;
    }

    .dev-card img {
      width: 150px;
      height: 150px;
      border-radius: 50%;
      object-fit: cover;
      box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }

    .dev-card h5 { margin-top: 15px; color: #7a0000; }

    .btn-retour {
      background-color: #7a0000;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 8px;
      margin-top: 20px;
      transition: background 0.3s;
      text-decoration: none;
    }

    .btn-retour:hover {
      background-color: #0059b3;
    }

    .owl-carousel img {
      max-height: 250px;
      object-fit: cover;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
      transition: transform 0.3s ease;
    }

    .owl-carousel img:hover {
      transform: scale(1.05);
    }
  </style>
</head>
<body>

  <div class="header">
    <h1>À propos de notre plateforme</h1>
    <p>Développée dans le cadre de LAU - Leadership Academia University</p>
  </div>

  <section class="vision">
    <h2 class="text-center mb-4">Notre Vision</h2>
    <p class="text-center">Nous croyons en une éducation numérique accessible, intuitive et sécurisée pour tous. Ce projet vise à faciliter la gestion des inscriptions, des étudiants et des opérations administratives d'une université moderne.</p>
  </section>

  <section class="dev-team">
    <h2 class="text-center mb-4">Équipe de développement</h2>
    <div class="row justify-content-center">
      <div class="col-md-4 dev-card">
        <img src="ed.jpg" alt="Développeur 1">
        <h5>YENGA EDDY</h5>
        <p>Chef de projet - Full Stack Developer</p>
      </div>
      <div class="col-md-4 dev-card">
        <img src="bra.png" alt="Développeur 2">
        <h5>bbm-branham</h5>
        <p>UI/UX Designer - Frontend Specialist</p>
      </div>
      <div class="col-md-4 dev-card">
        <img src="eno.jpg" alt="Développeur 3">
        <h5>Enovic officiel</h5>
        <p>Backend Developer - Sécurité & DBA</p>
      </div>
    </div>
  </section>

  <section class="lau-info">
    <h2 class="text-center mb-4">À propos de LAU</h2>
    <p class="text-center">
      Leadership Academia University (LAU) est une institution d'enseignement supérieur visionnaire, engagée à former des leaders compétents dans un monde numérique en constante évolution. Nos valeurs sont l'excellence, l'innovation et la responsabilité sociale.
    </p>
    
    <!-- ✅ Slider LAU Photos -->
    <div class="owl-carousel owl-theme mt-4">
      <div><img src="lau1.jpeg" class="img-fluid" alt="LAU 1"></div>
      <div><img src="lau2.jpeg" class="img-fluid" alt="LAU 2"></div>
      <div><img src="lau3.jpeg" class="img-fluid" alt="LAU 3"></div>
      <div><img src="lua4.jpeg" class="img-fluid" alt="LAU 4"></div>
      <div><img src="lau5.jpeg" class="img-fluid" alt="LAU 5"></div>
      <div><img src="lau6.jpeg" class="img-fluid" alt="LAU 6"></div>
      <div><img src="lau7.jpeg" class="img-fluid" alt="LAU 7"></div>
      <div><img src="lau8.jpeg" class="img-fluid" alt="LAU 8"></div>
      <div><img src="lau9.jpg" class="img-fluid" alt="LAU 9"></div>
      <div><img src="lau10.jpeg" class="img-fluid" alt="LAU 10"></div>
    </div>
  </section>

  <div class="text-center">
    <a href="index.php" class="btn-retour"><i class="fa fa-arrow-left"></i> Retour à l'accueil</a>
  </div>

  <!-- ✅ JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
  <script>
    $('.owl-carousel').owlCarousel({
      loop: true,
      margin: 15,
      autoplay: true,
      autoplayTimeout: 2500,
      autoplayHoverPause: true,
      responsive: {
        0: { items: 1 },
        576: { items: 2 },
        768: { items: 3 },
        992: { items: 4 }
      }
    });

    // Animation de section à l’apparition
    const sections = document.querySelectorAll('.vision, .dev-team, .lau-info');
    const observer = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('show');
        }
      });
    }, { threshold: 0.3 });

    sections.forEach(section => observer.observe(section));
  </script>
</body>
</html>
