<?php include "../Template/header.php"; ?>
<ul class="nav nav-tabs nav-tabs-custom border-bottom-0 mt-3 nav-justfied"
                                        role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link px-4 "  href="../index.php">
                                                <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                                <span class="d-none d-sm-block">Mis Tickets</span>
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link px-4 active"
                                                href="../Visualizar/llamadas.php">
                                                <span class="d-block d-sm-none"><i class="mdi mdi-menu-open"></i></span>
                                                <span class="d-none d-sm-block">Mis Llamadas </span>
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link px-4 "
                                                href="../Visualizar/nuevo_llamada.php">
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
        <h4 class="card-title mb-4">Llamadas</h4>
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


    <?php include "../Template/footer.php"; ?>
