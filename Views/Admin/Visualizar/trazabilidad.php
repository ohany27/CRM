<?php include "../Template/header.php"; ?>
<?php
require_once ("../../../Config/conexion.php");

$DataBase = new Database;
$con = $DataBase->conectar();

// Obtener el NITC del usuario en sesión
$nitc_usuario = $_SESSION['usuario']['nitc'];

// Manejo del formulario de fechas
$fecha_inicio = $_POST['fecha_inicio'] ?? '';
$fecha_fin = $_POST['fecha_fin'] ?? '';

// Validar que la fecha de fin no sea menor que la fecha de inicio
if (!empty($fecha_inicio) && !empty($fecha_fin) && $fecha_fin < $fecha_inicio) {
    echo "<script>alert('La fecha de final no puede ser menor a la fecha de inicio.')</script>";
} else {
    // Consulta SQL ajustada para obtener detalles del ticket
    $detalle_ticket_sql = "
        SELECT dt.id_ticket, dt.id_estado, dt.documento, dt.id_riesgo, DATE(dt.fecha_inicio) AS fecha_inicio, DATE(dt.fecha_final) AS fecha_final, dt.descripcion_detalle
        FROM detalle_ticket dt
        INNER JOIN usuario u ON dt.documento = u.documento
        WHERE u.nitc = :nitc_usuario
        ORDER BY dt.id_ticket
    ";

    $stmt = $con->prepare($detalle_ticket_sql);
    $stmt->bindParam(':nitc_usuario', $nitc_usuario, PDO::PARAM_STR);
    $stmt->execute();
    $detalle_tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Si las fechas son válidas, ejecutar la consulta SQL con las fechas
    if (!empty($fecha_inicio) && !empty($fecha_fin)) {
        $fecha_detalle_sql = "
            SELECT dt.id_ticket, dt.id_estado, dt.documento, dt.id_riesgo, DATE(dt.fecha_inicio) AS fecha_inicio, DATE(dt.fecha_final) AS fecha_final, dt.descripcion_detalle
            FROM detalle_ticket dt
            INNER JOIN usuario u ON dt.documento = u.documento
            WHERE u.nitc = :nitc_usuario
            AND DATE(dt.fecha_inicio) >= :fecha_inicio
            AND DATE(dt.fecha_inicio) <= :fecha_fin
            ORDER BY dt.id_ticket
        ";

        $fecha_stmt = $con->prepare($fecha_detalle_sql);
        $fecha_stmt->bindParam(':nitc_usuario', $nitc_usuario, PDO::PARAM_STR);
        $fecha_stmt->bindParam(':fecha_inicio', $fecha_inicio, PDO::PARAM_STR);
        $fecha_stmt->bindParam(':fecha_fin', $fecha_fin, PDO::PARAM_STR);
        $fecha_stmt->execute();
        $fecha_detalle_tickets = $fecha_stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>



<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Trazabilidad Completa</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <?php if (!empty($detalle_tickets)): ?>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Detalle Tickets</h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-hover">
                            <tbody>
                                <?php
                                $current_ticket_id = null;
                                foreach ($detalle_tickets as $detalle_ticket):
                                    // Verificar si hay un cambio en el id_ticket
                                    if ($detalle_ticket['id_ticket'] !== $current_ticket_id):
                                        // Cerrar la fila anterior si hay una abierta
                                        if ($current_ticket_id !== null):
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php endif; ?>
                                <tr data-widget="expandable-table" aria-expanded="false">
                                    <td>
                                        <i class="expandable-table-caret fas fa-caret-right fa-fw"></i>
                                        Ticket <?php echo $detalle_ticket['id_ticket']; ?>
                                    </td>
                                </tr>
                                <tr class="expandable-body">
                                    <td>
                                        <div class="p-0">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Estado</th>
                                                        <th>Documento</th>
                                                        <th>ID Riesgo</th>
                                                        <th>Fecha Inicio</th>
                                                        <th>Fecha Final</th>
                                                        <th>Descripción Detalle</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                        <?php
                                        // Actualizar el id_ticket actual
                                        $current_ticket_id = $detalle_ticket['id_ticket'];
                                    endif;
                                    ?>
                                    <tr>
                                        <td><?php echo $detalle_ticket['id_estado']; ?></td>
                                        <td><?php echo $detalle_ticket['documento']; ?></td>
                                        <td><?php echo $detalle_ticket['id_riesgo']; ?></td>
                                        <td><?php echo $detalle_ticket['fecha_inicio']; ?></td>
                                        <td><?php echo $detalle_ticket['fecha_final']; ?></td>
                                        <td><?php echo $detalle_ticket['descripcion_detalle']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- /.card -->
<?php else: ?>
    <p>No se encontraron tickets para mostrar.</p>
<?php endif; ?>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Fechas</h3>
    </div>
    <div class="card-body">
        <form method="post">
            <div class="form-group">
                <label for="fecha_inicio">Fecha de Inicio:</label>
                <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" value="<?php echo $fecha_inicio; ?>">
            </div>
            <div class="form-group">
                <label for="fecha_fin">Fecha Fin:</label>
                <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" value="<?php echo $fecha_fin; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Filtrar</button>
        </form>
        <?php if (!empty($fecha_detalle_tickets)): ?>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Ticket</th>
                        <th>Estado</th>
                        <th>Documento</th>
                        <th>ID Riesgo</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Final</th>
                        <th>Descripción Detalle</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($fecha_detalle_tickets as $ticket): ?>
                        <tr>
                            <td><?php echo $ticket['id_ticket']; ?></td>
                            <td><?php echo $ticket['id_estado']; ?></td>
                            <td><?php echo $ticket['documento']; ?></td>
                            <td><?php echo $ticket['id_riesgo']; ?></td>
                            <td><?php echo $ticket['fecha_inicio']; ?></td>
                            <td><?php echo $ticket['fecha_final']; ?></td>
                            <td><?php echo $ticket['descripcion_detalle']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No se encontraron tickets para el rango de fechas seleccionado.</p>
        <?php endif; ?>
    </div>
</div>

</div>
</section>
</div>

<?php include "../Template/footer.php"; ?>
