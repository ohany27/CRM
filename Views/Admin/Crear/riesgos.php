<?php include "../Template/header.php"; ?>
<?php
require_once("../../../Config/conexion.php");
$DataBase = new Database;
$con = $DataBase->conectar();

// Obtener el NITC del usuario que ha iniciado sesión desde la sesión
$nitc_usuario = $_SESSION['usuario']['nitc'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoger los datos del formulario
    $tip_riesgo = $_POST['tip_riesgo'];
    $tiempo_atent = $_POST['tiempo_atent'];
    
    // Insertar los datos en la base de datos
    $consulta = "INSERT INTO riesgos (tip_riesgo, tiempo_atent, nitc) VALUES (:tip_riesgo, :tiempo_atent, :nitc)";
    $stmt = $con->prepare($consulta);
    $stmt->bindParam(':tip_riesgo', $tip_riesgo);
    $stmt->bindParam(':tiempo_atent', $tiempo_atent);
    $stmt->bindParam(':nitc', $nitc_usuario);
    
    if ($stmt->execute()) {
        echo "<script>alert('Riesgo creado exitosamente'); window.location.href='../Visualizar/riesgos.php';</script>";
    } else {
        echo "<script>alert('Error al crear el riesgo');</script>";
    }
}
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Crear Nuevo Riesgo</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form method="post">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="tip_riesgo">Tipo de Riesgo</label>
                                    <input type="text" class="form-control" id="tip_riesgo" name="tip_riesgo" placeholder="Tipo de Riesgo" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="tiempo_atent">Tiempo de Atención</label>
                                    <input type="text" class="form-control" id="tiempo_atent" name="tiempo_atent" placeholder="Tiempo de Atención" required>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Crear</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include "../Template/footer.php"; ?>
