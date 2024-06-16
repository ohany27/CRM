<?php include "../Template/header.php"; ?>
<?php
require_once("../../Config/conexion.php");

$conexion = new Database();
$con = $conexion->conectar();

// Verificar si se recibió el parámetro 'id' en la URL
if (isset($_GET['id'])) {
    $id_estado = $_GET['id'];

    // Consultar el estado específico por su ID
    $consulta_estado = "SELECT id_est, tip_est FROM estado WHERE id_est = ?";
    $stmt = $con->prepare($consulta_estado);
    $stmt->execute([$id_estado]);

    // Verificar si la consulta fue exitosa
    if ($stmt->rowCount() > 0) {
        $estado = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        echo "No se encontró el estado con ID: $id_estado";
        exit;
    }
} else {
    echo "ID de estado no proporcionado";
    exit;
}

// Verificar si se envió el formulario de edición
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Procesar el formulario de edición y actualizar el estado en la base de datos
    $nuevo_estado = $_POST['nuevo_estado'];

    $actualizar_estado = "UPDATE estado SET tip_est = ? WHERE id_est = ?";
    $stmt = $con->prepare($actualizar_estado);
    $stmt->execute([$nuevo_estado, $id_estado]);

    if ($stmt->rowCount() > 0) {
        // Redirigir a la página de lista de estados después de la edición exitosa
        echo '<script>alert ("Actualización exitosa.");</script>';
            echo '<script>window.location="../Visualizar/estados.php"</script>';
            exit();
    } else {
        echo "Error al actualizar el estado.";
    }
}
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Editar Un Estado</h1>
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
                                    <input type="text" class="form-control" id="nuevo_estado" name="nuevo_estado" value="<?php echo $estado['tip_est']; ?>"
                                        placeholder="Nombre" required>
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
            this.setCustomValidity('El nombre debe contener minimo 3 letras, no se permite signos de puntuacion.');
        }
    });
</script>
<?php include "../Template/footer.php"; ?>