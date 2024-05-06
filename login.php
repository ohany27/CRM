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

// Manejar el formulario de registro
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["registro_form"])) {
    // Obtener los datos del formulario
    $documento = $_POST["documento"];
    $nombre = $_POST["nombre"];
    $correo = $_POST["correo"];
    $password = $_POST["password"];
    $pin = $_POST["pin"];
    $telefono = $_POST["telefono"];
    $direccion = $_POST["direccion"];

    // Obtener automáticamente el nitc de la primera empresa de la tabla empresa
    $query_empresa = "SELECT nitc FROM empresa LIMIT 1";
    $stmt_empresa = $pdo->query($query_empresa);
    $empresa_seleccionada = $stmt_empresa->fetch(PDO::FETCH_ASSOC);
    $nitc = $empresa_seleccionada['nitc'];

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
                <h1>Registrate</h1>
                <!-- Este input oculto se utiliza para distinguir entre los formularios -->
                <input type="hidden" name="registro_form" value="1">
                <!-- Campos del formulario de registro -->
                <input type="number" id="documento" name="documento"  minlength="9" required placeholder="Documento">
                <input type="text" id="nombre" name="nombre"  required placeholder="Nombre">
                <input type="email" id="correo" name="correo"  required placeholder="Correo">
                <input type="password" id="password" name="password"  pattern="^(?=.*\d)(?=.*[a-zA-Z]).{5,}$" required placeholder="Contraseña">
                <input type="number" id="pin" name="pin"  pattern="\d{5,}" required placeholder="Pin">
                <input type="number" id="telefono" name="telefono" minlength="9" required placeholder="Telefono">
                <input type="text" id="direccion" name="direccion"  required placeholder="Direccion">
                <button type="submit">Registrarse</button>
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
                    <h1>Ya Tienes Una Cuenta!</h1>
                    <p>Inicia sesion y disfruta de todas nuestra funciones</p>
                    <button class="hidden" id="login">Ingresa</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Hola amig@!</h1>
                    <p>Regístrese con tus datos personales para utilizar todas las funciones del sitio</p>
                    <button class="hidden" id="register">Registrarse</button>
                </div>
            </div>
        </div>
    </div>

    <script src="Assets/js/script.js"></script>
</body>

</html>
