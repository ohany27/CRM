<?php include "../Template/header.php"; ?>
<?php
require_once ("../../../Config/conexion.php");
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
        echo '<script>alert ("Detalle registrado exitosamente.");</script>';
        echo '<script>window.location = "../Visualizar/daño_detalle.php"</script>';
    }

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
                <form method="post" name="formreg">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">ID de Detalle</label>
                                    <input type="number" class="form-control" name="detalle" placeholder="Numero"
                                        readonly required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="daño">
                                        <label for="">Daños</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <label for="daño">
                                                    <select id="daño" class="form-control" name="daño"
                                                        placeholder="Daños:" required>
                                                        <option value="">Seleccione tipo de daño</option>
                                                        <?php
                                                        $control = $con->prepare("SELECT * From tipo_daño");
                                                        $control->execute();
                                                        while ($fila = $control->fetch(PDO::FETCH_ASSOC)) {
                                                            echo "<option value=" . $fila['id_daño'] . ">" . $fila['nombre'] . "</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </label>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="">Solucion</label>
                                    <input type="text" class="form-control" id="solucion" name="solucion"
                                        placeholder="Pasos De Solucion" required>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" name="inicio" class="btn btn-primary">Crear</button>
                        </div>
                        <input type="hidden" name="MM_insert" value="formreg">
                </form>

            </div>
        </div>
    </section>
</div>
<?php include "../Template/footer.php"; ?>