<?php
    require_once("../../Config/conexion.php"); 

    $conexion = new Database();
    $con = $conexion->conectar();

    $insertSQL = $con -> prepare("DELETE FROM estado WHERE id_est = '".$_GET['id']."'");      
    $insertSQL->execute();
    echo '<script>alert ("Registro eliminado exitosamente.");</script>';
    echo '<script>window.location="../Visualizar/estado.php"</script>';
?>