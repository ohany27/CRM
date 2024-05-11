<?php
include "../Template/header.php";
require_once("../../Config/conexion.php");

$Conexion = new Database;
$con = $Conexion->conectar();
$pdo = $con;

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $documento = $_POST["documento"];
    $nombre = $_POST["nombre"];
    $correo = $_POST["correo"];
    $telefono = $_POST["telefono"];
    $direccion = $_POST["direccion"];
    $nitc = $_POST["nitc"];
    $id_tip_usu = $_POST["id_tip_usu"];

    if (empty($documento) || empty($nombre) || empty($correo) || empty($telefono) || empty($direccion) || empty($nitc) || empty($id_tip_usu)) {
        echo "<script>alert('Todos los campos son obligatorios.')</script>";
    } else {
        $password = generarContraseñaAleatoria();
        $pin = generarPinAleatorio();
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

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

function generarContraseñaAleatoria($longitud = 10) {
    $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $contraseña = '';
    for ($i = 0; $i < $longitud; $i++) {
        $contraseña .= $caracteres[rand(0, strlen($caracteres) - 1)];
    }
    return $contraseña;
}

function generarPinAleatorio($longitud = 4) {
    $pin = '';
    for ($i = 0; $i < $longitud; $i++) {
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
                                        placeholder="Documento" minlength="9" required>
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
                                    <input type="text" class="form-control" id="correo" name="correo"
                                        placeholder="Correo-Electronico" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Telefono</label>
                                    <input type="number" class="form-control" id="telefono" name="telefono"
                                        placeholder="Telefono" pattern="\d{9,}" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Direccion</label>
                                    <input type="text" class="form-control" id="direccion" name="direccion"
                                        placeholder="Direccion" required>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="nitc">
                                        <label for="">Empresas</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <label for="nitc">
                                                    <select id="nitc" class="form-control" name="nitc"
                                                        placeholder="Nitc:" required>
                                                        <option value="">Seleccione_Empresa</option>
                                                        <?php
                                                        // Obtener las empresas
                                                        $query_empresas = "SELECT * FROM empresa";
                                                        $stmt_empresas = $con->query($query_empresas);
                                                        while ($row_empresas = $stmt_empresas->fetch(PDO::FETCH_ASSOC)) {
                                                            echo "<option value='" . $row_empresas['nitc'] . "'>" . $row_empresas['nombre'] . "</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </label>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="nitc">
                                        <label for="">Rol</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <label for="id_tip_usu">
                                                    <select class="form-control"  id="id_tip_usu" name="id_tip_usu" placeholder="rol:"
                                                        required>
                                                        <option value="">Seleccione_Rol</option>
                                                        <?php
                                                        // Obtener los roles
                                                        $query_roles = "SELECT * FROM roles";
                                                        $stmt_roles = $con->query($query_roles);
                                                        while ($row_roles = $stmt_roles->fetch(PDO::FETCH_ASSOC)) {
                                                            echo "<option value='" . $row_roles['id_tip_usu'] . "'>" . $row_roles['tip_usu'] . "</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </label>
                                            </div>
                                        </div>
                                    </label>
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
<?php include "../Template/footer.php"; ?>