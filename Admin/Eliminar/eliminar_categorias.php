<?php
    require_once("../../Config/conexion.php"); 

    $conexion = new Database();
    $con = $conexion->conectar();

    $insertSQL = $con -> prepare("DELETE FROM categoria WHERE id_cat = '".$_GET['id']."'");      
    $insertSQL->execute();
    echo '<script>alert ("Categoria eliminada exitosamente.");</script>';
    echo '<script>window.location="../Visualizar/categoria.php"</script>';
?>