<?php include "../Template/header.php"; ?>
<?php
include ('../../Config/conexion.php');

$database = new Database();
$pdo = $database->conectar();

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nitcToUpdate = $_POST['nitc'];
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];

    // Check if there are any records with the same nombre or telefono
    $checkQuery = $pdo->prepare("SELECT * FROM empresa WHERE (nombre = ? OR telefono = ?) AND nitc <> ?");
    $checkQuery->execute([$nombre, $telefono, $nitcToUpdate]);
    $existingRecord = $checkQuery->fetch(PDO::FETCH_ASSOC);

    if ($existingRecord) {
        // If a record with the same nombre or telefono exists, display an error message
        echo '<script>alert("Ya existe un registro con el mismo nombre o teléfono.");</script>';
    } else {
        // Prepare and execute the update query
        $updateQuery = $pdo->prepare("UPDATE empresa SET nombre = ?, direccion = ?, telefono = ? WHERE nitc = ?");
        $updateQuery->execute([$nombre, $direccion, $telefono, $nitcToUpdate]);

        // Redirect to the page displaying the updated data or any other desired location
        echo '<script>alert ("Actualización exitosa.");</script>';
        echo '<script>window.location="../Visualizar/empresa.php"</script>';
        exit();
    }
}

// Retrieve existing data for the selected record
if (isset($_GET['nitc'])) {
    $nitcToUpdate = $_GET['nitc'];

    $selectQuery = $pdo->prepare("SELECT * FROM empresa WHERE nitc = ?");
    $selectQuery->execute([$nitcToUpdate]);
    $empresa = $selectQuery->fetch(PDO::FETCH_ASSOC);
} else {
    // Redirect to the page displaying the data if nitc parameter is not provided
    header("Location: ../Visualizar/empresa.php");
    exit();
}
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Editar Empresa</h1>
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
                <form method="POST">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Nit:</label>
                                    <input type="number" class="form-control" name="nitc"
                                        value="<?php echo $empresa['nitc']; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="nombre">Nombre:</label>
                                    <input type="text" class="form-control" name="nombre"
                                        value="<?php echo $empresa['nombre']; ?>" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="direccion">Direccion:</label>
                                    <input type="text" class="form-control" name="direccion"
                                        value="<?php echo $empresa['direccion']; ?>" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="telefono">Telefono:</label>
                                    <input type="number" class="form-control" name="telefono"
                                        value="<?php echo $empresa['telefono']; ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                        </div>
                </form>

            </div>
        </div>
    </section>
</div>
<script>
    document.querySelector('input[name="nombre"]').addEventListener('input', function () {
        var nombreValue = this.value;
        
        // Verificar si el nombre solo contiene letras y permite la letra "ñ"
        if (/^[A-Za-zñÑ\s]{3,}$/.test(nombreValue) && !/[.]/.test(nombreValue)) {
            this.setCustomValidity('');
        } else {
            this.setCustomValidity('El nombre debe contener minimo 3 letras, no se permite signos de puntuacion.');
        }
    });

    document.querySelector('input[name="telefono"]').addEventListener('input', function () {
        var telefonoValue = this.value;
        
        // Verificar si el teléfono tiene exactamente 10 dígitos y no contiene puntos
        if (/^\d{10}$/.test(telefonoValue) && !/[.]/.test(telefonoValue)) {
            this.setCustomValidity('');
        } else {
            this.setCustomValidity('El teléfono debe contener exactamente 10 dígitos y no permitir puntos.');
        }
    });
</script>
<?php include "../Template/footer.php"; ?>