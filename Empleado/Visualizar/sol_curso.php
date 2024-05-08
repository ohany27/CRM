<?php 
include "../Template/header.php"; 
require_once ("../../Config/conexion.php");
$DataBase = new Database;
$con = $DataBase->conectar();
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
                  <li>
                    <a href="llamada.php">
                      <div class="article-post"> <span class="user-info"> <span>By:</span> Ohany Garcia / <span>Fecha:</span> 12 Jun 2024 / <span>Hora:</span> 09:27 AM </span>
                        <p>Tipo de Daño</p>
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="llamada.php">
                      <div class="article-post"> <span class="user-info"> <span>By:</span> Ohany Garcia / <span>Fecha:</span> 12 Jun 2024 / <span>Hora:</span> 09:27 AM </span>
                        <p>Tipo de Daño</p>
                      </div>
                    </a>
                  </li>
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
                <li>
                  <a href="llamada.php">
                    <div class="article-post"> <span class="user-info"> <span>By:</span> Ohany Garcia / <span>Fecha:</span> 12 Jun 2024 / <span>Hora:</span> 09:27 AM </span>
                      <p>Tipo de Daño</p>
                    </div>
                  </a>
                </li>
                <li>
                  <a href="llamada.php">
                    <div class="article-post"> <span class="user-info"> <span>By:</span> Ohany Garcia / <span>Fecha:</span> 12 Jun 2024 / <span>Hora:</span> 09:27 AM </span>
                      <p>Tipo de Daño</p>
                    </div>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<?php include "../Template/footer.php"; ?>

</body>
</html>
