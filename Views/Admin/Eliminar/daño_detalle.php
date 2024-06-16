<?php
require_once("../../../Config/conexion.php");
$Conexion = new Database;
$con = $Conexion->conectar();
session_start();

$insertSQL = $con->prepare("DELETE FROM detalle_daño WHERE id_detalle_daño = '" . $_GET['id_detalle_daño'] . "'");
$insertSQL->execute();
echo '<script>alert ("Registro eliminado exitosamente.");</script>';
echo '<script>window.location="../Visualizar/daño_detalle.php"</script>';
?>