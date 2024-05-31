<?php include "../Template/header.php"; ?>
<?php
include ('../../Config/conexion.php');

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

        // Verificar si ya existe un registro con el mismo teléfono
        $stmt = $pdo->prepare("SELECT * FROM empresa WHERE telefono = :telefono");
        $stmt->execute([':telefono' => $telefono]);
        $existingTelefono = $stmt->fetch();

        if ($existingNitc) {
            echo "<script>alert('Ya existe una empresa con este NITC.')</script>";
        } elseif ($existingNombre) {
            echo "<script>alert('Ya existe una empresa con este nombre.')</script>";
        } elseif ($existingTelefono) {
            echo "<script>alert('Ya existe una empresa con este teléfono.')</script>";
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
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Empresas </h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"></h3>
                </div>
                <div class="card-body">
                    <form action="" method="post">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="nitc" class="form-label">NIT:</label>
                                    <input type="number" class="form-control" id="nitc" name="nitc" 
                                        title="Ingrese solo números" required>
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
                                    <input type="text" class="form-control" id="direccion" name="direccion" required>
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

                        <button type="submit" class="btn btn-primary">Guardar Empresa</button>
                    </form>
                    <br>
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>NITC</th>
                                <th>Nombre</th>
                                <th>Dirección</th>
                                <th>Teléfono</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($empresas as $empresa) { ?>
                                <tr>
                                    <td><?php echo $empresa['nitc']; ?></td>
                                    <td><?php echo $empresa['nombre']; ?></td>
                                    <td><?php echo $empresa['direccion']; ?></td>
                                    <td><?php echo $empresa['telefono']; ?></td>
                                    <td class="project-actions text-center">
                                        <a href="../Editar/empresa.php?nitc=<?php echo $empresa['nitc']; ?>"
                                            class="btn btn-info btn-sm" href="#">
                                            <i class="fas fa-pencil-alt">
                                            </i>
                                            Editar
                                        </a>
                                        <a href="?delete_nitc=<?php echo $empresa['nitc']; ?>" 
                                        onclick="return confirm('¿Estás seguro de eliminar esta empresa?')"
                                            class="btn btn-danger btn-sm" href="#">
                                            <i class="fas fa-trash">
                                            </i>
                                            Eliminar
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    document.getElementById('nitc').addEventListener('input', function () {
        var nitValue = this.value;
        var nitLength = nitValue.length;
        
        // Verificar 
        if (nitLength >= 7 && nitLength <= 10 && /^\d+$/.test(nitValue) && !/[.,]/.test(nitValue)) {
            this.setCustomValidity('');
        } else {
            this.setCustomValidity('El NIT debe tener entre 7 y 10 dígitos, no se permite signos de puntuacion.');
        }
    });
    document.getElementById('nombre').addEventListener('input', function () {
        var nombreValue = this.value;
        
        // Verificar 
        if (/^[A-Za-zñÑ\s]{3,}$/.test(nombreValue) && !/[.]/.test(nombreValue)) {
            this.setCustomValidity('');
        } else {
            this.setCustomValidity('El nombre debe contener minimo 3 letras, no se permite signos de puntuacion.');
        }
    });
    document.getElementById('telefono').addEventListener('input', function () {
        var telefonoValue = this.value;
        
        // Verificar 
        if (/^\d{10}$/.test(telefonoValue) && !/[.]/.test(telefonoValue)) {
            this.setCustomValidity('');
        } else {
            this.setCustomValidity('El teléfono debe contener exactamente 10 dígitos.');
        }
    });
</script>
<?php include "../Template/footer.php"; ?>