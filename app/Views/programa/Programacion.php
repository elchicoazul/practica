<?= $this->extend('Layout/Dashboard'); ?>
<?= $this->section('content'); ?>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
  <style>
  .container {
    max-width: 500px;
  }
  .select2-container--default .select2-selection--single {
    position: relative;
  }
  .select2-container--default .select2-selection--single .select2-selection__placeholder {
    position: absolute;
    top: 58%;
    transform: translateY(-50%);
    line-height: 40px; /* Ajusta la altura según sea necesario */
  }

  /* Estilo para el color rojo en los campos de precio y stock */
  .campo-rojo {
    color: red;
  }

  /* Estilo para hacer el campo de total no editable */
  #total {
    pointer-events: none;
    background-color: #f4f4f4;
  }
</style>

<div class="row">
<div class="col-md-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Programación</h4>
                <p class="card-description">Ingrese los datos requeridos</p>

                <!-- Campo Cliente -->
                <div class="form-group">
                    <label for="search-cliente">Usuario</label>
                    <select class="form-control" name="search-cliente" id="search-cliente"></select>
                </div>

                <!-- Campo Producto -->
                <div class="form-group">
                    
                    <div class="row">
                       
                        <div class="col-md-6">
                            <label for="search-product">Producto</label>
                            <select class="form-control" name="search-product" id="search-product"></select>
                        </div>
                        <div class="col-md-3">
                            <label for="product-stock">Stock</label>
                            <input type="text" class="form-control campo-rojo" id="product-stock" placeholder="Stock" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="product-price">Precio</label>
                            <input type="text" class="form-control campo-rojo" id="product-price" placeholder="Precio" readonly>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Campo Cantidad -->
                    <div class="form-group col-md-7">
                        <label for="cantidad">Cantidad</label>
                        <input type="number" class="form-control" placeholder="Cantidad" name="cantidad" id="cantidad">
                    </div>
                    <div class="form-group col-md-5">
                        <label for="total">Total</label>
                        <input type="text" class="form-control campo-rojo" placeholder="Total" name="total" id="total" readonly>
                    </div>
                </div>

                <!-- Botón Agregar -->
                <button class="btn btn-primary" onclick="registrarProgramacion()">Agregar</button>
            </div>
        </div>
    </div>
  <!-- muestras -->
  <div class="col-lg-8 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Registro de Programaciones</h4>
        <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
          <!-- Agrega un estilo para limitar la altura y agregar una barra de desplazamiento -->
          <table class="table tabla-programaciones">
            <thead>
              <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Producto</th>
                <th>Cantidad (uds)</th>
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
          obtenerDatosProgramacion(data.id);
          // Aquí puedes hacer más acciones con el id_cliente si es necesario
      });

  //producto
  $('#search-product').select2({
    placeholder: 'Producto',
    ajax: {
      url: '<?php echo base_url('Productos/ObtenerProductos');?>',
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
      // Obtener los datos del producto seleccionado
      var data = e.params.data;
      
      // Actualizar el input del stock
      $('#product-stock').val(data.stock);
      
      // Actualizar el input del precio
      $('#product-price').val(data.price);

    // Escuchar el evento input en el campo de cantidad
    $('#cantidad').on('input', function () {
      // Obtener el valor de cantidad
      var cantidad = $(this).val();

      // Obtener el valor de precio
      var precio = $('#product-price').val();

      // Calcular el total multiplicando cantidad por precio
      var total = cantidad * precio;

      // Actualizar el valor del campo total
      $('#total').val(total);
    });
  });



<?= $this->endSection(); ?>