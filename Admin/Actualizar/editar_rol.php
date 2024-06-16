<?php
include("../../Config/validarSesion.php");
require_once("../../Config/conexion.php");

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
        header("Location: ../Visualizar/roles.php");
        exit;
    } else {
        echo "Error al actualizar el rol.";
    }
}
?>

<?php include "../Template/header.php"; ?>
<div class="container mt-5">
    <h1 class="text-center">Editar Rol</h1>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="nuevo_rol" class="form-label">Nuevo Rol</label>
            <input type="text" class="form-control" id="nuevo_rol" name="nuevo_estado"
                value="<?php echo $rol['tip_usu']; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </form>
</div>
<?php include "../Template/footer.php"; ?>