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
  </style>


<div class="col-md-4 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Prpgramación</h4>
            <p class="card-description">Ingrese los datos requeridos</p>

            <!-- Campo Cliente -->
            <div class="form-group">
              <select class="form-control" name="search-cliente" id="search-cliente"></select>
            </div>

            <!-- Campo Producto -->
            <div class="row">
              <div class="form-group col-md-6">
                <select class="form-control" name="search-product" id="search-product"></select>
              </div>
              <div class="form-group col-md-3">
                <input type="text" class="form-control" id="product-stock" placeholder="Stock" readonly>
              </div>
              <div class="form-group col-md-3">
                <input type="text" class="form-control" id="product-price" placeholder="Price" readonly>
              </div>
            </div>
            
            <!-- Campo Cantidad -->
            <div class="form-group">
                <input type="number" class="form-control" placeholder="Cantidad" id="cantidad">
            </div>

            <!-- Botón Agregar -->
            <button class="btn btn-primary" onclick="Temporal()">Agregar</button>
        </div>
    </div>
</div>

  <script>
    $(document).ready(function () {
      $('#search-cliente').select2({
        placeholder: 'Usuario',
        ajax: {
          url: '<?php echo base_url('Usuarios/ObtenerUsuario');?>',
          dataType: 'json',
          delay: 250,
          processResults: function(data){
            return {
              results: data
            };
          },
          cache: true
        }
      });
    });

  
  //producto
  
  $('#search-product').select2({
    placeholder: 'Producto',
    ajax: {
      url: '<?php echo base_url('Productos/ObtenerProductos');?>',
      dataType: 'json',
      delay: 250,
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
  });

  </script>



<?= $this->endSection(); ?>