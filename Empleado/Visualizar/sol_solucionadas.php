<?php 
include "../Template/header.php"; 
require_once ("../../Config/conexion.php");
$DataBase = new Database;
$con = $DataBase->conectar();
?>
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Roles Registrados</h1>
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
                <th>N° de Llamada</th>
                <th>N° de Ticket</th> 
                <th>Fecha finalizado</th>
                <th>Cliente</th>
                <th>Documento</th>
                <th>Tipo de Problema</th>
                <th>Descripcion</th>
                <th>Estado</th>
              </tr>
            </thead>
            <tbody>
            <?php
            // Consulta de Empleados
            $consulta = "SELECT * FROM detalle_ticket, ticket, llamadas, usuario, tipo_daño, estado
            WHERE detalle_ticket.id_ticket = ticket.id_ticket 
            AND ticket.id_llamada = llamadas.id_llamada
            AND ticket.id_estado = estado.id_est
            AND llamadas.id_daño = tipo_daño.id_daño
            AND llamadas.documento = usuario.documento
            AND ticket.id_estado = 5 ";
            $resultado = $con->query($consulta);

            while ($fila = $resultado->fetch()) {
                echo '
                <tr>
                    <td>' . $fila["id_llamada"] . '</td>
                    <td>' . $fila["id_ticket"] . '</td>
                    <td>' . $fila["fecha"] . '</td>
                    <td>' . $fila["nombre"] . '</td>
                    <td>' . $fila["documento"] . '</td>
                    <td>' . $fila["nombredano"] . '</td>
                    <td>' . $fila["descripcion"] . '</td>
                    <td>' . $fila["tip_est"] . '</td>
                </tr>';
            }
            ?>
        </tbody>
            </tbody>
          </table>
        </div>
      </div>
  </section>
</div>
<?php include "../Template/footer.php"; ?>