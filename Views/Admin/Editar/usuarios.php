<?php include "../Template/header.php"; ?>
<?php
require_once ("../../../Config/conexion.php");
$conexion = new Database();
$con = $conexion->conectar();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $documento = $_POST["documento"];
    $nombre = $_POST["nombre"];
    $correo = $_POST["correo"];
    $pin = $_POST["pin"];
    $telefono = $_POST["telefono"];
    $direccion = $_POST["direccion"];
    $password = $_POST["password"]; // No necesitas verificar si está seteado aquí
    $id_rol = $_POST["id_tip_usu"];

    // Verificar si el rol de usuario seleccionado existe en la tabla roles
    $stmt_rol = $con->prepare("SELECT COUNT(*) FROM roles WHERE id_tip_usu = ?");
    $stmt_rol->execute([$id_rol]);
    $rol_exist = $stmt_rol->fetchColumn();

    if ($rol_exist) {
        if (!empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $actualizar_usuario = "UPDATE usuario SET nombre=?, correo=?, pin=?, telefono=?, direccion=?, id_tip_usu=?, password=? WHERE documento=?";
            $stmt = $con->prepare($actualizar_usuario);
            $stmt->execute([$nombre, $correo, $pin, $telefono, $direccion, $id_rol, $hashed_password, $documento]);
        } else {
            // Si no se proporciona una nueva contraseña, no la actualices
            $actualizar_usuario = "UPDATE usuario SET nombre=?, correo=?, pin=?, telefono=?, direccion=?, id_tip_usu=? WHERE documento=?";
            $stmt = $con->prepare($actualizar_usuario);
            $stmt->execute([$nombre, $correo, $pin, $telefono, $direccion, $id_rol, $documento]);
        }

        if ($stmt->rowCount() > 0) {
            echo '<script>alert ("Actualización exitosa.");</script>';
            echo '<script>window.location="../Visualizar/usuarios.php"</script>';
            exit();
        } else {
            echo "Error al actualizar el usuario.";
        }
    } else {
        echo "Error: El rol de usuario seleccionado no existe.";
    }
} else {
    $documento = isset($_GET["id"]) ? $_GET["id"] : die("ID de usuario no proporcionado");

    $consulta_usuario = "SELECT * FROM usuario WHERE documento=?";
    $stmt_usuario = $con->prepare($consulta_usuario);
    $stmt_usuario->execute([$documento]);
    $usuario = $stmt_usuario->fetch();
}
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Editar Usuario</h1>
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
                                        placeholder="Documento" minlength="9" value="<?php echo $usuario["documento"]; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $usuario["nombre"]; ?>"
                                        placeholder="Nombre" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Correo</label>
                                    <input type="text" class="form-control" id="correo" name="correo" value="<?php echo $usuario["correo"]; ?>"
                                        placeholder="Correo-Electronico" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Contraseña</label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Password" pattern="^(?=.*\d)(?=.*[a-zA-Z]).{5,}$" >
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Pin</label>
                                    <input type="number" class="form-control" id="pin" name="pin" placeholder="Pin" value="<?php echo $usuario["pin"]; ?>"
                                        pattern="\d{5,}" readonly>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Telefono</label>
                                    <input type="number" class="form-control" id="telefono" name="telefono" value="<?php echo $usuario["telefono"]; ?>"
                                        placeholder="Telefono" pattern="\d{9,}" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Direccion</label>
                                    <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo $usuario["direccion"]; ?>"
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
                            $selected_empresa = ($row_empresas['nitc'] == $usuario['nitc']) ? 'selected' : '';
                            echo "<option value='" . $row_empresas['nitc'] . "' $selected_empresa>" . $row_empresas['nombre'] . "</option>";
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
                        $query_roles = "SELECT * FROM roles";
                        $stmt_roles = $con->query($query_roles);
                        while ($row_roles = $stmt_roles->fetch(PDO::FETCH_ASSOC)) {
                            $selected = ($row_roles['id_tip_usu'] == $usuario['id_tip_usu']) ? 'selected' : '';
                            echo "<option value='" . $row_roles['id_tip_usu'] . "' $selected>"
                                . $row_roles['tip_usu'] . "</option>";
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
                            <button type="submit" class="btn btn-primary">Editar</button>
                        </div>
                </form>

            </div>
        </div>
    </section>
</div>
<?php include "../Template/footer.php"; ?>
