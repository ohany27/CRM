<?php 
include "../Template/header.php";
require_once("../../../Config/conexion.php");
$Conexion = new Database;
$con = $Conexion->conectar();

// Verificar si se ha enviado el formulario de actualización
if (isset($_POST["update"])) {
    // Evitar inyección SQL utilizando sentencias preparadas
    $id = $_POST['id'];
    $tipo = $_POST['tipo'];
    $precio = $_POST['precio'];

    $updateSQL = $con->prepare("UPDATE tipo_daño SET nombre = ?, precio = ? WHERE id_daño = ?");
    $updateSQL->execute([$tipo, $precio, $_GET['id_daño']]);
    
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
                <form method="post" name="formreg">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="tipo">Nombre</label>
                                    <input type="text" class="form-control" id="tipo" name="tipo" value="<?php echo htmlspecialchars($usua['nombre']); ?>" placeholder="Nombre" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="precio">Precio</label>
                                    <input type="number" class="form-control" id="precio" name="precio" value="<?php echo htmlspecialchars($usua['precio']); ?>" placeholder="Precio" required>
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
<?php include "../Template/footer.php"; ?>
