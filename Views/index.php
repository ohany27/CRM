<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Tickets</title>
    <!-- Enlaces a Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <?php include("../Config/validarSesion.php"); ?>

    <header class="bg-dark text-white text-center p-3">
        <h1>Bienvenido</h1>
    </header>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Tickets</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Tickets</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Perfil</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container mt-3">
        <section id="tickets" class="mb-4">
            <h2>Tickets</h2>
            <!-- Contenido relacionado con la gestión de tickets -->
        </section>

        <section id="usuarios" class="mb-4">
            <h2>Usuarios</h2>
            <!-- Contenido relacionado con la gestión de usuarios -->
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <!-- Agrega más columnas según tus necesidades -->
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td></td>
                        <td></td>
                        <!-- Agrega más filas según tus usuarios -->
                    </tr>
                </tbody>
            </table>
        </section>
        
        <!-- Puedes agregar más secciones según tus necesidades -->
    </main>

    <footer class="bg-dark text-white text-center p-3">
        <p>&copy; <?php echo date("Y"); ?> crm - Todos los derechos reservados</p>
        <ul class="list-unstyled">
            <li>
                <a class="text-white" href="../Config/validarSesion.php?logout=true">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Salir</span>
                </a>
            </li>
        </ul>
    </footer>

    <!-- Enlaces a Bootstrap JS y scripts JavaScript si los tienes -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
