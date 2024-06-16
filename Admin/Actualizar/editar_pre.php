<?php
include("../../Config/validarSesion.php");
require_once("../../Config/conexion.php");
$Conexion = new Database;
$con = $Conexion->conectar();


$sql = $con->prepare("SELECT * FROM precios,tipo_daño WHERE  precios.id_daño = tipo_daño. id_daño AND id_pre = '" . $_GET['id_pre'] . "'");
$sql->execute();
$usua = $sql->fetch();
?>

<?php
//3
if (isset($_POST["update"])) {
    $precio = $_POST['precio'];
    //4
    $insertSQL = $con->prepare("UPDATE precios SET precio ='$precio' WHERE id_pre = '" . $_GET['id_pre'] . "'");
    $insertSQL->execute();
    echo '<script>alert ("Actualización exitosa.");</script>';
    echo '<script>window.location="../Visualizar/precios.php"</script>';
}


?>

<?php include "../Template/header.php"; ?>
<div class="formulario">
    <h1>Actualizar Riesgo</h1>
    <form method="POST" name="formreg" autocomplete="off">
        <div class="mb-3">
            <label for="id" class="form-label">ID</label>
            <input type="text" name="id" class="form-control" value="<?php echo $usua['id_pre'] ?>" readonly>
        </div>
        <div class="mb-3">
            <label for="daño" class="form-label">Tipo de daño</label>
            <input type="text" name="daño" class="form-control" value="<?php echo $usua['nombre'] ?>" readonly>
        </div>
        <div class="mb-3">
            <label for="precio" class="form-label">Precio</label>
            <input type="text" name="precio" class="form-control" value="<?php echo $usua['precio'] ?>">
        </div>
        <br>
        <input type="submit" name="update" value="Actualizar" class="btn btn-primary">
        <input type="hidden" name="MM_insert" value="formreg">
    </form>
</div>

<?php include "../Template/footer.php"; ?>