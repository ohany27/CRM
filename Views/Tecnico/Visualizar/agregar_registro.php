<?php
include "../../../Config/conexion.php";
$DataBase = new Database;
$con = $DataBase->conectar();

// Verificar si se recibieron datos del formulario
if (isset($_POST['id_ticket']) && isset($_POST['documento']) && isset($_POST['fecha_inicio']) && isset($_POST['fecha_final']) && isset($_POST['id_estado']) && isset($_POST['descripcion_detalle'])) {
    // Recuperar los datos del formulario
    $id_ticket = $_POST['id_ticket'];
    $documento = $_POST['documento'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_final = $_POST['fecha_final'];
    $id_estado = $_POST['id_estado'];
    $descripcion_detalle = $_POST['descripcion_detalle'];

    // Obtener id_riesgo correspondiente de detalle_ticket
    $query_riesgo = "SELECT id_riesgo FROM detalle_ticket WHERE id_estado = 4 AND id_ticket = :id_ticket"; // Modificado para obtener id_riesgo del mismo id_ticket
    $stmt_riesgo = $con->prepare($query_riesgo);
    $stmt_riesgo->bindParam(':id_ticket', $id_ticket);
    $stmt_riesgo->execute();
    $row_riesgo = $stmt_riesgo->fetch(PDO::FETCH_ASSOC);
    $id_riesgo = $row_riesgo['id_riesgo'];

    // Actualizar el registro existente con id_estado = 4 para agregar la fecha final y descripción
    $query_update = "UPDATE detalle_ticket SET fecha_final = :fecha_final, descripcion_detalle = :descripcion_detalle WHERE id_estado = 4 AND id_ticket = :id_ticket";
    $stmt_update = $con->prepare($query_update);
    $stmt_update->bindParam(':fecha_final', $fecha_inicio); // Se utiliza la fecha de inicio como fecha final
    $stmt_update->bindParam(':descripcion_detalle', $descripcion_detalle);
    $stmt_update->bindParam(':id_ticket', $id_ticket);
    $stmt_update->execute();

    // Realizar la inserción en la base de datos para el nuevo registro con id_estado = 5
    $query_insert = "INSERT INTO detalle_ticket (id_ticket, documento, id_estado, fecha_inicio, fecha_final, descripcion_detalle, id_riesgo) 
                     VALUES (:id_ticket, :documento, :id_estado, :fecha_inicio, :fecha_final, :descripcion_detalle, :id_riesgo)";
    $stmt_insert = $con->prepare($query_insert);
    $stmt_insert->bindParam(':id_ticket', $id_ticket);
    $stmt_insert->bindParam(':documento', $documento);
    $stmt_insert->bindParam(':id_estado', $id_estado);
    $stmt_insert->bindParam(':fecha_inicio', $fecha_inicio);
    $stmt_insert->bindParam(':fecha_final', $fecha_final); // Se establece la misma fecha de inicio como fecha final
    $stmt_insert->bindParam(':descripcion_detalle', $descripcion_detalle);
    $stmt_insert->bindParam(':id_riesgo', $id_riesgo);
    
    // Ejecutar la consulta
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
