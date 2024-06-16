<?php include "../Template/header.php"; ?>
<?php
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
    echo "<script>alert('Estado creado'); window.location='../Visualizar/categorias.php';</script>";
        exit;
}
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Crea Una Categorias</h1>
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
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">ID de estado</label>
                                    <input type="number" class="form-control" placeholder="Numero" readonly >
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Nombre</label>
                                    <input type="text" class="form-control" id="tipo_categoria" name="tipo_categoria"
                                        placeholder="Nombre" required>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Crear</button>
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
            this.setCustomValidity('La Categoria debe contener mínimo 3 letras y no se permiten signos de puntuación.');
        }
    });
</script>
<?php include "../Template/footer.php"; ?>