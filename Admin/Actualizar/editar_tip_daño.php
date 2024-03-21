<?php
include("../../Config/validarSesion.php");
require_once("../../Config/conexion.php");
$Conexion = new Database;
$con = $Conexion->conectar();


$sql = $con->prepare("SELECT * FROM tipo_daño WHERE id_daño = '" . $_GET['id_daño'] . "'");
$sql->execute();
$usua = $sql->fetch();
?>

<?php
//3
if (isset($_POST["update"])) {
    $id = $_POST['id'];
    $tipo = $_POST['tipo'];
    //4
    $insertSQL = $con->prepare("UPDATE tipo_daño SET id_daño = '$id', nombre = '$tipo' WHERE id_daño = '" . $_GET['id_daño'] . "'");
    $insertSQL->execute();
    echo '<script>alert ("Actualización exitosa.");</script>';
    echo '<script>window.location="../Visualizar/tipo_daño.php"</script>';
} 

?>
<?php include "../Template/header.php"; ?>
<div class="formulario">
    <h1>Actualizar Tipo de daño</h1>
    <form method="POST" name="formreg" autocomplete="off">
        <div class="mb-3">
            <label for="id" class="form-label">ID</label>
            <input type="text" name="id" class="form-control" value="<?php echo $usua['id_daño'] ?>" readonly>
        </div>
        <div class="mb-3">
            <label for="tipo" class="form-label">Tipo de daño</label>
            <input type="text" name="tipo" class="form-control" value="<?php echo $usua['nombre'] ?>">
        </div>
        <br>
        <input type="submit" name="update" value="Actualizar" class="btn btn-primary">
        <input type="hidden" name="MM_insert" value="formreg">
    </form>
</div>

<?php include "../Template/footer.php"; ?>