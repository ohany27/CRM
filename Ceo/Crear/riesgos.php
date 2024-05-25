<?php include "../Template/header.php"; ?>
<?php
require_once ("../../Config/conexion.php");
$DataBase = new Database;
$con = $DataBase->conectar();



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoger los datos del formulario
    $tip_riesgo = $_POST['tip_riesgo'];
    $tiempo_atent = $_POST['tiempo_atent'];

    // Insertar los datos en la base de datos
    $consulta = "INSERT INTO riesgos (tip_riesgo, tiempo_atent) VALUES (:tip_riesgo, :tiempo_atent)";
    $stmt = $con->prepare($consulta);
    $stmt->bindParam(':tip_riesgo', $tip_riesgo);
    $stmt->bindParam(':tiempo_atent', $tiempo_atent);

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
                                    <input type="text" class="form-control" id="tip_riesgo" name="tip_riesgo"
                                        placeholder="Tipo de Riesgo" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="tiempo_atent">Tiempo de Atención</label>
                                    <input type="text" class="form-control" id="tiempo_atent" name="tiempo_atent"
                                        placeholder="Tiempo de Atención" required>
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
<script>
        document.addEventListener("DOMContentLoaded", function() {
            var nombreInput = document.getElementById("tip_riesgo");
            var tiempoRiesgoInput = document.getElementById("tiempo_atent");

            nombreInput.addEventListener("input", function() {
                var nombreRegex = /^[a-zA-Z\s]{3,}$/;
                if (!nombreRegex.test(nombreInput.value)) {
                    nombreInput.setCustomValidity("El nombre debe tener al menos 3 letras y no debe contener puntos ni números.");
                } else {
                    nombreInput.setCustomValidity("");
                }
            });

            tiempoRiesgoInput.addEventListener("input", function() {
                var tiempoRiesgoRegex = /^(?=.*[a-zA-Z])(?=.*\d).+$/;
                if (!tiempoRiesgoRegex.test(tiempoRiesgoInput.value)) {
                    tiempoRiesgoInput.setCustomValidity("El tiempo de riesgo debe contener tanto letras como números.");
                } else {
                    tiempoRiesgoInput.setCustomValidity("");
                }
            });
        });
    </script>
<?php include "../Template/footer.php"; ?>