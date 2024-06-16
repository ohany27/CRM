<?php
include("../../Config/validarSesion.php");
require_once("../../Config/conexion.php");
$DataBase = new Database;
$con = $DataBase->conectar();



?>

<?php include "../Template/header.php"; ?>

<div class="container mt-5">
    <h1 class="text-center">Tipos de daños</h1>
    <table class="table table-bordered">
        <thead class="table-primary">
            <tr>
                <th>Id_Daños</th>
                <th>Tipos de Daños</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Consulta de Empleados
            $consulta = "SELECT * FROM tipo_daño";
            $resultado = $con->query($consulta);

            while ($fila = $resultado->fetch()) {
                echo '
                <tr>
                    <td>' . $fila["id_daño"] . '</td>
                    <td>' . $fila["nombre"] . '</td>
                    <td>
                        <div class="text-center">
                            <a href="../Actualizar/editar_tip_daño.php?id_daño=' . $fila["id_daño"] . '" class="btn btn-primary btn-sm">Editar</a>
                            <a href="../Eliminar/eliminar_tip_daño.php?id_daño=' . $fila["id_daño"] . '" class="btn btn-danger btn-sm">Eliminar</a>
                        </div>
                    </td>
                </tr>';
            }
            ?>
        </tbody>
    </table>
    <div class="row mt-3">
    </div>
</div>
<?php include "../Template/footer.php"; ?>