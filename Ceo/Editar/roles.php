<?php include "../Template/header.php"; ?>
<?php
require_once ("../../Config/conexion.php");
$conexion = new Database();
$con = $conexion->conectar();

// Verificar si se recibió el parámetro 'id' en la URL
if (isset($_GET['id'])) {
    $id_rol = $_GET['id'];

    // Consultar el rol específico por su ID
    $consulta_rol = "SELECT id_tip_usu, tip_usu FROM roles WHERE id_tip_usu = ?";
    $stmt = $con->prepare($consulta_rol);
    $stmt->execute([$id_rol]);

    // Verificar si la consulta fue exitosa
    if ($stmt->rowCount() > 0) {
        $rol = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        echo "No se encontró el rol con ID: $id_rol";
        exit;
    }
} else {
    echo "ID de rol no proporcionado";
    exit;
}

// Verificar si se envió el formulario de edición
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Procesar el formulario de edición y actualizar el rol en la base de datos
    $nuevo_rol = $_POST['nuevo_estado'];

    $actualizar_rol = "UPDATE roles SET tip_usu = ? WHERE id_tip_usu = ?";
    $stmt = $con->prepare($actualizar_rol);
    $stmt->execute([$nuevo_rol, $id_rol]);

    if ($stmt->rowCount() > 0) {
        // Redirigir a la página de lista de roles después de la edición exitosa
        echo '<script>alert ("Actualización exitosa.");</script>';
        echo '<script>window.location="../Visualizar/roles.php"</script>';
        exit();
    } else {
        echo "Error al actualizar el rol.";
    }
}
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Editar Un Rol</h1>
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
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="">Nombre</label>
                                    <input type="text" class="form-control" id="nuevo_rol" name="nuevo_estado"
                                        value="<?php echo $rol['tip_usu']; ?>" placeholder="Nombre" required>
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
    document.querySelector('input[name="nuevo_estado"]').addEventListener('input', function () {
        var nombreValue = this.value;
        
        // Verificar si el nombre solo contiene letras y permite la letra "ñ"
        if (/^[A-Za-zñÑ\s]{3,}$/.test(nombreValue) && !/[.]/.test(nombreValue)) {
            this.setCustomValidity('');
        } else {
            this.setCustomValidity('El rol debe contener mínimo 3 letras y no se permiten signos de puntuación.');
        }
    });
</script>
<?php include "../Template/footer.php"; ?>