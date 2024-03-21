<?php
include("../../Config/validarSesion.php");
require_once("../../Config/conexion.php");

$conexion = new Database();
$con = $conexion->conectar();


// Verificar si se envió el formulario de creación
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Procesar el formulario de creación y agregar el nuevo estado a la base de datos
    $nuevo_estado = $_POST['nuevo_estado'];

    $insertar_estado = "INSERT INTO estado (tip_est) VALUES (?)";
    $stmt = $con->prepare($insertar_estado);
    $stmt->execute([$nuevo_estado]);

    if ($stmt->rowCount() > 0) {
        // Redirigir a la página de lista de estados después de la creación exitosa
        header("Location: ../Visualizar/estado.php");
        exit;
    } else {
        echo "Error al crear el estado.";
    }
}
?>
<?php include "../Template/header.php"; ?>
<div class="container mt-5">
    <h1 class="text-center">Crear Estado</h1>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="nuevo_estado" class="form-label">Nuevo Estado</label>
            <input type="text" class="form-control" id="nuevo_estado" name="nuevo_estado"  required>
        </div>
        <button type="submit" class="btn btn-primary">Crear Estado</button>
    </form>
</div>
<?php include "../Template/footer.php"; ?>