<?php
include "../Template/header.php";
require_once ("../../../Config/conexion.php");
$Conexion = new Database;
$con = $Conexion->conectar();

// Verificar si se ha enviado el formulario de actualización
if (isset($_POST["update"])) {
    // Evitar inyección SQL utilizando sentencias preparadas
    $id = $_POST['id'];
    $tipo = $_POST['tipo'];
    $precio = $_POST['precio'];
    $categoria = $_POST['categoria']; // Agregado para obtener la nueva categoría seleccionada
    $id_riesgos = $_POST['id_riesgos']; // Nuevo campo para obtener el riesgo seleccionado

    // Comprobamos si se ha subido una nueva imagen
    if ($_FILES['foto']['tmp_name'] != '') {
        // Guardamos la nueva imagen en una variable
        $imagen = file_get_contents($_FILES['foto']['tmp_name']);

        // Actualizamos la imagen junto con los otros campos
        $updateSQL = $con->prepare("UPDATE tipo_daño SET nombredano = ?, foto = ?, precio = ?, id_categoria = ?, id_riesgos = ? WHERE id_daño = ?");
        $updateSQL->execute([$tipo, $imagen, $precio, $categoria, $id_riesgos, $_GET['id_daño']]);
    } else {
        // Si no se ha subido una nueva imagen, actualizamos solo los otros campos
        $updateSQL = $con->prepare("UPDATE tipo_daño SET nombredano = ?, precio = ?, id_categoria = ?, id_riesgos = ? WHERE id_daño = ?");
        $updateSQL->execute([$tipo, $precio, $categoria, $id_riesgos, $_GET['id_daño']]);
    }

    // Comprobar si se realizó la actualización correctamente
    if ($updateSQL) {
        echo '<script>alert("Actualización exitosa.");</script>';
        echo '<script>window.location="../Visualizar/daños.php"</script>';
    } else {
        echo '<script>alert("Error al actualizar.");</script>';
    }
}

// Obtener los datos del tipo de daño a editar
$sql = $con->prepare("SELECT * FROM tipo_daño WHERE id_daño = ?");
$sql->execute([$_GET['id_daño']]);
$usua = $sql->fetch();

// Consulta para obtener los tipos de categoría
$consulta_categorias = "SELECT id_cat, tip_cat FROM categoria";
$resultado_categorias = $con->query($consulta_categorias);

// Consulta para obtener los tipos de riesgos
$consulta_riesgos = "SELECT id_riesgo, tip_riesgo FROM riesgos";
$resultado_riesgos = $con->query($consulta_riesgos);
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Editar Un Daño</h1>
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
                <!-- Formulario de edición -->
                <form method="post" name="formreg" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="tipo">Nombre</label>
                                    <input type="text" class="form-control" id="tipo" name="tipo"
                                        value="<?php echo htmlspecialchars($usua['nombredano']); ?>"
                                        placeholder="Nombre" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="precio">Precio</label>
                                    <input type="number" class="form-control" id="precio" name="precio"
                                        value="<?php echo htmlspecialchars($usua['precio']); ?>" placeholder="Precio"
                                        required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="categoria_nueva">Seleccionar Nueva Categoría</label>
                                    <select class="form-control" id="categoria_nueva" name="categoria" required>
                                        <option value="">Selecciona una categoría</option>
                                        <?php
                                        // Iterar sobre los resultados de la consulta y mostrar las opciones
                                        while ($fila_categoria = $resultado_categorias->fetch()) {
                                            $selected = ($fila_categoria['id_cat'] == $usua['id_categoria']) ? 'selected' : '';
                                            echo '<option value="' . $fila_categoria["id_cat"] . '" ' . $selected . '>' . $fila_categoria["tip_cat"] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="id_riesgos">Seleccionar Riesgo</label>
                                    <select class="form-control" id="id_riesgos" name="id_riesgos" required>
                                        <option value="">Selecciona un riesgo</option>
                                        <?php
                                        // Iterar sobre los resultados de la consulta y mostrar las opciones
                                        while ($fila_riesgo = $resultado_riesgos->fetch()) {
                                            $selected = ($fila_riesgo['id_riesgo'] == $usua['id_riesgos']) ? 'selected' : '';
                                            echo '<option value="' . $fila_riesgo["id_riesgo"] . '" ' . $selected . '>' . $fila_riesgo["tip_riesgo"] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="foto">Foto Actual</label>
                                    <br>
                                    <img src="data:image/jpeg;base64,<?php echo base64_encode($usua['foto']); ?>"
                                        alt="Foto actual" style="max-width: 300px;">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="foto">Seleccionar Nueva Foto</label>
                                    <input type="file" class="form-control-file" id="foto" name="foto">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" name="update" class="btn btn-primary">Editar</button>
                    </div>
                    <input type="hidden" name="MM_insert" value="formreg">
                </form>
            </div>
        </div>
    </section>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Validar nombre del daño
        document.getElementById('tipo').addEventListener('input', function () {
            var nombreValue = this.value;
            var nombreRegex = /^[A-Za-z0-9\sñÑ]{3,}$/;
            if (nombreRegex.test(nombreValue)) {
                this.setCustomValidity('');
            } else {
                this.setCustomValidity('El nombre del daño debe tener al menos 3 letras o números y no puede contener signos de puntuación.');
            }
        });

        // Validar precio
        document.getElementById('precio').addEventListener('input', function () {
            var precioValue = this.value;
            var precioRegex = /^[0-9]+([.,][0-9]+)?$/;
            if (precioRegex.test(precioValue) && parseFloat(precioValue) > 0) {
                this.setCustomValidity('');
            } else {
                this.setCustomValidity('El precio debe ser un número positivo.');
            }
        });

        // Validar tipo de archivo de la foto
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