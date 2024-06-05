<?php 
include "../Template/header.php"; 
require_once ("../../../Config/conexion.php");
$DataBase = new Database;
$con = $DataBase->conectar();
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Estados Registrados</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"></h3>
                </div>
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                            <th>Codigo Ticket</th> 
                            <th>Fecha Inicio</th>
                            <th>Fecha Final</th>
                            <th>Nombre Empleado</th>
                            <th>Nombre Cliente</th>
                            <th>Tipo de Problema</th>
                            <th>Direccion</th>
                            <th>Urgencia</th>
                            <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
    </section>
</div>
<?php include "../Template/footer.php"; ?>