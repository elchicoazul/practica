<?= $this->extend('Layout/Dashboard'); ?>
<?= $this->section('content'); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Datos del cliente</h4>
                <p class="card-description">Recepción del cliente</p>

                <!-- Cliente con botón de búsqueda -->
                <div class="form-group">
                    <div class="input-group">
                        <select class="form-control js-example-basic-single" id="cliente" placeholder="Cliente" style="height: 100px;"></select>
                        <input type="text" class="form-control" id="codigo" placeholder="Código" aria-label="Código">
                    </div>
                </div>

                <!-- Código -->
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" class="form-control" id="codigo_guia" placeholder="Código" aria-label="Código">
                    </div>
                </div>

                <!-- Fecha -->
                <div class="form-group">
                    <div class="input-group">
                        <input type="date" id="fecha" class="form-control" aria-label="Fecha">
                    </div>
                </div>

                <!-- DNI/RUC -->
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" class="form-control" id="dni_ruc" placeholder="DNI/RUC" aria-label="DNI/RUC">
                    </div>
                </div>

                <!-- Guía de Remisión Cliente -->
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" id="guia" class="form-control" placeholder="Guía de Remisión Cliente" aria-label="Guía de Remisión Cliente">
                    </div>
                </div>


            </div>
        </div>
    </div>


</div>
<div class="row">
    <div class="col-md-3 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Recepcion</h4>
                <p class="card-description">Ingrese los datos requeridos</p>

                <!-- Peso Bruto -->
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Kg</span>
                        </div>
                        <input onkeyup="calcularPesos()" type="number" step="0.01" class="form-control" placeholder="Peso Bruto KG" id="pesoBruto">
                    </div>
                </div>

                <!-- Tara -->
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Kg</span>
                        </div>
                        <input onkeyup="calcularPesos()" type="number" step="0.01" class="form-control" placeholder="Tara KG" id="tara">
                    </div>
                </div>

                <!-- Peso Muestra -->
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Kg</span>
                        </div>
                        <input onkeyup="calcularPesos()" type="number" step="0.01" class="form-control" placeholder="Peso Muestra KG" id="pesoMuestra">
                    </div>
                </div>

                <!-- Peso Húmedo -->
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Kg</span>
                        </div>
                        <input disabled style="color: red;" type="number" step="0.01" class="form-control color-red" placeholder="Peso Húmedo KG" id="pesoHumedo">
                    </div>
                </div>

                <!-- Humedad -->
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">%</span>
                        </div>
                        <input onkeyup="calcularPesos()" type="number" step="0.01" class="form-control" placeholder="Humedad %" id="humedad">
                    </div>
                </div>

                <!-- Peso Seco -->
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Kg</span>
                        </div>
                        <input disabled style="color: red;" type="number" step="0.01" class="form-control" placeholder="Peso Seco KG" id="pesoSeco">
                    </div>
                </div>

                <button class="btn btn-primary" onclick="Temporal()">Ingresar</button>
            </div>
        </div>
    </div>

    <!-- muestras -->
    <div class="col-lg-9 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Pre visualización</h4>
                <button class="btn btn-primary" onclick="btnTransferirDatos()">Guardar</button>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>P. Bruto (KG)</th>
                                <th>Tara (KG)</th>
                                <th>P. Muestra (KG)</th>
                                <th>P. Húmedo (KG)</th>
                                <th>Humedad (%)</th>
                                <th>P. Seco (KG)</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Ejemplo de fila -->

                            <!-- Puede agregar más filas según sea necesario -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    function calcularPesos() {
        var pesoBruto = parseFloat($("#pesoBruto").val()) || 0;
        var tara = parseFloat($("#tara").val()) || 0;
        var pesoMuestra = parseFloat($("#pesoMuestra").val()) || 0;
        var humedad = parseFloat($("#humedad").val()) || 0;

        // Calcular Peso Húmedo: Peso Bruto - Tara - Peso Muestra
        var pesoHumedo = pesoBruto - tara - pesoMuestra;
        $("#pesoHumedo").val(pesoHumedo.toFixed(2));

        // Calcular Peso Seco: Peso Húmedo - 10% de Peso Húmedo
        var pesoSeco = pesoHumedo - (pesoHumedo * humedad / 100);
        $("#pesoSeco").val(pesoSeco.toFixed(2));
    }
</script>
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
        // Obtener los datos del producto seleccionado
        var data = e.params.data;

        // Actualizar el input del stock
        $('#dni_ruc').val(data.dni_ruc);
        $('#codigo').val(data.id);
        obtenerDatosActualizados(data.id);
        // Actualizar el input del precio

    });
</script>
<?= $this->endSection(); ?>