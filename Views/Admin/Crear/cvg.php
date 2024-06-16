<?php include "../Template/header.php"; ?>
<?php
require_once("../../../Config/conexion.php");
$Conexion = new Database;
$con = $Conexion->conectar();

// Asignar objeto PDO a $pdo
$pdo = $con;

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

            while (($datos = fgetcsv($gestor, 1000, ";")) !== FALSE) {
                // Asignar los valores a las variables según la tabla de usuarios
                $documento = !empty($datos[0]) ? trim($datos[0]) : '';
                $nombre = !empty($datos[1]) ? trim($datos[1]) : '';
                $correo = !empty($datos[2]) ? trim($datos[2]) : '';
                $telefono = !empty($datos[3]) ? trim($datos[3]) : '';
                $direccion = !empty($datos[4]) ? trim($datos[4]) : '';

                // Verificar si los datos están vacíos
                if(empty($documento) || empty($nombre) || empty($correo) || empty($telefono) || empty($direccion)) {
                    echo "<script>alert('Los datos del archivo CSV están incompletos: $documento, $nombre, $correo, $telefono, $direccion');</script>";
                    exit();
                }

                // Generar contraseña y pin aleatorios
                $password = generateRandomString();
                $pin = generateRandomPin();

                // Verificar si $_SESSION['usuario']['nitc'] está disponible
                if (!empty($_SESSION['usuario']['nitc'])) {
                    $nitc_usuario = $_SESSION['usuario']['nitc'];

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
                            ':password' => $password,
                            ':pin' => $pin,
                            ':nitc' => $nitc_usuario
                        )
                    );
                } else {
                    // Manejar la falta de valor en $_SESSION['usuario']['nitc'] según tu lógica de negocio
                }

                // Envío de correo electrónico
                $mensaje = "Estimado/a $nombre,\n\nHemos generado una contraseña segura para tu cuenta en CRM. Por favor, utiliza la siguiente contraseña para iniciar sesión:\n\nContraseña: $password\n\n Recuerda que esta es una contraseña temporal y te recomendamos cambiarla tan pronto como inicies sesión. Si tienes alguna pregunta o necesitas ayuda, no dudes en contactarnos.\n\nAtentamente,\nEquipo de Soporte Cloud Chasers";
                $asunto = "Confirmacion Usuario - Cloud Chasers";
                $headers = "From: Soporte Cloud Chasers <soporte@cloudchasers.com>\r\n";

                if (mail($correo, $asunto, $mensaje, $headers)) {
                    echo "<script>alert('Usuario creado y correo enviado con la contraseña generada'); window.location='../Visualizar/usuarios.php';</script>";
                    exit();
                } else {
                    echo "<script>alert('No se logró enviar el mensaje a su destino.'); window.location.href='../Visualizar/usuarios.php';</script>";
                    exit();
                }
            }
            fclose($gestor);
        } else {
            echo "<script>alert('Error al abrir el archivo CSV');</script>";
            echo "<script>window.location='../Visualizar/usuarios.php'</script>";
            exit();
        }
    } else {
        echo "<script>alert('No se Agregó ningún Archivo')</script>";
        echo "<script>window.location='../Visualizar/usuarios.php'</script>";
        exit();
    }
}

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
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"></h3>
                </div>
                <form method="post" enctype="multipart/form-data">
                    <label for="dataCliente">Seleccione un archivo CSV:</label><br>
                    <input type="file" id="dataCliente" name="dataCliente" accept=".csv" required><br><br>
                    <input type="submit" value="Subir Archivo" name="submit">
                </form>
            </div>
        </div>
    </section>
</div>
<?php include "../Template/footer.php"; ?>