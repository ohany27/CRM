<?php 
include "../Template/header.php";
require_once ("../../../Config/conexion.php");
$DataBase = new Database;
$con = $DataBase->conectar();

// Consulta para obtener las llamadas con id_est = 3 y id_empleado igual al usuario en sesión, agrupadas por riesgo
$consulta_llamadas = "SELECT llamadas.*, tipo_daño.nombredano AS tipo_daño_nombre, usuario.nombre AS nombre_usuario, riesgos.tip_riesgo, tipo_daño.id_riesgos AS id_riesgo
                      FROM llamadas 
                      INNER JOIN tipo_daño ON llamadas.id_daño = tipo_daño.id_daño 
                      INNER JOIN categoria ON tipo_daño.id_categoria = categoria.id_cat 
                      INNER JOIN usuario ON llamadas.documento = usuario.documento
                      INNER JOIN riesgos ON tipo_daño.id_riesgos = riesgos.id_riesgo
                      WHERE llamadas.id_est = 3 AND llamadas.id_empleado = :id_empleado";
$stmt_llamadas = $con->prepare($consulta_llamadas);
$stmt_llamadas->bindParam(':id_empleado', $_SESSION['usuario']['documento']);
$stmt_llamadas->execute();
$resultado_llamadas = $stmt_llamadas->fetchAll(PDO::FETCH_ASSOC);

// Clasificar las llamadas por riesgo
$llamadas_riesgo_alto = [];
$llamadas_riesgo_medio = [];
$llamadas_riesgo_bajo = [];

foreach ($resultado_llamadas as $fila) {
    if ($fila['id_riesgo'] == 1) { // 1 es Alto
        $llamadas_riesgo_alto[] = $fila;
    } elseif ($fila['id_riesgo'] == 2) { // 2 es Medio
        $llamadas_riesgo_medio[] = $fila;
    } elseif ($fila['id_riesgo'] == 3) { // 3 es Bajo
        $llamadas_riesgo_bajo[] = $fila;
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Título de la página</title>
  <link rel="stylesheet" href="../dist/css/sol_proceso.css"> 
</head>
<body>

<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">SOLICITUDES</h1>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- Riesgo Alto -->
        <div class="col-md-4">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title" id="alto">RIESGO ALTO</h3>
            </div>
            <div class="card-body">
              <ul class="recent-posts">
                <?php if ($llamadas_riesgo_alto): ?>
                  <?php foreach ($llamadas_riesgo_alto as $fila): ?>
                    <li>
                        <div class="article-post">
                          <p>Llamada N°<?php echo $fila['id_llamada']; ?></p>
                          <button class="btn btn-primary float-right" onclick="actualizarEstado(<?php echo $fila['id_llamada']; ?>)">Empezar llamada</button>
                          <span class="user-info">
                            <span>By:</span> <?php echo $fila['nombre_usuario']; ?> /
                            <span>Fecha:</span> <?php echo $fila['fecha']; ?> 
                          <p><?php echo $fila['tipo_daño_nombre']; ?></p>
                        </div>
                    </li>
                  <?php endforeach; ?>
                <?php else: ?>
                  <li>No se encontraron llamadas de alto riesgo para este empleado.</li>
                <?php endif; ?>
              </ul>
            </div>
          </div>
        </div>

        <!-- Riesgo Medio -->
        <div class="col-md-4">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title" id="medio">RIESGO MEDIO</h3>
            </div>
            <div class="card-body">
              <ul class="recent-posts">
                <?php if ($llamadas_riesgo_medio): ?>
                  <?php foreach ($llamadas_riesgo_medio as $fila): ?>
                    <li>
                        <div class="article-post">
                          <p>Llamada N°<?php echo $fila['id_llamada']; ?></p>
                          <button class="btn btn-primary float-right" onclick="actualizarEstado(<?php echo $fila['id_llamada']; ?>)">Empezar llamada</button>
                          <span class="user-info">
                            <span>By:</span> <?php echo $fila['nombre_usuario']; ?> /
                            <span>Fecha:</span> <?php echo $fila['fecha']; ?> 
                          <p><?php echo $fila['tipo_daño_nombre']; ?></p>
                        </div>
                    </li>
                  <?php endforeach; ?>
                <?php else: ?>
                  <li>No se encontraron llamadas de medio riesgo para este empleado.</li>
                <?php endif; ?>
              </ul>
            </div>
          </div>
        </div>

        <!-- Riesgo Bajo -->
        <div class="col-md-4">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title"id="bajo">RIESGO BAJO</h3>
            </div>
            <div class="card-body">
              <ul class="recent-posts">
                <?php if ($llamadas_riesgo_bajo): ?>
                  <?php foreach ($llamadas_riesgo_bajo as $fila): ?>
                    <li>
                        <div class="article-post">
                          <p>Llamada N°<?php echo $fila['id_llamada']; ?></p>
                          <button class="btn btn-primary float-right" onclick="actualizarEstado(<?php echo $fila['id_llamada']; ?>)">Empezar llamada</button>
                          <span class="user-info">
                            <span>By:</span> <?php echo $fila['nombre_usuario']; ?> /
                            <span>Fecha:</span> <?php echo $fila['fecha']; ?> 
                          <p><?php echo $fila['tipo_daño_nombre']; ?></p>
                        </div>
                    </li>
                  <?php endforeach; ?>
                <?php else: ?>
                  <li>No se encontraron llamadas de bajo riesgo para este empleado.</li>
                <?php endif; ?>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<?php include "../Template/footer.php"; ?>

<script src="../js/sol_curso.js"></script>

</body>
</html>
