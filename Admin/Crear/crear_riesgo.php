<?php
include("../../Config/validarSesion.php");
require_once("../../Config/conexion.php");
$Conexion = new Database;
$con = $Conexion->conectar();
?>

<?php
//3
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formreg")) {
    $id = $_POST['id'];
    $tipo = $_POST['tipo'];
    $hora = $_POST['hora'];

    //4
    $sql = $con->prepare("SELECT * FROM riesgos WHERE id_riesgo='$id' or tip_riesgo='$tipo' or tiempo_atent='$hora'");
    $sql->execute();
    $fila = $sql->fetchAll(PDO::FETCH_ASSOC);

    if ($tipo == "" || $hora == "") {
        echo '<script>alert ("Hay campos vacios, llena los campos.");</script>';

    } else if ($fila) {
        echo '<script>alert ("Ese tipo de riesgo ya esta registrado.");</script>';
    } else {
        $insertSQL = $con->prepare("INSERT INTO riesgos (id_riesgo,tip_riesgo,tiempo_atent) VALUES 
        ('$id','$tipo','$hora')");

        $insertSQL->execute();
        echo '<script>alert ("Tipo de riesgo registrado exitosamente.");</script>';
        echo '<script>window.location = "../Visualizar/riesgos.php"</script>';
    }

}
?>

<?php include "../Template/header.php"; ?>
<h1>Crear Riesgo</h1>

<div class="col-sm-12 col-md-8 offset-md-2">
    <form method="POST" name="formreg" autocomplete="off">
        <div class="mb-3">
            <label for="id" class="form-label">Id_Riesgo</label>
            <input type="text" name="id" class="form-control" placeholder="Id_Riesgo" readonly>
        </div>
        <div class="mb-3">
            <label for="tipo" class="form-label">Tipo de riesgo</label>
            <input type="text" name="tipo" class="form-control" placeholder="Tipo de riesgo">
        </div>
        <div class="mb-3">
            <label for="tiempo" class="form-label">Tiempo de Demora</label>
            <input type="text" name="hora" class="form-control" placeholder="Tiempo de Demora">
        </div>
        <br>
        <input type="submit" name="inicio" value="Registrar" class="btn btn-primary">
        <input type="hidden" name="MM_insert" value="formreg">
    </form>
</div>

<?php include "../Template/footer.php"; ?>