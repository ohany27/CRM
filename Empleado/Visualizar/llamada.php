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
                    <h5>Ticket</h5>
                    <form class="formulario">
                    <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="codigoTicket">Código del Ticket</label>
                                    <input type="text" class="form-control" id="codigoTicket" placeholder="Código de barras">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="idLlamada">Id llamada</label>
                                    <input type="text" class="form-control" id="idLlamada" placeholder="Llamada">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="fecha">Fecha</label>
                                    <input type="text" class="form-control" id="fecha" placeholder="Fecha">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="hora">Hora</label>
                                    <input type="text" class="form-control" id="hora" placeholder="Hora">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tituloSelect">Estado</label>
                            <select class="form-control" id="tituloSelect">
                                <option value="">Seleccione el estado</option>
                                <option value="opcion1">Opción 1</option>
                                <option value="opcion2">Opción 2</option>
                                <option value="opcion3">Opción 3</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tituloSelect">Urgencia</label>
                            <select class="form-control" id="tituloSelect">
                                <option value="">Seleccione la urgencia</option>
                                <option value="opcion1">Opción 1</option>
                                <option value="opcion2">Opción 2</option>
                                <option value="opcion3">Opción 3</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tituloSelect">Tecnicos</label>
                            <select class="form-control" id="tituloSelect">
                                <option value="">Seleccione al tecnico</option>
                                <option value="opcion1">Opción 1</option>
                                <option value="opcion2">Opción 2</option>
                                <option value="opcion3">Opción 3</option>
                            </select>
                        </div>
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary">Crear</button>
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
                                <th class="text-center">Hora</th>
                                <th class="text-center">Tipo de Problema</th>
                                <th class="text-center">Numero de Telefono</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">08/08/2017</td>
                                <td class="text-center">2:00pm</td>
                                <td class="text-center">Pantalla Azul</td>
                                <td class="text-center">Telefono</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="comment">
                    <div class="comment-author-ava"><img src="https://bootdey.com/img/Content/avatar/avatar6.png" alt="Avatar"></div>
                    <div class="comment-body">
                        <p class="comment-text">Explicacion del problema</p>
                        <div class="comment-footer"><span class="comment-meta">Ohany Garcia</span></div>
                    </div>
                </div>
                <div class="text-center w-100">
                    <h5 class="mb-30 padding-top-1x">Soluciones</h5>
                    <form method="post">
                        <div class="form-group">
                            <div class="solution-box">
                                <p>1. Posible solución para el problema.</p>
                            </div>
                            <div class="solution-box">
                                <p>2. Posible solución para el problema.</p>
                            </div>
                            <div class="solution-box">
                                <p>3. Posible solución para el problema.</p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
        
    </script>
</body>
</html>
