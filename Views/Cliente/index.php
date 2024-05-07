<?php
include ("../../Config/validarSesion.php");
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
                                            <a class="nav-link px-4"
                                                href="Visualizar/llamadas.php">
                                                <span class="d-block d-sm-none"><i class="mdi mdi-menu-open"></i></span>
                                                <span class="d-none d-sm-block">Mis Llamadas </span>
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link px-4"
                                                href="Visualizar/nuevo_llamada.php">
                                                <span class="d-block d-sm-none"><i class="mdi mdi-menu-open"></i></span>
                                                <span class="d-none d-sm-block">Empieza Una Llamada </span>
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
                            
                            <p>Nos alegra anunciar nuestro nuevo sistema de atención al cliente, que promete mejorar nuestra plataforma CRM. Ahora, puedes contactar directamente a nuestros empleados para generar y dar seguimiento a tus solicitudes de tickets.</p>
                        
                            <ul class="ps-3 mb-0">
                                <li></i><a
                                                        href="" class="__cf_email__"
                                                        data-cfemail="105a717e637867757c7c635060627f7279733e737f7d">[Terminos y Condiciones]</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div>
                            <h4 class="card-title mb-4">Datos Personales</h4>
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
                                            <td><?php echo $_SESSION['usuario']['nitc']; ?></td>
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
                            <h4 class="card-title mb-4">Work Experince</h4>
                            <ul class="list-unstyled work-activity mb-0">
                                <li class="work-item" data-date="2020-21">
                                    <h6 class="lh-base mb-0">ABCD Company</h6>
                                    <p class="font-size-13 mb-2">Web Designer</p>
                                    <p>To achieve this, it would be necessary to have uniform grammar, and more
                                        common words.</p>
                                </li>
                                <li class="work-item" data-date="2019-20">
                                    <h6 class="lh-base mb-0">XYZ Company</h6>
                                    <p class="font-size-13 mb-2">Graphic Designer</p>
                                    <p class="mb-0">It will be as simple as occidental in fact, it will be
                                        Occidental person, it will seem like simplified.</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">

    </script>
</body>

</html>