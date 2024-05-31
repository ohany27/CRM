<?php
include "../Template/header.php";
require_once ("../../Config/conexion.php");

$Conexion = new Database;
$con = $Conexion->conectar();
$pdo = $con;

$id_tip_usu = 1; // Valor predeterminado para id_tip_usu

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $documento = $_POST["documento"];
    $nombre = $_POST["nombre"];
    $correo = $_POST["correo"];
    $telefono = $_POST["telefono"];
    $direccion = $_POST["direccion"];
    $nitc = $_POST["nitc"];
    // No es necesario recuperar $_POST["id_tip_usu"] porque ya está definido como 1

    // Verificar si ya existe un administrador para la empresa
    if ($id_tip_usu == 1) {
        $query_verificar_admin = "SELECT * FROM usuario WHERE id_tip_usu = 1 AND nitc = :nitc";
        $stmt_verificar_admin = $pdo->prepare($query_verificar_admin);
        $stmt_verificar_admin->execute(array(':nitc' => $nitc));
        $existe_admin = $stmt_verificar_admin->fetch();

        if ($existe_admin) {
            echo "<script>alert('Ya existe un administrador para esta empresa.');window.location='../Visualizar/usuarios.php';</script>";
            exit();
        }
    }

    // Verificar si el documento, correo o teléfono ya existen en la base de datos
    $query_verificar = "SELECT * FROM usuario WHERE documento = :documento OR correo = :correo OR telefono = :telefono";
    $stmt_verificar = $pdo->prepare($query_verificar);
    $stmt_verificar->execute(array(':documento' => $documento, ':correo' => $correo, ':telefono' => $telefono));
    $existe_registro = $stmt_verificar->fetch();

    if ($existe_registro) {
        echo "<script>alert('Ya existe un usuario con el mismo documento, correo o teléfono.')</script>";
    } else {
        // Generar contraseña y PIN aleatorio
        $password = generarContraseñaAleatoria();
        $pin = generarPinAleatorio();
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insertar el nuevo usuario en la base de datos
        $query_insert_user = "INSERT INTO usuario (documento, nombre, correo, password, pin, telefono, direccion, nitc, id_tip_usu, id_estado) 
                                VALUES (:documento, :nombre, :correo, :password, :pin, :telefono, :direccion, :nitc, :id_tip_usu, 1)";
        $stmt_insert_user = $pdo->prepare($query_insert_user);
        $stmt_insert_user->execute(
            array(
                ':documento' => $documento,
                ':nombre' => $nombre,
                ':correo' => $correo,
                ':password' => $hashed_password,
                ':pin' => $pin,
                ':telefono' => $telefono,
                ':direccion' => $direccion,
                ':nitc' => $nitc,
                ':id_tip_usu' => $id_tip_usu
            )
        );

        // Enviar correo de confirmación
        $mensaje = "Estimado/a $nombre,\n\nHemos generado una contraseña segura para tu cuenta en CRM. Por favor, utiliza la siguiente contraseña para iniciar sesión:\n\nContraseña: $password\n\n Recuerda que esta es una contraseña temporal y te recomendamos cambiarla tan pronto como inicies sesión. Si tienes alguna pregunta o necesitas ayuda, no dudes en contactarnos.\n\nAtentamente,\nEquipo de Soporte Cloud Chasers";
        $asunto = "Confirmacion Usuario - Cloud Chasers";
        $headers = "From: Soporte Cloud Chasers <soporte@cloudchasers.com>\r\n";

        if (mail($correo, $asunto, $mensaje, $headers)) {
            echo "<script>alert('Administrador creado'); window.location='../Visualizar/usuarios.php';</script>";
        } else {
            echo "<script>alert('No se logró enviar el mensaje a su destino.'); window.location.href='../Visualizar/usuarios.php';</script>";
        }
    }
}

function generarContraseñaAleatoria($longitud = 10)
{
    $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $contraseña = '';
    for ($i = 0; $i < $longitud; $i++) {
        $contraseña .= $caracteres[rand(0, strlen($caracteres) - 1)];
    }
    return $contraseña;
}

function generarPinAleatorio($longitud = 4)
{
    $pin = '';
    for ($i = 0; $longitud > $i; $i++) {
        $pin .= rand(0, 9);
    }
    return $pin;
}
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Crea Un Usuario</h1>
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
                <!-- /.card-header -->
                <!-- form start -->
                <form method="post">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Documento</label>
                                    <input type="number" class="form-control" id="documento" name="documento"
                                        placeholder="Documento" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre"
                                        placeholder="Nombre" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Correo</label>
                                    <input type="email" class="form-control" id="correo" name="correo"
                                        placeholder="Correo-Electronico" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Telefono</label>
                                    <input type="number" class="form-control" id="telefono" name="telefono"
                                        placeholder="Telefono" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Direccion</label>
                                    <input type="text" class="form-control" id="direccion" name="direccion"
                                        placeholder="Direccion" required>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="nitc">Empresas</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <select id="nitc" class="form-control" name="nitc" required>
                                                <option value="">Seleccione_Empresa</option>
                                                <?php
                                                // Consulta SQL para obtener las empresas que tengan un estado = 1 en la tabla licencia
                                                $query_empresas = "SELECT empresa.nitc, empresa.nombre 
                                                    FROM empresa 
                                                    INNER JOIN licencia ON empresa.nitc = licencia.nitc 
                                                    WHERE licencia.estado = 1";
                                                // Ejecutar la consulta
                                                $stmt_empresas = $con->query($query_empresas);
                                                // Iterar sobre los resultados y generar las opciones del menú desplegable
                                                while ($row_empresas = $stmt_empresas->fetch(PDO::FETCH_ASSOC)) {
                                                    echo "<option value='" . $row_empresas['nitc'] . "'>" . $row_empresas['nombre'] . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Crear</button>
                        </div>
                </form>
            </div>
        </div>
    </section>
</div>
<script>
    document.getElementById('documento').addEventListener('input', function () {
        var documentoValue = this.value;

        // Verificar si el documento tiene entre 7 y 11 números
        if (/^\d{7,11}$/.test(documentoValue)) {
            this.setCustomValidity('');
        } else {
            this.setCustomValidity('El documento debe tener entre 7 y 11 números.');
        }
    });

    document.getElementById('nombre').addEventListener('input', function () {
        var nombreValue = this.value;

        // Verificar si el nombre tiene al menos 3 letras y no contiene puntos
        if (/^[A-Za-zñÑ\s]{3,}$/.test(nombreValue) && !/[.]/.test(nombreValue)) {
            this.setCustomValidity('');
        } else {
            this.setCustomValidity('El nombre debe contener al menos 3 letras y no se permiten signos de puntuación.');
        }
    });

    document.getElementById('telefono').addEventListener('input', function () {
        var telefonoValue = this.value;

        // Verificar si el teléfono tiene 10 números
        if (/^\d{10}$/.test(telefonoValue)) {
            this.setCustomValidity('');
        } else {
            this.setCustomValidity('El teléfono debe tener 10 números.');
        }
    });
</script>

<?php include "../Template/footer.php"; ?>
