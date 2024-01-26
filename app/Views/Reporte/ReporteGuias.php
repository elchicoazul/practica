<?= $this->extend('Layout/Dashboard'); ?>
<?= $this->section('content'); ?>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
  <style>

/* Estilo personalizado para el select2 */
.select2-container .select2-selection--single {
    height: 35px !important; /* Ajusta la altura según tus necesidades */
    display: flex !important;
    align-items: center !important;
}


</style>

<div class="row">
<div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Reportes de Guías</h4>



                <!-- Campo Producto -->
                <div class="form-group">
                    <div class="row align-items-center">
                        <div class="col-md-2">
                            <label for="id-filtro">Filtros de busqueda</label>
                            <select class="form-control" name="id-filtro" id="id-filtro">
                              <option value="guia">-- --</option>
                              <option value="guia">guia</option>
                              <option value="liquidacion">liquidacion</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="search-product1">Cliente</label>
                            <!--<input class="form-control" name="cliente" id="cliente">-->
                            <select class="form-control js-example-basic-single" id="cliente" placeholder="Cliente" style="height: 40px;"></select>
                        </div>
                        
                        <div class="col-md-2">
                            <label for="search-product2">Fecha Inicio</label>
                            <input class="form-control" type="datetime-local" name="fecha-inicio" id="fecha-inicio">
                        </div>
                        <div class="col-md-2">
                            <label for="search-product3">Fecha Fin</label>
                            <input class="form-control" type="datetime-local" name="fecha-fin" id="fecha-fin">
                        </div>
                        <div class="col-md-2">
                            <label for="search-product4">Guia(codigo)</label>
                            <!--<input class="form-control" name="codigo-guia"  id="codigo-guia">-->
                            <select class="form-control js-example-basic-single" id="codigo" placeholder="codigo" style="height: 40px;"></select>

                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary" onclick="FiltrarReporte()">Buscar</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
  <!-- muestras -->
  <div id="tabla-guias" class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Guias</h4>
        <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
          <!-- Agrega un estilo para limitar la altura y agregar una barra de desplazamiento -->
          <table class="table tabla-reportes-guia">
            <thead>
              <tr>
                <th>Cliente</th>
                <th>Fecha Registro</th>
                <th>CodGuia</th>
                <th>Guia Remision</th>
                <th>Estado</th>
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

  <div id="tabla-liquidacion" class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Liquidacion</h4>
        <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
          <!-- Agrega un estilo para limitar la altura y agregar una barra de desplazamiento -->
          <table class="table tabla-reportes-liquidacion">
            <thead>
              <tr>
                <th>Cliente</th>
                <th>Fecha Registro</th>
                <th>idGuia</th>
                <th>Precio</th>
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

//buscar por el cliente
$('#cliente').select2({
    // Agrega una opción vacía o predeterminada al principio de la lista
    data: [{ id: '', text: 'Seleccione un cliente' }],

    ajax: {
        url: '<?php echo base_url('Usuarios/ObtenerUsuario'); ?>',
        dataType: 'json',
        delay: 25,
        processResults: function(data) {
            // Agrega los clientes obtenidos a la opción vacía o predeterminada
            return {
                results: [{ id: '', text: 'Seleccione un cliente' }].concat(data)
            };
        },
        cache: true
    },
    tags: false // Desactiva la opción de entrada de texto libre
});

//buscar por el codigo de la guia

$('#codigo').select2({
  // Agrega una opción vacía o predeterminada al principio de la lista
  data: [{ id: '', text: 'Seleccione un CodigoGuia' }],

  ajax: {
    url: '<?php echo base_url('Guia/obtenerGuia'); ?>',
        dataType: 'json',
        delay: 25,
        processResults: function(data) {
            // Agrega los clientes obtenidos a la opción vacía o predeterminada
            return {
                results: [{ id: '', text: 'Seleccione un CodGuia' }].concat(data)
            };
        },
        cache: true
  },
  tags: false // Desactiva la opción de entrada de texto libre
});

//para ocultar y mostrar las tablas

$(document).ready(function () {
        // Oculta ambas tablas al inicio
        $('#tabla-guias').hide();
        $('#tabla-liquidacion').hide();

        // Maneja el cambio en el campo de filtro
        $('#id-filtro').change(function () {
            var filtroSeleccionado = $(this).val();

            // Oculta ambas tablas al principio
            $('#tabla-guias').hide();
            $('#tabla-liquidacion').hide();

            // Muestra la tabla correspondiente al filtro seleccionado
            if (filtroSeleccionado === 'guia') {
                $('#tabla-guias').show();
            } else if (filtroSeleccionado === 'liquidacion') {
                $('#tabla-liquidacion').show();
            }
        });
    });
</script>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/js/impresion/impresion.js"></script>


<?= $this->endSection(); ?>