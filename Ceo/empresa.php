<?php
include('../Config/conexion.php');

$database = new Database();
$pdo = $database->conectar();

// Check if delete button is clicked
if (isset($_GET['delete_nitc'])) {
    $nitcToDelete = $_GET['delete_nitc'];

    // Prepare and execute the delete query
    $deleteQuery = $pdo->prepare("DELETE FROM empresa WHERE nitc = ?");
    $deleteQuery->execute([$nitcToDelete]);
}

// Fetch and display data
$selectQuery = $pdo->prepare("SELECT * FROM empresa");
$selectQuery->execute();
$empresas = $selectQuery->fetchAll(PDO::FETCH_ASSOC);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nitc = $_POST['nitc'];
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];

    // Verificar si todos los campos están llenos
    if (empty($nitc) || empty($nombre) || empty($direccion) || empty($telefono)) {
        echo "<script>alert('Todos los campos son obligatorios.')</script>";
    } elseif (!is_numeric($nitc) || !is_numeric($telefono)) {
        echo "<script>alert('El NITC y el teléfono deben contener solo números.')</script>";
    } else {
        $database = new Database();
        $pdo = $database->conectar();

        // Verificar si ya existe un registro con el mismo NITC
        $stmt = $pdo->prepare("SELECT * FROM empresa WHERE nitc = :nitc");
        $stmt->execute([':nitc' => $nitc]);
        $existingNitc = $stmt->fetch();

        // Verificar si ya existe un registro con el mismo nombre
        $stmt = $pdo->prepare("SELECT * FROM empresa WHERE nombre = :nombre");
        $stmt->execute([':nombre' => $nombre]);
        $existingNombre = $stmt->fetch();

        if ($existingNitc) {
            echo "<script>alert('Ya existe una empresa con este NITC.')</script>";
        } elseif ($existingNombre) {
            echo "<script>alert('Ya existe una empresa con este nombre.')</script>";
        } else {
            // Insertar datos en la base de datos
            $sql = "INSERT INTO empresa (nitc, nombre, direccion, telefono) VALUES (:nitc, :nombre, :direccion, :telefono)";
            $stmt = $pdo->prepare($sql);

            $params = array(
                ':nitc' => $nitc,
                ':nombre' => $nombre,
                ':direccion' => $direccion,
                ':telefono' => $telefono
            );

            if ($stmt->execute($params)) {
                echo "<script>alert('Empresa creada correctamente.')</script>";
                echo "<script>window.location.href = 'empresa.php';</script>";
            } else {
                echo "<script>alert('Error al crear la empresa.')</script>";
            }
        }

        unset($stmt);
        unset($pdo);
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Tabla de Empresas y Creación</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
    <br><br>
        <div class="row">
            <!-- Columna Izquierda - Formulario Crear Empresa -->
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h1>Crea Una Empresa</h1>
                        <form action="" method="post">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="nitc" class="form-label">NIT:</label>
                                        <input type="number" class="form-control" id="nitc" name="nitc"
                                            pattern="[0-9]*" title="Ingrese solo números" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="nombre" class="form-label">Nombre:</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="direccion" class="form-label">Dirección:</label>
                                        <input type="text" class="form-control" id="direccion" name="direccion"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="telefono" class="form-label">Teléfono:</label>
                                        <input type="number" class="form-control" id="telefono" name="telefono"
                                            pattern="[0-9]*" title="Ingrese solo números" required>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Generar Empresa</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <br><br>
        <!-- Tabla de Empresas -->
        <div class="row mt-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h1>Empresas</h1>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>NITC</th>
                                        <th>Nombre</th>
                                        <th>Dirección</th>
                                        <th>Teléfono</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($empresas as $empresa) { ?>
                                        <tr>
                                            <td><?php echo $empresa['nitc']; ?></td>
                                            <td><?php echo $empresa['nombre']; ?></td>
                                            <td><?php echo $empresa['direccion']; ?></td>
                                            <td><?php echo $empresa['telefono']; ?></td>
                                            <td>
                                                <a href="Acciones/actualizar.php?nitc=<?php echo $empresa['nitc']; ?>"
                                                    class="btn btn-primary">Actualizar</a>
                                                <a href="?delete_nitc=<?php echo $empresa['nitc']; ?>"
                                                    onclick="return confirm('¿Estás seguro de eliminar esta empresa?')"
                                                    class="btn btn-danger">Eliminar</a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <a href="index.php" class="btn btn-success float-right mt-3">Volver</a>
    </div>
    <!-- Bootstrap JS y dependencias Popper.js y jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
