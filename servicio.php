<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Servicios - TECNI-ELECTRIC</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link
    href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
    rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- Animación CSS -->
  <style>
    /* Estilos para la animación al pasar el puntero por encima del icono */
    .iconbox-teal:hover .icon img {
      animation: shake 0.5s;
    }

    @keyframes shake {
      0% {
        transform: translateX(0);
      }

      25% {
        transform: translateX(-5px);
      }

      50% {
        transform: translateX(5px);
      }

      75% {
        transform: translateX(-5px);
      }

      100% {
        transform: translateX(0);
      }
    }
  </style>
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top">
    <div class="container-fluid d-flex justify-content-between align-items-center">

      <h1 class="logo me-auto me-lg-0"><a href="index.php">CRM</a></h1>

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

    <!-- ======= Services Section ======= -->
    <section id="services" class="services">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Servicios</h2>
          <p>Bienvenido a nuestra aplicación de gestión de mantenimiento de equipos informáticos. Somos tu solución
            integral para garantizar que tus dispositivos electrónicos estén siempre en óptimas condiciones. Ofrecemos
            servicios adaptados a tus necesidades, desde resolver problemas técnicos por teléfono hasta coordinar
            visitas de técnicos especializados en caso de necesidad. Además, proporcionamos opciones de mantenimiento
            preventivo para evitar problemas futuros. Con nuestra aplicación, tus equipos recibirán el cuidado y la
            atención que se merecen, brindándote una experiencia sin complicaciones y manteniendo tus dispositivos
            funcionando sin preocupaciones.

          </p>
        </div>

        <div class="row">
          <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
            <div class="icon-box iconbox-blue">
              <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="40" fill="currentColor"
                  class="bi bi-phone-fill" viewBox="0 0 16 16">
                  <path
                    d="M3 2a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2zm6 11a1 1 0 1 0-2 0 1 1 0 0 0 2 0" />
                </svg>
                <img src="assets/img/viber (1).png" alt="Icono de persona caminando" width="40" height="45"
                  fill="currentColor" class="bi bi-telephone" viewBox="0 0 16 16">
              </div>
              <h4><a href="">Soporte técnico por teléfono:</a></h4>
              <p>Proporcionar asistencia inmediata a los usuarios que experimenten problemas con sus equipos
                informáticos a través de llamadas telefónicas, ofreciendo soluciones remotas siempre que sea posible.
              </p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-md-0" data-aos="zoom-in"
            data-aos-delay="200">
            <div class="icon-box iconbox-orange">
              <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="40" fill="currentColor"
                  class="bi bi-person-lines-fill" viewBox="0 0 16 16">
                  <path
                    d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5m.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1z" />
                </svg>
                <img src="assets/img/caminar.png" alt="Icono de persona caminando" width="40" height="45"
                  fill="currentColor" class="bi bi-telephone" viewBox="0 0 16 16">
              </div>
              <h4><a href="">Visitas de técnicos especializados:</a></h4>
              <p>Coordinar la visita de técnicos altamente capacitados y equipados para abordar problemas que no puedan
                resolverse por teléfono, asegurando una atención profesional y eficiente.</p>
            </div>
          </div>


          <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-lg-0" data-aos="zoom-in"
            data-aos-delay="300">
            <div class="icon-box iconbox-pink">
              <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="40" fill="currentColor"
                  class="bi bi-pc-display-horizontal" viewBox="0 0 16 16">
                  <path
                    d="M1.5 0A1.5 1.5 0 0 0 0 1.5v7A1.5 1.5 0 0 0 1.5 10H6v1H1a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1h-5v-1h4.5A1.5 1.5 0 0 0 16 8.5v-7A1.5 1.5 0 0 0 14.5 0zm0 1h13a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-7a.5.5 0 0 1 .5-.5M12 12.5a.5.5 0 1 1 1 0 .5.5 0 0 1-1 0m2 0a.5.5 0 1 1 1 0 .5.5 0 0 1-1 0M1.5 12h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1 0-1M1 14.25a.25.25 0 0 1 .25-.25h5.5a.25.25 0 1 1 0 .5h-5.5a.25.25 0 0 1-.25-.25" />
                </svg>
                <img src="assets/img/dano.png" alt="Icono de persona caminando" width="40" height="45"
                  fill="currentColor" class="bi bi-telephone" viewBox="0 0 16 16">
              </div>
              <h4><a href="">Mantenimiento preventivo programado: </a></h4>
              <p> Permitir a los usuarios programar servicios de mantenimiento periódicos, como actualizaciones de
                software, limpieza de hardware y revisiones de seguridad, para prevenir problemas futuros y garantizar
                el rendimiento óptimo de sus equipos.</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4" data-aos="zoom-in" data-aos-delay="100">
            <div class="icon-box iconbox-yellow">
              <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="40" fill="currentColor"
                  class="bi bi-sd-card-fill" viewBox="0 0 16 16">
                  <path
                    d="M12.5 0H5.914a1.5 1.5 0 0 0-1.06.44L2.439 2.853A1.5 1.5 0 0 0 2 3.914V14.5A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-13A1.5 1.5 0 0 0 12.5 0m-7 2.75a.75.75 0 0 1 .75.75v2a.75.75 0 0 1-1.5 0v-2a.75.75 0 0 1 .75-.75m2 0a.75.75 0 0 1 .75.75v2a.75.75 0 0 1-1.5 0v-2a.75.75 0 0 1 .75-.75m2.75.75v2a.75.75 0 0 1-1.5 0v-2a.75.75 0 0 1 1.5 0m1.25-.75a.75.75 0 0 1 .75.75v2a.75.75 0 0 1-1.5 0v-2a.75.75 0 0 1 .75-.75" />
                </svg>
                <img src="assets/img/web.png" alt="Icono de persona caminando" width="40" height="45"
                  fill="currentColor" class="bi bi-telephone" viewBox="0 0 16 16">
              </div>
              <h4><a href="">Registro de tickets de servicio:</a></h4>
              <p> Proporcionar a los usuarios un número de ticket único para problemas técnicos que requieran atención
                personalizada, facilitando el seguimiento y la gestión eficiente de cada solicitud de servicio.</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4" data-aos="zoom-in" data-aos-delay="200">
            <div class="icon-box iconbox-red">
              <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="40" fill="currentColor"
                  class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                  <path
                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                </svg>
                <img src="assets/img/servicio-al-cliente.png" alt="Icono de persona caminando" width="40" height="45"
                  fill="currentColor" class="bi bi-telephone" viewBox="0 0 16 16">
              </div>
              <h4><a href="">Asesoramiento técnico: </a></h4>
              <p>Ofrecer orientación y recomendaciones a los usuarios sobre el mantenimiento adecuado de sus equipos
                informáticos, así como sobre la optimización de su rendimiento y seguridad.</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4" data-aos="zoom-in" data-aos-delay="300">
            <div class="icon-box iconbox-teal">
              <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="40" fill="currentColor"
                  class="bi bi-person-arms-up" viewBox="0 0 16 16">
                  <path d="M8 3a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3" />
                  <path
                    d="m5.93 6.704-.846 8.451a.768.768 0 0 0 1.523.203l.81-4.865a.59.59 0 0 1 1.165 0l.81 4.865a.768.768 0 0 0 1.523-.203l-.845-8.451A1.5 1.5 0 0 1 10.5 5.5L13 2.284a.796.796 0 0 0-1.239-.998L9.634 3.84a.7.7 0 0 1-.33.235c-.23.074-.665.176-1.304.176-.64 0-1.074-.102-1.305-.176a.7.7 0 0 1-.329-.235L4.239 1.286a.796.796 0 0 0-1.24.998l2.5 3.216c.317.316.475.758.43 1.204Z" />
                </svg>
                <img src="assets/img/actualizar.png" alt="Icono de persona caminando" width="40" height="45"
                  fill="currentColor" class="bi bi-telephone" viewBox="0 0 16 16">
              </div>
              <h4><a href="">Actualizaciones de estado en tiempo real: </a></h4>
              <p> Mantener a los usuarios informados sobre el progreso de sus solicitudes de servicio mediante
                actualizaciones en tiempo real sobre el estado de sus tickets y visitas programadas.</p>
            </div>
          </div>

        </div>

      </div>
    </section><!-- End Services Section -->

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
          Bienvenido al [Tecnelectrics], proporcionado por [Nombre de la Empresa]. Al utilizar nuestro servicio, usted
          acepta los siguientes términos y condiciones:

          <br><br><strong>Registro y Cuentas de Usuario:</strong> Para utilizar nuestro CRM, puede ser necesario
          registrarse y crear una cuenta de usuario. Usted es responsable de mantener la confidencialidad de su cuenta y
          contraseña.

          <br><br><strong>Propiedad Intelectual:</strong> Todos los derechos de propiedad intelectual sobre el CRM
          [Nombre del CRM] y cualquier contenido generado por los usuarios pertenecen a [Nombre de la Empresa].

          <br><br><strong>Privacidad y Seguridad:</strong> Nos comprometemos a proteger la privacidad y seguridad de sus
          datos.

          <br><br><strong>Uso Aceptable:</strong> Usted acepta utilizar nuestro CRM de manera ética y legal. Se prohíbe
          cualquier uso del servicio que sea ilegal o que viole los derechos de terceros.

          <br><br><strong>Responsabilidad:</strong> No somos responsables de ningún daño directo, indirecto, incidental,
          especial o consecuente que surja del uso de nuestro CRM. Usted utiliza nuestro servicio bajo su propio riesgo.
        </div>
      </div>
    </div>
  </div>

  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/waypoints/noframework.waypoints.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>