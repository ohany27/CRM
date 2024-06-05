<?php
include "../../../Config/conexion.php";
$DataBase = new Database;
$con = $DataBase->conectar();

// Verificar si se recibieron datos del formulario
if (isset($_POST['id_ticket']) && isset($_POST['documento']) && isset($_POST['fecha_inicio']) && isset($_POST['fecha_final']) && isset($_POST['id_estado']) && isset($_POST['descripcion_detalle']) && isset($_POST['id_riesgo'])) {
    // Recuperar los datos del formulario
    $id_ticket = $_POST['id_ticket'];
    $documento = $_POST['documento'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_final = $_POST['fecha_final'];
    $id_estado = $_POST['id_estado'];
    $descripcion_detalle = $_POST['descripcion_detalle'];
    $id_riesgo = $_POST['id_riesgo'];

    // Realizar la inserción en la base de datos
    $query = "INSERT INTO detalle_ticket (id_ticket, documento, id_estado, fecha_inicio, fecha_final, descripcion_detalle, id_riesgo) 
              VALUES (:id_ticket, :documento, :id_estado, :fecha_inicio, :fecha_final, :descripcion_detalle, :id_riesgo)";
    $stmt = $con->prepare($query);
    $stmt->bindParam(':id_ticket', $id_ticket);
    $stmt->bindParam(':documento', $documento);
    $stmt->bindParam(':id_estado', $id_estado);
    $stmt->bindParam(':fecha_inicio', $fecha_inicio);
    $stmt->bindParam(':fecha_final', $fecha_final);
    $stmt->bindParam(':descripcion_detalle', $descripcion_detalle);
    $stmt->bindParam(':id_riesgo', $id_riesgo);
    
    // Ejecutar la consulta
    if ($stmt->execute()) {
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
