<?php include "../Template/header.php"; ?>

<?php
// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $DataBase = new Database;
        $con = $DataBase->conectar();

        // Obtener los datos del formulario
        $id_daño = $_POST['inputState']; // Obtener el id de daño seleccionado
        $descripcion = $_POST['descripcion']; // Obtener la descripción ingresada en el textarea
        $fecha = $_POST['fecha']; // Obtener la fecha desde el formulario

        // Verificar si los campos obligatorios están llenos
        if (empty($id_daño) || empty($descripcion) || empty($fecha)) {
            echo "<script>alert('Todos los campos son obligatorios');</script>";
            exit();
        }

        // Definir el id_est
        $id_est = 3; // Supongamos que el id_est siempre será 3

        // Obtener el documento del usuario desde la sesión
        $documento_usuario = $_SESSION['usuario']['documento'];

        // Obtener el nitc del usuario desde la sesión
        $nitc_usuario = $_SESSION['usuario']['nitc'];

        // Obtener un empleado aleatorio con id_tip_usu = 3 y el mismo nitc que el usuario
        $stmt_empleado = $con->prepare("SELECT documento FROM usuario WHERE id_tip_usu = 3 AND nitc = :nitc ORDER BY RAND() LIMIT 1");
        $stmt_empleado->bindParam(':nitc', $nitc_usuario, PDO::PARAM_STR);
        $stmt_empleado->execute();
        $empleado = $stmt_empleado->fetch(PDO::FETCH_ASSOC);

        // Verificar si se encontró un empleado
        if (!$empleado) {
            echo "<script>alert('No se encontró un empleado disponible'); window.location='../Visualizar/solicitud.php';</script>";
            exit();
        }

        // Obtener el documento del empleado seleccionado
        $documento_empleado = $empleado['documento'];

        // Preparar la consulta SQL
        $sql = "INSERT INTO llamadas (id_ticket, id_daño, id_est, fecha, descripcion, documento, id_empleado) VALUES (NULL, ?, ?, ?, ?, ?, ?)";

        // Preparar la declaración
        $stmt = $con->prepare($sql);

        // Vincular los parámetros
        $stmt->bindValue(1, $id_daño, PDO::PARAM_INT);
        $stmt->bindValue(2, $id_est, PDO::PARAM_INT);
        $stmt->bindValue(3, $fecha);
        $stmt->bindValue(4, $descripcion);
        $stmt->bindValue(5, $documento_usuario);
        $stmt->bindValue(6, $documento_empleado);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el número de filas afectadas
        $affected_rows = $stmt->rowCount();

        // Verificar si se realizó la inserción correctamente
        if ($affected_rows > 0) {
            echo "<script>alert('Llamada generada correctamente, por favor espere a que el empleado atienda su llamada'); window.location='../Visualizar/llamadas.php';</script>";
            exit();
        } else {
            echo "<script>alert('No se pudo generar la llamada'); window.location='../Visualizar/solicitud.php';</script>";
            exit();
        }
    } catch (PDOException $e) {
        echo "Error al crear la llamada: " . $e->getMessage();
    }
}

try {
    $db = new Database();
    $conn = $db->conectar();
    $stmt = $conn->query("SELECT id_daño, nombredano, foto, precio FROM tipo_daño");
    $tipo_daño = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<ul class="nav nav-tabs nav-tabs-custom border-bottom-0 mt-3 nav-justfied" role="tablist">
    <li class="nav-item" role="presentation">
        <a class="nav-link px-4 " href="../index.php">
            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
            <span class="d-none d-sm-block">Mis Tickets</span>
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link px-4" href="../Visualizar/llamadas.php">
            <span class="d-block d-sm-none"><i class="mdi mdi-menu-open"></i></span>
            <span class="d-none d-sm-block">Mis Llamadas </span>
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link px-4 active" href="../Visualizar/solicitud.php">
            <span class="d-block d-sm-none"><i class="mdi mdi-menu-open"></i></span>
            <span class="d-none d-sm-block">Empieza Una Solicitud </span>
        </a>
    </li>
</ul>
</div>
</div>
</div>
</div>
</div>
<div class="card">
    <div class="tab-content p-4">
        <div class="tab-pane active show" id="projects-tab" role="tabpanel">
            <div class="d-flex align-items-center">
                <div class="flex-1">
                    <h4 class="card-title mb-4">Genera Una Solicitud</h4>
                </div>
            </div>
            <div class="row" id="all-projects">
                <form method="post" onsubmit="return establecerFecha()">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="inputState">Seleccione el Tipo de Daño</label>
                            <select name="inputState" id="inputState" class="form-control" onchange="mostrarImagen()" required>
                                <option value="" disabled selected>Seleccione</option>
                                <!-- Obtener opciones de tipos de daño desde la base de datos -->
                                <?php foreach ($tipo_daño as $tipo): ?>
                                    <option value="<?php echo $tipo['id_daño']; ?>"><?php echo $tipo['nombredano']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <br>
                    </div>
                    <div id="danioSeleccionado" class="agente-seleccionado"></div>
                    <div class="form-group">
                        <label for="descripcion">Mensaje</label>
                        <textarea rows="4" cols="50" class="form-control" name="descripcion" id="descripcion" placeholder="Descripción" required></textarea>
                    </div>
                    <br>
                    <input type="hidden" id="fecha" name="fecha">
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </form>
            </div>

            <script>
                // Función para obtener la fecha y hora actual
                function obtenerFechaActual() {
                    const ahora = new Date();
                    const ano = ahora.getFullYear();
                    const mes = ('0' + (ahora.getMonth() + 1)).slice(-2);
                    const dia = ('0' + ahora.getDate()).slice(-2);
                    const horas = ('0' + ahora.getHours()).slice(-2);
                    const minutos = ('0' + ahora.getMinutes()).slice(-2);
                    const segundos = ('0' + ahora.getSeconds()).slice(-2);
                    return `${ano}-${mes}-${dia} ${horas}:${minutos}:${segundos}`;
                }

                // Función para establecer la fecha en el campo oculto
                function establecerFecha() {
                    document.getElementById('fecha').value = obtenerFechaActual();
                    return true; // Permite que el formulario se envíe
                }

                // Establecer la fecha al cargar la página
                document.addEventListener('DOMContentLoaded', function() {
                    document.getElementById('fecha').value = obtenerFechaActual();
                });
            </script>

            <?php include "../Template/footer.php"; ?>
