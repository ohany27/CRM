<?php
require_once("../../../Config/conexion.php");
$Conexion = new Database;
$con = $Conexion->conectar();
session_start();

if (isset($_GET['id_daño']) && !empty($_GET['id_daño'])) {
    // Verificar si existen detalles de daño asociados
    $checkSQL = $con->prepare("SELECT COUNT(*) AS total FROM detalle_daño WHERE id_daño = :id_dano");
    $checkSQL->bindParam(':id_dano', $_GET['id_daño']);
    $checkSQL->execute();
    $result = $checkSQL->fetch(PDO::FETCH_ASSOC);

    if ($result['total'] > 0) {
        echo '<script>alert("No se puede eliminar el daño porque existen detalles de daño asociados. Elimina primero los detalles.");</script>';
        echo '<script>window.location="../Visualizar/daño_detalle.php"</script>';
    } else {
        // Si no hay detalles de daño asociados, proceder con la eliminación
        $deleteSQL = $con->prepare("DELETE FROM tipo_daño WHERE id_daño = :id_dano");
        $deleteSQL->bindParam(':id_dano', $_GET['id_daño']);
        $deleteSQL->execute();

        echo '<script>alert("Registro eliminado exitosamente.");</script>';
        echo '<script>window.location="../Visualizar/daños.php"</script>';
    }
} else {
    // Manejo de error si no se proporciona id_daño
    echo '<script>alert("No se ha proporcionado un ID válido.");</script>';
    echo '<script>window.location="../Visualizar/daños.php"</script>';
}
?>
