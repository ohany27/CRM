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

?>