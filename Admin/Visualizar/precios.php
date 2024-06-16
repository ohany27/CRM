<?php
include("../../Config/validarSesion.php");
    require_once("../../Config/conexion.php");
    $DataBase = new Database;
    $con = $DataBase -> conectar();
?>
<?php include "../Template/header.php"; ?>
<div class="container mt-5">
    <h1 class="text-center">Precios</h1>
    <table class="table table-bordered">
        <thead class="table-primary">
            <tr>
                <th>Id_Precios</th>
                <th>Tipo de Daño</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Consulta de Empleados
            $consulta = "SELECT * FROM precios, tipo_daño WHERE precios.id_daño = tipo_daño. id_daño";
            $resultado = $con->query($consulta);

            while ($fila = $resultado->fetch()) {
                echo '
                <tr>
                    <td>' . $fila["id_pre"] . '</td>
                    <td>' . $fila["nombre"] . '</td>
                    <td>' . $fila["precio"] . '</td>
                    <td>
                        <div class="text-center">
                            <a href="../Actualizar/editar_pre.php?id_pre=' . $fila["id_pre"] . '" class="btn btn-primary btn-sm">Editar</a>
                            <a href="../Eliminar/eliminar_pre.php?id_pre=' . $fila["id_pre"] . '" class="btn btn-danger btn-sm">Eliminar</a>
                        </div>
                    </td>
                </tr>';
            }
            ?>
        </tbody>
    </table>
</div>
<?php include "../Template/footer.php"; ?>
