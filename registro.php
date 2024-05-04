<?php
session_start();
require_once("Config/conexion.php");

// Crear una instancia de la clase Database para obtener la conexión PDO
$database = new Database();
$pdo = $database->conectar();

// Verificar si se ha hecho clic en el enlace de registro
if (isset($_GET['accion']) && $_GET['accion'] == 'registro') {
    // Consultar cuántas licencias activas hay
    $query = "SELECT COUNT(*) as total FROM licencia WHERE estado = 1";
    $resultado = $pdo->query($query);
    $row = $resultado->fetch(PDO::FETCH_ASSOC);
    $total_licencias_activas = $row['total'];

    // Si hay una o más licencias activas, realizar la acción de registro
    if ($total_licencias_activas < 1) {
        // Si no hay una licencia activa, redirigir al usuario al index.php
        echo '<script>alert("No Hay una licencia Activa Si desea utilizar nuestros servicios contactanos.");</script>';
        echo '<script>window.location = "index.php";</script>';
        exit(); // Detener la ejecución del script // Detener la ejecución del script
    }
  }

// Si llegamos aquí, significa que hay una licencia activa o no se ha intentado registrarse

// Inicializar mensaje de error
$error = '';

// Verificar si se ha enviado el formulario de registro
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $documento = $_POST["documento"];
    $nombre = $_POST["nombre"];
    $correo = $_POST["correo"];
    $password = $_POST["password"];
    $pin = $_POST["pin"];
    $telefono = $_POST["telefono"];
    $direccion = $_POST["direccion"];
    $nitc = $_POST["nitc"];

    // Validar campos obligatorios
    if (empty($documento) || empty($nombre) || empty($correo) || empty($password) || empty($pin) || empty($telefono) || empty($direccion) || empty($nitc)) {
        echo "<script>alert('Todos los campos son obligatorios.')</script>";
    } else {
        // Verificar si ya existe un usuario con el mismo correo, pin o documento
        $query = "SELECT * FROM usuario WHERE correo = :correo OR pin = :pin OR documento = :documento";
        $stmt = $pdo->prepare($query);
        $stmt->execute(array(':correo' => $correo, ':pin' => $pin, ':documento' => $documento));

        // Si se encuentra algún registro, mostrar un mensaje de error
        if ($stmt->rowCount() > 0) {
            echo "<script>alert('Correo existente o pin')</script>";
        } else {
            // Si no hay registros duplicados, insertar el nuevo usuario
            // Encriptar la contraseña antes de insertarla en la base de datos
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $tipo_usuario = 2;

            $query_insert_user = "INSERT INTO usuario (documento, nombre, correo, password, pin, telefono, direccion, nitc, id_tip_usu) 
                                  VALUES (:documento, :nombre, :correo, :password, :pin, :telefono, :direccion, :nitc, :id_tip_usu)";
            $stmt_insert_user = $pdo->prepare($query_insert_user);
            $stmt_insert_user->execute(array(
                ':documento' => $documento,
                ':nombre' => $nombre,
                ':correo' => $correo,
                ':password' => $hashed_password,
                ':pin' => $pin,
                ':telefono' => $telefono,
                ':direccion' => $direccion,
                ':nitc' => $nitc,
                ':id_tip_usu' => $tipo_usuario 
            ));
            // Mostrar alerta de registro exitoso
            echo "<script>alert('Se ha registrado correctamente'); window.location='../crm/Views/Cliente/index.php';</script>";
            exit(); 
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Pages / Register - NiceAdmin Bootstrap Template</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="Admin/assets/img/favicon.png" rel="icon">
  <link href="Admin/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="Admin/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="Admin/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="Admin/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="Admin/assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="Admin/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="Admin/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="Admin/assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="Admin/assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Jan 29 2024 with Bootstrap v5.3.2
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="index.php" class="logo d-flex align-items-center w-auto">
                  <img src="Admin/assets/img/logo.png" alt="">
                  <span class="d-none d-lg-block">crm</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Registrate Gratis</h5>
                    <p class="text-center small">Ingrese sus datos personales para crear una cuenta</p>
                  </div>

                  <form class="needs-validation" method="post" novalidate>
                    <div class="row mb-3">
                      <div class="col-md-6">
                        <label class="form-label" for="documento">Documento</label>
                        <input type="number" id="documento" name="documento" class="form-control" minlength="9" required>
                        <div class="invalid-feedback">Por Favor, ingrese su Documento!</div>
                      </div>
                      <div class="col-md-6">
                        <label class="form-label" for="nombre">Nombre</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" required>
                        <div class="invalid-feedback">Por Favor, ingrese su Nombre!</div>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-md-6">
                        <label class="form-label" for="correo">Correo</label>
                        <input type="email" id="correo" name="correo" class="form-control" required>
                        <div class="invalid-feedback">Por Favor, ingrese su Correo!</div>
                      </div>
                      <div class="col-md-6">
                        <label class="form-label" for="password">Contraseña</label>
                        <input type="password" id="password" name="password" class="form-control" pattern="^(?=.*\d)(?=.*[a-zA-Z]).{5,}$" required>
                        <div class="invalid-feedback">Por Favor, ingrese su Contraseña!</div>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <div class="col-md-6">
                        <label class="form-label" for="pin">Pin</label>
                        <input type="number" id="pin" name="pin" class="form-control" pattern="\d{5,}" required>
                        <div class="invalid-feedback">Por Favor, ingrese su Pin!</div>
                      </div>
                      <div class="col-md-6">
                        <label class="form-label" for="telefono">Telefono</label>
                        <input type="number" id="telefono" name="telefono" class="form-control" required>
                        <div class="invalid-feedback">Por Favor, ingrese su Telefono!</div>
                      </div>
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="direccion">Dirección</label>
                      <input type="text" id="direccion" name="direccion" class="form-control" required>
                      <div class="invalid-feedback">Por Favor, ingrese su Dirección!</div>
                    </div>
                    <div class="mb-3">
                      <label class="form-label" for="nitc">Empresa</label>
                      <select id="nitc" name="nitc" class="form-control" required>
                        <option value="">Seleccione una Empresa</option>
                        <?php
                        // Conectar a la base de datos y obtener las empresas
                        require_once("Config/conexion.php");
                        $database = new Database();
                        $pdo = $database->conectar();
                        $query = "SELECT * FROM empresa";
                        $stmt = $pdo->query($query);
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                          echo "<option value='" . $row['nitc'] . "'>" . $row['nombre'] . "</option>";
                        }
                        ?>
                      </select>
                      <div class="invalid-feedback">Por Favor, seleccione una Empresa!</div>
                    </div>
                    <button class="btn btn-primary w-100" type="submit">Registrarse</button>
                    <div class="text-center mt-3">
                      <p class="small mb-0">Ya tienes una Cuenta? <a href="login.php?accion=registro">Inicia Sesión</a></p>
                    </div>
                  </form>

                </div>
              </div>

              <div class="credits">
                Terminos Y Condiciones</a>
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="Admin/assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="Admin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="Admin/assets/vendor/chart.js/chart.umd.js"></script>
  <script src="Admin/assets/vendor/echarts/echarts.min.js"></script>
  <script src="Admin/assets/vendor/quill/quill.min.js"></script>
  <script src="Admin/assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="Admin/assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="Admin/assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="Admin/assets/js/main.js"></script>

</body>

</html>
