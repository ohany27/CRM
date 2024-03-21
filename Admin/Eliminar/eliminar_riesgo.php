<?php
//1
    require_once("../../Config/conexion.php");
    $Conexion = new Database;
    $con = $Conexion -> conectar();
    session_start();

    $insertSQL = $con -> prepare("DELETE FROM riesgos WHERE id_riesgo = '".$_GET['id_riesgo']."'");      
    $insertSQL->execute();
    echo '<script>alert ("Registro eliminado exitosamente.");</script>';
    echo '<script>window.location="../Visualizar/riesgos.php"</script>';
    ?>