<?php
require_once("../Config/conexion.php");

$fecha_actual = date('Y-m-d'); // Defino la fecha actual
$fecha_vencimiento = date('Y-m-d', strtotime('+1 year', strtotime($fecha_actual))); // calculamos de tiempo para el vencimiento

$caracteres = "lkjhsysaASMNB8811AMMaksjyuyysth098765432%#%poiyAZXSDEWOjhhs";
$long = 20;
$licencia = substr(str_shuffle($caracteres), 0, $long);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nit = $_POST['nit'] ?? '';
    $estado = $_POST['estado'] ?? '';

    if (empty($nit) || empty($estado)) {
        echo "<script>alert('Por favor, complete todos los campos.');</script>";
    } else {
        $database = new Database();
        $pdo = $database->conectar();

        try {
            $pdo->beginTransaction();

            $query_verificar = "SELECT COUNT(*) as count FROM licencia WHERE nitc = :nit AND estado = 1";
            $statement_verificar = $pdo->prepare($query_verificar);
            $statement_verificar->execute(array('nit' => $nit));
            $resultado_verificar = $statement_verificar->fetch(PDO::FETCH_ASSOC);

            if ($resultado_verificar['count'] > 0) {
                echo "<script>alert('Ya existe una licencia activa asociada al NIT proporcionado.');</script>";
            } else {
                $query = "INSERT INTO licencia (licencia, nitc, estado, fecha_inicial, fecha_final) VALUES (:licencia, :nitc, :estado, :fecha_inicial, :fecha_final)";
                $statement = $pdo->prepare($query);
                $statement->execute(array(
                    'licencia' => $licencia,
                    'nitc' => $nit,
                    'estado' => $estado,
                    'fecha_inicial' => $fecha_actual,
                    'fecha_final' => $fecha_vencimiento
                ));

                if ($statement->rowCount() > 0) {
                    $pdo->commit();
                    echo "<script>alert('La licencia se ha generado y guardado en la base de datos.');</script>";
                } else {
                    $pdo->rollBack();
                    echo "<script>alert('Ha ocurrido un error al generar y guardar la licencia.');</script>";
                }
            }
        } catch (PDOException $e) {
            $pdo->rollBack();
            echo "<script>alert('Error en la transacción: " . $e->getMessage() . "');</script>";
        }
    }
}

$database = new Database();
$pdo = $database->conectar();
$query_licencias = "SELECT licencia, nitc, estado, fecha_inicial, fecha_final FROM licencia";
$statement_licencias = $pdo->prepare($query_licencias);
$statement_licencias->execute();
$licencias = $statement_licencias->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Tabla de Licencias y Creación</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <br><br>
        <div class="row">
            <!-- Columna Izquierda - Formulario Crear Licencia -->
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h2>Crear Licencia</h2>
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="nit" class="form-label">Selecciona el NIT de la empresa:</label><br>
                                    <select id="nit" name="nit" class="form-control" required>
                                        <option value="" disabled selected>Selecciona un NIT</option>
                                        <?php
                                        $query_empresas = "SELECT nitc, nombre FROM empresa";
                                        $statement_empresas = $pdo->prepare($query_empresas);
                                        $statement_empresas->execute();
                                        while ($row = $statement_empresas->fetch(PDO::FETCH_ASSOC)) {
                                            echo "<option value='" . $row['nitc'] . "'>" . $row['nombre'] . "</option>";
                                        }
                                        ?>
                                    </select><br><br>
                                    <label for="fecha_inicial" class="form-label">Fecha de Creación:</label><br>
                                    <input type="text" id="fecha_inicial" name="fecha_inicial" class="form-control"
                                        value="<?php echo $fecha_actual; ?>" readonly><br><br>
                                </div>
                                <div class="col-md-6">
                                    <label for="estado" class="form-label">Selecciona el estado de la licencia:</label><br>
                                    <select id="estado" name="estado" class="form-control" required>
                                        <option value="" disabled selected>Selecciona un estado</option>
                                        <?php
                                        $query_estados = "SELECT id_est, tip_est FROM estado WHERE id_est < 2";
                                        $statement_estados = $pdo->prepare($query_estados);
                                        $statement_estados->execute();
                                        while ($row = $statement_estados->fetch(PDO::FETCH_ASSOC)) {
                                            echo "<option value='" . $row['id_est'] . "'>" . $row['tip_est'] . "</option>";
                                        }
                                        ?>
                                    </select><br><br>
                                    <label for="fecha_final" class="form-label">Fecha de Vencimiento:</label><br>
                                    <input type="text" id="fecha_final" name="fecha_final" class="form-control"
                                        value="<?php echo $fecha_vencimiento; ?>" readonly><br><br>
                                </div>
                            </div>
                            <label for="licencia" class="form-label">Licencia Generada:</label><br>
                            <input type="text" id="licencia" name="licencia" class="form-control"
                                value="<?php echo $licencia; ?>" readonly><br><br>

                            <input type="submit" class="btn btn-primary" value="Crear Licencia">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Tabla de Licencias -->
        <div class="row mt-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h2>Licencias</h2>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Licencia</th>
                                        <th>NIT</th>
                                        <th>Estado</th>
                                        <th>Fecha Inicial</th>
                                        <th>Fecha Final</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($licencias as $licencia) : ?>
                                        <tr>
                                            <td><?php echo $licencia['licencia']; ?></td>
                                            <td><?php echo $licencia['nitc']; ?></td>
                                            <td><?php echo $licencia['estado']; ?></td>
                                            <td><?php echo $licencia['fecha_inicial']; ?></td>
                                            <td><?php echo $licencia['fecha_final']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
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



