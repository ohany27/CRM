<?php
include("../../Config/validarSesion.php");
require_once("../../Config/conexion.php");
$DataBase = new Database;
$con = $DataBase->conectar();
?>
<?php include "../Template/header.php"; ?>

<div class="container mt-5">
    <h1 class="text-center">Riesgos</h1>
    <table class="table table-bordered">
        <thead class="table-primary">
            <tr>
                <th>Id_Riesgos</th>
                <th>Tipo de Riesgos</th>
                <th>Tiempo de atencion</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Consulta de Empleados
            $consulta = "SELECT * FROM riesgos";
            $resultado = $con->query($consulta);

            while ($fila = $resultado->fetch()) {
                echo '
                <tr>
                    <td>' . $fila["id_riesgo"] . '</td>
                    <td>' . $fila["tip_riesgo"] . '</td>
                    <td>' . $fila["tiempo_atent"] . '</td>
                    <td>
                        <div class="text-center">
                            <a href="../Actualizar/editar_riesgo.php?id_riesgo=' . $fila["id_riesgo"] . '" class="btn btn-primary btn-sm">Editar</a>
                            <a href="../Eliminar/eliminar_riesgo.php?id_riesgo=' . $fila["id_riesgo"] . '" class="btn btn-danger btn-sm">Eliminar</a>
                        </div>
                    </td>
                </tr>';
            }
            ?>
        </tbody>
    </table>
    <?php include "../Template/footer.php"; ?>