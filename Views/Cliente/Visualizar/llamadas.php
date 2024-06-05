<?php
include "../Template/header.php";

?>

<ul class="nav nav-tabs nav-tabs-custom border-bottom-0 mt-3 nav-justfied" role="tablist">
    <li class="nav-item" role="presentation">
        <a class="nav-link px-4 " href="../index.php">
            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
            <span class="d-none d-sm-block">Mis Tickets</span>
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link px-4 active" href="../Visualizar/llamadas.php">
            <span class="d-block d-sm-none"><i class="mdi mdi-menu-open"></i></span>
            <span class="d-none d-sm-block">Mis Llamadas </span>
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link px-4 " href="../Visualizar/solicitud.php">
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
                    <h4 class="card-title mb-4">Llamadas</h4>
                </div>
            </div>
            <div class="row" id="all-projects">
                <?php
                // Verificar si el usuario ha iniciado sesión y obtener su documento
                if (isset($_SESSION['usuario']['documento'])) {
                    $documento = $_SESSION['usuario']['documento'];
                    // Consulta para obtener las llamadas del usuario actual
                    $query = "SELECT id_llamada, fecha, id_daño, id_est, descripcion, id_empleado FROM llamadas WHERE documento = ?";
                    $stmt = $con->prepare($query);
                    $stmt->bindParam(1, $documento, PDO::PARAM_STR);
                    $stmt->execute();
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    // Verificar si se encontraron resultados
                    foreach ($result as $row) {
                        $id_llamada = $row['id_llamada'];
                        $fecha = $row['fecha'];
                        $id_daño = $row['id_daño'];
                        $id_estado = $row['id_est'];
                        $descripcion = $row['descripcion'];
                        $id_empleado = $row['id_empleado'];

                        // Consulta para obtener el nombre del daño
                        $query_nombre = "SELECT nombredano FROM tipo_daño WHERE id_daño = ?";
                        $stmt_nombre = $con->prepare($query_nombre);
                        $stmt_nombre->bindParam(1, $id_daño, PDO::PARAM_INT);
                        $stmt_nombre->execute();
                        $nombre_daño = $stmt_nombre->fetchColumn();

                        // Definir el nombre del estado
                        if ($id_estado == 4 || $id_estado == 5) {
                            $tip_estado = "Aceptada";
                        } else {
                            $query_tip_est = "SELECT tip_est FROM estado WHERE id_est = ?";
                            $stmt_tip_est = $con->prepare($query_tip_est);
                            $stmt_tip_est->bindParam(1, $id_estado, PDO::PARAM_INT);
                            $stmt_tip_est->execute();
                            $tip_estado = $stmt_tip_est->fetchColumn();
                        }

                        // Verificar el estado y asignar la clase adecuada
                        $clase_estado = ($id_estado == 4 || $id_estado == 5) ? "badge-soft-success" : "badge-soft-danger";
                        $clase_icono = ($id_estado == 4 || $id_estado == 5) ? "mdi mdi-circle-medium text-success" : "mdi mdi-circle-medium text-danger";

                        ?>
                        <div class="col-md-6" id="project-items-1">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex mb-3">
                                        <div class="flex-grow-1 align-items-start">
                                            <div>
                                                <h6 class="mb-0 text-muted">
                                                    <i class="<?php echo $clase_icono; ?> fs-3 align-middle"></i>
                                                    <span class="team-date"><?php echo $fecha; ?></span>
                                                </h6>
                                            </div>
                                        </div>
                                        <div class="dropdown ms-2">
                                            <a href="#" class="dropdown-toggle font-size-16 text-muted"
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="mdi mdi-dots-horizontal"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="javascript:void(0);"
                                                    onclick="showDetails('<?php echo $descripcion; ?>', '<?php echo $id_empleado; ?>')">Descripcion</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <h5 class="mb-1 font-size-17 team-title"><?php echo $nombre_daño; ?></h5>

                                    </div>
                                    <div class="d-flex">
                                        <div class="align-self-end">
                                            <span
                                                class="badge <?php echo $clase_estado; ?> p-2 team-status"><?php echo $tip_estado; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    } // Cierre del foreach
                } // Cierre del if ($result)
                ?>
            </div>
            <div class="modal fade bs-example-new-project" tabindex="-1" role="dialog"
                aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Detalles de la llamada</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div id="descripcion"></div>
                        </div>
                    </div>
                </div>
            </div>




            <?php include "../Template/footer.php"; ?>