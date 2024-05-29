<?php
include "../Template/header.php";
require_once("../../../Config/conexion.php");
$conexion = new Database();
$con = $conexion->conectar();

// Fetch current user's data from the session
$usuario = $_SESSION['usuario'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $documento = $usuario['documento'];
    $nombre = $_POST["nombre"];
    $correo = $_POST["correo"];
    $telefono = $_POST["telefono"];
    $direccion = $_POST["direccion"];
    $nueva_contrasena = $_POST["nueva_contrasena"];
    
    // Verify if the selected user role exists in the roles table
    $stmt_rol = $con->prepare("SELECT COUNT(*) FROM roles WHERE id_tip_usu = ?");
    $stmt_rol->execute([$usuario['id_tip_usu']]);
    $rol_exist = $stmt_rol->fetchColumn();

    if ($rol_exist) {
        // Update user data
        $actualizar_usuario = "UPDATE usuario SET nombre=?, correo=?, telefono=?, direccion=? WHERE documento=?";
        $stmt = $con->prepare($actualizar_usuario);
        $stmt->execute([$nombre, $correo, $telefono, $direccion,  $documento]);

        // Update password if provided
        if (!empty($nueva_contrasena)) {
            $hashed_password = password_hash($nueva_contrasena, PASSWORD_DEFAULT);
            $actualizar_contrasena = "UPDATE usuario SET password=? WHERE documento=?";
            $stmt_contrasena = $con->prepare($actualizar_contrasena);
            $stmt_contrasena->execute([$hashed_password, $documento]);
        }

        if ($stmt->rowCount() > 0 || (isset($stmt_contrasena) && $stmt_contrasena->rowCount() > 0)) {
            // Update session data
            $_SESSION['usuario']['nombre'] = $nombre;
            $_SESSION['usuario']['correo'] = $correo;
            $_SESSION['usuario']['telefono'] = $telefono;
            $_SESSION['usuario']['direccion'] = $direccion;
            echo '<script>alert("Actualización exitosa.");</script>';
            echo '<script>window.location="../Visualizar/perfil.php"</script>';
            exit();
        } else {
            echo "Error al actualizar el usuario.";
        }
    } else {
        echo "Error: El rol de usuario seleccionado no existe.";
    }
}
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Perfil Empleado</h1>
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
                                    <label for="documento">Documento</label>
                                    <input type="number" class="form-control" id="documento" name="documento"
                                        placeholder="Documento" value="<?php echo $usuario["documento"]; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $usuario["nombre"]; ?>"
                                        placeholder="Nombre" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="correo">Correo</label>
                                    <input type="email" class="form-control" id="correo" name="correo" value="<?php echo $usuario["correo"]; ?>"
                                        placeholder="Correo-Electronico" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="telefono">Telefono</label>
                                    <input type="number" class="form-control" id="telefono" name="telefono" value="<?php echo $usuario["telefono"]; ?>"
                                        placeholder="Telefono" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="direccion">Direccion</label>
                                    <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo $usuario["direccion"]; ?>"
                                        placeholder="Direccion" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="nueva_contrasena">Nueva Contraseña</label>
                                    <input type="password" class="form-control" id="nueva_contrasena" name="nueva_contrasena"
                                           placeholder="Nueva Contraseña">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Editar</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
<?php include "../Template/footer.php"; ?>
