<?php
include "../Template/header.php";
require_once("../../../Config/conexion.php");

$DataBase = new Database;
$con = $DataBase->conectar();

// Verificar si la sesión está iniciada y 'usuario' está definido antes de acceder a 'documento'
if (isset($_SESSION['usuario']) && isset($_SESSION['usuario']['documento'])) {
    $nitc_usuario = $_SESSION['usuario']['documento'];

    // Consulta SQL para seleccionar los registros deseados y hacer JOIN con las tablas estados, llamadas, tipo_daño y usuario
    $query = "SELECT dt.id_detalle_ticket, dt.id_ticket, dt.id_estado, dt.documento, dt.id_riesgo, dt.fecha_inicio, dt.fecha_final, dt.descripcion_detalle, e.tip_est, ld.id_daño, td.nombredano, u.nombre as nombre_cliente, u.documento as documento_cliente
              FROM detalle_ticket dt
              INNER JOIN estado e ON dt.id_estado = e.id_est
              LEFT JOIN llamadas ld ON dt.id_ticket = ld.id_ticket
              LEFT JOIN tipo_daño td ON ld.id_daño = td.id_daño
              LEFT JOIN usuario u ON ld.documento = u.documento
              WHERE dt.id_estado = 5
              AND dt.documento = :documento";

    $stmt = $con->prepare($query);
    $stmt->bindParam(':documento', $nitc_usuario, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Solicitudes Solucionadas</h1>
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
                                <th>N° de Ticket</th>
                                <th>Estado</th>
                                <th>Cliente Nombre</th>
                                <th>Cliente Documento</th>
                                <th>Daño</th>
                                <th>Fecha Final</th>
                                <th>Tipo de Descripción Detalle</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Iterar sobre los resultados de la consulta y mostrar cada fila en la tabla
                            if (isset($result)) {
                                foreach ($result as $row) {
                                    echo "<tr>";
                                    echo "<td>".$row['id_ticket']."</td>";
                                    echo "<td>".$row['tip_est']."</td>";
                                    echo "<td>".$row['nombre_cliente']."</td>";
                                    echo "<td>".$row['documento_cliente']."</td>";
                                    echo "<td>".$row['nombredano']."</td>";
                                    echo "<td>".$row['fecha_final']."</td>";
                                    echo "<td>".$row['descripcion_detalle']."</td>";
                                    echo "</tr>";
                                }
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
