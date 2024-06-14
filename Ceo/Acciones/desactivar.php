<?php
    require_once("../../Config/conexion.php"); 

    $conexion = new Database();
    $con = $conexion->conectar();

    $updateSQL = $con->prepare("UPDATE usuario SET id_estado = 2 WHERE documento = :documento");      
    $updateSQL->bindParam(':documento', $_GET['id']);
    $updateSQL->execute();
    echo '<script>alert("Usuario desactivado.");</script>';
    echo '<script>window.location="../Visualizar/usuarios.php"</script>';
?>  
