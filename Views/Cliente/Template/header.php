<?php
include ("../../../Config/validarSesion.php");
?>
<?php
require_once ("../../../Config/conexion.php");
$DataBase = new Database;
$con = $DataBase->conectar();
$id_tip_usu = $_SESSION['usuario']['id_tip_usu'];
$nitc = $_SESSION['usuario']['nitc'];

// Consulta SQL para obtener el nombre del tipo de usuario
$sql_tipo_usuario = "SELECT tip_usu FROM roles WHERE id_tip_usu = :id_tip_usu";

// Preparar la consulta para el tipo de usuario
$stmt_tipo_usuario = $con->prepare($sql_tipo_usuario);
$stmt_tipo_usuario->bindParam(':id_tip_usu', $id_tip_usu, PDO::PARAM_INT);
$stmt_tipo_usuario->execute();
$tipo_usuario_resultado = $stmt_tipo_usuario->fetch(PDO::FETCH_ASSOC);

// Obtener el nombre del tipo de usuario
if ($tipo_usuario_resultado) {
    $nombre_tipo_usuario = $tipo_usuario_resultado['tip_usu'];
} else {
    $nombre_tipo_usuario = "Desconocido";
}

// Consulta SQL para obtener el nombre de la empresa
$sql_empresa = "SELECT nombre FROM empresa WHERE nitc = :nitc";

// Preparar la consulta para la empresa
$stmt_empresa = $con->prepare($sql_empresa);
$stmt_empresa->bindParam(':nitc', $nitc, PDO::PARAM_INT);
$stmt_empresa->execute();
$empresa_resultado = $stmt_empresa->fetch(PDO::FETCH_ASSOC);

// Obtener el nombre de la empresa
if ($empresa_resultado) {
    $nombre_empresa = $empresa_resultado['nombre'];
} else {
    $nombre_empresa = "Desconocida";
}


$sql_empleados = "SELECT COUNT(*) AS total_empleados FROM usuario WHERE id_tip_usu = 3 AND nitc = :nitc";

// Preparar y ejecutar la consulta de empleados
$stmt_empleados = $con->prepare($sql_empleados);
$stmt_empleados->bindParam(':nitc', $nitc, PDO::PARAM_STR);
$stmt_empleados->execute();
$resultado_empleados = $stmt_empleados->fetch(PDO::FETCH_ASSOC);
$total_empleados = $resultado_empleados['total_empleados'];

// Determinar la clase del ícono de empleados
$clase_icono_empleados = ($total_empleados <= 0) ? "mdi mdi-circle-medium text-danger fs-3 align-middle" : "mdi mdi-circle-medium text-success fs-3 align-middle";

// Consulta SQL para contar técnicos con el mismo nitc
$sql_tecnicos = "SELECT COUNT(*) AS total_tecnicos FROM usuario WHERE id_tip_usu = 4 AND nitc = :nitc";

// Preparar y ejecutar la consulta de técnicos
$stmt_tecnicos = $con->prepare($sql_tecnicos);
$stmt_tecnicos->bindParam(':nitc', $nitc, PDO::PARAM_STR);
$stmt_tecnicos->execute();
$resultado_tecnicos = $stmt_tecnicos->fetch(PDO::FETCH_ASSOC);
$total_tecnicos = $resultado_tecnicos['total_tecnicos'];

// Determinar la clase del ícono de técnicos
$clase_icono_tecnicos = ($total_tecnicos <= 0) ? "mdi mdi-circle-medium text-danger fs-3 align-middle" : "mdi mdi-circle-medium text-success fs-3 align-middle";
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">


    <title>CRM - CLIENTE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../Assets/css/index.css" rel="stylesheet">
</head>

<body>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/7.2.96/css/materialdesignicons.min.css"
        integrity="sha512-LX0YV/MWBEn2dwXCYgQHrpa9HJkwB+S+bnBpifSOTO1No27TqNMKYoAn6ff2FBh03THAzAiiCwQ+aPX+/Qt/Ow=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <div class="container">
        <div class="row">
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body pb-0">
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <div class="text-center border-end">
                                    <img src="https://cdn-icons-png.freepik.com/512/2867/2867297.png"
                                        class="img-fluid avatar-xxl rounded-circle" alt>
                                    <h4 class="text-primary font-size-20 mt-3 mb-2"><?php echo $_SESSION['usuario']['nombre']; ?></h4>
                                    <h5 class="text-muted font-size-13 mb-0"><?php echo $nombre_tipo_usuario; ?></h5>
                                    <br>
                                    <a class="custom-nav-link px-4" href="../../../Config/validarSesion.php?logout=true">
                                        <i class="mdi mdi-door-open mdi-24px"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="ms-3">
                                    <div>
                                        <h4 class="card-title mb-2">Tienes Problemas!</h4>
                                        <p class="mb-0 text-muted">Saludos cordiales. Antes de comenzar un ticket, te solicitamos amablemente que esperes a que un empleado esté disponible para atender tu Solicitud. Esta acción asegura una asistencia más eficiente y personalizada.</p>
                                    </div>
                                    <div class="row my-4">
                                        <div class="col-md-12">
                                            <div>
                                                <p class="text-muted mb-2 fw-medium"><i
                                                        class="mdi mdi-email-outline me-2"> Tecnelectrics@gmail.com</i>
                                                </p>
                                                <p class="text-muted fw-medium mb-0"><i
                                                        class="mdi mdi-phone-in-talk-outline me-2"></i>+57 310 2552 339
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    
                            