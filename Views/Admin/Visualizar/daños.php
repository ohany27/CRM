<?php include "../Template/header.php"; ?>
<?php
require_once ("../../../Config/conexion.php");
$DataBase = new Database;
$con = $DataBase->conectar();

$nitc_usuario = $_SESSION['usuario']['nitc'];

// Preparar la consulta SQL con un JOIN adicional para obtener el campo tip_riesgo
$consulta = $con->prepare("
    SELECT tipo_daño.*, categoria.tip_cat, riesgos.tip_riesgo
    FROM tipo_daño
    INNER JOIN categoria ON tipo_daño.id_categoria = categoria.id_cat
    INNER JOIN riesgos ON tipo_daño.id_riesgos = riesgos.id_riesgo
    WHERE tipo_daño.nitc = :nitc
");

$consulta->bindParam(':nitc', $nitc_usuario, PDO::PARAM_STR);
$consulta->execute();
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Daños Registrados</h1>
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
                                <th>Tipos de Daños</th>
                                <th>Categoría</th>
                                <th>Foto</th>
                                <th>Precio</th>
                                <th>Nivel De Riesgo</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
                                echo '
                                <tr>
                                    <td>' . htmlspecialchars($fila["nombredano"]) . '</td>
                                    <td>' . htmlspecialchars($fila["tip_cat"]) . '</td>
                                    <td><img src="data:image/jpeg;base64,' . base64_encode($fila["foto"]) . '" width="200" height="100" alt="Foto de daño"></td>
                                    <td>' . htmlspecialchars($fila["precio"]) . '</td>
                                    <td>' . htmlspecialchars($fila["tip_riesgo"]) . '</td>
                                    <td class="project-actions text-center">';
                                    
                                    // Lógica para el botón de activar o desactivar según el estado
                                    if ($fila["estado"] == 2) {
                                        // Estado 1: Botón para activar
                                        echo '
                                        <a href="../Eliminar/Adaños.php?id_daño=' . htmlspecialchars($fila["id_daño"]) . '" class="btn btn-success btn-sm">
                                            <i class="fas fa-check"></i> Activar
                                        </a>';
                                    } elseif ($fila["estado"] == 1) {
                                        // Estado 2: Botón para desactivar
                                        echo '
                                        <a href="../Eliminar/Ddaños.php?id_daño=' . htmlspecialchars($fila["id_daño"]) . '" class="btn btn-danger btn-sm">
                                            <i class="fas fa-times"></i> Desactivar
                                        </a>';
                                    }

                                    echo '
                                        <a href="../Editar/daños.php?id_daño=' . htmlspecialchars($fila["id_daño"]) . '" class="btn btn-info btn-sm">
                                            <i class="fas fa-pencil-alt"></i> Editar
                                        </a>
                                    </td>
                                </tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
<?php include "../Template/footer.php"; ?>