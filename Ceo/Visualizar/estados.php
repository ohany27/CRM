<?php
include "../Template/header.php";
require_once("../../Config/conexion.php");
$DataBase = new Database;
$con = $DataBase->conectar();

// Verificar si la cookie de acceso está presente y tiene el valor esperado
if (!isset($_COOKIE['acceso_permitido']) || $_COOKIE['acceso_permitido'] !== 'true') {
  // Redirigir a la página de inicio si la cookie no está presente o no tiene el valor correcto
  echo "<script>alert('Ingresa primero en el panel Ceo.');window.location='../index.php';</script>";
  exit();
}
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Estados Registrados</h1>
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
                            $consulta = "SELECT * FROM estado WHERE estado.id_est ";

                            $resultado = $con->query($consulta);
                            while ($fila = $resultado->fetch()) {
                                echo '
                <tr>
                <td>' . $fila["id_est"] . '</td>
                <td>' . $fila["tip_est"] . '</td>
                    <td class="project-actions text-center">
                            <a href="../Editar/estados.php?id=' . $fila["id_est"] . '" class="btn btn-info btn-sm" href="#">
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