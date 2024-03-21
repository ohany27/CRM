<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Panel Administrativo</title>
    <meta content name="description">
    <meta content name="keywords">

    <!-- Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Favicons -->
    <link href="../assets/img/favicon.png" rel="icon">
    <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="../assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="../assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="../assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="../assets/css/style.css" rel="stylesheet">

    <!--data tables-->
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/2.0.1/css/dataTables.dataTables.min.css">


    <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Jan 29 2024 with Bootstrap v5.3.2
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="../index.php" class="logo d-flex align-items-center">
                <img src="assets/img/logo.png" alt>
                <span class="d-none d-lg-block">CRM</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        <div class="search-bar">
            <form class="search-form d-flex align-items-center" method="POST" action="#">
                <input type="text" name="query" placeholder="Search" title="Enter search keyword">
                <button type="submit" title="Search"><i class="bi bi-search"></i></button>
            </form>
        </div><!-- End Search Bar -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <li class="nav-item d-block d-lg-none">
                    <a class="nav-link nav-icon search-bar-toggle " href="#">
                        <i class="bi bi-search"></i>
                    </a>
                </li><!-- End Search Icon-->

                <li class="nav-item dropdown">

                <li>
                    <a class="dropdown-item d-flex align-items-center"
                        href="../../Config/validarSesion.php?logout=true">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Salir</span>
                    </a>
                </li>

            </ul><!-- End Profile Dropdown Items -->
            </li><!-- End Profile Nav -->

            </ul>
        </nav><!-- End Icons Navigation -->

    </header><!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <a class="nav-link " href="../index.php">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li><!-- End Dashboard Nav -->

            <li class="nav-heading">Julian</li>

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-people"></i><span>Usuarios</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="components-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="../Visualizar/usuarios.php">
                            <i class="bi bi-circle"></i><span>Visualizar</span>
                        </a>
                    </li>
                    <li>
                        <a href="../Crear/usuarios.php">
                            <i class="bi bi-circle"></i><span>Crear</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Usuarios Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#roles-nav" data-bs-toggle="collapse" href="#"
                    onclick="toggleCollapse('#roles-nav')">
                    <i class="bi bi-person-plus"></i></i></i></i><span>Roles</span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="roles-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="../Visualizar/roles.php">
                            <i class="bi bi-circle"></i><span>Visualizar</span>
                        </a>
                    </li>
                    <li>
                        <a href="../Crear/crear_rol.php">
                            <i class="bi bi-circle"></i><span>Crear</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#estados-nav" data-bs-toggle="collapse" href="#"
                    onclick="toggleCollapse('#estados-nav')">
                    <i class="bi bi-check-circle"></i>
                    </i><span>Estados</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="estados-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="../Visualizar/estado.php">
                            <i class="bi bi-circle"></i><span>Visualizar</span>
                        </a>
                    </li>
                    <li>
                        <a href="../Crear/crear_estado.php">
                            <i class="bi bi-circle"></i><span>Crear</span>
                        </a>
                    </li>
                </ul>
            </li>


            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#categories-nav" data-bs-toggle="collapse" href="#"
                    onclick="toggleCollapse('#categories-nav')">
                    <i class="bi bi-list"></i><span>Categorias</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="categories-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="../Visualizar/categoria.php">
                            <i class="bi bi-circle"></i><span>Visualizar</span>
                        </a>
                    </li>
                    <li>
                        <a href="../Crear/crear_categoria.php">
                            <i class="bi bi-circle"></i><span>Crear</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-heading">Yareht</li>

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-currency-dollar"></i></i><span>Precios</span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="../Visualizar/precios.php">
                            <i class="bi bi-circle"></i><span>Visualizar</span>
                        </a>
                    </li>
                    <li>
                        <a href="../Crear/crear_pre.php">
                            <i class="bi bi-circle"></i><span>Crear</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-fire"></i></i><span>Riesgos</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="charts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="../Visualizar/riesgos.php">
                            <i class="bi bi-circle"></i><span>Visualizar</span>
                        </a>
                    </li>
                    <li>
                        <a href="../Crear/crear_riesgo.php">
                            <i class="bi bi-circle"></i><span>Crear</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Charts Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-exclamation-triangle"></i><span>Tipos_Daños</span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="icons-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="../Visualizar/tipo_daño.php">
                            <i class="bi bi-circle"></i><span>Visualizar</span>
                        </a>
                    </li>
                    <li>
                        <a href="../Crear/crear_tip_daño.php">
                            <i class="bi bi-circle"></i><span>Crear</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#details-nav" data-bs-toggle="collapse" href="#"
                    onclick="toggleCollapse('#details-nav')">
                    <i class="bi bi-exclamation-circle"></i></i><span>Detalles_Daños</span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="details-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="../Visualizar/detalle_daño.php">
                            <i class="bi bi-circle"></i><span>Visualizar</span>
                        </a>
                    </li>
                    <li>
                        <a href="../Crear/crear_detalle_daño.php">
                            <i class="bi bi-circle"></i><span>Crear</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-heading">Pages</li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="users-profile.html">
                    <i class="bi bi-person"></i>
                    <span>No-Editado</span>
                </a>
            </li><!-- End Profile Page Nav -->


            <li class="nav-item">
                <a class="nav-link collapsed" href="pages-error-404.html">
                    <i class="bi bi-dash-circle"></i>
                    <span>No-Editado</span>
                </a>
            </li><!-- End Error 404 Page Nav -->

        </ul>

    </aside><!-- End Sidebar-->
    <main id="main" class="main">