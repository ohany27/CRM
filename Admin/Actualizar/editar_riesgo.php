<?php
include("../../Config/validarSesion.php");
require_once("../../Config/conexion.php");
$Conexion = new Database;
$con = $Conexion->conectar();


$sql = $con->prepare("SELECT * FROM riesgos WHERE id_riesgo = '" . $_GET['id_riesgo'] . "'");
$sql->execute();
$usua = $sql->fetch();
?>

<?php
//3
if (isset($_POST["update"])) {
    $id = $_POST['id'];
    $tipo = $_POST['tipo'];
    $hora = $_POST['hora'];
    //4
    $insertSQL = $con->prepare("UPDATE riesgos SET id_riesgo = '$id', tip_riesgo = '$tipo', tiempo_atent ='$hora' WHERE id_riesgo = '" . $_GET['id_riesgo'] . "'");
    $insertSQL->execute();
    echo '<script>alert ("Actualización exitosa.");</script>';
    echo '<script>window.location="../Visualizar/riesgos.php"</script>';
}

?>
<?php include "../Template/header.php"; ?>
<div class="formulario">
    <h1>Actualizar Riesgo</h1>
    <form method="POST" name="formreg" autocomplete="off">
        <div class="mb-3">
            <label for="id" class="form-label">ID</label>
            <input type="text" name="id" class="form-control" value="<?php echo $usua['id_riesgo'] ?>" readonly>
        </div>
        <div class="mb-3">
            <label for="tipo" class="form-label">Tipo de Riesgo</label>
            <input type="text" name="tipo" class="form-control" value="<?php echo $usua['tip_riesgo'] ?>">
        </div>
        <div class="mb-3">
            <label for="hora" class="form-label">Tiempo de Atentado</label>
            <input type="text" name="hora" class="form-control" value="<?php echo $usua['tiempo_atent'] ?>">
        </div>
        <br>
        <input type="submit" name="update" value="Actualizar" class="btn btn-primary">
        <input type="hidden" name="MM_insert" value="formreg">
    </form>
</div>

<?php include "../Template/footer.php"; ?>