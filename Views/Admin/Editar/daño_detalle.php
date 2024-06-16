<?php include "../Template/header.php"; ?>
<?php
require_once("../../../Config/conexion.php");
$Conexion = new Database;
$con = $Conexion->conectar();


$sql = $con->prepare("SELECT detalle_daño.*, tipo_daño.nombredano 
                    FROM detalle_daño 
                    JOIN tipo_daño ON detalle_daño.id_daño = tipo_daño.id_daño 
                    WHERE detalle_daño.id_detalle_daño = ?");
$sql->execute([$_GET['id_detalle_daño']]);
$usua = $sql->fetch();
?>

<?php
//3
if (isset($_POST["update"])) {
    $solucion = $_POST['solucion'];

    //4
    $insertSQL = $con->prepare("UPDATE detalle_daño SET pasos_solucion ='$solucion' WHERE id_detalle_daño = '" . $_GET['id_detalle_daño'] . "'");
    $insertSQL->execute();
    echo '<script>alert ("Actualización exitosa.");</script>';
    echo '<script>window.location="../Visualizar/daño_detalle.php"</script>';
}

?>


<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Crea Un Detalle De Daño</h1>
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
                <form id="formularioDetalle" method="post" name="formreg">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">ID de Detalle</label>
                                    <input type="number" class="form-control" name="detalle" placeholder="Numero" value="<?php echo $usua['id_detalle_daño'] ?>"
                                        readonly>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Nombre</label>
                                    <input type="text" class="form-control" name="nombre" placeholder="" value="<?php echo $usua['nombredano'] ?>"
                                        readonly>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="">Solucion</label>
                                    <input type="text" class="form-control" id="solucion" name="solucion" value="<?php echo $usua['pasos_solucion'] ?>"
                                        placeholder="Pasos De Solucion" required>
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
document.addEventListener('DOMContentLoaded', function () {
    var solucionInput = document.getElementById('solucion');
    solucionInput.addEventListener('input', function () {
        var solucionValue = solucionInput.value.replace(/\s/g, ''); // Remove all spaces
        if (solucionValue.length < 10) {
            solucionInput.setCustomValidity('La solución debe contener al menos 10 letras.');
        } else {
            solucionInput.setCustomValidity('');
        }
    });

    document.getElementById('formularioDetalle').addEventListener('submit', function (event) {
        var solucionValue = solucionInput.value.replace(/\s/g, ''); // Remove all spaces
        if (solucionValue.length < 10) {
            alert('La solución debe contener al menos 10 letras.');
            event.preventDefault();
        }
    });
});
</script>
<?php include "../Template/footer.php"; ?>