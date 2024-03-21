<?php
include("../../Config/validarSesion.php");
require_once("../../Config/conexion.php");
$Conexion = new Database;
$con = $Conexion->conectar();
?>

<?php
//3
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formreg")) {
    $detalle = $_POST['detalle'];
    $daño = $_POST['daño'];
    $solucion = $_POST['solucion'];

    //4
    $sql = $con->prepare("SELECT * FROM detalle_daño WHERE id_detalle_daño='$detalle' or pasos_solucion='$solucion'");
    $sql->execute();
    $fila = $sql->fetchAll(PDO::FETCH_ASSOC);

    if ($daño == "" || $solucion == "") {
        echo '<script>alert ("Hay campos vacios, llena los campos.");</script>';

    } else if ($fila) {
        echo '<script>alert ("Esa solucion ya esta registrada.");</script>';
    } else {
        $insertSQL = $con->prepare("INSERT INTO detalle_Daño (id_detalle_daño, id_daño, pasos_solucion) VALUES 
        ('$detalle','$daño','$solucion')");

        $insertSQL->execute();
        echo '<script>alert ("Solucion daño registrado exitosamente.");</script>';
        echo '<script>window.location = "../Visualizar/detalle_daño.php"</script>';
    }

}
?>
<?php include "../Template/header.php"; ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="formulario">
                <h1 class="mb-4">Crear Solucion</h1>
                <form method="POST" name="formreg" autocomplete="off">
                    <div class="mb-3">
                        <label for="detalle" class="form-label">Id_detalle_daño</label>
                        <input type="text" name="detalle" class="form-control" id="detalle" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="daño" class="form-label">Seleccione tipo de daño</label>
                        <select name="daño" class="form-select" id="daño">
                            <option value="">Seleccione tipo de daño</option>
                            <?php
                            //2
                            $control = $con->prepare("SELECT * From tipo_daño");
                            $control->execute();
                            while ($fila = $control->fetch(PDO::FETCH_ASSOC)) {
                                echo "<option value=" . $fila['id_daño'] . ">" . $fila['nombre'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="solucion" class="form-label">Solución</label>
                        <input type="text" name="solucion" class="form-control" id="solucion" placeholder="Solución">
                    </div>
                    <button type="submit" name="inicio" class="btn btn-primary">Registrar</button>
                    <input type="hidden" name="MM_insert" value="formreg">
                </form>
            </div>
        </div>
    </div>
</div>

<?php include "../Template/footer.php"; ?>