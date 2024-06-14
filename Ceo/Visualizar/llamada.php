<?php
include('../../Config/conexion.php');
$database = new Database();
$pdo = $database->conectar();

if(isset($_GET['toggle_nitc'])) {
    $nitc = $_GET['toggle_nitc'];
    
    // Verificar si la empresa está activa o inactiva
    $stmt = $pdo->prepare("SELECT id_estado FROM empresa WHERE nitc = :nitc");
    $stmt->execute([':nitc' => $nitc]);
    $estado = $stmt->fetchColumn();

    // Cambiar el estado de la empresa
    if ($estado == 1) {
        $newState = 2; // Cambiar de activa a inactiva
        $alertMessage = "La empresa ha sido desactivada.";
    } elseif ($estado == 2) {
        $newState = 1; // Cambiar de inactiva a activa
        $alertMessage = "La empresa ha sido activada.";
    }

    // Actualizar el estado en la base de datos
    $stmt = $pdo->prepare("UPDATE empresa SET id_estado = :newState WHERE nitc = :nitc");
    $stmt->execute([':newState' => $newState, ':nitc' => $nitc]);

    // Crear el script de alerta y redireccionamiento
    echo "<script>alert('$alertMessage'); window.location='empresa.php';</script>";
    exit;
}
?>
