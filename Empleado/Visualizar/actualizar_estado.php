<?php
require_once ("../../../Config/conexion.php");
$DataBase = new Database;
$con = $DataBase->conectar();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_llamada = $_POST['id_llamada'];
    $fecha_inicio = $_POST['fecha_inicio'];

    // Actualizar el estado de la llamada a 4
    $consulta = "UPDATE llamadas SET id_est = 4 WHERE id_llamada = :id_llamada";
    $stmt = $con->prepare($consulta);
    $stmt->bindParam(':id_llamada', $id_llamada);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
}
?>
