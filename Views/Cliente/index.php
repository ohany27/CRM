<?php
include ("../../Config/validarSesion.php");
?>
<?php
require_once ("../../Config/conexion.php");
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

// Consulta SQL para contar empleados
$sql_empleados = "SELECT COUNT(*) AS total_empleados FROM usuario WHERE id_tip_usu = 3";

// Preparar y ejecutar la consulta de empleados
$stmt_empleados = $con->prepare($sql_empleados);
$stmt_empleados->execute();
$resultado_empleados = $stmt_empleados->fetch(PDO::FETCH_ASSOC);
$total_empleados = $resultado_empleados['total_empleados'];


// Determinar la clase del ícono de empleados
$clase_icono_empleados = ($total_empleados <= 0) ? "mdi mdi-circle-medium text-danger fs-3 align-middle" : "mdi mdi-circle-medium text-success fs-3 align-middle";

// Consulta SQL para contar técnicos
$sql_tecnicos = "SELECT COUNT(*) AS total_tecnicos FROM usuario WHERE id_tip_usu = 4";

// Preparar y ejecutar la consulta de técnicos
$stmt_tecnicos = $con->prepare($sql_tecnicos);
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
    <link href="Assets/css/index.css" rel="stylesheet">
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
                                    <h4 class="text-primary font-size-20 mt-3 mb-2">
                                        <?php echo $_SESSION['usuario']['nombre']; ?>
                                    </h4>
                                    <h5 class="text-muted font-size-13 mb-0"><?php echo $nombre_tipo_usuario; ?></h5>
                                    <br>
                                    <a class="custom-nav-link px-4" href="../../Config/validarSesion.php?logout=true">
                                        <i class="mdi mdi-door-open mdi-24px"></i>
                                    </a>

                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="ms-3">
                                    <div>
                                        <h4 class="card-title mb-2">Tienes Problemas!</h4>
                                        <p class="mb-0 text-muted">Saludos cordiales. Antes de comenzar un ticket, te
                                            solicitamos amablemente que esperes a que un empleado esté disponible para
                                            atender tu Solicitud. Esta acción asegura una asistencia más eficiente y
                                            personalizada.</p>
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
                                    <ul class="nav nav-tabs nav-tabs-custom border-bottom-0 mt-3 nav-justfied"
                                        role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link px-4 active" data-bs-toggle="tab" href="index.php"
                                                role="tab" aria-selected="false" tabindex="-1">
                                                <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                                <span class="d-none d-sm-block">Mis Tickets</span>
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link px-4" href="Visualizar/llamadas.php">
                                                <span class="d-block d-sm-none"><i class="mdi mdi-menu-open"></i></span>
                                                <span class="d-none d-sm-block">Mis Llamadas </span>
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link px-4" href="Visualizar/solicitud.php">
                                                <span class="d-block d-sm-none"><i class="mdi mdi-menu-open"></i></span>
                                                <span class="d-none d-sm-block">Empieza Una Solicitud </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="tab-content p-4">
                        <div class="tab-pane active show" id="projects-tab" role="tabpanel">
                            <div class="d-flex align-items-center">
                                <div class="flex-1">
                                    <h4 class="card-title mb-4">Tickets</h4>
                                </div>
                            </div>
                            <div class="row" id="all-projects">
                                <div class="col-md-6" id="project-items-1">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex mb-3">
                                                <div class="flex-grow-1 align-items-start">
                                                    <div>
                                                        <h6 class="mb-0 text-muted">
                                                            <i
                                                                class="mdi mdi-circle-medium text-danger fs-3 align-middle"></i>
                                                            <span class="team-date">21 Jun, 2021</span>
                                                        </h6>
                                                    </div>
                                                </div>
                                                <div class="dropdown ms-2">
                                                    <a href="#" class="dropdown-toggle font-size-16 text-muted"
                                                        data-bs-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <i class="mdi mdi-dots-horizontal"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a class="dropdown-item" href="javascript: void(0);"
                                                            data-bs-toggle="modal"
                                                            data-bs-target=".bs-example-new-project"
                                                            onclick="editProjects('project-items-1')">Edit</a>
                                                        <a class="dropdown-item" href="javascript: void(0);">Share</a>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item delete-item"
                                                            onclick="deleteProjects('project-items-1')"
                                                            data-id="project-items-1"
                                                            href="javascript: void(0);">Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-4">
                                                <h5 class="mb-1 font-size-17 team-title">Hardware</h5>
                                                <p class="text-muted mb-0 team-description">Every Marketing Plan
                                                    Needs</p>
                                            </div>
                                            <div class="d-flex">
                                                <div class="align-self-end">
                                                    <span class="badge badge-soft-danger p-2 team-status">Pending</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6" id="project-items-2">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex mb-3">
                                                <div class="flex-grow-1 align-items-start">
                                                    <div>
                                                        <h6 class="mb-0 text-muted">
                                                            <i
                                                                class="mdi mdi-circle-medium text-success fs-3 align-middle"></i>
                                                            <span class="team-date">13 Aug, 2021</span>
                                                        </h6>
                                                    </div>
                                                </div>
                                                <div class="dropdown ms-2">
                                                    <a href="#" class="dropdown-toggle font-size-16 text-muted"
                                                        data-bs-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <i class="mdi mdi-dots-horizontal"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a class="dropdown-item" href="javascript: void(0);"
                                                            data-bs-toggle="modal"
                                                            data-bs-target=".bs-example-new-project"
                                                            onclick="editProjects('project-items-2')">Edit</a>
                                                        <a class="dropdown-item" href="javascript: void(0);">Share</a>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item delete-item" href="javascript:void(0);"
                                                            onclick="deleteProjects('project-items-2')"
                                                            data-id="project-items-2">Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-4">
                                                <h5 class="mb-1 font-size-17 team-title">Hardware</h5>
                                                <p class="text-muted mb-0 team-description">Creating the design
                                                    and layout of a
                                                    website.</p>
                                            </div>
                                            <div class="d-flex">
                                                <div class="align-self-end">
                                                    <span
                                                        class="badge badge-soft-success p-2 team-status">Completed</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6" id="project-items-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex mb-3">
                                                <div class="flex-grow-1 align-items-start">
                                                    <div>
                                                        <h6 class="mb-0 text-muted">
                                                            <i
                                                                class="mdi mdi-circle-medium text-warning fs-3 align-middle"></i>
                                                            <span class="team-date">08 Sep, 2021</span>
                                                        </h6>
                                                    </div>
                                                </div>
                                                <div class="dropdown ms-2">
                                                    <a href="#" class="dropdown-toggle font-size-16 text-muted"
                                                        data-bs-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <i class="mdi mdi-dots-horizontal"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a class="dropdown-item" href="javascript: void(0);"
                                                            data-bs-toggle="modal"
                                                            data-bs-target=".bs-example-new-project"
                                                            onclick="editProjects('project-items-3')">Edit</a>
                                                        <a class="dropdown-item" href="javascript: void(0);">Share</a>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item delete-item" href="javascript: void(0);"
                                                            data-id="project-items-3"
                                                            onclick="deleteProjects('project-items-3')">Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-4">
                                                <h5 class="mb-1 font-size-17 team-title">software</h5>
                                                <p class="text-muted mb-0 team-description">Plan and onduct user
                                                    research and analysis</p>
                                            </div>
                                            <div class="d-flex">

                                                <div class="align-self-end">
                                                    <span
                                                        class="badge badge-soft-warning p-2 team-status">Progress</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6" id="project-items-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex mb-3">
                                                <div class="flex-grow-1 align-items-start">
                                                    <div>
                                                        <h6 class="mb-0 text-muted">
                                                            <i
                                                                class="mdi mdi-circle-medium text-danger fs-3 align-middle"></i>
                                                            <span class="team-date">20 Sep, 2021</span>
                                                        </h6>
                                                    </div>
                                                </div>
                                                <div class="dropdown ms-2">
                                                    <a href="#" class="dropdown-toggle font-size-16 text-muted"
                                                        data-bs-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <i class="mdi mdi-dots-horizontal"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a class="dropdown-item" href="javascript: void(0);"
                                                            data-bs-toggle="modal"
                                                            data-bs-target=".bs-example-new-project"
                                                            onclick="editProjects('project-items-4')">Edit</a>
                                                        <a class="dropdown-item" href="javascript: void(0);">Share</a>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item delete-item" href="javascript:void(0);"
                                                            data-id="project-items-4"
                                                            onclick="deleteProjects('project-items-4')">Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-4">
                                                <h5 class="mb-1 font-size-17 team-title">software</h5>
                                                <p class="text-muted mb-0 team-description">The procurement
                                                    specifications should
                                                    describe</p>
                                            </div>
                                            <div class="d-flex">

                                                <div class="align-self-end">
                                                    <span class="badge badge-soft-danger p-2 team-status">Pending</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="pb-2">
                            <h4 class="card-title mb-3">Nuevo Software</h4>

                            <p>Nos alegra anunciar nuestro nuevo sistema de atención al cliente, que promete mejorar
                                nuestra plataforma CRM. Ahora, puedes contactar directamente a nuestros empleados para
                                generar y dar seguimiento a tus solicitudes de tickets.</p>

                            <ul class="ps-3 mb-0">
                                <li><a href="#" class="__cf_email__"
                                        data-cfemail="105a717e637867757c7c635060627f7279733e737f7d"
                                        data-bs-toggle="modal" data-bs-target="#modalTerminosCondiciones">[Terminos y
                                        Condiciones]</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div>
                            <h4 class="card-title mb-4"><a class="perfil" href="Visualizar/perfil.php"><i
                                        class="mdi mdi-account-circle mdi-18px">
                                        Datos Personales
                                    </i></a></h4>
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <tbody>
                                        <tr>
                                            <th scope="row">Nombre</th>
                                            <td><?php echo $_SESSION['usuario']['nombre']; ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Correo</th>
                                            <td><?php echo $_SESSION['usuario']['correo']; ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Direccion</th>
                                            <td><?php echo $_SESSION['usuario']['direccion']; ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Telefono</th>
                                            <td>+57 <?php echo $_SESSION['usuario']['telefono']; ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Empresa</th>
                                            <td><?php echo $nombre_empresa; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div>
                            <h4 class="card-title mb-4"><i class="<?php echo $clase_icono_empleados; ?>"></i>Empleados
                            </h4>
                            <ul class="list-unstyled work-activity mb-0">
                                <li class="work-item" data-date="2024">
                                    <h6 class="lh-base mb-0"><?php echo $total_empleados; ?></h6>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div>
                            <h4 class="card-title mb-4"><i class="<?php echo $clase_icono_tecnicos; ?>"></i>Tecnicos
                            </h4>
                            <ul class="list-unstyled work-activity mb-0">
                                <li class="work-item" data-date="2024">
                                    <h6 class="lh-base mb-0"><?php echo $total_tecnicos; ?> </h6>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal de Términos y Condiciones -->
    <div class="modal fade" id="modalTerminosCondiciones" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Términos y Condiciones</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ol>
                        <li><strong>Aceptación de los Términos:</strong> Al acceder y utilizar nuestro CRM para aparatos
                            tecnológicos (hardware) y software, aceptas cumplir y estar sujeto a estos términos y
                            condiciones. Si no estás de acuerdo con alguna parte de estos términos, no podrás acceder al
                            CRM ni utilizar nuestros servicios.</li>
                        <li><strong>Uso del CRM:</strong> Nuestro CRM está destinado para el seguimiento de tickets de
                            soporte técnico, gestión de llamadas, y otras actividades relacionadas con la atención al
                            cliente en el contexto de aparatos tecnológicos y software. Queda prohibido utilizar el CRM
                            con cualquier fin ilegal o no autorizado.</li>
                        <li><strong>Responsabilidades del Usuario:</strong> Eres responsable de mantener la
                            confidencialidad de tu cuenta y contraseña, y de todas las actividades que ocurran bajo tu
                            cuenta. Debes notificarnos de inmediato sobre cualquier uso no autorizado de tu cuenta o
                            cualquier otra violación de seguridad.</li>
                        <li><strong>Privacidad:</strong> Nos comprometemos a proteger tu privacidad y tus datos
                            personales de acuerdo con nuestra política de privacidad. Sin embargo, al utilizar nuestro
                            CRM, aceptas que podamos recopilar, almacenar y utilizar cierta información personal de
                            acuerdo con dicha política.</li>
                        <li><strong>Propiedad Intelectual:</strong> Todo el contenido del CRM, incluidos textos,
                            gráficos, logotipos, iconos, imágenes, clips de audio y video, y software, es propiedad de
                            nuestra empresa o de sus proveedores y está protegido por las leyes de propiedad
                            intelectual.</li>
                        <li><strong>Limitación de Responsabilidad:</strong> En ningún caso seremos responsables ante ti
                            o cualquier tercero por daños indirectos, incidentales, especiales, ejemplares o
                            consecuentes que surjan del uso o la imposibilidad de utilizar nuestro CRM.</li>
                        <li><strong>Modificaciones:</strong> Nos reservamos el derecho de modificar o revisar estos
                            términos y condiciones en cualquier momento sin previo aviso. El uso continuado del CRM
                            después de cualquier cambio constituye tu aceptación de dichos cambios.</li>
                    </ol>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">
    </script>
    <script>
        $(document).ready(function () {
            // Script para activar el modal de Términos y Condiciones al hacer clic en el enlace
            $('#modalTerminosCondiciones').on('show.bs.modal', function (e) {
                // Aquí puedes realizar alguna acción si es necesario antes de mostrar el modal
            });
        });
    </script>
</body>

</html>