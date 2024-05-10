<?php
include('../../Config/conexion.php');

$database = new Database();
$pdo = $database->conectar();

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nitcToUpdate = $_POST['nitc'];
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];

    // Prepare and execute the update query
    $updateQuery = $pdo->prepare("UPDATE empresa SET nombre = ?, direccion = ?, telefono = ? WHERE nitc = ?");
    $updateQuery->execute([$nombre, $direccion, $telefono, $nitcToUpdate]);

    // Redirect to the page displaying the updated data or any other desired location
    header("Location: ../empresa.php");
    exit();
}

// Retrieve existing data for the selected record
if (isset($_GET['nitc'])) {
    $nitcToUpdate = $_GET['nitc'];

    $selectQuery = $pdo->prepare("SELECT * FROM empresa WHERE nitc = ?");
    $selectQuery->execute([$nitcToUpdate]);
    $empresa = $selectQuery->fetch(PDO::FETCH_ASSOC);
} else {
    // Redirect to the page displaying the data if nitc parameter is not provided
    header("Location: ../empresa.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Tabla de Empresas y Creacion</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="text-center">
        <h1>Edita La Empresa</h1>
    </div>
    <section class="section">
        <div class="container my-5">
            <div class="row">
                <div class="col-sm-12 col-md-8 offset-md-2"> <!-- Ajusté el ancho del formulario -->
                    <form method="POST">
                        <input type="hidden" name="nitc" value="<?php echo $empresa['nitc']; ?>">
                        <div class="form-group"> <!-- Agregué la clase form-group para cada campo -->
                            <label for="nombre">Nombre:</label>
                            <input type="text" class="form-control" name="nombre"
                                value="<?php echo $empresa['nombre']; ?>" required>
                        </div>
                        <div class="form-group"> <!-- Agregué la clase form-group para cada campo -->
                            <label for="direccion">Direccion:</label>
                            <input type="text" class="form-control" name="direccion"
                                value="<?php echo $empresa['direccion']; ?>" required>
                        </div>
                        <div class="form-group"> <!-- Agregué la clase form-group para cada campo -->
                            <label for="telefono">Telefono:</label>
                            <input type="text" class="form-control" name="telefono"
                                value="<?php echo $empresa['telefono']; ?>" required>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                        <!-- Agregué estilos de botón de Bootstrap -->
                    </form>
                </div>
            </div>
            <a href="../empresa.php" class="btn btn-success  float-right mt-3">Volver</a>
        </div>
    </section>
    </div> <!-- Aquí termina el contenedor div -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>