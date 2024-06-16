<?php
include "../../../Config/conexion.php";
$DataBase = new Database;
$con = $DataBase->conectar();

// Obtener la fecha actual del servidor
$fecha_actual = date('Y-m-d H:i:s'); // Obtener la fecha y hora actuales en formato MySQL

// Verificar si se recibieron datos del formulario
if (isset($_POST['id_ticket']) && isset($_POST['documento']) && isset($_POST['id_estado']) && isset($_POST['descripcion_detalle'])) {
    // Recuperar los datos del formulario
    $id_ticket = $_POST['id_ticket'];
    $documento = $_POST['documento'];
    $id_estado = $_POST['id_estado'];
    $descripcion_detalle = $_POST['descripcion_detalle'];

    // Obtener id_riesgo correspondiente de detalle_ticket
    $query_riesgo = "SELECT id_riesgo FROM detalle_ticket WHERE id_estado = 4 AND id_ticket = :id_ticket"; // Modificado para obtener id_riesgo del mismo id_ticket
    $stmt_riesgo = $con->prepare($query_riesgo);
    $stmt_riesgo->bindParam(':id_ticket', $id_ticket);
    $stmt_riesgo->execute();
    $row_riesgo = $stmt_riesgo->fetch(PDO::FETCH_ASSOC);
    $id_riesgo = $row_riesgo['id_riesgo'];

    // Realizar el primer UPDATE en detalle_ticket
    $query_update_detalle = "UPDATE detalle_ticket SET fecha_final = :fecha_final WHERE id_estado = 4 AND id_ticket = :id_ticket";
    $stmt_update_detalle = $con->prepare($query_update_detalle);
    $stmt_update_detalle->bindParam(':fecha_final', $fecha_actual); // Usar la fecha actual obtenida al principio
    $stmt_update_detalle->bindParam(':id_ticket', $id_ticket);
    $stmt_update_detalle->execute();

    // Establecer fecha_inicio igual a fecha_final
    $fecha_inicio = $fecha_actual;

    // Realizar el segundo UPDATE en la tabla llamadas
    $query_update_llamadas = "UPDATE llamadas SET id_est = 5 WHERE id_ticket = :id_ticket";
    $stmt_update_llamadas = $con->prepare($query_update_llamadas);
    $stmt_update_llamadas->bindParam(':id_ticket', $id_ticket);
    $stmt_update_llamadas->execute();

    // Realizar la inserción en la base de datos para el nuevo registro con id_estado = 5
    $query_insert = "INSERT INTO detalle_ticket (id_ticket, documento, id_estado, fecha_inicio, fecha_final, descripcion_detalle, id_riesgo) 
                     VALUES (:id_ticket, :documento, :id_estado, :fecha_inicio, :fecha_final, :descripcion_detalle, :id_riesgo)";
    $stmt_insert = $con->prepare($query_insert);
    $stmt_insert->bindParam(':id_ticket', $id_ticket);
    $stmt_insert->bindParam(':documento', $documento);
    $stmt_insert->bindParam(':id_estado', $id_estado);
    $stmt_insert->bindParam(':fecha_inicio', $fecha_inicio);
    $stmt_insert->bindParam(':fecha_final', $fecha_actual); // Usar la fecha actual obtenida al principio
    $stmt_insert->bindParam(':descripcion_detalle', $descripcion_detalle);
    $stmt_insert->bindParam(':id_riesgo', $id_riesgo);

    // Ejecutar la consulta de inserción
    if ($stmt_insert->execute()) {
        // Redirigir o mostrar un mensaje de éxito
        header("Location: ../index.php");
        exit();
    } else {
        // Manejo de errores
        echo "Error al insertar el registro.";
    }
} else {
    echo "Faltan datos.";
}
?>
