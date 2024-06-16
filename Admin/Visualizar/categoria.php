<?php
include("../../Config/validarSesion.php");
require_once("../../Config/conexion.php");
$conexion = new Database();
$con = $conexion->conectar();

// Lógica para eliminar categoría
if (isset($_GET['eliminar_id'])) {
    $eliminar_id = $_GET['eliminar_id'];
    $consultaEliminar = "DELETE FROM categoria WHERE id_cat = $eliminar_id";
    $con->query($consultaEliminar);
    header('Location: categoria.php');
    exit;
}

$consulta = "SELECT * FROM categoria";
$resultado = $con->query($consulta);
?>
<?php include "../Template/header.php"; ?>
    <div class="container mt-5">
        <h1 class="text-center">Lista de Categorías</h1>
        <br>
        <table class="table table-bordered">
            <thead class="table-primary">
                <tr>
                    <th>ID</th>
                    <th>Tipo de Categoría</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($fila = $resultado->fetch()) {
                    echo '
                    <tr>
                        <td>' . $fila["id_cat"] . '</td>
                        <td>' . $fila["tip_cat"] . '</td>
                        <td>
                            <a href="../Actualizar/editar_categoria.php?id=' . $fila["id_cat"] . '" class="btn btn-warning">Editar</a>
                            <a href="../Eliminar/eliminar_categorias.php?id=' . $fila["id_cat"] . '" class="btn btn-danger">Eliminar</a>
                        </td>
                    </tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
    <?php include "../Template/footer.php"; ?>