
<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Contacto - TecniElectrics</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="Assets/img/favicon.png" rel="icon">
  <link href="Assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="Assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="Assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="Assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="Assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="Assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="Assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="Assets/css/about.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Kelly
  * Updated: Jan 29 2024 with Bootstrap v5.3.2
  * Template URL: https://bootstrapmade.com/kelly-free-bootstrap-cv-resume-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top">
    <div class="container-fluid d-flex justify-content-between align-items-center">

      <h1 class="logo me-auto me-lg-0"><a href="index.php">CRM</a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo"><img src="Assets/img/logo.png" alt="" class="img-fluid"></a>-->

      <nav id="navbar" class="navbar order-last order-lg-0">
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="about.php">Acerca de Nosotros</a></li>
          <li><a href="servicio.php">Servicios</a></li>
          <li><a href="contacto.php">Contacto</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

      <div class="header-social-links">
        <a href="https://web.whatsapp.com/" class="whatsapp"><i class="bi bi-whatsapp"></i></a>
        <a href="https://web.facebook.com/?locale=es_LA&_rdc=1&_rdr" class="facebook"><i class="bi bi-facebook"></i></a>
        <a href="https://www.instagram.com/" class="instagram"><i class="bi bi-instagram"></i></a>
      </div>

    </div>

  </header><!-- End Header -->

  <main id="main">

    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Contactanos</h2>
          <p>"¡Estamos aquí para ayudarte! Si tienes alguna pregunta, comentario o inquietud, no dudes en ponerte en contacto con nosotros. Nuestro equipo de atención al cliente está disponible para asistirte en todo lo que necesites."</p>
        </div>

        <div>
          <iframe style="border:0; width: 100%; height: 270px;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d127297.77108249468!2d-75.21495491310671!3d4.400746957067138!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e38daac36ef33ef%3A0xc4167c4b60b14a15!2sSENA%20Centro%20de%20Industria%20y%20de%20la%20Construcci%C3%B3n!5e0!3m2!1ses-419!2sco!4v1707840047126!5m2!1ses-419!2sco" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" frameborder="0" allowfullscreen></iframe>
        </div>

        <div class="row mt-5">

          <div class="col-lg-4">
            <div class="info">
              <div class="address">
                <i class="bi bi-geo-alt"></i>
                <h4>Ubicacion:</h4>
                <p>Mz Casa 14 Barrio La Gaitana</p>
              </div>

              <div class="email">
                <i class="bi bi-envelope"></i>
                <h4>Email:</h4>
                <p>Tecnelectrics@gmail.com</p>
              </div>

              <div class="phone">
                <i class="bi bi-phone"></i>
                <h4>Telefono:</h4>
                <p>+57 320 217 4961</p>
              </div>

            </div>

          </div>

          <div class="col-lg-8 mt-5 mt-lg-0">

            <form action="Config/contacto" method="post" role="form" class="php-email-form">
              <div class="row">
                <div class="col-md-6 form-group">
                  <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Nombre" required>
                </div>
                <div class="col-md-6 form-group mt-3 mt-md-0">
                  <input type="email" class="form-control" name="email" id="email" placeholder=" Email" required>
                </div>
              </div>
              <div class="form-group mt-3">
                <textarea class="form-control" id="editor" name="mensaje" rows="5" placeholder="Mensaje"></textarea>
              </div>
              <div class="text-center"><button type="submit">Enviar Mensaje</button></div>
            </form>

          </div>

        </div>

      </div>
    </section><!-- End Contact Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong><span>TecniElectrics</span></strong>. All Rights Reserved
        <div class="copyright">
          <span><a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Terminos&Condiciones</a></span>
        </div>
      </div>
    </div>
  </footer><!-- End  Footer -->

  <!-- Modal -->
  <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Términos y Condiciones</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Bienvenido al [Tecnelectrics], proporcionado por [Nombre de la Empresa]. Al utilizar nuestro servicio, usted acepta los siguientes términos y condiciones:

          <br><br><strong>Registro y Cuentas de Usuario:</strong> Para utilizar nuestro CRM, puede ser necesario registrarse y crear una cuenta de usuario. Usted es responsable de mantener la confidencialidad de su cuenta y contraseña.

          <br><br><strong>Propiedad Intelectual:</strong> Todos los derechos de propiedad intelectual sobre el CRM [Nombre del CRM] y cualquier contenido generado por los usuarios pertenecen a [Nombre de la Empresa].

          <br><br><strong>Privacidad y Seguridad:</strong> Nos comprometemos a proteger la privacidad y seguridad de sus datos.

          <br><br><strong>Uso Aceptable:</strong> Usted acepta utilizar nuestro CRM de manera ética y legal. Se prohíbe cualquier uso del servicio que sea ilegal o que viole los derechos de terceros.

          <br><br><strong>Responsabilidad:</strong> No somos responsables de ningún daño directo, indirecto, incidental, especial o consecuente que surja del uso de nuestro CRM. Usted utiliza nuestro servicio bajo su propio riesgo.
        </div>
      </div>
    </div>
  </div>

  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="Assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="Assets/vendor/aos/aos.js"></script>
  <script src="Assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="Assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="Assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="Assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="Assets/vendor/waypoints/noframework.waypoints.js"></script>
  <script src="Assets/vendor/php-email-form/validate.js"></script>

  <!-- Vendor JS ckeditor -->
  <script src="Assets/js/ckeditor.js"></script>
  <script src="Assets/js/ckeditor/build/ckeditor.js"></script>

  <script>
    ClassicEditor
      .create(document.querySelector('#editor'))
      .catch(error => {
        console.error(error);
      });
  </script>

  <!-- Template Main JS File -->
  <script src="Assets/js/main.js"></script>

</body>

</html>