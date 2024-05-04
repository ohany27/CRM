<?php include "../Template/header.php"; ?>
<?php
require_once ("../../../Config/conexion.php");
$DataBase = new Database;
$con = $DataBase->conectar();
?>
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Usuarios Registrados</h1>
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
                <th>Documento</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>Dirección</th>
                <th>NITC</th>
                <th>Tipo Usuario</th>
                <th></th>
              </tr>
            </thead>
            <tbody>

              <?php
              $consulta = "SELECT * FROM usuario INNER JOIN roles ON usuario.id_tip_usu = roles.id_tip_usu ";
              $resultado = $con->query($consulta);

              while ($fila = $resultado->fetch()) {
                echo '
                <tr>
                    <td>' . $fila["documento"] . '</td>
                    <td>' . $fila["nombre"] . '</td>
                    <td>' . (isset($fila["correo"]) ? $fila["correo"] : '') . '</td>
                    <td>' . $fila["telefono"] . '</td>
                    <td>' . $fila["direccion"] . '</td>
                    <td>' . ($fila["nitc"])  . '</td>
                    <td>' . (isset($fila["tip_usu"]) ? $fila["tip_usu"] : 'Valor predeterminado') . '</td>
                    <td class="project-actions text-center">
                          <a href="../Editar/usuarios.php?id=' . $fila['documento'] . '" class="btn btn-info btn-sm" href="#">
                              <i class="fas fa-pencil-alt">
                              </i>
                              Editar
                          </a>
                          <a href="../Eliminar/usuarios.php?id=' . $fila['documento'] . '" class="btn btn-danger btn-sm" href="#">
                              <i class="fas fa-trash">
                              </i>
                              Eliminar
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