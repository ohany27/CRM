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
    $foto = file_get_contents($_FILES['foto']['tmp_name']);

    // Insertar los datos en la base de datos
    $consulta = "INSERT INTO tipo_daño (nombredano, foto, precio, id_categoria, nitc) VALUES (:nombredano, :foto, :precio, :id_categoria, :nitc)";
    $stmt = $con->prepare($consulta);
    $stmt->bindParam(':nombredano', $nombredano);
    $stmt->bindParam(':foto', $foto, PDO::PARAM_LOB);
    $stmt->bindParam(':precio', $precio);
    $stmt->bindParam(':id_categoria', $id_categoria);
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
                    <form method="post" enctype="multipart/form-data">
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
                                    <label for="foto">Foto</label>
                                    <input type="file" class="form-control" id="foto" name="foto" required>
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

<?php include "../Template/footer.php"; ?>
