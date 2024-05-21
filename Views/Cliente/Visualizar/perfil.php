<?php include "../Template/header.php"; ?>
<?php
require_once("../../../Config/conexion.php");
$conexion = new Database();
$con = $conexion->conectar();

// Fetch current user's data from the session
$usuario = $_SESSION['usuario'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $documento = $usuario['documento'];
    $nombre = $_POST["nombre"];
    $correo = $_POST["correo"];
    $pin = $_POST["pin"];
    $telefono = $_POST["telefono"];
    $direccion = $_POST["direccion"];
    $nueva_contrasena = $_POST["nueva_contrasena"];

    // Ensure required fields are not empty
    if (!empty($nombre) && !empty($correo) && !empty($telefono) && !empty($direccion)) {
        // Update user data
        $actualizar_usuario = "UPDATE usuario SET nombre=?, correo=?, telefono=?, direccion=? WHERE documento=?";
        $stmt = $con->prepare($actualizar_usuario);
        $stmt->execute([$nombre, $correo, $telefono, $direccion, $documento]);

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
            
        }
    } else {
        echo "Error: Todos los campos son obligatorios.";
    }
}
?>
<ul class="nav nav-tabs nav-tabs-custom border-bottom-0 mt-3 nav-justfied" role="tablist">
    <li class="nav-item" role="presentation">
        <a class="nav-link px-4 " href="../index.php">
            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
            <span class="d-none d-sm-block">Mis Tickets</span>
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link px-4" href="../Visualizar/llamadas.php">
            <span class="d-block d-sm-none"><i class="mdi mdi-menu-open"></i></span>
            <span class="d-none d-sm-block">Mis Llamadas </span>
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link px-4" href="../Visualizar/solicitud.php">
            <span class="d-block d-sm-none"><i class="mdi mdi-menu-open"></i></span>
            <span class="d-none d-sm-block">Empieza Una Solicitud </span>
        </a>
    </li>
</ul>
</div>
</div>
</div>
</div>
</div>
<div class="card">
    <div class="tab-content p-4">
        <div class="tab-pane active show" id="projects-tab" role="tabpanel">
            <div class="d-flex align-items-center">
                <div class="flex-1">
                    <h4 class="card-title mb-4">Mi Perfil</h4>
                </div>
            </div>
            <div class="row" id="all-projects"></div>
            <form method="POST">
                <div class="row gx-3 mb-3">
                    <div class="col-md-6">
                        <label class="small mb-1" for="inputUsername">Nombre</label>
                        <input class="form-control" id="inputUsername" type="text" name="nombre" value="<?php echo $usuario['nombre']; ?>" placeholder="Nombre">
                    </div>
                    <div class="col-md-6">
                        <label class="small mb-1" for="inputOrgName">Documento</label>
                        <input class="form-control" id="inputOrgName" type="text" value="<?php echo $usuario['documento']; ?>" readonly>
                    </div>
                </div>
                <div class="row gx-3 mb-3">
                    <div class="col-md-6">
                        <label class="small mb-1" for="inputAddress">Direccion</label>
                        <input class="form-control" id="inputAddress" type="text" name="direccion" value="<?php echo $usuario['direccion']; ?>" placeholder="Direccion">
                    </div>
                    <div class="col-md-6">
                        <label class="small mb-1" for="inputEmail">Correo - Electronico</label>
                        <input class="form-control" id="inputEmail" type="email" name="correo" value="<?php echo $usuario['correo']; ?>" placeholder="@gmail.com">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="small mb-1" for="inputPassword">Contraseña</label>
                    <input class="form-control" id="inputPassword" type="password" name="nueva_contrasena" placeholder="******">
                </div>
                <div class="row gx-3 mb-3">
                    <div class="col-md-6">
                        <label class="small mb-1" for="inputPhone">Telefono</label>
                        <input class="form-control" id="inputPhone" type="tel" name="telefono" value="<?php echo $usuario['telefono']; ?>" placeholder="+57">
                    </div>
                    <div class="col-md-6">
                        <label class="small mb-1" for="inputPin">Pin</label>
                        <input class="form-control" id="inputPin" type="text" name="pin" value="<?php echo $usuario['pin']; ?>" readonly>
                    </div>
                </div>
                <button class="btn btn-primary" type="submit">Actualizar</button>
            </form>
            
            <?php include "../Template/footer.php"; ?>