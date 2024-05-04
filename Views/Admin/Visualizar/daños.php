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
                    <h1 class="m-0">Daños Registrados</h1>
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
                                <th>Id_Daños</th>
                                <th>Tipos de Daños</th>
                                <th>Precio</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $consulta = "SELECT * FROM tipo_daño";
                            $resultado = $con->query($consulta);

                            while ($fila = $resultado->fetch()) {
                                echo '
                                <tr>
                                <td>' . $fila["id_daño"] . '</td>
                                <td>' . $fila["nombre"] . '</td>
                                <td>' . $fila["precio"] . '</td>
                    <td class="project-actions text-center">
                            <a href="../Editar/daños.php?id_daño=' . $fila["id_daño"] . '" class="btn btn-info btn-sm" href="#">
                                <i class="fas fa-pencil-alt">
                                </i>
                                Editar
                            </a>
                            <a href="../Eliminar/daños.php?id_daño=' . $fila["id_daño"] . '" class="btn btn-danger btn-sm" href="#">
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