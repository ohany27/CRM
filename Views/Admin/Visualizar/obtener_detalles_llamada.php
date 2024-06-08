<?php
require_once ("../../../Config/conexion.php");
$DataBase = new Database;
$con = $DataBase->conectar();

$id_llamada = $_GET['id_llamada'];

$query = $con->prepare("SELECT id_ticket, documento, fecha, descripcion, id_empleado FROM llamadas WHERE id_llamada = ?");
$query->execute([$id_llamada]);

$detalle = $query->fetch(PDO::FETCH_ASSOC);

echo json_encode($detalle);
?>