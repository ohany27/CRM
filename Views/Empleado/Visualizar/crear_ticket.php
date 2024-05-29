<?php
session_start();
require_once("../../../Config/conexion.php");
$DataBase = new Database;
$con = $DataBase->conectar();

// Obtener datos del enlace
$id_llamada = $_GET['id_llamada'];
$fecha_inicio = $_GET['fecha_inicio'];

// Obtener el documento del usuario logeado desde la sesión
$documento_empleado = $_SESSION['usuario']['documento'];

// Iniciar una transacción
$con->beginTransaction();

try {
    // Obtener el último id_ticket generado
    $sql_get_last_id = $con->prepare("SELECT MAX(CAST(SUBSTRING(id_ticket, 4) AS UNSIGNED)) AS max_id FROM llamadas WHERE id_ticket IS NOT NULL");
    $sql_get_last_id->execute();
    $last_id_row = $sql_get_last_id->fetch(PDO::FETCH_ASSOC);
    $last_id = $last_id_row['max_id'];

    // Verificar si hay un último id_ticket válido
    if ($last_id !== null) {
        // Incrementar el último id_ticket y generar el nuevo id_ticket
        $next_id = $last_id + 1;
        $id_ticket = "Tk_" . str_pad($next_id, 3, "0", STR_PAD_LEFT);
    } else {
        // Si no hay un último id_ticket válido, generar el primer id_ticket
        $id_ticket = "Tk_001";
    }

    // Actualizar la fila en la tabla llamadas con el id_ticket generado
    $sql_update_llamada = $con->prepare("UPDATE llamadas SET id_ticket = :id_ticket WHERE id_llamada = :id_llamada");
    $sql_update_llamada->bindParam(':id_ticket', $id_ticket);
    $sql_update_llamada->bindParam(':id_llamada', $id_llamada);
    $sql_update_llamada->execute();

    // Insertar en la tabla detalle_ticket utilizando el ID del ticket y el documento del empleado
    $sql_insert_detalle = $con->prepare("INSERT INTO detalle_ticket (id_ticket, id_estado, documento, id_riesgo, fecha_inicio, fecha_final, descripcion_detalle) VALUES (?, 3, ?, NULL, ?, NULL, NULL)");
    $sql_insert_detalle->execute([$id_ticket, $documento_empleado, $fecha_inicio]);

    // Confirmar la transacción
    $con->commit();

    // Redirigir a la página de llamada con el ID del ticket recién insertado
    header("Location: llamada.php?id=" . $id_ticket);
} catch (Exception $e) {
    // Revertir la transacción en caso de error
    $con->rollBack();
    echo "Error: " . $e->getMessage();
}
?>
