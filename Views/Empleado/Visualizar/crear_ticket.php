<?php
session_start();
require_once("../../../Config/conexion.php");
$DataBase = new Database;
$con = $DataBase->conectar();

// Configurar la zona horaria
date_default_timezone_set('America/Bogota'); // Ajusta esto a tu zona horaria

// Obtener datos del enlace
$id_llamada = $_GET['id_llamada'];
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

    
    // Obtener el id_riesgo de la llamada
    $sql_get_id_riesgo = $con->prepare("SELECT tipo_daño.id_riesgos AS id_riesgo 
                                        FROM llamadas 
                                        INNER JOIN tipo_daño ON llamadas.id_daño = tipo_daño.id_daño 
                                        WHERE llamadas.id_llamada = :id_llamada");
    $sql_get_id_riesgo->bindParam(':id_llamada', $id_llamada);
    $sql_get_id_riesgo->execute();
    $id_riesgo_row = $sql_get_id_riesgo->fetch(PDO::FETCH_ASSOC);
    $id_riesgo = $id_riesgo_row['id_riesgo'];

    // Obtener la fecha y hora actual para la fecha_final
    $fecha = date("Y-m-d H:i:s");

    // Insertar en la tabla detalle_ticket utilizando el ID del ticket, el documento del empleado, y las fechas
    $sql_insert_detalle = $con->prepare("INSERT INTO detalle_ticket (id_ticket, id_estado, documento, id_riesgo, fecha_inicio, fecha_final, descripcion_detalle) VALUES (?, 3, ?, ?, ?, ?, NULL)");
    $sql_insert_detalle->execute([$id_ticket, $documento_empleado, $id_riesgo, $fecha, $fecha]);


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
