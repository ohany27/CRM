<?php include "../Template/header.php"; ?>
<?php
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
                <th>ID_Rol</th>
                <th>Nombre</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
            <?php
            $consulta = "SELECT * FROM roles";

            $resultado = $con->query($consulta);

            while ($fila = $resultado->fetch()) {
                echo '
                <tr>
                    <td>' . $fila["id_tip_usu"] . '</td>
                    <td>' . $fila["tip_usu"] . '</td>
                    <td class="project-actions text-center">
                          <a href="../Editar/roles.php?id=' . $fila["id_tip_usu"] . '" class="btn btn-info btn-sm" href="#">
                              <i class="fas fa-pencil-alt">
                              </i>
                              Editar
                          </a>
                          
                      </td>
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