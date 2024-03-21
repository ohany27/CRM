<?php
include("../../Config/validarSesion.php");
    require_once("../../Config/conexion.php");
    $DataBase = new Database;
    $con = $DataBase -> conectar();
?>
<?php include "../Template/header.php"; ?>

<div class="container mt-5">
    <h1 class="text-center">Usuarios Registrados</h1>
    <br>
    <table class="table table-bordered">
        <thead class="table-primary">
            <tr>
                <th>Documento</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>PIN</th>
                <th>Teléfono</th>
                <th>Dirección</th>
                <th>NITC</th>
                <th>Tipo de Usuario</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>

            <?php
            $consulta = "SELECT * FROM usuario INNER JOIN roles ON usuario.id_tip_usu = roles.id_tip_usu";
            $resultado = $con->query($consulta);

            while ($fila = $resultado->fetch()) {
                echo '
                <tr>
                    <td>' . $fila["documento"] . '</td>
                    <td>' . $fila["nombre"] . '</td>
                    <td>' . (isset($fila["correo"]) ? $fila["correo"] : '') . '</td>
                    <td>' . $fila["pin"] . '</td>
                    <td>' . $fila["telefono"] . '</td>
                    <td>' . $fila["direccion"] . '</td>
                    <td>' . (isset($fila["nitc"]) ? $fila["nitc"] : 'Valor predeterminado') . '</td>
                    <td>' . (isset($fila["tip_usu"]) ? $fila["tip_usu"] : 'Valor predeterminado') . '</td>
                    <td>
                        <div class="text-center">
                            <a href="../Actualizar/editar_usuario.php?id=' . $fila['documento'] . '" class="btn btn-primary btn-sm">Editar</a>
                            <a href="../Eliminar/eliminar_usuario.php?id=' . $fila['documento'] . '" class="btn btn-danger btn-sm">Eliminar</a>
                        </div>
                    </td>
                </tr>';
            }
            ?>
        </tbody>
    </table>
</div>
<?php include "../Template/footer.php"; ?>