<?php
// Incluir archivos necesarios
include "../Template/header.php";
require_once ("../../../Config/conexion.php");

// Función para generar una cadena aleatoria para la contraseña
function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

// Función para generar un PIN aleatorio
function generateRandomPin($length = 5)
{
    $pin = '';
    for ($i = 0; $i < $length; $i++) {
        $pin .= mt_rand(0, 9);
    }
    return $pin;
}

// Verificar si se ha enviado el formulario de carga de archivo
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_FILES['dataCliente']['name'])) {
        $archivo = $_FILES['dataCliente']['tmp_name'];

        // Verificar si es un archivo CSV válido
        if ($_FILES['dataCliente']['type'] != 'text/csv') {
            echo "<script>alert('Seleccione un archivo CSV')</script>";
            echo "<script>window.location='../Visualizar/usuarios.php'</script>";
            exit();
        }

        // Abrir archivo CSV
        if (($gestor = fopen($archivo, "r")) !== FALSE) {
            // Saltar la primera línea (encabezados)
            fgetcsv($gestor);

            $errores = [];

            while (($datos = fgetcsv($gestor, 1000, ";")) !== FALSE) {
                // Asignar los valores a las variables según la tabla de usuarios
                $documento = !empty($datos[0]) ? trim($datos[0]) : '';
                $nombre = !empty($datos[1]) ? trim($datos[1]) : '';
                $correo = !empty($datos[2]) ? trim($datos[2]) : '';
                $telefono = !empty($datos[3]) ? trim($datos[3]) : '';
                $direccion = !empty($datos[4]) ? trim($datos[4]) : '';

                // Verificar si los datos están vacíos
                if (empty($documento) || empty($nombre) || empty($correo) || empty($telefono) || empty($direccion)) {
                    $errores[] = "Los datos del archivo CSV están incompletos: $documento, $nombre, $correo, $telefono, $direccion";
                    continue; // Saltar al siguiente registro si faltan datos
                }

                // Verificar si ya existe un usuario con el mismo correo o documento
                $Conexion = new Database;
                $con = $Conexion->conectar();
                $pdo = $con;

                $query_check_existing = "SELECT COUNT(*) AS count_correo FROM usuario WHERE correo = :correo";
                $stmt_check_correo = $pdo->prepare($query_check_existing);
                $stmt_check_correo->execute([':correo' => $correo]);
                $result_correo = $stmt_check_correo->fetch(PDO::FETCH_ASSOC);

                $query_check_existing = "SELECT COUNT(*) AS count_documento FROM usuario WHERE documento = :documento";
                $stmt_check_documento = $pdo->prepare($query_check_existing);
                $stmt_check_documento->execute([':documento' => $documento]);
                $result_documento = $stmt_check_documento->fetch(PDO::FETCH_ASSOC);

                // Verificar si ya existe un usuario con el mismo correo o documento
                if ($result_correo['count_correo'] > 0) {
                    $errores[] = "Ya existe un usuario registrado con el correo electrónico: $correo";
                    continue; // Saltar al siguiente registro si ya existe correo
                }

                if ($result_documento['count_documento'] > 0) {
                    $errores[] = "Ya existe un usuario registrado con el número de documento: $documento";
                    continue; // Saltar al siguiente registro si ya existe documento
                }

                // Generar contraseña aleatoria
                $password = generateRandomString();
                $pin = generateRandomPin();

                // Encriptar la contraseña
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Insertar nuevo usuario
                $query_insert_user = "INSERT INTO usuario (documento, nombre, correo, telefono, direccion, password, pin, nitc, id_tip_usu, id_estado) 
                                    VALUES (:documento, :nombre, :correo, :telefono, :direccion, :password, :pin, :nitc, 2, 1)";
                $stmt_insert_user = $pdo->prepare($query_insert_user);
                $stmt_insert_user->execute(
                    array(
                        ':documento' => $documento,
                        ':nombre' => $nombre,
                        ':correo' => $correo,
                        ':telefono' => $telefono,
                        ':direccion' => $direccion,
                        ':password' => $hashed_password, // Almacenar la contraseña encriptada
                        ':pin' => $pin,
                        ':nitc' => $_SESSION['usuario']['nitc'] // Asumiendo que esto está correctamente configurado
                    )
                );

                // Envío de correo electrónico
                $mensaje = "Estimado/a $nombre,\n\nHemos generado una contraseña segura para tu cuenta en CRM. Por favor, utiliza la siguiente contraseña para iniciar sesión:\n\nContraseña: $password\n\nRecuerda que esta es una contraseña temporal y te recomendamos cambiarla tan pronto como inicies sesión. Si tienes alguna pregunta o necesitas ayuda, no dudes en contactarnos.\n\nAtentamente,\nEquipo de Soporte Cloud Chasers";
                $asunto = "Confirmacion Usuario - Cloud Chasers";
                $headers = "From: Soporte Cloud Chasers <soporte@cloudchasers.com>\r\n";

                if (mail($correo, $asunto, $mensaje, $headers)) {
                    echo "<script>alert('Usuario creado y correo enviado con la contraseña generada');</script>";
                } else {
                    echo "<script>alert('No se logró enviar el mensaje a su destino.');</script>";
                }
            }
            fclose($gestor);

            // Mostrar errores si los hubiera
            if (!empty($errores)) {
                foreach ($errores as $error) {
                    echo "<script>alert('$error');</script>";
                }
            }
        } else {
            echo "<script>alert('Error al abrir el archivo CSV');</script>";
        }
    } else {
        echo "<script>alert('No se Agregó ningún Archivo');</script>";
    }
}
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Sube los Datos de tus clientes</h1>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"></h3>
                        </div>
                        <div class="card-body">
                            <form method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="dataCliente">Seleccione un archivo CSV:</label>
                                    <input type="file" class="form-control-file" id="dataCliente" name="dataCliente"
                                        accept=".csv" required>
                                </div>
                                <button type="submit" class="btn btn-primary" name="submit">Subir Archivo</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Descargar Estructura del Archivo CSV</h3>
                        </div>
                        <div class="card-body">
                            <p>Descargue un ejemplo de archivo CSV con la estructura requerida.</p>
                            <a href="Guia.csv" download="Guia.csv" class="btn btn-primary">Descargar Ejemplo CSV</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php include "../Template/footer.php"; ?>