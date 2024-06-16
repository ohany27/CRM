<?php
include "../Template/header.php";
require_once("../../../Config/conexion.php");

$DataBase = new Database;
$con = $DataBase->conectar();

// Verificar si la sesión está iniciada y 'usuario' está definido antes de acceder a 'documento'
if (isset($_SESSION['usuario']) && isset($_SESSION['usuario']['documento'])) {
    $nitc_usuario = $_SESSION['usuario']['documento'];

    try {
        // Consulta SQL para seleccionar los datos incluyendo la fecha_final de detalle_ticket
        $query = "SELECT llamadas.*, detalle_ticket.id_ticket, usuario.nombre AS cliente, usuario.direccion, estado.tip_est, riesgos.tip_riesgo, detalle_ticket.descripcion_detalle, tipo_daño.nombredano AS tipo_de_problema, detalle_ticket.fecha_final
                FROM llamadas 
                INNER JOIN detalle_ticket ON llamadas.id_ticket = detalle_ticket.id_ticket
                INNER JOIN usuario ON llamadas.documento = usuario.documento
                INNER JOIN estado ON detalle_ticket.id_estado = estado.id_est
                INNER JOIN riesgos ON llamadas.id_daño = riesgos.id_riesgo
                INNER JOIN tipo_daño ON llamadas.id_daño = tipo_daño.id_daño
                WHERE detalle_ticket.id_estado = 5 AND detalle_ticket.documento = :documento";

        $stmt = $con->prepare($query);
        $stmt->bindParam(':documento', $nitc_usuario);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Verificar los resultados obtenidos
        // var_dump($result); // Puedes usar var_dump para depurar

    } catch (PDOException $e) {
        echo "Error en la consulta: " . $e->getMessage();
    }
} else {
    // Manejo del caso en que la sesión no esté iniciada o 'documento' no esté definido
    echo "No se pudo obtener el documento del usuario.";
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
                                <th>Cliente</th>
                                <th>Fecha finalizado</th>
                                <th>Descripcion</th>
                                <th>Estado</th>
                                <th>Riesgo</th>
                                <th>Tipo de Problema</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Iterar sobre los resultados de la consulta y mostrar cada fila en la tabla
                            if (isset($result)) {
                                foreach ($result as $row) {
                                    echo '<tr>';
                                    echo '<td>' . htmlspecialchars($row['id_ticket']) . '</td>';
                                    echo '<td>' . htmlspecialchars($row['cliente']) . '-' . htmlspecialchars($row['documento']) .  '</td>';
                                    echo '<td>' . htmlspecialchars($row['fecha_final']) . '</td>'; // Mostrar fecha_final aquí
                                    echo '<td>' . htmlspecialchars($row['descripcion_detalle']) . '</td>';
                                    echo '<td>' . htmlspecialchars($row['tip_est']) . '</td>';
                                    echo '<td>' . htmlspecialchars($row['tip_riesgo']) . '</td>';
                                    echo '<td>' . htmlspecialchars($row['tipo_de_problema']) . '</td>';
                                    echo '</tr>';
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
