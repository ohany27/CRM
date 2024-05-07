<?php include "../Template/header.php"; ?>
<?php
require_once ("../../../Config/conexion.php");
$DataBase = new Database;
$con = $DataBase->conectar();
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Bienvenido Admin</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            
        </div>
    </section>
</div>
<?php include "../Template/footer.php"; ?>