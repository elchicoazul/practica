<?= $this->extend('Layout/Dashboard'); ?>
<?= $this->section('content'); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<div class="row">
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Datos del Cliente y Código de Guía</h4>
                <p class="card-description">Ingrese los datos requeridos</p>

                <!-- Cliente con botón de búsqueda -->
                <div class="form-group">
                    <div class="input-group">
                        <select class="form-control js-example-basic-single" id="cliente" placeholder="Cliente" style="height: 100px;"></select>
                        <div class="input-group-append">
                            <button class="btn btn-sm btn-primary" type="button">Buscar Cliente</button>
                        </div>
                    </div>
                </div>

                <!-- Código de Guía con botón de búsqueda -->
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Código de Guía" aria-label="Código de Guía">
                        <div class="input-group-append">
                            <button class="btn btn-sm btn-primary" type="button">Buscar Guía</button>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
    <div class="col-lg-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tabla de Datos</h4>
                <button class="btn btn-primary" id="btnGenerarAnalisis">Generar</button>
                <div class="table-responsive">
                    <table class="table" id="tablaDatos">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Guía</th>
                                <th>Código</th>
                                <th>Peso Hum (KG)</th>
                                <th>Humedad (%)</th>
                                <th>Peso Seco (KG)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Ejemplo de fila -->
                            <tr>
                                <td>1</td>
                                <td>Guía #1</td>
                                <td>Código #1</td>
                                <td>Valor Peso Hum</td>
                                <td>Valor Humedad</td>
                                <td>Valor Peso Seco</td>
                            </tr>
                            <!-- Puede agregar más filas según sea necesario -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- oro -->
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tabla de Análisis Au</h4>
                <div class="table-responsive">
                    <table class="table" id="tablaAnalisisAU">
                        <thead>
                            <tr>
                                <th>Editar</th>
                                <th>Item</th>
                                <th>Peso Seco (Kg.)</th>
                                <th>Ley Oroan (grs./Kg. Carbón)</th>
                                <th>Ley Cliente</th>
                                <th>Dirimencia</th>
                                <th>Ley Final</th>
                                <th>Neto (Kg.)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- <tr>
                                <td>
                                    <span class="btn btn-icon mb-1 text-primary">
                                    <i class="mdi mdi-pencil"></i>
                                    </span>
                                </td>
                                <td>1</td>
                                <td>Valor Peso Seco</td>
                                <td>Valor Ley Oroan</td>
                                <td>Valor Ley Cliente</td>
                                <td>Valor Dirimencia</td>
                                <td>Valor Ley Final</td>
                                <td>Valor Neto</td>
                            </tr> -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tabla de Análisis AG</h4>
                <div class="table-responsive">
                    <table class="table" id="tablaAnalisisAG">
                        <thead>
                            <tr>
                                <th>Editar</th>
                                <th>Item</th>
                                <th>Peso Seco (Kg.)</th>
                                <th>Ley Oroan (grs./Kg. Carbón)</th>
                                <th>Ley Cliente</th>
                                <th>Dirimencia</th>
                                <th>Ley Final</th>
                                <th>Neto (Kg.)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Ejemplo de fila -->
                            <!-- <tr>
                                <td>
                                    <span class="btn btn-icon mb-1 text-primary">
                                    <i class="mdi mdi-pencil"></i>
                                    </span>
                                </td>
                                <td>1</td>
                                <td>Valor Peso Seco</td>
                                <td>Valor Ley Oroan</td>
                                <td>Valor Ley Cliente</td>
                                <td>Valor Dirimencia</td>
                                <td>Valor Ley Final</td>
                                <td>Valor Neto</td>
                            </tr> -->
                            <!-- Puede agregar más filas según sea necesario -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tabla de Análisis Elementos</h4>
                <div class="table-responsive">
                    <table class="table" id="tablaTotal">
                        <thead>
                            <tr>
                                <th>
                                    <div class="text-center">Tipo de</div>
                                    <div class="text-center">Metal</div>
                                </th>
                                <th>
                                    <div class="text-center">Peso de</div>
                                    <div class="text-center">Metal grs</div>
                                </th>
                                <th>
                                    <div class="text-center">Accion internacional</div>
                                    <div class="text-center">USD$ onza</div>
                                </th>
                                <th>
                                    <div class="text-center">Accion internacional</div>
                                    <div class="text-center">USD$ grs</div>
                                </th>
                                <th>
                                    <div class="text-center">Valor metal</div>
                                    <div class="text-center">USD$ grs</div>
                                </th>
                                <th>
                                    <div class="text-center">Descuento</div>
                                    <div class="text-center">%</div>
                                </th>
                                <th>
                                    <div class="text-center">Valor Neto</div>
                                    <div class="text-center">USD$ grs</div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#cliente').select2({
        ajax: {
            url: '<?php echo base_url('Usuarios/ObtenerUsuario'); ?>',
            dataType: 'json',
            delay: 50,
            processResults: function(data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    }).on('select2:select', function(e) {
        const {data} = e.params;
        console.log(data)
        obtenerLiquidacionData(data.id);
        obtenerDatosAnalisis(data.id);
    });

    function leyes(id) {
        var secoValor = parseFloat(document.getElementById('seco-' + id).value);
        var officeLawValor = parseFloat(document.getElementById('officeLaw-' + id).value);
        var clientLawValor = parseFloat(document.getElementById('clientLaw-' + id).value);
        var differenceValor = parseFloat(document.getElementById('difference-' + id).value);
        
        var finalValor;
        var pesoNeto;

        if (differenceValor !== 0) {
            finalValor = differenceValor;
        } else {
            finalValor = (officeLawValor + clientLawValor) / 2;
        }

        document.getElementById('final-' + id).value = finalValor.toFixed(2);  // Asumiendo que desea dos decimales
        document.getElementById('neto-' + id).value = (finalValor * secoValor).toFixed(2);;
    }
</script>

<?= $this->endSection(); ?>