<?php include "../Template/header.php"; ?>
<?php
require_once("../../Config/conexion.php");
$Conexion = new Database;
$con = $Conexion->conectar();

$sql = $con->prepare("SELECT * FROM riesgos WHERE id_riesgo = '" . $_GET['id_riesgo'] . "'");
$sql->execute();
$usua = $sql->fetch();

if (isset($_POST["update"])) {
    $id = $_POST['id'];
    $tipo = $_POST['tipo'];
    $hora = $_POST['hora'];
    $insertSQL = $con->prepare("UPDATE riesgos SET tip_riesgo = '$tipo', tiempo_atent ='$hora' WHERE id_riesgo = '" . $_GET['id_riesgo'] . "'");
    $insertSQL->execute();
    echo '<script>alert ("Actualización exitosa.");</script>';
    echo '<script>window.location="../Visualizar/riesgos.php"</script>';
}

?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Editar Un Riesgo</h1>
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
                <!-- /.card-header -->
                <!-- form start -->
                <form method="post">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Nombre</label>
                                    <input type="text" class="form-control" id="tipo" name="tipo" value="<?php echo $usua['tip_riesgo'] ?>"
                                        placeholder="Nombre" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Tiempo de Atentado</label>
                                    <input type="text" class="form-control" id="hora" name="hora" value="<?php echo $usua['tiempo_atent'] ?>"
                                        placeholder="Tiempo" required>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" name="update" class="btn btn-primary">Editar</button>
                        </div>
                        <input type="hidden" name="MM_insert" value="formreg">
                </form>
            </div>
        </div>
    </section>
</div>
<script>
        document.addEventListener("DOMContentLoaded", function() {
            var nombreInput = document.getElementById("tipo");
            var tiempoRiesgoInput = document.getElementById("hora");

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
