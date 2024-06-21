<?php
require_once "../Template/header.php";
require_once "../../../Config/conexion.php";

$DataBase = new Database;
$con = $DataBase->conectar();

// Verificar si la sesión está iniciada y obtener el documento del usuario
if (!isset($_SESSION['usuario']['documento'])) {
    header('Location: ../../../index.php');
    exit();
}
$nitc_usuario = $_SESSION['usuario']['documento'];

// Función para mostrar alertas en JavaScript desde PHP
function mostrarAlerta($mensaje)
{
    echo '<script>alert("' . $mensaje . '");</script>';
}

try {
    $consulta = "SELECT
                    detalle_ticket.id_ticket,
                    detalle_ticket.fecha_inicio,
                    CASE
                        WHEN detalle_ticket.id_riesgo = 1 THEN DATE_ADD(detalle_ticket.fecha_inicio, INTERVAL 4 DAY)
                        WHEN detalle_ticket.id_riesgo = 2 THEN DATE_ADD(detalle_ticket.fecha_inicio, INTERVAL 7 DAY)
                        WHEN detalle_ticket.id_riesgo = 3 THEN DATE_ADD(detalle_ticket.fecha_inicio, INTERVAL 10 DAY)
                    END AS fecha_vencimiento,
                    riesgos.tip_riesgo AS urgencia,
                    detalle_ticket.id_riesgo,  
                    tecnico.nombre AS tecnico_nombre,
                    tecnico.documento AS tecnico_documento,
                    usuario.nombre AS cliente, 
                    usuario.documento AS cliente_documento,
                    tipo_daño.nombredano AS tipo_problema, 
                    detalle_ticket.descripcion_detalle AS descripcion, 
                    estado.tip_est AS estado
                FROM
                    llamadas
                    INNER JOIN detalle_ticket ON llamadas.id_ticket = detalle_ticket.id_ticket
                    INNER JOIN usuario AS tecnico ON detalle_ticket.documento = tecnico.documento
                    INNER JOIN usuario ON llamadas.documento = usuario.documento
                    INNER JOIN tipo_daño ON llamadas.id_daño = tipo_daño.id_daño
                    INNER JOIN estado ON detalle_ticket.id_estado = estado.id_est
                    INNER JOIN riesgos ON detalle_ticket.id_riesgo = riesgos.id_riesgo
                WHERE
                    detalle_ticket.id_estado = 4
                    AND detalle_ticket.fecha_final IS NULL";
    $stmt = $con->query($consulta);
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log('Error en la consulta SQL: ' . $e->getMessage());
    mostrarAlerta('Error al obtener las solicitudes en curso. Por favor, inténtelo de nuevo.');
}
?>

<!-- Contenido HTML y JavaScript -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Solicitudes En curso</h1>
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
                                <th>N° de Ticket</th>
                                <th>Urgencia</th>
                                <th>Fecha y Hora inicialización</th>
                                <th>Fecha de Vencimiento</th>
                                <th>Cliente</th>
                                <th>Documento del Cliente</th>
                                <th>Tipo de Problema</th>
                                <th>Descripción</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($resultado as $fila): ?>
                                <?php
                                // Determinar el color según el nivel de urgencia para la fecha de finalización
                                $color_fecha_finalizacion = '';
                                switch ($fila["id_riesgo"]) {
                                    case 1:
                                        $color_fecha_finalizacion = 'red';
                                        break;
                                    case 2:
                                        $color_fecha_finalizacion = 'yellow';
                                        break;
                                    case 3:
                                        $color_fecha_finalizacion = 'green';
                                        break;
                                    default:
                                        $color_fecha_finalizacion = 'black';
                                        break;
                                }
                                ?>
                                <tr>
                                    <td><?= $fila["id_ticket"] ?></td>
                                    <td><?= $fila["urgencia"] ?></td>
                                    <td><?= $fila["fecha_inicio"] ?></td>
                                    <td style="color: <?= $color_fecha_finalizacion ?>;"><?= $fila["fecha_vencimiento"] ?>
                                    </td>
                                    <td><?= $fila["cliente"] ?></td>
                                    <td><?= $fila["cliente_documento"] ?></td>
                                    <td><?= $fila["tipo_problema"] ?></td>
                                    <td><?= $fila["descripcion"] ?></td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-open-modal" data-toggle="modal"
                                            data-target="#modalVerificarPIN"
                                            data-documento="<?= $fila["cliente_documento"] ?>"
                                            data-ticket="<?= $fila["id_ticket"] ?>"
                                            data-riesgo="<?= $fila["id_riesgo"] ?>"
                                            data-fechainicio="<?= $fila["fecha_inicio"] ?>">Solucionar</button>

                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal para Verificar PIN -->
<div class="modal fade" id="modalVerificarPIN" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Verificación de PIN</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formVerificarPIN">
                    <div class="form-group">
                        <label for="inputPIN">Ingrese el PIN</label>
                        <input type="number" class="form-control" id="inputPIN" required>
                    </div>
                    <input type="hidden" id="clienteDocumento" value="">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnVerificarPIN">Verificar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Agregar Registro -->
<div class="modal fade" id="modalAgregarRegistro" tabindex="-1" role="dialog" aria-labelledby="modalAgregarRegistroLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAgregarRegistroLabel">Agregar Registro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formAgregarRegistro" action="agregar_registro.php" method="POST">
                    <input type="hidden" id="modal-ticket-id" name="id_ticket" value="">
                    <input type="hidden" name="documento" value="<?php echo $nitc_usuario; ?>">
                    <input type="hidden" id="modal-riesgo-id" name="id_riesgo_modal" value="">
                    <input type="hidden" id="fecha-inicio" name="fecha_inicio" value="">
                    <input type="hidden" id="fecha-final" name="fecha_final" value="">
                    <input type="hidden" name="id_estado" value="5">
                    <div class="form-group">
                        <label for="descripcion_detalle">Descripción Detalle</label>
                        <textarea class="form-control" id="descripcion_detalle" name="descripcion_detalle" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" id="btn-finalizar" disabled>Finalizar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        // Abre la ventana modal y establece el documento del cliente
        $('.btn-open-modal').click(function () {
            var documento = $(this).data('documento');
            $('#clienteDocumento').val(documento);

            // Configurar datos para el modal de agregar registro
            var ticketId = $(this).data('ticket');
            var riesgoId = $(this).data('riesgo');
            var fechaInicio = $(this).data('fechainicio');

            $("#modal-ticket-id").val(ticketId);
            $("#modal-riesgo-id").val(riesgoId);
            $("#fecha-inicio").val(fechaInicio);
            $("#fecha-final").val(""); // Reiniciamos la fecha final
            $("#btn-finalizar").prop("disabled", true); // Deshabilitamos el botón Finalizar
        });

        // Verifica el PIN
        $('#btnVerificarPIN').click(function () {
            var pin = $('#inputPIN').val();
            var documento = $('#clienteDocumento').val();

            if (pin && documento) {
                $.ajax({
                    url: 'verificar_pin.php',
                    type: 'POST',
                    data: {
                        pin: pin,
                        documento: documento
                    },
                    success: function (response) {
                        response = JSON.parse(response);
                        if (response.success) {
                            alert('PIN correcto');
                            // Cierra la modal de verificación de PIN
                            $('#modalVerificarPIN').modal('hide');
                            // Abre la ventana modal de agregar registro
                            $('#modalAgregarRegistro').modal('show');
                        } else {
                            alert('PIN incorrecto');
                        }
                    },
                    error: function () {
                        alert('Error al verificar el PIN');
                    }
                });
            } else {
                alert('Por favor ingrese el PIN');
            }
        });

        // Habilitar el botón Finalizar cuando se ingresa una descripción en el textarea
        $(document).on("input", "#descripcion_detalle", function () {
            var descripcion = $(this).val().trim();
            if (descripcion !== "") {
                $("#btn-finalizar").prop("disabled", false);
            } else {
                $("#btn-finalizar").prop("disabled", true);
            }
        });

        // Manejar la actualización de la fecha final al hacer clic en el botón Finalizar
        $(document).on("click", "#btn-finalizar", function () {
            var fechaFinal = new Date().toISOString().slice(0, 19).replace('T', ' '); // Obtiene la fecha y hora actual en formato yyyy-mm-dd HH:MM:SS
            $("#fecha-final").val(fechaFinal);
        });
    });
</script>

<?php
require_once "../Template/footer.php";
?>
