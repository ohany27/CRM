<?php
require_once("../../../Config/conexion.php");
$DataBase = new Database;
$con = $DataBase->conectar();

$id_llamada = $_GET['id_llamada'];

$query = $con->prepare("SELECT l.id_ticket, l.documento, l.fecha, l.descripcion, l.id_empleado, u.nombre AS nombre_usuario, u_empleado.nombre AS nombre_empleado
                        FROM llamadas l
                        LEFT JOIN usuario u ON l.documento = u.documento
                        LEFT JOIN usuario u_empleado ON l.id_empleado = u_empleado.documento
                        WHERE l.id_llamada = ?");
$query->execute([$id_llamada]);

$detalle = $query->fetch(PDO::FETCH_ASSOC);

// Si el detalle está vacío, puedes manejar el caso de error aquí

echo json_encode($detalle);
?>
