<?php
require_once("../../../Config/conexion.php");

if (isset($_GET['id_daño'])) {
    $id_daño = $_GET['id_daño'];

    // Crear una instancia de la conexión
    $conexion = new Database();
    $con = $conexion->conectar();

    // Realizar la actualización del estado a 2 (inactivo)
    $updateSQL = $con->prepare("UPDATE tipo_daño SET estado = 1 WHERE id_daño = :id");
    $updateSQL->bindParam(':id', $id_daño, PDO::PARAM_INT);
    $updateSQL->execute();

    // Redirigir de vuelta a la página principal o a donde corresponda
    echo '<script>alert("Daño Activo.");</script>';
    echo '<script>window.location="../Visualizar/daños.php";</script>';
    exit();
} else {
    // Manejo de error si no se proporciona id_daño
    echo '<script>alert("No se proporcionó el ID del daño.");</script>';
    echo '<script>window.location="../Visualizar/daños.php";</script>';
}
?>
