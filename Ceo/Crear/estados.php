<?php include "../Template/header.php"; ?>
<?php
require_once("../../Config/conexion.php");
$conexion = new Database();
$con = $conexion->conectar();


// Verificar si se envió el formulario de creación
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Procesar el formulario de creación y agregar el nuevo estado a la base de datos
    $nuevo_estado = $_POST['nuevo_estado'];

    $insertar_estado = "INSERT INTO estado (tip_est) VALUES (?)";
    $stmt = $con->prepare($insertar_estado);
    $stmt->execute([$nuevo_estado]);

    if ($stmt->rowCount() > 0) {
        // Redirigir a la página de lista de estados después de la creación exitosa
        echo "<script>alert('Estado creado'); window.location='../Visualizar/estados.php';</script>";
        exit;
    } else {
        echo "Error al crear el estado.";
    }
}
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Crea Un Estado</h1>
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
                                    <input type="text" class="form-control" id="nuevo_estado" name="nuevo_estado"
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
    document.querySelector('input[name="nuevo_estado"]').addEventListener('input', function () {
        var nombreValue = this.value;
        
        // Verificar si el nombre solo contiene letras y permite la letra "ñ"
        if (/^[A-Za-zñÑ\s]{3,}$/.test(nombreValue) && !/[.]/.test(nombreValue)) {
            this.setCustomValidity('');
        } else {
            this.setCustomValidity('El nombre debe contener minimo 3 letras, no se permite signos de puntuacion.');
        }
    });
</script>
<?php include "../Template/footer.php"; ?>