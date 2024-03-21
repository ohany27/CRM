<?php
include("../../Config/validarSesion.php");
require_once("../../Config/conexion.php");

$conexion = new Database();
$con = $conexion->conectar();

// Consulta para obtener los datos de la tabla estado usando PDO
$sql = "SELECT id_est, tip_est FROM estado";
$resultado = $con->query($sql);

// Verificar si la consulta fue exitosa
if ($resultado) {
    // Comprobar si hay filas en el resultado
    if ($resultado->rowCount() > 0) {
?>
<?php include "../Template/header.php"; ?>

        <div class="container mt-5">
            <h1 class="text-center">Lista de estados</h1>
            <br>
            <table class="table table-bordered">
                <thead class="table-primary">
                    <tr>
                        <th>ID Estado</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>

<?php while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) {
    echo '
    <tr>
        <td>' . $fila["id_est"] . '</td>
        <td>' . $fila["tip_est"] . '</td>
        <td>
            <div class="text-center">
                <a href="../Actualizar/editar_estado.php?id=' . $fila["id_est"] . '" class="btn btn-primary btn-sm">Editar</a>
                <a href="../Eliminar/eliminar_estado.php?id=' . $fila["id_est"] . '" class="btn btn-danger btn-sm">Eliminar</a>
            </div>
        </td>
    </tr>';
}

                    ?>

                </tbody>
            </table>
        </div>
        <?php
    } else {
        echo "No hay resultados en la tabla estado.";
    }
} else {
    echo "Error en la consulta: " . $con->errorInfo()[2];
}

// Cerrar la conexión PDO
$con = null;
?>
<?php include "../Template/footer.php"; ?>