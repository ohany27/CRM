</div>
</div>
</div>
</div>
<div class="col-xl-4">
    <div class="card">
        <div class="card-body">
            <div class="pb-2">
                <h4 class="card-title mb-3">Nuevo Software</h4>

                <p>Nos alegra anunciar nuestro nuevo sistema de atención al cliente, que promete mejorar nuestra
                    plataforma CRM. Ahora, puedes contactar directamente a nuestros empleados para generar y dar
                    seguimiento a tus solicitudes de tickets.</p>

                <ul class="ps-3 mb-0">
                    <li><a href="#" class="__cf_email__" data-cfemail="105a717e637867757c7c635060627f7279733e737f7d"
                            data-bs-toggle="modal" data-bs-target="#modalTerminosCondiciones">[Terminos y
                            Condiciones]</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div>
                <h4 class="card-title mb-4"><a class="perfil" href="../Visualizar/perfil.php"><i
                            class="mdi mdi-account-circle mdi-18px">
                            Datos Personales
                        </i></a></h4>
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <tbody>
                            <tr>
                                <th scope="row">Nombre</th>
                                <td><?php echo $_SESSION['usuario']['nombre']; ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Correo</th>
                                <td><?php echo $_SESSION['usuario']['correo']; ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Direccion</th>
                                <td><?php echo $_SESSION['usuario']['direccion']; ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Telefono</th>
                                <td>+57 <?php echo $_SESSION['usuario']['telefono']; ?></td>
                            </tr>
                            <tr>
                                <th scope="row">Empresa</th>
                                <td><?php echo $nombre_empresa; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div>
                <h4 class="card-title mb-4"><i class="<?php echo $clase_icono_empleados; ?>"></i>Empleados </h4>
                <ul class="list-unstyled work-activity mb-0">
                    <li class="work-item" data-date="2024">
                        <h6 class="lh-base mb-0"><?php echo $total_empleados; ?></h6>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div>
                <h4 class="card-title mb-4"><i class="<?php echo $clase_icono_tecnicos; ?>"></i>Tecnicos
                </h4>
                <ul class="list-unstyled work-activity mb-0">
                    <li class="work-item" data-date="2024">
                        <h6 class="lh-base mb-0"><?php echo $total_tecnicos; ?> </h6>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<!-- Modal de Términos y Condiciones -->
<div class="modal fade" id="modalTerminosCondiciones" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Términos y Condiciones</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ol>
                    <li><strong>Aceptación de los Términos:</strong> Al acceder y utilizar nuestro CRM para aparatos
                        tecnológicos (hardware) y software, aceptas cumplir y estar sujeto a estos términos y
                        condiciones. Si no estás de acuerdo con alguna parte de estos términos, no podrás acceder al
                        CRM ni utilizar nuestros servicios.</li>
                    <li><strong>Uso del CRM:</strong> Nuestro CRM está destinado para el seguimiento de tickets de
                        soporte técnico, gestión de llamadas, y otras actividades relacionadas con la atención al
                        cliente en el contexto de aparatos tecnológicos y software. Queda prohibido utilizar el CRM
                        con cualquier fin ilegal o no autorizado.</li>
                    <li><strong>Responsabilidades del Usuario:</strong> Eres responsable de mantener la
                        confidencialidad de tu cuenta y contraseña, y de todas las actividades que ocurran bajo tu
                        cuenta. Debes notificarnos de inmediato sobre cualquier uso no autorizado de tu cuenta o
                        cualquier otra violación de seguridad.</li>
                    <li><strong>Privacidad:</strong> Nos comprometemos a proteger tu privacidad y tus datos
                        personales de acuerdo con nuestra política de privacidad. Sin embargo, al utilizar nuestro
                        CRM, aceptas que podamos recopilar, almacenar y utilizar cierta información personal de
                        acuerdo con dicha política.</li>
                    <li><strong>Propiedad Intelectual:</strong> Todo el contenido del CRM, incluidos textos,
                        gráficos, logotipos, iconos, imágenes, clips de audio y video, y software, es propiedad de
                        nuestra empresa o de sus proveedores y está protegido por las leyes de propiedad
                        intelectual.</li>
                    <li><strong>Limitación de Responsabilidad:</strong> En ningún caso seremos responsables ante ti
                        o cualquier tercero por daños indirectos, incidentales, especiales, ejemplares o
                        consecuentes que surjan del uso o la imposibilidad de utilizar nuestro CRM.</li>
                    <li><strong>Modificaciones:</strong> Nos reservamos el derecho de modificar o revisar estos
                        términos y condiciones en cualquier momento sin previo aviso. El uso continuado del CRM
                        después de cualquier cambio constituye tu aceptación de dichos cambios.</li>
                </ol>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript"></script>

<script>
    function showDetails(descripcion, nombre_empleado) {
        document.getElementById('descripcion').innerHTML = '<strong>Descripción:</strong> ' + descripcion;
        $('.bs-example-new-project').modal('show'); // Activar la ventana modal
    }
</script>
<script>
    $(document).ready(function () {
        // Script para activar el modal de Términos y Condiciones al hacer clic en el enlace
        $('#modalTerminosCondiciones').on('show.bs.modal', function (e) {
            // Aquí puedes realizar alguna acción si es necesario antes de mostrar el modal
        });
    });
</script>
<script>
    function mostrarImagen() {
        var tipoDanioSelect = document.getElementById("inputState");
        var danioSeleccionado = document.getElementById("danioSeleccionado");
        var idTipoDanio = tipoDanioSelect.value;

        // Limpiar contenido anterior
        danioSeleccionado.innerHTML = '';

        if (idTipoDanio) {
            <?php foreach ($tipo_daño as $tipo): ?>
                if ('<?php echo $tipo['id_daño']; ?>' === idTipoDanio) {
                    var img = document.createElement("img");
                    img.src = 'data:image/jpeg;base64,' + '<?php echo base64_encode($tipo["foto"]); ?>';
                    img.alt = '<?php echo $tipo["nombredano"]; ?>';
                    img.width = 200;
                    img.height = 200;
                    danioSeleccionado.appendChild(img);
                }
            <?php endforeach; ?>
        }
    }
</script>
</body>

</html>