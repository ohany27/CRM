<?php 
include "../Template/header.php"; 
require_once ("../../../Config/conexion.php");
$DataBase = new Database;
$con = $DataBase->conectar();

// Verificar si la sesión está iniciada y 'usuario' está definido antes de acceder a 'documento'
if (isset($_SESSION['usuario']) && isset($_SESSION['usuario']['documento'])) {
    $nitc_usuario = $_SESSION['usuario']['documento'];

    // Consulta SQL para seleccionar los datos de la tabla detalle_ticket, la tabla llamadas, la tabla usuario, la tabla riesgos y la tabla tipo_dano
    $query = "SELECT llamadas.*, detalle_ticket.id_ticket, usuario.nombre AS cliente, usuario.direccion, estado.tip_est, riesgos.tip_riesgo, detalle_ticket.descripcion_detalle, tipo_daño.nombredano AS tipo_de_problema
          FROM llamadas 
          INNER JOIN detalle_ticket ON llamadas.id_ticket = detalle_ticket.id_ticket
          INNER JOIN usuario ON llamadas.documento = usuario.documento
          INNER JOIN estado ON detalle_ticket.id_estado = estado.id_est
          INNER JOIN riesgos ON llamadas.id_daño = riesgos.id_riesgo
          INNER JOIN tipo_daño ON llamadas.id_daño = tipo_daño.id_daño
          WHERE detalle_ticket.id_estado = 4 AND detalle_ticket.documento = :documento
          AND NOT EXISTS (
              SELECT 1 FROM detalle_ticket 
              WHERE detalle_ticket.id_ticket = llamadas.id_ticket 
              AND detalle_ticket.id_estado = 5
          )";
    $stmt = $con->prepare($query);
    $stmt->bindParam(':documento', $nitc_usuario);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
          <h1 class="m-0">Solicitudes En curso</h1>
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
                <th>Dirección</th>
                <th>Fecha</th>
                <th>Descripción</th>
                <th>Estado</th>
                <th>Riesgo</th>
                <th>Tipo de Problema</th>
                <th>Acción</th> <!-- Agregamos una columna para el botón -->
              </tr>
            </thead>
            <tbody>
              <?php
              // Iterar sobre los resultados de la consulta y mostrar cada fila en la tabla
              if (isset($result)) {
                  foreach ($result as $row) {
                      echo '<tr>';
                      echo '<td>' . $row['id_ticket'] . '</td>';
                      echo '<td>' . $row['cliente'] . '</td>';
                      echo '<td>' . $row['direccion'] . '</td>';
                      echo '<td>' . $row['fecha'] . '</td>';
                      echo '<td>' . $row['descripcion_detalle'] . '</td>';
                      echo '<td>' . $row['tip_est'] . '</td>';
                      echo '<td>' . $row['tip_riesgo'] . '</td>';
                      echo '<td>' . $row['tipo_de_problema'] . '</td>';
                      echo '<td><button class="btn btn-primary btn-open-modal" data-toggle="modal" data-target="#modalAgregarRegistro" data-ticket="' . $row['id_ticket'] . '">solucionar </button></td>'; // Agregamos un botón con clase btn-open-modal y data-ticket que contiene el id del ticket
                      echo '</tr>';
                  }
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </section>
  </div>

<!-- Modal -->
<div class="modal fade" id="modalAgregarRegistro" tabindex="-1" role="dialog" aria-labelledby="modalAgregarRegistroLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalAgregarRegistroLabel">Agregar Registro</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formAgregarRegistro" action="agregar_registro.php" method="POST">
          <input type="hidden" id="modal-ticket-id" name="id_ticket" value="">
          <input type="hidden" name="documento" value="<?php echo $nitc_usuario; ?>">
          <input type="hidden" id="modal-riesgo-id" name="id_riesgo" value="">
          <input type="hidden" id="modal-riesgo-id" name="id_riesgo" value="">
          <input type="hidden" id="fecha-inicio" name="fecha_inicio" value="">
          <input type="hidden" id="fecha-final" name="fecha_final" value="">
          <input type="hidden" name="id_estado" value="5">
          <div class="form-group">
            <label for="descripcion_detalle">Descripción Detalle</label>
            <textarea class="form-control" id="descripcion_detalle" name="descripcion_detalle" rows="3"></textarea>
          </div>
          <button type="submit" class="btn btn-primary" id="btn-finalizar" disabled>Finalizar</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include "../Template/footer.php"; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  // JavaScript para manejar el clic en el botón y configurar los campos ocultos en la ventana modal
  $(document).on("click", ".btn-open-modal", function () {
    var ticketId = $(this).data('ticket');
    $("#modal-ticket-id").val(ticketId);
    var riesgoId = $(this).closest('tr').find('td:eq(6)').text(); // Suponiendo que la columna del riesgo es la séptima (índice 6)
    $("#modal-riesgo-id").val(riesgoId);
    var fechaInicio = $(this).closest('tr').find('td:eq(3)').text(); // Suponiendo que la columna de la fecha es la cuarta (índice 3)
    $("#fecha-inicio").val(fechaInicio);
    $("#fecha-final").val(""); // Reiniciamos la fecha final
    $("#btn-finalizar").prop("disabled", true); // Deshabilitamos el botón Finalizar
  });

  // JavaScript para manejar la actualización de la fecha final al hacer clic en el botón Finalizar
  $(document).on("click", "#btn-finalizar", function () {
    var fechaFinal = new Date().toISOString().slice(0, 19).replace('T', ' '); // Obtiene la fecha y hora actual en formato yyyy-mm-dd HH:MM:SS
    $("#fecha-final").val(fechaFinal);
  });
  
  // JavaScript para habilitar el botón Finalizar cuando se ingresa una descripción en el textarea
  $(document).on("input", "#descripcion_detalle", function () {
    var descripcion = $(this).val().trim();
    if (descripcion !== "") {
      $("#btn-finalizar").prop("disabled", false);
    } else {
      $("#btn-finalizar").prop("disabled", true);
    }
  });
</script>
