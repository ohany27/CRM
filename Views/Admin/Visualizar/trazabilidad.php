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

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Fechas</h3>
                </div>
                <div class="card-body">
                    <form method="post">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="fecha_inicio">Fecha de Inicio:</label>
                                    <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio"
                                        value="<?php echo $fecha_inicio; ?>">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="fecha_fin">Fecha Fin:</label>
                                    <input type="date" class="form-control" id="fecha_fin" name="fecha_fin"
                                        value="<?php echo $fecha_fin; ?>">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Filtrar</button>
                        <br><br>
                    </form>
                    <?php if (!empty($fecha_detalle_tickets)): ?>
                        <table id="example1" class="table table-bordered table-striped">
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

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detalle Tickets</h3>
                    <button class="btn btn-primary float-right" onclick="window.print()">Imprimir</button>
                </div>
                <?php
                // Agrupar detalle_tickets por id_ticket
                $grouped_tickets = [];
                foreach ($detalle_tickets as $detalle_ticket) {
                    $grouped_tickets[$detalle_ticket['id_ticket']][] = $detalle_ticket;
                }

                // Parámetros de paginación
                $items_per_page = 4; // Dos id_ticket por página
                $total_items = count($grouped_tickets); // Total de grupos
                $total_pages = ceil($total_items / $items_per_page); // Total de páginas
                
                // Obtener la página actual de la URL, por defecto es la primera página
                $current_page = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;
                $current_page = max(1, min($current_page, $total_pages)); // Asegurarse de que la página actual esté dentro del rango
                
                // Calcular el índice inicial y final de los elementos en la página actual
                $start_index = ($current_page - 1) * $items_per_page;
                $end_index = min($start_index + $items_per_page - 1, $total_items - 1);

                // Obtener los elementos para la página actual
                $current_items = array_slice($grouped_tickets, $start_index, $items_per_page, true);
                ?>

                <?php if (!empty($current_items)): ?>
                    <div class="card-body p-0">
                        <table class="table table-hover">
                            <tbody>
                                <?php foreach ($current_items as $id_ticket => $detalles): ?>
                                    <tr data-widget="expandable-table" aria-expanded="false">
                                        <td>
                                            <i class="expandable-table-caret fas fa-caret-right fa-fw"></i>
                                            Ticket <?php echo $id_ticket; ?>
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
                                                        <?php foreach ($detalles as $detalle_ticket): ?>
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
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card -->

                    <!-- Paginación -->
                    <div class="card-footer clearfix">
                        <ul class="pagination pagination-sm m-0 float-right">
                            <?php if ($current_page > 1): ?>
                                <li class="page-item"><a class="page-link"
                                        href="?pagina=<?php echo $current_page - 1; ?>">&laquo;</a></li>
                            <?php endif; ?>
                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <li class="page-item <?php echo ($i == $current_page) ? 'active' : ''; ?>">
                                    <a class="page-link" href="?pagina=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>
                            <?php if ($current_page < $total_pages): ?>
                                <li class="page-item"><a class="page-link"
                                        href="?pagina=<?php echo $current_page + 1; ?>">&raquo;</a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                <?php else: ?>
                    <p>No se encontraron tickets para mostrar.</p>
                <?php endif; ?>


            </div>



        </div>
    </section>
</div>

<?php include "../Template/footer.php"; ?>