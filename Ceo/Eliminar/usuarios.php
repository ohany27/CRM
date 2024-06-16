<?php
    require_once("../../Config/conexion.php"); 

    $conexion = new Database();
    $con = $conexion->conectar();

    $insertSQL = $con -> prepare("DELETE FROM usuario WHERE documento = '".$_GET['id']."'");      
    $insertSQL->execute();
    echo '<script>alert ("Registro eliminado exitosamente.");</script>';
    echo '<script>window.location="../Visualizar/usuarios.php"</script>';
?> 