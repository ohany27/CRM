<?php include "../Template/header.php"; ?>
<?php
require_once("../../Config/conexion.php");
$conexion = new Database();
$con = $conexion->conectar();

// Lógica de creación si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Asegúrate de que el campo en el formulario coincida exactamente con el que estás utilizando aquí
    $nuevo_id_rol = isset($_POST['nuevo_id_tip_usu']) ? $_POST['nuevo_id_tip_usu'] : '';
    $nuevo_tipo_usu = isset($_POST['nuevo_tip_usu']) ? $_POST['nuevo_tip_usu'] : '';

    // Verificar si el id_tip_usu ya existe en la base de datos
    $consultaExistencia = "SELECT COUNT(*) FROM roles WHERE id_tip_usu = '$nuevo_id_rol'";
    $resultadoExistencia = $con->query($consultaExistencia);

    if ($resultadoExistencia->fetchColumn() == 0) {
        // El id_tip_usu no existe, realizar la inserción
        $insertarConsulta = "INSERT INTO roles (id_tip_usu, tip_usu) VALUES ('$nuevo_id_rol', '$nuevo_tipo_usu')";
        $con->exec($insertarConsulta);

        // Redirigir a la página de lista después de la creación
        echo "<script>alert('Usuario creado'); window.location='../Visualizar/roles.php';</script>";
        exit();
    } else {
        // El id_tip_usu ya existe, manejar el error o mostrar un mensaje al usuario
        echo "El ID de Rol ya existe. Por favor, elige otro.";
    }
}
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Crea Un Rol</h1>
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
                                    <label for="">ID de Rol</label>
                                    <input type="number" class="form-control" id="nuevo_id_tip_usu" name="nuevo_id_tip_usu" placeholder="Numero" readonly required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Nombre</label>
                                    <input type="text" class="form-control" id="nuevo_tip_usu" name="nuevo_tip_usu"
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
    document.querySelector('input[name="nuevo_tip_usu"]').addEventListener('input', function () {
        var nombreValue = this.value;
        
        // Verificar si el nombre solo contiene letras y permite la letra "ñ"
        if (/^[A-Za-zñÑ\s]{3,}$/.test(nombreValue) && !/[.]/.test(nombreValue)) {
            this.setCustomValidity('');
        } else {
            this.setCustomValidity('El nombre debe contener mínimo 3 letras y no se permiten signos de puntuación.');
        }
    });
</script>
<?php include "../Template/footer.php"; ?>