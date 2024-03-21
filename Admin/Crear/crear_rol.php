<?php
include("../../Config/validarSesion.php");
require_once("../../Config/conexion.php");

$conexion = new Database();
$con = $conexion->conectar();

// Lógica de creación si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Asegúrate de que el campo en el formulario coincida exactamente con el que estás utilizando aquí
    $nuevo_id_rol = isset($_POST['nuevo_id_tip_usu']) ? $_POST['nuevo_id_tip_usu'] : '';
    $nuevo_tipo_usu = isset($_POST['nuevo_tip_usu']) ? $_POST['nuevo_tip_usu'] : '';

    // Verificar si el id_tip_usu ya existe en la base de datos
    $consultaExistencia = "SELECT COUNT(*) FROM roles WHERE id_tip_usu = '$nuevo_id_rol'";
    $resultadoExistencia = $con->query($consultaExistencia);

    if ($resultadoExistencia->fetchColumn() == 0) {
        // El id_tip_usu no existe, realizar la inserción
        $insertarConsulta = "INSERT INTO roles (id_tip_usu, tip_usu) VALUES ('$nuevo_id_rol', '$nuevo_tipo_usu')";
        $con->exec($insertarConsulta);

        // Redirigir a la página de lista después de la creación
        header("Location: ../Visualizar/roles.php");
        exit();
    } else {
        // El id_tip_usu ya existe, manejar el error o mostrar un mensaje al usuario
        echo "El ID de Rol ya existe. Por favor, elige otro.";
    }
}
?>
<?php include "../Template/header.php"; ?>
<div class="container mt-5">
    <h1 class="text-center">Crear Tipo de Usuario</h1>
    <br>
    <form method="POST">
        <div class="mb-3">
            <label for="nuevo_id_rol" class="form-label">ID de Rol:</label>
            <input type="text" class="form-control" id="nuevo_id_tip_usu" name="nuevo_id_tip_usu" readonly required>
        </div>
        <div class="mb-3">
            <label for="nuevo_tip_usu" class="form-label">Nuevo Tipo de Usuario:</label>
            <input type="text" class="form-control" id="nuevo_tip_usu" name="nuevo_tip_usu" required>
        </div>
        <button type="submit" class="btn btn-primary">Crear Tipo de Usuario</button>
    </form>
</div>
<?php include "../Template/footer.php"; ?>