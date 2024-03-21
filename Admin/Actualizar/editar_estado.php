<?php
include("../../Config/validarSesion.php");
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
        header("Location: ../Visualizar/estado.php");
        exit;
    } else {
        echo "Error al actualizar el estado.";
    }
}
?>
<?php include "../Template/header.php"; ?>
<div class="container mt-5">
    <h1 class="text-center">Editar Estado</h1>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="nuevo_estado" class="form-label">Nuevo Estado</label>
            <input type="text" class="form-control" id="nuevo_estado" name="nuevo_estado"
                value="<?php echo $estado['tip_est']; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </form>
</div>
<?php include "../Template/footer.php"; ?>