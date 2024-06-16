<?php include "../Template/header.php"; ?>
<?php
require_once("../../Config/conexion.php");

$conexion = new Database();
$con = $conexion->conectar();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Procesar el formulario cuando se envía
    $idCategoria = $_POST['id_categoria'];
    $tipoCategoria = $_POST['tipo_categoria'];

    // Validar los datos si es necesario

    // Actualizar la categoría en la base de datos
    $consultaActualizar = "UPDATE categoria SET tip_cat = '$tipoCategoria' WHERE id_cat = $idCategoria";
    $con->query($consultaActualizar);

    // Redirigir a la página principal de categorías
    echo '<script>alert ("Actualización exitosa.");</script>';
            echo '<script>window.location="../Visualizar/categorias.php"</script>';
            exit();
} elseif (isset($_GET['id'])) {
    // Mostrar el formulario de edición si se proporciona un ID en la URL
    $idCategoria = $_GET['id'];

    // Obtener los datos de la categoría para prellenar el formulario
    $consultaObtener = "SELECT * FROM categoria WHERE id_cat = $idCategoria";
    $resultado = $con->query($consultaObtener);

    if ($fila = $resultado->fetch()) {
        $tipoCategoria = $fila['tip_cat'];
    } else {
        // Manejar el caso en que no se encuentre la categoría con el ID dado
        echo "Categoría no encontrada.";
        exit;
    }
} else {
    // Manejar el caso en que no se proporciona un ID
    echo "ID de categoría no proporcionado.";
    exit;
}
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Editar Un Categoria</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"></h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form method="post">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="">Nombre</label>
                                    <input type="hidden" name="id_categoria" value="<?php echo $idCategoria; ?>">
                                    <input type="text" class="form-control" id="tipo_categoria" name="tipo_categoria" value="<?php echo $tipoCategoria; ?>"
                                        placeholder="Nombre" required>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Editar</button>
                        </div>
                </form>

            </div>
        </div>
    </section>
</div>
<script>
    document.getElementById('tipo_categoria').addEventListener('input', function () {
        var nombreValue = this.value;
        
        // Verificar si el nombre solo contiene letras y permite la letra "ñ"
        if (/^[A-Za-zñÑ\s]{3,}$/.test(nombreValue) && !/[.]/.test(nombreValue)) {
            this.setCustomValidity('');
        } else {
            this.setCustomValidity('La categoria debe contener mínimo 3 letras y no se permiten signos de puntuación.');
        }
    });
</script>
<?php include "../Template/footer.php"; ?>