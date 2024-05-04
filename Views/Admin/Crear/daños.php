<?php include "../Template/header.php"; ?>
<?php
require_once("../../../Config/conexion.php");
$Conexion = new Database;
$con = $Conexion->conectar();

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formreg")) {
    $id = $_POST['id'];
    $tipo = $_POST['tipo'];
    $precio = $_POST['precio'];

    //4
    $sql = $con->prepare("SELECT * FROM tipo_daño WHERE id_daño='$id' or nombre='$tipo' or precio='$precio'");
    $sql->execute();
    $fila = $sql->fetchAll(PDO::FETCH_ASSOC);

    if ($tipo == "") {
        echo '<script>alert ("Hay campos vacios, llena los campos.");</script>';

    } else if ($fila) {
        echo '<script>alert ("Ese tipo de daño ya esta registrado.");</script>';
    } else {
        $insertSQL = $con->prepare("INSERT INTO tipo_daño (id_daño,nombre,precio) VALUES 
        ('$id','$tipo','$precio')");

        $insertSQL->execute();
        echo '<script>alert ("Tipo de daño registrado exitosamente.");</script>';
        echo '<script>window.location = "../Visualizar/daños.php"</script>';
    }

}
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Crea Un Daño</h1>
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
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="">ID de Daño</label>
                                    <input type="number" class="form-control" name="id" placeholder="Numero" readonly required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Nombre</label>
                                    <input type="text" class="form-control" id="tipo" name="tipo"
                                        placeholder="Nombre" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Precio</label>
                                    <input type="number" class="form-control" id="precio" name="precio"
                                        placeholder="Precios" required>
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
