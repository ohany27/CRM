<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../../../../crm/index.php");
    exit;
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: ../../../../crm/index.php");
    exit;
}
$tiempo_inactividad = 300; // 5 minutos

// Comprueba si la sesión ha expirado debido a la inactividad
if (isset($_SESSION['tiempo_ultimo_acceso']) && (time() - $_SESSION['tiempo_ultimo_acceso']) > $tiempo_inactividad) {
    // Destruye la sesión y redirige a la página de inicio de sesión
    session_unset();
    session_destroy();
    echo "<script>alert('Sobrepasaste el tiempo de inactividad, por favor inicie sesión nueva mente.'); window.location.href='../../../../crm/index.php';</script>";

    exit;
}

// Actualiza el tiempo del último acceso
$_SESSION['tiempo_ultimo_acceso'] = time();
?>