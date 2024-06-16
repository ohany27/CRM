<?php
include("../../Config/validarSesion.php");
    require_once("../../Config/conexion.php");
    $DataBase = new Database;
    $con = $DataBase -> conectar();
?>

<?php include "../Template/header.php"; ?>

<div class="container mt-5">
    <h1 class="text-center">Detalles de daños</h1>
    <table class="table table-bordered">
        <thead class="table-primary">
            <tr>
                <th>Id detalle del daño</th>
                <th>Id del daño</th>
                <th>Solución</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $consulta = "SELECT * FROM detalle_daño, tipo_daño WHERE detalle_daño.id_daño = tipo_daño.id_daño";
            $resultado = $con->query($consulta);

            while ($fila = $resultado->fetch()) {
                echo '
                <tr>
                    <td>' . $fila["id_detalle_daño"] . '</td>
                    <td>' . $fila["nombre"] . '</td>
                    <td>' . $fila["pasos_solucion"] . '</td>
                    <td>
                        <div class="text-center">
                            <a href="../Actualizar/editar_detalle_daño.php?id_detalle_daño=' . $fila["id_detalle_daño"] . '" class="btn btn-primary btn-sm">Editar</a>
                            <a href="../Eliminar/eliminar_detalle_daño.php?id_detalle_daño=' . $fila["id_detalle_daño"] . '" class="btn btn-danger btn-sm">Eliminar</a>
                        </div>
                    </td>
                </tr>';
            }
            ?>
        </tbody>
    </table>
</div>
<?php include "../Template/footer.php"; ?>