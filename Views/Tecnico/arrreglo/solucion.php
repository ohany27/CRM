<?php 
include "../Template/header.php"; 
require_once ("../../Config/conexion.php");

// Conectar a la base de datos
$DataBase = new Database;
$con = $DataBase->conectar();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener el documento del usuario
    $documento = $_POST['documento'];

    // Obtener el estado seleccionado del formulario
    $id_estado = $_POST['estado'];

    // Actualizar el estado del usuario en la base de datos
    $query = "UPDATE usuario SET id_estado = :id_estado WHERE documento = :documento";
    $stmt = $con->prepare($query);
    $stmt->bindParam(':id_estado', $id_estado);
    $stmt->bindParam(':documento', $documento);
    $stmt->execute();

    // Obtener la descripción del empleado y la fecha de actualización del detalle_ticket
    $descripcion_empleado = $_POST['descripcion_empleado'];
    $fecha_actualizacion = date('Y-m-d H:i:s');

    // Actualizar la descripción del empleado en detalle_ticket
    $queryDetalleTicket = "UPDATE detalle_ticket SET descripcion_empleado = :descripcion_empleado, fecha_actualizacion = :fecha_actualizacion WHERE id_ticket = :id_ticket";
    $stmtDetalleTicket = $con->prepare($queryDetalleTicket);
    $stmtDetalleTicket->bindParam(':descripcion_empleado', $descripcion_empleado);
    $stmtDetalleTicket->bindParam(':fecha_actualizacion', $fecha_actualizacion);
    $stmtDetalleTicket->bindParam(':id_ticket', $documento); // Estoy asumiendo que el id_ticket es el mismo que el documento, pero podría ser diferente en tu base de datos
    $stmtDetalleTicket->execute();

    echo "<div class='alert alert-success'>Estado actualizado correctamente.</div>";
}

// Obtener el documento del usuario a editar
$documento = $_GET['documento'];

// Consultar los datos del usuario
$query = "SELECT documento, nombre, direccion, descripcion_tecnico, id_estado FROM usuario WHERE documento = :documento";
$stmt = $con->prepare($query);
$stmt->bindParam(':documento', $documento);
$stmt->execute();

$row = $stmt->fetch(PDO::FETCH_ASSOC);

// Consultar los estados disponibles
$queryEstados = "SELECT id_est, tip_est FROM estado";
$stmtEstados = $con->query($queryEstados);
$estados = $stmtEstados->fetchAll(PDO::FETCH_ASSOC);

// Definir la descripción del empleado como vacía
$descripcion_empleado = '';

// Consultar la fecha de actualización desde detalle_ticket
$fecha_actualizacion = '';

// Aquí se comienza el formulario de edición
?>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Editar Usuario</h1>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Editar Estado del Usuario</h3>
        </div>
        <div class="card-body">
          <form method="POST" action="">
            <div class="form-group">
              <label for="documento">Documento</label>
              <input type="text" class="form-control" id="documento" name="documento" value="<?php echo htmlspecialchars($row['documento']); ?>" readonly>
            </div>
            <div class="form-group">
              <label for="nombre">Nombre</label>
              <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($row['nombre']); ?>" readonly>
            </div>
            <div class="form-group">
              <label for="direccion">Direccion</label>
              <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo htmlspecialchars($row['direccion']); ?>" readonly>
            </div>
            <!-- Campo para editar el estado -->
            <div class="form-group">
              <label for="estado">Estado</label>
              <select class="form-control" id="estado" name="estado">
                <?php foreach ($estados as $estado) : ?>
                  <option value="<?php echo $estado['id_est']; ?>" <?php if ($estado['id_est'] == $row['id_estado']) echo 'selected'; ?>>
                    <?php echo $estado['tip_est']; ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <!-- Campo para editar la descripción del empleado (siempre vacío) -->
            <div class="form-group">
              <label for="descripcion_empleado">Descripción del Empleado</label>
              <textarea class="form-control" id="descripcion_empleado" name="descripcion_empleado" rows="4"><?php echo htmlspecialchars($descripcion_empleado); ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
          </form>
        </div>
      </div>
  </section>
</div>

<?php include "../Template/footer.php"; ?>
