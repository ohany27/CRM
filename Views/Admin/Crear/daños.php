<?php include "../Template/header.php"; ?>
<?php
require_once("../../../Config/conexion.php");
$DataBase = new Database;
$con = $DataBase->conectar();

// Obtener el NITC del usuario que ha iniciado sesión desde la sesión
$nitc_usuario = $_SESSION['usuario']['nitc'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoger los datos del formulario
    $nombredano = $_POST['nombredano'];
    $id_categoria = $_POST['id_categoria'];
    $precio = $_POST['precio'];
    $id_riesgos = $_POST['id_riesgos'];
    $foto = file_get_contents($_FILES['foto']['tmp_name']);

    // Insertar los datos en la base de datos
    $consulta = "INSERT INTO tipo_daño (nombredano, foto, precio, id_categoria, id_riesgos, nitc) VALUES (:nombredano, :foto, :precio, :id_categoria, :id_riesgos, :nitc)";
    $stmt = $con->prepare($consulta);
    $stmt->bindParam(':nombredano', $nombredano);
    $stmt->bindParam(':foto', $foto, PDO::PARAM_LOB);
    $stmt->bindParam(':precio', $precio);
    $stmt->bindParam(':id_categoria', $id_categoria);
    $stmt->bindParam(':id_riesgos', $id_riesgos);
    $stmt->bindParam(':nitc', $nitc_usuario);
    
    if ($stmt->execute()) {
        echo "<script>alert('Daño creado exitosamente'); window.location.href='../Visualizar/daños.php';</script>";
    } else {
        echo "<script>alert('Error al crear el daño');</script>";
    }
}
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Crear Nuevo Daño</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data" id="formularioDano">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="nombredano">Nombre del Daño</label>
                                    <input type="text" class="form-control" id="nombredano" name="nombredano" placeholder="Nombre del Daño" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="id_categoria">Categoría</label>
                                    <select class="form-control" id="id_categoria" name="id_categoria" required>
                                        <?php
                                        $consultaCat = "SELECT * FROM categoria";
                                        $resultadoCat = $con->query($consultaCat);
                                        while ($filaCat = $resultadoCat->fetch()) {
                                            echo '<option value="' . $filaCat["id_cat"] . '">' . $filaCat["tip_cat"] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="precio">Precio</label>
                                    <input type="number" class="form-control" id="precio" name="precio" placeholder="Precio" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="id_riesgos">Riesgo</label>
                                    <select class="form-control" id="id_riesgos" name="id_riesgos" required>
                                        <?php
                                        $consultaRiesgo = "SELECT * FROM riesgos";
                                        $resultadoRiesgo = $con->query($consultaRiesgo);
                                        while ($filaRiesgo = $resultadoRiesgo->fetch()) {
                                            echo '<option value="' . $filaRiesgo["id_riesgo"] . '">' . $filaRiesgo["tip_riesgo"] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="foto">Foto</label>
                                    <input type="file" class="form-control" id="foto" name="foto" accept="image/*" required>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Crear</button>
                        </div>
                    </form>
                </div>
            </div>
    </section>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('nombredano').addEventListener('input', function () {
        var nombreValue = this.value;
        var nombreRegex = /^[A-Za-z0-9\sñÑ]{3,}$/;
        if (nombreRegex.test(nombreValue)) {
            this.setCustomValidity('');
        } else {
            this.setCustomValidity('El nombre del daño debe tener al menos 3 letras o números y no puede contener signos de puntuación.');
        }
    });

    document.getElementById('precio').addEventListener('input', function () {
        var precioValue = this.value;
        var precioRegex = /^[0-9]+([.,][0-9]+)?$/;
        if (precioRegex.test(precioValue) && parseFloat(precioValue) > 0) {
            this.setCustomValidity('');
        } else {
            this.setCustomValidity('El precio debe ser un número positivo.');
        }
    });

    document.getElementById('foto').addEventListener('change', function () {
        var foto = this.files[0];
        var validImageTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (validImageTypes.includes(foto.type)) {
            this.setCustomValidity('');
        } else {
            this.setCustomValidity('Solo se permiten archivos de imagen (JPG, PNG, GIF).');
        }
    });
});
</script>

<?php include "../Template/footer.php"; ?>
