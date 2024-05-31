<?php
// Establecer la conexión a la base de datos
require_once("../Config/conexion.php");
$DataBase = new Database;
$con = $DataBase->conectar();

// Verificar si la conexión fue exitosa
if ($con) {
    // Consulta SQL para obtener el número de empresas
    $query_empresas = "SELECT COUNT(*) AS num_empresas FROM empresa";

    // Ejecutar la consulta de empresas
    $resultado_empresas = $con->query($query_empresas);

    // Verificar si la consulta de empresas fue exitosa
    if ($resultado_empresas) {
        // Obtener el número de empresas
        $fila_empresas = $resultado_empresas->fetch(PDO::FETCH_ASSOC);
        $num_empresas = $fila_empresas['num_empresas'];
    } else {
        echo "Error en la consulta de empresas: " . $con->errorInfo()[2];
        exit();
    }

    // Consulta SQL para obtener el número de usuarios con id_tip_usu igual a 1
    $query_usuarios = "SELECT COUNT(*) AS num_usuarios FROM usuario WHERE id_tip_usu = 1";

    // Ejecutar la consulta de usuarios
    $resultado_usuarios = $con->query($query_usuarios);

    // Verificar si la consulta de usuarios fue exitosa
    if ($resultado_usuarios) {
        // Obtener el número de usuarios
        $fila_usuarios = $resultado_usuarios->fetch(PDO::FETCH_ASSOC);
        $num_usuarios = $fila_usuarios['num_usuarios'];
    } else {
        echo "Error en la consulta de usuarios: " . $con->errorInfo()[2];
        exit();
    }

    // Consulta SQL para obtener el número de registros en la tabla estado
    $query_estados = "SELECT COUNT(*) AS num_estados FROM estado";

    // Ejecutar la consulta de estados
    $resultado_estados = $con->query($query_estados);

    // Verificar si la consulta de estados fue exitosa
    if ($resultado_estados) {
        // Obtener el número de estados
        $fila_estados = $resultado_estados->fetch(PDO::FETCH_ASSOC);
        $num_estados = $fila_estados['num_estados'];
    } else {
        echo "Error en la consulta de estados: " . $con->errorInfo()[2];
        exit();
    }

    // Consulta SQL para obtener el número de registros en la tabla licencia donde el estado es igual a 1
    $query_licencias = "SELECT COUNT(*) AS num_licencias FROM licencia WHERE estado = 1";

    // Ejecutar la consulta de licencias
    $resultado_licencias = $con->query($query_licencias);

    // Verificar si la consulta de licencias fue exitosa
    if ($resultado_licencias) {
        // Obtener el número de licencias
        $fila_licencias = $resultado_licencias->fetch(PDO::FETCH_ASSOC);
        $num_licencias = $fila_licencias['num_licencias'];
    } else {
        echo "Error en la consulta de licencias: " . $con->errorInfo()[2];
        exit();
    }
} else {
    // Mostrar un mensaje de error si la conexión falla
    echo "Error al conectar a la base de datos.";
}
?>





<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Panel Admin | CRM</title>


  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
  <!-- Favicon -->
  <link rel="apple-touch-icon" sizes="57x57" href="../Assets/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="../Assets/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="../Assets/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="../Assets/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="../Assets/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="../Assets/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="../Assets/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="../Assets/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="../Assets/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="../Assets/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../Assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="../Assets/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../Assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="../Assets/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
  <style>
    .modal-content {
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      text-align: center;
      max-width: 30%;
      /* Cambia el valor según sea necesario */
      margin: 0 auto;
      /* Centra horizontalmente */
      padding: 20px;
      /* Añade algo de espacio alrededor del contenido */
    }
  </style>
</head>
<div class="modal" id="modal">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">Solo Personal autorizado</h5>
    </div>
    <div class="modal-body">
      <input type="password" id="passwordInput" class="form-control" placeholder="Contraseña">
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-primary" onclick="validarCodigo()">Aceptar</button>
    </div>
  </div>
</div>




<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->

        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>


      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="../index.php" class="brand-link">
        <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
          style="opacity: .8">
        <span class="brand-text font-weight-light">CRM</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="info">
            <a href="#" class="d-block">Ceo </a>
          </div>
        </div>


        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
              with font-awesome or any other icon font library -->
            <li class="nav-item menu-open">
              <a href="./index.php" class="nav-link active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Panel
                </p>
              </a>
            </li>
            <li class="nav-header">Usuarios</li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                <p>
                  Administradores
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="Visualizar/usuarios.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Visualizar</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="Crear/usuarios.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Crear</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-user-tag"></i>
                <p>
                  Roles
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="Visualizar/roles.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Visualizar</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="Crear/roles.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Crear</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-header">Clasificacion</li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-clipboard-check"></i>
                <p>
                  Estados
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="Visualizar/estados.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Visualizar</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="Crear/estados.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Crear</p>
                  </a>
                </li>
              </ul>
              </li>
              <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-folder-open"></i>
                <p>
                  Categorias
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="Visualizar/categorias.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Visualizar</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="Crear/categorias.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Crear</p>
                  </a>
                </li>
                
              </ul>
              <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-fire"></i>
                <p>
                  Riesgos
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="Visualizar/riesgos.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Visualizar</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="Crear/riesgos.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Crear</p>
                  </a>
                </li>
              </ul>
            </li>
            </li>
            <li class="nav-header">Empresas</li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fab fa-wpforms"></i>
                <p>
                  Empresas
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="Visualizar/empresa.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Visualizar</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fab fa-soundcloud"></i>
                <p>
                  Licencias
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="Visualizar/licencia.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Visualizar</p>
                  </a>
                </li>
              </ul>
            </li>

            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Panel Ceo </h1>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <!-- Small boxes (Stat box) -->
          <div class="row">
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-info">
                <div class="inner">
                  <h3><?php echo $num_empresas; ?></h3>

                  <p>Empresas</p>
                </div>
                <div class="icon">
                  <i class="fab fa-wpforms"></i>
                </div>

              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-success">
                <div class="inner">
                  <h3><?php echo $num_usuarios; ?></h3>

                  <p>Administradores </p>
                </div>
                <div class="icon">
                  <i class="fas fa-user-lock"></i>
                </div>

              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-warning">
                <div class="inner">
                  <h3><?php echo $num_estados; ?></h3>

                  <p>Estados </p>
                </div>
                <div class="icon">
                  <i class="	fas fa-calendar-check"></i>
                </div>

              </div>
            </div>


            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-danger">
                <div class="inner">
                  <h3><?php echo $num_licencias; ?></h3>

                  <p>Licencias Activas</p>
                </div>
                <div class="icon">
                  <i class="fab fa-soundcloud"></i>
                </div>

              </div>
            </div>
            <!-- ./col -->
          </div>
          <!-- /.row -->
          <!-- Main row -->

          <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
      <strong>Copyright &copy; 2024 <a href="#">CRM</a>.</strong>
      All rights reserved.
      <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.0.0
      </div>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- ChartJS -->
  <script src="plugins/chart.js/Chart.min.js"></script>
  <!-- Sparkline -->
  <script src="plugins/sparklines/sparkline.js"></script>
  <!-- JQVMap -->
  <script src="plugins/jqvmap/jquery.vmap.min.js"></script>
  <script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
  <!-- jQuery Knob Chart -->
  <script src="plugins/jquery-knob/jquery.knob.min.js"></script>
  <!-- daterangepicker -->
  <script src="plugins/moment/moment.min.js"></script>
  <script src="plugins/daterangepicker/daterangepicker.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- Summernote -->
  <script src="plugins/summernote/summernote-bs4.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.js"></script>

  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="dist/js/pages/dashboard.js"></script>
  <script src="build/js/validacion.js"></script>
</body>

</html>