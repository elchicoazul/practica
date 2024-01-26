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
<div class="col-md-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <p class="card-description">Ingrese los datos requeridos</p>

                <!-- Campo Cliente -->
                <div class="form-group">
                    <label for="search-cliente">Usuario</label>
                    <select class="form-control" name="search-cliente" id="search-cliente"></select>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">


    <div class="col-lg-6 grid-margin">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tabla de liquidaciones</h4>
                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                    <!-- Agrega un estilo para limitar la altura y agregar una barra de desplazamiento -->
                    <table class="table tabla-liquidaciones">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nombre_Servicio</th>
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
    <div class="col-lg-6 grid-margin">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tabla de programaciones</h4>
                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                    <!-- Agrega un estilo para limitar la altura y agregar una barra de desplazamiento -->
                    <table class="table tabla-programaciones-liquidar">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nombre_Servicio</th>
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

<div class="row">
    <div class="col-lg-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tabla Temporal para liquidar</h4>
                
                <!-- Agrega el botón "Liquidar" aquí -->
                <button class="btn btn-primary mb-3"  onclick="btnTransferirDatosfac()">Liquidar</button>

                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                    <!-- Agrega un estilo para limitar la altura y agregar una barra de desplazamiento -->
                    <table class="table tabla-liquidartemp">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Cantidad</th>
                                <th>Total</th>
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
  $('#search-cliente').select2({
          placeholder: 'Usuario',
          ajax: {
              url: '<?php echo base_url('Usuarios/ObtenerUsuario');?>',
              dataType: 'json',
              delay: 25,
              processResults: function(data){
                  return {
                      results: data
                  };
              },
              cache: true
          }
      }).on('select2:select', function (e) {

          // Obtener los datos del cliente seleccionado
          var data = e.params.data;
          // Almacenar el ID del cliente en la variable
          obtenerDatosProgramacionLiquidar(data.id);
          obtenerDatosLiquidacionLiquidar(data.id);
          obtenerDatosTemporalesFac(data.id);
          // Aquí puedes hacer más acciones con el id_cliente si es necesario
      });
</script>

<?= $this->endSection(); ?>