<?php
//1
    require_once("../../Config/conexion.php");
    $Conexion = new Database;
    $con = $Conexion -> conectar();
    session_start();

    $insertSQL = $con -> prepare("DELETE FROM precios WHERE id_pre = '".$_GET['id_pre']."'");      
    $insertSQL->execute();
    echo '<script>alert ("Registro eliminado exitosamente.");</script>';
    echo '<script>window.location="../Visualizar/precios.php"</script>';
    ?>