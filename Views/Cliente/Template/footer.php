</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="pb-2">
                            <h4 class="card-title mb-3">Nuevo Software</h4>
                            
                            <p>Nos alegra anunciar nuestro nuevo sistema de atención al cliente, que promete mejorar nuestra plataforma CRM. Ahora, puedes contactar directamente a nuestros empleados para generar y dar seguimiento a tus solicitudes de tickets.</p>
                        
                            <ul class="ps-3 mb-0">
                                <li></i><a
                                                        href="" class="__cf_email__"
                                                        data-cfemail="105a717e637867757c7c635060627f7279733e737f7d">[Terminos y Condiciones]</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div>
                            <h4 class="card-title mb-4">Datos Personales</h4>
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
                                            <td><?php echo $_SESSION['usuario']['nitc']; ?></td>
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
                            <h4 class="card-title mb-4">Work Experince</h4>
                            <ul class="list-unstyled work-activity mb-0">
                                <li class="work-item" data-date="2020-21">
                                    <h6 class="lh-base mb-0">ABCD Company</h6>
                                    <p class="font-size-13 mb-2">Web Designer</p>
                                    <p>To achieve this, it would be necessary to have uniform grammar, and more
                                        common words.</p>
                                </li>
                                <li class="work-item" data-date="2019-20">
                                    <h6 class="lh-base mb-0">XYZ Company</h6>
                                    <p class="font-size-13 mb-2">Graphic Designer</p>
                                    <p class="mb-0">It will be as simple as occidental in fact, it will be
                                        Occidental person, it will seem like simplified.</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">

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
                                    img.alt = '<?php echo $tipo["nombre"]; ?>';
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
