<?php
include "../Template/header.php";
require_once ("../../Config/conexion.php");

// Asegúrate de que la biblioteca de código de barras esté cargada
require '../vendor/autoload.php';
use Picqer\Barcode\BarcodeGeneratorPNG;

$fecha_actual = date('Y-m-d'); // Defino la fecha actual
$fecha_vencimiento = date('Y-m-d', strtotime('+1 year', strtotime($fecha_actual))); // calculamos de tiempo para el vencimiento

$caracteres = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
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

            // Verificar si hay una licencia activa con estado = 1 para el mismo NIT
            $query_verificar = "SELECT COUNT(*) as count FROM licencia WHERE nitc = :nitc AND estado = 1";
            $statement_verificar = $pdo->prepare($query_verificar);
            $statement_verificar->execute(array('nitc' => $nit));
            $resultado_verificar = $statement_verificar->fetch(PDO::FETCH_ASSOC);

            if ($resultado_verificar['count'] > 0) {
                echo "<script>alert('Ya existe una licencia activa para este NIT en el sistema.');</script>";
            } else {
                // Generar el código de barras
                $generator = new BarcodeGeneratorPNG();
                $codigo_barras_imagen = $generator->getBarcode($licencia, $generator::TYPE_CODE_128);

                // Guardar la imagen del código de barras
                $ruta_imagen = __DIR__ . '/../dist/img/codigo/' . $licencia . '.png';
                file_put_contents($ruta_imagen, $codigo_barras_imagen);

                // Insertar la licencia en la base de datos
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
$query_licencias = "SELECT l.licencia, e.nombre as nombre_empresa, es.tip_est as estado, l.fecha_inicial, l.fecha_final 
                    FROM licencia l
                    JOIN empresa e ON l.nitc = e.nitc
                    JOIN estado es ON l.estado = es.id_est";
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
                                <th style="text-align: center;">Licencia</th>
                                <th>NIT</th>
                                <th>Estado</th>
                                <th>Fecha Inicial</th>
                                <th>Fecha Final</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($licencias as $licencia): ?>
                                <tr>
                                    <td style="text-align: center;">
                                        <img src="../dist/img/codigo/<?= $licencia['licencia'] ?>.png"
                                        style="max-width: 400px;">
                                    </td>
                                    <td><?php echo $licencia['nombre_empresa']; ?></td>
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

<?php include "../Template/footer.php"; ?>