<?php include "../Template/header.php"; ?>
<?php
require_once("../../../Config/conexion.php");
$DataBase = new Database;
$con = $DataBase->conectar();

// Obtener el NITC del usuario que ha iniciado sesión desde la sesión
$nitc_usuario = $_SESSION['usuario']['nitc'];

// Preparar la consulta SQL con una cláusula WHERE para filtrar según NITC
$consulta = "SELECT * FROM riesgos WHERE nitc = '$nitc_usuario'";
$resultado = $con->query($consulta);
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Riesgos Registrados</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"></h3>
                </div>
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Id_Riesgos</th>
                                <th>Tipo de Riesgos</th>
                                <th>Tiempo de atencion</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($fila = $resultado->fetch()) {
                                echo '
                                <tr>
                                    <td>' . $fila["id_riesgo"] . '</td>
                                    <td>' . $fila["tip_riesgo"] . '</td>
                                    <td>' . $fila["tiempo_atent"] . '</td>
                                    <td class="project-actions text-center">
                                        <a href="../Editar/riesgos.php?id_riesgo=' . $fila["id_riesgo"] . '" class="btn btn-info btn-sm" href="#">
                                            <i class="fas fa-pencil-alt"></i> Editar
                                        </a>
                                        <a href="../Eliminar/riesgos.php?id_riesgo=' . $fila["id_riesgo"] . '" class="btn btn-danger btn-sm" href="#">
                                            <i class="fas fa-trash"></i> Eliminar
                                        </a>
                                    </td>
                                </tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
<?php include "../Template/footer.php"; ?>
