<?php
require_once __DIR__ . '/../inc/config.php';
require_once __DIR__ . '/../inc/functions.php';
require_once __DIR__ . '/../inc/header.php';
require_once __DIR__ . '/../inc/categories.php';
?>
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Index - Nexa Bootstrap Template</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="Nexa/assets/img/favicon.png" rel="icon">
  <link href="Nexa/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;O8O8O8O8O8O8O8O8O8O8O8O8O8O8O8O8O8O8O8O8&family=Inter:wght@1OOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOODisplay=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="Nexa/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="Nexa/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="Nexa/assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="Nexa/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="Nexa/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="Nexa/assets/css/main.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Nexa
  * Template URL: https://bootstrapmade.com/nexa-bootstrap-agency-template/
  * Updated: Aug 19 2025 with Bootstrap v5.3.7
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section">
      <div class="hero-background">
        <div class="hero-overlay"></div>
      </div>

      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row justify-content-center text-center">
          <div class="col-lg-10">
            <div class="hero-content" data-aos="fade-up" data-aos-delay="200">
              <h1>Help Is Just Around the Corner.</h1>
              <p>KindConnect helps people find support from their own community.
                  Whether you need groceries, repairs, medical assistance, or daily help,
                  nearby volunteers and small business owners can respond quickly.
                </p>

              <div class="hero-btns" data-aos="fade-up" data-aos-delay="300">

              <?php if(($_SESSION['role'] ?? '') !== 'business'): ?>
                <a href="<?= SITE_URL ?>/public/post_problem.php" class="btn btn-primary">Post What You Need</a>
                 
                <?php endif; ?>
                <?php if(($_SESSION['role'] ?? '') !== 'business'): ?>
                <a href="<?= SITE_URL ?>/public/register.php" class="btn btn-outline ">
                  Become a Helper
                </a>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>

        <div class="row justify-content-center">
          <div class="col-lg-8">
            <div class="hero-image-container" data-aos="zoom-in" data-aos-delay="400">
              <div class="hero-image">
                <img src="Nexa/assets/img/about/image1.png" alt="Business Innovation" class="img-fluid">
                <div class="image-decoration"></div>
              </div>
            </div>
          </div>
        </div>

        <div class="row justify-content-center">
          <div class="col-lg-10">
            <div class="hero-stats" data-aos="fade-up" data-aos-delay="500">
              <div class="stat-item">
                <div class="stat-icon">
                  <i class="bi bi-trophy"></i>
                </div>
                <h3><span data-purecounter-start="0" data-purecounter-end="25" data-purecounter-duration="1" class="purecounter"></span>+</h3>
                <p>Services</p>
              </div>
              <div class="stat-item">
                <div class="stat-icon">
                  <i class="bi bi-people"></i>
                </div>
                <h3><span data-purecounter-start="0" data-purecounter-end="850" data-purecounter-duration="1" class="purecounter"></span>+</h3>
                <p>Happy Clients</p>
              </div>
              <div class="stat-item">
                <div class="stat-icon">
                  <i class="bi bi-lightning"></i>
                </div>
                <h3><span data-purecounter-start="0" data-purecounter-end="95" data-purecounter-duration="1" class="purecounter"></span>%</h3>
                <p>Project Success</p>
              </div>
              <div class="stat-item">
                <div class="stat-icon">
                  <i class="bi bi-globe"></i>
                </div>
                <h3><span data-purecounter-start="0" data-purecounter-end="12" data-purecounter-duration="1" class="purecounter"></span>+</h3>
                <p>Countries Served</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section><!-- /Hero Section -->

    <!-- About Section -->
    <section id="about" class="about section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <span class="description-title">About</span>
        <h2>About</h2>
        <p>Helping people in my neighborhood with daily needs and emergencies.</p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gx-0 gx-lg-5 gy-5 align-items-center">
          <div class="col-lg-6" data-aos="zoom-out" data-aos-delay="200">
            <div class="image-wrapper">
              <div class="image-box">
                <img src="Nexa/assets/img/about/help.png" class="img-fluid" alt="About Image" loading="lazy">
              </div>
              <div class="experience-box" data-aos="zoom-in" data-aos-delay="300">
                <div class="years">100+</div>

                <div class="text"><br>Community Helpers</div>
              </div>
            </div>
          </div>

          <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
            <div class="content">
              <div class="section-header">
                <h2>Connecting Communities Through Kindness</h2>
              </div>

              <p class="highlight-text">KindConnect is a community-first platform designed to connect people who need help
                with nearby volunteers and small business owners. Whether it’s groceries, repairs,
                medical needs, or everyday assistance, help is always close to home.
                </p>

              <div class="features-list">
                <div class="feature-item" data-aos="zoom-in" data-aos-delay="300">
                  <div class="icon-box">
                    <i class="bi bi-check2-circle"></i>
                  </div>
                  <div class="text">
                    <h4>Local & Trusted Help</h4>
                    <p>KindConnect connects you with people from your own neighborhood — volunteers
                      and local shop owners who genuinely care and are ready to help.
                      </p>
                  </div>
                </div>

                <div class="feature-item" data-aos="zoom-in" data-aos-delay="400">
                  <div class="icon-box">
                    <i class="bi bi-lightbulb"></i>
                  </div>
                  <div class="text">
                    <h4>Fast Community Response</h4>
                    <p>When you post a request, nearby helpers get notified instantly,
                          allowing quick responses during urgent or everyday situations.
                          </p>
                  </div>
                </div>

                <div class="feature-item" data-aos="zoom-in" data-aos-delay="500">
                  <div class="icon-box">
                    <i class="bi bi-graph-up-arrow"></i>
                  </div>
                  <div class="text">
                    <h4>Empowering Small Businesses & Volunteers</h4>
                    <p>KindConnect supports small shop owners and volunteers by helping them
                    reach nearby people who need their services, strengthening local communities.
                    </p>
                  </div>
                </div>
              </div>

              <div class="cta-buttons">
                <a href="#" class="btn-learn-more">Learn More</a>
                <a href="#" class="btn-get-started">Get Started</a>
              </div>
            </div>
          </div>
        </div>

      </div>

    </section><!-- /About Section -->


</div>
</main>
 <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="Nexa/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="Nexa/assets/vendor/php-email-form/validate.js"></script>
  <script src="Nexa/assets/vendor/aos/aos.js"></script>
  <script src="Nexa/assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="Nexa/assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="Nexa/assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="Nexa/assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="Nexa/assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>

  <!-- Main JS File -->
  <script src="Nexa/assets/js/main.js"></script>

</body>
<?php require_once __DIR__ . '/../inc/footer.php'; ?>
