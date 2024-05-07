<?php
include ("../../../Config/validarSesion.php");
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
                                    <img src="https://bootdey.com/img/Content/avatar/avatar1.png"
                                        class="img-fluid avatar-xxl rounded-circle" alt>
                                    <h4 class="text-primary font-size-20 mt-3 mb-2"><?php echo $_SESSION['usuario']['nombre']; ?></h4>
                                    <h5 class="text-muted font-size-13 mb-0"><?php echo $_SESSION['usuario']['id_tip_usu']; ?></h5>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="ms-3">
                                    <div>
                                        <h4 class="card-title mb-2">Tienes Problemas!</h4>
                                        <p class="mb-0 text-muted">Saludos cordiales. Antes de comenzar un ticket, te solicitamos amablemente que esperes a que un empleado esté disponible para atender tu llamada. Esta acción asegura una asistencia más eficiente y personalizada.</p>
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
                                    
                            