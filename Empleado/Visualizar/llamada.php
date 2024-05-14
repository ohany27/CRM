<?php 
require_once ("../../Config/conexion.php");
$DataBase = new Database;
$con = $DataBase->conectar();

// Consulta para obtener datos del ticket y la llamada relacionada
$sql = $con->prepare("SELECT * FROM ticket
    INNER JOIN llamadas ON ticket.id_llamada = llamadas.id_llamada
    INNER JOIN usuario ON llamadas.documento = usuario.documento
    INNER JOIN tipo_daño ON llamadas.id_daño = tipo_daño.id_daño
    INNER JOIN detalle_daño ON llamadas.id_daño = detalle_daño.id_daño
    WHERE ticket.id = :id");
$sql->bindParam(':id', $_GET['id']);
$sql->execute();
$usua = $sql->fetch();

// Consulta para obtener los pasos de solución
$sql = $con->prepare("
    SELECT pasos_solucion 
    FROM detalle_daño 
    WHERE id_daño = ?
");
$sql->execute([$usua['id_daño']]); // Pasar el valor de id_daño como un parámetro
$pasos_solucion = $sql->fetchAll(PDO::FETCH_COLUMN);

// Manejar la lógica de inserción de datos cuando se envía el formulario
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "formreg")) {
    $fecha_final = $_POST['fecha_final'];
    $estado = $_POST['estado'];
    $urgencia = $_POST['urgencia'];
    $tecnico = $_POST['tecnico'];
    $descripcion = $_POST['descripcion'];

    if ($estado == 5) { // Estado "Solucionado"
        // Insertar datos en la tabla detalle_ticket con valores NULL en id_tecnico y id_riesgo
        $insertSQL = $con->prepare("INSERT INTO detalle_ticket (id_ticket, id_tecnico, id_riesgo, fecha, descripcion) VALUES (:id_ticket, NULL, NULL, NOW(), :descripcion)");
        $insertSQL->bindParam(':id_ticket', $usua['id_ticket']);
        $insertSQL->bindParam(':descripcion', $descripcion);
        $insertSQL->execute();
        // Actualizar la fecha final en la tabla ticket
        $updateSQL = $con->prepare("UPDATE ticket SET fecha_final = NOW(), id_estado = 5 WHERE id = :id");
        $updateSQL->bindParam(':id', $_GET['id']);
        $updateSQL->execute();

        // Actualizar el estado en la tabla llamadas
        $updateLlamadaSQL = $con->prepare("UPDATE llamadas SET id_est = 5 WHERE id_llamada = :id_llamada");
        $updateLlamadaSQL->bindParam(':id_llamada', $usua['id_llamada']);
        $updateLlamadaSQL->execute();

        // Redirigir a la página de tickets solucionados
        header("Location: sol_solucionadas.php");
        exit(); // Detener la ejecución del script después de redirigir
    } elseif ($estado == 4) { // Estado "En proceso"
        // Insertar datos en la tabla detalle_ticket
        $insertSQL = $con->prepare("INSERT INTO detalle_ticket (id_ticket, id_tecnico, id_riesgo, fecha, descripcion) VALUES (:id_ticket, :id_tecnico, :id_riesgo, NOW(), :descripcion)");
        $insertSQL->bindParam(':id_ticket', $usua['id_ticket']);
        $insertSQL->bindParam(':id_tecnico', $tecnico);
        $insertSQL->bindParam(':id_riesgo', $urgencia);
        $insertSQL->bindParam(':descripcion', $descripcion);
        $insertSQL->execute();

        // Redirigir a la página de tickets en proceso
        header("Location: tickets_proceso.php");
        exit(); // Detener la ejecución del script después de redirigir
    }

    echo '<script>alert("Datos registrados exitosamente.");</script>';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Llamada</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../dist/css/llamada.css">
</head>
<body>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <div class="container padding-bottom-3x mb-2">
        <div class="row">
            <div class="col-lg-4">
                <aside class="aside">
                    <h5 class="text-center">Ticket</h5>
                    <form class="formulario" enctype="multipart/form-data" method="post">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="numeroticket">N° Ticket</label>
                                    <input type="text" class="form-control" id="numeroticket" name="numeroticket" value="<?php echo $usua['id_ticket']?>" readonly>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="llamada">N° Llamada</label>
                                    <input type="text" class="form-control" id="llamada" name="numerollamada" value="<?php echo $usua['id_llamada']?>" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="fecha_inicial">Fecha Inicial</label>
                                    <input type="text" class="form-control" id="fecha_inicial" name="fecha_inicial" value="<?php echo $usua['fecha_inicio']?>" readonly>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="fecha_final">Fecha Final</label>
                                    <input type="text" class="form-control" name="fecha_final" id="fecha_final" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="estado">Estado</label>
                            <select name="estado" id="id_estado" class="form-control">
                                <?php
                                // Consulta para obtener todos los estados disponibles
                                $sql_estados = $con->prepare("SELECT * FROM estado WHERE id_est IN (4, 5)");
                                $sql_estados->execute();
                                // Recorre los resultados y muestra cada estado como una opción en el menú desplegable
                                while ($estado = $sql_estados->fetch(PDO::FETCH_ASSOC)) {
                                    // Verifica si el estado actual coincide con el estado del ticket
                                    $selected = ($estado['id_est'] == $usua['id_estado']) ? "selected" : "";
                                    // Imprime la opción del estado
                                    echo "<option value='" . $estado['id_est'] . "' $selected>" . $estado['tip_est'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <h5 class="text-center">Detalle Ticket</h5>
                        <div class="form-group">
                            <label for="urgencia">Urgencia</label>
                            <select class="form-control" id="urgencia" name="urgencia">
                                <option value="">Seleccione</option>
                                <?php
                                // Consulta para obtener los riesgos
                                $control = $con->prepare("SELECT * FROM riesgos");
                                $control->execute();
                                while ($fila = $control->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value=" . $fila['id_riesgo'] . ">" . $fila['tip_riesgo'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tecnico">Técnicos</label>
                            <select class="form-control" id="tecnico" name="tecnico">
                                <option value="">Seleccione al técnico</option>
                                <?php
                                // Consulta para obtener los técnicos
                                $control = $con->prepare("SELECT * FROM usuario WHERE id_tip_usu = 4");
                                $control->execute();
                                while ($fila = $control->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value='" . $fila['id_tip_usu'] . "'>" . $fila['nombre'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="descripcion">¿Qué pasó con el problema?</label>
                            <textarea class="form-control form-control-rounded" id="review_text" rows="8" placeholder="Write your message here..." required="" name="descripcion"></textarea>
                        </div>
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary">Crear</button>
                            <input type="hidden" name="MM_insert" value="formreg">
                        </div>
                    </form>  
                </aside>
            </div>
            <div class="col-lg-8">
                <div class="padding-top-2x mt-2 hidden-lg-up"></div>
                <div class="table-responsive margin-bottom-2x">
                    <table class="table margin-bottom-none">
                        <thead>
                            <tr>
                                <th class="text-center">Fecha</th>
                                <th class="text-center">Tipo de Problema</th>
                                <th class="text-center">Número de Teléfono</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center"><?php echo $usua['fecha']?></td>
                                <td class="text-center"><?php echo $usua['nombredano']?></td>
                                <td class="text-center"><?php echo $usua['telefono']?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="comment">
                    <div class="comment-author-ava"><img src="https://bootdey.com/img/Content/avatar/avatar6.png" alt="Avatar"></div>
                    <div class="comment-body">
                        <p class="comment-text"><?php echo $usua['descripcion']?></p>
                        <div class="comment-footer"><span><?php echo $usua['nombre']?></span></div>
                    </div>
                </div>
                <div class="text-center w-100">
                    <h5 class="mb-30 padding-top-1x">Soluciones</h5>
                    <form method="post">
                        <div class="form-group">
                            <?php 
                            $numeroPaso = 1; // Variable para numeración
                            foreach ($pasos_solucion as $solucion): ?>
                                <div class="solution-box">
                                    <p><span><?php echo $numeroPaso; ?>.</span> <?php echo $solucion; ?></p>
                                </div>
                                <?php $numeroPaso++; // Incrementar número de paso ?>
                            <?php endforeach; ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script src="../dist/js/llamada.js"></script>
</body>
</html>
