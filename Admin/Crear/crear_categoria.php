<?php
include("../../Config/validarSesion.php");
require_once("../../Config/conexion.php");

$conexion = new Database();
$con = $conexion->conectar();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Procesar el formulario cuando se envía
    $tipoCategoria = $_POST['tipo_categoria'];

    // Validar los datos si es necesario

    // Insertar nueva categoría en la base de datos
    $consultaInsertar = "INSERT INTO categoria (tip_cat) VALUES ('$tipoCategoria')";
    $con->query($consultaInsertar);

    // Redirigir a la página principal de categorías (en este caso, categoria.php)
    header('Location: ../Visualizar/categoria.php');
    exit;
}
?>
<?php include "../Template/header.php"; ?>

<div class="container mt-5">
    <h1 class="text-center">Crear Nueva Categoría</h1>
    <br>
    <form method="POST">
        <div class="mb-3">
            <label for="tipo_categoria" class="form-label">Tipo de Categoría</label>
            <input type="text" class="form-control" id="tipo_categoria" name="tipo_categoria" required>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>
<?php include "../Template/footer.php"; ?>