<?php
include "../Template/header.php";

require_once ("../../../Config/conexion.php");
$DataBase = new Database;
$con = $DataBase->conectar();

// Get the NITC of the logged-in user from the session
$nitc_usuario = $_SESSION['usuario']['nitc'];

// Prepare the SQL query with a WHERE clause to filter based on NITC
$consulta = "SELECT * FROM usuario 
                INNER JOIN roles ON usuario.id_tip_usu = roles.id_tip_usu 
                WHERE usuario.nitc = '$nitc_usuario' 
                AND usuario.id_tip_usu > 1";

$resultado = $con->query($consulta);
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Usuarios Registrados </h1>
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
                                <th>Documento</th>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Teléfono</th>
                                <th>Dirección</th>
                                <th>NITC</th>
                                <th>Tipo Usuario</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $consulta = "SELECT usuario.*, empresa.nombre AS nombre_empresa, roles.tip_usu 
                            FROM usuario 
                            LEFT JOIN empresa ON usuario.nitc = empresa.nitc 
                            LEFT JOIN roles ON usuario.id_tip_usu = roles.id_tip_usu 
                            WHERE usuario.id_tip_usu > 1";
                            $resultado = $con->query($consulta);

                            while ($fila = $resultado->fetch()) {
                                echo '
                <tr>
                    <td>' . $fila["documento"] . '</td>
                    <td>' . $fila["nombre"] . '</td>
                    <td>' . (isset($fila["correo"]) ? $fila["correo"] : '') . '</td>
                    <td>' . $fila["telefono"] . '</td>
                    <td>' . $fila["direccion"] . '</td>
                    <td>' . ($fila["nombre_empresa"] ? $fila["nombre_empresa"] : $fila["nombre"]) . '</td>
                    <td>' . $fila["tip_usu"] . '</td>
                    <td class="project-actions text-center">
                                        <a href="../Editar/usuarios.php?id=' . $fila['documento'] . '" class="btn btn-info btn-sm" href="#">
                                            <i class="fas fa-pencil-alt"></i> Editar
                                        </a>
                                        <a href="../Eliminar/usuarios.php?id=' . $fila['documento'] . '" class="btn btn-danger btn-sm" href="#">
                                            <i class="fas fa-trash"></i> Eliminar
                                        </a>
                                    </td>
                </tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
    </section>
</div>

<?php include "../Template/footer.php"; ?>