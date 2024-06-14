<?php
    require_once("../../../Config/conexion.php"); 

    $conexion = new Database();
    $con = $conexion->conectar();

    $updateSQL = $con -> prepare("UPDATE usuario SET id_estado = 1 WHERE documento = :documento");      
    $updateSQL->bindParam(':documento', $_GET['id']);
    $updateSQL->execute();
    echo '<script>alert("Usuario activado.");</script>';
    echo '<script>window.location="../Visualizar/usuarios.php"</script>';
?>  
