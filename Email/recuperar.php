<?php
require_once ("../Config/conexion.php");

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
    if ($total_licencias_activas >= 1) {

    } else {
        // Si no hay una licencia activa, redirigir al usuario al index.php
        header("Location: ../index.php");
        exit(); // Detener la ejecución del script
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="../Assets/css/ingreso.css">
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
    <title>CRM - RECUPERAR</title>
</head>

<body>

    <div class="container" id="container">

        <div class="form-container sign-in">
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                require_once '../Config/conexion.php';

                $documento = $_POST["documento"];
                $db = new Database();
                $pdo = $db->conectar();

                // Verificar si el documento existe en la base de datos
                $stmt = $pdo->prepare("SELECT * FROM usuario WHERE documento = ?");
                $stmt->execute([$documento]);
                $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($usuario) {
                    // Generar una nueva contraseña aleatoria
                    $nueva_contraseña = bin2hex(random_bytes(8)); // Genera una cadena hexadecimal aleatoria de 16 caracteres
            
                    // Encriptar la nueva contraseña
                    $contraseña_encriptada = password_hash($nueva_contraseña, PASSWORD_DEFAULT);

                    // Actualizar la contraseña en la base de datos
                    $sql = "UPDATE usuario SET password = :password WHERE documento = :documento";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':password', $contraseña_encriptada);
                    $stmt->bindParam(':documento', $documento);
                    $stmt->execute();

                    // Enviar la nueva contraseña por correo electrónico
                    $mensaje = "Estimado/a " . $usuario['nombre'] . ",\n\nHemos generado una nueva contraseña segura para tu cuenta en CRM. Por favor, utiliza la siguiente contraseña para iniciar sesión: \n\nContraseña: $nueva_contraseña\n\nRecuerda que esta es una contraseña temporal y te recomendamos cambiarla tan pronto como inicies sesión. Si tienes alguna pregunta o necesitas ayuda, no dudes en contactarnos.\n\nAtentamente,\nEquipo de Soporte Cloud Chasers";
                    $asunto = "Recuperación de Contraseña - Cloud Chasers";
                    $headers = "From: Soporte Cloud Chasers <soporte@cloudchasers.com>\r\n";
                    mail($usuario['correo'], $asunto, $mensaje, $headers);
                    echo "<script>alert('Se ha enviado una nueva contraseña al correo electrónico asociado al documento proporcionado.'); window.location.href='../login.php?accion=registro';</script>";
                } else {
                    echo "<script>alert('No se encontró ninguna cuenta asociada a este documento.'); window.location.href='../Email/recuperar.php?accion=registro';</script>";
                }
            }
            ?>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <h1>Recuperar</h1>
                <br>
                <!-- Este input oculto se utiliza para distinguir entre los formularios -->
                <input type="hidden" name="login_form" value="1">
                <!-- Campos del formulario de inicio de sesión -->
                <input type="Number" name="documento" id="documento" placeholder="Documento - Cedula" required>
                <a href="../login.php?accion=registro">¿Inicia Sesion?</a>
                <br>
                <button type="submit">validar</button>
                <br>
            </form>
        </div>
        
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-right">
                    <h1>Estamos Para Ayudarte!</h1>
                    <p>"En caso de que hayas olvidado tu contraseña, tenemos un sistema para recuperarla. No olvides actualizar tu contraseña una vez que vuelvas a iniciar sesión."</p>
                </div>
            </div>
        </div>
    </div>

    <script src="../Assets/js/script.js"></script>
</body>

</html>