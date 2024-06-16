<?php
include "../Template/header.php"; 
require_once ("../../../Config/conexion.php");
$DataBase = new Database;
$con = $DataBase->conectar();
// Consulta para obtener tickets sin fecha de finalización que ya han vencido
$consulta_notificaciones = "
    SELECT
        tecnico.nombre AS tecnico_nombre,
        tecnico.documento AS tecnico_documento,
        detalle_ticket.id_ticket,
        detalle_ticket.id_riesgo AS urgencia,
        CASE
            WHEN detalle_ticket.id_riesgo = 1 THEN DATE_ADD(detalle_ticket.fecha_inicio, INTERVAL 4 DAY)
            WHEN detalle_ticket.id_riesgo = 2 THEN DATE_ADD(detalle_ticket.fecha_inicio, INTERVAL 7 DAY)
            WHEN detalle_ticket.id_riesgo = 3 THEN DATE_ADD(detalle_ticket.fecha_inicio, INTERVAL 10 DAY)
        END AS fecha_vencimiento
    FROM
        detalle_ticket
        INNER JOIN usuario AS tecnico ON detalle_ticket.documento = tecnico.documento
    WHERE
        detalle_ticket.fecha_final IS NULL
        AND (
            (detalle_ticket.id_riesgo = 1 AND DATE_ADD(detalle_ticket.fecha_inicio, INTERVAL 4 DAY) < NOW()) OR
            (detalle_ticket.id_riesgo = 2 AND DATE_ADD(detalle_ticket.fecha_inicio, INTERVAL 7 DAY) < NOW()) OR
            (detalle_ticket.id_riesgo = 3 AND DATE_ADD(detalle_ticket.fecha_inicio, INTERVAL 10 DAY) < NOW())
        )";

$resultado_notificaciones = $con->query($consulta_notificaciones);

// Agrupar los resultados por técnico y urgencia
$notificaciones = [];
while ($fila = $resultado_notificaciones->fetch()) {
    $tecnico_nombre = $fila["tecnico_nombre"];
    $urgencia = $fila["urgencia"];
    $id_ticket = $fila["id_ticket"];

    if (!isset($notificaciones[$tecnico_nombre])) {
        $notificaciones[$tecnico_nombre] = [
            1 => [],
            2 => [],
            3 => []
        ];
    }

    $notificaciones[$tecnico_nombre][$urgencia][] = $id_ticket;
}

?>


?>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">SOLICITUDES EN PROCESO</h1>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Tickets vencidos</h3>
            </div>
            <div class="card-body">
                <?php
                // Mostrar las notificaciones resumidas
                foreach ($notificaciones as $tecnico => $tickets_por_urgencia) {
                    echo "<h4>Técnico: $tecnico</h4>";
                    foreach ($tickets_por_urgencia as $urgencia => $tickets) {
                        if (!empty($tickets)) {
                            $urgencia_text = '';
                            $color = '';
                            switch ($urgencia) {
                                case 1:
                                    $urgencia_text = '<span style="color: red;">Urgencia Alta</span>';
                                    break;
                                case 2:
                                    $urgencia_text = '<span style="color: orange;">Urgencia Media</span>';
                                    break;
                                case 3:
                                    $urgencia_text = '<span style="color: green;">Urgencia Baja</span>';
                                    break;
                            }
                            echo "<p>$urgencia_text: ";
                            foreach ($tickets as $ticket) {
                                echo "<span style='color: black;'>$ticket</span>, ";
                            }
                            echo "</p>";
                        }
                    }
                }
                ?>
            </div>
        </div>

      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Solicitudes en Proceso</h3>
        </div>
        <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
          <thead>
              <tr>
                  <th>N° de Ticket</th>
                  <th>Urgencia</th>
                  <th>Fecha y Hora inicialización</th>
                  <th>Fecha de Vencimiento</th>
                  <th>Técnico Asignado</th>
                  <th>Documento del Técnico</th>
                  <th>Cliente</th>
                  <th>Documento del Cliente</th>
                  <th>Tipo de Problema</th>
                  <th>Descripción</th>
                  <th>Estado</th>
              </tr>
          </thead>
          <tbody>
              <?php
              $consulta = "SELECT
                  detalle_ticket.id_ticket,
                  detalle_ticket.fecha_inicio,
                  CASE
                      WHEN detalle_ticket.id_riesgo = 1 THEN DATE_ADD(detalle_ticket.fecha_inicio, INTERVAL 4 DAY)
                      WHEN detalle_ticket.id_riesgo = 2 THEN DATE_ADD(detalle_ticket.fecha_inicio, INTERVAL 7 DAY)
                      WHEN detalle_ticket.id_riesgo = 3 THEN DATE_ADD(detalle_ticket.fecha_inicio, INTERVAL 10 DAY)
                  END AS fecha_vencimiento,
                  riesgos.tip_riesgo AS urgencia,
                  detalle_ticket.id_riesgo,  
                  tecnico.nombre AS tecnico_nombre,
                  tecnico.documento AS tecnico_documento,
                  usuario.nombre AS cliente, 
                  usuario.documento AS cliente_documento,
                  tipo_daño.nombredano AS tipo_problema, 
                  detalle_ticket.descripcion_detalle AS descripcion, 
                  estado.tip_est AS estado
              FROM
                  llamadas
                  INNER JOIN detalle_ticket ON llamadas.id_ticket = detalle_ticket.id_ticket
                  INNER JOIN usuario AS tecnico ON detalle_ticket.documento = tecnico.documento
                  INNER JOIN usuario ON llamadas.documento = usuario.documento
                  INNER JOIN tipo_daño ON llamadas.id_daño = tipo_daño.id_daño
                  INNER JOIN estado ON detalle_ticket.id_estado = estado.id_est
                  INNER JOIN riesgos ON detalle_ticket.id_riesgo = riesgos.id_riesgo
              WHERE
                  detalle_ticket.id_estado = 4
                  AND detalle_ticket.fecha_final IS NULL;";
              $resultado = $con->query($consulta);

              while ($fila = $resultado->fetch()) {
                  // Determinar el color según el nivel de urgencia para la fecha de finalización
                  $color_fecha_finalizacion = '';
                  switch ($fila["id_riesgo"]) {
                      case 1:
                          $color_fecha_finalizacion = 'red';
                          break;
                      case 2:
                          $color_fecha_finalizacion = 'yellow';
                          break;
                      case 3:
                          $color_fecha_finalizacion = 'green';
                          break;
                      default:
                          $color_fecha_finalizacion = 'black';
                          break;
                  }
                  echo '
                  <tr>
                      <td>' . $fila["id_ticket"] . '</td>
                      <td>' . $fila["urgencia"] . '</td>
                      <td>' . $fila["fecha_inicio"] . '</td>
                      <td style="color: ' . $color_fecha_finalizacion . ';">' . $fila["fecha_vencimiento"] . '</td>
                      <td>' . $fila["tecnico_nombre"] . '</td>
                      <td>' . $fila["tecnico_documento"] . '</td>
                      <td>' . $fila["cliente"] . '</td>
                      <td>' . $fila["cliente_documento"] . '</td>
                      <td>' . $fila["tipo_problema"] . '</td>
                      <td>' . $fila["descripcion"] . '</td>
                      <td>' . $fila["estado"] . '</td>
                  </tr>';
              }
              ?>
          </tbody>
        </table>

      </div>
    </div>
  </section>
</div>
<?php include "../Template/footer.php"; ?>
