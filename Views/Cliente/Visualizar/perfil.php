<?php include "../Template/header.php"; ?>
<?php
require_once("../../../Config/conexion.php");
$conexion = new Database();
$con = $conexion->conectar();

// Obtener el documento del usuario para cargar sus datos
$documento_usuario = "DocumentoPorDefecto"; // Asigna un valor por defecto si no se ha proporcionado

if (isset($_GET["documento"])) {
    $documento_usuario = $_GET["documento"];
    
    // Consulta para obtener los datos del usuario
    $sql_select = "SELECT * FROM usuario WHERE documento = ?";
    
    if ($stmt = $con->prepare($sql_select)) {
        $stmt->bind_param("s", $documento_usuario);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $nombre_usuario = $row["nombre"];
                $correo_usuario = $row["correo"];
                $password_usuario = $row["password"];
                $telefono_usuario = $row["telefono"];
                $direccion_usuario = $row["direccion"];
            } else {
                echo "No se encontró ningún usuario con el documento proporcionado.";
                exit();
            }
        } else {
            echo "Error al ejecutar la consulta: " . $stmt->error;
            exit();
        }
        $stmt->close();
    } else {
        echo "Error de preparación de la consulta: " . $con->error;
        exit();
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
            <form>

                <div class="mb-3">
                    <label class="small mb-1" for="inputUsername">Nombre</label>
                    <input class="form-control" id="inputUsername" type="text" placeholder="Nombre">
                </div>

                <div class="row gx-3 mb-3">

                    <div class="col-md-6">
                        <label class="small mb-1" for="inputOrgName">Documento</label>
                        <input class="form-control" id="inputOrgName" type="text" placeholder="" readonly>
                    </div>

                    <div class="col-md-6">
                        <label class="small mb-1" for="inputLocation">Correo - Electronico</label>
                        <input class="form-control" id="inputLocation" type="text" placeholder="@gmail.com">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="small mb-1" for="inputEmailAddress">Contraseña</label>
                    <input class="form-control" id="inputEmailAddress" type="email" placeholder="******">
                </div>

                <div class="row gx-3 mb-3">

                    <div class="col-md-6">
                        <label class="small mb-1" for="inputPhone">Telefono</label>
                        <input class="form-control" id="inputPhone" type="tel" placeholder="+57">
                    </div>

                    <div class="col-md-6">
                        <label class="small mb-1" for="inputBirthday">Pin</label>
                        <input class="form-control" id="inputBirthday" type="text" name="birthday" placeholder=""
                            readonly>
                    </div>
                </div>

                <button class="btn btn-primary" type="button">Actualizar</button>
            </form>
            <?php include "../Template/footer.php"; ?>