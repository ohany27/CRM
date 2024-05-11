<?php
include "../Template/header.php";
require_once ("../../Config/conexion.php");

$fecha_actual = date('Y-m-d'); // Defino la fecha actual
$fecha_vencimiento = date('Y-m-d', strtotime('+1 year', strtotime($fecha_actual))); // calculamos de tiempo para el vencimiento

$caracteres = "lkjhsysaASMNB8811AMMaksjyuyysth098765432%#%poiyAZXSDEWOjhhs";
$long = 20;
$licencia = substr(str_shuffle($caracteres), 0, $long);

$estado = 1; // Establecer el estado en 1

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nit = $_POST['nit'] ?? '';

    if (empty($nit)) {
        echo "<script>alert('Por favor, completa el campo NIT.');</script>";
    } else {
        $database = new Database();
        $pdo = $database->conectar();

        try {
            $pdo->beginTransaction();

            // Verificar si hay alguna licencia activa con estado = 1
            $query_verificar = "SELECT COUNT(*) as count FROM licencia WHERE estado = 1";
            $statement_verificar = $pdo->prepare($query_verificar);
            $statement_verificar->execute();
            $resultado_verificar = $statement_verificar->fetch(PDO::FETCH_ASSOC);

            if ($resultado_verificar['count'] > 0) {
                echo "<script>alert('Ya existe una licencia activa en el sistema.');</script>";
            } else {
                $query = "INSERT INTO licencia (licencia, nitc, estado, fecha_inicial, fecha_final) VALUES (:licencia, :nitc, :estado, :fecha_inicial, :fecha_final)";
                $statement = $pdo->prepare($query);
                $statement->execute(
                    array(
                        'licencia' => $licencia,
                        'nitc' => $nit,
                        'estado' => $estado,
                        'fecha_inicial' => $fecha_actual,
                        'fecha_final' => $fecha_vencimiento
                    )
                );

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

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Licencias </h1>
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
                                <label for="licencia" class="form-label">Licencia Generada:</label><br>
                                <input type="text" id="licencia" name="licencia" class="form-control"
                                    value="<?php echo $licencia; ?>" readonly><br><br>
                                <label for="fecha_final" class="form-label">Fecha de Vencimiento:</label><br>
                                <input type="text" id="fecha_final" name="fecha_final" class="form-control"
                                    value="<?php echo $fecha_vencimiento; ?>" readonly><br><br>
                            </div>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Crear Licencia">
                    </form>
                    <br>

                    <table id="example1" class="table table-bordered table-striped">
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
                            <?php foreach ($licencias as $licencia): ?>
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
    </section>
</div>
<script>
    // Obtener el valor de la licencia generada en PHP
    var licencia = "<?php echo $licencia; ?>";

    // Generar el código de barras utilizando jsBarcode
    JsBarcode("#barcode", licencia, {
        format: "CODE128", // Puedes ajustar el formato según tus necesidades
        displayValue: true // Mostrar el valor de la licencia debajo del código de barras
    });
</script>
<?php include "../Template/footer.php"; ?>