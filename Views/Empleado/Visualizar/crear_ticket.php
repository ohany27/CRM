<?php
require_once("../../../Config/conexion.php");
$DataBase = new Database;
$con = $DataBase->conectar();

// Obtener datos del enlace
$id_llamada = $_GET['id_llamada'];
$fecha_inicio = $_GET['fecha_inicio'];
$id_estado = 4; // ID del estado "Procesando"

$sql = $con->prepare("INSERT INTO ticket (id_llamada, fecha_inicio, id_estado) VALUES (?, ?, ?)");
$sql->execute([$id_llamada, $fecha_inicio, $id_estado]);


// Redirigir a la página de llamada con el ID del ticket recién insertado
header("Location: llamada.php?id=" . $con->lastInsertId());
?>
