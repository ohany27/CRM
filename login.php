<?php
session_start();
require_once("Config/conexion.php");

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
        exit(); // Detener la ejecución del script
    }
}

// Manejar el formulario de inicio de sesión
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login_form"])) {
    $correo = $_POST["correo"];
    $contraseña = $_POST["contraseña"];

    // Verificar si el correo y la contraseña son válidos
    $query = "SELECT * FROM usuario WHERE correo = :correo";
    $stmt = $pdo->prepare($query);
    $stmt->execute(array(':correo' => $correo));

    if ($stmt->rowCount() == 1) {
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if (password_verify($contraseña, $usuario['password'])) {
            $_SESSION['usuario'] = $usuario;

            if ($usuario['id_tip_usu'] == 1) {
                header("Location: Views/Admin/index.php");
                exit();
            } elseif ($usuario['id_tip_usu'] == 2) {
                header("Location: Views/Cliente/index.php");
                exit();
            } elseif ($usuario['id_tip_usu'] == 3) {
                header("Location: Views/Empleado/index.php");
                exit();
            } elseif ($usuario['id_tip_usu'] == 4) {
                header("Location: Views/Tecnico/index.php");
                exit();
            } else {
                header("Location: index.php?accion=registro");
                exit();
            }
        } else {
            $_SESSION['error'] = 'Contraseña incorrecta.';
            echo "<script>alert('Contraseña incorrecta.'); window.location.href='login.php?accion=registro';</script>";
            exit();
        }
    } else {
        $_SESSION['error'] = 'Usuario no encontrado.';
        echo "<script>alert('Usuario no encontrado.'); window.location.href='login.php?accion=registro';</script>";
        exit();
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="Assets/css/ingreso.css">
    <title>CRM - INICIAR SESION</title>
</head>

<body>

    <div class="container" id="container">
        <div class="form-container sign-up">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <img src="Assets/img/correo.jpg" alt="Correo" width="350" height="350">
            </form>
        </div>

        <div class="form-container sign-in">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <h1>Inicia Sesion</h1>
                <br></br>
                <!-- Este input oculto se utiliza para distinguir entre los formularios -->
                <input type="hidden" name="login_form" value="1">
                <!-- Campos del formulario de inicio de sesión -->
                <input type="email" name="correo" id="correo" placeholder="Correo" required>
                <input type="password" name="contraseña" id="contraseña" placeholder="Contraseña" required>
                <a href="Email/recuperar.php?accion=registro">¿olvidaste tu contraseña?</a>
                <button type="submit">Ingresa</button>
                <br>
                <a href="index.php" style=" color: rgba(0, 0, 0, 0.35);   transform: scale(2); "><i class="fas fa-reply-all"></i></a>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1></h1>
                    <p>"Le recomendamos encarecidamente revisar su bandeja de entrada corporativa, donde encontrará detalles importantes sobre su cuenta temporal, así como las instrucciones precisas para iniciar sesión."</p>
                    <button class="hidden" id="login">Iniciar Sesión</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Hola amig@!</h1>
                    <p>Por favor, inicie sesión para acceder a todas nuestras funciones disponibles y disfrutar de una experiencia completa.</p>
                    <button class="hidden" id="register">No tienes Cuenta</button>
                </div>
            </div>
        </div>
    </div>

    <script src="Assets/js/script.js"></script>
</body>

</html>
