<?php
session_start();
require_once("Config/conexion.php");

$database = new Database();
$pdo = $database->conectar();

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

        // Verificar si el usuario tiene una licencia activa
        $query_licencia = "SELECT * FROM licencia WHERE nitc = :nitc AND estado = 1";
        $stmt_licencia = $pdo->prepare($query_licencia);
        $stmt_licencia->execute(array(':nitc' => $usuario['nitc']));

        if ($stmt_licencia->rowCount() > 0) {
            if (password_verify($contraseña, $usuario['password'])) {
                $_SESSION['usuario'] = $usuario;

                // Redireccionar según el tipo de usuario
                switch ($usuario['id_tip_usu']) {
                    case 1:
                        header("Location: Views/Admin/index.php");
                        exit();
                    case 2:
                        header("Location: Views/Cliente/index.php");
                        exit();
                    case 3:
                        header("Location: Views/Empleado/index.php");
                        exit();
                    case 4:
                        header("Location: Views/Tecnico/index.php");
                        exit();
                    default:
                        header("Location: index.php?accion=registro");
                        exit();
                }
            } else {
                $_SESSION['error'] = 'Contraseña incorrecta.';
                echo "<script>alert('Contraseña incorrecta.'); window.location.href='login.php?accion=registro';</script>";
                exit();
            }
        } else {
            // Si no tiene una licencia activa, mostrar una alerta
            echo "<script>alert('No existe una licencia activa.'); window.location.href='index.php';</script>";
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
