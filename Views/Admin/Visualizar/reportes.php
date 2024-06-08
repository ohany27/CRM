<?php include "../Template/header.php"; ?>
<?php
require_once ("../../../Config/conexion.php");
$DataBase = new Database;
$con = $DataBase->conectar();

// Número de registros por página
$registros_por_pagina = 4;

// Página actual
$pagina_actual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

// Determinar el índice del primer registro de la página
$indice_inicial = ($pagina_actual - 1) * $registros_por_pagina;

// Obtener el número total de registros
$total_registros_sql = "SELECT COUNT(*) as total FROM llamadas";
$total_registros_result = $con->query($total_registros_sql);
$total_registros = $total_registros_result->fetch(PDO::FETCH_ASSOC)['total'];

// Obtener los datos de la tabla 'llamadas' junto con 'nombredano' de 'tipo_daño'
$query = "SELECT llamadas.*, tipo_daño.nombredano 
          FROM llamadas 
          JOIN tipo_daño ON llamadas.id_daño = tipo_daño.id_daño 
          LIMIT $indice_inicial, $registros_por_pagina";
$resultado = $con->query($query);

// Calcular el número total de páginas
$total_paginas = ceil($total_registros / $registros_por_pagina);
?>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Reportes</h1>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Llamadas</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th style="width: 10px">Progreso</th>
                <th>Daño</th>
                <th style="width: 40px">Detalle</th>
              </tr>
            </thead>
            <tbody>
              <?php
              while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) {
                $progreso = ($fila['id_est'] == 3) ? 50 : 100;
                $progreso_clase = ($fila['id_est'] == 3) ? "bg-warning" : "bg-success";
                ?>
                <tr>
                  <td><span class="badge <?php echo $progreso_clase; ?>"><?php echo $progreso; ?>%</span></td>
                  <td><?php echo $fila['nombredano']; ?></td>
                  <td>
                    <button class="btn btn-primary btn-sm ver-detalles"
                      data-id="<?php echo $fila['id_llamada']; ?>">Ver</button>
                  </td>
                </tr>
                <?php
              }
              ?>
            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
        <div class="card-footer clearfix">
          <ul class="pagination pagination-sm m-0 float-right">
            <?php if ($pagina_actual > 1): ?>
              <li class="page-item"><a class="page-link" href="?pagina=<?php echo $pagina_actual - 1; ?>">&laquo;</a></li>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
              <li class="page-item <?php echo ($i == $pagina_actual) ? 'active' : ''; ?>"><a class="page-link"
                  href="?pagina=<?php echo $i; ?>"><?php echo $i; ?></a></li>
            <?php endfor; ?>
            <?php if ($pagina_actual < $total_paginas): ?>
              <li class="page-item"><a class="page-link" href="?pagina=<?php echo $pagina_actual + 1; ?>">&raquo;</a></li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Tickets</h3>
        </div>
        <div class="card-header p-2">
          <ul class="nav nav-pills">
            <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Espera</a></li>
            <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Proceso</a></li>
            <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Finalizado</a></li>
          </ul>
        </div><!-- /.card-header -->
        <div class="card-body">
          <div class="tab-content">
            <div class="active tab-pane" id="activity">
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>ID Ticket</th>
                      <th>Estado</th>
                      <th>Riesgo</th>
                      <th>Empleado</th>
                      <th>Fecha</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    // Consulta SQL para obtener los registros según los criterios dados
                    $consulta = "SELECT dt.id_ticket, e.tip_est as estado, r.tip_riesgo as riesgo, dt.documento, dt.fecha_inicio
                    FROM detalle_ticket dt
                    INNER JOIN estado e ON dt.id_estado = e.id_est
                    LEFT JOIN riesgos r ON dt.id_riesgo = r.id_riesgo
                    WHERE dt.id_estado = 3
                    AND NOT EXISTS (
                        SELECT 1
                        FROM detalle_ticket dt2
                        WHERE dt2.id_ticket = dt.id_ticket
                        AND dt2.id_estado > 3
                    )";

                    // Ejecutar la consulta y mostrar los resultados en la tabla
                    $resultado = $con->query($consulta);
                    while ($fila = $resultado->fetch()) {
                      echo '
                <tr>
                    <td>' . $fila["id_ticket"] . '</td>
                    <td>' . $fila["estado"] . '</td>
                    <td>' . $fila["riesgo"] . '</td>
                    <td>' . $fila["documento"] . '</td>
                    <td>' . $fila["fecha_inicio"] . '</td>
                </tr>';
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="timeline">
              <div class="card-body">
                <table id="example2" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>ID Ticket</th>
                      <th>Estado</th>
                      <th>Riesgo</th>
                      <th>Tecnico Asignado</th>
                      <th>Descripción Detalle</th>
                      <th>Fecha</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $consulta = "SELECT dt.id_ticket, e.tip_est as estado, r.tip_riesgo as riesgo, dt.documento, dt.fecha_inicio, dt.descripcion_detalle
                  FROM detalle_ticket dt
                  INNER JOIN estado e ON dt.id_estado = e.id_est
                  LEFT JOIN riesgos r ON dt.id_riesgo = r.id_riesgo
                  WHERE dt.id_estado = 4
                  AND NOT EXISTS (
                      SELECT 1
                      FROM detalle_ticket dt2
                      WHERE dt2.id_ticket = dt.id_ticket
                      AND dt2.id_estado > 4
                  )";

                    $resultado = $con->query($consulta);
                    while ($fila = $resultado->fetch()) {
                      echo '
        <tr>
            <td>' . $fila["id_ticket"] . '</td>
            <td>' . $fila["estado"] . '</td>
            <td>' . $fila["riesgo"] . '</td>
            <td>' . $fila["documento"] . '</td>
            <td>' . $fila["descripcion_detalle"] . '</td>
            <td>' . $fila["fecha_inicio"] . '</td>
        </tr>';
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- /.tab-pane -->

            <div class="tab-pane" id="settings">
              <div class="card-body">
                <table id="example3" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>ID Ticket</th>
                      <th>Estado</th>
                      <th>Riesgo</th>
                      <th>Empleado</th>
                      <th>Descripción Detalle</th>
                      <th>Fecha</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $consulta = "SELECT dt.id_ticket, e.tip_est as estado, r.tip_riesgo as riesgo, dt.documento, dt.fecha_inicio, dt.descripcion_detalle
                  FROM detalle_ticket dt
                  INNER JOIN estado e ON dt.id_estado = e.id_est
                  LEFT JOIN riesgos r ON dt.id_riesgo = r.id_riesgo
                  WHERE dt.id_estado = 5";

                    $resultado = $con->query($consulta);
                    while ($fila = $resultado->fetch()) {
                      echo '
        <tr>
            <td>' . $fila["id_ticket"] . '</td>
            <td>' . $fila["estado"] . '</td>
            <td>' . $fila["riesgo"] . '</td>
            <td>' . $fila["documento"] . '</td>
            <td>' . $fila["descripcion_detalle"] . '</td>
            <td>' . $fila["fecha_inicio"] . '</td>
        </tr>';
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- /.tab-pane -->
          </div>
          <!-- /.tab-content -->
        </div><!-- /.card-body -->
      </div>
    </div>
  </section>
</div>

<!-- Modal -->
<div class="modal fade" id="detallesModal" tabindex="-1" role="dialog" aria-labelledby="detallesModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detallesModalLabel">Detalles de la Llamada</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Aquí se cargarán los detalles de la llamada -->
        <table class="table table-bordered">
          <tbody id="detallesLlamada">
            <!-- Contenido dinámico -->
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="imprimirDetalles()">Imprimir</button>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".ver-detalles").forEach(function (button) {
      button.addEventListener("click", function () {
        var idLlamada = this.getAttribute("data-id");
        // Hacer una petición AJAX para obtener los detalles
        fetch("obtener_detalles_llamada.php?id_llamada=" + idLlamada)
          .then(response => response.json())
          .then(data => {
            var detallesHtml = `
                        <tr><th>ID Ticket</th><td>${data.id_ticket}</td></tr>
                        <tr><th>ID Cliente</th><td>${data.documento}</td></tr>
                        <tr><th>Fecha</th><td>${data.fecha}</td></tr>
                        <tr><th>Descripción</th><td>${data.descripcion}</td></tr>
                        <tr><th>ID Empleado</th><td>${data.id_empleado}</td></tr>
                    `;
            document.getElementById("detallesLlamada").innerHTML = detallesHtml;
            $("#detallesModal").modal("show");
          });
      });
    });
  });

  function imprimirDetalles() {
    var contenido = document.getElementById("detallesLlamada").innerHTML;
    var ventana = window.open('', 'PRINT', 'height=400,width=600');
    ventana.document.write('<html><head><title>Detalles de la Llamada</title>');
    ventana.document.write('</head><body>');
    ventana.document.write('<h1>Detalles de la Llamada</h1>');
    ventana.document.write(contenido);
    ventana.document.write('</body></html>');
    ventana.document.close();
    ventana.focus();
    ventana.print();
    ventana.close();
  }
</script>

<?php include "../Template/footer.php"; ?>