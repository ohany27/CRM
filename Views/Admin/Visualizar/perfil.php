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
            echo '<script>window.location="../Visualizar/usuarios.php"</script>';
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
                    <h1 class="m-0">Perfil Admin</h1>
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
                                    <input type="password" class="form-control" id="nueva_contrasena" name="nueva_contrasena"placeholder="Nueva Contraseña">
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
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Guardar los valores originales
        var originalNombre = "<?php echo $usuario['nombre']; ?>";
        var originalCorreo = "<?php echo $usuario['correo']; ?>";
        var originalTelefono = "<?php echo $usuario['telefono']; ?>";
        var originalDireccion = "<?php echo $usuario['direccion']; ?>";

        var nombreInput = document.getElementById("nombre");
        var telefonoInput = document.getElementById("telefono");

        nombreInput.addEventListener("input", function() {
            var nombreRegex = /^[a-zA-Z\s]{3,}$/;
            if (!nombreRegex.test(nombreInput.value)) {
                nombreInput.setCustomValidity("El nombre debe tener al menos 3 letras y no debe contener signos.");
            } else {
                nombreInput.setCustomValidity("");
            }
        });

        telefonoInput.addEventListener("input", function() {
            var telefonoRegex = /^\d{10}$/;
            if (!telefonoRegex.test(telefonoInput.value)) {
                telefonoInput.setCustomValidity("El teléfono debe tener exactamente 10 números.");
            } else {
                telefonoInput.setCustomValidity("");
            }
        });

        document.getElementById('direccion').addEventListener('input', function () {
            var direccionValue = this.value;

            // Verificar si la dirección tiene al menos 3 caracteres (letras o números)
            if (/^[A-Za-z0-9ñÑáéíóúÁÉÍÓÚ\s]{3,}$/.test(direccionValue)) {
                this.setCustomValidity('');
            } else {
                this.setCustomValidity('La dirección debe contener al menos 3 caracteres (letras o números).');
            }
        });

        var contrasenaInput = document.getElementById('nueva_contrasena');
        contrasenaInput.addEventListener('input', function() {
            var contrasenaValue = contrasenaInput.value;
            var letraCount = (contrasenaValue.match(/[a-zA-Z]/g) || []).length;
            var numeroCount = (contrasenaValue.match(/[0-9]/g) || []).length;
            
            if (letraCount < 3 || numeroCount < 2) {
                contrasenaInput.setCustomValidity('La contraseña debe tener al menos 3 letras y 2 números.');
            } else {
                contrasenaInput.setCustomValidity('');
            }
        });

        // Función para validar el formulario y verificar cambios
        window.validateForm = function() {
            // Obtener valores actuales
            var currentNombre = document.getElementById("nombre").value;
            var currentCorreo = document.getElementById("correo").value;
            var currentTelefono = document.getElementById("telefono").value;
            var currentDireccion = document.getElementById("direccion").value;

            // Verificar si hay cambios
            if (
                originalNombre === currentNombre &&
                originalCorreo === currentCorreo &&
                originalTelefono === currentTelefono &&
                originalDireccion === currentDireccion &&
                !document.getElementById("nueva_contrasena").value // Verifica que no se haya ingresado una nueva contraseña
            ) {
                alert("Realiza algún cambio para editar.");
                return false; // Evita el envío del formulario
            }
            return true; // Permite el envío del formulario
        };
    });
</script>
<?php include "../Template/footer.php"; ?>
