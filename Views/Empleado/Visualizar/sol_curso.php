<?php 
include "../Template/header.php"; 
require_once ("../../../Config/conexion.php");
$DataBase = new Database;
$con = $DataBase->conectar();

// Consulta para obtener las llamadas de software con id_est = 4
$consulta_software = "SELECT llamadas.*, tipo_daño.nombredano AS tipo_daño_nombre, usuario.nombre AS nombre_usuario 
                      FROM llamadas 
                      INNER JOIN tipo_daño ON llamadas.id_daño = tipo_daño.id_daño 
                      INNER JOIN categoria ON tipo_daño.id_categoria = categoria.id_cat 
                      INNER JOIN usuario ON llamadas.documento = usuario.documento
                      WHERE categoria.tip_cat = 'SOFTWARE' AND llamadas.id_est = 3";
$resultado_software = $con->query($consulta_software);

// Consulta para obtener las llamadas de hardware con id_est = 4
$consulta_hardware = "SELECT llamadas.*, tipo_daño.nombredano AS tipo_daño_nombre, usuario.nombre AS nombre_usuario 
                      FROM llamadas 
                      INNER JOIN tipo_daño ON llamadas.id_daño = tipo_daño.id_daño 
                      INNER JOIN categoria ON tipo_daño.id_categoria = categoria.id_cat 
                      INNER JOIN usuario ON llamadas.documento = usuario.documento
                      WHERE categoria.tip_cat = 'HARDWARE' AND llamadas.id_est = 3";
$resultado_hardware = $con->query($consulta_hardware);

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
          <h1 class="m-0">Solicitudes en proceso</h1>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">SOFTWARE</h3>
            </div>
            <div class="card-body">
              <ul class="recent-posts">
                <?php while ($fila = $resultado_software->fetch(PDO::FETCH_ASSOC)): ?>
                  <li>
                      <div class="article-post">
                        <p>Llamada N°<?php echo $fila['id_llamada']; ?></p>
                        <button class="btn btn-primary float-right"><a href="crear_ticket.php?id_llamada=<?php echo $fila['id_llamada']; ?>&fecha_inicio=<?php echo date('Y-m-d H:i:s'); ?>">Empezar llamada</a></button>
                        <span class="user-info">
                          <span>By:</span> <?php echo $fila['nombre_usuario']; ?> /
                          <span>Fecha:</span> <?php echo $fila['fecha']; ?> 
                        <p><?php echo $fila['tipo_daño_nombre']; ?></p>
                      </div>
                  </li>
                <?php endwhile; ?>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">HARDWARE</h3>
            </div>
            <div class="card-body">
              <ul class="recent-posts">
                <?php while ($fila = $resultado_hardware->fetch(PDO::FETCH_ASSOC)): ?>
                  <li>
                      <div class="article-post">
                        <p>Llamada N°<?php echo $fila['id_llamada']; ?></p>
                        <button class="btn btn-primary float-right" onclick="actualizarEstado(<?php echo $fila['id_llamada']; ?>)">Empezar llamada</button>
                        <span class="user-info">
                          <span>By:</span> <?php echo $fila['nombre_usuario']; ?>  /
                          <span>Fecha:</span> <?php echo $fila['fecha']; ?> 
                        <p><?php echo $fila['tipo_daño_nombre']; ?></p>
                      </div>
                  </li>
                <?php endwhile; ?>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<?php include "../Template/footer.php"; ?>

<script src="../dist/js/sol_curso.js"></script>

</body>
</html>