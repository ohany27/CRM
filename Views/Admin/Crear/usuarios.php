<?php include "../Template/header.php"; ?>
<?php
require_once ("../../../Config/conexion.php");
$Conexion = new Database;
$con = $Conexion->conectar();

// Assign PDO object to $pdo
$pdo = $con;

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
    $id_tip_usu = $_POST["id_tip_usu"];

    // Validar campos obligatorios
    if (empty($documento) || empty($nombre) || empty($correo) || empty($password) || empty($pin) || empty($telefono) || empty($direccion) || empty($nitc) || empty($id_tip_usu)) {
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

            $query_insert_user = "INSERT INTO usuario (documento, nombre, correo, password, pin, telefono, direccion, nitc, id_tip_usu) 
                                VALUES (:documento, :nombre, :correo, :password, :pin, :telefono, :direccion, :nitc, :id_tip_usu)";
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

            // Mostrar alerta de registro exitoso
            echo "<script>alert('Usuario creado'); window.location='../Visualizar/usuarios.php';</script>";
            exit();
        }
    }
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
                                    <label for="">Contraseña</label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Password" pattern="^(?=.*\d)(?=.*[a-zA-Z]).{5,}$" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Pin</label>
                                    <input type="number" class="form-control" id="pin" name="pin" placeholder="Pin"
                                        pattern="\d{5,}" required>
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
                                                        <?php
                                                        // Obtener el NITC de la empresa asociada al usuario en sesión
                                                        $nitc_usuario = $_SESSION['usuario']['nitc'];

                                                        // Obtener la información de la empresa asociada al usuario en sesión
                                                        $query_empresa_usuario = "SELECT * FROM empresa WHERE nitc = :nitc_usuario";
                                                        $stmt_empresa_usuario = $pdo->prepare($query_empresa_usuario);
                                                        $stmt_empresa_usuario->execute(array(':nitc_usuario' => $nitc_usuario));
                                                        $row_empresa_usuario = $stmt_empresa_usuario->fetch(PDO::FETCH_ASSOC);

                                                        // Verificar si se encontró la empresa asociada al usuario en sesión
                                                        if ($row_empresa_usuario) {
                                                            // Mostrar la opción de la empresa asociada al usuario en sesión
                                                            echo "<option value='" . $row_empresa_usuario['nitc'] . "' selected>" . $row_empresa_usuario['nombre'] . "</option>";
                                                        } else {
                                                            // Si no se encuentra la empresa asociada al usuario en sesión, mostrar un mensaje de error
                                                            echo "<option value='' disabled>No se encontró la empresa asociada al usuario en sesión</option>";
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
                                                    <select class="form-control" id="id_tip_usu" name="id_tip_usu"
                                                        placeholder="rol:" required>
                                                        <option value="">Seleccione_Rol</option>
                                                        <?php
                                                        // Obtener los roles
                                                        $query_roles = "SELECT * FROM roles WHERE id_tip_usu > 1";
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