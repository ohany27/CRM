<?php
include("../../Config/validarSesion.php");
require_once("../../Config/conexion.php");
$conexion = new Database();
$con = $conexion->conectar();
?>

<?php include "../Template/header.php"; ?>
<div class="container mt-5">
    <h1 class="text-center">Lista de Tipos de Usuario</h1>
    <br>
    <table class="table table-bordered">
        <thead class="table-primary">
            <tr>
                <th>id_rol</th>
                <th>Tipo de Usuario</th>
                <th>Acciones</th>
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
                    <td>
                        <div class="text-center">
                            <a href="../Actualizar/editar_rol.php?id=' . $fila["id_tip_usu"] . '" class="btn btn-primary btn-sm">Editar</a>
                            <a href="../Eliminar/eliminar_rol.php?id=' . $fila["id_tip_usu"] . '" class="btn btn-danger btn-sm">Eliminar</a>
                        </div>
                    </td>
                </tr>';
            }
            ?>
        </tbody>
    </table>
</div>
<?php include "../Template/footer.php"; ?>