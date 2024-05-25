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
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="../plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="../plugins/summernote/summernote-bs4.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<!-- Favicon -->
<link rel="apple-touch-icon" sizes="57x57" href="../../Assets/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="../../Assets/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="../../Assets/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="../../Assets/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="../../Assets/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="../../Assets/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="../../Assets/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="../../Assets/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="../../Assets/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="../../Assets/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../../Assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="../../Assets/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../../Assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="../Assets/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="../dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
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
        <!-- Notifications Dropdown Menu -->

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
      <a href="../../index.php" class="brand-link">
        <img src="../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
          style="opacity: .8">
        <span class="brand-text font-weight-light">CRM</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="info">
            <a href="#" class="d-block">Ceo</a>
          </div>
        </div>

        <!-- SidebarSearch Form -->


        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
              with font-awesome or any other icon font library -->
            <li class="nav-item menu-open">
              <a href="../index.php" class="nav-link ">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Panel
                </p>
              </a>
            </li>
            <li class="nav-header">Usuarios</li>
            <li class="nav-item">
              <a href="#" class="nav-link ">
                <i class="nav-icon fas fa-users"></i>
                <p>
                  Administradores
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="../Visualizar/usuarios.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Visualizar</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="../Crear/usuarios.php" class="nav-link">
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
                  <a href="../Visualizar/roles.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Visualizar</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="../Crear/roles.php" class="nav-link">
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
                  <a href="../Visualizar/estados.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Visualizar</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="../Crear/estados.php" class="nav-link">
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
                  <a href="../Visualizar/categorias.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Visualizar</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="../Crear/categorias.php" class="nav-link">
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
                  <a href="../Visualizar/riesgos.php" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Visualizar</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="../Crear/riesgos.php" class="nav-link">
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
                  <a href="../Visualizar/empresa.php" class="nav-link">
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
                  <a href="../Visualizar/licencia.php" class="nav-link">
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