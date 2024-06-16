<?php include "../Template/header.php"; ?>
<?php
require_once("../../../Config/conexion.php");


$DataBase = new Database;
$con = $DataBase->conectar();

$nitc_usuario = $_SESSION['usuario']['nitc']; // Obtener el nitc del usuario logueado
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Detalle Registrados</h1>
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
                                <th>Nombre Daño</th>
                                <th>Solucion</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $consulta = "SELECT detalle_daño.id_detalle_daño, tipo_daño.nombredano, detalle_daño.pasos_solucion 
                                        FROM detalle_daño 
                                        INNER JOIN tipo_daño ON detalle_daño.id_daño = tipo_daño.id_daño
                                        WHERE tipo_daño.nitc = :nitc_usuario"; // Añadida la condición WHERE
                            $stmt = $con->prepare($consulta);
                            $stmt->bindParam(':nitc_usuario', $nitc_usuario, PDO::PARAM_STR); // Vincular el parámetro
                            $stmt->execute();

                            while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo '
                                <tr>
                                    <td>' . htmlspecialchars($fila["nombredano"]) . '</td>
                                    <td>' . htmlspecialchars($fila["pasos_solucion"]) . '</td>
                                    <td class="project-actions text-center">
                                        <a href="../Editar/daño_detalle.php?id_detalle_daño=' . htmlspecialchars($fila["id_detalle_daño"]) . '" class="btn btn-info btn-sm">
                                            <i class="fas fa-pencil-alt"></i> Editar
                                        </a>
                                        <a href="../Eliminar/daño_detalle.php?id_detalle_daño=' . htmlspecialchars($fila["id_detalle_daño"]) . '" class="btn btn-danger btn-sm">
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
