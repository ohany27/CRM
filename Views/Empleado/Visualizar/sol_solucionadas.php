<?php
include "../Template/header.php"; 
require_once ("../../../Config/conexion.php");
$DataBase = new Database;
$con = $DataBase->conectar();
?>
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">SOLICITUDES SOLUCIONADAS</h1>
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
                <th>Fecha y Hora Finalizacion</th>
                <th>Cliente</th>
                <th>Documento</th>
                <th>Tipo de Problema</th>
                <th>Descripcion</th>
                <th>Estado</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $consulta = "SELECT DISTINCT llamadas.id_llamada,
               detalle_ticket.id_ticket, 
               detalle_ticket.fecha_final, 
               usuario.nombre AS cliente, 
               usuario.documento, 
               tipo_daño.nombredano AS tipo_problema, 
               tipo_daño.id_daño, 
               detalle_ticket.descripcion_detalle AS descripcion, 
               estado.tip_est AS estado
              FROM llamadas
              INNER JOIN detalle_ticket ON llamadas.id_ticket = detalle_ticket.id_ticket
              INNER JOIN usuario ON llamadas.documento = usuario.documento
              INNER JOIN tipo_daño ON llamadas.id_daño = tipo_daño.id_daño
              INNER JOIN estado ON detalle_ticket.id_estado = estado.id_est
              WHERE detalle_ticket.id_estado = 5;";
              $resultado = $con->query($consulta);

              while ($fila = $resultado->fetch()) {
                  echo '
                  <tr>
                      <td>' . $fila["id_ticket"] . '</td>
                      <td>' . $fila["fecha_final"] . '</td>
                      <td>' . $fila["cliente"] . '</td>
                      <td>' . $fila["documento"] . '</td>
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
