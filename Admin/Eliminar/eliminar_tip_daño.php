<?php
//1
    require_once("../../Config/conexion.php");
    $Conexion = new Database;
    $con = $Conexion -> conectar();
    session_start();

    $insertSQL = $con -> prepare("DELETE FROM tipo_daño WHERE id_daño = '".$_GET['id_daño']."'");      
    $insertSQL->execute();
    echo '<script>alert ("Registro eliminado exitosamente.");</script>';
    echo '<script>window.location="../Visualizar/tipo_daño.php"</script>';
    ?>